<?php
if ( ! class_exists( 'BravePop_Sender' ) ) {
   
   class BravePop_Sender {

      protected $api_key;

      function __construct() {
         $braveSettings = get_option('_bravepopup_settings');
         $integrations = $braveSettings && isset($braveSettings['integrations']) ? $braveSettings['integrations'] : array() ;
         $this->api_key = isset($integrations['sender']->api)  ? $integrations['sender']->api  : '';
      }

      public function get_lists($apiKey=''){
         $apiKey = $apiKey ? $apiKey : $this->api_key;
         if(!$apiKey){ return false;}

         $args = array(
            'headers' => array(
               'Authorization' => 'Bearer ' . $apiKey,
               'Content-Type' => 'application/json'
            )
         );
         $response = wp_remote_get( 'https://api.sender.net/v2/groups', $args );
         
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );

         if($data && isset($data->data)){
            $lists = $data->data;
            $finalLists = array();
            foreach ($lists as $list) {
               $listItem = new stdClass();
               $listItem->id = $list->id;
               $listItem->name = $list->title;
               $listItem->count = $list->recipient_count;
               $finalLists[] = $listItem;
            }
            return wp_json_encode($finalLists);
         }else{
            return false;
         }
      }

      public function add_to_lists($email, $list_id, $fname='', $lname='', $phone='', $customFields=array(), $tags=array(), $userData=array()){
         if(!$email || !$list_id){ return null; }
         if(!$this->api_key){ return false; }

         if (empty($lname) && strpos($fname, ' ') !== false) {
            $name_parts = explode(' ', $fname, 2);
            $fname = $name_parts[0];
            $lname = $name_parts[1];
         }

         $contact = array(
            'email' => $email,
            'groups' => array($list_id),
            'firstname' => trim($fname),
            'lastname' => trim($lname)
         );

         if(!empty($phone)){
            $contact['phone'] = $phone;
         }

         if(count($customFields) > 0){
            $contact['fields'] = $customFields;
         }

         $args = array(
            'method' => 'POST',
            'headers' => array(
               'Authorization' => 'Bearer ' . $this->api_key,
               'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($contact)
         );
         
         $response = wp_remote_post( 'https://api.sender.net/v2/subscribers', $args );
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         
         if($data && isset($data->data->id)){
            $addedData = array(
               'action'=> isset($userData['action']) ? $userData['action'] : 'visitor_added',  
               'user_id'=> isset($userData['userData']['ID']) ? $userData['userData']['ID'] : false,
               'user_mail'=> $email, 
               'esp_user_id'=> $data->data->id,
               'user_data'=> $contact,
               'list_id' => $list_id,
               'response' => $response,
            ); 
            do_action( 'bravepop_added_to_list', 'sender', $addedData );
            return array( 'success' => true, 'result' => $addedData );
         }else{
            $errorMsg = $response->get_error_message() ? $response->get_error_message() : 'Unknown Error Occurred. No Error details provided by Sender.net';
            $errorPayload = array( 'user_mail'=> $email, 'user_data'=> $contact, 'list_id'=> $list_id, 'error' => $errorMsg, 'response'=> $response );
            do_action( 'bravepop_added_to_list_failed', 'sender', $errorPayload );
            return array( 'success' => false, 'errorMsg' => $errorMsg, 'result' => $errorPayload );
         }
      }
   }
}
?>

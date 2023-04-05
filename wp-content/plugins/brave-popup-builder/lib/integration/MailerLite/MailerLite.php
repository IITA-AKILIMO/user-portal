<?php
if ( ! class_exists( 'BravePop_MailerLite' ) ) {
   
   class BravePop_MailerLite {

      function __construct() {
         $braveSettings = get_option('_bravepopup_settings');
         $integrations = $braveSettings && isset($braveSettings['integrations']) ? $braveSettings['integrations'] : array() ;
         $this->api_key = isset($integrations['mailerlite']->api)  ? $integrations['mailerlite']->api  : '';
      }

      public function get_lists($apiKey=''){
         $apiKey  = $apiKey ? $apiKey : $this->api_key;

         $args = array(
            'headers' => array(
               'X-MailerLite-ApiKey' => $apiKey
            )
         );
         $response = wp_remote_get( 'https://api.mailerlite.com/api/v2/groups?limit=300', $args );
         if( is_wp_error( $response ) ) {
            return false; // Bail early
         }

         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         $lists = $data;
         $finalLists = array();

         if($lists && is_array($lists)){
            
            foreach ($lists as $key => $list) {
               $listItem = new stdClass();
               $listItem->id = isset($list->id) ? $list->id : '';
               $listItem->name = isset($list->name) ? $list->name : '';
               $listItem->count = isset($list->total)  ? $list->total : 0;
               $finalLists[] = $listItem;
            }

            //error_log(json_encode($finalLists));
            return json_encode($finalLists);
         }else{
            return false;
         }

      }


      public function add_to_lists($email, $list_id, $fname='', $lname='', $phone='', $customFields=array(), $tags=array(), $userData=array()){
         if(!$email || !$list_id){ return null; }
         if(!$this->api_key){ 
            //error_log('API KEY or SECRET Missing!');
            return false;
         }
         $firstname = trim($fname);
         $lastname = trim($lname);
         $fullname = $firstname;

         //Convert firstname and lastname to Fullname. 
         if($firstname && $lastname){
            $fullname = $firstname.' '.$lastname;
         }

         $contact = array('autoresponders'=> true, 'resubscribe'=> true, 'email'=> $email, 'name'=> trim($fullname), 'fields'=> array('phone'=> trim($phone)  ));
         
         //Add Custom Field Values
         if(count($customFields) > 0 && $contact['fields']){
            foreach ($customFields as $key => $value) {
               $value = !empty($value) && is_array($value) ?  implode(',', $value) : $value;
               $contact['fields'][$key] = $value;
            }
         }

         $args = array(
            'method' => 'POST',
            'headers' => array(
               'content-type' => 'application/json',
               'X-MailerLite-ApiKey' => $this->api_key
            ),
            'body'=> json_encode($contact)
         );

         $response = wp_remote_post( 'https://api.mailerlite.com/api/v2/groups/'.$list_id.'/subscribers', $args );
                  
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );

         //error_log('### Add to Group Response: '. json_encode($data));

         if($data && isset($data->id)){
            $userID = $data->id;
            $addedData = array(
               'action'=> isset($userData['action']) ? $userData['action'] : 'visitor_added',  
               'user_id'=> isset($userData['userData']['ID']) ? $userData['userData']['ID'] : false,
               'user_mail'=> $email, 'esp_user_id'=> $userID
            ); 
            do_action( 'bravepop_addded_to_list', 'mailerlite', $addedData );

            return true; 
         }else{
            return false;
         }
      }


   }

}
?>
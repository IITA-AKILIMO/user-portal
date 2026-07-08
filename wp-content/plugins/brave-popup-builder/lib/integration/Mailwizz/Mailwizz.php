<?php
if ( ! class_exists( 'BravePop_Mailwizz' ) ) {

   class BravePop_Mailwizz {

      protected $api_key;
      protected $api_url;

      function __construct() {
         $braveSettings = get_option('_bravepopup_settings');
         $integrations = $braveSettings && isset($braveSettings['integrations']) ? $braveSettings['integrations'] : array() ;
         $this->api_url = isset($integrations['mailwizz']->url)  ? esc_url(rtrim($integrations['mailwizz']->url))  : '';
         $this->api_key = isset($integrations['mailwizz']->api)  ? $integrations['mailwizz']->api  : '';
      }

      public function get_lists($apiKey=''){
         error_log('Mailwizz get_lists:'. $apiKey);
         $apiKey = $apiKey ? $apiKey : $this->api_key;
         if(!$apiKey){ return false;}
         $args = array(
            'method' => 'GET',
            'headers' => array(
               'X-MW-PUBLIC-KEY' => $apiKey
            ),         );
         $response = wp_remote_get( $this->api_url.'/lists', $args );
         //error_log(wp_json_encode($response));
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         

         if(!$data || (isset($data->status) && $data->status !== 'success')){
            return false;
         }

         if(isset($data->data->records) && is_array($data->data->records)){
            $lists = $data->data->records;
            $finalLists = array();
            foreach ($lists as $key => $list) {
               $listItem = new stdClass();
               $listItem->id = isset($list->general->list_uid) ? $list->general->list_uid : '';
               $listItem->name = isset($list->general->name) ? $list->general->name : '';
               $finalLists[] = $listItem;
            }
            return wp_json_encode($finalLists);
         }else{
            return false;
         }
      }

      public function add_to_lists($email, $list_id, $fname='', $lname='', $phone='', $customFields=array(), $tags=array(), $userData=array(), $doubleOptin=false, $misc=array()){
         if(!$email || !$list_id){ return null; }
         if(!$this->api_key){ 
            //error_log('API KEY or SECRET Missing!');
            return false;
         }
         $firstname = trim($fname);
         $lastname = trim($lname);

         $contact = array('NEWSLETTER_CONSENT'=> 1, 'EMAIL'=> $email, 'FIRST_NAME'=> $firstname, 'LAST_NAME'=> $lastname);
         
         //Add Custom Field Values
         if(count($customFields) > 0){
            foreach ($customFields as $key => $value) {
               $value = !empty($value) && is_array($value) ?  implode(',', $value) : $value;
               $contact[$key] = $value;
            }
         }

         $args = array( 'method' => 'POST', 'body'=> ($contact), 'timeout' => 30, 'headers' => array( 'X-MW-PUBLIC-KEY' => $this->api_key) );

         $response = wp_remote_post( $this->api_url.'/lists/'.$list_id.'/subscribers', $args );
                  
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         $success =   $data->status === 'success' ? true : false; 

         if($success){
            $addedData = array(
               'action'=> isset($userData['action']) ? $userData['action'] : 'visitor_added',  
               'user_id'=> isset($userData['userData']['ID']) ? $userData['userData']['ID'] : false,
               'user_mail'=> $email,
               'esp_user_id'=> '',
               'user_data'=> $contact,
               'list_id' => $list_id,
               'response' => $response,
            );
            do_action( 'bravepop_added_to_list', 'mailwizz', $addedData );
            return array( 'success' => true, 'result' => $addedData ); 
         }else{
            $errorMsg = $response->get_error_message() ? $response->get_error_message() : 'Unknown Error Occurred. No Error details provided by Mailwizz.';
            $errorPayload = array( 'user_mail'=> $email, 'user_data'=> $contact, 'list_id'=> $list_id, 'error' => $errorMsg, 'response'=> $response );
            do_action( 'bravepop_added_to_list_failed', 'mailwizz', $errorPayload );
            return array( 'success' => false, 'errorMsg' => $errorMsg, 'result' => $errorPayload );
         }
      }


   }

}
?>
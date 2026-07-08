<?php
if ( ! class_exists( 'BravePop_Aweber' ) ) {
   
   class BravePop_Aweber {

      protected $api_secret;
      protected $refresh_token;

      function __construct() {
         $braveSettings = get_option('_bravepopup_settings');
         $integrations = $braveSettings && isset($braveSettings['integrations']) ? $braveSettings['integrations'] : array() ;
         $this->api_secret = isset($integrations['aweber']->secret)  ? $integrations['aweber']->secret  : '';
         $this->refresh_token = isset($integrations['aweber']->refresh)  ? $integrations['aweber']->refresh  : '';
      }

      public function get_accountID($access_token){
         $accountID = get_option('_bravepop_aweber_accountID');
         if(!empty($accountID)){ return array( 'success' => true, 'accountID' => $accountID ); }
         //First Get the AccountID
         $headerArgs = array( 'headers' => array(  'Authorization' => 'Bearer ' . $access_token ) );
         $response = wp_remote_get( 'https://api.aweber.com/1.0/accounts', $headerArgs );
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         if(isset($data->entries) && is_array($data->entries) && $data->entries[0]){
            update_option('_bravepop_aweber_accountID', $data->entries[0]->id);
            return array( 'success' => true, 'accountID' => $data->entries[0]->id );
         }else{
            $errorMsg = isset($data->error->message) ? $data->error->message : 'Unknown Error Occurred. No Error details provided by Aweber.';
            return array( 'success' => false, 'errorMsg' => $errorMsg, 'response' => $response );
         }
      }

      public function get_access_token($refresh_token=''){
         $existingToken = get_option('_bravepop_aweber_tkn');
         if($existingToken){
            $existingToken = json_decode($existingToken);
            if(isset($existingToken->token) && isset($existingToken->expires_in) && $existingToken->expires_in > time() ){
               //error_log('Valid existing Token!'.'Expires In: '.$existingToken->expires_in.' Current Time: '.time());
               return $existingToken->token;
            }
         }
         if(!$this->refresh_token && !$refresh_token){ 
            return false;
         }
         $args = array( 'method' => 'POST','headers' => array( 'Content-Type' => 'application/x-www-form-urlencoded'  ) );
         $response = wp_remote_post( 'https://auth.aweber.com/oauth2/token?grant_type=refresh_token&client_id=RFHkkuTqrezTnsLVZzUt4NVQmEhcbe0p&refresh_token='.$refresh_token, $args );
         
         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         if(isset($data->expires_in) && isset($data->access_token) ){
            update_option('_bravepop_aweber_tkn', wp_json_encode(array('token'=> $data->access_token, 'expires_in'=> (time() + ($data->expires_in - 200) ))));
         }

         return isset($data->access_token) ? $data->access_token : '';
      }

      public function get_lists($refresh_token=''){
         $refresh_token  = $refresh_token ? $refresh_token : $this->refresh_token;
         $access_token  = $this->get_access_token($refresh_token); 
         $accountIDObj = $this->get_accountID($access_token);

         if(!$accountIDObj['success'] || !isset($accountIDObj['accountID'])){ 
            return false; // Bail early if account ID is not available
         }

         $headerArgs = array( 'headers' => array(  'Authorization' => 'Bearer ' . $access_token ) );
         $lresponse = wp_remote_get( 'https://api.aweber.com/1.0/accounts/'.$accountIDObj['accountID'].'/lists', $headerArgs );

         if( is_wp_error( $lresponse ) ) {
            return false; // Bail early
         }

         $lbody = wp_remote_retrieve_body( $lresponse );
         $ldata = json_decode( $lbody );

         
         $finalLists = array();
         
         if(isset($ldata->entries) && is_array($ldata->entries)){
            $lists = $ldata->entries;
            foreach ($lists as $key => $list) {
               $listItem = new stdClass();
               $listItem->id = isset($list->id) ? $list->id : '';
               $listItem->name = isset($list->name) ? $list->name : '';
               $finalLists[] = $listItem;
            }

            //error_log(wp_json_encode($finalLists));

            return wp_json_encode($finalLists);
         }else{
            return false;
         }

      }

      public function add_to_lists($email, $list_id, $fname='', $lname='', $phone='', $customFields=array(), $tags=array(), $userData=array()){
         if(!$email || !$list_id){ return null; }
         if( !$this->refresh_token){ 
            //error_log('Aweber Refresh Token Missing!');
            return false;
         }

         $firstname = trim($fname);
         $lastname = trim($lname);
         $fullname = $firstname;

         //Convert firstname and lastname to Fullname. 
         if($firstname && $lastname){
            $fullname = $firstname.' '.$lastname;
         }

         $access_token  = $this->get_access_token($this->refresh_token);

         // First get the AccountID
         $getAccountRes = $this->get_accountID($access_token);
         if(!$getAccountRes['success'] || !isset($getAccountRes['accountID'])){ 
            $errorMsg = isset($getAccountRes['errorMsg']) ? $getAccountRes['errorMsg'] : 'Unknown Error Occurred. No Error details provided by Aweber.';
            $errorPayload = array( 'user_mail'=> $email, 'firstname'=> $firstname, 'lastname'=> $lastname, 'list_id'=> $list_id, 'error' => $errorMsg, 'response'=> $getAccountRes['response'] );
            do_action( 'bravepop_added_to_list_failed', 'aweber', $errorPayload );
            return array( 'success' => false, 'errorMsg' => $errorMsg, 'result' => $errorPayload );
         }

         // Then Add User to a List in Aweber
         $contact = array( 'email' => $email, 'name' => trim($fullname), 'update_existing' => 'true', 'ip_address' => class_exists('BravePop_Geolocation') ? bravepop_getVisitorIP() : '' );

         //Add Custom Field Values
         if(count($customFields) > 0){
            $fieldValues = array();
            foreach ($customFields as $key => $value) {
               $fieldValues[$key] = !empty($value) && is_array($value) ?  implode(',', $value) : $value;
            }
            $contact['custom_fields'] = $fieldValues;
         }
         
         //Add Tags
         if(isset($tags[0])){
            $tagsArray = explode(",",$tags[0]);
            if(count($tagsArray) > 0){
               $contact['tags'] = $tagsArray;
            }
         }

         if($getAccountRes['accountID']){
            $args = array(
               'method' => 'POST',
               'headers' => array( 'Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json'  ),
               'body' => wp_json_encode($contact)
            );
            //https://api.aweber.com/#tag/Subscribers/paths/~1accounts~1{accountId}~1lists~1{listId}~1subscribers/post
            $response = wp_remote_post( 'https://api.aweber.com/1.0/accounts/'.$getAccountRes['accountID'].'/lists/'.$list_id.'/subscribers', $args );
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body );

            // if(isset($data->error->message)){ error_log('Error Object: '. $data->error->message); }

            if((isset($response['response']['code']) && $response['response']['code'] === 201)){
               $addedData = array(
                  'action'=> isset($userData['action']) ? $userData['action'] : 'visitor_added',  
                  'user_id'=> isset($userData['userData']['ID']) ? $userData['userData']['ID'] : false,
                  'user_mail'=> $email, 
                  'user_data'=> $contact,
                  'esp_user_id'=> '',
                  'list_id'=> $list_id,
                  'response' => $response
               ); 
               do_action( 'bravepop_added_to_list', 'aweber', $addedData );
               return array( 'success' => true, 'result' => $addedData );
            }else{
               $errorMsg = isset($data->error->message) ? $data->error->message : 'Unknown Error Occurred. No Error details provided by Aweber.';
               $errorPayload = array( 'user_mail'=> $email, 'list_id'=> $list_id, 'user_data'=> $contact, 'error' => $errorMsg, 'response'=> $response );
               do_action( 'bravepop_added_to_list_failed', 'aweber', $errorPayload );
               return array( 'success' => false, 'errorMsg' => $errorMsg, 'result' => $errorPayload );
            }

         }

      }


   }

}
?>
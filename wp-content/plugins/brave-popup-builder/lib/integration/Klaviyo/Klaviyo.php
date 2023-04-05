<?php
if ( ! class_exists( 'BravePop_Klaviyo' ) ) {
   
   class BravePop_Klaviyo {

      function __construct() {
         $braveSettings = get_option('_bravepopup_settings');
         $integrations = $braveSettings && isset($braveSettings['integrations']) ? $braveSettings['integrations'] : array() ;
         $this->api_key = isset($integrations['klaviyo']->api)  ? $integrations['klaviyo']->api  : '';
      }


      public function get_lists($apiKey=''){
         $apiKey     = $apiKey ? $apiKey : $this->api_key;

         if(!$apiKey){ return false;}

         $response = wp_remote_get( 'https://a.klaviyo.com/api/v2/lists?api_key='.$apiKey  );
         if( is_wp_error( $response ) ) {
            return false; // Bail early
         }

         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );
         if($data){
            $lists = $data;
            $finalLists = array();
            if($lists && is_array($lists)){
               foreach ($lists as $key => $list) {
                  $listItem = new stdClass();
                  $listItem->id = isset($list->list_id) ? $list->list_id : '';
                  $listItem->name = isset($list->list_name) ? $list->list_name : '';
                  $listItem->count = 0;
                  $finalLists[] = $listItem;
               }
            }
            return json_encode($finalLists);
         }else{
            return false;
         }

      }


      public function add_to_lists($email, $list_id, $fname='', $lname='', $phone='', $customFields=array(), $tags=array(), $userData=array()){
         if(!$email || !$list_id){ return false; }
         if(!$this->api_key){ 
            //error_log('API KEY Missing!');
            return false;
         }

         $firstname = trim($fname);
         $lastname = trim($lname);

         //Convert Full name to firstname and lastname. 
         if(!$lastname && $firstname && strpos($firstname, ' ') !== false){
            $splitted = explode(" ",$firstname);
            $firstname = $splitted[0] ? $splitted[0] : '';
            $lastname = $splitted[1] ? trim(str_replace($firstname, '', $fname)) : '';
         }
         
         $contact = array( 'email' => $email );

         if(!empty($phone)){ $contact['$phone_number'] = $phone; }
         if(!empty($firstname)){   $contact['first_name'] = $firstname; }
         if(!empty($lastname)){   $contact['last_name'] = $lastname; }

         //Add Custom Field Values
         if(count($customFields) > 0){
            foreach ($customFields as $key => $value) {
               $contact[trim($key)] = !empty($value) && is_array($value) ?  implode(',', $value) : $value;
            }
         }

         $args = array(
            'method' => 'POST',
            'headers' => array(
               'content-type' => 'application/json',
            ),
            'body' => json_encode(array(
               'api_key' => $this->api_key,
               'profiles' => ($contact)
            ))
         );

         $response = wp_remote_post( 'https://a.klaviyo.com/api/v2/list/'.$list_id.'/members', $args );
         

         $body = wp_remote_retrieve_body( $response );
         $data = json_decode( $body );

         //error_log(json_encode($response));

         if($data && is_array($data) ){ 
            $addedData = array(
               'action'=> isset($userData['action']) ? $userData['action'] : 'visitor_added',  
               'user_id'=> isset($userData['userData']['ID']) ? $userData['userData']['ID'] : false,
               'user_mail'=> $email, 'esp_user_id'=> isset($data[0]->id) ? isset($data[0]->id) : ''
            ); 
            do_action( 'bravepop_addded_to_list', 'klaviyo', $addedData );

            return $data; 
         }else{
            return false;
         }

      }


   }

}
?>
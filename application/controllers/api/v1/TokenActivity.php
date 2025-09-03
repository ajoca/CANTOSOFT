<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class TokenActivity extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Sale_model');
               $this->load->library('form_validation');
               $this->Common_model->setDefaultTimezone();
                //loading dabase
               $this->load->database();

               $hostname = $this->db->hostname;
               $username = $this->db->username;
               $password = $this->db->password;
               $database = $this->db->database;
               $port = $this->db->port;
               //dns checking 
               $dsn  = 'mysql:dbname=' . $database . ';host=' . $hostname. ';port=' . $port;
               $dbusername = $username;
               $dbpassword = $password;

              OAuth2\Autoloader::register();
              $storage = new OAuth2\Storage\Pdo(array(
                'dsn' => $dsn,
                'username' => $dbusername,
                'password' => $dbpassword
              ));
              $this->oauth_server = new OAuth2\Server($storage);
              $this->oauth_server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
              $this->oauth_server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
              $uri_segments = $this->uri->segment_array();
              $r = array();
              //check token
              $access_token_array = OAuth2\Request::createFromGlobals();
              $headers = get_all_headers();
              $access_token_array->query['access_token'] = $headers['access-token'];
             
                if(!$this->oauth_server->verifyResourceRequest($access_token_array) && $uri_segments[4]!="token"){
                   $status = 'Token invalid';
                   $responce = 'http_response_unauthorized';

                   $this->response(array(
                        'status'=> $status
                     ),$this->config->item($responce)
                  );
                
               } 

     }
  

   public function update_token_activity_post()
   {
    
      $headers = get_all_headers(); 
      $access_token = $headers['access-token'];
       
      
      $token_details = getTokenDetails($access_token);
       
      $originalDate = $token_details->expires;

    // Create a DateTime object
        $date = new DateTime($originalDate);

        // Add 30 minutes
        $date->modify('+30 minutes');

        // Get the new date and time as a string
        $new_value = $date->format('Y-m-d H:i:s');
     
      $message = '';
      $data['expires'] = $new_value;
      $this->db->where('access_token', $access_token);
      $this->db->update("oauth_access_tokens", $data);
  
      $status = "success";
      $message = lang('update_success');
      $responce = "http_response_ok";


       $this->response(array(
               'data' => '',
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
   public function delete_token_post()
   {
    $headers = get_all_headers(); 
    $access_token = $headers['access-token'];
      $message = '';
      $this->db->delete("oauth_access_tokens", array("access_token" => $access_token));

      $status = "success";
      $message = lang('update_success');
      $responce = "http_response_ok";


       $this->response(array(
               'data' => '',
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }

}
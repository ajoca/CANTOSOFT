<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Notification extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Api_model');  
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
     public function get_notifications_post()
     {
      $jsonData = json_decode(file_get_contents('php://input'), true);
    $headers = get_all_headers();;
    // if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
          //   $this->response(array(
          //           'status'=> 'error',
          //           'message'=> "Unauthorized access"
          //         ),$this->config->item("http_response_unauthorized")
          //       );
          // }
      $this->form_validation->set_data($jsonData);
      
      $this->form_validation->set_rules('outlet_id', "Outlet", 'required|max_length[50]');  
      $this->form_validation->set_rules('user_id', "User", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
          $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';

          $data = $this->Api_model->getNotificationByOutletId($outlet_id,$user_id);
          $status = "success";
          $message = '';
          $responce = "http_response_ok";
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
      }
       
       
        $this->response(array(
          'data' => $data,
          'status'=> $status,
          'message'=> $message,
          ),$this->config->item($responce)
        );
  
    } 

    public function remove_notification_post()
     {
      $jsonData = json_decode(file_get_contents('php://input'), true);
    $headers = get_all_headers();;
    // if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
          //   $this->response(array(
          //           'status'=> 'error',
          //           'message'=> "Unauthorized access"
          //         ),$this->config->item("http_response_unauthorized")
          //       );
          // }
      $this->form_validation->set_data($jsonData);
      
      $this->form_validation->set_rules('id', "ID", 'required|max_length[50]');   
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $id  = isset($jsonData['id']) && $jsonData['id']?$jsonData['id']:'';

          $notifications_array = explode(",",$id);
          foreach($notifications_array as $single_notification){
              $this->db->delete('tbl_notifications', array('id' => $single_notification));
          }

          $status = "success";
          $message = 'Notification removed successfully'; 
          $responce = "http_response_ok";
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
      }
       
       
        $this->response(array(
          'data' => $data,
          'status'=> $status,
          'message'=> $message,
          ),$this->config->item($responce)
        );
  
    } 

}
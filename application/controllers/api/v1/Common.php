<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Common extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Api_model');
               $this->load->library('form_validation');
               $this->Common_model->setDefaultTimezone();
                //loading dabase
//                $this->load->database();

//                $hostname = $this->db->hostname;
//                $username = $this->db->username;
//                $password = $this->db->password;
//                $database = $this->db->database;
//                $port = $this->db->port;
//                //dns checking 
//                $dsn  = 'mysql:dbname=' . $database . ';host=' . $hostname. ';port=' . $port;
//                $dbusername = $username;
//                $dbpassword = $password;

//               OAuth2\Autoloader::register();
//               $storage = new OAuth2\Storage\Pdo(array(
//                 'dsn' => $dsn,
//                 'username' => $dbusername,
//                 'password' => $dbpassword
//               ));
//               $this->oauth_server = new OAuth2\Server($storage);
//               $this->oauth_server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
//               $this->oauth_server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
//               $uri_segments = $this->uri->segment_array();
//               $r = array();
//              //check token
//              $access_token_array = OAuth2\Request::createFromGlobals();
//              $headers = get_all_headers();
//              $access_token_array->query['access_token'] = $headers['access-token'];
// if(!$this->oauth_server->verifyResourceRequest($access_token_array) && $uri_segments[4]!="token"){
//                    $status = 'Token invalid';
//                    $responce = 'http_response_unauthorized';

//                    $this->response(array(
//                         'status'=> $status
//                      ),$this->config->item($responce)
//                   );
                 
//                } 

     }
     public function designations_get() {
        $data = ["Admin","Cashier","Manager","Waiter","Normal User","Others"];
        $responce = "http_response_ok";
        $this->response(array(
          'data' => $data,
          'status'=> "success",
          'message'=> "",
          ),$this->config->item($responce)
        );
    }
   
  public function outlets_post()
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
   
   $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');  
   
   $message = '';
   $data = array();
   if ($this->form_validation->run() == TRUE) { 
       $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
       
       $data = $this->Api_model->getOutlets($company_id);
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

  public function users_get() {
    $users = $this->Common_model->getAllByCompanyIdForDropdown(1, "tbl_users");
    $responce = "http_response_ok";
    $this->response(array(
      'data' => $users,
      'status'=> "success",
      'message'=> "",
      ),$this->config->item($responce)
    );
 } 
 public function time_zone_get() {
  $data = $this->Common_model->getAllForDropdown("tbl_time_zone");
   
  $responce = "http_response_ok";
  $this->response(array(
    'data' => $data,
    'status'=> "success",
    'message'=> "",
    ),$this->config->item($responce)
  );
} 
public function payment_methods_get() {
  $data  = $this->Common_model->getAllByCompanyId(1, "tbl_payment_methods");
  $responce = "http_response_ok";
  $this->response(array(
    'data' => $data,
    'status'=> "success",
    'message'=> "",
    ),$this->config->item($responce)
  );
} 
public function countries_get() {
  $data = $this->Common_model->getAllForDropdown("tbl_countries");  

  $responce = "http_response_ok";
  $this->response(array(
    'data' => $data,
    'status'=> "success",
    'message'=> "",
    ),$this->config->item($responce)
  );
} 


public function get_reservations_post()
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
 
 $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]');  
 
 $message = '';
 $data = array();
 if ($this->form_validation->run() == TRUE) { 
     $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
     
     $data = $this->Api_model->getReservations($outlet_id);  
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


public function change_status_reservation_post()
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
 $this->form_validation->set_rules('status', "Status", 'required|max_length[50]');  
 
 $message = '';
 $data = array();
 if ($this->form_validation->run() == TRUE) { 
     $id  = isset($jsonData['id']) && $jsonData['id']?$jsonData['id']:'';
     $status  = isset($jsonData['status']) && $jsonData['status']?$jsonData['status']:'';
     $data1 = array();
     $data1['status'] =$status;
     $this->Common_model->updateInformation($data1, $id, "tbl_reservations");
     
     $status = "success";
     $message = lang('success_reservation_status');
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

public function remove_reservation_post()
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
      $this->Common_model->deleteStatusChange($id, "tbl_reservations");

      $status = "success";
      $message = lang('remove_reservation_status');;
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
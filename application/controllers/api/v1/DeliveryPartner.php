<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class DeliveryPartner extends REST_Controller
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
    
   public function add_delivery_partner_post()
   {
      $jsonData = json_decode(file_get_contents('php://input'), true);
  $headers = get_all_headers();;
  if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
     $this->response(array(
            'status'=> 'error',
            'message'=> "Unauthorized access"
          ),$this->config->item("http_response_unauthorized")
        );
  }
      $this->form_validation->set_data($jsonData);
     
      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[250]');
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        $data= array();
        $data['name'] = $jsonData['name'];
        $data['description'] = $jsonData['description'];
        $data['logo'] = $jsonData['logo'];
        $data['user_id'] = 1;
        $data['company_id'] = 1;
        $this->Common_model->insertInformation($data, "tbl_delivery_partners");
        
        $status = "success";
        $message = lang('insertion_success');
        $responce = "http_response_ok";
              
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

       $this->response(array(
               'data' => '',
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
   public function edit_delivery_partner_post()
   {
  
      $jsonData = json_decode(file_get_contents('php://input'), true);
  $headers = get_all_headers();;
  if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
     $this->response(array(
            'status'=> 'error',
            'message'=> "Unauthorized access"
          ),$this->config->item("http_response_unauthorized")
        );
  }
      $id =htmlspecialcharscustom($jsonData['id']); 

      $data =  $this->Common_model->getRowByCustomId($id,'id','tbl_delivery_partners');
      
      if($data){
        $status = "success";
        $responce = "http_response_ok";
        $message = '';
      }else{
        $status = "error";
        $message = "No data found!";
        $responce = "http_response_not_found";
      }

      $this->response(array(
                'data' => $data,
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }

   public function store_edit_delivery_partner_post()
   {
      $jsonData = json_decode(file_get_contents('php://input'), true);
  $headers = get_all_headers();;
  if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
     $this->response(array(
            'status'=> 'error',
            'message'=> "Unauthorized access"
          ),$this->config->item("http_response_unauthorized")
        );
  }
      $this->form_validation->set_data($jsonData);
      $id = $jsonData['id'];

      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[10]');
       
      $message = '';
      if ($this->form_validation->run() == TRUE) {
            $data['name'] = $jsonData['name'];
            $data['description'] = $jsonData['description'];
            $data['logo'] = $jsonData['logo'];
            $data['user_id'] = 1;
            $data['company_id'] = 1;
            $this->Common_model->updateInformation($data, $id, "tbl_delivery_partners");
        
            $status = "success";
            $message = lang('update_success');
            $responce = "http_response_ok";
              
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

       $this->response(array(
               'data' => '',
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
    
   public function delivery_partners_get()
   {
      $data = $this->Common_model->getAllByCompanyId(1, "tbl_delivery_partners");
      $responce = "http_response_ok";
      $this->response(array(
        'data' => $data,
        'status'=> "success",
        'message'=> "",
        ),$this->config->item($responce)
      );
   }
 
   public function delete_delivery_partner_post() {
        $jsonData = json_decode(file_get_contents('php://input'), true);
  $headers = get_all_headers();;
  if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
     $this->response(array(
            'status'=> 'error',
            'message'=> "Unauthorized access"
          ),$this->config->item("http_response_unauthorized")
        );
  }
        $this->form_validation->set_data($jsonData);

        $id = $jsonData['id'];
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_delivery_partners");

      $status = "success";
      $message = lang('delete_success');
      $responce = "http_response_ok";

      $this->response(array(
               'data' => '',
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
    }

}
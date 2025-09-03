<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Customer extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Promotion_model');
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
    
   public function add_customer_post()
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
   
      $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
      $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
      if(collectGST1()=="Yes"){
          $this->form_validation->set_rules('gst_number', lang('gst_number'), 'required|max_length[50]');
          $this->form_validation->set_rules('same_or_diff_state', lang('same_or_diff_state'), 'required|max_length[50]');
      }
 
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        $customer_info = array();
        $customer_info['name'] = $jsonData['name'];
        $customer_info['phone'] =$jsonData['phone'];
        $customer_info['email'] =$jsonData['email'];
        $customer_info['default_discount'] =$jsonData['default_discount'];

        if(htmlspecialcharscustom($jsonData['date_of_birth'])){
            $customer_info['date_of_birth'] =$jsonData['date_of_birth'];
        }
        if(htmlspecialcharscustom($jsonData['date_of_anniversary'])){
            $customer_info['date_of_anniversary'] =$jsonData['date_of_anniversary'];
        }
        $c_address = $jsonData['address'];
        $customer_info['address'] = preg_replace("/[\n\r]/"," ",escape_output($c_address)); #remove new line from address

        if(collectGST1()=="Yes"){
            $customer_info['gst_number'] =$jsonData['gst_number'];
            $customer_info['same_or_diff_state'] =$jsonData['same_or_diff_state'];
        }
        $customer_info['user_id'] = 1;
        $customer_info['company_id'] = 1;

 
        $this->Common_model->insertInformation($customer_info, "tbl_customers");
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
   public function edit_customer_post()
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

      $data =  $this->Common_model->getRowByCustomId($id,'id','tbl_customers');
    
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

   public function store_edit_customer_post()
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
     
      $this->form_validation->set_rules('name', lang('category_name'), 'required|max_length[50]');
      $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
      if(collectGST()=="Yes"){
          $this->form_validation->set_rules('gst_number', lang('gst_number'), 'required|max_length[50]');
          $this->form_validation->set_rules('same_or_diff_state', lang('same_or_diff_state'), 'required|max_length[50]');
      }
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
            $customer_info = array();
            $customer_info['name'] = $jsonData['name'];
            $customer_info['phone'] =$jsonData['phone'];
            $customer_info['email'] =$jsonData['email'];
            $customer_info['default_discount'] =$jsonData['default_discount'];

            if($jsonData['date_of_birth']){
                $customer_info['date_of_birth'] =$jsonData['date_of_birth'];
            }
            if($jsonData['date_of_anniversary']){
                $customer_info['date_of_anniversary'] =$jsonData['date_of_anniversary'];
            }
            $c_address = $jsonData['address'];
            $customer_info['address'] = preg_replace("/[\n\r]/"," ",escape_output($c_address)); #remove new line from address

            if(collectGST()=="Yes"){
                $customer_info['gst_number'] =$jsonData['gst_number'];
                $customer_info['same_or_diff_state'] =$jsonData['same_or_diff_state'];
            }
            $customer_info['user_id'] = 1;
            $customer_info['company_id'] = 1;
            
            $this->Common_model->updateInformation($customer_info, $id, "tbl_customers");

            
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
    
   public function customers_post()
   {
    $message = '';
    $data = array(); 
    $data = $this->Common_model->getAllByCompanyId(1, "tbl_customers");
    if($data){
          $status = "success";
          $message = '';
          $responce = "http_response_ok";
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
 
   public function delete_customer_post() {
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
        $this->Common_model->deleteStatusChange($id, "tbl_customers");
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Outlet extends REST_Controller
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
    
   public function edit_outlet_post()
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

      $data =  $this->Common_model->getRowByCustomId($id,'id','tbl_outlets');
       if($data){
        $data->zone_names = $this->Common_model->getAllForDropdown("tbl_time_zone");
        $data->countries = $this->Common_model->getAllForDropdown("tbl_countries");
        $data->items = $this->Common_model->getFoodMenuForOutlet(1, "tbl_food_menus");
        $data->waiters = $this->Common_model->getAllByCompanyId(1, "tbl_users");
     
       } 
 

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

   public function store_edit_outlet_post()
   {
      $jsonData = json_decode(file_get_contents('php://input'), true);
 
  $headers = get_all_headers();;
 
  $tmp = json_encode(str_replace("\/", '/', $jsonData));
  $tmp = (str_replace("\/", '/', $tmp));
 
  if($headers['checksum'] != generateHashCode($tmp)){
     $this->response(array(
            'status'=> 'error',
            'message'=> "Unauthorized access"
          ),$this->config->item("http_response_unauthorized")
        );
  }
     
      $this->form_validation->set_data($jsonData);
      $id = $jsonData['id'];

     
      $this->form_validation->set_rules('branch_name', lang('branch_name'), 'required');
      $this->form_validation->set_rules('address_line_1', lang('address_line_1'), 'required');
      $this->form_validation->set_rules('address_line_2', lang('address_line_2'), 'required');
      $this->form_validation->set_rules('city', lang('city'), 'required');
      $this->form_validation->set_rules('state_province_region', lang('state_province_region'), 'required');
      $this->form_validation->set_rules('zip_postal_code', lang('zip_postal_code'), 'required');
      $this->form_validation->set_rules('country', lang('country'), 'required');
      $this->form_validation->set_rules('timezone', lang('timezone'), 'required');
      $this->form_validation->set_rules('branch_location', lang('branch_location'), 'required');
      $this->form_validation->set_rules('primary_poc_name', lang('primary_poc_name'), 'required');
      $this->form_validation->set_rules('primary_poc_number', lang('primary_poc_number'), 'required');
      $this->form_validation->set_rules('primary_poc_email', lang('primary_poc_email'), 'required');
      $this->form_validation->set_rules('secondary_poc_name', lang('secondary_poc_name'), 'required');
      $this->form_validation->set_rules('secondary_poc_number', lang('secondary_poc_number'), 'required');
      $this->form_validation->set_rules('secondary_poc_email', lang('secondary_poc_email'), 'required');
      $this->form_validation->set_rules('admin_full_name', lang('admin_full_name'), 'required');
      $this->form_validation->set_rules('admin_username', lang('admin_username'), 'required');
      $this->form_validation->set_rules('admin_email', lang('admin_email'), 'required');
      $this->form_validation->set_rules('admin_password', lang('admin_password'), 'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/]');
      $this->form_validation->set_rules('default_waiter', lang('Default_Waiter'), 'max_length[11]');
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        
        
        $outlet_info = array();
        $outlet_info['branch_name'] = $jsonData['branch_name'];
        $outlet_info['address_line_1'] = $jsonData['address_line_1'];
        $outlet_info['address_line_2'] = $jsonData['address_line_2'];
        $outlet_info['city'] = $jsonData['city'];
        $outlet_info['state_province_region'] = $jsonData['state_province_region'];
        $outlet_info['zip_postal_code'] = $jsonData['zip_postal_code'];
        $outlet_info['country'] = $jsonData['country'];
        $outlet_info['timezone'] = $jsonData['timezone'];
        $outlet_info['branch_location'] = $jsonData['branch_location'];
        $outlet_info['primary_poc_name'] = $jsonData['primary_poc_name'];
        $outlet_info['primary_poc_number'] = $jsonData['primary_poc_number'];
        $outlet_info['primary_poc_email'] = $jsonData['primary_poc_email'];
        $outlet_info['secondary_poc_name'] = $jsonData['secondary_poc_name'];
        $outlet_info['secondary_poc_number'] = $jsonData['secondary_poc_number'];
        $outlet_info['secondary_poc_email'] = $jsonData['secondary_poc_email'];
        $outlet_info['admin_full_name'] = $jsonData['admin_full_name'];
        $outlet_info['admin_username'] = $jsonData['admin_username'];
        $outlet_info['admin_email'] = $jsonData['admin_email'];
        $outlet_info['admin_password'] = $jsonData['admin_password'];
        $outlet_info['address'] = $outlet_info['address_line_1'];
        $outlet_info['phone'] = $outlet_info['primary_poc_number'];
        $outlet_info['email'] = $outlet_info['primary_poc_email'];
        $outlet_info['online_self_order_receiving_id'] =$jsonData['online_self_order_receiving_id'];
        $outlet_info['default_waiter'] =$jsonData['default_waiter'];
        $outlet_info['active_status'] =$jsonData['active_status'];
       
        
        $main_array = array();
        $i =1;
        
        $branch_timings = json_decode(str_replace("'", '"', $jsonData['branch_timings']), true);
        if(!empty($branch_timings)){
            foreach($branch_timings as $key=>$branch_timing){
                $tmp_array['counter'] = getCounter($branch_timing['counter_name']);
                $tmp_array['status'] = $branch_timing['status'];
                $tmp_array['counter_name'] = $branch_timing['counter_name'];
                $tmp_array['start_time'] = $branch_timing['start_time'];
                $tmp_array['end_time'] = $branch_timing['end_time'];
                $tmp_array['start_time_int'] = $branch_timing['start_time_int'];
                $tmp_array['end_time_int'] = $branch_timing['end_time_int'];
                $main_arr[] = $tmp_array;
            }
            $outlet_info['branch_timings'] = json_encode($main_arr);
           
        }

        $main_array = array();
        $special_days_list = json_decode(str_replace("'", '"', $jsonData['special_days_list']), true);
     
        if(!empty($special_days_list)){
            foreach($special_days_list as $key=>$spacial_day_title){
                $tmp_array['spacial_day_title'] = $spacial_day_title['spacial_day_title'];
                $tmp_array['spacial_day_date'] = $spacial_day_title['spacial_day_date'];
                $main_arr[] = $tmp_array;
            }
            $outlet_info['special_days_list'] = json_encode($main_arr);
          
           
        }
 
        $this->Common_model->updateInformation($outlet_info, $id, "tbl_outlets");
        
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
    
   public function outlets_get()
   {
      $data =$this->Common_model->getAllByCompanyId(1, "tbl_outlets");
      $responce = "http_response_ok";
      $this->response(array(
        'data' => $data,
        'status'=> "success",
        'message'=> "",
        ),$this->config->item($responce)
      );
   }
 
   public function delete_outlet_post() {
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
        $this->Common_model->deleteStatusChange($id, "tbl_outlets");
        $this->Common_model->deletingMultipleFormData('outlet_id', $id, 'tbl_outlet_ingredients');
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
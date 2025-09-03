<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Kitchen extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Kitchen_model');
               $this->load->model('Api_model');
               $this->load->model('Sale_model');
               $this->load->model('Waiter_model');
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
     
     public function get_new_orders($outlet_id, $kitchen_id) {
      $data1 = $this->Api_model->getKichenData($outlet_id);
      $i = 0;
      foreach ($data1 as $key => $value) {
          $items_by_sales_id = $this->Api_model->getAllKitchenItemsFromSalesDetailBySalesId($value->id, $kitchen_id);
          
          if ($items_by_sales_id) {
              foreach ($items_by_sales_id as $single_item_by_sale_id) {
                  $modifier_information = $this->Api_model->getModifiersBySaleAndSaleDetailsId($value->id, $single_item_by_sale_id->id);
                  
                  $single_item_by_sale_id->modifiers = $modifier_information;
              }
              $value->items = $items_by_sales_id;
          } else {
              unset($data1[$key]); // safe to unset but we'll reindex below
          }
      }
      return array_values($data1); // Reindex array to avoid gaps in numeric keys
  }
 
   
   
   public function panel_post()
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
   $this->form_validation->set_rules('kitchen_id', "Kitchen ID", 'required|max_length[50]');  
   
   $message = '';
   $data = array();
   if ($this->form_validation->run() == TRUE) { 
       $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
       $kitchen_id  = isset($jsonData['kitchen_id']) && $jsonData['kitchen_id']?$jsonData['kitchen_id']:'';
       $data =  $this->get_new_orders($outlet_id,$kitchen_id);
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

   public function kitchens_post()
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
       $data = $this->Common_model->getAllByCompanyId($company_id, "tbl_kitchens"); 

       foreach ($data as $key=>$value){
        $txt_cates = '';
        $categories = $this->Common_model->getKitchenCategoriesById($value->id);
        foreach ($categories as $k=>$category){
            $txt_cates.=$category->category_name;
            if($k<sizeof($categories)-1){
                $txt_cates.=", ";
            }
        }
        $data[$key]->outlet_name = getOutletNameById($value->outlet_id);
        unset($data[$key]->outlet_id);
        unset($data[$key]->printer_id);
        unset($data[$key]->print_server_url);
        unset($data[$key]->company_id);
        unset($data[$key]->del_status);
        $data[$key]->categories = $txt_cates;
    }

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

 public function change_kitchen_status_post()
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
     
    $this->form_validation->set_rules('item_ids', "Item IDs", 'required|max_length[50]');   
    $this->form_validation->set_rules('cooking_status', "Cooking Status", 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $cooking_status  = isset($jsonData['cooking_status']) && $jsonData['cooking_status']?$jsonData['cooking_status']:'';
        $item_ids  = isset($jsonData['item_ids']) && $jsonData['item_ids']?$jsonData['item_ids']:'';

        
        $previous_id = $item_ids; 
        $previous_id_array = explode(",",$previous_id);

        foreach($previous_id_array as $single_previous_id){
            $previous_id = $single_previous_id;
            $item_info = $this->Api_model->getItemInfoByPreviousId($previous_id);
            
            $sale_id = $item_info->sales_id;
           
            $sale_info = $this->Api_model->getSaleBySaleId($sale_id);

            $tables_booked = $sale_info[0]->orders_table_text;

            if($cooking_status=="Started Cooking"){
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_start_time' => date('Y-m-d H:i:s'));
                
                $this->db->where('previous_id', $previous_id);
                $this->db->update('tbl_kitchen_sales_details', $cooking_status_update_array);
                
                if($sale_info[0]->cooking_start_time==''){
                    $cooking_update_array_sales_tbl = array('cooking_start_time' => date('Y-m-d H:i:s'));
                    $this->db->where('id', $sale_id);
                    $this->db->update('tbl_kitchen_sales', $cooking_update_array_sales_tbl);
                }
                
            }else{

                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_done_time' => date('Y-m-d H:i:s'));
                $this->db->where('previous_id', $previous_id);
                $this->db->update('tbl_kitchen_sales_details', $cooking_status_update_array);

                $cooking_update_array_sales_tbl = array('cooking_done_time' => date('Y-m-d H:i:s'));
                $this->db->where('id', $sale_id);
                $this->db->update('tbl_kitchen_sales', $cooking_update_array_sales_tbl);

                $order_name = $sale_info[0]->sale_no;

                $notification = "Table: ".$tables_booked.', Customer: '.$sale_info[0]->customer_name.', Item: '.$item_info->menu_name.' is ready to serve, Order: '.$order_name;
                $notification_data = array();        
                $notification_data['notification'] = $notification;
                $notification_data['sale_id'] = $sale_id;
                $notification_data['waiter_id'] = $sale_info[0]->waiter_id;
                $notification_data['outlet_id'] = $sale_info[0]->outlet_id;
                $this->db->insert('tbl_notifications', $notification_data); 
            }
        } 

        
        
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

}
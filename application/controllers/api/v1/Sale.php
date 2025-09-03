<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Sale extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('Sale_model');
               $this->load->model('Dashboard_model');
               $this->load->model('Inventory_model');
               $this->load->library('form_validation');
               $this->load->model('Api_model');
               $this->Common_model->setDefaultTimezone();
                //loading dabase
//                 $this->load->database();

//                 $hostname = $this->db->hostname;
//                 $username = $this->db->username;
//                 $password = $this->db->password;
//                 $database = $this->db->database;
//                 $port = $this->db->port;
//                 //dns checking 
//                 $dsn  = 'mysql:dbname=' . $database . ';host=' . $hostname. ';port=' . $port;
//                 $dbusername = $username;
//                 $dbpassword = $password;
 
//                OAuth2\Autoloader::register();
//                $storage = new OAuth2\Storage\Pdo(array(
//                  'dsn' => $dsn,
//                  'username' => $dbusername,
//                  'password' => $dbpassword
//                ));
//                $this->oauth_server = new OAuth2\Server($storage);
//                $this->oauth_server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
//                $this->oauth_server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
//                $uri_segments = $this->uri->segment_array();
//                $r = array();
//                //check token
//                $access_token_array = OAuth2\Request::createFromGlobals();
//                $headers = get_all_headers();
//                $access_token_array->query['access_token'] = $headers['access-token'];
//  if(!$this->oauth_server->verifyResourceRequest($access_token_array) && $uri_segments[4]!="token"){
//                     $status = 'Token invalid';
//                     $responce = 'http_response_unauthorized';
 
//                     $this->response(array(
//                          'status'=> $status
//                       ),$this->config->item($responce)
//                    );
                    
//                 } 

     }
    
     public function getTablesDetails($tables){
      foreach($tables as $table){
          $table->orders_table = $this->Sale_model->getOrdersOfTableByTableId($table->id);
          foreach($table->orders_table as $order_table){
              $to_time = strtotime(date('Y-m-d H:i:s'));
              $from_time = strtotime($order_table->booking_time);
              $minutes = floor(abs($to_time - $from_time) / 60);
              $order_table->booked_in_minute = $minutes;
          }
      }
      return $tables;
  }
  public function get_new_notification_outlet($outlet_id)
  {
      $notifications = $this->Sale_model->getNotificationByOutletIdCustom($outlet_id);
      return $notifications;
  }

   public function get_food_menu_categories_post()
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
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';

          $data = $this->Api_model->getSortingForPOSApi($company_id);
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
     public function get_food_menus_post()
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
      
      $message = '';
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
          $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $data = $this->Api_model->getAllFoodMenusAPI($outlet_id,$company_id);
        
          if(isset($data) && $data){
              foreach ($data as $key=>$value){
                $variations = $this->Api_model->getFoodMenuVariations($value->id);
                if($variations){
                  foreach($variations as $variation){
                    $variation->delivery_price =convertPlanJson($variation->delivery_price);
                    foreach ($variation->delivery_price as $index => $price) {
                                $convertedDeliveryPrice[] = [
                                    "partner_id" => explode('_', $index)[1],
                                    "sale_price_delivery" => $price
                                ];
                            }
                      $variation->delivery_price = $convertedDeliveryPrice;
                      $variation->photo =   $value->photo;
                      $variation->name =   $data->name." ".$value->name;
                    }
                }
  
                
                $modifiers = $this->Api_model->getFoodMenuModierById($value->id); 
                $value->modifiers = $modifiers;
                $value->variations = $variations;
                $value->delivery_price =convertPlanJson($value->delivery_price);
                $convertedDeliveryPrice = [];
                      foreach ($value->delivery_price as $index => $price) {
                          $convertedDeliveryPrice[] = [
                              "partner_id" => explode('_', $index)[1],
                              "sale_price_delivery" => $price
                          ];
                      }
                $value->delivery_price = $convertedDeliveryPrice;
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


     public function get_food_menu_details_post()
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
      
      $this->form_validation->set_rules('food_menu_id', "Food Menu ID", 'required|max_length[50]');  
      
      $message = '';
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $food_menu_id  = isset($jsonData['food_menu_id']) && $jsonData['food_menu_id']?$jsonData['food_menu_id']:'';
          $data = $this->Api_model->getFoodMenuDetails($food_menu_id);
            if($data){
              $variations = $this->Api_model->getFoodMenuVariations($data->id);
              if($variations){
                foreach($variations as $variation){
                  $variation->delivery_price =convertPlanJson($variation->delivery_price);
                  foreach ($variation->delivery_price as $index => $price) {
                              $convertedDeliveryPrice[] = [
                                  "partner_id" => explode('_', $index)[1],
                                  "sale_price_delivery" => $price
                              ];
                          }
                    $variation->delivery_price = $convertedDeliveryPrice;
                    $variation->photo =   $data->photo;
                    $variation->name =   $data->name." ".$variation->name;
                  }
              }

              
              $modifiers = $this->Api_model->getFoodMenuModierById($data->id); 
              $data->modifiers = $modifiers;
              $data->variations = $variations;
              $data->delivery_price =convertPlanJson($data->delivery_price);
              $convertedDeliveryPrice = [];
                    foreach ($data->delivery_price as $index => $price) {
                        $convertedDeliveryPrice[] = [
                            "partner_id" => explode('_', $index)[1],
                            "sale_price_delivery" => $price
                        ];
                    }
              $data->delivery_price = $convertedDeliveryPrice;
              
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

     public function pos_post()
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
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
          $company_id = 1;

          $data = array();
          $tables = $this->Sale_model->getTablesByOutletId($outlet_id);
        
          $data['tables'] = $this->getTablesDetails($tables);
          $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
          $data['food_menus'] = $this->Sale_model->getAllFoodMenusAPI($outlet_id);
        
          if(isset($data['food_menus']) && $data['food_menus']){
              foreach ($data['food_menus'] as $key=>$value){
                  $variations = $this->Common_model->getAllByCustomId($value->id,"parent_id","tbl_food_menus",$order='');
                  $modifiers = $this->Sale_model->getFoodMenuModierById($value->id);
                  $data['food_menus'][$key]->modifiers = $modifiers;
                  $data['food_menus'][$key]->is_variation = isset($variations) && $variations?'Yes':'No';
                  $data['food_menus'][$key]->variations = $variations;
                      $kitchen = getKitchenNameAndIdByOutletId($outlet_id,$value->category_id);
                      $data['food_menus'][$key]->kitchen_id =$kitchen[0];
                      $data['food_menus'][$key]->kitchen_name =$kitchen[1];
              }
          }
          $data['denominations'] = $this->Common_model->getDenomination($company_id);
          $data['menu_categories'] = $this->Common_model->getSortingForPOS();
          $data['menu_modifiers'] = $this->Sale_model->getAllMenuModifiers();
          $data['waiters'] = $this->Sale_model->getWaitersForThisCompany($company_id,'tbl_users');
          $data['MultipleCurrencies'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_multiple_currencies");
          $data['users'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
          $data['outlet_information'] = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
          $data['payment_methods'] = $this->Sale_model->getAllPaymentMethods();
          $data['payment_method_finalize'] = $this->Sale_model->getAllPaymentMethodsFinalize();
          $data['deliveryPartners'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_delivery_partners");
          $data['areas'] = $this->Common_model->getAllByCompanyIdOrderBy($company_id, 'tbl_areas',"ASC");
          $data['only_modifiers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_modifiers');
          $data['kitchens'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
          $data['notifications'] = $this->get_new_notification_outlet($outlet_id);
          //$data['sale_details'] = $this->Common_model->getDataById($sale_id, "tbl_sales");
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
 
     public function get_customers_post()
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
          $company_id = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $data = array(); 
          $data['customers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_customers');
          
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
     public function get_delivery_partners_post()
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
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $company_id = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $data= $this->Api_model->getAllDeliveryPartners($company_id);
          
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
     public function get_waiters_post()
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
      $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
          $company_id = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $data['waiters'] = $this->Sale_model->getWaitersForThisCompany($company_id,'tbl_users'); 
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


     public function get_promo_post()
     {
      $jsonData = json_decode(file_get_contents('php://input'), true);
  $headers = get_all_headers();;
  // if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
  //    $this->response(array(
  //           'status'=> 'error',
  //           'message'=> "Unauthorized access"
  //         ),$this->config->item("http_response_unauthorized")
  //       );
  // }
      $this->form_validation->set_data($jsonData);
      
      $this->form_validation->set_rules('outlet_id', "Outlet", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
         
          $data = getTodayPromoDetailsByOutletId($outlet_id);
          
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
     public function order_status_screen_post()
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
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
          $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
          
          $data = getStatusOrdersByOutlet($outlet_id);
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

     public function customer_display_post()
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
      
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
        $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
        $file_name = "cart_data_".$user_id.".json";
        $str = file_get_contents("assets/".$file_name);
        $data = json_decode($str);

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
 
     public function get_register_details_post()
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
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
        $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
        $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';

        $date = date('Y-m-d');
        $getOpeningDateTime = $this->Sale_model->getOpeningDateTime($user_id,$outlet_id,$date);
        $opening_date_time = isset($getOpeningDateTime->opening_date_time) && $getOpeningDateTime->opening_date_time?$getOpeningDateTime->opening_date_time:'';
 
        $getOpeningDetails = $this->Sale_model->getOpeningDetails($user_id,$outlet_id,$date);
        $opening_details=  isset($getOpeningDetails->opening_details) && $getOpeningDetails->opening_details?$getOpeningDetails->opening_details:'';


        $opening_details_decode = json_decode($opening_details);
                    $main_array = array(); 
                    $array_p_name = array();
                    $array_p_amount = array();
                    if(isset($opening_details_decode) && $opening_details_decode){
                        foreach ($opening_details_decode as $key=>$value){
                            $key++;
                            $payments = explode("||",$value);

                            $total_purchase = $this->Sale_model->getAllPurchaseByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
                            $total_due_receive = $this->Sale_model->getAllDueReceiveByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
                            $total_due_payment = $this->Sale_model->getAllDuePaymentByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
                            $total_expense = $this->Sale_model->getAllExpenseByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
                            $refund_amount = $this->Sale_model->getAllRefundByPaymentAPI($user_id,$opening_date_time,$payments[0]);
                            $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);

                            $inline_total = $payments[2] - $total_purchase + $total_sale  + $total_due_receive - $total_due_payment - $total_expense - $refund_amount;

                            $array_p_name[] = $payments[1];
                            $array_p_amount[] = $inline_total;

                            $inline_array = array();
                            $inline_array['payment_method'] = $payments[1];
                            $inline_array['opening_balance'] = getAmtPCustom($payments[2]);
                            $inline_array['purchase'] = getAmtPCustom($total_purchase);
                            $inline_array['sale'] = getAmtPCustom($total_sale);

                            if($payments[0]==1):
                                $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRowsForAPI($user_id,$opening_date_time,$payments[0]);
                                $array_mul = array();
                                if($total_sale_mul_c_rows){
                                    foreach ($total_sale_mul_c_rows as $value1):
                                      $array_mul[$value1->multi_currency] = getAmtPCustom($value1->total_amount);
                                    endforeach;

                                }
                                $inline_array['multi_currency'] = $array_mul;

                            endif;

                            $inline_array['due_receive'] = getAmtPCustom($total_due_receive);
                            $inline_array['due_payment'] = getAmtPCustom($total_due_payment);
                            $inline_array['expense'] = getAmtPCustom($total_expense);
                            $inline_array['refund_amount'] = getAmtPCustom($refund_amount);
                            $inline_array['closing_balance'] = getAmtPCustom($inline_total);
                            $main_array[] = $inline_array;
                    } 

                  }

                    $summary = array();
                    foreach ($array_p_name as $key=>$value){
                      $summary_inline = array();
                      $summary_inline['payment_name'] = $value;
                      $summary_inline['total_amount'] = getAmtPCustom($array_p_amount[$key]);
                      $summary[] = $summary_inline;
                    }

                    $data['opening_date_time'] = date('Y-m-d h:m A', strtotime($opening_date_time));
                    $data['payment_wise_details'] = $main_array;
                    $data['summary'] = $summary;
        
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

    public function close_register_post()
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
     $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');  
     
     $message = '';
     $data = array();
     if ($this->form_validation->run() == TRUE) { 
       $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
       $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';

       $date = date('Y-m-d');
       $getOpeningDateTime = $this->Sale_model->getOpeningDateTime($user_id,$outlet_id,$date);
       $opening_date_time = isset($getOpeningDateTime->opening_date_time) && $getOpeningDateTime->opening_date_time?$getOpeningDateTime->opening_date_time:'';

       $getOpeningDetails = $this->Sale_model->getOpeningDetails($user_id,$outlet_id,$date);
       $opening_details=  isset($getOpeningDetails->opening_details) && $getOpeningDetails->opening_details?$getOpeningDetails->opening_details:'';


       $opening_details_decode = json_decode($opening_details);
       $total_closing = 0;
       $total_sale_all = 0;
       $total_purchase_all = 0;
       $total_due_receive_all = 0;
       $total_due_payment_all = 0;
       $total_expense_all = 0;

       $payment_details = array();
       $others_currency = array();
       foreach ($opening_details_decode as $key=>$value){
           $payments = explode("||",$value);

           $total_sale =  $this->Sale_model->getAllSaleByPayment($opening_date_time,$payments[0]);
           $total_purchase = $this->Sale_model->getAllPurchaseByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
           $total_due_receive = $this->Sale_model->getAllDueReceiveByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
           $total_due_payment = $this->Sale_model->getAllDuePaymentByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
           $total_expense = $this->Sale_model->getAllExpenseByPaymentAPI($user_id,$outlet_id,$opening_date_time,$payments[0]);
           $refund_amount = $this->Sale_model->getAllRefundByPaymentAPI($user_id,$opening_date_time,$payments[0]);


           $total_sale_all += $total_sale;
           $total_purchase_all += $total_purchase;
           $total_due_receive_all += $total_due_receive;
           $total_due_payment_all += $total_due_payment;
           $total_expense_all += $total_expense;
           $inline_closing = ($payments[2] - $total_purchase - $refund_amount +  $total_sale  + $total_due_receive - $total_due_payment - $total_expense);
           $total_closing += $inline_closing;

           $preview_amount = isset($payment_details[$payments[1]]) && $payment_details[$payments[1]]?$payment_details[$payments[1]]:0;
           $payment_details[$payments[1]] = $preview_amount + $inline_closing;

           if($payments[0]==1):
               $total_sale_mul_c_rows =  $this->Sale_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0]);
               if($total_sale_mul_c_rows){
                   foreach ($total_sale_mul_c_rows as $value1):
                       $tmp_arr = array();
                       $tmp_arr['payment_name'] = $value1->multi_currency;
                       $tmp_arr['amount'] = getAmtPCustom($value1->total_amount);
                       $others_currency[] = $tmp_arr;
                   endforeach;
               }
          endif;
       }


       $changes = array(
           'closing_balance' => $total_closing,
           'closing_balance_date_time' => date("Y-m-d H:i:s"),
           'customer_due_receive' => $total_due_receive_all,
           'total_purchase' => $total_purchase_all,
           'total_due_payment' => $total_due_payment_all,
           'total_expense' => $total_expense_all,
           'sale_paid_amount' => $total_sale_all,
           'others_currency' => json_encode($others_currency),
           'payment_methods_sale' => json_encode($payment_details),
           'register_status' => 2
       );

       $this->db->where('outlet_id', $outlet_id);
       $this->db->where('user_id', $user_id);
       $this->db->where('opening_balance_date_time', $opening_date_time);
       $this->db->where('register_status', 1);
       $this->db->update('tbl_register', $changes);

       
         $status = "success";
         $message = lang('register_close');
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

   public function reservation_page_get()
   {
    $data = array();
    $data['outlets'] =$this->Common_model->getAllByCompanyId(1, "tbl_outlets");
    $company = getMainCompany();
    $data['reservation_availability_times'] = json_decode($company->reservation_times);

    $responce = "http_response_ok";
    $this->response(array(
      'data' => $data,
      'status'=> "success",
      'message'=> "",
      ),$this->config->item($responce)
    );
   
  }

  public function get_reservation_post()
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
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
        
        $data = $this->Common_model->getReservationsAPI($outlet_id);
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
  public function get_self_orders_post()
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
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
        $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
        
        $data = $this->Sale_model->self_order_sales_adminAPI($outlet_id,$user_id);
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

 
  public function get_online_orders_post()
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
   
   $message = '';
   $data = array();
   if ($this->form_validation->run() == TRUE) { 
       $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
       $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
       
       $data = $this->Sale_model->online_order_sales_adminAPI($outlet_id,$user_id);
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
 public function get_order_details_post()
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
   
   $this->form_validation->set_rules('sale_id', "ID", 'required|max_length[50]');  
   
   $message = '';
   $data = array();
   if ($this->form_validation->run() == TRUE) { 
    $sales_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:''; 
       $sales_information = $this->Common_model->getDataById($sales_id, "tbl_kitchen_sales");;

        $sales_information->sub_total = getAmtP(isset($sales_information->sub_total) && $sales_information->sub_total?$sales_information->sub_total:0);
        $sales_information->paid_amount = getAmtP(isset($sales_information->paid_amount) && $sales_information->paid_amount?$sales_information->paid_amount:0);
        $sales_information->due_amount = getAmtP(isset($sales_information->due_amount) && $sales_information->due_amount?$sales_information->due_amount:0);
        $sales_information->vat = getAmtP(isset($sales_information->vat) && $sales_information->vat?$sales_information->vat:0);
        $sales_information->total_payable = getAmtP(isset($sales_information->total_payable) && $sales_information->total_payable?$sales_information->total_payable:0);
        $sales_information->total_item_discount_amount = getAmtP(isset($sales_information->total_item_discount_amount) && $sales_information->total_item_discount_amount?$sales_information->total_item_discount_amount:0);
        $sales_information->sub_total_with_discount = getAmtP(isset($sales_information->sub_total_with_discount) && $sales_information->sub_total_with_discount?$sales_information->sub_total_with_discount:0);
        $sales_information->sub_total_discount_amount = getAmtP(isset($sales_information->sub_total_discount_amount) && $sales_information->sub_total_discount_amount?$sales_information->sub_total_discount_amount:0);
        $sales_information->total_discount_amount = getAmtP(isset($sales_information->total_discount_amount) && $sales_information->total_discount_amount?$sales_information->total_discount_amount:0);
        $sales_information->delivery_charge = (isset($sales_information->delivery_charge) && $sales_information->delivery_charge?$sales_information->delivery_charge:0);
        $this_value = $sales_information->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_information->sub_total_discount_value = getAmtP(isset($sales_information->sub_total_discount_value) && $sales_information->sub_total_discount_value?$sales_information->sub_total_discount_value:0);
        }
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesIdKitchen($sales_id);

        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchen($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sales_details_objects[0]->menu_price_without_discount = getAmtP(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0);
        $sales_details_objects[0]->menu_price_with_discount = getAmtP(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0);
        $sales_details_objects[0]->menu_unit_price = getAmtP(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0);
        $sales_details_objects[0]->menu_vat_percentage = getAmtP(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0);
        $sales_details_objects[0]->discount_amount = getAmtP(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0);

        $this_value = $sales_details_objects[0]->menu_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_details_objects[0]->menu_discount_value = getAmtP(isset($sales_details_objects[0]->menu_discount_value) && $sales_information->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0);
        }

        $sale_object = $sales_information;
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = '';

       $data = $sale_object;
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
 public function accept_order_post()
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
   
   $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
   
   $message = '';
   $data = array();
   if ($this->form_validation->run() == TRUE) { 
        $sales_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:''; 
         
        $status = 3;

        $data1 = array();
        $data1['is_self_order'] = "No";
        $data1['is_online_order'] = "No";
        $data1['is_accept'] = 1;
        $data1['future_sale_status'] = $status;
        $data1['self_order_status'] = "Approved";
        $this->db->where('id', $sales_id);
        $this->db->update('tbl_kitchen_sales', $data1);

        $sales_information = $this->Common_model->getDataById($sales_id, "tbl_kitchen_sales");;
        $sales_information->sub_total = getAmtP(isset($sales_information->sub_total) && $sales_information->sub_total?$sales_information->sub_total:0);
        $sales_information->paid_amount = getAmtP(isset($sales_information->paid_amount) && $sales_information->paid_amount?$sales_information->paid_amount:0);
        $sales_information->due_amount = getAmtP(isset($sales_information->due_amount) && $sales_information->due_amount?$sales_information->due_amount:0);
        $sales_information->vat = getAmtP(isset($sales_information->vat) && $sales_information->vat?$sales_information->vat:0);
        $sales_information->total_payable = getAmtP(isset($sales_information->total_payable) && $sales_information->total_payable?$sales_information->total_payable:0);
        $sales_information->total_item_discount_amount = getAmtP(isset($sales_information->total_item_discount_amount) && $sales_information->total_item_discount_amount?$sales_information->total_item_discount_amount:0);
        $sales_information->sub_total_with_discount = getAmtP(isset($sales_information->sub_total_with_discount) && $sales_information->sub_total_with_discount?$sales_information->sub_total_with_discount:0);
        $sales_information->sub_total_discount_amount = getAmtP(isset($sales_information->sub_total_discount_amount) && $sales_information->sub_total_discount_amount?$sales_information->sub_total_discount_amount:0);
        $sales_information->total_discount_amount = getAmtP(isset($sales_information->total_discount_amount) && $sales_information->total_discount_amount?$sales_information->total_discount_amount:0);
        $sales_information->delivery_charge = (isset($sales_information->delivery_charge) && $sales_information->delivery_charge?$sales_information->delivery_charge:0);
        $this_value = $sales_information->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_information->sub_total_discount_value = getAmtP(isset($sales_information->sub_total_discount_value) && $sales_information->sub_total_discount_value?$sales_information->sub_total_discount_value:0);
        }
        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesIdKitchen($sales_id);

        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchen($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sales_details_objects[0]->menu_price_without_discount = getAmtP(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0);
        $sales_details_objects[0]->menu_price_with_discount = getAmtP(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0);
        $sales_details_objects[0]->menu_unit_price = getAmtP(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0);
        $sales_details_objects[0]->menu_vat_percentage = getAmtP(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0);
        $sales_details_objects[0]->discount_amount = getAmtP(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0);

        $this_value = $sales_details_objects[0]->menu_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_details_objects[0]->menu_discount_value = getAmtP(isset($sales_details_objects[0]->menu_discount_value) && $sales_information->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0);
        }

        $sale_object = $sales_information;
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = '';

       $data = $sale_object;
       $status = "success";
       $message = 'Order accept successfully!';
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
   public function decline_order_post()
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
    
    $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
         $sales_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:''; 
          
         $status = 3;
 
         $data1 = array();
         $data1['is_self_order'] = "No";
         $data1['is_online_order'] = "No";
         $data1['future_sale_status'] = $status;
         $data1['self_order_status'] = "Decline";
         $this->db->where('id', $sales_id);
         $this->db->update('tbl_kitchen_sales', $data1);
          
         
        $status = "success";
        $message = 'Order decline successfully!';
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
 public function delete_sale_post() {
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

  $id = $jsonData['id'];
  $sale_id = $this->custom->encrypt_decrypt($id, 'decrypt');
  $this->db->delete('tbl_sales', array('id' => $sale_id));
  $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));
  $this->db->delete('tbl_sale_payments', array('sale_id' => $sale_id));
  $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
  $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));
  $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
  $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));
  $this->db->delete('tbl_orders_table', array('sale_id' => $sale_id));
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
 public function cancel_order_post()
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
    
    $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
    $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');  
    $this->form_validation->set_rules('reason', "Reason", 'required|max_length[250]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
         $sales_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:''; 
         $reason  = isset($jsonData['reason']) && $jsonData['reason']?$jsonData['reason']:''; 
         $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:''; 
         $select_kitchen_row = getOrderNoByOrderId($sales_id);
         $order_details = json_decode($select_kitchen_row->self_order_content);
          
         if($select_kitchen_row){
             $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
             $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
             $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
         }
 
         $txt = '<b>Reason: '.$reason."</b>";
         $txt .= '<br>';
       
 
         $customer_info = getCustomerData($order_details->customer_id);
         $txt.="Sale No: ".$order_details->sale_no.", ";
         $txt.="Sale Date: ".date($this->session->userdata('date_format'), strtotime($order_details->date_time)).", ";
         $txt.="Customer: ".(isset($customer_info) && $customer_info->name?$customer_info->name:'---')." - ".(isset($customer_info) && $customer_info->phone?$customer_info->phone:'').", ";
 
         if(isset($order_details->total_vat) && $order_details->total_vat){
             $txt.="VAT: ".$order_details->total_vat.",";
         }
         if(isset($order_details->total_discount_amount) && $order_details->total_discount_amount){
             $txt.="Discount: ".$order_details->total_discount_amount.", ";
         }
         if(isset($order_details->delivery_charge) && $order_details->delivery_charge){
             $txt.="Charge: ".$order_details->delivery_charge.", ";
         }
         if(isset($order_details->tips_amount) && $order_details->tips_amount){
             $txt.="Tips: ".$order_details->tips_amount.", ";
         }
         $txt.="Total Payable: ".$order_details->total_payable;
         if(count($order_details->items)>0){
             $txt.="<br><b>Items:</b><br>";
             foreach($order_details->items as $key=>$item){
 
                 $txt.=$item->menu_name."("."$item->qty X $item->menu_unit_price".")";
                 if($item->menu_combo_items  && $item->menu_combo_items!='undefined'){
                     $txt.="=><b>Combo Items: </b>";
                     $txt.=$item->menu_combo_items;
                 }
                 if($key < (sizeof($order_details->items) -1)){
                     $txt.=", ";
                 }
                 $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                 if(!empty($modifier_id_array)>0){
                     $i = 0;
                     $txt.=", <b>&nbsp;&nbsp;Modifier:</b>";
                     foreach($modifier_id_array as $key1=>$single_modifier_id){
                         $txt.="&nbsp;&nbsp;".getModifierNameById($single_modifier_id);
                         if($key1 < (sizeof($modifier_id_array) -1)){
                             $txt.=", ";
                         }
                         $i++;
                     }
                 }
             }
         }
 
         //store audit log data
         putAuditLog($user_id,$txt,"Cancelled Sale",date('Y-m-d H:i:s'));

         
        $status = "success";
        $message = 'Order cancelled successfully!';
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
  public function change_reservation_status_post()
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
        $id   = isset($jsonData['id']) && $jsonData['id']?$jsonData['id']:'';
        $status   = isset($jsonData['status']) && $jsonData['status']?$jsonData['status']:'';
         

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
        $id   = isset($jsonData['id']) && $jsonData['id']?$jsonData['id']:'';
        $this->Common_model->deleteStatusChange($id, "tbl_reservations");
        $status = "success";
        $message = lang('remove_reservation_status');
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
  
  public function add_reservation_post()
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
    
      $this->form_validation->set_rules('outlet_id', "Outlet", 'required|max_length[200]');
      $this->form_validation->set_rules('name', "Name", 'required|max_length[200]');
      $this->form_validation->set_rules('phone', "Phone", 'required|max_length[200]');
      $this->form_validation->set_rules('number_of_guest', "Number of Guest", 'required|max_length[200]');
      $this->form_validation->set_rules('reservation_date', "Reservation Date", 'required|max_length[200]');
      $this->form_validation->set_rules('reservation_type', "Reservation Type", 'required|max_length[200]');
      $this->form_validation->set_rules('special_request',"Special Request", 'max_length[250]');
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        $data = array();
        $data['company_id'] =1;
        $data['outlet_id'] =$jsonData['outlet_id'];
        $data['name'] =$jsonData['name'];
        $data['phone'] =$jsonData['phone'];
        $data['email'] =$jsonData['email'];
        $data['number_of_guest'] =$jsonData['number_of_guest'];
        $data['reservation_date'] =$jsonData['reservation_date'];
        $data['reservation_type'] =$jsonData['reservation_type'];
        $data['special_request'] =$jsonData['special_request'];
        $this->Common_model->insertInformation($data, "tbl_reservations");
        
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

   public function sales_post()
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
    
    $this->form_validation->set_rules('outlet_id', lang('outlet'), 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 

        
        $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
       
        $this->db->select("tbl_sales.*,tbl_users.full_name,tbl_customers.name as customer_name,tbl_payment_methods.name,tbl_customers.phone as customer_phone");
        $this->db->from('tbl_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_sales.user_id', 'left');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sales.payment_method_id', 'left');
        $this->db->where("tbl_sales.outlet_id", $outlet_id);
        $this->db->where("tbl_sales.order_status", '3');
        $this->db->where("tbl_sales.del_status", "Live");
        $this->db->order_by('tbl_sales.id', 'DESC');
        $data = $this->db->get()->result();
         
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


   public function getAllKitchenItemsAuto($sales_id){
    $this->db->select("tbl_kitchen_sales_details.id,tbl_kitchen_sales_details.menu_name,tbl_kitchen_sales_details.qty,tbl_kitchen_sales_details.tmp_qty,tbl_kitchen_sales_details.menu_combo_items,tbl_kitchen_sales_details.menu_note,tbl_kitchen_sales_details.id as sales_details_id,tbl_kitchen_sales_details.is_print");
    $this->db->from('tbl_kitchen_sales_details');
    $this->db->where("sales_id", $sales_id);
    $this->db->order_by('id', 'ASC');
    $data =  $this->db->get()->result();
    return $data;
}
public function getModifiers($sales_details_id){
  $this->db->select("tbl_modifiers.name as modifier_name,tbl_kitchen_sales_details_modifiers.*");
  $this->db->from('tbl_kitchen_sales_details_modifiers');
  $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_kitchen_sales_details_modifiers.modifier_id', 'left');
  $this->db->where("sales_details_id", $sales_details_id);
  $this->db->order_by('id', 'ASC');
  $data =  $this->db->get()->result();
  return $data;
}
   public function running_orders_post()
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
    
    $this->form_validation->set_rules('outlet_id', lang('outlet'), 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 

        
        $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
       
        $this->db->select("tbl_kitchen_sales.*,tbl_users.full_name,tbl_customers.name as customer_name,tbl_payment_methods.name,tbl_customers.phone as customer_phone");
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.user_id', 'left');
        $this->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_kitchen_sales.payment_method_id', 'left');
        $this->db->where("tbl_kitchen_sales.outlet_id", $outlet_id);
        $this->db->where("tbl_kitchen_sales.order_status", '1');
        $this->db->where("tbl_kitchen_sales.is_accept", 1);
        $this->db->where("tbl_kitchen_sales.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales.id', 'DESC');
        $data = $this->db->get()->result();
        if($data){
          foreach($data as $key=>$value){
            $items = $this->getAllKitchenItemsAuto($value->id);
            $data[$key]->items = $items;
            foreach($items as $k1=>$value1){
              $items[$k1]->modifiers = $this->getModifiers($value1->id);
            }
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
  
   public function refund_post()
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
    
    $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $sale_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:'';
        $data =  $this->Common_model->getRowByCustomId($sale_id,'id','tbl_sales');
        $data->food_menus = $this->Common_model->getAllByCustomId($sale_id,"sales_id","tbl_sales_details",$order='');

         
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
   public function remove_notication_post()
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
    
    $this->form_validation->set_rules('notification_id', "Notification ID", 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
         
        $notification_id = $jsonData['notification_id'];
        $this->db->delete('tbl_notifications', array('id' => $notification_id));
      
        $status = "success";
        $message = lang('delete_success');
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

   public function remove_multiple_notification_post()
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
    
    $this->form_validation->set_rules('notification_id', "Notification ID", 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $notifications = $jsonData['notification_id'];
        $notifications_array = explode(",",$notifications);
        foreach($notifications_array as $single_notification){
            $this->db->delete('tbl_notifications', array('id' => $single_notification));
        }


        $status = "success";
        $message = lang('delete_success');
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

   public function store_refund_post()
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
    
    $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
    $this->form_validation->set_rules('total_refund', lang('total_refund'), 'required|max_length[50]');  
    $this->form_validation->set_rules('payment_id', lang('payment_method'), 'required|max_length[50]');  
    
    $message = '';
    $data = array();
    if ($this->form_validation->run() == TRUE) { 
        $sale_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:'';
        $purchase_info['refund_date_time'] = date('Y-m-d');
        $purchase_info['total_refund'] = $jsonData['total_refund'];
        $purchase_info['refund_payment_id'] = $jsonData['payment_id'];
        $this->Common_model->updateInformation($purchase_info, $sale_id, "tbl_sales");
        
        $main_arry = array();
          $tmp_txt ="<br><b>Items:</b><br>";

          $food_menus = json_decode(str_replace("'", '"', $jsonData['food_menus']), true);
        if(!empty($food_menus)){
          
          foreach($food_menus as $key=>$value){
            $fmi = array();
            $fmi['qty'] = $value['quantity'];
            $fmi['item_id'] = $value['food_menu_id'];
            $fmi['name'] = $value['name'];
            $fmi['price'] = $value['price'];
            $fmi['vat'] = $value['tax'];
            $fmi['discount'] = $value['discount'];
            $fmi['refund_qty'] = $value['refund_qty'];
            $main_arry[] = $fmi;
            $price = $value['price'];
            $qty = $value['quantity'];
            $tmp_txt.=$value['name']."("."$qty X $price".")";

            if($key < (sizeof($food_menus) -1)){
                $tmp_txt.=", ";
            }
          }
      }

      
        $sale['refund_content'] = json_encode($main_arry);
        $this->Common_model->updateInformation($sale, $sale_id, "tbl_sales");

        $txt = '';
        $sale = $this->Common_model->getDataById($sale_id, "tbl_sales");
        $customer_info = getCustomerData($sale->customer_id);
        $company = getMainCompany();
        $txt.="Sale No: ".$sale->sale_no.", ";
        $txt.="Sale Date: ".date($company->date_format, strtotime($sale->sale_date)).", ";
        $txt.="Refund Date: ".date($company->date_format, strtotime($sale->refund_date_time)).", ";
        $txt.="Customer: ".(isset($customer_info) && $customer_info->name?$customer_info->name:'---')." - ".(isset($customer_info) && $customer_info->phone?$customer_info->phone:'').", ";
        $txt.="Total Payable: ".$sale->total_payable.", ";
        $txt.="Total Refund: ".$sale->total_refund;
        $txt.=$tmp_txt;
        putAuditLog(1,$txt,"Refund Sale",date('Y-m-d H:i:s'));


         
        $status = "success";
        $message = lang('update_success');
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

   public function add_customer_pos_post()
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
   public function edit_customer_pos_post()
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

   public function store_edit_customer_pos_post()
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

}
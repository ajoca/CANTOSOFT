<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Cart extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Authentication_model');
               $this->load->library('form_validation');
               $this->load->model('Common_model');
               $this->load->model('Sale_model');
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
     
     public function add_cart_product_post()
   {
      $jsonData = json_decode(file_get_contents('php://input'), true);
  //$headers = get_all_headers();;
//   if($headers['checksum'] != generateHashCode(json_encode($jsonData))){
//      $this->response(array(
//             'status'=> 'error',
//             'message'=> "Unauthorized access"
//           ),$this->config->item("http_response_unauthorized")
//         );
//   }
      $this->form_validation->set_data($jsonData);
   
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]'); 
      $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');
     
 
      $message = '';
      $data = '';
      $sub_total = 0; 
      $total_discount = 0;
      $total_tax = 0;
      $tips = 0;
      $charge = 0;
      $grand_total = 0;

      if ($this->form_validation->run() == TRUE) {
            $outlet_id = $jsonData['outlet_id'];
            $company_id = $jsonData['company_id'];
            $user_id = $jsonData['user_id'];

            unset($jsonData['outlet_id']);
            unset($jsonData['company_id']);
            unset($jsonData['user_id']);
            $json = json_encode($jsonData);

            $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
            if($get_cart_product){
                  
                  $newItemJson = $json;
                  $existingCartJson = json_decode($get_cart_product->json_content);
                  $mergedCart = mergeCartItem($newItemJson, $existingCartJson);
                  $this->db->where('id', $get_cart_product->id);
                  $this->db->update('tbl_carts', array('json_content' => json_encode($mergedCart))); 
            }else{

                  $newItemJson = $json;
                  $existingCartJson = '';
                  $mergedCart = mergeCartItem($newItemJson, $existingCartJson);
                  $this->db->insert('tbl_carts', array('outlet_id' => $outlet_id, 'company_id' => $company_id, 'user_id' => $user_id, 'json_content' => json_encode($mergedCart)));
            }
            
        $status = "success";
        $message = lang('insertion_success');
        $responce = "http_response_ok";
              
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }
       $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
       $data = [];
       if($get_cart_product){
            $data = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
            // Calculate sub total including modifier amounts
            foreach ($data as $item) {
              $food_details = getFoodMenuDetails($item['food_menu_id']);
                $tax_info = json_decode($food_details->tax_information, true);
                foreach ($tax_info as $tax) { 
                  $total_tax += (((float)$item['sale_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                }
                if($item['discount_type'] == 2){
                  $total_discount += ((float)$item['sale_price']*(float)$item['quantity']) * (float)$item['discount'] / 100;
                }else{
                  $total_discount += (float)$item['discount'];
                }
                $sub_total += (float)$item['sale_price']*(float)$item['quantity'];
                foreach ($item['modifiers'] as $modifier) {
                    $sub_total += ((float)$modifier['modifier_price']*(float)$item['quantity']);
                    $modifier_details = getModifierDetails($modifier['modifier_id']);
                    $tax_info = json_decode($modifier_details->tax_information, true);
                    foreach ($tax_info as $tax) { 
                      $total_tax += (((float)$modifier['modifier_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                    }
                }
            }
       }
       $grand_total = $sub_total - $total_discount + $total_tax + $tips + $charge;

       $this->response(array(
               'data' => $data,
                'status'=> $status,
                'message'=> $message,
                'sub_total' => $sub_total,
                'total_discount' => $total_discount,
                'tax' => $total_tax,
                'tips' => $tips,
                'charge' => $charge,
                'grand_total' => $grand_total,
               ),$this->config->item($responce)
             );
   }

   public function remove_cart_product_post()
   {
      $jsonData = json_decode(file_get_contents('php://input'), true);
      $this->form_validation->set_data($jsonData);
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]');
      $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');
      $this->form_validation->set_rules('unique_id', "Unique ID", 'required|max_length[50]');
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]'); 

      $message = '';
      $data = '';
      $sub_total = 0; 
      $total_discount = 0;
      $total_tax = 0;
      $tips = 0;
      $charge = 0;
      $grand_total = 0;

      if ($this->form_validation->run() == TRUE) {
            $outlet_id = $jsonData['outlet_id'];
            $company_id = $jsonData['company_id'];
            $user_id = $jsonData['user_id'];

            $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
            if($get_cart_product){  
                  $existingCartArray = json_decode(json_decode($get_cart_product->json_content, true));
                  foreach($existingCartArray as $key => $item){ 
                        if($item->unique_id == $jsonData['unique_id']){
                              unset($existingCartArray[$key]);
                        }
                  }
                  $flatArray = array_values($existingCartArray);
  
                  $this->db->where('id', $get_cart_product->id);
                  $this->db->update('tbl_carts', array('json_content' => json_encode(json_encode($flatArray, JSON_PRETTY_PRINT)))); 

                  $status = "success";
                  $message = "Cart product removed successfully";
                  $responce = "http_response_ok";
            }else{
              $status = "error";
              $message = "Cart product not found";
              $responce = "http_response_invalid";
            }
           
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
      }

      $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
      $data = [];
      if($get_cart_product){
           $data = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
               // Calculate sub total including modifier amounts
            foreach ($data as $item) {
              $food_details = getFoodMenuDetails($item['food_menu_id']);
                $tax_info = json_decode($food_details->tax_information, true);
                foreach ($tax_info as $tax) { 
                  $total_tax += (((float)$item['sale_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                }
                if($item['discount_type'] == 2){
                  $total_discount += ((float)$item['sale_price']*(float)$item['quantity']) * (float)$item['discount'] / 100;
                }else{
                  $total_discount += (float)$item['discount'];
                }
                $sub_total += (float)$item['sale_price']*(float)$item['quantity'];
                foreach ($item['modifiers'] as $modifier) {
                    $sub_total += ((float)$modifier['modifier_price']*(float)$item['quantity']);
                    $modifier_details = getModifierDetails($modifier['modifier_id']);
                    $tax_info = json_decode($modifier_details->tax_information, true);
                    foreach ($tax_info as $tax) { 
                      $total_tax += (((float)$modifier['modifier_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                    }
                }
            }            
      }
      $grand_total = $sub_total - $total_discount + $total_tax + $tips + $charge;

      $this->response(array(
            'data' => $data,
            'status'=> $status,
            'message'=> $message,
            'sub_total' => $sub_total,
            'total_discount' => $total_discount,
            'tax' => $total_tax,
            'tips' => $tips,
            'charge' => $charge,
            'grand_total' => $grand_total,
            ),$this->config->item($responce)
          );
   }
   public function cart_details_post()
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
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]');
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');
      
      $message = '';
      $data = '';
      $sub_total = 0; 
      $total_discount = 0;
      $total_tax = 0;
      $tips = 0;
      $charge = 0;
      $grand_total = 0;

      if ($this->form_validation->run() == TRUE) { 
          $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $outlet_id = $jsonData['outlet_id'];
          $user_id = $jsonData['user_id'];
          $data = [];   
          $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
          if($get_cart_product){
            $data = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
            
              // Calculate sub total including modifier amounts
              foreach ($data as $item) {
                $food_details = getFoodMenuDetails($item['food_menu_id']);
                  $tax_info = json_decode($food_details->tax_information, true);
                  foreach ($tax_info as $tax) { 
                    $total_tax += (((float)$item['sale_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                  }
                  if($item['discount_type'] == 2){
                    $total_discount += ((float)$item['sale_price']*(float)$item['quantity']) * (float)$item['discount'] / 100;
                  }else{
                    $total_discount += (float)$item['discount'];
                  }
                  $sub_total += (float)$item['sale_price']*(float)$item['quantity'];
                  foreach ($item['modifiers'] as $modifier) {
                      $sub_total += ((float)$modifier['modifier_price']*(float)$item['quantity']);
                      $modifier_details = getModifierDetails($modifier['modifier_id']);
                      $tax_info = json_decode($modifier_details->tax_information, true);
                      foreach ($tax_info as $tax) { 
                        $total_tax += (((float)$modifier['modifier_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                      }
                  }
              }

            
            $status = "success";
            $message = '';
            $responce = "http_response_ok";
          }else{
            $status = "error";
            $message = "Cart product not found";
            $responce = "http_response_ok";
          }
        
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_ok";
      }
       
    
      $grand_total = $sub_total - $total_discount + $total_tax + $tips + $charge;

      $this->response(array(
        'data' => $data,
        'status'=> $status,   
        'message'=> $message,
        'sub_total' => $sub_total,
        'total_discount' => $total_discount,
        'tax' => $total_tax,
        'tips' => $tips,
        'charge' => $charge,
        'grand_total' => $grand_total,
      ), $this->config->item($responce));
       
     }

     public function cart_clear_post()
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
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]');
      $this->form_validation->set_rules('user_id', "User ID", 'required|max_length[50]');
      
      $message = '';
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
          $outlet_id = $jsonData['outlet_id'];
          $user_id = $jsonData['user_id'];
          $data = [];   
          $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
          if($get_cart_product){

            $this->db->delete('tbl_carts', array('id' => $get_cart_product->id));

            
            $status = "success";
            $message = '';
            $responce = "http_response_ok";
          }else{
            $status = "error";
            $message = "Cart product not found";
            $responce = "http_response_ok";
          }
        
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_ok";
      }
       
      $this->response(array(
        'data' => $data,
        'status'=> $status,   
        'message'=> $message,
      ), $this->config->item($responce));
       
     }
     
     public function place_order_post()
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
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]'); 
      $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');
      $this->form_validation->set_rules('customer_id', "Customer ID", 'required|max_length[50]');

      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
        $user_id = $jsonData['user_id'];
        $outlet_id = $jsonData['outlet_id'];
        $company_id = $jsonData['company_id'];
        $customer_id = $jsonData['customer_id'];
        $waiter_id = $jsonData['waiter_id'];
        $partner_id = $jsonData['partner_id'];
        $sale_date = $jsonData['sale_date'];
        $order_table_no = $jsonData['order_table_no'];
        $tips = $jsonData['tips'];
        $charge = $jsonData['charge'];
        $charge_type = $jsonData['charge_type'];
   

        $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
        if($get_cart_product){
          
          $customer_details = getCustomerData($customer_id);
          $sale_no = generateSaleNo($outlet_id);

          $order_details = array();
          $order_details['customer_id'] =   $customer_id; 
          $order_details['sale_no'] = $sale_no; 
          $order_details['order_receiving_id'] = getOnlineSelfOrderReceivingId($outlet_id);
          $order_details['order_receiving_id_admin'] = getOrderReceivingIdAdminAPI($company_id);
          $order_details['self_order_content'] = '';

          $order_details['del_address'] = trim_checker($customer_details->address)!="undefined"?trim_checker($customer_details->address):"";
          $order_details['delivery_partner_id'] = $partner_id;
          $order_details['rounding_amount_hidden'] = 0;
          $order_details['previous_due_tmp'] = 0;
          $order_details['total_items'] = 0;
          $order_details['sub_total'] = 0;
          $order_details['charge_type'] = $charge_type;
          $order_details['vat'] = 0;
          $order_details['total_payable'] = 0;
          $order_details['total_item_discount_amount'] = 0;
          $order_details['sub_total_with_discount'] = 0;
          $order_details['sub_total_discount_amount'] = 0;
          $order_details['total_discount_amount'] = 0;
          $order_details['delivery_charge'] = $charge;
          $order_details['delivery_charge_actual_charge'] = 0;
          $order_details['tips_amount'] = $tips;
          $order_details['tips_amount_actual_charge'] = 0;
          $order_details['sub_total_discount_value'] = 0;
          $order_details['sub_total_discount_type'] = 0; 
          $order_details['waiter_id'] = $waiter_id;
          $order_details['outlet_id'] = $outlet_id;
          $order_details['company_id'] = $company_id;
          $order_details['sale_date'] = $sale_date;
          $order_details['date_time'] = date('Y-m-d H:i:s');
          $order_details['order_time'] = date("H:i:s");
          $order_details['order_status'] = 1;
          $order_details['user_id'] = $user_id; 
          $order_details['sale_no'] = $sale_no; 
          //ekhane table id o niye kaj korte hobe
          $order_details['orders_table_text'] = $order_table_no; 
          $order_details['random_code'] = generateRandomCode(); 
          $today_ = date('Y-m-d');
          //zatca value need to be added 
          
          if($today_<$sale_date){
          //1 is runny sale, 2 is future sales, 3 is future status null
          $order_details['future_sale_status'] = 2;
          }
          $order_details['is_pickup_sale'] = 1;

          $this->db->insert('tbl_kitchen_sales', $order_details);
          $sale_id = $this->db->insert_id();    


          $order_details_json = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
          // Calculate sub total including modifier amounts
          foreach ($order_details_json as $item) {
            $food_details = getFoodMenuDetails($item['food_menu_id']);

            $item_data = array();
            $item_data['food_menu_id'] = $item['food_menu_id'];
            $item_data['menu_name'] = $item['product_name'];
            //ekhane free checking ase
            $item_data['is_free_item'] = 0;

            $item_data['qty'] = $item['quantity'];
            $item_data['tmp_qty'] = 0;
            $item_data['menu_price_without_discount'] = $item['sale_price'];
            $item_data['menu_price_with_discount'] = $item['sale_price'];
            $item_data['menu_unit_price'] = $item['sale_price'];
            $item_data['menu_taxes'] = $food_details->tax_information;
            $item_data['menu_discount_value'] = $item['discount'];
            $item_data['discount_type'] = ($item['discount_type'] == 1) ? 'plain' : 'percentage';
            $item_data['menu_note'] = $item['note'];
            //ekhane combo item detials rakhte hobe
            $item_data['menu_combo_items'] = '';
            $item_data['discount_amount'] = $item['discount'];
            $item_data['item_type'] = "Kitchen Item";
            $item_data['cooking_start_time'] = '0000-00-00 00:00:00';
            $item_data['cooking_done_time'] = '0000-00-00 00:00:00';
            $item_data['previous_id'] = 0;
            $item_data['sales_id'] = $sale_id;
            $item_data['user_id'] = $user_id;
            $item_data['outlet_id'] = $outlet_id;
            if($customer_id!=1){
                $item_data['loyalty_point_earn'] = ($item_data['qty'] * getLoyaltyPointByFoodMenuAPI($item_data['food_menu_id'],''));
            }
            $item_data['del_status'] = 'Live';
            $item_data['cooking_status'] = 'New';
            //ekhane cooking upate er jonno kisu kaj korte hobe
            $this->db->insert('tbl_kitchen_sales_details', $item_data);
            $sales_details_id = $this->db->insert_id();


            foreach ($item['modifiers'] as $modifier) {
              $modifier_details = getModifierDetails($modifier['modifier_id']);
              
              $modifier_data = array();
              $modifier_data['modifier_id'] =$modifier['modifier_id'];
              $modifier_data['modifier_price'] = $modifier['modifier_price'];
              $modifier_data['food_menu_id'] = $item['food_menu_id'];
              $modifier_data['sales_id'] = $sale_id;
              $modifier_data['sales_details_id'] = $sales_details_id;
              $modifier_data['menu_taxes'] = $modifier_details->tax_information;
              $modifier_data['user_id'] = $user_id;
              $modifier_data['outlet_id'] = $outlet_id; 
              //update hole ekhane ekta kaj korte hobe
              $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
          }



          } 

          
          $sub_total = 0; 
          $total_discount = 0;
          $total_tax = 0;
          $tips = 0;
          $charge = 0;
          $grand_total = 0; 
          $total_items = 0; 
          $order_type = 1; 

          $data = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
               // Calculate sub total including modifier amounts
            foreach ($data as $item) {
              $total_items++;
              $order_type = $item['order_type'];
              $food_details = getFoodMenuDetails($item['food_menu_id']);
                $tax_info = json_decode($food_details->tax_information, true);
                foreach ($tax_info as $tax) { 
                  $total_tax += (((float)$item['sale_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                }
                if($item['discount_type'] == 2){
                  $total_discount += ((float)$item['sale_price']*(float)$item['quantity']) * (float)$item['discount'] / 100;
                }else{
                  $total_discount += (float)$item['discount'];
                }
                $sub_total += (float)$item['sale_price']*(float)$item['quantity'];
                foreach ($item['modifiers'] as $modifier) {
                    $sub_total += ((float)$modifier['modifier_price']*(float)$item['quantity']);
                    $modifier_details = getModifierDetails($modifier['modifier_id']);
                    $tax_info = json_decode($modifier_details->tax_information, true);
                    foreach ($tax_info as $tax) { 
                      $total_tax += (((float)$modifier['modifier_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                    }
                }
            }

            $discount_in_subtotal = $jsonData['discount'];
            $delivery_charge_actual_charge = getTotalPercentageAmount($sub_total, $charge);
            $tips_amount_actual_charge = getTotalPercentageAmount($sub_total, $tips);
            $total_discount_amount = getTotalPercentageAmount($sub_total, $discount_in_subtotal);

            $grand_total = $sub_total - $total_discount - $total_discount_amount + $total_tax + $tips_amount_actual_charge + $delivery_charge_actual_charge;

          
          $order_details_update['order_type'] = $order_type;
          $order_details_update['total_items'] = $total_items;
          $order_details_update['sub_total'] = $sub_total; 
          $order_details_update['vat'] = $total_tax;
          $order_details_update['total_payable'] = $grand_total; 
          $order_details_update['sub_total_with_discount'] = $sub_total;
          $order_details_update['sub_total_discount_amount'] = 0;
          $order_details_update['total_discount_amount'] = $total_discount + $total_discount_amount; 
          $order_details_update['sub_total_discount_value'] = $total_discount_amount; 

          $this->db->where('id', $sale_id);
          $this->db->update('tbl_kitchen_sales', $order_details_update);
          
          $this->db->delete('tbl_carts', array('id' => $get_cart_product->id));


          $status = "success";
          $message = lang('insertion_success');
          $responce = "http_response_ok";
       }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
       }

    }else{
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

    public function place_hold_order_post()
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
      $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]'); 
      $this->form_validation->set_rules('company_id', "Company ID", 'required|max_length[50]');
      $this->form_validation->set_rules('customer_id', "Customer ID", 'required|max_length[50]');

      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
        $user_id = $jsonData['user_id'];
        $outlet_id = $jsonData['outlet_id'];
        $company_id = $jsonData['company_id'];
        $customer_id = $jsonData['customer_id'];
        $waiter_id = $jsonData['waiter_id'];
        $partner_id = $jsonData['partner_id'];
        $sale_date = $jsonData['sale_date'];
        $order_table_no = $jsonData['order_table_no']; 
        $tips = $jsonData['tips'];
        $charge = $jsonData['charge'];
        $charge_type = $jsonData['charge_type']; 

        $get_cart_product = $this->Api_model->getCartProduct($outlet_id, $company_id,$user_id);
        if($get_cart_product){
          
          $customer_details = getCustomerData($customer_id);
          $sale_no = generateHoldSaleNo($outlet_id);

          $order_details = array();
          $order_details['customer_id'] =   $customer_id; 
          $order_details['sale_no'] = $sale_no; 
          $order_details['order_receiving_id'] = getOnlineSelfOrderReceivingId($outlet_id);
          $order_details['order_receiving_id_admin'] = getOrderReceivingIdAdminAPI($company_id);
          $order_details['self_order_content'] = '';

          $order_details['del_address'] = trim_checker($customer_details->address)!="undefined"?trim_checker($customer_details->address):"";
          $order_details['delivery_partner_id'] = $partner_id;
          $order_details['rounding_amount_hidden'] = 0;
          $order_details['previous_due_tmp'] = 0;
          $order_details['total_items'] = 0;
          $order_details['sub_total'] = 0;
          $order_details['charge_type'] = $charge_type;
          $order_details['vat'] = 0;
          $order_details['total_payable'] = 0;
          $order_details['total_item_discount_amount'] = 0;
          $order_details['sub_total_with_discount'] = 0;
          $order_details['sub_total_discount_amount'] = 0;
          $order_details['total_discount_amount'] = 0;
          $order_details['delivery_charge'] = $charge;
          $order_details['delivery_charge_actual_charge'] = 0;
          $order_details['tips_amount'] = $tips;
          $order_details['tips_amount_actual_charge'] = 0;
          $order_details['sub_total_discount_value'] = 0;
          $order_details['sub_total_discount_type'] = 0; 
          $order_details['waiter_id'] = $waiter_id;
          $order_details['outlet_id'] = $outlet_id;
          $order_details['company_id'] = $company_id;
          $order_details['sale_date'] = $sale_date;
          $order_details['date_time'] = date('Y-m-d H:i:s');
          $order_details['order_time'] = date("H:i:s");
          $order_details['order_status'] = 1;
          $order_details['user_id'] = $user_id; 
          $order_details['sale_no'] = $sale_no; 
          //ekhane table id o niye kaj korte hobe
          $order_details['orders_table_text'] = $order_table_no; 
          $order_details['random_code'] = generateRandomCode(); 
          $today_ = date('Y-m-d');
          //zatca value need to be added 
          
          if($today_<$sale_date){
          //1 is runny sale, 2 is future sales, 3 is future status null
          $order_details['future_sale_status'] = 2;
          }
          $order_details['is_pickup_sale'] = 1;

          $this->db->insert('tbl_holds', $order_details);
          $sale_id = $this->db->insert_id();    


          $order_details_json = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
          // Calculate sub total including modifier amounts
          foreach ($order_details_json as $item) {
            $food_details = getFoodMenuDetails($item['food_menu_id']);

            $item_data = array();
            $item_data['food_menu_id'] = $item['food_menu_id'];
            $item_data['menu_name'] = $item['product_name'];
            //ekhane free checking ase
            $item_data['is_free_item'] = 0;

            $item_data['qty'] = $item['quantity'];
            $item_data['tmp_qty'] = 0;
            $item_data['menu_price_without_discount'] = $item['sale_price'];
            $item_data['menu_price_with_discount'] = $item['sale_price'];
            $item_data['menu_unit_price'] = $item['sale_price'];
            $item_data['menu_taxes'] = $food_details->tax_information;
            $item_data['menu_discount_value'] = $item['discount'];
            $item_data['discount_type'] = ($item['discount_type'] == 1) ? 'plain' : 'percentage';
            $item_data['menu_note'] = $item['note'];
            //ekhane combo item detials rakhte hobe
            $item_data['menu_combo_items'] = '';
            $item_data['discount_amount'] = $item['discount'];
            $item_data['item_type'] = "Kitchen Item";
            $item_data['cooking_start_time'] = '0000-00-00 00:00:00';
            $item_data['cooking_done_time'] = '0000-00-00 00:00:00';
            $item_data['previous_id'] = 0;
            $item_data['sales_id'] = $sale_id;
            $item_data['user_id'] = $user_id;
            $item_data['outlet_id'] = $outlet_id;
            if($customer_id!=1){
                $item_data['loyalty_point_earn'] = ($item_data['qty'] * getLoyaltyPointByFoodMenuAPI($item_data['food_menu_id'],''));
            }
            $item_data['del_status'] = 'Live';
            $item_data['cooking_status'] = 'New';
            //ekhane cooking upate er jonno kisu kaj korte hobe
            $this->db->insert('tbl_holds_details', $item_data);
            $sales_details_id = $this->db->insert_id();


            foreach ($item['modifiers'] as $modifier) {
              $modifier_details = getModifierDetails($modifier['modifier_id']);
              
              $modifier_data = array();
              $modifier_data['modifier_id'] =$modifier['modifier_id'];
              $modifier_data['modifier_price'] = $modifier['modifier_price'];
              $modifier_data['food_menu_id'] = $item['food_menu_id'];
              $modifier_data['sales_id'] = $sale_id;
              $modifier_data['sales_details_id'] = $sales_details_id;
              $modifier_data['menu_taxes'] = $modifier_details->tax_information;
              $modifier_data['user_id'] = $user_id;
              $modifier_data['outlet_id'] = $outlet_id; 
              //update hole ekhane ekta kaj korte hobe
              $this->db->insert('tbl_holds_details_modifiers', $modifier_data);
          }



          } 

          
          $sub_total = 0; 
          $total_discount = 0;
          $total_tax = 0;
          $tips = 0;
          $charge = 0;
          $grand_total = 0; 
          $total_items = 0; 
          $order_type = 1; 

          $data = getCartResponse(json_decode(json_decode($get_cart_product->json_content,true)));
               // Calculate sub total including modifier amounts
            foreach ($data as $item) {
              $total_items++;
              $order_type = $item['order_type'];
              $food_details = getFoodMenuDetails($item['food_menu_id']);
                $tax_info = json_decode($food_details->tax_information, true);
                foreach ($tax_info as $tax) { 
                  $total_tax += (((float)$item['sale_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                }
                if($item['discount_type'] == 2){
                  $total_discount += ((float)$item['sale_price']*(float)$item['quantity']) * (float)$item['discount'] / 100;
                }else{
                  $total_discount += (float)$item['discount'];
                }
                $sub_total += (float)$item['sale_price']*(float)$item['quantity'];
                foreach ($item['modifiers'] as $modifier) {
                    $sub_total += ((float)$modifier['modifier_price']*(float)$item['quantity']);
                    $modifier_details = getModifierDetails($modifier['modifier_id']);
                    $tax_info = json_decode($modifier_details->tax_information, true);
                    foreach ($tax_info as $tax) { 
                      $total_tax += (((float)$modifier['modifier_price']*(float)$item['quantity']) * (float)$tax['tax_field_percentage']) / 100;
                    }
                }
            }
            $discount_in_subtotal = $jsonData['discount'];
            $delivery_charge_actual_charge = getTotalPercentageAmount($sub_total, $charge);
            $tips_amount_actual_charge = getTotalPercentageAmount($sub_total, $tips);
            $total_discount_amount = getTotalPercentageAmount($sub_total, $discount_in_subtotal);

            $grand_total = $sub_total - $total_discount - $total_discount_amount + $total_tax + $tips_amount_actual_charge + $delivery_charge_actual_charge;

          
          $order_details_update['order_type'] = $order_type;
          $order_details_update['total_items'] = $total_items;
          $order_details_update['sub_total'] = $sub_total; 
          $order_details_update['vat'] = $total_tax;
          $order_details_update['total_payable'] = $grand_total; 
          $order_details_update['sub_total_with_discount'] = $sub_total;
          $order_details_update['sub_total_discount_amount'] = 0;
          $order_details_update['total_discount_amount'] = $total_discount + $total_discount_amount; 
          $order_details_update['sub_total_discount_value'] = $total_discount_amount; 

          $this->db->where('id', $sale_id);
          $this->db->update('tbl_holds', $order_details_update);


          $this->db->delete('tbl_carts', array('id' => $get_cart_product->id));
          $status = "success";
          $message = lang('insertion_success');
          $responce = "http_response_ok";
       }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
       }

    }else{
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
   
   $this->form_validation->set_rules('outlet_id', "Outlet", 'required|max_length[50]');  
   
   $message = '';
   $all_data_main = array();
   if ($this->form_validation->run() == TRUE) { 
       $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
       $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
       
       $all_data = $this->Api_model->online_order_sales_adminAPI($outlet_id,$user_id);
       foreach($all_data as $key=>$data){
        $items = $this->Api_model->getFoodMenuDetailsBySaleId($data->id); 
        $all_data[$key]->data = $items;
        foreach($all_data[$key]->data as $item){
          $modifiers = $this->Api_model->getModifiersBySaleId($data->id);
          $item->modifiers = $modifiers;
        }
       
        
      }
      $all_data_main = $all_data;
       $status = "success";
       $message = '';
       $responce = "http_response_ok";

   }else{
     $status = "error";
     $message = $this->form_validation->error_array();
     $responce = "http_response_invalid";
   }
    
    
     $this->response(array(
       'data' => $all_data_main,
       'status'=> $status,
       'message'=> $message,
       ),$this->config->item($responce)
     );

 }
 
 public function get_draft_orders_post()
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
  $all_data_main = array();
  if ($this->form_validation->run() == TRUE) { 
      $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
      $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
      
      $all_data = $this->Api_model->getDraftOrders($outlet_id,$user_id);
      foreach($all_data as $key=>$data){
       $items = $this->Api_model->getDraftSaleFoods($data->id); 
       $all_data[$key]->data = $items;
       foreach($all_data[$key]->data as $item){
         $modifiers = $this->Api_model->getDraftModifiersBySaleId($data->id);
         $item->modifiers = $modifiers;
       }
      
       
     }
     $all_data_main = $all_data;
      $status = "success";
      $message = '';
      $responce = "http_response_ok";

  }else{
    $status = "error";
    $message = $this->form_validation->error_array();
    $responce = "http_response_invalid";
  }
   
   
    $this->response(array(
      'data' => $all_data_main,
      'status'=> $status,
      'message'=> $message,
      ),$this->config->item($responce)
    );

}
public function delete_draft_sale_post()
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
      $data = '';
      if ($this->form_validation->run() == TRUE) { 
          $id = $jsonData['id'];
         
          $data = [];   

            $this->db->delete('tbl_holds', array('id' => $id));
            $this->db->delete('tbl_holds_details', array('sales_id' => $id));
            $this->db->delete('tbl_holds_details_modifiers', array('sales_id' => $id));

            $status = "success";
            $message = 'Draft Sale Removed Successfully';
            $responce = "http_response_ok";
        
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_ok";
      }
       
      $this->response(array(
        'data' => $data,
        'status'=> $status,   
        'message'=> $message,
      ), $this->config->item($responce));
       
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
  
  $this->form_validation->set_rules('sale_id', "Sale ID", 'required|max_length[50]');  
  
  $message = '';
  $data = array();
  if ($this->form_validation->run() == TRUE) { 
      $sale_id  = isset($jsonData['sale_id']) && $jsonData['sale_id']?$jsonData['sale_id']:'';
      
      $data = $this->Api_model->get_order_details_adminAPIBySaleId($sale_id);
      if($data){
        $items = $this->Api_model->getFoodMenuDetailsBySaleId($sale_id); 
        $data->data = $items;
        foreach($data->data as $item){
          $modifiers = $this->Api_model->getModifiersBySaleId($data->id);
          $item->modifiers = $modifiers;
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
public function get_areas_post()
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
      
      $data = $this->Api_model->getAreas($outlet_id);
      
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
  
public function get_tables_post()
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
  
  $this->form_validation->set_rules('area_id', "Area ID", 'required|max_length[50]');  
  $this->form_validation->set_rules('outlet_id', "Outlet ID", 'required|max_length[50]');  
  
  $message = '';
  $data = array();
  if ($this->form_validation->run() == TRUE) { 
      $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
      $area_id  = isset($jsonData['area_id']) && $jsonData['area_id']?$jsonData['area_id']:'';

      $data = $this->Api_model->getTables($outlet_id, $area_id);
      
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

public function generate_invoice_post()
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
      
      $this->form_validation->set_rules('order_no', "Order No", 'required|max_length[50]');  
      $this->form_validation->set_rules('paid_amount', "Paid Amount", 'required|max_length[50]');
      $this->form_validation->set_rules('due_amount', "Due Amount", 'max_length[50]');
      $this->form_validation->set_rules('given_amount', "Given Amount", 'max_length[50]');
      $this->form_validation->set_rules('change_amount', "Change Amount", 'max_length[50]');
      $this->form_validation->set_rules('is_multi_currency', "Is Multi Currency", 'max_length[50]');
      $this->form_validation->set_rules('multi_currency', "Multi Currency", 'max_length[50]');
      $this->form_validation->set_rules('multi_currency_rate', "Multi Currency Rate", 'max_length[50]');
      $this->form_validation->set_rules('multi_currency_amount', "Multi Currency Amount", 'max_length[50]');
      
      $message = '';
      $data = ''; 

      if ($this->form_validation->run() == TRUE) { 
          $order_no  = isset($jsonData['order_no']) && $jsonData['order_no']?$jsonData['order_no']:'';
          $paid_amount = $jsonData['paid_amount'];
          $due_amount = $jsonData['due_amount'];
          $given_amount = $jsonData['given_amount'];
          $change_amount = $jsonData['change_amount'];
        

          $select_kitchen_row = getKitchenSaleDetailsBySaleNo($order_no);
          if($select_kitchen_row){

            $order_details = json_decode($select_kitchen_row->self_order_content);
            $sale_no = $order_no;
            $sale_id = '';
            
            $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);
            $check_existing = getSaleDetailsBySaleNo($sale_no);
            
            if(isset($check_existing) && $check_existing){
                $sale_id = $check_existing->id; 
            }
  
            $outlet_id = $select_kitchen_row->outlet_id;
            $company_id = $select_kitchen_row->company_id;
        
          $data = array();
          $data['self_order_content'] = json_encode($select_kitchen_row->self_order_content);
  
          $data['customer_id'] = trim_checker($order_details->customer_id);
          $data['counter_id'] = trim_checker($order_details->counter_id);
          $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
          $data['total_items'] = trim_checker($order_details->total_items_in_cart);
          $data['sub_total'] = trim_checker($order_details->sub_total);
          $data['charge_type'] = trim_checker($order_details->charge_type);
          $data['previous_due_tmp'] = trim_checker($order_details->previous_due_tmp);
          $data['vat'] = trim_checker($order_details->total_vat);
          $data['total_payable'] = trim_checker($order_details->total_payable);
          $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
          $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
          $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
          $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
          $data['tips_amount'] = trim_checker($order_details->tips_amount);
          $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);
          $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
          $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
          $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
          $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
          $data['given_amount'] = trim_checker($given_amount);
          $data['change_amount'] = trim_checker($change_amount);
          $data['token_number'] = trim_checker($order_details->token_number);
          $data['random_code'] = trim_checker(isset($order_details->random_code) && $order_details->random_code?$order_details->random_code:'');
          $data['user_id'] = trim_checker($order_details->user_id);
          $data['waiter_id'] = trim_checker($order_details->waiter_id);
          $data['outlet_id'] = trim_checker($outlet_id);
          $data['company_id'] = trim_checker($company_id);
          $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
          $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
          $data['order_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
          $data['paid_date_time'] = date('Y-m-d H:i:s');
          $data['order_status'] = 3;
          $data['orders_table_text'] = ($order_details->orders_table_text); 
          $data['paid_amount'] = trim_checker($paid_amount);
          $data['due_amount'] = trim_checker($due_amount);
          $data['zatca_value'] = trim_checker($order_details->zatca_invoice_value);
          $total_tax = 0;
          if(isset($order_details->sale_vat_objects) && $order_details->sale_vat_objects){
              foreach ($order_details->sale_vat_objects as $keys=>$val){
                  $total_tax+=$val->tax_field_amount;
              }
          }
          $data['vat'] = $total_tax;
          $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
          $data['order_type'] = trim_checker($order_details->order_type);
  
          $this->db->trans_begin();
          if($sale_id>0){
              $data['modified'] = 'Yes';
              $this->db->where('id', $sale_id);
              $this->db->update('tbl_sales', $data);
  
              //end of send notification process
              $this->db->delete('tbl_sales_details', array('sales_id' => $sale_id));
              $this->db->delete('tbl_sales_details_modifiers', array('sales_id' => $sale_id));
              $this->db->delete('tbl_sale_consumptions', array('sale_id' => $sale_id));
              $this->db->delete('tbl_sale_consumptions_of_menus', array('sales_id' => $sale_id));
              $this->db->delete('tbl_sale_consumptions_of_modifiers_of_menus', array('sales_id' => $sale_id));
              $this->db->delete('tbl_sale_payments', array('sale_id' => $sale_id));
              $sales_id = $sale_id;
          }else{
              $this->db->insert('tbl_sales', $data);
              $sales_id = $this->db->insert_id();
              $sale_no_update_array = array('sale_no' => $sale_no);
              $this->db->where('id', $sales_id);
              $this->db->update('tbl_sales', $sale_no_update_array);
          }
  
          $data_sale_consumptions = array();
          $data_sale_consumptions['sale_id'] = $sales_id;
          $data_sale_consumptions['user_id'] = trim_checker($order_details->user_id);
          $data_sale_consumptions['outlet_id'] = trim_checker($outlet_id);
          $data_sale_consumptions['del_status'] = 'Live';
          $this->db->insert('tbl_sale_consumptions',$data_sale_consumptions);
          $sale_consumption_id = $this->db->insert_id();
  
          if($sales_id>0 && count($order_details->items)>0){
              foreach($order_details->items as $item){
                  $tmp_var_111 = isset($item->p_qty) && $item->p_qty && $item->p_qty!='undefined'?$item->p_qty:0;
                  $tmp = $item->qty-$tmp_var_111;
                  $tmp_var = 0;
                  if($tmp>0){
                      $tmp_var = $tmp;
                  }
  
                  $food_details =  $this->Common_model->getDataById($item->food_menu_id, "tbl_food_menus");
                  $item_data = array();
                  $item_data['food_menu_id'] = $item->food_menu_id;
                  $p_name = getParentNameOnly($food_details->parent_id);
                  $item_data['menu_name'] = isset($p_name) ? $p_name . (isset($food_details->name) && $food_details->name ? " " . $food_details->name : '') : (isset($food_details->name) && $food_details->name ? $food_details->name : '');
                  $item_data['qty'] = $item->qty;
                  $item_data['tmp_qty'] = $tmp_var;
                  $item_data['menu_price_without_discount'] = $item->menu_price_without_discount;
                  $item_data['menu_price_with_discount'] = $item->menu_price_with_discount;
                  $item_data['menu_combo_items'] = isset($item->menu_combo_items) && $item->menu_combo_items && $item->menu_combo_items!="undefined"?$item->menu_combo_items:'';
                  $item_data['is_free_item'] = $item->is_free;
                  $item_data['menu_unit_price'] = $item->menu_unit_price;
                  $item_data['menu_taxes'] = json_encode($item->item_vat);
                  $item_data['menu_discount_value'] = $item->menu_discount_value;
                  $item_data['discount_type'] = $item->discount_type;
                  $item_data['menu_note'] = isset($item->item_note) && $item->item_note?$item->item_note:'';
                  $item_data['discount_amount'] = $item->item_discount_amount;
                  $item_data['item_type'] = ($this->Sale_model->getItemType($item->food_menu_id)->item_type=="Bar No")?"Kitchen Item":"Bar Item";
                  $item_data['cooking_status'] = ($item->item_cooking_status=="")?NULL:$item->item_cooking_status;
                  
                  if(isset($select_kitchen_row->id) && $select_kitchen_row->id){
                      $kitchen_data = getKitchenItemDetails($select_kitchen_row->id,$item->food_menu_id);
                      $item_data['cooking_start_time'] = isset($kitchen_data->cooking_start_time) && $kitchen_data->cooking_start_time?$kitchen_data->cooking_start_time:'0000-00-00 00:00:00';
                      $item_data['cooking_done_time'] = isset($kitchen_data->cooking_done_time) && $kitchen_data->cooking_done_time?$kitchen_data->cooking_done_time:'0000-00-00 00:00:00';
                  }else{
                      $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                      $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                  }
                 
                  $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                  $item_data['sales_id'] = $sales_id;
                  $item_data['user_id'] = trim_checker($order_details->user_id);
                  $item_data['outlet_id'] = trim_checker($outlet_id);
                  if($order_details->customer_id!=1){
                      $item_data['loyalty_point_earn'] = ($item->qty * getLoyaltyPointByFoodMenu($item->food_menu_id,''));
                  }
  
                  $item_data['del_status'] = 'Live';
                  $this->db->insert('tbl_sales_details', $item_data);
                  $sales_details_id = $this->db->insert_id();
  
                  if($item->item_previous_id==""){
                      $previous_id_update_array = array('previous_id' => $sales_details_id);
                      $this->db->where('id', $sales_details_id);
                      $this->db->update('tbl_sales_details', $previous_id_update_array);
                  }
  
                  if(isset($food_details->product_type) && $food_details->product_type==1){
                      $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$item->food_menu_id")->result();
                      foreach($food_menu_ingredients as $single_ingredient){
                          $inline_total = $single_ingredient->cost;
                          $data_sale_consumptions_detail = array();
                          $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                          $data_sale_consumptions_detail['consumption'] = $item->qty*$single_ingredient->consumption;
                          $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                          $data_sale_consumptions_detail['sales_id'] = $sales_id;
                          $data_sale_consumptions_detail['cost'] = $inline_total;
                          $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                          $data_sale_consumptions_detail['user_id'] = trim_checker($order_details->user_id);
                          $data_sale_consumptions_detail['outlet_id'] = trim_checker($outlet_id);
                          $data_sale_consumptions_detail['del_status'] = 'Live';
                          $query = $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                      }
                  }else if(isset($food_details->product_type) && $food_details->product_type==3){
                      $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_ingredients WHERE food_id=$item->food_menu_id")->result();
                      foreach($food_menu_ingredients as $single_ingredient){
                          $inline_total = $single_ingredient->consumption_unit_cost;
                          $data_sale_consumptions_detail = array();
                          $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->id;
                          $data_sale_consumptions_detail['consumption'] = $item->qty;
                          $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                          $data_sale_consumptions_detail['sales_id'] = $sales_id;
                          $data_sale_consumptions_detail['cost'] = $inline_total;
                          $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                          $data_sale_consumptions_detail['user_id'] = trim_checker($order_details->user_id);
                          $data_sale_consumptions_detail['outlet_id'] = trim_checker($outlet_id);
                          $data_sale_consumptions_detail['del_status'] = 'Live';
                           $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                      }
                  }else{
                      $combo_food_menus = $this->db->query("SELECT * FROM tbl_combo_food_menus WHERE food_menu_id=$item->food_menu_id AND del_status='Live'")->result();
                      if(isset($combo_food_menus) && $combo_food_menus){
                          foreach ($combo_food_menus as $single_combo_fm){
                              $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_food_menus_ingredients WHERE food_menu_id=$single_combo_fm->added_food_menu_id")->result();
                              foreach($food_menu_ingredients as $single_ingredient){
                                  $inline_total = $single_ingredient->cost*($item->qty*$single_combo_fm->quantity);
                                  $data_sale_consumptions_detail = array();
                                  $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                                  $data_sale_consumptions_detail['consumption'] = ($item->qty*$single_combo_fm->quantity)*$single_ingredient->consumption;
                                  $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                                  $data_sale_consumptions_detail['sales_id'] = $sales_id;
                                  $data_sale_consumptions_detail['cost'] = $inline_total;
                                  $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                                  $data_sale_consumptions_detail['user_id'] = trim_checker($order_details->user_id);
                                  $data_sale_consumptions_detail['outlet_id'] = trim_checker($outlet_id);
                                  $data_sale_consumptions_detail['del_status'] = 'Live';
                                  $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
                              }
                          }
  
                      }
                  }
  
  
  
                  $modifier_id_array = isset($item->modifiers_id) && ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                  /*new_added_zak*/
                  $modifiers_mul_id_array = isset($item->modifiers_mul_id) && ($item->modifiers_mul_id!="")?explode(",",$item->modifiers_mul_id):null;
                  /*end_new_added_zak*/
                  $modifier_price_array = isset($item->modifiers_price) && ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                  $modifier_vat_array = (isset($item->modifier_vat) && $item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;
                  if(!empty($modifier_id_array)>0){
                      $i = 0;
                      foreach($modifier_id_array as $key1=>$single_modifier_id){
                          $modifiers_mul_id_array_value = isset($modifiers_mul_id_array[$key1]) && $modifiers_mul_id_array[$key1]?explode('_',$modifiers_mul_id_array[$key1]):'';
  
                          $modifier_data = array();
                          $modifier_data['modifier_id'] =$single_modifier_id;
                          $modifier_data['modifier_price'] = $modifier_price_array[$i];
                          $modifier_data['food_menu_id'] = $item->food_menu_id;
                          $modifier_data['sales_id'] = $sales_id;
                          $modifier_data['sales_details_id'] = $sales_details_id;
                          $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                          $modifier_data['user_id'] = trim_checker($order_details->user_id);
                          $modifier_data['outlet_id'] = trim_checker($outlet_id);
                          $modifier_data['customer_id'] =$order_details->customer_id;
                          $this->db->insert('tbl_sales_details_modifiers', $modifier_data);
  
                          $modifier_ingredients = $this->db->query("SELECT * FROM tbl_modifier_ingredients WHERE modifier_id=$single_modifier_id")->result();
  
                          foreach($modifier_ingredients as $single_ingredient){
                              $data_sale_consumptions_detail = array();
                              $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                              $data_sale_consumptions_detail['consumption'] = $item->qty*$single_ingredient->consumption;
                              $data_sale_consumptions_detail['sale_consumption_id'] = $sale_consumption_id;
                              $data_sale_consumptions_detail['sales_id'] = $sales_id;
                              $data_sale_consumptions_detail['food_menu_id'] = $item->food_menu_id;
                              $data_sale_consumptions_detail['user_id'] = trim_checker($order_details->user_id);
                              $data_sale_consumptions_detail['outlet_id'] = trim_checker($outlet_id);
                              $data_sale_consumptions_detail['del_status'] = 'Live';
                              $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus',$data_sale_consumptions_detail);
                          }
                          $i++;
                      }
                  }
              }
          }
  
  
          if(!$sale_id){
              $this->db->delete('tbl_sale_payments', array('sale_id' => $sales_id));
          }
  
  
          $payment_object = isset($jsonData['payment_object']) && $jsonData['payment_object']?$jsonData['payment_object']:'';
          $fixed_json = str_replace("'", '"', $payment_object);
          // Step 2: Decode into PHP array
          $payment_object = json_decode($fixed_json, true);
          
   
          //put payment details
          if (is_array($payment_object)) {
              $currency_type = $jsonData['is_multi_currency'];
              $multi_currency = $jsonData['multi_currency'];
              $multi_currency_rate = $jsonData['multi_currency_rate'];
              $multi_currency_amount = $jsonData['multi_currency_amount'];
  
  
              if($currency_type==1){
                  $check_existing_payment = getPaymentInfo($sales_id,1);
                  if(!$check_existing_payment){
                      $data = array();
                      $data['payment_id'] = 1;
                      $data['payment_name'] = "Cash";
                      $data['amount'] = $multi_currency_amount;
                      $data['multi_currency'] = $multi_currency;
                      $data['multi_currency_rate'] = $multi_currency_rate;
                      $data['currency_type'] = $currency_type;
                      $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
                      $data['sale_id'] = $sales_id;
                      $data['counter_id'] = trim_checker($order_details->counter_id);
                      $data['user_id'] = trim_checker($order_details->user_id);
                      $data['outlet_id'] = trim_checker($outlet_id); 
                      $this->Common_model->insertInformation($data, "tbl_sale_payments");
                  }
              }else{
                    foreach ($payment_object as $value) {
                      $check_existing_payment = getPaymentInfo($sales_id,$value['payment_id']);
                      if(!$check_existing_payment){
                          $data = array();
                          $data['payment_id'] = $value['payment_id'];
                          $data['payment_name'] = $value['payment_name'];
                          if($value['payment_id']==5){
                              $data['usage_point'] = $value['usage_point'];
                              $previous_id_update_array = array('loyalty_point_earn' => 0);
                              $this->db->where('sales_id', $sales_id);
                              $this->db->update('tbl_sales_details', $previous_id_update_array);
                          }
                          $data['amount'] = $value['amount'];
                          $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
                          $data['sale_id'] = $sales_id;
                          $data['counter_id'] = trim_checker($order_details->counter_id);
                          $data['user_id'] = trim_checker($order_details->user_id);
                          $data['outlet_id'] = trim_checker($outlet_id);
                          $this->Common_model->insertInformation($data, "tbl_sale_payments");
                      }
                    
                  }
              }
          }
  
  
          $this->db->trans_complete();
          if ($this->db->trans_status() === FALSE) {
              $this->db->trans_rollback();
          } else {
              $send_sms_status = isset($order_details->send_sms_status) && $order_details->send_sms_status?$order_details->send_sms_status:'';
              if($send_sms_status==1){
                  $customer = getCustomerData(trim_checker($order_details->customer_id));
                  $outlet_name = getOutletNameById($outlet_id);
                  $sms_content = "Hi ".$customer->name.", thank you for visiting '.$outlet_name.'. Total bill of your order on '.$order_details->date_time.' is ".getAmtCustom($order_details->total_payable).". Paid amount is: ".getAmtCustom($paid_amount).", Due Amount is: ".getAmtCustom($due_amount)."
  We hope to see you again!";
                  if($customer->phone){
                      smsSendOnly($sms_content,$customer->phone);
                  }
              }
              if($select_kitchen_row){
                // $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
                // $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
                // $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
              }
              $this->db->trans_commit();
          }  
            
            $status = "success";
            $message = 'Invoice generated successfully!';
            $responce = "http_response_ok";  
          }else{
            $status = "error";
            $message = "Order not found or aleady generated";
            $responce = "http_response_invalid";
          }
         
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
      }
       
 
      $this->response(array(
        'data' => "",
        'status'=> $status,   
        'message'=> $message, 
      ), $this->config->item($responce));
       
     }
}
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
                  $total_discount += $item['discount'];
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
                  $total_discount += $item['discount'];
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
                    $total_discount += $item['discount'];
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
            $responce = "http_response_invalid";
          }
        
  
      }else{
        $status = "error";
        $message = $this->form_validation->error_array();
        $responce = "http_response_invalid";
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
      
      $this->form_validation->set_rules('sale_no', "Sale No", 'required|max_length[50]');  
      
      $message = '';
      $data = array();
      if ($this->form_validation->run() == TRUE) { 
  
        $order_details = (Object)$jsonData;
        $sale_vat_objects = str_replace("'", '"', $order_details->sale_vat_objects);
        $items = str_replace("'", '"', $order_details->items);
        $data['customer_id'] =   getCustomerDetails($order_details->customer_name,$order_details->customer_address,$order_details->customer_phone,$order_details->customer_email);
   
        $order_details_json = $order_details;
        $order_details_json->sale_vat_objects = "xsale_vat_objectsx";;
        $order_details_json->items = "xitemsx";;
        $order_details_json->customer_id = $data['customer_id'];;
  
        $self_order_content = json_encode($order_details_json);
       
        $self_order_content = str_replace('"xsale_vat_objectsx"', $sale_vat_objects, $self_order_content);
        $self_order_content = str_replace('"xitemsx"', $items, $self_order_content);
  
        //  pre($self_order_content);exit;
   
  
  
  
  
      
        //this id will be 0 when there is new order, but will be greater then 0 when there is modification
        //on previous order
        $sale_no = $order_details->sale_no;
        $sale_d = getKitchenSaleDetailsBySaleNo($sale_no);
        $data = array();
        $data['customer_id'] =   getCustomerDetails($order_details->customer_name,$order_details->customer_address,$order_details->customer_phone,$order_details->customer_email);
   
        $data['order_receiving_id'] = getOnlineSelfOrderReceivingId($order_details->outlet_id);
        $data['order_receiving_id_admin'] = getOrderReceivingIdAdmin();
  
  
        $data['self_order_content'] = $self_order_content;
        $data['del_address'] = trim_checker($order_details->customer_address)!="undefined"?trim_checker($order_details->customer_address):"";
        $data['delivery_partner_id'] = trim_checker($order_details->delivery_partner_id);
        $data['rounding_amount_hidden'] = trim_checker($order_details->rounding_amount_hidden);
        $data['previous_due_tmp'] = trim_checker($order_details->previous_due_tmp);
        $data['total_items'] = trim_checker($order_details->total_items_in_cart);
        $data['sub_total'] = trim_checker($order_details->sub_total);
        $data['charge_type'] = trim_checker($order_details->charge_type);
        $data['vat'] = trim_checker($order_details->total_vat);
        $data['total_payable'] = trim_checker($order_details->total_payable);
        $data['total_item_discount_amount'] = trim_checker($order_details->total_item_discount_amount);
        $data['sub_total_with_discount'] = trim_checker($order_details->sub_total_with_discount);
        $data['sub_total_discount_amount'] = trim_checker($order_details->sub_total_discount_amount);
        $data['total_discount_amount'] = trim_checker($order_details->total_discount_amount);
        $data['delivery_charge'] = trim_checker($order_details->delivery_charge);
        $data['delivery_charge_actual_charge'] = trim_checker($order_details->delivery_charge_actual_charge);
        $data['tips_amount'] = trim_checker($order_details->tips_amount);
        $data['tips_amount_actual_charge'] = trim_checker($order_details->tips_amount_actual_charge);
        $data['sub_total_discount_value'] = trim_checker($order_details->sub_total_discount_value);
        $data['sub_total_discount_type'] = trim_checker($order_details->sub_total_discount_type);
        $data['orders_table_text'] = trim_checker($order_details->orders_table_text);
        $data['waiter_id'] = trim_checker($order_details->waiter_id);
        $data['outlet_id'] = $order_details->outlet_id;
        $data['company_id'] = 1;
        $data['sale_date'] = trim_checker(isset($order_details->open_invoice_date_hidden) && $order_details->open_invoice_date_hidden?$order_details->open_invoice_date_hidden:date('Y-m-d'));
        $data['date_time'] = date('Y-m-d H:i:s',strtotime($order_details->date_time));
        $data['order_time'] = date("H:i:s",strtotime($order_details->order_time));
        $data['order_status'] = trim_checker($order_details->order_status);
        $data['sale_no'] = $sale_no;
        $data['order_receiving_id_admin'] = 1;
        $today_ = date('Y-m-d');
        
        if($today_<$data['sale_date']){
        //1 is runny sale, 2 is future sales, 3 is future status null
            $data['future_sale_status'] = 2;
        }
  
        $data['is_pickup_sale'] = 1;
        $total_tax = 0;
        $sale_vat_objects = json_decode(str_replace("'", '"', $order_details->sale_vat_objects), true);
        if(!empty($sale_vat_objects)){
            foreach ($sale_vat_objects as $keys=>$val){
              $val = (Object)$val;
              $total_tax+=$val->tax_field_amount;
          }
        }
        
        $data['vat'] = $total_tax;
        $data['sale_vat_objects'] = json_encode($order_details->sale_vat_objects);
        $data['order_type'] = trim_checker($order_details->order_type);
        
        $this->db->trans_begin();
        $sale_id = isset($sale_d->id) && $sale_d->id?$sale_d->id:'';
        if($sale_id>0){
            $data['user_id'] = $sale_d->user_id;
            $data['modified'] = 'Yes';
            $data['is_update_sender'] = 1;
            $data['is_update_receiver'] = 1;
            $data['is_update_receiver_admin'] = 1;
            $this->db->where('id', $sale_id);
            $this->db->update('tbl_kitchen_sales', $data);
            checkAndRemoveAllRemovedItem($order_details->items,$sale_id);
        }else{
            $data['user_id'] = $order_details->user_id;
            $data['random_code'] = trim_checker(isset($order_details->random_code) && $order_details->random_code?$order_details->random_code:'');
            $this->db->insert('tbl_kitchen_sales', $data);
            $sale_id = $this->db->insert_id();
        }
        $items = json_decode(str_replace("'", '"', $order_details->items), true);
        
        if($sale_id>0 && !empty($items)){
            $previous_food_id = 0;
            $arr_item_id = array();
  
  
       
            foreach($items as $key_counter=>$item){
                $item = (Object)$item;
                $item_data = array();
                $tmp_var_111 = isset($item->p_qty) && $item->p_qty && $item->p_qty!='undefined'?$item->p_qty:0;
                $tmp = $item->qty-$tmp_var_111;
                $tmp_var = 0;
                if($tmp>0){
                    $tmp_var = $tmp;
                }
  
                
                $item_data['food_menu_id'] = $item->food_menu_id;
                $item_data['menu_name'] = $item->menu_name;
                if($item->is_free==1){
                    $item_data['is_free_item'] = $previous_food_id;
                }else{
                    $item_data['is_free_item'] = 0;
                }
                $item_data['qty'] = $item->qty;
                $item_data['tmp_qty'] = $tmp_var;
                $item_data['menu_price_without_discount'] = $item->menu_price_without_discount;
                $item_data['menu_price_with_discount'] = $item->menu_price_with_discount;
                $item_data['menu_unit_price'] = $item->menu_unit_price;
                $item_data['menu_taxes'] = json_encode($item->item_vat);
                $item_data['menu_discount_value'] = $item->menu_discount_value;
                $item_data['discount_type'] = $item->discount_type;
                $item_data['menu_note'] = $item->item_note;
                $item_data['menu_combo_items'] = $item->menu_combo_items;
                $item_data['discount_amount'] = $item->item_discount_amount;
                $item_data['item_type'] = "Kitchen Item";
                $item_data['cooking_start_time'] = ($item->item_cooking_start_time=="" || $item->item_cooking_start_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_start_time));
                $item_data['cooking_done_time'] = ($item->item_cooking_done_time=="" || $item->item_cooking_done_time=="0000-00-00 00:00:00")?'0000-00-00 00:00:00':date('Y-m-d H:i:s',strtotime($item->item_cooking_done_time));
                $item_data['previous_id'] = ($item->item_previous_id=="")?0:$item->item_previous_id;
                $item_data['sales_id'] = $sale_id;
                $item_data['user_id'] = $order_details->user_id;
                $item_data['outlet_id'] = $order_details->outlet_id;
                if($order_details->customer_id!=1){
                    $item_data['loyalty_point_earn'] = ($item->qty * getLoyaltyPointByFoodMenu($item->food_menu_id,''));
                }
                $item_data['del_status'] = 'Live';
              
                $sales_details_id = '';
                if($sale_id){
                    $preview_id_counter_value = isset($arr_item_id[$item->food_menu_id]) && $arr_item_id[$item->food_menu_id]?$arr_item_id[$item->food_menu_id]:0;
                    $arr_item_id[$item->food_menu_id] = $preview_id_counter_value + 1;
                    $check_exist_item = checkExistItem($sale_id,$item->food_menu_id,$preview_id_counter_value);
                    if(isset($check_exist_item) && $check_exist_item){
                        $sales_details_id = $check_exist_item->id;
                        if($item->qty!=$check_exist_item->qty){
                            $item_data['cooking_status'] = 'New';
                            $item_data['is_print'] = 1;
                            $updated_notifications = $this->Common_model->getOrderedKitchens($sale_id);
                            foreach ($updated_notifications as $k=>$kitchen){
                                $notification_message = 'Order:'.$sale_no.' has been modified. Modified item: '.$item->menu_name.", Modified item qty:".$item->qty;
                                $bar_kitchen_notification_data = array();
                                $bar_kitchen_notification_data['notification'] = $notification_message;
                                $bar_kitchen_notification_data['sale_id'] = $sale_id;
                                $bar_kitchen_notification_data['outlet_id'] = $order_details->outlet_id;
                                $bar_kitchen_notification_data['kitchen_id'] = $kitchen->kitchen_id;
                                $this->db->insert('tbl_notification_bar_kitchen_panel', $bar_kitchen_notification_data);
                            }
                        }else{
                            
                        }
                        $this->Common_model->updateInformation($item_data, $sales_details_id, "tbl_kitchen_sales_details");
                    }else{
                        $item_data['cooking_status'] = 'New';
                        $this->db->insert('tbl_kitchen_sales_details', $item_data);
                         $sales_details_id = $this->db->insert_id();
                    }
                }else{
                    $item_data['cooking_status'] = 'New';
                    $this->db->insert('tbl_kitchen_sales_details', $item_data);
                     $sales_details_id = $this->db->insert_id();
                }
  
                $previous_food_id = $sales_details_id;
                $update_previous_id = array();
                $update_previous_id['previous_id'] = $previous_food_id;
                $this->Common_model->updateInformation($update_previous_id, $sales_details_id, "tbl_kitchen_sales_details");
  
  
                $modifier_id_array = ($item->modifiers_id!="")?explode(",",$item->modifiers_id):null;
                $modifier_price_array = ($item->modifiers_price!="")?explode(",",$item->modifiers_price):null;
                $modifier_vat_array = (isset($item->modifier_vat) && $item->modifier_vat!="")?explode("|||",$item->modifier_vat):null;
                if(!empty($modifier_id_array)>0){
                    $i = 0;
                    foreach($modifier_id_array as $key1=>$single_modifier_id){
                        $modifier_data = array();
                        $modifier_data['modifier_id'] =$single_modifier_id;
                        $modifier_data['modifier_price'] = $modifier_price_array[$i];
                        $modifier_data['food_menu_id'] = $item->food_menu_id;
                        $modifier_data['sales_id'] = $sale_id;
                        $modifier_data['sales_details_id'] = $sales_details_id;
                        $modifier_data['menu_taxes'] = isset($modifier_vat_array[$key1]) && $modifier_vat_array[$key1]?$modifier_vat_array[$key1]:'';
                        $modifier_data['user_id'] = $order_details->user_id;
                        $modifier_data['outlet_id'] = $order_details->outlet_id; 
                        if($sale_id){
                            $check_exist_modifer = checkExistItemModifer($sale_id,$item->food_menu_id,$sales_details_id,$single_modifier_id);
                            if(isset($check_exist_modifer) && $check_exist_modifer){
                                $sales_details_modifier_id = $check_exist_modifer->id;
                                if($item->qty!=$check_exist_item->qty){
                                    $modifier_data['is_print'] = 1;
                                }
                                $this->Common_model->updateInformation($modifier_data, $sales_details_modifier_id, "tbl_kitchen_sales_details_modifiers");
  
                            }else{
                                $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
                            }
                        }else{
                            $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
                        }
  
                        $i++;
                    }
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit(); 
        }
  
        
          $status = "success";
          $message = lang('insertion_success');
          $responce = "http_response_ok";
  
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
  
}
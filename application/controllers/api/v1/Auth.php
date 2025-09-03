<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');
require(APPPATH.'/libraries/REST_Controller.php');

class Auth extends REST_Controller
{
	  public function __construct() {
               parent::__construct();
              
               $this->load->model('Common_model');
               $this->load->model('Authentication_model');
               $this->load->model('User_model');
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
             $access_token_array->query['access_token'] = isset($headers['access-token']) && $headers['access-token']?$headers['access-token']:'';
if(!$this->oauth_server->verifyResourceRequest($access_token_array) && $uri_segments[4]!="token"){
                  
                   $status = 'Token invalid';
                   $responce = 'http_response_unauthorized';

                   $this->response(array(
                        'status'=> $status
                     ),$this->config->item($responce)
                  ); 
               } 

$this->load->model('Api_model');
     }

   function token_post() {
      //getting headers data
       $headers = get_all_headers();
  
       $variable = OAuth2\Request::createFromGlobals();
       //updating client id and secret id from header.
       $array['grant_type'] = "client_credentials";
       $array['client_id'] = $headers['client-id'];
       $array['client_secret'] = $headers['client-secret'];
       $variable->request = $array;
       $this->oauth_server->handleTokenRequest($variable)->send();
   }
   public function login_post()
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

      $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Password', 'required');
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        
            $email = isset($jsonData['email']) && $jsonData['email']?$jsonData['email']:'';
            $password = isset($jsonData['password']) && $jsonData['password']?$jsonData['password']:'';
           
            $user_information = $this->Api_model->getUserInformation($email, $password);
           
            if($user_information){
              $outlets  = $this->Api_model->getOutletsByUserId($user_information->outlets,$user_information->role,$user_information->company_id);  
              $user_information->outlets = $outlets;
              unset($user_information->outlet_id);

              $status = "success";
                $message = "Login successfully!";
                $responce = "http_response_ok";
              }else{
                $message = "Emil or Password not valid!";
                $status = "error";
                $responce = "http_response_not_found";
              }
              
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

       $this->response(array(
               'data' => $user_information,
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
   public function login_pin_post()
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


       $this->form_validation->set_rules('login_pin', 'Login Pin', 'required'); 
      
       if ($this->form_validation->run() == TRUE) {
        $user_information = $this->Api_model->getUserInformationPin($jsonData['login_pin']);
        $message = '';
        if($user_information){
          $outlets  = $this->Api_model->getOutletsByUserId($user_information->outlets,$user_information->role,$user_information->company_id);  
          $user_information->outlets = $outlets;
          unset($user_information->outlet_id);

           $status = "success";
           $message = "Login successfully!";
           $responce = "http_response_ok";
         }else{
           $status = "error";
           $message = "Pin not valid!";
           $responce = "http_response_not_found";
         }
      } else {
          $status = "error";
          $message = $this->form_validation->error_array();
          $responce = "http_response_invalid";
        }
     

      $this->response(array(
                'data' => $user_information,
                'status'=> $status,
                'message'=> $message
              ),$this->config->item($responce)
            );
   }


   public function is_open_register_post()
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

      $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required');
      $this->form_validation->set_rules('user_id', 'User ID', 'required');
      
      $message = '';
      if ($this->form_validation->run() == TRUE) {
        
            $outlet_id = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
            $user_id = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
            $user_information = $this->Api_model->isOpenRegister($user_id, $outlet_id);
            $status = "success";
            $message = "Register is open!";
            $responce = "http_response_ok"; 
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

       $this->response(array(
               'data' => $user_information,
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
   public function add_register_details_post()
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

      $this->form_validation->set_rules('company_id', 'Company ID', 'required'); 
      
      $message = '';
      $counters = [];
      $payment_methods = [];
      if ($this->form_validation->run() == TRUE) {
        
            $company_id = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
            $counters = $this->Common_model->getAllCounters($company_id, "tbl_counters");
            $payment_methods = $this->Common_model->getAllByCompanyId($company_id, "tbl_payment_methods");
            $status = "success";
            $message = "Counters fetched successfully!";
            $responce = "http_response_ok"; 
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

       $this->response(array(
                'counters' => $counters,
                'payment_methods' => $payment_methods,
                'status'=> $status,
                'message'=> $message,
               ),$this->config->item($responce)
             );
   }
   public function store_register_details_post()
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

      $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'required'); 
      $this->form_validation->set_rules('counter_id', 'Counter ID', 'required'); 
      $this->form_validation->set_rules('user_id', 'User ID', 'required'); 
      $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required'); 
      $this->form_validation->set_rules('company_id', 'Company ID', 'required');  
      
      $message = '';
      $data = []; 
      if ($this->form_validation->run() == TRUE) {
        
            $company_id = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';
            $counter_id = isset($jsonData['counter_id']) && $jsonData['counter_id']?$jsonData['counter_id']:'';
            $user_id = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
            $outlet_id = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
            $opening_balance = isset($jsonData['opening_balance']) && $jsonData['opening_balance']?$jsonData['opening_balance']:'';
            $payment_object = isset($jsonData['payment_object']) && $jsonData['payment_object']?$jsonData['payment_object']:'';
            
            $register_info = array();
            $register_info['opening_balance'] = $opening_balance;
            $register_info['closing_balance'] = 0.00;
            $register_info['counter_id'] = $counter_id;
            $register_info['opening_balance_date_time'] = date('Y-m-d H:i:s');
            $register_info['register_status'] = 1;
            $register_info['user_id'] = $user_id;
            $register_info['outlet_id'] = $outlet_id;
            $register_info['company_id'] = $company_id;


            $fixed_json = str_replace("'", '"', $payment_object);
            // Step 2: Decode into PHP array
            $payment_object = json_decode($fixed_json, true);
            
            // Step 3: Loop through and build your desired format
            $arr = [];
            if (is_array($payment_object)) {
                foreach ($payment_object as $value) {
                    $arr[] = $value['payment_id'] . "||" . $value['payment_name'] . "||" . $value['amount'];
                }
            }
            $register_info['opening_details'] = json_encode($arr);
            $this->Common_model->insertInformation($register_info, "tbl_register");

            $status = "success";
            $message = "Register details stored successfully!";
            $responce = "http_response_ok"; 
    } else {
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
   public function getOpeningDateTime($counter_id,$outlet_id){ 
    $getOpeningDateTime = $this->Api_model->getOpeningDateTime($counter_id,$outlet_id);
    return $getOpeningDateTime;
} 

   public function registerDetailCalculationToShow($counter_id,$outlet_id){
    $opening_details_row = $this->getOpeningDateTime($counter_id,$outlet_id);
    $opening_date_time = isset($opening_details_row->opening_date_time) && $opening_details_row->opening_date_time?$opening_details_row->opening_date_time:'';
    $opening_details= isset($opening_details_row->opening_details) && $opening_details_row->opening_details?$opening_details_row->opening_details:'';

    $opening_details_decode = json_decode($opening_details);
 
    
    $return_array = array();
    $return_array['counter_name'] = getCounterName($counter_id);
    $return_array['time_range'] = date('Y-m-d h:i A', strtotime($opening_date_time)) . ' to ' . date('Y-m-d h:i:s A');
    $return_array['payments'] = [];
    $return_array['summary'] = [];

    if (isset($opening_details_decode) && $opening_details_decode) {
      foreach ($opening_details_decode as $key => $value) {
          $payments = explode("||", $value);
          $payment_id = $payments[0];
          $payment_name = $payments[1];
          $opening_amount = (float)$payments[2];
  
          $total_purchase = (float)$this->Api_model->getAllPurchaseByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
          $total_due_receive = (float)$this->Api_model->getAllDueReceiveByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
          $total_due_payment = (float)$this->Api_model->getAllDuePaymentByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
          $total_expense = (float)$this->Api_model->getAllExpenseByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
          $refund_amount = (float)$this->Api_model->getAllRefundByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
          $total_sale = (float)$this->Api_model->getAllSaleByPayment($opening_date_time, $payment_id,$counter_id,$outlet_id);
  
          $closing_balance = $opening_amount - $total_purchase + $total_sale + $total_due_receive - $total_due_payment - $total_expense - $refund_amount;
  
          $payment_data = [
              'payment_id' => $payment_id,
              'payment_name' => $payment_name,
              'opening_amount' => $opening_amount,
              'total_purchase' => $total_purchase,
              'total_sale' => $total_sale,
              'total_due_receive' => $total_due_receive,
              'total_due_payment' => $total_due_payment,
              'total_expense' => $total_expense,
              'refund_amount' => $refund_amount,
              'closing_balance' => $closing_balance
          ];
  
          if ($payment_id == 1) {
              $multi_currency_sales = $this->Api_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time, $payment_id,$counter_id,$outlet_id); 
              if ($multi_currency_sales) {
                  $payment_data['multi_currency_sales'] = array_map(function ($row) {
                      return [
                          'currency' => $row->multi_currency,
                          'total_amount' => (float)$row->total_amount
                      ];
                  }, $multi_currency_sales);
              }
          }
  
          $return_array['payments'][] = $payment_data;

          $return_array['summary'][$payment_name] = $closing_balance;
      }
  }
 
    return $return_array;
}

   public function get_register_details_post()
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
      $this->form_validation->set_rules('counter_id', 'Counter ID', 'required'); 
      $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required'); 
      
      $message = '';
      $data = []; 
      if ($this->form_validation->run() == TRUE) {
           $counter_id = isset($jsonData['counter_id']) && $jsonData['counter_id']?$jsonData['counter_id']:'';
           $outlet_id = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
        
            $data = $this->registerDetailCalculationToShow($counter_id,$outlet_id);
            $status = "success";
            $message = "Register details fetched successfully!";
            $responce = "http_response_ok"; 
    } else {
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
   public function forgot_password_step_one_post() {
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

    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    
    $message = '';
    if ($this->form_validation->run() == TRUE) {
        $email = $jsonData['email'];
        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
        $errors = '';
        if($user_information){
            $status = "success";
            $message = "Email Address found!";
            $responce = "http_response_ok";
          }else{
            $message = "Email Address not found!";
            $status = "error";
            $responce = "http_response_not_found";
          }
    } else {
      $status = "error";
      $message = $this->form_validation->error_array();
      $responce = "http_response_invalid";
    }

    $this->response(array(
              'data' => $user_information,
              'status'=> $status,
              'message' => $message
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
 
 $this->form_validation->set_rules('counter_id', 'Counter ID', 'required'); 
 $this->form_validation->set_rules('user_id', 'User ID', 'required'); 
 $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required'); 
 $this->form_validation->set_rules('company_id', 'Company ID', 'required'); 
 
 $message = '';
 $data = array();
 if ($this->form_validation->run() == TRUE) { 
   $user_id  = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
   $outlet_id  = isset($jsonData['outlet_id']) && $jsonData['outlet_id']?$jsonData['outlet_id']:'';
   $counter_id  = isset($jsonData['counter_id']) && $jsonData['counter_id']?$jsonData['counter_id']:'';
   $company_id  = isset($jsonData['company_id']) && $jsonData['company_id']?$jsonData['company_id']:'';

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

       $total_sale =  $this->Api_model->getAllSaleByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);
       $total_purchase = $this->Api_model->getAllPurchaseByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);
       $total_due_receive = $this->Api_model->getAllDueReceiveByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);
       $total_due_payment = $this->Api_model->getAllDuePaymentByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);
       $total_expense = $this->Api_model->getAllExpenseByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);
       $refund_amount = $this->Api_model->getAllRefundByPayment($opening_date_time,$payments[0],$counter_id,$outlet_id);


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
           $total_sale_mul_c_rows =  $this->Api_model->getAllSaleByPaymentMultiCurrencyRows($opening_date_time,$payments[0],$counter_id,$outlet_id);
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

public function forgot_password_step_two_post() {
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

  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
  $this->form_validation->set_rules('answer', 'Answer', 'required');
  $this->form_validation->set_rules('question', 'Question', 'required');
  $message = '';
  if ($this->form_validation->run() == TRUE) {
      $email = $jsonData['email'];
      $answer = $jsonData['answer'];
      $question = $jsonData['question'];
      $user_information = $this->Authentication_model->getAccountByMobileNo($email);
     
      if($user_information){
         
        if($answer != $user_information->answer){
            $status = "error";
            $message = "Incorrect answer";
            $responce = "http_response_not_found";
        }
        if($question != $user_information->question){
            $status = "error";
            $message = "Incorrect question";
            $responce = "http_response_not_found";
        } 

        if($status=="error"){
          $user_information = null;
        }else{
          $status = "success";
          $message = "Question and Answer matched!";
          $responce = "http_response_ok";
        }
        
      }else{
          $status = "error";
          $message = "No data found!";
          $responce = "http_response_not_found";
      }
  } else {
    $status = "error";
    $message = $this->form_validation->error_array();
    $responce = "http_response_invalid";
  }

      $this->response(array(
            'data' => $user_information,
            'status'=> $status,
            'message' => $message
          ),$this->config->item($responce)
        );
}
public function forgot_password_step_final_post() {
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
  
  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
  $this->form_validation->set_rules('password', 'Password', 'required');
  $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

  $message = '';
    if ($this->form_validation->run() == TRUE) {
        $password = htmlspecialcharscustom($jsonData['password']);
        $email = htmlspecialcharscustom($jsonData['email']);

        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
        if($user_information){
          $this->Authentication_model->updatePasswordEmail(md5($password), $email);
          $status = "success";
          $responce = "http_response_ok";
          $message = lang('update_success');
        }else{
          $status = "error";
          $message = "No data found!";
          $responce = "http_response_not_found";
        }
        
    } else {
        $message = $this->form_validation->error_array();
        $status = "error";
        $responce = "http_response_invalid";
    }

    $this->response(array(
        'data' => '',
        'message'=> $message,
        'status'=> $status
      ),$this->config->item($responce)
    );
}

public function change_profile_post() {
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
  
  $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
   
  $message = '';
    if ($this->form_validation->run() == TRUE) {
        $email = isset($jsonData['email']) && $jsonData['email']?$jsonData['email']:'';
        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
      
        if($user_information){
        $status = "success";
          $responce = "http_response_ok";
        }else{
          $status = "error";
          $message = "Data not found!";
          $responce = "http_response_not_found";
        }
    } else {
      
        $message = $this->form_validation->error_array();
        
        $status = "error";
        $responce = "http_response_invalid";
    }
    
    $this->response(array(
            'data' => $user_information,
            'status'=> $status,
            'message'=> $message
          ),$this->config->item($responce)
        );
  }

  public function store_change_profile_post() {
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
  
     
    $post_email_address =htmlspecialcharscustom($jsonData['email_address']);
    $user_details = $this->Authentication_model->getAccountByMobileNo($post_email_address);
    
    $existing_email_address = $user_details->email_address;
    if ($post_email_address != $existing_email_address) {
        $this->form_validation->set_rules('email_address', lang('email_address'), "required|valid_email|max_length[50]|is_unique[tbl_users.email_address]");
    } else {
        $this->form_validation->set_rules('email_address',lang('email_address'), "required|valid_email|max_length[50]");
    }
  
  $this->form_validation->set_rules('full_name', lang('full_name'), "required|max_length[50]");
  $this->form_validation->set_rules('phone', lang('phone'), "max_length[50]");
  $message = '';
    if ($this->form_validation->run() == TRUE) {
       
        if($user_details){
          $user_info = array();
          $user_info['full_name'] =htmlspecialcharscustom($jsonData['full_name']);
          $user_info['email_address'] =htmlspecialcharscustom($jsonData['email_address']);
          $user_info['phone'] =htmlspecialcharscustom($jsonData['phone']);
          $this->Common_model->updateInformation($user_info, $user_details->id, "tbl_users");
           
          $status = "success";
          $responce = "http_response_ok";
          $message = lang('update_success');
        }else{
          $status = "error";
          $message = "No data found!";
          $responce = "http_response_not_found";
        }
    } else {
      $message = $this->form_validation->error_array();
      $status = "error";
      $responce = "http_response_invalid";
    }

    $this->response(array(
              'data' => '',
              'status'=> $status,
              'message' => $message
            ),$this->config->item($responce)
          );
}
  public function store_change_password_post() {
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

    $this->form_validation->set_data($jsonData);
    
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
    $this->form_validation->set_rules('old_password',lang('old_password'), 'required|max_length[50]');
    $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
  
    $message = '';
    $status = '';
    if ($this->form_validation->run() == TRUE) {
      
      $user_id = isset($jsonData['user_id']) && $jsonData['user_id']?$jsonData['user_id']:'';
    
      $old_password =htmlspecialcharscustom($jsonData['old_password']);
      $password_check = $this->Authentication_model->passwordCheck(md5($old_password), $user_id);

       
      if ($password_check) {
          $new_password =htmlspecialcharscustom($jsonData['new_password']);
          $this->Authentication_model->updatePassword(md5($new_password), $user_id); 
          $message = lang('password_changed');
          $status = "success";
          $responce = "http_response_ok";
          $message = lang('update_success');
      } else {
          $message = lang('old_password_not_match');
          $status = "error";
          $responce = "http_response_invalid";
      }
    } else {
        $status = "error";
        $message  = $this->form_validation->error_array();
        $responce = "http_response_invalid";
    }

    $this->response(array(
              'data' => '', 
              'status'=> $status,
              'message' => $message
            ),$this->config->item($responce)
          );
  }
  public function store_change_pin_post() {
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


    $email_address = isset($jsonData['email_address']) && $jsonData['email_address']?$jsonData['email_address']:'';
    
    $this->form_validation->set_rules('old_pin',lang('old_pin'), 'required|max_length[4]|min_length[4]');


    $old_pin =htmlspecialcharscustom($jsonData['old_pin']);
    $new_pin =htmlspecialcharscustom($jsonData['new_pin']);
    
    if($old_pin!=$new_pin){
        $this->form_validation->set_rules('new_pin',  lang('new_pin'), "required|max_length[4]|min_length[4]|is_unique[tbl_users.login_pin]");
    }else{
        $this->form_validation->set_rules('new_pin',  lang('new_pin'), "required|max_length[4]|min_length[4]");
    }

    $message = '';
    $status = '';
    if ($this->form_validation->run() == TRUE) {
      
      $pin_check = $this->Authentication_model->pinCheck1(($old_pin), $email_address);
       
      if ($pin_check) {
          $new_pin =htmlspecialcharscustom($jsonData['new_pin']);
          $this->Authentication_model->updatePinEmail(($new_pin), $email_address);

          $message = lang('pin_changed');
          $status = "success";
          $responce = "http_response_ok";
      } else {
          $message = lang('old_pin_not_match');
          $status = "error";
          $responce = "http_response_invalid";
      }
    } else {
        $status = "error";
        $message  = $this->form_validation->error_array();
        $responce = "http_response_invalid";
    }

    $this->response(array(
              'data' => '', 
              'status'=> $status,
              'message' => $message
            ),$this->config->item($responce)
          );
  }


  public function store_security_question_post() {
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

    $email_address = isset($jsonData['email_address']) && $jsonData['email_address']?$jsonData['email_address']:'';
    
    $this->form_validation->set_rules('email_address',lang('email_address'), "required|valid_email|max_length[50]");
    $this->form_validation->set_rules('question', lang('question'), 'required|max_length[50]');
    $this->form_validation->set_rules('answer', lang('SecurityAnswer'), 'required|max_length[50]');

    $message = '';
    $status = '';
    if ($this->form_validation->run() == TRUE) {

      $user_information = $this->Authentication_model->getAccountByMobileNo($email_address);
      
      if($user_information){
        $security_question = htmlspecialcharscustom($jsonData['question']);
        $security_answer = htmlspecialcharscustom($jsonData['answer']);
        $this->Authentication_model->updateSecurityQuestion1('', $email_address, $security_question, $security_answer);
        $message = lang('setsecurityquestionsuccess');
        $status = "success";
        $responce = "http_response_ok";
      }else{
        $status = "error";
        $message = "Data not found!";
        $responce = "http_response_not_found";
      }
    } else {
        $status = "error";
        $message  = $this->form_validation->error_array();
        $responce = "http_response_invalid";
    }

    $this->response(array(
              'data' => '', 
              'status'=> $status,
              'message' => $message
            ),$this->config->item($responce)
          );
  }
  

}
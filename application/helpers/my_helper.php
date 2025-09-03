<?php
/**
 * return  characters to HTML entities.
 * @return string
 * @param string
 */
function escape_output($string){
    if($string){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }else{
        return '';
    }
}

function getCustomerDetails($customer_name,$customer_address,$phone,$customer_email) {
    $CI = & get_instance();
    $company_id = 1;
     
    $id = $CI->db->query("SELECT id FROM tbl_customers WHERE company_id=$company_id and phone='" . $phone . "' and del_status='Live'")->row('id');
    if ($id != '') {
        return $id;
    } else {
            $customer_info = array();
            $customer_info['name'] = $customer_name;
            $customer_info['phone'] = $phone;
            $customer_info['email'] = $customer_email;
            $customer_info['default_discount'] = 0;
            $c_address = $customer_address;
            $customer_info['address'] = preg_replace("/[\n\r]/"," ",escape_output($c_address)); #remove new line from address
            $customer_info['user_id'] = 1;
            $customer_info['company_id'] = $company_id;
            $id = insertInformation($customer_info, "tbl_customers");
            return $id;
    }
}
function insertInformation($data, $table_name) {
    $CI = & get_instance();
    $CI->db->insert($table_name, $data);
    return $CI->db->insert_id();
}
function getOrderNoByOrderId($id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales where `id`='$id' AND del_status='Live'")->row();

    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
function collectGST1(){
    $CI = & get_instance();
    $company_id = 1;
    if($company_id){
        $outlet_info = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id'")->row();
        return isset($outlet_info->tax_is_gst) && $outlet_info->tax_is_gst?$outlet_info->tax_is_gst:'No';
    }else{
        return "No";
    }
}
function generateHashCode($body_text){
        $data = $body_text;
        $hash = hash('sha256', $data);
        return $hash;
}
function getPlanText($text){
    if($text){
        $res = trim(str_replace( array( '\'', '"',',' , ';', '<', '>','(',')','{','}','[',']','$','%','#','/','@','&','?'), ' ', $text));
        $tmp_text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $res)));
        $final_txt = preg_replace("/[\n\r]/"," ",escape_output($tmp_text)); #remove new line from address
       return $final_txt;
    }else{
        return '';
    }
}
function checkH() {
    $spi = null;
    if ( defined( 'INPUT_SERVER' ) && filter_has_var( INPUT_SERVER, 'REMOTE_ADDR' ) ) {
        $spi = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
    } elseif ( defined( 'INPUT_ENV' ) && filter_has_var( INPUT_ENV, 'REMOTE_ADDR' ) ) {
        $spi = filter_input( INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
    } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
        $spi = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
    }

    if ( empty( $spi ) ) {
        $spi = '127.0.0.1';
    }
    $data = empty( filter_var( $spi, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE ));
    return $data;
}

function checkHH() {
    $spi = null;
    if ( defined( 'INPUT_SERVER' ) && filter_has_var( INPUT_SERVER, 'REMOTE_ADDR' ) ) {
        $spi = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
    } elseif ( defined( 'INPUT_ENV' ) && filter_has_var( INPUT_ENV, 'REMOTE_ADDR' ) ) {
        $spi = filter_input( INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
    } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
        $spi = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
    }

    if ( empty( $spi ) ) {
        $spi = '127.0.0.1';
    }
    $data = empty( filter_var( $spi, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE ));
    return $data!=1?$data:'';
}

function getTotalItem($sale_id) {
    $CI = & get_instance();
    $CI->db->select('sum(qty) as totalQty');
    $CI->db->from('tbl_sales_details');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $row = $query_result->row();
    if($row){
        return $row->totalQty;
    }else{
        return 0;
    }
}
function get_numb_with_zero($number){
    $numb = str_pad($number, 2, '0', STR_PAD_LEFT);
    return $numb;
}

function getRanking($amount) {
    $CI = & get_instance();
    $txt = "";
    if($amount>=0 && $amount<=50){
        $txt = "A";
    }
    else if($amount>50 && $amount<=80){
        $txt = "B";
    }
    else if($amount>80 && $amount<=100){
        $txt = "C";
    }

    return $txt;

}
function getTotalHour($out_time,$in_time){
    $time1 = $out_time;
    $time2 = $in_time;
    $array1 = explode(':', $time1);
    $array2 = explode(':', $time2);

    $minutes1 = ($array1[0] * 60.0 + $array1[1]);
    $minutes2 = ($array2[0] * 60.0 + $array2[1]);

    $total_min = $minutes1 - $minutes2;
    $total_tmp_hour = (int)($total_min/60);
    $total_tmp_hour_minus = ($total_min%60);

    //return $total_tmp_hour.".".$total_min_tmp;
    return $total_tmp_hour.".".get_numb_with_zero($total_tmp_hour_minus);

}
function getSplitTotalBill($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales');
    $CI->db->where('del_status', "Live");
    $CI->db->where('split_sale_id', $id);
    $main_row =  $CI->db->get()->result();
    return sizeof($main_row);

}

function getSaleDetails($sale_no) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales');
    $CI->db->where('del_status', "Live");
    $CI->db->where('sale_no', $sale_no);
    $main_row =  $CI->db->get()->row();
    return $main_row;

}
function getTotalSaleRows() {
    $CI = & get_instance();
    $CI->db->select('count(id) as total_row');
    $CI->db->from('tbl_sales');
    $CI->db->where('split_sale_id', Null);
    $main_row =  $CI->db->get()->row();
    return ($main_row->total_row);

}
function getExistFoodMenu($sale_id,$food_menu_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales_details');
    $CI->db->where('del_status', "Live");
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('food_menu_id', $food_menu_id);
    $main_row =  $CI->db->get()->row();
    return $main_row;

}
function getRandomCodeOne($length = 1) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getRandomCodeTwoCapital($length = 2) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getShortName() {
    $CI = & get_instance();
    $full_name = $CI->session->userdata('full_name');
    if (!empty($full_name) && is_string($full_name)) {
        $short_name = strtolower(substr($full_name, 0, 1));
    } else {
        $short_name = getRandomCodeOne(1);
    }
    // Append 2 capital letters
    return $short_name . getRandomCodeTwoCapital(2);
}
function getShortCustomerName() {
    $CI = & get_instance();
    $customer_name = $CI->session->userdata('customer_name');
    if (!empty($customer_name) && is_string($customer_name)) {
        $short_name = strtolower(substr($customer_name, 0, 1));
    } else {
        $short_name = getRandomCodeOne(1); 
    }
    return $short_name . getRandomCodeTwoCapital(2);
}
function generateOtp($length = 6) {
    // Ensure the length is 6 (you can adjust the length parameter as needed)
    if ($length != 6) {
        $length = 6;
    }

    // Generate a random 6-digit number
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= mt_rand(0, 9); // Appends a random digit (0-9)
    }

    return $otp;
}
function getExistFoodMenuModifier($sale_id,$food_menu_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales_details_modifiers');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('food_menu_id', $food_menu_id);
    $main_row =  $CI->db->get()->result();
    return $main_row;

}
function getCustomerDue($customer_id) {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');
    if($outlet_id){
        $customer_due = $CI->db->query("SELECT SUM(due_amount) as due FROM tbl_sales WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live' and order_status='3'")->row();
        $customer_payment = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id and outlet_id=$outlet_id and del_status='Live'")->row();
    }else{
        $customer_due = $CI->db->query("SELECT SUM(due_amount) as due FROM tbl_sales WHERE customer_id=$customer_id and del_status='Live' and order_status='3'")->row();
        $customer_payment = $CI->db->query("SELECT SUM(amount) as amount FROM tbl_customer_due_receives WHERE customer_id=$customer_id  and del_status='Live'")->row();
    }
   
    $remaining_due = $customer_due->due - $customer_payment->amount;
    return $remaining_due;

}
/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function isServiceAccess($user_id='',$company_id='',$service_type='') {
    $CI = & get_instance();
    $company = getMainCompany();
    $service_type = str_rot13($service_type);
    $status = false;
    if($user_id==''){
        $user_id = $CI->session->userdata('user_id');
    }
    if($company_id==''){
        $company_id = $CI->session->userdata('company_id');
    }
    if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->languge_manifesto) =="fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
        $plugin = $result = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status='Live' AND bestoro='$service_type' AND active_status='Active'")->result();
        if($plugin){
            if($company_id==1 && $user_id==1){
                $status = true;
            }
        }
    }
    return $status;
}
/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function isFoodCourt($id='') {
    $company = getMainCompany();
    $status = false;
    if(isset($company->languagefcrt_manifesto) && str_rot13($company->languagefcrt_manifesto)=="fTzfWnSWIRSPeg"){
        $status = true;
    }
    return $status;
}
/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function getLabelForFoodCourt($str) {
    $company = getMainCompany();
    if(isset($company->languagefcrt_manifesto) && str_rot13($company->languagefcrt_manifesto)=="fTzfWnSWIRSPeg"){
        $str = "food_court";
    }
    return $str;
}

/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function isServiceAccessPlugin($user_id='',$company_id='',$service_type='') {
    $CI = & get_instance();
    $company = getMainCompany();
    $service_type = str_rot13($service_type);
    $status = false;
    if($company_id==''){
        $company_id = $CI->session->userdata('company_id');
    }
    if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->languge_manifesto) =="fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
        $plugin = $result = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status='Live' AND bestoro='$service_type' AND active_status='Active'")->row();
        if($plugin){
            if($company_id==1){
                $status = true;
            }
        }
    }
    return $status;

}

/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function isServiceAccessOnly($service_type='') {
    $company = getMainCompany();
    $CI = & get_instance();
    $status = false;
    $company_id = $CI->session->userdata("company_id");
    if($company_id==1 && $service_type && $service_type =="fTzfWnSWR" && str_rot13($company->languge_manifesto) =="fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
        return true;
    }else{
        $service_type = str_rot13($service_type);
        if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->languge_manifesto) =="fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
            $plugin = $result = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status='Live' AND bestoro='$service_type' AND active_status='Active'")->row();
            if(isset($plugin) && $plugin){
                $status = true;
            }
        }
    }
    return $status;
}
function getStatusOrdersItems($sale_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales_details');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('del_status', "Live");
    $main_row =  $CI->db->get()->result();
    return $main_row;
}
function getStatusOrders() {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');

    $CI->db->select('tbl_kitchen_sales.id,order_type,tbl_kitchen_sales.sale_no,tbl_customers.name as customer_name');
    $CI->db->from('tbl_kitchen_sales');
    $CI->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
    $CI->db->where('tbl_kitchen_sales.del_status', "Live");
    $CI->db->where('tbl_kitchen_sales.is_pickup_sale', 1);
    $CI->db->where("tbl_kitchen_sales.is_accept", 1);
    $CI->db->where("tbl_kitchen_sales.is_kitchen", 1);
    $CI->db->where('tbl_kitchen_sales.outlet_id', $outlet_id);
    $results =  $CI->db->get()->result();
    foreach ($results as $ky=>$value){
        $items = getStatusOrdersItems($value->id);
        $new = 0;
        $inprogress = 0;
        $done = 0;
        foreach($items as $ky1=>$value1){
            if($value1->cooking_status=="New"){
                $new++;
            }else if($value1->cooking_status=="Done"){
                $done++;
            }else if($value1->cooking_status=="Started Cooking"){
                $inprogress++;
            }
        }
        $status = '';
        if($new==sizeof($items)){
            //all new red
            $status = '1';
        }else if($done==sizeof($items)){
            //all done green
            $status = '2';
        }else{
            //inprogress
            $status = '3';
        }

        $results[$ky]->status = $status;
    }
    return $results;
}
/**
 * get Main Menu
 * @access
 * @return boolean
 * @param no
 */
function isServiceAccessOnlyLogin($service_type='') {
    $CI = & get_instance();
    $company = getMainCompany();
    $status = false;
    $service_type = str_rot13($service_type);
    if($service_type && $service_type =="fTzfWnSWR" && str_rot13($company->languge_manifesto) =="fTzfWnSWIR" &&  file_exists(APPPATH.'controllers/Service.php')){
        $plugin = $result = $CI->db->query("SELECT * FROM tbl_plugins WHERE del_status='Live' AND bestoro='$service_type' AND active_status='Active'")->row();
        if(isset($plugin) && $plugin){
            $status = true;
        }
    }
    return $status;
}

/**
 * get Main Menu
 * @access
 * @return object
 * @param no
 */
function getLastSaleId() {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');
    $CI->db->select('*');
    $CI->db->from('tbl_sales');
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('del_status', "Live");
    $CI->db->order_by('id desc');
    $last_row =   $CI->db->get()->row();
    return $last_row?$last_row->id:'';
}
function getParentNameOnly($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return (isset($food_information->name) && $food_information->name?$food_information->name:'');
}
function getSaleDetailsBySaleNo($sale_no) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_sales where `sale_no`='$sale_no' AND del_status='Live'")->row();
    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
 
function getKitchenItemDetails($sale_id,$food_menu_id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales_details where `food_menu_id`='$food_menu_id' AND `sales_id`='$sale_id' AND del_status='Live'")->row();
    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
/**
 * return access module main name
 * @return string
 * @param int
 */
if (!function_exists('getMainModuleName')) {
    function getMainModuleName($id)
    {
        $CI = &get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_main_modules");
        $CI->db->where("id", $id);
        $result = $CI->db->get()->row();
        if ($result) {
            return ($result->name);
        } else {
            return '';
        }
    }
}
function getKitchenSaleDetailsBySaleNo($sale_no) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales where `sale_no`='$sale_no' AND del_status='Live'")->row();

    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
function getKitchenSaleDetailsBySaleNoWithDeleted($sale_no) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales where `sale_no`='$sale_no' AND del_status='Live'")->row();

    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
function getExistOrderInfo($sale_no) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_running_orders where `sale_no`='$sale_no' AND del_status='Live'")->row();

    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}

function getExistOrderInfoTable($sale_no,$table_id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_running_order_tables where `sale_no`='$sale_no' AND `table_id`='$table_id' AND del_status='Live'")->row();

    if(isset($user_information) && $user_information){
        return $user_information;
    }else{
        return false;
    }
}
/**
 * get Main Menu
 * @access
 * @return object
 * @param no
 */
function returnSaleNo($id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales');
    $CI->db->where('id', $id);
    $last_row =   $CI->db->get()->row();
    return $last_row?$last_row->sale_no:'';
}
function getSaleDetailsByCode($code) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sales');
    $CI->db->where('random_code', $code);
    $CI->db->where('del_status', "Live");
    $last_row =   $CI->db->get()->row();
    return $last_row;
}
function checkExistItem($sale_id,$item_id,$row_counter) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales_details');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('food_menu_id', $item_id);
    $CI->db->where('del_status', "Live");
    $CI->db->limit(1, $row_counter);
    $selected_row =   $CI->db->get()->row();
    return $selected_row;
}
function checkExistItemModifer($sale_id,$item_id,$sales_details_id,$single_modifier_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales_details_modifiers');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('food_menu_id', $item_id);
    $CI->db->where('sales_details_id', $sales_details_id);
    $CI->db->where('modifier_id', $single_modifier_id);
    $selected_row =   $CI->db->get()->row();
    return $selected_row;
}
function getCustomerData($customer_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();

    if($information){
        return $information;
    }else{
        return "";
    }
}
function getCustomerDataByEmail($email) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_customers where `email`='$email' AND del_status='Live'")->row();

    if($information){
        return $information;
    }else{
        return "";
    }
}
function getSaleText($id) {
    $CI = & get_instance();
    $txt = '';

    $CI->db->select("*");
    $CI->db->from("tbl_sales");
    $CI->db->where("id", $id);
    $sale =  $CI->db->get()->row();

    if(isset($sale) && $sale){
        $customer_info = getCustomerData($sale->customer_id);
        $txt.="Sale No: ".$sale->sale_no.", ";
        $txt.="Sale Date: ".date($CI->session->userdata('date_format'), strtotime($sale->sale_date)).", ";
        $txt.="Customer: ".(isset($customer_info) && $customer_info->name?$customer_info->name:'---')." - ".(isset($customer_info) && $customer_info->phone?$customer_info->phone:'').", ";

        if(isset($sale->vat) && $sale->vat){
            $txt.="VAT: ".$sale->vat.",";
        }
        if(isset($sale->total_discount_amount) && $sale->total_discount_amount){
            $txt.="Discount: ".$sale->total_discount_amount.", ";
        }
        if(isset($sale->delivery_charge) && $sale->delivery_charge){
            $txt.="Charge: ".$sale->delivery_charge.", ";
        }
        if(isset($sale->tips_amount) && $sale->tips_amount){
            $txt.="Tips: ".$sale->tips_amount.", ";
        }
        $txt.="Total Payable: ".$sale->total_payable;

        $CI->db->select("*");
        $CI->db->from("tbl_sales_details");
        $CI->db->where("sales_id", $id);
        $sale_items =  $CI->db->get()->result();

        if(isset($sale_items) && $sale_items){
            $txt.="<br><b>Items:</b><br>";
            foreach ($sale_items as $key1=>$value1){
                $txt.=$value1->menu_name."("."$value1->qty X $value1->menu_unit_price".")";
                if($value1->menu_combo_items  && $value1->menu_combo_items!='undefined'){
                    $txt.="=><b>Combo Items:</b>";
                    $txt.=$value1->menu_combo_items;
                }
                if($key1 < (sizeof($sale_items) -1)){
                    $txt.=", ";
                }

                $CI->db->select("tbl_sales_details_modifiers.*,tbl_modifiers.name");
                $CI->db->from('tbl_sales_details_modifiers');
                $CI->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_sales_details_modifiers.modifier_id', 'left');
                $CI->db->where("tbl_sales_details_modifiers.sales_id", $sale->id);
                $CI->db->where("tbl_sales_details_modifiers.sales_details_id", $value1->id);
                $CI->db->order_by('tbl_sales_details_modifiers.id', 'ASC');
                $result = $CI->db->get();
                $data_result = $result->result();
                if($data_result){
                    $txt.=", <b>&nbsp;&nbsp;Modifier:</b>";
                    foreach($data_result as $key11=>$single_modifier){
                        $txt.="&nbsp;&nbsp;".$single_modifier->name;
                        if($key11 < (sizeof($data_result) -1)){
                            $txt.=", ";
                        }
                    }
                }

            }
        }
    }

    return $txt;
}
function setDefaultTimezone(){
    $CI = & get_instance();
    $CI->db->select("zone_name");
    $CI->db->from('tbl_companies');
    $CI->db->where('del_status', "Live");
    $zoneName = $CI->db->get()->row();
    if ($zoneName)
        date_default_timezone_set($zoneName->zone_name);
}
function putAuditLog($user_id,$txt,$event,$date_time) {
    setDefaultTimezone();

    $CI = & get_instance();
    $outlet_id = $CI->session->userdata("outlet_id");
    $data['user_id'] = $user_id;
    $data['event_title'] = $event;
    $data['date_time'] = $date_time;
    $data['outlet_id'] = $outlet_id;
    $data['date'] = date('Y-m-d');
    $data['details'] = $txt;
    $CI->db->insert("tbl_audit_logs", $data);

}
/**
 * get Main Menu
 * @access
 * @return object
 * @param no
 */
function returnSessionLng() {
    $CI = & get_instance();
    $language = $CI->session->userdata('language');
    return isset($language) && $language?$language:'';
}
/**
 * get All By Custom Id
 * @access public
 * @return boolean
 * @param int
 * @param string
 * @param string
 * @param string
 */
function getAllByCustomId($id,$filed,$tbl,$order=''){
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from($tbl);
    $CI->db->where($filed,$id);
    if($order!=''){
        $CI->db->order_by('id',$order);
    }
    $CI->db->where("del_status", 'Live');
    $result = $CI->db->get();

    if($result != false){
        return $result->result();
    }else{
        return false;
    }
}
/**
 * get Language Manifesto
 * @access public
 * @return array
 * @param no
 */
function getLanguageManifesto(){
    $CI = & get_instance();
    $language_manifesto = $CI->session->userdata('language_manifesto');
    if(isset($language_manifesto) && $language_manifesto){
        $outlet_id = $CI->session->userdata('outlet_id');
        if ($language_manifesto !== null) {
            if (str_rot13($language_manifesto) == "eriutoeri") {
                return [$language_manifesto, "Outlet/outlets"];
            } else if (str_rot13($language_manifesto) == "fgjgldkfg") {
                return [$language_manifesto, "Outlet/addEditOutlet/".$outlet_id];
            }
            return ['',''];
        } else {
            // Handle the case where $language_manifesto is null
            return ['',''];

        }
    }else{
        return ['',''];
    }

}

//SELECT * from sma_sales  desc limit 1
function paymentSetting() {
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $CI = & get_instance();
   
    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    $result = $CI->db->get()->row();
    return json_decode($result->payment_settings);

}

function paymentSettingSaas() {
    $company_id = 1;
    $CI = & get_instance();
 
   
    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    $result = $CI->db->get()->row();
    return json_decode($result->payment_settings);

}

//SELECT * from sma_sales  desc limit 1
function getCustomURL() {
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }
   
    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    $result = $CI->db->get()->row();
    return $result;

}
/**
 * get Company Info
 * @access public
 * @return object
 * @param no
 */
function getCompanyInfo($company_id = '') {
    $CI = & get_instance();
    if(!$company_id){
        $company_id = $CI->session->userdata('company_id');
        if(!$company_id){
            $company_id = 1;
        }
    } 
    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    return $CI->db->get()->row();
}

/**
 * get Company Info
 * @access public
 * @return object
 * @param no
 */
function findCompanyEmalByCompanyId($company_id) {
    $CI = & get_instance();
    $CI->db->select("email_address, full_name");
    $CI->db->from("tbl_users");
    $CI->db->where("company_id", $company_id);
    $result =  $CI->db->get()->row();
    if($result){
        return $result;
    }else{
        return false;
    }
}
function get_customer_details($phone,$password) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_customers");
    $CI->db->where("phone", $phone);
    $CI->db->where("password_online_user", md5($password));
    $CI->db->where("del_status", "Live");
    return $CI->db->get()->row();
}
function customerDetailsByPhone($phone) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_customers");
    $CI->db->where("phone", $phone);
    $CI->db->where("del_status", "Live");
    return $CI->db->get()->row();
}
/**
 * get Company Info
 * @access public
 * @return object
 * @param no
 */
function getCompanyInfoById($company_id='') {
    $CI = & get_instance();
    if($company_id==''){
        $company_id = $CI->session->userdata('company_id');
    }
    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    return $CI->db->get()->row();
}
/**
 * get first outlet Info
 * @access public
 * @return object
 * @param no
 */
function getFirstOutletByCompany($company_id='') {
    $CI = & get_instance();
    if($company_id==''){
        $company_id = $CI->session->userdata('company_id');
    }
    $CI->db->select("*");
    $CI->db->from("tbl_outlets");
    $CI->db->where("id", $company_id);
    return $CI->db->get()->row();
}
/**
 * get first outlet Info
 * @access public
 * @return object
 * @param no
 */
function getFirstUserByCompany($company_id='') {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_users");
    $CI->db->where("company_id", $company_id);
    $CI->db->order_by('id', 'ASC');
    $CI->db->limit(1);
    return $CI->db->get()->row();
}
/**
 * get return percentage value
 * @access public
 * @return object
 * @param no
 */
function getPercentageValue($percentage,$total) {
    $tmp = explode('%',$percentage);
    if(isset($tmp[1])){
        $total_amount  = ($tmp[0]*$total)/100;
        return $total_amount;
    }else{
        return isset($tmp[0]) && $tmp[0]?$tmp[0]:0;
    }
}
function getPlanTextOrP($percentage) {
    $tmp = explode('%',$percentage);
    if(isset($tmp[1])){
        $total_amount  = $percentage;
        return $total_amount;
    }else{
        return isset($tmp[0]) && $tmp[0]?getAmt($tmp[0]):getAmt(0);
    }
}
/**
 * get Company Info
 * @access public
 * @return object
 * @param no
 */
function getPricingPlan() {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_pricing_plans");
    $CI->db->order_by('id', 'ASC');
    $CI->db->where("del_status", 'Live');
    return $CI->db->get()->result();
}

/**
 *  get dynamically domain name and return
 * @return string
 * @param string
 */
function getDomain($url){
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){
        $tmp = explode('.',$regs['domain']);
        return ucfirstcustom($tmp[0]);
    }
    return FALSE;
}
/**
 *  get dynamically domain name and return
 * @return string
 * @param string
 */
function getIPv4WithFormat($ipv_address){
    $ipv_address = (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$ipv_address."/";
    return $ipv_address;
}
/**
 * send_email
 * @access public
 * @return boolean
 * @param string
 * @param string
 * @param string
 * @param string
 * @param string
 */
function sendEmailOnly($txt,$to_email,$attached='',$sender_email='',$subject=''){
    $company = getMainCompany();
    $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
    $domain_name = ''.getDomain(base_url()).'';
    $username = $smtEmail->user_name;
    $password = $smtEmail->password;
    if($smtEmail->enable_status==1){
        $CI = &get_instance();
        // Load PHPMailer library
        $CI->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $CI->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = $smtEmail->host_name;
        $mail->SMTPAuth = true;
        $mail->Username = $smtEmail->user_name;
        $mail->Password = $password;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $smtEmail->port_address;

        $mail->setFrom($username, $domain_name);
        $mail->addReplyTo($username, $domain_name);
        // Add a recipient
        $mail->addAddress($to_email);
        // Email subject
        $mail->Subject = $subject;
        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content
        $mail->Body = $txt;
        if($attached!=''){
            $mail->AddAttachment($attached);
        }
        // Send email
        if(!$mail->send()){
            return false;
        }else{
            return true;
        }
    }
    return true;
}
function sendEmailOnlyOld($txt,$to_email,$attached='',$sender_email='',$subject=''){
    $company = getMainCompany();
    $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
    $domain_name = ''.getDomain(base_url()).'';
    if(isset($smtEmail->enable_status) && $smtEmail->enable_status==1){
        $CI = &get_instance();
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => ''.$smtEmail->host_name.'',
            'smtp_port' => ''.$smtEmail->port_address.'',
            'smtp_user' => ''.$smtEmail->user_name.'',
            'smtp_pass' => ''.$smtEmail->password.'',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->set_mailtype("html");
        $CI->email->from($domain_name, $domain_name);
        $CI->email->to($to_email, $sender_email);
        $CI->email->subject($subject);
        $CI->email->message($txt);
        //send mail
        if($attached!=''){
            $CI->email->attach($attached);
        }
        $CI->email->send();
    }

    return true;
}
/**
 * get Company Info
 * @access public
 * @return object
 * @param no
 */
function getMainCompany() {
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    } 
 
    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("id", $company_id);
    return $CI->db->get()->row();
}

if(! function_exists('product_name')) {
    function product_name($name, $size = 0) {
        if (!$size) { $size = 42; }
        return character_limiter($name, ($size-5));
    }
}

if(! function_exists('drawLine')) {
    function drawLine($size) {
        $line = '';
        for ($i = 1; $i <= $size; $i++) {
            $line .= '-';
        }
        return $line."\n";
    }
}

if(! function_exists('printLine')) {
    function printLine($str, $size, $sep = ":", $space = NULL) {
        $size = $space ? $space : $size;
        $lenght = strlen($str);
        list($first, $second) = explode(":", $str, 2);
        $line = $first . ($sep == ":" ? $sep : '');
        for ($i = 1; $i < ($size - $lenght); $i++) {
            $line .= ' ';
        }
        $line .= ($sep != ":" ? $sep : '') . $second;
        return $line;
    }
}

if(! function_exists('printText')) {
    function printText($text, $size) {
        $line = wordwrap($text, $size, "\\n");
        return $line;
    }
}
if(! function_exists('getPlanData')) {
    function getPlanData($str) {
        $str = $installation_url = str_replace('<br>',' ',str_replace('<span>','',str_replace('','',str_replace('</span>','',$str))));
       return $str;
    }
}

if(! function_exists('taxLine')) {
    function taxLine($name, $code, $qty, $amt, $tax, $size) {
        return printLine(printLine(printLine(printLine($name . ':' . $code, 16, '') . ':' . $qty, 22, '') . ':' . $amt, 33, '') . ':' . $tax, $size, '');
    }
}

if ( ! function_exists('character_limiter')) {
    function character_limiter($str, $n = 500, $end_char = '&#8230;') {
        if (mb_strlen($str) < $n) {
            return $str;
        }
        $str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\x0B", "\x0C"), ' ', $str));
        if (mb_strlen($str) <= $n) {
            return $str;
        }

        $out = '';
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val.' ';
            if (mb_strlen($out) >= $n) {
                $out = trim($out);
                return (mb_strlen($out) === mb_strlen($str)) ? $out : $out.$end_char;
            }
        }
    }
}

if ( ! function_exists('word_wrap')) {
    function word_wrap($str, $charlim = 76) {
        is_numeric($charlim) OR $charlim = 76;
        $str = preg_replace('| +|', ' ', $str);
        if (strpos($str, "\r") !== FALSE) {
            $str = str_replace(array("\r\n", "\r"), "\n", $str);
        }
        $unwrap = array();
        if (preg_match_all('|\{unwrap\}(.+?)\{/unwrap\}|s', $str, $matches)) {
            for ($i = 0, $c = count($matches[0]); $i < $c; $i++)
            {
                $unwrap[] = $matches[1][$i];
                $str = str_replace($matches[0][$i], '{{unwrapped'.$i.'}}', $str);
            }
        }

        $str = wordwrap($str, $charlim, "\n", FALSE);
        $output = '';
        foreach (explode("\n", $str) as $line) {
            if (mb_strlen($line) <= $charlim) {
                $output .= $line."\n";
                continue;
            }
            $temp = '';
            while (mb_strlen($line) > $charlim) {
                if (preg_match('!\[url.+\]|://|www\.!', $line)) {
                    break;
                }
                $temp .= mb_substr($line, 0, $charlim - 1);
                $line = mb_substr($line, $charlim - 1);
            }
            if ($temp !== '') {
                $output .= $temp."\n".$line."\n";
            } else {
                $output .= $line."\n";
            }
        }

        if (count($unwrap) > 0) {
            foreach ($unwrap as $key => $val) {
                $output = str_replace('{{unwrapped'.$key.'}}', $val, $output);
            }
        }

        return $output;
    }
}


/**
 * return printer info
 * @access public
 * @return object
 * @param int
 */
function getPrinterInfo($id) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_printers");
    $CI->db->where("id", $id);
    $CI->db->order_by("id", "DESC");
    return $CI->db->get()->row();
}
/**
 * get All Outlet By Assign User
 * @access public
 * @return object
 * @param no
 */
function getAllOutlestByAssign() {
    $CI = & get_instance();
    $role = $CI->session->userdata('role');
    $company_id = $CI->session->userdata('company_id');
    $user_id = $CI->session->userdata('user_id');
    $outlets = $CI->session->userdata('session_outlets');

    $language_manifesto = $CI->session->userdata('language_manifesto');
    if(str_rot13($language_manifesto)!="eriutoeri"):
        $outlets = 1;
    endif;

    if(isFoodCourt()){
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live'")->result();
        return $result;
    }
    if($company_id==1 && $user_id==1){
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE company_id='$company_id' AND del_status='Live'")->result();
    }else{
        if($role=="Admin"){
            $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`company_id`, '$company_id') AND del_status='Live'")->result();
        }else{
            $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`id`, '$outlets') AND del_status='Live'")->result();
        }

    }

    if(str_rot13($language_manifesto)!="eriutoeri"):
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND id=1")->result();
    endif;

    return $result;
}
function getAllOutlestByAssignAll() {
    $CI = & get_instance();
    $role = $CI->session->userdata('role');
    $company_id = $CI->session->userdata('company_id');
    $user_id = $CI->session->userdata('user_id');
    $outlets = $CI->session->userdata('session_outlets');

    $language_manifesto = $CI->session->userdata('language_manifesto');
    if(str_rot13($language_manifesto)!="eriutoeri"):
        $outlets = 1;
    endif;
    
    $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE company_id='$company_id' AND del_status='Live'")->result();

    if(str_rot13($language_manifesto)!="eriutoeri"):
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND id=1")->result();
    endif;

    return $result;
}
function getAllOutlestByAssignFront() {
    $CI = & get_instance(); 
    $company_id = 1;
    $compnay = getMainCompany();
    $language_manifesto = $compnay->language_manifesto;
 

    if(isFoodCourt()){
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live'")->result();
        return $result;
    }
    
    $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE company_id='$company_id' AND del_status='Live'")->result();
    
    if(str_rot13($language_manifesto)!="eriutoeri"):
        $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND id=1")->result();
    endif;
   
    return $result;
}
/**
 * get All Outlet By Assign User
 * @access public
 * @return object
 * @param no
 */
function getAllOutlestByAssignFood() {
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $result = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND `company_id`='$company_id'")->result();
    return $result;
}
/**
 * get Total Lanuage Manifesto
 * @access public
 * @return array
 * @param no
 */
function getTotalLanuageManifesto(){
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $company = $CI->db->query("SELECT * FROM tbl_companies WHERE del_status='Live'")->row();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live'AND company_id='$company_id'")->result();

    if(str_rot13($company->language_manifesto)=="eriutoeri"){
        $return_menu = "Outlet/outlets";
    }else if(str_rot13($company->language_manifesto)=="fgjgldkfg"){
        $outlet_info = $CI->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live'")->row();
        $return_menu = "Outlet/addEditOutlet/".(isset($outlet_info->id) && $outlet_info->id?$outlet_info->id:'');
    }
    return [$company->language_manifesto,sizeof($outlet_info1),$return_menu,$company->outlet_qty];
}
/**
 * get Outlets
 * @access public
 * @return string
 * @param string
 */
function getOutlets($outlets){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`id`, '$outlets') AND del_status='Live'")->result();
    $outlet_names = '';
    if($outlet_info1){
        foreach ($outlet_info1 as $key=>$name){
            $outlet_names.= $name->outlet_name;
            if($key < (sizeof($outlet_info1) -1)){
                $outlet_names.=", ";
            }
        }
    }

    return $outlet_names;
}
function getKitchens($kitchens){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_kitchens WHERE FIND_IN_SET(`id`, '$kitchens') AND del_status='Live'")->result();
    $outlet_names = '';
    if($outlet_info1){
        foreach ($outlet_info1 as $key=>$name){
            $outlet_names.= $name->name;
            if($key < (sizeof($outlet_info1) -1)){
                $outlet_names.=", ";
            }
        }
    }

    return $outlet_names;
}
/**
 * get Outlet Name By Id
 * @access public
 * @return string
 * @param int
 */
function getOutletNameById($outlet_id){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_outlets WHERE id='$outlet_id' AND del_status='Live'")->row();
    if($outlet_info1){
        return $outlet_info1->outlet_name;
    }else{
        return "";
    }
}
function getRole($role_id){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_roles WHERE id='$role_id' AND del_status='Live'")->row();
    if($outlet_info1){
        return $outlet_info1->role_name;
    }else{
        return "";
    }
}
/**
 * total Users
 * @access public
 * @return int
 * @param int
 */
function totalUsers($company_id) {
    $CI = & get_instance();
    $total_users = $CI->db->query("SELECT * FROM tbl_users where `company_id`='$company_id'")->num_rows();
    return $total_users;
}

function getRunningOrders($user_id) {
    $CI = & get_instance();
    $total_users = $CI->db->query("SELECT * FROM tbl_running_orders where `user_id`='$user_id'")->result();
    return $total_users;
}

function get_all_running_order_for_new_pc($user_id) {
    $CI = & get_instance();
    $sale_no_all = escape_output($_POST['sale_no_all']);
    $company_id = $CI->session->userdata('company_id');
    $outlet_id = $CI->session->userdata('outlet_id');
    $total_users = $CI->db->query("
                    SELECT id, sale_no, self_order_content 
                    FROM tbl_kitchen_sales 
                    WHERE NOT FIND_IN_SET(`sale_no`, '$sale_no_all') 
                    AND (user_id = '$user_id' OR order_receiving_id = '$user_id') 
                    AND is_accept = 1 
                    AND company_id = '$company_id' 
                    AND outlet_id = '$outlet_id' 
                    AND del_status = 'Live'
                ")->result();
    return $total_users;
}

function getOrderReceivingId($id) {
    $CI = & get_instance();
    $data = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();
    return isset($data->order_receiving_id) && $data->order_receiving_id?$data->order_receiving_id:'';
}
function getUserDetails($id) {
    $CI = & get_instance();
    $data = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();
    if($data){
        return $data;
    }else{
        return false;
    }
}
function getOrderReceivingIdAdmin() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $data = $CI->db->query("SELECT * FROM tbl_users where `company_id`='$company_id' AND `role`='Admin' AND del_status='Live'")->row();
    return isset($data->id) && $data->id?$data->id:'';
}
function getOrderReceivingIdAdminAPI($company_id) {
    $CI = & get_instance(); 
    $data = $CI->db->query("SELECT * FROM tbl_users where `company_id`='$company_id' AND `role`='Admin' AND del_status='Live'")->row();
    return isset($data->id) && $data->id?$data->id:'';
}
function getKitchenNameAndIdByOutletId($outlet_id,$cat_id) {
    $CI = & get_instance();
    $CI->db->select('tbl_kitchens.id as kitchen_id, tbl_kitchens.name as kitchen_name');
    $CI->db->from('tbl_kitchen_categories');
    $CI->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
    $CI->db->where('tbl_kitchen_categories.outlet_id', $outlet_id);
    $CI->db->where('tbl_kitchen_categories.cat_id', $cat_id);
    $CI->db->where('tbl_kitchen_categories.del_status', 'Live');
        $query_result = $CI->db->get();
    $row = $query_result->row();

    if($row){
    return [$row->kitchen_id,$row->kitchen_name];
    }else{
        return ['',''];
    }
}
function getTodayPromoDetailsByOutletId($outlet_id) {
    $CI = & get_instance();
    $start_date = date("Y-m-d");
 
    $CI->db->select('*');
    $CI->db->from('tbl_promotions');
    if ($start_date != '') {
        $CI->db->where('start_date<=', $start_date);
        $CI->db->where('end_date>=', $start_date);
    }
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $result = $query_result->result();
    return($result);
}
function convertPlanJson($json){
    $json = json_decode($json);
    return $json;
}
function getOnlineSelfOrderReceivingId($id) {
    $CI = & get_instance();
    $data = $CI->db->query("SELECT * FROM tbl_outlets where `id`='$id'")->row();
    return isset($data->online_self_order_receiving_id) && $data->online_self_order_receiving_id?$data->online_self_order_receiving_id:'';
}
function getOnlineOrderReceivingId($id) {
    $CI = & get_instance();
    $data = $CI->db->query("SELECT * FROM tbl_outlets where `id`='$id'")->row();
    return isset($data->online_order_receiving_id) && $data->online_order_receiving_id?$data->online_order_receiving_id:'';
}
function getReservationOrderReceivingId($id) {
    $CI = & get_instance();
    $data = $CI->db->query("SELECT * FROM tbl_outlets where `id`='$id'")->row();
    return isset($data->reservation_order_receiving_id) && $data->reservation_order_receiving_id?$data->reservation_order_receiving_id:'';
}

function getTotalFoodMenu($category_id) {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $CI = & get_instance();
    $CI->db->select('count(id) as total_item');
    $CI->db->from('tbl_food_menus');
    $CI->db->where('category_id', $category_id);
    $CI->db->where('company_id', $company_id);
    $CI->db->where('parent_id', '0');
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $row = $query_result->row();
    if($row){
        return $row->total_item;
    }else{
        return 0;
    }
}
/**
 * get White Label for setting info
 * @access public
 * @return object
 * @param no
 */
function getWhiteLabel() {
    $company_info = getMainCompany();
    $getWhiteLabel = json_decode(isset($company_info->white_label) && $company_info->white_label?$company_info->white_label:'');
    return $getWhiteLabel;
}
/**
 * return food menu id for outlet
 * @access public
 * @return string
 * @param no
 */
function getFMIds($outlet_id) {
    $CI = & get_instance();
    $getCompanyInfo = getCompanyInfo();
    $company_id = $CI->session->userdata('company_id');
    $language_manifesto = $getCompanyInfo->language_manifesto;
    if(str_rot13($language_manifesto)=="fgjgldkfg"){
        $CI->db->select("id");
        $CI->db->from("tbl_food_menus");
        $CI->db->where("company_id",$company_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->result();
        $main_arr = '';
        if(isset($result) && $result){
            foreach ($result as $keys=>$value){
                $main_arr.=$value->id;
                if($keys < (sizeof($result)) -1){
                    $main_arr.=",";
                }
            }
        }
        return $main_arr;
    }else{
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id",$outlet_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->row();
    
        if(isset($result)&& $result){
            return $result->food_menus;
        }else{
            $CI->db->select("id");
            $CI->db->from("tbl_food_menus");
            $CI->db->where("company_id",$company_id);
            $CI->db->where("del_status","Live");
            $result = $CI->db->get()->result();
            $main_arr = '';
            if(isset($result) && $result){
                foreach ($result as $keys=>$value){
                    $main_arr.=$value->id;
                    if($keys < (sizeof($result)) -1){
                        $main_arr.=",";
                    }
                }
            }
            return $main_arr;
        }
    }

}
function getApiFMIds($outlet_id,$company_id) {
    $CI = & get_instance();
    $getCompanyInfo = getCompanyInfo(); 
    $language_manifesto = $getCompanyInfo->language_manifesto;
    if(str_rot13($language_manifesto)=="fgjgldkfg"){
        $CI->db->select("id");
        $CI->db->from("tbl_food_menus");
        $CI->db->where("company_id",$company_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->result();
        $main_arr = '';
        if(isset($result) && $result){
            foreach ($result as $keys=>$value){
                $main_arr.=$value->id;
                if($keys < (sizeof($result)) -1){
                    $main_arr.=",";
                }
            }
        }
        return $main_arr;
    }else{
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id",$outlet_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->row();
    
        if(isset($result)&& $result){
            return $result->food_menus;
        }else{
            $CI->db->select("id");
            $CI->db->from("tbl_food_menus");
            $CI->db->where("company_id",$company_id);
            $CI->db->where("del_status","Live");
            $result = $CI->db->get()->result();
            $main_arr = '';
            if(isset($result) && $result){
                foreach ($result as $keys=>$value){
                    $main_arr.=$value->id;
                    if($keys < (sizeof($result)) -1){
                        $main_arr.=",";
                    }
                }
            }
            return $main_arr;
        }
    }

}
/**
 * return food menu id for outlet
 * @access public
 * @return string
 * @param no
 */
function getFMIdsOutlet($outlet_id) {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $language_manifesto = $CI->session->userdata('language_manifesto');
    if(str_rot13($language_manifesto)=="fgjgldkfg"){
        $CI->db->select("id");
        $CI->db->from("tbl_food_menus");
        $CI->db->where("company_id",$company_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->result();
        $main_arr = '';
        if(isset($result) && $result){
            foreach ($result as $keys=>$value){
                $main_arr.=$value->id;
                if($keys < (sizeof($result)) -1){
                    $main_arr.=",";
                }
            }
        }
        return $main_arr;
    }else{
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id",$outlet_id);
        $CI->db->where("del_status","Live");
        $result = $CI->db->get()->row();
      
        if(isset($result)&& $result){
            return $result->food_menus;
        }else{
            $CI->db->select("id");
            $CI->db->from("tbl_food_menus");
            $CI->db->where("company_id",$company_id);
            $CI->db->where("del_status","Live");
            $result = $CI->db->get()->result();
            $main_arr = '';
            if(isset($result) && $result){
                foreach ($result as $keys=>$value){
                    $main_arr.=$value->id;
                    if($keys < (sizeof($result)) -1){
                        $main_arr.=",";
                    }
                }
            }
            return $main_arr;
        }
    }

}
function updatePrice($company_id,$item_id,$price,$sale_price_take_away,$delivery_prices,$sale_price_delivery){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_outlets WHERE company_id='$company_id' AND del_status='Live'")->result();
    if(isset($outlet_info1) && $outlet_info1){
        foreach ($outlet_info1 as $outlet_key=>$outlet){
            $food_menus = ($outlet->food_menus);
            $foods_prices = json_decode($outlet->food_menu_prices);
            $delivery_price = json_decode($outlet->delivery_price);

            $data_price_array = array();
            $data_delivery_price_array = array();
            $available_counter = 1;
            foreach ($foods_prices as $key=>$value){
                $key_id = explode("tmp",$key);
                if(($key_id[1]==$item_id)){
                    $data_price_array[$key] = $price."||".$sale_price_take_away."||".$sale_price_delivery;
                    $available_counter++;
                }else{
                    $data_price_array[$key] = $value;
                }
            }
            if($available_counter==1){
                $index_name = "tmp".$item_id;
                $data_price_array[$index_name] = $price."||".$sale_price_take_away."||".$sale_price_delivery;
            }


            $available_counter = 1;
            foreach ($delivery_price as $key=>$value){
                $key_id = explode("index_",$key);
                if(($key_id[1]==$item_id)){
                    $data_delivery_price_array[$key] = $delivery_prices;
                    $available_counter++;
                }else{
                    $data_delivery_price_array[$key] = $value;
                }
            }
            if($available_counter==1){
                $food_menus = "$food_menus".",".$item_id;
                $index_name = "index_".$item_id;
                $data_delivery_price_array[$index_name] = $delivery_prices;
            }
            $data_u = array();
            $data_u['food_menu_prices'] = json_encode($data_price_array);
            $data_u['delivery_price'] = json_encode($data_delivery_price_array);
            $data_u['food_menus'] = $food_menus;
            $CI->db->where('id', $outlet->id);
            $CI->db->update("tbl_outlets", $data_u);
        }
    }else{
        return "";
    }
}
/**
 * is LMni
 * @access public
 * @return boolean
 * @param no
 */
function isLMni() {
    $data_c = getLanguageManifesto();
    if(isFoodCourt()){
        $CI = & get_instance();
        $company_id = $CI->session->userdata('company_id');
        if($company_id==1){
            return true;
        }
    }
    if(str_rot13($data_c[0])=="eriutoeri"){
        return true;
    }else{
        return false;
    }
}
/**
 * get FM Id Dashboard
 * @access public
 * @return string
 * @param int
 */
function getFMIdDashboard($outlet_id) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("tbl_outlets");
    $CI->db->where("id",$outlet_id);
    $CI->db->where("del_status","Live");
    $result = $CI->db->get()->row();
    return $result->food_menus;
}
/**
 * user Name
 * @access public
 * @return string
 * @param int
 */
function userName($user_id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_users where `id`='$user_id'")->row();
    return isset($user_information->full_name) && $user_information->full_name?$user_information->full_name:'';
}
function getCounterName($counter_id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_counters where `id`='$counter_id'")->row();
    return isset($user_information->name) && $user_information->name?$user_information->name:'';
}
function getExpenseItemName($user_id) {
    $CI = & get_instance();
    $user_information = $CI->db->query("SELECT * FROM tbl_expense_items where `id`='$user_id'")->row();
    return isset($user_information->name) && $user_information->name?$user_information->name:'';
}
/**
 * get Customer Name
 * @access public
 * @return string
 * @param int
 */
function getCustomerName($customer_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
    return isset($information->name) && $information->name?$information->name:'';
}
function getCustomerAddress($customer_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
    return isset($information->address) && $information->address?$information->address:'';
}
function getCustomerGST($customer_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_customers where `id`='$customer_id'")->row();
    return isset($information->gst_number) && $information->gst_number?$information->gst_number:'';
}
function getCustomerTaxNumber($customer_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT tax_number FROM tbl_customers where `id`='$customer_id'")->row();
    return isset($information->tax_number) && $information->tax_number?$information->tax_number:'';
}
/**
 * get Order Type
 * @access public
 * @return string
 * @param int
 */
function getOrderType($order_type_id) {
    if ($order_type_id == 1) {
        return "Dine In";
    }elseif ($order_type_id == 2) {
        return "Take Away";
    }elseif ($order_type_id == 3) {
        return "Delivery";
    }
}
function getAssetsPath($str='') {
    return str_replace('www.','',str_replace('https://','',str_replace('','',str_replace('http://','',$str))));
}
/**
 * get Table Name
 * @access public
 * @return string
 * @param int
 */
function getTableName($table_id) {
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_tables where `id`='$table_id'")->row();
    return isset($information->name) && $information->name?$information->name:'';
}
/**
 * get area Name
 * @access public
 * @return string
 * @param int
 */
function getAreaName($id='') {
    if($id==''){
        return $id;
    }
    $CI = & get_instance();
    $information = $CI->db->query("SELECT * FROM tbl_areas where `id`='$id'")->row();
    return isset($information->area_name) && $information->area_name?$information->area_name:'';
}
/**
 * get Consumption ID
 * @access public
 * @return string
 * @param int
 */
function getConsumptionID($id) {
    $CI = & get_instance();
    $selectRow = $CI->db->query("SELECT * FROM tbl_sale_consumptions where `sale_id`='$id'")->row();
    if (!empty($selectRow)) {
        return $selectRow->id;
    } else {
        return '0';
    }
}
/**
 * vat Name
 * @access public
 * @return string
 * @param int
 */
function vatName($id){
    $CI = & get_instance();
    $expense_item_information = $CI->db->query("SELECT * FROM tbl_vats where `id`='$id'")->row();

    return $expense_item_information->name;
}
/**
 * expense Item Name
 * @access public
 * @return string
 * @param int
 */
function expenseItemName($id) {
    $CI = & get_instance();
    $expense_item_information = $CI->db->query("SELECT * FROM tbl_expense_items where `id`='$id'")->row();
    return $expense_item_information->name;
}
/**
 * employee Name
 * @access public
 * @return string
 * @param int
 */
function employeeName($id) {
    $CI = & get_instance();
    $employee_information = $CI->db->query("SELECT * FROM tbl_users where `id`='$id'")->row();
    if (!empty($employee_information)) {
        return $employee_information->full_name;
    }else{
        return "N/A";
    }
}
/**
 * category Name
 * @access public
 * @return string
 * @param int
 */
function categoryName($category_id) {
    $CI = & get_instance();
    $category_information = $CI->db->query("SELECT * FROM tbl_ingredient_categories where `id`='$category_id'")->row();
    return $category_information->category_name;
}
/**
 * food Menu Category Name
 * @access public
 * @return string
 * @param int
 */
function foodMenucategoryName($category_id) {
    $CI = & get_instance();
    $category_information = $CI->db->query("SELECT * FROM tbl_food_menu_categories where `id`='$category_id'")->row();
    return $category_information->category_name;
}
/**
 * food Menu Name
 * @access public
 * @return string
 * @param int
 */
function foodMenuName($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return $food_information->name;
}
function foodMenuRow($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return $food_information;
}
function getVariationName($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return isset($food_information->name) && $food_information->name?$food_information->name:'';
}
/**
 * food Menu Name Code
 * @access public
 * @return string
 * @param int
 */
function foodMenuNameCode($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return "(" . $food_information->code . ")";
}
/**
 * unitName
 * @access public
 * @return object
 * @param int
 */
function unitName($unit_id) {
    $CI = & get_instance();
    $unit_information = $CI->db->query("SELECT * FROM tbl_units where `id`='$unit_id'")->row();
    if (!empty($unit_information)) {
        return $unit_information->unit_name;
    } else {
        return '';
    }
}
/**
 * totalIngredients
 * @access public
 * @return int
 * @param int
 */
function totalIngredients($food_menu_id) {
    $CI = & get_instance();
    $total_count = $CI->db->query("SELECT * FROM tbl_food_menus_ingredients where `food_menu_id`='$food_menu_id'")->num_rows();
    return $total_count;
}
/**
 * food Menu Ingredients
 * @access public
 * @return object
 * @param int
 */
function foodMenuIngredients($food_menu_id) {
    $CI = & get_instance();
    $food_menu_ingredients = $CI->db->query("SELECT * FROM tbl_food_menus_ingredients where `food_menu_id`='$food_menu_id'")->result();
    return $food_menu_ingredients;
}
function getDetailsCombo($food_menu_id) {
    $CI = & get_instance();
    $food_menu_ingredients = $CI->db->query("SELECT * FROM tbl_combo_food_menus where `food_menu_id`='$food_menu_id'")->result();
    $txt = '';
    foreach ($food_menu_ingredients as $ky=>$value){
        $txt.=$value->name.'(<i class="combo_class" data-qty="'.$value->quantity.'">Qty:'.$value->quantity.'</i>)';
        if($ky < (sizeof($food_menu_ingredients) -1)){
            $txt.=", ";
        }
    }
   return $txt;
}
function getPlanTextFromHtml($content){
    return (strip_tags($content));
}
/**
 * modifier Ingredients
 * @access public
 * @return object
 * @param int
 */
function modifierIngredients($modifier_id) {
    $CI = & get_instance();
    $food_menu_ingredients = $CI->db->query("SELECT * FROM tbl_modifier_ingredients where `modifier_id`='$modifier_id'")->result();
    return $food_menu_ingredients;
}
/**
 * get Payment Name
 * @access public
 * @return string
 * @param int
 */
function getPaymentName($id,$online_payment_details) {
    $CI = & get_instance();
    $getPaymentName = $CI->db->query("SELECT * FROM tbl_payment_methods where `id`='$id'")->row();
    if(isset($getPaymentName->name) && $getPaymentName->name){
        return $getPaymentName->name;
    }else{
        $online_payment_details = json_decode($online_payment_details);
        if(isset($online_payment_details->payment_type) && $online_payment_details->payment_type){
            return "&nbsp;".$online_payment_details->payment_type.", Txn ID: ".$online_payment_details->txn_id;

        }else{
            return "";
        }    
    }

}
function salePaymentDetails($id,$outlet_id) {
    $CI = & get_instance();
    $CI->db->select('tbl_payment_methods.*,tbl_payment_methods.name as payment_name,multi_currency,usage_point,amount,currency_type,multi_currency_rate');
    $CI->db->from('tbl_sale_payments');
    $CI->db->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sale_payments.payment_id', 'left');
    $CI->db->where('tbl_sale_payments.outlet_id', $outlet_id);
    $CI->db->where('tbl_sale_payments.sale_id', $id);
    $CI->db->where('tbl_sale_payments.del_status', 'Live');
    $query_result = $CI->db->get();
    $results = $query_result->result();
    return $results;
}

function timeElapsed($start_time) {
    // Convert start time to DateTime object
    $start = new DateTime($start_time);

    // Get current time
    $now = new DateTime();

    // Calculate the difference
    $interval = $start->diff($now);

    // Get the total number of minutes elapsed
    $minutes = $interval->days * 24 * 60;
    $minutes += $interval->h * 60;
    $minutes += $interval->i;

    return $minutes." minutes ago";
}

function getPaymentInfo($sale_id,$payment_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_sale_payments'); 
    $CI->db->where('payment_id', $payment_id);
    $CI->db->where('sale_id', $sale_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $results = $query_result->row();
     if($results){
        return true;
     }else{
        return false;
     }
}

/**
 * get Alert Count
 * @access public
 * @return string
 * @param int
 */
function getAlertCount() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $outlet_id = $CI->session->userdata('outlet_id');
    $where = '';
    $getFMIds = getFMIds($outlet_id);
    $result = $CI->db->query("SELECT ingr_tbl.*,i.id as food_menu_id,ingr_cat_tbl.category_name,ingr_unit_tbl.unit_name,ingr_unit_tbl2.unit_name as unit_name2, (select SUM(quantity_amount) from tbl_purchase_ingredients where ingredient_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
(select SUM(consumption) from tbl_sale_consumptions_of_menus where ingredient_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_consumption,
(select SUM(consumption) from tbl_sale_consumptions_of_modifiers_of_menus where ingredient_id=i.id AND outlet_id=$outlet_id AND  del_status='Live') total_modifiers_consumption,
(select SUM(waste_amount) from tbl_waste_ingredients  where ingredient_id=i.id AND outlet_id=$outlet_id AND tbl_waste_ingredients.del_status='Live') total_waste,
(select SUM(consumption_amount) from tbl_inventory_adjustment_ingredients  where ingredient_id=i.id AND outlet_id=$outlet_id AND  tbl_inventory_adjustment_ingredients.del_status='Live' AND  tbl_inventory_adjustment_ingredients.consumption_status='Plus') total_consumption_plus,
(select SUM(consumption_amount) from tbl_inventory_adjustment_ingredients  where ingredient_id=i.id AND outlet_id=$outlet_id AND  tbl_inventory_adjustment_ingredients.del_status='Live' AND  tbl_inventory_adjustment_ingredients.consumption_status='Minus') total_consumption_minus,
(select SUM(quantity_amount) from tbl_production_ingredients  where ingredient_id=i.id AND outlet_id=$outlet_id AND  tbl_production_ingredients.del_status='Live' AND tbl_production_ingredients.status=1) total_production,
(select SUM(quantity_amount) from tbl_transfer_ingredients  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_ingredients.del_status='Live' AND  tbl_transfer_ingredients.status=1 AND tbl_transfer_ingredients.transfer_type=1) total_transfer_plus,
(select SUM(quantity_amount) from tbl_transfer_ingredients  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_ingredients.del_status='Live' AND (tbl_transfer_ingredients.status=1) AND tbl_transfer_ingredients.transfer_type=1) total_transfer_minus,
(select SUM(quantity_amount) from tbl_transfer_received_ingredients  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_received_ingredients.del_status='Live' AND  tbl_transfer_received_ingredients.status=1) total_transfer_plus_2,
(select SUM(quantity_amount) from tbl_transfer_received_ingredients  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_received_ingredients.del_status='Live' AND (tbl_transfer_received_ingredients.status=1)) total_transfer_minus_2
FROM tbl_ingredients i  LEFT JOIN (select * from tbl_ingredients where del_status='Live') ingr_tbl ON ingr_tbl.id = i.id LEFT JOIN (select * from tbl_ingredient_categories where del_status='Live') ingr_cat_tbl ON ingr_cat_tbl.id = ingr_tbl.category_id LEFT JOIN (select * from tbl_units where del_status='Live') ingr_unit_tbl ON ingr_unit_tbl.id = ingr_tbl.unit_id  LEFT JOIN (select * from tbl_units where del_status='Live') ingr_unit_tbl2 ON ingr_unit_tbl2.id = ingr_tbl.purchase_unit_id WHERE  i.company_id= '$company_id' AND i.del_status='Live' $where  GROUP BY i.id")->result();
    $alertCount = 0;
    foreach ($result as $value) {
        $conversion_rate = (int)$value->conversion_rate?$value->conversion_rate:1;
        $totalStock = ($value->total_purchase*$value->conversion_rate)  - $value->total_consumption - $value->total_modifiers_consumption - $value->total_waste + $value->total_consumption_plus - $value->total_consumption_minus + ($value->total_transfer_plus*$value->conversion_rate) - ($value->total_transfer_minus*$value->conversion_rate)  +  ($value->total_transfer_plus_2*$value->conversion_rate) -  ($value->total_transfer_minus_2*$value->conversion_rate)+ ($value->total_production*$value->conversion_rate);
        if ($totalStock <= $value->alert_quantity) {
            if($value->id):
                $alertCount++;
            endif;
        }
    }
    return $alertCount;
}

function getRandomCode($length = 11) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmtPublic($id,$amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfoById($id);
    $precision = $getCompanyInfo->precision;
    $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    return $str_amount;
}
function getAmtPPublic($id,$amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfoById($id);
    $precision = $getCompanyInfo->precision;
    $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    return $str_amount;
}
function getSalePriceDetails($json_data) {
    $plan_data_arr = (array)json_decode($json_data);
    $return_txt = '';
    $key_custom = 0;
    foreach ($plan_data_arr as $key=>$value){
        $return_txt.=$key."||".$value;
        if($key_custom < (sizeof($plan_data_arr) -1)){
            $return_txt.="|||";
        }
        $key_custom++;
    }
    return $return_txt;
}
/**
 * food Menu Name
 * @access public
 * @return string
 * @param int
 */
function getParentNameTemp($id) {
    $CI = & get_instance();
    $food_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return (isset($food_information->name) && $food_information->name?getPlanText($food_information->name)." ":'');
}
function generateCode($number) {
    $food_menu_code = str_pad($number, 2, '0', STR_PAD_LEFT);
    return $food_menu_code;

}
/**
 * get Alert Count
 * @access public
 * @return string
 * @param int
 */
function getCurrentStockById($getFMIds) {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $outlet_id = $CI->session->userdata('outlet_id');
    $where = '';
    $result = $this->db->query("SELECT ingr_tbl.*,i.food_menu_id,ingr_cat_tbl.category_name,ingr_unit_tbl.unit_name, (select SUM(quantity_amount) from tbl_purchase_ingredients where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
        (select SUM(consumption) from tbl_sale_consumptions_of_menus where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND del_status='Live') total_consumption,
        (select SUM(consumption) from tbl_sale_consumptions_of_modifiers_of_menus where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND  del_status='Live') total_modifiers_consumption,
        (select SUM(waste_amount) from tbl_waste_ingredients  where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND tbl_waste_ingredients.del_status='Live') total_waste,
        (select SUM(consumption_amount) from tbl_inventory_adjustment_ingredients  where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND  tbl_inventory_adjustment_ingredients.del_status='Live' AND  tbl_inventory_adjustment_ingredients.consumption_status='Plus') total_consumption_plus,
        (select SUM(consumption_amount) from tbl_inventory_adjustment_ingredients  where ingredient_id=i.ingredient_id AND outlet_id=$outlet_id AND  tbl_inventory_adjustment_ingredients.del_status='Live' AND  tbl_inventory_adjustment_ingredients.consumption_status='Minus') total_consumption_minus,
        (select SUM(quantity_amount) from tbl_transfer_ingredients  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_ingredients.del_status='Live' AND  tbl_transfer_ingredients.status=1 AND tbl_transfer_ingredients.transfer_type=1) total_transfer_plus,
        (select SUM(quantity_amount) from tbl_transfer_ingredients  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_ingredients.del_status='Live' AND (tbl_transfer_ingredients.status=1) AND tbl_transfer_ingredients.transfer_type=1) total_transfer_minus,
(select SUM(quantity_amount) from tbl_transfer_received_ingredients  where ingredient_id=i.id AND to_outlet_id=$outlet_id AND  tbl_transfer_received_ingredients.del_status='Live' AND  tbl_transfer_received_ingredients.status=1) total_transfer_plus_2,
(select SUM(quantity_amount) from tbl_transfer_received_ingredients  where ingredient_id=i.id AND from_outlet_id=$outlet_id AND  tbl_transfer_received_ingredients.del_status='Live' AND (tbl_transfer_received_ingredients.status=1)) total_transfer_minus_2

        FROM tbl_food_menus_ingredients i  LEFT JOIN (select * from tbl_ingredients where del_status='Live') ingr_tbl ON ingr_tbl.id = i.ingredient_id LEFT JOIN (select * from tbl_ingredient_categories where del_status='Live') ingr_cat_tbl ON ingr_cat_tbl.id = ingr_tbl.category_id LEFT JOIN (select * from tbl_units where del_status='Live') ingr_unit_tbl ON ingr_unit_tbl.id = ingr_tbl.unit_id WHERE FIND_IN_SET(`food_menu_id`, '$getFMIds') AND i.company_id= '$company_id' AND i.del_status='Live' $where  GROUP BY i.ingredient_id")->row();
    return $result;

    $alertCount = 0;
    $totalStock = $result->total_purchase - $result->total_consumption - $result->total_modifiers_consumption - $result->total_waste + $result->total_consumption_plus  + $result->total_transfer_plus  - $result->total_transfer_minus - $result->total_consumption_minus + $result->total_transfer_plus  - $result->total_transfer_minus_2;
    return $totalStock;
}
/**
 * collect GST
 * @access public
 * @return string
 * @param int
 */
function collectGST(){
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    if($company_id){
        $outlet_info = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id'")->row();
        return isset($outlet_info->tax_is_gst) && $outlet_info->tax_is_gst?$outlet_info->tax_is_gst:'No';
    }else{
        return "No";
    }
}
/**
 * collect GST
 * @access public
 * @return string
 * @param int
 */
function setReadonly($type,$tax){
    $CI = & get_instance();
    $return_value = "";
    //iff type is 1 then system will return readonly;
    if($type==1){
        $tax_is_gst = $CI->session->userdata('tax_is_gst');
        if($tax_is_gst=="Yes"){
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "readonly";
            }
        }else{
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "readonly";
            }
        }
    }else if($type==2){
        $tax_is_gst = $CI->session->userdata('tax_is_gst');
        if($tax_is_gst=="Yes"){
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "none";
            }
        }else{
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "none";
            }
        }
    }else if($type==3){
        $tax_is_gst = $CI->session->userdata('tax_is_gst');
        if($tax_is_gst=="Yes"){
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "gst_div";
            }
        }else{
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "gst_div";
            }
        }
    }else if($type==4){
        $tax_is_gst = $CI->session->userdata('tax_is_gst');
        if($tax_is_gst=="Yes"){
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "1";
            }
        }else{
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){
                $return_value = "1";
            }
        }
    }else if($type==5){
        $tax_is_gst = $CI->session->userdata('tax_is_gst');
        if($tax_is_gst=="Yes"){
            $return_value = "1";
        }else{
            if($tax=="CGST" || $tax=="SGST" || $tax=="IGST"){

            }else{
                $return_value = "1";
            }
        }
    }
    return $return_value;
}/**
 * total tax
 * @access public
 * @return string
 * @param int
 */
function getTaxAmount($sale_price,$tax){
    $CI = & get_instance();
    $decode_tax = json_decode($tax);
    $total_return_amount = 0;
    foreach ($decode_tax as $key=>$value){
        if(isset($decode_tax[$key]->tax_field_percentage) && $decode_tax[$key]->tax_field_percentage && $decode_tax[$key]->tax_field_percentage!="0.00"){
            $total_return_amount+=($sale_price*$decode_tax[$key]->tax_field_percentage)/100;
        }

    }
return $total_return_amount;

}
/**
 * get Ingredient Name By Id
 * @access public
 * @return string
 * @param int
 */
function getIngredientNameById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->name;
    } else {
        return '';
    }
}
/**
 * get getOutletIdByArea By Id
 * @access public
 * @return string
 * @param int
 */
function getOutletIdByArea($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_areas where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->outlet_id;
    } else {
        return '0';
    }
}
/**
 * get Ingredient
 * @access public
 * @return string
 * @param int
 */
function getIngredient($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information;
    } else {
        return '';
    }
}
/**
 * get Modifier Name By Id
 * @access public
 * @return string
 * @param int
 */
function getModifierNameById($id) {
    $CI = & get_instance();
    $m_information = $CI->db->query("SELECT * FROM tbl_modifiers where `id`='$id'")->row();
    if (!empty($m_information)) {
        return $m_information->name;
    } else {
        return '';
    }
}
function getModifierDetails($id) {
    $CI = & get_instance();
    $m_information = $CI->db->query("SELECT * FROM tbl_modifiers where `id`='$id'")->row();
    if (!empty($m_information)) {
        return $m_information;
    } else {
        return '';
    }
}   
function getFoodMenuNameById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return getParentNameTemp($ig_information->parent_id).$ig_information->name;
    } else {
        return '';
    }
}
function getAlternativeNameById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    if (!empty($ig_information->alternative_name)) {
        return "(".$ig_information->alternative_name.")";
    } else {
        return '';
    }
}
function getFoodMenuNameCodeById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return getPlanText($ig_information->name)."(".$ig_information->code.")";
    } else {
        return '';
    }
}
/**
 * get Ingredient Code By Id
 * @access public
 * @return string
 * @param int
 */
function getIngredientCodeById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    return $ig_information->code;
}
/**
 * get Ingredient Code By Id
 * @access public
 * @return string
 * @param int
 */
function getFoodMenuCodeById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    return $ig_information->code;
}
/**
 * get Ingredient Code By Id
 * @access public
 * @return string
 * @param int
 */
function getFoodMenuForMenuPage() {
    $CI = & get_instance();
    $online_selected_outlet = $CI->session->userdata('online_selected_outlet');
    
    $outlet_details = getOutletById($online_selected_outlet);
    if($outlet_details){
        $parts = explode(',', $outlet_details->available_online_foods);
        $filtered_parts = [];
        foreach ($parts as $part) {
            if (strpos($part, '1_') === 0) { // Only keep values starting with "1_"
                $filtered_parts[] = preg_replace('/^\d+_/', '', $part); // Remove the first number and "_"
            }
        }
        $modified_string = implode(',', $filtered_parts);
        $ig_information = $CI->db->query("SELECT `id`, `name`, `code`, `category_id`, `description`, `sale_price`, `photo`,parent_id,product_type,alternative_name, `tax_information`, `tax_string` FROM tbl_food_menus where FIND_IN_SET(`id`, '$modified_string') AND `del_status`='Live'")->result();
        return $ig_information;
    }else{
        return [];
    }
}
function exploreItemForAdminPanel($outlet_id) {
    $CI = & get_instance();
    $outlet_details = getOutletById($outlet_id);
    if($outlet_details){
        $parts = explode(',', $outlet_details->available_online_foods);
        $filtered_parts = [];
        foreach ($parts as $part) {
            if (strpos($part, '1_') === 0) { // Only keep values starting with "1_"
                $filtered_parts[] = preg_replace('/^\d+_/', '', $part); // Remove the first number and "_"
            }
        }
        $modified_string = implode(',', $filtered_parts);
        $ig_information = $CI->db->query("SELECT `id`, `name`, `code`, `category_id`, `description`, `sale_price`, `photo`,parent_id,product_type,alternative_name, `tax_information`, `tax_string` FROM tbl_food_menus where FIND_IN_SET(`id`, '$modified_string') AND `del_status`='Live'")->result();
        return $ig_information;
    }else{
        return false;
    }
}
function getFoodMenuCategory() { 
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menu_categories WHERE `del_status` = 'Live' AND `company_id`='$company_id'")->result();
    return $ig_information;
}
function getModifiersForMenuPage() {
    $company_id = 1;
    $CI = & get_instance();

    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $ig_information = $CI->db->query("SELECT * FROM tbl_modifiers where  `del_status`='Live' AND `company_id`='$company_id'")->result();
    return $ig_information;
}
function getFoodMenuCateCodeById($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menu_categories where `id`='$id'")->row();
    return $ig_information->category_name;
}

function countFoodMenuCategory($id){
    $CI = & get_instance();

    $online_selected_outlet = $CI->session->userdata('online_selected_outlet');
    $outlet_details = getOutletById($online_selected_outlet);
    if($outlet_details){
        $parts = explode(',', $outlet_details->available_online_foods);
        $filtered_parts = [];
        foreach ($parts as $part) {
            if (strpos($part, '1_') === 0) { // Only keep values starting with "1_"
                $filtered_parts[] = preg_replace('/^\d+_/', '', $part); // Remove the first number and "_"
            }
        }
        
        $modified_string = implode(',', $filtered_parts);
    $ig_information = $CI->db->query("SELECT COUNT(*) AS total FROM tbl_food_menus where FIND_IN_SET(`id`, '$modified_string') AND  `category_id`='$id' AND `del_status` = 'Live'")->row();
    return $ig_information->total;
    }else{
        return false;
    }
}


/**
 * Get Rating By Food ID
 */

function getRating($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT AVG(rating) as rating FROM tbl_food_menu_ratings where `food_menu_id`='$id'")->row();
    return number_format($ig_information->rating, 2) ?? 0;
}


/**
 * Get Order History By Customer
 */

function getOrderHistory($id, $limit, $offset){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT self_order_content, self_order_status,sale_no,date_time,total_payable,is_invoice FROM tbl_kitchen_sales where customer_id='$id' AND del_status='Live' order by id DESC")->result();
    $ig_information_sales = $CI->db->query("SELECT self_order_content, self_order_status,sale_no,date_time,total_payable,is_invoice FROM tbl_sales where customer_id='$id' AND del_status='Live' order by id DESC")->result();
    
    // Merge the results
    $combined_results = array_merge($ig_information, $ig_information_sales);
    
    // Apply LIMIT and OFFSET using array_slice
    $final_results = array_slice($combined_results, $offset, $limit);
    // Concatenate the results
    $combined_results = array_merge($ig_information, $ig_information_sales);
    return $final_results;
}

/**
 * Get Total Order
 */
function getTotalOrders($customerId) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT COUNT(*) as total FROM tbl_kitchen_sales where `customer_id`='$customerId' AND del_status='Live'")->row();
    return $ig_information->total;
}

/**
 * Order Details
 */

function getOrderDetails($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales where `sale_no`='$id' AND del_status='Live'")->row();
    return $ig_information;
}
function getOrderDetails1($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales where `id`='$id' AND del_status='Live'")->row();
    return $ig_information;
}
function getOrderDetailsSaleTable($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_sales where `sale_no`='$id' AND del_status='Live'")->row();
    return $ig_information;
}
/**
 * Get Order Items
 */

function getOrderItems($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_kitchen_sales_details where `sales_id`='$id' AND del_status='Live'")->result();
    return $ig_information;
}
function getOrderItemsSaleTable($id){
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_sales_details where `sales_id`='$id' AND del_status='Live'")->result();
    return $ig_information;
}


/**
 * get Supplier Name By Id
 * @access public
 * @return string
 * @param int
 */
function getSupplierNameById($id) {
    $CI = & get_instance();
    $supplier_information = $CI->db->query("SELECT * FROM tbl_suppliers where `id`='$id'")->row();
    return $supplier_information->name;
}
/**
 * get Supplier Name By Id
 * @access public
 * @return string
 * @param int
 */
function getSupplier($id) {
    $CI = & get_instance();
    $supplier_information = $CI->db->query("SELECT * FROM tbl_suppliers where `id`='$id'")->row();
    return $supplier_information;
}
/**
 * get Unit Id By Ig Id
 * @access public
 * @return string
 * @param int
 */
function getUnitIdByIgId($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->unit_id;
    } else {
        return '';
    }
}
function getPurchaseUnitIdByIgId($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->purchase_unit_id;
    } else {
        return '';
    }
}
/**
 * get Last Purchase Amount
 * @access public
 * @return float
 * @param int
 */
function getLastPurchaseAmount($id) {
    $CI = & get_instance();
    $ings = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    $purchase_ingredients = $CI->db->query("SELECT * FROM tbl_purchase_ingredients where `ingredient_id`='$id' ORDER BY id DESC")->row();
    if (!empty($purchase_ingredients)) {
        $returnPrice = $purchase_ingredients->unit_price;
    } else {
        $returnPrice = isset($ings->purchase_price) && $ings->purchase_price?$ings->purchase_price:0;
    }
    return $returnPrice;
}
/**
 * get Purchase Ingredients
 * @access public
 * @return string
 * @param int
 */
function getPurchaseIngredients($id) {
    $CI = & get_instance();
    $purchase_ingredients = $CI->db->query("SELECT * FROM tbl_purchase_ingredients where `purchase_id`='$id'")->result();
    if (!empty($purchase_ingredients)) {
        $pur_ingr_all = "";
        $key = 1;
        $pur_ingr_all .= "<b>SN-Ingredient-Qty/Amount-Unit Price-Total</b><br>";
        foreach ($purchase_ingredients as $value) {
            $pur_ingr_all .= $key ."-". getIngredientNameById($value->ingredient_id)."-".$value->quantity_amount.unitName(getPurchaseUnitIdByIgId($value->ingredient_id)) ."-". $value->unit_price ."-". $value->total."<br>";
            $key++;
        }
        return $pur_ingr_all;
    }else{
        return "Not found!";
    }
}
/**
 * get Last Purchase Price
 * @access public
 * @return float
 * @param int
 */
function getLastPurchasePrice($ingredient_id) {
    $CI = & get_instance();
    $purchase_info = $CI->db->query("SELECT *
        FROM tbl_purchase_ingredients
        WHERE ingredient_id = $ingredient_id
        ORDER BY id DESC
        LIMIT 1")->row();
    if (!empty($purchase_info)) {
        return $purchase_info->unit_price;
    } else {
        $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$ingredient_id'")->row();
        return $ig_information->purchase_price;
    }
}
/**
 * ingredient Count
 * @access public
 * @return int
 * @param int
 */
function ingredientCount($id) {
    $CI = & get_instance();
    $ingredient_count = $CI->db->query("SELECT COUNT(*) AS ingredient_count
        FROM tbl_waste_ingredients
        WHERE waste_id = $id")->row();
    return $ingredient_count->ingredient_count;
}
/**
 * ingredient Count Consumption
 * @access public
 * @return int
 * @param int
 */
function ingredientCountConsumption($id) {
    $CI = & get_instance();
    $ingredient_count = $CI->db->query("SELECT COUNT(*) AS ingredient_count
        FROM tbl_inventory_adjustment_ingredients
        WHERE inventory_adjustment_id = $id")->row();
    return $ingredient_count->ingredient_count;
}
/**
 * company Information
 * @access public
 * @return object
 * @param int
 */
function companyInformation($company_id) {
    $CI = & get_instance();
    $company_info = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id'")->row();
    return $company_info;
}
/**
 * find Date
 * @access public
 * @return string
 * @param int
 */
function findDate($date) {
    $format = null;
    if ($date == '') {
        return '';
    } else {
        $format = 'd/m/Y';
    }
    return date($format, strtotime($date));
}
/**
 * alter Date Format return
 * @access public
 * @return string
 * @param int
 */
function alterDateFormat($date) {
    $query1 = mysql_query("SELECT date_format FROM company_info where id='1'");
    $row = mysql_fetch_array($query1);
    $format = null;
    if ($date != "") {
        $dateSlug = explode('/', $date);
        //return $dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
        switch ($row['date_format']) {
            case 'dd/mm/yyyy':
                $format = $dateSlug[2] . '-' . $dateSlug[1] . '-' . $dateSlug[0];
                break;
            case 'mm/dd/yyyy':
                $format = $dateSlug[2] . '-' . $dateSlug[0] . '-' . $dateSlug[1];
                break;
            case 'yyyy/mm/dd':
                $format = $dateSlug[0] . '-' . $dateSlug[1] . '-' . $dateSlug[2];
                break;
            default:
                $format = $dateSlug[2] . '-' . $dateSlug[1] . '-' . $dateSlug[0];
                break;
        }
        return $format;
    } else {
        return "0000-00-00 00:00:00";
    }
}
/**
 * get Customer Due Receive
 * @access public
 * @return float
 * @param int
 */
function getCustomerDueReceive($customer_id){
    $CI = & get_instance();
    $information = $CI->db->query("SELECT sum(amount) as amount FROM tbl_customer_due_receives where `customer_id`='$customer_id' and del_status='Live'")->row();
    return $information->amount;
}
/**
 * getSupplierDuePayment
 * @access public
 * @return float
 * @param int
 */

function getOutletById($outlet_id){
    $CI = & get_instance();
    $outlet_info1 = $CI->db->query("SELECT * FROM tbl_outlets WHERE id='$outlet_id' AND del_status='Live'")->row();
    if($outlet_info1){
        return $outlet_info1;
    }else{
        return false;
    }
}
function getSupplierDuePayment($supplier_id){
    $CI = & get_instance();
    $information = $CI->db->query("SELECT sum(amount) as amount FROM tbl_supplier_payments where `supplier_id`='$supplier_id' and del_status='Live'")->row();
    return $information->amount;
}

function checkAvailableLang($lang){
    $dir = glob("application/language/*",GLOB_ONLYDIR);
    $return = false;
    foreach ($dir as $value):
        $separete = explode("language/",$value);
        if($separete[1]==$lang){
            $return = true;
        }
    endforeach;
    return $return;
}
/**
 * getSupplierDuePayment
 * @access public
 * @return float
 * @param int
 */
function is_mobile_access(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..
    return false;
}

/**
 * get plan name
 * @access public
 * @return string
 * @param int
 */
function getPlanName($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_pricing_plans where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->plan_name;
    } else {
        return '';
    }
}
function getPrinter($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_printers where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->title;
    } else {
        return '';
    }
}
function getLoyaltyPointByFoodMenu($id,$is_ignore='') {
    $CI = & get_instance();
    $is_loyalty_enable = $CI->session->userdata('is_loyalty_enable');
    if($is_loyalty_enable=="enable" && $is_ignore==''){
        $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return $ig_information->loyalty_point;
        } else {
            return 0;
        }
    }else{
        return 0;
    }

}
function getLoyaltyPointByFoodMenuAPI($company_id,$id,$is_ignore='') {
    $CI = & get_instance();
    $company = companyInformation($company_id);
    $is_loyalty_enable = $company->is_loyalty_enable;
    if($is_loyalty_enable=="enable" && $is_ignore==''){
        $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
        if (!empty($ig_information)) {
            return $ig_information->loyalty_point;
        } else {
            return 0;
        }
    }else{
        return 0;
    }

}
function getTotalLoyaltyPoint($id,$outlet_id) {
    $CI = & get_instance();
    $CI->db->select('sum(usage_point) as used_loyalty_point');
    $CI->db->from('tbl_sale_payments');
    $CI->db->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left');
    $CI->db->where('tbl_sales.outlet_id', $outlet_id);
    $CI->db->where('tbl_sales.customer_id', $id);
    $CI->db->where('tbl_sale_payments.payment_id', 5);
    $CI->db->where('tbl_sales.order_status', 3);
    $CI->db->where('tbl_sale_payments.del_status', 'Live');
    $query_result = $CI->db->get();
    $used_loyalty_point = $query_result->row();

    $CI->db->select('sum(loyalty_point_earn) as loyalty_point_earn');
    $CI->db->from('tbl_sales_details');
    $CI->db->join('tbl_sales', 'tbl_sales.id = tbl_sales_details.sales_id', 'left');
    $CI->db->where('tbl_sales_details.outlet_id', $outlet_id);
    $CI->db->where('tbl_sales.customer_id', $id);
    $CI->db->where('tbl_sales.order_status', 3);
    $CI->db->where('tbl_sales_details.del_status', 'Live');
    $query_result = $CI->db->get();
    $loyalty_point_earn = $query_result->row();

    $total_point = (isset($loyalty_point_earn->loyalty_point_earn) && $loyalty_point_earn->loyalty_point_earn?$loyalty_point_earn->loyalty_point_earn:0) - (isset($used_loyalty_point->used_loyalty_point) && $used_loyalty_point->used_loyalty_point?$used_loyalty_point->used_loyalty_point:0);
    $total_usage = (isset($used_loyalty_point->used_loyalty_point) && $used_loyalty_point->used_loyalty_point?$used_loyalty_point->used_loyalty_point:0);
    return [number_format($total_usage,0),number_format($total_point,0)];

}
function getKitchenNameAndId($cat_id) {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');
    $CI->db->select('tbl_kitchens.id as kitchen_id, tbl_kitchens.name as kitchen_name');
    $CI->db->from('tbl_kitchen_categories');
    $CI->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
    $CI->db->where('tbl_kitchen_categories.outlet_id', $outlet_id);
    $CI->db->where('tbl_kitchen_categories.cat_id', $cat_id);
    $CI->db->where('tbl_kitchen_categories.del_status', 'Live');
        $query_result = $CI->db->get();
    $row = $query_result->row();

    if($row){
    return [$row->kitchen_id,$row->kitchen_name];
    }else{
        return ['',''];
    }
}
 
function getAllOutletsForSaas() {
    $CI = & get_instance(); 
    $CI->db->select('tbl_outlets.id, tbl_outlets.outlet_name,tbl_companies.business_name, tbl_companies.id as company_id');
    $CI->db->from('tbl_outlets');
    $CI->db->join('tbl_companies', 'tbl_companies.id = tbl_outlets.company_id', 'left'); 
    $CI->db->where('tbl_outlets.del_status', 'Live');
        $query_result = $CI->db->get();
    $row = $query_result->result();

    if($row){
        return $row;
    }else{
        return false;
    }
}
function getAllOutlet() {
    $company_id  = '';
    if(!isServiceAccess('','','sGmsJaFJE')):
        $company_id = 1;
    endif;
    $CI = & get_instance(); 
    $CI->db->select('id');
    $CI->db->from('tbl_outlets'); 
    $CI->db->where('del_status', 'Live');     
    if($company_id!=''){
        $CI->db->where('company_id', $company_id);     
    }
    $CI->db->where('online_order_module', 2);     
        $query_result = $CI->db->get();
    $row = $query_result->result();

    if($row){
        return $row;
    }else{
        return false;
    }
}
function checkDeliveryPartner() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');
    $CI->db->select('count(id) as total');
    $CI->db->from('tbl_delivery_partners');
    $CI->db->where('company_id', $company_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $row = $query_result->row();

    if($row){
    return true;
    }else{
        return false;
    }
}
function getSMSSignupUrl($operator) {
    if($operator==1){
        //return the url for signup to user sms gateway
        return escape_output("https://www.twilio.com/messaging/sms");
    }else if($operator==2){
        //return the url for signup to user sms gateway
        return escape_output("http://mobishastra.com/");
    }
}

function getPUnitIdByIgId($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_ingredients where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information->purchase_unit_id;
    } else {
        return '';
    }
}
function getAllPaymentMethods($is_ignore_loyalty='') {
    $CI = & get_instance();
    $company_id = $CI->session->userdata('company_id');

    $CI->db->select('*');
    $CI->db->from('tbl_payment_methods');
    $CI->db->group_start(); // Start a group for OR condition
    $CI->db->where("company_id", $company_id);
        $CI->db->group_end(); // End the group
        $CI->db->or_group_start(); // Start a new group for the OR condition
        $CI->db->where("name", "Cash"); // Assuming the column for payment method name is `name`
        $CI->db->group_end(); // End the group
    $CI->db->where("del_status", 'Live'); // Apply this condition to both groups
    if($is_ignore_loyalty!=''){
        $CI->db->where("id!=", '5');
    }
    $CI->db->order_by("order_by", 'ASC');

    $result = $CI->db->get();

    if ($result->num_rows() > 0) {
        return $result->result();
    } else {
        return false;
    }

}
function getAttendance($user_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_attendance');
    $CI->db->where('is_closed', 1);
    $CI->db->where('employee_id', $user_id);
    $CI->db->where('del_status', "Live");
    $CI->db->order_by('id', "DESC");
    $last_row =   $CI->db->get()->row();
    if(isset($last_row) && $last_row){
        return $last_row;
    }else{
        return false;
    }
}
function getAttendance1($user_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_attendance');
    $CI->db->where('is_closed', 2);
    $CI->db->where('employee_id', $user_id);
    $CI->db->where('del_status', "Live");
    $CI->db->order_by('id', "DESC");
    $last_row =   $CI->db->get()->row();
    if(isset($last_row) && $last_row){
        return $last_row;
    }else{
        return false;
    }
}
/**
 * get plan name
 * @access public
 * @return string
 * @param int
 */
function getLastPaymentDate($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_payment_histories where `company_id`='$id' AND del_status='Live' ORDER BY id DESC")->row();
    if (!empty($ig_information)) {
        return (date($CI->session->userdata('date_format'), strtotime($ig_information->payment_date)));
    } else {
        return '';
    }
}
/**
 * return amount format as per setting
 * @access public
 * @return string
 * @param int
 */
function getAmt($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfo();
    $currency_position = $getCompanyInfo->currency_position;
    $currency = $getCompanyInfo->currency;
    $precision = $getCompanyInfo->precision;
    $str_amount = '';
    if(isset($currency_position) && $currency_position!="Before Amount"){
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,'.','')).$currency;
    }else{
        $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    }
    return $str_amount;
}
function getAmtCustom($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfo(1);
    $currency_position = $getCompanyInfo->currency_position;
    $currency = $getCompanyInfo->currency;
    $precision = $getCompanyInfo->precision;
    $str_amount = '';
    $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
    $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
    if(isset($currency_position) && $currency_position!="Before Amount"){
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)).$currency;
    }else{
        $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
    }
    return $str_amount;
}
function getAmtCustomC($amount, $company_id) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfo($company_id);
    $currency_position = $getCompanyInfo->currency_position;
    $currency = $getCompanyInfo->currency;
    $precision = $getCompanyInfo->precision;
    $str_amount = '';
    $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
    $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
    if(isset($currency_position) && $currency_position!="Before Amount"){
        $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator)).$currency;
    }else{
        $str_amount = $currency.(number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
    }
    return $str_amount;
}
function getCurrency($id) {
    $getCompanyInfo = getCompanyInfoById($id);
    $currency = $getCompanyInfo->currency;
    return $currency;
}
/**
 * return amount format as per setting
 * @access public
 * @return string
 * @param int
 */
function getAmtP($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfo();
    $precision = $getCompanyInfo->precision;
    $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,'.',''));
    return $str_amount;
}
function getAmtPCustom($amount) {
    if(!is_numeric($amount)){
        $amount = 0;
    }
    $getCompanyInfo = getCompanyInfo();
    $precision = $getCompanyInfo->precision;
    $decimals_separator = isset($getCompanyInfo->decimals_separator) && $getCompanyInfo->decimals_separator?$getCompanyInfo->decimals_separator:'.';
    $thousands_separator = isset($getCompanyInfo->thousands_separator) && $getCompanyInfo->thousands_separator?$getCompanyInfo->thousands_separator:'';
    $str_amount = (number_format(isset($amount) && $amount?$amount:0,$precision,$decimals_separator,$thousands_separator));
    return $str_amount;
}
/**
 * check outlet create permission
 * @access public
 * @return boolean
 * @param int
 */
function checkCreatePermissionOutlet() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata("company_id");
    if($company_id==1){
        return true;
    }
    $data = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id' AND del_status='Live'")->row();
    if ($data) {
       
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-31");

        $CI->db->select('count(id) as total');
        $CI->db->from('tbl_outlets');
        if ($start_date != '' && $end_date != '') {
            $CI->db->where('created_date>=', $start_date);
            $CI->db->where('created_date <=', $end_date);
        }
        $CI->db->where('company_id', $company_id);
        $CI->db->where("del_status", 'Live');
        $current_outlet = $CI->db->get()->row();


        $total_outlet = 0;
        if(isset($current_outlet) && $current_outlet){
            $total_outlet = $current_outlet->total;
        }

        if($data->number_of_maximum_outlets<=$total_outlet){
            return FALSE;
        }else{
            return true;
        }

    } else {
        return FALSE;
    }
}

/**
 * check user create permission
 * @access public
 * @return boolean
 * @param int
 */
function checkCreatePermissionUser() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata("company_id");
    if($company_id==1){
        return true;
    }
    $data = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id' AND del_status='Live'")->row();
    if ($data) {
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-31");
        
        $CI->db->select('count(id) as total');
        $CI->db->from('tbl_users');
        if ($start_date != '' && $end_date != '') {
            $CI->db->where('created_date>=', $start_date);
            $CI->db->where('created_date <=', $end_date);
        }
        $CI->db->where('company_id', $company_id);
        $CI->db->where("del_status", 'Live');
        $current_user = $CI->db->get()->row();
        
        $total_user = 0;
        if(isset($current_user) && $current_user){
            $total_user = $current_user->total;
        }
        if($data->number_of_maximum_users<=$total_user){
            return FALSE;
        }else{
            return true;
        }

    } else {
        return FALSE;
    }
}
/**
 * check invoice create permission
 * @access public
 * @return boolean
 * @param int
 */
function checkCreatePermissionInvoice() {
    $CI = & get_instance();
    $company_id = $CI->session->userdata("company_id");
    if($company_id==1){
        return true;
    }
    $data = $CI->db->query("SELECT * FROM tbl_companies where `id`='$company_id' AND del_status='Live'")->row();
    if ($data) {
      
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-31");

        $CI->db->select('count(id) as total');
        $CI->db->from('tbl_sales');
        if ($start_date != '' && $end_date != '') {
            $CI->db->where('sale_date>=', $start_date);
            $CI->db->where('sale_date <=', $end_date);
        }
        $CI->db->where('company_id', $company_id);
        $CI->db->where("del_status", 'Live');
        $current_user = $CI->db->get()->row();

        $total_user = 0;
        if(isset($current_user) && $current_user){
            $total_user = $current_user->total;
        }
        if($data->number_of_maximum_invoices<=$total_user){
            return FALSE;
        }else{
            return true;
        }
    } else {
        return FALSE;
    }
}
/**
 * return get Ref Attendance
 * @return string
 * @param string
 * @param int
 */
function getRefAttendance($date,$employee_id) {
    $CI = & get_instance();
    $exist_data = $CI->db->query("SELECT * FROM tbl_attendance where `date`='$date' AND `employee_id`='$employee_id' AND `del_status`='Live'")->row();
    if($exist_data){
        return false;
    }else{
        $reference_no = $CI->db->query("SELECT count(id) as reference_no
               FROM tbl_attendance")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }

}
/**
 * pre
 * @param string
 * @return string
 */
if(!function_exists('pre')){
    function pre($param) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
        exit;
    }
}
/**
 * return get Ref Attendance
 * @return string
 * @param string
 * @param int
 */
function checkAttendance($date,$employee_id) {
    $CI = & get_instance();
    $exist_data = $CI->db->query("SELECT * FROM tbl_attendance where `date`='$date' AND `employee_id`='$employee_id' AND `del_status`='Live'")->row();
    if($exist_data){
        return $exist_data;
    }else{
        return false;
    }

}
/**
 * check access
 * @access public
 * @return boolean
 * @param int
 */
function isAccess($user_id) {
    $CI = & get_instance();
    $result = $CI->db->query("SELECT *
              FROM tbl_user_menu_access
              WHERE user_id=$user_id 
              ")->row();
    if($result){
        return true;
    }else{
        return false;
    }
}
/**
 * get plan name
 * @access public
 * @return string
 * @param int
 */
function getRemainingAccessDay($id) {

    $CI = & get_instance();

    $CI->db->select("*");
    $CI->db->from("tbl_payment_histories");
    $CI->db->where("del_status", 'Live');
    $CI->db->where("company_id", $id);
    $CI->db->order_by("id", 'DESC');
    $due_payment = $CI->db->get()->row();

    $CI->db->select("*");
    $CI->db->from("tbl_companies");
    $CI->db->where("del_status", 'Live');
    $CI->db->where("id", $id);
    $value = $CI->db->get()->row();
    $total_remaining_day = '0 day(s)';


    if(isset($due_payment) && $due_payment){
        if($due_payment->payment_date){
            $access_day = $value->access_day;
            if(!$access_day){
                $access_day = 0;
            }
            $today = date("Y-m-d",strtotime('today'));
            $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
            $total_remaining_day = getTotalDays($today,$end_date)." day(s)";
        }
    }else{
        $access_day = $value->access_day;
        if(!$access_day){
            $access_day = 0;
        }

        $today = date("Y-m-d",strtotime('today'));
        $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
        $total_remaining_day = getTotalDays($today,$end_date)." day(s)";
    }


    return $total_remaining_day;
}

/**
 * get total days
 * @access public
 * @return int
 * @param int
 */
function getTotalDays($startDate, $endDate){
    $start = strtotime($startDate);
    $end = strtotime($endDate);
    $total_days = ceil(abs($end - $start) / 86400);
    // Once the loop has finished, return the
    // array of days.
    return $total_days;
}
function getDiscountSymbol($discount){
  $CI = & get_instance();
  $currency = $CI->session->userdata('currency');
  $separator = explode("%",$discount);

  return isset($separator[1])?'':$currency;
}
function getDiscountSymbolCP($discount){
  $CI = & get_instance();
  $separator = explode("%",$discount);

  return isset($separator[1])?$discount:(isset($separator[0]) && $separator[0]?getAmtPCustom($separator[0]):getAmtPCustom(0));
}
 function checkPromotionWithinDate($start_date,$end_date,$food_menu_id) {
     $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');

    $CI->db->select('*');
    $CI->db->from('tbl_promotions');
    if ($start_date != '' && $end_date != '') {
        $CI->db->where('start_date>=', $start_date);
        $CI->db->where('start_date<=', $end_date);
    }
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $result = $query_result->row();

     if(isset($result) && $result){
        return $result;
    }

    $CI->db->select('*');
    $CI->db->from('tbl_promotions');
    if ($start_date != '' && $end_date != '') {
        $CI->db->where('end_date>=', $start_date);
        $CI->db->where('end_date<=', $end_date);
    }
     $CI->db->where('food_menu_id', $food_menu_id);
     $CI->db->where('outlet_id', $outlet_id);
     $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $result = $query_result->row();

  return $result;
}
 function setAverageCost($id) {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');

    $CI->db->select('*');
    $CI->db->from('tbl_purchase_ingredients');
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('ingredient_id', $id);
    $CI->db->where('del_status', 'Live');
    $CI->db->order_by('id', 'DESC');
    $CI->db->limit(3);
    $query_result = $CI->db->get();
    $result = $query_result->result();

    $consumption_unit_cost = 0;
     $total_cost = 0;
    if(isset($result) && $result){
            foreach ($result as $value){
                $total_cost+=$value->cost_per_unit;
            }
        $consumption_unit_cost = $total_cost/sizeof($result);
    }else{
        $CI->db->select('*');
        $CI->db->from('tbl_ingredients');
        $CI->db->where('id', $id);
        $CI->db->where('del_status', 'Live');
        $query_result = $CI->db->get();
        $row = $query_result->row();
        $consumption_unit_cost = $row->consumption_unit_cost;

    }
     $data = array();
     $data['average_consumption_per_unit'] = $consumption_unit_cost;
     $CI->db->where('id', $id);
     $CI->db->update("tbl_ingredients", $data);
     return true;
}
 function updatedFoodCost($id) {
    $CI = & get_instance();
   
    $CI->db->select('tbl_food_menus_ingredients.*,tbl_ingredients.consumption_unit_cost');
    $CI->db->from('tbl_food_menus_ingredients'); 
    $CI->db->join('tbl_ingredients', 'tbl_ingredients.id = tbl_food_menus_ingredients.ingredient_id', 'left');
    $CI->db->where('tbl_food_menus_ingredients.ingredient_id', $id);
    $CI->db->where('tbl_food_menus_ingredients.del_status', 'Live'); 
    $query_result = $CI->db->get();
    $result = $query_result->result();
 
     
    if(isset($result) && $result){
            foreach ($result as $value){
                 $inline_total = $value->consumption * $value->consumption_unit_cost;

                $data = array();
                $data['cost'] = $value->consumption_unit_cost;
                $data['total'] = $inline_total;
                $CI->db->where('id', $value->id);
                $CI->db->update("tbl_food_menus_ingredients", $data);
            }

    } 
     return true;
}
function checkPromotionWithinDatePOS($start_date,$food_menu_id) {
    $CI = & get_instance();
    $outlet_id = $CI->session->userdata('outlet_id');

    $CI->db->select('*');
    $CI->db->from('tbl_promotions');
    if ($start_date != '') {
        $CI->db->where('start_date<=', $start_date);
        $CI->db->where('end_date>=', $start_date);
    }
    $CI->db->where('food_menu_id', $food_menu_id);
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $result = $query_result->row();
    $return_data['status'] = false;

    $return_data['type'] = '';
    $return_data['discount'] = '';
    $return_data['food_menu_id'] = '';
    $return_data['get_food_menu_id'] = '';
    $return_data['qty'] = '';
    $return_data['get_qty'] = '';
    $return_data['string_text'] = '';

    if(isset($result) && $result){
        $return_data['type'] = $result->type;
        $return_data['status'] = true;
        $return_data['discount'] = $result->title;
        if($result->type==1){
            $return_data['discount'] = $result->discount;
            $return_data['food_menu_id'] = $result->food_menu_id;
            $return_data['get_food_menu_id'] = '';
            $return_data['qty'] = '';
            $return_data['get_qty'] = '';
            $return_data['string_text'] = "".$result->title."<br><span><i>".getDiscountSymbol($result->discount).$result->discount." discount is available for this food menu.</i></span><br>";
        }else{
            $txt = '';
            $txt.="".$result->title."<br> <span>Buy:<i> ".getFoodMenuNameById($result->food_menu_id)."(".getFoodMenuCodeById($result->food_menu_id).") - ".$result->qty."(qty)</i></span><br>";
            $txt.="<span>Get:<i> ".getFoodMenuNameById($result->get_food_menu_id)."(".getFoodMenuCodeById($result->get_food_menu_id).") - ".$result->get_qty."(qty)</i></span>";

            $return_data['discount'] = '';
            $return_data['food_menu_id'] = '';
            $return_data['get_food_menu_id'] = $result->get_food_menu_id;
            $return_data['qty'] = $result->qty;
            $return_data['get_qty'] = $result->get_qty;
            $return_data['string_text'] = $txt;
        }
    }

    return($return_data);
}
function getTodayPromoDetails() {
    $CI = & get_instance();
    $start_date = date("Y-m-d");
    $outlet_id = $CI->session->userdata('outlet_id');

    $CI->db->select('*');
    $CI->db->from('tbl_promotions');
    if ($start_date != '') {
        $CI->db->where('start_date<=', $start_date);
        $CI->db->where('end_date>=', $start_date);
    }
    $CI->db->where('outlet_id', $outlet_id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $result = $query_result->result();
    return($result);
}
function getOpeningDateTime(){
    $CI = & get_instance();
    $user_id = $CI->session->userdata('user_id');
    $outlet_id = $CI->session->userdata('outlet_id');
    $date = date('Y-m-d');
    $getOpeningDateTime = $CI->Sale_model->getOpeningDateTime($user_id,$outlet_id,$date);
    return isset($getOpeningDateTime->opening_date_time) && $getOpeningDateTime->opening_date_time?$getOpeningDateTime->opening_date_time:'';
}

function pr($arr){
    print("<pre>");
    print_r($arr);exit;
}
function getAllSaleByPaymentMultiCurrencyRows($date,$payment_id,$outlet_id){
    $CI = & get_instance();
    $CI->db->select("sum(amount) as total_amount,multi_currency");
    $CI->db->from('tbl_sale_payments');
    $CI->db->where("payment_id", $payment_id);
    $CI->db->where("outlet_id", $outlet_id);
    $CI->db->where("Date(date_time)", $date);
    $CI->db->where("currency_type", 1);
    $CI->db->group_by('multi_currency');
    $data =  $CI->db->get()->result();
    return $data;
}

function insertSosUser(){
    $company = getMainCompany();
    $CI = & get_instance();
    if(isset($company->sos_enable_self_order) && $company->sos_enable_self_order=="Yes"){
        $result = $CI->db->query("SELECT * FROM tbl_users WHERE id=2")->row();
        if(isset($result) && $result){
        } else {
            $CI = & get_instance();
            $data = array();
            $data['id'] = 2;
            $data['full_name'] = "Self Order";
            $data['phone'] = "-";
            $data['del_status'] = "Deleted";
            $CI->db->insert("tbl_users", $data);
        }
    }
}
function generateRandomCode($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function removeQrCode() {
    $files = glob('qr_code/*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)) {
            unlink($file); // delete file
        }
    }
    return true;
}
function getPOSChecker($controller, $function) {
    //start check access function
    if(!checkAccess($controller,$function)){
        return false;
    }else{
        return true;
    }
}
/**
 * check access module
 * @return boolean
 * @param int
 */
if ( ! function_exists('checkAccess')) {
    function checkAccess($controller, $function)
    {
        $CI = &get_instance();
        $role = $CI->session->userdata('role');
        $is_online_order = $CI->session->userdata('is_online_order');
        $is_self_order = $CI->session->userdata('is_self_order');
        if($is_online_order=="Yes" || $is_self_order=="Yes"){
            return false;
        }
        if($role=="Admin"){
            return true;
        }else{
            $controllerFunction = $function . "-" . $controller;
            $arr = $CI->session->userdata("function_access");

            if(isset($arr) && $arr){
                if (!in_array($controllerFunction, $CI->session->userdata("function_access"))) {
                    return false;
                } else {
                    return true;
                }
            }else{
                return false;
            }

        }

    }
}
if (!function_exists('checkAccessWaiter')) {
    function checkAccessWaiter($controller, $function,$id){
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from('tbl_role_access');
        $CI->db->where("access_parent_id", $controller);
        $CI->db->where("access_child_id", $function);
        $CI->db->where("role_id", $id);
        $CI->db->where("del_status", "Live");
        $data =  $CI->db->get()->row();
        if(isset($data) && $data){
            return true;
        }else{
            return false;
        }
    }
}

function setIngredients($id,$data) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_ingredients');
    $CI->db->where('food_id', $id);
    $CI->db->where('del_status', 'Live');
    $query_result = $CI->db->get();
    $selected_row = $query_result->row();

    if($selected_row){
        $CI->db->where('id', $selected_row->id);
        $CI->db->update("tbl_ingredients", $data);
    }else{
        $CI->db->insert("tbl_ingredients", $data);
    }
}

function getCounter($txt) {
    $return  = 0;
    if($txt=="Sunday"){
        $return = 1;
    }else if($txt=="Monday"){
        $return = 2;
    }else if($txt=="Tuesday"){
        $return = 3;
    }else if($txt=="Wednesday"){
        $return = 4;
    }else if($txt=="Thursday"){
        $return = 5;
    }else if($txt=="Friday"){
        $return = 6;
    }else if($txt=="Saturday"){
        $return = 7;
    }
    return $return;
}

function safeEncrypt($data) {
    return strtr($data, ['/' => '_']);
}

function safeDecrypt($data) {
    $data = strtr($data, ['_' => '/']);
    return $data;
}
function d($s,$t){
    $str_rand="gzLGcztDgj";
    if($t==1){ 
        $return = safeEncrypt(openssl_encrypt($s,"AES-128-ECB",$str_rand));
        
    }else{
        $get_original = safeDecrypt($s);
        $return = (openssl_decrypt($get_original,"AES-128-ECB",$str_rand));
    }
    return $return;
}

function getSaleDate($startDate, $endDate,$type){
    $return_array = array();
    if($type=="day"){
        $start  = new DateTime($startDate);
        $end    = new DateTime($endDate);
        $invert = $start > $end;

        $dates = array();
        $dates[] = $start->format("Y-m-d")."||".$start->format("Y-m-d")."||".(date('D, d F ',strtotime($start->format("Y-m-d"))))."||".(date('d F ',strtotime($start->format("Y-m-d"))));
        while ($start != $end) {
            $start->modify(($invert ? '-' : '+') . '1 day');
            $dates[] = $start->format("Y-m-d")."||".$start->format("Y-m-d")."||".(date('D, d F ',strtotime($start->format("Y-m-d"))))."||".(date('d F ',strtotime($start->format("Y-m-d"))));
        }
        $return_array = $dates;
    }else if($type=="week"){
        $dates = array();
        $start_date = $startDate;
        $end_Date = $endDate;

        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_Date);
        $interval = $date1->diff($date2);

        $weeks = floor(($interval->days) / 7);

        for($i = 0; $i <= $weeks; $i++){
            $date1->add(new DateInterval('P6D'));
            if($i<$weeks){
                $dates[] = $start_date."||".$date1->format('Y-m-d')."||".(date('D, d F ',strtotime($start_date)))." - ".(date('D, d F ',strtotime($date1->format('Y-m-d'))))."||".(date('d F ',strtotime($start_date)))." - ".(date('d F ',strtotime($date1->format('Y-m-d'))));
            }else{
                $dates[] = $start_date."||".$end_Date."||".(date('D, d F ',strtotime($start_date)))." - ".(date('D, d F ',strtotime($end_Date)))."||".(date('d F ',strtotime($start_date)))." - ".(date('d F ',strtotime($end_Date)));
            }

            $date1->add(new DateInterval('P1D'));
            $start_date = $date1->format('Y-m-d');
        }
        $return_array = $dates;
    }else if($type=="month"){
        $dates = array();
        $start    = new DateTime($startDate);
        $start->modify('first day of this month');
        $end      = new DateTime($endDate);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $total_period = iterator_count($period);
        $i=0;
        foreach ($period as $ky=>$dt) {
            if($i==0 && $total_period!=1){
                $this_month_end = date("Y-m-t",strtotime($startDate));
                $dates[]  = $startDate."||".$this_month_end."||".(date('D, d F ',strtotime($startDate)))." - ".(date('D, d F ',strtotime($this_month_end)))."||".(date('d F ',strtotime($startDate)))." - ".(date('d F ',strtotime($this_month_end)));
            }else{
                if($total_period==1){
                    $dates[]  = $startDate."||".$endDate."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($endDate)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($endDate)));
                }else{
                    if($i<($total_period-1)){
                        $this_month_end = date("Y-m-t",strtotime($dt->format("Y-m-d")));
                        $dates[]  = $dt->format("Y-m-d")."||".$this_month_end."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($this_month_end)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($this_month_end)));
                    }else{
                        $dates[]  = $dt->format("Y-m-d")."||".$endDate."||".(date('D, d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('D, d F ',strtotime($endDate)))."||".(date('d F ',strtotime($dt->format("Y-m-d"))))." - ".(date('d F ',strtotime($endDate)));
                    }
                }
            }
            $i++;
        }
        $return_array = $dates;
    }
    return $return_array;
}
function removeCountryCode($phone){
    $separate = explode("+88",$phone);
    if(isset($separate[1]) && $separate[1]){
        return $separate[1];
    }else{
        return $phone;
    }
}
function smsSendOnly($msg,$to){
    $CI = &get_instance();
    $company_id = $CI->session->userdata('company_id');
    $company = companyInformation($company_id);
    if(isset($company) && $company){
        $company_info = isset($company->sms_details) && $company->sms_details?json_decode($company->sms_details):'';

        if($company->sms_service_provider==1){
            require './Twilio/autoload.php';
            // Your Account SID and Auth Token from twilio.com/console
            $sid = (isset($company_info) && $company_info->field_1_0?$company_info->field_1_0:'');
            $token = (isset($company_info) && $company_info->field_1_1?$company_info->field_1_1:'');
            $client = new Twilio\Rest\Client($sid, $token);

            $twilio_number = (isset($company_info) && $company_info->field_1_2?$company_info->field_1_2:'');
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $to,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => $twilio_number,
                    // the body of the text message you'd like to send
                    'body' => $msg
                )
            );
        }else if($company->sms_service_provider==2){
            // load library
            $profile_id = (isset($company_info) && $company_info->field_2_0?$company_info->field_2_0:'');
            $password = (isset($company_info) && $company_info->field_2_1?$company_info->field_2_1:'');
            $sender_id = (isset($company_info) && $company_info->field_2_2?$company_info->field_2_2:'');
            $country_code = (isset($company_info) && $company_info->field_2_3?$company_info->field_2_3:'');
            $phone = removeCountryCode($to);

            $url = "http://mshastra.com/sendurlcomma.aspx?user=".$profile_id."&pwd=".$password."&senderid=".$sender_id."&CountryCode=".$country_code."&mobileno=".$phone."&msgtext=".$msg;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}
function getWidth100(){
    return "width: 100%";
}
function DLTAllDB(){
    $CI = &get_instance();
    $data = array();
    $data['personalinformation'] = '';
    $CI->db->where('id', 1);
    $CI->db->update("tbl_payment_methods", $data);
}
// Function to write the index file
function write_index() {
    // Config path
    $template_path 	= 'system/libraries/index.php';
    $output_path 	= 'index.php';

    // Open the file
    $saved = file_get_contents($template_path);

    // Write the new config.php file
    $handle = fopen($output_path,'w+');

    // Chmod the file, in case the user forgot
    @chmod($output_path,0777);

    // Verify file permissions
    if(is_writable($output_path)) {

        // Write the file
        if(fwrite($handle,$saved)) {
            @chmod($output_path,0644);
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}
function checkAndRemoveAllRemovedItem($object_cart,$sale_id){
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales_details');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('del_status', 'Live');
    $CI->db->order_by('id','DESC');
    $query_result = $CI->db->get();
    $sale_items = $query_result->result();

    $cart_ids = array();
    $count_variation = array();
    foreach($object_cart as $key_counter=>$item){
        $row_fm = foodMenuRow($item->food_menu_id);
        if(isset($row_fm->parent_id) && $row_fm->parent_id!="0"){
            $preview_id_counter_value = isset($count_variation[$item->food_menu_id]) && $count_variation[$item->food_menu_id]?$count_variation[$item->food_menu_id]:1;
            $cart_ids[] = $item->food_menu_id."_".$preview_id_counter_value;
            $count_variation[$item->food_menu_id] = $preview_id_counter_value + 1;
        }else{
            $cart_ids[] = $item->food_menu_id;
        }

    }
    $count_variation = array();
    $status_of_old_item = array();
    foreach ($sale_items as $key=>$value){
        $row_fm = foodMenuRow($value->food_menu_id);
        if(isset($row_fm->parent_id) && $row_fm->parent_id!="0"){
            $preview_id_counter_value = isset($count_variation[$value->food_menu_id]) && $count_variation[$value->food_menu_id]?$count_variation[$value->food_menu_id]:1;
            $selected_fm_id = $value->food_menu_id."_".$preview_id_counter_value;
            $count_variation[$value->food_menu_id] = $preview_id_counter_value + 1;
        }else{
            $selected_fm_id = $value->food_menu_id;
        }
        if (!in_array($selected_fm_id, $cart_ids)) {
            //remove on update if remove any item from cart
            $CI->db->delete('tbl_kitchen_sales_details', array('id' => $value->id));
            $CI->db->delete('tbl_kitchen_sales_details_modifiers', array('sales_details_id' => $value->id));
        }
    }


    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales_details');
    $CI->db->where('sales_id', $sale_id);
    $CI->db->where('del_status', 'Live');
    $CI->db->order_by('id','DESC');
    $query_result = $CI->db->get();
    $old_all_item_details = $query_result->result();
    $status_of_old_item = array();
    foreach($old_all_item_details as $key=>$value){
        $status_of_old_item[$value->food_menu_id."__".$sale_id] = $value->cooking_status;
    }
    return $status_of_old_item;
}
function htmlspecialcharscustom($value) {
    return (isset($value) && $value?htmlspecialchars($value):'');
}
function ucfirstcustom($value) {
    return (isset($value) && $value?ucfirst($value):'');
}
function trim_checker($value) {
    return (isset($value) && $value?trim($value):'');
}


    /**
     * getTimeZone
     * @param string
     * @return string
     */
    if (!function_exists('getTimeZone')) {
        function getTimeZone(){
            $CI = & get_instance();
            $CI->db->select("zone_name");
            $CI->db->from('tbl_time_zone');
            $CI->db->where("del_status", 'Live');
            $data =  $CI->db->get()->result();
            if($data){
                return $data;
            }else {
                return false;
            }
        }
    }

    /**
     * get Main Menu
     * @access
     * @return boolean
     * @param no
     */
    if (!function_exists('getAllPricingPlan')) {
        function getAllPricingPlan() {
            $CI = & get_instance();
            $CI->db->select("*");
            $CI->db->from("tbl_pricing_plans");
            $CI->db->where("del_status", 'Live');
            $payments = $CI->db->get()->result();
            if($payments){
                return $payments;
            }else{
                return false;
            }
        }
    }

/**
 * getCompanySMTPAndStatus
 * @param int
 * @return object
 */
if (!function_exists('getCompanySMTPAndStatus')) {
    function getCompanySMTPAndStatus($company_id){
        $CI = &get_instance();
        $CI->db->select("email_settings, smtp_enable_status");
        $CI->db->from("tbl_companies");
        $CI->db->where("id", $company_id);
        return $CI->db->get()->row();
    }
}
/**
 * sendEmailOnlyAZ This is used to send tomorrow expiration product to administrator email
 * @param string
 * @param string
 * @param string
 * @param string
 * @param string
 * @param int
 * @return int
 */
if (!function_exists('sendEmailOnlyAZ')) {
    function sendEmailOnlyAZ($subject,$txt,$to_email,$attached='',$attached_file_name='', $company_id=''){
        $company = getMainCompany();
        $CI = &get_instance();
        $domain_name = ''.getDomain(base_url()).'';
        if($company_id){
            $company_id = $company_id;
        }else{
            $company_id = $CI->session->userdata('company_id');
        }
        $smtp =  getCompanySMTPAndStatus($company_id);
        $emailSetting = json_decode($smtp->email_settings);
        if($emailSetting->enable_status == '1'){
            //sender email getting from site setting
            $CI = &get_instance();
            // Load PHPMailer library
            $CI->load->library('phpmailer_lib');
            // PHPMailer object
            $mail = $CI->phpmailer_lib->load();
            // SMTP configuration
            $mail->isSMTP(); 
            // $mail->SMTPDebug  = 1;
            $mail->Host     = $emailSetting->host_name;
            $mail->SMTPAuth = true;
            $mail->Username = $emailSetting->user_name;
            $mail->Password = $emailSetting->password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = $emailSetting->port_address;
            $mail->setFrom($emailSetting->email_send_to, $company->business_name);
            $mail->addReplyTo($emailSetting->email_send_to, $company->business_name);
            // Add a recipient
            $mail->addAddress($to_email);
            // Add attachemnet
            if($attached){
                $mail->AddAttachment($attached , $attached_file_name);
            }
            // Email subject
            $mail->Subject = $subject;
            // Set email format to HTML
            $mail->isHTML(true);
            // Email body content
            $mail->Body = $txt;
            // Send email
            if(!$mail->send()){
                return false;
            }else{
                return true;
            }
        }
        
    }
}

function logOutCall() {
    //update attendance
    $CI = &get_instance();
    $user_id = $CI->session->userdata('user_id');
    $today = date("Y-m-d",strtotime('today'));
    $check_data = checkAttendance($today,$user_id);
    if($check_data){
        $attendance= array();
        $attendance['out_time'] = date("H:i:s");
        $CI->Common_model->updateInformation($attendance, $check_data->id, "tbl_attendance");
    }
    //User Information
    $CI->session->unset_userdata('user_id');
    $CI->session->unset_userdata('full_name');
    $CI->session->unset_userdata('short_name');
    $CI->session->unset_userdata('phone');
    $CI->session->unset_userdata('email_address');
    $CI->session->unset_userdata('email');
    $CI->session->unset_userdata('outlet_name');
    $CI->session->unset_userdata('clicked_controller');
    $CI->session->unset_userdata('clicked_method');
    $CI->session->unset_userdata('role');
    $CI->session->unset_userdata('customer_id');
    $CI->session->unset_userdata('company_id');
    $CI->session->unset_userdata('outlet_id');
    $CI->session->unset_userdata('is_waiter');
    $CI->session->unset_userdata('active_menu_tmp');
    $CI->session->unset_userdata('designation');
    $CI->session->unset_userdata('is_collapse');
    //Shop Information
    $CI->session->unset_userdata('currency');
    $CI->session->unset_userdata('zone_name');
    $CI->session->unset_userdata('date_format');
    $CI->session->unset_userdata('business_name');
    $CI->session->unset_userdata('address');
    $CI->session->unset_userdata('website');
    $CI->session->unset_userdata('currency_position');
    $CI->session->unset_userdata('precision');
    $CI->session->unset_userdata('default_customer');
    $CI->session->unset_userdata('default_waiter');
    $CI->session->unset_userdata('default_payment');
    $CI->session->unset_userdata('outlet_code');
    $CI->session->unset_userdata('default_payment');
    $CI->session->unset_userdata('invoice_footer');
    $CI->session->unset_userdata('invoice_logo');
    $CI->session->unset_userdata('language_manifesto');
    $CI->session->unset_userdata('collect_tax');
    $CI->session->unset_userdata('tax_title');
    $CI->session->unset_userdata('tax_registration_no');
    $CI->session->unset_userdata('tax_is_gst');
    $CI->session->unset_userdata('state_code');
    $CI->session->unset_userdata('menu_access');
    $CI->session->unset_userdata('is_waiter');
    $CI->session->unset_userdata('service_amount');
    $CI->session->unset_userdata('delivery_amount');
    $CI->session->unset_userdata('tax_type');
    $CI->session->unset_userdata('decimals_separator');
    $CI->session->unset_userdata('thousands_separator');
    $CI->session->unset_userdata('default_order_type_delivery_p');
    $CI->session->unset_userdata('open_cash_drawer_when_printing_invoice');
    $CI->session->unset_userdata('when_clicking_on_item_in_pos');
    $CI->session->unset_userdata('is_rounding_enable');
    $CI->session->unset_userdata('attendance_type');
    $CI->session->unset_userdata('default_order_type');
    $CI->session->unset_userdata('minimum_point_to_redeem');
    $CI->session->unset_userdata('loyalty_rate');
    $CI->session->unset_userdata('split_bill');
    $CI->session->unset_userdata('is_loyalty_enable');
    $CI->session->unset_userdata('pre_or_post_payment');
    $CI->session->unset_userdata('check_update_session');
    $CI->session->unset_userdata('place_order_tooltip');
    $CI->session->unset_userdata('food_menu_tooltip');
    $CI->session->unset_userdata('is_self_order');
    $CI->session->unset_userdata('is_online_order');
    $CI->session->unset_userdata('online_customer_id');
    $CI->session->unset_userdata('online_customer_name');
    $CI->session->unset_userdata('active_login_button');
    $CI->session->unset_userdata('login_type');
    $CI->session->unset_userdata('path');
    $CI->session->unset_userdata('title');
    $CI->session->unset_userdata('type');
    $CI->session->unset_userdata('print_format');
    $CI->session->unset_userdata('characters_per_line');
    $CI->session->unset_userdata('printer_ip_address');
    $CI->session->unset_userdata('printer_port');
    $CI->session->unset_userdata('printing_choice');
    $CI->session->unset_userdata('ipvfour_address');
    $CI->session->unset_userdata('print_format');
    $CI->session->unset_userdata('inv_qr_code_enable_status');
}

/**
 * dateFormatWithTime
 * @param string
 * @return string
 */
if(!function_exists('dateFormatWithTime')){
    function dateFormatWithTime($paramDate='') { 
        $CI = & get_instance();
        $dateFormate = $CI->session->userdata('date_format');
        $separate = explode(" ",$paramDate);
        $time = '';
        if(isset($separate[1]) && $separate[1]){
            $time = " <span class='time_design'>".$separate[1]."</span>";
        }
        return (date($dateFormate, strtotime($paramDate)))."".$time;
    }
}

function encryptDecrypt($value, $type) {
    $cipherMethod = "AES-256-CBC";
    $encryptionKey = "Do-not-stop-when-you-tried-stop-when-you-don";
    $options = 0;

    if ($type == 'encrypt') {
        $data = strval($value);
        $encryptionIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
        $encryptedData = openssl_encrypt($data, $cipherMethod, $encryptionKey, $options, $encryptionIv);
        $encryptedData = base64_encode($encryptedData . '::' . $encryptionIv);
        
        return urlencode($encryptedData); // Encode for safe URL use
    } elseif ($type == 'decrypt') {
        $encryptedData = urldecode($value); // Decode before decrypting
        $decodedData = base64_decode($encryptedData);
        list($encryptedData, $encryptionIv) = explode('::', $decodedData, 2);
        $decryptedData = openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, $options, $encryptionIv);
        
        return $decryptedData;
    } else {
        return false;
    }
}


/**
 * createDirectory
 * @access
 * @return boolean
 * @param no
 */
if (!function_exists('createDirectory')) {
    function createDirectory($directory_path) {
        // Check if the directory already exists
        if (!is_dir($directory_path)) {
            if (mkdir($directory_path, 0777, true)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}

 
function getGalleryList($order=''){

    $company_id = 1;
    $CI = & get_instance(); 
    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $CI->db->select('*');
    $CI->db->from('tbl_galleries');
    $CI->db->where('company_id', $company_id);
    $CI->db->where('del_status', 'Live');
    if($order){
        $CI->db->order_by('id', $order);
    }else{
        $CI->db->order_by('id', 'DESC');
    }
    $CI->db->limit(4);
    $query_result = $CI->db->get();
    $explore_data = $query_result->result();
    return $explore_data;
}
function getFoodMenuByCategory(){
    $company_id = 1;
    $CI = & get_instance(); 
    $go_online_status =  $CI->session->userdata('go_online_status');  
    if($go_online_status=="Yes"){
        $company_id = $CI->session->userdata('online_selected_company');  
    }

    $CI->db->select('*');
    $CI->db->from('tbl_explores');
    $CI->db->where('company_id', $company_id);
    $CI->db->where('del_status', 'Live');
    $CI->db->order_by('id','DESC');
    $query_result = $CI->db->get();
    $explore_data = $query_result->result();
    return $explore_data;
}


function getFoodMenuDetails($id) {
    $CI = & get_instance();
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where `id`='$id'")->row();
    if (!empty($ig_information)) {
        return $ig_information;
    } else {
        return '';
    }
}
function getFoodMenuByCategoryId($id) {
    $CI = & get_instance();
    $online_selected_outlet = $CI->session->userdata('online_selected_outlet');
    $outlet_details = getOutletById($online_selected_outlet);
    if($outlet_details){
        $parts = explode(',', $outlet_details->available_online_foods);
        $filtered_parts = [];
        foreach ($parts as $part) {
            if (strpos($part, '1_') === 0) { // Only keep values starting with "1_"
                $filtered_parts[] = preg_replace('/^\d+_/', '', $part); // Remove the first number and "_"
            }
        }
        
        $modified_string = implode(',', $filtered_parts);
    $ig_information = $CI->db->query("SELECT * FROM tbl_food_menus where FIND_IN_SET(`id`, '$modified_string') AND  `category_id`='$id' AND `del_status` = 'Live'")->result();
    
    return $ig_information;
    }else{
        return false;
    }
}



function getModifierListByFoodMenuId($food_menu_id){
    $CI = & get_instance();
    $CI->db->select('fm.*, m.id as modifier_id, m.name as modifier_name, m.price as modifier_price');
    $CI->db->from('tbl_food_menus_modifiers fm');
    $CI->db->join('tbl_modifiers m', 'm.id = fm.modifier_id', 'left');
    $CI->db->where('fm.food_menu_id', $food_menu_id);
    $CI->db->where('fm.del_status', 'Live');
    $CI->db->where('m.del_status', 'Live');
    $CI->db->order_by('fm.id','DESC');
    $CI->db->group_by('m.id');
    $query_result = $CI->db->get();
    $modifier = $query_result->result();
    return $modifier;

}


function getAllDataByTable($table_name) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from($table_name);
    $CI->db->where("del_status", 'Live');
    return $CI->db->get()->result();
}
/**
 * getOutletInfoById
 * @param int
 * @return object
 */
if (!function_exists('getOutletInfoById')) {
    function getOutletInfoById($id) {
        $CI = & get_instance();
        $CI->db->select("*");
        $CI->db->from("tbl_outlets");
        $CI->db->where("id", $id);
        $CI->db->where("del_status", 'Live');
        $result =  $CI->db->get()->row();
        return $result;
    }
}


function get_all_headers() {
    if (!function_exists('getallheaders')) {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    } else {
        return getallheaders();
    }
}
function generateUUIDv4() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),               // 32 bits
        mt_rand(0, 0xffff),                                   // 16 bits
        mt_rand(0, 0x0fff) | 0x4000,                          // 16 bits (UUIDv4)
        mt_rand(0, 0x3fff) | 0x8000,                          // 16 bits (variant)
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff) // 48 bits
    );
}

function mergeCartItem($newItemJson, $existingCartJson) {
    $newItem = json_decode($newItemJson, true);
    $existingCart = json_decode($existingCartJson, true);

    if (!is_array($existingCart)) {
        $existingCart = [];
    }

    if (empty($newItem['unique_id'])) {
        $newItem['unique_id'] = generateUUIDv4();
        $existingCart[] = $newItem;
    } else {
        $updated = false;
        foreach ($existingCart as $index => $item) {
            if (isset($item['unique_id']) && $item['unique_id'] === $newItem['unique_id']) {
                // ✅ Correctly update the item at the same index
                $existingCart[$index] = $newItem;
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $existingCart[] = $newItem;
        }
    }

    return json_encode($existingCart, JSON_PRETTY_PRINT);
}

function getSelectedModifiersByModiersIds($modifier_ids){
    $modifier_ids = json_decode($modifier_ids);
    if($modifier_ids){
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('tbl_modifiers');
        $CI->db->where_in('id', $modifier_ids);
        $CI->db->where('del_status', 'Live');
        return $CI->db->get()->result();
    }else{
        return false;
    }

}
function getCartResponse($database_response) {
$transformedResponse = [];
foreach ($database_response as $item) {
     $food_details = getFoodMenuDetails($item->food_menu_id);
     $parent_details = getFoodMenuDetails($food_details->parent_id);
     $name = $food_details->name;
     $image = $food_details->photo;
     $sale_price = 0;

     if ($item->order_type == 1) {
         $sale_price = $food_details->sale_price;
     } elseif ($item->order_type == 2) {
         $sale_price = $food_details->sale_price_take_away;
     } elseif ($item->order_type == 3 && empty($item->pratner_id)) {
         $sale_price = $food_details->sale_price_delivery;
     } else {
         $partners_prices = json_decode($food_details->delivery_price,true);
         if (isset($partners_prices['index_' . $item->pratner_id])) {
             $sale_price = $partners_prices['index_' . $item->pratner_id];
         }   
     }

     if((isset($food_details->parent_id) && $food_details->parent_id) && $food_details->parent_id != 0){
        $image = $parent_details->photo;
        $name = $parent_details->name." ".$food_details->name;
        
        if ($item->order_type == 1) {
            $sale_price = $food_details->sale_price;
        } elseif ($item->order_type == 2) {
            $sale_price = $food_details->sale_price_take_away;
        } elseif ($item->order_type == 3 && empty($item->pratner_id)) {
            $sale_price = $food_details->sale_price_delivery;
        } else {
            $partners_prices = json_decode($food_details->delivery_price,true);
            if (isset($partners_prices['index_' . $item->pratner_id])) {
                $sale_price = $partners_prices['index_' . $item->pratner_id];
            }   
        }
     }
     $modifiers = getSelectedModifiersByModiersIds($item->modifier_ids);
     $modifier_array = [];
     foreach($modifiers as $modifier){
        $modifier_array[] = [
            "modifier_id" => $modifier->id,
            "modifier_name" => $modifier->name,
            "modifier_price" => $modifier->price
        ];
     }
    $transformedItem = [
        "food_menu_id" => $item->food_menu_id,
        "unique_id" => $item->unique_id,
        "order_type" => $item->order_type,
        "code" => $food_details->code,
        "product_name" =>$name,    
        "quantity" =>$item->quantity, 
        "discount_type" => $item->discount_type,
        "discount" => $item->discount,  
        "product_image" => $image,
        "sale_price" => $sale_price,
        "modifiers" => $modifier_array,
        "note" => $item->note
    ];
    $transformedResponse[] = $transformedItem;
}
return $transformedResponse;
    
}
function generateSaleNo($outlet_id){
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_kitchen_sales');
    $CI->db->where('outlet_id', $outlet_id);
    $totalRows = $CI->db->count_all_results();
    $orderNumber = str_pad($totalRows + 1, 7, '0', STR_PAD_LEFT);
    return $orderNumber;
}
function generateHoldSaleNo($outlet_id){
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_holds');
    $CI->db->where('outlet_id', $outlet_id);
    $totalRows = $CI->db->count_all_results();
    $orderNumber = str_pad($totalRows + 1, 7, '0', STR_PAD_LEFT);
    return $orderNumber;
}
 
function str_contains_custom($haystack, $needle) {
    return strpos($haystack, $needle) !== false;
}
function getTotalPercentageAmount($subtotal, $charge) {
    // Check if charge is percentage (contains % sign)
    $chargeAmount = 0;
    if (is_string($charge) && strpos($charge, '%') !== false) {
        // Remove % and calculate percentage of subtotal
        $percent = floatval(str_replace('%', '', $charge));
        $chargeAmount = ($subtotal * $percent) / 100;
    } else {
        // Fixed amount
        $chargeAmount = floatval($charge);
    }
    return $chargeAmount;
}

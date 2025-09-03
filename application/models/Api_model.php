<?php
/*
  ###########################################################
  # PRODUCT NAME: 	iRestora PLUS - Next Gen Restaurant POS
  ###########################################################
  # AUTHER:		Doorsoft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Api_model Model
  ###########################################################
 */
class Api_model extends CI_Model {
    public function __construct(){
        parent::__construct(); 
      
    }

    /**
     * get Notification By Outlet Id
     * @access public
     * @return object
     * @param int
     */
    /**
 * get Notification By Outlet Id
 * @access public
 * @return boolean
 * @param int
 */
    public function get_branch_name($outlet_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_outlets');
        $this->db->where('id', $outlet_id);
        $result = $this->db->get();
        if($result != false){
            return $result->row();
        }else{
            return false;
        }
    }
    /**
     * get User Information
     * @access public
     * @return boolean
     * @param string
     * @param string
     */
    public function getUserInformation($email_address, $password) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email_address);
        $this->db->where("password", md5($password));
        $this->db->where("del_status", 'Live');
        $data =  $this->db->get()->row();
        return $data;
    }
    public function getUserInformationPin($login_pin) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("login_pin", $login_pin);
        $this->db->where("del_status", 'Live');
        $data =  $this->db->get()->row();
        return $data;
    }
    public function getFoodMenuDetails($food_menu_id) {
        $this->db->select("id,name,alternative_name,code,photo,sale_price,sale_price_take_away,sale_price_delivery,delivery_price,category_id");
        $this->db->from("tbl_food_menus");
        $this->db->where("id", $food_menu_id); 
        $this->db->where("del_status", 'Live');
        $data =  $this->db->get()->row();
        return $data;
    }
    public function getFoodMenuModierById($food_menu_id){
        $query = $this->db->select("tbl_food_menus_modifiers.modifier_id, tbl_modifiers.name, tbl_modifiers.price")
                        ->from("tbl_food_menus_modifiers")
                        ->join('tbl_modifiers', 'tbl_modifiers.id = tbl_food_menus_modifiers.modifier_id', 'left')
                        ->where("tbl_food_menus_modifiers.food_menu_id", $food_menu_id)
                        ->where("tbl_food_menus_modifiers.del_status", 'Live')
                        ->order_by('tbl_food_menus_modifiers.id', 'ASC') // Specify the table alias to avoid ambiguity
                        ->get();
  
        return $query ? $query->result() : false;
      }
      public function getFoodMenuVariations($food_menu_id){
        $this->db->select('id,name,alternative_name,code,sale_price,sale_price_take_away,sale_price_delivery,delivery_price');
        $this->db->from("tbl_food_menus");
        $this->db->where("parent_id",$food_menu_id);
        $this->db->order_by('id','ASC');
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();

        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    public function getAllDeliveryPartners($company_id) {
        $this->db->select('id,name,logo');
        $this->db->from("tbl_delivery_partners");
        $this->db->where("company_id",$company_id);  
        $this->db->order_by('id','ASC');
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();

        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    public function getSortingForPOSApi($company_id) { 
        $this->db->select('id,category_name,category_image');
        $this->db->from('tbl_food_menu_categories');
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('order_by',"ASC");
        return $this->db->get()->result();
    }
    public function getAllFoodMenusAPI($outlet_id,$company_id){
        $ids = explode(',', getApiFMIds($outlet_id, $company_id));
        $result = $this->db->select('tbl_food_menus.id, tbl_food_menus.name, tbl_food_menus.alternative_name, tbl_food_menus.code, tbl_food_menus.photo, tbl_food_menus.sale_price, tbl_food_menus.sale_price_take_away, tbl_food_menus.sale_price_delivery, tbl_food_menus.delivery_price, tbl_food_menus.category_id, tbl_food_menu_categories.category_name')
            ->from('tbl_food_menus')
            ->join('tbl_food_menu_categories', 'tbl_food_menus.category_id = tbl_food_menu_categories.id', 'left')
            ->where_in('tbl_food_menus.id', $ids)
            ->where('tbl_food_menus.del_status', 'Live')
            ->where('tbl_food_menus.parent_id', '0')
            ->order_by('tbl_food_menus.name', 'ASC')
            ->get();

        return $result ? $result->result() : false;
      }
      public function getCartProduct($outlet_id, $company_id,$user_id) {
        $this->db->select("id,json_content");
        $this->db->from("tbl_carts");
        $this->db->where("outlet_id", $outlet_id); 
        $this->db->where("company_id", $company_id); 
        $this->db->where("user_id", $user_id); 
        $data =  $this->db->get()->row();
        return $data;
    }
    public function getOutlets($company_id) {
        $this->db->select("id,outlet_name,outlet_code");
        $this->db->from("tbl_outlets");
        $this->db->where("company_id", $company_id); 
        $this->db->where("del_status", "Live"); 
        $data =  $this->db->get()->result();
        return $data;
    }
    public function online_order_sales_adminAPI($outlet_id,$user_id){ 
        $this->db->select("tbl_kitchen_sales.id,tbl_kitchen_sales.sale_no,tbl_kitchen_sales.order_type,tbl_kitchen_sales.orders_table_text as table_no,tbl_kitchen_sales.sale_date,tbl_customers.name as customer_name,tbl_users.full_name as waiter_name,tbl_kitchen_sales.date_time as order_placement_time,sub_total,total_discount_amount as discount,vat as tax,tips_amount_actual_charge as tips,delivery_charge_actual_charge as charge,total_payable as grand_total");
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.waiter_id', 'left');
        $this->db->where("tbl_kitchen_sales.outlet_id", $outlet_id);
        $this->db->where("tbl_kitchen_sales.user_id", $user_id);
        $this->db->where("tbl_kitchen_sales.del_status", "Live"); 
        $this->db->order_by('tbl_kitchen_sales.id', 'DESC');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    public function getDraftOrders($outlet_id,$user_id){ 
        $this->db->select("tbl_holds.id,tbl_holds.sale_no,tbl_holds.order_type,tbl_holds.orders_table_text as table_no,tbl_holds.sale_date,tbl_customers.name as customer_name,tbl_users.full_name as waiter_name,tbl_holds.date_time as order_placement_time,sub_total,total_discount_amount as discount,vat as tax,tips_amount_actual_charge as tips,delivery_charge_actual_charge as charge,total_payable as grand_total");
        $this->db->from('tbl_holds');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_holds.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_holds.waiter_id', 'left');
        $this->db->where("tbl_holds.outlet_id", $outlet_id);
        $this->db->where("tbl_holds.user_id", $user_id);
        $this->db->where("tbl_holds.del_status", "Live"); 
        $this->db->order_by('tbl_holds.id', 'DESC');
        $result = $this->db->get();
        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    public function get_order_details_adminAPIBySaleId($sale_id){
        $this->db->select("tbl_kitchen_sales.id,tbl_kitchen_sales.sale_no,tbl_kitchen_sales.order_type,tbl_kitchen_sales.orders_table_text as table_no,tbl_kitchen_sales.sale_date,tbl_customers.name as customer_name,tbl_users.full_name as waiter_name,tbl_kitchen_sales.date_time as order_placement_time,sub_total,total_discount_amount as discount,vat as tax,tips_amount_actual_charge as tips,delivery_charge_actual_charge as charge,total_payable as grand_total");
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.waiter_id', 'left');
        $this->db->where("tbl_kitchen_sales.id", $sale_id);
        $this->db->where("tbl_kitchen_sales.del_status", "Live");
        $result = $this->db->get();
        return $result->row();
    }
    public function getFoodMenuDetailsBySaleId($sale_id){
        $this->db->select("food_menu_id,menu_name as product_name,qty,menu_price_with_discount as total_sale_price,discount_amount as discount,menu_note");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->where("tbl_kitchen_sales_details.sales_id", $sale_id);
        $this->db->where("tbl_kitchen_sales_details.del_status", "Live");
        $result = $this->db->get();
        return $result->result();
    }
    public function getDraftSaleFoods($sale_id){
        $this->db->select("food_menu_id,menu_name as product_name,qty,menu_price_with_discount as total_sale_price,discount_amount as discount,menu_note");
        $this->db->from('tbl_holds_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("del_status", "Live");
        $result = $this->db->get();
        return $result->result();
    }
    public function getModifiersBySaleId($sale_id){
        $this->db->select("tbl_kitchen_sales_details_modifiers.modifier_id,tbl_modifiers.name as modifier_name,tbl_kitchen_sales_details_modifiers.modifier_price");
        $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_kitchen_sales_details_modifiers.modifier_id', 'left');
        $this->db->from('tbl_kitchen_sales_details_modifiers');
        $this->db->where("tbl_kitchen_sales_details_modifiers.sales_id", $sale_id); 
        $result = $this->db->get();
        return $result->result();
    }
    public function getDraftModifiersBySaleId($sale_id){
        $this->db->select("tbl_holds_details_modifiers.modifier_id,tbl_modifiers.name as modifier_name,tbl_holds_details_modifiers.modifier_price");
        $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_holds_details_modifiers.modifier_id', 'left');
        $this->db->from('tbl_holds_details_modifiers');
        $this->db->where("tbl_holds_details_modifiers.sales_id", $sale_id); 
        $result = $this->db->get();
        return $result->result();
    }
    public function ready_to_pickup_orders($outlet_id,$company_id){
        $this->db->select('tbl_kitchen_sales.id,order_type,tbl_kitchen_sales.sale_no,tbl_customers.name as customer_name');
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->where('tbl_kitchen_sales.del_status', "Live");
        $this->db->where('tbl_kitchen_sales.is_pickup_sale', 1);
        $this->db->where("tbl_kitchen_sales.is_accept", 1);
        $this->db->where("tbl_kitchen_sales.is_kitchen", 1);
        $this->db->where('tbl_kitchen_sales.outlet_id', $outlet_id);
        $results =  $this->db->get()->result();

        $results = array_values($results);
      
        $company = getCompanyInfoById($company_id);

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
                unset($results[$ky]);
            }else if($done==sizeof($items)){
                //all done green
                $status = 2;
            }else{
                //inprogress
                $status = 1;
            } 
            if($company->show_order_full_short==1){
                $sale_no_parts = explode('-', $value->sale_no);
                $value->sale_no = end($sale_no_parts);
            }
            
            $value->status = $status;
        }
        return $results;
    }
    public function remove_order_from_screen($id,$company_id){
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        $this->db->delete('tbl_carts');
    }
    public function getOutletsByUserId($outlets,$role,$company_id){
        $this->db->select('id,outlet_name,outlet_code');
        $this->db->from('tbl_outlets'); 
        if($role!="Admin"){
            $this->db->where("FIND_IN_SET(id, '$outlets')", null, false);
        } 
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }
    public function getPrinterIdByCounterId($counter_id){
        $this->db->select("id as counter_id, name as counter_name");
        $this->db->from("tbl_counters");
        $this->db->where('id', $counter_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result;
        }
    }
    public function isOpenRegister($user_id, $outlet_id){
        $this->db->select('*');
        $this->db->from('tbl_register');
        $this->db->where("user_id", $user_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("register_status", 1);
        $this->db->order_by('id', 'DESC');
        $row_details =  $this->db->get()->row();
        
        $counter_details = $this->getPrinterIdByCounterId($row_details->counter_id);
        return $counter_details;
    }
    public function getOpeningDateTime($counter_id, $outlet_id)
    {
      $this->db->select("opening_balance_date_time as opening_date_time,opening_details");
      $this->db->from('tbl_register');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("register_status", 1);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->row();
    }
    public function getAllPurchaseByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(paid) as total_amount");
      $this->db->from('tbl_purchase');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("added_date_time>=", $date);
      $this->db->where("added_date_time<=", date('Y-m-d H:i:s'));
      $this->db->where('del_status', 'Live');
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    public function getAllDueReceiveByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(amount) as total_amount");
      $this->db->from('tbl_customer_due_receives');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("date>=", $date);
      $this->db->where("date<=", date('Y-m-d H:i:s'));
      $this->db->where('del_status', 'Live');
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }  
    public function getAllDuePaymentByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(amount) as total_amount");
      $this->db->from('tbl_supplier_payments');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("added_date_time	>=", $date);
      $this->db->where("added_date_time	<=", date('Y-m-d H:i:s'));
      $this->db->where('del_status', 'Live');
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    public function getAllExpenseByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(amount) as total_amount");
      $this->db->from('tbl_expenses');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("added_date_time	>=", $date);
      $this->db->where("added_date_time	<=", date('Y-m-d H:i:s'));
      $this->db->where('del_status', 'Live');
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    public function getAllRefundByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(total_refund) as total_amount");
      $this->db->from('tbl_sales');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("refund_date_time	>=", $date);
      $this->db->where("refund_date_time	<=", date('Y-m-d H:i:s'));
      $this->db->where("refund_payment_id", $payment_id);
      $this->db->where("del_status", "Live");
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    public function getAllSaleByPayment($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(amount) as total_amount");
      $this->db->from('tbl_sale_payments');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("date_time	>=", $date);
      $this->db->where("date_time	<=", date('Y-m-d H:i:s'));
      $this->db->where("currency_type", null);
      $this->db->where('del_status', 'Live');
      $data =  $this->db->get()->row();
      return (isset($data->total_amount) && $data->total_amount?$data->total_amount:0);
    }
    
    public function getAllSaleByPaymentMultiCurrencyRows($date,$payment_id,$counter_id,$outlet_id)
    {
      $this->db->select("sum(amount) as total_amount,multi_currency");
      $this->db->from('tbl_sale_payments');
      $this->db->where("counter_id", $counter_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("payment_id", $payment_id);
      $this->db->where("date_time	>=", $date);
      $this->db->where("date_time	<=", date('Y-m-d H:i:s'));
      $this->db->where("currency_type", 1);
      $this->db->where('del_status', 'Live');
      $this->db->group_by('multi_currency');
      $data =  $this->db->get()->result();
      return $data;
    }
    
    public function getNotificationByOutletId($outlet_id,$user_id)
    {
        $get_user = getUserDetails($user_id);
        $designation = $get_user->designation; 
        
        $this->db->select('*');
        $this->db->from('tbl_notifications');
            if($designation=="Waiter"){
                $this->db->where("waiter_id", $user_id);
            }
        $this->db->where("outlet_id", $outlet_id);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get();

        if($result != false){
          return $result->result();
        }else{
          return false;
        }
    }
    public function getKichenData($outlet_id){
        $this->db->select("
        tbl_kitchen_sales.id, 
        tbl_kitchen_sales.sale_no,
        tbl_kitchen_sales.cooking_start_time,
        tbl_kitchen_sales.order_time,
        CASE 
            WHEN tbl_kitchen_sales.order_type = 1 THEN 'Dine In'
            WHEN tbl_kitchen_sales.order_type = 2 THEN 'Take Away'
            WHEN tbl_kitchen_sales.order_type = 3 THEN 'Delivery'
            ELSE 'Unknown'
        END as order_type,
        tbl_customers.name as customer_name,
        orders_table_text as table_no
    ");
    $this->db->from('tbl_kitchen_sales'); 
    $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
    $this->db->where("tbl_kitchen_sales.is_self_order", "No");
    $this->db->where("tbl_kitchen_sales.outlet_id", $outlet_id);
    $this->db->where("(order_status='1' OR order_status='2')");
    $this->db->where("tbl_kitchen_sales.is_accept", 1);
    $this->db->order_by('tbl_kitchen_sales.id', 'ASC');
    return $this->db->get()->result();
    }

    public function getAllKitchenItemsFromSalesDetailBySalesId($sales_id,$kitchen_id){
        $this->db->select("tbl_kitchen_sales_details.id,tbl_kitchen_sales_details.sales_id,tbl_kitchen_sales_details.menu_name,qty,tbl_kitchen_sales_details.cooking_status,tbl_kitchen_sales_details.menu_note");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_kitchen_categories.kitchen_id", $kitchen_id);
        $this->db->where("tbl_kitchen_sales_details.cooking_status!=", "Done");
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $data =  $this->db->get()->result();
        return $data;
    }
     /**
     * get Modifiers By Sale And Sale Details Id
     * @access public
     * @return object
     * @param int
     * @param int
     */
    public function getModifiersBySaleAndSaleDetailsId($sales_id,$sale_details_id){
        $this->db->select("tbl_modifiers.name");
        $this->db->from('tbl_kitchen_sales_details_modifiers');
        $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_kitchen_sales_details_modifiers.modifier_id', 'left');
        $this->db->where("tbl_kitchen_sales_details_modifiers.sales_id", $sales_id);
        $this->db->where("tbl_kitchen_sales_details_modifiers.sales_details_id", $sale_details_id);
        $this->db->order_by('tbl_kitchen_sales_details_modifiers.id', 'ASC');
        return $this->db->get()->result(); 
    }

    public function getItemInfoByPreviousId($previous_id)
    {
        $this->db->select('tbl_kitchen_sales_details.*,tbl_food_menus.code as code,tbl_food_menus.name as menu_name');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->where("tbl_kitchen_sales_details.id", $previous_id);
        return $this->db->get()->row();   
    }

    public function getSaleBySaleId($sales_id){
        $this->db->select("tbl_kitchen_sales.orders_table_text,tbl_kitchen_sales.outlet_id,tbl_kitchen_sales.date_time,tbl_kitchen_sales.sale_no,waiter_id,tbl_users.full_name as waiter_name,tbl_customers.name as customer_name,tbl_tables.name as table_name,tbl_users.full_name as user_name");
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.user_id', 'left');
        $this->db->join('tbl_tables', 'tbl_tables.id = tbl_kitchen_sales.table_id', 'left');
        $this->db->join('tbl_users w', 'w.id = tbl_kitchen_sales.waiter_id', 'left');
        $this->db->where("tbl_kitchen_sales.id", $sales_id);
        $this->db->order_by('tbl_kitchen_sales.id', 'ASC');
        return $this->db->get()->result();
    }
    
    public function getReservations($outlet_id) { 
        $this->db->select('*');
        $this->db->from('tbl_reservations');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('status',"DESC");
        return $this->db->get()->result();
    }
    public function getTables($outlet_id, $area_id) { 
        $this->db->select('name,sit_capacity');
        $this->db->from('tbl_tables');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('area', $area_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id',"DESC");
        return $this->db->get()->result();
    }
    public function getAreas($outlet_id ) { 
        $this->db->select('id,area_name');
        $this->db->from('tbl_areas');
        $this->db->where('outlet_id', $outlet_id); 
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id',"DESC");
        return $this->db->get()->result();
    }
}


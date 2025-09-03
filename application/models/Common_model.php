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
  # This is Common_model Model
  ###########################################################
 */
class Common_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        if ($this->session->has_userdata('language')) {
            $language = $this->session->userdata('language');
        }else{
            $language = 'english';
        }
        $this->lang->load("$language", "$language");
        $this->config->set_item('language', $language);
    }
    /**
     * is Open Register
     * @access public
     * @return object
     * @param int
     * @param int
     */

    public function isOpenRegister($user_id, $outlet_id){
        $counter_id = $this->session->userdata('counter_id');
        
        $this->db->select('id');
        $this->db->from('tbl_register');
        $this->db->where("counter_id", $counter_id);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("register_status", 1);
        $this->db->order_by('id', 'DESC');
        $row =  $this->db->get()->num_rows();
        if($row){
            return $row;
        }else{
            $this->db->select('*');
            $this->db->from('tbl_register');
            $this->db->where("user_id", $user_id);
            $this->db->where("outlet_id", $outlet_id);
            $this->db->where("register_status", 1);
            $this->db->order_by('id', 'DESC');
            $row_details =  $this->db->get()->row();
            if($row_details){
                $counter_details = $this->Common_model->getPrinterIdByCounterId($row_details->counter_id);
                $printer_info = $this->Common_model->getPrinterInfoById($counter_details->invoice_printer_id);
                $print_arr = [];
                $print_arr['counter_id'] = $row_details->counter_id;
                $print_arr['counter_name'] = $counter_details->name;
                $print_arr['printer_id'] = $counter_details->invoice_printer_id;
                if($printer_info):
                     $print_arr['path'] = $printer_info->path;
                     $print_arr['title'] = $printer_info->title;
                     $print_arr['type'] = $printer_info->type;
                     $print_arr['characters_per_line'] = $printer_info->characters_per_line;
                     $print_arr['printer_ip_address'] = $printer_info->printer_ip_address;
                     $print_arr['printer_port'] = $printer_info->printer_port;
                     $print_arr['printing_choice'] = $printer_info->printing_choice;
                     $print_arr['ipvfour_address'] = $printer_info->ipvfour_address;
                     $print_arr['print_format'] = $printer_info->print_format;
                     $print_arr['inv_qr_code_enable_status'] = $printer_info->inv_qr_code_enable_status;
                endif;
                //bill
                $printer_info_bill = $this->Common_model->getPrinterInfoById($counter_details->bill_printer_id);
                $print_arr['bill_printer_id'] = $counter_details->bill_printer_id;
                if($printer_info_bill):
                     $print_arr['path_bill'] = $printer_info_bill->path;
                     $print_arr['title_bill'] = $printer_info_bill->title;
                     $print_arr['type_bill'] = $printer_info_bill->type;
                     $print_arr['characters_per_line_bill'] = $printer_info_bill->characters_per_line;
                     $print_arr['printer_ip_address_bill'] = $printer_info_bill->printer_ip_address;
                     $print_arr['printer_port_bill'] = $printer_info_bill->printer_port;
                     $print_arr['printing_choice_bill'] = $printer_info_bill->printing_choice;
                     $print_arr['ipvfour_address_bill'] = $printer_info_bill->ipvfour_address;
                     $print_arr['print_format_bill'] = $printer_info_bill->print_format;
                     $print_arr['inv_qr_code_enable_status_bill'] = $printer_info_bill->inv_qr_code_enable_status;
                endif;
                $this->session->set_userdata($print_arr);

                return true;
            }else{
                return 0;
            }
        }
    }
    /**
     * get Purchase Amount By User And Outlet Id
     * @access public
     * @return object
     * @param int
     * @param int
     */
    public function getPurchaseAmountByUserAndOutletId($user_id, $outlet_id){
        $this->db->select('SUM(paid) as total_purchase_amount');
        $this->db->from('tbl_purchase');
        $this->db->where("DATE(date)", date('Y-m-d'));
        $this->db->where("user_id", $user_id);
        $this->db->where("outlet_id", $outlet_id);
        return $this->db->get()->row();
    }
    /**
     * getRestaurantAdminUser
     * @access public
     * @return object
     * @param int
     */
    public function getRestaurantAdminUser($company_id){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where("del_status", "Live");
        $this->db->where("role", "Admin");
        $this->db->where("company_id", $company_id);
        return $this->db->get()->row();
    }
    /**
     * delete Custom Row
     * @access public
     * @return object
     * @param int
     * @param string
     * @param string
     */
    public function deleteCustomRow($id,$colm,$tbl) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($colm, $id);
        $this->db->update($tbl);
    }
    /**
     * get All By Custom Id
     * @access public
     * @return object
     * @param int
     * @param string
     * @param string
     * @param string
     */
    public function getAllByCustomId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();

        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * get All By Table
     * @access public
     * @return object
     * @param string
     */
    public function getAllByTable($table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where("del_status", 'Live');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }
    public function getAllByTableAsc($table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * return all custom table data
     * @access public
     * @return  boolean
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function getAllCustomData($tbl,$order_colm,$order_type,$where_colm,$coln_value) {
        $this->db->select('*');
        $this->db->from($tbl);
        if($order_colm!=''){
            $this->db->order_by($order_colm,$order_type);
        }
        if($where_colm!=''){
            $this->db->where($where_colm,$coln_value);
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();

        if($result != false){
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * get All By Table
     * @access public
     * @return object
     * @param string
     */
    public function getServiceCompanies() {
        $this->db->select("c.*, pp.price_interval, pp.monthly_cost, pp.price_for_month2");
        $this->db->from("tbl_companies c");
        $this->db->join("tbl_pricing_plans pp", 'pp.id = c.plan_id', 'left');
        $this->db->where("c.del_status", 'Live');
        $this->db->order_by("c.payment_clear", 'ASC');
        $this->db->order_by("c.id", 'DESC');
        return $this->db->get()->result();
    }
    /**
     * get All By Table
     * @access public
     * @return object
     * @param string
     */
    public function getServiceCompaniesYes() {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $this->db->where("del_status", 'Live');
        $this->db->where("payment_clear", 'Yes');
        $this->db->order_by("payment_clear", 'ASC');
        $this->db->order_by("id", 'DESC');
        return $this->db->get()->result();
    }
    /**
     * get All By Table
     * @access public
     * @return object
     * @param string
     */
    public function getPaymentInfo($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_payment_histories");
        $this->db->where("del_status", 'Live');
        $this->db->where("company_id", $company_id);
        $this->db->order_by("id", 'DESC');
        return $this->db->get()->row();
    }
    /**
     * get AdminInfo For Company
     * @access public
     * @return object
     * @param int
     */
    public function getAdminInfoForCompany($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("del_status", 'Live');
        $this->db->where("role", 'Admin');
        $this->db->where("company_id", $company_id);
        $this->db->order_by("id", 'DESC');
        return $this->db->get()->row();
    }
    /**
     * get AdminInfo For Company
     * @access public
     * @return object
     * @param int
     */
    public function checkExistingAdmin($email) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("del_status", 'Live');
        $this->db->where("email_address", $email);
        return $this->db->get()->row();
    }
    /**
     * get All Outlest By Assign
     * @access public
     * @return object
     * @param no
     */
    public function getAllOutlestByAssign() {
        $role = $this->session->userdata('role');
        $company_id = $this->session->userdata('company_id');
        $outlets = $this->session->userdata('session_outlets');
        if($role=="Admin"){
            $result = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND company_id = '$company_id'")->result();
        }else{
            $result = $this->db->query("SELECT * FROM tbl_outlets WHERE FIND_IN_SET(`id`, '$outlets') AND del_status='Live' AND company_id = '$company_id'")->result();
        }
        return $result;
    }
    public function getSelectedMenu($menus) {
        $result = $this->db->query("SELECT * FROM tbl_food_menus WHERE FIND_IN_SET(`id`, '$menus') AND del_status='Live'")->result();
        return $result;
    }
    /**
     * get All By Company Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllByCompanyId($company_id, $table_name) {
        $where = array(
            'company_id' => $company_id,
            'del_status' => 'Live'
        );
    
        if ($table_name == "tbl_food_menus") {
            $where['parent_id'] = 0;
        }
    
        $language_manifesto = $this->session->userdata('language_manifesto');
    
        if (str_rot13($language_manifesto) == "eriutoeri") {
            if ($table_name == "tbl_areas") {
                $this->db->order_by('id', 'ASC');
            }else{
                $this->db->order_by('id', 'DESC');
            }
            $query = $this->db->get_where($table_name, $where);
            return $query->result();
        } else {
            $outlet_id = $this->session->userdata('outlet_id');
            if ($table_name == "tbl_tables" || $table_name == "tbl_users") {
                $where['outlet_id'] = $outlet_id;
            }
            if ($table_name == "tbl_areas") {
                $this->db->order_by('id', 'ASC');
            }else{
                $this->db->order_by('id', 'DESC');
            }
            $query = $this->db->get_where($table_name, $where);
            return $query->result();
        }
    }
    /**
     * get Food Menu
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getFoodMenu($company_id, $table_name) {
        $where = "";
        if($table_name=="tbl_food_menus"){
            $where.=" AND parent_id =  '0'";
        }
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  $where
          ORDER BY name asc")->result();
        return $result;
    }
    /**
     * get By Company Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getByCompanyId($company_id, $table_name) {
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY id DESC")->row();
        return $result;
    }
    /**
     * get All By Company Id ForDropdown
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllByCompanyIdForDropdown($company_id, $table_name) {
        $where = "";
        if($table_name=="tbl_food_menus"){
            $where.=" AND parent_id =  '0'";
        }

        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live' $where 
          ORDER BY 2")->result();
        return $result;
    }
    /**
     * get All By Company Id ForDropdown
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getFoodMenuWithVariations($company_id, $table_name) {
        $where = "";
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live' $where 
          ORDER BY 2")->result();
        return $result;
    }
    /**
     * get All For Dropdown
     * @access public
     * @return object
     * @param string
     */
    public function getAllForDropdown($table_name) {
        $result = $this->db->query("SELECT * 
              FROM $table_name 
              WHERE del_status = 'Live'  
              ORDER BY 2")->result();
        return $result;
    }
    /**
     * get All By Outlet Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllByOutletId($outlet_id, $table_name) {
        $asc = "DESC";
        if($table_name=="tbl_areas"){
            $asc = "ASC";
        }
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE outlet_id=$outlet_id AND del_status = 'Live'  
          ORDER BY id $asc")->result();
        return $result;
    }
    /**
     * get All By Outlet Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getKitchenCategories($id='') {
        $company_id = $this->session->userdata('company_id');
        if($id==''){
            $result = $this->db->query("SELECT * FROM `tbl_food_menu_categories` WHERE id not in (select distinct cat_id FROM tbl_kitchen_categories WHERE del_status='Live') AND del_status='Live' AND company_id='$company_id'")->result();
        }else{
            $result = $this->db->query("SELECT * FROM `tbl_food_menu_categories` WHERE id not in (select distinct cat_id FROM tbl_kitchen_categories WHERE del_status='Live' AND kitchen_id!='$id') AND del_status='Live' AND company_id='$company_id'")->result();
        }
        return $result;
    }
    public function getKitchenCategoriesById($id) {
        $this->db->select('category_name');
        $this->db->from('tbl_kitchen_categories');
        $this->db->join('tbl_food_menu_categories', 'tbl_food_menu_categories.id = tbl_kitchen_categories.cat_id', 'left');
        $this->db->where('kitchen_id', $id);
        $this->db->where('tbl_kitchen_categories.del_status', 'Live');
        return $this->db->get()->result();
    }
    public function getAllViaPanel() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from('tbl_kitchens');
        $this->db->where('del_status', 'Live');
        $this->db->where('company_id', $company_id);
        return $this->db->get()->result();
    }
    public function checkForExist($id) {
        $this->db->select('id');
        $this->db->from('tbl_kitchen_categories');
        $this->db->where('cat_id', $id);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->row();
    }
    public function checkForExistUpdate($id,$outlet_id='') {
        $this->db->select('id');
        $this->db->from('tbl_kitchen_categories');
        $this->db->where('cat_id', $id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->row();
    }
    public function getDenomination($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_denominations");
        $this->db->where("del_status", 'Live');
        $this->db->where("company_id", $company_id);
        $this->db->order_by("amount", 'asc');
        return $this->db->get()->result();
    }
    public function getOrderDetailsWithKitchenStatus($sales_id){
        $this->db->select("tbl_kitchen_categories.kitchen_id");
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->order_by('tbl_sales_details.id', 'ASC');
        $data =  $this->db->get()->result();
        return $data;
    }
    public function getOrderDetailsForPrint($sales_id,$kitchen_id){
        $this->db->select("tbl_sales_details.*,tbl_kitchen_categories.kitchen_id");
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->where("tbl_sales_details.sales_id", $sales_id);
        $this->db->where("tbl_kitchen_categories.kitchen_id", $kitchen_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->order_by('tbl_sales_details.id', 'ASC');
        $this->db->group_by('tbl_sales_details.food_menu_id');
        $data =  $this->db->get()->result();
        return $data;
    }
    public function getOnlyKitchenID($sales_id){
        $this->db->select("tbl_kitchen_categories.kitchen_id");
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->where("tbl_sales_details.sales_id", $sales_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->order_by('tbl_sales_details.id', 'ASC');
        $this->db->group_by('tbl_kitchen_categories.kitchen_id');
        $data =  $this->db->get()->result();
        return $data;
    }
    public function getKitchenDetails($kitchen_id){
        $this->db->select("tbl_kitchens.print_server_url,tbl_printers.*");
        $this->db->from('tbl_kitchens');
        $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
        $this->db->where("tbl_kitchens.id", $kitchen_id);
        $this->db->where('tbl_kitchens.del_status', 'Live');
        $data =  $this->db->get()->row();
        return $data;
    }
    /**
     * get All By Outlet Id For Dropdown
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllByOutletIdForDropdown($outlet_id, $table_name) {
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE outlet_id=$outlet_id AND del_status = 'Live'  
          ORDER BY 2")->result();
        return $result;
    }
    /**
     * get Food Menu
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getFoodMenuForOutlet($company_id, $table_name) {
        $where = "";
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  $where
          ORDER BY name asc")->result();
        return $result;
    }
    /**
     * get All Food Menus By Category
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllFoodMenusByCategory($category_id, $table_name) {
        $where = "";
        if($table_name=="tbl_food_menus"){
            $where.=" AND parent_id =  '0'";
        }
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE category_id=$category_id AND del_status = 'Live' AND parent_id = '0' $where
          ORDER BY id DESC")->result();
        return $result;
    }
    /**
     * get All Modifier By CompanyId
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getAllModifierByCompanyId($company_id, $table_name) {
        $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live'  
          ORDER BY name ASC")->result();
        return $result;
    }
    /**
     * delete Status Change
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function deleteStatusChange($id, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where('id', $id);
        $this->db->update($table_name);
    }
    /**
     * delete Status Change
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function deleteStatusChangeByCustomRow($id,$field, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($field, $id);
        $this->db->update($table_name);
    }
    /**
     * delete Status Change With Child
     * @access public
     * @return object
     * @param int
     * @param int
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function deleteStatusChangeWithChild($id, $id1, $table_name, $table_name2, $filed_name, $filed_name1) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($filed_name, $id);
        $this->db->update($table_name);

        $this->db->set('del_status', "Deleted");
        $this->db->where($filed_name1, $id1);
        $this->db->update($table_name2);
    }
    /**
     * insert Information
     * @access public
     * @return int
     * @param array
     * @param string
     */
    public function insertInformation($data, $table_name) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getDataById($id, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where("id", $id);
        return $this->db->get()->row();
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getLastPayment($company_id) {
        $this->db->select("payment_date");
        $this->db->from('tbl_payment_histories');
        $this->db->where("company_id", $company_id);
        $this->db->order_by('id', 'DESC'); 
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getCountSaleNo($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->from('tbl_sales');
        $count = $this->db->count_all_results();
        return $count;
    }
    /**
     * get Data By Id
     * @access public
     * @return object
     * @param int
     * @param string
     */
    public function getFirstUserByCompanyId($company_id) {
        $this->db->select("*");
        $this->db->from('tbl_users');
        $this->db->where("company_id", $company_id);
        $this->db->order_by('id', 'ASC'); 
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    public function getActiveAddress($id) {
        $this->db->select("*");
        $this->db->from("tbl_customer_address");
        $this->db->where("customer_id", $id);
        $this->db->where("is_active", "1");
        return $this->db->get()->row();
    }
    public function getCustomDataByParams($field_name,$value, $table_name) {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where($field_name, $value);
        return $this->db->get()->row();
    }
    /**
     * update Information
     * @access public
     * @return void
     * @param array
     * @param int
     * @param string
     */
    public function updateInformation($data, $id, $table_name) {
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
    }
    /**
     * update Information By Company Id
     * @access public
     * @return void
     * @param array
     * @param int
     * @param string
     */
    public function updateInformationByCompanyId($data, $company_id, $table_name) {
        $this->db->where('company_id', $company_id);
        $this->db->update($table_name, $data);
    }
    /**
     * deleting Multiple Form Data
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function deletingMultipleFormData($field_name, $primary_table_id, $table_name) {
        $this->db->delete($table_name, array($field_name => $primary_table_id));
    }
    /**
     * get All Customers
     * @access public
     * @return object
     * @param no
     */
    public function getAllCustomers() {
        return $this->db->get("tbl_customers")->result();
    }
    /**
     * get Purchase Paid Amount
     * @access public
     * @return object
     * @param string
     */
    public function getPurchasePaidAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $ppaid = $this->db->query("SELECT IFNULL(SUM(p.paid),0) as ppaid
        FROM tbl_purchase p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('ppaid');
        return $ppaid;
    }
    /**
     * get Purchase Amount
     * @access public
     * @return float
     * @param string
     */
    public function getPurchaseAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalPurchase = $this->db->query("SELECT IFNULL(SUM(p.grand_total),0) as totalPurchase
        FROM tbl_purchase p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('totalPurchase');
        return $totalPurchase;
    }
    /**
     * get Supplier Paid Amount
     * @access public
     * @return object
     * @param string
     */
    public function getSupplierPaidAmount($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $partypaid = $this->db->query("SELECT IFNULL(SUM(p.amount),0) as partypaid
        FROM tbl_supplier_payments p  
        WHERE p.outlet_id=$outlet_id AND p.del_status = 'Live'
        AND p.date LIKE '$month%' ")->row('partypaid');
        return $partypaid;
    }
    /**
     * get Sale Paid Amount
     * @access public
     * @return float
     * @param string
     * @param boolean
     */
    public function getSalePaidAmount($month, $payment_method_id = FALSE) {
        $outlet_id = $this->session->userdata('outlet_id');
        $condition = " ";
        if ($payment_method_id != FALSE) {
            $condition = " AND s.payment_method_id=$payment_method_id";
        }
        $totalSale = $this->db->query("SELECT IFNULL(SUM(s.total_payable),0) as totalSale
        FROM tbl_sales s  
        WHERE s.outlet_id=$outlet_id AND s.del_status = 'Live'
        AND s.sale_date LIKE '$month%' $condition")->row('totalSale');
        return $totalSale;
    }
    /**
     * get Menu By Menu Name
     * @access public
     * @return object
     * @param string
     */
    public function getMenuByMenuName($menu_name){
      $this->db->select("*");
      $this->db->from('tbl_food_menus');
      $this->db->where("tbl_food_menus.name", $menu_name);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->row();      
    }
    /**
     * get Ingredient By Ingredient Name
     * @access public
     * @return object
     * @param string
     */
    public function getIngredientByIngredientName($menu_name){
      $this->db->select("*");
      $this->db->from('tbl_ingredients');
      $this->db->where("tbl_ingredients.name", $menu_name);
      $this->db->order_by('id', 'ASC');
      return $this->db->get()->row();      
    }
    /**
     * get Sale Vat
     * @access public
     * @return object
     * @param string
     */
    public function getSaleVat($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalSaleVat = $this->db->query("SELECT IFNULL(SUM(s.vat),0) as totalSaleVat
        FROM tbl_sales s  
        WHERE s.outlet_id=$outlet_id AND s.del_status = 'Live'
        AND s.sale_date LIKE '$month%'")->row('totalSaleVat');
        return $totalSaleVat;
    }
    /**
     * get Waste
     * @access public
     * @return float
     * @param string
     */
    public function getWaste($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalWaste = $this->db->query("SELECT IFNULL(SUM(w.total_loss),0) as totalWaste
        FROM tbl_wastes w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalWaste');
        return $totalWaste;
    }
    /**
     * get Expense
     * @access public
     * @return float
     * @param string
     */
    public function getExpense($month) {
        $outlet_id = $this->session->userdata('outlet_id');
        $totalExpense = $this->db->query("SELECT IFNULL(SUM(w.amount),0) as totalExpense
        FROM tbl_expenses w  
        WHERE w.outlet_id=$outlet_id AND w.del_status = 'Live'
        AND w.date LIKE '$month%'")->row('totalExpense');
        return $totalExpense;
    }
    /**
     * current Inventory
     * @access public
     * @return float
     * @param no
     */
    public function currentInventory() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');

        $result = $this->db->query("SELECT i.*,(select SUM(quantity_amount) from tbl_purchase_ingredients where ingredient_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_purchase, 
                (select SUM(consumption) from tbl_sale_consumptions_of_menus where ingredient_id=i.id AND outlet_id=$outlet_id AND del_status='Live') total_consumption,
                (select SUM(waste_amount) from tbl_waste_ingredients  where ingredient_id=i.id AND outlet_id=$outlet_id AND tbl_waste_ingredients.del_status='Live') total_waste,
                (select category_name from tbl_ingredient_categories where id=i.category_id  AND del_status='Live') category_name,
                (select unit_name from tbl_units where id=i.unit_id AND del_status='Live') unit_name
                FROM tbl_ingredients i WHERE i.del_status='Live' AND i.company_id= '$company_id' ORDER BY i.name ASC")->result();
        $grandTotal = 0;
        foreach ($result as $value) {
            $totalStock = $value->total_purchase - $value->total_consumption - $value->total_waste;
            if ($totalStock >= 0) {
                $grandTotal = $grandTotal + $totalStock * getLastPurchaseAmount($value->id);
            }
        }
        return $grandTotal;
    }
    /**
     * top ten food menu
     * @access public
     * @return object
     * @param string
     * @param string
     */
    public function top_ten_food_menu($start_date, $end_date) {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(qty) as totalQty,food_menu_id,menu_name,sale_date');
        $this->db->from('tbl_sales_details');
        $this->db->join('tbl_sales', 'tbl_sales.id = tbl_sales_details.sales_id', 'left');
        $this->db->where('sale_date>=', $start_date);
        $this->db->where('sale_date <=', $end_date);
        $this->db->order_by('totalQty desc');
        $this->db->where('tbl_sales_details.outlet_id', $outlet_id);
        $this->db->where('tbl_sales_details.del_status', 'Live');
        $this->db->group_by('food_menu_id');
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    public function deleteStatusChangeWithCustom($id,$filed_name, $table_name) {
        $this->db->set('del_status', "Deleted");
        $this->db->where($filed_name, $id);
        $this->db->update($table_name);
    }
    /**
     * top ten supplier payable
     * @access public
     * @return object
     * @param no
     */
    public function top_ten_supplier_payable() {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(due) as totalDue,supplier_id,date,name');
        $this->db->from('tbl_purchase');
        $this->db->join('tbl_suppliers', 'tbl_suppliers.id = tbl_purchase.supplier_id', 'left');
        $this->db->order_by('totalDue desc');
        $this->db->where('tbl_purchase.outlet_id', $outlet_id);
        $this->db->where('tbl_purchase.del_status', 'Live');
        $this->db->group_by('tbl_purchase.supplier_id');
        return $this->db->get()->result();
    }
    /**
     * top ten supplier payable
     * @access public
     * @return object
     * @param no
     */
    public function getPaymentHistory($company_id='') {
        $this->db->select('tbl_payment_histories.*,tbl_companies.business_name');
        $this->db->from('tbl_payment_histories');
        $this->db->join('tbl_companies', 'tbl_companies.id = tbl_payment_histories.company_id', 'left');
        if($company_id!=''){
            $this->db->where('tbl_payment_histories.company_id', $company_id);
        }
        $this->db->where('tbl_payment_histories.del_status', 'Live');
        $this->db->order_by('tbl_payment_histories.id',"DESC");
        return $this->db->get()->result();
    }
    /**
     * get Payable Amount By Supplier Id
     * @access public
     * @return float
     * @param int
     */
    public function getPayableAmountBySupplierId($id) {
        $this->load->model('Report_model', 'Report_model');
        $month = date('Y-m');
        $monthOnly = date('m', strtotime($month));
        $finalDayByMonth = $this->Report_model->getLastDayInDateMonth($monthOnly);
        $temp = $month . '-' . $finalDayByMonth;
        $start_date = $month . '-' . '01';
        $end_date = $temp;
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('sum(amount) as totalPayment,supplier_id,date');
        $this->db->from('tbl_supplier_payments');
        $this->db->where('date>=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('supplier_id', $id);
        $this->db->where('del_status', 'Live');
        $this->db->group_by('supplier_id');
        $result = $this->db->get()->row();
        if (!empty($result)) {
            return $result->totalPayment;
        } else {
            return 0.0;
        }
    }
    /**
     * comparison sale report
     * @access public
     * @return object
     * @param string
     * @param string
     */
    public function comparison_sale_report($start_date, $end_date) {
        $outlet_id = $this->session->userdata('outlet_id');
        $query = $this->db->query("select year(sale_date) as year, month(sale_date) as month, sum(total_payable) as total_amount from tbl_sales WHERE `sale_date` BETWEEN '$start_date' AND '$end_date' AND outlet_id='$outlet_id' group by year(sale_date), month(sale_date)");
        return $query->row();
    }
    /**
     * set Default Timezone
     * @access public
     * @return void
     */
    public function setDefaultTimezone() {
        $this->db->select("zone_name");
        $this->db->from('tbl_companies');
        $this->db->where('del_status', "Live");
        $zoneName = $this->db->get()->row();
        if ($zoneName)
            date_default_timezone_set($zoneName->zone_name);
    }
    /**
     * get custom row depend on parameters
     * @access public
     * @return object
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function get_row($table_name, $where_param, $select_param, $group = "", $limit = "") {
        if (!empty($select_param))
            $this->db->select($select_param);
        if (!empty($where_param))
            $this->db->where($where_param);
        $this->db->group_by($group);
        if (!empty($limit))
            $this->db->limit($limit);
        $result = $this->db->get($table_name);
        return $result->result();
    }
    /**
     * get custom row array depend on parameters
     * @access public
     * @return object
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param boolean
     * @param boolean
     */
    public function get_row_array($table_name, $where_param, $select_param, $group = "", $limit = "", $order_by = false, $order_value = false) {
        if (!empty($select_param))
            $this->db->select($select_param);
        if (!empty($where_param))
            $this->db->where($where_param);
        if (!empty($group))
            $this->db->group_by($group);
        if (!empty($order_by))
            $this->db->order_by($order_by, $order_value);
        if (!empty($limit))
            $this->db->limit($limit);
        $result = $this->db->get($table_name);
        return $result->result_array();
    }
    /**
     * custom Query
     * @access public
     * @return object
     * @param string
     */
    public function customeQuery($sql) {
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    /**
     * qcode function
     * @access public
     * @return string
     * @param string
     * @param string
     * @param int
     */
    public function qcode_function($code,$level='S',$size=2){       
            $this->load->library('ci_qr_code');
            $this->config->load('qr_code');
            $qr_code_config = array(); 
            $qr_code_config['cacheable']    = $this->config->item('cacheable');
            $qr_code_config['cachedir']     = $this->config->item('cachedir');
            $qr_code_config['imagedir']     = $this->config->item('imagedir');
            $qr_code_config['errorlog']     = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib']  = $this->config->item('ciqrcodelib');
            $qr_code_config['quality']      = $this->config->item('quality');
            $qr_code_config['size']         = $this->config->item('size');
            $qr_code_config['black']        = $this->config->item('black');
            $qr_code_config['white']        = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            $image_name =$code.'.png';
            $params['data'] = $code;
            $params['level'] = 'S';
            $params['size'] =3;
            $params['savename'] = FCPATH.$qr_code_config['imagedir'].$image_name;
            $this->ci_qr_code->generate($params); 
            $qr_code_image_url = base_url().$qr_code_config['imagedir'].$image_name;
            return $qr_code_image_url;
    }
    /**
     * check existing account by email
     * @access public
     * @param string
     */
    public function checkExistingAccountByEmail($email){
        $this->db->select('*');
        $this->db->from("tbl_customers");
        $this->db->where("email", $email);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    /**
     * check $sales_id
     * @access public
     * @param string
     */
    public function getAllKitchenItems($sales_id,$printer_id,$kot_print){
        $this->db->select("tbl_kitchen_sales_details.menu_name,tbl_kitchen_sales_details.qty,tbl_kitchen_sales_details.food_menu_id,tbl_kitchen_sales_details.tmp_qty,tbl_kitchen_sales_details.menu_combo_items,tbl_kitchen_sales_details.menu_note as item_note,tbl_kitchen_sales_details.id as sales_details_id,tbl_printers.id as printer_id");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
        $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_printers.id", $printer_id);
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->where("tbl_kitchen_sales_details.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $this->db->group_by('tbl_kitchen_sales_details.id');
        $data =  $this->db->get()->result();
        return $data;
    }
    /**
     * check $sales_id
     * @access public
     * @param string
     */
    public function getAllKitchenItemsAuto($sales_id,$printer_id,$kot_print=0){
        $this->db->select("tbl_kitchen_sales_details.menu_name,tbl_kitchen_sales_details.menu_note,tbl_kitchen_sales_details.qty,tbl_kitchen_sales_details.food_menu_id,tbl_kitchen_sales_details.tmp_qty,tbl_kitchen_sales_details.menu_combo_items,tbl_kitchen_sales_details.id as sales_details_id,tbl_kitchen_sales_details.is_print,tbl_printers.id as printer_id");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
        $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_printers.id", $printer_id);
        if($kot_print==2){
            $this->db->where("tbl_kitchen_sales_details.is_print", 1);
        } 
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $this->db->group_by('tbl_kitchen_sales_details.id');
        $data =  $this->db->get()->result();
      
        
        return $data;
    }

    /**
     * check getOrderedPrinter
     * @access public
     * @param string
     */
    public function getOrderedPrinter($sales_id,$type=''){
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select("tbl_kitchen_sales_details.outlet_id,tbl_printers.*,tbl_kitchens.name as kitchen_name,tbl_kitchens.id as kitchen_id");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
        $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_printers.outlet_id", $outlet_id);
        $this->db->where("tbl_kitchen_sales_details.outlet_id", $outlet_id);
        if($type==2){
            $this->db->where("tbl_printers.printing_choice", "direct_print");
        }else{
            $this->db->where("tbl_printers.printing_choice", "web_browser_popup");
        }
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $this->db->group_by('tbl_printers.id');
        $data =  $this->db->get()->result();
        return $data;
    }
    /**
     * check getOrderedKitchens
     * @access public
     * @param string
     */
    public function getOrderedKitchens($sales_id){
        $this->db->select("tbl_kitchens.id as kitchen_id");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
        $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $this->db->group_by('tbl_kitchens.id');
        $data =  $this->db->get()->result();
        return $data;
    }
    /**
     * check checkPrinterForKOT
     * @access public
     * @param string
     */
        public function checkPrinterForKOT($sales_id){
            $outlet_id = $this->session->userdata('outlet_id');
            $this->db->select("tbl_printers.*,tbl_kitchens.id as kitchen_id,tbl_kitchens.name as kitchen_name");
            $this->db->from('tbl_kitchen_sales_details');
            $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
            $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
            $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
            $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
            $this->db->where("sales_id", $sales_id);
            $this->db->where("tbl_kitchens.outlet_id", $outlet_id);
            $this->db->where("tbl_kitchen_categories.del_status", "Live");
            $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
            $this->db->group_by('tbl_kitchens.id');
            $data =  $this->db->get()->result();
            return $data;
        }
    /**
     * check get Selected Printers
     * @access public
     * @param int
     * @param int
     */
        public function getSelectedPrinters($sales_id,$kitchen_id,$type=''){
            $printers  = explode(",",$kitchen_id);
            $this->db->select("tbl_printers.*,tbl_kitchens.name as kitchen_name,tbl_kitchens.id as kitchen_id");
            $this->db->from('tbl_kitchen_sales_details');
            $this->db->join('tbl_kitchen_sales', 'tbl_kitchen_sales.id = tbl_kitchen_sales_details.sales_id', 'left');
            $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
            $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
            $this->db->join('tbl_kitchens', 'tbl_kitchens.id = tbl_kitchen_categories.kitchen_id', 'left');
            $this->db->join('tbl_printers', 'tbl_printers.id = tbl_kitchens.printer_id', 'left');
            $this->db->where("sale_no", $sales_id);
            $this->db->where("tbl_kitchen_categories.del_status", "Live");
            if($type==2){
                $this->db->where("tbl_printers.printing_choice", "direct_print");
            }else{
                $this->db->where("tbl_printers.printing_choice", "web_browser_popup");
            }
            $this->db->where_in('tbl_kitchens.id',$printers);
            $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
            $this->db->group_by('tbl_printers.id');
            $data =  $this->db->get()->result();
            return $data; 
            
        }

        
    /**
     * get AllBy Custom Row Id
     * @access public
     * @param int
     * @param string
     * @param string
     * @param string
     */
    public function getAllByCustomRowId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    public function getAllByCustomResultsId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }
    /**
     * get Pre Made Ingredients,
     * @access public
     * @param int
     * @param string
     */
    public function getPreMadeIngredients($company_id,$status) {
        $this->db->select('*');
        $this->db->from('tbl_ingredients');
        $this->db->where('company_id', $company_id);
        $this->db->where('ing_type', $status);
        $this->db->where('del_status',"Live");
        $this->db->order_by('id',"DESC");
        return $this->db->get()->result();
    }
    /**
     * check get Access List
     * @access public
     * @param no
     */
    public function getAccessList() {
        $company_id = $this->session->userdata('company_id');
        $status_sa = false;
        if(!isServiceAccess('','','sGmsJaFJE')){
            $status_sa  = true;
        }

        $this->db->select('*');
        $this->db->from('tbl_access');
        if($company_id!=1){
            $this->db->where('main_module_id!=', 2);
        }
        if($status_sa){
            $this->db->where('main_module_id!=', 2);
            $this->db->where('id!=', 316);
        }
        $this->db->where('parent_id', "0");
        $this->db->where('del_status',"Live");
        $this->db->order_by('main_module_id',"DESC");
        return $this->db->get()->result();
    }
    /**
     * check get Reservations
     * @access public
     * @param no
     */
    public function getReservations() {
        $outlet_id = $this->session->userdata('outlet_id');
        $this->db->select('*');
        $this->db->from('tbl_reservations');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('status',"DESC");
        return $this->db->get()->result();
    }
    /**
     * check get Sorting For POS
     * @access public
     * @param no
     */
    public function getSortingForPOS() {
        $company_id = $this->session->userdata('company_id');
        $this->db->select('*');
        $this->db->from('tbl_food_menu_categories');
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('order_by',"ASC");
        return $this->db->get()->result();
    }
    public function getSortingForPOSApi($company_id) { 
        $this->db->select('*');
        $this->db->from('tbl_food_menu_categories');
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('order_by',"ASC");
        return $this->db->get()->result();
    }
    /**
     * check get Data Custom Name
     * @access public
     * @param string
     * @param string
     * @param string
     */
    public function getDataCustomName($tbl, $db_field,$search_value){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($db_field, $search_value);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }
    public function getTables() {
        $area_id = escape_output($_POST['id']);
        $this->db->select('*');
        $this->db->from('tbl_tables');
        $this->db->where('area', $area_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id',"DESC");
        return $this->db->get()->result();
    }
    public function getNewAddedTable() {
        $area_id = escape_output($_POST['id']);
        $this->db->select('*');
        $this->db->from('tbl_tables');
        $this->db->where('is_setting', 0);
        $this->db->where('area', $area_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('id',"DESC");
        return $this->db->get()->result();
    }
    /**
     * check get Kitchen Categories By Ajax
     * @access public
     * @param no
     */
    public function getKitchenCategoriesByAjax($id='') {
        $company_id = $this->session->userdata('company_id');

        $outlet_id = '';
        if(isLMni()):
            $outlet_id = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        else:
             $outlet_id =  $this->session->userdata('outlet_id');
       endif;     

        if($outlet_id){
 
            $sql = "
                SELECT * 
                FROM `tbl_food_menu_categories` 
                WHERE id NOT IN (
                    SELECT DISTINCT cat_id 
                    FROM tbl_kitchen_categories 
                    WHERE del_status = 'Live' 
                    AND outlet_id = '$outlet_id'
                ) 
                AND del_status = 'Live' 
                AND company_id = '$company_id'

                UNION

                SELECT * 
                FROM `tbl_food_menu_categories` 
                WHERE id NOT IN (
                    SELECT DISTINCT cat_id 
                    FROM tbl_kitchen_categories 
                    WHERE del_status = 'Live' 
                    AND outlet_id = '$outlet_id' 
                    AND kitchen_id != '$id'
                ) 
                AND del_status = 'Live' 
                AND company_id = '$company_id';
            ";

                $result = $this->db->query($sql)->result();
                foreach ($result as $key=>$value){
                    $result[$key]->outlet_id = $outlet_id;
                }
        }
        return $result;
    }
    /**
     * check get Waiter Orders
     * @access public
     * @param no
     */
    public function getWaiterOrders() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $role = $this->session->userdata('role');
        $designation = $this->session->userdata('designation');

        if($role=="Admin"){
            $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update_admin=1 AND is_accept=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id_admin='$user_id'")->result();
        }else{
            if($designation=="Cashier"){
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update_cashier=1 AND is_accept=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id='$user_id'")->result();
            }else{
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update=1 AND is_accept=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id='$user_id'")->result();
            }
        }
        return $result;
    }
    /**
     * check get Waiter Orders For Update Sender
     * @access public
     * @param no
     */
    public function getWaiterOrdersForUpdateSender() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND is_update_sender=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND user_id='$user_id'")->result();
        return $result;
    }
    /**
     * check get Waiter Orders For Update Receiver
     * @access public
     * @param no
     */
    public function getWaiterOrdersForUpdateReceiver() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $role = $this->session->userdata('role');
      
        if($role=="Admin"){
            $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND is_update_receiver_admin=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id_admin='$user_id'")->result();
        }else{
            $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND is_update_receiver=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id='$user_id'")->result();
        }

        return $result;
    }
    /**
     * check get Waiter Orders For Delete Sender
     * @access public
     * @param string
     */
    public function getWaiterOrdersForDeleteSender() {
        $sale_no_all = escape_output($_POST['sale_no_all']);
        $sale_no_string = '';
        if($sale_no_all){
            $expload = explode(",",$sale_no_all);
            foreach($expload as $ky=>$value){
                if($value){
                    $data_sale = getKitchenSaleDetailsBySaleNo($value);
                    if($data_sale){

                    }else{
                        $sale_no_string.=$value;
                        if($ky<(sizeof($expload))-1){
                            $sale_no_string.=",";
                        }
                    }
                    
                }
            }
        }
        
        return $sale_no_string;
    }
    /**
     * check get Waiter Orders For Delete Receiver
     * @access public
     * @param no
     */
    public function getWaiterOrdersForDeleteReceiver() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $role = $this->session->userdata('role');
        $designation = $this->session->userdata('designation');
        if($role=="Admin"){
            $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND is_delete_receiver_admin=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id_admin='$user_id'")->result();
        }else{
            if($designation=="Cashier"){
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no  in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live' AND is_delete_receiver=1 AND company_id='$company_id' AND outlet_id='$outlet_id'")->result();
            }else{
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no not in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND is_delete_receiver=1 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id='$user_id'")->result();
            }
        }
        return $result;
    }
    public function getOrderedTable() {
        $outlet_id = $this->session->userdata('outlet_id');
        $result = $this->db->query("SELECT * FROM `tbl_running_order_tables` WHERE del_status='Live' AND outlet_id='$outlet_id'")->result();
        return $result;
    }
    /**
     * check get Waiter Invoice Orders
     * @access public
     * @param no
     */
    public function getWaiterInvoiceOrders() {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $role = $this->session->userdata('role');
        $designation = $this->session->userdata('designation');
        if($role=="Admin"){
            $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update_admin=2 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id_admin='$user_id'")->result();
        }else{
            if($designation=="Cashier"){
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update_cashier=2 AND company_id='$company_id' AND outlet_id='$outlet_id' AND order_receiving_id='$user_id'")->result();
            }else{
                $result = $this->db->query("SELECT id,sale_no,self_order_content FROM `tbl_kitchen_sales` WHERE sale_no in (select distinct sale_no FROM tbl_sales WHERE del_status='Live' AND outlet_id='$outlet_id' AND company_id='$company_id') AND del_status='Live'  AND pull_update=2 AND company_id='$company_id' AND outlet_id='$outlet_id' AND user_id='$user_id'")->result();
            }
        }
        return $result;
    }
        /**
     * getAllPrinter
     * @access public
     * @param int
     * @return object
     * Added By Azhar
     */
    public function getAllPrinter($company_id) {
		$this->db->select('*');
		$this->db->from('tbl_printers');
		$this->db->where('company_id', $company_id);
		$this->db->where('del_status', 'Live');
		$result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }
    /**
     * getPrinterIdByCounterId
     * @access public
     * @param int
     * @return int
     */
    public function getPrinterIdByCounterId($counter_id){
        $this->db->select("name,invoice_printer_id,bill_printer_id");
        $this->db->from("tbl_counters");
        $this->db->where('id', $counter_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result;
        }
    }

    /**
     * getPrinterInfoById
     * @access public
     * @param int
     * @return object
     */
    public function getPrinterInfoById($printer_id){
        $this->db->select("*");
        $this->db->from("tbl_printers");
        $this->db->where('id', $printer_id);
        $this->db->where('del_status', 'Live');
        $result = $this->db->get()->row();
        if($result){
            return $result;
        }
    }
    /**
     * getAllCounters
     * @access public
     * @param int
     * @param string
     * @return object
     * Added By Azhar
     */
    public function getAllCounters($company_id) {
        $this->db->select("c.id, c.name as counter_name, c.description, c.added_date, o.outlet_name, p.title as invoice_printer,pb.title as bill_printer, u.full_name as added_by");
        $this->db->from('tbl_counters c');
        $this->db->join("tbl_outlets o", "o.id = c.outlet_id", 'left');
        $this->db->join("tbl_printers p", "p.id = c.invoice_printer_id", 'left');
        $this->db->join("tbl_printers pb", "pb.id = c.bill_printer_id", 'left');
        $this->db->join("tbl_users u", "u.id = c.user_id", 'left');
        $this->db->where("c.company_id", $company_id);
        $this->db->where("c.del_status", 'Live');
        $this->db->order_by("c.id", 'DESC');
        $result = $this->db->get(); 
        if($result != false){  
            return $result->result();
        }else{
            return false;
        }
    }

    /**
     * check get Waiter Invoice Orders
     * @access public
     * @param no
     */
    public function alreadyInvoicedOrders() {
        $sale_no_all = escape_output($_POST['sale_no_all']);
        $spt = explode(',',$sale_no_all);
        $arr = array();
        foreach ($spt as $key=>$value){
            if($value){
                $row = getSaleDetailsBySaleNo($value);
                if(isset($row) && $row){
                    $inline_arr = array();
                    $inline_arr['sale_no'] =  $value;
                    $arr[] = $inline_arr;

                    $selected = getKitchenSaleDetailsBySaleNo($value);
                    $pre_or_post_payment = $this->session->userdata('pre_or_post_payment');
                    if($pre_or_post_payment!=2){
                        $this->db->delete("tbl_sales_details", array("sales_id" => $selected->id));
                        $this->db->delete("tbl_sales_details_modifiers", array("sales_id" => $selected->id));
                        $this->db->delete("tbl_sales", array("id" => $selected->id));
                    } 
                } 
            }
        }
        return $arr;
    }

    /**
     * getSaleInfoByUserId
     * @access public
     * @param int
     * @return object
     */
    public function getSaleInfoByUserId($user_id){
        $company_id = $this->session->userdata('company_id');
        $this->db->select('s.id, s.sale_no, s.total_items, s.total_payable, s.paid_amount, s.date_time, c.name as customer_name, c.phone as customer_phone');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->where('s.user_id', $user_id);
        $this->db->where('s.company_id', $company_id);
		$this->db->where('s.del_status','Live');
        $result = $this->db->get()->result();
        return $result;
    }
    public function getAllByCompanyIdOrderBy($company_id, $table_name,$order_by='') {
        $where = "";
        $where_order_by = "";
        if($table_name=="tbl_food_menus"){
            $where.=" AND parent_id =  '0'";
        }
        if($order_by!=""){
            $where_order_by.=" ".$order_by;
        }
        $language_manifesto = $this->session->userdata('language_manifesto');
        if(str_rot13($language_manifesto)=="eriutoeri"){
            $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live' $where  
          ORDER BY id $where_order_by")->result();
            return $result;
        }else{
            $outlet_id = $this->session->userdata('outlet_id');
            if($table_name=="tbl_tables" || $table_name=="tbl_users"){
                $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND outlet_id=$outlet_id AND del_status = 'Live' $where  
          ORDER BY id $where_order_by")->result();
                return $result;
            }else{
                $result = $this->db->query("SELECT * 
          FROM $table_name 
          WHERE company_id=$company_id AND del_status = 'Live' $where  
          ORDER BY id $where_order_by")->result();
                return $result;
            }
        }
    }

    public function getRowByCustomId($id,$filed,$tbl,$order=''){
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($filed,$id);
        if($order!=''){
            $this->db->order_by('id',$order);
        }
        $this->db->where("del_status", 'Live');
        $result = $this->db->get();

        if($result != false){
            return $result->row();
        }else{
            return false;
        }
    }

}

?>

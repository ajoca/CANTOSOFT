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
  # This is Kitchen Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Kitchen extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Kitchen_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation'); 
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);

    }

     /**
     * kitchen panel
     * @access public
     * @return void
     * @param no
     */
    public function panel($id=''){
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "98";
        $function = "";

        if($segment_2=="kitchens"){
            $function = "view";
        }elseif($segment_2=="panel" && $segment_3){
            $function = "enter";
        }elseif($segment_2=="addEditKitchen" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditKitchen"){
            $function = "add";
        }elseif($segment_2=="deleteKitchen"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        if($id==''){
            redirect('Kitchen/kitchens');
        }
        $id = d($id,2);
        $data = array();
        $data['kitchen'] = $this->Common_model->getDataById($id, "tbl_kitchens");
        $data['kitchen_id'] = $id;
        $data['notifications'] = $this->get_new_notification($id);
        $this->load->view('kitchen/panel', $data);
    }
    /**
     * kitchens info
     * @access public
     * @return void
     * @param no
     */
    public function kitchens() {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "98";
        $function = "";

        if($segment_2=="kitchens"){
            $function = "view";
        }elseif($segment_2=="panel" && $segment_3){
            $function = "enter";
        }elseif($segment_2=="addEditKitchen" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditKitchen"){
            $function = "add";
        }elseif($segment_2=="deleteKitchen"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
 
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['kitchens'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_kitchens"); 
       
        foreach ($data['kitchens'] as $key=>$value){
            $txt_cates = '';
            $categories = $this->Common_model->getKitchenCategoriesById($value->id);
            foreach ($categories as $k=>$category){
                $txt_cates.=$category->category_name;
                if($k<sizeof($categories)-1){
                    $txt_cates.=", ";
                }
            }
            $data['kitchens'][$key]->categories = $txt_cates;
        }
        $data['main_content'] = $this->load->view('kitchen/kitchens', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete Kitchen
     * @access public
     * @return void
     * @param int
     */
    public function deleteKitchen($id) {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "98";
        $function = "";
        if($segment_2=="kitchens"){
            $function = "view";
        }elseif($segment_2=="panel" && $segment_3){
            $function = "enter";
        }elseif($segment_2=="addEditKitchen" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditKitchen"){
            $function = "add";
        }elseif($segment_2=="deleteKitchen"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->db->delete("tbl_kitchens", array("id" => $id));
        $this->db->delete("tbl_kitchen_categories", array("kitchen_id" => $id)); 
        
        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Kitchen/kitchens');
    }
    /**
     * add/Edit Kitchen
     * @access public
     * @return void
     * @param int
     */
    public function addEditKitchen($encrypted_id = "") {
        if(isLMni()):
    
          else:
            if (!$this->session->has_userdata('outlet_id')) {
                $this->session->set_flashdata('exception_2',lang('please_click_green_button'));
                $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
                $this->session->set_userdata("clicked_method", $this->uri->segment(2));
                redirect('Outlet/outlets');
            }
       endif;

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "98";
        $function = "";

        if($segment_2=="kitchens"){
            $function = "view";
        }elseif($segment_2=="panel" && $segment_3){
            $function = "enter";
        }elseif($segment_2=="addEditKitchen" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditKitchen"){
            $function = "add";
        }elseif($segment_2=="deleteKitchen"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $language_manifesto = $this->session->userdata('language_manifesto');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name',lang('name'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $kitchen_info = array();
                $kitchen_info['name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $kitchen_info['printer_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('printer_id')));
                if(isLMni()):
                    $kitchen_info['outlet_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
                  else:
                    $kitchen_info['outlet_id'] = $this->session->userdata("outlet_id");
               endif;
                $kitchen_info['company_id'] = $company_id;
                if ($id == "") {
                    $id = $this->Common_model->insertInformation($kitchen_info, "tbl_kitchens");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($kitchen_info, $id, "tbl_kitchens");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                $this->Common_model->deleteStatusChangeByCustomRow($id, "kitchen_id","tbl_kitchen_categories");
                //This variable could not be escaped because this is html content
                $item_check =$this->input->post($this->security->xss_clean('item_check'));
                if($item_check){
                    foreach ($item_check as $key=>$vl){
                        $kitchen_food_categories = array();
                        $kitchen_food_categories['kitchen_id'] = $id;
                        $kitchen_food_categories['cat_id'] = $vl;
                        $kitchen_food_categories['outlet_id'] = $kitchen_info['outlet_id'];
                        $this->Common_model->insertInformation($kitchen_food_categories, "tbl_kitchen_categories");
                    }
                }
                redirect('Kitchen/kitchens');

            } else {
                if ($id == "") {
                    $data = array();
                     $data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
                    $data['categories'] = $this->Common_model->getKitchenCategories('');
                    $data['main_content'] = $this->load->view('kitchen/addKitchen', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                     $data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
                    $data['encrypted_id'] = $encrypted_id;
                    $data['kitchen'] = $this->Common_model->getDataById($id, "tbl_kitchens");
                    $data['categories'] = $this->Common_model->getKitchenCategories($encrypted_id);
                    foreach ($data['categories'] as $key=>$value){
                        $is_checked = $this->Common_model->checkForExist($value->id);
                        if(isset($is_checked) && $is_checked){
                            $data['categories'][$key]->checker = 'checked';
                        }else{
                            $data['categories'][$key]->checker = '';
                        }
                    }
                    $data['main_content'] = $this->load->view('kitchen/editKitchen', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                 $data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
                $data['categories'] = $this->Common_model->getKitchenCategories('');
                $data['main_content'] = $this->load->view('kitchen/addKitchen', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                 $data['printers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
                $data['encrypted_id'] = $encrypted_id;
                $data['kitchen'] = $this->Common_model->getDataById($id, "tbl_kitchens");
                $data['categories'] = $this->Common_model->getKitchenCategories($encrypted_id);
                foreach ($data['categories'] as $key=>$value){
                    $is_checked = $this->Common_model->checkForExist($value->id);
                    if(isset($is_checked) && $is_checked){
                        $data['categories'][$key]->checker = 'checked';
                    }else{
                        $data['categories'][$key]->checker = '';
                    }
                }
                $data['main_content'] = $this->load->view('kitchen/editKitchen', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * get new orders
     * @access public
     * @return object
     * @param no
     */
    public function get_new_orders_ajax(){
        $kitchen_id = escape_output($_POST['kitchen_id']);
        $data1 = $this->get_new_orders($kitchen_id);
        echo json_encode($data1);        
    }
     /**
     * get order details kitchen
     * @access public
     * @return object
     * @param no
     */
    public function get_order_details_kitchen_ajax(){
        $sale_id = $this->input->post('sale_id');
        $kitchen_id = $this->input->post('kitchen_id');
        $sale_object = $this->get_all_information_of_a_sale_kitchen_type($sale_id,$kitchen_id);
        echo json_encode($sale_object);
    }
     /**
     * get all information of a sale kitchen type
     * @access public
     * @return object
     * @param int
     */
    public function get_all_information_of_a_sale_kitchen_type($sales_id,$kitchen_id){
        $sales_information = $this->Kitchen_model->getSaleBySaleId($sales_id);
        $items_by_sales_id = $this->Kitchen_model->getAllKitchenItemsFromSalesDetailBySalesId($sales_id,$kitchen_id);
        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Kitchen_model->getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        return $sale_object;
    }
     /**
     * get new orders
     * @access public
     * @return string
     * @param no
     */
    public function get_new_orders($kitchen_id){
        $outlet_id = $this->session->userdata('outlet_id');
        $user_id = $this->session->userdata('user_id');
        $kitchen = $this->Common_model->getDataById($kitchen_id, "tbl_kitchens");
        $data1 = $this->Kitchen_model->getNewOrders($kitchen->outlet_id);
        $i = 0;
        for($i;$i<count($data1);$i++){
            //update for bell
            $data_bell = array();
            $data_bell['is_kitchen_bell'] = 2;
            $this->Common_model->updateInformation($data_bell, $data1[$i]->sale_id, "tbl_kitchen_sales");

            $data1[$i]->total_kitchen_type_items = $this->Kitchen_model->get_total_kitchen_type_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_done_items = $this->Kitchen_model->get_total_kitchen_type_done_items($data1[$i]->sale_id);
            $data1[$i]->total_kitchen_type_started_cooking_items = $this->Kitchen_model->get_total_kitchen_type_started_cooking_items($data1[$i]->sale_id);
            $data1[$i]->tables_booked = $this->Kitchen_model->get_all_tables_of_a_sale_items($data1[$i]->sale_id);
            $items_by_sales_id = $this->Kitchen_model->getAllKitchenItemsFromSalesDetailBySalesId($data1[$i]->sale_id,$kitchen_id);

            foreach($items_by_sales_id as $single_item_by_sale_id){
                $modifier_information = $this->Kitchen_model->getModifiersBySaleAndSaleDetailsId($data1[$i]->sale_id,$single_item_by_sale_id->sales_details_id);
                $single_item_by_sale_id->modifiers = $modifier_information;
            }
            $data1[$i]->items = $items_by_sales_id;
        }
        return $data1;
    }
     /**
     * update cooking status
     * @access public
     * @return void
     * @param no
     */
    public function update_cooking_status_ajax()
    {
        $previous_id = $this->input->post('previous_id');
        $kitchen_id = $this->input->post('kitchen_id');
        $previous_id_array = explode(",",$previous_id);
        $cooking_status = $this->input->post('cooking_status');
        $total_item = count($previous_id_array); 

        foreach($previous_id_array as $single_previous_id){
            $previous_id = $single_previous_id;
            $item_info = $this->Kitchen_model->getItemInfoByPreviousId($previous_id);
            $sale_id = $item_info->sales_id;
            $sale_info = $this->Kitchen_model->getSaleBySaleId($sale_id);

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
                $notification_data['outlet_id'] = $this->session->userdata('outlet_id');
                $this->db->insert('tbl_notifications', $notification_data); 
            }
        } 
    }
    public function get_update_kitchen_status_ajax()
    {
        $sale_no = $this->input->post('sale_no');
        $sale = getKitchenSaleDetailsBySaleNo($sale_no);
        $result = $this->Kitchen_model->get_all_kitchen_items($sale->id);
        echo json_encode($result);
    }
    public function check_update_kitchen_status_ajax()
    {
        $sale_no = $this->input->post('sale_no');
        $sale = getKitchenSaleDetailsBySaleNo($sale_no);
        $is_done = $this->Kitchen_model->get_total_kitchen_type_done_items($sale->id);
        $is_cooked = $this->Kitchen_model->get_total_kitchen_type_started_cooking_items($sale->id);
        $data['status'] = false;
        $data['is_done'] = false;
        $data['is_cooked'] = false;
        if($is_done){
            $data['status'] = true;
            $data['is_done'] = true;
        }
        if($is_cooked){
            $data['status'] = true;
            $data['is_cooked'] = true;
        }
       echo json_encode($data);
    }
     /**
     * update cooking status, delivery, take away
     * @access public
     * @return void
     * @param no
     */
    public function update_cooking_status_delivery_take_away_ajax(){
        $previous_id = $this->input->post('previous_id');
        $kitchen_id = $this->input->post('kitchen_id');
        $previous_id_array = explode(",",$previous_id);
        $cooking_status = $this->input->post('cooking_status');
        $total_item = count($previous_id_array);
        $i = 1;
        foreach($previous_id_array as $single_previous_id){
            $previous_id = $single_previous_id;
            $item_info = $this->Kitchen_model->getItemInfoByPreviousId($previous_id);
            $sale_id = $item_info->sales_id;
            if($cooking_status=="Started Cooking"){
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_start_time' => date('Y-m-d H:i:s'));
                
                $this->db->where('previous_id', $previous_id);
                $this->db->update('tbl_kitchen_sales_details', $cooking_status_update_array);
                
                $cooking_update_array_sales_tbl = array('cooking_start_time' => date('Y-m-d H:i:s'));
                $this->db->where('id', $sale_id);
                $this->db->update('tbl_kitchen_sales', $cooking_update_array_sales_tbl);
            }else{
                $cooking_status_update_array = array('cooking_status' => $cooking_status, 'cooking_done_time' => date('Y-m-d H:i:s'));
                
                $this->db->where('previous_id', $previous_id);
                $this->db->update('tbl_kitchen_sales_details', $cooking_status_update_array);

                $cooking_update_array_sales_tbl = array('cooking_done_time' => date('Y-m-d H:i:s'));
                $this->db->where('id', $sale_id);
                $this->db->update('tbl_kitchen_sales', $cooking_update_array_sales_tbl);

                if($i==$total_item){
                    $sale_info = $this->get_all_information_of_a_sale_kitchen_type($sale_id,$kitchen_id);
                    $order_type_operation = '';
                    if($sale_info->order_type==1){
                        $order_name = $sale_info->sale_no;
                    }elseif($sale_info->order_type==2){
                        $order_name = $sale_info->sale_no;
                        $order_type_operation = 'Take Away order is ready to take';
                    }elseif($sale_info->order_type==3){
                        $order_name = $sale_info->sale_no;
                        $order_type_operation = 'Delivery order is ready to deliver';
                    }
                    $notification = 'Customer: '.$sale_info->customer_name.', Order Number: '.$order_name.' '.$order_type_operation;
                    $notification_data = array();        
                    $notification_data['notification'] = $notification;
                    $notification_data['sale_id'] = $sale_id;
                    $notification_data['waiter_id'] = $sale_info->waiter_id;
                    $notification_data['outlet_id'] = $this->session->userdata('outlet_id');
                    $this->db->insert('tbl_notifications', $notification_data);           
                }
            }
            $i++;
        }
    }
     /**
     * get Food Menu By Sale Id
     * @access public
     * @return object
     * @param no
     */
    public function getFoodMenuBySaleId(){
        $sale_id = $this->input->get('sale_id');
        $data = $this->Kitchen_model->getFoodMenuBySaleId($sale_id);
        echo  json_encode($data);
    }
     /**
     * get Current Food
     * @access public
     * @return object
     * @param no
     */
    public function getCurrentFood(){
        $data = $this->Kitchen_model->getUnReadyOrders();
        echo  json_encode($data);
    }
     /**
     * check Unready Food Menus
     * @access public
     * @return object
     * @param no
     */
    public function checkUnreadyFoodMenus(){
        $data['TotalUnreadyFood'] = '';
        echo json_encode($data);
    }
     /**
     * set Order Ready
     * @access public
     * @return object
     * @param no
     */
    public function setOrderReady(){
        $sale_details_id = $this->input->get('sale_details_id');
        $data = $this->Kitchen_model->setOrderReady($sale_details_id);
         $data['status'] = 'true';
        echo json_encode($data);
    }
     /**
     * set Order Ready All
     * @access public
     * @return void
     * @param no
     */
    public function setOrderReadyAll(){
        $sale_id = $this->input->get('sale_id');
        $data = $this->Kitchen_model->setOrderReadyAll($sale_id);
         $data['status'] = 'true';
        echo json_encode($data);
    }
     /**
     * get new notification
     * @access public
     * @return object
     * @param no
     */
    public function get_new_notification($id)
    {
        $outlet_id = $this->session->userdata('outlet_id');
        $notifications = $this->Kitchen_model->getNotificationByOutletId($outlet_id,$id);
        return $notifications;
    }
     /**
     * get new notifications
     * @access public
     * @return object
     * @param no
     */
    public function get_new_notifications_ajax()
    {
        $id = escape_output($_POST['kitchen_id']);
        echo json_encode($this->get_new_notification($id));
    }
     /**
     * remove notification
     * @access public
     * @return void
     * @param no
     */
    public function remove_notication_ajax()
    {
        $notification_id = $this->input->post('notification_id');
        $this->db->delete('tbl_notification_bar_kitchen_panel', array('id' => $notification_id));
        echo escape_output($notification_id);
    }
     /**
     * remove multiple notification
     * @access public
     * @return void
     * @param no
     */
    public function remove_multiple_notification_ajax()
    {
        $notifications = $this->input->post('notifications');
        $notifications_array = explode(",",$notifications);
        foreach($notifications_array as $single_notification){
            $this->db->delete('tbl_notification_bar_kitchen_panel', array('id' => $single_notification));
        } 
    }
    public function getKitchenCategoriesByAjax()
    {
        /*This all variables could not be escaped because this is an array field*/
        $id = isset($_POST['kitchen_id']) && $_POST['kitchen_id']?$_POST['kitchen_id']:'';

        if(isLMni()):
            $outlet_id = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
        else:
            $outlet_id = $this->session->userdata('outlet_id');
        endif;

        $categories = $this->Common_model->getKitchenCategoriesByAjax($id);
        $html = '';
        foreach ($categories as $key=>$value){
            $is_checked = $this->Common_model->checkForExistUpdate($value->id,$outlet_id);
            $checked = '';
            if($is_checked){
                $checked = "checked";
            }
            $html.='<div class="col-sm-12 mb-3 col-md-6 col-lg-3">
                                <div class="border_custom">
                                <label class="container txt_47" for="checker_'.$value->id.'"><b>'.$value->category_name.'</b>
                                    <input class="checkbox_user parent_class" '.$checked.' id="checker_'.$value->id.'" data-name="'.$value->category_name.'" value="'.$value->id.'" type="checkbox" name="item_check[]">
                                    <span class="checkmark"></span>
                                </label>
                                <br>
                                </div>
                            </div>';
        }

        echo json_encode($html);
    }
}

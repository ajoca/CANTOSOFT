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
  # This is Authentication Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Inventory_model');
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->load->model('Sale_model');
        $this->load->model('Attendance_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
    }


  public function check_internet() {
    echo "sccess";
  }
  public function frontend() {
        $is_valid = isset($_POST['is_valid']) && $_POST['is_valid']?$_POST['is_valid']:'';
        $update_plan = isset($_GET['update_plan']) && $_GET['update_plan']?$_GET['update_plan']:'';
        $data['update_plan'] = $update_plan;
        if($is_valid){
            $data['is_valid'] = $is_valid;
            $data['base_url'] = base_url();
            echo json_encode($data);
        }else{ 
            if(isServiceAccessOnly('sGmsJaFJE')){
                $company = getMainCompany();
                if($company->saas_landing_page==1){
                    $update_plan = isset($_GET['update_plan']) && $_GET['update_plan']?$_GET['update_plan']:'';
                    $data['update_plan'] = $update_plan;
                    $data['all_outlets'] = getAllOutletsForSaas(); 
                    $go_online_status =  $this->session->userdata('go_online_status');  
                    if($go_online_status=="Yes"){
                        $data = array();
                        $data['header_content'] = $this->load->view('frontend/header_section_index', $data, TRUE);
                        $data['main_content'] = $this->load->view('frontend/index', $data, TRUE);
                        $this->load->view('frontend/website_layout', $data);
                    }else{
                        $this->load->view('saas/landing/index',$data);
                    }
                    
                }else{
                    $this->load->view('authentication/login');
                }
            }else{

                $company = getMainCompany();
                if(str_rot13($company->language_manifesto)=="eriutoeri"){
            
                }else{
                    $this->session->set_userdata('online_selected_outlet', 1);
                    $this->session->set_userdata('online_selected_company', 1);
                }

                if(isset($company->sos_enable_online_order_frontend_website) && $company->sos_enable_online_order_frontend_website==1){
                    $data = array();
                    $data['header_content'] = $this->load->view('frontend/header_section_index', $data, TRUE);
                    $data['main_content'] = $this->load->view('frontend/index', $data, TRUE);
                    $this->load->view('frontend/website_layout', $data);
                }else{
                    $this->load->view('authentication/login');
                }
                
            }
        }
 }
    public function index() {
        $is_valid = isset($_POST['is_valid']) && $_POST['is_valid']?$_POST['is_valid']:'';
        $update_plan = isset($_GET['update_plan']) && $_GET['update_plan']?$_GET['update_plan']:'';
        $data['update_plan'] = $update_plan;
        if($is_valid){
            $data['is_valid'] = $is_valid;
            $data['base_url'] = base_url();
            echo json_encode($data);
        }else{
             $this->load->view('authentication/login');
        }
    }
    public function plan($id='',$type='') {
        if($id && $type){
            $data['package_type'] = $type;
            $data['pricingPlans'] = $this->Common_model->getDataById($id, "tbl_pricing_plans");
         
            if($type == 2){ 
                $total_payable_amount = $data['pricingPlans']->price_for_month2;
            }else{
                $total_payable_amount = $data['pricingPlans']->monthly_cost;
            }
            
            $data['total_payable_amount'] = $total_payable_amount;
            $plan = $this->Common_model->getDataById($id, "tbl_pricing_plans");
            if($plan->free_trial_status == 'Yes'){
                $data['is_trail_plan'] = "Yes";
            }else{
                $data['is_trail_plan'] = "No";
            }
            $data['plan_id'] = $id;
            $this->load->view('saas/online_pay_front',$data);
        }else{
            $data['pricingPlans'] = $this->Common_model->getAllByTable("tbl_pricing_plans");
            $this->load->view('saas/landing/index',$data);
        }
    }
    public function contactUs() {
        $first_url = ucfirstcustom($this->uri->segment(1));
        if($first_url=="Authentication" || $first_url=="authentication"){
            $this->load->view('authentication/login');
        }else{
            if(isServiceAccessOnlyLogin('sGmsJaFJE')){
                $data = array();
                $data['main_content'] = $this->load->view('saas/frontend/contact_us', $data, TRUE);
                $this->load->view('saas/frontend/layout', $data);
            }else{
                $this->load->view('authentication/login');
            }
        }
    }

    public function landing() {
        $this->load->view('saas/landing/index');
    }
    public function singup() {
        $data['pricingPlans'] = $this->Common_model->getAllByTable("tbl_pricing_plans");
        $this->load->view('saas/signup',$data);
    }
    public function sendEmail() {
        $name = $_POST['name']." - ".$_POST['phone'];
        $subject = $_POST['subject'];
        $txt = $name."<br>".$_POST['message'];
        $company = getMainCompany();
        $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
        $send_to = isset($smtEmail->email_send_to) && $smtEmail->email_send_to?$smtEmail->email_send_to:'';
        $return = sendEmailOnly($txt,$send_to,$attached='',$name,$subject);
        $data['msg'] = lang('wrong_send_email');
        $data['status'] = false;
        if($return){
            $data['msg'] = lang('success_send_email');
            $data['status'] = true;
        }
        echo json_encode($data);
    }

    /**
     * check login info
     * @access public
     * @return void
     * @param no
     */
    public function loginCheck() {        
        if($this->input->post('submit') != 'submit'){
            redirect("Authentication/index");
        }
        $active_login_button = htmlspecialcharscustom($this->input->post($this->security->xss_clean('active_login_button_hidden')));
       
        if($active_login_button==1){
            $this->form_validation->set_rules('email_address', lang('email_address'), 'required|max_length[50]');
            $this->form_validation->set_rules('password', lang('password'), "required|max_length[25]");
        }else{
            $this->form_validation->set_rules('login_pin', lang('login_pin'), 'required|max_length[4]');
        }

        if ($this->form_validation->run() == TRUE) {
            $email_address =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
            $password = md5($this->input->post($this->security->xss_clean('password')));
            $login_pin =htmlspecialcharscustom($this->input->post($this->security->xss_clean('login_pin')));
            $user_information = $this->Authentication_model->getUserInformation($email_address, $password,$login_pin,$active_login_button);
        
            //If user exists
            if ($user_information) {
                //insert sos_default_user
                insertSosUser();
                //If the user is Active
                if ($user_information->active_status == 'Active') {
                    
                    $company_info = $this->Authentication_model->getCompanyInformation($user_information->company_id);
                    if($company_info){
                        if($company_info->is_active==1){
                            $is_block = "No";
                            $is_payment_clear = 'Yes';
                            if(!isFoodCourt()){
                           

                                if(!isServiceAccess($user_information->id,$user_information->company_id) && $user_information->company_id!=1){
                                    $is_block = $company_info->is_block_all_user;
                                    $is_payment_clear = 'No';

                                    $due_payment = $this->Common_model->getPaymentInfo($company_info->id);
                                    if($due_payment){
                                        if($due_payment->payment_date){
                                            $access_day = $company_info->access_day;
                                            if(!$access_day){
                                                $access_day = 0;
                                            }
                                            $today = date("Y-m-d",strtotime('today'));
                                            $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                            if($today<$end_date){
                                                $is_payment_clear = "Yes";
                                            }
                                        }

                                    }else{
                                        $access_day = $company_info->access_day;
                                        if(!$access_day){
                                            $access_day = 0;
                                        }
                                        $today = date("Y-m-d",strtotime('today'));
                                        $end_date = date("Y-m-d",strtotime($company_info->created_date." +".$access_day."day"));
                                        if($today<$end_date){
                                            $is_payment_clear = "Yes";
                                        }
                                    }
                                }
                            }
                            if($is_payment_clear=="Yes" && $is_block=="No"){
                               
                                //check menu access list from selected role
                                if($user_information->role=="Admin"){
                                    $getAccess = $this->Common_model->getAllByTable('tbl_access');
                                }else{
                                    $getAccess = $this->Common_model->getAllByCustomId($user_information->role_id,'role_id','tbl_role_access');
                                }

                                $menu_access_container = array();
                                if($user_information->role=="Admin"){
                                    if (isset($getAccess)) {
                                        foreach ($getAccess as $value) {
                                            array_push($menu_access_container, $value->function_name."-".$value->parent_id);
                                        }
                                    }
                                }else{
                                    if (isset($getAccess)) {
                                        //pre($getAccess);exit;
                                        foreach ($getAccess as $value) {
                                            $getAccesRow = $this->Common_model->getAllByCustomRowId($value->access_child_id,"id",'tbl_access');
                                            if($getAccesRow){
                                                array_push($menu_access_container, $getAccesRow->function_name."-".$getAccesRow->parent_id);
                                            }
                                            
                                        }
                                    }
                                }
                                $primary_session_data['function_access'] = $menu_access_container;
                                $this->session->set_userdata($primary_session_data);
                                //end


                                $login_session = array();
                                //User Information
                                $login_session['user_id'] = $user_information->id;
                                $login_session['language'] = $user_information->language;
                                $login_session['designation'] = $user_information->designation;
                                $login_session['full_name'] = $user_information->full_name;
                                $login_session['short_name'] = strtolower(substr($user_information->full_name,0, 1));
                                $login_session['phone'] = $user_information->phone;
                                $login_session['email_address'] = $user_information->email_address;
                                $login_session['role'] = $user_information->role;
                                $login_session['company_id'] = $user_information->company_id;
                                $login_session['session_outlets'] = $user_information->outlets;
                                $login_session['active_menu_tmp'] = 4;

                                //Company Information


                                //Set session

                                $company_info_session = array();
                                $company_info_session['currency'] = $company_info->currency;
                                $company_info_session['zone_name'] = $company_info->zone_name;
                                $company_info_session['date_format'] = $company_info->date_format;
                                $company_info_session['business_name'] = $company_info->business_name;
                                $company_info_session['website'] = $company_info->website;
                                $company_info_session['currency_position'] =$company_info->currency_position;
                                $company_info_session['precision'] =$company_info->precision;
                                $company_info_session['default_customer'] =$company_info->default_customer;
                                $company_info_session['export_daily_sale'] =$company_info->export_daily_sale;
                                $company_info_session['service_amount'] =$company_info->service_amount;
                                $company_info_session['take_away_service_charge'] =$company_info->take_away_service_charge;
                                $company_info_session['delivery_amount'] =$company_info->delivery_amount;
                                $company_info_session['tax_type'] =$company_info->tax_type;
                                $company_info_session['decimals_separator'] =$company_info->decimals_separator;
                                $company_info_session['thousands_separator'] =$company_info->thousands_separator;
                                $company_info_session['open_cash_drawer_when_printing_invoice'] =$company_info->open_cash_drawer_when_printing_invoice;
                                $company_info_session['when_clicking_on_item_in_pos'] =$company_info->when_clicking_on_item_in_pos;
                                $company_info_session['is_rounding_enable'] =$company_info->is_rounding_enable;
                                $company_info_session['attendance_type'] =$company_info->attendance_type;
                                $company_info_session['default_order_type'] =$company_info->default_order_type;
                                $company_info_session['is_loyalty_enable'] =$company_info->is_loyalty_enable;
                                $company_info_session['pre_or_post_payment'] =$company_info->pre_or_post_payment;
                                $company_info_session['minimum_point_to_redeem'] =$company_info->minimum_point_to_redeem;
                                $company_info_session['loyalty_rate'] =$company_info->loyalty_rate;
                                $company_info_session['split_bill'] =$company_info->split_bill;
                                $company_info_session['place_order_tooltip'] =$company_info->place_order_tooltip;
                                $company_info_session['food_menu_tooltip'] =$company_info->food_menu_tooltip;
                                $company_info_session['table_bg_color'] =$company_info->table_bg_color;
                                $company_info_session['kot_print_online_self_order'] =$company_info->kot_print_online_self_order;

                                if(str_rot13($company_info->language_manifesto)!="eriutoeri"):
                                    $company_info_session['default_waiter'] =$company_info->default_waiter;
                                endif;
                                $company_info_session['default_payment'] =$company_info->default_payment;
                                $company_info_session['invoice_footer'] = $company_info->invoice_footer;
                                $company_info_session['invoice_logo'] = $company_info->invoice_logo;
                                $company_info_session['language_manifesto'] = $company_info->language_manifesto;
                                $company_info_session['collect_tax'] = $company_info->collect_tax;
                                $company_info_session['tax_title'] = $company_info->tax_title;
                                $company_info_session['tax_registration_no'] = $company_info->tax_registration_no;
                                $company_info_session['tax_is_gst'] = $company_info->tax_is_gst;
                                $company_info_session['apply_on_delivery_charge'] = $company_info->apply_on_delivery_charge;
                                $company_info_session['state_code'] = $company_info->state_code;
                                $company_info_session['active_login_button'] = $company_info->active_login_button;
                                $company_info_session['login_type'] = $company_info->login_type;
                                
                                if(isFoodCourt() && $user_information->id!=1){
                                    if(isset($user_information->outlet_id) && $user_information->outlet_id){
                                        $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id=$user_information->outlet_id")->row();
                                    }else{
                                        $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active'")->row();
                                    }
                                }else{
                                    $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active'")->row();
                                }

                                if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){

                                   
                                    if ($user_information->role != 'Admin') {
                                        if($outlet_info->active_status=="inactive"){
                                            $this->session->set_flashdata('exception_1', lang('outlet_not_active'));
                                            redirect('Authentication/index');
                                        }
                                    }
                                    $this->session->set_userdata($login_session);
                                    $this->session->set_userdata($company_info_session);

                                    $outlet_session = array();
                                    if(isset($outlet_info) && $outlet_info):
                                        $outlet_session['outlet_id'] = $outlet_info->id;
                                        $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                        $outlet_session['address'] = $outlet_info->address;
                                        $outlet_session['phone'] = $outlet_info->phone;
                                        $outlet_session['email'] = $outlet_info->email;
                                        $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                        $outlet_session['online_order_module'] = $outlet_info->online_order_module;
                                        if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                            $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                        endif;
                                    endif;
                                    $this->session->set_userdata($outlet_session);



                                  
                                    //for saas module
                                    if(isServiceAccess('','','')){
                                        $all_companies = $this->Common_model->getServiceCompaniesYes();
                                        if($all_companies){
                                            foreach ($all_companies as $value){
                                                $due_payment = $this->Common_model->getPaymentInfo($value->id);
                                                if($due_payment){
                                                    if($due_payment->payment_date){
                                                        $access_day = $value->access_day;
                                                        if(!$access_day){
                                                            $access_day = 0;
                                                        }
                                                        $today = date("Y-m-d",strtotime('today'));
                                                        $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                                        if($today>$end_date){
                                                            $data['payment_clear'] = "No";
                                                            $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                        }
                                                    }
                                                }else{
                                                    $access_day = $value->access_day;
                                                    if(!$access_day){
                                                        $access_day = 0;
                                                    }
                                                    $today = date("Y-m-d",strtotime('today'));
                                                    $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
                                                    if($today>$end_date){
                                                        $data['payment_clear'] = "No";
                                                        $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                    }
                                                }
                                            }
                                        }

                                    }
                                    //attendance insert
                                    $today = date("Y-m-d",strtotime('today'));
                                    $check_and_return_ref = getRefAttendance($today,$user_information->id);
                                    if($check_and_return_ref){
                                        $attendance= array();
                                        $attendance['reference_no'] = $check_and_return_ref;
                                        $attendance['date'] = $today;
                                        $attendance['employee_id'] = $user_information->id;
                                        $attendance['in_time'] = date("H:i:s");
                                        $attendance['out_time'] = "00:00:00";
                                        $attendance['user_id'] = $user_information->id;
                                        $attendance['company_id'] = $company_info->id;
                                        $this->Common_model->insertInformation($attendance, "tbl_attendance");
                                    }

                                    $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id='$user_information->outlet_id'")->row();
                                    $outlet_session = array();
                                    if(isset($outlet_info) && $outlet_info):
                                        $outlet_session['outlet_id'] = $outlet_info->id;
                                        $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                        $outlet_session['address'] = $outlet_info->address;
                                        $outlet_session['phone'] = $outlet_info->phone;
                                        $outlet_session['email'] = $outlet_info->email;
                                        $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                        $outlet_session['has_kitchen'] = $outlet_info->has_kitchen;
                                        $outlet_session['online_order_module'] = $outlet_info->online_order_module;
                                        if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                            $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                        endif;
                                        $this->session->set_userdata($outlet_session);
                                        if ($user_information->designation == 'Waiter') {
                                            redirect("Sale/POS");
                                        }
                                    endif;

                                    $outlets_count = explode(",",$user_information->outlets);
                                    if(sizeof($outlets_count)==1 && $user_information->role != 'Admin'){
                                       $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id='$user_information->outlet_id'")->row();
                                       $outlet_session = array();
                                       if(isset($outlet_info) && $outlet_info):
                                           $outlet_session['outlet_id'] = $outlet_info->id;
                                           $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                           $outlet_session['address'] = $outlet_info->address;
                                           $outlet_session['phone'] = $outlet_info->phone;
                                           $outlet_session['email'] = $outlet_info->email;
                                           $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                           $outlet_session['has_kitchen'] = $outlet_info->has_kitchen;
                                           $outlet_session['online_order_module'] = $outlet_info->online_order_module;
                                           if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                               $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                           endif;
                                           $this->session->set_userdata($outlet_session);
                                           if ($user_information->designation == 'Chef') {
                                            redirect("Kitchen/kitchens");
                                        }else{
                                            redirect("Sale/POS");
                                        }
                                       endif;
                                    }


                                  
                                    if(isFoodCourt() && $user_information->id==1){
                                        redirect("Authentication/userProfile");
                                    }
                                    if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){
                                        redirect("Authentication/userProfile");
                                    }
                                    redirect("Outlet/outlets");

                                }else{
                                    $this->session->set_userdata($login_session);
                                    $this->session->set_userdata($company_info_session);

                                    //for saas module
                                    if(isServiceAccess('','','')){
                                        $all_companies = $this->Common_model->getServiceCompaniesYes();

                                        if($all_companies){
                                            foreach ($all_companies as $value){
                                                $due_payment = $this->Common_model->getPaymentInfo($value->id);
                                                if($due_payment){
                                                    if($due_payment->payment_date){
                                                        $access_day = $value->access_day;
                                                        if(!$access_day){
                                                            $access_day = 0;
                                                        }
                                                        $today = date("Y-m-d",strtotime('today'));
                                                        $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                                        if($today>$end_date){
                                                            $data['payment_clear'] = "No";
                                                            $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                        }
                                                    }
                                                }else{
                                                    $access_day = $value->access_day;
                                                    if(!$access_day){
                                                        $access_day = 0;
                                                    }
                                                    $today = date("Y-m-d",strtotime('today'));
                                                    $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
                                                    if($today>$end_date){
                                                        $data['payment_clear'] = "No";
                                                        $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //attendance insert
                                    $today = date("Y-m-d",strtotime('today'));
                                    $check_and_return_ref = getRefAttendance($today,$user_information->id);
                                    if($check_and_return_ref){
                                        $attendance= array();
                                        $attendance['reference_no'] = $check_and_return_ref;
                                        $attendance['date'] = $today;
                                        $attendance['employee_id'] = $user_information->id;
                                        $attendance['in_time'] = date("H:i:s");
                                        $attendance['out_time'] = "00:00:00";
                                        $attendance['user_id'] = $user_information->id;
                                        $attendance['company_id'] = $company_info->id;
                                        $this->Common_model->insertInformation($attendance, "tbl_attendance");
                                    }

                                    $outlets_count = explode(",",$user_information->outlets);
                                     if(sizeof($outlets_count)==1 && $user_information->role != 'Admin'){
                                        $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id='$user_information->outlet_id'")->row();
                                        $outlet_session = array();
                                        if(isset($outlet_info) && $outlet_info):
                                            $outlet_session['outlet_id'] = $outlet_info->id;
                                            $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                            $outlet_session['address'] = $outlet_info->address;
                                            $outlet_session['phone'] = $outlet_info->phone;
                                            $outlet_session['email'] = $outlet_info->email;
                                            $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                            $outlet_session['has_kitchen'] = $outlet_info->has_kitchen;
                                            $outlet_session['online_order_module'] = $outlet_info->online_order_module;
                                            if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                                $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                            endif;
                                            $this->session->set_userdata($outlet_session);
                                            if ($user_information->designation == 'Chef') {
                                                redirect("Kitchen/kitchens");
                                            }else{
                                                redirect("Sale/POS");
                                            }
                                        endif;
                                     }

                                    if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){
                                        redirect("Authentication/userProfile");
                                    }
                                    redirect("Outlet/outlets");
                                }
                            }else{
                                if($is_block=="Yes"){
                                    $this->session->set_flashdata('exception_1', lang('block_tmp_err'));
                                    redirect('Authentication/index');
                                }else if($is_payment_clear=="No"){
                                    $this->session->set_flashdata('exception_1', lang('payment_not_clear_err'));
                                    redirect('Authentication/index');
                                }
                            }
                        }else{
                            $this->session->set_flashdata('exception_1', lang('company_not_set_err1'));
                            redirect('Authentication/index');
                        }

                    }else{
                        $this->session->set_flashdata('exception_1', lang('company_not_set_err'));
                        redirect('Authentication/index');
                    }
                } else {
                    $this->session->set_flashdata('exception_1', lang('user_not_active'));
                    redirect('Authentication/index');
                }
            } else {
                if($active_login_button==1){
                    $this->session->set_flashdata('exception_1', lang('incorrect_email_password'));
                }else{
                    $this->session->set_flashdata('exception_1', lang('incorrect_pin'));
                }
                $this->session->set_flashdata('active_login_button', $active_login_button);
                redirect('Authentication/index');
            }
        } else {
            $this->load->view('authentication/login');
        }
    }
    /**
     * check payment clear or not
     * @access public
     * @return void
     * @param no
     */
    public function paymentNotClear() {
        if (!$this->session->has_userdata('customer_id')) {
            redirect('Authentication/index');
        }
        $this->load->view('authentication/paymentNotClear');
    }
    /**
     * user profile data
     * @access public
     * @return void
     * @param no
     */
    public function userProfile() {
        
        $is_self_order = $this->session->userdata('is_self_order');
        $is_online_order = $this->session->userdata('is_online_order');
        $outlet_id = $this->session->userdata('outlet_id');
        if($is_self_order=="Yes" && $is_online_order==''){
            //if system detect self order then redirect to POS screen
            $table_id = $this->session->userdata('self_order_table_id');
            unset($_SESSION['exception_er']);
            redirect('Sale/POS/2/'.$outlet_id.'/'.$table_id);
        }else if($is_self_order=="Yes" && $is_online_order=='Yes'){
            //if system detect online order then redirect to POS screen
            unset($_SESSION['exception_er']);
            redirect('Sale/POS/2/'.$outlet_id);
        }
 
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if($this->session->userdata('role') == 'Kitchen User'){
            redirect("Kitchen/panel");
        }

        if($this->session->userdata('role') == 'Waiter User'){
            redirect("Waiter/panel");
        }
        if($this->session->userdata('role') == 'POS User'){
            redirect("Sale/POS");
        }
        $login_session['active_menu_tmp'] = 1;
        $this->session->set_userdata($login_session);
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['sales'] = $this->Common_model->getSaleInfoByUserId($user_id);
        $data['main_content'] = $this->load->view('authentication/userProfile', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function checkInOut() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "310";
        $function = "";

        if($segment_2=="checkInOut"){
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $user_id = $this->session->userdata('user_id');
        $data = array();
        $data['attendances'] = $this->db->query("select * from tbl_attendance where employee_id=$user_id and del_status='Live' order by id desc")->result();
        $data['main_content'] = $this->load->view('authentication/check_in_out', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function reservation() {
        $company = getMainCompany();
        if($company->reservation_status=="disable"){
            $this->session->set_flashdata('exception_1', lang('reservation_disable_msg'));
            redirect('Authentication/index');
        }
        $data['companies'] = $this->Common_model->getAllByTableAsc("tbl_companies");
        $this->load->view('saas/reservation',$data);
    }

    public function checkOut()
    {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "310";
        $function = "";

        if($segment_2=="checkOut"){
            $function = "check_in";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $user_id = $this->session->userdata('user_id');
        $attendance = getAttendance($user_id);
        if($attendance){
            $information = array();
            $information['out_time'] = date('Y-m-d H:i:s');
            $information['is_closed'] = 2;
            $this->Common_model->updateInformation($information, $attendance->id, "tbl_attendance");
        }
        $this->session->set_flashdata('exception', lang('insertion_success_checkout'));
        redirect('authentication/checkInOut');

    }
    public function checkIn()
    {
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "310";
        $function = "";

        if($segment_2=="checkIn"){
            $function = "check_out";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
        $user_id = $this->session->userdata('user_id');
        $information = array();
        $information['reference_no'] = $this->Attendance_model->generateReferenceNo();
        $information['date'] = date("Y-m-d", strtotime('today'));
        $information['employee_id'] = $user_id;
        $information['in_time'] = date('Y-m-d H:i:s');
        $information['out_time'] = '';
        $information['note'] = "--";
        $information['is_closed'] = 1;
        $information['user_id'] = $this->session->userdata('user_id');
        $information['company_id'] = $this->session->userdata('company_id');

        $this->Common_model->insertInformation($information, "tbl_attendance");
        $this->session->set_flashdata('exception', lang('insertion_success_checkin'));
        redirect('authentication/checkInOut');
    }
    /**
     * change password
     * @access public
     * @return void
     * @param no
     */
    public function changePassword() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "300";
        $function = "";

        if($segment_2=="changePassword"){
            $function = "update";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('old_password',lang('old_password'), 'required|max_length[50]');
            $this->form_validation->set_rules('new_password', lang('new_password'), 'required|max_length[50]|min_length[6]');
            if ($this->form_validation->run() == TRUE) {
                $old_password =htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_password')));
                $user_id = $this->session->userdata('user_id');

                $password_check = $this->Authentication_model->passwordCheck(md5($old_password), $user_id);

                if ($password_check) {
                    $new_password =htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_password')));

                    $this->Authentication_model->updatePassword(md5($new_password), $user_id);

                    mail($this->session->userdata['email_address'], "Change Password", "Your new password is : " . $new_password);

                    $this->session->set_flashdata('exception',lang('password_changed'));
                    redirect('Authentication/changePassword');
                } else {
                    $this->session->set_flashdata('exception_1',lang('old_password_not_match'));
                    redirect('Authentication/changePassword');
                }
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('authentication/changePassword', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function changePin() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "330";
        $function = "";

        if($segment_2=="changePin"){
            $function = "update";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
        $this->form_validation->set_rules('old_pin',lang('old_pin'), 'required|max_length[4]|min_length[4]');

        $old_pin =htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_pin')));
        $new_pin =htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_pin')));
        if($old_pin!=$new_pin){
            $this->form_validation->set_rules('new_pin',  lang('new_pin'), "required|max_length[4]|min_length[4]|is_unique[tbl_users.login_pin]");
        }else{
            $this->form_validation->set_rules('new_pin',  lang('new_pin'), "required|max_length[4]|min_length[4]");
        }

        if ($this->input->post('submit') == 'submit') {
            if ($this->form_validation->run() == TRUE) {

                $user_id = $this->session->userdata('user_id');
                $pin_check = $this->Authentication_model->pinCheck(($old_pin), $user_id);

                if ($pin_check) {
                    $new_pin =htmlspecialcharscustom($this->input->post($this->security->xss_clean('new_pin')));
                    $this->Authentication_model->updatePin(($new_pin), $user_id);

                    mail($this->session->userdata['email_address'], "Change Pin", "Your new pin is : " . $new_pin);

                    $this->session->set_flashdata('exception',lang('pin_changed'));
                    redirect('Authentication/changePin');
                } else {
                    $this->session->set_flashdata('exception_1',lang('old_pin_not_match'));
                    redirect('Authentication/changePin');
                }
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('authentication/changePin', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('authentication/changePin', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    /**
     * forgot password
     * @access public
     * @return void
     * @param no
     */
    public function forgotPassword() {
        $this->load->view('authentication/forgotPassword');
    }
    /**
     * send auto password through email
     * @access public
     * @return void
     * @param no
     */
    public function sendAutoPassword() {
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('email_address', lang('email_address'), 'required|callback_checkEmailAddressExistance');
            if ($this->form_validation->run() == TRUE) {
                $email_address =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));

                $user_details = $this->Authentication_model->getAccountByMobileNo($email_address);

                $user_id = $user_details->id;

                $auto_generated_password = mt_rand(100000, 999999);

                $this->Authentication_model->updatePassword($auto_generated_password, $user_id);

                //Send Password by Email
                $this->load->library('email');

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);

                mail($email_address, "Change Password", "Your new password is : " . $auto_generated_password);

                $this->load->view('authentication/forgotPasswordSuccess');
            } else {
                $this->load->view('authentication/forgotPassword');
            }
        } else {
            $this->load->view('authentication/forgotPassword');
        }
    }
    /**
     * check email address that is exist or not
     * @access public
     * @return void
     * @param boolean
     */
    public function checkEmailAddressExistance() {
        $email_address =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));

        $checkEmailAddressExistance = $this->Authentication_model->getAccountByMobileNo($email_address);

        if (count($checkEmailAddressExistance) <= 0) {
            $this->form_validation->set_message('checkEmailAddressExistance', 'Email Address does not exist');
            return false;
        } else {
            return true;
        }
    }
    /**
     * logout from system
     * @access public
     * @return void
     * @param no
     */
    public function logOut() {
        //update attendance
        $user_id = $this->session->userdata('user_id');
        $today = date("Y-m-d",strtotime('today'));
        $check_data = checkAttendance($today,$user_id);
        if($check_data){
            $attendance= array();
            $attendance['out_time'] = date("H:i:s");
            $this->Common_model->updateInformation($attendance, $check_data->id, "tbl_attendance");
        }


        //User Information
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('full_name');
        $this->session->unset_userdata('short_name');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('email_address');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('outlet_name');
        $this->session->unset_userdata('clicked_controller');
        $this->session->unset_userdata('clicked_method');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('company_id');
        $this->session->unset_userdata('outlet_id');
        $this->session->unset_userdata('is_waiter');
        $this->session->unset_userdata('active_menu_tmp');
        $this->session->unset_userdata('designation');
        $this->session->unset_userdata('is_collapse');

        //Shop Information
        $this->session->unset_userdata('currency');
        $this->session->unset_userdata('zone_name');
        $this->session->unset_userdata('date_format');
        $this->session->unset_userdata('business_name');
        $this->session->unset_userdata('address');
        $this->session->unset_userdata('website');
        $this->session->unset_userdata('currency_position');
        $this->session->unset_userdata('precision');
        $this->session->unset_userdata('default_customer');
        $this->session->unset_userdata('default_waiter');
        $this->session->unset_userdata('default_payment');
        $this->session->unset_userdata('outlet_code');
        $this->session->unset_userdata('default_payment');
        $this->session->unset_userdata('invoice_footer');
        $this->session->unset_userdata('invoice_logo');
        $this->session->unset_userdata('language_manifesto');
        $this->session->unset_userdata('collect_tax');
        $this->session->unset_userdata('tax_title');
        $this->session->unset_userdata('tax_registration_no');
        $this->session->unset_userdata('tax_is_gst');
        $this->session->unset_userdata('state_code');
        $this->session->unset_userdata('menu_access');
        $this->session->unset_userdata('is_waiter');
        $this->session->unset_userdata('service_amount');
        $this->session->unset_userdata('take_away_service_charge');
        $this->session->unset_userdata('delivery_amount');
        $this->session->unset_userdata('tax_type');
        $this->session->unset_userdata('decimals_separator');
        $this->session->unset_userdata('thousands_separator');
        $this->session->unset_userdata('default_order_type_delivery_p');
        $this->session->unset_userdata('open_cash_drawer_when_printing_invoice');
        $this->session->unset_userdata('when_clicking_on_item_in_pos');
        $this->session->unset_userdata('is_rounding_enable');
        $this->session->unset_userdata('attendance_type');
        $this->session->unset_userdata('default_order_type');
        $this->session->unset_userdata('minimum_point_to_redeem');
        $this->session->unset_userdata('loyalty_rate');
        $this->session->unset_userdata('split_bill');
        $this->session->unset_userdata('is_loyalty_enable');
        $this->session->unset_userdata('pre_or_post_payment');
        $this->session->unset_userdata('check_update_session');
        $this->session->unset_userdata('place_order_tooltip');
        $this->session->unset_userdata('food_menu_tooltip');
        $this->session->unset_userdata('is_self_order');
        $this->session->unset_userdata('is_online_order');
        $this->session->unset_userdata('online_customer_id');
        $this->session->unset_userdata('online_customer_name');
        $this->session->unset_userdata('active_login_button');
        $this->session->unset_userdata('login_type');
        $this->session->unset_userdata('path');
        $this->session->unset_userdata('title');
        $this->session->unset_userdata('type');
        $this->session->unset_userdata('print_format');
        $this->session->unset_userdata('characters_per_line');
        $this->session->unset_userdata('printer_ip_address');
        $this->session->unset_userdata('printer_port');
        $this->session->unset_userdata('printing_choice');
        $this->session->unset_userdata('ipvfour_address');
        $this->session->unset_userdata('print_format');
        $this->session->unset_userdata('inv_qr_code_enable_status');
        $this->session->unset_userdata('apply_on_delivery_charge');
        $this->session->unset_userdata('mobile_responsive_checker_self_order');
        $this->session->unset_userdata('kot_print_online_self_order');
        $this->session->unset_userdata('show_order_full_short');

        redirect('Authentication/index');
    }
    public function logout_online_order() {
        $this->session->unset_userdata('online_customer_id');
        $this->session->unset_userdata('online_customer_name');
        $this->session->unset_userdata('mobile_responsive_checker_self_order');
        $this->session->unset_userdata('short_name');
        $this->session->unset_userdata('online_selected_outlet');
        $this->session->unset_userdata('go_online_status');
        $this->session->unset_userdata('is_front_signup');
        $this->session->unset_userdata('online_selected_company');  
        redirect($_SERVER["HTTP_REFERER"]);
    }
    public function backtomainpage(){
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('customer_name');
        $this->session->unset_userdata('customer_phone');
        $this->session->unset_userdata('customer_email');
        $this->session->unset_userdata('customer_address');
        $this->session->unset_userdata('online_selected_outlet');
        $this->session->unset_userdata('go_online_status');
        $this->session->unset_userdata('is_front_signup');
        $this->session->unset_userdata('online_selected_company'); 
        redirect(base_url());
    }
    /**
     * sms setting data
     * @access public
     * @return void
     * @param int
     */
    public function SMSSetting($id='') {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('sms_service_provider',lang('sms_service_provider'), "max_length[50]");
            $sms_service_provider = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));
            if($sms_service_provider==1){
                $this->form_validation->set_rules('field_1_0',lang('SID'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_1',lang('Token'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_2',lang('Twilio_Number'), "required|max_length[250]");
            }else if($sms_service_provider==2){
                $this->form_validation->set_rules('field_2_0',lang('profile_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_1',lang('password'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_2',lang('sender_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_3',lang('country_code'), "required|max_length[250]");
            }
            if ($this->form_validation->run() == TRUE) {
                $sms_info_json = array();
                $sms_info_json['field_1_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_0')));
                $sms_info_json['field_1_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_1')));
                $sms_info_json['field_1_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_2')));

                $sms_info_json['field_2_0'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_0')));
                $sms_info_json['field_2_1'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_1')));
                $sms_info_json['field_2_2'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_2')));
                $sms_info_json['field_2_3'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_3')));

                $sms_info = array();
                $sms_info['sms_service_provider'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));
                $sms_info['sms_details'] = json_encode($sms_info_json);
                $this->Common_model->updateInformation($sms_info, $id, "tbl_companies");

                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Authentication/SMSSetting/'.$id);
            } else {
                $data = array();
                $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
                $data['company_id'] = ($company_id);
                $data['main_content'] = $this->load->view('authentication/sms_setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['sms_information'] = $this->Authentication_model->getSMSInformation($company_id);
            $data['company_id'] = ($company_id);
            $data['main_content'] = $this->load->view('authentication/sms_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    /**
     * white label data
     * @access public
     * @return void
     * @param int
     */
    public function whiteLabel($id = '') {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            /*form validation check*/
            $this->form_validation->set_rules('site_name', lang('site_name'), 'required|max_length[300]');
            $this->form_validation->set_rules('footer', lang('footer'), 'required|max_length[300]');
            $this->form_validation->set_rules('system_logo', lang('logo'), 'callback_validate_system_logo');


            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['site_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_name')));
                $data['footer'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('footer')));

                if ($_FILES['system_logo']['name'] != "") {
                    $data['system_logo'] = $this->session->userdata('system_logo');;
                    $this->session->unset_userdata('system_logo');
                    @unlink("./images/".$this->input->post($this->security->xss_clean('old_system_logo')));
                }else{
                    $data['system_logo'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('old_system_logo')));
                }

                $json_data['white_label'] = json_encode($data);

                $this->Common_model->updateInformation($json_data, $id, "tbl_companies");

                redirect('Authentication/whiteLabel');
            } else {
                $data = array();
                $data['main_content'] = $this->load->view('authentication/whiteLabel', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('authentication/whiteLabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    /**
     * change profile data
     * @access public
     * @return void
     * @param int
     */
    public function changeProfile($id = '') {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "298";
        $function = "";

        if($segment_2=="changeProfile"){
            $function = "update";
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
        $company_id = $this->session->userdata('company_id');
        if ($id != '') {
            $user_details = $this->Common_model->getDataById($id, "tbl_users");
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            if ($id != '') {
                $post_email_address =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $existing_email_address = $user_details->email_address;
                if ($post_email_address != $existing_email_address) {
                    $this->form_validation->set_rules('email_address', lang('email_address'), "required|max_length[50]|is_unique[tbl_users.email_address]");
                } else {
                    $this->form_validation->set_rules('email_address',lang('email_address'), "required|max_length[50]");
                }
            } else {
                $this->form_validation->set_rules('email_address', lang('email_address'), "required|max_length[50]|is_unique[tbl_users.email_address]");
            }
            $this->form_validation->set_rules('full_name', lang('full_name'), "required|max_length[50]");
            $this->form_validation->set_rules('phone', lang('phone'), "required|max_length[50]");

            if ($this->form_validation->run() == TRUE) {
                $user_info = array();
                $user_info['full_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $user_info['email_address'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $user_info['phone'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $this->Common_model->updateInformation($user_info, $id, "tbl_users");
                $this->session->set_flashdata('exception', lang('update_success'));

                $this->session->set_userdata('full_name', $user_info['full_name']);
                $this->session->set_userdata('phone', $user_info['phone']);
                $this->session->set_userdata('email_address', $user_info['email_address']);

                redirect('Authentication/changeProfile');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                    $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                    $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/changeProfile', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    /**
     * valideted system logo data
     * @access public
     * @return boolean
     * @param no
     */
    public function validate_system_logo() {

        if ($_FILES['system_logo']['name'] != "") {
            $config['upload_path'] = './images';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("system_logo")) {
                $upload_info = $this->upload->data();
                $system_logo = $upload_info['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/' . $system_logo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 230;
                $config['height'] = 50;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->session->set_userdata('system_logo', $system_logo);
            } else {
                $this->form_validation->set_message('validate_system_logo', $this->upload->display_errors());
                return FALSE;
            }
        }
    }
    /**
     * set language on session
     * @access public
     * @return void
     * @param no
     */
    public function setlanguage($value=''){
        if($value==''){
            $value = $_POST['language'];
        }
    $id=$this->session->userdata('user_id');
    $language=$value;
    if ($language == "") {
        $language = "english";
    }
    if(!checkAvailableLang($value)){
        $language = "english";
    }
    $data['language']=$language;
    $this->session->set_userdata('language', $language);
    $this->db->WHERE('id',$id);
    $this->db->update('tbl_users',$data);
    redirect($_SERVER["HTTP_REFERER"]);
   }

    /**
     * set language on session from POS screen
     * @access public
     * @return void
     * @param string
     */
    public function setlanguagePOS($lng){
    $id=$this->session->userdata('user_id');
    $language=$lng;
    if ($language == "") {
        $language = "english";
    }
        if(!checkAvailableLang($lng)){
            $language = "english";
        }
    $data['language']=$language;
    $this->session->set_userdata('language', $language);
    $this->db->WHERE('id',$id);
    $this->db->update('tbl_users',$data);
    redirect("Sale/POS");
   }
    /**
     * check In
     * @access public
     * @return void
     * @param string
     */
    public function checkInn($type='')
    {
        $this->db->set('attendance_type', $type);
        $this->db->update("tbl_companies");
    }
    /**
     * set language on session from POS screen
     * @access public
     * @return void
     * @param string
     */
  public function setOutlet($outlet_id,$company_id){
    $this->session->set_userdata('outlet_id', $outlet_id);
    $this->session->set_userdata('company_id', $company_id);
      redirect($_SERVER["HTTP_REFERER"]);
   }
    /**
     * sorting main menu
     * @access public
     * @return object
     * @param no
     */
    public function signupCompany() {
        $is_trail = 1;
        $user_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('admin_name')));
        $company_info= array();
        $company_info['business_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('business_name')));
        $company_info['phone'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
        $company_info['address'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));
        $company_info['plan_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('plan_id')));
        $company_info['terms_and_condition'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('term_condition')));
        $company_info['del_status'] = "Deleted";
        $main_company = getMainCompany();
        $company_info['currency_position'] = isset($main_company->currency_position) && $main_company->currency_position?$main_company->currency_position:'';
        $company_info['precision'] = isset($main_company->precision) && $main_company->precision?$main_company->precision:'';
        $company_info['payment_settings'] = isset($main_company->payment_settings) && $main_company->payment_settings?$main_company->payment_settings:'';
        $company_info['sms_setting_check'] = isset($main_company->sms_setting_check) && $main_company->sms_setting_check?$main_company->sms_setting_check:'';
        $company_info['tax_title'] = isset($main_company->tax_title) && $main_company->tax_title?$main_company->tax_title:'';
        $company_info['tax_registration_no'] = isset($main_company->tax_registration_no) && $main_company->tax_registration_no?$main_company->tax_registration_no:'';
        $company_info['tax_is_gst'] = isset($main_company->tax_is_gst) && $main_company->tax_is_gst?$main_company->tax_is_gst:'';
        $company_info['state_code'] = isset($main_company->state_code) && $main_company->state_code?$main_company->state_code:'';
        $company_info['tax_setting'] = isset($main_company->tax_setting) && $main_company->tax_setting?$main_company->tax_setting:'';
        $company_info['tax_string'] = isset($main_company->tax_string) && $main_company->tax_string?$main_company->tax_string:'';
        $company_info['sms_enable_status'] = isset($main_company->sms_enable_status) && $main_company->sms_enable_status?$main_company->sms_enable_status:'';
        $company_info['sms_details'] = isset($main_company->sms_details) && $main_company->sms_details?$main_company->sms_details:'';
        $company_info['smtp_enable_status'] = isset($main_company->smtp_enable_status) && $main_company->smtp_enable_status?$main_company->smtp_enable_status:'';
        $company_info['smtp_details'] = isset($main_company->smtp_details) && $main_company->smtp_details?$main_company->smtp_details:'';
        $company_info['whatsapp_share_number'] = isset($main_company->whatsapp_share_number) && $main_company->whatsapp_share_number?$main_company->whatsapp_share_number:'';
        $company_info['language_manifesto'] = isset($main_company->language_manifesto) && $main_company->language_manifesto?$main_company->language_manifesto:'';
        $company_info['white_label'] = isset($main_company->white_label) && $main_company->white_label?$main_company->white_label:'';
        $company_info['date_format'] = isset($main_company->date_format) && $main_company->date_format?$main_company->date_format:'';
        $company_info['zone_name'] = isset($main_company->zone_name) && $main_company->zone_name?$main_company->zone_name:'';
        $company_info['currency'] = isset($main_company->currency) && $main_company->currency?$main_company->currency:'';
        $company_info['split_bill'] = isset($main_company->split_bill) && $main_company->split_bill?$main_company->split_bill:'';
        $company_info['is_active'] = 2;
        /*getting active random code*/
        $active_code = uniqid();
        $company_info['active_code'] = $active_code;
        $company_info['invoice_footer'] = isset($main_company->invoice_footer) && $main_company->invoice_footer?$main_company->invoice_footer:'';
        $company_info['collect_tax'] = isset($main_company->collect_tax) && $main_company->collect_tax?$main_company->collect_tax:'';

            $plan_id = $this->input->post($this->security->xss_clean('plan_id'));
            $return_data = array();
            $return_data['id'] = '';
            $return_data['status'] = false;
            $return_data['free_status'] = false;
            $checkExisting = $this->Common_model->checkExistingAdmin(htmlspecialcharscustom($this->input->post($this->security->xss_clean('email'))));
            $id = '';
            $this->session->set_userdata('is_front_signup',"Yes");
            if($checkExisting){
                $return_data['msg'] = lang('user_exist_error');
            }else{
                if($plan_id){
                    $plan = $this->Common_model->getDataById($plan_id, "tbl_pricing_plans");
                    if($plan){
                        $company_info['monthly_cost'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('total_amount_payment')));
                        $package_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('package_type')));
                        $company_info['number_of_maximum_users'] = $plan->number_of_maximum_users;
                        $company_info['number_of_maximum_outlets'] = $plan->number_of_maximum_outlets;
                        $company_info['number_of_maximum_invoices'] = $plan->number_of_maximum_invoices;
                        
                        if($plan->free_trial_status == "Yes"){
                            $company_info['payment_clear'] = "Yes";
                            $company_info['access_day'] = $plan->trail_days;
                            $id = $this->Common_model->insertInformation($company_info, "tbl_companies");
                            if($id){
                                $return_data['status'] = true;
                                $return_data['id']  = $id;
                            }
                            $return_data['free_status'] = true;
                          
                          

                            $business =htmlspecialcharscustom($this->input->post($this->security->xss_clean('business_name')));
                            $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.
                            For active your account- <a href="'.base_url().'authentication/active_company/'.$active_code.'">Active Now</a>';
                            //send success message for restaurant admin
                            $send_to = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));

                            $smtp =  getCompanySMTPAndStatus($main_company->id);
                            if($smtp){
                                $emailSetting = json_decode($smtp->email_settings);
                                if($emailSetting->enable_status == 1){
                                    $mail_data = [];
                                    $mail_data['to'] = ["$send_to"];
                                    $mail_data['subject'] = 'Restaurant Signup Varification';
                                    $mail_data['file_name'] = '';
                                    $mail_data['company_id'] = 1;
                                    $mail_data['company_info'] = $main_company;
                                    $mail_data['message'] = $txt;
                                    $mail_data['user_name'] = $user_name;
                                    $mail_data['body_title'] = "Restaurant Signup Varification!";
                                    $mail_data['template'] = $this->load->view('mail-template/signup-template', $mail_data, TRUE);
                                    sendEmailOnlyAZ($mail_data['subject'],$mail_data['template'],$send_to,'',$mail_data['file_name'], $main_company->id);
                                }
                                $return_data['msg'] = 'Successfully signup, Please check your email inbox/spam to verify your email and activate your account';
                            } else{
                                $return_data['msg'] = 'Email Not Configure';
                            }
                        }else{
                            $company_info['payment_clear'] = "No";
                            $company_info['del_status'] = "Deleted";
                            $company_info['access_day'] = $plan->trail_days;
                            $id = $this->Common_model->insertInformation($company_info, "tbl_companies");
                            if($id){
                                $return_data['status'] = true;
                                $return_data['id']  = $id;
                            }
                            $return_data['free_status'] = false;
                            $return_data['msg'] = "Successfully signup, Please check your email inbox/spam to verify your email and activate your account";
                            $is_trail++;
                        }
                    }else{
                        $return_data['msg'] = lang('no_plan_select');
                    }
                }else{
                    $return_data['msg'] = lang('no_plan_select');
                }
            }

            if($id){
                //update admin info
                $admin_data = array();
                $admin_data['full_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('admin_name')));
                $admin_data['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $admin_data['email_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $admin_data['password'] = md5(($this->input->post($this->security->xss_clean('password'))));
                $admin_data['designation'] = "Admin User";
                $admin_data['role'] = "Admin";
                $admin_data['company_id'] = $id;
                $admin_data['will_login'] = "Yes";
                if($is_trail==1){
                    $admin_data['del_status'] = "Deleted";
                }
                $this->Common_model->insertInformation($admin_data, "tbl_users");
            }
            echo json_encode($return_data);
    }
  
    public function subscribeEmail() {
        $email_send_subscribe = $_POST['email_send_subscribe'];
        $data['msg'] = "You did subscribe already!";
        $data['status'] = false;
        $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($email_send_subscribe);
        if(!$checkExistingAccount){
            $data_db['email'] = $email_send_subscribe;
            $this->Common_model->insertInformation($data_db, "tbl_customers");
            $data['msg'] = "Subscription has been completed!";
            $data['status'] = true;
        }
        echo json_encode($data);
    }
    /**
     * get all information of a sale
     * @access public
     * @return object
     * @param int
     */
    public function get_all_information_of_a_sale($sales_id){
        $sales_information = $this->Sale_model->getSaleBySaleId($sales_id);
        $company_id = $sales_information[0]->company_id;
        $sales_information[0]->sub_total = getAmtPublic($company_id,(isset($sales_information[0]->sub_total) && $sales_information[0]->sub_total?$sales_information[0]->sub_total:0));
        $sales_information[0]->paid_amount = getAmtPublic($company_id,(isset($sales_information[0]->paid_amount) && $sales_information[0]->paid_amount?$sales_information[0]->paid_amount:0));
        $sales_information[0]->due_amount = getAmtPublic($company_id,(isset($sales_information[0]->due_amount) && $sales_information[0]->due_amount?$sales_information[0]->due_amount:0));
        $sales_information[0]->vat = getAmtPublic($company_id,(isset($sales_information[0]->vat) && $sales_information[0]->vat?$sales_information[0]->vat:0));
        $sales_information[0]->total_payable = getAmtPublic($company_id,(isset($sales_information[0]->total_payable) && $sales_information[0]->total_payable?$sales_information[0]->total_payable:0));
        $sales_information[0]->total_item_discount_amount = getAmtPublic($company_id,(isset($sales_information[0]->total_item_discount_amount) && $sales_information[0]->total_item_discount_amount?$sales_information[0]->total_item_discount_amount:0));
        $sales_information[0]->sub_total_with_discount = getAmtPublic($company_id,(isset($sales_information[0]->sub_total_with_discount) && $sales_information[0]->sub_total_with_discount?$sales_information[0]->sub_total_with_discount:0));
        $sales_information[0]->sub_total_discount_amount = getAmtPublic($company_id,(isset($sales_information[0]->sub_total_discount_amount) && $sales_information[0]->sub_total_discount_amount?$sales_information[0]->sub_total_discount_amount:0));
        $sales_information[0]->total_discount_amount = getAmtPublic($company_id,(isset($sales_information[0]->total_discount_amount) && $sales_information[0]->total_discount_amount?$sales_information[0]->total_discount_amount:0));
        $sales_information[0]->delivery_charge = (isset($sales_information[0]->delivery_charge) && $sales_information[0]->delivery_charge?$sales_information[0]->delivery_charge:0);
        $this_value = $sales_information[0]->sub_total_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_information[0]->sub_total_discount_value = getAmtPublic($company_id,(isset($sales_information[0]->sub_total_discount_value) && $sales_information[0]->sub_total_discount_value?$sales_information[0]->sub_total_discount_value:0));
        }


        $items_by_sales_id = $this->Sale_model->getAllItemsFromSalesDetailBySalesId($sales_id);

        foreach($items_by_sales_id as $single_item_by_sale_id){
            $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsId($sales_id,$single_item_by_sale_id->sales_details_id);
            $single_item_by_sale_id->modifiers = $modifier_information;
        }
        $sales_details_objects = $items_by_sales_id;
        $sales_details_objects[0]->menu_price_without_discount = getAmtPublic($company_id,(isset($sales_details_objects[0]->menu_price_without_discount) && $sales_details_objects[0]->menu_price_without_discount?$sales_details_objects[0]->menu_price_without_discount:0));
        $sales_details_objects[0]->menu_price_with_discount = getAmtPublic($company_id,(isset($sales_details_objects[0]->menu_price_with_discount) && $sales_details_objects[0]->menu_price_with_discount?$sales_details_objects[0]->menu_price_with_discount:0));
        $sales_details_objects[0]->menu_unit_price = getAmtPublic($company_id,(isset($sales_details_objects[0]->menu_unit_price) && $sales_details_objects[0]->menu_unit_price?$sales_details_objects[0]->menu_unit_price:0));
        $sales_details_objects[0]->menu_vat_percentage = getAmtPublic($company_id,(isset($sales_details_objects[0]->menu_vat_percentage) && $sales_details_objects[0]->menu_vat_percentage?$sales_details_objects[0]->menu_vat_percentage:0));
        $sales_details_objects[0]->discount_amount = getAmtPublic($company_id,(isset($sales_details_objects[0]->discount_amount) && $sales_details_objects[0]->discount_amount?$sales_details_objects[0]->discount_amount:0));

        $this_value = $sales_details_objects[0]->menu_discount_value;
        $disc_fields = explode('%',$this_value);
        $discP = isset($disc_fields[1]) && $disc_fields[1]?$disc_fields[1]:'';
        if ($discP == "") {
        } else {
            $sales_details_objects[0]->menu_discount_value = getAmtPublic($company_id,(isset($sales_details_objects[0]->menu_discount_value) && $sales_information[0]->menu_discount_value?$sales_details_objects[0]->menu_discount_value:0));
        }

        $sale_object = $sales_information[0];
        $sale_object->items = $sales_details_objects;
        $sale_object->tables_booked = $this->Sale_model->get_all_tables_of_a_sale_items($sales_id);
        return $sale_object;
    }

    public function checkQty()
    {
        $curr_qty = htmlspecialcharscustom($this->input->post('curr_qty'));
        $product_id = htmlspecialcharscustom($this->input->post('item_id'));
        $value = $this->Inventory_model->checkInventory($product_id);
        $totalStock = $value->total_transfer_plus_2  -  $value->total_transfer_minus_2 - $value->sale_total;
        if ($curr_qty <= $totalStock) {
            echo json_encode('available->'.$totalStock);
        } else {
            echo json_encode('');
        }
    }
    public function active_company($code)
    {
        $companies_info = $this->Common_model->getCustomDataByParams("active_code",$code, "tbl_companies");
        if(isset($companies_info->active_code) && $companies_info->active_code==$code && $companies_info->is_active != 1){
            $data['is_active'] = 1; 
            $data['del_status'] = 'Live'; 
            $user_arr = [];
            $user_arr['del_status'] = 'Live'; 
            $thisCompanyAdmin = getFirstUserByCompany($companies_info->id);
            $this->Common_model->updateInformation($data, $companies_info->id, "tbl_companies");
            $this->Common_model->updateInformation($user_arr, $thisCompanyAdmin->id, "tbl_users");
            $this->session->set_flashdata('exception',"Your account successfully activate");
        }else if(isset($companies_info->active_code) && $companies_info->active_code==$code && $companies_info->is_active==1){
            $this->session->set_flashdata('exception_1',"Your account already active");
        }else{
            $this->session->set_flashdata('exception_1',"You clicked URL not valid");
        }
        redirect('Authentication/index');
    }
    /**
     * update order success after payment
     * @access public
     * @return string
     */
    public function updateOrderSuccess() {
        $razorpay_payment_id = htmlspecialcharscustom($this->input->post('razorpay_payment_id'));
        $last_added_company_id = htmlspecialcharscustom($this->input->post('last_added_company_id'));
        $total_amount = htmlspecialcharscustom($this->input->post('total_amount'));
        $return_data['status'] = false;
        $return_data['msg'] = "Something is wrong with processing your payment";

        if($razorpay_payment_id){
            //update success order row
            $data = array();
            $data['del_status'] = "Live";
            $data['payment_clear'] = "Yes";
            $this->Common_model->updateInformation($data, $last_added_company_id, "tbl_companies");

            $data = array();
            $data['del_status'] = "Live";
            $this->db->where('company_id', $last_added_company_id);
            $this->db->update('tbl_users', $data);

            //payment history
            $data = array();
            $data['payment_type'] = "Rezorpay";
            $data['company_id'] = $last_added_company_id;
            $data['amount'] = $total_amount;
            $data['payment_date'] = date("Y-m-d",strtotime('today'));
            $data['trans_id'] = $razorpay_payment_id;
            $this->Common_model->insertInformation($data, "tbl_payment_histories");

            $return_data['status'] = true;
            $return_data['msg'] = "Payment successfully accept, Please check your email inbox/spam for active your account";

            //send email
            //send success message for supper admin
            $company = getMainCompany();
            $smtEmail = isset($company->email_settings) && $company->email_settings?json_decode($company->email_settings):'';
            $send_to = isset($smtEmail->email_send_to) && $smtEmail->email_send_to?$smtEmail->email_send_to:'';
            $companies_info = $this->Common_model->getDataById($last_added_company_id, "tbl_companies");

            $business = $companies_info->business_name;
            $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.';
            sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");

            $txt = 'Congratulations, "'.$business.'" restaurant sign-up has been successful.
            For active your account- <a target="_blank" href="'.base_url().'authentication/active_company/'.$companies_info->active_code.'">Active Now</a>';
            //send success message for restaurant admin
            $restaurantAdminUser = $this->Common_model->getRestaurantAdminUser($last_added_company_id);
            $send_to = $restaurantAdminUser->email_address;
            sendEmailOnly($txt,trim_checker($send_to),$attached='',$business,"Restaurant SignUp Success");
        }
        echo json_encode($return_data);
    }

    public function qr_code_invoice($code){
        $sale = getSaleDetailsByCode($code);
            if(isset($sale) && $sale){
                //generate qrcode
                $url_patient = base_url().'invoice/'.$sale->random_code;
                $rand_id = $sale->id;
                $this->load->library('phpqrcode/qrlib');
                $qr_codes_path = "qr_code/";
                $folder = $qr_codes_path;
                $file_name1 = $folder.$rand_id.".png";
                $file_name = $file_name1;
                QRcode::png($url_patient,$file_name,'',4,1);

                $data['sale_object'] = $this->get_all_information_of_a_sale($sale->id);
                $company_info = $this->Common_model->getDataById($data['sale_object']->company_id,'tbl_companies');
                $outlet_info = $this->Common_model->getDataById($data['sale_object']->outlet_id,'tbl_outlets');
                $data['company_info'] = $company_info;
                $data['outlet_info'] = $outlet_info;
                $this->load->view('sale/print_invoice_56mm_public', $data);
            }else{
                    echo "<h1 style='color:red;text-align: center;margin-top:10%'>Your scanned QR-code is not valid!</h1>";
            }

    }
    /**
     * customer_panel
     * @access public
     * @return void
     */
    public function customer_panel() {

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $this->load->view('authentication/customer_panel');
    } 
    /**
     * customer_panel
     * @access public
     * @return void
     */
    public function put_customer_panel_data() {
        $order_details = json_decode(json_decode($this->input->post('order')));
        $data_main = array();
        $data_item_con = array();
        if(count($order_details->items)>0){
            foreach($order_details->items as $item){
                $data_item = array();
                $data_item['row_type'] = $item->row_type;
                $data_item['item_name'] = $item->item_name;
                $data_item['item_note'] = $item->item_note;
                $data_item['item_price'] = $item->item_unit_price;
                $data_item['item_qty'] =  $item->item_quantity;
                $data_item['percentage_table'] =  $item->percentage_table;
                $data_item['item_discount_table'] =  $item->item_discount_table;
                $data_item['modifiers_name'] =  $item->modifiers_name;
                $data_item['modifiers_price'] =  $item->modifiers_price;
                $data_item['total_price'] =  $item->total_price;
                $data_item_con[] = $data_item;
            }
        }

        $data_main['items'] =$data_item_con;
        $data_item_other = array();
        $data_item_other['total_item'] = trim_checker($order_details->total_items_in_cart);
        $data_item_other['total_item_1'] = trim_checker($order_details->total_items_with_qty_in_cart);
        $data_item_other['total_sub_total'] = trim_checker($order_details->sub_total);;
        $data_item_other['total_discount'] = trim_checker($order_details->actual_discount);
        $data_item_other['total_tax'] = trim_checker($order_details->total_vat);
        $data_item_other['total_charge'] = trim_checker($order_details->delivery_charge);
        $data_item_other['total_tips'] = trim_checker($order_details->total_tips);
        $data_item_other['total_payable'] = trim_checker($order_details->total_payable);
        $data_main['others'] =$data_item_other;
        $user_id = $this->session->userdata('user_id');
        $file_name = "cart_data_".$user_id.".json";
        $fp = fopen('assets/'.$file_name, 'w');
        fwrite($fp, json_encode($data_main));
        fclose($fp);


        $seller_name   = escape_output($this->session->userdata('outlet_name'));
        $vat_number    = $this->session->userdata('tax_registration_no');
        $timestamp     = date('Y-m-d\TH:i:s');    // Invoice Timestamp in ISO 8601  
        $invoice_total = $order_details->total_payable;
        $vat_amount    = $order_details->total_vat;
        
        $qr_code_data = generate_qr_code($seller_name, $vat_number, $timestamp, $invoice_total, $vat_amount);  
        
        echo json_encode($qr_code_data);
    }

    /**
     * customer_panel
     * @access public
     * @return void
     */
    public function customer_panel_data() {
        $user_id = $this->session->userdata('user_id');
        $file_name = "cart_data_".$user_id.".json";
        $str = file_get_contents("assets/".$file_name);
        $json_a = json_decode($str);

        $html = '';
        $total_row = 0;
        $total_row_qty = 0;

        foreach ($json_a->items as $value){
            $total_row++;
            $total_row_qty+=$value->item_qty;
            $total_price = isset($value->total_price) && $value->total_price?$value->total_price:0;
            $total_amount = getAmtPCustom($total_price);
            $html.='<tr>
                        <td class="w-30">'.($value->row_type==4?"&nbsp;&nbsp;<b>".lang('free_item')." </b>":'').$value->item_name;
                                if($value->modifiers_name){
                                    $separator = explode('|||',$value->modifiers_name);
                                    foreach ($separator as $value1){
                                        $html.='<br>&nbsp;&nbsp;<b>'.lang('modifier').' : </b>'.$value1;
                                    }
                                }
                                if($value->item_note){
                                    $html.='<br>&nbsp;&nbsp;<b>'.lang('note').' : </b>'.$value->item_note;
                                }
                         $html.='</td>
                         <td class="w-20 text-center">'.getAmtPCustom($value->item_price).'</td>
                        <td class="w-15 text-center">'.$value->item_qty.'</td>
                        <td class="w-15 text-center">'.getDiscountSymbolCP($value->item_discount_table).'</td>
                           <td class="w-20 text-center">'.$total_amount;
                                if($value->modifiers_price){
                                    $separator = explode('|||',$value->modifiers_price);
                                    foreach ($separator as $value1){
                                        $html.='<br>'.$value1;
                                    }
                                }
                         $html.='</td>
                    </tr>';
             if($value->item_note){

             }
        }

        $return_arr ['items_html'] = $html;
        $return_arr['total_item'] = $total_row;
        $return_arr['total_item_1'] = $total_row_qty;
        $return_arr['total_sub_total'] = getAmtPCustom(isset($json_a->others->total_sub_total) && $json_a->others->total_sub_total?$json_a->others->total_sub_total:0);
        $return_arr['total_discount'] = (isset($json_a->others->total_discount) && $json_a->others->total_discount?$json_a->others->total_discount:0);
        $return_arr['total_tax'] = getAmtPCustom(isset($json_a->others->total_tax) && $json_a->others->total_tax?$json_a->others->total_tax:0);
        $return_arr['total_charge'] = getAmtPCustom(isset($json_a->others->total_charge) && $json_a->others->total_charge?$json_a->others->total_charge:0);
        $return_arr['total_tips'] = getAmtPCustom(isset($json_a->others->total_tips) && $json_a->others->total_tips?$json_a->others->total_tips:0);
        $return_arr['total_payable'] = getAmtPCustom(isset($json_a->others->total_payable) && $json_a->others->total_payable?$json_a->others->total_payable:0);

        echo json_encode($return_arr);

    }

    public function securityQuestion(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "302";
        $function = "";

        if($segment_2=="securityQuestion"){
            $function = "update";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $json = file_get_contents("./assets/sampleQustions.json");
        $obj  = json_decode($json);
        $data = array();
        $data['question'] = $obj;
        if ($this->input->post('submit') == 'submit') {
            $this->form_validation->set_rules('answer', lang('SecurityAnswer'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $security_question = htmlspecialcharscustom($this->input->post($this->security->xss_clean('question')));
                $security_answer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('answer')));
                $this->Authentication_model->updateSecurityQuestion($this->session->userdata('company_id'), $this->session->userdata('user_id'), $security_question, $security_answer);
                $this->session->set_flashdata('exception',lang('securityAnswer'));
                redirect('Authentication/securityQuestion');
            } else {
                $data['profile_info'] = $this->Authentication_model->getProfileInformation();
                $data['main_content'] = $this->load->view('authentication/setQuestion', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data['profile_info'] = $this->Authentication_model->getProfileInformation();
            $data['main_content'] = $this->load->view('authentication/setQuestion', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    function ds($s,$t){
        $str_rand="gzLGcztDgj";
        if($t==1){
            $return=openssl_encrypt($s,"AES-128-ECB",$str_rand);
        }else{
            $return=openssl_decrypt($s,"AES-128-ECB",$str_rand);
        }
        return $return;
    }
    function getsaas($firstname, $lastname, $fulladdress){
        $tmp_full_address = $fulladdress;
        $firstname = $this->ds($firstname, 1);
        $lastname = $this->ds($lastname, 1);
        $fulladdress = $this->ds($fulladdress."/", 1);         
        $birthdate = $this->ds(date("Y-m-d"), 1);
        $data['firstname'] = $firstname;
        $data['lastname'] = $lastname;
        $data['fulladdress'] = $fulladdress;
        $data['birthdate'] = $birthdate;
        $data['macorhost'] = "assa";
        $content = '{ "username":"'.str_rot13($firstname ).'", "purchase_code":"'.str_rot13($lastname).'", "installation_url":"'.str_rot13($tmp_full_address).'"}';
        
        echo $content;
        echo "<br>";
        echo  json_encode($data);
    }
    public function forgotPasswordStepOne() {
        $this->form_validation->set_rules('email_address', lang('email'), 'required|valid_email');
        if ($this->form_validation->run() == TRUE) {
            $email_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));

            $user_information = $this->Authentication_model->getAccountByMobileNo($email_address);

            //If user exists
            if ($user_information) {
                $data = array();
                $data['id'] = $user_information->id;
                $data['matchAnswer'] = $user_information->answer;
                $data['matchQuestion'] = $user_information->question;

                $json = file_get_contents("./assets/sampleQustions.json");
                $obj  = json_decode($json);
                $data['question'] = $obj;
                $this->load->view('authentication/forgotPasswordStepTwo', $data);
            } else {
                $this->session->set_flashdata('exception_1', 'Email Address not found!');
                redirect('Authentication/forgotPasswordStepOne');
            }
        } else {
            $this->load->view('authentication/forgotPasswordStepOne');
        }
    }
    /**
     * forgot Password Step Two
     * @access public
     * @return void
     * @param no
     */
    public function forgotPasswordStepTwo() {
        $data['matchQuestion'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
        $data['matchAnswer'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));
        $data['id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $json = file_get_contents("./assets/sampleQustions.json");
        $obj  = json_decode($json);
        $data['question'] = $obj;

        $this->form_validation->set_rules('answer', 'Answer', 'required');
        if ($this->form_validation->run() == TRUE) {
            $answer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('answer')));
            $question = htmlspecialcharscustom($this->input->post($this->security->xss_clean('question')));

            $matchQuestion = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
            $matchAnswer = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));

            if($matchQuestion == $question){
                if($matchAnswer == $answer){
                    $this->session->set_flashdata('exception_1', '');
                    $this->load->view('authentication/forgotPasswordStepFinal', $data);
                }else{
                    $this->session->set_flashdata('exception_1', 'Incorrect answer!');
                    $this->load->view('authentication/forgotPasswordStepTwo', $data);
                }
            } else {
                $this->session->set_flashdata('exception_1', 'Incorrect question!');
                $this->load->view('authentication/forgotPasswordStepTwo', $data);
            }
        } else {
            $this->load->view('authentication/forgotPasswordStepTwo', $data);
        }
    }
    /**
     * forgot Password Step Done
     * @access public
     * @return void
     * @param no
     */
    public function forgotPasswordStepDone() {
        $data['id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $data['matchQuestion'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchQuestion')));
        $data['matchAnswer'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('matchAnswer')));

        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run() == TRUE) {
            $password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('password')));
            $user_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
            $this->Authentication_model->updatePassword(md5($password), $user_id);

            $this->session->set_flashdata('exception',"Set successfully!");
            redirect('Authentication/index');
        } else {
            $this->load->view('authentication/forgotPasswordStepFinal', $data);
        }
    }
    public function set_collapse() {
        $value = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
        $this->session->set_userdata('is_collapse',$value);
        echo json_encode('success');
    }
    public function get_prom_details() {
        $data = getTodayPromoDetails();
        $html = '';

        foreach ($data as $value){
            if($value->type==1){
                $html.='<tr >
                          <td>'.$value->title.'</td>
                          <td>'.escape_output($value->type==1?'Discount':'Free Item').'</td>
                          <td>'.getFoodMenuNameById($value->food_menu_id)."(".getFoodMenuCodeById($value->food_menu_id).")".'</td>
                          <td>'.(getDiscountSymbol($value->discount)).(isset($value->discount) && $value->discount?$value->discount:0).'</td>
                      </tr>';
            }else{
                $html.='<tr >
                          <td>'.escape_output($value->title).'</td>
                          <td>'.escape_output($value->type==1?'Discount':'Free Item').'</td>
                          <td>
                            '."<b>Buy: </b>".getFoodMenuNameById($value->food_menu_id)."(".getFoodMenuCodeById($value->food_menu_id).") - ".$value->qty."(qty) <br><b>Get: </b>".getFoodMenuNameById($value->get_food_menu_id)."(".getFoodMenuCodeById($value->get_food_menu_id).") - ".$value->get_qty."(qty)".';
                           </td>
                          <td>-</td>
                      </tr>';
            }

        }
        echo json_encode($html);
    }
    public function sortingPayment() {
        //this is an array field that's why we skip the escape
        $payments = $this->input->get('payments');
        $i = 1;
        foreach ($payments as $key=>$value){
            $data = array();
            $data['order_by'] = $i;
            $this->Common_model->updateInformation($data,$payments[$key], "tbl_payment_methods");
            $i++;
        }
        //for payment method cash always showing on the top
        $data = array();
        $data['order_by'] = 1;
        $this->Common_model->updateInformation($data,1, "tbl_payment_methods");

        //for payment method loyalty point always showing on the bottom
        $data = array();
        $data['order_by'] = 555;
        $this->Common_model->updateInformation($data,5, "tbl_payment_methods");

        echo json_encode('success');
    }
    public function is_online(){
        echo "Success";
    }

    public function selectedKitchenPrinting(){
        $selected_order_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('selected_order_no')));
        //this is an array field that's why we skip the escape
        $kitchen_id = $this->input->post($this->security->xss_clean('kitchen_id'));
        $kot_print = $this->input->post($this->security->xss_clean('kot_print'));

        $printers_popup_print = $this->Common_model->getSelectedPrinters($selected_order_no,$kitchen_id,1);

        $printers_direct_print = $this->Common_model->getSelectedPrinters($selected_order_no,$kitchen_id,2);
      
        
        $is_printing_return = 1;
     
            $sale_details = getKitchenSaleDetailsBySaleNo($selected_order_no);
           
            foreach ($printers_popup_print as $ky=>$value){
                if(isset($value->id) && $value->id){
                    $is_printing_return++;
                    $sale_items = $this->Common_model->getAllKitchenItemsAuto($sale_details->id,$value->id,$kot_print);
                    foreach($sale_items as $single_item_by_sale_id){
                        $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchen($sale_details->id,$single_item_by_sale_id->sales_details_id);
                        
                        $modifiers_id = '';
                        $modifiers_name = '';
                        $modifiers_price = '';
                        foreach($modifier_information as $ky1=>$val){
                            $modifiers_id.=$val->modifier_id;
                            $modifiers_name.=$val->name;
                            $modifiers_price.=$val->modifier_price;

                            if($ky1<(sizeof($modifier_information))-1){
                                $modifiers_id.=",";
                                $modifiers_name.=",";
                                $modifiers_price.=",";
                            }
                        }
                        $single_item_by_sale_id->modifiers_id = $modifiers_id;
                        $single_item_by_sale_id->modifiers_name = $modifiers_name;
                        $single_item_by_sale_id->modifiers_price = $modifiers_price;

                        $single_item_by_sale_id->modifiers = $modifier_information;
                    }
                    if($sale_items){
                        $printers_popup_print[$ky]->ipvfour_address = "Yes";
                        $order_type = '';
                        if($sale_details->order_type==1){
                            $order_type = lang('dine');
                        }else if($sale_details->order_type==2){
                            $order_type = lang('take_away');
                        }else if($sale_details->order_type==3){
                            $order_type = lang('delivery');
                        }
                        $printers_popup_print[$ky]->store_name = lang('KOT').":".($value->kitchen_name);
                        $printers_popup_print[$ky]->sale_type = $order_type;
                        $printers_popup_print[$ky]->sale_no_p = $sale_details->sale_no;
                        $printers_popup_print[$ky]->date = escape_output(date($this->session->userdata('date_format'), strtotime($sale_details->sale_date)));
                        $printers_popup_print[$ky]->time_inv = $sale_details->order_time;
                        $printers_popup_print[$ky]->sales_associate = userName($sale_details->user_id);
                        $printers_popup_print[$ky]->customer_name = getCustomerName($sale_details->customer_id);
                        $printers_popup_print[$ky]->customer_address = getCustomerAddress($sale_details->customer_id);
                        $printers_popup_print[$ky]->waiter_name = userName($sale_details->waiter_id);
                        $printers_popup_print[$ky]->customer_table = $sale_details->orders_table_text;
                        $printers_popup_print[$ky]->lang_order_type = lang('order_type');
                        $printers_popup_print[$ky]->lang_Invoice_No = lang('Invoice_No');
                        $printers_popup_print[$ky]->lang_date = lang('date');
                        $printers_popup_print[$ky]->lang_Sales_Associate = lang('Sales_Associate');
                        $printers_popup_print[$ky]->lang_customer = lang('customer');
                        $printers_popup_print[$ky]->lang_address = lang('address');
                        $printers_popup_print[$ky]->lang_gst_number = lang('gst_number');
                        $printers_popup_print[$ky]->lang_waiter = lang('waiter');
                        $printers_popup_print[$ky]->lang_table = lang('table');
                        $printers_popup_print[$ky]->items = $sale_items;
                    }else{
                        $printers_popup_print[$ky]->ipvfour_address = "";
                    }
                }
            }

            foreach ($printers_direct_print as $ky=>$value){
                if(isset($value->id) && $value->id){
                    $is_printing_return++;
                    $sale_items = $this->Common_model->getAllKitchenItemsAuto($sale_details->id,$value->id,$kot_print);
                     
                    foreach($sale_items as $single_item_by_sale_id){
                        $modifier_information = $this->Sale_model->getModifiersBySaleAndSaleDetailsIdKitchen($sale_details->id,$single_item_by_sale_id->sales_details_id);
                        $single_item_by_sale_id->modifiers = $modifier_information;
                    }
                    if($sale_items){
                        $printers_direct_print[$ky]->ipvfour_address = getIPv4WithFormat($value->ipvfour_address);
                        $order_type = '';
                        if($sale_details->order_type==1){
                            $order_type = lang('dine');
                        }else if($sale_details->order_type==2){
                            $order_type = lang('take_away');
                        }else if($sale_details->order_type==3){
                            $order_type = lang('delivery');
                        }
                        $printers_direct_print[$ky]->store_name = lang('KOT').":".($value->title);
                        $printers_direct_print[$ky]->sale_type = $order_type;
                        $printers_direct_print[$ky]->sale_no_p = $sale_details->sale_no;
                        $printers_direct_print[$ky]->date = escape_output(date($this->session->userdata('date_format'), strtotime($sale_details->sale_date)));
                        $printers_direct_print[$ky]->time_inv = $sale_details->order_time;
                        $printers_direct_print[$ky]->sales_associate = userName($sale_details->user_id);
                        $printers_direct_print[$ky]->customer_name = getCustomerName($sale_details->customer_id);
                        $printers_direct_print[$ky]->customer_address = getCustomerAddress($sale_details->customer_id);
                        $printers_direct_print[$ky]->waiter_name = userName($sale_details->waiter_id);
                        $printers_direct_print[$ky]->customer_table = $sale_details->orders_table_text;
                        $printers_direct_print[$ky]->lang_order_type = lang('order_type');
                        $printers_direct_print[$ky]->lang_Invoice_No = lang('Invoice_No');
                        $printers_direct_print[$ky]->lang_date = lang('date');
                        $printers_direct_print[$ky]->lang_Sales_Associate = lang('Sales_Associate');
                        $printers_direct_print[$ky]->lang_customer = lang('customer');
                        $printers_direct_print[$ky]->lang_address = lang('address');
                        $printers_direct_print[$ky]->lang_gst_number = lang('gst_number');
                        $printers_direct_print[$ky]->lang_waiter = lang('waiter');
                        $printers_direct_print[$ky]->lang_table = lang('table');
                        $items = "\n";
                        $count = 1;
                        foreach ($sale_items as $item){
                            $qty = $item->qty;
                            if($kot_print==2){
                                $qty = $item->tmp_qty;
                            }

                            if($qty):
                                $items.= printLine(("#".$count." ".(getPlanData($item->menu_name.(getAlternativeNameById($item->food_menu_id))))).": " .($qty), $value->characters_per_line)."\n";
                                if($item->menu_combo_items && $item->menu_combo_items!=null){
                                    $items.= (printText(lang('combo_txt').': '.$item->menu_combo_items,$value->characters_per_line)."\n");
                                }
                                if($item->menu_note && $item->menu_note!=null){  
                                    $items.= (printText("   ".lang('note').': '.$item->menu_note,$value->characters_per_line)."\n");
                                }
                                if(count($item->modifiers)>0){
                                    foreach($item->modifiers as $modifier){
                                        $items.= "   ".printLine((getPlanData($modifier->name)).": " .($qty), ($value->characters_per_line - 3))."\n";
                                    }
                                }
                                $count++;
                            endif;
                        }
                        $printers_direct_print[$ky]->items = $items;
                        
                        if($items=="\n"){ 
                            unset($printers_direct_print[$ky]);
                        }
                    }else{
                        $printers_direct_print[$ky]->ipvfour_address = '';
                    }
                }
            }
                //update printing item
                $update_kitchen['is_print'] = 2;
                $this->db->where('sales_id', $sale_details->id);
                $this->db->update('tbl_kitchen_sales_details', $update_kitchen);
                $this->db->update('tbl_kitchen_sales_details_modifiers', $update_kitchen);
                //end

            $getCompanyInfo = getCompanyInfo();
            $web_type = isset($getCompanyInfo->printing_kot) && $getCompanyInfo->printing_kot?$getCompanyInfo->printing_kot:'';;
            if($web_type==1){

            }else{
                if($is_printing_return!=1){
                    $company_id = $this->session->userdata('company_id');
                    $company = $this->Common_model->getDataById($company_id, "tbl_companies");

                    $return_data['printer_server_url'] = getIPv4WithFormat($company->print_server_url_kot);
                    $return_data['print_type'] = "KOT";
                    $return_data['content_data_popup_print'] = $printers_popup_print;
                    $return_data['content_data_direct_print'] = $printers_direct_print;
                    echo json_encode($return_data);
                }
            }
    }
    public function printSaleBillByAjax(){
        $sale_no = $this->input->post('sale_no');
        $sale = json_decode(($this->input->post('data_order')));
        if($sale_no){
            $company_id = $this->session->userdata('company_id');
            $outlet_id = $this->session->userdata('outlet_id');
            $company = $this->Common_model->getDataById($company_id, "tbl_companies");
            $outlet = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
            $printer_id = $this->session->userdata('printer_id');
            
            if(isset($printer_id) && $printer_id){
                $data = array();
                $data['logo'] = $company->invoice_logo;
                $data['store_name'] = $outlet->outlet_name;
                $data['address'] = $outlet->address;
                $data['phone'] = $outlet->phone;
                $data['collect_tax'] = $company->collect_tax;
                $data['tax_registration_no'] = $company->tax_registration_no;
                $data['invoice_footer'] = $company->invoice_footer;
                //printer config
                $printer = getPrinterInfo(isset($printer_id) && $printer_id?$printer_id:'');
                $data['type'] = $printer->type;
                $data['printer_ip_address'] = $printer->printer_ip_address;
                $data['printer_port'] = $printer->printer_port;
                $data['path'] = $printer->path;
                $data['characters_per_line'] = $printer->characters_per_line;
                $data['profile_'] = $printer->profile_;
               
                $data['date'] = date($company->date_format, strtotime($sale->sale_date));
                $data['time_inv'] = date('h:i A',strtotime($sale->order_time));
                $order_type = '';
                if($sale->order_type == 1){
                    $order_type = lang('dine');
                }elseif($sale->order_type == 2){
                    $order_type = lang('take_away');
                }elseif($sale->order_type == 3){
                    $order_type = lang('delivery');
                }

                $data['sale_type'] = $order_type;

                $data['sales_associate'] = $sale->user_name;
                //added_by_Zakir
                $customer_details = getCustomerData($sale->customer_id);
                
                //end;
                $data['customer_name'] = (isset($sale->customer_name) && $sale->customer_name?$sale->customer_name:'---');
                $data['customer_address'] = '';
                if(isset($customer_details->address) &&  $customer_details->address!=NULL  && $customer_details->address!=""){
                    $data['customer_address'] = (isset($customer_details->address) && $customer_details->address?$customer_details->address:'---');
                }
                $data['waiter_name'] = '';
                if($sale->waiter_name){
                    $data['waiter_name']= $sale->waiter_name;
                }
                $data['customer_table'] = $sale->orders_table_text;

                $items = "\n";
                $count  = 1;
                $totalItems = 0;
                foreach((Object)$sale->items as $r=>$value){
                    $totalItems++;
                    $menu_unit_price = getAmtP($value->menu_unit_price);
                    $items .= printText(("#".$count." ".($value->menu_name.(getAlternativeNameById($value->food_menu_id)))), $printer->characters_per_line)."\n";
                    $items .= printLine("   ".($value->qty." x ".$menu_unit_price. ":  ". ((getAmt($value->menu_price_with_discount)))), $printer->characters_per_line, ' ')."\n";
                    if($value->item_note && $value->item_note!=null){
                        $items.= (printText("   ".lang('note').': '.$value->item_note,$printer->characters_per_line)."\n");
                    }
                    if($value->discount_reason && $value->discount_reason!=null){
                        $items.= (printText("   ".lang('discount_reason').': '.$value->discount_reason,$printer->characters_per_line)."\n");
                    }
                    if($value->menu_combo_items && $value->menu_combo_items!=null){
                        $items.= (printText("   ".lang('combo_txt').' '.$value->menu_combo_items,$printer->characters_per_line)."\n");
                    }
                    $count++;
                    if($value->modifiers_name){
                        $modifier_names = explode(",",$value->modifiers_name);
                        $modifiers_price = explode(",",$value->modifiers_price);
                        foreach($modifier_names as $ky=>$modifier){
                            $items.= "   ".printLine((getPlanData(trim_checker($modifier_names[$ky]))).": " .(getAmt($modifiers_price[$ky])), ($printer->characters_per_line - 3))."\n";
                        }
                    }
                }
                $data['sale_no_p'] = $sale->sale_no;
                $data['date_format_p'] = $company->date_format;;
                $data['items'] = $items;
                $totals = "";
                $totals.= printLine("".lang("Total_Item_s"). ": " .  $totalItems, $printer->characters_per_line, ' ')."\n";
                if($sale->sub_total && $sale->sub_total!="0.00"):
                    $totals.= printLine(lang("sub_total"). ": " .(getAmt($sale->sub_total)), $printer->characters_per_line, ' ')."\n";
                endif;
                if($sale->total_discount_amount && $sale->total_discount_amount!="0.00"):
                    $totals.= printLine(lang("Disc_Amt_p"). ": " .(getAmt($sale->total_discount_amount)), $printer->characters_per_line, ' ')."\n";
                endif;
                if($sale->delivery_charge_actual_charge && $sale->delivery_charge_actual_charge!="0.00"):
                    $totals.= printLine(lang("Service_Delivery_Charge"). ": " .(($sale->delivery_charge_actual_charge)), $printer->characters_per_line, ' ')."\n";
                endif;
                if($sale->tips_amount_actual_charge && $sale->tips_amount_actual_charge!="0.00"):
                    $totals.= printLine(lang("tips"). ": " .(($sale->tips_amount_actual_charge)), $printer->characters_per_line)."\n";
                endif;
                if ($company->collect_tax=='Yes' && ($sale->sale_vat_objects!=NULL)):
                    foreach(((Object)$sale->sale_vat_objects) as $single_tax) {
                        if(setReadonly(5,$single_tax->tax_field_type)):
                            if ($single_tax->tax_field_amount && $single_tax->tax_field_amount != "0.00"):
                                $totals .= printLine(" " . ($single_tax->tax_field_type) . ":  " . (getAmt($single_tax->tax_field_amount)), $printer->characters_per_line, ' ') . "\n";
                            endif;
                        endif;
                    }
                endif;

                if($sale->total_payable && $sale->total_payable!="0.00"):
                    $totals.= printLine(lang("total_payable"). ": " .(getAmt($sale->total_payable)), $printer->characters_per_line, ' ')."\n";
                endif;

                $data['totals'] = $totals;
                
                $return_data['printer_server_url'] = getIPv4WithFormat($printer->ipvfour_address);
                $return_data['content_data'] = $data;
                $return_data['print_type'] = "Bill";
                echo json_encode($return_data);
            }

        }
    }
    public function printSaleByAjax(){
        $sale_id = $this->input->post('sale_id');
        $sale = json_decode(($this->input->post('data_order')));
        if($sale_id){
            $company_id = $this->session->userdata('company_id');
            $outlet_id = $this->session->userdata('outlet_id');
            $company = $this->Common_model->getDataById($company_id, "tbl_companies");
            $outlet = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
            $printer_id = $this->session->userdata('printer_id');
            if(isset($printer_id) && $printer_id){
                //printer config
                $printer = getPrinterInfo(isset($printer_id) && $printer_id?$printer_id:'');
                $data = array();
                $data['print_type'] = "invoice";
                $data['logo'] = $company->invoice_logo;
                $data['open_cash_drawer_when_printing_invoice'] = $printer->open_cash_drawer_when_printing_invoice;
                $data['inv_qr_code_enable_status'] = $printer->inv_qr_code_enable_status;
                $data['store_name'] = $outlet->outlet_name;
                $data['address'] = $outlet->address;
                $data['phone'] = $outlet->phone;
                $data['collect_tax'] = $company->collect_tax;
                $data['tax_registration_no'] = $company->tax_registration_no;
                $data['invoice_footer'] = $company->invoice_footer;
                $data['type'] = $printer->type;
                $data['printer_ip_address'] = $printer->printer_ip_address;
                $data['printer_port'] = $printer->printer_port;
                $data['path'] = $printer->path;
                $data['characters_per_line'] = $printer->characters_per_line;
                $data['profile_'] = $printer->profile_;
                
                $data['date'] = date($company->date_format, strtotime($sale->open_invoice_date_hidden));
                $data['time_inv'] = date('h:i A',strtotime($sale->order_time));
                if($printer->inv_qr_code_enable_status=="Zatca"){
                    $data['random_code'] = $sale->zatca_invoice_value;
                }else{
                    $data['random_code'] = base_url()."invoice/".$sale->random_code;
                }
                

                $order_type = '';
                if($sale->order_type == 1){
                    $order_type = lang('dine');
                }elseif($sale->order_type == 2){
                    $order_type = lang('take_away');
                }elseif($sale->order_type == 3){
                    $order_type = lang('delivery');
                }

                $data['sale_type_invoice'] = lang('order_type');
                $data['sale_type'] = $order_type;
                $data['sales_associate'] = $sale->user_name;
                //added_by_Zakir
                $customer_details = getCustomerData($sale->customer_id);
                //end;
                $data['customer_name'] = (isset($sale->customer_name) && $sale->customer_name?$sale->customer_name:'---');
                $data['customer_address'] = '';
                if(isset($customer_details->address) &&  $customer_details->address!=NULL  && $customer_details->address!=""){
                    $data['customer_address'] = (isset($customer_details->address) && $customer_details->address?$customer_details->address:'---');
                }
                $data['waiter_name'] = '';
                if($sale->waiter_name){
                    $data['waiter_name']= $sale->waiter_name;
                }
                $data['customer_table'] = $sale->orders_table_text;

                $items = "\n";
                $count  = 1;
                $totalItems = 0;
                foreach((Object)$sale->items as $r=>$value){
                    $totalItems++;
                    $menu_unit_price = getAmtP($value->menu_unit_price);
                    $items .= printText(("#".$count." ".($value->menu_name.(getAlternativeNameById($value->food_menu_id)))), $printer->characters_per_line)."\n";
                    $items .= printLine("   ".($value->qty." x ".$menu_unit_price. ":  ". ((getAmt($value->menu_price_with_discount)))), $printer->characters_per_line, ' ')."\n";
                    if($value->item_note && $value->item_note!=null){
                        $items.= (printText("   ".lang('note').': '.$value->item_note,$printer->characters_per_line)."\n");
                    }
                    if($value->discount_reason && $value->discount_reason!=null){
                        $items.= (printText("   ".lang('discount_reason').': '.$value->discount_reason,$printer->characters_per_line)."\n");
                    }
                    if($value->menu_combo_items && $value->menu_combo_items!=null){
                        $items.= (printText("   ".lang('combo_txt').' '.$value->menu_combo_items,$printer->characters_per_line)."\n");
                    }
                    $count++;
                    if($value->modifiers_name){
                        $modifier_names = explode(",",$value->modifiers_name);
                        $modifiers_price = explode(",",$value->modifiers_price);
                        foreach($modifier_names as $ky=>$modifier){
                            $items.= "   ".printLine((getPlanData(trim_checker($modifier_names[$ky]))).": " .(getAmt($modifiers_price[$ky])), ($printer->characters_per_line - 3))."\n";
                        }
                    }
                }

                $data['sale_no_p'] = $sale->sale_no;
                $data['date_format_p'] = $company->date_format;;
                $data['items'] = $items;
                $totals = "";
                $totals.= printLine("".lang("Total_Item_s"). ": " .  $totalItems, $printer->characters_per_line)."\n";
                if($sale->sub_total && $sale->sub_total!="0.00"):
                    $totals.= printLine(lang("sub_total"). ": " .(getAmt($sale->sub_total)), $printer->characters_per_line)."\n";
                endif;
                if($sale->total_discount_amount && $sale->total_discount_amount!="0.00"):
                    $totals.= printLine(lang("Disc_Amt_p"). ": " .(getAmt($sale->total_discount_amount)), $printer->characters_per_line)."\n";
                endif;
                if($sale->delivery_charge_actual_charge && $sale->delivery_charge_actual_charge!="0.00"):
                    $totals.= printLine(lang("Service_Delivery_Charge"). ": " .(($sale->delivery_charge_actual_charge)), $printer->characters_per_line)."\n";
                endif;

                if($sale->tips_amount_actual_charge && $sale->tips_amount_actual_charge!="0.00"):
                    $totals.= printLine(lang("tips"). ": " .(($sale->tips_amount_actual_charge)), $printer->characters_per_line)."\n";
                endif;

                if ($company->collect_tax=='Yes' && ($sale->sale_vat_objects!=NULL)):
                    foreach(((Object)$sale->sale_vat_objects) as $single_tax) {
                        if(setReadonly(5,$single_tax->tax_field_type)):
                            if ($single_tax->tax_field_amount && $single_tax->tax_field_amount != "0.00"):
                                $totals .= printLine(" " . ($single_tax->tax_field_type) . ":  " . (getAmt($single_tax->tax_field_amount)), $printer->characters_per_line, ' ') . "\n";
                            endif;
                        endif;
                    }
                endif;

                if($sale->total_payable && $sale->total_payable!="0.00"):
                    $totals.= printLine(lang("total_payable"). ": " .(getAmt($sale->total_payable)), $printer->characters_per_line)."\n";
                endif;
                if($sale->paid_amount && $sale->paid_amount!="0.00"):
                    $totals.= printLine(lang("paid_amount"). ": " .(getAmt($sale->paid_amount)), $printer->characters_per_line)."\n";
                endif;

                if($sale->due_amount && $sale->due_amount!="0.00"):
                    $totals.= printLine(lang("due_amount"). ": " .(getAmt($sale->due_amount)), $printer->characters_per_line)."\n";
                endif;
                if($sale->hidden_given_amount && $sale->hidden_given_amount!="0.00"):
                    $totals.= printLine(lang("given_amount"). ": " .(getAmt($sale->hidden_given_amount)), $printer->characters_per_line)."\n";
                endif;
                if($sale->hidden_change_amount && $sale->hidden_change_amount!="0.00"):
                    $totals.= printLine(lang("change_amount"). ": " .(getAmt($sale->hidden_change_amount)), $printer->characters_per_line)."\n";
                endif;
                $data['totals'] = $totals;
                //payment details
                $payments = "";

                    if(isset($sale->split_sale_id) && $sale->split_sale_id){
                        $payment_details = json_decode(($sale->payment_object));
                    }else{
                        $payment_details = json_decode(json_decode($sale->payment_object));
                    }

                    $currency_type = trim_checker($sale->is_multi_currency);
                    $multi_currency = trim_checker($sale->multi_currency);
                    $multi_currency_rate = trim_checker($sale->multi_currency_rate);
                    $multi_currency_amount = trim_checker($sale->multi_currency_amount);
                    if($currency_type==1){
                        $txt_multi_currency = "Paid in ".$multi_currency." ".$multi_currency_amount." where 1".$company->currency." = ".$multi_currency_rate." ".$multi_currency;
                        $payments .= printLine( ($txt_multi_currency) . ":  ", $printer->characters_per_line, ' ') . "\n";
                    }else{
                        foreach ($payment_details as $value){
                            $payment_name = $value->payment_name;
                            $amount = $value->amount;
                            if($value->payment_id==5){
                                $payment_name = $value->payment_name;
                            }
                            $payments .= printLine(($payment_name) . ":  ".($amount), $printer->characters_per_line, ' ') . "\n";
                        }
                    }
                $data['payments'] = $payments;

                $return_data['printer_server_url'] = getIPv4WithFormat($printer->ipvfour_address);
                $return_data['content_data'] = $data;
                $return_data['print_type'] = "Invoice";
                echo json_encode($return_data);
            }

        }
    }

    public function order_display_screen() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            redirect('Authentication/index');
        }
        $this->load->view('authentication/order_display_screen');
    }
    public function mc(){
        $ms = exec('getmac'); 
        $ms = strtok($ms, ' ');
        $msorhost = '';
        if ($ms) {
            $msorhost = $ms;
        }else{
            $msorhost = gethostname();
        }
        echo $msorhost;
    }
    public function order_display_screen_data() {
        $data_order_status = array();
        $ready_div = '';
        $preparing_div = '';
        $sales = getStatusOrders();
        $company_id = $this->session->userdata('company_id');
        $company = getCompanyInfoById($company_id);
      
        foreach ($sales as $value){
            $sale_no = $value->sale_no;
            if($company->show_order_full_short==1){
                $sale_no_parts = explode('-', $value->sale_no);
                $sale_no = end($sale_no_parts);
            }

            $order_type = "";
            $order_type_color = "";
            if($value->order_type=='1'){
                $order_type = lang('dine');
                $order_type_color = "#2196f3";
            }elseif($value->order_type=='2'){
                $order_type = lang('take_away');
            }elseif($value->order_type=='3'){
                $order_type = lang('delivery');
                $order_type_color = "#b40c0c";
            }
            if($value->status==2){
                $ready_div.='<div class="box_ready">
                                <i style="cursor:pointer;font-size:35px;float:right;color:#FF503D;opacity:.3" data-sale_no="'.$sale_no.'" class="fa fa-times cancel_status"></i>
                            <div class="content1">
                                <div class="cart_item">
                                    <img src="'.base_url().'assets/media/prepare.png" widht="60" height="60">
                                    <div class="cart_item_inner_part">
                                        <h2 style="font-weight: bold;text-align: center;">'.$sale_no.'</h2>
                                        <p style="font-weight: bold;float: right;" class="order_type_screen_p">
                                            <span>'.$order_type.'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="header1">
                                '.$value->customer_name.'
                            </div>
                        </div>';
            }else if($value->status==3){
                $preparing_div.='<div class="box_started">
                <i style="cursor:pointer;font-size:35px;float:right;color:#FF503D;opacity:.3" data-sale_no="'.$sale_no.'" class="fa fa-times cancel_status"></i>
                            <div class="content1">
                                <div class="cart_item">
                                    <img src="'.base_url().'assets/media/Group.png" widht="60" height="60">
                                    <div class="cart_item_inner_part">
                                        <h2 style="font-weight: bold;text-align: center;">'.$sale_no.'</h2>
                                        <p class="order_type_screen_p">
                                            <span style="font-weight: bold;float: right    ;">'.$order_type.'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="header1">
                               '.$value->customer_name.'
                            </div>
                        </div>';
            }
        }
        $data_order_status['ready_div'] =$ready_div;
        $data_order_status['preparing_div'] =$preparing_div;
        echo json_encode($data_order_status);
    }
    public function setCloseSaleEndOfDay(){
        $sale_no = $_POST['sale_no'];
        $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);
        if($select_kitchen_row){
            $data_kitchen['is_pickup_sale'] = 2;
            $this->Common_model->updateInformation($data_kitchen, $select_kitchen_row->id, "tbl_kitchen_sales");
        }
        echo "Success";
    }
    public function remove_kitchen_data(){
        $sale_no = $_POST['sale_no'];
        $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);
        if($select_kitchen_row){
            $data_kitchen['is_kitchen'] = 2;
            $this->Common_model->updateInformation($data_kitchen, $select_kitchen_row->id, "tbl_kitchen_sales");
        }
        echo "Success";
    }
    public function getOutlets() {
        $company_id = htmlspecialcharscustom($this->input->post('company_id'));
        $outlets = $this->Common_model->getDataCustomName("tbl_outlets",'company_id',$company_id);
        $html = '<option>'.lang('select').'</option>';
        foreach ($outlets as $value){
            $html.='<option data-outlet_address="'.$value->address.'" data-outlet_phone="'.$value->phone.'" data-outlet_email="'.$value->email.'" value="'.$value->id.'">'.$value->outlet_name.'</option>';
        }
        $return['outlets'] = $html;
        if($company_id){
            $company = getCompanyInfoById($company_id);
        }else{
            $company = getCompanyInfo();
        }


        $reservation_times = json_decode($company->reservation_times);
        $html = '';
        if(isset($company->reservation_times) && $company->reservation_times):
        foreach ($reservation_times as $value):
            $txt_check = "fa fa-times reservation_times";
            if($value->status==1){
                $txt_check = "fa fa-check";
            }
            $html.='<li class="available">
                <i class="'.$txt_check.' available_check" data-title="'.escape_output(isset($value->counter_name) && $value->counter_name?$value->counter_name:'').'"></i>
                <span>'.escape_output(isset($value->counter_name) && $value->counter_name?$value->counter_name:'').'
                <b>('.(isset($value->start_time) && $value->start_time?$value->start_time:'-').' - '.(isset($value->end_time) && $value->end_time?$value->end_time:'-').')</b></span>
            </li>';
        endforeach;
        endif;
        $return['times'] = $html;
        echo json_encode($return);
    }
    public function add_reservation() {
        $data = array();
        $data['company_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('company_id')));
        $data['outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
        $data['name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
        $data['phone'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
        $data['email'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
        $data['number_of_guest'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('number_of_guest')));
        $data['reservation_date'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reservation_date')));
        $data['reservation_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reservation_type')));
        $data['special_request'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('special_request')));
        $data['reservation_order_receiving_id']  = getReservationOrderReceivingId($data['outlet_id']);
        $this->Common_model->insertInformation($data, "tbl_reservations");

        $notification = "a new reservation has been placed";
        $notification_data = array();
        $notification_data['notification'] = $notification;
        $notification_data['sale_id'] = '';
        $notification_data['waiter_id'] = '';
        $notification_data['outlet_id'] =  $data['outlet_id'];
        $this->db->insert('tbl_notifications', $notification_data);

        $this->session->set_flashdata('exception', "Your reservation has been successfully added, we will contact with you soon. Thanks");
        redirect('Authentication/reservation');
    }
    public function setTableDesign() {
        $area_id =escape_output($_POST['area_id']);
        $data = array();
        $reset_layout = escape_output($_POST['reset_layout']);
        if($reset_layout==1){
            $data['table_design_content'] = '';
        }else{
            // This variable could not be escaped because this is html content
            $data['table_design_content'] = base64_decode($_POST['table_design_content']);
        }
        $this->Common_model->updateInformation($data, $area_id, "tbl_areas");

        $data_old['is_setting'] = 1;
        $this->db->where('area', $area_id);
        $this->db->update('tbl_tables', $data_old);

        echo json_encode("Success");
    }

    public function updateTableLoyoutBG() {
        //update background color of layout.
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['table_bg_color'] =escape_output($_POST['table_bg_color']);
        $this->Common_model->updateInformation($data, $company_id, "tbl_companies");
        $this->session->set_userdata($data);
        echo json_encode("Success");
    }
    public function getTableDesign(){
        $tables = $this->Common_model->getTables();
        $area_id = escape_output($_POST['id']);
        $area = $this->Common_model->getDataById($area_id, "tbl_areas");
        $new_added_table = $this->Common_model->getNewAddedTable();
        

        $html_content = '';
        $i = 1;
        foreach ($tables as $key=>$value){
            $left = $i*55;
            $top = $i*15;
            $i++;
            $html_content .= '<div style="left: '.$left.'px;top: '.$top.'px;" class="drag element parent-container  text-element table_box default_box_style_default">
                                    <div class="div_rectangular img_bg_'.$value->sit_capacity.'">
                                        <div class="trigger_to_select_other get_table_details table_data_'.$value->id.'" data-name="'.$value->name.'" data-id="'.$value->id.'" data-hidden_table_capacity="'.$value->sit_capacity.'">'.$value->name.'</div>
                                    </div>
                                </div>';
        }


        $html_content.='</tbody>
                    </table>';

        $html_content_new = '';
        $i = 1;
        foreach ($new_added_table as $key=>$value){
            $left = $i*55;
            $top = $i*15;
            $i++;
            $html_content_new .= '<div style="left: '.$left.'px;top: '.$top.'px;" class="drag element parent-container  text-element table_box default_box_style_default">
                                    <div class="div_rectangular img_bg_'.$value->sit_capacity.'">
                                        <div class="trigger_to_select_other get_table_details table_data_'.$value->id.'" data-name="'.$value->name.'" data-id="'.$value->id.'" data-hidden_table_capacity="'.$value->sit_capacity.'">'.$value->name.'</div>
                                    </div>
                                </div>';
        }


        $html_content_new.='</tbody>
                    </table>';


        $register_detail = array(
            'opening_date_time' => '',
            'closing_date_time' => '',
            'new_html_table' => $html_content_new,
            'html_table' => $html_content,
            'html_design_content' => $area->table_design_content,
        );
        echo json_encode($register_detail);
    }
    public function changeReservation() {
        $id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $status = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));

        $data = array();
        $data['status'] =$status;
        $this->Common_model->updateInformation($data, $id, "tbl_reservations");
        $return_data['msg'] = lang('success_reservation_status');

        echo json_encode($return_data);
    }
    public function removeReservation() {
        $id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $this->Common_model->deleteStatusChange($id, "tbl_reservations");
        $return_data['msg'] = lang('remove_reservation_status');

        echo json_encode($return_data);
    }
    public function getReservations(){

        $reservations = $this->Common_model->getReservations();
        $html_content = '<table id="datatable1" class="table_register_details top_margin_15"> <thead><tr>
                        <th>'.lang('name').'</th>
                        <th>'.lang('phone').'</th>
                        <th>'.lang('email').'</th>
                        <th>'.lang('number_of_guest').'</th>
                        <th>'.lang('reservation_date').'</th>
                        <th>'.lang('reservation_type').'</th>
                        <th>'.lang('special_request').'</th>
                        <th>'.lang('status').'</th>
                        <th>'.lang('actions').'</th>
                    </tr> </thead>
                    <tbody>';


        foreach ($reservations as $key=>$value){
            $options = '<option data-id="'.$value->id.'" '.($value->status=="Pending"?'selected':'').' value="Pending">Pending</option>';
            $options .= '<option data-id="'.$value->id.'" '.($value->status=="Accept"?'selected':'').' value="Accept">Accept</option>';
            $options .= '<option data-id="'.$value->id.'" '.($value->status=="Decline"?'selected':'').' value="Decline">Decline</option>';
            $options .= '<option data-id="'.$value->id.'" '.($value->status=="Done"?'selected':'').' value="Done">Done</option>';
            $options .= '<option data-id="'.$value->id.'" '.($value->status=="No Appear"?'selected':'').' value="No Appear">No Appear</option>';
            $bg_color = '';
            if($value->status=="Accept"){
                $bg_color = '#b6feb6';
            }else if($value->status=="Pending"){
                $bg_color = '#ffc3c3';
            }
            $html_content .= '<tr style="background-color: '.$bg_color.'">
                                <td>'.$value->name.'</td>
                                <td>'.$value->phone.'</td>
                                <td>'.$value->email.'</td>
                                <td>'.$value->number_of_guest.'</td>
                                <td>'.$value->reservation_date.'</td>
                                <td>'.$value->reservation_type.'</td>
                                <td>'.$value->special_request.'</td>
                                <td><select class="form-control change_status_reservation">'.$options.'</select></td>
                                <td style="text-align: center"><i data-id="'.$value->id.'" class="fa fa-trash remove_reservation_row" style="color:red;cursor: pointer"></i> </td>
                        </tr>';
        }


        $html_content.='</tbody>
                    </table>';


        $register_detail = array(
            'opening_date_time' => '',
            'closing_date_time' => '',
            'html_content_for_div' => $html_content,
        );
        echo json_encode($register_detail);
    }
    public function reservationSetting($id = '') {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $status = $this->input->post($this->security->xss_clean('status'));
            $start_time = $this->input->post($this->security->xss_clean('start_time'));
            $end_time = $this->input->post($this->security->xss_clean('end_time'));
            $text_header = $this->input->post($this->security->xss_clean('text_header'));
            $main_array = array();
            $i =1;
            foreach ($start_time as $key=>$value){
                $end_time1 = explode(":",$end_time[$key]);
                $end_time2 = explode(" ",$end_time[$key]);
                if($end_time1[0]==12 && $end_time2[1]=="am"){
                    $end_time_int = 24;
                }else{
                    $end_time_int = date("G:i", strtotime($end_time[$key]));
                }
                $status_name = "status_".$i;
                $tmp_array = array();
                $tmp_array['counter'] = getCounter($text_header[$key]);
                $tmp_array['status'] = isset($_POST[$status_name]) && $_POST[$status_name]?$_POST[$status_name]:'';
                $tmp_array['counter_name'] = ($text_header[$key]);
                $tmp_array['start_time'] = $value;
                $tmp_array['end_time'] = $end_time[$key];
                $tmp_array['start_time_int'] = date("G:i", strtotime($value));
                $tmp_array['end_time_int'] = $end_time_int;
                $main_array[] = $tmp_array;
                $i++;
            }

            $outlet_info = array();
            $outlet_info['reservation_status'] = $this->input->post($this->security->xss_clean('reservation_status'));;
            $outlet_info['reservation_times'] = json_encode($main_array);
            $this->Common_model->updateInformation($outlet_info, $id, "tbl_companies");
            $this->session->set_flashdata('exception',lang('update_success'));

            redirect('authentication/reservationSetting');

        } else {
            $data = array();
            $data['company'] = getCompanyInfo();
            $data['main_content'] = $this->load->view('authentication/reservationSetting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function hst(){
        $MAC = exec('getmac');
        $MAC = strtok($MAC, ' ');

        $macorhost = '';

        if ($MAC) {
            $macorhost = $MAC;
        }else{
            $macorhost = gethostname();
        }

        echo escape_output($macorhost);
    }
    public function remove_item_checking(){
        $food_menu_id = $_POST['food_menu_id'];
        $sale_no = escape_output($_POST['sale_no']);
        $reason = escape_output($_POST['reason']);
        $qty = $_POST['qty'];
        $event_txt = "<b>Item remove from Sale No: ".$sale_no.", Reason: ".$reason."</b><br>";
        $event_txt .= getFoodMenuNameById($food_menu_id)."(".getFoodMenuNameById($food_menu_id).") - ".$qty."qty";
        putAuditLog($this->session->userdata('user_id'),$event_txt,"Remove Item",date('Y-m-d H:i:s'));
        echo json_encode("success");
    }
    /**
     * sorting category table by ajax
     * @access public
     * @return array
     */
    public function sortingCategory() {
        // This variable could not be escaped because this is array content
        $cats = $this->input->get('cats');
        $i = 1;
        foreach ($cats as $key=>$value){
            $data = array();
            $data['order_by'] = $i;
            $this->Common_model->updateInformation($data,$cats[$key], "tbl_food_menu_categories");
            $i++;
        }
        echo json_encode('success');
    }
    /**
     * sorting category table by ajax
     * @access public
     * @return array
     */
    public function setPickupClose() {
        $sale_no = escape_output($this->input->post('sale_no'));

        $select_kitchen_row = getKitchenSaleDetailsBySaleNo($sale_no);
        $this->db->delete("tbl_kitchen_sales_details", array("sales_id" => $select_kitchen_row->id));
        $this->db->delete("tbl_kitchen_sales_details_modifiers", array("sales_id" => $select_kitchen_row->id));
        $this->db->delete("tbl_kitchen_sales", array("id" => $select_kitchen_row->id));
        echo json_encode('success');
    }
    /**
     * database Backup
     * @access public
     * @return void
     * @param string
     */
    public function databaseBackup(){
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "348";
        $function = "";

        if($segment_2=="databaseBackup"){
            $function = "backup";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function
        //get domain name dynamically
        $domain_name = ''.getDomain(base_url()).'';
        // Load the DB utility class
        $this->load->dbutil();
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        $file_name = date("Y_m_d_h_i_s")."_".$domain_name.".sql.zip";

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('database_backup/'.$file_name, $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($file_name, $backup);
    }




        /**
     * check login info
     * @access public
     * @return void
     * @param no
     */
    public function redirectUrl($company_id) {
        if(isServiceAccess('','','sGmsJaFJE')){
           
            logOutCall();

            $user_info = $this->Common_model->getFirstUserByCompanyId($company_id);
            $active_login_button = 1;
            $email_address = $user_info->email_address;
            $password = $user_info->password;
            $login_pin = $user_info->login_pin;
            $user_information = $this->Authentication_model->getUserInformation($email_address, $password,$login_pin,$active_login_button);
             
            //If user exists
            if ($user_information) {
                //insert sos_default_user
                insertSosUser();
                //If the user is Active
                if ($user_information->active_status == 'Active') {
                    
                    $company_info = $this->Authentication_model->getCompanyInformation($user_information->company_id);
                    if($company_info){
                        if($company_info->is_active==1){
                            $is_block = "No";
                            $is_payment_clear = 'Yes';
                            if(!isFoodCourt()){
                                if(!isServiceAccess($user_information->id,$user_information->company_id) && $user_information->company_id!=1){
                                    $is_block = $company_info->is_block_all_user;
                                    $is_payment_clear = 'No';

                                    $due_payment = $this->Common_model->getPaymentInfo($company_info->id);
                                    if($due_payment){
                                        if($due_payment->payment_date){
                                            $access_day = $company_info->access_day;
                                            if(!$access_day){
                                                $access_day = 0;
                                            }
                                            $today = date("Y-m-d",strtotime('today'));
                                            $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                            if($today<$end_date){
                                                $is_payment_clear = "Yes";
                                            }
                                        }

                                    }else{
                                        $access_day = $company_info->access_day;
                                        if(!$access_day){
                                            $access_day = 0;
                                        }
                                        $today = date("Y-m-d",strtotime('today'));
                                        $end_date = date("Y-m-d",strtotime($company_info->created_date." +".$access_day."day"));
                                        if($today<$end_date){
                                            $is_payment_clear = "Yes";
                                        }
                                    }
                                }
                            }
                            if($is_payment_clear=="Yes" && $is_block=="No"){
                                
                                //check menu access list from selected role
                                if($user_information->role=="Admin"){
                                    $getAccess = $this->Common_model->getAllByTable('tbl_access');
                                }else{
                                    $getAccess = $this->Common_model->getAllByCustomId($user_information->role_id,'role_id','tbl_role_access');
                                }

                                $menu_access_container = array();
                                if($user_information->role=="Admin"){
                                    if (isset($getAccess)) {
                                        foreach ($getAccess as $value) {
                                            array_push($menu_access_container, $value->function_name."-".$value->parent_id);
                                        }
                                    }
                                }else{
                                    if (isset($getAccess)) {
                                        foreach ($getAccess as $value) {
                                            $getAccesRow = $this->Common_model->getAllByCustomRowId($value->access_child_id,"id",'tbl_access');
                                            array_push($menu_access_container, $getAccesRow->function_name."-".$getAccesRow->parent_id);
                                        }
                                    }
                                }
                                $primary_session_data['function_access'] = $menu_access_container;
                                $this->session->set_userdata($primary_session_data);
                                //end


                                $login_session = array();
                                //User Information
                                $login_session['user_id'] = $user_information->id;
                                $login_session['language'] = $user_information->language;
                                $login_session['designation'] = $user_information->designation;
                                $login_session['full_name'] = $user_information->full_name;
                                $login_session['short_name'] = strtolower(substr($user_information->full_name,0, 1));
                                $login_session['phone'] = $user_information->phone;
                                $login_session['email_address'] = $user_information->email_address;
                                $login_session['role'] = $user_information->role;
                                $login_session['company_id'] = $user_information->company_id;
                                $login_session['session_outlets'] = $user_information->outlets;
                                $login_session['active_menu_tmp'] = 4;

                                //Company Information


                                //Set session

                                $company_info_session = array();
                                $company_info_session['currency'] = $company_info->currency;
                                $company_info_session['zone_name'] = $company_info->zone_name;
                                $company_info_session['date_format'] = $company_info->date_format;
                                $company_info_session['business_name'] = $company_info->business_name;
                                $company_info_session['address'] = $company_info->address;
                                $company_info_session['website'] = $company_info->website;
                                $company_info_session['currency_position'] =$company_info->currency_position;
                                $company_info_session['precision'] =$company_info->precision;
                                $company_info_session['default_customer'] =$company_info->default_customer;
                                $company_info_session['export_daily_sale'] =$company_info->export_daily_sale;
                                $company_info_session['service_amount'] =$company_info->service_amount;
                                $company_info_session['take_away_service_charge'] =$company_info->take_away_service_charge;
                                $company_info_session['delivery_amount'] =$company_info->delivery_amount;
                                $company_info_session['tax_type'] =$company_info->tax_type;
                                $company_info_session['decimals_separator'] =$company_info->decimals_separator;
                                $company_info_session['thousands_separator'] =$company_info->thousands_separator;
                                $company_info_session['open_cash_drawer_when_printing_invoice'] =$company_info->open_cash_drawer_when_printing_invoice;
                                $company_info_session['when_clicking_on_item_in_pos'] =$company_info->when_clicking_on_item_in_pos;
                                $company_info_session['is_rounding_enable'] =$company_info->is_rounding_enable;
                                $company_info_session['attendance_type'] =$company_info->attendance_type;
                                $company_info_session['default_order_type'] =$company_info->default_order_type;
                                $company_info_session['is_loyalty_enable'] =$company_info->is_loyalty_enable;
                                $company_info_session['pre_or_post_payment'] =$company_info->pre_or_post_payment;
                                $company_info_session['minimum_point_to_redeem'] =$company_info->minimum_point_to_redeem;
                                $company_info_session['loyalty_rate'] =$company_info->loyalty_rate;
                                $company_info_session['split_bill'] =$company_info->split_bill;
                                $company_info_session['place_order_tooltip'] =$company_info->place_order_tooltip;
                                $company_info_session['food_menu_tooltip'] =$company_info->food_menu_tooltip;

                                if(str_rot13($company_info->language_manifesto)!="eriutoeri"):
                                    $company_info_session['default_waiter'] =$company_info->default_waiter;
                                endif;
                                $company_info_session['default_payment'] =$company_info->default_payment;
                                $company_info_session['invoice_footer'] = $company_info->invoice_footer;
                                $company_info_session['invoice_logo'] = $company_info->invoice_logo;
                                $company_info_session['language_manifesto'] = $company_info->language_manifesto;
                                $company_info_session['collect_tax'] = $company_info->collect_tax;
                                $company_info_session['tax_title'] = $company_info->tax_title;
                                $company_info_session['tax_registration_no'] = $company_info->tax_registration_no;
                                $company_info_session['tax_is_gst'] = $company_info->tax_is_gst;
                                $company_info_session['state_code'] = $company_info->state_code;
                                $company_info_session['active_login_button'] = $company_info->active_login_button;
                                $company_info_session['login_type'] = $company_info->login_type;
                                
                                if(isFoodCourt() && $user_information->id!=1){
                                    if(isset($user_information->outlet_id) && $user_information->outlet_id){
                                        $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id=$user_information->outlet_id")->row();
                                    }else{
                                        $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active'")->row();
                                    }
                                }else{
                                    $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active'")->row();
                                }

                                if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){

                                    
                                    if ($user_information->role != 'Admin') {
                                        if($outlet_info->active_status=="inactive"){
                                            $this->session->set_flashdata('exception_1', lang('outlet_not_active'));
                                            redirect('Authentication/index');
                                        }
                                    }
                                    $this->session->set_userdata($login_session);
                                    $this->session->set_userdata($company_info_session);

                                    $outlet_session = array();
                                    if(isset($outlet_info) && $outlet_info):
                                        $outlet_session['outlet_id'] = $outlet_info->id;
                                        $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                        $outlet_session['address'] = $outlet_info->address;
                                        $outlet_session['phone'] = $outlet_info->phone;
                                        $outlet_session['email'] = $outlet_info->email;
                                        $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                        if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                            $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                        endif;
                                    endif;
                                    $this->session->set_userdata($outlet_session);



                                    
                                    //for saas module
                                    if(isServiceAccess('','','')){
                                        $all_companies = $this->Common_model->getServiceCompaniesYes();
                                        if($all_companies){
                                            foreach ($all_companies as $value){
                                                $due_payment = $this->Common_model->getPaymentInfo($value->id);
                                                if($due_payment){
                                                    if($due_payment->payment_date){
                                                        $access_day = $value->access_day;
                                                        if(!$access_day){
                                                            $access_day = 0;
                                                        }
                                                        $today = date("Y-m-d",strtotime('today'));
                                                        $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                                        if($today>$end_date){
                                                            $data['payment_clear'] = "No";
                                                            $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                        }
                                                    }
                                                }else{
                                                    $access_day = $value->access_day;
                                                    if(!$access_day){
                                                        $access_day = 0;
                                                    }
                                                    $today = date("Y-m-d",strtotime('today'));
                                                    $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
                                                    if($today>$end_date){
                                                        $data['payment_clear'] = "No";
                                                        $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                    }
                                                }
                                            }
                                        }

                                    }
                                    //attendance insert
                                    $today = date("Y-m-d",strtotime('today'));
                                    $check_and_return_ref = getRefAttendance($today,$user_information->id);
                                    if($check_and_return_ref){
                                        $attendance= array();
                                        $attendance['reference_no'] = $check_and_return_ref;
                                        $attendance['date'] = $today;
                                        $attendance['employee_id'] = $user_information->id;
                                        $attendance['in_time'] = date("H:i:s");
                                        $attendance['out_time'] = "00:00:00";
                                        $attendance['user_id'] = $user_information->id;
                                        $attendance['company_id'] = $company_info->id;
                                        $this->Common_model->insertInformation($attendance, "tbl_attendance");
                                    }

                                    $outlet_info = $this->db->query("SELECT * FROM tbl_outlets WHERE del_status='Live' AND active_status='active' AND id='$user_information->outlet_id'")->row();
                                    $outlet_session = array();
                                    if(isset($outlet_info) && $outlet_info):
                                        $outlet_session['outlet_id'] = $outlet_info->id;
                                        $outlet_session['outlet_name'] = $outlet_info->outlet_name;
                                        $outlet_session['address'] = $outlet_info->address;
                                        $outlet_session['phone'] = $outlet_info->phone;
                                        $outlet_session['email'] = $outlet_info->email;
                                        $outlet_session['outlet_code'] = $outlet_info->outlet_code;
                                        $outlet_session['has_kitchen'] = $outlet_info->has_kitchen;
                                        if(str_rot13($company_info->language_manifesto)=="eriutoeri"):
                                            $outlet_session['default_waiter'] =$outlet_info->default_waiter;
                                        endif;
                                        $this->session->set_userdata($outlet_session);
                                        if ($user_information->designation == 'Waiter') {
                                            redirect("Sale/POS");
                                        }
                                    endif;

                                    
                                    if(isFoodCourt() && $user_information->id==1){
                                        redirect("Authentication/userProfile");
                                    }
                                    if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){
                                        redirect("Authentication/userProfile");
                                    }
                                    if ($user_information->role == 'Admin') {
                                        redirect("Outlet/outlets");
                                    } else {
                                        redirect("Authentication/userProfile");
                                    }

                                }else{
                                    $this->session->set_userdata($login_session);
                                    $this->session->set_userdata($company_info_session);

                                    //for saas module
                                    if(isServiceAccess('','','')){
                                        $all_companies = $this->Common_model->getServiceCompaniesYes();

                                        if($all_companies){
                                            foreach ($all_companies as $value){
                                                $due_payment = $this->Common_model->getPaymentInfo($value->id);
                                                if($due_payment){
                                                    if($due_payment->payment_date){
                                                        $access_day = $value->access_day;
                                                        if(!$access_day){
                                                            $access_day = 0;
                                                        }
                                                        $today = date("Y-m-d",strtotime('today'));
                                                        $end_date = date("Y-m-d",strtotime($due_payment->payment_date." +".$access_day."day"));
                                                        if($today>$end_date){
                                                            $data['payment_clear'] = "No";
                                                            $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                        }
                                                    }
                                                }else{
                                                    $access_day = $value->access_day;
                                                    if(!$access_day){
                                                        $access_day = 0;
                                                    }
                                                    $today = date("Y-m-d",strtotime('today'));
                                                    $end_date = date("Y-m-d",strtotime($value->created_date." +".$access_day."day"));
                                                    if($today>$end_date){
                                                        $data['payment_clear'] = "No";
                                                        $this->Common_model->updateInformation($data, $value->id, "tbl_companies");
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //attendance insert
                                    $today = date("Y-m-d",strtotime('today'));
                                    $check_and_return_ref = getRefAttendance($today,$user_information->id);
                                    if($check_and_return_ref){
                                        $attendance= array();
                                        $attendance['reference_no'] = $check_and_return_ref;
                                        $attendance['date'] = $today;
                                        $attendance['employee_id'] = $user_information->id;
                                        $attendance['in_time'] = date("H:i:s");
                                        $attendance['out_time'] = "00:00:00";
                                        $attendance['user_id'] = $user_information->id;
                                        $attendance['company_id'] = $company_info->id;
                                        $this->Common_model->insertInformation($attendance, "tbl_attendance");
                                    }
                                    if(str_rot13($company_info->language_manifesto)=="fgjgldkfg"){
                                        redirect("Authentication/userProfile");
                                    }
                                    if ($user_information->role == 'Admin') {
                                        redirect("Outlet/outlets");
                                    } else {
                                        redirect("Authentication/userProfile");
                                    }
                                }
                            }else{
                                if($is_block=="Yes"){
                                    $this->session->set_flashdata('exception_1', lang('block_tmp_err'));
                                    redirect('Authentication/index');
                                }else if($is_payment_clear=="No"){
                                    $this->session->set_flashdata('exception_1', lang('payment_not_clear_err'));
                                    redirect('Authentication/index');
                                }
                            }
                        }else{
                            $this->session->set_flashdata('exception_1', lang('company_not_set_err1'));
                            redirect('Authentication/index');
                        }

                    }else{
                        $this->session->set_flashdata('exception_1', lang('company_not_set_err'));
                        redirect('Authentication/index');
                    }
                } else {
                    $this->session->set_flashdata('exception_1', lang('user_not_active'));
                    redirect('Authentication/index');
                }
            }
        } else {
            $this->session->set_flashdata('exception_1', 'You are not eligible to access this');
            redirect('Authentication/index');
        }
    }
    public function currentPlanDetails() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication');
        }
        $data = array();
        $company_info = getCompanyInfo();
        $data['plan_details'] = $this->Common_model->getDataById($company_info->plan_id, 'tbl_pricing_plans');
        $data['last_payment'] = $this->Common_model->getLastPayment($company_info->id);
        $data['count_invoice'] = $this->Common_model->getCountSaleNo($company_info->id);
        $data['company_id'] = $company_info->id;
        $data['main_content'] = $this->load->view('saas/current_plan_details', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function payment($company_id='') 
    {
        $company_dec_id = encryptDecrypt($company_id, 'decrypt');
        $company_info = getCompanyInfoById($company_dec_id);
        $data['company_info'] = $company_info;
        $data['plan_details'] = $this->Common_model->getDataById($company_info->plan_id, 'tbl_pricing_plans');
        $this->load->view('saas/onetime_payment', $data);
    }
    public function getFoodDetails() 
    {
        $id = escape_output($_POST['food_menu_id']);
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['encrypted_id'] = $id;
        $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_food_menus");
        $data['food_menu_ingredients'] = $this->Master_model->getFoodMenuIngredients($data['food_menu_details']->id);
        $data['deliveryPartners'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_delivery_partners");
        $data['variation_food_menus'] = $this->Common_model->getAllByCustomId($id,"parent_id","tbl_food_menus",$order='');
        $data['main_content'] = $this->load->view('master/foodMenu/foodMenuDetails', $data);
        echo json_encode($data['main_content']);
    }
    public function updateOnlineFoodInfo($image='',$food_menu_id='',$hidden_outlet_id='',$type,$another_image='',$checked_value)
    {
        $outlet_information = $this->Common_model->getDataById($hidden_outlet_id, "tbl_outlets");
        if($outlet_information){

            $available_online_foods = $outlet_information->available_online_foods;
            if($available_online_foods){
                $thumb_imgs = (Array)json_decode($outlet_information->thumb_imgs);
                $large_imgs = (Array)json_decode($outlet_information->large_imgs);

                $available_online_foods_json = explode(",",$available_online_foods);
                $is_exist = 1;
                foreach($available_online_foods_json as $vl=>$value){
                    $tmp = explode("_",$value);
                    if($value && $tmp[1]==$food_menu_id){
                        $is_exist++;
                        if($type==1){
                            $thumb_imgs['thumb_'.$food_menu_id] = $image;
                            $large_imgs['large_'.$food_menu_id] = $another_image;
                        }else{
                            $large_imgs['large_'.$food_menu_id] = $image;
                            $thumb_imgs['thumb_'.$food_menu_id] = $another_image;
                        }
                    }
                }
                if($is_exist==1){
                    $available_online_foods_json[]= $checked_value."_".$food_menu_id;
                    if($type==1){
                        $thumb_imgs['thumb_'.$food_menu_id] = $image;
                        $large_imgs['large_'.$food_menu_id] = $another_image;
                    }else{
                        $large_imgs['large_'.$food_menu_id] = $image;
                        $thumb_imgs['thumb_'.$food_menu_id] = $another_image;
                    }
                }


                $main_arr = $clean_string = preg_replace('/,+/', ',', implode(",", $available_online_foods_json)); ; 
           
                //set food menu for this outlet
                $data_food_menus['available_online_foods'] = $main_arr;
                $data_food_menus['thumb_imgs'] = json_encode($thumb_imgs);
                $data_food_menus['large_imgs'] = json_encode($large_imgs);
 
                $this->Common_model->updateInformation($data_food_menus, $hidden_outlet_id, "tbl_outlets");

            }else{
                $array_thumb_img_arr = array();
                $array_large_img_arr = array();

                $main_arr = $checked_value."_".$food_menu_id;; 
                if($type==1){
                    $array_thumb_img_arr['thumb_'.$food_menu_id] = $image;
                    $array_large_img_arr['large_'.$food_menu_id] = $another_image;
                }else{
                    $array_large_img_arr['large_'.$food_menu_id] = $image;
                    $array_thumb_img_arr['thumb_'.$food_menu_id] = $another_image;
                }
               
                //set food menu for this outlet
                $data_food_menus['available_online_foods'] = $main_arr;
                $data_food_menus['thumb_imgs'] = json_encode($array_thumb_img_arr);
                $data_food_menus['large_imgs'] = json_encode($array_large_img_arr);
                $this->Common_model->updateInformation($data_food_menus, $hidden_outlet_id, "tbl_outlets");
            }
        }
    }
    public function updateOnlineFoodInfoOthers($thumb_image,$large_image,$food_menu_id,$hidden_outlet_id,$checked_value)
    {
        $outlet_information = $this->Common_model->getDataById($hidden_outlet_id, "tbl_outlets");
         
        if($outlet_information){

            $available_online_foods = $outlet_information->available_online_foods;
          
            if($available_online_foods){
                $thumb_imgs = (Array)json_decode($outlet_information->thumb_imgs);
                $large_imgs = (Array)json_decode($outlet_information->large_imgs);

                $available_online_foods_json = explode(",",$available_online_foods);
                $is_exist = 1;
              
                foreach($available_online_foods_json as $vl=>$value){
                    $tmp = explode("_",$value);
                    if($value && $tmp[1]==$food_menu_id){
                        $is_exist++;
                        $id_values = $checked_value."_".$tmp[1];
                        $available_online_foods_json[$vl] = $id_values;
                        $thumb_imgs['thumb_'.$food_menu_id] = $thumb_image;
                        $large_imgs['large_'.$food_menu_id] = $large_image;
                    }
                }
                if($is_exist==1){
                    $available_online_foods_json[]= $checked_value."_".$food_menu_id;
                    $thumb_imgs['thumb_'.$food_menu_id] = $thumb_image;
                    $large_imgs['large_'.$food_menu_id] = $large_image;
                }
               

                $main_arr = $clean_string = preg_replace('/,+/', ',', implode(",", $available_online_foods_json)); ; 
           
                //set food menu for this outlet
                $data_food_menus['available_online_foods'] = $main_arr;
                $data_food_menus['thumb_imgs'] = json_encode($thumb_imgs);
                $data_food_menus['large_imgs'] = json_encode($large_imgs);
              
 
                $this->Common_model->updateInformation($data_food_menus, $hidden_outlet_id, "tbl_outlets");

            }else{
                $array_thumb_img_arr = array();
                $array_large_img_arr = array();

                $main_arr = $checked_value."_".$food_menu_id;; 
                $array_thumb_img_arr['thumb_'.$food_menu_id] = $thumb_image;
                $array_large_img_arr['large_'.$food_menu_id] = $large_image;

                //set food menu for this outlet
                $data_food_menus['available_online_foods'] = $main_arr;
                $data_food_menus['thumb_imgs'] = json_encode($array_thumb_img_arr);
                $data_food_menus['large_imgs'] = json_encode($array_large_img_arr);
                $this->Common_model->updateInformation($data_food_menus, $hidden_outlet_id, "tbl_outlets");
            }
        }
    }

    public function saveItemImage()
    {
        $data = escape_output($_POST['image']);
        $food_menu_id = escape_output($_POST['food_menu_id']);
        $hidden_outlet_id = escape_output($_POST['hidden_outlet_id']);
        $type = escape_output($_POST['type']);
        $another_image = escape_output($_POST['another_image']);
        $checked_value = escape_output($_POST['checked_value']);

        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = time().'.png';
        file_put_contents('uploads/website/'.$imageName, $data);
        $data_return['image_name'] = $imageName;
        $this->updateOnlineFoodInfo($imageName,$food_menu_id,$hidden_outlet_id,$type,$another_image,$checked_value);

        echo json_encode($data_return);
    }

    public function callUpdateInfo()
    {
        $thumb_image = escape_output($_POST['thumb_image']);
        $large_image = escape_output($_POST['large_image']);
        $food_menu_id = escape_output($_POST['food_menu_id']);
        $hidden_outlet_id = escape_output($_POST['hidden_outlet_id']);
        $checked_value = escape_output($_POST['checked_value']);
        $this->updateOnlineFoodInfoOthers($thumb_image,$large_image,$food_menu_id,$hidden_outlet_id,$checked_value);
    }
    public function setOutletForOnline()
    {
        $outlet_company_id = escape_output($_POST['outlet_company_id']);
        $split_id = explode("||",$outlet_company_id);
        $outlet_id = $split_id[0];
        $company_id = $split_id[1];
        $this->session->set_userdata('go_online_status', "Yes");
        $this->session->set_userdata('online_selected_outlet', $outlet_id);
        $this->session->set_userdata('online_selected_company', $company_id);
        echo "Success";
    }

    /**
     * Batch update online food information for better performance
     * @access public
     * @return json
     */
    public function callBatchUpdateInfo()
    {
        $updates = $this->input->post('updates');
        $hidden_outlet_id = escape_output($_POST['hidden_outlet_id']);
        
        $response = array('success' => false, 'message' => '');
        
        try {
            if (!is_array($updates) || empty($updates)) {
                $response['message'] = 'No updates provided';
                echo json_encode($response);
                return;
            }
            
            // Get outlet information once
            $outlet_information = $this->Common_model->getDataById($hidden_outlet_id, "tbl_outlets");
            
            if (!$outlet_information) {
                $response['message'] = 'Outlet not found';
                echo json_encode($response);
                return;
            }
            
            $available_online_foods = $outlet_information->available_online_foods;
            $thumb_imgs = $available_online_foods ? (Array)json_decode($outlet_information->thumb_imgs) : array();
            $large_imgs = $available_online_foods ? (Array)json_decode($outlet_information->large_imgs) : array();
            
            $available_online_foods_array = $available_online_foods ? explode(",", $available_online_foods) : array();
            $existing_food_ids = array();
            
            // Create lookup for existing food IDs
            foreach ($available_online_foods_array as $value) {
                if ($value) {
                    $tmp = explode("_", $value);
                    if (isset($tmp[1])) {
                        $existing_food_ids[$tmp[1]] = $value;
                    }
                }
            }
            
            // Process all updates
            foreach ($updates as $update) {
                $food_menu_id = escape_output($update['food_menu_id']);
                $checked_value = escape_output($update['checked_value']);
                $thumb_image = escape_output($update['thumb_image']);
                $large_image = escape_output($update['large_image']);
                
                // Update or add the food menu
                $new_value = $checked_value . "_" . $food_menu_id;
                $existing_food_ids[$food_menu_id] = $new_value;
                
                // Update images
                $thumb_imgs['thumb_' . $food_menu_id] = $thumb_image;
                $large_imgs['large_' . $food_menu_id] = $large_image;
            }
            
            // Prepare final data
            $main_arr = implode(",", $existing_food_ids);
            $main_arr = preg_replace('/,+/', ',', $main_arr); // Clean up multiple commas
            
            $data_food_menus = array(
                'available_online_foods' => $main_arr,
                'thumb_imgs' => json_encode($thumb_imgs),
                'large_imgs' => json_encode($large_imgs)
            );
            
            // Single database update for all changes
            $this->Common_model->updateInformation($data_food_menus, $hidden_outlet_id, "tbl_outlets");
            
            $response['success'] = true;
            $response['message'] = 'Batch update completed successfully';
            
        } catch (Exception $e) {
            $response['message'] = 'Error processing batch update: ' . $e->getMessage();
        }
        
        echo json_encode($response);
    }

 
  
}



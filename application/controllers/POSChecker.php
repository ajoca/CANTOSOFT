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
  # This is POSChecker Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class POSChecker extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Attendance_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
    }
    public function posAndWaiterMiddleman($user_id='', $outlet_id='', $company_id='',$is_waiter=''){
        if ($outlet_id!='') {

        }else{
            $outlet_id = $this->session->userdata('outlet_id');
            if($outlet_id==''){
                $this->session->set_flashdata('exception_2', 'Please click on green Enter button of an outlet');
                redirect('Outlet/outlets');
            }
        }

        if ($company_id!='') {

        }else{
            $company_id = $this->session->userdata('company_id');
        }
        if ($user_id!='') {

        }else{
            $user_id = $this->session->userdata('user_id');
        }
        if ($is_waiter=='') {
            $is_waiter = 'No';
        }else{
            $is_waiter = 'Yes';
        }

        if ($is_waiter == 'Yes') {
            $this->session->set_userdata('is_waiter', 'Yes');
        }else{
            $this->session->set_userdata('is_waiter', 'No');
        }
        
        if($is_waiter=="Yes"){
            //get company information
            $getCompanyInfo = getCompanyInfoById($company_id);
            $outlet_info = $this->Common_model->getDataById($outlet_id, "tbl_outlets");
            $user = $this->Common_model->getDataById($user_id, "tbl_users");
            $this->session->set_userdata('user_id', $user_id);
            $this->session->set_userdata('outlet_id', $outlet_id);
            $this->session->set_userdata('company_id', $company_id);
            $this->session->set_userdata('date_format', $getCompanyInfo->date_format);
            $this->session->set_userdata('service_amount', $getCompanyInfo->service_amount);
            $this->session->set_userdata('invoice_logo', $getCompanyInfo->invoice_logo);
            $this->session->set_userdata('precision', $getCompanyInfo->precision);
            $this->session->set_userdata('outlet_name', $outlet_info->outlet_name);
            $this->session->set_userdata('address', $outlet_info->address);
            $this->session->set_userdata('phone', $outlet_info->phone);
            $this->session->set_userdata('email', $outlet_info->email);
            $this->session->set_userdata('role', $user->role);
            $this->session->set_userdata('is_online_order', "No");
            $this->session->set_userdata('full_name', $user->full_name);
            $this->session->set_userdata('designation', $user->designation);
            $this->session->set_userdata('mobile_responsive_checker_self_order', "");
        }
        redirect('Sale/POS/'.$user_id.'/'.$outlet_id);
    }
    public function posAndSelfOrderMiddleman($table_id='',$outlet_id='', $company_id='',$is_waiter=''){
        if($table_id && $outlet_id && $company_id && $is_waiter){
            if ($outlet_id!='') {

            }else{
                $outlet_id = $this->session->userdata('outlet_id');
            }

            if ($company_id!='') {

            }else{
                $company_id = $this->session->userdata('company_id');
            }
            if ($is_waiter=='') {
                $is_waiter = 'No';
            }else{
                $is_waiter = 'Yes';
            }

            if ($is_waiter == 'Yes') {
                $this->session->set_userdata('is_waiter', 'Yes');
            }else{
                $this->session->set_userdata('is_waiter', 'No');
            }
            $self_order_ran_code = $this->session->userdata('self_order_ran_code');
            if(isset($self_order_ran_code) && $self_order_ran_code){
                $ran_code = $self_order_ran_code;
            }else{
                $ran_code = generateRandomCode();
            }
            //get company information
            $getCompanyInfo = getCompanyInfoById($company_id);
            $outlet_info = $this->Common_model->getDataById($outlet_id, "tbl_outlets");

            $this->session->set_userdata('user_id', 2);
            $this->session->set_userdata('outlet_id', $outlet_id);
            $this->session->set_userdata('company_id', $company_id);
            $this->session->set_userdata('date_format', $getCompanyInfo->date_format);
            $this->session->set_userdata('service_amount', $getCompanyInfo->service_amount);
            $this->session->set_userdata('invoice_logo', $getCompanyInfo->invoice_logo);
            $this->session->set_userdata('precision', $getCompanyInfo->precision);
            $this->session->set_userdata('outlet_name', $outlet_info->outlet_name);
            $this->session->set_userdata('has_kitchen', $outlet_info->has_kitchen);
            $this->session->set_userdata('address', $outlet_info->address);
            $this->session->set_userdata('phone', $outlet_info->phone);
            $this->session->set_userdata('email', $outlet_info->email);
            $this->session->set_userdata('self_order_ran_code', $ran_code);
            $this->session->set_userdata('is_self_order', "Yes");
            $this->session->set_userdata('designation', "Waiter");
            $this->session->set_userdata('is_online_order', "No");
            $this->session->set_userdata('mobile_responsive_checker_self_order', "Yes");

            $this->session->set_userdata('self_order_table_name', getTableName($table_id));
            $this->session->set_userdata('self_order_table_id', $table_id);
            redirect('Sale/POS/2/'.$outlet_id.'/'.$table_id);
        }else{
            echo "Unable to scanned or you scanned wrong QR-code!";exit;
        }
    }
    public function posAndOnlineOrderMiddleman($outlet_id='', $company_id=''){
        if($outlet_id && $company_id){
            if ($outlet_id!='') {

            }else{
                $outlet_id = $this->session->userdata('outlet_id');
            }

            if ($company_id!='') {

            }else{
                $company_id = $this->session->userdata('company_id');
            }
            //get company information
            $getCompanyInfo = getCompanyInfoById($company_id);
            $outlet_info = $this->Common_model->getDataById($outlet_id, "tbl_outlets");

            $this->session->set_userdata('outlet_id', $outlet_id);
            $this->session->set_userdata('company_id', $company_id);
            $this->session->set_userdata('date_format', $getCompanyInfo->date_format);
            $this->session->set_userdata('service_amount', $getCompanyInfo->service_amount);
            $this->session->set_userdata('invoice_logo', $getCompanyInfo->invoice_logo);
            $this->session->set_userdata('precision', $getCompanyInfo->precision);
            $this->session->set_userdata('outlet_name', $outlet_info->outlet_name);
            $this->session->set_userdata('has_kitchen', $outlet_info->has_kitchen);
            $this->session->set_userdata('address', $outlet_info->address);
            $this->session->set_userdata('phone', $outlet_info->phone);
            $this->session->set_userdata('email', $outlet_info->email);
            $this->session->set_userdata('is_online_order', "Yes");
            $this->session->set_userdata('is_self_order', "Yes");
            $this->session->set_userdata('designation', "Waiter");
            $this->session->set_userdata('mobile_responsive_checker_self_order', "");
            $this->session->set_userdata('mobile_responsive_checker_online_order', "Yes");
            redirect('Sale/POS/2/'.$outlet_id);
        }else{
            echo "Unable to open or your entered URL wrong!";exit;
        }
    }

}

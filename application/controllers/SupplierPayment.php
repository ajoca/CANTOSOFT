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
  # This is SupplierPayment Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierPayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Supplier_payment_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "147";
        $function = "";

        if($segment_2=="supplierPayments"){
            $function = "view";
        }elseif($segment_2=="addSupplierPayment" ||  $segment_2=="getSupplierDue"){
            $function = "add";
        }elseif($segment_2=="deleteSupplierPayment"){
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

        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
    }


     /**
     * supplier Payments
     * @access public
     * @return void
     * @param no
     */
    public function supplierPayments() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['supplierPayments'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_supplier_payments");
        $data['main_content'] = $this->load->view('supplierPayment/supplierPayments', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Supplier Payment
     * @access public
     * @return void
     * @param int
     */
    public function deleteSupplierPayment($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_supplier_payments");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('SupplierPayment/supplierPayments');
    }
     /**
     * add Supplier Payment
     * @access public
     * @return void
     * @param no
     */
    public function addSupplierPayment() {
         //check register is open or not
         $is_waiter = $this->session->userdata('is_waiter');
         $designation = $this->session->userdata('designation');
         if($designation!="Waiter" && $this->session->has_userdata('is_online_order')!="Yes" && !isFoodCourt()){
             $user_id = $this->session->userdata('user_id');
             $outlet_id = $this->session->userdata('outlet_id');
             if($this->Common_model->isOpenRegister($user_id,$outlet_id)==0){
                 $this->session->set_flashdata('exception_3', lang('register_open_msg'));
                 if($this->uri->segment(2)=='registerDetailCalculationToShowAjax' || $this->uri->segment(2)=='closeRegister'){
                     redirect('Register/openRegister');
                 }else{
                     $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
                     $this->session->set_userdata("clicked_method", $this->uri->segment(2));
                     redirect('Register/openRegister');
                 }
 
             }
         }
         
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount', lang('amount'), 'required|max_length[50]');
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_id', lang('payment_method'), 'required|max_length[10]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
            if ($this->form_validation->run() == TRUE) {
                $splr_payment_info = array();
                $splr_payment_info['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $splr_payment_info['amount'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $splr_payment_info['supplier_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
                $splr_payment_info['payment_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_id')));
                $splr_payment_info['note'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $splr_payment_info['counter_id'] = $this->session->userdata('counter_id');
                $splr_payment_info['user_id'] = $this->session->userdata('user_id');
                $splr_payment_info['outlet_id'] = $this->session->userdata('outlet_id');
                $splr_payment_info['added_date_time'] = date('Y-m-d H:i:s');

                $this->Common_model->insertInformation($splr_payment_info, "tbl_supplier_payments");
                $this->session->set_flashdata('exception', lang('insertion_success'));

                redirect('SupplierPayment/supplierPayments');
            } else {
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
                $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
            $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_suppliers");
            $data['main_content'] = $this->load->view('supplierPayment/addSupplierPayment', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
     /**
     * get Supplier Due
     * @access public
     * @return float
     * @param no
     */
    public function getSupplierDue() {
        $supplier_id = $_GET['supplier_id'];
        $remaining_due = $this->Supplier_payment_model->getSupplierDue($supplier_id);
        echo escape_output(getAmtP($remaining_due));
    }

}

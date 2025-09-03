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
  # This is PaymentMethod Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentMethod extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "260";
        $function = "";
        if($segment_2=="paymentMethods"){
            $function = "view";
        }elseif($segment_2=="addEditPaymentMethod" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditPaymentMethod"){
            $function = "add";
        }elseif($segment_2=="deletePaymentMethod"){
            $function = "delete";
        }elseif($segment_2=="sorting"){
            $function = "sorting";
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
     * payment Methods
     * @access public
     * @return void
     * @param no
     */
    public function paymentMethods() {
        $data = array();
        $data['paymentMethods'] = $this->Sale_model->getAllPaymentMethodsFinalize();
        $data['main_content'] = $this->load->view('master/paymentMethod/paymentMethods', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * payment Methods
     * @access public
     * @return void
     * @param no
     */
    public function sorting() {
        $data = array();
        $data['paymentMethods'] = $this->Sale_model->getAllPaymentMethodsFinalize();
        $data['main_content'] = $this->load->view('master/paymentMethod/sorting', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Payment Method
     * @access public
     * @return void
     * @param int
     */
    public function deletePaymentMethod($id) {
        if($id!=1 && $id!=5):
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_payment_methods");
        $this->session->set_flashdata('exception', lang('delete_success'));
        endif;
        redirect('paymentMethod/paymentMethods');
    }
     /**
     * add Edit Payment Method
     * @access public
     * @return void
     * @param int
     */
    public function addEditPaymentMethod($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if($this->input->post('submit')) {
            $this->form_validation->set_rules('name', lang('payment_method_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                if($name=="Cash" || $name=="cash"){
                    $this->session->set_flashdata('exception_r',lang('exist_message'));
                    redirect('paymentMethod/paymentMethods');
                }
                
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] =escape_output($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_payment_methods");
                    $this->session->set_flashdata('exception',lang('delete_success'));
                }
                redirect('paymentMethod/paymentMethods');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                    $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/paymentMethod/addPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['payment_method_information'] = $this->Common_model->getDataById($id, "tbl_payment_methods");
                $data['main_content'] = $this->load->view('master/paymentMethod/editPaymentMethod', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

}

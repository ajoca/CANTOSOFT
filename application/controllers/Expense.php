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
  # This is Expense Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2',lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "142";
        $function = "";

        if($segment_2=="expenses"){
            $function = "view";
        }elseif($segment_2=="addEditExpense" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditExpense"){
            $function = "add";
        }elseif($segment_2=="deleteExpense"){
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
     * expense info
     * @access public
     * @return void
     * @param no
     */
    public function expenses() {
        $outlet_id = $this->session->userdata('outlet_id');

        $data = array();
        $data['expenses'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_expenses");
        $data['main_content'] = $this->load->view('expense/expenses', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * delete expense
     * @access public
     * @return void
     * @param int
     */
    public function deleteExpense($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_expenses");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('Expense/expenses');
    }
      /**
     * add/edit expense
     * @access public
     * @return void
     * @param int
     */
    public function addEditExpense($encrypted_id = "") {
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

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('date',lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('amount',lang('amount'), 'required|max_length[50]');
            $this->form_validation->set_rules('category_id',lang('category'), 'required|max_length[10]');
            $this->form_validation->set_rules('employee_id',lang('responsible_person'), 'required|max_length[10]');
            $this->form_validation->set_rules('payment_id', lang('payment_method'), 'required|numeric|max_length[50]');
            $this->form_validation->set_rules('note',lang('note'), 'max_length[200]');
            if ($this->form_validation->run() == TRUE) {
                $expnse_info = array(); 
                $expnse_info['date'] = date("Y-m-d", strtotime($this->input->post($this->security->xss_clean('date'))));
                $expnse_info['amount'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('amount')));
                $expnse_info['category_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $expnse_info['employee_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $expnse_info['note'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $expnse_info['counter_id'] = $this->session->userdata('counter_id');
                $expnse_info['user_id'] = $this->session->userdata('user_id');
                $expnse_info['outlet_id'] = $this->session->userdata('outlet_id');
                $expnse_info['payment_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_id')));
                if ($id == "") {
                    $expnse_info['added_date_time'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($expnse_info, "tbl_expenses");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($expnse_info, $id, "tbl_expenses");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Expense/expenses');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
                    $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                    $data['main_content'] = $this->load->view('expense/addExpense', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['encrypted_id'] = $encrypted_id;
                    $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
                    $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                    $data['expense_information'] = $this->Common_model->getDataById($id, "tbl_expenses");
                    $data['main_content'] = $this->load->view('expense/editExpense', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
                $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                $data['main_content'] = $this->load->view('expense/addExpense', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['encrypted_id'] = $encrypted_id;
                $data['expense_categories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
                $data['employees'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                $data['expense_information'] = $this->Common_model->getDataById($id, "tbl_expenses");
                $data['main_content'] = $this->load->view('expense/editExpense', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

}

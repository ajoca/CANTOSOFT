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
  # This is ExpenseItems Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class ExpenseItems extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "255";
        $function = "";
        if($segment_2=="expenseItems"){
            $function = "view";
        }elseif($segment_2=="addEditExpenseItem" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditExpenseItem"){
            $function = "add";
        }elseif($segment_2=="deleteExpenseItem"){
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
     * expense item info
     * @access public
     * @return void
     * @param no
     */
    public function expenseItems() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['expenseItems'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_expense_items");
        $data['main_content'] = $this->load->view('master/expenseItem/expenseItems', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * delete expense item
     * @access public
     * @return void
     * @param int
     */
    public function deleteExpenseItem($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_expense_items");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('expenseItems/expenseItems');
    }
      /**
     * add/edit expense info
     * @access public
     * @return void
     * @param int
     */
    public function addEditExpenseItem($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_expense_items");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('expenseItems/expenseItems');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                    $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/expenseItem/addExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['expense_item_information'] = $this->Common_model->getDataById($id, "tbl_expense_items");
                $data['main_content'] = $this->load->view('master/expenseItem/editExpenseItem', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
}

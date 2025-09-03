<?php
/*
  ###########################################################
  # PRODUCT NAME: 	One Stop
  ###########################################################
  # AUTHER:		Door Soft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is MultipleCurrency Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MultipleCurrency extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "55";
        $function = "";

        if($segment_2=="MultipleCurrencies" || $segment_2=="multipleCurrencies"){
            $function = "view";
        }elseif($segment_2=="addEditMultipleCurrency" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditMultipleCurrency"){
            $function = "add";
        }elseif($segment_2=="deleteMultipleCurrency"){
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
    }


    /**
     * MultipleCurrencies view page
     * @access public
     * @return void
     */
    public function MultipleCurrencies() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['MultipleCurrencies'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_multiple_currencies");
        $data['main_content'] = $this->load->view('master/multiple_currency/multiplecurrencies', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete MultipleCurrency
     * @access public
     * @return void
     * @param int
     */
    public function deleteMultipleCurrency($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_multiple_currencies");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('MultipleCurrency/MultipleCurrencies');
    }
    /**
     * add/edit MultipleCurrency
     * @access public
     * @return void
     * @param int
     */
    public function addEditMultipleCurrency($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('currency', lang('currency'), 'required|max_length[10]');
            $this->form_validation->set_rules('conversion_rate', lang('conversion_rate'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $vat = array();
                $vat['currency'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('currency')));
                $vat['conversion_rate'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('conversion_rate')));
                $vat['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($vat, "tbl_multiple_currencies");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($vat, $id, "tbl_multiple_currencies");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('MultipleCurrency/MultipleCurrencies');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['MultipleCurrencies'] = $this->Common_model->getDataById($id, "tbl_multiple_currencies");
                    $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['MultipleCurrencies'] = $this->Common_model->getDataById($id, "tbl_multiple_currencies");
                $data['main_content'] = $this->load->view('master/multiple_currency/addEditMultipleCurrency', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

}

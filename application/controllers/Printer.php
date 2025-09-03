<?php
/*
  ###########################################################
  # PRODUCT NAME: 	One Stop
  ###########################################################
  # AUTHER:		Doorsoft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Doorsoft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Printer Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Printer extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Authentication_model');
        $this->load->model('Printer_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "35";
        $function = "";

        if($segment_2=="printers"){
            $function = "view";
        }elseif($segment_2=="addEditPrinter" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditPrinter"){
            $function = "add";
        }elseif($segment_2=="deletePrinter"){
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
     * printer list
     * @access public
     * @return void
     */
    public function printers() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['printer_'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_printers");
        $data['main_content'] = $this->load->view('printer/printers', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete printer
     * @access public
     * @return void
     * @param int
     */
    public function deletePrinter($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_printers");
        $this->session->set_flashdata('exception',  lang('delete_success'));
        redirect('printer/printers');
    }
    /**
     * add/edit printer
     * @access public
     * @return void
     * @param int
     */
    public function addEditPrinter($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('outlet_id',  lang('outlet'), 'required|max_length[300]');
            $this->form_validation->set_rules('title',  lang('title'), 'required|max_length[300]');
            
            $type = htmlspecialcharscustom($this->input->post('type'));
            $printing_choice = htmlspecialcharscustom($this->input->post('printing_choice'));
          
            if($printing_choice=="web_browser_popup"){
                $this->form_validation->set_rules('print_format', lang('print_format'), 'required|max_length[50]');
            }else{
                $this->form_validation->set_rules('type', lang('type'), 'required|max_length[20]');
                if($type=="linux" || $type=="windows"){
                    $this->form_validation->set_rules('path', lang('path'), 'required|max_length[100]');
                }else if($type=="network"){
                    $this->form_validation->set_rules('printer_ip_address', lang('printer_ip_address'), 'required|max_length[20]');
                    $this->form_validation->set_rules('printer_port', lang('printer_port'), 'required|max_length[20]');
                }
                $this->form_validation->set_rules('characters_per_line',  lang('characters_per_line'), 'required|max_length[300]');
                $this->form_validation->set_rules('ipvfour_address', lang('ipvfour_address'), 'required|max_length[100]');
            }
            $this->form_validation->set_rules('inv_qr_code_status', lang('inv_qr_code_status'), 'required|max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                $data= array();
                $data['outlet_id'] = htmlspecialcharscustom($this->input->post('outlet_id'));
                $data['path'] = htmlspecialcharscustom($this->input->post('path'));
                $data['title'] = htmlspecialcharscustom($this->input->post('title'));
                $data['type'] = htmlspecialcharscustom($this->input->post('type'));
                $data['profile_'] = "default";
                $data['printer_ip_address'] = htmlspecialcharscustom($this->input->post('printer_ip_address'));
                $data['printer_port'] = htmlspecialcharscustom($this->input->post('printer_port'));
                $data['characters_per_line'] = htmlspecialcharscustom($this->input->post('characters_per_line'));
                $data['printing_choice'] = htmlspecialcharscustom($this->input->post('printing_choice'));
                $data['ipvfour_address'] = htmlspecialcharscustom($this->input->post('ipvfour_address'));
                $data['print_format'] = htmlspecialcharscustom($this->input->post('print_format'));
                $data['inv_qr_code_enable_status'] = htmlspecialcharscustom($this->input->post('inv_qr_code_status'));
                $data['open_cash_drawer_when_printing_invoice'] = htmlspecialcharscustom($this->input->post('open_cash_drawer_when_printing_invoice'));
                if($printing_choice=="web_browser_popup"){
                    $data['path'] = '';
                    $data['profile_'] = '';
                    $data['printer_ip_address'] = '';
                    $data['printer_port'] = '';
                    $data['characters_per_line'] = '';
                    $data['ipvfour_address'] = '';
                    $data['type'] = '';
                }else{
                    $data['print_format'] = '';
                }
                
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($data, "tbl_printers");
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $counter_id =  $this->session->userdata('counter_id');
                        if($counter_id){
                            $counter = $this->Common_model->getDataById($counter_id, "tbl_counters");
                            $printer_info = $this->Common_model->getPrinterInfoById($counter->printer_id);
                            $print_arr = [];
                            $print_arr['counter_id'] = $counter_id;
                            $print_arr['printer_id'] = $counter->printer_id;
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
                            $this->session->set_userdata($print_arr);
                        }

                                    
                    $this->Common_model->updateInformation($data, $id, "tbl_printers");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('printer/printers');
            } else {

                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('printer/addPrinter', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['printer_'] = $this->Common_model->getDataById($id, "tbl_printers");
                    $data['main_content'] = $this->load->view('printer/editPrinter', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('printer/addPrinter', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['printer_'] = $this->Common_model->getDataById($id, "tbl_printers");
                $data['main_content'] = $this->load->view('printer/editPrinter', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
}

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
  # This is Table Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Table extends Cl_Controller {

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
        $controller = "280";
        $function = "";
        if($segment_2=="tables"){
            $function = "view";
        }elseif($segment_2=="addEditTable" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditTable" || $segment_2=="tableLayoutSetting" || $segment_2=="addElement"){
            $function = "add";
        }elseif($segment_2=="deleteTable"){
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
     * tables
     * @access public
     * @return void
     * @param no
     */
    public function tables() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['tables'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_tables");
        $data['main_content'] = $this->load->view('master/table/tables', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Table
     * @access public
     * @return void
     * @param int
     */
    public function deleteTable($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_tables");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('table/tables');
    }
     /**
     * add/Edit Table
     * @access public
     * @return void
     * @param int
     */
    public function addEditTable($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('area',lang('area'), 'required|max_length[50]');
            $this->form_validation->set_rules('name',lang('table_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('sit_capacity', lang('seat_capacity'), 'max_length[50]');
            $this->form_validation->set_rules('position', lang('position'), 'max_length[50]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $igc_info = array();
                $igc_info['area'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('area')));
                $igc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $igc_info['sit_capacity'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sit_capacity')));
                $igc_info['position'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('position')));
                $igc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $igc_info['outlet_id'] = getOutletIdByArea($igc_info['area']);
                $igc_info['user_id'] = $this->session->userdata('user_id');
                $igc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $igc_info['is_setting'] = 0;
                    $this->Common_model->insertInformation($igc_info, "tbl_tables");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_tables");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('table/tables');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['areas'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_areas');
                    $data['main_content'] = $this->load->view('master/table/addTable', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['areas'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_areas');
                    $data['encrypted_id'] = $encrypted_id;
                    $data['table_information'] = $this->Common_model->getDataById($id, "tbl_tables");
                    $data['main_content'] = $this->load->view('master/table/editTable', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['areas'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_areas');
                $data['main_content'] = $this->load->view('master/table/addTable', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['areas'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_areas');
                $data['encrypted_id'] = $encrypted_id;
                $data['table_information'] = $this->Common_model->getDataById($id, "tbl_tables");
                $data['main_content'] = $this->load->view('master/table/editTable', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    public function tableLayoutSetting(){
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['areas'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_areas');
        $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
        $data['tables'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_tables");
        $data['main_content'] = $this->load->view('master/table/table_layout_setting', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function addElement(){   
        //this is base64 object, that's why we skip escape
        $image = imagecreatefrompng($_POST['image']);
        $id = uniqid();
        imagealphablending($image, false);
        imagesavealpha($image, true);
            $file_name = 'images/table_draw_object/' .$id . '.png';
        imagepng($image, $file_name);
        echo $file_name;
    }
}

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
  # This is Area Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends Cl_Controller {

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
        $controller = "275";
        $function = "";
        if($segment_2=="areas"){
            $function = "view";
        }elseif($segment_2=="addEditArea" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditArea"){
            $function = "add";
        }elseif($segment_2=="deleteArea"){
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
     * areas
     * @access public
     * @return void
     * @param no
     */
    public function areas() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['areas'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_areas");
        $data['main_content'] = $this->load->view('master/area/areas', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Area
     * @access public
     * @return void
     * @param int
     */
    public function deleteArea($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_areas");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('area/areas');
    }
     /**
     * add/Edit Area
     * @access public
     * @return void
     * @param int
     */
    public function addEditArea($encrypted_id = "") {
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('area_name',lang('area_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description',lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $igc_info = array();
                $igc_info['area_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('area_name')));
                $igc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $igc_info['company_id'] = $this->session->userdata('company_id');
                if(isLMni()):
                    $igc_info['outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet')));
                else:
                    $igc_info['outlet_id'] = $this->session->userdata('outlet_id');;
                endif;
                if ($id == "") {
                    $this->Common_model->insertInformation($igc_info, "tbl_areas");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_areas");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('area/areas');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                    $data['main_content'] = $this->load->view('master/area/addArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                    $data['area'] = $this->Common_model->getDataById($id, "tbl_areas");
                    $data['main_content'] = $this->load->view('master/area/editArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                $data['main_content'] = $this->load->view('master/area/addArea', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_outlets');
                $data['area'] = $this->Common_model->getDataById($id, "tbl_areas");
                $data['main_content'] = $this->load->view('master/area/editArea', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
}

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
  # This is Sass Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class WhiteLabel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Pricing_plan_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "49";
        $function = "";

        if($segment_2=="index" || $segment_2==""){
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

    }
    public function index($id = '') {
        $company_id = $id = $outlet_id = $this->session->userdata('company_id');
        $id = $company_id;
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('site_name', lang('site_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('footer', lang('footer'), 'required|max_length[250]');
            $this->form_validation->set_rules('system_logo', lang('system_logo'), 'callback_validate_system_logo|max_length[500]');
            $this->form_validation->set_rules('favicon', lang('favicon'), 'callback_validate_favicon|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $outlet_info = array();
                $outlet_info['site_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_name')));
                if ($_FILES['system_logo']['name'] != "") {
                    $outlet_info['system_logo'] = $this->session->userdata('system_logo');
                    $this->session->unset_userdata('system_logo');
                }else{
                    $outlet_info['system_logo'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('system_logo_p')));
                }

                if ($_FILES['favicon']['name'] != "") {
                    $outlet_info['favicon'] = $this->session->userdata('favicon');
                    $this->session->unset_userdata('favicon');
                }else{
                    $outlet_info['favicon'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('favicon_p')));
                }
                $outlet_info['footer'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('footer')));
                $return['white_label']  = json_encode($outlet_info);

                $this->Common_model->updateInformation($return, $id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));

                $this->session->set_userdata($outlet_info);
                redirect('WhiteLabel');
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_companies");
                $data['main_content'] = $this->load->view('authentication/WhiteLabel', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['encrypted_id'] = $encrypted_id;
            $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_companies");
            $data['main_content'] = $this->load->view('authentication/WhiteLabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
    /**
     * validate invoice logo
     * @access public
     * @return string
     * @param boolean
     */
    public function validate_system_logo() {

        if ($_FILES['system_logo']['name'] != "") {
            $config['upload_path'] = './images';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("system_logo")) {
                $upload_info = $this->upload->data();
                $file_name = $upload_info['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/' . $file_name;
                $config['width'] = 240;
                $config['height'] = 50;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->session->set_userdata('system_logo', $file_name);
            } else {
                $this->form_validation->set_message('validate_system_logo', $this->upload->display_errors());
                return FALSE;
            }
        }
    }
    public function validate_favicon() {

        if ($_FILES['favicon']['name'] != "") {
            $config['upload_path'] = './images';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("favicon")) {
                $upload_info = $this->upload->data();
                $file_name = $upload_info['file_name'];
                $this->session->set_userdata('favicon', $file_name);
            } else {
                $this->form_validation->set_message('validate_favicon', $this->upload->display_errors());
                return FALSE;
            }
        }
    }

}

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
  # This is DeliveryPartner Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryPartner extends Cl_Controller {

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
        $controller = "270";
        $function = "";
        if($segment_2=="deliveryPartners"){
            $function = "view";
        }elseif($segment_2=="addEditDeliveryPartner" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditDeliveryPartner"){
            $function = "add";
        }elseif($segment_2=="deleteDeliveryPartner"){
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
     * food Menu Categories
     * @access public
     * @return void
     * @param no
     */
    public function deliveryPartners() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['deliveryPartners'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_delivery_partners");
        $data['main_content'] = $this->load->view('master/deliveryPartner/deliveryPartners', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Food Menu Category
     * @access public
     * @return void
     * @param int
     */
    public function deleteDeliveryPartner($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_delivery_partners");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('deliveryPartner/deliveryPartners');
    }
     /**
     * add/Edit Food Menu Category
     * @access public
     * @return void
     * @param int
     */
    public function addEditDeliveryPartner($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');

            if ($_FILES['logo']['name'] != "") {
                $this->form_validation->set_rules('logo', lang('logo'), 'callback_validate_logo');
            }


            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');

                if ($_FILES['logo']['name'] != "") {
                    $fmc_info['logo'] = $this->session->userdata('logo');;
                    $this->session->unset_userdata('logo');
                    @unlink("./images/".htmlspecialcharscustom($this->input->post('old_logo')));
                }else{
                    $fmc_info['logo'] = htmlspecialcharscustom($this->input->post('old_logo'));
                }
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_delivery_partners");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('deliveryPartner/deliveryPartners');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/deliveryPartner/addDeliveryPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                    $data['main_content'] = $this->load->view('master/deliveryPartner/editDeliveryPartner', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/deliveryPartner/addDeliveryPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_delivery_partners");
                $data['main_content'] = $this->load->view('master/deliveryPartner/editDeliveryPartner', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * validate check and upload image
     * @access public
     * @return boolean
     */
    public function validate_logo() {
        if ($_FILES['logo']['name'] != "") {
            $config['upload_path'] = './images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '6048';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload("logo")) {
                $upload_info = $this->upload->data();
                $logo = $upload_info['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/' . $logo;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->session->set_userdata('logo', $logo);
            } else {
                $this->form_validation->set_message('validate_logo', $this->upload->display_errors());
                return FALSE;
            }
        }
    }
}

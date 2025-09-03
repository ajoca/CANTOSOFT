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
  # This is Authentication Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Frontend_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
    }
    public function index() {
        $data = array();
        $data['header_content'] = $this->load->view('frontend/header_section_index', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/index', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }


    public function APISetting(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $api_status = $this->input->post($this->security->xss_clean('api_status'));
            if($api_status == 'live'){
                $this->form_validation->set_rules('api_key', lang('api_key'), 'required|max_length[255]');
            }else{
                $this->form_validation->set_rules('api_key', lang('api_key'), 'max_length[255]');
            }
            $this->form_validation->set_rules('api_status', lang('api_status'), 'required|max_length[10]');
            if ($this->form_validation->run() == TRUE) {
                $administrator = array();

                if($api_status == 'live'){
                    $administrator['api_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('api_key')));
                }else{
                    $administrator['api_key'] = '';
                }

                $administrator['api_status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('api_status')));
                
                $this->Common_model->updateInformation($administrator, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/APISetting');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/api_setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/api_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function bannerSection(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('main_header', lang('main_header'), 'required|max_length[55]');
            $this->form_validation->set_rules('short_des', lang('short_des'), 'required|max_length[255]');
            $this->form_validation->set_rules('main_banner', lang('main_banner'), 'callback_validate_main_banner');
            if ($this->form_validation->run() == TRUE) {
                $banner_section = array();
                $banner_section['main_header'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('main_header')));
                $banner_section['short_des'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('short_des')));
                
                if ($_FILES['main_banner']['name'] != "") {
                    $banner_section['main_banner'] = $this->session->userdata('main_banner');
                    $this->session->unset_userdata('main_banner');
                }else{
                    $banner_section['main_banner'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('main_banner_old')));
                }
               
               
                
                $return['main_banner_section']  = json_encode($banner_section);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/bannerSection');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/banner_section', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/banner_section', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
 
    /**
     * validate_main_banner
     * @access public
     * @param no
     * @return void
     */
    public function validate_main_banner() {
        if ($_FILES['main_banner']['name'] != "") {
            $config['upload_path'] = './uploads/banner_section';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/banner_section')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('main_banner');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("main_banner")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/banner_section/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('main_banner', $file_name);
                } else {
                    $this->form_validation->set_message('validate_main_banner', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
 
    
    public function serviceSection(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('service_title', lang('service_title'), 'required|max_length[40]');
            $this->form_validation->set_rules('service_heading', lang('service_heading'), 'required|max_length[150]');
            $this->form_validation->set_rules('service_description', lang('service_description'), 'required');
            $this->form_validation->set_rules('service_image', lang('service_image'), 'callback_validate_service_image');
            if ($this->form_validation->run() == TRUE) {
                $service_section = array();
                $service_section['service_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_title')));
                $service_section['service_heading'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_heading')));
                $service_section['service_description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_description')));
                if ($_FILES['service_image']['name'] != "") {
                    $service_section['service_image'] = $this->session->userdata('service_image');
                    $this->session->unset_userdata('service_image');
                }else{
                    $service_section['service_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_image_old')));
                }
                $return['service_section']  = json_encode($service_section);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/serviceSection');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/service_section', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/service_section', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }


    /**
     * @access public
     * @param no
     * @return void
     */
    public function validate_service_image() {
        if ($_FILES['service_image']['name'] != "") {
            $config['upload_path'] = './uploads/service_section';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if(createDirectory('uploads/service_section')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('service_image');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("service_image")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/service_section/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('service_image', $file_name);
                } else {
                    $this->form_validation->set_message('validate_service_image', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }





    public function exploreMenuSection($id=''){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if($id==''){
           $id = $this->session->userdata('outlet_id');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('explore_menu_title', lang('explore_menu_title'), 'required|max_length[40]');
            $this->form_validation->set_rules('explore_menu_heading', lang('explore_menu_heading'), 'required|max_length[150]');
            if ($this->form_validation->run() == TRUE) {
                $explore_menu_section = array();
                $explore_menu_section['explore_menu_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('explore_menu_title')));
                $explore_menu_section['explore_menu_heading'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('explore_menu_heading')));
                $return['explore_menu_section']  = json_encode($explore_menu_section);
                
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                
                $outlet_id  = isset($_POST['outlet_id']) && $_POST['outlet_id']?$_POST['outlet_id']:'';
                if(!$outlet_id){
                    $outlet_id = $this->session->userdata('outlet_id');
                }

                $menu_details = ($_POST['menu_details']);
                $description = ($_POST['description']);
                $main_array = array();
                foreach($menu_details as $key=>$val){
                    $inline_array  = array();
                    $expload = explode("|||",$val);
                    $inline_array['food_id'] = $expload[0];
                    $inline_array['name'] = $expload[1];
                    $inline_array['sale_price'] = $expload[2];
                    $inline_array['description'] = $description[$key];
                    $main_array[] =$inline_array;
                }

          
                 $data = array();
                 $data['explore_section_items'] = json_encode($main_array); 
                 $this->Common_model->updateInformation($data, $outlet_id, "tbl_outlets");

                $this->session->set_flashdata('exception', lang('update_success'));
                if($outlet_id){
                    redirect('Frontend/exploreMenuSection/'.$outlet_id);
                }else{
                    redirect('Frontend/exploreMenuSection');
                }
                
            } else {
                $data = array();
                $data['explor_items'] = exploreItemForAdminPanel($id);
                $data['hidden_outlet_id'] = $id;
                $data['outlet_details'] = getOutletById($id);;
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/explore_menu_section', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['explor_items'] = exploreItemForAdminPanel($id);
            $data['outlet_details'] = getOutletById($id);;
            $data['hidden_outlet_id'] = $id;
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/explore_menu_section', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }



    public function socialMedia(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('facebook_link', lang('facebook_link'), 'required|max_length[255]');
            $this->form_validation->set_rules('google_link', lang('google_link'), 'required|max_length[255]');
            $this->form_validation->set_rules('twitter_link', lang('twitter_link'), 'required|max_length[255]');
            if ($this->form_validation->run() == TRUE) {
                $social_media = array();
                $social_media['facebook_link'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('facebook_link')));
                $social_media['google_link'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('google_link')));
                $social_media['twitter_link'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('twitter_link')));
                $return['social_media']  = json_encode($social_media);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/bannerSection');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/social_media', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/social_media', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function addEditExplore($encrypted_id = ''){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('explore_title', lang('explore_title'), 'required|max_length[255]');
            $this->form_validation->set_rules('explore_price', lang('explore_price'), 'required');
            $this->form_validation->set_rules('explore_des', lang('explore_des'), 'required|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $explore_data = array();
                $explore_data['explore_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('explore_title')));
                $explore_data['explore_price'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('explore_price')));
                $explore_data['explore_des'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('explore_des')));
                $explore_data['user_id'] = $this->session->userdata('user_id');
                $explore_data['company_id'] = $this->session->userdata('company_id');

                if ($id == "") {
                    $this->Common_model->insertInformation($explore_data, "tbl_explores");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($explore_data, $id, "tbl_explores");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Frontend/explores');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('frontend_dynamic/explore/addEditExplore', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['explore'] = $this->Common_model->getDataById($id, "tbl_explores");
                    $data['main_content'] = $this->load->view('frontend_dynamic/explore/addEditExplore', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('frontend_dynamic/explore/addEditExplore', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['explore'] = $this->Common_model->getDataById($id, "tbl_explores");
                $data['main_content'] = $this->load->view('frontend_dynamic/explore/addEditExplore', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }


     /**
     * contactList
     * @access public
     * @return void
     * @param no
     */
    public function contactList() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['contacts'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_contacts");
        $data['main_content'] = $this->load->view('frontend_dynamic/contacts/contacts', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * delete contact
     * @access public
     * @return void
     * @param int
     */
    public function deleteContact($id) {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_contacts");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Frontend/contactList');
    }

     /**
     * explores
     * @access public
     * @return void
     * @param no
     */
    public function explores() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['explores'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_explores");
        $data['main_content'] = $this->load->view('frontend_dynamic/explore/explores', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    
    /**
     * delete explores
     * @access public
     * @return void
     * @param int
     */
    public function deleteExplore($id) {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_explores");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Frontend/explores');
    }




    public function googleMap(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('google_map', lang('google_map'), 'required');
            $this->form_validation->set_rules('contact_us_des', lang('goocontact_us_desgle_map'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $google_map = array();
                $google_map['google_map'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('google_map')));
                $google_map['contact_us_des'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('contact_us_des')));
                $this->Common_model->updateInformation($google_map, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/googleMap');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/google_map', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/google_map', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }




    public function contactUs(){
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('first_name', lang('first_name'), 'required|max_length[55]');
            $this->form_validation->set_rules('last_name', lang('last_name'), 'required|max_length[55]');
            $this->form_validation->set_rules('email', lang('email'), 'required|max_length[100]');
            $this->form_validation->set_rules('subject', lang('subject'), 'required|max_length[100]');
            $this->form_validation->set_rules('message', lang('message'), 'required|max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $contact_us = array();
                $contact_us['first_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('first_name')));
                $contact_us['last_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('last_name')));
                $contact_us['email'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $contact_us['subject'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('subject')));
                $contact_us['message'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('message')));
                $contact_us['company_id'] = 1;
                $this->Common_model->insertInformation($contact_us, "tbl_contacts");
                $this->session->set_flashdata('exception', lang('insertion_success'));

                redirect('contact-us');
            }else{
                $data = array();
                $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                $data['main_content'] = $this->load->view('frontend/contactus', $data, TRUE);
                $this->load->view('frontend/website_layout', $data);
            }
        } else {
            $data = array();
            $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
            $data['main_content'] = $this->load->view('frontend/contactus', $data, TRUE);
            $this->load->view('frontend/website_layout', $data);
        
        }
    }


    public function aboutUs(){
        $data = array();
        $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/aboutus', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }


    public function oldOrders(){
        $data = array();
        $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/old_orders', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }

    public function orderDetails($id){
        $id = d($id,2); 
         
        $order = getOrderDetails($id);
        if($order){
            $orderItems = getOrderItems($order->id);
        }else{
            $order = getOrderDetailsSaleTable($id);
            $orderItems = getOrderItemsSaleTable($order->id);
        }
        $totalItems = count($orderItems);
        $data = array();
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        $data['totalItems'] = $totalItems;
        $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/order_details', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }

    public function orderSuccess($id)
    {

        $id = d($id,2); 
       
        $orderData = getOrderDetails1($id);
      
        $data = array();
        $data['orderData'] = $orderData;
        $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/order-success', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }





    // Admin Panel
    public function aboutUsContent(){
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('about_us_title', lang('about_us_title'), 'required|max_length[40]');
            $this->form_validation->set_rules('abous_us_heading', lang('abous_us_heading'), 'required|max_length[150]');
            $this->form_validation->set_rules('about_us_des', lang('about_us_des'), 'required');
            $this->form_validation->set_rules('about_us_image', lang('about_us_image'), 'callback_validate_about_us_image');
            if ($this->form_validation->run() == TRUE) {
                $about_us = array();
                $about_us['about_us_title'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('about_us_title')));
                $about_us['abous_us_heading'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('abous_us_heading')));
                $about_us['about_us_des'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('about_us_des')));
                if ($_FILES['about_us_image']['name'] != "") {
                    $about_us['about_us_image'] = $this->session->userdata('about_us_image');
                    $this->session->unset_userdata('about_us_image');
                }else{
                    $about_us['about_us_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('about_us_image_old')));
                }
                $return['about_us']  = json_encode($about_us);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/aboutUsContent');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/about_us_content', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/about_us_content', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * validate_about_us_image
     * @access public
     * @param no
     * @return void
     */
    public function validate_about_us_image() {
        if ($_FILES['about_us_image']['name'] != "") {
            $config['upload_path'] = './uploads/about_us';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/about_us')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('about_us_image');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("about_us_image")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/about_us/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('about_us_image', $file_name);
                } else {
                    $this->form_validation->set_message('validate_about_us_image', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }


    public function reservations(){
        $c_id = isset($_GET["c_id"]) && $_GET["c_id"]?$_GET["c_id"]:1;
        $company = getCompanyInfo($c_id);
        if($company->sos_enable_reservation!="Yes"){
            $this->session->set_flashdata('exception_1', lang('reservation_disable_msg'));
            redirect('Authentication/index');
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('outlet_id', lang('outlet'), 'max_length[55]');
            $this->form_validation->set_rules('first_name', lang('first_name'), 'max_length[55]');
            $this->form_validation->set_rules('last_name', lang('last_name'), 'max_length[55]');
            $this->form_validation->set_rules('phone', lang('phone '), 'required|max_length[100]');
            $this->form_validation->set_rules('no_of_people', lang('no_of_people'), 'required|max_length[255]');
            $this->form_validation->set_rules('date', lang('date'), 'max_length[55]');
            $this->form_validation->set_rules('time', lang('time'), 'max_length[55]');
            $this->form_validation->set_rules('special_request', lang('special_request'), 'max_length[55]');
            if ($this->form_validation->run() == TRUE) {
                $first_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('first_name')));
                $last_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('last_name')));

                $reservations = array();
                $reservations['outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
                $reservations['company_id'] = 1;
                $reservations['name'] = $first_name . ' '  . $last_name;
                $reservations['phone'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $reservations['number_of_guest'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('no_of_people')));
                $reservations['reservation_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('date')));
                $reservations['reservation_time'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('time')));
                $reservations['reservation_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reservation_type')));
                $reservations['special_request'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('special_request')));
                $reservations['reservation_order_receiving_id']  = getReservationOrderReceivingId($reservations['outlet_id']);
                 

                $this->Common_model->insertInformation($reservations, "tbl_reservations");
                $this->session->set_flashdata('exception', lang('insertion_success'));
            }
            redirect('reservation');
        } else {
            $data = array();
            if(isServiceAccessOnly('sGmsJaFJE')){
                $data['companies'] = $this->Common_model->getAllByTableAsc("tbl_companies"); 
                $this->load->view('saas/reservation',$data);
            }else{
                $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                $data['main_content'] = $this->load->view('frontend/reservations', $data, TRUE);
                $this->load->view('frontend/website_layout', $data);
            }
            
        
        }
    }

    /**
     * forgot password
     * @access public
     * @return void
     * @param no
     */
    public function forgotPassword() {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('email', lang('email'), 'required|valid_email|max_length[250]');
            if ($this->form_validation->run() == TRUE) {
                $email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $customer = getCustomerDataByEmail($email);
                if($customer){

                    $smtp =  getCompanySMTPAndStatus(1);
                    $random = generateOtp();
                    $data1['password_online_user'] = md5($random); 
                    $this->Common_model->updateInformation($data1, $customer->id, "tbl_customers"); 

                    if($smtp){ 
                        $txt = 'Your temporary password is <b>'.$random.'</b>';
                        //send success message for restaurant admin
                        $send_to = $email;
                        $emailSetting = json_decode($smtp->email_settings);
                        if($emailSetting->enable_status == 1){
                            //if setting enable then we are doing inactive default
                            $mail_data = [];
                            $mail_data['to'] = ["$send_to"];
                            $mail_data['subject'] = 'Reset Password';
                            $mail_data['file_name'] = '';
                            $mail_data['company_id'] = 1;
                            $mail_data['company_info'] = $smtp;
                            $mail_data['message'] = $txt;
                            $mail_data['body_title'] = "Reset Password";
                            $mail_data['user_name'] = $customer->name;
                            $mail_data['template'] = $this->load->view('mail-template/signup-template', $mail_data, TRUE);
                            sendEmailOnlyAZ($mail_data['subject'],$mail_data['template'],$send_to,'',$mail_data['file_name'], $smtp->id);
                            
                            $this->session->set_flashdata('exception', lang('sent_temporary_mail'));
                            redirect('login');

                        }else{
                            $this->session->set_flashdata('exception_1', lang('no_customer_found'));
                            redirect('forgot-password');
                        }
                    }else{
                        $this->session->set_flashdata('exception_1', lang('no_customer_found'));
                        redirect('forgot-password');
                    }
                }else{
                    $this->session->set_flashdata('exception_1', lang('no_customer_found'));
                    $data = array();
                    $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                    $data['main_content'] = $this->load->view('frontend/forgot_password', $data, TRUE);
                    $this->load->view('frontend/website_layout', $data);
                }

            } else {
                $data = array();
                $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                $data['main_content'] = $this->load->view('frontend/forgot_password', $data, TRUE);
                $this->load->view('frontend/website_layout', $data);
            }
        } else {
            $data = array();
            $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
            $data['main_content'] = $this->load->view('frontend/forgot_password', $data, TRUE);
            $this->load->view('frontend/website_layout', $data);
        }
    }


    public function menuPage(){
        $data = array();
        $data['header_content'] = $this->load->view('frontend/header_section_menu2', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/menu-page', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }


    public function commonMenuPage(){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('common_menu_page_banner', lang('common_menu_page_banner'), 'callback_validate_common_menu_page_banner');
            if ($this->form_validation->run() == TRUE) {
                $banner_section = array();
                
                if ($_FILES['common_menu_page_banner']['name'] != "") {
                    $banner_section['common_menu_page_banner'] = $this->session->userdata('common_menu_page_banner');
                    $this->session->unset_userdata('common_menu_page_banner');
                }else{
                    $banner_section['common_menu_page_banner'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('common_menu_page_banner_old')));
                }
                $return['common_menu_page']  = json_encode($banner_section);
                $this->Common_model->updateInformation($return, $company_id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/commonMenuPage');
            } else {
                $data = array();
                $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/common_menu_page', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/common_menu_page', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    } 
    public function social_login_setting(){
        $company_id = 1;
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('facebook_app_id', lang('facebook_app_id'), 'max_length[500]');
            $this->form_validation->set_rules('facebook_app_secret', lang('facebook_app_secret'), 'max_length[500]');
            $this->form_validation->set_rules('google_client_id', lang('google_client_id'), 'max_length[500]');
            $this->form_validation->set_rules('google_client_secret_key', lang('google_client_secret_key '), 'max_length[500]'); 
            if ($this->form_validation->run() == TRUE) {
                $reservations = array();
                $reservations['facebook_app_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('facebook_app_id')));
                $reservations['facebook_app_secret'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('facebook_app_secret')));
                $reservations['google_client_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('google_client_id')));
                $reservations['google_client_secret_key'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('google_client_secret_key')));
               
                $this->Common_model->updateInformation($reservations, $company_id, "tbl_companies"); 
                $this->session->set_flashdata('exception', lang('update_success'));
            }
            redirect('Frontend/social_login_setting');
        } else {
            $data = array();
            $data['company_info'] = $this->Common_model->getDataById($company_id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/social_login_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        
        }
    }

    /**
     * validate_common_menu_page_banner
     * @access public
     * @param no
     * @return void
     */
    public function validate_common_menu_page_banner() {
        if ($_FILES['common_menu_page_banner']['name'] != "") {
            $config['upload_path'] = './uploads/common_menu_page';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/common_menu_page')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('common_menu_page_banner');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("common_menu_page_banner")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/common_menu_page/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('common_menu_page_banner', $file_name);
                } else {
                    $this->form_validation->set_message('validate_common_menu_page_banner', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }


    public function menuItemDetails($food_id="", $category_id=""){
        $data = array();
        $data['food_details'] = getFoodMenuDetails(d($food_id,2));
        $data['food_by_cat'] = getFoodMenuByCategoryId(d($category_id,2));
        $data['header_content'] = $this->load->view('frontend/header_section_menu2', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/menu-item', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }



    public function singleItemOrder(){
        $food_id = $this->input->post($this->security->xss_clean('food_id'));
        $food_menu_details = getFoodMenuDetails($food_id);
        $online_selected_outlet = $this->session->userdata('online_selected_outlet');
        $outlet_details = getOutletById($online_selected_outlet);
        $thumb_imgs = isset($outlet_details->thumb_imgs)?(Array)json_decode($outlet_details->thumb_imgs):'';
        $img  = '';
        $str = "thumb_".$food_id;
        if(isset($thumb_imgs[$str]) && $thumb_imgs[$str]){
          $img = base_url()."uploads/website/".$thumb_imgs[$str];
        }else{
          if($food_menu_details->photo)  {
            $img = base_url()."images/".$food_menu_details->photo;
          }else{
            $img = base_url()."assets/media/no_image.png";
          }
          
        }
        $food_menu_details->photo = $img;
        if($food_menu_details){
            $response = [
                'status' => 'success',
                'data' => $food_menu_details,
            ];	
        }else{
            $response = [
                'status' => 'error',
                'data' => '',
            ];	
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function active($code){
        $customers = $this->Common_model->getCustomDataByParams("active_code",$code, "tbl_customers");
       
        if(isset($customers->active_code) && $customers->active_code==$code && $customers->del_status == "Deleted"){
            $data['del_status'] = 'Live'; 
            $this->Common_model->updateInformation($data, $customers->id, "tbl_customers"); 
            $this->session->set_flashdata('exception',"Your account successfully activate");
        }else if(isset($customers->active_code) && $customers->active_code==$code && $customers->del_status=="Live"){
            $this->session->set_flashdata('exception_1',"Your account already active");
        }else{
            $this->session->set_flashdata('exception_1',"You clicked URL not valid");
        }
        redirect('login');
    }
    
    public function login(){ 
    //for google login
        include_once APPPATH . "libraries/vendor/autoload.php";
        $google_client = new Google_Client();
        $siteSetting = getMainCompany();
        $google_client_id = isset($siteSetting->google_client_id) && $siteSetting->google_client_id?$siteSetting->google_client_id:'-';
        $google_client_secret_key = isset($siteSetting->google_client_secret_key) && $siteSetting->google_client_secret_key?$siteSetting->google_client_secret_key:'-';
        $google_client->setClientId($google_client_id); //Define your ClientID
        $google_client->setClientSecret($google_client_secret_key); //Define your Client Secret Key
        $google_client->setRedirectUri(base_url().'google_login/'); //Define your Redirect Uri

        $google_client->addScope('email');
        $google_client->addScope('profile');

        $google_auth_url = $google_client->createAuthUrl();
        // Load facebook oauth library
         $this->load->library('facebook');
        $facebook_auth_url =  $this->facebook->login_url();
        
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[40]');
            $this->form_validation->set_rules('password', lang('password'), 'required|max_length[150]');
            if ($this->form_validation->run() == TRUE) {
                $phone = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $password = htmlspecialcharscustom($this->input->post($this->security->xss_clean('password')));
                $customer = $this->Frontend_model->getCustomerLogin($phone,$password);
                if($customer){
                    $data = array();
                    $data['customer_id'] = $customer->id;
                    $data['customer_name'] = $customer->name;
                    $data['customer_phone'] = $customer->phone;
                    $data['customer_email'] = $customer->email;
                    $data['customer_address'] = $customer->address;
                    $this->session->set_userdata($data);
                    redirect('checkout');
                }else{
                    $this->session->set_flashdata('exception_1', lang('incorrect_phone_password'));
                    redirect('login');
                }
            }else{
                $data = array();
                $data['google_auth_url'] = $google_auth_url;
                $data['facebook_auth_url'] = $facebook_auth_url;
                $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                $data['main_content'] = $this->load->view('frontend/login', $data, TRUE);
                $this->load->view('frontend/website_layout', $data); 
            }
        }else{
          
             
            $data = array();
            $data['google_auth_url'] = $google_auth_url;
            $data['facebook_auth_url'] = $facebook_auth_url;
            $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
            $data['main_content'] = $this->load->view('frontend/login', $data, TRUE);
            $this->load->view('frontend/website_layout', $data);
        }
    }
    public function register(){
        //for google login
        include_once APPPATH . "libraries/vendor/autoload.php";
        $google_client = new Google_Client();
        $siteSetting = getMainCompany();
        $google_client_id = isset($siteSetting->google_client_id) && $siteSetting->google_client_id?$siteSetting->google_client_id:'-';
        $google_client_secret_key = isset($siteSetting->google_client_secret_key) && $siteSetting->google_client_secret_key?$siteSetting->google_client_secret_key:'-';
        $google_client->setClientId($google_client_id); //Define your ClientID
        $google_client->setClientSecret($google_client_secret_key); //Define your Client Secret Key
        $google_client->setRedirectUri(base_url().'google_login/'); //Define your Redirect Uri

        $google_client->addScope('email');
        $google_client->addScope('profile');

        $google_auth_url = $google_client->createAuthUrl();
        // Load facebook oauth library
         $this->load->library('facebook');
        $facebook_auth_url =  $this->facebook->login_url();
        
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('full_name', lang('full_name'), 'required|max_length[100]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[15]|is_unique[tbl_customers.phone]');
            $this->form_validation->set_rules('email', lang('email'), 'required|valid_email|max_length[50]');
            $this->form_validation->set_rules('password', lang('password'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $full_name = htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $phone = htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $email = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $password = md5($this->input->post($this->security->xss_clean('password')));
                
                $customer_info = array();
                $customer_info['name'] = $full_name;
                $customer_info['phone'] =$phone;
                $customer_info['email'] =$email;
                $customer_info['password_online_user'] =$password;
                $customer_info['default_discount'] =0;
                $active_code = uniqid();
                $customer_info['active_code'] = $active_code;
                $customer_info['company_id'] = 1;
                if (APPLICATION_MODE != 'demo') {
                    $customer_info['del_status'] = "Deleted";
                } 
                $checkExist = customerDetailsByPhone($phone);
                if($checkExist){
                    $this->session->set_flashdata('exception_1', lang('exist_customer_signup_info'));
                    redirect('register');
                }
                $smtp =  getCompanySMTPAndStatus(1);
                if($smtp){
                    $company = getMainCompany();
                    $business =$company->business_name;
                    $txt = 'Congratulations, "'.$business.'" customer sign-up has been successful.
                    For active your account- <a href="'.base_url().'active/'.$active_code.'">Active Now</a>';
                    //send success message for restaurant admin
                    $send_to = $email;

                    $emailSetting = json_decode($smtp->email_settings);
                    if($emailSetting->enable_status == 1){
                        //if setting enable then we are doing inactive default
                        $this->Common_model->insertInformation($customer_info, "tbl_customers");
                        $mail_data = [];
                        $mail_data['to'] = ["$send_to"];
                        $mail_data['subject'] = 'Customer Signup';
                        $mail_data['file_name'] = '';
                        $mail_data['company_id'] = 1;
                        $mail_data['company_info'] = $company;
                        $mail_data['message'] = $txt;
                        $mail_data['body_title'] = "Customer Signup Varification!";
                        $mail_data['user_name'] = $customer_info['name'];
                        $mail_data['template'] = $this->load->view('mail-template/signup-template', $mail_data, TRUE);
                        sendEmailOnlyAZ($mail_data['subject'],$mail_data['template'],$send_to,'',$mail_data['file_name'], $company->id);
                    }else{
                        $this->Common_model->insertInformation($customer_info, "tbl_customers");
                    }
                }else{
                    $this->Common_model->insertInformation($customer_info, "tbl_customers");
                }
                if (APPLICATION_MODE != 'demo') {
                    $this->session->set_flashdata('exception', lang('customer_signup_message'));
                }else{
                    $this->session->set_flashdata('exception', lang('customer_signup_message_1'));
                } 
                
                redirect('login');

            }else{
                $data = array();
                $data['google_auth_url'] = $google_auth_url;
                $data['facebook_auth_url'] = $facebook_auth_url;
                $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
                $data['main_content'] = $this->load->view('frontend/register', $data, TRUE);
                $this->load->view('frontend/website_layout', $data); 
            }
        }else{
            $data = array();
            $data['google_auth_url'] = $google_auth_url;
                $data['facebook_auth_url'] = $facebook_auth_url;
            $data['header_content'] = $this->load->view('frontend/header_section_menu', $data, TRUE);
            $data['main_content'] = $this->load->view('frontend/register', $data, TRUE);
            $this->load->view('frontend/website_layout', $data);
        }
    }


    
    public function checkoutPage(){
        if (!$this->session->has_userdata('customer_id')) {
            redirect('Frontend/login');
        }
        
        $data = array();
        $short_name = strtolower(substr($this->session->userdata('customer_name'),0, 1));
        if(!$short_name){
            $short_name = getRandomCodeOne(1);
        }
       
        $data['customer_short_name'] = $short_name.(getRandomCodeTwoCapital(2));
        
        $data['header_content'] = $this->load->view('frontend/header_section_menu2', $data, TRUE);
        $data['main_content'] = $this->load->view('frontend/check_out', $data, TRUE);
        $this->load->view('frontend/website_layout', $data);
    }


    public function logOut(){
        $this->session->unset_userdata('customer_id');
        $this->session->unset_userdata('customer_name');
        $this->session->unset_userdata('customer_phone');
        $this->session->unset_userdata('customer_email');
        $this->session->unset_userdata('customer_address');
        $this->session->unset_userdata('online_selected_outlet');
        $this->session->unset_userdata('go_online_status');
        $this->session->unset_userdata('online_selected_company'); 
        redirect(base_url());
    } 

    public function addEditPhoto($encrypted_id = ''){
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('photo', lang('photo'), 'max_length[255]|callback_validate_photo');
            if ($this->form_validation->run() == TRUE) {
                $photo = array();
                if ($_FILES['photo']['name'] != "") {
                    $photo['photo'] = $this->session->userdata('photo');
                    $this->session->unset_userdata('photo');
                }else{
                    $photo['photo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('photo_old')));
                }
                $photo['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($photo, "tbl_galleries");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($photo, $id, "tbl_galleries");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Frontend/photos');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('frontend_dynamic/photo/addEditPhoto', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['photo'] = $this->Common_model->getDataById($id, "tbl_galleries");
                    $data['main_content'] = $this->load->view('frontend_dynamic/photo/addEditPhoto', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('frontend_dynamic/photo/addEditPhoto', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['photo'] = $this->Common_model->getDataById($id, "tbl_galleries");
                $data['main_content'] = $this->load->view('frontend_dynamic/photo/addEditPhoto', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * validate_photo
     * @access public
     * @param no
     * @return void
     */
    public function validate_photo() {
        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './uploads/photo_gallery';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if(createDirectory('uploads/photo_gallery')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('photo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("photo")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/photo_gallery/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('photo', $file_name);
                } else {
                    $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

     /**
     * photos
     * @access public
     * @return void
     * @param no
     */
    public function photos() {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['photos'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_galleries");
        $data['main_content'] = $this->load->view('frontend_dynamic/photo/photos', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    public function updateOrderSuccess() {
        
    }

        /**
     * deletePhoto
     * @access public
     * @return void
     * @param int
     */
    public function deletePhoto($id) {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_galleries");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Frontend/photos');
    }
  
    public function paymentSetting($id = '') {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $field_2  = htmlspecialcharscustom($this->input->post('field_2'));
            $field_3  = htmlspecialcharscustom($this->input->post('field_3'));
            $field_5  = htmlspecialcharscustom($this->input->post('field_5'));

            $field_2_v  = htmlspecialcharscustom($this->input->post('field_2_v'));
            $field_3_v  = htmlspecialcharscustom($this->input->post('field_3_v'));
            $field_4_v  = htmlspecialcharscustom($this->input->post('field_4_v'));
            $this->form_validation->set_rules('submit', "submit", "required");
            if($field_2==1){
                $this->form_validation->set_rules('paypal_business_email', "Paypal Business Amount", "required");
                $this->form_validation->set_rules('field_2_key_1', "Client ID", "required");
                $this->form_validation->set_rules('field_2_key_2', "Secret Key", "required");
            }
            if($field_3==1){
                $this->form_validation->set_rules('field_3_key_1', "Stripe API Key", "required");
                $this->form_validation->set_rules('field_3_key_2', "Stripe Publishable Key", "required");
            }
            if($field_5==1){
                $this->form_validation->set_rules('field_4_key_1', "Key ID", "required");
                $this->form_validation->set_rules('field_4_key_2', "Key Secret", "required");
            }

            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['field_2'] = $field_2;
                $data['field_3'] = $field_3;
                $data['field_5'] = $field_5;

                $data['field_2_v'] = $field_2_v;
                $data['field_3_v'] = $field_3_v;
                $data['field_4_v'] = $field_4_v;

                $data['field_2_key_1']  = htmlspecialcharscustom($this->input->post('field_2_key_1'));
                $data['field_2_key_2']  = htmlspecialcharscustom($this->input->post('field_2_key_2'));
                $data['field_3_key_1']  = htmlspecialcharscustom($this->input->post('field_3_key_1'));
                $data['field_3_key_2']  = htmlspecialcharscustom($this->input->post('field_3_key_2'));
                $data['field_4_key_1']  = htmlspecialcharscustom($this->input->post('field_4_key_1'));
                $data['field_4_key_2']  = htmlspecialcharscustom($this->input->post('field_4_key_2'));
                //pre($data);
                $data['paypal_business_email']  = htmlspecialcharscustom($this->input->post('paypal_business_email'));
                if($field_2_v=="sandbox"){
                    $data['url_paypal']  = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                }else{
                    $data['url_paypal']  = "https://www.paypal.com/cgi-bin/webscr";
                }

                $data_payment_setting['payment_settings'] = json_encode($data);
                if ($id == "") {
                    $this->Common_model->insertInformation($data_payment_setting, "tbl_companies");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data_payment_setting, $id, "tbl_companies");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('Frontend/paymentSetting');
            }else{
                $data = array();
                $data['paymentSetting'] = paymentSetting();
                $data['main_content'] = $this->load->view('frontend/paymentSetting', $data, TRUE);
                $this->load->view('userHome', $data);
            }

        } else {
            $data = array();
            $data['paymentSetting'] = paymentSetting();
            $data['main_content'] = $this->load->view('frontend/paymentSetting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    /**
     * payment setting
     * @access public
     * @return void
     * @param int
     */
    public function emailSetting($id = '') {
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $enable_status  = htmlspecialcharscustom($this->input->post('enable_status'));
            if($enable_status==1){
                $this->form_validation->set_rules('host_name', lang('SMTPHost'), "required");
                $this->form_validation->set_rules('port_address', lang('PortAddress'), "required");
                $this->form_validation->set_rules('user_name', lang('Username'), "required");
                $this->form_validation->set_rules('password', lang('Password'), "required");
                if ($this->form_validation->run() == TRUE) {
                    $data = array();
                    $data['enable_status']  = htmlspecialcharscustom($this->input->post('enable_status'));
                    $data['host_name']  = htmlspecialcharscustom($this->input->post('host_name'));
                    $data['email_send_to']  = htmlspecialcharscustom($this->input->post('email_send_to'));
                    $data['port_address']  = htmlspecialcharscustom($this->input->post('port_address'));
                    $data['user_name']  = htmlspecialcharscustom($this->input->post('user_name'));
                    $data['password']  = htmlspecialcharscustom($this->input->post('password'));
                    $data_payment_setting['email_settings'] = json_encode($data);
                    $this->Common_model->updateInformation($data_payment_setting, $id, "tbl_companies");
                    $this->session->set_flashdata('exception', lang('update_success'));
                    redirect('Frontend/emailSetting');
                }else{
                    $data = array();
                    $data['main_content'] = $this->load->view('frontend_dynamic/email_setting', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }else{
                $data = array();
                $data['enable_status']  = htmlspecialcharscustom($this->input->post('enable_status'));
                $data['host_name']  = htmlspecialcharscustom($this->input->post('host_name'));
                $data['port_address']  = htmlspecialcharscustom($this->input->post('port_address'));
                $data['email_send_to']  = htmlspecialcharscustom($this->input->post('email_send_to'));
                $data['user_name']  = htmlspecialcharscustom($this->input->post('user_name'));
                $data['password']  = htmlspecialcharscustom($this->input->post('password'));
                $data_payment_setting['email_settings'] = json_encode($data);
                $this->Common_model->updateInformation($data_payment_setting, $id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('Frontend/emailSetting');
            }
        } else {
            $data = array();
            $data['main_content'] = $this->load->view('frontend_dynamic/email_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
    public function googleLogin()
    {
        //include libraries for google
        include_once APPPATH . "libraries/vendor/autoload.php";
        $google_client = new Google_Client();
        $siteSetting = getMainCompany();
        $google_client_id = isset($siteSetting->google_client_id) && $siteSetting->google_client_id?$siteSetting->google_client_id:'-';
        $google_client_secret_key = isset($siteSetting->google_client_secret_key) && $siteSetting->google_client_secret_key?$siteSetting->google_client_secret_key:'-';

        $google_client->setClientId($google_client_id); //Define your ClientID
        $google_client->setClientSecret($google_client_secret_key); //Define your Client Secret Key
        $google_client->setRedirectUri(base_url().'google_login/'); //Define your Redirect Uri

        $google_client->addScope('email');
        $google_client->addScope('profile');

        if(isset($_GET["code"]))
        {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            if(!isset($token["error"]))
            {
                $google_client->setAccessToken($token['access_token']);
                $this->session->set_userdata('access_token', $token['access_token']);
                $google_service = new Google_Service_Oauth2($google_client);
                $data = $google_service->userinfo->get();
 
                $data_db = array();
                $data_db['name'] = $data['name'];
                $data_db['email'] = $data['email'];
                $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($data['email']);
                if($checkExistingAccount){
                    $return_data = array();
                    $return_data['customer_id'] = $checkExistingAccount->id;
                    $return_data['customer_name'] = $checkExistingAccount->name;
                    $return_data['customer_phone'] = $checkExistingAccount->phone;
                    $return_data['customer_email'] = $checkExistingAccount->email;
                    $return_data['customer_address'] = $checkExistingAccount->address;
                    $this->session->set_userdata($return_data);
                    $this->session->set_flashdata('success', "Successfully login with google account!");
                }else{
                    $id = $this->Common_model->insertInformation($data_db, "tbl_customers");
                    $return_data = array();
                    $return_data['customer_id'] = $id;
                    $return_data['customer_name'] = $data['name'];
                    $return_data['customer_phone'] = $data['phone'];;
                    $return_data['customer_email'] = $data['email'];
                    $return_data['customer_address'] = '';
                    $this->session->set_flashdata('success', "Successfully login with google account!");
                    $this->session->set_userdata($return_data);
                }
            }
        }
        redirect('/');
    }

    /**
     * facebook login
     * @access public
     * @return void
     * @param no
     */
    public function facebookLogin()
    {
        //load facebook library
        $this->load->library('facebook');
        $userData = array();

        // Authenticate user with facebook
        if($this->facebook->is_authenticated()){
            // Get user info from facebook
            $fbUser = $this->facebook->request('get', '/me?fields=first_name,last_name,email');
            pre($fbUser);exit;
            // Preparing data for database insertion
            $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
            $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
       
            $data_db = array();
            $data_db['name'] = $userData['first_name']." ".$userData['last_name'];
            $data_db['email'] = $userData['email'];
            if($userData['email']){
                $checkExistingAccount = $this->Common_model->checkExistingAccountByEmail($userData['email']);
                if($checkExistingAccount){
                    $return_data = array();
                    $return_data['customer_id'] = $checkExistingAccount->id;
                    $return_data['customer_name'] = $checkExistingAccount->name;
                    $return_data['customer_phone'] = $checkExistingAccount->phone;
                    $return_data['customer_email'] = $checkExistingAccount->email;
                    $return_data['customer_address'] = $checkExistingAccount->address;
                    $this->session->set_flashdata('success', "Successfully login with facebook account!");
                    $this->session->set_userdata($return_data);
                }else{
                    $data_db['created_date_time'] = date('Y-m-d H:i:s');
                    $id = $this->Common_model->insertInformation($data_db, "tbl_customers");
                    $return_data = array();
                    $return_data['customer_id'] = $id;
                    $return_data['customer_name'] = $userData['first_name']." ".$userData['last_name'];
                    $return_data['customer_phone'] = '';
                    $return_data['customer_email'] = $userData['email'];
                    $return_data['customer_address'] = '';
                    $return_data['c_email'] = $userData['email'];
                    $this->session->set_flashdata('success', "Successfully login with facebook account!");
                    $this->session->set_userdata($return_data);
                }
            }else{
                $return_data['c_login_type_message'] = "No email address found following the facebook account";
                $this->session->set_userdata($return_data);
            }
        }
        redirect('/');
    }



    public function ratingSubmit(){
        $data = array();
        $data['rating'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('rating')));
        $data['food_menu_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('id')));
        $data['user_id'] = $this->session->has_userdata('customer_id') ? $this->session->userdata('customer_id') : 0;
        $data['company_id'] = 1;
        $this->Common_model->insertInformation($data, "tbl_food_menu_ratings");
        
        echo json_encode(array('status' => 'success'));
    }


    
    public function websiteWhiteLabel($id = '') {
        $company_id = $id = $outlet_id = $this->session->userdata('company_id');
        $id = $company_id;
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('site_name', lang('site_name'), 'required|max_length[250]');
            $this->form_validation->set_rules('footer', lang('footer'), 'required|max_length[250]');
            $this->form_validation->set_rules('system_logo', lang('system_logo'), 'callback_validate_system_logo|max_length[500]');
            $this->form_validation->set_rules('favicon', lang('favicon'), 'callback_validate_favicon|max_length[500]');
            $this->form_validation->set_rules('website_theme_color', lang('website_theme_color'), 'max_length[250]');
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
                $outlet_info['website_theme_color'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('website_theme_color')));
                $return['website_white_label']  = json_encode($outlet_info);

                $this->Common_model->updateInformation($return, $id, "tbl_companies");
                $this->session->set_flashdata('exception', lang('update_success'));

                $this->session->set_userdata($outlet_info);
                redirect('Frontend/websiteWhiteLabel');
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_companies");
                $data['main_content'] = $this->load->view('frontend_dynamic/whitelabel', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['encrypted_id'] = $encrypted_id;
            $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_companies");
            $data['main_content'] = $this->load->view('frontend_dynamic/whitelabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
    public function availableOnlineFoods($id='') {
        if($id==""){
            $id = $this->session->userdata('outlet_id');
        }
        $data = array();
        $data['hidden_outlet_id'] = $id;
        $selected_modules_arr = array();
        $data['outlet_information'] = $this->Common_model->getDataById($id, "tbl_outlets");
        
        $language_manifesto = $this->session->userdata('language_manifesto');
        
            if(str_rot13($language_manifesto)=="eriutoeri"){
                $data['items'] = $this->Common_model->getSelectedMenu($data['outlet_information']->food_menus);
            }else{
                $company_id = $this->session->userdata('company_id');
                $data['items'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menus"); 
            }
            
            $selected_modules =  explode(',',$data['outlet_information']->available_online_foods);
            foreach ($selected_modules as $value) {
                $id_arr = explode("_",$value);
                $selected_modules_arr[$id_arr[1]] = $value;
            }

        $data['selected_modules_arr'] = $selected_modules_arr;
        $data['main_content'] = $this->load->view('frontend_dynamic/availableOnlineFoods', $data, TRUE);
        $this->load->view('userHome', $data);

    }
    public function setNearestOutlet() {
        $outlet_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('outlet_id')));
        $this->session->set_userdata('online_selected_outlet', $outlet_id);
        redirect(base_url());
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
                $config['width'] = 120;
                $config['height'] = 36;
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



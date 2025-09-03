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
  # This is FoodMenuCategory Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class FoodMenuCategory extends Cl_Controller {

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
        $controller = "229";
        $function = "";
        if($segment_2=="foodMenuCategories"){
            $function = "view";
        }elseif($segment_2=="addEditFoodMenuCategory" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditFoodMenuCategory"){
            $function = "add";
        }elseif($segment_2=="sortingForPOS"){
            $function = "sorting";
        }elseif($segment_2=="deleteFoodMenuCategory"){
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
    public function foodMenuCategories() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['foodMenuCategories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_food_menu_categories");
        $data['main_content'] = $this->load->view('master/foodMenuCategory/foodMenuCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * food Menu Categories
     * @access public
     * @return void
     * @param no
     */
    public function sortingForPOS() {
        $data = array();
        $data['foodMenuCategories'] = $this->Common_model->getSortingForPOS();
        $data['main_content'] = $this->load->view('master/foodMenuCategory/ordering_for_pos', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Food Menu Category
     * @access public
     * @return void
     * @param int
     */
    public function deleteFoodMenuCategory($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_food_menu_categories");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('foodMenuCategory/foodMenuCategories');
    }
     /**
     * add/Edit Food Menu Category
     * @access public
     * @return void
     * @param int
     */
    public function addEditFoodMenuCategory($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('category_name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            $this->form_validation->set_rules('category_image', lang('category_image'), 'callback_validate_category_image');
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['category_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_name')));
                if ($_FILES['category_image']['name'] != "") {
                    $fmc_info['category_image'] = $this->session->userdata('category_image');
                    $this->session->unset_userdata('category_image');
                }else{
                    $fmc_info['category_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_image_old')));
                }
                $fmc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($fmc_info, "tbl_food_menu_categories");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_food_menu_categories");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('foodMenuCategory/foodMenuCategories');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/foodMenuCategory/addFoodMenuCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_food_menu_categories");
                    $data['main_content'] = $this->load->view('master/foodMenuCategory/editFoodMenuCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/foodMenuCategory/addFoodMenuCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/foodMenuCategory/editFoodMenuCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    
        /**
     * @access public
     * @param no
     * @return void
     */
    public function validate_category_image() {
        if ($_FILES['category_image']['name'] != "") {
            $config['upload_path'] = './uploads/category';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/category')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('category_image');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("category_image")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/category/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('category_image', $file_name);
                } else {
                    $this->form_validation->set_message('validate_category_image', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    


}

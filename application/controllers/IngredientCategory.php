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
  # This is IngredientCategory Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class IngredientCategory extends Cl_Controller {

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
        $controller = "207";
        $function = "";

        if($segment_2=="ingredientCategories"){
            $function = "view";
        }elseif($segment_2=="addEditIngredientCategory" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditIngredientCategory"){
            $function = "add";
        }elseif($segment_2=="deleteIngredientCategory"){
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
     * ingredient Categories
     * @access public
     * @return void
     * @param no
     */
    public function ingredientCategories() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['ingredientCategories'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_ingredient_categories");
        $data['main_content'] = $this->load->view('master/ingredientCategory/ingredientCategories', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Ingredient Category
     * @access public
     * @return void
     * @param int
     */
    public function deleteIngredientCategory($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_ingredient_categories");

        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ingredientCategory/ingredientCategories');
    }
     /**
     * add/Edit Ingredient Category
     * @access public
     * @return void
     * @param int
     */
    public function addEditIngredientCategory($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('category_name',lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $igc_info = array();
                $igc_info['category_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_name')));
                $igc_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $igc_info['user_id'] = $this->session->userdata('user_id');
                $igc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $this->Common_model->insertInformation($igc_info, "tbl_ingredient_categories");
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($igc_info, $id, "tbl_ingredient_categories");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('ingredientCategory/ingredientCategories');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/ingredientCategory/addIngredientCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['category_information'] = $this->Common_model->getDataById($id, "tbl_ingredient_categories");
                    $data['main_content'] = $this->load->view('master/ingredientCategory/editIngredientCategory', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/ingredientCategory/addIngredientCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['category_information'] = $this->Common_model->getDataById($id, "tbl_ingredient_categories");
                $data['main_content'] = $this->load->view('master/ingredientCategory/editIngredientCategory', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

}

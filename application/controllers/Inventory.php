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
  # This is Inventory Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Inventory_model');
        $this->load->model('Master_model');
        $this->load->model('Sale_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }


        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
    }

     /**
     * inventory info
     * @access public
     * @return void
     * @param no
     */
    public function index() {
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);

        $controller = "129";
        $function = "";

        if($segment_1=="Inventory" || $segment_2=="index"){
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function


        $data = array();
        $ingredient_id = $this->input->post('ingredient_id');
        $category_id = $this->input->post('category_id');
        $food_id = $this->input->post('food_id');
        $data['ingredient_id'] = $ingredient_id;
        $company_id = $this->session->userdata('company_id');
        $data['ingredient_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_ingredient_categories");
        $data['ingredients'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_ingredients");

        $data['foodMenus'] = $this->Sale_model->getAllFoodMenus();
        $data['inventory'] = $this->Inventory_model->getInventory($category_id, $ingredient_id, $food_id);
        $data['main_content'] = $this->load->view('inventory/inventory', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * inventory info
     * @access public
     * @return void
     * @param no
     */
    public function inventoryFoodMenu() {
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);

        $controller = "346";
        $function = "";

        if($segment_1=="Inventory" || $segment_2=="inventoryFoodMenu"){
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $data = array();
        $food_id = $this->input->post('food_id');
        $company_id = $this->session->userdata('company_id');
        $data['foodMenus'] = $this->Sale_model->getAllFoodMenus();
        $category_id = $this->input->post('category_id');
        $data['ingredient_categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
        $data['inventory'] = $this->Inventory_model->getInventoryFoodMenu($food_id,$category_id);
        $data['main_content'] = $this->load->view('inventory/inventory_food_menu', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * inventory info
     * @access public
     * @return void
     * @param no
     */
     /**
     * get Inventory Alert List
     * @access public
     * @return void
     * @param no
     */
    public function getInventoryAlertList() {
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);

        $controller = "173";
        $function = "";

        if($segment_1=="Inventory" || $segment_2=="getInventoryAlertList"){
            $function = "view";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }
        //end check access function

        $data = array();
        $data['inventory'] = $this->Inventory_model->getInventoryAlertList();
        $data['main_content'] = $this->load->view('inventory/inventoryAlertList', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * get Ingredient Info Ajax
     * @access public
     * @return object
     * @param no
     */
    public function getIngredientInfoAjax() {
        $cat_id = $_GET['category_id'];
        $outlet_id = $this->session->userdata('outlet_id');
        if ($cat_id) {
            $results = $this->Inventory_model->getDataByCatId($cat_id, "tbl_ingredients");
        } else {
            $results = $this->Inventory_model->getAllByOutletIdForDropdown($outlet_id, "tbl_ingredients");
        }
        echo json_encode($results);
    }
    public function getCurrentInventory() {
        $ing_id = $_POST['ing_id'];
        $data =  $this->Inventory_model->getCurrentInventory($ing_id);
        echo json_encode($data);
    }

}

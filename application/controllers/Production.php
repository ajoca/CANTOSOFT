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
  # This is Production Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Production_model');
        $this->load->model('Master_model');
        $this->load->model('Common_model');
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

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "340";
        $function = "";

        if($segment_2=="productions"){
            $function = "view";
        }elseif($segment_2=="addEditProduction" && $segment_3){
            $function = "update";
        }elseif($segment_2=="productionDetails" && $segment_3){
            $function = "view_details";
        }elseif($segment_2=="addEditProduction"){
            $function = "add";
        }elseif($segment_2=="deleteProduction"){
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
     * productions info
     * @access public
     * @return void
     * @param no
     */
    public function productions() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['productions'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_production");
        $data['main_content'] = $this->load->view('production/productions', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Production
     * @access public
     * @return void
     * @param int
     */
    public function deleteProduction($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_production", "tbl_production_ingredients", 'id', 'production_id');
        $this->Common_model->deletingMultipleFormData('production_id', $id, 'tbl_sale_consumptions_of_menus');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Production/productions');
    }
     /**
     * add/Edit Production
     * @access public
     * @return void
     * @param int
     */
    public function addEditProduction($encrypted_id = "") {


        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        $production_info = array();

        if ($id == "") {
            $production_info['reference_no'] = $this->Production_model->generatePurRefNo($outlet_id);
        } else {
            $production_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_production")->reference_no;
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $production_info['reference_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $production_info['status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $production_info['date'] = date('Y-m-d', strtotime($this->input->post($this->security->xss_clean('date'))));
                $production_info['user_id'] = $this->session->userdata('user_id');
                $production_info['outlet_id'] = $this->session->userdata('outlet_id');
                if ($id == "") {
                    $production_id = $this->Common_model->insertInformation($production_info, "tbl_production");
                    $this->saveProductionIngredients($_POST['ingredient_id'], $production_id, 'tbl_production_ingredients');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($production_info, $id, "tbl_production");
                    $this->Common_model->deletingMultipleFormData('production_id', $id, 'tbl_production_ingredients');
                    $this->Common_model->deletingMultipleFormData('production_id', $id, 'tbl_sale_consumptions_of_menus');
                    $this->saveProductionIngredients($_POST['ingredient_id'], $id, 'tbl_production_ingredients');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('Production/productions');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['pur_ref_no'] = $this->Production_model->generatePurRefNo($outlet_id);
                    $data['ingredients'] = $this->Production_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['main_content'] = $this->load->view('production/addProduction', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['encrypted_id'] = $encrypted_id;
                    $data['production_details'] = $this->Common_model->getDataById($id, "tbl_production");
                    $data['ingredients'] = $this->Production_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['production_ingredients'] = $this->Production_model->getProductionIngredients($id);
                    $data['main_content'] = $this->load->view('production/editProduction', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['pur_ref_no'] = $this->Production_model->generatePurRefNo($outlet_id);
                $data['ingredients'] = $this->Production_model->getIngredientListWithUnitAndPrice($company_id);
                $data['main_content'] = $this->load->view('production/addProduction', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['production_details'] = $this->Common_model->getDataById($id, "tbl_production");
                $data['ingredients'] = $this->Production_model->getIngredientListWithUnitAndPrice($company_id);
                $data['production_ingredients'] = $this->Production_model->getProductionIngredients($id);
                $data['main_content'] = $this->load->view('production/editProduction', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save Production Ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveProductionIngredients($production_ingredients, $production_id, $table_name) {
        //This variable could not be escaped because this is array content
        foreach ($production_ingredients as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $_POST['ingredient_id'][$row];
            $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
            $fmi['status'] = $_POST['status'];
            $fmi['production_id'] = $production_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $id = $this->Common_model->insertInformation($fmi, "tbl_production_ingredients");

            $preparation_id = $_POST['ingredient_id'][$row];
            $food_menu_ingredients = $this->db->query("SELECT * FROM tbl_premade_ingredients WHERE pre_made_id=$preparation_id")->result();

            foreach($food_menu_ingredients as $single_ingredient){
                $inline_total = $single_ingredient->cost*$_POST['quantity_amount'][$row];
                $data_sale_consumptions_detail = array();
                $data_sale_consumptions_detail['ingredient_id'] = $single_ingredient->ingredient_id;
                $data_sale_consumptions_detail['consumption'] = $_POST['quantity_amount'][$row]*$single_ingredient->consumption;
                $data_sale_consumptions_detail['sale_consumption_id'] = $id;
                $data_sale_consumptions_detail['sales_id'] = '';
                $data_sale_consumptions_detail['cost'] = $inline_total;
                $data_sale_consumptions_detail['food_menu_id'] = '';
                $data_sale_consumptions_detail['production_id'] = $production_id;
                $data_sale_consumptions_detail['status'] =  $_POST['status'];
                $data_sale_consumptions_detail['user_id'] = $this->session->userdata('outlet_id');
                $data_sale_consumptions_detail['outlet_id'] = $this->session->userdata('outlet_id');
                $data_sale_consumptions_detail['del_status'] = 'Live';
                $this->db->insert('tbl_sale_consumptions_of_menus',$data_sale_consumptions_detail);
            }
        endforeach;
    }
     /**
     * production Details
     * @access public
     * @return void
     * @param int
     */
    public function productionDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['production_details'] = $this->Common_model->getDataById($id, "tbl_production");
        $data['production_ingredients'] = $this->Production_model->getProductionIngredients($id);
        $data['main_content'] = $this->load->view('production/productionDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * add New Supplier By Ajax
     * @access public
     * @return object
     * @param no
     */
    public function addNewSupplierByAjax() {
        $data['name'] = $_GET['name'];
        $data['contact_person'] = $_GET['contact_person'];
        $data['phone'] = $_GET['phone'];
        $data['email'] = $_GET['emailAddress'];
        $data['address'] = $_GET['supAddress'];
        $data['description'] = $_GET['description'];
        $data['user_id'] = $this->session->userdata('user_id');
        $data['company_id'] = $this->session->userdata('company_id');
        $this->db->insert('tbl_suppliers', $data);
        $supplier_id = $this->db->insert_id();
        $data1 = array('supplier_id' => $supplier_id);
        echo json_encode($data1);
    }
     /**
     * get Supplier List
     * @access public
     * @return void
     * @param no
     */
    public function getSupplierList() {
        $company_id = $this->session->userdata('company_id');
        $data1 = $this->db->query("SELECT * FROM tbl_suppliers 
              WHERE company_id=$company_id")->result();
        //generate html content for view
        echo '<option value="">Select</option>';
        foreach ($data1 as $value) {
            echo '<option value="' . $value->id . '" >' . $value->name . '</option>';
        }
        exit;
    }
}

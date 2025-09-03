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
  # This is Inventory_adjustment Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_adjustment extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('Inventory_adjustment_model');
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
        $controller = "131";
        $function = "";

        if($segment_2=="inventoryAdjustments"){
            $function = "view";
        }elseif(($segment_2=="addEditInventoryAdjustment") && $segment_3){
            $function = "update";
        }elseif($segment_2=="inventoryAdjustmentDetails" && $segment_3){
            $function = "view_details";
        }elseif($segment_2=="addEditInventoryAdjustment"){
            $function = "add";
        }elseif($segment_2=="deleteInventoryAdjustment"){
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
     * inventory Adjustments
     * @access public
     * @return void
     * @param no
     */
    public function inventoryAdjustments() {
        $outlet_id = $this->session->userdata('outlet_id');

        $data = array();
        $data['inventory_adjustments'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_inventory_adjustment");
        $data['main_content'] = $this->load->view('inventoryAdjustment/inventoryAdjustments', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Inventory Adjustment
     * @access public
     * @return void
     * @param int
     */
    public function deleteInventoryAdjustment($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_inventory_adjustment", "tbl_inventory_adjustment_ingredients", 'id', 'inventory_adjustment_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Inventory_adjustment/inventoryAdjustments');
    }
     /**
     * add/Edit Inventory Adjustment
     * @access public
     * @return void
     * @param int
     */
    public function addEditInventoryAdjustment($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('date',  lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('note',  lang('note'), 'max_length[200]');
            $this->form_validation->set_rules('employee_id',  lang('responsible_person'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $ia_info = array();
                $ia_info['reference_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $ia_info['date'] = date('Y-m-d', strtotime($this->input->post($this->security->xss_clean('date'))));
                $ia_info['note'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $ia_info['employee_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('employee_id')));
                $ia_info['user_id'] = $this->session->userdata('user_id');
                $ia_info['outlet_id'] = $this->session->userdata('outlet_id');
                if ($id == "") {
                    $inventory_adjustment_id = $this->Common_model->insertInformation($ia_info, "tbl_inventory_adjustment");
                    $this->saveInventoryAdjustmentIngredients($_POST['ingredient_id'], $inventory_adjustment_id, 'tbl_inventory_adjustment_ingredients');
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($ia_info, $id, "tbl_inventory_adjustment");
                    $this->Common_model->deletingMultipleFormData('inventory_adjustment_id', $id, 'tbl_inventory_adjustment_ingredients');
                    $this->saveInventoryAdjustmentIngredients($_POST['ingredient_id'], $id, 'tbl_inventory_adjustment_ingredients');
                    $this->session->set_flashdata('exception',  lang('update_success'));
                }

                redirect('Inventory_adjustment/inventoryAdjustments');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['reference_no'] = $this->Inventory_adjustment_model->generateReferenceNo($outlet_id);
                    $data['ingredients'] = $this->Inventory_adjustment_model->getIngredientList();
                    $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                    $data['main_content'] = $this->load->view('inventoryAdjustment/addInventoryAdjustment', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['ingredients'] = $this->Inventory_adjustment_model->getIngredientList();
                    $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                    $data['inventory_adjustment_details'] = $this->Common_model->getDataById($id, "tbl_inventory_adjustment");
                    $data['inventory_adjustment_ingredients'] = $this->Inventory_adjustment_model->getInventoryAdjustmentIngredients($id);
                    $data['main_content'] = $this->load->view('inventoryAdjustment/editInventoryAdjustment', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['reference_no'] = $this->Inventory_adjustment_model->generateReferenceNo($outlet_id);
                $data['ingredients'] = $this->Inventory_adjustment_model->getIngredientList();
                $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                $data['main_content'] = $this->load->view('inventoryAdjustment/addInventoryAdjustment', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['ingredients'] = $this->Inventory_adjustment_model->getIngredientList();
                $data['employees'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_users");
                $data['inventory_adjustment_details'] = $this->Common_model->getDataById($id, "tbl_inventory_adjustment");
                $data['inventory_adjustment_ingredients'] = $this->Inventory_adjustment_model->getInventoryAdjustmentIngredients($id);
                $data['main_content'] = $this->load->view('inventoryAdjustment/editInventoryAdjustment', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save Inventory Adjustment Ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveInventoryAdjustmentIngredients($inventory_adjustment_ingredients, $inventory_adjustment_id, $table_name) {
        foreach ($inventory_adjustment_ingredients as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption_amount'] = $_POST['consumption_amount'][$row];
            $fmi['consumption_status'] = $_POST['consumption_status'][$row];
            $fmi['inventory_adjustment_id'] = $inventory_adjustment_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $this->Common_model->insertInformation($fmi, "tbl_inventory_adjustment_ingredients");
        endforeach;
    }
     /**
     * inventory Adjustment Details
     * @access public
     * @return void
     * @param int
     */
    public function inventoryAdjustmentDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['inventory_adjustment_details'] = $this->Common_model->getDataById($id, "tbl_inventory_adjustment");
        $data['inventory_adjustment_ingredients'] = $this->Inventory_adjustment_model->getInventoryAdjustmentIngredients($id);
        $data['main_content'] = $this->load->view('inventoryAdjustment/inventoryAdjustmentDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}

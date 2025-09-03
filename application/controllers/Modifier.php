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
  # This is Modifier Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Master_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "223";
        $function = "";

        if($segment_2=="modifiers"){
            $function = "view";
        }elseif($segment_2=="addEditModifier" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditModifier"){
            $function = "add";
        }elseif($segment_2=="modifierDetails"){
            $function = "view_details";
        }elseif($segment_2=="deleteModifier"){
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
     * modifiers
     * @access public
     * @return void
     * @param no
     */
    public function modifiers() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['modifiers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_modifiers");
        $data['main_content'] = $this->load->view('master/modifier/modifiers', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Modifier
     * @access public
     * @return void
     * @param no
     */
    public function deleteModifier($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_modifiers");
        $this->Common_model->deletingMultipleFormData('modifier_id', $id, 'tbl_modifier_ingredients');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('modifier/modifiers');
    }
     /**
     * add/Edit Modifier
     * @access public
     * @return void
     * @param int
     */
    public function addEditModifier($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $tax_information = array();
            $tax_string ='';
            if(!empty($_POST['tax_field_percentage'])){
                foreach($this->input->post('tax_field_percentage') as $key=>$value){
                    $single_info = array(
                        'tax_field_id' => $this->input->post('tax_field_id')[$key],
                        'tax_field_company_id' => $this->input->post('tax_field_company_id')[$key],
                        'tax_field_name' => $this->input->post('tax_field_name')[$key],
                        'tax_field_percentage' => ($this->input->post('tax_field_percentage')[$key]=="")?0:$this->input->post('tax_field_percentage')[$key]
                    );
                    $tax_string.=($this->input->post('tax_field_name')[$key]).":";
                    array_push($tax_information,$single_info);
                }
            }
            $tax_information = json_encode($tax_information);

            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[200]');
            $this->form_validation->set_rules('price', lang('price'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {

                $modifier_info = array();
                $modifier_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $modifier_info['description'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $modifier_info['price'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('price')));
                $modifier_info['user_id'] = $this->session->userdata('user_id');
                $modifier_info['company_id'] = $this->session->userdata('company_id');
                $modifier_info['tax_information'] = $tax_information;
                $modifier_info['tax_string'] = $tax_string;
                $modifier_info['total_cost'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total_cost')));
                if ($id == "") {
                    $modifier_id = $this->Common_model->insertInformation($modifier_info, "tbl_modifiers");
                    $this->saveModifierIngredients($_POST['ingredient_id'], $modifier_id, 'tbl_modifier_ingredients');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($modifier_info, $id, "tbl_modifiers");
                    $this->Common_model->deletingMultipleFormData('modifier_id', $id, 'tbl_modifier_ingredients');
                    $this->saveModifierIngredients($_POST['ingredient_id'], $id, 'tbl_modifier_ingredients');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('modifier/modifiers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/modifier/addModifier', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['modifier_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
                    $data['modifier_ingredients'] = $this->Master_model->getModifierIngredients($data['modifier_details']->id);
                    $data['main_content'] = $this->load->view('master/modifier/editModifier', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['main_content'] = $this->load->view('master/modifier/addModifier', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['modifier_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
                $data['modifier_ingredients'] = $this->Master_model->getModifierIngredients($data['modifier_details']->id);
                $data['main_content'] = $this->load->view('master/modifier/editModifier', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save Modifier Ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveModifierIngredients($modifier_ingredients, $modifier_id_id, $table_name) {
        foreach ($modifier_ingredients as $row => $ingredient_id):
            $fmi = array();
            $fmi['ingredient_id'] = $ingredient_id;
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['consumption'] = $_POST['consumption'][$row];
            $fmi['cost'] = $_POST['cost'][$row];
            $fmi['total'] = $_POST['total_cost'][$row];
            $fmi['modifier_id'] = $modifier_id_id;
            $fmi['user_id'] = $this->session->userdata('user_id');
            $fmi['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmi, "tbl_modifier_ingredients");
        endforeach;
    }
     /**
     * modifier Details
     * @access public
     * @return void
     * @param int
     */
    public function modifierDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_modifiers");
        $data['main_content'] = $this->load->view('master/modifier/modifierDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }

}

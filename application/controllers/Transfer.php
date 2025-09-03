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
  # This is Transfer Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Transfer_model');
        $this->load->model('Sale_model');
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
        $controller = "112";
        $function = "";

        if($segment_2=="transfers"){
            $function = "view";
        }elseif($segment_2=="addEditTransfer" && $segment_3){
            $function = "update";
        }elseif($segment_2=="transferDetails" && $segment_3){
            $function = "view_details";
        }elseif($segment_2=="addEditTransfer"){
            $function = "add";
        }elseif($segment_2=="deleteTransfer"){
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
     * transfers info
     * @access public
     * @return void
     * @param no
     */
    public function transfers() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['transfers'] = $this->Transfer_model->getAllTrasferData($outlet_id);
        $data['main_content'] = $this->load->view('transfer/transfers', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Transfer
     * @access public
     * @return void
     * @param int
     */
    public function deleteTransfer($id) {
        $role = $this->session->userdata('role');
        if($role=="Admin"){
            $id = $this->custom->encrypt_decrypt($id, 'decrypt');
            $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_transfer", "tbl_transfer_ingredients", 'id', 'transfer_id');
            $this->session->set_flashdata('exception', lang('delete_success'));
        }else{
            $this->session->set_flashdata('exception_error', lang('error_transfer'));
        }
        redirect('Transfer/transfers');
    }
     /**
     * add/Edit Transfer
     * @access public
     * @return void
     * @param int
     */
    public function addEditTransfer($encrypted_id = "") {


        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        $transfer_info = array();

        if ($id == "") {
            $transfer_info['reference_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
        } else {
            $transfer_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_transfer")->reference_no;
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            if ($id == "") {
                $this->form_validation->set_rules('to_outlet_id', lang('to_outlet'), 'required|max_length[50]');
            }
            $this->form_validation->set_rules('status', "Status", 'required');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $transfer_info['reference_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $transfer_info['date'] = date('Y-m-d', strtotime($this->input->post($this->security->xss_clean('date'))));
                $transfer_info['note_for_sender'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note_for_sender')));
                $transfer_info['note_for_receiver'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note_for_receiver')));
                $transfer_info['status'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $transfer_info['transfer_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('transfer_type')));
                $transfer_info['user_id'] = $this->session->userdata('user_id');
                if($this->input->post($this->security->xss_clean('received_date'))){
                    $transfer_info['received_date'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('received_date')));
                }
                if ($id == "") {
                    $transfer_info['from_outlet_id'] = $this->session->userdata('outlet_id');
                    $transfer_info['to_outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('to_outlet_id')));
                    $transfer_info['outlet_id'] = $this->session->userdata('outlet_id');

                    $transfer_id = $this->Common_model->insertInformation($transfer_info, "tbl_transfer");
                    /*This all variables could not be escaped because this is an array field*/
                    $this->saveTransferIngredients($_POST['ingredient_id'], $transfer_id, $this->session->userdata('outlet_id'),$transfer_info['to_outlet_id'],$transfer_info['status'],'');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $transfer_details = $this->Common_model->getDataById($id, "tbl_transfer");
                    $outlet_id = $this->session->userdata('outlet_id');
                    if($outlet_id!=$transfer_details->to_outlet_id  && $outlet_id==$transfer_details->outlet_id){
                        $transfer_info['from_outlet_id'] = $this->session->userdata('outlet_id');
                        $transfer_info['to_outlet_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('to_outlet_id')));
                        $transfer_info['outlet_id'] = $this->session->userdata('outlet_id');
                    }
                    $this->Common_model->updateInformation($transfer_info, $id, "tbl_transfer");
                    $this->Common_model->deletingMultipleFormData('transfer_id', $id, 'tbl_transfer_ingredients');
                    $this->Common_model->deletingMultipleFormData('transfer_id', $id, 'tbl_transfer_received_ingredients');
                    /*This variable could not be escaped because this is an array field*/
                    $this->saveTransferIngredients($_POST['ingredient_id'], $id, $transfer_details->outlet_id,$transfer_info['to_outlet_id'],$transfer_info['status'],$transfer_details->to_outlet_id);
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('Transfer/transfers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['pur_ref_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
                    $data['ingredients'] = $this->Transfer_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                    $data['food_menus'] = $this->Common_model->getAllByTable("tbl_food_menus");

                    foreach ($data['food_menus'] as $key=>$value){
                        $total = 0;
                        $all_ings = $this->Transfer_model->getTotalCostAmount($value->id);
                        foreach ($all_ings as $vl){
                            $last_purchase_price = getLastPurchaseAmount($vl->ingredient_id);
                            $conversion_rate = 1;
                            if($vl->conversion_rate){
                                $conversion_rate =  $vl->conversion_rate;
                            }
                            $inline_total = ($last_purchase_price/$conversion_rate)*$vl->consumption;
                            $total+=$inline_total;
                        }
                           if ($this->session->userdata('collect_tax')=='Yes'){
                                $total_return_amount = getTaxAmount($value->sale_price,$value->tax_information);
                            }else{
                                $total_return_amount = 0;
                            }

                        $data['food_menus'][$key]->ings_total_cost = $total;
                        $data['food_menus'][$key]->total_tax = $total_return_amount;
                    }
                    $data['main_content'] = $this->load->view('transfer/addTransfer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
                    $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
                    $data['ingredients'] = $this->Transfer_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['food_menus'] = $this->Common_model->getAllByTable("tbl_food_menus");

                    foreach ($data['food_menus'] as $key=>$value){
                        $total = 0;
                        $all_ings = $this->Transfer_model->getTotalCostAmount($value->id);
                        foreach ($all_ings as $vl){
                            $last_purchase_price = getLastPurchaseAmount($vl->ingredient_id);
                            $conversion_rate = 1;
                            if($vl->conversion_rate){
                                $conversion_rate =  $vl->conversion_rate;
                            }
                            $inline_total = ($last_purchase_price/$conversion_rate)*$vl->consumption;
                            $total+=$inline_total;
                        }
                           if ($this->session->userdata('collect_tax')=='Yes'){
                                $total_return_amount = getTaxAmount($value->sale_price,$value->tax_information);
                            }else{
                                $total_return_amount = 0;
                            }

                        $data['food_menus'][$key]->ings_total_cost = $total;
                        $data['food_menus'][$key]->total_tax = $total_return_amount;
                    }
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                    $data['main_content'] = $this->load->view('transfer/editTransfer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['pur_ref_no'] = $this->Transfer_model->generatePurRefNo($outlet_id);
                $data['ingredients'] = $this->Transfer_model->getIngredientListWithUnitAndPrice($company_id);
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                $data['food_menus'] = $this->Common_model->getAllByTable("tbl_food_menus");

                foreach ($data['food_menus'] as $key=>$value){
                    $total = 0;
                    $all_ings = $this->Transfer_model->getTotalCostAmount($value->id);
                    foreach ($all_ings as $vl){
                        $last_purchase_price = getLastPurchaseAmount($vl->ingredient_id);
                        $conversion_rate = 1;
                        if($vl->conversion_rate){
                            $conversion_rate =  $vl->conversion_rate;
                        }
                        $inline_total = ($last_purchase_price/$conversion_rate)*$vl->consumption;
                        $total+=$inline_total;
                    }
                    if ($this->session->userdata('collect_tax')=='Yes'){
                        $total_return_amount = getTaxAmount($value->sale_price,$value->tax_information);
                    }else{
                        $total_return_amount = 0;
                    }
                    $data['food_menus'][$key]->ings_total_cost = $total;
                    $data['food_menus'][$key]->total_tax = $total_return_amount;
                }
                $data['main_content'] = $this->load->view('transfer/addTransfer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
                $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
                $data['ingredients'] = $this->Transfer_model->getIngredientListWithUnitAndPrice($company_id);
                $data['food_menus'] = $this->Common_model->getAllByTable("tbl_food_menus");
                foreach ($data['food_menus'] as $key=>$value){
                    $total = 0;
                    $all_ings = $this->Transfer_model->getTotalCostAmount($value->id);
                    foreach ($all_ings as $vl){
                        $last_purchase_price = getLastPurchaseAmount($vl->ingredient_id);
                        $conversion_rate = 1;
                        if($vl->conversion_rate){
                            $conversion_rate =  $vl->conversion_rate;
                        }
                        $inline_total = ($last_purchase_price/$conversion_rate)*$vl->consumption;
                        $total+=$inline_total;
                    }
                    if ($this->session->userdata('collect_tax')=='Yes'){
                        $total_return_amount = getTaxAmount($value->sale_price,$value->tax_information);
                    }else{
                        $total_return_amount = 0;
                    }

                    $data['food_menus'][$key]->ings_total_cost = $total;
                    $data['food_menus'][$key]->total_tax = $total_return_amount;
                }
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                $data['main_content'] = $this->load->view('transfer/editTransfer', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save Transfer Ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveTransferIngredients($transfer_ingredients, $transfer_id, $from_outlet,$to_outlet,$status,$to_outlet_id='') {
        foreach ($transfer_ingredients as $row => $ingredient_id):
            $data_sale_consumptions_detail = array();
            $data_sale_consumptions_detail['status'] = $status;
            /*This all variables could not be escaped because this is an array field*/
            $data_sale_consumptions_detail['ingredient_id'] = $_POST['ingredient_id'][$row];
            $data_sale_consumptions_detail['quantity_amount'] = $_POST['quantity_amount'][$row];
            $data_sale_consumptions_detail['total_cost'] = isset($_POST['total_cost'][$row]) && $_POST['total_cost'][$row]?$_POST['total_cost'][$row]:0;
            $data_sale_consumptions_detail['single_cost_total'] = isset($_POST['single_cost_total'][$row]) && $_POST['single_cost_total'][$row]?$_POST['single_cost_total'][$row]:0;
            $data_sale_consumptions_detail['total_sale_amount'] = isset($_POST['total_sale_amount'][$row]) && $_POST['total_sale_amount'][$row]?$_POST['total_sale_amount'][$row]:0;
            $data_sale_consumptions_detail['total_tax'] = isset($_POST['total_tax'][$row]) && $_POST['total_tax'][$row]?$_POST['total_tax'][$row]:0;
            $data_sale_consumptions_detail['single_total_sale_amount'] = isset($_POST['single_total_sale_amount'][$row]) && $_POST['single_total_sale_amount'][$row]?$_POST['single_total_sale_amount'][$row]:0;
            $data_sale_consumptions_detail['single_total_tax'] = isset($_POST['single_total_tax'][$row]) && $_POST['single_total_tax'][$row]?$_POST['single_total_tax'][$row]:0;
            $data_sale_consumptions_detail['transfer_id'] = $transfer_id;
            $data_sale_consumptions_detail['from_outlet_id'] = $from_outlet;
            $data_sale_consumptions_detail['transfer_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('transfer_type')));
            if($to_outlet_id!=''){
                $data_sale_consumptions_detail['to_outlet_id'] = $to_outlet_id;
            }else{
                $data_sale_consumptions_detail['to_outlet_id'] = $to_outlet;
            }
            $data_sale_consumptions_detail['del_status'] = 'Live';

            $this->db->insert('tbl_transfer_ingredients',$data_sale_consumptions_detail);
        endforeach;

    }
     /**
     * transfer Details
     * @access public
     * @return void
     * @param int
     */
    public function transferDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['transfer_details'] = $this->Common_model->getDataById($id, "tbl_transfer");
        $data['food_details'] = $this->Transfer_model->getFoodDetails($id);
        $data['main_content'] = $this->load->view('transfer/transferDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}

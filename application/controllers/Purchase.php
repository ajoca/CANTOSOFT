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
  # This is Purchase Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Cl_Controller {

    public function __construct() {
        parent::__construct();
         

        $this->load->model('Authentication_model');
        $this->load->model('Purchase_model');
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
        $controller = "106";
        $function = "";

        if($segment_2=="purchases" || $segment_2=="barcode"){
            $function = "view";
        }elseif(($segment_2=="addEditPurchase" || $segment_2=="getSupplierList" || $segment_2=="addNewSupplierByAjax") && $segment_3){
            $function = "update";
        }elseif($segment_2=="purchaseDetails" && $segment_3){
            $function = "view_details";
        }elseif($segment_2=="addEditPurchase" || $segment_2=="getSupplierList" || $segment_2=="addNewSupplierByAjax"){
            $function = "add";
        }elseif($segment_2=="deletePurchase"){
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
     * purchases info
     * @access public
     * @return void
     * @param no
     */
    public function purchases() {
        $outlet_id = $this->session->userdata('outlet_id');
        $data = array();
        $data['purchases'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_purchase");
        $data['main_content'] = $this->load->view('purchase/purchases', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete Purchase
     * @access public
     * @return void
     * @param int
     */
    public function barcode($id='') {
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $food_menu_id = $this->input->post($this->security->xss_clean('food_menu_id'));
            $qty = $this->input->post($this->security->xss_clean('qty'));
            $expire_date = $this->input->post($this->security->xss_clean('expire_date'));
            $barcode_width = $this->input->post($this->security->xss_clean('barcode_width'));
            $barcode_height = $this->input->post($this->security->xss_clean('barcode_height'));
            $arr = array();
            if($food_menu_id){
                for ($i=0;$i<sizeof($food_menu_id);$i++){
                    $value = explode("|",$food_menu_id[$i]);
                    $arr[] = array(
                        'id' => $value[0],
                        'item_name' => $value[1],
                        'code' => $value[2],
                        'qty' => $qty[$i],
                        'expire_date' => $value[3]
                    );
                }
            }
            $data = array();
            $data['id'] = $id;
            $data['items'] = $arr;
            $data['barcode_width'] = $barcode_width;
            $data['barcode_height'] = $barcode_height;
            $data['main_content'] = $this->load->view('purchase/barcode_preview', $data, TRUE);
            $this->load->view('userHome', $data);
        } else {
            $data = array();
            $data['id'] = $id;
            $data['purchase_ingredients'] = $this->Purchase_model->getPurchaseIngredients($id);
            $data['main_content'] = $this->load->view('purchase/BarcodeGenerator', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
    public function deletePurchase($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_purchase", "tbl_purchase_ingredients", 'id', 'purchase_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('Purchase/purchases');
    }
     /**
     * add/Edit Purchase
     * @access public
     * @return void
     * @param int
     */
    public function addEditPurchase($encrypted_id = "") {

        //check register is open or not
        $is_waiter = $this->session->userdata('is_waiter');
        $designation = $this->session->userdata('designation');
        if($designation!="Waiter" && $this->session->has_userdata('is_online_order')!="Yes" && !isFoodCourt()){
            $user_id = $this->session->userdata('user_id');
            $outlet_id = $this->session->userdata('outlet_id');
            if($this->Common_model->isOpenRegister($user_id,$outlet_id)==0){
                $this->session->set_flashdata('exception_3', lang('register_open_msg'));
                if($this->uri->segment(2)=='registerDetailCalculationToShowAjax' || $this->uri->segment(2)=='closeRegister'){
                    redirect('Register/openRegister');
                }else{
                    $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
                    $this->session->set_userdata("clicked_method", $this->uri->segment(2));
                    redirect('Register/openRegister');
                }

            }
        }

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $outlet_id = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');

        $purchase_info = array();

        if ($id == "") {
            $purchase_info['reference_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
        } else {
            $purchase_info['reference_no'] = $this->Common_model->getDataById($id, "tbl_purchase")->reference_no;
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('reference_no', lang('ref_no'), 'required|max_length[50]');
            $this->form_validation->set_rules('supplier_id', lang('supplier'), 'required|max_length[50]');
            $this->form_validation->set_rules('date', lang('date'), 'required|max_length[50]');
            $this->form_validation->set_rules('note', lang('note'), 'max_length[200]');
            $this->form_validation->set_rules('paid', lang('paid_amount'), 'required|numeric|max_length[50]');
            $this->form_validation->set_rules('payment_id', lang('payment_method'), 'required|numeric|max_length[50]');
           

            if ($this->form_validation->run() == TRUE) {
                $purchase_info['reference_no'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
                $purchase_info['supplier_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('supplier_id')));
                $purchase_info['date'] = date('Y-m-d', strtotime($this->input->post($this->security->xss_clean('date'))));
                $purchase_info['note'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('note')));
                $purchase_info['grand_total'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('grand_total')));
                $purchase_info['paid'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('paid')));
                $purchase_info['due'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('due')));
                $purchase_info['payment_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('payment_id')));
                $purchase_info['counter_id'] = $this->session->userdata('counter_id');
                $purchase_info['user_id'] = $this->session->userdata('user_id');
                $purchase_info['outlet_id'] = $this->session->userdata('outlet_id');
                
                if ($id == "") {
                    $purchase_info['added_date_time'] = date('Y-m-d H:i:s');
                    $purchase_id = $this->Common_model->insertInformation($purchase_info, "tbl_purchase");
                    $this->savePurchaseIngredients($_POST['ingredient_id'], $purchase_id, 'tbl_purchase_ingredients');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($purchase_info, $id, "tbl_purchase");
                    $this->Common_model->deletingMultipleFormData('purchase_id', $id, 'tbl_purchase_ingredients');
                    $this->savePurchaseIngredients($_POST['ingredient_id'], $id, 'tbl_purchase_ingredients');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }

                redirect('Purchase/purchases');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['pur_ref_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
                    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                    $data['ingredients'] = $this->Purchase_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['main_content'] = $this->load->view('purchase/addPurchase', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                    $data['encrypted_id'] = $encrypted_id;
                    $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
                    $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                    $data['ingredients'] = $this->Purchase_model->getIngredientListWithUnitAndPrice($company_id);
                    $data['purchase_ingredients'] = $this->Purchase_model->getPurchaseIngredients($id);
                    $data['main_content'] = $this->load->view('purchase/editPurchase', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['pur_ref_no'] = $this->Purchase_model->generatePurRefNo($outlet_id);
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                $data['ingredients'] = $this->Purchase_model->getIngredientListWithUnitAndPrice($company_id);
                $data['main_content'] = $this->load->view('purchase/addPurchase', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['payment_methods'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_payment_methods");
                $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
                $data['suppliers'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_suppliers');
                $data['ingredients'] = $this->Purchase_model->getIngredientListWithUnitAndPrice($company_id);
                $data['purchase_ingredients'] = $this->Purchase_model->getPurchaseIngredients($id);
                $data['main_content'] = $this->load->view('purchase/editPurchase', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save Purchase Ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function savePurchaseIngredients($purchase_ingredients, $purchase_id, $table_name) {
        //This variable could not be escaped because this is array content
        foreach ($purchase_ingredients as $row => $ingredient_id):
            $ingredient = getIngredient($_POST['ingredient_id'][$row]);
            $conversion_rate = isset($ingredient->conversion_rate) && $ingredient->conversion_rate?$ingredient->conversion_rate:1;
            $inline_cost = ($_POST['unit_price'][$row]/$conversion_rate);
            $fmi = array();
            $fmi['ingredient_id'] = $_POST['ingredient_id'][$row];
            $fmi['unit_price'] = $_POST['unit_price'][$row];
            $fmi['quantity_amount'] = $_POST['quantity_amount'][$row];
            $fmi['total'] = $_POST['total'][$row];
            $fmi['cost_per_unit'] = getAmtP($inline_cost);
            $fmi['purchase_id'] = $purchase_id;
            $fmi['outlet_id'] = $this->session->userdata('outlet_id');
            $this->Common_model->insertInformation($fmi, "tbl_purchase_ingredients");
            //set average cost for profit loss report
            setAverageCost($_POST['ingredient_id'][$row]);
            //update ingredenits purchase amount
            $data = array();
            $data['consumption_unit_cost'] = $inline_cost;
            $data['purchase_price'] = $fmi['unit_price'];
            $this->db->where('id', $fmi['ingredient_id']);
            $this->db->update("tbl_ingredients", $data);
            
            updatedFoodCost($_POST['ingredient_id'][$row]);
        endforeach;
    }
     /**
     * purchase Details
     * @access public
     * @return void
     * @param int
     */
    public function purchaseDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['purchase_details'] = $this->Common_model->getDataById($id, "tbl_purchase");
        $data['purchase_ingredients'] = $this->Purchase_model->getPurchaseIngredients($id);
        $data['main_content'] = $this->load->view('purchase/purchaseDetails', $data, TRUE);
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

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
  # This is PreMadeFood Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PreMadeFood extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('excel'); //load PHPExcel library
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
        $controller = "325";
        $function = "";

        if($segment_2=="preMadeFoods"){
            $function = "view";
        }elseif($segment_2=="addEditPreMadeFood" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditPreMadeFood"){
            $function = "add";
        }elseif($segment_2=="deletePreMadeFood"){
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
     * food menu info
     * @access public
     * @return void
     * @param no
     */
    public function preMadeFoods() {
        $company_id = $this->session->userdata('company_id');

        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('category_id', lang('category'), 'required|max_length[50]');
            if ($this->form_validation->run() == TRUE) {
                $category_id =htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $data = array();
                $data['ingredients'] = $this->Common_model->getPreMadeIngredients($company_id, "Pre-made Item");
                $data['preMadeFoodCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/preMadeFood/preMadeFoods', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();

                $data['ingredients'] = $this->Common_model->getPreMadeIngredients($company_id, "Pre-made Item");
                $data['preMadeFoodCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
                $data['main_content'] = $this->load->view('master/preMadeFood/preMadeFoods', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['ingredients'] = $this->Common_model->getPreMadeIngredients($company_id, "Pre-made Item");
            $data['preMadeFoodCategories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_food_menu_categories");
            $data['main_content'] = $this->load->view('master/preMadeFood/preMadeFoods', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }
     /**
     * delete food menu
     * @access public
     * @return void
     * @param int
     */
    public function deletePreMadeFood($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChangeWithChild($id, $id, "tbl_ingredients", "tbl_premade_ingredients", 'id', 'pre_made_id');
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('preMadeFood/preMadeFoods');
    }
     /**
     * add/edit food menu
     * @access public
     * @return void
     * @param int
     */
    public function addEditPreMadeFood($encrypted_id = "") {

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        if($outlet_id==""){
            $this->session->set_flashdata('exception_1', 'Select an outlet');
            redirect('Outlet/outlets');
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name', lang('name'), 'required|max_length[50]');
            $this->form_validation->set_rules('category_id', lang('category'), 'required');
            $this->form_validation->set_rules('purchase_price', lang('purchase_price'), 'required|numeric|max_length[15]');
            $this->form_validation->set_rules('alert_quantity',lang('alert_quantity'), 'required|numeric|max_length[15]');
            $this->form_validation->set_rules('code',lang('unit'), 'required');
            $unit_type = $_POST['unit_type'];
            $this->form_validation->set_rules('consumption_unit_id',lang('unit'), 'required');

            if($unit_type==2){
                $this->form_validation->set_rules('conversion_rate',lang('unit'), 'required');
            }
            if ($this->form_validation->run() == TRUE) {
                $fmc_info = array();
                $fmc_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $fmc_info['code'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('code')));
                $fmc_info['category_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('category_id')));
                $fmc_info['purchase_price'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('purchase_price')));
                $fmc_info['alert_quantity'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('alert_quantity')));
                $fmc_info['unit_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('consumption_unit_id')));
                $fmc_info['purchase_unit_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('purchase_unit_id')));
                $fmc_info['consumption_unit_cost'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('consumption_unit_cost')));
                $fmc_info['average_consumption_per_unit'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('consumption_unit_cost')));
                $fmc_info['conversion_rate'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('conversion_rate')));
                $fmc_info['unit_type'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('unit_type')));
                $fmc_info['ing_type'] = "Pre-made Item";
                $fmc_info['user_id'] = $this->session->userdata('user_id');
                $fmc_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $id = $this->Common_model->insertInformation($fmc_info, "tbl_ingredients");
                    $this->saveFoodMenusIngredients($_POST['ingredient_id'], $id, 'tbl_premade_ingredients');
                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($fmc_info, $id, "tbl_ingredients");
                    $this->Common_model->deletingMultipleFormData('pre_made_id', $id, 'tbl_premade_ingredients');
                    $this->saveFoodMenusIngredients($_POST['ingredient_id'], $id, 'tbl_premade_ingredients');
                    $this->session->set_flashdata('exception',lang('update_success'));
                }
                redirect('preMadeFood/preMadeFoods');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['units'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_units');
                    $outlet_id = $this->session->userdata('outlet_id');
                    $data['storages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
                    $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                    $data['autoCode'] = $this->Master_model->generateIngredientCode();
                    $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                    $data['main_content'] = $this->load->view('master/preMadeFood/addPreMadeFood', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['units'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_units');
                    $outlet_id = $this->session->userdata('outlet_id');
                    $data['storages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
                    $data['encrypted_id'] = $encrypted_id;
                    $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                    $data['autoCode'] = $this->Master_model->generateIngredientCode();
                    $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                    $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_ingredients");
                    $data['food_menu_ingredients'] = $this->Master_model->getPremadeIngredients($data['food_menu_details']->id);
                    $data['main_content'] = $this->load->view('master/preMadeFood/editPreMadeFood', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['units'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_units');
                $outlet_id = $this->session->userdata('outlet_id');
                $data['storages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
                $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                $data['autoCode'] = $this->Master_model->generateIngredientCode();
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);

                $data['main_content'] = $this->load->view('master/preMadeFood/addPreMadeFood', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $outlet_id = $this->session->userdata('outlet_id');
                $data['storages'] = $this->Common_model->getAllByOutletId($outlet_id, "tbl_kitchens");
                $data['encrypted_id'] = $encrypted_id;
                $data['units'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_units');
                $data['categories'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, 'tbl_ingredient_categories');
                $data['ingredients'] = $this->Master_model->getIngredientListWithUnit($company_id);
                $data['autoCode'] = $this->Master_model->generateIngredientCode();
                $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_ingredients");
                $data['food_menu_ingredients'] = $this->Master_model->getPremadeIngredients($data['food_menu_details']->id);
                $data['main_content'] = $this->load->view('master/preMadeFood/editPreMadeFood', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * fix food menu
     * @access public
     * @return void
     * @param no
     */
    public function fixFoodMenus(){
        $result = $this->db->query("SELECT * FROM tbl_pre_made_foods")->result();
        foreach ($result as $key => $value) {
            $this->db->set('veg_item', "Veg No");
            $this->db->set('beverage_item', "Beverage No");
            $this->db->update('tbl_pre_made_foods');
            $this->db->where('id', $value->id);
        }
    }


     /**
     * validate photo
     * @access public
     * @return string
     * @param no
     */
    public function validate_photo() {

        if ($_FILES['photo']['name'] != "") {
            $config['upload_path'] = './images';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['maintain_ratio'] = TRUE;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("photo")) {
                $upload_info = $this->upload->data();
                $photo = $upload_info['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/'.$photo;
                // $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 100;

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();
                $this->session->set_userdata('photo', $upload_info['file_name']);

            } else {
                $this->form_validation->set_message('validate_photo', $this->upload->display_errors());
                return FALSE;
            }
        }
    }
     /**
     * save food menus ingredients
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveFoodMenusIngredients($food_menu_ingredients, $food_menu_id, $table_name) {
        if(isset($food_menu_ingredients) && $food_menu_ingredients){
            foreach ($food_menu_ingredients as $row => $ingredient_id):
                $fmi = array();
                $fmi['ingredient_id'] = $ingredient_id;
                $fmi['consumption'] = $_POST['consumption'][$row];
                $fmi['cost'] = $_POST['cost'][$row];
                $fmi['total'] = $_POST['total_cost'][$row];
                $fmi['pre_made_id'] = $food_menu_id;
                $fmi['user_id'] = $this->session->userdata('user_id');
                $fmi['company_id'] = $this->session->userdata('company_id');
                $this->Common_model->insertInformation($fmi, "tbl_premade_ingredients");

            endforeach;
        }

    }
     /**
     * save Food Menus Modifiers
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
    public function saveFoodMenusModifiers($food_menu_modifiers, $food_menu_id, $table_name) {
        foreach ($food_menu_modifiers as $row => $modifier_id):
            $fmm = array();
            $fmm['modifier_id'] = $modifier_id;
            $fmm['food_menu_id'] = $food_menu_id;
            $fmm['user_id'] = $this->session->userdata('user_id');
            $fmm['company_id'] = $this->session->userdata('company_id');
            $this->Common_model->insertInformation($fmm, "tbl_food_menus_modifiers");
        endforeach;
    }
     /**
     * upload Food Menu
     * @access public
     * @return void
     * @param no
     */

     /**
     * food Menu Details
     * @access public
     * @return void
     * @param int
     */
    public function preMadeFoodDetails($id) {
        $encrypted_id = $id;
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $data = array();
        $data['encrypted_id'] = $encrypted_id;
        $data['food_menu_details'] = $this->Common_model->getDataById($id, "tbl_pre_made_foods");
        $data['main_content'] = $this->load->view('master/preMadeFood/preMadeFoodDetails', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * get food menu category by name
     * @access public
     * @return int
     * @param string
     */
    public function get_foodmenu_ct_id_byname($category) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_food_menu_categories WHERE company_id=$company_id and user_id=$user_id and category_name='" . $category . "' and del_status='Live'")->row('id');
        if ($id != '') {
            return $id;
        } else {
            $data = array('category_name' => $category, 'company_id' => $company_id, 'user_id' => $user_id);
            $query = $this->db->insert('tbl_food_menu_categories', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }
     /**
     * get food menu vat id by name
     * @access public
     * @return int
     * @param string
     * @param float
     */
    public function get_foodmenu_vat_id_byname($vat_name, $vat_percent) {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        $id = $this->db->query("SELECT id FROM tbl_vats WHERE company_id=$company_id and name='" . $vat_name . "'")->row('id');
        if ($id) {
            return $id;
        } else {
            $data = array('name' => $vat_name, 'company_id' => $company_id, 'percentage' => $vat_percent);
            $query = $this->db->insert('tbl_vats', $data);
            $id = $this->db->insert_id();
            return $id;
        }
    }
     /**
     * upload Food Menu Ingredients
     * @access public
     * @return void
     * @param no
     */
    public function uploadFoodMenuIngredients() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['main_content'] = $this->load->view('master/preMadeFood/uploadspreMadeFoodsIngredients', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * Excel Data Add Food menus Ingredients
     * @access public
     * @return void
     * @param no
     */
    public function ExcelDataAddFoodmenusIngredients()
    {
        $company_id = $this->session->userdata('company_id');
        $user_id = $this->session->userdata('user_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Food_Menu_Ingredients_Upload.xlsx") {
                //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)
                $configUpload['upload_path'] = FCPATH . 'asset/excel/';
                $configUpload['allowed_types'] = 'xls|xlsx';
                $configUpload['max_size'] = '5000';
                $this->load->library('upload', $configUpload);
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    $file_name = $upload_data['file_name']; //uploded file name
                    $extension = $upload_data['file_ext'];    // uploded file extension
                    //$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // For excel 2007
                    //Set to read only
                    $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
                    $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                    //loop from first data untill last data
                    $totalFoodMenuToUpload = 0;

                    if ($totalrows > 2) {
                        $arrayerror = '';
                        for ($i = 3; $i <= $totalrows; $i++) {
                            $menuOrIngredient = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            //it counts total number of food menus
                            if($menuOrIngredient=='FM'){
                                $totalFoodMenuToUpload++;
                            }
                        }
                        if($totalFoodMenuToUpload<10){
                            for ($i = 3; $i <= $totalrows; $i++) {
                                $menuOrIngredient = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $menuOrIngredientName = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $consumption = null;

                                $currentRowFor = ''; //it hold current row wether menu or ingredient
                                //it counts total number of food menus
                                if($menuOrIngredient=='FM'){
                                    $totalFoodMenuToUpload++;
                                    $record = $this->Common_model->getMenuByMenuName($menuOrIngredientName);
                                    $currentRowFor = 'Menu';
                                }else{
                                    $consumption = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                    $record = $this->Common_model->getIngredientByIngredientName($menuOrIngredientName);
                                    $currentRowFor = 'Ingredient';
                                }

                                //get next menu or ingredient
                                $isNextMenuOrIngredient = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i+1)->getValue()));

                                // if any record is not found then set this message
                                if ($record==NULL) {
                                    if ($arrayerror == '') {
                                        $arrayerror.="Row Number $i column B required & must be valid menu or ingredient name";
                                    } else {
                                        $arrayerror.="<br>Row Number $i column B required & must be valid menu or ingredient name";
                                    }
                                }


                                // //it sets message when it's not menu and ingredient as well
                                if ($menuOrIngredient!="FM" && $menuOrIngredient!="IG") {
                                    if ($arrayerror == '') {
                                        $arrayerror.="Row Number $i column A required & must be 'FM' or 'IG'";
                                    } else {
                                        $arrayerror.="<br>Row Number $i column A required & must be 'FM' or 'IG'";
                                    }
                                }

                                if ($menuOrIngredient == 'IG' && ($consumption == null || $consumption == '' || !is_numeric($consumption))) {
                                    if ($arrayerror == '') {
                                        $arrayerror.=" $i Row Number column C required, it must be numeric";
                                    } else {
                                        $arrayerror.="<br> $i Row Number column C required, it must be numeric";
                                    }
                                }

                                //it sets message when food menu number is greater than 10
                                if ($totalFoodMenuToUpload>10) {
                                    if ($arrayerror == '') {
                                        $arrayerror.="You can not upload more than 10 food menus at a time.";
                                    } else {
                                        $arrayerror.="<br>You can not upload more than 10 food menus at a time.";
                                    }
                                }

                                //it checks next one is food menu or ingredient. if current one is food menu and next one
                                //is food menu then it means current food menu doesn't have ingredients
                                if($menuOrIngredient=='FM' && $isNextMenuOrIngredient=='FM'){
                                    if ($arrayerror == '') {
                                        $arrayerror.="row number $i is a Food Menu, no ingredient found for $menuOrIngredientName";
                                    } else {
                                        $arrayerror.="<br>row number $i is a Food Menu, no ingredient found for $menuOrIngredientName";
                                    }
                                }
                            }
                            if ($arrayerror == '') {
                                if(!is_null($this->input->post('remove_previous'))){
                                    $this->db->query("TRUNCATE table `tbl_food_menus_ingredients`");
                                }
                                for ($i = 3; $i <= $totalrows; $i++) {
                                    $menuOrIngredient = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                    $menuOrIngredientName = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                    $consumption = null;
                                    if($menuOrIngredient=='FM'){
                                        $food_menu_record = $this->Common_model->getMenuByMenuName($menuOrIngredientName);
                                        $info_session['food_id_custom'] = $food_menu_record->id;
                                        $this->session->set_userdata($info_session);
                                    }else{
                                        $ingredient_record = $this->Common_model->getIngredientByIngredientName($menuOrIngredientName);
                                        $consumption = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                        $food_menu_ingredient_info = array();
                                        $food_menu_ingredient_info['ingredient_id'] = $ingredient_record->id;
                                        $food_menu_ingredient_info['consumption'] = $consumption;
                                        $food_menu_ingredient_info['food_menu_id'] = $this->session->userdata('food_id_custom');
                                        $food_menu_ingredient_info['user_id'] = $this->session->userdata('user_id');
                                        $food_menu_ingredient_info['company_id'] = $this->session->userdata('company_id');
                                        $food_menu_ingredient_info['del_status'] = 'Live';
                                        $this->Common_model->insertInformation($food_menu_ingredient_info, "tbl_food_menus_ingredients");
                                    }
                                }
                                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                                $this->session->set_flashdata('exception', 'Imported successfully!');
                                redirect('preMadeFood/preMadeFoods');
                            } else {
                                unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                                $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                            }
                        }else{
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception_err', "You can not upload more than 10 food menus at a time.");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                        $this->session->set_flashdata('exception_err', "No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Food_Menu_Ingredients_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Food_Menu_Ingredients_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('preMadeFood/uploadFoodMenuIngredients');
    }

}

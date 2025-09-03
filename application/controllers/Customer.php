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
  # This is Customer Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('excel'); //load PHPExcel library
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "249";
        $function = "";

        if($segment_2=="customers"){
            $function = "view";
        }elseif($segment_2=="addEditCustomer" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditCustomer"){
            $function = "add";
        }elseif($segment_2=="uploadCustomer" || $segment_2=="ExcelDataAddCustomers" || $segment_2=="downloadPDF"){
            $function = "upload_customer";
        }elseif($segment_2=="deleteCustomer"){
            $function = "delete";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if($segment_2=="downloadPDF"){

        }else{
            if(!checkAccess($controller,$function)){
                $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
                redirect('Authentication/userProfile');
            }
        }

        //end check access function
        $login_session['active_menu_tmp'] = '';
        $this->session->set_userdata($login_session);
    }

     /**
     * customers info
     * @access public
     * @return void
     * @param no
     */
    public function customers() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['customers'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_customers");
        $data['main_content'] = $this->load->view('master/customer/customers', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete customer
     * @access public
     * @return void
     * @param int
     */
    public function deleteCustomer($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_customers");

        $this->session->set_flashdata('exception',lang('delete_success'));
        redirect('customer/customers');
    }
     /**
     * upload customer from excel file
     * @access public
     * @return void
     * @param no
     */
    public function uploadCustomer()
    {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['main_content'] = $this->load->view('master/customer/uploadsCustomer', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * add/edit customer
     * @access public
     * @return void
     * @param int
     */
    public function addEditCustomer($encrypted_id = "") {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('name', lang('category_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('phone', lang('phone'), 'required|max_length[50]');
            if(collectGST()=="Yes"){
                $this->form_validation->set_rules('gst_number', lang('gst_number'), 'required|max_length[50]');
                $this->form_validation->set_rules('same_or_diff_state', lang('same_or_diff_state'), 'required|max_length[50]');
            }
            
            if ($this->form_validation->run() == TRUE) {
                $customer_info = array();
                $customer_info['name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('name')));
                $customer_info['phone'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $customer_info['email'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email')));
                $customer_info['default_discount'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('default_discount')));
                
                if(htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_birth')))){
                    $customer_info['date_of_birth'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_birth')));
                }
                if(htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_anniversary')))){
                    $customer_info['date_of_anniversary'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('date_of_anniversary')));
                }

                $online_order_login_password = (htmlspecialcharscustom($this->input->post($this->security->xss_clean('online_order_login_password'))));
                if($online_order_login_password){
                    $customer_info['password_online_user'] = md5($online_order_login_password);
                }
                $c_address = htmlspecialcharscustom($this->input->post($this->security->xss_clean('address')));
                $customer_info['address'] = preg_replace("/[\n\r]/"," ",escape_output($c_address)); #remove new line from address

                if(collectGST()=="Yes"){
                    $customer_info['gst_number'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('gst_number')));
                    $customer_info['same_or_diff_state'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('same_or_diff_state')));
                }
                $customer_info['user_id'] = $this->session->userdata('user_id');
                $customer_info['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $id = $this->Common_model->insertInformation($customer_info, "tbl_customers");
                    $customer_address = array();
                    $customer_address['customer_id'] = $id;
                    $customer_address['address'] = $customer_info['address'];
                    $customer_address['is_active'] = 1;
                    $this->Common_model->insertInformation($customer_address, "tbl_customer_address");

                    $this->session->set_flashdata('exception', lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($customer_info, $id, "tbl_customers");

                    $customer_address = array();
                    $customer_address['customer_id'] = $id;
                    $customer_address['address'] = $customer_info['address'];
                    $customer_address['is_active'] = 1;

                    $getActiveAddress = $this->Common_model->getActiveAddress($id);
                    if(isset($getActiveAddress) && $getActiveAddress){
                        $this->Common_model->updateInformation($customer_address, $getActiveAddress->id, "tbl_customer_address");
                    }else{
                        $this->Common_model->insertInformation($customer_address, "tbl_customer_address");
                    }

                    $this->session->set_flashdata('exception',lang('update_success'));
                }



                redirect('customer/customers');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                    $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('master/customer/addCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['customer_information'] = $this->Common_model->getDataById($id, "tbl_customers");
                $data['main_content'] = $this->load->view('master/customer/editCustomer', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * excel data add form
     * @access public
     * @return void
     * @param no
     */
    public function ExcelDataAddCustomers()
    {
        $company_id = $this->session->userdata('company_id');
        if ($_FILES['userfile']['name'] != "") {
            if ($_FILES['userfile']['name'] == "Customer_Upload.xlsx") {
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
                    if ($totalrows < 54) {
                        $arrayerror = '';
                        for ($i = 4; $i <= $totalrows; $i++) {
                            $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                            $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                            $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                            $dob = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                            $doa = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                            $delivery_address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));

                            if ($name == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column A required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column A required";
                                }
                            }

                            if ($phone == '') {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column B required";
                                } else {
                                    $arrayerror.="<br>Row Number $i column B required";
                                }
                            }

                            if ($email != '' && $this->validateEmail($email)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column C should be valid email";
                                } else {
                                    $arrayerror.="<br>Row Number $i column C should be valid email";
                                }
                            }

                            if ($dob != '' && $this->isValidDate($dob)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column D should be in YYYY-MM-DD format";
                                } else {
                                    $arrayerror.="<br>Row Number $i column D should be in YYYY-MM-DD format";
                                }
                            }

                            if ($doa != '' && $this->isValidDate($doa)==false) {
                                if ($arrayerror == '') {
                                    $arrayerror.="Row Number $i column E should be in YYYY-MM-DD format";
                                } else {
                                    $arrayerror.="<br>Row Number $i column E should be in YYYY-MM-DD format";
                                }
                            }
                        }
                        if ($arrayerror == '') {

                            for ($i = 4; $i <= $totalrows; $i++) {
                                $name = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
                                $phone = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
                                $email = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(2, $i)->getValue()));
                                $dob = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(3, $i)->getValue()));
                                $doa = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(4, $i)->getValue()));
                                $delivery_address = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(5, $i)->getValue()));
                                $default_discount = htmlspecialcharscustom(trim_checker($objWorksheet->getCellByColumnAndRow(6, $i)->getValue()));


                                $customer_info = array();
                                $customer_info['name'] = $name;
                                $customer_info['phone'] = $phone;
                                $customer_info['email'] = $email;
                                $customer_info['date_of_birth'] = $dob;
                                $customer_info['date_of_anniversary'] = $doa;
                                $customer_info['address'] = $delivery_address;
                                $customer_info['default_discount'] = $default_discount;
                                $customer_info['user_id'] = $this->session->userdata('user_id');
                                $customer_info['company_id'] = $this->session->userdata('company_id');
                                $this->Common_model->insertInformation($customer_info, "tbl_customers");
                            }
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception', 'Imported successfully!');
                            redirect('customer/customers');
                        } else {
                            unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                            $this->session->set_flashdata('exception_err', "Required Data Missing:$arrayerror");
                        }
                    } else {
                        unlink(FCPATH . 'asset/excel/' . $file_name); //File Deleted After uploading in database .
                        $this->session->set_flashdata('exception_err', "Entry is more than 50 or No entry found.");
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('exception_err', "$error");
                }
            } else {
                $this->session->set_flashdata('exception_err', "We can not accept other files, please download the sample file 'Customer_Upload.xlsx', fill it up properly and upload it or rename the file name as 'Customer_Upload.xlsx' then fill it.");
            }
        } else {
            $this->session->set_flashdata('exception_err', 'File is required');
        }
        redirect('customer/uploadCustomer');
    }
     /**
     * download file
     * @access public
     * @return void
     * @param string
     */
    public function downloadPDF($file = "") {
        // load ci download helder
        $file = $file.".xlsx";
        $this->load->helper('download');
        $data = file_get_contents("asset/sample/" . $file); // Read the file's
        $name = $file;
        force_download($name, $data);
    }
     /**
     * check validate email address
     * @access public
     * @return object
     * @param string
     */
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
     /**
     * check valid dat4e
     * @access public
     * @return boolean
     * @param string
     */
    function isValidDate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            return true;
        } else {
            return false;
        }
    }

}

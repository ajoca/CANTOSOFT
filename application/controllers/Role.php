<?php
/*
  ###########################################################
  # PRODUCT NAME: 	One Stop
  ###########################################################
  # AUTHER:		Door Soft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Role Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Authentication_model');
        $this->load->model('Role_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }


        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $segment_4 = $this->uri->segment(4);
        $controller = "285";
        $function = "";
        if($segment_2=="roles"){
            $function = "view";
        }elseif($segment_2=="addEditRole" && $segment_3 && $segment_4){
            $function = "copy";
        }elseif($segment_2=="addEditRole" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditRole"){
            $function = "add";
        }elseif($segment_2=="deleteRole"){
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

    }

    /**
     * roles view page
     * @access public
     * @return void
     */
    public function roles() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['roles'] = $this->Role_model->getRolesByCompanyId($company_id, "tbl_roles");
        $data['main_content'] = $this->load->view('role/roles', $data, TRUE);
        $this->load->view('userHome', $data);
    }
    /**
     * delete role
     * @access public
     * @return void
     * @param int
     */
    public function deleteRole($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->db->delete("tbl_roles", array("id" => $id));
        $this->db->delete("tbl_role_access", array("role_id" => $id));
        $this->session->set_flashdata('exception',  lang('delete_success'));
        redirect('Role/roles');
    }
    /**
     * add/edit unit
     * @access public
     * @return void
     * @param int
     */
    public function addEditRole($encrypted_id = "",$copy='') {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('role_name',  lang('role_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('access_id',  lang('menu_access'), "callback_check_menu_access");
            if ($this->form_validation->run() == TRUE) {

                $role_info = array();
                $role_info['role_name'] = htmlspecialcharscustom($this->input->post('role_name'));
                $role_info['company_id'] = $this->session->userdata('company_id');

                if ($id == "") {
                    $role_id = $this->Common_model->insertInformation($role_info, "tbl_roles");
                    //This field should not be escaped, because this is an array field
                    $access_id = $this->input->post('access_id');
                    if($access_id){
                        //data insert in role access table
                        for($i=0;$i<sizeof($access_id);$i++){
                            $original_value = explode('|',$access_id[$i]);
                            $data = array();
                            $data['role_id'] = $role_id;
                            $data['access_parent_id'] = $original_value[0];
                            $data['access_child_id'] = $original_value[1];
                            $this->Common_model->insertInformation($data, "tbl_role_access");
                        }
                        //end data insert in role access table
                    }
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    if($copy=="copy"){
                        $role_id = $this->Common_model->insertInformation($role_info, "tbl_roles");
                        //This field should not be escaped, because this is an array field
                        $access_id = $this->input->post('access_id');
                        if($access_id){
                            //data insert in role access table
                            for($i=0;$i<sizeof($access_id);$i++){
                                $original_value = explode('|',$access_id[$i]);
                                $data = array();
                                $data['role_id'] = $role_id;
                                $data['access_parent_id'] = $original_value[0];
                                $data['access_child_id'] = $original_value[1];
                                $this->Common_model->insertInformation($data, "tbl_role_access");
                            }
                            //end data insert in role access table
                        }
                        $this->session->set_flashdata('exception',  lang('insertion_success'));
                    }else{
                        $this->Common_model->updateInformation($role_info, $id, "tbl_roles");
                        //This field should not be escaped, because this is an array field
                        $access_id = $this->input->post('access_id');
                        $this->Common_model->deletingMultipleFormData("role_id", $id, "tbl_role_access");
                        if($access_id){
                            //delete previous access before add
                            //end delete previous access before add
                            //data insert in role access table
                            for($i=0;$i<sizeof($access_id);$i++){
                                $original_value = explode('|',$access_id[$i]);
                                $data = array();
                                $data['role_id'] = $id;
                                $data['access_parent_id'] = $original_value[0];
                                $data['access_child_id'] = $original_value[1];
                                $this->Common_model->insertInformation($data, "tbl_role_access");
                            }
                            //end data update in role access table
                        }
                        $this->session->set_flashdata('exception', lang('update_success'));
                    }


                }
                redirect('Role/roles');
            } else {

                if ($id == "") {
                    $data = array();
                    $data['access'] = $this->Common_model->getAllByTableAsc("tbl_access");
                    $data['access_modules'] = $this->Common_model->getAccessList();
                    foreach ($data['access_modules'] as $key=>$value){
                        $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                    }
                    $data['main_content'] = $this->load->view('role/addRole', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['copy'] = $copy;
                    $data['access'] = $this->Common_model->getAllByTableAsc("tbl_access");
                    $data['access_modules'] = $this->Common_model->getAccessList();
                    foreach ($data['access_modules'] as $key=>$value){
                        $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                    }

                    $selected_modules =  $this->Common_model->getAllByCustomId($id,'role_id','tbl_role_access');
                    $selected_modules_arr = array();
                    foreach ($selected_modules as $value) {
                        $selected_modules_arr[] = $value->access_child_id;
                    }
                    $data['selected_modules_arr'] = $selected_modules_arr;
                    $data['role_details'] = $this->Common_model->getDataById($id, "tbl_roles");
                    $data['main_content'] = $this->load->view('role/editRole', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['access_modules'] = $this->Common_model->getAccessList();
                foreach ($data['access_modules'] as $key=>$value){
                    $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                }
                $data['main_content'] = $this->load->view('role/addRole', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['copy'] = $copy;
                $data['access'] = $this->Common_model->getAllByTableAsc("tbl_access");

                $data['access_modules'] = $this->Common_model->getAccessList();
                foreach ($data['access_modules'] as $key=>$value){
                    $data['access_modules'][$key]->functions = $this->Common_model->getAllCustomData("tbl_access",'label_name','asc','parent_id',$value->id);
                }
                $selected_modules =  $this->Common_model->getAllByCustomId($id,'role_id','tbl_role_access');

                $selected_modules_arr = array();
                foreach ($selected_modules as $value) {
                    $selected_modules_arr[] = $value->access_child_id;
                }
                $data['selected_modules_arr'] = $selected_modules_arr;
                $data['role_details'] = $this->Common_model->getDataById($id, "tbl_roles");
                $data['main_content'] = $this->load->view('role/editRole', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
    /**
     * check role access menu list
     * @access public
     * @return boolean
     */
    public function check_menu_access() {
        //This field should not be escaped, because this is an array field
        $access_id = $this->input->post('access_id');
        if ($access_id && count($access_id) <= 0) {
            $this->form_validation->set_message('check_menu_access', 'At least 1 menu access should be selected');
            return false;
        } else {
            return true;
        }
    }

}

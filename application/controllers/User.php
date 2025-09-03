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
  # This is User Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
         $this->load->model('Authentication_model');
        $this->load->model('User_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "291";
        $function = "";
        if($segment_2=="users"){
            $function = "view";
        }elseif($segment_2=="addEditUser" && $segment_3){
            $function = "update";
        }elseif($segment_2=="addEditUser"){
            $function = "add";
        }elseif($segment_2=="deactivateUser"){
            $function = "deactivate";
        }elseif($segment_2=="activateUser"){
            $function = "activate";
        }elseif($segment_2=="deleteUser"){
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
     * users
     * @access public
     * @return void
     * @param no
     */
    public function users() {
        $company_id = $this->session->userdata('company_id');

        $data = array();
        $data['users'] = $this->User_model->getUsersByCompanyId($company_id, "tbl_users");
        $data['main_content'] = $this->load->view('user/users', $data, TRUE);
        $this->load->view('userHome', $data);
    }
     /**
     * delete User
     * @access public
     * @return void
     * @param int
     */
    public function deleteUser($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');

        $this->Common_model->deleteStatusChange($id, "tbl_users");

        $this->session->set_flashdata('exception',  lang('delete_success'));
        redirect('User/users');
    }
     /**
     * add/Edit User
     * @access public
     * @return void
     * @param int
     */
    public function addEditUser($encrypted_id = "") {
        $str = $this->session->userdata('language_manifesto');
        if($str!="fgjgldkfg"){
            if(isServiceAccessOnly('sGmsJaFJE') && !isFoodCourt()){
                if(!checkCreatePermissionUser()){
                    $this->session->set_flashdata('exception_1',lang('not_permission_user_create_error'));
                    redirect('User/users');
                }
            }
        }

        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        if ($id != '') {
            $user_details = $this->Common_model->getDataById($id, "tbl_users");
        }
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('full_name',  lang('name'), 'required|max_length[50]');
            if ($id != '') {
                $post_phone =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $existing_phone = $user_details->phone;
                if ($post_phone != $existing_phone) {
                    $this->form_validation->set_rules('phone',  lang('phone'), "required|numeric");
                } else {
                    $this->form_validation->set_rules('phone',  lang('phone'), "required|numeric");
                }
            } else {
                $this->form_validation->set_rules('phone', lang('phone'), "required|numeric");
            }

            if ($id != '') {
                $post_email_address =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $post_login_pin =htmlspecialcharscustom($this->input->post($this->security->xss_clean('login_pin')));
                $existing_email_address = $user_details->email_address;
                $existing_login_pin = $user_details->login_pin;
                if ($post_email_address != $existing_email_address) {
                    $this->form_validation->set_rules('email_address',  lang('email_address'), "max_length[50]");
                } else {
                    $this->form_validation->set_rules('email_address',  lang('email_address'), "max_length[50]");
                }

                if ($existing_login_pin != $post_login_pin) {
                    $this->form_validation->set_rules('login_pin',  lang('login_pin'), "required|max_length[4]|min_length[4]|is_unique[tbl_users.login_pin]");
                }

            } else {
                $this->form_validation->set_rules('email_address',  lang('email_address'), "max_length[50]");
            }
            $this->form_validation->set_rules('designation',  lang('designation'), "required|max_length[50]|min_length[3]");

            if($this->input->post($this->security->xss_clean('will_login'))=='Yes' && $id == ""){
                $this->form_validation->set_rules('role_id',  lang('role_id'), "required|max_length[50]");
                $this->form_validation->set_rules('password',  lang('password'), "required|max_length[50]|min_length[6]");
                $this->form_validation->set_rules('confirm_password',  lang('confirm_password'), "required|max_length[50]|min_length[6]|matches[password]");
                $this->form_validation->set_rules('login_pin',  lang('login_pin'), "max_length[4]|min_length[4]|is_unique[tbl_users.login_pin]");
            }
            if ($this->form_validation->run() == TRUE) {
                $ids = '';
                    $language_manifesto = $this->session->userdata('language_manifesto');

                    if(str_rot13($language_manifesto)=="eriutoeri"  && !(isFoodCourt('sGmsJaFJE'))):
                        $outlets =$this->input->post($this->security->xss_clean('outlets'));
                        foreach ($outlets as $k1 => $outlet):
                            $ids.= $outlet;
                            if($k1 < (sizeof($outlets) -1)){
                                $ids.=",";
                            }
                        endforeach;
                      else:
                          $ids = $outlet_id;
                          endif;
                $kitchens = '';
                $kitchens_tmp =$this->input->post($this->security->xss_clean('kitchens'));
                if(isset($kitchens_tmp) && $kitchens_tmp){
                    foreach ($kitchens_tmp as $k1 => $kitchen):
                        $kitchens.= $kitchen;
                        $kitchens.=",";
                    endforeach;
                }

                $user_info = array();
                $user_info['full_name'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('full_name')));
                $user_info['email_address'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $user_info['phone'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('phone')));
                $user_info['designation'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('designation')));
                $user_info['login_pin'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('login_pin')));
                $user_info['will_login'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('will_login')));
                $user_info['role_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('role_id')));
                $user_info['order_receiving_id'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('order_receiving_id')));
                $user_info['kitchens'] = $kitchens;
                if($this->input->post($this->security->xss_clean('will_login'))=='Yes' && $this->input->post($this->security->xss_clean('password'))){
                    $user_info['password'] = md5($this->input->post($this->security->xss_clean('password')));
                    if($id==''){
                        $user_info['role'] = (is_null($this->input->post('user_type')) || $this->input->post('user_type')=="")?'User':$this->input->post('user_type');
                    }
                }
                if(!isFoodCourt()){
                    $user_info['outlets'] = $ids;
                    $user_info['outlet_id'] = $ids;
                }else{
                    $user_info['outlets'] = $this->session->userdata('outlet_id');;
                    $user_info['outlet_id'] = $this->session->userdata('outlet_id');;
                }
                if ($id == "") {
                    $user_info['company_id'] = $this->session->userdata('company_id');
                    $user_info['created_date'] = date("Y-m-d");
                    $user_info['created_id'] = $this->session->userdata('user_id');
                    $this->Common_model->insertInformation($user_info, "tbl_users");
                    if($this->input->post($this->security->xss_clean('will_login'))=='Yes'){

                    }
                    $this->session->set_flashdata('exception',  lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($user_info, $id, "tbl_users");
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                redirect('User/users');
            } else {

                if ($id == "") {
                    $data = array();
                    $data['roles'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_roles");
                     $data['waiters'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                    $data['kitchens'] = $this->Common_model->getAllViaPanel();
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                    $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['roles'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_roles");
                    $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
                    $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                     $data['waiters'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                    $data['kitchens'] = $this->Common_model->getAllViaPanel();
                    $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['roles'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_roles");
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                $data['kitchens'] = $this->Common_model->getAllViaPanel();
                 $data['waiters'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                $data['main_content'] = $this->load->view('user/addUser', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['roles'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_roles");
                $data['user_details'] = $this->Common_model->getDataById($id, "tbl_users");
                $data['outlets'] = $this->Common_model->getAllByCompanyIdForDropdown($company_id, "tbl_outlets");
                $data['kitchens'] = $this->Common_model->getAllViaPanel();
                 $data['waiters'] = $this->Common_model->getAllByCompanyId($company_id, "tbl_users");
                $data['main_content'] = $this->load->view('user/editUser', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }
     /**
     * save User Menus Access
     * @access public
     * @return void
     * @param string
     * @param int
     * @param string
     */
     /**
     * deactivate User
     * @access public
     * @return void
     * @param int
     */
    public function deactivateUser($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $user_info = array();
        $user_info['active_status'] = 'Inactive';
        $this->Common_model->updateInformation($user_info, $id, "tbl_users");
        $this->session->set_flashdata('exception',lang('user_deactivate'));
        redirect('User/users');
    }
     /**
     * activate User
     * @access public
     * @return void
     * @param int
     */
    public function activateUser($encrypted_id) {
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $user_info = array();
        $user_info['active_status'] = 'Active';
        $this->Common_model->updateInformation($user_info, $id, "tbl_users");
        $this->session->set_flashdata('exception', lang('user_activate'));
        redirect('User/users');
    }

}

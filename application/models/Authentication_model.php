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
  # This is Authentication_model Model
  ###########################################################
 */

class Authentication_model extends CI_Model {
    public function __construct(){
        parent::__construct(); 
        if ($this->session->has_userdata('language')) {
            $language = $this->session->userdata('language');
        }else{
            $language = 'english';
        }  
        $this->lang->load("$language", "$language");
        $this->config->set_item('language', $language);
    }
    /**
     * get White Label
     * @access public
     * @return object
     * @param int
     */
    public function getWhiteLabel($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_setting");
        $this->db->where("company_id", $company_id);
        return $this->db->get()->row();
    }
    /**
     * get User Information
     * @access public
     * @return object
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function getUserInformation($email_address, $password,$login_pin='',$login_type='') {
        $this->db->select("*");
        $this->db->from("tbl_users");
        if($login_type==1){
            $this->db->where("email_address", $email_address);
            $this->db->where("password", $password);
        }else{
            $this->db->where("login_pin", $login_pin);
        }
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    public function pinCheck($old_pin, $user_id) {
        $row = $this->db->query("SELECT * FROM tbl_users WHERE id=$user_id AND login_pin='$old_pin'")->row();
        return $row;
    }
    public function updatePin($new_pin, $user_id) {
        $this->db->set('login_pin', $new_pin);
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
    }
    /**
     * update User Info
     * @access public
     * @return object
     * @param int
     * @param int
     */
    public function updateUserInfo($company_id, $user_id) {
        $this->db->set('company_id', $company_id);
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
    }
    /**
     * save Company Info
     * @access public
     * @return int
     * @param array
     */
    public function saveCompanyInfo($company_info) {
        $this->db->insert('tbl_companies', $company_info);
        return $this->db->insert_id();
    }
    /**
     * get Account By Mobile No
     * @access public
     * @return object
     * @param string
     */
    public function getAccountByMobileNo($email_address) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email_address);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    public function updatePasswordEmail($new_password, $email) {
        $this->db->set('password', $new_password);
        $this->db->where('email_address', $email);
        $this->db->where('del_status', "Live");
        $this->db->update('tbl_users');
    }
    /**
     * get Company Information
     * @access public
     * @return object
     * @param int
     */
    public function getCompanyInformation($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $this->db->where("id", $company_id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }
    /**
     * save User Info
     * @access public
     * @return int
     * @param array
     */
    public function saveUserInfo($user_info) {
        $this->db->insert('tbl_users', $user_info);
        return $this->db->insert_id();
    }
    /**
     * password Check
     * @access public
     * @return object
     * @param string
     * @param int
     */
    public function passwordCheck($old_password, $user_id) {
        $row = $this->db->query("SELECT * FROM tbl_users WHERE id=$user_id AND password='$old_password'")->row();
        return $row;
    }
    /**
     * update Password
     * @access public
     * @return void
     * @param string
     * @param int
     */
    public function updatePassword($new_password, $user_id) {
        $this->db->set('password', $new_password);
        $this->db->where('id', $user_id);
        $this->db->update('tbl_users');
    }

    /**
     * get Setting Information
     * @access public
     * @return object
     * @param no
     */
    public function getSettingInformation() {
        $company_info = getCompanyInfo();
        $getWhiteLabel = json_decode($company_info->white_label);
        return $getWhiteLabel;
    }
    /**
     * get SMS Information
     * @access public
     * @return object
     * @param int
     */
    public function getSMSInformation($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_companies");
        $this->db->where("id", $company_id);
        $this->db->where("del_status", "Live");
        $row = $this->db->get()->row();
        return ($row);
    }
    /**
     * get Profile Information
     * @access public
     * @return object
     * @param no
     */
    public function getProfileInformation() {
        $user_id = $this->session->userdata('user_id');
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("id", $user_id);
        return $this->db->get()->row();
    }
    public function updateSecurityQuestion($company_id, $user_id, $security_question, $security_answer) {
        $this->db->set(array('question' => $security_question, 'answer'=> $security_answer));
        $this->db->where('id', $user_id);
        $this->db->where("del_status", 'Live');
        $this->db->update('tbl_users');
    }
}


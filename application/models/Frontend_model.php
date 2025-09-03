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
  # This is Frontend_model Model
  ###########################################################
 */
class Frontend_model extends CI_Model {
     /**
     * check online customer login
     * @access public
     * @return object
     * @param int
     */
    public function getCustomerLogin($phone,$password) {
        $this->db->select("*");
        $this->db->from("tbl_customers");
        $this->db->where("phone", $phone);
        $this->db->where("password_online_user", md5($password));
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    } 
    
    function getOrderReceivingIdAdmin() {
        $CI = & get_instance();
        $company_id = 1;
        $data = $CI->db->query("SELECT * FROM tbl_users where `company_id`='$company_id' AND `role`='Admin' AND del_status='Live'")->row();
        return isset($data->id) && $data->id?$data->id:'';
    }

}


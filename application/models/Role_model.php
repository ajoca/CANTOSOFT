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
  # This is Role_model Model
  ###########################################################
 */
class Role_model extends CI_Model {
    /**
     * return role data
     * @access public
     * @param int
     */
    public function getRolesByCompanyId($company_id) {
        $this->db->select("*");
        $this->db->from("tbl_roles");
        $this->db->where("company_id", $company_id);
        $this->db->where("del_status", 'Live');
        $this->db->order_by("id", 'desc');
        return $this->db->get()->result();
    }

}


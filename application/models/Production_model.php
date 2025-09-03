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
  # This is Production_model Model
  ###########################################################
 */
class Production_model extends CI_Model {
 /**
     * generate Production Ref No
     * @access public
     * @return string
     * @param int
     */
    public function generatePurRefNo($outlet_id) {
        $production_count = $this->db->query("SELECT count(id) as production_count
               FROM tbl_production where outlet_id=$outlet_id")->row('production_count');
        $ingredient_code = str_pad($production_count + 1, 6, '0', STR_PAD_LEFT);
        return $ingredient_code;
    }
 /**
     * get Ingredient List With Unit And Price
     * @access public
     * @return object
     * @param int
     */
    public function getIngredientListWithUnitAndPrice($company_id) {
        $result = $this->db->query("SELECT tbl_ingredients.id, tbl_ingredients.name, tbl_ingredients.code, tbl_ingredients.purchase_price, tbl_ingredients.consumption_unit_cost, tbl_units.unit_name
          FROM tbl_ingredients 
          left JOIN tbl_units ON tbl_ingredients.unit_id = tbl_units.id
          WHERE tbl_ingredients.company_id=$company_id AND tbl_ingredients.del_status = 'Live'   AND tbl_ingredients.ing_type = 'Pre-made Item'  
          ORDER BY tbl_ingredients.name ASC")->result();
        return $result;
    }
    /**
     * get Production Ingredients
     * @access public
     * @return object
     * @param int
     */
    public function getProductionIngredients($id) {
        $this->db->select("*");
        $this->db->from("tbl_production_ingredients");
        $this->db->order_by('id', 'ASC');
        $this->db->where("production_id", $id);
        $this->db->where("del_status", 'Live');
        return $this->db->get()->result();
    }

}


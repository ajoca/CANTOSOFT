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
  # This is Kitchen_model Model
  ###########################################################
 */
class Kitchen_model extends CI_Model {

     /**
     * get New Orders
     * @access public
     * @return object
     * @param int
     */

    public function getNewOrders($outlet_id){
        $this->db->select("*,tbl_kitchen_sales.id as sale_id, tbl_customers.name as customer_name, tbl_kitchen_sales.id as sales_id,tbl_users.full_name as waiter_name,tbl_tables.name as table_name");
        $this->db->from('tbl_kitchen_sales');
        $this->db->where("tbl_kitchen_sales.is_self_order", "No");
        $this->db->where("tbl_kitchen_sales.outlet_id", $outlet_id);
        $this->db->where("(order_status='1' OR order_status='2')");
        $this->db->where("tbl_kitchen_sales.is_accept", 1);
        $this->db->join('tbl_tables', 'tbl_tables.id = tbl_kitchen_sales.table_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.waiter_id', 'left');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->order_by('tbl_kitchen_sales.id', 'ASC');
        return $this->db->get()->result();
    }
     /**
     * get total kitchen type items
     * @access public
     * @return object
     * @param int
     */
    public function get_total_kitchen_type_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->where("sales_id", $sale_id);
        return $this->db->get()->num_rows();    
    }
     /**
     * get total kitchen type done items
     * @access public
     * @return object
     * @param int
     */
    public function get_total_kitchen_type_done_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("cooking_status", "Done");
        return $this->db->get()->num_rows();    
    }
    public function get_all_kitchen_items($sale_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("del_status", "Live");
        return $this->db->get()->result();
    }
     /**
     * get total kitchen type started cooking items
     * @access public
     * @return object
     * @param int
     */
    public function get_total_kitchen_type_started_cooking_items($sale_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->where("sales_id", $sale_id);
        $this->db->where("cooking_status", "Started Cooking");
        return $this->db->get()->num_rows();    
    }
     /**
     * get Item Info By Previous Id
     * @access public
     * @return object
     * @param int
     */
    public function getItemInfoByPreviousId($previous_id)
    {
        $this->db->select('tbl_kitchen_sales_details.*,tbl_food_menus.code as code,tbl_food_menus.name as menu_name');
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->where("previous_id", $previous_id);
        return $this->db->get()->row();   
    }
     /**
     * get Sale By Sale Id
     * @access public
     * @return object
     * @param int
     */
    public function getSaleBySaleId($sales_id){
        $this->db->select("tbl_kitchen_sales.*,tbl_users.full_name as waiter_name,tbl_customers.name as customer_name,tbl_tables.name as table_name,tbl_users.full_name as user_name");
        $this->db->from('tbl_kitchen_sales');
        $this->db->join('tbl_customers', 'tbl_customers.id = tbl_kitchen_sales.customer_id', 'left');
        $this->db->join('tbl_users', 'tbl_users.id = tbl_kitchen_sales.user_id', 'left');
        $this->db->join('tbl_tables', 'tbl_tables.id = tbl_kitchen_sales.table_id', 'left');
        $this->db->join('tbl_users w', 'w.id = tbl_kitchen_sales.waiter_id', 'left');
        $this->db->where("tbl_kitchen_sales.id", $sales_id);
        $this->db->order_by('tbl_kitchen_sales.id', 'ASC');
        return $this->db->get()->result();
    }
     /**
     * get All Kitchen Items From Sales Detail By Sales Id
     * @access public
     * @return object
     * @param int
     */
    public function getAllKitchenItemsFromSalesDetailBySalesId($sales_id,$kitchen_id){
        $this->db->select("tbl_kitchen_sales_details.*,tbl_kitchen_sales_details.id as sales_details_id,tbl_food_menus.code as code,tbl_food_menus.alternative_name,tbl_kitchen_categories.kitchen_id");
        $this->db->from('tbl_kitchen_sales_details');
        $this->db->join('tbl_food_menus', 'tbl_food_menus.id = tbl_kitchen_sales_details.food_menu_id', 'left');
        $this->db->join('tbl_kitchen_categories', 'tbl_kitchen_categories.cat_id = tbl_food_menus.category_id', 'left');
        $this->db->where("sales_id", $sales_id);
        $this->db->where("tbl_kitchen_categories.kitchen_id", $kitchen_id);
        $this->db->where("tbl_kitchen_sales_details.cooking_status!=", "Done");
        $this->db->where("tbl_kitchen_categories.del_status", "Live");
        $this->db->order_by('tbl_kitchen_sales_details.id', 'ASC');
        $data =  $this->db->get()->result();
        return $data;
    }
     /**
     * get Modifiers By Sale And Sale Details Id
     * @access public
     * @return object
     * @param int
     * @param int
     */
    public function getModifiersBySaleAndSaleDetailsId($sales_id,$sale_details_id){
        $this->db->select("tbl_kitchen_sales_details_modifiers.*,tbl_modifiers.name");
        $this->db->from('tbl_kitchen_sales_details_modifiers');
        $this->db->join('tbl_modifiers', 'tbl_modifiers.id = tbl_kitchen_sales_details_modifiers.modifier_id', 'left');
        $this->db->where("tbl_kitchen_sales_details_modifiers.sales_id", $sales_id);
        $this->db->where("tbl_kitchen_sales_details_modifiers.sales_details_id", $sale_details_id);
        $this->db->order_by('tbl_kitchen_sales_details_modifiers.id', 'ASC');
        return $this->db->get()->result(); 
    }
     /**
     * get Notification By Outlet Id
     * @access public
     * @return object
     * @param int
     */
    public function getNotificationByOutletId($outlet_id,$kitchen_id)
    {
      $this->db->select('*');
      $this->db->from('tbl_notification_bar_kitchen_panel');
      $this->db->where("outlet_id", $outlet_id);
      $this->db->where("kitchen_id", $kitchen_id);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result(); 
    }
     /**
     * get all tables of a sale items
     * @access public
     * @return object
     * @param int
     */
    public function get_all_tables_of_a_sale_items($sale_id)
    {
      $this->db->select('tbl_tables.name as table_name');
      $this->db->from('tbl_orders_table');
      $this->db->join('tbl_tables', 'tbl_tables.id = tbl_orders_table.table_id', 'left');
      $this->db->where("sale_id", $sale_id);
      // $this->db->where("tbl_orders_table.del_status", 'Live');
      return $this->db->get()->result();
      
    }

}


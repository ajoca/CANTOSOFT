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
  # This is Expense Controller
  ###########################################################
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Plugin extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "291";
        $function = "";
        if($segment_2=="plugins"){
            $function = "view";
        }elseif($segment_2=="OP" && $segment_3=="Inactive"){
            $function = "deactivate";
        }elseif($segment_2=="OP" && $segment_3=="Active"){
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
     * plugin info
     * @access public
     * @return void
     * @param no
     */
    public function plugins() {
        $data = array();
        $data['plugins'] = $this->Common_model->getAllByTable("tbl_plugins");
        $data['main_content'] = $this->load->view('plugin/plugins', $data, TRUE);
        $this->load->view('userHome', $data);
    }
      /**
     * plugin info
     * @access public
     * @return void
     * @param no
     */
    public function OP($status,$id) {
        $plugin['active_status'] = $status;
        $this->Common_model->updateInformation($plugin, $id, "tbl_plugins");
        if($status=="Yes"){
            $this->session->set_flashdata('exception', lang('insertion_success'));
        }else{
            $this->session->set_flashdata('exception', lang('update_success'));
        }
        redirect('Plugin/plugins');
    }

}

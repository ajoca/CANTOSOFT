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
  # This is Authentication Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Cl_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->library('form_validation');
    }

    public function waiter_login() {
        if (is_mobile_access()) {
            $valid_txt = isset($_GET['txt_vld']) && $_GET['txt_vld']?$_GET['txt_vld']:'';
            if(str_rot13($valid_txt) == "Ty3qq5fq"){
                $this->load->view('authentication/login_waiter');
            }else{
                redirect("access-denied");
            }
        }else{
            redirect("access-denied");
        }
    }
    public function accessDenied() {
        echo "<title>".lang('desktop_access_denied')."</title>";
        echo lang('desktop_access_denied');exit;
    }

    /**
     * check login info
     * @access public
     * @return void
     * @param no
     */
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Short_message_service extends Cl_Controller {
 
    public function __construct() {
        parent::__construct(); 

        $this->load->model('Common_model'); 
        $this->load->model('Authentication_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        
        $this->load->library('setupfile');

        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }

        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));

            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $controller = "321";
        $function = "";

        if($segment_1=="Short_message_service"){
            $function = "view";
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

    public function send(){
    	$this->setupfile->send("8801812391633", "Hello there this is message");
    }

    public function smsService(){ 
        $data = array(); 
        $data['main_content'] = $this->load->view('shortMessageService/smsService', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function sendSMS($type=''){

        $company_id = $this->session->userdata('company_id');
        $company = companyInformation($company_id);
        if (!($company->sms_service_provider)) {
            $this->session->set_flashdata('exception_2', 'Please configure SMS first');
            redirect('Short_message_service/smsService');
        }

        $data = array(); 
        $data['type'] = $type;
        $data['balance'] = 0;
        $today = date('Y-m-d');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('outlet_name', lang('outlet_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('message', lang('message'), 'required|max_length[200]');
            if ($type == "custom") {
                $this->form_validation->set_rules('number',lang('number'), 'required|max_length[50]'); 
            }
            if ($this->form_validation->run() == TRUE) { 

                $sender = $this->input->post($this->security->xss_clean('outlet_name'));
                $message = $this->input->post($this->security->xss_clean('message')); 
                $numbers = ($this->input->post($this->security->xss_clean('number')));
 
                if ($type == 'custom') {
                    try {
                        smsSendOnly($message,$numbers);
                        $this->session->set_flashdata('exception', 'SMS has been sent successfully!');
                    } catch (Exception $e) {
                        die('Error: ' . $e->getMessage());
                    }
                }else{ 

                    if ($type == 'birthday') {
                        $sms_count=  $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                        $this->session->set_flashdata('exception_2', 'No customer has birthday found with valid phone number!');
                    }elseif ($type =='anniversary') {
                        $sms_count=  $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                        $this->session->set_flashdata('exception_2', 'No customer has anniversary found with valid phone number!');
                    }elseif ($type =='customAll') {
                        $sms_count=  $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
                        $this->session->set_flashdata('exception_2', 'No customer has found with valid phone number!');
                    }  

                    if (empty($sms_count)) {
                        redirect('Short_message_service/smsService');
                    }

                    foreach ($sms_count as $value) {
                        smsSendOnly($message,$value->phone);
                    }
                } 
 
                redirect('Short_message_service/smsService');
            } else {
                $day = '';
                $outlet_name = $this->session->userdata('outlet_name');

                if ($type == 'birthday') {
                    $day = "Birthday";
                }elseif ($type =='anniversary') {
                    $day = "Anniversary";
                }

                if ($type == 'birthday' || $type == 'anniversary') {
                    $data['message'] = "Wishing you Happy $day from $outlet_name. Please come to our restaurant and enjoy discount in your special day.";
                }else{
                    $data['message'] = "";
                }

                $data['outlet_name'] = $outlet_name;

                $today = date('Y-m-d');

                if ($type == 'birthday') {
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
                }elseif ($type =='anniversary') {
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
                }elseif($type =='customAll'){
                    $data['sms_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
                }

                if ($type == 'balance') {
                    $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE);
                }else{
                    $data['main_content'] = $this->load->view('shortMessageService/sendSMS', $data, TRUE);
                }
                $this->load->view('userHome', $data);
            }
        }else{
            $day = '';
            $outlet_name = $this->session->userdata('outlet_name');

            if ($type == 'birthday') {
                $day = "Birthday";
            }elseif ($type =='anniversary') {
                $day = "Anniversary";
            }  

            if ($type == 'birthday' || $type == 'anniversary') {
                $data['message'] = "Wishing you Happy $day from $outlet_name. Please come to our restaurant and enjoy discount in your special day.";
            }else{
                $data['message'] = "";
            } 

            $data['outlet_name'] = $outlet_name;

            $today = date('Y-m-d');

            if ($type == 'birthday') {
                $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_birth`='". $today."' AND company_id = $company_id")->result();
            }elseif ($type =='anniversary') {
                $data['sms_count'] = $this->db->query("select * from tbl_customers where `date_of_anniversary`='". $today."' AND company_id = $company_id")->result();
            }elseif($type =='customAll'){
                $data['sms_count'] = $this->db->query("select * from tbl_customers where company_id = $company_id")->result();
            }    

            if ($type == 'balance') {
                $data['main_content'] = $this->load->view('shortMessageService/checkBalance', $data, TRUE); 
            }else{ 
                $data['main_content'] = $this->load->view('shortMessageService/sendSMS', $data, TRUE);
            } 
            $this->load->view('userHome', $data); 
        }
    } 

}


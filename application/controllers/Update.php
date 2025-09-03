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
  # This is Update Controller
  ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Update extends Cl_Controller {

    protected $update;
    protected $my_info;
    function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->my_info = json_decode(file_get_contents(base_url(str_rot13('/nffrgf/oyhrvzc/ERFG_NCV_HI.wfba'))));
        $this->update = json_decode(file_get_contents((str_rot13($this->my_info->url))));
    }

     /**
     * update view page
     * @access public
     * @return void
     * @param no
     */
    public function index(){
        //start check access function
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = 0;
        $function = "";
        if($segment_2=="index"){
            $controller = "60";
            $function = "update";
        }else if($segment_1=="update" || $segment_1=="Update"){
            $controller = "60";
            $function = "update";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        $check_update_session = "Yes";

        $system_version_number = $this->session->userdata('system_version_number');
        $updated_version = isset($this->update->version) && $this->update->version?$this->update->version:'';

        if($check_update_session=="Yes"){
            if((float)$updated_version > (float)$system_version_number){
                $data['color'] = '#4b7bec';
                $data['message'] = 'A NEW VERSION IS AVAILABLE';
                if(isset($this->update->whats_new)){
                    $data['whats_new'] = $this->update->whats_new;
                }
                $data['update_url'] = base_url('/update/do_update');
            }else{
                $data['color']= '#16a085';
                $data['message']= 'You are using '.$system_version_number.' version';
            }
            $this->load->view('updater/update_view', $data);
        }else{
            redirect('Update/updateVerification');
        }
    }
    /**
     * update view page
     * @access public
     * @return void
     * @param no
     */
    public function updateVerification(){
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);

        $function = "";
        $controller = 0;
        if($segment_2=="updateVerification"){
            $controller = "60";
            $function = "update";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        $details = json_decode(file_get_contents(base_url(str_rot13('/nffrgf/juvgr_ynory.wfba'))));

        if(isset($details->is_white_label) && $details->is_white_label=="No"){
            $this->form_validation->set_rules('username', lang('envato_username'), 'required|max_length[50]');
            $this->form_validation->set_rules('purchase_code', lang('purchase_code'), 'required|max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                if (htmlspecialcharscustom($this->input->post('submit'))) {
                    $purchase_code = $_POST["purchase_code"];
                    $username = $_POST["username"];
                    $owner = $_POST["owner"];
                    //need to change
                    $source = 'CodeCanyon';
                    //need to change
                    $company = getMainCompany();
                    $language_manifesto = $company->language_manifesto;
                    if(str_rot13($language_manifesto)=="eriutoeri"):
                        $product_id = '24077441';
                    else:
                        $product_id = '23033741';
                    endif;
                    
                    $root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
                    $root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
                    $installation_url = $root; 

                    $curl_handle = curl_init();
                    //need to change
                    curl_setopt($curl_handle, CURLOPT_URL, str_rot13("uggcf://qbbefbsg.pb/qfy/Inyvqngvba/purpxvat_hcqngr/"));
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl_handle, CURLOPT_POST, 1);
                    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                    $referer = "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
                    $path = substr(realpath(dirname(__FILE__)), 0, -8);
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                        'username' => $username,
                        'purchase_code' => $purchase_code,
                        'source' => $source,
                        'product_id' => $product_id,
                        'owner' => $owner,
                        'installation_url' => $installation_url,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'referer' => $referer,
                        'path' => $path
                    ));
        
                    $buffer = curl_exec($curl_handle);
                    curl_close($curl_handle);
                    if (! (is_object(json_decode($buffer)))) {
                        $cfc = strip_tags($buffer);
                    } else {
                        $cfc = NULL;
                    }
        
                    $object = json_decode($buffer);
 
                    $data['status']= 1;
                    $data['color']= "red";
                    if(isset($object->status) &&  $object->status == 'success'){
                        $data['status']= 2;
                        $data['color']= "green";
                        $this->session->set_userdata('check_update_session',"Yes");
                        $this->session->set_flashdata('exception', lang('verification_success'));
                    }else{
                        $this->session->set_flashdata('exception_err', lang('verification_err'));
                    }
                    $data['main_content'] = $this->load->view('updater/updateVerification', $data, TRUE);
                    $this->load->view('userHome', $data);
                }else{
                    $data['status']= '';
                    $data['color']= "red";
                    $data['main_content'] = $this->load->view('updater/updateVerification', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }else{
                $data['status']= '';
                $data['color']= "red";
                $data['main_content'] = $this->load->view('updater/updateVerification', $data, TRUE);
                $this->load->view('userHome', $data);
            }

        }else{
            $this->session->set_userdata('check_update_session',"Yes");
            redirect('Update/index');
        }
    }

    public function rrmdir($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file))
                $this->rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }
    /**
     * update view page
     * @access public
     * @return void
     * @param no
     */
    public function uninstallLicense(){
        //start check access function
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);

        $function = "";
        if($segment_2=="UninstallLicense" || $segment_2=="uninstallLicense"){
            $controller = "62";
            $function = "uninstall";
        }else{
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_er', lang('menu_not_permit_access'));
            redirect('Authentication/userProfile');
        }

        if (htmlspecialcharscustom($this->input->post('submit'))) {

            $this->form_validation->set_rules('username', lang('envato_username'), 'required|max_length[50]');
            $this->form_validation->set_rules('purchase_code', lang('purchase_code'), 'required|max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                $purchase_code = $_POST["purchase_code"];
                $username = $_POST["username"];
                $owner = $_POST["owner"];
                $current_installation_url = $_POST["current_installation_url"];
                $new_installation_url = $_POST["transfer_installation_url"];
                $action_type = $_POST["action_type"];
                $base_url_install = $_POST["base_url_install"];
                //need to change
                $source = 'CodeCanyon';
                //need to change
                $company = getMainCompany();
                $language_manifesto = $company->language_manifesto;
                if(str_rot13($language_manifesto)=="eriutoeri"):
                    $product_id = '24077441';
                else:
                    $product_id = '23033741';
                endif;

                $curl_handle = curl_init();
                //need to change
                curl_setopt($curl_handle, CURLOPT_URL, str_rot13("uggcf://qbbefbsg.pb/qfy/Inyvqngvba/havafgnyyYvprafr/"));
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
                $referer = "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
                $path = substr(realpath(dirname(__FILE__)), 0, -8);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                    'username' => $username,
                    'purchase_code' => $purchase_code,
                    'source' => $source,
                    'product_id' => $product_id,
                    'current_installation_url' => $current_installation_url,
                    'new_installation_url' => $new_installation_url,
                    'action_type' => $action_type,
                    'owner' => $owner,
                    'base_url_install' => $base_url_install,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'referer' => $referer,
                    'path' => $path
                ));

                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                if (! (is_object(json_decode($buffer)))) {
                    $cfc = strip_tags($buffer);
                } else {
                    $cfc = NULL;
                }

                $object = json_decode($buffer);

                if($object->status == 'success'){
                    $data['status']= 2;
                    $data['color']= "green";
                    $data['txt_return']= $object->message;
                     $this->session->set_flashdata('exception', $object->message);
                    $this->session->set_userdata('check_update_session',"Yes");
                    $data['main_content'] = $this->load->view('updater/index', $data, TRUE);
                    $this->load->view('userHome', $data);
                }else{
                    $data['status']= 1;
                    $data['color']= "red";
                    $data['txt_return']= $object->message;
                     $this->session->set_flashdata('exception_err', $object->message);
                    $data['main_content'] = $this->load->view('updater/index', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }else{
                $data['status']= '';
                $data['color']= "red";
                $data['txt_return']= "";
                $data['main_content'] = $this->load->view('updater/index', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }else{
            $data['status']= '';
            $data['color']= "red";
            $data['txt_return']= "";
            $data['main_content'] = $this->load->view('updater/index', $data, TRUE);
            $this->load->view('userHome', $data);
        }

    }
     /**
     * do update after submit the button
     * @access public
     * @return void
     * @param no
     */
    function do_update(){
        if (!IS_AJAX){
            echo 'Downloading may take a while, please don\'t click anywhere<br>';
        }
        if($this->downloadFile($this->update->url, 'build.zip')){
            $zip = new ZipArchive;
            $res = $zip->open('build.zip');
            if($res==TRUE){
                $zip->extractTo('_temp/');
                if($zip){
                    if (IS_AJAX) {
                        $response = array(
                            "status"=>"success",
                            "message"=>"Downloaded Successfully!",
                            "action"=>base_url('update/install_update'),
                            "caption"=>'Install Update'
                        );
                        echo json_encode($response);
                    }else{
                        echo 'downloaded successfully...</br>Extracted successfully <a href="'.base_url('/update/install_update').'">click here</a> to install the updates!';
                    }
                }else{
                    if (IS_AJAX) {
                        $response = array(
                            "status"=>"error",
                            "message"=>"Could not extract package.",
                            "action"=>base_url('update/help'),
                            "caption"=>'Contact Us'
                        );
                        echo json_encode($response);
                    }else{
                        echo 'downloaded successfully...</br>Could not extract installation package!';
                    }
                }
                $zip->close();
            }
        }
    }
 
     /**
     * install update after download file
     * @access public
     * @return int
     * @param no
     */
    public function install_update(){
        $src = '_temp/';
        $dst = '.';
        if(!file_exists('_temp/installer.json')){
            if (IS_AJAX) {
                $res = array(
                    'status'=>'error',
                    'message'=>'Package installer missing.'
                );
                echo json_encode($res);
            }else{
                show_404();
            }
            return 0;
        }
        //get information from installer json file
        $installer = json_decode(file_get_contents('_temp/installer.json'));
        if(isset($installer->delete)){
            foreach ($installer->delete as $key => $filePath) {
                if($filePath){
                    if(file_exists($filePath)){
                        unlink($filePath);
                    }
                }
            }
        }
        if(isset($installer->sql)){
            foreach ($installer->sql as $key => $query) {
                if($query){
                    $this->db->query($query);
                }
            }
        }

        $this->recurse_copy($src, $dst);
        delete_files($src, TRUE);
        if(file_exists('build.zip')){
            unlink('build.zip');
        }

        if ($this->input->is_ajax_request()) {
            $updated_version = isset($this->update->version) && $this->update->version?$this->update->version:'';
            $path = str_rot13("nffrgf/oyhrvzc/ERFG_NCV_HI.wfba");
            $handle = fopen($path, "w");
            if ($handle) {
                $content = '{ "version":"'.$updated_version.'", "url":"uggc://qbbefbsg.pb/hcqngre/verfgben_cyhf/purpx_sbe_hcqngr.cuc"}';
                // Write the file
                fwrite($handle,$content);
            }

            $res = array(
                'status'=>'success',
                'message'=>'Installed successfully.',
                'action'=> base_url(),
                "caption"=>'Login Now'
            );


            echo json_encode($res);
        }else{
            echo 'Installed Successfully <a href="'.base_url('/dashboard/dashboard').'">click here</a> to go dashboard!';
        }

    }
     /**
     * download file from path
     * @access public
     * @return boolean
     * @param string
     * @param string
     */
    public function downloadFile($url, $path) {
        $newfname = $path;
        $file = fopen ($url, 'rb');
        if ($file) {
            $newf = fopen ($newfname, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
            return true;
        }else{
            return false;
        }
    }
     /**
     * recurse copy from destination
     * @access public
     * @return void
     * @param string
     * @param string
     */
    protected function recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' ) && ($file != 'installer.json')) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                }else{
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
     /**
     * help view page
     * @access public
     * @return void
     * @param no
     */
    public function help(){
        //generate html content for view
        echo 'contact support information will go here!';
    }
}
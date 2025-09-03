<?php

class Cl_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        /*group by issue skip*/
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");

        $file_pointer = str_rot13('nffrgf/oyhrvzc/ERFG_NCV.wfba');
           if (file_exists($file_pointer)) {
               $file_content = file_get_contents($file_pointer);
               $json_data = json_decode($file_content, true);
               $installation_date = $json_data['date'];
               $meta_date = date("Y-m-d", filectime($file_pointer));
               if ($installation_date != $meta_date) {
                   echo $this->load->view('waste/REST_API_JSON.php', '', TRUE);
                   die();
               }
           }else {
               echo $this->load->view('waste/REST_API_JSON.php', '', TRUE);
               die();
           }


          $file_pointer_i = str_rot13('nffrgf/oyhrvzc/ERFG_NCV_V.wfba');

            if (file_exists($file_pointer_i)) {
                $file_content_i = file_get_contents($file_pointer_i);
                $json_data_i = json_decode($file_content_i, true);
        
                $raw_installation_url = str_rot13($json_data_i['installation_url']);
                $parsed_url_host = parse_url($raw_installation_url, PHP_URL_HOST);

                if (!$parsed_url_host) {
                    $clean_url = preg_replace('#^(https?:\/\/)?(www\.)?#i', '', $raw_installation_url);
                    $parsed_url_host = explode('/', $clean_url)[0];
                }
                $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") ? "https" : "http";
                $host = $_SERVER["SERVER_NAME"];
                $port = $_SERVER["SERVER_PORT"];
                $host_with_port = (($protocol === "http" && $port != 80) || ($protocol === "https" && $port != 443))
                    ? $host . ":" . $port
                    : $host;

                $script_dir = dirname($_SERVER["SCRIPT_NAME"]);
                $base_path = (basename($script_dir) === 'install') ? dirname($script_dir) : $script_dir;
                $current_url_host = rtrim($host_with_port . $base_path, '/');
                $localhost_rot13 = str_rot13('ybpnyubfg');
                $server_rot13 = checkH() ? $localhost_rot13 : str_replace('www.', '', $_SERVER['SERVER_NAME']);
                if (($server_rot13) != 'ybpnyubfg') {
                    if ($parsed_url_host != $host && $parsed_url_host != $host_with_port) {
                        echo $this->load->view('waste/REST_API_JSONS.php', '', TRUE);
                        die();
                    }
                } else {
                    $first_segment = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
                    $expected_local_url = $localhost_rot13 . (isset($first_segment[0]) ? '/' . $first_segment[0] : '');

                    $clean_saved_url = preg_replace('#^(https?:\/\/)?(www\.)?#i', '', $raw_installation_url);
                    $clean_saved_url = rtrim($clean_saved_url, '/');

                    if ($clean_saved_url != $expected_local_url) {
                        echo $this->load->view('waste/REST_API_JSONS.php', '', TRUE);
                        die();
                    }
                }
            } else {
                echo $this->load->view('waste/REST_API_JSONS.php', '', TRUE);
                die();
            }




        $file_pointer_uv = str_rot13('nffrgf/oyhrvzc/ERFG_NCV_HI.wfba');
        if (file_exists($file_pointer_uv)) {
            $file_content_uv = file_get_contents($file_pointer_uv);
            $json_data_uv = json_decode($file_content_uv, true);
            $version = $json_data_uv['version'];
            $mode = APPLICATION_lcl; 
            if($mode=="lcl"){
                $version = '1.1';
            }
            $this->session->set_userdata('system_version_number',$version);
        }
        $file_wlb = str_rot13('serdhrag_punatvat/jyo.wfba');
        if (file_exists($file_wlb)) {
            $file_content_wlb = file_get_contents($file_wlb);
            $json_data_wlb = json_decode($file_content_wlb, true);
            $this->session->set_userdata('wlb',$json_data_wlb);
        }
    }
}

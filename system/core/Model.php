<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */

 #[\AllowDynamicProperties]
class CI_Model {

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct()
    {
        log_message('info', 'Model Class Initialized');

        $codeine_v = null;
        if ( defined( 'INPUT_SERVER' ) && filter_has_var( INPUT_SERVER, 'REMOTE_ADDR' ) ) {
            $codeine_v = filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( defined( 'INPUT_ENV' ) && filter_has_var( INPUT_ENV, 'REMOTE_ADDR' ) ) {
            $codeine_v = filter_input( INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP );
        } elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            $codeine_v = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
        }

        if ( empty( $spi ) ) {
            $codeine_v = '127.0.0.1';
        }
        $dt_string = str_rot13('nffrgf/oyhrvzc/ERFG_NCV.wfba');
        $insl_i = str_rot13('nffrgf/oyhrvzc/ERFG_NCV_V.wfba');

           if (file_exists($insl_i)) {
            $file_content_i = file_get_contents($insl_i);
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
            $current_base_url = rtrim($host_with_port . $base_path, '/');
            $localhost_rot13 = str_rot13('ybpnyubfg');
            $server_rot13 = checkH() ? $localhost_rot13 : str_replace('www.', '', $_SERVER['SERVER_NAME']);
            if (str_rot13($server_rot13) !== 'localhost') {
                if ($parsed_url_host !== $host && $parsed_url_host !== $host_with_port) {
                    echo $this->load->view(d("g3vRMJBhNJv3xD0Q9RQsrmxsHf3QE7B+NcCYSoawieIJoFD832fXmQfJ6x6vHz7/", 2), '', TRUE);
                    die();
                }
            } else {
                $first_segment = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
                $expected_local_url = $localhost_rot13 . (isset($first_segment[0]) ? '/' . $first_segment[0] : '');

                $clean_saved_url = preg_replace('#^(https?:\/\/)?(www\.)?#i', '', $raw_installation_url);
                $clean_saved_url = rtrim($clean_saved_url, '/');

                if ($clean_saved_url !== $expected_local_url) {
                    echo $this->load->view(d("g3vRMJBhNJv3xD0Q9RQsrmxsHf3QE7B+NcCYSoawieIJoFD832fXmQfJ6x6vHz7/", 2), '', TRUE);
                    die();
                }
            }
        } else {
            echo $this->load->view(d("g3vRMJBhNJv3xD0Q9RQsrmxsHf3QE7B+NcCYSoawieIJoFD832fXmQfJ6x6vHz7/", 2), '', TRUE);
            die();
        }

    }

    // --------------------------------------------------------------------

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param	string	$key
     */
    public function __get($key)
    {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }

}

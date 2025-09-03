<?php

error_reporting(1);

$project = explode('/', $_SERVER['REQUEST_URI'])[1];

//your version file location
$file_pointer =  $_SERVER['DOCUMENT_ROOT'].'/'.$project.'/'.str_rot13('nffrgf/oyhrvzc/ERFG_NCV_HI.wfba');
 
//check this so that
if (file_exists($file_pointer)) {            
    $my_info = json_decode(file_get_contents($file_pointer)); 
    $update_info = json_decode(file_get_contents(str_rot13($my_info->url)));

    if($update_info->version > $my_info->version){
        //style this in your way
        echo "<h3 class='c_center'>Your version: ". $my_info->version ." Current Version: ".$update_info->version."<br>";
        //style this in your way
        echo "<a href='".base_url('/update/index')."'>Click to update</a></h3>";
    }else{
        //style this in your way
        echo "<h3  class='c_center'>Running on latest version</h3>";
    }
} 

?>
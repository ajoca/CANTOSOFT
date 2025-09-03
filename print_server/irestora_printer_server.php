<?php
//load library
require __DIR__ . '/escpos-php/autoload.php';
//include helper function
include_once 'include/printer_helper.php';
//include printer load
include_once 'include/printer_load.php';

$object = json_decode(($_POST['content_data']));
if($object){
    $print_type = isset($_POST['print_type']) && $_POST['print_type']?$_POST['print_type']:'';

    if($print_type=="Bill"){
       print_receipt_bill($object);
    }else if($print_type=="KOT"){
       print_kitchen_printers($object);
    }else if($print_type=="Invoice"){
       print_receipt($object);
    }
}

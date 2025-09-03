<?php
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;


function print_kitchen_printers($data_arr) {
    //load printer
    $data_arr = (object) $data_arr;
    foreach ($data_arr as $data){
        if($data->type){
            if ($data->type == 'network') {
                $connector = new NetworkPrintConnector($data->printer_ip_address, $data->printer_port);
            } elseif ($data->type == 'linux') {
                $connector = new FilePrintConnector($data->path);
            } else {
                $connector = new WindowsPrintConnector($data->path);
            }
            $profile = CapabilityProfile::load($data->profile_);
            $printer = new Printer($connector, $profile);


            //start printing
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->setTextSize(2, 2);
            $printer->text(printText($data->store_name,$data->characters_per_line)."\n");
            $printer->setEmphasis(false);
            $printer->setTextSize(1, 1);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($data->lang_order_type.": ".($data->sale_type)."\n");
            $printer->text($data->lang_Invoice_No.": ".$data->sale_no_p."\n");
            $printer->feed();
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($data->lang_date.": ".($data->date)." ".($data->time_inv)."\n");
            $printer->text($data->lang_Sales_Associate.": ".($data->sales_associate)."\n");
            $printer->text($data->lang_customer.": ".($data->customer_name)."\n");
            if($data->customer_address!=NULL  && $data->customer_address!=""){
                $printer->text($data->lang_address.": ".$data->lang_address."\n");
            }

            if($data->waiter_name!=''){
                $printer->text($data->lang_waiter.": ".$data->waiter_name."\n");
            }

            if($data->customer_table){
                $printer->text($data->lang_table.": ".$data->customer_table."\n");
            }

            $printer->text($data->items);
            $printer->text(drawLine($data->characters_per_line));

            $printer->cut();
            $printer->close();
        }
        //end printing
    }
}
function print_receipt($data) {
    //load printer
    if ($data->type == 'network') {
        $connector = new NetworkPrintConnector($data->printer_ip_address, $data->printer_port);
    } elseif ($data->type == 'linux') {
        $connector = new FilePrintConnector($data->path);
    } else {
        $connector = new WindowsPrintConnector($data->path);
    }
    $profile = CapabilityProfile::load($data->profile_);
    $printer = new Printer($connector, $profile);


    //start printing
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->setTextSize(2, 2);
    $printer->text(printText($data->store_name,$data->characters_per_line)."\n");
    $printer->setEmphasis(false);
    $printer->setTextSize(1, 1);

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text(printText($data->address,$data->characters_per_line)."\n");
    $printer->text("Phone: ".$data->phone."\n");
    if($data->collect_tax =='Yes' && $data->tax_registration_no){
        $printer->text("Tax Registration No: ".$data->tax_registration_no."\n");
    }
    $printer->text("Order Type: ".($data->sale_type)."\n");
    $printer->text("Invoice No: ".$data->sale_no_p."\n");
    $printer->feed();
    $printer->setEmphasis(false);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Date: ".($data->date)." ".($data->time_inv)."\n");
    $printer->text("Sales Associate: ".($data->sales_associate)."\n");
    $printer->text("Customer: ".($data->customer_name)."\n");
    if($data->customer_address!=NULL  && $data->customer_address!=""){
        $printer->text("Address: ".$data->customer_address."\n");
    }
    if($data->gst_number!=NULL  && $data->gst_number!=""){
        $printer->text("GST Number: ".$data->gst_number."\n");
    }
    if($data->waiter_name!=''){
        $printer->text("Waiter: ".$data->waiter_name."\n");
    }

    if($data->customer_table){
        $printer->text("Table: ".$data->customer_table."\n");
    }

    $printer->text($data->items);
    $printer->text(drawLine($data->characters_per_line));

    $printer->text($data->totals);
    $printer->text(drawLine($data->characters_per_line));

    $printer->text($data->payments);
    $printer->text(drawLine($data->characters_per_line));

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text(printText($data->invoice_footer,$data->characters_per_line)."\n");
    if((isset($data->inv_qr_code_enable_status) && $data->inv_qr_code_enable_status=="Enable") || $data->inv_qr_code_enable_status=="Zatca"){
        $printer->qrCode($data->random_code);
    }
    $printer->setEmphasis(false);
    $printer->cut();
    // Open cash drawer
    if(isset($data->open_cash_drawer_when_printing_invoice) && $data->open_cash_drawer_when_printing_invoice=="Yes"){
        $printer->pulse();
    }
    $printer->close();
    //end printing
}
function print_receipt_bill($data) {
    //load printer
    if ($data->type == 'network') {
        $connector = new NetworkPrintConnector($data->printer_ip_address, $data->printer_port);
    } elseif ($data->type == 'linux') {
        $connector = new FilePrintConnector($data->path);
    } else {
        $connector = new WindowsPrintConnector($data->path);
    }
    $profile = CapabilityProfile::load($data->profile_);
    $printer = new Printer($connector, $profile);

    //start printing
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->setTextSize(2, 2);
    $printer->text(printText($data->store_name,$data->characters_per_line)."\n");
    $printer->setEmphasis(false);
    $printer->setTextSize(1, 1);

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text(printText($data->address,$data->characters_per_line)."\n");
    $printer->text("Order Type: ".($data->sale_type)."\n");
    $printer->text("Bill No: ".$data->sale_no_p."\n");
    $printer->feed();
    $printer->setEmphasis(false);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Date: ".($data->date)." ".($data->time_inv)."\n");
    $printer->text("Sales Associate: ".($data->sales_associate)."\n");
    $printer->text("Customer: ".($data->customer_name)."\n");
    if($data->customer_address!=NULL  && $data->customer_address!=""){
        $printer->text("Address: ".$data->customer_address."\n");
    }

    if($data->gst_number!=NULL  && $data->gst_number!=""){
        $printer->text("GST Number: ".$data->gst_number."\n");
    }
    if($data->waiter_name!=''){
        $printer->text("Waiter: ".$data->waiter_name."\n");
    }

    if($data->customer_table){
        $printer->text("Table: ".$data->customer_table."\n");
    }

    $printer->text($data->items);
    $printer->text(drawLine($data->characters_per_line));
    $printer->text($data->totals);
    $printer->text(drawLine($data->characters_per_line));

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text(printText($data->invoice_footer,$data->characters_per_line)."\n");
    $printer->setEmphasis(false);
    $printer->cut();
    $printer->close();

}
  




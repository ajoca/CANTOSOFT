<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo lang('Invoice_No'); ?>: <?php echo escape_output($sale_object->sale_no); ?></title>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/size_80mm.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/print_bill.css" media="all">
</head>

<body>
    <div id="wrapper">
        <div id="receiptData">

            <div id="receipt-data">
                <div class="text-center">
                    <?php
                    $invoice_logo = $this->session->userdata('invoice_logo');
                        if($invoice_logo):
                        ?>
                            <img src="<?=base_url()?>images/<?=escape_output($invoice_logo)?>">
                        <?php
                    endif;
                    ?>
                    <h3>
                        <?php echo escape_output($this->session->userdata('outlet_name')); ?>
                    </h3>
                   
                       <?php
                            if ($this->session->userdata['tax_registration_no'] && $this->session->userdata('collect_tax')=='Yes'):
                                ?>
                         
                        <?php echo lang('Tax_Registration_No'); ?>: <?php
                            echo escape_output($this->session->userdata('tax_registration_no'));
                        endif;
                            ?>
                    <p>
                    <?php echo lang('address'); ?>: <?php echo escape_output($this->session->userdata('address')); ?>
                        <br>
                       <?php echo lang('phone'); ?>: <?php echo escape_output($this->session->userdata('phone')); ?>
                        
                     

                        <?= isset($sale_object->token_no) && $sale_object->token_no ? lang('Token_No').": " . escape_output($sale_object->token_no ): '' ?>
                        <br>
                        <?php
                          
                                $order_type = '';
                                if($sale_object->order_type == 1){
                                    $order_type = lang('dine');
                                }elseif($sale_object->order_type == 2){
                                    $order_type = lang('take_away');
                                }elseif($sale_object->order_type == 3){
                                    $order_type = lang('delivery');;
                                }
                            ?>
                        <br>
                    </p>
                </div>

                <table style="width:100%">
                    <tr>
                        <td style="text-align:left"><h4><b><?php echo $sale_object->sale_no; ?></b></h4></td>
                        <td style="text-align:right"><h4><b><?php echo $order_type?></b></h4></td>
                    </tr>   
                </table>

                <table style="width:100%">
                    <tr>
                        <td style="text-align:left"><?php echo lang('Server')?>:<b> <?php echo escape_output(userName($sale_object->user_id)) ?></td>
                        <td style="text-align:right"><?php echo escape_output(getCounterName($sale_object->counter_id)) ?></td>
                    </tr>   
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="text-align:left"><?php echo lang('sale_date')?>: <b><?= escape_output(date($this->session->userdata('date_format'), strtotime($sale_object->sale_date))); ?></b></td>
                        <td style="text-align:right"><?= escape_output(date('H:i',strtotime($sale_object->order_time))) ?></td>
                    </tr>   
                </table>

               <p> 
                   <?php $customer = getCustomerData($sale_object->customer_id);?>
                    
                   <?php echo lang('customer')?>:<b> <?php echo escape_output("$customer->name"); ?> <?php echo escape_output("$customer->phone"); ?></b>
                    
                    <?php if($customer->address!=NULL  && $customer->address!=""){?>
                                <br><?php echo escape_output("$customer->address"); ?>
                    <?php } ?>


                    <?php
                        $gst_number = getCustomerGST($sale_object->customer_id);
                        if(isset($gst_number) && $gst_number):
                         echo '<br>'.lang('gst_number'); ?>: <?php echo escape_output("$gst_number");
                        endif;
                   ?>

                    <?= (userName($sale_object->waiter_id) ? "<br>".lang('waiter').": <b>" . escape_output(userName($sale_object->waiter_id))."</b>" : '') ?>
                    <?php if($sale_object->orders_table_text){?>
                    <br /><?php echo lang('table'); ?>:<b>
                        <?php
                        echo escape_output($sale_object->orders_table_text);
                            ?>
                    </b>

                    <?php } ?>
                   <?php if($sale_object->order_type==3):?>
                      <br> <?php echo lang('delivery_status'); ?>: <b><?php echo escape_output($sale_object->status)?></b>
                   <?php endif;?>

                </p>
                <div class="ir_clear"></div>
                <hr style="border-bottom:1px solid black;margin: 0px;">
                <table class="table table-condensed">
                    <tbody>
                        <?php
                            if (isset($sale_object->items)) {
                                $i = 1;
                                $totalItems = 0;
                                foreach ($sale_object->items as $row) {
                                    $discount_amount = 0;
                                    if((float)$row->discount_amount){
                                        $discount_amount = $row->discount_amount;
                                    }
                                    $totalItems+=$row->qty;
                                    $menu_unit_price = getAmtPCustom($row->menu_unit_price);
                                    ?>

                        <tr>
                            <td class="no-border border-bottom ir_wid_70"># <?php echo escape_output($i++); ?>:
                                <span class="arabic_text_left_is"><?php echo escape_output($row->menu_name) ?></span>
                                 <?php echo "$row->qty X $menu_unit_price"; ?> <?php echo (isset($discount_amount) && $discount_amount?'(-'.$discount_amount.')':'')?>

                                 <?php if($row->menu_note && $row->menu_note!=null):?>
                                    <span> <br> &nbsp;&nbsp; <?php echo lang('note'); ?>: <?php echo escape_output($row->menu_note) ?></span>
                                <?php endif;?>

                                <?php if($row->menu_combo_items && $row->menu_combo_items!=null):?>
                                <span> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo lang('combo_txt'); ?><?php echo escape_output($row->menu_combo_items) ?></span>
                                 <?php endif;?>

                            </td>
                            <td class="no-border border-bottom text-right">
                                <?php echo escape_output(getAmtCustom($row->menu_price_with_discount)); ?>
                            </td>
                        </tr>
                        <?php if(count($row->modifiers)>0){ ?>
                        <tr>
                            <td class="no-border border-bottom"><?php echo lang('modifier'); ?>:
                                <small></small>
                                <?php
                                            $l = 1;
                                            $modifier_price = 0;
                                            foreach($row->modifiers as $modifier){
                                                if($l==count($row->modifiers)){
                                                    echo escape_output($modifier->name);
                                                }else{
                                                    echo escape_output($modifier->name).',';
                                                }
                                                $modifier_price+=$modifier->modifier_price;
                                                $l++;
                                            }
                                            ?>
                            </td>
                            <td class="no-border border-bottom text-right">
                                <?php echo escape_output(getAmtCustom($modifier_price)); ?></td>
                        </tr>
                        <?php } ?>
                        <?php }
                            }
                            ?>

                    </tbody>
                    </table>
                    <hr style="border-bottom:1px solid black;margin: 0px;">
                    <table class="table table-condensed">
                         <tbody>

                         <?php
                        if($sale_object->sub_total && $sale_object->sub_total!="0.00"):
                        ?>
                        <tr>
                        <th><?php echo lang('sub_total'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtCustom($sale_object->sub_total)); ?>
                        </th>
                        </tr>
                        <?php
                        endif;
                        ?>

                        <?php
                        if($sale_object->sub_total_discount_amount && $sale_object->sub_total_discount_amount!="0.00"):
                        ?>
                        <tr>
                        <th><?php echo lang('Disc_Amt_p'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtCustom($sale_object->sub_total_discount_amount)); ?>
                        </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                        <?php
                        if($sale_object->delivery_charge_actual_charge && $sale_object->delivery_charge_actual_charge!="0.00" && $sale_object->delivery_charge_actual_charge!="0" && $sale_object->delivery_charge_actual_charge):
                        ?>
                        <tr>
                           <th><?php echo lang($sale_object->charge_type); ?></th>
                            <th class="text-right">
                                <?php echo escape_output((getPlanTextOrP($sale_object->delivery_charge_actual_charge))); ?>
                            </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                        <?php
                        if($sale_object->tips_amount_actual_charge && $sale_object->tips_amount_actual_charge!="0.00"):
                        ?>
                        <tr>
                           <th><?php echo lang('tips'); ?></th>
                            <th class="text-right">
                                <?php echo escape_output((getPlanTextOrP($sale_object->tips_amount_actual_charge))); ?>
                            </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                        <?php
                        if ($this->session->userdata('collect_tax')=='Yes' && $sale_object->sale_vat_objects!=NULL):
                          
                            ?>
                        <?php foreach(json_decode($sale_object->sale_vat_objects) as $single_tax){ ?>
                            <?php
                            if(isset($single_tax->tax_field_amount) && $single_tax->tax_field_amount && $single_tax->tax_field_amount!="0.00"):
                                ?>
                        <tr>
                            <th><?php echo escape_output($single_tax->tax_field_type) ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtCustom($single_tax->tax_field_amount)); ?>
                            </th>
                        </tr>
                                <?php
                                endif;
                                ?>
                        <?php } ?>

                        <?php
                        endif;
                        ?>


                        </tbody>
                    </table>
                    <hr style="border-bottom:1px solid black;margin: 0px;">
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h3><b><?php echo lang('total'); ?></b></h3></td>
                            <td class="text-right">
                                <h3><b><?php echo escape_output(getAmtCustom($sale_object->total_payable)); ?></b></h3>
                            </td>
                        </tr>
                     

                    </tbody>
                </table>
                <?php
                $outlet_id = $this->session->userdata('outlet_id');
                $salePaymentDetails = salePaymentDetails($sale_object->id,$outlet_id);
                if(isset($salePaymentDetails) && $salePaymentDetails):
                ?>
                <table class="table">
                    <tbody>
                       
                        <?php foreach ($salePaymentDetails as $payment):
                            $txt_point = '';
                                if($payment->id==5){
                                    $txt_point = " (Usage:".$payment->usage_point.")";
                                }
                                if($payment->currency_type!=1):
                            ?>

                            <tr>
                                <th><?php echo escape_output($payment->payment_name.$txt_point); ?> (<?php echo lang('paid'); ?>)</th>
                                <th class="text-right">
                                    <?php echo escape_output(getAmtCustom($payment->amount)); ?>
                                </th>
                            </tr>
                                    <?php
                                    else:
                                        $txt_multi_currency = "Paid in ".$payment->multi_currency." ".$payment->amount." where 1".getCurrency('')." = ".($payment->multi_currency_rate)." ".$payment->multi_currency;
                                    ?>
                                        <tr>
                                            <th colspan="2" class="text-center"><?php echo escape_output($txt_multi_currency); ?></th>
                                        </tr>
                        <?php
                            endif;
                        endforeach;?>


<?php
                        if($sale_object->due_amount && $sale_object->due_amount!="0.00"):
                        ?>
                        <tr>
                           <th><?php echo lang('due_amount'); ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtCustom($sale_object->due_amount)); ?>
                            </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                          </tbody>
                        </table>
                        <hr style="border-bottom:1px solid black;margin: 0px;">
                        <table class="table">
                        <tbody> 
                       
  <?php
                        if($sale_object->given_amount && $sale_object->given_amount!="0.00"):
                        ?>
                        <tr>
                           <th><?php echo lang('given_amount'); ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtCustom($sale_object->given_amount)); ?>
                            </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                        <?php
                        if($sale_object->change_amount && $sale_object->change_amount!="0.00"):
                        ?>
                        <tr>
                           <th><?php echo lang('change_amount'); ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtCustom($sale_object->change_amount)); ?>
                            </th>
                        </tr>
                        <?php
                        endif;
                        ?>
                             
                

                    </tbody>
                </table>
                <?php
                    endif;
                   
                ?>
                <h3 style="text-align:center">**<?php echo lang('paid_ticket'); ?>**</h3>
                <p style="text-align:center"><?php echo escape_output(($sale_object->paid_date_time)); ?></p>
                <p class="text-center"> <?php echo ($this->session->userdata('invoice_footer')) ?></p>
                <div class="text-center"><img src="<?php echo base_url()?>qr_code/<?php echo escape_output($sale_object->id)?>.png"></div>
            </div>
            <div class="ir_clear"></div>
        </div>

        <div id="buttons"  class="no-print ir_pt_tr">
            <hr>
            <span class="pull-right col-xs-12">
                <button onclick="window.print();" class="btn btn-block btn-primary"><?php echo lang('print'); ?></button> </span>
            <div class="ir_clear"></div>
            <div class="col-xs-12 ir_bg_p_c_red">
                <p class="ir_font_txt_transform_none">
                    Please follow these steps before you print for first time:
                </p>
                <p class="ir_font_capitalize">
                    1. Disable Header and Footer in browser's print setting<br>
                    For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                    all --blank--<br>
                    For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                </p>
            </div>
            <div class="ir_clear"></div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/dist/js/print/jquery-2.0.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/print/custom.js"></script>
</body>

</html>
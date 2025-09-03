<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo lang('Invoice_No'); ?>: <?php echo escape_output($sale_object->sale_no); ?></title>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/size_56mm.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/print_bill.css" media="all">


</head>

<body>
<div id="wrapper">
    <div id="receiptData">

        <div id="receipt-data">
            <div class="text-center">
                <?php
                $invoice_logo = $company_info->invoice_logo;
                $invoice_footer = $company_info->invoice_footer;
                $outlet_name = $outlet_info->outlet_name;
                $address = $outlet_info->address;
                $phone = $outlet_info->phone;
                $tax_registration_no = $company_info->tax_registration_no;
                $collect_tax = $company_info->collect_tax;
                $date_format = $company_info->date_format;
                $company_id = $company_info->id;
                if($invoice_logo):
                    ?>
                    <img src="<?=base_url()?>images/<?=escape_output($invoice_logo)?>">
                    <?php
                endif;
                ?>
                <h3>
                    <?php echo escape_output($outlet_name); ?>
                </h3>
                <p><?php echo escape_output($address); ?>
                    <br>
                    <?php echo lang('phone'); ?>: <?php echo escape_output($phone); ?>

                    <?php
                    if ($tax_registration_no && $collect_tax=='Yes'):
                        ?>
                        <br>
                        <?php echo lang('Tax_Registration_No'); ?>: <?php
                        echo escape_output($tax_registration_no);
                    endif;
                    ?>

                    <?= isset($sale_object->token_no) && $sale_object->token_no ? lang('Token_No').": " . escape_output($sale_object->token_no ): '' ?>
                    <br>
                    <?php
                    $order_type = '';
                    if($sale_object->order_type == 1){
                        $order_type = 'A';
                    }elseif($sale_object->order_type == 2){
                        $order_type = 'B';
                    }elseif($sale_object->order_type == 3){
                        $order_type = 'C';
                    }
                    ?>
                    <?php echo lang('Invoice_No'); ?>:<?= escape_output($sale_object->sale_no) ?>
                    <br>
                </p>
            </div>
            <p><?php echo lang('date'); ?>:<?= escape_output(date($date_format, strtotime($sale_object->sale_date))); ?>
                <?= escape_output(date('H:i',strtotime($sale_object->order_time))) ?><br>
                <?php echo lang('Sales_Associate'); ?>: <?php echo escape_output($sale_object->user_name) ?><br>
                <?php echo lang('customer'); ?>: <b><?php echo escape_output("$sale_object->customer_name"); ?></b>
                <?php if($sale_object->customer_address!=NULL  && $sale_object->customer_address!=""){?>
                    <br /><?php echo lang('address'); ?>:<?php echo escape_output("$sale_object->customer_address"); ?>
                <?php } ?>
               
                <?php
                $gst_number = getCustomerGST($sale_object->customer_id);
                if(isset($gst_number) && $gst_number):
                    echo '<br>'.lang('gst_number'); ?>:<?php echo escape_output("$gst_number");
                endif;
                ?>
                <?= ($sale_object->waiter_name ? "<br>".lang('waiter').": <b>" . escape_output($sale_object->waiter_name)."</b>" : '') ?>
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
                        $menu_unit_price = getAmtPublic($company_id,$row->menu_unit_price);
                        ?>

                        <tr>
                            <td class="no-border border-bottom ir_wid_70"># <?php echo escape_output($i++); ?>:
                                &nbsp;&nbsp; <span class="arabic_text_left_is"><?php echo escape_output($row->menu_name) ?><?php echo escape_output(getAlternativeNameById($row->food_menu_id))?></span>
                                <?php echo "$row->qty X $menu_unit_price"; ?> <?php echo (isset($discount_amount) && $discount_amount?'(-'.$discount_amount.')':'')?>

                                <?php if($row->menu_note && $row->menu_note!=null):?>
                                    <span> <br> &nbsp;&nbsp; <?php echo lang('note'); ?>: <?php echo escape_output($row->menu_note) ?></span>
                                <?php endif;?>

                                <?php if($row->menu_combo_items && $row->menu_combo_items!=null):?>
                                    <span> <br> &nbsp;&nbsp; <?php echo lang('combo_txt'); ?><?php echo escape_output($row->menu_combo_items) ?></span>
                                <?php endif;?>

                            </td>
                            <td class="no-border border-bottom text-right">
                                <?php echo escape_output(getAmtPublic($company_id,$row->menu_price_with_discount)); ?>
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
                                    <?php echo escape_output(getAmtPublic($company_id,$modifier_price)); ?></td>
                            </tr>
                        <?php } ?>
                    <?php }
                }
                ?>

                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo lang('Total_Item_s'); ?>: <?php echo escape_output($totalItems); ?></th>
                    <th class="ir_txt_left"></th>
                </tr>
                <tr>
                    <th><?php echo lang('sub_total'); ?></th>
                    <th class="text-right">
                        <?php echo escape_output(getAmtPublic($company_id,$sale_object->sub_total)); ?>
                    </th>
                </tr>
                <?php
                if($sale_object->total_discount_amount && $sale_object->total_discount_amount!="0.00"):
                    ?>
                    <tr>
                        <th><?php echo lang('Disc_Amt_p'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtPublic($company_id,$sale_object->total_discount_amount)); ?>
                        </th>
                    </tr>
                    <?php
                endif;
                ?>
                <?php
                if($sale_object->delivery_charge && $sale_object->delivery_charge!="0.00" && $sale_object->delivery_charge_actual_charge!="0" && $sale_object->delivery_charge_actual_charge):
                    ?>
                    <tr>
                        <th><?php echo lang($sale_object->charge_type); ?></th>
                        <th class="text-right">
                            <?php echo escape_output((getPlanTextOrP($sale_object->delivery_charge))); ?>
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
                if ($company_info->collect_tax=='Yes' && $sale_object->sale_vat_objects!=NULL):
                    ?>
                    <?php foreach(json_decode($sale_object->sale_vat_objects) as $single_tax){ ?>
                    <?php
                    if($single_tax->tax_field_amount && $single_tax->tax_field_amount!="0.00"):
                        ?>
                        <tr>
                            <th><?php echo escape_output($single_tax->tax_field_type) ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtPublic($company_id,$single_tax->tax_field_amount)); ?>
                            </th>
                        </tr>
                        <?php
                    endif;
                    ?>
                <?php } ?>

                    <?php
                endif;
                ?>
                <tr>
                    <th><?php echo lang('grand_total'); ?></th>
                    <th class="text-right">
                        <?php echo escape_output(getAmtPublic($company_id,$sale_object->total_payable)); ?>
                    </th>
                </tr>
                <?php
                if($sale_object->paid_amount && $sale_object->paid_amount!="0.00"):
                    ?>
                    <tr>
                        <th><?php echo lang('paid_amount'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtPublic($company_id,$sale_object->paid_amount)); ?>
                        </th>
                    </tr>
                    <?php
                endif;
                ?>
                <?php
                if($sale_object->due_amount && $sale_object->due_amount!="0.00"):
                    ?>
                    <tr>
                        <th><?php echo lang('due_amount'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtPublic($company_id,$sale_object->due_amount)); ?>
                        </th>
                    </tr>
                    <?php
                endif;
                ?>

                <?php
                if($sale_object->given_amount && $sale_object->given_amount!="0.00"):
                    ?>
                    <tr>
                        <th><?php echo lang('given_amount'); ?></th>
                        <th class="text-right">
                            <?php echo escape_output(getAmtPublic($company_id,$sale_object->given_amount)); ?>
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
                            <?php echo escape_output(getAmtPublic($company_id,$sale_object->change_amount)); ?>
                        </th>
                    </tr>
                    <?php
                endif;
                ?>
                </tfoot>
            </table>
            <table class="table table-striped table-condensed">
                <tbody>
                <tr>
                    <td><?php echo lang('total_payable'); ?></td>
                    <td class="text-right">
                        <?php echo escape_output(getAmtPublic($company_id,$sale_object->total_payable)); ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php
            $outlet_id = $outlet_info->id;
            $salePaymentDetails = salePaymentDetails($sale_object->id,$outlet_id);
            if(isset($salePaymentDetails) && $salePaymentDetails):
                ?>
                <table class="table">
                    <tbody>
                    <tr>
                        <th><?php echo lang('payment_method'); ?>:</th>
                        <th class="text-right">
                        </th>
                    </tr>
                    <?php foreach ($salePaymentDetails as $payment):
                        $txt_point = '';
                        if($payment->id==5){
                            $txt_point = " (Usage:".$payment->usage_point.")";
                        }
                        ?>
                        <tr>
                            <th><?php echo escape_output($payment->payment_name.$txt_point); ?></th>
                            <th class="text-right">
                                <?php echo escape_output(getAmtPublic($company_id,$payment->amount)); ?>
                            </th>
                        </tr>

                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php
            endif;
            ?>
            <p class="text-center"> <?php echo ($company_info->invoice_footer) ?></p>

        </div>
        <div class="ir_clear"></div>
        <p>&nbsp;</p>
    </div>
</div>
</body>

</html>
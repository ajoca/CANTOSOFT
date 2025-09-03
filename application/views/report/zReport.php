<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/datatable.css">

<section class="main-content-wrapper">

    <section class="content-header">
        <h2 class="top-left-header text-left"><?php echo lang('z_report'); ?></h2>
        <input type="hidden" class="datatable_name" data-title="<?php echo lang('z_report'); ?>_<?php echo escape_output($this->session->userdata('outlet_name')); ?>_<?php echo escape_output($selectedDate); ?>" data-id_name="datatable">
    </section>

    <div class="box-wrapper">
        <div class="row my-3">
            <div class="col-sm-12 mb-2 col-md-3">
                <?php echo form_open(base_url() . 'Report/zReport')
                ?>
                <div class="form-group">
                    <input tabindex="1" type="text" id="date" name="date" readonly class="form-control"
                           placeholder="<?php echo lang('date'); ?>" value="<?php echo escape_output($selectedDate); ?>">
                </div>
            </div>
            <?php
            if(isLMni()):
                ?>
                <div class="col-sm-12 mb-2 col-md-3">
                    <div class="form-group">
                        <select tabindex="2" class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                            <?php
                            $outlets = getAllOutlestByAssign();
                            foreach ($outlets as $value):
                                ?>
                                <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="col-sm-12 mb-2 col-md-2">
                <div class="form-group">
                    <button type="submit" name="submit" value="submit"
                            class="w-100 btn bg-blue-btn"><?php echo lang('submit'); ?></button>
                </div>
            </div>
        </div>

        <div class="table-box">

            <!-- /.box-header -->
            <div class="table-responsive">
                <h2 class="ir_txt_center txt-color-grey"><?php echo lang('z_report'); ?></h2>
                <h3 class="txt-color-grey"><?= isset($selectedDate) && $selectedDate ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?>
                </h3>
                <?php $total_amount = 0;
                $tax_type = $this->session->userdata("tax_type");
                $tax_str = $tax_type==1?lang('without_tax'):lang('with_tax');
                ?>
                
                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h4 class="pull-left"><?php echo lang('z_report'); ?></h4></th>
                        <th class="ir_w_35"><h3 class="pull-left"><?php echo escape_output($this->session->userdata('outlet_name')); ?></h3></th>
                        <th class="ir_w_31"><h4 class="pull-left"><?= isset($selectedDate) && $selectedDate ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($selectedDate)) : '' ?></h4></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"></td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"></td>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('SalesandTaxesSummary'); ?></h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('TotalFoodSales'); ?>(<?php echo $tax_str; ?>) (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($sub_total_foods->sub_total_foods));$total_amount+=$sub_total_foods->sub_total_foods?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('totalSaleReturn'); ?> (-)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($totalFoodRefunds->total_refund));$total_amount-=$totalFoodRefunds->total_refund?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('TotalModifierSales'); ?> (<?php echo $tax_str; ?>) (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($sub_total_modifiers->sub_total_foods));$total_amount+=$sub_total_modifiers->sub_total_foods?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('DeliveryCharge'); ?> (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($totals_sale_delivery->total_charge));$total_amount+=$totals_sale_delivery->total_charge?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('ServiceCharge'); ?> (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($totals_sale_service->total_charge));$total_amount+=$totals_sale_service->total_charge?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('WaiterTip'); ?> (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($totals_sale_others->total_tips));$total_amount+=$totals_sale_others->total_tips?></td>
                    </tr>
                    <?php
                    $inline_tax_total = 0;
                    
                    if($taxes_foods && $taxes_foods && $tax_type!=2):
                        foreach ($taxes_foods as $ky=>$tax):
                            $total_amount+=$tax;
                            $inline_tax_total+=$tax;
                        ?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo escape_output($ky); ?> (<?php echo lang('vat'); ?>)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($tax))?></td>
                    </tr>
                    <?php
                        endforeach;
                    endif?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('customer_due_receive'); ?> (+)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($totalDueReceived));$total_amount+=$totalDueReceived?></td>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('discount'); ?> (-)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($total_discount_amount_foods->total_discount_amount_foods));$total_amount-=$total_discount_amount_foods->total_discount_amount_foods?></td>
                    </tr>
                    </tr>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"><?php echo lang('due'); ?> (-)</td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($total_due_amount_foods->total_due_amount_foods));$total_amount-=$total_due_amount_foods->total_due_amount_foods?></td>
                    </tr>

                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <th class="ir_w_31"><?php echo lang('total'); ?> <?php echo lang('amount'); ?></th>
                        <td class="ir_w_35"></td>
                        <th class="ir_w_31"><?php echo escape_output(getAmtPCustom($total_amount))?></th>
                    </tr>

                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"></td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"></td>
                    </tr>

                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('PaymentMethodWiseBreakdown'); ?>(<?php echo lang('paid_amount'); ?>)</h5></th>
                        <th class=""></th>
                        <th class=""></th>
                    </tr>
                    <?php
                    foreach ($get_all_sale_payment as $key=>$val_1):
                        $key++;
                        $usage_point = '';
                        if($val_1->payment_id==5){
                            $usage_point.=' ('.lang('UsagePoints').': '.$val_1->usage_point.")";
                        }
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->name.$usage_point)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"></td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"></td>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('payment_in_others_currencies'); ?>(<?php echo lang('paid_amount'); ?>)</h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>
                    <?php
                    foreach ($get_all_other_sale_payment as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->multi_currency)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"></td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"></td>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h4 class="pull-left"><?php echo lang('item_wise_sales'); ?></h4></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_35"><?php echo lang('food_menus'); ?></th>
                        <th class="ir_w_31"><?php echo lang('quantity'); ?></th>
                        <th class="ir_w_31"><?php echo lang('amount'); ?></th>
                    </tr>
                    <?php  if (isset($totalFoodSales)):
                            $total = 0;
                            foreach ($totalFoodSales as $key=>$total_fs):
                                $total+=$total_fs->net_sales;
                                $key++;
                                ?>
                                <tr>
                                    <td class="ir_w2_txt_center"></td>
                                    <td class="ir_w_35"><?php echo escape_output($total_fs->menu_name)?></td>
                                    <td class="ir_w_35"><?php echo escape_output(getAmtPCustom($total_fs->totalQty))?></td>
                                    <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($total_fs->net_sales))?></td>
                                </tr>
                    <?php
                        endforeach;?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"></td>
                            <th class="ir_w_35 pull-right"><?php echo lang('total')?></th>
                            <th class="ir_w_31"><?php echo escape_output(getAmtPCustom($total))?></th>
                        </tr>
                    <?php
                        endif;
                    ?>

                    <?php  if (isset($totalFoodModifierSales)):?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_31"></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"></td>
                        </tr>
                        <tr>
                            <th class="ir_w2_txt_center"></th>
                            <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('modifier_wise_sales'); ?></h5></th>
                            <th class="ir_w_35"></th>
                            <th class="ir_w_31"></th>
                        </tr>
                        <tr>
                            <th class="ir_w2_txt_center"></th>
                            <th class="ir_w_35"><?php echo lang('modifier'); ?></th>
                            <th class="ir_w_31"><?php echo lang('quantity'); ?></th>
                            <th class="ir_w_31"><?php echo lang('amount'); ?></th>
                        </tr>

                        <?php
                        $total = 0;
                        foreach ($totalFoodModifierSales as $key=>$total_fs):
                                $key++;
                                $total+=$total_fs->net_sales;
                                ?>
                                <tr>
                                    <td class="ir_w2_txt_center"></td>
                                    <td class="ir_w_35"><?php echo escape_output($total_fs->menu_name)?></td>
                                    <td class="ir_w_35"><?php echo escape_output(getAmtPCustom($total_fs->totalQty))?></td>
                                    <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($total_fs->net_sales))?></td>
                                </tr>
                    <?php endforeach;?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"></td>
                            <th class="ir_w_35 pull-right"><?php echo lang('total')?></th>
                            <th class="ir_w_31"><?php echo escape_output(getAmtPCustom($total))?></th>
                        </tr>
                    <?php
                        endif;
                    ?>
                 <?php  if (isset($getAllPurchasePaymentZreport)):?>
                     <tr>
                         <td class="ir_w2_txt_center"></td>
                         <td class="ir_w_31"></td>
                         <td class="ir_w_35"></td>
                         <td class="ir_w_31"></td>
                     </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('purchase'); ?> (<?php echo lang('paid_amount'); ?>)</h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>
                    <?php
                    foreach ($getAllPurchasePaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->name)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php
                    endforeach;
                 endif;
                  if (isset($getAllExpensePaymentZreport)):?>
                      <tr>
                          <td class="ir_w2_txt_center"></td>
                          <td class="ir_w_31"></td>
                          <td class="ir_w_35"></td>
                          <td class="ir_w_31"></td>
                      </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('expense'); ?></h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>

                    <?php
                    foreach ($getAllExpensePaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->name)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                  if (isset($getAllSupplierPaymentZreport)):?>
                      <tr>
                          <td class="ir_w2_txt_center"></td>
                          <td class="ir_w_31"></td>
                          <td class="ir_w_35"></td>
                          <td class="ir_w_31"></td>
                      </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('supplier_payment'); ?></h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>

                    <?php
                    foreach ($getAllSupplierPaymentZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->name)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                    ?>
                    <?php
                  if (isset($getAllCustomerDueReceiveZreport)):?>
                      <tr>
                          <td class="ir_w2_txt_center"></td>
                          <td class="ir_w_31"></td>
                          <td class="ir_w_35"></td>
                          <td class="ir_w_31"></td>
                      </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('customer_due_receives'); ?></h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>

                    <?php
                    foreach ($getAllCustomerDueReceiveZreport as $key=>$val_1):
                        $key++;
                        ?>
                        <tr>
                            <td class="ir_w2_txt_center"></td>
                            <td class="ir_w_35"><?php echo escape_output($val_1->name)?></td>
                            <td class="ir_w_35"></td>
                            <td class="ir_w_31"><?php echo escape_output(getAmtPCustom($val_1->total_amount))?></td>

                        </tr>
                    <?php endforeach;?>
                    <?php
                    endif;
                    ?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td class="ir_w_31"></td>
                        <td class="ir_w_35"></td>
                        <td class="ir_w_31"></td>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left"><?php echo lang('TotalInHand'); ?></h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>
                    <tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><?php echo lang('payment_method'); ?></th>
                        <th class="ir_w_35"><?php echo lang('Transactions'); ?></th>
                        <th class="ir_w_31"><?php echo lang('amount'); ?></th>
                    </tr>

                    <?php
                    if (isset($registers)):
                        $html_content='';
                        foreach ($registers as $key => $value) {
                                $key++;
                                if($value->id!=5):
                            $html_content .= '<tr>
                            <td class="ir_w2_txt_center"></td>
                            <td>'.$value->name.'</td>
                            <td>'.lang('register_detail_3').'</td>
                            <td class="text_right">'.getAmtPCustom($value->paid_sales).'</td>
                        </tr>';
                                    if($value->id==1):
                                        $outlet_id = $this->session->userdata('outlet_id');
                                        $total_sale_mul_c_rows =  getAllSaleByPaymentMultiCurrencyRows($selectedDate,$value->id,$outlet_id);
                                        if($total_sale_mul_c_rows){
                                            foreach ($total_sale_mul_c_rows as $value1):
                                                $html_content .= '<tr>
                                        <td></td>
                                        <td></td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;'.$value1->multi_currency.'</td>
                                        <td class="text_right">'.getAmtPCustom($value1->total_amount).'</td>
                                    </tr>';
                                            endforeach;
                                        }

                                    endif;
                                else:
                                    $html_content .= '<tr>
                                        <td class="ir_w2_txt_center"></td>
                                        <td>'.$value->name.'</td>
                                        <td>'.lang('is_loyalty_enable').'</td>
                                        <td class="text_right">'.getAmtPCustom($value->paid_sales).'</td>
                                    </tr>';
                                    endif;
                        if($value->id!=5):
                            $html_content .= '
                            <tr>
                                <td></td>
                                <td></td>
                                <td>'.lang('refund').' '.lang('sale').' (-)</td>
                                <td class="text_right">'.getAmtPCustom($value->return_sales).'</td>
                            </tr>';
                            
                            $html_content .= '
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_2').'</td>
                            <td class="text_right">'.getAmtPCustom($value->purchase).'</td>
                        </tr>';

                            $html_content .= '<tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_5').'</td>
                            <td class="text_right">'.getAmtPCustom($value->due_receive).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_6').'</td>
                            <td class="text_right">'.getAmtPCustom($value->due_payment).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>'.lang('register_detail_7').'</td>
                            <td class="text_right">'.getAmtPCustom($value->expense).'</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>'.lang('balance').'</th>
                            <th class="text_right">'.getAmtPCustom($value->inline_total).'</th>
                        </tr>';
                            endif;
                        }
                        $html_content .= '<tr>
                        <th class="ir_w2_txt_center"></th>
                        <th class="ir_w_31"><h5 class="pull-left">'.lang('InHandSummary').'</h5></th>
                        <th class="ir_w_35"></th>
                        <th class="ir_w_31"></th>
                    </tr>';
                        foreach ($total_payments as $key=>$val_1){
                            $separate = explode("||",$val_1);
                            $html_content .= '<tr>
                                <th></th>
                                <th></th>
                                <th>'.$separate[0].'</th>
                                <th class="text_right">'.getAmtPCustom($separate[1]).'</th>
                        </tr>';
                        }
                        /*This variable could not be escaped because this is html content*/
                        echo ($html_content);
                    endif;
                    ?>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
    </div>

</section>

<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report_no_sorting_z_report.js"></script>
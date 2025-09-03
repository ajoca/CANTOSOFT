<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">



<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header text-left"><?php echo lang('serviceDeliveryChargeReport'); ?></h3>
        <input type="hidden" class="datatable_name" data-title="<?php echo lang('serviceDeliveryChargeReport'); ?>" data-id_name="datatable">

    </section>

    <div>
        <?php
        if(isLMni() && isset($outlet_id)):
            ?>
            <h4 class="txt-color-grey"> <?php echo lang('outlet'); ?>: <?php echo escape_output(getOutletNameById($outlet_id))?></h4>
            <?php
        endif;
        ?>
        <h4 class="txt-color-grey"><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?>
        </h4>
        <h4 class="txt-color-grey ir_txtCenter_mt0"><?php
            if (isset($user_id) && $user_id):
                echo lang('user').": " . userName($user_id);
            else:
                echo lang('user').": ".lang('all');
            endif;
            ?></h4>
        <h4 class="txt-color-grey ir_txtCenter_mt0"><?php
            if (isset($waiter_id) && $waiter_id):
                echo lang('waiter').": " . userName($waiter_id);
            else:
                echo lang('waiter').": ".lang('all');
            endif;
            ?></h4>

    </div>


    <div class="box-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <?php echo form_open(base_url() . 'Report/serviceDeliveryChargeReport') ?>
                <div class="form-group">
                    <input tabindex="1" type="text" id="" name="startDate" readonly class="form-control customDatepicker"
                           placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">

                <div class="form-group">
                    <input tabindex="2" type="text" id="endMonth" name="endDate" readonly
                           class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>"
                           value="<?php echo set_value('endDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <div class="form-group">
                    <select tabindex="2" class="form-control select2 ir_w_100" id="charge_type" name="charge_type">
                        <option value=""><?php echo lang('charge_type'); ?></option>
                        <option value="service" <?= set_select('charge_type', 'service') ?>><?php echo lang('service_charge'); ?></option>
                        <option value="delivery" <?= set_select('charge_type', 'delivery') ?>><?php echo lang('DeliveryCharge'); ?></option>
                         
                    </select>
                </div>
            </div>
            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <div class="form-group">
                    <select tabindex="2" class="form-control select2 ir_w_100" id="waiter_id" name="waiter_id">
                        <option value=""><?php echo lang('waiter'); ?></option>
                        <?php
                        foreach ($users as $value) {
                            if($value->designation=="Waiter"):
                                ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('waiter_id', $value->id); ?>>
                                    <?php echo escape_output($value->full_name) ?></option>
                                <?php
                            endif;
                        } ?>
                    </select>
                </div>
            </div>
            <?php
            if(isLMni()):
                ?>
                <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
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
            <div class="col-sm-12 mb-3 col-md-2 pull-right">
                <div class="form-group">
                    <button type="submit" name="submit" value="submit"
                            class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                </div>
            </div>
        </div>

        <div class="table-box">

            <div class="table-responsive">

                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="ir_w2_txt_center"><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('date'); ?></th>
                        <th><?php echo lang('order_type'); ?></th> 
                        <th><?php echo lang('sale_no'); ?></th> 
                        <th><?php echo lang('charge'); ?></th> 
                        <th><?php echo lang('g_total'); ?></th> 
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $pGrandTotal = 0;
                    $charge_amount_total = 0; 
                    if (isset($serviceDeliveryChargeReport)):
                        foreach ($serviceDeliveryChargeReport as $key => $value) {
                            $pGrandTotal+=$value->total_payable;    
                            $charge_amount = ''; 
                            $charge_amount_total += $value->delivery_charge_actual_charge;
                            $order_type = '';
                              if($value->order_type == 1){
                                    $order_type = lang('dine');
                              }elseif($value->order_type == 2){
                                    $order_type = lang('take_away');
                              }elseif($value->order_type == 3){
                                    $order_type = lang('delivery');
                              } 
                            if($value->charge_type=="service"){
                              $charge_amount =  getAmt($value->delivery_charge_actual_charge)." (".lang('service_charge').")";
                            }else{
                              $charge_amount =  getAmt($value->delivery_charge_actual_charge)." (".lang('DeliveryCharge').")";
                            }
                            $key++;
                            ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($key); ?></td>
                                <td><?= escape_output(date($this->session->userdata('date_format'), strtotime($value->sale_date))) ?></td>
                                <td><?php echo escape_output($order_type) ?></td>
                                <td><?php echo escape_output($value->sale_no) ?></td>
                                <td><?php echo escape_output($charge_amount) ?></td>
                                <td><?php echo escape_output(getAmt($value->total_payable)) ?></td>
                            </tr>
                            <?php
                        }
                    endif;
                    ?>
                    <tr>
                        <td class="ir_w2_txt_center"></td>
                        <td></td>
                        <td></td>
                        <td class="ir_txt_right"><b><?php echo lang('total'); ?></b> </td>
                        <td><?= getAmt($charge_amount_total) ?></td> 
                        <td>
                            <?php echo escape_output(getAmt($pGrandTotal)) ?></td>  
                    </tr>
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</section>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">
</script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report.js"></script>
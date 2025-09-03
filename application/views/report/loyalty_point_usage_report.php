<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">

<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="text-left top-left-header"><?php echo lang('usage_loyalty_point_report'); ?></h3>
        <input type="hidden" class="datatable_name" data-title="<?php echo lang('usage_loyalty_point_report'); ?>" data-id_name="datatable">


    </section>


    <div class="my-2">
        <h4 class="ir_txtCenter_mt0"><?php
            if (isset($customer_id) && $customer_id):
                echo "<span>" . escape_output(getCustomerName($customer_id)) . "</span>";
            endif;
            ?></h4>
    </div>

    <div class="box-wrapper">
        <div class="row">

            <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                <?php echo form_open(base_url() . 'Report/usageLoyaltyPointReport') ?>
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
                    <select tabindex="2" class="form-control select2 ir_w_100" id="customer_id" name="customer_id">
                        <option value=""><?php echo lang('customers'); ?></option>
                        <?php
                        $check_walk_in_customer = 1;
                        foreach ($customers_dropdown as $value) {
                            if($value->id!=1){
                                ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('customer_id', $value->id); ?>>
                                    <?php echo escape_output($value->name) ?></option>
                            <?php }
                        }
                        ?>
                    </select>
                </div>
                <div class="alert error-msg customer_id_err_msg_contnr ir_p_5">
                    <p id="customer_id_err_msg"></p>
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
            <div class="col-md-2 col-sm-12">
                <div class="form-group">
                    <button type="submit" name="submit" value="submit"
                            class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                </div>
            </div>
        </div>
        <div class="table-box">

            <div class="table-responsive">
                <h3><?php echo lang('usage_loyalty_point_report'); ?></h3>
                <table id="datatable" class="datatable table">
                    <thead>
                    <tr>
                        <th class="ir_w2_txt_center"><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('date_time'); ?></th>
                        <th><?php echo lang('sale_no'); ?></th>
                        <th><?php echo lang('customer'); ?>(<?php echo lang('phone'); ?>)</th>
                        <th><?php echo lang('usage_point'); ?></th>
                        <th><?php echo lang('redeemed_amount'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($customers)):
                        $is_loyalty_enable = $this->session->userdata('is_loyalty_enable');
                        $counter =1;
                        foreach ($customers as $key => $value) {
                            $redeemed_point = 0;
                            $available_point = 0;
                            if (isset($is_loyalty_enable) && $is_loyalty_enable == "enable"):
                                $available_point = $value->usage_point;
                                $redeemed_point = $value->amount;
                            endif;
                            if($available_point):
                                $key++;
                                ?>
                                <tr>
                                    <td class="ir_txt_center"><?php echo escape_output($counter); ?></td>
                                    <td class="txt-uh-41"><?php echo date("d/m/Y h:m A",strtotime($value->date_time))?></td>
                                    <td><?php echo escape_output($value->sale_no) ?></td>
                                    <td><?php echo escape_output($value->name) ?>(<?php echo escape_output($value->phone) ?>)</td>
                                    <td><?php echo escape_output(($available_point)) ?></td>
                                    <td><?php echo escape_output(getAmtPCustom($redeemed_point)) ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endif;
                        }
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>



</section>
<!-- DataTables -->
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

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report1.js"></script>
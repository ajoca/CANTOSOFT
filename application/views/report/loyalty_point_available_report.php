<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">

<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="text-left top-left-header"><?php echo lang('loyalty_point_report'); ?></h3>
        <input type="hidden" class="datatable_name" data-title="<?php echo lang('loyalty_point_report'); ?>" data-id_name="datatable">


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

            <div class="mb-3 col-md-2 col-sm-12">
                <?php echo form_open(base_url() . 'Report/availableLoyaltyPointReport') ?>
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
                <table id="datatable" class="datatable table">
                    <thead>
                        <tr>
                            <th class="ir_w2_txt_center"><?php echo lang('sn'); ?></th>
                            <th><?php echo lang('customer'); ?>(<?php echo lang('phone'); ?>)</th>
                            <th><?php echo lang('Total_Redeemed_Point'); ?></th>
                            <th><?php echo lang('Total_Available_Point'); ?></th>
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
                            if ($value->id != 1) {


                                if (isset($is_loyalty_enable) && $is_loyalty_enable == "enable"):

                                    $return_data = getTotalLoyaltyPoint($value->id,$outlet_id);
                                    $redeemed_point = $return_data[0];
                                    $available_point = $return_data[1];
                                endif;
                                if($available_point):
                                    $key++;
                                ?>
                                <tr>
                                    <td class="ir_txt_center"><?php echo escape_output($counter); ?></td>
                                    <td><?php echo escape_output($value->name) ?>(<?php echo escape_output($value->phone) ?>)</td>
                                    <td><?php echo escape_output(($redeemed_point)) ?></td>
                                    <td><?php echo escape_output(($available_point)) ?></td>
                                </tr>
                    <?php
                                    $counter++;
                    endif;
                            }
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
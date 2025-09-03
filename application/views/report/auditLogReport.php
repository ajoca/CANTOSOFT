<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">

<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="top-left-header text-left"><?php echo lang('auditLogReport'); ?></h3>
        <input type="hidden" class="datatable_name" data-title="<?php echo lang('auditLogReport'); ?>" data-id_name="datatable">
    </section>

    <div class="my-2">

        <?php
        if(isLMni() && isset($outlet_id)):
            ?>
            <h4> <?php echo lang('outlet'); ?>: <?php echo escape_output(getOutletNameById($outlet_id))?></h4>
            <?php
        endif;
        ?>
        <h4><?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('report_date') . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?>
        </h4>
        <h4 class="txt-color-grey ir_txtCenter_mt0"><?php
            if (isset($waiter_id) && $waiter_id):
                echo lang('user').": " . userName($waiter_id);
            else:
                echo lang('user').": ".lang('all');
            endif;
            if (isset($event_title) && $event_title):
                echo '<br>'.lang('event_title').": " . $event_title;
            else:
                echo '<br>'.lang('event_title').": ".lang('all');
            endif;
            ?></h4>
    </div>

    <div class="box-wrapper">
        <div class="row">
            <div class="col-md-2">
                <?php echo form_open(base_url() . 'Report/auditLogReport', $arrayName = array('id' => 'orderReport')) ?>
                <div class="form-group">
                    <input tabindex="1" autocomplete="off" type="text" id="" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
            </div>
            <div class="col-md-2">

                <div class="form-group">
                    <input tabindex="2" autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-control select2 width_100_p" name="event_title">
                    <option value=""><?php echo lang('event_title'); ?></option>
                    <option <?php echo set_select('event_title',"Cancelled Sale")?> value="Cancelled Sale"><?php echo lang('Cancelled_Sale'); ?></option>
                    <option <?php echo set_select('event_title',"Deleted Sale")?> value="Deleted Sale"><?php echo lang('Deleted_Sale'); ?></option>
                    <option <?php echo set_select('event_title',"Refund Sale")?> value="Refund Sale"><?php echo lang('Refund_Sale'); ?></option>
                    <option <?php echo set_select('event_title',"Remove Item")?> value="Remove Item"><?php echo lang('Remove_Item'); ?></option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control select2 width_100_p" name="user_id">
                    <option value=""><?php echo lang('user'); ?></option>
                    <?php
                    foreach ($users as $value):
                        ?>
                        <option <?php echo set_select('user_id', $value->id); ?> value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->full_name); ?> - <?php echo escape_output($value->phone); ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>

            <?php
            if(isLMni()):
                ?>
                <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                    <div class="form-group">
                        <select tabindex="2" class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('outlet'); ?></option>
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

            <div class="col-md-1">
                <div class="form-group">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100 pull-left"><?php echo lang('submit'); ?></button>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="hidden-lg">
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo lang('sn'); ?></th>
                        <th scope="col"><?php echo lang('outlet'); ?></th>
                        <th scope="col"><?php echo lang('done_by'); ?></th>
                        <th scope="col"><?php echo lang('event_title'); ?></th>
                        <th scope="col"><?php echo lang('date_time'); ?></th>
                        <th scope="col"><?php echo lang('details'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($auditLogReport)):
                        foreach ($auditLogReport as $key => $value) {
                            $key++;
                            ?>
                            <tr>
                                <th class="txt-uh-41" scope="row"><?php echo escape_output($key)?></th>
                                <td class="txt-uh-41"><?php echo escape_output(($value->outlet_name)); ?></td>
                                <td class="txt-uh-41"><?php echo escape_output(userName($value->user_id)); ?></td>
                                <td class="txt-uh-41"><?php echo escape_output($value->event_title); ?></td>
                                <td class="txt-uh-41"><?php echo date("d/m/Y h:m A",strtotime($value->date_time))?></td>
                                <td class="txt-uh-41"><?php echo ($value->details); ?></td>
                            </tr>
                            <?php
                        }
                    endif;
                    ?>
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
<script src="<?php echo base_url(); ?>assets/datatable_custom/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report.js"></script>
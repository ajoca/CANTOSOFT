<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datetimepicker/css/bootstrap-datetimepicker.css">
<script src="<?php echo base_url(); ?>assets/bower_components/datetimepicker/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- Main content -->
<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
    <?php
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>

    <style>
        .box-wrapper {
            -webkit-animation: unset !important;
        }
        .form-control{
            width: 150px;
        }
    </style>
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('reservationSettingRange'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'setting/reservationEnableDisable/'.(isset($company) && $company->id?$company->id:''), $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div>
                <?php
                $reservation_times = json_decode($company->reservation_times);
                ?>
                <div class="row">
                    <?php
                    $display = 'none';

                    if(isServiceAccess('','','sGmsJaFJE')):
                        $display = "";
                        ?>

                    <?php endif?>
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-4" style="display: <?php echo ($display)?>;">
                        <div class="form-group">
                            <label> <?php echo lang('reservation_status'); ?>  <span
                                        class="required_star">*</span></label>
                            <select tabindex="7" class="form-control select2" name="reservation_status"
                                    id="reservation_status">
                                <option
                                    <?= isset($company) && $company->reservation_status== "enable" ? 'selected' : '' ?>
                                        value="enable"><?php echo lang('enable')?></option>
                                <option
                                    <?= isset($company) && $company->reservation_status== "disable" ? 'selected' : '' ?>
                                        value="disable"><?php echo lang('disable')?></option>
                            </select>
                        </div>
                        <?php if (form_error('reservation_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('reservation_status'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label><?php echo lang('shareable_url'); ?></label>
                           
                            <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" onfocus="select();" readonly autocomplete="off" type="text"  class="form-control" value="<?php echo base_url()?>reservation/?c_id=<?php echo escape_output($this->session->userdata("company_id"))?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('reservation_url_tooltip'); ?>"></i>
                            </div>
                                        </td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                        <table class="">

                            <tr>
                                <th>Availability</th>
                                <th class="text-center">Day</th>
                                <th>Start Time</th>
                                <th></th>
                                <th>End Time</th>
                            </tr>

                            <tbody>
                            <?php
                            $i = 1;
                            if(isset($reservation_times) && $reservation_times):
                             foreach ($reservation_times as $value):
                                ?>
                                <tr>
                                    <td class="txt-uh-23 text-center"><input type="checkbox" <?php echo escape_output(isset($value->status) && $value->status?"checked":'')?> name="status_<?php echo escape_output($i)?>"  value="1"></td>
                                    <td class="txt-uh-23"><?php echo escape_output(isset($value->counter_name) && $value->counter_name?$value->counter_name:'')?></td>
                                    <td>
                                        <input type="hidden" value="<?php echo escape_output(isset($value->counter_name) && $value->counter_name?$value->counter_name:'')?>" name="text_header[]">
                                        <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="<?php echo isset($value->start_time) && $value->start_time?$value->start_time:'0'?>"></td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="<?php echo isset($value->end_time) && $value->end_time?$value->end_time:'0'?>"></td>
                                </tr>
                            <?php
                                 $i++;
                             endforeach;
                                else:
                            ?>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_1"  value="1"></td>
                                        <td class="txt-uh-23">Sunday</td>
                                        <td>
                                            <input type="hidden" value="Sunday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="01:00 am"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="12:00 am"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_2"  value="1"></td>
                                        <td class="txt-uh-23">Monday</td>
                                        <td>
                                            <input type="hidden" value="Monday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="01:00 am"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="11:00 pm"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_3"  value="1"></td>
                                        <td class="txt-uh-23">Tuesday</td>
                                        <td>
                                            <input type="hidden" value="Tuesday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="01:00 pm"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="11:00 pm"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_4"  value="1"></td>
                                        <td class="txt-uh-23">Wednesday</td>
                                        <td>
                                            <input type="hidden" value="Wednesday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="05:00 pm"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="10:00 pm"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_5"  value="1"></td>
                                        <td class="txt-uh-23">Thursday</td>
                                        <td>
                                            <input type="hidden" value="Thursday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="01:00 pm"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="12:00 am"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_6"  value="1"></td>
                                        <td class="txt-uh-23">Friday</td>
                                        <td>
                                            <input type="hidden" value="Friday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="08:00 am"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="09:00 pm"></td>
                                    </tr>
                                    <tr>
                                        <td class="txt-uh-23 text-center"><input type="checkbox" name="status_7"  value="1"></td>
                                        <td class="txt-uh-23">Saturday</td>
                                        <td>
                                            <input type="hidden" value="Saturday" name="text_header[]">
                                            <input type="text" name="start_time[]" class="form-control check_required customDatepicker_time"  value="11:00 am"></td>
                                        <td>&nbsp;</td>
                                        <td><input type="text" name="end_time[]" class="form-control check_required customDatepicker_time"  value="04:30 pm"></td>
                                    </tr>

                                <?php endif?>

                            </tbody>

                        </table>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
            <div
            <div class="row py-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

</section>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>

<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/tax.js'); ?>"></script>


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

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('Tax_Setting'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $company_info = json_decode($company->smtp_details);
            ?>
            <?php echo form_open(base_url() . 'setting/tax/'.(isset($company) && $company->id?$company->id:''), $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">

                    <div class="col-sm-12 mb-2 col-sm-12 col-md-6">
                        <div class="form-group radio_button_problem">
                            <label><?php echo lang('collect_tax'); ?> <span class="required_star">*</span></label>
                            <div class="radio">
                                <label>
                                    <input tabindex="5" type="radio" name="collect_tax" id="collect_tax_yes" value="Yes"
                                        <?php
                                        if ($company->collect_tax == "Yes") {
                                            echo "checked";
                                        };
                                        ?>
                                    ><?php echo lang('yes'); ?> </label>
                                <label>

                                    <input tabindex="6" type="radio" name="collect_tax" id="collect_tax_no" value="No"
                                        <?php
                                        if ($company->collect_tax == "No" || ($company->collect_tax != "Yes" && $company->collect_tax != "No")) {
                                            echo "checked";
                                        };
                                        ?>
                                    ><?php echo lang('no'); ?>
                                </label>
                            </div>
                        </div>
                        <?php if (form_error('collect_tax')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('collect_tax'); ?>
                            </div>
                        <?php } ?>


                    </div>

                </div>

                <div id="tax_yes_section" style="display:<?php if($company->collect_tax=="Yes"){echo "block;";}else{echo "none;";}?>">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <button id="show_sample_invoice_with_tax" type="button" class="new-btn w-100 show_preview" data-bs-toggle="modal" data-bs-target="#show_sample_invoice_with_tax_modal"><?php echo lang('show_invoice_sample'); ?></button>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('tax_type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2" name="tax_type">
                                    <option <?php echo set_select('tax_type','1')?> <?php echo isset($company->tax_type) & $company->tax_type==1?'selected':''?> value="1"><?php echo lang('exclusive_tax'); ?></option>
                                    <option <?php echo set_select('tax_type','2')?> <?php echo isset($company->tax_type) & $company->tax_type==2?'selected':''?> value="2"><?php echo lang('inclusive_tax'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('apply_on_delivery_charge'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2" name="apply_on_delivery_charge">
                                    <option
                                        <?= isset($company) && $company->apply_on_delivery_charge== "1" ? 'selected' : '' ?>
                                            value="1"><?php echo lang('no')?></option>
                                    <option
                                        <?= isset($company) && $company->apply_on_delivery_charge== "2" ? 'selected' : '' ?>
                                            value="2"><?php echo lang('yes')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">

                            <div class="form-group">
                                <label><?php echo lang('my_tax_title'); ?> <span class="required_star">*</span></label>
                                
                                <table>
                                <tr>
                                    <td class="ir_w_100">
                                    <input tabindex="1" type="text" id="tax_title" name="tax_title" class="form-control" placeholder="<?php echo lang('my_tax_title'); ?>" value="<?php echo escape_output($company->tax_title); ?>">

                                        <?php if (form_error('tax_title')) { ?>
                                        <div class="callout callout-danger my-2">
                                                    <?php echo form_error('tax_title'); ?>
                                                </div>
                                            <?php } ?>

                                            <div class="alert alert-error txt_35 txt_11" id="tax_title_error">
                                                <p><?php echo lang('tooltip_txt_2'); ?></p>
                                            </div>

                                    </td>
                                    <td> 
                                            <a id="show_how_tax_title_works" data-bs-toggle="modal" data-bs-target="#show_how_tax_title_works_modal" class="new-btn h-40 show_preview"
                                        href="#"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            </table>

                            </div> 

                        </div>
                        <div class="col-sm-12 col-md-3">

                            <div class="form-group">
                                <label><?php echo lang('tax_registration_no'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="tax_registration_no" name="tax_registration_no" class="form-control" placeholder="<?php echo lang('tax_registration_no'); ?>" value="<?php echo escape_output($company->tax_registration_no); ?>">
                            </div>

                            <?php if (form_error('tax_registration_no')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('tax_registration_no'); ?>
                                </div>
                            <?php } ?>

                            <div class="alert alert-error txt_35 txt_11" id="tax_registration_no_error">
                                <p><?php echo lang('tooltip_txt_3'); ?></p>
                            </div>

                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group radio_button_problem">
                                <label><?php echo lang('tax_is_gst'); ?> <span class="required_star">*</span></label>
                                <div class="radio">
                                    <label>
                                        <input tabindex="5" type="radio" name="tax_is_gst" id="tax_is_gst_yes" value="Yes"
                                            <?php
                                            if ($company->tax_is_gst == "Yes") {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('yes'); ?> </label>
                                    <label>
                                        <input tabindex="6" type="radio" name="tax_is_gst" id="tax_is_gst_no" value="No"
                                            <?php
                                            if ($company->tax_is_gst == "No" || ($company->tax_is_gst != "Yes" && $company->tax_is_gst != "No")) {
                                                echo "checked";
                                            };
                                            ?>
                                        ><?php echo lang('no'); ?>
                                    </label>
                                </div>
                            </div>
                            <?php if (form_error('tax_is_gst')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('tax_is_gst'); ?>
                                </div>
                            <?php } ?>
                            <button id="what_will_happen_if_i_say_yes" type="button" class="new-btn my-3 show_preview" data-bs-toggle="modal" data-bs-target="#what_will_happen_if_i_say_yes_modal"><?php echo lang('if_i_say_yes'); ?></button>

                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('my_tax_fields');?> <span class="required_star">*</span></label>
                                <table id="datatable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="ir_w_1"><?php echo lang('sn'); ?></th>
                                        <th class="ir_w_20"><?php echo lang('name'); ?></th>
                                        <th class="ir_w_20"><?php echo lang('Rate'); ?></th>
                                        <th class="ir_w_1"><?php echo lang('actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tax_table_body">
                                    <?php
                                    $new_row_number = 1;
                                    $show_tax_row = '';
                                    $tax_setting = json_decode($company->tax_setting);

                                    if(isset($tax_setting) && count($tax_setting)>0){
                                        foreach($tax_setting as $key=>$single_tax){
                                            $show_tax_row .= '<tr  class="tax_single_row '.setReadonly(3,$single_tax->tax).'" id="tax_row_'.$new_row_number.'">';
                                            $show_tax_row .= '<td>'.$new_row_number.'</td>';
                                            $show_tax_row .= '<td><input type="hidden" name="p_tax_id[]" value="'.(isset($single_tax->id) && $single_tax->id?$single_tax->id:'').'"><input type="text" name="taxes[]" '.setReadonly(1,$single_tax->tax).' class="form-control check_required" value="'.$single_tax->tax.'"/></td>';
                                            $show_tax_row .= '<td><input type="text" onfocus="select()" name="tax_rate[]" class="form-control integerchk check_required" value="'.$single_tax->tax_rate.'"/></td>';
                                            $show_tax_row .= '<td class="txt_51"><span style="display: '.setReadonly(2,$single_tax->tax).'" class="remove_this_tax_row txt_25" id="remove_this_tax_row_'.$new_row_number.'" ><i class="color_red fa fa-trash"></i> </span></td>';
                                            $show_tax_row .= '</tr>';
                                            $new_row_number++;
                                        }
                                    }
                                    //This variable could not be escaped because this is html content
                                    echo ($show_tax_row);
                                    ?>
                                    </tbody>
                                </table>
                                <button id="add_tax" class="new-btn my-2 show_preview" type="button"><?php echo lang('add_more'); ?></button>
                            </div>
                            <?php if (form_error('taxes[]')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('taxes[]'); ?>
                                </div>
                            <?php } ?>
                            <button id="show_how_tax_fields_work" type="button" class="new-btn my-2 show_preview" data-bs-toggle="modal" data-bs-target="#show_how_tax_fields_work_modal"><?php echo lang('how_tax_fields_work'); ?></button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>setting">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
   
</section>


<!-- Modal -->
<div id="show_sample_invoice_with_tax_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('Sample_Invoice'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i data-feather="x"></i></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <img src="<?php echo base_url()?>images/GST Invoice.jpg">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="show_how_tax_title_works_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('how_tax_title_works'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i data-feather="x"></i></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('tooltip_txt_5'); ?><br>
                    <?php echo lang('tooltip_txt_6'); ?><br>
                    <?php echo lang('tooltip_txt_7'); ?><br>
                    <?php echo lang('tooltip_txt_8'); ?><br>
                    <?php echo lang('tooltip_txt_9'); ?><br>
                    <?php echo lang('tooltip_txt_10'); ?><br>
                    <?php echo lang('tooltip_txt_11'); ?><br>
                    <?php echo lang('tooltip_txt_12'); ?><br>
                    <?php echo lang('tooltip_txt_13'); ?><br>
                    <?php echo lang('tooltip_txt_14'); ?><br>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="what_will_happen_if_i_say_yes_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('tooltip_txt_15'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i data-feather="x"></i></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('tooltip_txt_16'); ?><br>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="show_how_tax_fields_work_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('tooltip_txt_22'); ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><i data-feather="x"></i></button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo lang('tooltip_txt_23'); ?> <br>
                    <?php echo lang('tooltip_txt_24'); ?> <br>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>

    </div>
</div>
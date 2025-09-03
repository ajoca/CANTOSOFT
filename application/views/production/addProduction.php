<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_purchase.css">
<script type="text/javascript" src="<?php echo base_url('frequent_changing/supplier.js'); ?>"></script>

<input type="hidden" id="ingredient_already_remain" value="<?php echo lang('production_already_remain'); ?>">
<input type="hidden" id="supplier_field_required" value="<?php echo lang('supplier_field_required'); ?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" id="at_least_ingredient" value="<?php echo lang('at_least_ingredient'); ?>">
<input type="hidden" id="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">
<input type="hidden" id="payment_id_field_required" value="<?php echo lang('payment_id_field_required'); ?>">
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="alert" value="<?php echo lang('alert'); ?>">

<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/add_production.js'); ?>"></script>




<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('add_production'); ?>
        </h3>
    </section>

        <div class="box-wrapper">
            
            <div class="table-box">
                <?php echo form_open(base_url() . 'Production/addEditProduction', $arrayName = array('id' => 'production_form')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('ref_no'); ?></label>
                                <input tabindex="1" type="text" id="reference_no" readonly name="reference_no"
                                    class="form-control" placeholder="<?php echo lang('ref_no'); ?>"
                                    value="<?php echo escape_output($pur_ref_no); ?>">
                            </div>
                            <?php if (form_error('reference_no')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('reference_no'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg name_err_msg_contnr">
                                <p id="name_err_msg"></p>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" readonly type="text" id="date" name="date" class="form-control"
                                    placeholder="<?php echo lang('date'); ?>" value="<?php echo date("Y-m-d",strtotime('today')); ?>">
                            </div>
                            <?php if (form_error('date')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('date'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg date_err_msg_contnr"">
                                <p id="date_err_msg">
                                </p>
                            </div>
                        </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span>
                               
                            </label>

                            <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="2" class="form-control select2" id="status"
                                            name="status">
                                        <option <?php echo set_select('status',0)?> value="0"><?php echo lang('Draft'); ?></option>
                                        <option <?php echo set_select('status',1)?> value="1"><?php echo lang('Final'); ?></option>
                                    </select>
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('final_tooltip'); ?>" data-feather="help-circle"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>

                         
                        </div>
                        <?php if (form_error('status')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('status'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-sm-12 col-md-3">

                            <div class="form-group">
                                <label><?php echo lang('premade_food'); ?> <?php echo lang('item'); ?> <span class="required_star">*</span></label>
                                <select tabindex="4" class="form-control select2 select2-hidden-accessible ir_w_100"
                                    name="ingredient_id" id="ingredient_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($ingredients as $ingnts) { ?>
                                    <option
                                        value="<?php echo escape_output($ingnts->id . "|" . $ingnts->name . " (" . $ingnts->code . ")|" . $ingnts->unit_name . "|" . $ingnts->purchase_price) ?>"
                                        <?php echo set_select('ingredient_id', $ingnts->id); ?>>
                                        <?php echo escape_output($ingnts->name . "(" . $ingnts->code . ")") ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('ingredient_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('ingredient_id'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg ingredient_id_err_msg_contnr">
                                <p id="ingredient_id_err_msg"></p>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="production_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('sn'); ?></th>
                                            <th>
                                                <?php echo lang('production'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th><?php echo lang('quantity_amount'); ?></th>
                                            <th><?php echo lang('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
                <input type="hidden" name="suffix_hidden_field" id="suffix_hidden_field" />

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Production/productions">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>


    <div class="modal fade" id="supplierModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo lang('add_supplier'); ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i data-feather="x"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('supplier_name'); ?><span
                                            class="ir_color_red"> *</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="<?php echo lang('supplier_name'); ?>" value="">
                                        <div class="callout callout-danger my-2 error-msg supplier_err_msg_contnr">
                                            <p class="supplier_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('contact_person'); ?><span
                                            class="ir_color_red"> *</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="contact_person" id="contact_person"
                                            placeholder="<?php echo lang('contact_person'); ?>" value="">
                                        <div class="callout callout-danger my-2 error-msg customer_err_msg_contnr">
                                            <p class="customer_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('phone'); ?> <span
                                            class="ir_color_red">
                                            *</span></label>
                                    <div>
                                        <input type="text" class="form-control integerchk" id="phone" name="phone"
                                            placeholder="<?php echo lang('phone'); ?>" value="">
                                        <div class="callout callout-danger my-2 error-msg customer_phone_err_msg_contnr ir_p_5">
                                            <p class="customer_phone_err_msg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('email'); ?></label>
                                    <div>
                                        <input type="text" class="form-control" id="emailAddress" name="emailAddress"
                                            placeholder="<?php echo lang('email'); ?>" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('address'); ?></label>
                                    <div>
                                        <textarea tabindex="4" class="form-control" rows="3" name="supAddress"
                                            placeholder="<?php echo lang('address'); ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('description'); ?></label>
                                    <div>
                                        <textarea tabindex="4" class="form-control" rows="4" name="description"
                                            placeholder="<?php echo lang('enter'); ?> ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" id="addSupplier">
                        <i class="fa fa-save m-right"></i> <?php echo lang('submit'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noticeModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="noticeModal">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Notice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 hidden-lg hidden-sm">
                            <p class="foodMenuCartNotice">
                                <strong class="ir_ml39"><?php echo lang('notice'); ?></strong><br>
                                <?php echo lang('notice_text_1'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
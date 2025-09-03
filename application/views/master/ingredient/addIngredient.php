<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/ingredient.js'); ?>"></script>
 <section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('add_ingredient'); ?>
        </h3>
    </section>
    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url('ingredient/addEditIngredient')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" name="name" class="form-control"
                                placeholder="<?php echo lang('name'); ?>" value="<?php echo set_value('name'); ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('name'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('code'); ?>  <span class="required_star">*</span></label>
                            <input tabindex="6" type="text" name="code" class="form-control"
                                placeholder="<?php echo lang('code'); ?>" value="<?php echo escape_output($autoCode); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                            <select tabindex="2" class="form-control select2 ir_w_100" name="category_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($categories as $ctry) { ?>
                                <option value="<?php echo escape_output($ctry->id) ?>"
                                    <?php echo set_select('category_id', $ctry->id); ?>>
                                    <?php echo escape_output($ctry->category_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('category_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('category_id'); ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('purchase_unit'); ?> <span class="required_star">*</span></label>
                            <select tabindex="3" class="form-control select2 ir_w_100" name="purchase_unit_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($units as $unts) { ?>
                                <option value="<?php echo escape_output($unts->id) ?>"
                                    <?php echo set_select('purchase_unit_id', $unts->id); ?>><?php echo escape_output($unts->unit_name) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('purchase_unit_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('purchase_unit_id'); ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('consumption_unit'); ?> <span class="required_star">*</span></label>
                            <div class="d-flex">
                                <select tabindex="3" class="form-control select2 ir_w_100" name="consumption_unit_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($units as $unts) { ?>
                                        <option value="<?php echo escape_output($unts->id) ?>"
                                            <?php echo set_select('consumption_unit_id', $unts->id); ?>><?php echo escape_output($unts->unit_name) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('ing_tooltip_1'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('consumption_unit_id')) { ?>
                            <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('consumption_unit_id'); ?>
                            </span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('conversion_rate'); ?> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="4" type="text" name="conversion_rate"  onfocus="select()"  id="conversion_rate"
                                    class="form-control integerchk change_consumption_cost"
                                    placeholder="<?php echo lang('conversion_rate'); ?>"
                                    value="<?php echo set_value('conversion_rate'); ?>">

                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('ing_tooltip_2'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('conversion_rate')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('conversion_rate'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('purchase_price'); ?> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="4" type="text" onfocus="select()" name="purchase_price" id="purchase_price"
                                    class="form-control integerchk change_consumption_cost"
                                    placeholder="<?php echo lang('purchase_price'); ?>"
                                    value="<?php echo set_value('purchase_price'); ?>">

                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('tooltip_txt_25'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('purchase_price')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('purchase_price'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('consumption_unit_cost'); ?> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="4" type="text" name="consumption_unit_cost" id="consumption_unit_cost"
                                    class="form-control integerchk" readonly
                                    placeholder="<?php echo lang('consumption_unit_cost'); ?>"
                                    value="<?php echo set_value('consumption_unit_cost'); ?>">

                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('ing_tooltip_4'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('consumption_unit_cost')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('consumption_unit_cost'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('alert_qty'); ?> <span class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="5" type="text" name="alert_quantity" class="form-control integerchk"
                                    placeholder="<?php echo lang('alert_qty'); ?>"
                                    value="<?php echo set_value('alert_quantity'); ?>">
                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('ing_tooltip_3'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('alert_quantity')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('alert_quantity'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>ingredient/ingredients">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
 </section>
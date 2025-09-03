<input type="hidden" id="ingredient_already_remain" value="<?php echo lang('ingredient_already_remain'); ?>">
<input type="hidden" id="name_field_required" value="<?php echo lang('name_field_required'); ?>">
<input type="hidden" id="sale_price_field_required" value="<?php echo lang('sale_price_field_required'); ?>">
<input type="hidden" id="category_field_required" value="<?php echo lang('category_field_required'); ?>">
<input type="hidden" id="veg_item_field_required" value="<?php echo lang('veg_item_field_required'); ?>">
<input type="hidden" id="beverage_item_field_required" value="<?php echo lang('beverage_item_field_required'); ?>">
<input type="hidden" id="bar_item_field_required" value="<?php echo lang('bar_item_field_required'); ?>">
<input type="hidden" id="description_field_can_not_exceed" value="<?php echo lang('description_field_can_not_exceed'); ?>">
<input type="hidden" id="consumption" value="<?php echo lang('consumption'); ?>">
<input type="hidden" id="Edit_Variation" value="<?php echo lang('Edit_Variation'); ?>">
<input type="hidden" id="tax_type_custom" value="<?php  echo escape_output($this->session->userdata('tax_type'))?>">
<script src="<?php echo base_url(); ?>frequent_changing/js/edit_premade_food.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_food_menu.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/variation.css">
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_premade_food'); ?>
        </h3>
    </section>



    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <?php echo form_open(base_url('preMadeFood/addEditPreMadeFood/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" id="name" name="name" class="form-control"
                                   placeholder="<?php echo lang('name'); ?>" value="<?php echo escape_output($food_menu_details->name) ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('name'); ?>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg name_err_msg_contnr">
                            <p id="name_err_msg"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('code'); ?></label>
                            <input tabindex="6" type="text" name="code" id="code"  class="form-control"
                                   placeholder="<?php echo lang('code'); ?>" value="<?php echo escape_output($food_menu_details->code) ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                            <select tabindex="2" class="form-control select2 ir_w_100" id="category_id"
                                    name="category_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($categories as $ctry) { ?>
                                    <option value="<?php echo escape_output($ctry->id) ?>" <?php
                                    if ($ctry->id == $food_menu_details->category_id) {
                                        echo "selected";
                                    }
                                    ?>><?php echo escape_output($ctry->category_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('category_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('category_id'); ?>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg category_err_msg_contnr">
                            <p id="category_id_err_msg"></p>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('ingredient_consumptions'); ?> <span
                                        class="required_star">*</span></label>
                            <select tabindex="5" class="txt_21 form-control select2 select2-hidden-accessible"
                                    name="ingredient_id" id="ingredient_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($ingredients as $ingnts) { ?>
                                    <option
                                            value="<?php echo escape_output($ingnts->id . "|" . $ingnts->name . "|" . $ingnts->unit_name. "|" . $ingnts->consumption_unit_cost) ?>"
                                        <?php echo set_select('unit_id', $ingnts->id); ?>>
                                        <?php echo escape_output($ingnts->name . "(" . $ingnts->code . ")"); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('ingredient_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('ingredient_id'); ?>
                            </div>
                        <?php } ?>
                        <div class="callout callout-danger my-2 error-msg ingredient_err_msg_contnr">
                            <p id="ingredient_id_err_msg"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php echo lang('sn'); ?></th>
                                    <th><?php echo lang('ingredient'); ?></th>
                                    <th><?php echo lang('consumption'); ?></th>
                                    <th><?php echo lang('consumption_cost'); ?></th>
                                    <th><?php echo lang('total'); ?></th>
                                    <th><?php echo lang('actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody id="ingredient_consumption_table">
                                <?php
                                $i = 0;
                                if ($food_menu_ingredients && !empty($food_menu_ingredients)) {
                                    foreach ($food_menu_ingredients as $fmi) {
                                        $i++;
                                        echo '<tr class="rowCount" id="row_' . $i . '">' .
                                            '<td ><p>' . $i . '</p></td>' .
                                            '<td class="ir_w_23"><span class="vr01_txt_igr" >' . (isset($fmi->ingredient_id) && $fmi->ingredient_id ? getIngredientNameById($fmi->ingredient_id) : '') . '</span></td>' .
                                            '<input type="hidden" class="ingredient_id" id="ingredient_id_' . $i . '" name="ingredient_id[]" value="' . $fmi->ingredient_id . '"/>' .
                                            '<td><input type="text" tabindex="' . $i . '" id="consumption_' . $i . '" name="consumption[]" value="' . $fmi->consumption . '" onfocus="this.select();" class="form-control integerchk aligning ir_w_85 vr01_consumption add_change_value required_checker_ing" placeholder="Consumption"/><span  class="label_aligning vr01_unit">' . (isset($fmi->ingredient_id) && $fmi->ingredient_id ? unitName(getUnitIdByIgId($fmi->ingredient_id)) : '') . '</span></td>' .
                                            '<td><input type="text" tabindex="' . $i . '" id="cost_' . $i . '" name="cost[]" value="' . $fmi->cost . '" onfocus="this.select();" class="form-control integerchk aligning ir_w_85 vr01_cost add_change_value required_checker_ing" placeholder="Consumption"/></td>' .
                                            '<td><input type="text" tabindex="' . $i . '" id="total_cost_' . $i . '" name="total_cost[]" value="' . $fmi->total . '" onfocus="this.select();" readonly class="form-control integerchk aligning ir_w_85 vr01_total_cost add_change_value required_checker_ing" placeholder="Consumption"/></td>' .
                                            '<td class="ir_w_17"><a class="btn btn-danger btn-xs del_ing" data-suffix="'.$i.'" data-ing_id="'.$fmi->ingredient_id.'"><i class="fa fa-trash"></i> </a></td>' .
                                            '</tr>';
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3" style="display: none">
                        <div class="form-group">
                            <label><?php echo lang('unit_type'); ?> <span class="required_star">*</span></label>
                            <div class="d-flex">
                                <select tabindex="3" class="form-control select2 ir_w_100" id="unit_type" name="unit_type">
                                    <option <?php echo set_select('unit_type',2)?> value="2"><?php echo lang('double_unit'); ?></option>
                                </select>
                            </div>
                        </div>
                        <?php if (form_error('unit_type')) { ?>
                            <div class="callout callout-danger my-2">
                                 <span class="error_paragraph"><?php echo form_error('unit_type'); ?>
                                 </span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3 div_2"  style="display: none">
                        <div class="form-group">
                            <label><?php echo lang('purchase_unit'); ?> <span class="required_star">*</span></label>
                            <select tabindex="3" class="form-control select2 ir_w_100" name="purchase_unit_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($units as $unts) { ?>
                                    <option value="<?php echo escape_output($unts->id) ?>" <?php
                                    if ($unts->id == $food_menu_details->purchase_unit_id) {
                                        echo "selected";
                                    }
                                    ?>><?php echo escape_output($unts->unit_name) ?></option>
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
                    <div class="col-sm-12 mb-2 col-md-3 div_2"  style="display: none">

                        <div class="form-group">
                            <label> <b>=</b> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="4" type="text" name="conversion_rate"   onfocus="select()"  id="conversion_rate"
                                       class="form-control integerchk change_consumption_cost"
                                       placeholder="="
                                       value="1">

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
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('consumption_unit'); ?> <span class="required_star">*</span></label>
                            <div class="d-flex">
                                <select tabindex="3" class="form-control select2 ir_w_100" name="consumption_unit_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($units as $unts) { ?>
                                        <option value="<?php echo escape_output($unts->id) ?>" <?php
                                        if ($unts->id == $food_menu_details->unit_id) {
                                            echo "selected";
                                        }
                                        ?>><?php echo escape_output($unts->unit_name) ?></option>
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

                    <div class="col-sm-12 mb-2 col-md-3"  style="display: none">

                        <div class="form-group">
                            <label><?php echo lang('purchase_price'); ?> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input type="text" class="form-control" readonly name="purchase_price"  placeholder="<?php echo lang('purchase_price'); ?>" id="grand_total_cost">
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
                    <div class="col-sm-12 mb-2 col-md-3 div_2">

                        <div class="form-group">
                            <label><?php echo lang('consumption_unit_cost'); ?> <span
                                        class="required_star">*</span></label>
                            <div class="d-flex">
                                <input tabindex="4" type="text" name="consumption_unit_cost" id="consumption_unit_cost"
                                       class="form-control integerchk" readonly
                                       placeholder="<?php echo lang('consumption_unit_cost'); ?>"
                                       value="<?php echo set_value('consumption_unit_cost'); ?>">

                                <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('ing_tooltip_3'); ?>"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('consumption_unit_cost')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('consumption_unit_cost'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('alert_qty'); ?> <span class="required_star">*</span></label>
                            <input tabindex="5" type="text" name="alert_quantity" class="form-control integerchk"
                                   placeholder="<?php echo lang('alert_qty'); ?>"
                                   value="<?php echo escape_output($food_menu_details->alert_quantity) ?>">
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

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>preMadeFood/preMadeFoods">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
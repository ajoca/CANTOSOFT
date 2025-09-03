<?php
$ingredient_id_container = "[";
if ($food_menu_ingredients && !empty($food_menu_ingredients)) {
    $x = 1;
    $total_ingredient = count($food_menu_ingredients);
    foreach ($food_menu_ingredients as $fmi) {
        if($x!=$total_ingredient){
            $ingredient_id_container .= '"' . $fmi->ingredient_id . '",';
        }else{
            $ingredient_id_container .= '"' . $fmi->ingredient_id . '"';
        }
        $x++;
    }
}
// $ingredient_id_container .= substr($ingredient_id_container, 0, -1);
$ingredient_id_container .= "]";
?>
<script>
    //This variable could not be escaped because this is object
    let ingredient_id_container = <?php echo ($ingredient_id_container); ?> ;
</script>
<input type="hidden" id="ingredient_already_remain" value="<?php echo lang('ingredient_already_remain'); ?>">
<input type="hidden" id="name_field_required" value="<?php echo lang('name_field_required'); ?>">
<input type="hidden" id="category_field_required" value="<?php echo lang('category_field_required'); ?>">
<input type="hidden" id="sale_price_field_required" value="<?php echo lang('sale_price_field_required'); ?>">
<input type="hidden" id="veg_item_field_required" value="<?php echo lang('veg_item_field_required'); ?>">
<input type="hidden" id="beverage_item_field_required" value="<?php echo lang('beverage_item_field_required'); ?>">
<input type="hidden" id="description_field_can_not_exceed"
    value="<?php echo lang('description_field_can_not_exceed'); ?>">
<input type="hidden" id="consumption" value="<?php echo lang('consumption'); ?>">
<input type="hidden" id="Edit_Variation" value="<?php echo lang('Edit_Variation'); ?>">

<script src="<?php echo base_url(); ?>frequent_changing/js/edit_food_menu.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_food_menu.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/variation.css">


<section class="main-content-wrapper">

    <section class="content-header">
        <h1>
            <?php echo lang('edit_food_menu'); ?>
        </h1>
    </section>

    
        <div class="box-wrapper">
        
            <div class="table-box">
            
                <?php echo form_open(base_url() . 'foodMenu/addEditFoodMenu/' . $encrypted_id, $arrayName = array('id' => 'food_menu_form', 'enctype' => 'multipart/form-data')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('product_type'); ?></label>
                                <select class="form-control select2" name="product_type" id="product_type">
                                    <option <?php echo set_select('product_type',1)?> <?php echo isset($food_menu_details->product_type) && $food_menu_details->product_type==1?'selected':''?> value="1"><?php echo lang('Regular'); ?></option>
                                    <option <?php echo set_select('product_type',2)?> <?php echo isset($food_menu_details->product_type) && $food_menu_details->product_type==2?'selected':''?> value="2"><?php echo lang('Combo'); ?></option>
                                    <option <?php echo set_select('product_type',3)?> <?php echo isset($food_menu_details->product_type) && $food_menu_details->product_type==3?'selected':''?> value="3"><?php echo lang('Product'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('product_type')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('product_type'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg product_type_err_msg_contnr">
                                <p id="product_type_err_msg"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                                <select tabindex="2" class="form-control select2 ir_w_100" id="category_id"
                                    name="category_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($categories as $ctry) { ?>
                                    <option value="<?php echo escape_output($ctry->id) ?>" <?php
                                        if ($food_menu_details->category_id == $ctry->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                        <?php echo escape_output($ctry->category_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('category_id')) { ?>
                            <div class="bg-danger text-white p-2">
                                <?php echo form_error('category_id'); ?>
                            </div>
                            <?php } ?>
                            <div class="bg-danger error-msg category_err_msg_contnr">
                                <p id="category_id_err_msg"></p>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="name" name="name" class="form-control"
                                    placeholder="<?php echo lang('name'); ?>"
                                    value="<?php echo escape_output($food_menu_details->name) ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                            <div class="bg-danger">
                                <?php echo form_error('name'); ?>
                            </div>
                            <?php } ?>
                            <div class="bg-danger error-msg name_err_msg_contnr">
                                <p id="name_err_msg">
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('alternative_name'); ?></label>
                                <input tabindex="1" type="text" id="alternative_name" name="alternative_name" class="form-control"
                                    placeholder="<?php echo lang('alternative_name'); ?>" value="<?php echo escape_output($food_menu_details->alternative_name) ?>">
                            </div>
                            <?php if (form_error('alternative_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('alternative_name'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg alternative_name_err_msg_contnr">
                                <p id="alternative_name_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('code'); ?></label>
                                <input tabindex="6" type="text" id="code" name="code" class="form-control"
                                    placeholder="<?php echo lang('code'); ?>"
                                    value="<?php echo escape_output($food_menu_details->code) ?>">
                            </div>
                        </div>
                       

                        <div class="col-md-4 div_product display_none">
                            <div class="form-group">
                                <label><?php echo lang('purchase_price'); ?> <span class="required_star">*</span>
                                  
                                </label>
                               
                                       <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" type="text" id="purchase_price" name="purchase_price" class="form-control"
                                       placeholder="<?php echo lang('purchase_price'); ?>"
                                       value="<?php echo escape_output($food_menu_details->purchase_price) ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('food_purchase_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('purchase_price')) { ?>
                                <div class="bg-danger text-white p-2">
                                    <?php echo form_error('purchase_price'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 div_product display_none">
                            <div class="form-group">
                                <label><?php echo lang('alert_quantity'); ?> <span class="required_star">*</span>
                                    
                                </label>
                               
                                       <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="1" type="text" id="alert_quantity" name="alert_quantity" class="form-control"
                                       placeholder="<?php echo lang('alert_quantity'); ?>"
                                       value="<?php echo escape_output($food_menu_details->alert_quantity) ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('food_alert_quantity_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('alert_quantity')) { ?>
                                <div class="bg-danger text-white p-2">
                                    <?php echo form_error('alert_quantity'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 div_product display_none">
                            <div class="form-group">
                                <label><?php echo lang('ingredient'); ?> <?php echo lang('category'); ?> <span class="required_star">*</span>
                                    
                                </label>
                                
                                <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="2" class="form-control select2 ir_w_100" id="ing_category_id"
                                        name="ing_category_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($ing_categories as $ctry) { ?>
                                        <option value="<?php echo escape_output($ctry->id) ?>"
                                            <?php echo set_select('ing_category_id', $ctry->id); ?> <?php
                                        if ($food_menu_details->ing_category_id == $ctry->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                            <?php echo escape_output($ctry->category_name) ?></option>
                                    <?php } ?>
                                </select>
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('food_ing_category_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('ing_category_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('ing_category_id'); ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 div_show_hide">
                            <div class="form-group">
                                <label><?php echo lang('ingredient_consumptions'); ?></label>
                                <select tabindex="5" class="w-100 form-control select2 select2-hidden-accessible"
                                    name="ingredient_id" id="ingredient_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($ingredients as $ingnts) { ?>
                                    <option
                                            value="<?php echo escape_output($ingnts->id . "|" . $ingnts->name . "|" . $ingnts->unit_name. "|" . $ingnts->consumption_unit_cost) ?>"
                                        <?php echo set_select('unit_id', $ingnts->id); ?>>
                                        <?php echo escape_output($ingnts->name) ?>
                                    </option>
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

                        <div class="col-sm-12 mb-2 col-md-4 div_show_hide_combo">
                            <div class="form-group">
                                <label><?php echo lang('food_menu'); ?></label>
                                <select tabindex="5" class="txt_21 form-control select2 select2-hidden-accessible"
                                        name="food_menu_id" id="food_menu_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($food_menus as $ingnts) {
                                        if($ingnts->is_variation!="Yes"):
                                            ?>
                                            <option data-name="<?php echo escape_output(getParentNameOnly($ingnts->parent_id)); ?> <?php echo escape_output($ingnts->name); ?>"
                                                    value="<?php echo escape_output($ingnts->id)?>"
                                                <?php echo set_select('unit_id', $ingnts->id); ?>>
                                                <?php echo escape_output(getParentNameOnly($ingnts->parent_id)); ?> <?php echo escape_output($ingnts->name . "(" . $ingnts->code . ")"); ?></option>
                                            <?php
                                        endif;
                                    } ?>
                                </select>
                            </div>
                            <?php if (form_error('food_menu_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('food_menu_id'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg ingredient_err_msg_contnr">
                                <p id="food_menu_id_err_msg"></p>
                            </div>
                        </div>

                        <div class="col-md-2 div_show_hide_combo">
                            <div class="hidden-xs hidden-sm mt-2">&nbsp;</div>
                            <a class="btn bg-red-btn" data-bs-toggle="modal"
                                data-bs-target="#noticeModal"><?php echo lang('read_me_first'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="hidden-lg hidden-sm">&nbsp;</div>

                    </div>

                    <div class="row div_show_hide">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('sn'); ?></th>
                                            <th><?php echo lang('ingredient'); ?></th>
                                            <th><?php echo lang('consumption'); ?></th>
                                            <th><?php echo lang('cost'); ?></th>
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
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="pull-right padding_17"><?php echo lang('total'); ?> <?php echo lang('cost'); ?></th>
                                        <th><input type="text" class="form-control" readonly name="grand_total_cost" placeholder="<?php echo lang('total'); ?> <?php echo lang('cost'); ?>" id="grand_total_cost"> </th>
                                        <th></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row div_show_hide_combo">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><?php echo lang('sn'); ?></th>
                                        <th><?php echo lang('food_menu'); ?></th>
                                        <th><?php echo lang('quantity'); ?></th>
                                        <th><?php echo lang('actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody id="food_menu_combo">
                                        <?php foreach ($added_combo_menus as $k=>$value):?>
                                            <tr class="food_row" data-id="<?php echo escape_output($value->added_food_menu_id)?>">
                                                <td class="ir_w_1"><p class="txt_food_row"></p></td>
                                                <td class="ir_w_23">
                                                    <?php echo escape_output($value->name)?> <input type="hidden" id="food_menu_id_hidden_4" name="food_menu_id_hidden[]" class="food_menu_id_hidden" value="<?php echo escape_output($value->added_food_menu_id)?>||<?php echo escape_output($value->name)?>"></td>
                                                <td><input type="text" tabindex="6" value="<?php echo escape_output($value->quantity)?>" id="qty_food_menu_4" name="qty_food_menu[]" onfocus="this.select();" class="form-control integerchk aligning vr01_qty_food_menu check_required_fm" placeholder="Quantity"></td>
                                                <td class="ir_w_17"><a class="btn btn-danger btn-xs del_fm txt_left_m_5"><i class="fa fa-trash"></i> </a></td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> (<?php echo lang('dine'); ?>) <span class="required_star">*</span></label>
                                <input tabindex="4" class="form-control ir_w_100" type="text" id="sale_price"
                                    name="sale_price" class="form-control integerchk"
                                    placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('dine'); ?>)"
                                    value="<?php echo escape_output($food_menu_details->sale_price) ?>">
                            </div>
                            <?php if (form_error('sale_price')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('sale_price'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg sale_price_err_msg_contnr">
                                <p id="sale_price_err_msg"></p>
                            </div>

                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>) <span class="required_star">*</span></label>
                                <input tabindex="4" type="text" onfocus="this.select();" id="sale_price_take_away"
                                       name="sale_price_take_away" class="form-control integerchk"
                                       onkeyup="return replacePonto();"
                                       placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>)"
                                       value="<?php echo escape_output($food_menu_details->sale_price_take_away) ?>">
                            </div>
                            <?php if (form_error('sale_price_take_away')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('sale_price_take_away'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg sale_price_take_away_err_msg_contnr">
                                <p id="sale_price_take_away_err_msg"></p>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>) <span class="required_star">*</span></label>
                                <?php if(isset($deliveryPartners) && sizeof($deliveryPartners)):?>
                                    <input type="hidden" name="sale_price_delivery" value="0">
                                    <table class="txt_21">
                                        <tbody>
                                        <?php
                                        $delivery_price = (array)json_decode($food_menu_details->delivery_price);
                                        foreach ($deliveryPartners as $value):
                                                $delivery_price_value = isset($delivery_price["index_".$value->id]) && $delivery_price["index_".$value->id]?$delivery_price["index_".$value->id]:'';
                                            ?>
                                            <tr>
                                                <td class="txt_21_50"><?php echo escape_output($value->name)?>
                                                </td>
                                                <td class="txt_21_50">
                                                    <input type="hidden" name="delivery_person[]" value="<?php echo escape_output($value->id)?>">
                                                    <input tabindex="4" type="text" onfocus="this.select();"
                                                           name="sale_price_delivery_json[]" class="form-control integerchk check_required"
                                                           placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)"
                                                           value="<?php echo escape_output($delivery_price_value); ?>"></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                <?php else:?>
                                    <input tabindex="1" type="text" id="sale_price_delivery" name="sale_price_delivery" class="form-control"
                                           placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)"
                                           value="<?php echo escape_output($food_menu_details->sale_price_delivery) ?>">
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <input tabindex="1" type="text" id="description" name="description" class="form-control"
                                    placeholder="<?php echo lang('description'); ?>"
                                    value="<?php echo escape_output($food_menu_details->description) ?>">
                            </div>
                            <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('description'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg description_err_msg_contnr">
                                <p id="description_err_msg"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('photo'); ?></label>(<small>
                                    <?php echo lang('photo_height_width'); ?></small>)
                                <input class="form-control" tabindex="10" type="file" name="photo" id="photo">
                            </div>
                            <?php if (form_error('photo')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('photo'); ?>
                            </div>
                            <?php } ?>
                            <input type="hidden" value="<?php echo escape_output($food_menu_details->photo); ?>"
                                name="photo">
                            <?php if(!empty($food_menu_details->photo)){?>
                            <img class="img-responsive" src="<?= base_url() . "images/" . $food_menu_details->photo ?>"
                                alt="Photo">
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('is_it_veg'); ?> ? <span class="required_star">*</span></label>
                                <select tabindex="2" class="form-control select2 ir_w_100" id="veg_item_id"
                                    name="veg_item">
                                    <option <?php if ($food_menu_details->veg_item == "Veg No") echo "selected" ?>
                                        value="Veg No"><?php echo lang('no'); ?></option>
                                    <option <?php if ($food_menu_details->veg_item == "Veg Yes") echo "selected" ?>
                                        value="Veg Yes"><?php echo lang('yes'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('veg_item_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('veg_item_id'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg veg_item_err_msg_contnr">
                                <p id="veg_item_id_err_msg"></p>
                            </div>

                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('is_it_beverage'); ?> ? <span
                                        class="required_star">*</span></label>
                                <select tabindex="2" class="w-100 form-control select2" id="beverage_item"
                                    name="beverage_item">
                                    <option <?php if ($food_menu_details->beverage_item == "Bev No") echo "selected" ?>
                                        value="Bev No"><?php echo lang('no'); ?></option>
                                    <option <?php if ($food_menu_details->beverage_item == "Bev Yes") echo "selected" ?>
                                        value="Bev Yes"><?php echo lang('yes'); ?></option>

                                </select>
                            </div>
                            <?php if (form_error('beverage_item')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('beverage_item'); ?>
                            </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg beverage_item_err_msg_contnr">
                                <p id="beverage_item_err_msg"></p>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <?php
                            $collect_tax = $this->session->userdata('collect_tax');
                            if(isset($collect_tax) && $collect_tax=="Yes"):
                            $tax_information = json_decode($food_menu_details->tax_information);
                            $tax_string_p = ($food_menu_details->tax_string);
                            //get company data
                            $company = getCompanyInfo();
                            $tax_setting = json_decode($company->tax_setting);
                            $tax_string_s = ($company->tax_string);

                            if($tax_string_p==$tax_string_s):
                                foreach($tax_information as $tax_field){
                                    if(setReadonly(5,$tax_field->tax_field_name)):
                                ?>

                            <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo escape_output($tax_field->tax_field_name) ?></label>
                                <table class="ir_w_100">
                                    <tr>
                                        <td>
                                            <input tabindex="1" type="hidden" name="tax_field_id[]"
                                                value="<?php echo escape_output((isset($tax_field->tax_field_id) && $tax_field->tax_field_id?$tax_field->tax_field_id:'')) ?>">
                                            <input tabindex="1" type="hidden" name="tax_field_company_id[]"
                                                value="<?php echo escape_output($tax_field->tax_field_company_id) ?>">
                                            <input tabindex="1" type="hidden" name="tax_field_name[]"
                                                value="<?php echo escape_output($tax_field->tax_field_name) ?>">
                                            <input tabindex="1" type="text" name="tax_field_percentage[]"
                                                class="form-control integerchk" placeholder=""
                                                value="<?php  echo escape_output($tax_field->tax_field_percentage) ?>">
                                        </td>
                                        <td class="txt_27">%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php
                                           endif;
                                            } ?>
                        <?php
                                            else:
                                                $arr = array();
                                                if($tax_information){
                                                    foreach($tax_information as $value_){
                                                        $arr[$value_->tax_field_name] = $value_->tax_field_percentage;
                                                    }
                                                }
                                                foreach($tax_setting as $single_tax){
                                                    $tax_percentage = '';
                                                    if(isset($arr[$single_tax->tax]) && $arr[$single_tax->tax]){
                                                        $tax_percentage = $arr[$single_tax->tax];
                                                    }else{
                                                        $tax_percentage = $single_tax->tax_rate;
                                                    }
                                                    if(setReadonly(5,$single_tax->tax)):
                                                ?>

                                                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo escape_output($single_tax->tax) ?></label>
                                <table class="ir_w_100">
                                    <tr>
                                        <td>
                                            <input tabindex="1" type="hidden" name="tax_field_id[]"
                                                value="<?php echo escape_output((isset($single_tax->id) && $single_tax->id?$single_tax->id:'')) ?>">
                                            <input tabindex="1" type="hidden" name="tax_field_company_id[]"
                                                value="<?php echo escape_output($this->session->userdata('company_id')); ?>">
                                            <input tabindex="1" type="hidden" name="tax_field_name[]"
                                                value="<?php echo escape_output($single_tax->tax) ?>">
                                            <input tabindex="1" type="text" name="tax_field_percentage[]"
                                                class="form-control integerchk" placeholder=""
                                                value="<?php  echo escape_output($tax_percentage) ?>">
                                        </td>
                                        <td class="txt_27">%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php

                                                    endif;
                                                } ?>


                        <?php
                                            endif;
                                            endif;
                                            ?>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('loyalty_point'); ?> </label>
                                <input tabindex="1" type="text" id="loyalty_point" name="loyalty_point" class="form-control"
                                       placeholder="<?php echo lang('loyalty_point'); ?>" value="<?php echo escape_output($food_menu_details->loyalty_point) ?>">
                            </div>
                            <?php if (form_error('loyalty_point')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('loyalty_point'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="row div_show_hide">
                        <h4><?php echo lang('Variation'); ?></h4>
                        <div class="table-responsive">
                            <table class="table table_margin_top_0">
                                <thead>
                                <tr>
                                    <th><?php echo lang('sn'); ?></th>
                                    <th><?php echo lang('variation_name'); ?></th>
                                    <th><?php echo lang('alternative_name'); ?></th>
                                    <th><?php echo lang('code'); ?></th>
                                    <th><?php echo lang('sale_price'); ?> (<?php echo lang('dine'); ?>)</th>
                                    <th><?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>)</th>
                                    <th><?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)</th>
                                    <th><?php echo lang('loyalty_point'); ?></th>
                                    <th><?php echo lang('actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody class="added_ingr_view">
                                <?php
                                    if(isset($variation_food_menus) && $variation_food_menus):
                                        foreach ($variation_food_menus as $key=>$value):
                                            $key++;
                                ?>
                                    <tr class="row_variation_view" id="row_variation_view1">
                                        <td class="vr_row_counter"><?php echo escape_output($key)?></td>
                                        <td><?php echo escape_output($value->name)?></td>
                                        <td><?php echo escape_output($value->alternative_name)?></td>
                                        <td><?php echo escape_output($value->code)?></td>
                                        <td><?php echo escape_output($value->sale_price)?></td>
                                        <td><?php echo escape_output($value->sale_price_take_away)?></td>
                                        <td><?php echo escape_output($value->sale_price_delivery)?></td>
                                        <td><?php echo escape_output($value->loyalty_point)?></td>
                                        <td>
                                            <input type="hidden" class="variation_row_update" value="<?php echo escape_output($value->id)?>" name="variation_row_update[]" id="variation_row_update1"><input type="hidden" class="variation_ingrs" value="<?php echo ($value->vr_ingr)?>" name="variation_ingrs[]" id="variation_ingrs1"><input type="hidden" value="<?php echo escape_output($value->name)?>" name="variation_name[]"><input type="hidden" value="<?php echo escape_output($value->alternative_name)?>" name="alternative_name_variation[]"><input type="hidden" value="<?php echo escape_output($value->sale_price)?>" name="m_sale_price[]"><input type="hidden" value="<?php echo escape_output($value->sale_price_take_away)?>" name="m_sale_price_take_away[]"><input type="hidden" value="<?php echo escape_output($value->sale_price_delivery)?>" name="m_sale_price_delivery[]"> <input type="hidden" value="<?php echo escape_output($value->loyalty_point)?>" name="vr01_loyalty_point_arr[]"> <input type="hidden" class="hidden_delivery_html" value="<?php echo escape_output($value->vr_del_details)?>" name="hidden_delivery_html[]" id="hidden_delivery_html"><input type="hidden" name="vr_tax_counter[]" value="1">
                                            <?php
                                                $collect_tax = $this->session->userdata('collect_tax');
                                                if(isset($collect_tax) && $collect_tax=="Yes"):
                                                $tax_information = json_decode($value->tax_information);
                                                $tax_string_p = ($value->tax_string);
                                                //get company data
                                                $company = getCompanyInfo();
                                                $tax_setting = json_decode($company->tax_setting);
                                                $tax_string_s = ($company->tax_string);

                                                if($tax_string_p==$tax_string_s):
                                                foreach($tax_information as $tax_field){ ?>
                                                        <div class="tax_details_view display_none">
                                                            <input type="hidden" value="" name="counter_tax[]">
                                                            <input tabindex="1" type="hidden" class="vr01_tax_field_id" value="<?php echo escape_output((isset($tax_field->tax_field_id) && $tax_field->tax_field_id?$tax_field->tax_field_id:'')) ?>" name="vr01_tax_field_id1[]">
                                                            <input tabindex="1" type="hidden" class="vr01_tax_field_company_id" value="<?php echo escape_output($tax_field->tax_field_company_id) ?>" name="vr01_tax_field_company_id1[]">
                                                            <input tabindex="1" type="hidden" class="vr01_tax_field_name" value="<?php echo escape_output($tax_field->tax_field_name) ?>" name="vr01_tax_field_name1[]">
                                                            <input tabindex="1" type="text" class="form-control integerchk add_change_value vr01_tax_field_percentage" placeholder="<?php echo escape_output($tax_field->tax_field_name) ?>" value="<?php  echo escape_output($tax_field->tax_field_percentage) ?>" name="vr01_tax_field_percentage1[]">
                                                        </div>

                                                <?php }
                                                endif;
                                            endif;
                                                ?>

                                                <i class="fa fa-edit row_edit"  data-title="<?php echo lang('Edit_Variation'); ?>" data-id="1"></i>
                                                <i class="fa fa-trash row_delete"></i>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                endif;
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-12 col-md-2 mb-2">
                            <button type="button" name="submit" class="btn bg-blue-btn w-100 add_variation" data-title="<?php echo lang('Add_Variation'); ?>"><?php echo lang('Add_Variation'); ?></button>
                        </div>

                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>foodMenu/foodMenus">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    
    <div class="modal fade" id="noticeModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="noticeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo lang('notice'); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="foodMenuCartNotice">
                                <strong class="ir_m_l_45"><?php echo lang('notice'); ?></strong><br>
                                <?php echo lang('notice_text_1'); ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="foodMenuCartInfo">
                                <a class="ir_font_bold" href="https://www.convert-me.com/en/convert/" target="_blank">
                                    <?php echo lang('click_here'); ?></a>
                                <?php echo lang('notice_text_2'); ?>
                                <br>
                                <br>
                                <?php echo lang('notice_text_3'); ?>
                                <br>
                                <span class="txt_17">
                                    <?php echo lang('notice_text_4'); ?></span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="photo" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="ShortCut">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        <img class="img-responsive" src="<?= base_url() . "images" . $food_menu_details->photo ?>"
                            alt="Photo">
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="variation_modal" role="dialog" aria-labelledby="myModalLabel">
        <input type="hidden" id="variation_update_id" value="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title variation_title">--</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('variation_name'); ?> <span class="required_star">*</span></label>
                               
                            
                                       <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" type="text" id="variation_name" name="variation_name" class="form-control required_checker"
                                        placeholder="<?php echo lang('variation_name'); ?>" value="<?php echo set_value('variation_name'); ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('variation_tooltip'); ?>" data-feather="help-circle"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('alternative_name'); ?> </label>
                              
                            
                                       <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" type="text" id="variation_alternative_name" name="variation_alternative_name" class="form-control required_checker"
                                        placeholder="<?php echo lang('alternative_name'); ?>" value="<?php echo set_value('variation_name'); ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                    <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('variation_tooltip'); ?>" data-feather="help-circle"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('code'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" id="variation_name_code" name="variation_name_code" class="form-control required_checker"
                                       placeholder="<?php echo lang('code'); ?>" value="<?php echo set_value('variation_name_code'); ?>">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> <span class="required_star">*</span> (<?php echo lang('dine'); ?>)</label>
                                <input tabindex="1" type="text" id="m_sale_price" name="m_sale_price" class="form-control integerchk required_checker"
                                       placeholder="<?php echo lang('sale_price'); ?>" value="<?php echo set_value('m_sale_price'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>) <span class="required_star">*</span></label>
                                <input tabindex="4" type="text" onfocus="this.select();" id="m_sale_price_take_away"
                                       name="m_sale_price_take_away" class="form-control integerchk required_checker"
                                       placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>)"
                                       value="<?php echo set_value('m_sale_price_take_away'); ?>">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label><?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>) <span class="required_star">*</span></label>
                                <?php if(isset($deliveryPartners) && sizeof($deliveryPartners)):?>
                                    <table class="txt_21">
                                        <tbody>
                                        <?php
                                        foreach ($deliveryPartners as $value):
                                            ?>
                                            <tr>
                                                <td class="txt_21_50"><?php echo escape_output($value->name)?></td>
                                                <td class="txt_21_50">
                                                    <input type="hidden" name="delivery_person_var[]" class="delivery_person_var delivery_person_var<?php echo escape_output($value->id)?>" value="<?php echo escape_output($value->id)?>">
                                                    <input tabindex="4" type="text" onfocus="this.select();"
                                                           name="sale_price_delivery_json_var[]" class="form-control integerchk required_checker sale_price_delivery_json_var sale_price_delivery_json_var<?php echo escape_output($value->id)?>"
                                                           placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)"
                                                           value="<?php echo set_value('sale_price_delivery'); ?>"></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                <?php else:?>
                                    <input tabindex="1" type="text" id="m_sale_price_delivery" name="m_sale_price_delivery" class="form-control integerchk"
                                           placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)"
                                           value="<?php echo set_value('sale_price_delivery'); ?>">
                                <?php endif;?>
                            </div>
                        </div>


                        <p class="margin_0">&nbsp;</p>
                        <div class="col-sm-12 mb-2 col-md-12">
                            <div class="form-group">
                                <label><?php echo lang('ingredient_consumptions'); ?></label>
                                <select tabindex="5" class="txt_21 form-control select2 select2-hidden-accessible"
                                        name="vr01_md_ingredient_id" id="vr01_md_ingredient_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach ($ingredients as $ingnts) { ?>
                                        <option
                                                value="<?php echo escape_output($ingnts->id . "|" . $ingnts->name . "|" . $ingnts->unit_name. "|" . $ingnts->consumption_unit_cost) ?>"
                                            <?php echo set_select('unit_id', $ingnts->id); ?>>
                                            <?php echo escape_output($ingnts->name . "(" . $ingnts->code . ")"); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php echo lang('sn'); ?></th>
                                    <th><?php echo lang('ingredient'); ?></th>
                                    <th><?php echo lang('consumption'); ?></th>
                                    <th><?php echo lang('cost'); ?></th>
                                    <th><?php echo lang('total'); ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="added_ingr">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="pull-right padding_17"><?php echo lang('total'); ?> <?php echo lang('cost'); ?></th>
                                    <th><input type="text" class="form-control" readonly name="var01_grand_total_cost" placeholder="<?php echo lang('total'); ?> <?php echo lang('cost'); ?>" id="var01_grand_total_cost"> </th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <p class="margin_0">&nbsp;</p>
                        <?php
                        $collect_tax = $this->session->userdata('collect_tax');
                        if(isset($collect_tax) && $collect_tax=="Yes"):
                            //get company data
                            $company = getCompanyInfo();
                            $tax_setting = json_decode($company->tax_setting);
                            foreach($tax_setting as $tax_field){
                                if(setReadonly(5,$tax_field->tax)):
                                ?>

                                <div class="col-sm-12 mb-2 col-md-4">
                                    <div class="form-group">
                                        <label><?php echo escape_output($tax_field->tax) ?></label>
                                        <table class="ir_w_100">
                                            <tr>
                                                <td class="tax_details">
                                                    <input type="hidden" value="" name="counter_tax[]">
                                                    <input tabindex="1" type="hidden" class="vr01_tax_field_id"
                                                           value="<?php echo escape_output((isset($tax_field->id) && $tax_field->id?$tax_field->id:'')) ?>">
                                                    <input tabindex="1" type="hidden" class="vr01_tax_field_company_id"
                                                           value="<?php echo escape_output($company->id) ?>">
                                                    <input tabindex="1" type="hidden" class="vr01_tax_field_name"
                                                           value="<?php echo escape_output($tax_field->tax) ?>">
                                                    <input tabindex="1" type="text"
                                                           class="form-control integerchk add_change_value vr01_tax_field_percentage"
                                                           placeholder="<?php echo escape_output($tax_field->tax) ?>" value="<?php echo escape_output($tax_field->tax_rate)?>">
                                                </td>
                                                <td class="txt_27">%</td>
                                            </tr>
                                        </table>


                                    </div>
                                </div>
                            <?php
                                endif;
                            }
                        endif;
                        ?>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('loyalty_point'); ?> </label>
                                <input tabindex="1" type="text" id="vr01_loyalty_point" name="vr01_loyalty_point" class="form-control"
                                       placeholder="<?php echo lang('loyalty_point'); ?>" value="<?php echo set_value('vr01_loyalty_point'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-3 mb-2">
                            <button type="button" name="submit" value="submit"
                                    class="btn bg-blue-btn w-100 add_variation_html"><?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


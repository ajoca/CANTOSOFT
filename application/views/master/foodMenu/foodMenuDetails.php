<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_food_menu.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/variation.css">
<section class="main-content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo lang('food_menu_details'); ?>
        </h1>
    </section>
    <div class="box-wrapper">

        <div class="table-box">

            <?php echo form_open(base_url() . 'foodMenu/addEditFoodMenu/' . $encrypted_id, $arrayName = array('id' => 'food_menu_form', 'enctype' => 'multipart/form-data')) ?>

            <div>

                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('product_type'); ?></label>
                            <p class=""><?php echo escape_output(isset($food_menu_details->product_type) && $food_menu_details->product_type==1?lang('Regular'):lang('Combo')) ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('name'); ?></label>
                            <p><?php echo escape_output($food_menu_details->name) ?></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('code'); ?></label>
                           <p><?php echo escape_output($food_menu_details->code) ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('category'); ?> </label>
                            <p class=""><?php echo escape_output(foodMenucategoryName($food_menu_details->category_id)); ?></p>
                        </div>
                    </div>
                </div>
                <?php if($food_menu_details->product_type!=3):?>
                    <div class="row">
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
                                            '<td><p>' . $fmi->consumption . ' ' . (isset($fmi->ingredient_id) && $fmi->ingredient_id ? unitName(getUnitIdByIgId($fmi->ingredient_id)) : '') . '</p></td>' .
                                            '<td><p>' . escape_output(getAmtPCustom($fmi->cost)) . '</p></td>' .
                                            '<td><p>' . escape_output(getAmtPCustom($fmi->total)) . '</p></td>' .
                                            '</tr>';
                                    }
                                }
                                ?>

                                </tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="pull-right "><?php echo lang('total'); ?> <?php echo lang('cost'); ?></th>
                                    <th><p><?php echo escape_output(getAmtPCustom($food_menu_details->total_cost)) ?></p></th>
                                    <th></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif?>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <p><?php echo escape_output(getAmtPCustom($food_menu_details->sale_price)) ?></p>
                            <label><?php echo lang('sale_price'); ?> (<?php echo lang('dine'); ?>) </label>
                        </div>

                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>) </label>
                            <p><?php echo escape_output(getAmtPCustom($food_menu_details->sale_price_take_away)) ?></p>
                        </div>

                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>) </label>
                            <table class="txt_21"">
                                <tbody>
                                        <?php
                                        $delivery_price = (array)json_decode($food_menu_details->delivery_price);
                                        foreach ($deliveryPartners as $value):
                                            $delivery_price_value = isset($delivery_price["index_".$value->id]) && $delivery_price["index_".$value->id]?$delivery_price["index_".$value->id]:'';
                                            ?>
                                            <tr>
                                                <td>
                                                    <p><?php echo escape_output($value->name)?></p>
                                                </td>
                                                <td>
                                                    <p><?php echo escape_output(getAmtPCustom($delivery_price_value)); ?></p></td>
                                            </tr>
                                        <?php endforeach;?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                           <p><?php echo escape_output($food_menu_details->description) ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">

                        <?php if(!empty($food_menu_details->photo)){?>
                            <div class="col-sm-12 mb-2 col-md-4">
                                    <img class="img-responsive" src="<?= base_url() . "images/" . $food_menu_details->photo ?>"
                                         alt="Photo">
                            </div>
                        <?php } ?>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('is_it_veg'); ?> ? </label>
                            <p><?php if($food_menu_details->veg_item == "Veg No"){ echo "No"; }else{ echo "Yes"; } ?></p>
                        </div>

                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('is_it_beverage'); ?> ? </label>
                            <p><?php if($food_menu_details->beverage_item == "Bev No"){ echo "No"; }else{ echo "Yes"; } ?></p>

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
                            foreach($tax_information as $tax_field){ ?>

                                <div class="col-sm-12 mb-2 col-md-4">
                                    <div class="form-group">
                                        <label><?php echo escape_output($tax_field->tax_field_name) ?></label>
                                        <table class="ir_w_100">
                                            <tr>
                                                <td>
                                                  <p><?php  echo escape_output($tax_field->tax_field_percentage) ?>%</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
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
                                ?>

                                <div class="col-sm-12 mb-2 col-md-4">
                                    <div class="form-group">
                                        <label><?php echo escape_output($single_tax->tax) ?></label>
                                        <table class="ir_w_100">
                                            <tr>
                                                <td>
                                                   <p><?php  echo escape_output($tax_percentage) ?>%</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php
                        endif;
                    endif;
                    ?>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('loyalty_point'); ?> </label>
                            <p><?php echo escape_output($food_menu_details->loyalty_point) ?></p>
                        </div>
                    </div>
                </div>

        <?php   if(isset($variation_food_menus) && $variation_food_menus):?>
                <div class="row div_show_hide">
                    <br>
                    <h4><?php echo lang('Variation'); ?></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('variation_name'); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('sale_price'); ?> (<?php echo lang('dine'); ?>)</th>
                                <th><?php echo lang('sale_price'); ?> (<?php echo lang('take_away'); ?>)</th>
                                <th><?php echo lang('loyalty_point'); ?></th>
                            </tr>
                            </thead>
                            <tbody class="added_ingr_view">
                            <?php
                            foreach ($variation_food_menus as $key=>$value):
                            $key++;
                            ?>
                            <tr class="row_variation_view" id="row_variation_view1">
                                <td class="vr_row_counter"><?php echo escape_output($key)?></td>
                                <td><?php echo escape_output($value->name)?></td>
                                <td><?php echo escape_output($value->code)?></td>
                                <td><?php echo escape_output(getAmtPCustom($value->sale_price))?></td>
                                <td><?php echo escape_output(getAmtPCustom($value->sale_price_take_away))?></td>
                                <td><?php echo escape_output($value->loyalty_point)?></td>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                    </table>
                </div>
            </div>
        <?php    endif;?>
            
            <?php echo form_close(); ?>
        </div>
    </div>
    </div>

</section>


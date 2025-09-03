<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/report.css">

<section class="main-content-wrapper">

<section class="content-header">
    <div>
        <h3 class="text-left top-left-header"><?php echo lang('inventory'); ?>  <?php echo lang('report'); ?></h3>
    </div>
    <input type="hidden" class="datatable_name" data-filter="no" data-title="<?php echo lang('inventory'); ?>  <?php echo lang('report'); ?>" data-id_name="datatable">
    
</section>

    <div class="box-wrapper">
            
                <?php echo form_open(base_url() . 'Report/inventoryReport') ?>
                <div class="row">
                    <input type="hidden" name="<?php echo escape_output($this->security->get_csrf_token_name()); ?>"
                        value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
                    <input type="hidden" name="hiddentIngredientID" id="hiddentIngredientID"
                        value="<?= isset($ingredient_id) ? $ingredient_id : '' ?>">
                    <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control select2 category_id ir_w_100" name="category_id" id="category_id">
                                <option value=""><?php echo lang('category'); ?></option>
                                <?php foreach ($ingredient_categories as $value) { ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('category_id', $value->id); ?>>
                                    <?php echo escape_output($value->category_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control select2 ir_w_100" name="ingredient_id" id="ingredient_id">
                                <option value=""><?php echo lang('ingredient'); ?></option>
                                <?php foreach ($ingredients as $value) {
                                    if ($value->id):
                                        ?>
                                        <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('ingredient_id', $value->id); ?>>
                                            <?php echo escape_output($value->name) . "(" . $value->code . ")" ?></option>
                                        <?php
                                    endif;
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3 col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control select2 ir_w_100" name="food_id" id="food_id">
                                <option value=""><?php echo lang('food_menu'); ?></option>
                                <?php foreach ($foodMenus as $value) {
                                if($value->is_variation!=1){
                                    $p_name = '';
                                    if($value->parent_id!='0'){
                                        $p_name = getVariationName($value->parent_id);
                                    }
                                    ?>
                                <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('food_id', $value->id); ?>>
                                    <?php echo substr(ucwords(strtolower((isset($p_name) && $p_name?$p_name." ":'').$value->name)), 0, 18) . "(" . $value->code . ")" ?>
                                </option>
                                <?php
                                    }
                                }

                                ?>
                            </select>
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
                    <div class="col-lg-2 col-md-4 col-sm-12 mb-2">
                        <button type="submit" name="submit" value="submit"
                            class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                    </div>
                    
                    <div class="col-sm-12 mb-2 col-md-2">
                        <a href="<?= base_url() . 'Inventory/getInventoryAlertList' ?>"
                            class="btn bg-blue-btn w-100"><span class="ir_color_red m-right"><?= getAlertCount() ?></span>
                            <?php echo lang('ingredients_alert'); ?> </a>
                    </div>
                    <div class="clearfix"></div>
                    
            </div>
            <?php
            echo form_close(); ?>
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="title" class="ir_w_5"><?php echo lang('sn'); ?></th>
                                <th class="title" class="ir_w_37">
                                    <?php echo lang('ingredient'); ?>(<?php echo lang('code'); ?>)</th>
                                <th class="title" class="ir_w_20"><?php echo lang('category'); ?></th>
                                <th class="title" class="ir_w_20"><?php echo lang('stock_qty_amount'); ?></th>
                                <th class="title" class="ir_w_20"><?php echo lang('total_cost'); ?></th>
                                <th class="title" class="ir_w_20"><?php echo lang('alert_qty_amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalStock = 0;
                        $grandTotal = 0;
                        $alertCount = 0;
                        $totalTK = 0;
                        
                        if (!empty($inventory) && isset($inventory)):
                            foreach ($inventory as $key => $value):
                                $conversion_rate = (int)$value->conversion_rate?(int)$value->conversion_rate:1;
                                if($value->id):
                                    $tmp = (float)$value->total_purchase * $conversion_rate;
                                    $total_consumption = (float)$value->total_consumption;
                                    $totalStock = ($value->total_purchase*$value->conversion_rate)  - $value->total_consumption - $value->total_modifiers_consumption - $value->total_waste + $value->total_consumption_plus - $value->total_consumption_minus + ($value->total_transfer_plus*$value->conversion_rate) - ($value->total_transfer_minus*$value->conversion_rate)  +  ($value->total_transfer_plus_2*$value->conversion_rate) -  ($value->total_transfer_minus_2*$value->conversion_rate)+ ($value->total_production*$value->conversion_rate);
                                    $last_purchase_price = getLastPurchaseAmount($value->id);
 
                                 
                                    $totalTK = ($last_purchase_price/$conversion_rate) * $totalStock;

                                    if ($totalStock >= 0) {
                                        $grandTotal += $totalTK;
                                    }
                                    if($value->conversion_rate==0 || $value->conversion_rate==''){
                                        $total_sale_unit = isset($value->conversion_rate) && (int)$value->conversion_rate?(int)($totalStock/1):'0';
                                    }else{
                                        $total_sale_unit = isset($value->conversion_rate) && (int)$value->conversion_rate?(int)($totalStock/$value->conversion_rate):'0';
                                    }

                                    $key++;

                                    ?>
                                    <tr>
                                        <td class="ir_txt_center"><?php echo escape_output($key); ?></td>
                                        <td><?= escape_output($value->name . "(" . $value->code . ")") ?></td>
                                        <td><?php echo escape_output($value->category_name); ?></td>
                                        <?php if($value->ing_type=="Plain Ingredient" && $value->is_direct_food!=2  && $value->conversion_rate!=1):?>
                                            <td style="<?= ($totalStock <= $value->alert_quantity) ? 'color:red' : '' ?>"><?php echo ($total_sale_unit)  && $total_sale_unit>0? getAmtP($total_sale_unit) : getAmtP(0) ?><?php echo " " . $value->unit_name2 ?></span> <span><?= ($totalStock) ? getAmtP($totalStock%$conversion_rate) : getAmtP(0) ?><?= " " . escape_output($value->unit_name)?></span></td>
                                        <?php else:
                                            $stock_float = (float)((($total_sale_unit)  && $total_sale_unit>0? ($total_sale_unit) : (0))+(($totalStock) ? ($totalStock%$conversion_rate) : (0)));
                                            ?>
                                            <td style="<?= ($totalStock <= $value->alert_quantity) ? 'color:red' : '' ?>"><?php echo escape_output(getAmtP($stock_float)) ?> <?= " " . escape_output($value->unit_name)?></span></td>
                                            <?php
                                        endif
                                        ?>
                                        <td><?= escape_output(getAmtP($totalTK)) ?></td>
                                        <td><?= escape_output(getAmtP($value->alert_quantity) . " " . $value->unit_name2) ?></td>

                                    </tr>
                                    <?php
                                    
                                endif;
                            endforeach;
                        endif;
                        ?>
                        <tr>
                                        <th class="ir_txt_center"></th>
                                        <th></th>
                                        <th></th>
                                        <th class="pull-right"><?php echo lang('total'); ?> =</th>
                                        <th><?= escape_output(getAmtP($grandTotal)) ?></th>
                                        <th></th>
                                    </tr>
                        </tbody>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>
    </div>


</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/inventory.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatable_custom/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report.js"></script>
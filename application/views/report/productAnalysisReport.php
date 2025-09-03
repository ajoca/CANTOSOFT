<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/foodMenuSales.css">



<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="text-left top-left-header"><?php echo lang('productAnalysisReport'); ?></h3>

        <input type="hidden" class="datatable_name" data-title="<?php echo lang('productAnalysisReport'); ?>" data-id_name="datatable">

    </section>

    <div class="my-3">
        <?php
        if(isLMni() && isset($outlet_id)):
            ?>
            <h4> <?php echo lang('outlet'); ?>: <?php echo escape_output(getOutletNameById($outlet_id))?></h4>
            <?php
        endif;
        ?>
        <h4>
            <?= isset($start_date) && $start_date && isset($end_date) && $end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) . " - " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?><?= isset($start_date) && $start_date && !$end_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($start_date)) : '' ?><?= isset($end_date) && $end_date && !$start_date ? lang('date').": " . date($this->session->userdata('date_format'), strtotime($end_date)) : '' ?>
        </h4>
    </div>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="row">
                <div class="mb-3 col-md-4 col-lg-2 col-sm-12">
                    <?php echo form_open(base_url() . 'Report/productAnalysisReport', $arrayName = array('id' => 'productAnalysisReport')) ?>
                    <div class="form-group">
                        <input tabindex="1" type="text" id="" name="startDate" readonly class="form-control customDatepicker"
                               placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                        <?php if (form_error('startDate')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('startDate'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3 col-md-4 col-lg-2 col-sm-12">

                    <div class="form-group">
                        <input tabindex="2" type="text" id="endMonth" name="endDate" readonly
                               class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>"
                               value="<?php echo set_value('endDate'); ?>">
                        <?php if (form_error('endDate')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('endDate'); ?>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <div class="mb-3 col-md-4 col-lg-2 col-sm-12">
                    <div class="form-group">
                        <select tabindex="2" class="form-control select2 ir_w_100" id="category_id"
                                name="category_id">
                            <option value=""><?php echo lang('select'); ?> <?php echo lang('category'); ?></option>
                            <?php foreach ($categories as $ctry) { ?>
                                <option value="<?php echo escape_output($ctry->id) ?>"
                                    <?php echo set_select('category_id', $ctry->id); ?>>
                                    <?php echo escape_output($ctry->category_name) ?></option>
                            <?php } ?>
                        </select>
                        <?php if (form_error('category_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('category_id'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                if(isLMni()):
                    ?>
                    <div class="mb-3 col-md-4 col-lg-2 col-sm-12">
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
                <div class="col-sm-12 col-md-4 col-lg-2">
                    <div class="form-group">
                        <button type="submit" name="submit" value="submit"
                                class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">

                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="ir_w2_txt_center"><?php echo lang('sn'); ?></th>
                        <th><?php echo lang('food_menu'); ?>(<?php echo lang('code'); ?>)</th>
                        <th><?php echo lang('SaleQty'); ?></th>
                        <th><?php echo lang('SaleQty'); ?> %</th>
                        <th><?php echo lang('cum_ratios'); ?></th>
                        <th><?php echo lang('price'); ?></th>
                        <th><?php echo lang('Revenue'); ?></th>
                        <th><?php echo lang('Revenue'); ?> %</th>
                        <th><?php echo lang('cum_ratios'); ?></th>
                        <th><?php echo lang('UnitCost'); ?></th>
                        <th><?php echo lang('total'); ?> <?php echo lang('UnitCost'); ?></th>
                        <th><?php echo lang('unit'); ?> <?php echo lang('Profit'); ?></th>
                        <th><?php echo lang('total'); ?> <?php echo lang('Profit'); ?> </th>
                        <th><?php echo lang('Profit'); ?> %</th>
                        <th><?php echo lang('cum_ratios'); ?></th>
                        <th><?php echo lang('sale'); ?> <?php echo lang('ranking'); ?></th>
                        <th><?php echo lang('Revenue'); ?> <?php echo lang('ranking'); ?></th>
                        <th><?php echo lang('Profit'); ?> <?php echo lang('ranking'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_revenue = 0;
                    $g_total_profit = 0;

                    if (isset($productAnalysisReport)):

                        $inline_total_profit = 0;
                        foreach ($productAnalysisReport as $key => $value) {
                            $price = $value->totalSale/$value->total_qty;
                            $sale_qty = $value->total_qty;
                            $revenue = $price*$sale_qty;
                            $total_cost = ($value->total_cost);

                            $total_unit_cost = $total_cost * $value->total_qty;
                            $inline_total_profit += ($revenue - $total_unit_cost);

                        }
                        $tmp_previous  = 0;
                        $tmp_previous1  = 0;
                        $tmp_previous2  = 0;
                        foreach ($productAnalysisReport as $key => $value) {
                            $key++;
                            $total_cost = ($value->total_cost);

                            $sale_qty = $value->total_qty;
                            $sale_qty_p = ($value->total_qty/$total_qty_all)*100;
                            $com_ratio_sale_qty = (($sale_qty_p + $tmp_previous));
                            $tmp_previous = $com_ratio_sale_qty;


                            $price = $value->totalSale/$value->total_qty;
                            $revenue = $price*$sale_qty;
                            $revenue_p = ($revenue/$total_amount_all)*100;

                            $com_ratio_revenue = (($revenue_p+$tmp_previous1));
                            $tmp_previous1 = $com_ratio_revenue;

                            $total_unit_cost = $total_cost * $value->total_qty;
                            $unit_profit = $price - $total_cost;
                            $total_profit = $revenue - $total_unit_cost;
                            $inline_total_profit_1 = ($total_profit/$inline_total_profit) * 100;

                            $com_ratio_profit = $inline_total_profit_1+$tmp_previous2;
                            $tmp_previous2 = $com_ratio_profit;
                            $total_revenue+=$revenue;
                            $g_total_profit+=$total_profit;
                            ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($key); ?></td>
                                <td><?php echo escape_output($value->menu_name) ?></td>
                                <td><?php echo escape_output(getAmtP($sale_qty)) ?></td>
                                <td><?php echo escape_output(getAmtP($sale_qty_p)) ?></td>
                                <td><?php echo escape_output(getAmtP($com_ratio_sale_qty)) ?></td>
                                <td><?php echo escape_output(getAmtP($price)) ?></td>
                                <td><?php echo escape_output(getAmtP($revenue)) ?></td>
                                <td><?php echo escape_output(getAmtP($revenue_p)) ?></td>
                                <td><?php echo escape_output(getAmtP($com_ratio_revenue)) ?></td>
                                <td><?php echo escape_output(getAmtP($total_cost)) ?></td>
                                <td><?php echo escape_output(getAmtP($total_unit_cost)) ?></td>
                                <td><?php echo escape_output(getAmtP($unit_profit)) ?></td>
                                <td><?php echo escape_output(getAmtP($total_profit)) ?></td>
                                <td><?php echo escape_output(getAmtP($inline_total_profit_1)) ?></td>
                                <td><?php echo escape_output(getAmtP($com_ratio_profit)) ?></td>
                                <th><?php echo (getRanking($com_ratio_sale_qty)) ?></th>
                                <th><?php echo (getRanking($com_ratio_revenue)) ?></th>
                                <th><?php echo (getRanking($com_ratio_profit)) ?></th>
                            </tr>
                            <?php
                        }
                    endif;
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="ir_txt_center"></th>
                        <th class="pull-right"><?php echo lang('total'); ?></th>
                        <th><?php echo escape_output(getAmtP(isset($total_qty_all) && $total_qty_all?$total_qty_all:0)) ?></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th><?php echo escape_output(getAmtP(isset($total_revenue) && $total_revenue?$total_revenue:0)) ?></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th><?php echo escape_output(getAmtP(isset($g_total_profit) && $g_total_profit?$g_total_profit:0)) ?></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                        <th class="ir_txt_center"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    </div>


</section>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">
</script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/abc_report.js"></script>
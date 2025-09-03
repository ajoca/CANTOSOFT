<input type="hidden" id="foodmenu_already_remain" value="<?php echo lang('foodmenu_already_remain'); ?>">
<input type="hidden" id="supplier_field_required" value="<?php echo lang('supplier_field_required'); ?>">
<input type="hidden" id="date_field_required" value="<?php echo lang('date_field_required'); ?>">
<input type="hidden" id="at_least_ingredient" value="<?php echo lang('at_least_ingredient'); ?>">
<input type="hidden" id="paid_field_required" value="<?php echo lang('paid_field_required'); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" id="alert" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="tax_type" value="<?php echo $this->session->userdata("tax_type")?>">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_purchase.css">


<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('refund'); ?>
        </h3>
    </section>



    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">

            <?php echo form_open(base_url() . 'Sale/refund/' . $encrypted_id, $arrayName = array('id' => 'refund_form')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label><?php echo lang('sale_no'); ?></label>
                            <p><?php echo escape_output($sale->sale_no) ?></p>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label><?php echo lang('customer'); ?> </label>
                            <div class="d-flex align-items-center">
                                <div class="w-100">
                                    <?php echo getCustomerName($sale->customer_id)?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label><?php echo lang('waiter'); ?> </label>
                            <div class="d-flex align-items-center">
                                <div class="w-100">
                                    <?php echo userName($sale->waiter_id)?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label><?php echo lang('sale'); ?> <?php echo lang('date'); ?> </label>
                            <p><?php echo date('Y-m-d', strtotime($sale->sale_date)); ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label><?php echo lang('total_payable'); ?> </label>
                            <div class="d-flex align-items-center">
                                <div class="w-100">
                                    <?php echo ($sale->total_payable)?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('sale'); ?> <?php echo lang('food_menu'); ?>
                            </label>
                            <select tabindex="4" class="form-control select2 select2-hidden-accessible ir_w_100"
                                    name="food_details_id" id="food_details_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($sale_details as $ingnts) {
                                    $total_tax = 0;
                                    $taxs = json_decode($ingnts->menu_taxes);
                                    foreach ($taxs as $val){
                                        $total_tax+=($val->item_vat_amount_for_unit_item);
                                    }

                                    ?>
                                    <option
                                            value="<?php echo escape_output($ingnts->id . "|" . $ingnts->menu_name."|" . $ingnts->qty . "|" . $ingnts->menu_unit_price. "|" . $ingnts->discount_amount. "|" . $total_tax) ?>"
                                        <?php echo set_select('unit_id', $ingnts->id); ?>>
                                        <?php echo escape_output($ingnts->menu_name) ?></option>
                                <?php } ?>
                            </select>
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
                                    <th><?php echo lang('food_menu'); ?>(<?php echo lang('code'); ?>)</th>
                                    <th><?php echo lang('quantity'); ?></th>
                                    <th><?php echo lang('price'); ?></th>
                                    <th><?php echo lang('vat'); ?></th>
                                    <th><?php echo lang('discount'); ?></th>
                                    <th><?php echo lang('refund_qty'); ?></th>
                                    <th><?php echo lang('refund_amount'); ?></th>
                                    <th><?php echo lang('actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody id="sale_refund_cart">
                                <?php
                                $i = 0;
                                if($sale->refund_content){
                                    $sale_json = (Object)json_decode($sale->refund_content);
                                }else{
                                    $sale_json = '';
                                }
                                if ($sale_json && !empty($sale_json)) {
                                    foreach ($sale_json as $pi) {?>
                                        <tr class="rowCount" data-item_id="<?php echo escape_output($pi->item_id)?>">
                                            <td class="sn_class"></td>
                                            <td><?php echo escape_output($pi->name)?></td>
                                            <td class="row_sale_qty" id="row_sale_qty_1"><?php echo escape_output($pi->qty)?></td>
                                            <td class="row_price" id="row_price_1"><?php echo escape_output($pi->price)?></td>
                                            <td class="row_vat" id="row_discount_1"><?php echo escape_output($pi->vat)?></td>
                                            <td class="row_discount" id="row_discount_1"><?php echo escape_output($pi->discount)?></td>
                                            <td><input type="hidden" name="qty[]" value="<?php echo escape_output($pi->qty)?>"><input type="hidden" name="name[]" value="<?php echo escape_output($pi->name)?>"><input type="hidden" name="price[]" value="<?php echo escape_output($pi->price)?>"><input type="hidden" value="<?php echo escape_output($pi->discount)?>" name="discount[]"><input type="hidden" value="<?php echo escape_output($pi->vat)?>" name="vat[]"><input type="number" name="refund_qty[]" value="<?php echo escape_output($pi->refund_qty)?>" class="form-control row_qty cal_row required_checker"></td>
                                            <td class="row_total" id="row_total_1">0.00</td>
                                            <td><i class="fa fa-trash remove_row text-red" style="cursor: pointer"></i> </td>
                                        </tr>
                                    <?php }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('total_refund'); ?></label>
                            <input class="form-control" readonly type="text" name="total_refund"
                                   id="total_refund" placeholder="<?php echo lang('total_refund'); ?>" value="<?php echo escape_output($sale->total_refund) ?>">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="col-md-1"></div>
                    <div class="clearfix"></div>
                    <div class="col-md-1"></div>
                        <div class="clearfix"></div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('payment_method'); ?> <span class="required_star">*</span></label>
                                <select tabindex="3" class="form-control select2 ir_w_100" id="payment_id"
                                        name="payment_id">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php foreach (getAllPaymentMethods(5) as $value) {
                                        ?>
                                        <option value="<?php echo escape_output($value->id) ?>" <?php echo $sale->refund_payment_id==$value->id?'selected':''; ?>
                                            <?php echo set_select('payment_id', $value->id); ?>>
                                            <?php echo escape_output($value->name)?></option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                            <?php if (form_error('payment_id')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('payment_id'); ?>
                                </div>
                            <?php } ?>
                            <div class="callout callout-danger my-2 error-msg payment_id_err_msg_contnr">
                                <p id="payment_id_err_msg"></p>
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

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Sale/sales">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url('frequent_changing/js/refund.js'); ?>"></script>

</section>

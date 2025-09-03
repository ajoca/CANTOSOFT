<?php
$base_color = '';
$getCompanyInfo = getCompanyInfo();
?>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>

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


    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('Setting'); ?>
        </h3>
    </section>
    <div class="box-wrapper">
        <div class="row">

            <!-- left column -->
            <div class="col-md-12">
                <div class="table-box">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php
                $attributes = array('id' => 'restaurant_setting_form');
                echo form_open_multipart(base_url('setting/index/' . $encrypted_id),$attributes); ?>
                    <div class="box-body">
                        <div class="row">

                        <?php
                                if(!isFoodCourt()):
                                    if($getCompanyInfo->id==1):
                                ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('business_name'); ?> <span
                                            class="required_star">*</span></label>
                                    <input tabindex="1" autocomplete="off" type="text" id="business_name"
                                        name="business_name" class="form-control"
                                        placeholder="<?php echo lang('business_name'); ?>"
                                        value="<?php echo escape_output($outlet_information->business_name); ?>">
                                </div>
                                <?php if (form_error('business_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('business_name'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('short_name'); ?> <span
                                            class="required_star">*</span></label>
                                    <input tabindex="1" autocomplete="off" type="text" id="short_name"
                                        name="short_name" class="form-control"
                                        placeholder="<?php echo lang('short_name'); ?>"
                                        value="<?php echo escape_output($outlet_information->short_name); ?>">
                                </div>
                                <?php if (form_error('short_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('short_name'); ?>
                                </div>
                                <?php } ?>
                            </div>
  <?php
                                    endif;
                                endif;
                                ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <div class="form-label-action">
                                        <input type="hidden" name="invoice_logo_p"
                                            value="<?php echo escape_output($outlet_information->invoice_logo)?>">
                                        <label><?php echo lang('Invoice_Logo'); ?></label>
                                        
                                    </div>
                                   

                                    <table>
                                    <tr>
                                        <td>
                                        <input tabindex="2" type="file" id="logo" name="invoice_logo" class="form-control">

                                        </td>
                                        <td> 
                                            <a data-file_path="<?php echo base_url()?>images/<?php echo escape_output($outlet_information->invoice_logo); ?>"
                                            data-id="1" data-title="<?php echo lang('Invoice_Logo'); ?>" class="new-btn h-40 show_preview"
                                            href="#"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('invoice_logo')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('invoice_logo'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label><?php echo lang('Website'); ?></label>
                                    <input tabindex="3" autocomplete="off" type="text" id="website" name="website"
                                        class="form-control" placeholder="<?php echo lang('Website'); ?>"
                                        value="<?= escape_output($outlet_information->website); ?>">
                                </div>
                                <?php if (form_error('website')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('website'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('date_format'); ?> <span
                                            class="required_star">*</span></label>
                                    <select tabindex="4" class="form-control select2" name="date_format"
                                        id="date_format">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->date_format == "d/m/Y" ? 'selected' : '' ?>
                                            selected value="d/m/Y">D/M/Y</option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->date_format == "m/d/Y" ? 'selected' : '' ?>
                                            value="m/d/Y">M/D/Y</option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->date_format == "Y/m/d" ? 'selected' : '' ?>
                                            value="Y/m/d">Y/M/D</option>
                                    </select>
                                </div>
                                <?php if (form_error('date_format')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('date_format'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('Time_Zone'); ?> <span class="required_star">*</span></label>
                                    <select tabindex="5" class="form-control select2" id="zone_name" name="zone_name">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php foreach ($zone_names as $zone_name) { ?>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->zone_name == $zone_name->zone_name ? 'selected' : '' ?>
                                            value="<?= escape_output($zone_name->zone_name) ?>">
                                            <?= escape_output($zone_name->zone_name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if (form_error('zone_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('zone_name'); ?>
                                </div>
                                <?php } ?>

                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label><?php echo lang('currency'); ?> <span class="required_star">*</span></label>
                                    <input tabindex="6" autocomplete="off" type="text" name="currency"
                                        class="form-control" placeholder="<?php echo lang('currency'); ?>"
                                        value="<?php echo escape_output($outlet_information->currency); ?>">
                                </div>
                                <?php if (form_error('currency')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('currency'); ?>
                                </div>
                                <?php } ?>

                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('Currency_Position'); ?> <span
                                            class="required_star">*</span></label>
                                    <select tabindex="7" class="form-control select2" name="currency_position"
                                        id="currency_position">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->currency_position == "Before Amount" ? 'selected' : '' ?>
                                            value="Before Amount"><?php echo lang('Before_Amount'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->currency_position == "After Amount" ? 'selected' : '' ?>
                                            value="After Amount"><?php echo lang('After_Amount'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('currency_position')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('currency_position'); ?>
                                </div>
                                <?php } ?>
                            </div>
                         
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3 display_none">

                                <div class="form-group">
                                    <label> <?php echo lang('Rounding'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="8" class="form-control select2" name="is_rounding_enable" id="is_rounding_enable">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->is_rounding_enable == "0" ? 'selected' : '' ?>
                                                value="0"><?php echo lang('disable'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->is_rounding_enable == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('enable'); ?></option>

                                    </select>
                                </div>
                                <?php if (form_error('is_rounding_enable')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('is_rounding_enable'); ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('Precision'); ?> <span
                                            class="required_star">*</span></label>
                                    <select tabindex="8" class="form-control select2" name="precision" id="precision">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->precision == "2" ? 'selected' : '' ?>
                                            value="2"><?php echo lang('2_Digit'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->precision == "3" ? 'selected' : '' ?>
                                            value="3"><?php echo lang('3_Digit'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('precision')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('precision'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('decimals_separator'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="7" class="form-control select2" name="decimals_separator"
                                            id="decimals_separator">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->decimals_separator == "." ? 'selected' : '' ?>
                                                value="."><?php echo lang('separator_dot'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->decimals_separator == "," ? 'selected' : '' ?>
                                                value=","><?php echo lang('separator_comma'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->decimals_separator == " " ? 'selected' : '' ?>
                                                value=" "><?php echo lang('space'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('decimals_separator')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('decimals_separator'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('thousands_separator'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="7" class="form-control select2" name="thousands_separator"
                                            id="thousands_separator">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->thousands_separator == "." ? 'selected' : '' ?>
                                                value="."><?php echo lang('separator_dot'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->thousands_separator == "," ? 'selected' : '' ?>
                                                value=","><?php echo lang('separator_comma'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->thousands_separator == " " ? 'selected' : '' ?>
                                                value=" "><?php echo lang('space'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('thousands_separator')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('thousands_separator'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('when_clicking_on_item_in_pos'); ?>  </label>
                                   

                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <select tabindex="12" class="form-control select2" name="when_clicking_on_item_in_pos"
                                            id="when_clicking_on_item_in_pos">

                                        <option
                                            <?= isset($outlet_information) && $outlet_information->when_clicking_on_item_in_pos == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('show_options'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->when_clicking_on_item_in_pos == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('dont_show_options'); ?></option>
                                    </select>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('when_clicking_on_item_in_pos_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>

                                </div>
                                <?php if (form_error('when_clicking_on_item_in_pos')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('when_clicking_on_item_in_pos'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('default_order_type'); ?>  </label>
                                 

                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <select tabindex="12" class="form-control select2" name="default_order_type"
                                            id="default_order_type">
                                        <option value=""><?php echo lang('None'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->default_order_type == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('dine'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->default_order_type == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('take_away'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->default_order_type == "3" ? 'selected' : '' ?>
                                                value="3"><?php echo lang('delivery'); ?></option>
                                    </select>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('default_order_type_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('default_order_type')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('default_order_type'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('default_order_type_delivery_p'); ?> </label>
                                    <select tabindex="12" class="form-control select2" name="default_order_type_delivery_p"
                                            id="default_order_type_delivery_p">
                                        <option value=""><?php echo lang('None'); ?></option>
                                        <?php foreach ($deliveryPartners as $value):?>
                                            <option <?php echo set_select('default_order_type_delivery_p',$value->id)?>  <?= isset($outlet_information) && $outlet_information->default_order_type_delivery_p == $value->id ? 'selected' : '' ?>  value="<?php echo escape_output($value->id)?>"><?php echo escape_output($value->name)?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <?php if (form_error('default_order_type_delivery_p')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('default_order_type_delivery_p'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            $language_manifesto = $this->session->userdata('language_manifesto');
                            $check_walk_in_customer = 1;
                            if(str_rot13($language_manifesto)!="eriutoeri"):
                            ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('Default_Waiter'); ?>  </label>
                                    <select tabindex="9" class="form-control select2" name="default_waiter"
                                        id="default_waiter">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php
                                    foreach ($waiters as $value):
                                        if($value->designation=="Waiter"):
                                        ?>
                                        <option
                                            <?=($outlet_information->default_waiter==$value->id?'selected':($value->id==1?'selected':''))?>
                                            value="<?=escape_output($value->id)?>"><?=escape_output($value->full_name)?>
                                        </option>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                    </select>
                                </div>
                                <?php if (form_error('default_waiter')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('default_waiter'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php endif; ?>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('Default_Customer'); ?><span
                                            class="required_star">*</span></label>
                                    <select tabindex="10" class="form-control select2" name="default_customer"
                                        id="default_customer">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php

                                    foreach ($customers as $value1):
                                        if($value1->id==1){
                                            $check_walk_in_customer++;
                                        }
                                        ?>
                                        <option <?=($outlet_information->default_customer==$value1->id?'selected':'')?>
                                            value="<?=escape_output($value1->id)?>"><?=escape_output($value1->name)?>
                                        </option>
                                        <?php
                                    endforeach;
                                    if($check_walk_in_customer==1){?>
                                        <option selected value="1">Walk-in Customer</option>
                                        <?php
                                    }

                                    ?>
                                    </select>
                                </div>
                                <?php if (form_error('default_customer')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('default_customer'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">

                                <div class="form-group">
                                    <label> <?php echo lang('Default_Payment_Method'); ?> <span
                                            class="required_star">*</span></label>
                                    <select tabindex="11" class="form-control select2" name="default_payment"
                                        id="default_payment">
                                        <option value=""><?php echo lang('select'); ?></option>
                                        <?php
                                    foreach (getAllPaymentMethods(5) as $value):
                                        ?>
                                        <option
                                            <?=($outlet_information->default_payment==$value->id?'selected':'')?>
                                            value="<?=escape_output($value->id)?>"><?=escape_output($value->name)?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                    </select>
                                </div>
                                <?php if (form_error('default_payment')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('default_payment'); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('place_order_tooltip'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="7" class="form-control select2" name="place_order_tooltip"
                                            id="place_order_tooltip">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->place_order_tooltip== "show" ? 'selected' : '' ?>
                                                value="show"><?php echo lang('show')?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->place_order_tooltip== "hide" ? 'selected' : '' ?>
                                                value="hide"><?php echo lang('hide')?></option>
                                    </select>
                                </div>
                                <?php if (form_error('place_order_tooltip')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('place_order_tooltip'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('food_menu_tooltip'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="7" class="form-control select2" name="food_menu_tooltip"
                                            id="food_menu_tooltip">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->food_menu_tooltip== "show" ? 'selected' : '' ?>
                                                value="show"><?php echo lang('show')?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->food_menu_tooltip== "hide" ? 'selected' : '' ?>
                                                value="hide"><?php echo lang('hide')?></option>
                                    </select>
                                </div>
                                <?php if (form_error('food_menu_tooltip')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('food_menu_tooltip'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('sms_send_auto'); ?> </label>
                                    <select tabindex="7" class="form-control select2" name="sms_send_auto"
                                            id="sms_send_auto">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->sms_send_auto== "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('no')?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->sms_send_auto== "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('yes')?></option>
                                    </select>
                                </div>
                                <?php if (form_error('sms_send_auto')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('sms_send_auto'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            $company_id = $this->session->userdata('company_id');
                            if($company_id==1):
                            ?>

                            <?php  endif; ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3 display_none">
                                <div class="form-group">
                                    <label><?php echo lang('split_bill'); ?> </label>
                                    

                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <select tabindex="8" class="form-control select2" name="split_bill" id="split_bill">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->split_bill == "0" ? 'selected' : '' ?>
                                                value="0"><?php echo lang('no'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->split_bill == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('yes'); ?></option>

                                    </select>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('split_bill_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('split_bill')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('split_bill'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('pre_or_post_payment'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="11" class="form-control select2" name="pre_or_post_payment"
                                            id="pre_or_post_payment">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->pre_or_post_payment == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('post_payment'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->pre_or_post_payment == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('pre_payment'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('pre_or_post_payment')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('pre_or_post_payment'); ?>
                                    </div>
                                <?php } ?>
                            </div>

                           

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('service_amount'); ?></label>
                                   
                                        <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="13" autocomplete="off" type="text" id="service_amount"
                                        name="service_amount" class="form-control"
                                        placeholder="<?php echo lang('default_discount_pl'); ?>"
                                        value="<?php echo escape_output($outlet_information->service_amount); ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('service_charge_tooltip'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('service_amount')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('service_amount'); ?>
                                </div>
                                <?php } ?>
                            </div>
                           

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('take_away_service_charge'); ?></label>
                                   
                                        <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="13" autocomplete="off" type="text" id="take_away_service_charge"
                                        name="take_away_service_charge" class="form-control"
                                        placeholder="<?php echo lang('default_discount_pl'); ?>"
                                        value="<?php echo escape_output($outlet_information->take_away_service_charge); ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('take_away_service_charge_tooltip'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('take_away_service_charge')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('take_away_service_charge'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('delivery_amount'); ?> </label>
                               
                                           <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="13" autocomplete="off" type="text" id="delivery_amount"
                                           name="delivery_amount" class="form-control"
                                           placeholder="<?php echo lang('default_discount_pl'); ?>"
                                           value="<?php echo escape_output($outlet_information->delivery_amount); ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('delivery_charge_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('delivery_amount')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('delivery_amount'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('kot_print_online_self_order'); ?> </label>
                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="7" class="form-control select2" name="kot_print_online_self_order"
                                            id="kot_print_online_self_order">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->kot_print_online_self_order== "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('no')?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->kot_print_online_self_order== "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('yes')?></option>
                                    </select>
                                </div>
                                <?php if (form_error('kot_print_online_self_order')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('kot_print_online_self_order'); ?>
                                    </div>
                                <?php } ?>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('kot_print_in_accept_order'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                    
                            </div>

                            <div class="clearfix"></div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('active_login_button'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="11" class="form-control select2" name="active_login_button"
                                            id="active_login_button">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->active_login_button == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('username_password'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->active_login_button == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('pin'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('active_login_button')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('active_login_button'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('login_type'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="11" class="form-control select2" name="login_type"
                                            id="login_type">
                                            <option
                                            <?= isset($outlet_information) && $outlet_information->login_type == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('both'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->login_type == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('username_password'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->login_type == "3" ? 'selected' : '' ?>
                                                value="3"><?php echo lang('pin'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('login_type')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('login_type'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('show_order_full_short'); ?> </label>
                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="7" class="form-control select2" name="show_order_full_short"
                                            id="show_order_full_short">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->show_order_full_short== "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('short_order_number')?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->show_order_full_short== "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('full_order_number')?></option>
                                    </select>
                                </div>
                                <?php if (form_error('show_order_full_short')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('show_order_full_short'); ?>
                                    </div>
                                <?php } ?>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('short_order_note'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                    
                            </div>

                            <?php if(isServiceAccess('','','sGmsJaFJE')):?>
                                <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('saas_landing_page'); ?>  </label>
                                    
                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="12" class="form-control select2" name="saas_landing_page"
                                            id="saas_landing_page">

                                        <option
                                            <?= isset($outlet_information) && $outlet_information->saas_landing_page == "1" ? 'selected' : '' ?>
                                                value="1"><?php echo lang('show'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->saas_landing_page == "2" ? 'selected' : '' ?>
                                                value="2"><?php echo lang('hide'); ?></option>
                                    </select>
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('saas_landing_page_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('saas_landing_page')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('saas_landing_page'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php endif?>
                            <div class="clearfix"></div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label><?php echo lang('is_loyalty_enable'); ?></label>
                                   
                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="12" class="form-control select2" name="is_loyalty_enable"
                                            id="is_loyalty_enable">

                                        <option
                                            <?= isset($outlet_information) && $outlet_information->is_loyalty_enable == "disable" ? 'selected' : '' ?>
                                                value="disable"><?php echo lang('disable'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->is_loyalty_enable == "enable" ? 'selected' : '' ?>
                                                value="enable"><?php echo lang('enable'); ?></option>
                                    </select>
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('is_loyalty_enable_tooltip'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('is_loyalty_enable')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('is_loyalty_enable'); ?>
                                </div>
                                <?php } ?>
                            </div>

                       
                            
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3 div_loyalty">
                                <div class="form-group">
                                    <label><?php echo lang('minimum_point_to_redeem'); ?> <span
                                                class="required_star">*</span></label>
                                    <input tabindex="13" autocomplete="off" type="number" id="minimum_point_to_redeem"
                                           name="minimum_point_to_redeem" class="form-control"
                                           placeholder="<?php echo lang('minimum_point_to_redeem'); ?>"
                                           value="<?php echo escape_output($outlet_information->minimum_point_to_redeem); ?>">
                                </div>
                                <?php if (form_error('minimum_point_to_redeem')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('minimum_point_to_redeem'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3 div_loyalty">
                                <div class="form-group">
                                    <label><?php echo lang('loyalty_rate'); ?> <span
                                                class="required_star">*</span>  </label>
                                    

                                           <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="13" autocomplete="off" type="text" id="loyalty_rate"
                                           name="loyalty_rate" class="form-control integerchk"
                                           placeholder="<?php echo lang('loyalty_rate'); ?>"
                                           value="<?php echo escape_output($outlet_information->loyalty_rate); ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                            <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('loyalty_rate_tooltip'); ?>"></i>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('loyalty_rate')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('loyalty_rate'); ?>
                                    </div>
                                <?php } ?>
                            </div>

                            
                            <div class="my-2"></div>

                            <?php  if(!isServiceAccessOnlyLogin('sGmsJaFJE')): ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label> <?php echo lang('ExportDailySalesResetAllSales'); ?></label>
                                    
                                   

                                    <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <select tabindex="16" class="form-control select2" name="export_daily_sale"
                                        id="export_daily_sale">
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->export_daily_sale == "disable" ? 'selected' : '' ?>
                                            value="disable"><?php echo lang('disable'); ?></option>
                                        <option
                                            <?= isset($outlet_information) && $outlet_information->export_daily_sale == "enable" ? 'selected' : '' ?>
                                            value="enable"><?php echo lang('enable'); ?></option>
                                    </select>
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom"><i class="fa fa-question fa-lg form_question"></i>
                                        <span
                                            class="tooltiptext_custom"><?php echo lang('tooltip_txt_export_daily_sale'); ?></span>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <?php if (form_error('export_daily_sale')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('export_daily_sale'); ?>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label></label>
                                    <table data-access="reset-350" class="menu_assign_class ir_w_100">
                                        <tr>
                                            <td><a  class="btn bg-blue-btn delete new-btn"
                                                    href="<?php echo base_url(); ?>setting/resetTransactionalData"><?php echo lang('ResetTransactionalData'); ?></a>
                                            </td>
                                            <td class="ir_w_1">
                                                <div class="tooltip_custom"><i
                                                        class="fa fa-question fa-lg form_question"></i>
                                                    <span
                                                        class="tooltiptext_custom"><?php echo lang('set_transactional_data'); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php  endif; ?>


                         
                            <div class="clearfix"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label><?php echo lang('invoice_footer'); ?></label>
                                    <textarea id="invoice_footer" rows="6" name="invoice_footer" class="form-control"
                                        placeholder="<?php echo lang('invoice_footer'); ?>"><?php echo escape_output($outlet_information->invoice_footer); ?></textarea>
                                </div>
                                <?php if (form_error('invoice_footer')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('invoice_footer'); ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                            <i data-feather="upload"></i>
                            <?php echo lang('submit'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logo_preview" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo lang('Invoice_Logo'); ?> </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"
                            style="background-color: <?php echo escape_output($base_color)?>;text-align: center;padding: 10px;">
                            <img class="img-fluid" src="" id="show_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn"
                        data-dismiss="modal"  data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                </div>
            </div>

        </div>
    </div>

</section>
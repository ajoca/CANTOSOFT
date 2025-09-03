<link rel="stylesheet" href="<?= base_url() ?>frequent_changing/css/custom_check_box.css">
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
            <?php
            $data_c = getLanguageManifesto();
            if(str_rot13($data_c[0])=="eriutoeri"){
                echo lang('edit_outlet');
            }else if(str_rot13($data_c[0])=="fgjgldkfg"){
                echo lang('outlet_setting');
            }
            ?>
        </h3>

    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open(base_url('Outlet/addEditOutlet/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <?php
                    if(str_rot13($data_c[0])=="eriutoeri") {
                        ?>
                        <div class="col-sm-12 mb-2 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('outlet_code'); ?> <span
                                            class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="outlet_code"
                                        class="form-control" onfocus="select();"
                                        placeholder="<?php echo lang('outlet_code'); ?>"
                                        value="<?php echo escape_output($outlet_information->outlet_code) ?>"/>
                            </div>
                            <?php if (form_error('outlet_code')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('outlet_code'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" autocomplete="off" type="text" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo escape_output($outlet_information->outlet_name); ?>">
                        </div>
                        <?php if (form_error('outlet_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('outlet_name'); ?>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="col-sm-12 mb-2 col-md-3">

                        <div class="form-group">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <input tabindex="4" autocomplete="off" type="text" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo escape_output($outlet_information->phone); ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('phone'); ?>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">

                        <div class="form-group">
                            <label><?php echo lang('email'); ?> </label>
                            <input tabindex="4" autocomplete="off" type="text" name="email" class="form-control" placeholder="<?php echo lang('email'); ?>" value="<?php echo escape_output($outlet_information->email); ?>" />
                        </div>
                        <?php if (form_error('email')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('email'); ?>
                            </div>
                        <?php } ?>

                    </div>

                    <?php
                    $language_manifesto = $this->session->userdata('language_manifesto');
                    if(str_rot13($language_manifesto)=="eriutoeri"):
                        ?>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('Active_Status'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2" name="active_status" id="active_status">
                                <option <?php echo isset($outlet_information->active_status) && $outlet_information->active_status=="active"?'selected':''?> value="active"><?php echo lang('Active'); ?></option>
                                <option <?php echo isset($outlet_information->active_status) && $outlet_information->active_status=="inactive"?'selected':''?> value="inactive"><?php echo lang('Inactive'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('active_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('active_status'); ?>
                            </div>
                        <?php } ?>
                    </div>

                        <div class="col-sm-12 mb-2 col-md-3">

                            <div class="form-group">
                                <label> <?php echo lang('Default_Waiter'); ?></label>
                                <select tabindex="2" class="form-control select2" name="default_waiter" id="default_waiter">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($waiters as $value):
                                        if($value->designation=="Waiter"):
                                            ?>
                                            <option <?=($outlet_information->default_waiter==$value->id?'selected':'')?>  value="<?=$value->id?>"><?=$value->full_name?></option>
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
                        <?php
                    endif;
                    ?>

                    <div class="col-sm-12 mb-2 col-md-3">

                        <div class="form-group">
                            <label><?php echo lang('address'); ?> <span class="required_star">*</span></label>
                            <textarea tabindex="3" autocomplete="off" name="address" class="form-control" placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($outlet_information->address); ?></textarea>
                        </div>
                        <?php if (form_error('address')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('address'); ?>
                            </div>
                        <?php } ?>

                    </div>
                        

                    <div class="mb-3 col-sm-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label> <?php echo lang('online_order_module'); ?> </label>
                                <select tabindex="7" class="form-control select2" name="online_order_module"
                                        id="online_order_module">
                                        <option
                                        <?= isset($outlet_information) && $outlet_information->online_order_module== "2" ? 'selected' : '' ?>
                                            value="2"><?php echo lang('yes')?></option>
                                        <option
                                        <?= isset($outlet_information) && $outlet_information->online_order_module== "1" ? 'selected' : '' ?>
                                            value="1"><?php echo lang('no')?></option>
                                  
                                </select>
                            </div>
                            <?php if (form_error('online_order_module')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('online_order_module'); ?>
                                </div>
                            <?php } ?>
                        </div>
                </div>

                <?php
                $language_manifesto = $this->session->userdata('language_manifesto');
                if(str_rot13($language_manifesto)=="eriutoeri"):
                ?>

                <div class="row my-3">
                    <div class="col-sm-6 col-md-12">
                        <div class="form-group">
                            <h6><?php echo lang('tooltip_txt_26'); ?></h6>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6 col-md-12">
                        <label class="container txt_48"> <?php echo lang('select_all'); ?>
                            <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                            <span class="checkmark"></span>
                        </label>
                        <b class="pull-right info_red"><?php echo lang('order_type_details'); ?></b>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <?php
                    foreach ($items as $item) {
                        $checked = '';
                        $new_id = $item->id;
                        if (isset($selected_modules_arr)):
                            foreach ($selected_modules_arr as $uma) {
                                if (in_array($new_id, $selected_modules_arr)) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            }
                        endif;
                        $previous_price = (array)json_decode($outlet_information->food_menu_prices);
                        $sale_price_tmp = isset($previous_price["tmp".$item->id]) && $previous_price["tmp".$item->id]?$previous_price["tmp".$item->id]:'';

                        $dine_ta_price = $item->sale_price;
                        $sale_ta_price = $item->sale_price_take_away;
                        $sale_de_price = $item->sale_price_delivery;

                        if(isset($sale_price_tmp) && $sale_price_tmp){
                            $sale_price = explode("||",$sale_price_tmp);
                            $dine_ta_price = isset($sale_price[0]) && $sale_price[0]?$sale_price[0]:$item->sale_price;
                            $sale_ta_price = isset($sale_price[1]) && $sale_price[1]?$sale_price[1]:$item->sale_price_take_away;
                            $sale_de_price = isset($sale_price[2]) && $sale_price[2]?$sale_price[2]:$item->sale_price_delivery;
                        }

                        ?>
                        <div class="col-sm-12 col-md-3 mb-2">
                            <div class="border_custom">
                            <label class="container txt_47" for="checker_<?php echo escape_output($item->id)?>"><?="<b>".getParentNameTemp($item->parent_id).(isset($item->name) && $item->name?''.$item->name.'':'')."</b>"?>
                                <input class="checkbox_user child_class" id="checker_<?php echo escape_output($item->id)?>"  <?=$checked?> data-name="<?php echo str_replace(' ', '_', $item->name)?>" value="<?=$item->id?>" type="checkbox" name="item_check[]">
                                <span class="checkmark"></span>
                            </label>
                            <div class="form-group outlet-price-field">
                                <label class="txt_outlet_1"><?php echo lang('price'); ?><?php echo lang('DI'); ?></label>
                                <input  type="text" value="<?php echo escape_output($dine_ta_price)?>" name="price_<?php echo escape_output($item->id)?>" placeholder="<?php echo lang('price');?><?php echo lang('DI'); ?>" onfocus="select()" class="txt_21 form-control">
                            </div>
                            <div class="form-group outlet-price-field">
                                <label class="txt_outlet_1"><?php echo lang('price'); ?><?php echo lang('TA'); ?></label>
                                <input  type="text" value="<?php echo escape_output($sale_ta_price)?>" name="price_ta_<?php echo escape_output($item->id)?>" placeholder="<?php echo lang('price');?><?php echo lang('TA'); ?>" onfocus="select()" class="txt_21 form-control">
                            </div>
                        <?php if(!sizeof($deliveryPartners)):?>
                            <div class="form-group outlet-price-field">
                                <label class="txt_outlet_1"><?php echo lang('price'); ?><?php echo lang('De'); ?></label>
                                <input  type="text" value="<?php echo escape_output($sale_de_price)?>" name="price_de_<?php echo escape_output($item->id)?>" placeholder="<?php echo lang('price');?><?php echo lang('De'); ?>" onfocus="select()" class="form-control txt_21">
                            </div>
                        <?php else:?>
                            <label class="margin_top_de_price"><?php echo lang('price'); ?> <?php echo lang('De'); ?></label>
                                <div class="form-group  outlet-price-field">

                                    <table class="txt_21 margin_left_de_price">
                                        <tbody>
                                        <?php
                                        $delivery_price = (array)json_decode($outlet_information->delivery_price);
                                        foreach ($deliveryPartners as $value):
                                            $delivery_price_value = (array)json_decode(isset($delivery_price["index_".$item->id]) && $delivery_price["index_".$item->id]?$delivery_price["index_".$item->id]:'');
                                            $dl_price = isset($delivery_price_value["index_".$value->id]) && $delivery_price_value["index_".$value->id]?$delivery_price_value["index_".$value->id]:'';
                                            if(!$dl_price){
                                                $dl_price = $item->sale_price;
                                            }
                                            ?>
                                            <tr>
                                                    <td class="txt_21_50"><?php echo escape_output($value->name)?>
                                                </td>
                                                <td class="txt_21_50">
                                                    <input type="hidden" name="delivery_person<?=$item->id?>[]" value="<?php echo escape_output($value->id)?>">
                                                    <input tabindex="4" type="text" onfocus="this.select();"
                                                            name="sale_price_delivery_json<?=$item->id?>[]" class="margin_top_9 form-control integerchk check_required"
                                                            placeholder="<?php echo lang('sale_price'); ?> (<?php echo lang('delivery'); ?>)"
                                                            value="<?php echo escape_output($dl_price); ?>"></td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif;?>
                            <br>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
                endif;
                ?>
            </div>
            <!-- /.box-body -->
            <?php
            $data_c = getLanguageManifesto();
            ?>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>
            
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Outlet/outlets">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/edit_outlet.js"></script>
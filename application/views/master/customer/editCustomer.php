
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_customer'); ?>
        </h3>
    </section>

    
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <?php echo form_open(base_url('customer/addEditCustomer/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('customer_name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" name="name" class="form-control"
                                placeholder="<?php echo lang('customer_name'); ?>"
                                value="<?php echo escape_output($customer_information->name) ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('name'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <small><?php echo lang('should_country_code'); ?></small>
                            <input tabindex="2" type="text" name="phone" class="form-control integerchk"
                                placeholder="Phone" value="<?php echo escape_output($customer_information->phone) ?>">
                        </div>
                        <?php if (form_error('phone')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('phone'); ?>
                        </div>
                        <?php } ?>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('email'); ?></label>
                            <input tabindex="3" type="text" name="email" class="form-control"
                                placeholder="<?php echo lang('email'); ?>"
                                value="<?php echo escape_output($customer_information->email) ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('date_of_birth'); ?></label>
                            <input tabindex="4" type="text" id="date" name="date_of_birth" class="form-control customDatepicker"
                                placeholder="<?php echo lang('date_of_birth'); ?>"
                                value="<?php echo escape_output($customer_information->date_of_birth) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('date_of_anniversary'); ?></label>
                            <input tabindex="5" type="text" id="dates2" name="date_of_anniversary"
                                class="form-control" placeholder="<?php echo lang('date_of_anniversary'); ?>"
                                value="<?php echo escape_output($customer_information->date_of_anniversary) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('address'); ?></label>
                            <textarea tabindex="6" name="address" class="form-control"
                                placeholder="<?php echo lang('address'); ?>"><?php echo escape_output($customer_information->address) ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('default_discount'); ?></label>
                            <input tabindex="3" type="text" name="default_discount" class="form-control"
                                    placeholder="<?php echo lang('default_discount_pl'); ?>"
                                    value="<?php echo escape_output($customer_information->default_discount) ?>">
                        </div>
                        <?php if (form_error('default_discount')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('default_discount'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('online_order_login_password'); ?> (<i><?php echo lang('unchanged'); ?></i>)</label>
                            <input tabindex="3" type="text" name="online_order_login_password" class="form-control"
                                    placeholder="<?php echo lang('online_order_login_password'); ?>"
                                    value="">
                        </div>
                        <?php if (form_error('online_order_login_password')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('online_order_login_password'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>
                    <?php if(collectGST()=="Yes"){?>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('same_or_diff_state'); ?> <span class="required_star">*</span> </label>
                                <select tabindex="4" class="form-control select2" name="same_or_diff_state"
                                        id="same_or_diff_state">
                                    <option value=""><?php echo lang('select'); ?></option>
                                    <option
                                        <?= isset($customer_information) && $customer_information->same_or_diff_state == "1" ? 'selected' : '' ?>
                                            <?php echo set_value('same_or_diff_state',1)?> value="1"><?php echo lang('same_state'); ?></option>
                                    <option
                                        <?= isset($customer_information) && $customer_information->same_or_diff_state == "2" ? 'selected' : '' ?>
                                            <?php echo set_value('same_or_diff_state',2)?> value="2"><?php echo lang('different_state'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('same_or_diff_state')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('same_or_diff_state'); ?>
                                </div>
                            <?php } ?>
                        </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('gst_number'); ?> <span class="required_star">*</span></label>
                            <input tabindex="3" type="text" name="gst_number" class="form-control"
                                placeholder="<?php echo lang('gst_number'); ?>"
                                value="<?php echo escape_output($customer_information->gst_number) ?>">
                        </div>
                        <?php if (form_error('gst_number')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('gst_number'); ?>
                            </div>
                        <?php } ?>
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

            <a class="btn bg-blue-btn" href="<?php echo base_url() ?>customer/customers">
                <i data-feather="corner-up-left"></i>
                <?php echo lang('back'); ?>
            </a>
        </div>
        <?php echo form_close(); ?>
    </div>
 
        
</section>
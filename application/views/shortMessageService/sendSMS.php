<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('send'); ?> <?php echo ucfirstcustom($type); ?>  <?php echo lang('sms'); ?>
        </h3>  
    </section>

    <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">

                <?php echo form_open(base_url('Short_message_service/sendSMS/'.$type)); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label> <?php echo lang('outlet_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="outlet_name" class="form-control" placeholder="<?php echo lang('outlet_name'); ?>" value="<?php echo escape_output($outlet_name); ?>">

                                <?php if (form_error('outlet_name')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('outlet_name'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                            <?php if($type == "custom"){?>
                                <div class="col-sm-12 col-md-6 mb-2">
                                    <div class="form-group">
                                        <label><?php echo lang('number'); ?> <span class="required_star">*</span></label><small> <?php echo lang('must_include_country_code'); ?></small>
                                        <input tabindex="1" type="text" name="number" class="form-control" placeholder="<?php echo lang('number'); ?>" >
                                    </div>
                                    <?php if (form_error('number')) { ?>
                                        <div class="callout callout-danger my-2">
                                            <?php echo form_error('number'); ?>
                                        </div>
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                      
                        <div class="col-sm-12 col-md-6 mb-2">
                            <div class="form-group">
                                <label><?php echo lang('message'); ?> <span class="required_star">*</span></label>
                                <!--This variable could not be escaped because this is html content-->
                                <textarea tabindex="5" class="form-control" rows="4" name="message" placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($message); ?></textarea>
                                <?php if (form_error('message')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('message'); ?>
                                    </div>
                                <?php } ?>

                                <?php if($type == 'birthday' || $type == 'anniversary'){?>
                                    <div class="form-group">
                                        <small><?php echo lang('there_are'); ?> <b><?php echo count($sms_count); ?></b> <?php echo lang('customer_has'); ?> <?php echo escape_output($type); ?> <?php echo lang('today'); ?>.</small>
                                    </div>
                                <?php } ?>

                                <?php if($type == 'customAll'){?>
                                    <div class="form-group">
                                        <small><?php echo lang('only'); ?> <b><?php echo count($sms_count); ?></b> <?php echo lang('customer_has_valid'); ?></small>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div> 
                    <!-- /.box-body --> 
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Short_message_service/smsService">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
    </div>
</section>
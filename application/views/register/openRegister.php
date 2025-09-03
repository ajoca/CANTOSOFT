<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception_3')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_3'));unset($_SESSION['exception_3']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('open_register'); ?>
        </h3>
    </section>
    <link href="<?php echo base_url(); ?>frequent_changing/css/register.css" rel="stylesheet" type="text/css" />

    <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">

            <div class="ds-tabs-container">
                <div class="ds-tabs-nav">
                    <button class="ds-tab-button active" data-tab="tab1"><?php echo lang('new_register'); ?></button>
                    <button class="ds-tab-button" data-tab="tab2"><?php echo lang('existing_register'); ?></button> 
                </div>
                <div class="ds-tab-content active" id="tab1">
                        
                <!-- form start -->
                <?php echo form_open(base_url('Register/addBalance')); ?>
                <input type="hidden" name="opening_balance" id="opening_balance" class="opening_balance_hidden" value="0">
                <div>
                    <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                        <div class="form-label-action">
                        <label for=""><?php echo lang('counter');?> <span class="required_star">*</span> </label>
                          <a data-id="1" class="btn bg-blue-btn btn-sm" href="<?php echo base_url()?>counter/addEditCounter"><i class="fa fa-plus"></i> <?php echo lang('Add'); ?> <?php echo lang('counter'); ?></a>
                                    </div>
                            <select name="counter_id" id="counter_id" class="select2 form-control">
                                <option value=""><?php echo lang('select') ?></option>
                                <?php foreach($counters as $counter){ ?>
                                <option value="<?php echo escape_output($counter->id) ?>"><?php echo escape_output($counter->name) ?></option>
                                <?php } ?>
                            </select>
                            <?php if (form_error('counter_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('counter_id'); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                        <?php foreach (getAllPaymentMethods(5) as $value):?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo escape_output($value->name); ?></label>
                                <input type="hidden" value="<?php echo escape_output($value->name); ?>" name="payment_names[]">
                                <input type="hidden" value="<?php echo escape_output($value->id); ?>" name="payment_ids[]">
                                <input tabindex="1" onfocus="select();" type="text" name="payments[]" class="form-control cal_row"
                                    placeholder="<?php echo lang('opening_balance'); ?>"
                                    value="0">
                            </div>
                            <?php if (form_error('opening_balance')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('opening_balance'); ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php endforeach;?>
                    </div>
                                
                    

                </div>
                <!-- /.box-body -->
                <p>&nbsp;</p>
                <a><?php echo lang('total_opening_balance'); ?>: <b class="total_opening_balance">0.00</b></a>
                <p>&nbsp;</p>
                <div class="box-footer px-0">
                    <button type="submit" name="submit" value="submit"
                        class="btn bg-blue-btn"><?php echo lang('submit'); ?></button>

                </div>
                <?php echo form_close(); ?>
                </div>
                <div class="ds-tab-content" id="tab2">
                      <!-- form start -->
                <?php echo form_open(base_url('Register/addExistingBalance')); ?>
                <input type="hidden" name="opening_balance" id="opening_balance" class="opening_balance_hidden" value="0">
                <div>
                    <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                        <div class="form-label-action">
                        <label for=""><?php echo lang('counter');?> <span class="required_star">*</span> </label>
                          <a data-id="1" class="btn bg-blue-btn btn-sm" href="<?php echo base_url()?>counter/addEditCounter"><i class="fa fa-plus"></i> <?php echo lang('Add'); ?> <?php echo lang('counter'); ?></a>
                                    </div>
                            <select name="counter_id" id="counter_id" class="select2 form-control">
                                <option value=""><?php echo lang('select') ?></option>
                                <?php foreach($counters as $counter){ ?>
                                <option value="<?php echo escape_output($counter->id) ?>"><?php echo escape_output($counter->name) ?></option>
                                <?php } ?>
                            </select>
                            <?php if (form_error('counter_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('counter_id'); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div> 
                    </div>
                                
                    

                </div>
                <!-- /.box-body -->
                <p>&nbsp;</p>
                <div class="box-footer px-0">
                    <button type="submit" name="submit" value="submit"
                        class="btn bg-blue-btn"><?php echo lang('submit'); ?></button>

                </div>
                <?php echo form_close(); ?>
                </div>
                
            </div>


            
            </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url('frequent_changing/js/opening_register.js'); ?>"></script>
</section>
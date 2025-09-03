<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
<section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_counter'); ?>
        </h3>
    </section>


    <div class="box-wrapper">
        
        <div class="table-box">
            
            <?php echo form_open(base_url('Counter/addEditCounter/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('counter_name'); ?> <span class="required_star">*</span></label>
                            <input  type="text" name="name" class="form-control"
                                placeholder="<?php echo lang('counter_name'); ?>"
                                value="<?php echo escape_output($counter->name) ?>">
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('name'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>       
                    <?php if(isLMni()):?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('outlet'); ?> <span class="required_star">*</span></label>
                            <select name="outlet_id" id="outlet_id" class="select2 form-control">
                                <option value=""><?php echo lang('select') ?></option>
                                <?php 
                                     $outlets = getAllOutlestByAssign();
                                     foreach ($outlets as $value){
                                ?>
                                <option <?php echo $counter->outlet_id == $value->id ? 'selected' : '' ?> value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('outlet_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('outlet_id'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
                     else:
                    ?>
                        <input type="hidden" id="outlet_id" name="outlet_id" value="<?php echo $this->session->userdata('outlet_id');?>">
                    <?php
                         endif;
                    ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('invoice_printer'); ?></label>
                            <input type="hidden" id="hidden_invoice_printer_id" value="<?php echo (set_value('invoice_printer_id')?set_value('invoice_printer_id'):$counter->invoice_printer_id); ?>">
                            <select name="invoice_printer_id" id="invoice_printer_id" class="select2 form-control">
                                <option value=""><?php echo lang('select') ?></option>
                            </select>
                        </div>
                        <?php if (form_error('invoice_printer_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('invoice_printer_id'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('bill_printer'); ?></label>
                            <input type="hidden" id="hidden_bill_printer_id" value="<?php echo (set_value('bill_printer_id')?set_value('bill_printer_id'):$counter->bill_printer_id); ?>">
                            <select name="bill_printer_id" id="bill_printer_id" class="select2 form-control">
                                <option value=""><?php echo lang('select') ?></option>
                            </select>
                        </div>
                        <?php if (form_error('bill_printer_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('bill_printer_id'); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div> 
                    <div class="col-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input  type="text" name="description" class="form-control"
                                    placeholder="<?php echo lang('description'); ?>" value="<?php echo escape_output($counter->description) ?>" >
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('description'); ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Counter/counters">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/counter.js'); ?>"></script>
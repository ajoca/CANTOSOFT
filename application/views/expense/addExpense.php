<!-- Main content -->
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('add_expense'); ?>
        </h3>
    </section>

    <div class="box-wrapper">   
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url('Expense/addEditExpense')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-3">

                        <div class="form-group">
                            <label><?php echo lang('date'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" id="date" name="date" readonly class="form-control"
                                placeholder="<?php echo lang('date'); ?>" value="<?php echo date("Y-m-d",strtotime('today')); ?>">
                        </div>
                        <?php if (form_error('date')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('date'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                            <input tabindex="2" type="text" name="amount" onfocus="this.select();"
                                class="form-control integerchk" placeholder="<?php echo lang('amount'); ?>"
                                value="<?php echo set_value('amount'); ?>">
                        </div>
                        <?php if (form_error('amount')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('amount'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('category'); ?> <span class="required_star">*</span></label>
                            <select tabindex="3" class="form-control select2 ir_w_100" name="category_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($expense_categories as $ec) { ?>
                                <option value="<?php echo escape_output($ec->id) ?>"
                                    <?php echo set_select('category_id', $ec->id); ?>><?php echo escape_output($ec->name) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('category_id')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('category_id'); ?>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('responsible_person'); ?> <span
                                    class="required_star">*</span></label>
                            <select tabindex="4" class="form-control select2 ir_w_100" name="employee_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($employees as $empls) { ?>
                                <option value="<?php echo escape_output($empls->id) ?>"
                                    <?php echo set_select('employee_id', $empls->id); ?>>
                                    <?php echo escape_output($empls->full_name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('employee_id')) { ?>
                            <div class="callout callout-danger my-2-2">
                                <?php echo form_error('employee_id'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('payment_method'); ?> <span class="required_star">*</span></label>
                            <select tabindex="3" class="form-control select2 ir_w_100" id="payment_id"
                                    name="payment_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach (getAllPaymentMethods(5) as $value) {
                                    ?>
                                    <option value="<?php echo escape_output($value->id) ?>"
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
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label><?php echo lang('note'); ?></label>
                            <textarea tabindex="5" class="form-control" rows="4" name="note"
                                placeholder="<?php echo lang('enter'); ?> ..."><?php echo escape_output($this->input->post('note')); ?></textarea>
                        </div>
                        <?php if (form_error('note')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('note'); ?>
                        </div>
                        <?php } ?>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Expense/expenses">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
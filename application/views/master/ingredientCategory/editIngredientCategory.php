<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_ingredient_category'); ?>
        </h3>
    </section>

    
    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url('ingredientCategory/addEditIngredientCategory/' . $encrypted_id)); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">

                        <div class="form-group">
                            <label><?php echo lang('category_name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" name="category_name" class="form-control"
                                placeholder="<?php echo lang('category_name'); ?>"
                                value="<?php echo escape_output($category_information->category_name) ?>">
                        </div>
                        <?php if (form_error('category_name')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('category_name'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6">

                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input tabindex="2" type="text" name="description" class="form-control"
                                placeholder="<?php echo lang('description'); ?>"
                                value="<?php echo escape_output($category_information->description) ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('description'); ?>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <!-- /.box-body -->

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>ingredientCategory/ingredientCategories">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
        
</section>
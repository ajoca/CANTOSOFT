<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('add_food_menu_category'); ?>
        </h3>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open_multipart(base_url('foodMenuCategory/addEditFoodMenuCategory')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">

                        <div class="form-group">
                            <label><?php echo lang('category_name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" name="category_name" class="form-control"
                                placeholder="<?php echo lang('category_name'); ?>"
                                value="<?php echo set_value('category_name'); ?>">
                        </div>
                        <?php if (form_error('category_name')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('category_name'); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('category_image'); ?> (Width: 200px, Height:200px )</label>
                            </div>
                            <input type="file" id="logo" accept="image/*" name="category_image" class="form-control">
                        </div>
                        <?php if (form_error('category_image')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('category_image'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-6">

                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input tabindex="2" type="text" name="description" class="form-control"
                                placeholder="<?php echo lang('description'); ?>"
                                value="<?php echo set_value('description'); ?>">
                        </div>
                    </div>
                    

                </div>
            </div>

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>foodMenuCategory/foodMenuCategories">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
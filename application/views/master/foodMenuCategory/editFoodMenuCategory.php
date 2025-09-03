<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>

<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_food_menu_category'); ?>
        </h3>
    </section>

    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open_multipart(base_url('foodMenuCategory/addEditFoodMenuCategory/' . $encrypted_id)); ?>
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
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="category_image_old" value="<?php echo isset($category_information->category_image) && $category_information->category_image ? $category_information->category_image : ''; ?>">
                                <label><?php echo lang('category_image'); ?> (Width: 200px, Height:200px )</label>
                                
                            </div>
                            
                            <table>
                                <tr>
                                    <td>
                                    <input type="file" id="logo" accept="image/*" name="category_image" class="form-control">

                                    </td>
                                    <td> 
                                    <a data-file_path="<?php echo base_url()?>uploads/category/<?php echo isset($category_information->category_image) && $category_information->category_image ? $category_information->category_image : ''; ?>"  data-id="1" class="new-btn h-40 show_preview" href="#"><i class="fa fa-eye"></i>&nbsp;<?php echo lang('show'); ?></a>
                                    
                                    </td>
                                </tr>
                            </table>
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
                                value="<?php echo escape_output($category_information->description) ?>">
                        </div>
                    </div>
                    

                </div>
            </div>
            <!-- /.box-body -->

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




<div class="modal fade" id="logo_preview" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                        <?php echo lang('system_logo'); ?> </h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-bod">
                    <div class="row">
                        <div class="col-md-12 site_logo_parent_div">
                            <img class="site_logo_parent_img ir_w_100" src="" id="show_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                </div>
            </div>

        </div>
    </div>
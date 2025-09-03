<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('edit_area'); ?>
        </h3>
    </section>

    
        <div class="box-wrapper">
            
            <div class="table-box">
                
                <?php echo form_open(base_url('area/addEditArea/' . $encrypted_id)); ?>
                <div class="box-body">
                    <div class="row">
                        <?php
                        if(isLMni()):
                            ?>
                            <div class="col-sm-12 mb-2 col-md-4">

                                <div class="form-group">
                                    <label><?php echo lang('outlet'); ?> <span class="required_star">*</span></label>
                                    <select class="form-control select2" name="outlet">
                                        <?php
                                        foreach ($outlets as $outlet):
                                            ?>
                                            <option <?=isset($area->outlet_id) && $area->outlet_id == $outlet->id?'selected':''?> value="<?php echo escape_output($outlet->id)?>"><?php echo escape_output($outlet->outlet_name)?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <?php if (form_error('outlet')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('outlet'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="col-sm-12 mb-2 col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('area_name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="area_name" class="form-control"
                                    placeholder="<?php echo lang('area_name'); ?>"
                                    value="<?php echo escape_output($area->area_name) ?>">
                            </div>
                            <?php if (form_error('area_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('area_name'); ?>
                            </div>
                            <?php } ?>

                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">

                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <input tabindex="2" type="text" name="description" class="form-control"
                                       placeholder="<?php echo lang('description'); ?>"
                                       value="<?php echo escape_output($area->description) ?>">
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

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>area/areas">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        
</section>
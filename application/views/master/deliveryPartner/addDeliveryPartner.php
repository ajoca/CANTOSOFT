
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('addDeliveryPartner'); ?>
        </h3>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
                <!-- form start -->
            <?php echo form_open(base_url() . 'deliveryPartner/addEditDeliveryPartner/', $arrayName = array('id' => 'add_category','enctype'=>'multipart/form-data')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-3">

                            <div class="form-group">
                                <label><?php echo lang('name'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text" name="name" class="form-control"
                                    placeholder="<?php echo lang('name'); ?>"
                                    value="<?php echo set_value('name'); ?>">
                            </div>
                            <?php if (form_error('name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('name'); ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-3">
                            <div class="form-group">
                                <label><?php echo lang('logo'); ?> (Width: 195px, Height:145px)</label>
                                <input type="file" accept="image/*" name="logo" class="form-control" id="logo">
                            </div>
                            <?php if (form_error('logo')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('logo'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-6">

                            <div class="form-group">
                                <label><?php echo lang('description'); ?></label>
                                <textarea tabindex="2" type="text" name="description" class="form-control"
                                          placeholder="<?php echo lang('description'); ?>"
                                ><?php echo set_value('description'); ?></textarea>
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

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>deliveryPartner/deliveryPartners">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>
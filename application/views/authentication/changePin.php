
<!-- Main content -->
<section class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }

    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('change_pin'); ?>
        </h3>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Authentication/changePin')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('old_pin'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="text" name="old_pin" class="form-control"
                                   placeholder="<?php echo lang('old_pin'); ?>" value="<?php echo set_value('old_pin')?>">
                        </div>
                        <?php if (form_error('old_pin')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('old_pin'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-sm-12 mb-2 col-md-6">
                        <div class="form-group">
                            <label><?php echo lang('new_pin'); ?> <span class="required_star">*</span></label>
                            <input tabindex="2" type="text" name="new_pin" class="form-control" value="<?php echo set_value('new_pin')?>"
                                   placeholder="<?php echo lang('new_pin'); ?>">
                        </div>
                        <?php if (form_error('new_pin')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('new_pin'); ?>
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
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</section>

<section class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo '<span class="text-center response_text">'.escape_output($this->session->flashdata('exception')).'</span>';
        echo ' <span class="redirect_text"><b>'.lang('redirecting').' <span class="counter">5</span></b></span>';
            unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>

    <?php
    if ($this->session->flashdata('exception_err')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</p></div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="top-left-header"><?php echo lang('Purchase_Verification'); ?> </h2>
            </div>
            <div>

            </div>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url() . 'Update/updateVerification', $arrayName = array('id' => 'update_verification')) ?>
            <input type="hidden" value="<?=escape_output($status)?>" id="status_value">
            <input type="hidden" value="<?=escape_output(base_url())?>" id="base_url_custom_update">
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('envato_username'); ?> <span class="required_star">*</span></label>  
                            <input tabindex="1" type="text" name="username" class="form-control"
                                   placeholder="<?php echo lang('envato_username'); ?>"
                                   value="<?php echo set_value('username'); ?>">
                        </div>
                        <?php if (form_error('username')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('username'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('purchase_code'); ?> <span class="required_star">*</span></label>
                            <input tabindex="2" type="text" name="purchase_code" class="form-control"
                                   placeholder="<?php echo lang('purchase_code'); ?>"
                                   value="<?php echo set_value('purchase_code'); ?>">
                        </div>
                        <?php if (form_error('purchase_code')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('purchase_code'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>

            <div class="row mt-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <button type="submit" name="submit" value="submit"
                            class="btn bg-blue-btn w-100 button_1"><?php echo lang('submit'); ?></button>
                </div>
                <div class="col-sm-12 col-md-2 mb-2">
                    <a class="btn bg-blue-btn w-100" href="<?php echo base_url() ?>Authentication/userProfile">
                        <?php echo lang('back'); ?></a>
                </div>
                <input id="owner" type="hidden" name="owner" class="input-large" value="doorsoftco"  />
                <input id="owner" type="hidden" name="base_url" class="input-large" value="<?php echo base_url()?>"  />
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/update_verification.js"></script>
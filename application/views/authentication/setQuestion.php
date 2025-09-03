<!-- Main content -->
<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('SetSecurityQuestion'); ?>
        </h3>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?= form_open(base_url('Authentication/securityQuestion/' . (isset($profile_info) && $profile_info ? $this->custom->encrypt_decrypt($profile_info->id, 'encrypt') : ''))); ?>
            <div class="box-body">
                <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo lang('SecurityQuestion'); ?> <span class="required_star">*</span></label>
                        <select class="form-control select2 fly_3" name="question" id="question">
                            <?php if(isset($profile_info) && ($profile_info->question!='')){ ?>
                                <option value="<?php echo escape_output($profile_info->question); ?>" <?php echo "selected = 'selected'"?>><?php echo escape_output($profile_info->question); ?></option>
                            <?php } ?>
                            <?php foreach ($question as $value) {  ?>
                                <option value="<?php echo escape_output($value); ?>" <?php if ($value == set_value('question')) echo "selected = 'selected'"?>><?php echo escape_output($value); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo lang('SecurityAnswer'); ?> <span class="required_star">*</span></label>
                        <input type="text" name="answer" class="form-control" placeholder="<?php echo lang('SecurityAnswer'); ?>" value="<?= isset($profile_info) && $profile_info->answer ? $profile_info->answer : set_value('answer') ?>">
                    </div>
                    <?php if (form_error('answer')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('answer'); ?></span>
                        </div>
                    <?php } ?>
                </div>

            </div>
            </div>
            <p>&nbsp;</p>

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
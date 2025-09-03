<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>
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
    ?>

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('social_login_setting'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
    <div class="table-box">
                <?php
                $attributes = array('id' => 'social_login_setting');
                echo form_open_multipart(base_url('Frontend/social_login_setting/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                    
                    <div class="row">
                    <div class="col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('facebook_app_id'); ?></label> 
                                <input type="text" onfocus="select();" name="facebook_app_id" class="form-control facebook_app_id" placeholder="<?php echo lang('facebook_app_id'); ?>" value="<?php echo isset($company_info->facebook_app_id) && $company_info->facebook_app_id?$company_info->facebook_app_id:set_value('facebook_app_id')?>">
                                <?php if (form_error('facebook_app_id')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('facebook_app_id'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('facebook_app_secret'); ?></label>
                                <input type="text" onfocus="select();" name="facebook_app_secret" class="form-control facebook_app_secret" placeholder="<?php echo lang('facebook_app_secret'); ?>" value="<?php echo isset($company_info->facebook_app_secret) && $company_info->facebook_app_secret?$company_info->facebook_app_secret:set_value('facebook_app_secret')?>">
                                <?php if (form_error('facebook_app_secret')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('facebook_app_secret'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label> <?php echo lang('google_client_id'); ?></label>
                                <input type="text" onfocus="select();" name="google_client_id" class="form-control google_client_id" placeholder="<?php echo lang('google_client_id'); ?>" value="<?php echo isset($company_info->google_client_id) && $company_info->google_client_id?$company_info->google_client_id:set_value('google_client_id')?>">
                                <?php if (form_error('google_client_id')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('google_client_id'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('google_client_secret_key'); ?></label>
                                <input type="text" onfocus="select();" name="google_client_secret_key" class="form-control google_client_secret_key" placeholder="<?php echo lang('google_client_secret_key'); ?>" value="<?php echo isset($company_info->google_client_secret_key) && $company_info->google_client_secret_key?$company_info->google_client_secret_key:set_value('google_client_secret_key')?>">
                                <?php if (form_error('google_client_secret_key')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('google_client_secret_key'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>

    </div>


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

</section>
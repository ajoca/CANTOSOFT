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
            <?php echo lang('socialMedia'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
    <div class="table-box">
                <?php
                $attributes = array('id' => 'social_media');
                $social_media = isset($company_info->social_media) && $company_info->social_media?json_decode($company_info->social_media):'';
                echo form_open_multipart(base_url('Frontend/socialMedia/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('facebook_link'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" onfocus="select();" type="text" id="facebook_link" name="facebook_link" class="form-control" placeholder="<?php echo lang('facebook_link'); ?>" value="<?php echo isset($social_media->facebook_link) && $social_media->facebook_link ? $social_media->facebook_link : ''; ?>">
                            </div>
                            <?php if (form_error('facebook_link')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('facebook_link'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('google_link'); ?> <span class="required_star">*</span></label>
                                <input tabindex="2" autocomplete="off" onfocus="select();" type="text" id="google_link" name="google_link" class="form-control" placeholder="<?php echo lang('google_link'); ?>" value="<?php echo isset($social_media->google_link) && $social_media->google_link ? $social_media->google_link : ''; ?>">
                            </div>
                            <?php if (form_error('google_link')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('google_link'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 mb-2 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('twitter_link'); ?> <span class="required_star">*</span></label>
                                <input tabindex="3" autocomplete="off" onfocus="select();" type="text" id="twitter_link" name="twitter_link" class="form-control" placeholder="<?php echo lang('twitter_link'); ?>" value="<?php echo isset($social_media->twitter_link) && $social_media->twitter_link ? $social_media->twitter_link : ''; ?>">
                            </div>
                            <?php if (form_error('twitter_link')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('twitter_link'); ?>
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
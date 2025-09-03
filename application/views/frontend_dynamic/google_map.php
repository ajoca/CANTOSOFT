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
            <?php echo lang('googleMap'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'googleMap');
            echo form_open_multipart(base_url('Frontend/googleMap/' . $this->session->userdata('company_id')),$attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label><?php echo lang('google_map'); ?> <span class="required_star">*</span></label>
                            <textarea tabindex="1" autocomplete="off" id="google_map" name="google_map" class="form-control" placeholder="<?php echo lang('google_map'); ?>"><?php echo isset($company_info->google_map) && $company_info->google_map ? $company_info->google_map : ''; ?></textarea>
                        </div>
                        <?php if (form_error('google_map')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('google_map'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-12">
                        <div class="form-group">
                            <label><?php echo lang('contact_us_des'); ?> <span class="required_star">*</span></label>
                            <textarea tabindex="2" autocomplete="off" id="contact_us_des" name="contact_us_des" class="form-control" placeholder="<?php echo lang('contact_us_des'); ?>"><?php echo isset($company_info->contact_us_des) && $company_info->contact_us_des ? $company_info->contact_us_des : ''; ?></textarea>
                        </div>
                        <?php if (form_error('contact_us_des')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('contact_us_des'); ?>
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
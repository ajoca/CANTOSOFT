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
            <?php echo lang('website_white_label'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'restaurant_setting_form');
            $outlet_information = isset($outlet_information->website_white_label) && $outlet_information->website_white_label?json_decode($outlet_information->website_white_label):'';
            echo form_open_multipart(base_url('Frontend/websiteWhiteLabel/' . $this->session->userdata('company_id')),$attributes); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('site_name'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" autocomplete="off" type="text" id="site_name" name="site_name" class="form-control" placeholder="<?php echo lang('site_name'); ?>" value="<?php echo escape_output($outlet_information->site_name); ?>">
                        </div>
                        <?php if (form_error('site_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('site_name'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cleartfix"></div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                                    <div class="form-label-action">
                                        <input type="hidden" name="system_logo_p" value="<?php echo escape_output($outlet_information->system_logo)?>">
                                        <label><?php echo lang('system_logo'); ?> (Width: 191px, Height:40px )</label>
                                    </div>

                            <table>
                                <tr>
                                    <td>
                                    <input type="file" id="logo" accept="image/*" name="system_logo" class="form-control">
                                    </td>
                                    <td><a data-file_path="<?php echo base_url()?>images/<?php echo escape_output($outlet_information->system_logo); ?>"  data-id="1" class="new-btn h-40 show_preview" data-title="<?php echo lang('system_logo'); ?>" href="#"><i class="fa fa-eye"></i></a></td>
                                </tr>
                            </table>
                        </div>
                        <?php if (form_error('system_logo')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('system_logo'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="favicon_p" value="<?php echo escape_output($outlet_information->favicon)?>">
                                <label><?php echo lang('favicon'); ?> (Width: 16px, Height:16px )</label>
                                
                            </div>
                            

                            <table>
                                <tr>
                                    <td>
                                    <input type="file" id="logo" accept="image/*" name="favicon" class="form-control">

                                    </td>
                                    <td> 
                                    <a data-file_path="<?php echo base_url()?>images/<?php echo escape_output($outlet_information->favicon); ?>"  data-id="1" class="new-btn h-40 show_preview" data-title="<?php echo lang('favicon'); ?>" href="#"><i class="fa fa-eye"></i></a>
                                </td>
                                </tr>
                            </table>
                        </div>
                        <?php if (form_error('favicon')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('favicon'); ?>
                            </div>
                        <?php } ?>
                    </div> 
                    <div class="col-sm-12 mb-2 col-md-4">

                        <div class="form-group">
                            <label><?php echo lang('footer'); ?> <span class="required_star">*</span></label>
                            <textarea id="footer" rows="6" name="footer" class="form-control" placeholder="<?php echo lang('footer'); ?>"><?php echo escape_output($outlet_information->footer); ?></textarea>
                        </div>
                        <?php if (form_error('footer')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('footer'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('website_theme_color'); ?> <span class="required_star">*</span></label>
                            <input autocomplete="off" type="color" id="website_theme_color" name="website_theme_color" class="form-control" placeholder="<?php echo lang('website_theme_color'); ?>" value="<?php echo escape_output($outlet_information->website_theme_color); ?>">
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
                            <img class="site_logo_parent_img" src="" id="show_id">
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

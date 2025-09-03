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
            <?php echo lang('bannerSection'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
            <div class="table-box">

                <?php
                $attributes = array('id' => 'bannerSection');
                $banner_section = isset($company_info->main_banner_section) && $company_info->main_banner_section?json_decode($company_info->main_banner_section):'';
                echo form_open_multipart(base_url('Frontend/bannerSection/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('main_header'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="main_header" name="main_header" class="form-control" placeholder="<?php echo lang('main_header'); ?>" value="<?php echo isset($banner_section->main_header) && $banner_section->main_header ? $banner_section->main_header : ''; ?>">
                            </div>
                            <?php if (form_error('main_header')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('main_header'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <div class="form-label-action">
                                    <input type="hidden" name="main_banner_old" value="<?php echo escape_output(isset($banner_section->main_banner) && $banner_section->main_banner ? $banner_section->main_banner : '')?>">
                                    <label><?php echo lang('main_banner'); ?> (Width: 1980px, Height:1080px )</label>
                                    
                                </div>
                                
                                <table>
                                    <tr>
                                        <td>
                                          <input type="file" id="logo" accept="image/*" name="main_banner" class="form-control">

                                        </td>
                                        <td> 
                                        <a data-file_path="<?php echo base_url()?>uploads/banner_section/<?php echo isset($banner_section->main_banner) && $banner_section->main_banner ? $banner_section->main_banner : ''; ?>"  data-id="1" class="new-btn h-40 show_preview" href="#"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('main_banner')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('main_banner'); ?>
                                </div>
                            <?php } ?>
                        </div>
                         

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('short_des'); ?> <span class="required_star">*</span></label>
                                <textarea id="short_des" rows="6" name="short_des" class="form-control" placeholder="<?php echo lang('short_des'); ?>"><?php echo isset($banner_section->short_des) && $banner_section->short_des ? $banner_section->short_des : ''; ?></textarea>
                            </div>
                            <?php if (form_error('short_des')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('short_des'); ?>
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
                        <?php echo lang('photo'); ?> </h4>

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
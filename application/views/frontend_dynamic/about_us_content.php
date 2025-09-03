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
            <?php echo lang('aboutUsContent'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'aboutUsContent');
            $about_us = isset($company_info->about_us) && $company_info->about_us?json_decode($company_info->about_us):'';
            echo form_open_multipart(base_url('Frontend/aboutUsContent/' . $this->session->userdata('company_id')),$attributes); ?>
            <div class="box-body">
            
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('about_us_title'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" autocomplete="off" type="text" id="about_us_title" name="about_us_title" class="form-control" placeholder="<?php echo lang('about_us_title'); ?>" value="<?php echo isset($about_us->about_us_title) && $about_us->about_us_title ? $about_us->about_us_title : ''; ?>">
                        </div>
                        <?php if (form_error('about_us_title')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('about_us_title'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('abous_us_heading'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" autocomplete="off" type="text" id="abous_us_heading" name="abous_us_heading" class="form-control" placeholder="<?php echo lang('abous_us_heading'); ?>" value="<?php echo isset($about_us->abous_us_heading) && $about_us->abous_us_heading ? $about_us->abous_us_heading : ''; ?>">
                        </div>
                        <?php if (form_error('abous_us_heading')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('abous_us_heading'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('about_us_des'); ?> <span class="required_star">*</span></label>
                            <textarea id="about_us_des" rows="6" name="about_us_des" class="form-control" placeholder="<?php echo lang('about_us_des'); ?>"><?php echo isset($about_us->about_us_des) && $about_us->about_us_des ? $about_us->about_us_des : ''; ?></textarea>
                        </div>
                        <?php if (form_error('about_us_des')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('about_us_des'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="about_us_image_old" value="<?php echo isset($about_us->about_us_image) && $about_us->about_us_image ? $about_us->about_us_image : ''; ?>">
                                <label><?php echo lang('about_us_image'); ?> (Width: 1280px, Height:1560px )</label>
                                
                            </div>
                            
                            <table>
                                <tr>
                                    <td>
                                    <input type="file" id="logo" accept="image/*" name="about_us_image" class="form-control">


                                    </td>
                                    <td> 
                                    <a data-file_path="<?php echo base_url()?>uploads/about_us/<?php echo isset($about_us->about_us_image) && $about_us->about_us_image ? $about_us->about_us_image : ''; ?>"  data-id="1" class="new-btn h-40 show_preview" href="#"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php if (form_error('about_us_image')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('about_us_image'); ?>
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
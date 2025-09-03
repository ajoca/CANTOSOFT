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
            <?php echo lang('serviceSection'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
  
    <div class="table-box">
                <?php
                $attributes = array('id' => 'serviceSection');
                $service_section = isset($company_info->service_section) && $company_info->service_section?json_decode($company_info->service_section):'';
                echo form_open_multipart(base_url('Frontend/serviceSection/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('service_title'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="service_title" name="service_title" class="form-control" placeholder="<?php echo lang('service_title'); ?>" value="<?php echo isset($service_section->service_title) && $service_section->service_title ? $service_section->service_title : ''; ?>">
                            </div>
                            <?php if (form_error('service_title')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('service_title'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('service_heading'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="service_heading" name="service_heading" class="form-control" placeholder="<?php echo lang('service_heading'); ?>" value="<?php echo isset($service_section->service_heading) && $service_section->service_heading ? $service_section->service_heading : ''; ?>">
                            </div>
                            <?php if (form_error('service_heading')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('service_heading'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('service_description'); ?> <span class="required_star">*</span></label>
                                <textarea id="service_description" rows="6" name="service_description" class="form-control" placeholder="<?php echo lang('service_description'); ?>"><?php echo isset($service_section->service_description) && $service_section->service_description ? $service_section->service_description : ''; ?></textarea>
                            </div>
                            <?php if (form_error('service_description')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('service_description'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <div class="form-label-action">
                                    <input type="hidden" name="service_image_old" value="<?php echo isset($service_section->service_image) && $service_section->service_image ? $service_section->service_image : ''; ?>">
                                    <label><?php echo lang('service_image'); ?> (Width: 1280px, Height:1560px )</label>
                                    
                                </div>
                                
                                <table>
                                    <tr>
                                        <td>
                                        <input type="file" id="logo" accept="image/*" name="service_image" class="form-control">

                                        </td>
                                        <td> 
                                            <a data-file_path="<?php echo base_url()?>uploads/service_section/<?php echo isset($service_section->service_image) && $service_section->service_image ? $service_section->service_image : ''; ?>"  data-id="1" class="new-btn h-40 show_preview" href="#"><i class="fa fa-eye"></i>&nbsp;<?php echo lang('show'); ?></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('service_image')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('service_image'); ?>
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
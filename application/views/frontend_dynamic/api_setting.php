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
            <?php echo lang('api_setting'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">

            <?php
            $attributes = array('id' => 'APISetting');
            echo form_open_multipart(base_url('Frontend/APISetting/' . $this->session->userdata('company_id')),$attributes); ?>
            <div class="body-body">
                <div class="row">
                <div class="col-sm-12 mb-2 col-md-4">
                    <div class="form-group">
                            <label><?php echo lang('api_status'); ?> <span class="required_star">*</span></label>
                            <select name="api_status" id="api_status" class="form-control select2">
                                <option <?php echo isset($company_info->api_status) && $company_info->api_status == 'sendbox' ? 'selected' : ''; ?> value="sendbox"><?php echo lang('sendbox');?></option>
                                <option <?php echo isset($company_info->api_status) && $company_info->api_status == 'live' ? 'selected' : ''; ?> value="live"><?php echo lang('live');?></option>
                            </select>
                            
                        </div>
                        <?php if (form_error('api_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('api_status'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('api_key'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" autocomplete="off" type="text" id="api_key" name="api_key" class="form-control" placeholder="<?php echo lang('api_key'); ?>" value="<?php echo isset($company_info->api_key) && $company_info->api_key ? $company_info->api_key : ''; ?>">
                        </div>
                        <?php if (form_error('api_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('api_key'); ?>
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


<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    
    ($this->view('report/view_report'));
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
                <h2 class="top-left-header"><?php echo lang('Uninstall_License'); ?> </h2>
            </div>
            <div>

            </div>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open(base_url() . 'Update/uninstallLicense', $arrayName = array('id' => 'update_verification')) ?>
            <input type="hidden" value="<?=escape_output($status)?>" id="status_value">
            <div class="box-body"> 
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-4">
                        <div class="form-group">
                            <label><?php echo lang('envato_username'); ?> <span class="required_star">*</span></label> 
                          
                                   <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="1" type="text" name="username" class="form-control"
                                   placeholder="<?php echo lang('envato_username'); ?>"
                                   value="<?php echo set_value('username'); ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('uninstall_notice'); ?>" data-feather="help-circle"></i>
                            </div>
                                        </td>
                                    </tr>
                                </table>
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

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Authentication/userProfile">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
                <input id="owner" type="hidden" name="owner" class="input-large" value="doorsoftco"  />
                <input id="base_url_install" type="hidden" name="base_url_install" class="input-large" value="<?php echo base_url()?>"  />
                <input id="action_type" type="hidden" name="action_type" class="input-large" value="uninstall"  />
            </div>

            <div class="control-group letf_margin display_none div_hide_status">
                <label class="control-label" for="current_installation_url">Current Installation URL</label>
                <div class="controls">
                    <input id="current_installation_url" type="text" name="current_installation_url"  class="input-large form-control txt_w_3"  data-error="Current Installation URL is required" value="<?=set_value('current_installation_url')?>" placeholder="Current Installation URL" />
                </div>
            </div>
            <div class="control-group display_none letf_margin txt_w_1">
                <label class="control-label" for="transfer_installation_url">New Installation URL</label>
                <div class="controls">
                    <input  id="transfer_installation_url" type="text" name="transfer_installation_url"  class="input-large form-control txt_w_3"  data-error="Transfer Installation URL is required" value="<?=set_value('transfer_installation_url')?>" placeholder="New Installation URL" />
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<?php
$wl = getWhiteLabel();
$system_logo = '';
if($wl){
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->footer){
        $footer = $wl->footer;
    }
    if($wl->system_logo){
        $system_logo = base_url()."images/".$wl->system_logo;
    }
}
//get company information
$getCompanyInfo = getCompanyInfo();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>License Uninstall || <?php echo escape_output($site_name)?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- custom css load -->
    <?php ($this->view('report/view_report')); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/updater.css">
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<input type="hidden" value="<?=escape_output($status)?>" id="status_value">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h3 class="text-center response_text" style="color:<?php echo escape_output($color)?>;"><?php echo escape_output($txt_return) ?></h3>
    </div>
    <div class="col-md-4 col-md-offset-4 form_div ">
        <h3 class="text-center">License Uninstall</h3>
        <div class="text-center"><a  data-toggle="modal"
                                     data-target="#noticeModal" class="text-color-red" href="#">Please read carefully</a></div>
        <?php echo form_open(base_url() . 'Update/uninstallLicense', $arrayName = array('id' => 'update_verification')) ?>
        <div class="control-group letf_margin">
            <label class="control-label" for="username">Envato Username</label>
            <div class="controls">
                <input  id="username" type="text" name="username" class="input-large form-control txt_w_3" required="required" data-error="Username is required" value="<?=set_value('username')?>" placeholder="Username" />
            </div>
        </div>
        <div class="control-group letf_margin">
            <label class="control-label" for="purchase_code">Purchase Code</label>
            <div class="controls">
                <input id="purchase_code" type="text" name="purchase_code" class="input-large form-control txt_w_3" required="required" data-error="Purchase Code is required" value="<?=set_value('purchase_code')?>" placeholder="Purchase Code" />
            </div>
            <!-- modified -->
            <input id="owner" type="hidden" name="owner" class="input-large" value="doorsoftco"  />
            <input id="base_url_install" type="hidden" name="base_url_install" class="input-large" value="<?php echo base_url()?>"  />
        </div>
        <div class="control-group letf_margin">
            <label class="control-label" for="current_installation_url">Action</label>
            <div class="controls">
                <select class="form-control txt_w_3" required name="action_type" id="action_type">
                    <option <?php echo set_select('action_type',"uninstall")?> value="uninstall">Uninstall</option>
                </select>
            </div>
        </div>
        <div class="control-group letf_margin div_hide_status">
            <label class="control-label" for="current_installation_url">Current Installation URL</label>
            <div class="controls">
                <input id="current_installation_url" type="text" name="current_installation_url"  class="input-large form-control txt_w_3"  data-error="Current Installation URL is required" value="<?=set_value('current_installation_url')?>" placeholder="Current Installation URL" />
            </div>
        </div>
        <div class="control-group div_hide_status letf_margin txt_w_1">
            <label class="control-label" for="transfer_installation_url">New Installation URL</label>
            <div class="controls">
                <input  id="transfer_installation_url" type="text" name="transfer_installation_url"  class="input-large form-control txt_w_3"  data-error="Transfer Installation URL is required" value="<?=set_value('transfer_installation_url')?>" placeholder="New Installation URL" />
            </div>
        </div>
        <div class="bottom txt_w_2">
            <input type="submit" name="submit" class="btn btn-primary button_1"  value="Submit"/>
            <a class="btn btn-primary" href="<?php echo base_url() ?>Dashboard/dashboard">
                <?php echo lang('back'); ?>
            </a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="modal fade" id="noticeModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="noticeModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i class="fa fa-2x">×</i></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="foodMenuCartNotice">
                            <strong class="ir_ml39"><?php echo lang('notice'); ?></strong><br>
                            If you uninstall the license then you can install this script again in any domain or local. So you must follow our documentation process before uninstall it.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/uninstall_license.js"></script>
</body>
</html>
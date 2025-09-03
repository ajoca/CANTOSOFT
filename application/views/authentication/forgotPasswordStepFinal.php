<?php
$wl = getWhiteLabel();
$site_name = '';
$footer = '';
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo escape_output($site_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo base_url(); ?>frequent_changing/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/login.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/kitchen_panel/css/custom_kitchen_panel.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login_new.css">
    <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="row">

        <!-- Mixins-->
        <!-- Pen Title-->
        <div class="pen-title">
            <img src="<?php echo escape_output($system_logo); ?>">
        </div>
        <div class="container">
            <div class="card"></div>
            <div class="card">
                <?php
                if ($this->session->flashdata('exception_1')) {
                    echo '<p class="red_error"><i  class="fa fa-times"></i> ';echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
                    echo '</p>';
                }
                ?>

                <?php
                if ($this->session->flashdata('exception')) {
                    echo '<p class="green_error"><i  class="fa fa-check"></i> ';echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
                    echo '</p>';
                }
                ?>
                <h1 class="title"><?php echo lang('step_final'); ?></h1>
                <?php echo form_open(base_url('forgot-password-step-final')); ?>
                <div class="input-container custom_margin">
                    <input id="password" type="password" name="password" value="<?php if(APPLICATION_MODE == 'demo'){ echo "123456"; }else{ echo set_value('password');} ?>" required="required"/>
                    <label for="password"><?php echo lang('password'); ?></label>
                    <div class="bar"></div>
                    <?php if (form_error('password')) { ?>
                        <div class="error_txt">
                            <?php echo form_error('password'); ?>
                        </div>
                    <?php } ?>

                </div>
                <div class="input-container">
                    <input id="confirm_password" type="password" name="confirm_password" value="<?php echo set_value('confirm_password') ?>" required="required"/>
                    <label for="confirm_password"><?php echo lang('confirm_password'); ?></label>
                    <div class="bar"></div>
                    <input type="hidden" class="form-control" name="id" value="<?php echo escape_output($id); ?>">
                    <input type="hidden" class="form-control" name="matchQuestion" value="<?php echo escape_output($matchQuestion); ?>">
                    <input type="hidden" class="form-control" name="matchAnswer" value="<?php echo escape_output($matchAnswer); ?>">
                </div>
                <?php if (form_error('confirm_password')) { ?>
                    <div class="error_txt">
                        <?php echo form_error('confirm_password'); ?>
                    </div>
                <?php } ?>
                <div class="button-container">
                    <button type="submit" name="submit" value="submit"><span><?php echo lang('submit'); ?></span></button>
                </div>
                <div class="footer"><a href="<?php echo base_url()?>authentication"><?php echo lang('back_to_login'); ?></a></div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
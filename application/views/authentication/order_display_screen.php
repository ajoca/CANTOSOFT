
<!DOCTYPE html>
<?php
$currency = "$";
//default base color
$base_color = "#6ab04c";
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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo lang('order_status_screen'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">
      <!-- Sweet alert -->
      <script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
    <!-- custom login page css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login.css">
    <!-- Favicon -->

    <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_tooltip.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/order_display_screen.css">
</head>
<body>
<input type="hidden" value="<?=base_url()?>" id="base_url">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="kitchen_status_screen_remove" value="<?php echo lang('kitchen_status_screen_remove'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">

<div class="row">
    <div class="col-md-11 ods_1">
        <h2 class="text-center"><b><?php echo lang('order_status_screen'); ?></b>
            <a href="javascript:void(0)" id="fullscreen" class="icon pull-right"><i
                    class="fa fa-arrows-alt"></i></a>

        </h2>
        <table class="text_001 ods_2">
            <thead>

            </thead>
            <tbody>
            <tr>
                <th class="ods_3">
                    <h3 class="ods_4"><?php echo lang('ReadytoPickup'); ?></h3>
                    <br>
                    <div class="ready_div">
                    </div>
                </th>
                <th class="ods_5">
                </th>
                <th class="ods_3">
                    <h3 class="ods_4"><?php echo lang('Preparing'); ?></h3>
                    <br>
                    <div class="preparing_div">
                    </div>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- custom login page js -->
<script src="<?php echo base_url(); ?>frequent_changing/js/order_status_panel.js"></script>
</body>
</html>

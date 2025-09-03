
<!DOCTYPE html>
<?php
$currency = "$";
//default base color
$base_color = "#8d5df3";
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
        <title><?php echo lang('customer_panel'); ?></title>
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
        <script src="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/sweetalert2/dist/sweetalert.min.css">
        <!-- custom login page css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/login.css">
        <!-- Favicon -->
        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
        <!-- Google Font -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/customer_pannel.css">
        <style>
            .header-part a i{
                color: <?php echo $base_color?>;
            }
        </style>
    </head>
    <body>
        <input type="hidden" value="<?=base_url()?>" id="base_url">
        
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="text-center customer_panel_header">
                        <img src="<?php echo $system_logo;?>" alt="logo">
                    </div>
                    <div class="main-body">
                        <div class="header-part">
                            <h2>
                                <span>
                                    <?php echo lang('customer_panel'); ?> 
                                </span>
                                <a href="javascript:void(0)" id="fullscreen" class="icon pull-right">
                                    <i class="fa fa-arrows-alt"></i>
                                </a>
                            </h2>
                            <div class="header-insider">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="w-30"><?php echo lang('item'); ?></th>
                                            <th class="w-20 text-center"><?php echo lang('price'); ?></th>
                                            <th class="w-15 text-center"><?php echo lang('quantity'); ?></th>
                                            <th class="w-15 text-center"><?php echo lang('discount'); ?></th>
                                            <th class="w-20 text-center"><?php echo lang('sub_total'); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="middle-part">
                            <table class="table">
                                <tbody id="items">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="customer_panel_header">

                    </div>
                    <div class="footer-part">
                        <div class="right-part">
                            <div class="single-item pt-0">
                                <p class="f-head"><?php echo lang('total_item'); ?>:</p>
                                <p><span id="total_item">0</span>(<span id="total_item_1">0</span>)</p>
                            </div>
                            <div class="single-item">
                                <p class="f-head"><?php echo lang('sub_total'); ?>:</p>
                                <p><span id="total_sub_total">0.00</span></p>
                            </div>
                            <div class="single-item">
                                <p class="f-head"><?php echo lang('in_global'); ?>:</p>
                                <p><span id="in_global">0.00</span></p>
                            </div>
                            <div class="single-item">
                                <p class="f-head"><?php echo lang('vat'); ?>:</p>
                                <p><span id="total_tax">0.00</span></p>
                            </div>
                            <div class="single-item">
                                <p class="f-head"><?php echo lang('charge'); ?>:</p>
                                <p><span id="total_charge">0.00</span></p>
                            </div>
                            <div class="single-item border-bottom-none">
                                <p class="f-head"><?php echo lang('tips'); ?>:</p>
                                <p><span id="total_tips">0.00</span></p>
                            </div>
                            <h4 class="total-payable"><b><?php echo lang('total_payable'); ?>: <span id="total_payable">0.00</span></b></h4>
                        </div>
                    </div>
                </div>
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
        <script src="<?php echo base_url(); ?>frequent_changing/js/customer_panel.js"></script>
    </body> 
</html>

<?php
    $getCompanyInfo = getCompanyInfo();
    $wl = json_decode(isset($getCompanyInfo->white_label) && $getCompanyInfo->white_label ? $getCompanyInfo->white_label : '');
    $system_logo = '';
    $site_name = '';
    $favicon = '';
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
        if($wl->favicon){
            $favicon = base_url()."images/".$wl->favicon;
        }else{
            $favicon = base_url()."images/favicon.ico";
        }
    }
    $data_c = getLanguageManifesto();
    $language_manifesto = $this->session->userdata('language_manifesto');
    $designation = $this->session->userdata('designation');
    $outlet_id = $this->session->userdata('outlet_id');
    $user_id = $this->session->userdata('user_id');
    $uri = $this->uri->segment(2);
    $is_collapse = $this->session->userdata('is_collapse');
    $language = $this->session->userdata('language');

    $base_color = '#8d5df3'; 
    $base_color2 = '#8b5cf61a';
    $dashboard_chart_color = '#7367f045';


?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo escape_output($site_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- jQuery 3.7 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/lib/currency-flags/dist/currency-flags.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_css.css">
    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
    <!-- Numpad -->
    <script src="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/jquery.numpad.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/numpad/theme.css">
    <!--datepicker-->
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datepicker/datepicker.css">
    <!-- bootstrap datepicker -->
    <script src="<?php echo base_url(); ?>assets/bower_components/datepicker/bootstrap-datepicker.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css-framework/bootstrap-new/bootstrap.min.css">
    <!-- New Admin Panel Design -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free-6.5.1-web/css/all.min.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($favicon) ?>" type="image/x-icon">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/userHome.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/nice-select/css/nice-select.css">
    <!-- Slick Slidear CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/slick-slider/slick.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_tooltip.css">
    <script src="<?php echo base_url(); ?>frequent_changing/js/user_home.js"></script>
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/userHomeResponsive.css">

    <style>
        .main-sidebar .sidebar-menu li.treeview > .treeview-menu .treeMenuActive a, .main-sidebar2 .sidebar-menu li.treeview > .treeview-menu .treeMenuActive a {
            color: <?php echo $base_color?>;
        }
        .main-sidebar .sidebar-menu li.treeview > .treeview-menu .treeMenuActive, .main-sidebar2 .sidebar-menu li.treeview > .treeview-menu .treeMenuActive {
            background-color: rgba(209, 196, 196, 0.168627451);
        }
        .main-sidebar .sidebar-menu li.treeview > .treeview-menu .treeMenuActive .child-menu:after, .main-sidebar2 .sidebar-menu li.treeview > .treeview-menu .treeMenuActive .child-menu:after {
            border: 3px solid <?php echo $base_color?>;
        }
        .menu-open .treeview-menu li:hover {
            color: <?php echo $base_color?>;
            background-color: #d1c4c42b;
        }
        .bg-blue-btn {
            background-color: <?php echo $base_color?> !important;
        }
        .bg-blue-btn:hover, .bg-blue-btn:focus {
            box-shadow: 0 8px 25px -8px <?php echo $base_color?> !important;
        }
        .new-btn {
            background-color: <?php echo $base_color2?> !important;
            color: <?php echo $base_color?> !important;
        }
        .new-btn:hover, .new-btn:focus {
            box-shadow: 0 8px 25px -8px <?php echo $base_color2?> !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: <?php echo $base_color2?>;
            color: #143157 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: <?php echo $base_color2?>;
            color: #143157 !important;
        }
        .dataTables_wrapper .dataTables_paginate.paging_simple_numbers .paginate_button.active a {
            background-color: <?php echo $base_color?>;
        }

        .main-sidebar .sidebar-toggle, .main-sidebar2 .sidebar-toggle {
            border: 2px solid <?php echo $base_color?>;
        }
        .main-sidebar .sidebar-toggle .inner-circle, .main-sidebar2 .sidebar-toggle .inner-circle {
            background-color: <?php echo $base_color?>;
        }
        .form-group .tooltip_custom {
            color: <?php echo $base_color?>;
        }
        .container input:checked ~ .checkmark {
            border-color: <?php echo $base_color?>;
            background-color: <?php echo $base_color?>;
            box-shadow: 0 2px 4px 0 <?php echo $base_color?>;
        }
        .form-group .form-control:focus {
            border-color: <?php echo $base_color?>;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-color:  <?php echo $base_color?>;
        }
        .main-header .navbar .navbar-custom-menu .lang-dropdown .lang-dropdown-menu li:hover {
            background-color: <?php echo $base_color2?>;
            color: <?php echo $base_color?>;
        }
        .main-header .navbar .navbar-custom-menu .lang-dropdown .lang-dropdown-menu li:hover a{
            color: <?php echo $base_color?>;
        }
        .main-header .navbar .navbar-custom-menu:last-child .c-dropdown-menu li a:hover {
            background-color: <?php echo $base_color2?>;
            color: <?php echo $base_color?>;
        }

        .form-group input[type=radio]:checked {
            background-color: <?php echo $base_color?>;
            border-color: <?php echo $base_color?>;
            box-shadow: 0 2px 5px <?php echo $base_color2?>;
        }
        .food_menu_slider .class_category:hover {
            border: 1px solid <?php echo $base_color?>;
        }
        .header_custom .class_category p{
            color: <?php echo $base_color?>;
        }
        .header_custom .active1 {
            border:  1px solid <?php echo $base_color?>;
        }
        .menu-item-custom .details .price {
            color: <?php echo $base_color?>;
        }
        .menu-item-custom .details .more-btn i{
            background-color: <?php echo $base_color?>;
        }
        .total-payable{
            background: <?php echo $base_color?>;
        }
        ::-webkit-scrollbar-thumb {
            background: <?php echo $base_color?>;
        }
        .custom_td{
            border: 1px solid transparent;
            color: <?php echo $base_color?>;
            background-color: <?php echo $base_color2?>;
        }
        .custom_td_active {
            border: 1px solid <?php echo $base_color?>;
            background-color: <?php echo $base_color?>;
        }
        .progress-bar {
            background-color: <?php echo $base_color2?>;
            color: <?php echo $base_color?>;
        }
        .grid_view2 .active{
            border: 1px solid <?php echo $base_color?>;
        }
    </style>
    
<div class="loader"></div>
<!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->

<body class="hold-transition skin-blue sidebar-mini <?php echo isset($is_collapse) && $is_collapse=="No"?'':'sidebar-collapse'?>">
<input type="hidden" id="base_color" value="<?php echo $base_color?>">
<input type="hidden" id="base_color2" value="<?php echo $base_color2?>">
<input type="hidden" id="dashboard_chart_color" value="<?php echo $dashboard_chart_color?>">
<input type="hidden" id="ingredient" value="<?php echo lang('ingredient'); ?>">
<input type="hidden" id="stock_value" value="<?php echo lang('stock_value'); ?>">
<input type="hidden" id="currency" value="<?php echo escape_output($this->session->userdata('currency')); ?>">
<input type="hidden" id="csrf_name_" value="<?php echo escape_output($this->security->get_csrf_token_name()); ?>">
<input type="hidden" id="csrf_value_" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="not_closed_yet" value="<?php echo lang('not_closed_yet'); ?>">
<input type="hidden" id="opening_balance" value="<?php echo lang('opening_balance'); ?>">
<input type="hidden" id="paid_amount" value="<?php echo lang('paid_amount'); ?>">
<input type="hidden" id="customer_due_receive" value="<?php echo lang('customer_due_receive'); ?>">
<input type="hidden" id="opening_balance" value="<?php echo lang('opening_balance'); ?>">
<input type="hidden" id="paid_amount" value="<?php echo lang('paid_amount'); ?>">
<input type="hidden" id="customer_due_receive" value="<?php echo lang('customer_due_receive'); ?>">
<input type="hidden" id="in_" value="<?php echo lang('in'); ?>">
<input type="hidden" id="cash" value="<?php echo lang('cash'); ?>">
<input type="hidden" id="txt_balance" value="<?php echo lang('balance'); ?>">
<input type="hidden" id="paypal" value="<?php echo lang('paypal'); ?>">
<input type="hidden" id="sale" value="<?php echo lang('sale'); ?>">
<input type="hidden" id="card" value="<?php echo lang('card'); ?>">
<input type="hidden" id="register_not_open" value="<?php echo lang('register_not_open'); ?>">
<input type="hidden" id="base_url_" value="<?php echo base_url(); ?>">
<input type="hidden" id="site_logo" value="<?php echo base_url(); ?>assets/media/logo.png">
<input type="hidden" id="site_favicon" value="<?php echo escape_output($favicon) ?>">
<input type="hidden" id="saas_m_ch" value="<?=file_exists(APPPATH.'controllers/Service.php')?'yes':''?>">
<input type="hidden" id="ir_precision" value="<?php echo escape_output($getCompanyInfo->precision)?>">
<input type="hidden" id="company_id_indexdb" value="<?php echo escape_output($this->session->userdata('company_id')); ?>">
<input type="hidden" id="user_id" value="<?php echo escape_output($this->session->userdata('user_id')); ?>">
<input type="hidden" class="active_menu_tmp" value="<?php echo escape_output($this->session->userdata('active_menu_tmp'))?>">
<input type="hidden" class="is_saas" value="<?php echo isServiceAccess('','','sGmsJaFJE')?>">
    <div class="main-preloader">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper <?=isset($language) && $language=="arabic"?'arabic-lang"':''?>">

        <header class="main-header <?=isset($language) && $language=='arabic' ? 'sidebar2_active' : ''?>">
            <nav class="navbar navbar-static-top" <?=isset($language) && $language=="arabic"?'style="margin-left:0px"':''?>>
                <div class="wrapper_up_wrapper">
                    <div class="hh_wrapper">
                        <div class="navbar-custom-menu">
                            <div class="menu-trigger-box">
                                <a href="javascript:void(0)" data-toggle="push-menu" class="st"><i data-feather="align-right"></i></a>
                                <a href="javascript:void(0)" class="om"><i data-feather="link"></i></a>
                            </div>
                            <ul class="screen-list">
                                <?php
                                $display_for_f_court_header = '';
                                $company_id = $this->session->userdata('company_id');
                                $user_id = $this->session->userdata('user_id');
                                if(isFoodCourt() && $user_id==1):
                                    $display_for_f_court_header = "none";
                                endif;
                                ?>
                                <?php if ($this->session->userdata('outlet_id')) { ?>
                                <!-- User Account: style can be found in dropdown.less -->
                                <li  data-access=""  style="display: <?php echo escape_output($display_for_f_court_header)?>" class="dropdown user user-menu">
                                    <a href="<?php echo base_url(); ?>POSChecker/posAndWaiterMiddleman" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('pos'); ?>">
                                        <i data-feather="shopping-cart"> <?php echo lang('pos'); ?></i> 
                                    </a>
                                </li>
                                <li data-access="add-106"  style="display: <?php echo escape_output($display_for_f_court_header)?>" class="dropdown user user-menu menu_assign_class">
                                    <a href="<?php echo base_url(); ?>Purchase/addEditPurchase" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('add_purchase'); ?>">
                                        <i data-feather="arrow-down-circle"> <?php echo lang('Add'); ?> <?php echo lang('purchase'); ?></i>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata('role') == "Admin") { ?>
                                <li style="display: <?php echo escape_output($display_for_f_court_header)?>" class="dropdown user user-menu">
                                    <a href="javascript:void(0)" onclick="todaysSummary();" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('todays_summary'); ?>">
                                        <i data-feather="pie-chart"> <?php echo lang('todays_summary'); ?></i> 
                                    </a>
                                </li>
                                <?php
                                        }
                                        $url = $this->uri->segment(2);
                                        if ($url == "addEditSale"):
                                            ?>
                                <li class="dropdown user user-menu">
                                    <a href="javascript:void(0)" onclick="shortcut();" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('shortcut_keys'); ?>">
                                            <i class="fa fa-keyboard-o"> <?php echo lang('shortcut_keys'); ?></i>
                                    </a>
                                </li>
                                <?php endif;
                                if($designation!="Waiter"):
                                ?>

                                    <li data-access="pos_21-73"  style="display: <?php echo escape_output($display_for_f_court_header)?>" class="dropdown user user-menu menu_assign_class">
                                        <a target="_blank" href="<?php echo base_url()?>Register/registerDetails" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('register_details'); ?>">
                                            <i data-feather="book"> <?php echo lang('register_details'); ?></i>
                                        </a>
                                    </li>
                                <?php
                                    endif;
                                 } ?>
                                <li data-access="view-310"  style="display: <?php echo escape_output($display_for_f_court_header)?>" class="dropdown user user-menu menu_assign_class">
                                    <a href="<?php echo base_url()?>authentication/checkInOut" class="new-btn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?php echo lang('check_in_check_out'); ?>">
                                        <i data-feather="clock"> <?php echo lang('check_in_check_out'); ?></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="navbar-custom-menu">
                            <ul class="menu-list">
                                    <li class="dropdown lang-dropdown">
                                        <?php $language=$this->session->userdata('language');
                                          $icon = "usd";
                                        ?>
                                        <button class="dropdown-toggle new-btn" type="button" data-toggle="dropdown" aria-hidden="false">
                                            <i data-feather="globe"></i> 
                                            <span><?php echo ucfirstcustom($language)?></span>
                                        </button>
                                        <ul class="lang-dropdown-menu">
                                            <?php
                                            $dir = glob("application/language/*",GLOB_ONLYDIR);
                                            foreach ($dir as $value):
                                                $separete = explode("language/",$value);?>
                                                    <li data-lang="English">
                                                        <a href="<?php echo base_url()?>Authentication/setlanguage/<?php echo escape_output($separete[1])?>"> <span><?php echo ucfirstcustom($separete[1])?></span></a>
                                                    </li>
                                                <?php
                                            endforeach;
                                            ?>
                                        </ul>
                                    </li>
                                    <li class="user-info-box">
                                        <div class="user-profile">
                                            <div class="user-info">
                                                <p class="user-name"><?php echo escape_output($this->session->userdata('full_name')); ?></p>
                                                <?php
                                                    $role = $this->session->userdata('role');
                                                    $designation = $this->session->userdata('designation');
                                                ?>
                                                <span class="user-role"><?php echo escape_output($designation)?></span>
                                            </div>
                                            <img class="user-avatar" src="<?=base_url()?>images/avatar.png" alt="user-avater">
                                        </div>
                                        <div class="c-dropdown-menu">
                                            <ul>
                                                <?php
                                                $getAccessURL = ucfirstcustom($this->uri->segment(1));
                                                $menu_access = $this->session->userdata('menu_access');
                                                if (isset($menu_access) && $menu_access && in_array($getAccessURL, $menu_access)):
                                                ?>
                                                <li  data-access="view-291" class="menu_assign_class"><a href="<?php echo base_url()?>User/users"><i data-feather="sliders"></i> <?php echo lang('manage_users')?></a></li>
                                                <?php
                                                  endif;
                                                ?>
                                                <li  data-access="update-298" class="menu_assign_class"><a href="<?php echo base_url()?>Authentication/changeProfile"><i data-feather="user"></i> <?php echo lang('change_profile')?></a></li>
                                                <li  data-access="update-300" class="menu_assign_class"><a href="<?php echo base_url()?>Authentication/changePassword"><i data-feather="key"></i> <?php echo lang('change_password')?></a></li>
                                                <li   class="menu_assign_class"><a href="<?=base_url()?>Authentication/logOut"><i data-feather="log-out"></i> <?php echo lang('logout')?></a></li>
                                            </ul>
                                        </div>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        
        <!-- Left side column. contains the sidebar -->
        <aside class="<?php echo isset($language) && $language=="arabic" ? 'main-sidebar2' : 'main-sidebar'?>">
            <a href="javascript:void(0)" class="sidebar-toggle set_collapse" data-status="<?php echo isset($is_collapse) && $is_collapse=="No"?'2':'1'?>" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="inner-circle"></span>
            </a>
            <!-- Sidebar toggle button-->
            <a href="javascript:void(0)" class="logo-wrapper">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><?php echo isset($getCompanyInfo->short_name) && $getCompanyInfo->short_name?$getCompanyInfo->short_name:'iR'?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg irestora_font_div">
                     <img src="<?php echo escape_output($system_logo); ?>">
                </span>
            </a>
            <!-- Admin Logo Part End -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left info">
                        <p><?php echo escape_output($this->session->userdata('outlet_name')); ?></p>
                        <p><?php echo escape_output($this->session->userdata('full_name')); ?></p>
                    </div>
                </div>
                <!-- <ul class="sidebar-menu">
                    <li class="header"><?php echo lang('main_navigation'); ?></li>
                </ul> -->
                <div id="left_menu_to_scroll">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu ps ps--active-x ps--active-y tree" data-widget="tree">
                        <li class="menu-header small border_bottom_none common_use">
                            <span class="menu-header-text"><?php echo lang('Common_Usages');?></span>
                        </li>
                        <li  class="menu_assign_class menu__cidirp_1 common_use" data-menu__cid="irp_1">
                            <a  href="<?php echo base_url()?>Authentication/userProfile">
                                <i data-feather="home"></i>
                                <span> <?php echo lang('home'); ?></span>
                            </a>
                        </li>
                        <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
                        <li class="treeview menu__cidirp_2 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="sliders"></i>
                                <span><?php echo lang('Saas'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/siteSetting">
                                        <?php echo lang('site_setting'); ?></a></li>

                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/emailSetting">
                                        <?php echo lang('email_setting'); ?></a></li>
 
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/paymentSetting">
                                        <?php echo lang('Payment_Setting'); ?></a></li>
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/addEditCompany">
                                        <?php echo lang('Add'); ?> <?php echo lang('Company'); ?></a></li>
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/companies">
                                        <?php echo lang('List'); ?> <?php echo lang('Company'); ?></a></li>

                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/addManualPayment">
                                        <?php echo lang('Add'); ?> <?php echo lang('Manual_Payment'); ?></a></li>
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/paymentHistory">
                                        <?php echo lang('List'); ?> <?php echo lang('Manual_Payment'); ?></a></li>
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/addPricingPlan">
                                        <?php echo lang('Add'); ?> <?php echo lang('Pricing_Plan'); ?></a></li>
                                <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>Service/pricingPlans">
                                        <?php echo lang('List'); ?> <?php echo lang('Pricing_Plan'); ?></a></li>
                            </ul>
                        </li>
                        <?php endif?>
                        <li data-access="view-1" class="menu_assign_class menu__cidirp_5 common_use" data-menu__cid="irp_5">
                            <a style="display: ;" href="<?php echo base_url()?>Dashboard/dashboard">
                                <i data-feather="bar-chart"></i>
                                <span> <?php echo lang('dashboard'); ?></span>
                            </a>
                        </li>

                        <?php
                        if(str_rot13($language_manifesto)=="eriutoeri"):?>
                        <li class="treeview menu__cidirp_3 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="grid"></i>
                                <span><?php echo lang('outlets'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-67" class="menu_assign_class" data-menu__cid="irp_3"><a class="child-menu" href="<?php echo base_url()?>Outlet/addEditOutlet">
                                        <?php echo lang('Add'); ?> <?php echo lang('outlet'); ?></a></li>
                                <li data-access="view-67" class="menu_assign_class" data-menu__cid="irp_3"><a class="child-menu" href="<?php echo base_url()?>Outlet/outlets">
                                        <?php echo lang('List'); ?> <?php echo lang('outlet'); ?></a></li>
                            </ul>
                        </li>
                        <?php else:?>
                        <li data-access="update-67"  class="menu_assign_class menu__cidirp_3 common_use" data-menu__cid="irp_3">
                            <a style="display: ;" href="<?php echo base_url()?>Outlet/addEditOutlet/<?php echo escape_output($outlet_id)?>">
                                <i data-feather="tool"></i>
                                <span> <?php echo lang('outlet_setting'); ?></span>
                            </a>
                        </li>
                        <?php endif;?>
                        <li class="treeview menu__cidirp_4 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="command"></i>
                                <span><?php echo lang('Panel'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="" class="" data-menu__cid="irp_4"><a class="child-menu" href="<?php echo base_url()?>POSChecker/posAndWaiterMiddleman">
                                        <?php echo lang('pos'); ?></a></li>
                                <li data-access="add-98" class="menu_assign_class" data-menu__cid="irp_4"><a class="child-menu" href="<?php echo base_url()?>Kitchen/addEditKitchen">
                                        <?php echo lang('Add'); ?> <?php echo lang('kitchen'); ?></a></li>
                                <li data-access="view-98" class="menu_assign_class" data-menu__cid="irp_4"><a class="child-menu" href="<?php echo base_url()?>Kitchen/kitchens">
                                        <?php echo lang('List'); ?> <?php echo lang('kitchen'); ?></a></li>
                                <li data-access="view-104" class="menu_assign_class" data-menu__cid="irp_4"><a class="child-menu" href="<?php echo base_url()?>Waiter/panel">
                                        <?php echo lang('Waiter'); ?></a></li>
                            </ul>
                        </li>

                        <li class="treeview menu__cidirp_32 check_main_menu common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="settings"></i>
                                <span><?php echo lang('Settings'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                    $main_com = getMainCompany();
                                    $languge_manifesto = $main_com->languge_manifesto;
                                    if($languge_manifesto=="sGmsJaFJVE" && $user_id!=1):
                                ?>

                                <li data-access="" class="" data-menu__cid="irp_2"><a class="child-menu" href="<?php echo base_url()?>authentication/currentPlanDetails">
                                <?php echo lang('Current_Plan_Details'); ?> </a></li>
                                <?php endif?>

                                <li data-access="update-6" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>setting/index">
                                        <?php echo lang('Settings'); ?></a></li>
                                 
                                <?php
                                if(!isFoodCourt()):
                                $wlb = $this->session->userdata('wlb');
                                if($wlb==1):
                                    if($getCompanyInfo->id==1):
                                ?>
                                <li data-access="update-49" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url(); ?>WhiteLabel">
                                        <?php echo lang('WhiteLabel'); ?></a></li>
                                    <?php
                                    endif;
                                endif;
                                endif;
                                ?>
                                
                                <li data-access="add-35" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>printer/addEditPrinter">
                                                <?php echo lang('Add'); ?> <?php echo lang('Printer'); ?></a></li>
                                        <li data-access="update-35" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>printer/printers">
                                                <?php echo lang('List'); ?> <?php echo lang('Printer'); ?></a></li>
                                         
                                <li data-access="add-353" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>counter/addEditCounter">
                                        <?php echo lang('Add'); ?> <?php echo lang('counter'); ?></a></li>
                                        <li data-access="view-353" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>counter/counters">
                                        <?php echo lang('List'); ?> <?php echo lang('counter'); ?></a></li>
                                <li data-access="update_tax-52" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>setting/tax">
                                        <?php echo lang('Tax_Setting'); ?></a></li>
                                <li data-access="add-55" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>MultipleCurrency/addEditMultipleCurrency">
                                        <?php echo lang('Add'); ?> <?php echo lang('Multiple_Currency'); ?></a></li>
                                <li data-access="view-55" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>MultipleCurrency/MultipleCurrencies">
                                        <?php echo lang('List'); ?> <?php echo lang('Multiple_Currency'); ?></a></li>
                                
                              

                                <li data-access="add-260" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>paymentMethod/addEditPaymentMethod">
                                        <?php echo lang('Add'); ?> <?php echo lang('payment_method'); ?></a></li>
                                <li data-access="view-260" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>paymentMethod/paymentMethods">
                                        <?php echo lang('List'); ?> <?php echo lang('payment_method'); ?></a></li>
                                <li data-access="add-265" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>Denomination/addEditDenomination">
                                        <?php echo lang('Add'); ?> <?php echo lang('denomination'); ?></a></li>
                                <li data-access="view-265" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>Denomination/denominations">
                                        <?php echo lang('List'); ?> <?php echo lang('denomination'); ?></a></li>
                                <li data-access="add-270" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>DeliveryPartner/addEditDeliveryPartner">
                                        <?php echo lang('Add'); ?> <?php echo lang('deliveryPartner'); ?></a></li>
                                <li data-access="view-270" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>DeliveryPartner/deliveryPartners">
                                        <?php echo lang('List'); ?> <?php echo lang('deliveryPartner'); ?></a></li>
                                <li data-access="add-275" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>Area/addEditArea">
                                        <?php echo lang('Add'); ?> <?php echo lang('area'); ?></a></li>
                                <li data-access="view-275" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>Area/areas">
                                        <?php echo lang('List'); ?> <?php echo lang('area'); ?></a></li>
                                <li data-access="add-280" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>table/addEditTable">
                                        <?php echo lang('Add'); ?> <?php echo lang('table'); ?></a></li>
                                <li data-access="view-280" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>table/tables">
                                <?php echo lang('List'); ?> <?php echo lang('table'); ?></a></li>
                                <li data-access="view-280" class="menu_assign_class" data-menu__cid="irp_32"><a class="child-menu" href="<?php echo base_url()?>table/tableLayoutSetting">
                                <?php echo lang('table_layout_setting'); ?></a></li>
 
                                <!-- End Sub Menu -->
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_2222 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="tool"></i>
                                <span><?php echo lang('sos_Self_Order_Setting'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_2222"><a class="child-menu" href="<?php echo base_url()?>setting/selfOrderEnableDisable">
                                <?php echo lang('enable_disable'); ?></a></li>
                                <?php if($getCompanyInfo->sos_enable_self_order=="Yes"):?>
                                    <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_2222"><a class="child-menu" href="<?php echo base_url()?>setting/tableQrcodeGenerator">
                                    <?php echo lang('table_qrcode_generator'); ?></a></li>
                                    <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_2222"><a class="child-menu" href="<?php echo base_url()?>setting/orderReceivingUserSelfOrder">
                                    <?php echo lang('order_receiving_user'); ?></a></li>
                                <?php endif?>
                                
                            </ul>
                        </li>
                        
                        
                        <li class="treeview menu__cidirp_222 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="globe"></i>
                                <span><?php echo lang('sos_online_order_setting'); ?></span>
                            </a>
                            <ul class="treeview-menu">

                            <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>setting/onlineOrderEnableDisable">
                            <?php echo lang('order'); ?> <?php echo lang('enable_disable'); ?></a></li>
                            <?php if($getCompanyInfo->sos_enable_online_order=="Yes"):?>
                            <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>setting/orderReceivingUserOnlineOrder">
                            <?php echo lang('order_receiving_user'); ?></a></li>
                            <?php endif?>
                            <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/websiteWhiteLabel">
                            <?php echo lang('website_white_label'); ?></a></li>
                            
                            <li class="sub_sub">
                                    <a href="javascript:void(0)">
                                        <?php echo lang('common_setting'); ?>
                                    </a>
                                    <ul class="sub-menu" style="display: none;">
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/bannerSection"> <?php echo lang('banner_section'); ?></a></li>
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/serviceSection"> <?php echo lang('serviceSection'); ?></a></li>
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/exploreMenuSection"> <?php echo lang('exploreMenuSection'); ?></a></li>
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/addEditPhoto"><?php echo lang('add_photo'); ?></a></li>
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/photos"><?php echo lang('list_photo'); ?></a></li>
                                        <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/socialMedia"> <?php echo lang('socialMedia'); ?></a></li>
                                    </ul>
                                </li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/availableOnlineFoods">
                                <?php echo lang('available_online_foods'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/aboutUsContent"> <?php echo lang('aboutUsContent'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/googleMap"> <?php echo lang('contact_us_content'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/contactList">
                                <?php echo lang('contact_list'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/commonMenuPage"> <?php echo lang('commonMenuPage'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/social_login_setting"> <?php echo lang('social_login_setting'); ?></a></li>
                                 
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/emailSetting">
                                        <?php echo lang('email_setting'); ?></a></li>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_222"><a class="child-menu" href="<?php echo base_url()?>Frontend/paymentSetting">
                                        <?php echo lang('payment_gateway'); ?></a></li>

                          
                            </ul>
                        </li>
                       

                        <li class="treeview menu__cidirp_2227 common_use">
                            <a href="javascript:void(0)">
                                <i data-feather="bookmark"></i>
                                <span><?php echo lang('reservationSetting'); ?></span>
                            </a>
                            <ul class="treeview-menu">

                            <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_2227">
                                <a class="child-menu" href="<?php echo base_url()?>setting/reservationEnableDisable">
                                <?php echo lang('order'); ?> <?php echo lang('enable_disable'); ?>
                                </a>
                            </li>
                            <?php if($getCompanyInfo->sos_enable_reservation=="Yes"):?>
                                <li data-access="all_setting-358" class="menu_assign_class" data-menu__cid="irp_2227">
                                    <a class="child-menu" href="<?php echo base_url()?>setting/orderReceivingUserReservation">
                                <?php echo lang('order_receiving_user'); ?></a></li>
                            <?php endif?>
                            </ul>
                        </li>
                        <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
                        <li data-access="view-291" class="menu_assign_class menu__cidirp_18 setting_report1" data-menu__cid="irp_18">
                            <a  href="<?php echo base_url()?>Plugin/plugins">
                                <i data-feather="pen-tool"></i>
                                <span> <?php echo lang('plugins'); ?></span>
                            </a>
                        </li>
                        <?php endif?>


                        <li class="menu-header small border_bottom_none item_stock">
                            <span class="menu-header-text"><?php echo lang('Item_Stock');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <li class="treeview menu__cidirp_16 item_stock">
                            <a href="javascript:void(0)">
                                <i data-feather="pocket"></i>
                                <span><?php echo lang('master'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-212" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>Unit/addEditUnit"><?php echo lang('Add'); ?> <?php echo lang('Ingredient_Unit'); ?></a></li>
                                <li data-access="view-212" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>Unit/Units"><?php echo lang('List'); ?> <?php echo lang('Ingredient_Unit'); ?></a></li>
                                <li data-access="add-207" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>ingredientCategory/addEditIngredientCategory"><?php echo lang('Add'); ?> <?php echo lang('ingredient_category'); ?></a></li>
                                <li data-access="view-207" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>ingredientCategory/ingredientCategories"><?php echo lang('List'); ?> <?php echo lang('ingredient_category'); ?></a></li>
                                <li data-access="add-217" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>ingredient/addEditIngredient"><?php echo lang('Add'); ?> <?php echo lang('ingredient'); ?></a></li>
                                <li data-access="view-217" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>ingredient/ingredients"><?php echo lang('List'); ?> <?php echo lang('ingredient'); ?></a></li>
                                <li data-access="add-223" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>modifier/addEditModifier"><?php echo lang('Add'); ?> <?php echo lang('modifier'); ?></a></li>
                                <li data-access="view-223" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>modifier/modifiers"><?php echo lang('List'); ?> <?php echo lang('modifier'); ?></a></li>
                                <li data-access="add-229" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>foodMenuCategory/addEditFoodMenuCategory"><?php echo lang('Add'); ?> <?php echo lang('food_menu_category'); ?></a></li>
                                <li data-access="view-229" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>foodMenuCategory/foodMenuCategories"><?php echo lang('List'); ?> <?php echo lang('food_menu_category'); ?></a></li>
                                <li data-access="add-234" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>foodMenu/addEditFoodMenu"><?php echo lang('Add'); ?> <?php echo lang('food_menu'); ?></a></li>
                                <li data-access="view-234" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>foodMenu/foodMenus"><?php echo lang('List'); ?> <?php echo lang('food_menu'); ?></a></li>
                                <li data-access="add-325" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>PreMadeFood/addEditPreMadeFood"><?php echo lang('Add'); ?> <?php echo lang('premade_food'); ?></a></li>
                                <li data-access="view-325" class="menu_assign_class" data-menu__cid="irp_16"><a class="child-menu" href="<?php echo base_url()?>PreMadeFood/preMadeFoods"><?php echo lang('List'); ?> <?php echo lang('premade_food'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_6_1 item_stock">
                            <a href="javascript:void(0)">
                                <i data-feather="anchor"></i>
                                <span> <?php echo lang('production'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-340" class="menu_assign_class" data-menu__cid="irp_6_1"><a class="child-menu" href="<?php echo base_url()?>Production/addEditProduction">
                                        <?php echo lang('Add'); ?> <?php echo lang('production'); ?></a></li>
                                <li data-access="view-340" class="menu_assign_class" data-menu__cid="irp_6_1"><a class="child-menu" href="<?php echo base_url()?>Production/productions">
                                        <?php echo lang('List'); ?> <?php echo lang('production'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_9 item_stock">
                            <a href="javascript:void(0)">
                                <i data-feather="database"></i>
                                <span> <?php echo lang('inventory'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="view-129" class="menu_assign_class" data-menu__cid="irp_9"><a class="child-menu" href="<?php echo base_url()?>Inventory/index">
                                        <?php echo lang('inventory'); ?></a></li>
                                <li data-access="view-173" class="menu_assign_class" data-menu__cid="irp_9"><a class="child-menu" href="<?php echo base_url()?>Inventory/getInventoryAlertList">
                                        <?php echo lang('ingredients_alert'); ?></a></li>
                                <li data-access="veiw-346" class="menu_assign_class" data-menu__cid="irp_9"><a class="child-menu" href="<?php echo base_url()?>Inventory/inventoryFoodMenu">
                                        <?php echo lang('inventory_food_menu'); ?></a></li>
                                <li data-access="add-131" class="menu_assign_class" data-menu__cid="irp_9"><a class="child-menu" href="<?php echo base_url()?>Inventory_adjustment/addEditInventoryAdjustment">
                                        <?php echo lang('Add'); ?> <?php echo lang('inventory_adjustment'); ?></a></li>
                                <li data-access="view-131" class="menu_assign_class" data-menu__cid="irp_9"><a class="child-menu" href="<?php echo base_url()?>Inventory_adjustment/inventoryAdjustments">
                                        <?php echo lang('List'); ?> <?php echo lang('inventory_adjustment'); ?></a></li>
                            </ul>
                        </li>

                        <li class="menu-header small border_bottom_none sale_customer">
                            <span class="menu-header-text"><?php echo lang('Sale_Customer');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <li class="treeview menu__cid8 sale_customer">
                            <a href="javascript:void(0)">
                                <i data-feather="shopping-cart"></i>
                                <span> <?php echo lang('sale'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-118" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>Promotion/addEditPromotion">
                                        <?php echo lang('Add'); ?> <?php echo lang('promotion'); ?></a></li>
                                <li data-access="view-118" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>Promotion/promotions">
                                        <?php echo lang('List'); ?> <?php echo lang('promotion'); ?></a></li>

                                <li data-access="add-249" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>customer/addEditCustomer">
                                        <?php echo lang('Add'); ?> <?php echo lang('customer'); ?></a></li>
                                <li data-access="view-249" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>customer/customers">
                                        <?php echo lang('List'); ?> <?php echo lang('customer'); ?></a></li>
                                <li data-access="upload_customer-249" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>customer/uploadCustomer">
                                        <?php echo lang('upload_customer'); ?></a></li>

                                <li data-access="pos_1-73" class="" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>POSChecker/posAndWaiterMiddleman">
                                        <?php echo lang('Add'); ?> <?php echo lang('sale'); ?></a></li>
                                <li data-access="view-123" class="menu_assign_class" data-menu__cid="8"><a class="child-menu" href="<?php echo base_url()?>Sale/sales">
                                        <?php echo lang('List'); ?> <?php echo lang('sale'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_13 sale_customer">
                            <a href="javascript:void(0)">
                                <i data-feather="corner-down-right"></i>
                                <span> <?php echo lang('customer_due_receive'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-151" class="menu_assign_class" data-menu__cid="irp_13"><a class="child-menu" href="<?php echo base_url()?>Customer_due_receive/addCustomerDueReceive">
                                        <?php echo lang('Add'); ?> <?php echo lang('customer_due_receive'); ?></a></li>
                                <li data-access="view-151" class="menu_assign_class" data-menu__cid="irp_13"><a class="child-menu" href="<?php echo base_url()?>Customer_due_receive/customerDueReceives">
                                        <?php echo lang('List'); ?> <?php echo lang('customer_due_receive'); ?></a></li>
                            </ul>
                        </li>
                        
                        <li class="menu-header small border_bottom_none purchase_expense">
                            <span class="menu-header-text"><?php echo lang('Purchase_Expense');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <li class="treeview menu__cidirp_6 purchase_expense">
                            <a href="javascript:void(0)">
                                <i data-feather="arrow-down-circle"></i>
                                <span> <?php echo lang('purchase'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-244" class="menu_assign_class" data-menu__cid="irp_6"><a class="child-menu" href="<?php echo base_url()?>supplier/addEditSupplier">
                                        <?php echo lang('Add'); ?> <?php echo lang('supplier'); ?></a></li>
                                <li data-access="view-244" class="menu_assign_class" data-menu__cid="irp_6"><a class="child-menu" href="<?php echo base_url()?>supplier/suppliers">
                                        <?php echo lang('List'); ?> <?php echo lang('supplier'); ?></a></li>
                                <li data-access="add-106" class="menu_assign_class" data-menu__cid="irp_6"><a class="child-menu" href="<?php echo base_url()?>Purchase/addEditPurchase">
                                        <?php echo lang('Add'); ?> <?php echo lang('purchase'); ?></a></li>
                                <li data-access="view-106" class="menu_assign_class" data-menu__cid="irp_6"><a class="child-menu" href="<?php echo base_url()?>Purchase/purchases">
                                        <?php echo lang('List'); ?> <?php echo lang('purchase'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_12 purchase_expense">
                            <a href="javascript:void(0)">
                                <i data-feather="corner-down-left"></i>
                                <span> <?php echo lang('supplier_due_payment'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-147" class="menu_assign_class" data-menu__cid="irp_12"><a class="child-menu" href="<?php echo base_url()?>SupplierPayment/addSupplierPayment">
                                        <?php echo lang('Add'); ?> <?php echo lang('supplier_due_payment'); ?></a></li>
                                <li data-access="view-147" class="menu_assign_class" data-menu__cid="irp_12"><a class="child-menu" href="<?php echo base_url()?>SupplierPayment/supplierPayments">
                                        <?php echo lang('List'); ?> <?php echo lang('supplier_due_payment'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_11 purchase_expense">
                            <a href="javascript:void(0)">
                                <i data-feather="arrow-left-circle"></i>
                                <span> <?php echo lang('expense'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-255" class="menu_assign_class" data-menu__cid="irp_11"><a class="child-menu" href="<?php echo base_url()?>expenseItems/addEditExpenseItem">
                                        <?php echo lang('Add'); ?> <?php echo lang('expense_item'); ?></a></li>
                                <li data-access="view-255" class="menu_assign_class" data-menu__cid="irp_11"><a class="child-menu" href="<?php echo base_url()?>expenseItems/expenseItems">
                                        <?php echo lang('List'); ?> <?php echo lang('expense_item'); ?></a></li>
                                <li data-access="add-142" class="menu_assign_class" data-menu__cid="irp_11"><a class="child-menu" href="<?php echo base_url()?>Expense/addEditExpense">
                                        <?php echo lang('Add'); ?> <?php echo lang('expense'); ?></a></li>
                                <li data-access="view-142" class="menu_assign_class" data-menu__cid="irp_11"><a class="child-menu" href="<?php echo base_url()?>Expense/expenses">
                                        <?php echo lang('List'); ?> <?php echo lang('expense'); ?></a></li>
                            </ul>
                        </li>

                        <li class="menu-header small border_bottom_none transfer_damage">
                            <span class="menu-header-text"><?php echo lang('Transfer_Damage');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <?php if(str_rot13($data_c[0]) == "eriutoeri"):?>
                        <li class="treeview menu__cidirp_7 transfer_damage">
                            <a href="javascript:void(0)">
                                <i data-feather="truck"></i>
                                <span> <?php echo lang('transfer'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-112" class="menu_assign_class" data-menu__cid="irp_7"><a class="child-menu" href="<?php echo base_url()?>Transfer/addEditTransfer">
                                        <?php echo lang('Add'); ?> <?php echo lang('transfer'); ?></a></li>
                                <li data-access="view-112" class="menu_assign_class" data-menu__cid="irp_7"><a class="child-menu" href="<?php echo base_url()?>Transfer/transfers">
                                        <?php echo lang('List'); ?> <?php echo lang('transfer'); ?></a></li>
                            </ul>
                        </li>
                        <?php endif;?>
                        <li class="treeview menu__cidirp_10 transfer_damage">
                            <a href="javascript:void(0)">
                                <i data-feather="trash-2"></i>
                                <span> <?php echo lang('waste'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-137" class="menu_assign_class" data-menu__cid="irp_10"><a class="child-menu" href="<?php echo base_url()?>Waste/addEditWaste">
                                        <?php echo lang('Add'); ?> <?php echo lang('waste'); ?></a></li>
                                <li data-access="view-137" class="menu_assign_class" data-menu__cid="irp_10"><a class="child-menu" href="<?php echo base_url()?>Waste/wastes">
                                        <?php echo lang('List'); ?> <?php echo lang('waste'); ?></a></li>
                            </ul>
                        </li>

                        <li class="menu-header small border_bottom_none account_attendance">
                            <span class="menu-header-text"><?php echo lang('Account_Attendance');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <li class="treeview menu__cidirp_17 account_attendance">
                            <a href="javascript:void(0)">
                                <i data-feather="users"></i>
                                <span><?php echo lang('account_user'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-285" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Role/addEditRole"><?php echo lang('Add'); ?> <?php echo lang('role'); ?></a></li>
                                <li data-access="view-285" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Role/roles"><?php echo lang('List'); ?> <?php echo lang('role'); ?></a></li>
                                <li data-access="add-291" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>User/addEditUser"><?php echo lang('Add'); ?> <?php echo lang('user'); ?></a></li>
                                <li data-access="view-291" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>User/users"><?php echo lang('List'); ?> <?php echo lang('user'); ?></a></li>
                                <li data-access="update-298" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Authentication/changeProfile"><?php echo lang('change_profile'); ?></a></li>
                                <li data-access="update-300" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Authentication/changePassword"><?php echo lang('change_password'); ?></a></li>
                                <li data-access="update-330" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Authentication/changePin"><?php echo lang('changePin'); ?></a></li>
                                <li data-access="update-302" class="menu_assign_class" data-menu__cid="irp_17"><a class="child-menu" href="<?php echo base_url()?>Authentication/securityQuestion"><?php echo lang('SetSecurityQuestion'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview menu__cidirp_14 account_attendance">
                            <a href="javascript:void(0)">
                                <i data-feather="clock"></i>
                                <span> <?php echo lang('attendance'); ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li data-access="add-155" class="menu_assign_class" data-menu__cid="irp_14"><a class="child-menu" href="<?php echo base_url()?>Attendance/addEditAttendance">
                                        <?php echo lang('Add'); ?> <?php echo lang('attendance'); ?></a></li>
                                <li data-access="view-155" class="menu_assign_class" data-menu__cid="irp_14"><a class="child-menu" href="<?php echo base_url()?>Attendance/attendances">
                                        <?php echo lang('List'); ?> <?php echo lang('attendance'); ?></a></li>
                            </ul>
                        </li>



                        <li class="menu-header small border_bottom_none setting_report1">
                            <span class="menu-header-text"><?php echo lang('Report_Settings');?></span>
                            <i data-feather="more-vertical"></i>
                        </li>
                        <li class="treeview menu__cidirp_15 setting_report1">
                            <a href="javascript:void(0)">
                                <i data-feather="book"></i>
                                <span><?php echo lang('report'); ?></span>

                            </a>
                            <ul class="treeview-menu">
                                <li data-access="view-159" class="menu_assign_class" data-menu__cid="irp_15">
                                    <a class="child-menu" href="<?php echo base_url()?>Report/registerReport">
                                        <?php echo lang('register_report'); ?>
                                    </a>
                                </li>
                                <li data-access="view-314" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/zReport"><?php echo lang('z_report'); ?></a></li>
                                <li data-access="view-314" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/kitchenPerformanceReport"><?php echo lang('kitchenPerformanceReport'); ?></a></li>
                                <li data-access="view-332" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/productAnalysisReport"> <?php echo lang('productAnalysisReport'); ?></a></li>
                                <li data-access="view-161" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/dailySummaryReport"><?php echo lang('daily_summary_report'); ?></a></li>
                                <li data-access="view-163" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/foodMenuSales"><?php echo lang('food_sale_report'); ?></a></li>
                                <li data-access="view-165" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/saleReportByDate"><?php echo lang('daily_sale_report'); ?></a></li>
                                <li data-access="view-167" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/detailedSaleReport"><?php echo lang('detailed_sale_report'); ?></a></li>
                                <li data-access="view-370" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/serviceDeliveryChargeReport"><?php echo lang('serviceDeliveryChargeReport'); ?></a></li>
                                <li data-access="view-169" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/consumptionReport"><?php echo lang('consumption_report'); ?></a></li>
                                <li data-access="view-171" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/inventoryReport"><?php echo lang('inventory_report'); ?></a></li>
                                <li data-access="view-173" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/getInventoryAlertList"><?php echo lang('low_inventory_report'); ?></a></li>
                                <li data-access="view-175" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/profitLossReport"><?php echo lang('profit_loss_report'); ?></a></li>
                                <li data-access="view-179" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/attendanceReport"><?php echo lang('attendance_report'); ?></a></li>
                                <li data-access="view-181" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/supplierLedgerReport"><?php echo lang('supplier_ledger_report'); ?></a></li>
                                <li data-access="view-183" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/supplierDueReport"><?php echo lang('supplier_due_report'); ?></a></li>
                                <li data-access="view-185" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/customerDueReport"><?php echo lang('customer_due_report'); ?></a></li>
                                <li data-access="view-187" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/customerLedgerReport"><?php echo lang('customer_ledger_report'); ?></a></li>
                                <li data-access="view-189" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/purchaseReportByDate"><?php echo lang('purchase_report'); ?></a></li>
                                <li data-access="view-191" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/expenseReport"><?php echo lang('expense_report'); ?></a></li>
                                <li data-access="view-193" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/wasteReport"><?php echo lang('waste_report'); ?></a></li>
                                <li data-access="view-195" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/vatReport"><?php echo lang('vat_report'); ?></a></li>
                                <li data-access="view-197" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/foodMenuSaleByCategories"><?php echo lang('foodMenuSaleByCategories'); ?></a></li>
                                <li data-access="view-199" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/tipsReport"><?php echo lang('tips_report'); ?></a></li>
                                <li data-access="view-201" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/auditLogReport"><?php echo lang('auditLogReport'); ?></a></li>
                                <li data-access="view-205" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/availableLoyaltyPointReport"><?php echo lang('loyalty_point_report'); ?></a></li>
                                <li data-access="view-203" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/usageLoyaltyPointReport"><?php echo lang('usage_loyalty_point_report'); ?></a></li>
                                <?php if(str_rot13($data_c[0]) == "eriutoeri"):?>
                                <li data-access="view-307" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/transferReport"><?php echo lang('transferReport'); ?></a></li>
                                <?php endif;?>
                                <li data-access="view-337" class="menu_assign_class" data-menu__cid="irp_15"><a class="child-menu" href="<?php echo base_url()?>Report/productionReport"><?php echo lang('productionReport'); ?></a></li>
                            </ul>
                        </li>

                        <li data-access="view-321" class="menu_assign_class"><a class="child-menu" href="<?php echo base_url()?>Short_message_service/smsService">
                        <i data-feather="message-square"></i>  <span> <?php echo lang('send_sms'); ?></span></a></li>

                        <li class="menu_assign_class">
                            <a href="<?php echo base_url()?>Authentication/logOut">
                                <i data-feather="log-out"></i>
                                <span> <?php echo lang('logout'); ?></span>
                            </a>
                        </li>

                        <div class="ps__rail-x" style="width: 70px; left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 21px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 545px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 304px;"></div>
                        </div>
                    </ul>

                </div>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- =============================================== -->
 
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" <?php echo isset($language) && $language=="arabic" ? 'style="margin-right:50px;margin-left:0px"':''?>>
            <!-- Main content -->
            <?php
                if (isset($main_content)) {
                    //This variable could not be escaped because this is html content
                    echo ($main_content);
                }
            ?>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer"  <?=isset($language) && $language=="arabic"?'style="margin-left:0px"':''?>>
            <div class="row">
                <div class="col-md-12 ir_txt_center">
                    <strong><?php echo escape_output($footer); ?></strong> <span class='pull-right footer_version'> <?php echo lang('Version').$this->session->userdata('system_version_number')?></span>
                    <div class="hidden-lg"></div>
                </div>
            </div>
        </footer>
    </div>

    <div class="modal fade" id="todaysSummary" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="ShortCut">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="myModalLabel"><?php echo lang('todays_summary'); ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-body table-responsive">
                        <table class="table">
                            <tr>
                                <td class="ir_w_80">
                                    <?php echo lang('purchase'); ?>(<?php echo lang('only_paid_amount'); ?>) (-)</td>
                                <td><span id="purchase_today_"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('sale'); ?>(<?php echo lang('only_paid_amount'); ?>) (+)</td>
                                <td><span id="sale_today"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('sale_return_amount'); ?> (-)</td>
                                <td><span id="sale_return_amount"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('total'); ?> <?php echo lang('vat'); ?> (-)</td>
                                <td><span id="totalVat"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('expense'); ?> (-)</td>
                                <td><span id="Expense"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('supplier_due_payment'); ?> (-)</td>
                                <td><span id="supplierDuePayment"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('customer_due_receive'); ?> (+)</td>
                                <td><span id="customerDueReceive"></span></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('waste'); ?> (-)</td>
                                <td><span id="waste_today"></span></td>
                            </tr>
                            <tr class="border_top_daily_summery">
                                <td><b><?php echo lang('balance'); ?></b> = (<?php echo lang('sale'); ?> +
                                    <?php echo lang('customer_due_receive'); ?>) - (<?php echo lang('purchase'); ?> +
                                    <?php echo lang('supplier_due_payment'); ?> + <?php echo lang('expense'); ?>) + <?php echo lang('sale_return_amount'); ?></td>
                                <td><span id="balance"></span></td>
                            </tr>
                        </table>

                        <br>
                        <div id="showCashStatus"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(APPLICATION_MODE == 'demo'): ?>
                <?php
                $company = getMainCompany();
                $language_manifesto = $company->language_manifesto;
                if(str_rot13($language_manifesto)=="eriutoeri"):?>
                    <a class="btn btn-danger custom_shadow" href="https://codecanyon.net/item/irestora-plus-multi-outlet-next-gen-restaurant-pos/24077441" target="_blank">&nbsp;&nbsp;Buy Now&nbsp;&nbsp;</a>
                <?php else:?>
                    <a class="btn btn-danger custom_shadow" href="https://codecanyon.net/item/irestora-plus-next-gen-restaurant-pos/23033741" target="_blank">&nbsp;&nbsp;Buy Now&nbsp;&nbsp;</a>
                <?php endif;?>
    <?php endif; ?>

<?php
//generating object for access module show/hide
$j = 1;
$menu_objects = "";
$access = $this->session->userdata('function_access');

if(isset($access) && $access):
    foreach($access as $value){
        if($j==count($access)){
            $menu_objects .="'".$value."'";
        }else{
            $menu_objects .="'".$value."',";
        }
        $j++;
    }
endif;
?>
    <script>
        /*This variable could not be escaped because this is building object*/
        window.menu_objects = [<?php echo ($menu_objects);?>];
    </script>
    <!-- Bootstrap 5.0.0 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/css-framework/bootstrap-new/bootstrap.bundle.min.js"></script>

    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/nice-select/js/jquery.nice-select.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/menu.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>
    <!-- custom scrollbar plugin -->
    <script src="<?php echo base_url(); ?>assets/dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- material icon -->
    <script src="<?php echo base_url(); ?>assets/dist/js/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/user_home_buttom.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/media.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/new-script.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/slick-slider/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/new_ui_design.js"></script>
</body>

</html>
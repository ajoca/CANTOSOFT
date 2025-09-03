<?php
    $notification_number = 0;
    if(count($notifications)>0){
        $notification_number = count($notifications);
    }
    $notification_list_show = '';
    foreach ($notifications as $single_notification){
        $notification_list_show .= '<div class="single_row_notification fix" id="single_notification_row_'.$single_notification->id.'">';
        $notification_list_show .= '<div class="fix single_notification_check_box">';
        $notification_list_show .= '<input class="single_notification_checkbox" type="checkbox" id="single_notification_'.$single_notification->id.'" value="'.$single_notification->id.'">';
        $notification_list_show .= '</div>';
        $notification_list_show .= '<div class="fix single_notification">'.$single_notification->notification.'</div>';
        $notification_list_show .= '<div class="single_serve_button">';
        $notification_list_show .= '<button class="btn bg-blue-btn single_serve_b" id="notification_serve_button_'.$single_notification->id.'">Delete</button>';
        $notification_list_show .= '</div>';
        $notification_list_show .= '</div>';
    }

    $base_color = '#8d5df3'; //old
    $base_color2 = '#8b5cf61a';
    // $base_color = '#FF1010'; //new
    // $base_color2 = '#FF10101A';
    $dashboard_chart_color = '#7367f045';
?>
<?php
    $wl = getWhiteLabel();
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
    $mode = APPLICATION_lcl; 
    ?>
<!DOCTYPE html>
<html class="gr__localhost">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo escape_output($site_name); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frequent_changing/bar_panel/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frequent_changing/bar_panel/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/v5/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom/login.css">
    <script src="<?php echo base_url()?>frequent_changing/bar_panel/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/bar_panel/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/bar_panel/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <base data-base="<?php echo base_url(); ?>"></base>
    <base data-collect-vat="<?php echo escape_output($this->session->userdata('collect_vat')); ?>"></base>
    <base data-currency=""></base>
    <base data-role="<?php echo escape_output($this->session->userdata('role')); ?>"></base>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($favicon) ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css-framework/bootstrap-new/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/newDesign/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/kitchen_panel/css/custom_kitchen_panel.css">
    <style>
        <?php if ($this->session->has_userdata('language')) {
                $font_detect=$this->session->userdata('language');
        }?>
        <?php if($font_detect=="arabic"):?>
            @font-face {
                font-family: arabic_font;
                src: url(<?=base_url()?>/assets/Cairo-VariableFont_wght.ttf);
            }
            .arabic_font {
                font-family: arabic_font !important
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            span,
            p,
            div {
                font-family: arabic_font !important
            }
        <?php endif;?>
        #main_kitchen_header{
            background-color: <?php echo $base_color;?>;
        }
        .single_row_notification .bg-blue-btn, #notification_list_modal .modal-footer .bg-blue-btn, #help_modal .modal-footer .bg-blue-btn{
            background-color: <?php echo $base_color?>;
        }
    </style>
</head>

<body class="arabic_font">
    <input type="hidden" id="csrf_name_" value="<?php echo escape_output($this->security->get_csrf_token_name()); ?>">
    <input type="hidden" id="csrf_value_" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
    <input type="hidden" id="kitchen_id" value="<?php echo escape_output($kitchen_id); ?>">
    <input type="hidden" id="note_text" value="<?php echo lang("note") ?>">
    <input type="hidden" id="sale_no" value="<?php echo lang("sale_no") ?>">
    <input type="hidden" id="table" value="<?php echo lang("table") ?>">
    <input type="hidden" id="order_type" value="<?php echo lang("order_type") ?>">
    <input type="hidden" id="inv_dine" value="<?php echo lang('dine') ?>">
    <input type="hidden" id="inv_take_away" value="<?php echo lang('take_away') ?>">
    <input type="hidden" id="inv_delivery" value="<?php echo lang('delivery') ?>">
    <input type="hidden" id="text_not_ready" value="<?php echo lang('text_not_ready') ?>">
    <input type="hidden" id="text_ready" value="<?php echo lang('text_ready') ?>">
    <input type="hidden" id="text_in_preparation" value="<?php echo lang('text_in_preparation') ?>">
    <input type="hidden" id="text_done" value="<?php echo lang('text_done') ?>">
    <input type="hidden" id="quantity_ln" value="<?php echo lang('quantity') ?>">
    <input type="hidden" id="note_ln" value="<?php echo lang('note') ?>">
    <input type="hidden" id="modifiers_ln" value="<?php echo lang('modifiers') ?>">
    <input type="hidden" id="Qty_Old" value="<?php echo lang('Qty_Old') ?>">
    <input type="hidden" id="Qty_New" value="<?php echo lang('Qty_New') ?>">
    <input type="hidden" id="dine_ln" value="<?php echo lang('dine') ?>">
    <input type="hidden" id="take_away_ln" value="<?php echo lang('take_away') ?>">
    <input type="hidden" id="delivery_ln" value="<?php echo lang('delivery') ?>">
    <input type="hidden" id="customer_name_ln" value="<?php echo lang('customer_name') ?>">
    <input type="hidden" id="text_not_ready_ln" value="<?php echo lang('text_not_ready') ?>">
    <input type="hidden" id="text_ready_ln" value="<?php echo lang('text_ready') ?>">
    <input type="hidden" id="text_in_preparation_ln" value="<?php echo lang('text_in_preparation') ?>">
    <input type="hidden" id="alert" value="<?php echo lang('alert') ?>">
    <input type="hidden" id="cooking_started" value="<?php echo lang('cooking_started') ?>">
    <input type="hidden" id="cooking_done" value="<?php echo lang('cooking_done') ?>">
    <input type="hidden" id="please_select_an_time_for_cook" value="<?php echo lang('please_select_an_time_for_cook') ?>">
    <input type="hidden" id="you_should_select_all" value="<?php echo lang('you_should_select_all') ?>">
    <input type="hidden" id="please_select_an_time_for_done" value="<?php echo lang('please_select_an_time_for_done') ?>">
    <input type="hidden" id="select_all" value="<?php echo lang('select_all') ?>">
    <input type="hidden" id="cook" value="<?php echo lang('cook') ?>">
    <input type="hidden" id="done" value="<?php echo lang('done') ?>">


    <span class="ir_display_none" id="selected_order_for_refreshing_help"></span>
    <span class="ir_display_none" id="refresh_it_or_not"><?php echo lang('yes'); ?></span>
    <div class="wrapper fix">
        <div class="fix main_top">
            <div class="row" id="main_kitchen_header">
                <div class="top_header col-sm-12 col-md-4">
                    <h1><?php echo escape_output($kitchen->name); ?></h1>
                </div>
                <div class="top_menu col-sm-12 col-md-8 d-flex align-items-center justify-content-end">
                <?php if($mode!='lcl'):?>
                    <?php $language=$this->session->userdata('language'); ?>
                    <?php echo form_open(base_url() . 'Authentication/setlanguage', $arrayName = array('id' => 'language')) ?>
                    <select tabindex="2" class="form-control select2 ir_w_100" name="language"
                            onchange='this.form.submit()'>
                            <?php
                        $dir = glob("application/language/*",GLOB_ONLYDIR);
                        $language = $this->session->userdata('language');
                        foreach ($dir as $value):
                            $separete = explode("language/",$value);?>
                            <option value="<?php echo escape_output($separete[1])?>" <?php if(isset($language)){
                            if ($language == $separete[1])
                                echo "selected";
                        }
                        ?>><?php echo ucfirstcustom($separete[1])?></option>
                            <?php
                        endforeach;
                        ?>

                    </select>
                    </form>
                   <?php endif?>
                    <a class="btn bg-blue-btn me-2"href="<?php echo base_url(); ?>Kitchen/kitchens" id="logout_button"><i
                                class="fas me-2 fas-caret-square-left"></i><?php echo lang('back'); ?></a>

                    <div class="top_menu_right" id="group_by_order_item_holder ir_h_float_m"></div>
                    
                    <div class="top_menu_right me-2 btn bg-blue-btn">
                        <p class="m-0">
                            <i class="fas fa-sync-alt ir_mouse_pointer" id="refresh_orders_button"></i>
                        </p>
                    </div>

                    <button id="notification_button" data-bs-toggle="modal" data-bs-target="#notification_list_modal" class="btn me-2 bg-blue-btn">
                        <i class="fa me-2 fa-bell"></i>
                        <?php echo lang('notification'); ?> (<span
                            id="notification_counter"><?php echo escape_output($notification_number); ?></span>)
                    </button>

                    <button id="help_button"  data-bs-toggle="modal" data-bs-target="#help_modal" class="btn me-2 bg-blue-btn">
                        <i class="fa me-2 fa-question-circle"></i>
                        <?php echo lang('help'); ?></button>

                    <a href="<?php echo base_url(); ?>Authentication/logOut" class="btn bg-blue-btn" id="logout_button">
                        <i class="fas me-2 fa-sign-out-alt"></i> <?php echo lang('logout'); ?></a>
                </div>
            </div>
        </div>

        <div class="fix main_bottom">
            <div class="fix order_holder mt-2" id="order_holder">
            </div>
        </div>
    </div>

  

    <div class="modal fade" id="help_modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('help'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="help_content">
                <?php echo lang('kitchen_help_text_first_para'); ?> 
                </p>
                <p class="help_content">
                <?php echo lang('kitchen_help_text_second_para'); ?>
                </p>
                <p class="help_content">
                    <?php echo lang('kitchen_help_text_third_para'); ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="notification_list_modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('notification_list'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="notification_list_header_holder">
                    <div class="single_row_notification_header fix ir_h_bm">
                        <div class="fix single_notification_check_box">
                            <input type="checkbox" id="select_all_notification">
                        </div>
                        <div class="fix single_notification"><strong><?php echo lang('select_all'); ?></strong></div>
                        <div class="fix single_serve_button">
                        </div>
                    </div>
                </div>

                <div id="notification_list_holder" class="fix">
                    <!--This variable could not be escaped because this is html content-->
                    <?php echo ($notification_list_show);?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn bg-blue-btn" id="notification_remove_all"><?php echo lang('remove'); ?></button>
                <button class="btn bg-blue-btn" data-bs-dismiss="modal" id="notification_close"><?php echo lang('close'); ?></button>
                
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
    
    <script src="<?php echo base_url(); ?>assets/css-framework/bootstrap-new/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/kitchen_panel/js/marquee.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/kitchen_panel/js/datable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/kitchen_panel/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/howler.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/kitchen_panel/js/custom.js"></script>
    <!-- material icon -->

</body>

</html>
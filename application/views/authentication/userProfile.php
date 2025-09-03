<!-- Main content -->
<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception_er')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p class="error_c_space"><i class="icon fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_er'));;unset($_SESSION['exception_er']);
        echo '</p></section>';
    }
    ?>
    <?php
        $is_display_1 = '';
        $is_display_2 = '';
        $is_display_3 = '';
        $is_display_4 = '';
        $role = $this->session->userdata('role');
        $outlet_id = $this->session->userdata('outlet_id');
        if($role!="Admin"){
            $segment_2 = $this->uri->segment(2);
            $segment_3 = $this->uri->segment(3);

            $controller = "73";
            $function = "pos_1";
            if(!checkAccess($controller,$function)){
                $is_display_1 = "none";
            }
            $controller = "104";
            $function = "view";
            if(!checkAccess($controller,$function)){
                $is_display_2 = "none";
            }
            $controller = "98";
            $function = "view";
            if(!checkAccess($controller,$function)){
                $is_display_3 = "none";
            }
            $controller = "1";
            $function = "view";
            if(!checkAccess($controller,$function)){
                $is_display_4 = "none";
            }
        }
        if(!$outlet_id){
            $is_display_1 = "none";
            $is_display_2 = "none";
            $is_display_3 = "none";
            $is_display_4 = "none";
        }
    ?>
    <div class="row">
        <div class="col-md-3 mb-2" style="display: <?php echo escape_output($is_display_4)?>">
            <a class="btn new-btn w-100" href="<?php echo base_url() ?>Dashboard/dashboard">
                <?php echo lang('dashboard'); ?>
            </a>
        </div>
        <div class="col-md-3 mb-2" style="display: <?php echo escape_output($is_display_1)?>">
            <a class="btn new-btn w-100" href="<?php echo base_url() ?>POSChecker/posAndWaiterMiddleman">
                <?php echo lang('pos_screen'); ?>
            </a>
        </div>
        <div class="col-md-3 mb-2" style="display: <?php echo escape_output($is_display_2)?>">
            <a class="btn new-btn w-100" href="<?php echo base_url() ?>Waiter/panel">
                <?php echo lang('waiter_screen'); ?>
            </a>
        </div>
        <div class="col-md-3 mb-2" style="display: <?php echo escape_output($is_display_3)?>">
            <a class="btn new-btn w-100" href="<?php echo base_url() ?>Kitchen/kitchens">
                <?php echo lang('kitchen_panel'); ?>
            </a>
        </div>

    </div>
    <!-- general form elements -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-5 col-xl-3 mt-2">
            <div class="user-profile-card">
                <div class="d-flex align-items-center">
                    <div class="media-size-email">
                        <img width="45" height="45" class="me-3 rounded-circle" src="<?=base_url()?>images/avatar.png" alt="Image">
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="m-0"><?php echo escape_output($this->session->userdata('full_name')); ?></h5>
                        <p class="text-muted my-1 font-weight-bolder text-lowercase overflow-wrap-anywhere">
                            <?php echo escape_output($this->session->userdata('email_address')); ?>
                        </p>
                    </div>
                </div>
                <!-- End User Profile Info -->

                <ul class="menu-list">
                    <li class="item">
                        <a href="<?php echo base_url();?>Authentication/changeProfile">
                            <span class="iconbg badge-light-primary">
                                <i data-feather="user"></i>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('change_profile'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="<?php echo base_url();?>Authentication/changePassword">
                            <span class="iconbg badge-light-success">
                                <i data-feather="key"></i>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('change_password'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="<?php echo base_url();?>Authentication/securityQuestion">
                            <span class="iconbg badge-light-info">
                                <i data-feather="alert-circle"></i>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('SetSecurityQuestion'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="<?php echo base_url();?>Authentication/logOut" class="logOutTrigger">
                            <span class="iconbg badge-light-danger">
                                <i data-feather="log-out"></i>
                            </span>
                            <span class="user-profile-card-text">
                                <?php echo lang('logout'); ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End User Profile -->
        <div class="col-sm-12 col-md-12 col-lg-7 col-xl-9 mt-2">
            <div class="table-card">
                <h2 class="top-left-header mb-0 mt-2 ms-3"><?php echo lang('recent_sales'); ?></h2>
                <div class="card-body table-responsive profile_min_height">
                    <input type="hidden" class="datatable_name" data-title="@lang('index.ticket')" data-id_name="datatable">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th class="w-15"><?php echo lang('sale_no'); ?></th>
                                <th class="w-19"><?php echo lang('customer'); ?></th>
                                <th class="w-10 text-center"><?php echo lang('items'); ?></th>
                                <th class="w-18 text-center"><?php echo lang('total_payable'); ?></th>
                                <th class="w-18 text-center"><?php echo lang('paid_amount'); ?></th>
                                <th class="w-15"><?php echo lang('sale_date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($sales as $key => $sale): ?>
                            <tr>
                                <td><?php echo $key +1 ?></td>
                                <td><?php echo escape_output($sale->sale_no) ?></td>
                                <td><?php echo escape_output($sale->customer_name) ?><?php echo escape_output($sale->customer_phone) ? '(' . $sale->customer_name . ')' : '' ?></td>
                                <td class="text-center"><?php echo escape_output($sale->total_items) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($sale->total_payable) ?></td>
                                <td class="text-center"><?php echo getAmtCustom($sale->paid_amount) ?></td>
                                <td><?php echo dateFormatWithTime($sale->date_time) ?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo base_url(); ?>frequent_changing/js/inventory.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>

<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report.js"></script>
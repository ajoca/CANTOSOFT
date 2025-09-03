<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/self_order.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/self_order.css">

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
    <?php
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('order_receiving_user'); ?> (<?php echo lang('reservation'); ?>)
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'setting/orderReceivingUserReservation/', $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <?php 
                    $outlets = getAllOutlestByAssign();
                    foreach ($outlets as $key=>$outlet):
                            $key++;
                    ?>
                        <input type="hidden" name="outlet_id[]" value="<?php echo escape_output($outlet->id)?>">
                    <div class="col-sm-12 mb-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo escape_output($key)?>. <?php echo lang('outlet'); ?>: <b><?php echo escape_output($outlet->outlet_name)?></b></label>
                                        <select class="form-control select2 ir_w_100" name="reservation_order_receiving_id[]" id="reservation_order_receiving_id">
                                        <option value=""><?php echo lang('receiving_user'); ?></option>
                                        <?php
                                        foreach ($waiters as $value):
                                                    ?>
                                                    <option  <?php echo ($outlet->reservation_order_receiving_id==$value->id)?'selected':''?> value="<?=$value->id?>"><?=$value->full_name?> (<?=$value->designation?>)</option>
                                                    <?php 
                                        endforeach;
                                        ?>
                                </select>
                            </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Outlet/outlets">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
</section>

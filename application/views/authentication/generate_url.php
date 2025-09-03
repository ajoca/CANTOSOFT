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
            <?php echo lang('urlGenerator'); ?> (<?php echo lang('online_order'); ?>)
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'setting/onlineOrderURL/'.(isset($company) && $company->id?$company->id:''), $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div>
                <div class="row">
                    <div class="clearfix"></div>
                    <?php
                    $session_company_id = $this->session->userdata('company_id');
                    $session_outlet_id = $this->session->userdata('outlet_id');
                    $outlets = getAllOutlestByAssignAll();
                    foreach ($outlets as $value):
                            ?>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-4">
                                <label><?php echo escape_output($value->outlet_name); ?></label>
                                <div class="form-group">
                                    <input tabindex="1" autocomplete="off" type="text"  class="form-control" placeholder="<?php echo lang('outlet_url'); ?>" readonly onfocus="select();" value="<?php echo escape_output(base_url().'online-order/'.$value->id.'/'.$session_company_id); ?>">
                                </div>
                            </div>
                        <?php endforeach;?>
                    <div class="clearfix">&nbsp;</div>
                </div>
            </div>

            <div class="row py-2">
                <div class="col-sm-12 col-md-2 mb-2">
                    <a class="btn bg-blue-btn w-100" href="<?php echo base_url() ?>setting/onlineOrder">
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

</section>

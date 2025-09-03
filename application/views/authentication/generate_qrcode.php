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
            <?php echo lang('table_qrcode_generator'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'setting/tableQrcodeGenerator/'.(isset($company) && $company->id?$company->id:''), $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <?php if(isLMni()): ?>
                        <div class="col-sm-12 mb-3 col-md-4 col-lg-3">
                            <div class="form-group">
                                <label> <?php echo lang('outlet'); ?> <span
                                            class="required_star">*</span></label>
                                <select tabindex="2" class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                                    <option value=""><?php echo lang('select') ?></option>
                                    <?php
                                    $session_outlet_id = $this->session->userdata('outlet_id');
                                    $outlets = getAllOutlestByAssign();
                                    foreach ($outlets as $value):
                                        ?>
                                        <option <?php echo isset($session_outlet_id) && $session_outlet_id==$value->id?'selected':''?> <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                                <?php if (form_error('outlet_id')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('outlet_id'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-2 mb-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-2 mb-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <a class="btn bg-blue-btn w-100" href="<?php echo base_url() ?>setting/selfOrderEnableDisable">
                                <?php echo lang('back'); ?>
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="outlet_id" value="<?php echo escape_output($this->session->userdata('outlet_id'))?>">
                    <?php endif; ?>
                 

                    <div class="clearfix"></div>
                    <?php if (isset($tables) && $tables):
                        foreach ($tables as $value):
                            ?>
                            <div class="mb-3 col-sm-12 col-md-3 col-lg-3 text_center">
                                <img  src="<?php echo base_url()?>qr_code/table-qrcode-<?php echo escape_output($value->id)?>.png">
                                <table class="sos_width_100">
                                    <tr><td><h4 class="download_qrcode"><i class="fa fa-download"></i><a class="a_qrcode" href="<?php echo base_url()?>setting/downloadQRcode/table-qrcode-<?php echo escape_output($value->id)?>.png"><?php echo lang('download')?></a></h4></td></tr>
                                </table>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                    <div class="clearfix">&nbsp;</div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
</section>

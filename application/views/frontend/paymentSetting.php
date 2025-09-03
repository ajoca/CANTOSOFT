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

        echo '<section class="content-header"
        <div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('Payment_Setting'); ?>
        </h3>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                $company_id = $this->session->userdata('company_id');
            ?>
            <?php echo form_open(base_url() . 'Frontend/paymentSetting/'.(isset($company_id) && $company_id?$company_id:''), $arrayName = array('id' => 'add_whitelabel','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 mb-2 col-md-3">
                        <?php
                        $s_field_2 = set_value('field_2');
                        ?>
                        <div class="form-group">
                            
                            <label>
                                    <b><?php echo lang('paypal'); ?></b>
                            </label>
                            <table class="ir_w_100">
                                <tr>
                                    <td>
                                        <select name="field_2"  class="form-control">
                                            <option <?php echo set_select('field_2', "0"); ?> <?php echo isset($paymentSetting->field_2) && $paymentSetting->field_2=="0"?'selected':''?> value="0"><?php echo lang('Inactive'); ?></option>
                                            <option <?php echo set_select('field_2', "1"); ?> <?php echo isset($paymentSetting->field_2) && $paymentSetting->field_2=="1"?'selected':''?> value="1"><?php echo lang('Active'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="field_2_v"  class="form-control">
                                            <option <?php echo set_select('field_2_v', "live"); ?> <?php echo isset($paymentSetting->field_2_v) && $paymentSetting->field_2_v=="live"?'selected':''?> value="live"><?php echo lang('Live'); ?></option>
                                            <option <?php echo set_select('field_2_v', "sandbox"); ?> <?php echo isset($paymentSetting->field_2_v) && $paymentSetting->field_2_v=="sandbox"?'selected':''?> value="sandbox"><?php echo lang('Sandbox'); ?></option>
                                        </select>
                                        <?php if (form_error('field_2_v')) { ?>
                                            <div class="alert alert-error txt-uh-21 ir_p_5">
                                                <?php echo form_error('field_2_v'); ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="paypal_business_email" class="form-control" placeholder="Paypal Business Email" value="<?php echo isset($paymentSetting->paypal_business_email) && $paymentSetting->paypal_business_email?$paymentSetting->paypal_business_email:set_value('paypal_business_email')?>">
                            <?php if (form_error('paypal_business_email')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('paypal_business_email'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_2_key_1" class="form-control" placeholder="Client ID" value="<?php echo isset($paymentSetting->field_2_key_1) && $paymentSetting->field_2_key_1?$paymentSetting->field_2_key_1:set_value('field_2_key_1')?>">
                            <?php if (form_error('field_2_key_1')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_2_key_1'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_2_key_2" class="form-control" placeholder="Secret Key" value="<?php echo isset($paymentSetting->field_2_key_2) && $paymentSetting->field_2_key_2?$paymentSetting->field_2_key_2:set_value('field_2_key_2')?>">
                            <?php if (form_error('field_2_key_2')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_2_key_2'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <?php
                        $s_field_3 = set_value('field_3');
                        ?>
                        <div class="form-group">

                                <label>
                                    <b><?php echo lang('stripe'); ?></b>
                            </label>
                            <table class="ir_w_100">
                                <tr>
                                    <td>
                                        <select name="field_3"  class="form-control">
                                            <option <?php echo set_select('field_3', "0"); ?> <?php echo isset($paymentSetting->field_3) && $paymentSetting->field_3=="0"?'selected':''?> value="0"><?php echo lang('Inactive'); ?></option>
                                            <option <?php echo set_select('field_3', "1"); ?> <?php echo isset($paymentSetting->field_3) && $paymentSetting->field_3=="1"?'selected':''?> value="1"><?php echo lang('Active'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="field_3_v"  class="form-control">
                                            <option <?php echo set_select('field_3_v', "live"); ?> <?php echo isset($paymentSetting->field_3_v) && $paymentSetting->field_3_v=="live"?'selected':''?> value="live"><?php echo lang('Live'); ?></option>
                                            <option <?php echo set_select('field_3_v', "demo"); ?> <?php echo isset($paymentSetting->field_3_v) && $paymentSetting->field_3_v=="demo"?'selected':''?> value="demo"><?php echo lang('Sandbox'); ?></option>
                                        </select>
                                        <?php if (form_error('field_3_v')) { ?>
                                            <div class="alert alert-error txt-uh-21 ir_p_5">
                                                <?php echo form_error('field_3_v'); ?>
                                            </div>
                                        <?php } ?>
                                </tr>
                            </table>


                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_3_key_1" class="form-control" placeholder="Stripe API Key" value="<?php echo isset($paymentSetting->field_3_key_1) && $paymentSetting->field_3_key_1?$paymentSetting->field_3_key_1:set_value('field_3_key_1')?>">
                            <?php if (form_error('field_3_key_1')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_3_key_1'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_3_key_2" class="form-control" placeholder="Stripe Publishable Key" value="<?php echo isset($paymentSetting->field_3_key_2) && $paymentSetting->field_3_key_2?$paymentSetting->field_3_key_2:set_value('field_3_key_2')?>">
                            <?php if (form_error('field_3_key_2')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_3_key_2'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <?php
                        $s_field_5 = set_value('field_5');
                        ?>
                        <div class="form-group">

                        <label>
                                    <b><?php echo lang('razorpay'); ?></b>
                            </label>
                            <table class="ir_w_100">
                                <tr>
                                    <td>
                                        <select name="field_5"  class="form-control">
                                            <option <?php echo set_select('field_5', "0"); ?> <?php echo isset($paymentSetting->field_5) && $paymentSetting->field_5=="0"?'selected':''?> value="0"><?php echo lang('Inactive'); ?></option>
                                            <option <?php echo set_select('field_5', "1"); ?> <?php echo isset($paymentSetting->field_5) && $paymentSetting->field_5=="1"?'selected':''?> value="1"><?php echo lang('Active'); ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="field_4_v"  class="form-control">
                                            <option <?php echo set_select('field_4_v', "live"); ?> <?php echo isset($paymentSetting->field_4_v) && $paymentSetting->field_4_v=="live"?'selected':''?> value="live"><?php echo lang('Live'); ?></option>
                                            <option <?php echo set_select('field_4_v', "demo"); ?> <?php echo isset($paymentSetting->field_4_v) && $paymentSetting->field_4_v=="demo"?'selected':''?> value="demo"><?php echo lang('Sandbox'); ?></option>
                                        </select>
                                        <?php if (form_error('field_4_v')) { ?>
                                            <div class="alert alert-error txt-uh-21 ir_p_5">
                                                <?php echo form_error('field_4_v'); ?>
                                            </div>
                                        <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_4_key_1" class="form-control" placeholder="Key ID" value="<?php echo isset($paymentSetting->field_4_key_1) && $paymentSetting->field_4_key_1?$paymentSetting->field_4_key_1:set_value('field_4_key_1')?>">
                            <?php if (form_error('field_4_key_1')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_4_key_1'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" onfocus="select();" name="field_4_key_2" class="form-control" placeholder="Key Secret" value="<?php echo isset($paymentSetting->field_4_key_2) && $paymentSetting->field_4_key_2?$paymentSetting->field_4_key_2:set_value('field_4_key_2')?>">
                            <?php if (form_error('field_4_key_2')) { ?>
                                <div class="alert alert-error txt-uh-21 ir_p_5">
                                    <?php echo form_error('field_4_key_2'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
   
</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/payment_setting.js"></script>
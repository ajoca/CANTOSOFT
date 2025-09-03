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
            <?php echo lang('enable_disable'); ?> (<?php echo lang('self_order'); ?>)
        </h3>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url() . 'setting/selfOrderEnableDisable/'.(isset($company) && $company->id?$company->id:''), $arrayName = array('id' => 'update_tax_setting','enctype'=>'multipart/form-data')) ?>
            <div class="box-body">
                <div class="row">
                    <div class="mb-3 col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label> <?php echo lang('enable_disable'); ?>  </label>
                           

                            <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <select tabindex="12" class="form-control select2" name="sos_enable_self_order"
                                    id="sos_enable_self_order">

                                <option <?php echo set_select('sos_enable_self_order',"No")?>
                                    <?= isset($company) && $company->sos_enable_self_order == "No" ? 'selected' : '' ?>
                                    value="No"><?php echo lang('disable'); ?></option>
                                <option <?php echo set_select('sos_enable_self_order',"Yes")?>
                                    <?= isset($company) && $company->sos_enable_self_order == "Yes" ? 'selected' : '' ?>
                                    value="Yes"><?php echo lang('enable'); ?></option>
                            </select>

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                    <i class="fa fa-question fa-2x form_question" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('sos_tooltip'); ?>"></i>
                                </div>
                                        </td>
                                    </tr>
                                </table>
                        </div>
                        <?php if (form_error('sos_enable_self_order')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('sos_enable_self_order'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <?php if(isset($company) && $company->sos_enable_self_order == "Yes"):?>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>setting/tableQrcodeGenerator">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
                <?php endif?>
            </div>
            <?php echo form_close(); ?>
        </div>
 
    </div>

</section>

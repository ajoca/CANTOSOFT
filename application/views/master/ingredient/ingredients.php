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

        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="top-left-header"><?php echo lang('ingredients'); ?> </h2>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('ingredients'); ?>" data-id_name="datatable">
                </div>
                <div class="col-md-offset-2 col-md-4">
                    
                    <div class="btn_list m-right d-flex">
                            <a data-access="upload_ingredient-217" class="btn bg-blue-btn menu_assign_class" href="<?php echo base_url() ?>ingredient/uploadingredients">
                                <i data-feather="upload"></i> <?php echo lang('upload_ingredient'); ?>
                            </a>
                        
                    </div>
                </div>

            </div>
        </section>
        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_6"><?php echo lang('code'); ?></th>
                                <th class="ir_w_15"><?php echo lang('name'); ?></th>
                                <th class="ir_w_10"><?php echo lang('category'); ?></th>
                                <th  class="ir_w_10"><?php echo lang('purchase_unit'); ?></th>
                                <th  class="ir_w_10"><?php echo lang('consumption_unit'); ?></th>
                                <th  class="ir_w_10"><?php echo lang('conversion_rate'); ?></th>
                                <th class="ir_w_12"><?php echo lang('purchase_price'); ?></th>
                                <th class="ir_w_12"><?php echo lang('consumption_unit_cost'); ?></th>
                                <th class="ir_w_8"><?php echo lang('alert_quantity_amount'); ?></th>
                                <th class="ir_w_8"><?php echo lang('added_by'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($ingredients && !empty($ingredients)) {
                                $i = count($ingredients);
                            }
                            foreach ($ingredients as $ingrnts) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($ingrnts->code) ?></td>
                                <td><?php echo escape_output($ingrnts->name) ?></td>
                                <td><?php echo escape_output(categoryName($ingrnts->category_id)); ?></td>
                                <td><?php echo escape_output(unitName($ingrnts->purchase_unit_id)); ?></td>
                                <td><?php echo escape_output(unitName($ingrnts->unit_id)); ?></td>
                                <td><?php echo escape_output(($ingrnts->conversion_rate)); ?></td>
                                <td><?php echo escape_output(getAmtPCustom($ingrnts->purchase_price)) ?></td>
                                <td><?php echo escape_output(getAmtPCustom($ingrnts->consumption_unit_cost)) ?></td>
                                <td><?php echo escape_output(getAmtPCustom($ingrnts->alert_quantity)) ?></td>
                                <td><?php echo escape_output(userName($ingrnts->user_id)); ?></td>

                                <td>
                                    <?php if($ingrnts->is_direct_food==1):?>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>ingredient/addEditIngredient/<?php echo escape_output($this->custom->encrypt_decrypt($ingrnts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>ingredient/deleteIngredient/<?php echo escape_output($this->custom->encrypt_decrypt($ingrnts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                    <?php else:?>
                                    <div class="btn_group_wrap">
                                        <div class="tooltip_custom">
                                            <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('action_tooltip_product'); ?>" data-feather="help-circle"></i>
                                        </div>
                                    </div>
                                    <?php endif?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
   
        
</section>

<div class="modal fade" id="uploadingredentsModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i
                            class="fa fa-2x">×</i></span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square-o ir_color_blue"></i>
                    <?php echo lang('upload_ingredients'); ?></h4>
            </div>
            <div class="modal-body">
                <!-- <form class="form-horizontal" action="<?php echo base_url() ?>Master/ExcelDataAddIngredints" method="post" accept-charset="utf-8"> -->
                <?php echo form_open(base_url() . 'ingredient/ExcelDataAddIngredints', $arrayName = array('id' => 'language', 'class' => 'form-horizontal', 'accept-charset' => 'utf-8')) ?>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo lang('upload_file'); ?><span class="ir_color_red">
                            *</span></label>
                    <div class="col-sm-7">
                        <input type="file" class="form-control" name="userfile" id="userfile" placeholder="Upload file"
                            value="">
                        <div class="callout callout-danger my-2 error-msg customer_err_msg_contnr">
                            <p class="customer_err_msg"></p>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addNewGuest">
                    <i class="fa fa-save"></i> <?php echo lang('upload'); ?> </button>
                <a class="btn btn-primary" href="<?php echo base_url() ?>ingredient/downloadPDF/Ingredient_Upload">
                    <i class="fa fa-save"></i> <?php echo lang('download_sample'); ?></a>
            </div>
        </div>
    </div>
</div>

<?php $this->view('common/footer_js')?>
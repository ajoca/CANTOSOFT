
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
                <h2 class="top-left-header"><?php echo lang('premade_foods'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('premade_foods'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-offset-2 col-md-4">

                <div class="btn_list m-right d-flex">


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
                        <th class="ir_w_22"><?php echo lang('name'); ?></th>
                        <th class="ir_w_16"><?php echo lang('category'); ?></th>
                        <th class="ir_w_12"><?php echo lang('purchase_price'); ?></th>
                        <th class="ir_w_15"><?php echo lang('alert_quantity_amount'); ?></th>
                        <th  class="ir_w_4"><?php echo lang('unit'); ?></th>
                        <th class="ir_w_15"><?php echo lang('added_by'); ?></th>
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
                            <td>
                                <?php echo escape_output(getAmtP($ingrnts->purchase_price)) ?></td>
                            <td><?php echo escape_output(getAmtP($ingrnts->alert_quantity)) ?></td>
                            <td><?php echo escape_output(unitName($ingrnts->unit_id)); ?></td>
                            <td><?php echo escape_output(userName($ingrnts->user_id)); ?></td>

                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>preMadeFood/addEditPreMadeFood/<?php echo escape_output($this->custom->encrypt_decrypt($ingrnts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>preMadeFood/deletePreMadeFood/<?php echo escape_output($this->custom->encrypt_decrypt($ingrnts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
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



<?php $this->view('common/footer_js')?>
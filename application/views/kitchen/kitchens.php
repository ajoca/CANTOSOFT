
<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
    <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="top-left-header"><?php echo lang('kitchens'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('kitchens'); ?>" data-id_name="datatable">
            </div>
            <div>

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
                        <th class="ir_w_10"><?php echo lang('name'); ?></th>
                        <th class="ir_w_8"></th>
                        <th><?php echo lang('categories'); ?></th>
                        <th class="ir_w_10"><?php echo lang('printer'); ?></th>
                        <th class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($kitchens && !empty($kitchens)) {
                        $i = count($kitchens);
                    }
                    foreach ($kitchens as $kitchen) { ?>
                        <tr>
                            <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                            <td><?php echo escape_output($kitchen->name) ?></td>    
                            <td><a target="_blank" href="<?php echo base_url()?>Kitchen/panel/<?php echo d($kitchen->id,1) ?>" class="new-btn d-inline-flex width_151"> <i data-feather="corner-down-right"></i> <?php echo lang('open_kitchen_panel'); ?></a></td>
                            <td><?php echo escape_output($kitchen->categories) ?></td>
                            <td><?php echo escape_output(getPrinter($kitchen->printer_id)) ?></td>

                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Kitchen/addEditKitchen/<?php echo escape_output($this->custom->encrypt_decrypt($kitchen->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Kitchen/deleteKitchen/<?php echo escape_output($this->custom->encrypt_decrypt($kitchen->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
        </div>
    </div>
</section>

<?php $this->view('common/footer_js')?>
<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
            <div class="alert alert-success alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-body">
            <p class="m-0"><i class="icon fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <h3 class="top-left-header"><?php echo lang('roles'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('roles'); ?>" data-id_name="datatable">
            </div>
            <div class="col-sm-12 col-md-4">

            </div>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="datatable" class="table table-responsive">
                    <thead>
                    <tr>
                        <th class="ir_w_1"><?php echo lang('sn'); ?></th>
                        <th class="width_23_p" ><?php echo lang('role_name'); ?></th>
                        <th class="ir_w5_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($roles && !empty($roles)) {
                        $i = count($roles);
                    }
                    foreach ($roles as $usrs) {
                        ?>
                        <tr>
                            <td class="c_center"><?php echo escape_output($i--); ?></td>
                            <td><?php echo escape_output($usrs->role_name); ?></td>

                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-unique" href="<?php echo base_url() ?>Role/addEditRole/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>/copy" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('copy'); ?>">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Role/addEditRole/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Role/deleteRole/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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


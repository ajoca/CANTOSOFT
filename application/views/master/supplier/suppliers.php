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
            <div class="col-md-12">
                <h2 class="top-left-header"><?php echo lang('suppliers'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('suppliers'); ?>" data-id_name="datatable">
            </div>
            <div>

            </div>
        </div>
    </section>


        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_14"><?php echo lang('name'); ?></th>
                                <th class="ir_w_14"><?php echo lang('contact_person'); ?></th>
                                <th class="ir_w_9"><?php echo lang('phone'); ?></th>
                                <th class="ir_w_10"><?php echo lang('email'); ?></th>
                                <th class="ir_w_20"><?php echo lang('address'); ?></th>
                                <th class="ir_w_17"><?php echo lang('description'); ?></th>
                                <th class="ir_w_16"><?php echo lang('added_by'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($suppliers && !empty($suppliers)) {
                                $i = count($suppliers);
                            }
                            foreach ($suppliers as $si) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($si->name) ?></td>
                                <td><?php echo escape_output($si->contact_person) ?></td>
                                <td><?php echo escape_output($si->phone) ?></td>
                                <td><?php echo escape_output($si->email) ?></td>
                                <td><?php echo escape_output($si->address) ?></td>
                                <td><?php if ($si->description != NULL) echo escape_output($si->description) ?></td>
                                <td><?php echo escape_output(userName($si->user_id)); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>supplier/addEditSupplier/<?php echo escape_output($this->custom->encrypt_decrypt($si->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>supplier/deleteSupplier/<?php echo escape_output($this->custom->encrypt_decrypt($si->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
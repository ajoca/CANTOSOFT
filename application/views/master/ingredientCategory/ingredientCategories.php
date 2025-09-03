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
            <h2 class="top-left-header"><?php echo lang('ingredient_categories'); ?> </h2>
            <input type="hidden" class="datatable_name" data-title="<?php echo lang('ingredient_categories'); ?>" data-id_name="datatable">
        </div>
        <div class="col-md-6">

        </div>
    </div>
</section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_23"><?php echo lang('category_name'); ?></th>
                                <th class="ir_w_23"><?php echo lang('description'); ?></th>
                                <th class="ir_w_23"><?php echo lang('added_by'); ?></th>
                                <th class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($ingredientCategories && !empty($ingredientCategories)) {
                                $i = count($ingredientCategories);
                            }
                            foreach ($ingredientCategories as $ic) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($ic->category_name) ?></td>
                                <td><?php echo escape_output($ic->description) ?></td>
                                <td><?php echo escape_output(userName($ic->user_id)); ?></td>

                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>ingredientCategory/addEditIngredientCategory/<?php echo escape_output($this->custom->encrypt_decrypt($ic->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>ingredientCategory/deleteIngredientCategory/<?php echo escape_output($this->custom->encrypt_decrypt($ic->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
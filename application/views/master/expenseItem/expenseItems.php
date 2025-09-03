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
            <div class="col-md-12">
                <h2 class="top-left-header"><?php echo lang('expense_items'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('expense_items'); ?>" data-id_name="datatable">
            </div>
            <div>

            </div>
        </div>
    </section>


        <div class="box-wrapper">
            <div class="table-box">
                
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th  class="ir_w_15 "><?php echo lang('expense_item_name'); ?></th>
                                <th  class="ir_w_20 "><?php echo lang('description'); ?></th>
                                <th class="ir_w_26"><?php echo lang('added_by'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($expenseItems && !empty($expenseItems)) {
                                $i = count($expenseItems);
                            }
                            foreach ($expenseItems as $ei) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($ei->name) ?></td>
                                <td><?php echo escape_output($ei->description) ?></td>
                                <td><?php echo escape_output(userName($ei->user_id)); ?></td>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>expenseItems/addEditExpenseItem/<?php echo escape_output($this->custom->encrypt_decrypt($ei->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>expenseItems/deleteExpenseItem/<?php echo escape_output($this->custom->encrypt_decrypt($ei->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
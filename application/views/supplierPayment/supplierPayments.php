<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<div class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></div>';
    }
    ?>

    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo lang('supplier_due_payments'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('supplier_due_payments'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </section>

    <div class="box-wrapper">
        
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_9"><?php echo lang('date'); ?></th>
                                <th class="ir_w_18"><?php echo lang('supplier'); ?></th>
                                <th class="ir_w_11"><?php echo lang('payment_method'); ?></th>
                                <th class="ir_w_14"><?php echo lang('amount'); ?></th>
                                <th class="ir_w_28"><?php echo lang('note'); ?></th>
                                <th class="ir_w_19"><?php echo lang('added_by'); ?></th>
                                <th class="ir_w_6 not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($supplierPayments && !empty($supplierPayments)) {
                                $i = count($supplierPayments);
                            }
                            foreach ($supplierPayments as $spns) {
                                ?>
                            <tr>
                                <td><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($spns->date))); ?>
                                </td>
                                <td><?php echo escape_output(getSupplierNameById($spns->supplier_id)); ?></td>
                                <td> <?php echo escape_output(getPaymentName($spns->payment_id)) ; ?></td>
                                <td>   <?php echo escape_output(getAmtPCustom($spns->amount)) ?>
                                </td>
                                <td><?php if ($spns->note != NULL) echo escape_output($spns->note) ?></td>
                                <td><?php echo escape_output(userName($spns->user_id)); ?></td>

                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>SupplierPayment/deleteSupplierPayment/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
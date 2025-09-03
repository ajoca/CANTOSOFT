

<section class="main-content-wrapper">
<?php
if ($value =$this->session->flashdata('exception')) {

    echo '<section class="content-header px-0"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-body"><p class="m-0"><i class="m-right fa fa-check"></i>';
    echo escape_output($value);
    echo '</p></div></div></section>';
}
?>

<section class="content-header px-0">
    <div class="row">
        <div class="col-md-6">
            <h2 class="top-left-header"><?php echo lang('customer_due_receives'); ?> </h2>
            <input type="hidden" class="datatable_name" data-title="<?php echo lang('customer_due_receives'); ?>" data-id_name="datatable">
        </div>
        <div class="col-md-6">

        </div>
    </div>
</section>

    <div class="box-wrapper">
        
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_10"><?php echo lang('ref_no'); ?></th>
                                <th class="ir_w_10"><?php echo lang('date'); ?></th>
                                <th class="ir_w_10"><?php echo lang('customer'); ?></th>
                                <th class="ir_w_10"><?php echo lang('amount'); ?></th>
                                <th class="ir_w_10"><?php echo lang('payment_method'); ?></th>
                                <th class="ir_w_28"><?php echo lang('note'); ?></th>
                                <th class="ir_w_19"><?php echo lang('added_by'); ?></th>
                                <th class="ir_w_6 not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customerDueReceives && !empty($customerDueReceives)) {
                                $i = count($customerDueReceives);
                            }
                            foreach ($customerDueReceives as $value) {
                                ?>
                            <tr>
                                <td><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($value->reference_no) ?></td>
                                <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($value->only_date))); ?>
                                </td>
                                <td><?php echo escape_output(getCustomerName($value->customer_id)); ?></td>
                                <td> <?php echo escape_output(getAmtPCustom($value->amount)) ?>
                                </td>
                                <td> <?php echo escape_output((getPaymentName($value->payment_id))) ?>
                                <td><?php if ($value->note != NULL) echo escape_output($value->note) ?></td>
                                <td><?php echo escape_output(userName($value->user_id)); ?></td>

                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Customer_due_receive/deleteCustomerDueReceive/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
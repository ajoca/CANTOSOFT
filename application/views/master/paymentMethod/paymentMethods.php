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
     <?php
    if ($this->session->flashdata('exception_r')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_r'));unset($_SESSION['exception_r']);
        echo '</p></div></div></section>';
    }
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/up_down.css">

    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="top-left-header"><?php echo lang('payment_methods'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('payment_methods'); ?>" data-id_name="datatable">
            </div>
            <div>

            </div>
            <div>
                <a class="btn_list btn bg-blue-btn m-right" href="<?php echo base_url() ?>paymentMethod/sorting">
                    <i data-feather="arrow-down"></i><i data-feather="arrow-up"></i> &nbsp;<?php echo lang('sorting'); ?>
                </a>
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
                                <th class="ir_w_10 "><?php echo lang('payment_method_name'); ?></th>
                                <th  class="ir_w_10"><?php echo lang('description'); ?></th>
                                <th class="ir_w_26"><?php echo lang('added_by'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($paymentMethods && !empty($paymentMethods)) {
                                $i = count($paymentMethods);
                            }
                            foreach ($paymentMethods as $key=>$value) {
                                $key++;
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($key); ?></td>
                                <td><?php echo escape_output($value->name) ?></td>
                                <td><?php echo escape_output($value->description) ?></td>
                                <td><?php echo escape_output(userName($value->user_id)); ?></td>

                                <td>
                                    <?php if($value->id!=1 && $value->id!=5): ?>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>paymentMethod/addEditPaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>paymentMethod/deletePaymentMethod/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                    <?php endif;?>
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
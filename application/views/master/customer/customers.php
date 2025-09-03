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
                <div class="col-md-6">
                    <h2 class="top-left-header"><?php echo lang('customers'); ?> </h2>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('customers'); ?>" data-id_name="datatable">
                </div>
                <div class="col-md-offset-2 col-md-4">
                    <div class="btn_list m-right d-flex">
                            <a data-access="upload_customer-249" class="btn bg-blue-btn menu_assign_class" href="<?php echo base_url() ?>customer/uploadCustomer">
                            <i data-feather="upload"></i> <?php echo lang('upload_customer'); ?>
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
                    <?php $is_loyalty_enable = $this->session->userdata('is_loyalty_enable');?>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_12"><?php echo lang('customer_name'); ?></th>
                                <th class="ir_w_7"><?php echo lang('phone'); ?></th>
                                <th class="ir_w_7"><?php echo lang('email'); ?></th>
                                <th class="ir_w_7"><?php echo lang('dob'); ?></th>
                                <th class="ir_w_7"><?php echo lang('default_discount_t'); ?></th>
                                <th class="ir_w_10"><?php echo lang('address'); ?></th>
                                <th class="ir_w_10"><?php echo lang('current_due'); ?></th>
                                <?php if(isset($is_loyalty_enable) && $is_loyalty_enable=="enable"):?>
                                    <th class="ir_w_10"><?php echo lang('is_loyalty_enable'); ?></th>
                                <?php endif;?>
                                <th class="ir_w_10"><?php echo lang('added_by'); ?></th>
                                <th class="ir_w_1_txt_center"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customers && !empty($customers)) {
                                $i = count($customers);
                            }
                            foreach ($customers as $cust) {
                                $current_due = 0;
                                $redeemed_point = 0;
                                $available_point = 0;
                                if($cust->id!=1){
                                    $current_due = getCustomerDue($cust->id);
                                    if(isset($is_loyalty_enable) && $is_loyalty_enable=="enable"):
                                        $return_data = getTotalLoyaltyPoint($cust->id,$this->session->userdata('outlet_id'));
                                        $redeemed_point = $return_data[0];
                                        $available_point = $return_data[1];
                                    endif;
                                }
                                $added = userName($cust->user_id);
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($cust->name) ?></td>
                                <td><?php echo escape_output($cust->phone) ?></td>
                                <td><?php echo escape_output($cust->email) ?></td>
                                <td><?php if($cust->date_of_birth != '1970-01-01'){ echo escape_output($cust->date_of_birth); }?></td>
                                <td><?php echo escape_output($cust->default_discount) ?></td>
                                <td><?php echo escape_output($cust->address) ?></td>
                                <td><?php echo escape_output(getAmtPCustom($current_due)) ?></td>
                                <?php if(isset($is_loyalty_enable) && $is_loyalty_enable=="enable"):?>
                                    <td><?php echo escape_output(($available_point)) ?></td>
                                <?php endif;?>
                                <td><?php echo $added?$added:"Online"; ?></td>

                                <td>
                                <?php if ($cust->name != "Walk-in Customer") { ?>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>customer/addEditCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>customer/deleteCustomer/<?php echo escape_output($this->custom->encrypt_decrypt($cust->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                    <?php } ?>
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
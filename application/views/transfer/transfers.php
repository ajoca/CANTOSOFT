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
             <?php
             if ($this->session->flashdata('exception_error')) {

                 echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p><i class="icon fa fa-times"></i>';
                 echo escape_output($this->session->flashdata('exception_error'));unset($_SESSION['exception_error']);
                 echo '</p></div></div></section>';
             }
        $plusSVG= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-50 font-small-4"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

             ?>
            <section class="content-header">
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <h2 class="top-left-header"><?php echo lang('transfers'); ?></h2>
                        <input type="hidden" class="datatable_name" data-title="<?php echo lang('transfers'); ?>" data-id_name="datatable">
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
                                 <th class="ir_w_11"><?php echo lang('ref_no'); ?></th>
                                 <th class="ir_w_11 display_none"><?php echo lang('transfer_type'); ?></th>
                                 <th class="ir_w_8"><?php echo lang('date'); ?></th>
                                 <th class="ir_w_8"><?php echo lang('to_outlet'); ?></th>
                                 <th class="ir_w_12"><?php echo lang('status'); ?></th>
                                 <th class="ir_w_8"><?php echo lang('received_date'); ?></th>
                                 <th class="ir_w_12"><?php echo lang('added_by'); ?></th>
                                 <th class="ir_w5_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                            if ($transfers && !empty($transfers)) {
                                $i = count($transfers);
                            }
                             $outlet_id = $this->session->userdata('outlet_id');
                            foreach ($transfers as $prchs) {
                                $new_file = '';
                                ?>
                             <tr>
                                 <td><?php echo escape_output($i--); ?>
                                     <?php
                                     if($prchs->status==3 && $outlet_id!=$prchs->from_outlet_id): ?>
                                         <img src="<?=base_url()?>assets/new-transfer.gif">
                                         <?php
                                     endif;
                                     ?>
                                 </td>
                                 <td><?php echo escape_output($prchs->reference_no) ?></td>
                                 <td class="display_none">
                                     <?php
                                     if($prchs->transfer_type==1){
                                         echo escape_output(lang('ingredient'));
                                     }elseif($prchs->transfer_type==2){
                                         echo escape_output(lang('food_menu'));
                                     }?>
                                     </td>
                                 <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($prchs->date))); ?>
                                 </td>
                                 <td><?php echo escape_output(getOutletNameById($prchs->to_outlet_id)); ?></td>
                                 <td><?php
                                        if($prchs->status==1){
                                            echo escape_output("Received");
                                        }elseif($prchs->status==2){
                                            echo escape_output("Draft");
                                        }elseif($prchs->status==3){
                                            echo escape_output("Sent");
                                        }
                                     ?></td>
                                 <td><?php echo isset($prchs->received_date)?escape_output(date($this->session->userdata('date_format'), strtotime($prchs->received_date))):''; ?>
                                 <td><?php echo escape_output(userName($prchs->user_id)); ?></td>

                                 <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-cyan" href="<?php echo base_url() ?>Transfer/transferDetails/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('view_details'); ?>">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Transfer/addEditTransfer/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Transfer/deleteTransfer/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
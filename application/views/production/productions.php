


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
                    <h3 class="top-left-header"><?php echo lang('productions'); ?> </h3>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('productions'); ?>" data-id_name="datatable">
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
                                 <th class="ir_w_8"><?php echo lang('date'); ?></th>
                                 <th class="ir_w_8"><?php echo lang('status'); ?></th>
                                 <th class="ir_w_12"><?php echo lang('added_by'); ?></th>
                                 <th class="ir_w5_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                            if ($productions && !empty($productions)) {
                                $i = count($productions);
                            }
                            foreach ($productions as $prchs) {
                                ?>
                             <tr>
                                 <td><?php echo escape_output($i--); ?></td>
                                 <td><?php echo escape_output($prchs->reference_no) ?></td>
                                 <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($prchs->date))); ?> </td>
                                 <td><?php echo ($prchs->status==1)?lang('Final'):lang('Draft'); ?></td>
                                 <td><?php echo escape_output(userName($prchs->user_id)); ?></td>

                                 <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-cyan" href="<?php echo base_url() ?>Production/productionDetails/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('view_details'); ?>">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Production/addEditProduction/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Production/deleteProduction/<?php echo escape_output($this->custom->encrypt_decrypt($prchs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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


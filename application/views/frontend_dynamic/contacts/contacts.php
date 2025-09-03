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
                <h2 class="top-left-header"><?php echo lang('contacts'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('contacts'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-offset-4 col-md-2">

            </div>
        </div>
    </section>


        <div class="box-wrapper">
            
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <th class="ir_w_25"><?php echo lang('full_name'); ?></th>
                                <th class="ir_w_16"><?php echo lang('email'); ?></th>
                                <th class="ir_w_16"><?php echo lang('subject'); ?></th>
                                <th class="ir_w_16"><?php echo lang('message'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($contacts && !empty($contacts)) {
                                $i = count($contacts);
                            }
                            foreach ($contacts as $contact) {
                                ?>
                            <tr>
                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($contact->first_name . ' ' . $contact->last_name) ?></td>
                                <td><?php echo escape_output($contact->email) ?></td>
                                <td><?php echo escape_output($contact->subject) ?></td>
                                <td><?php echo escape_output($contact->message) ?></td>

                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Frontend/deleteContact/<?php echo escape_output($this->custom->encrypt_decrypt($contact->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
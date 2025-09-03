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
        if ($this->session->flashdata('exception_r')) {

            echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p><i class="icon fa fa-times"></i>';
            echo escape_output($this->session->flashdata('exception_r'));unset($_SESSION['exception_r']);
            echo '</p></div></div></section>';
        }
        ?>

        <section class="content-header">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <h2 class="top-left-header"><?php echo lang('Printers'); ?></h2>
                </div>
                <div class="col-md-offset-4 col-md-2">

                </div>
            </div>
        </section>



        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('Printer'); ?>" data-id_name="datatable">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="width_1_p"><?php echo lang('sn'); ?></th>
                                <?php if(isLMni()):?>
                                <th class="width_15_p" ><?php echo lang('outlet'); ?></th>
                                <?php endif;?>
                                <th class="width_15_p" ><?php echo lang('title'); ?></th>
                                <th class="width_10_p" ><?php echo lang('printing_choice'); ?></th>
                                <th class="width_10_p" ><?php echo lang('print_format'); ?></th>
                                <th class="width_10_p" ><?php echo lang('Printer'); ?> <?php echo lang('type'); ?> </th>
                                <th class="width_10_p" ><?php echo lang('printer_ip_address'); ?></th>
                                <th class="width_10_p" ><?php echo lang('path'); ?></th>
                                <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($printer_ && !empty($printer_)) {
                                $i = count($printer_);
                            }
                            foreach ($printer_ as $usrs) {
                                    ?>
                                    <tr>
                                        <td class="c_center"><?php echo escape_output($i--); ?></td>
                                        <?php if(isLMni()):?>
                                        <td><?php echo escape_output(getOutletNameById($usrs->outlet_id)); ?></td>
                                        <?php endif;?>
                                        <td><?php echo escape_output($usrs->title); ?></td>
                                        <td><?php echo escape_output($usrs->printing_choice); ?></td>
                                        <td><?php echo escape_output($usrs->print_format); ?></td>
                                        <td><?php echo escape_output($usrs->type); ?></td>
                                        <td><?php echo escape_output($usrs->printer_ip_address); ?></td>
                                        <td><?php echo escape_output($usrs->path); ?></td>

                                        <td>
                                            <div class="btn_group_wrap">
                                                <a class="btn btn-warning" href="<?php echo base_url() ?>printer/addEditPrinter/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-original-title="<?php echo lang('edit'); ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a class="delete btn btn-danger" href="<?php echo base_url() ?>printer/deletePrinter/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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

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
            <div class="col-sm-12">
                <h2 class="top-left-header"><?php echo lang('counters'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('counters'); ?>" data-id_name="datatable">
            </div>
            <div>

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
                            <th class="w-5"> <?php echo lang('sn'); ?></th>
                            <?php if(isLMni()):?>         
                                <th class="w-15"><?php echo lang('outlet'); ?></th>
                             <?php endif;?>
                            <th class="w-20"><?php echo lang('counter_name'); ?></th>
                            <th class="w-15"><?php echo lang('invoice_printer'); ?></th>
                            <th class="w-15"><?php echo lang('bill_printer'); ?></th>
                            <th class="w-20"><?php echo lang('description'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th> 
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($counters && !empty($counters)) {
                            $i = count($counters);
                        }
                        foreach ($counters as $value) {
                            ?>
                        <tr>
                            
                            <td class="text-center"><?php echo escape_output($i--); ?></td>
                            <?php if(isLMni()):?>     
                                <td><?php echo escape_output($value->outlet_name) ?></td>      
                             <?php endif;?>
                             <td><?php echo escape_output($value->counter_name) ?></td>
                            <td><?php echo escape_output($value->invoice_printer) ?></td>
                            <td><?php echo escape_output($value->bill_printer) ?></td>
                            <td><?php echo escape_output($value->description) ?></td>
                            <td><?php echo escape_output($value->added_by) ?></td> 

                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Counter/addEditCounter/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Counter/deleteCounter/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
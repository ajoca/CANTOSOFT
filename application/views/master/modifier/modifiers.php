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
        if ($this->session->flashdata('exception_err')) {

            echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <p><i class="icon fa fa-times"></i>';
            echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
            echo '</p></div></div></section>';
        }
        ?>

        <section class="content-header">
            <div class="row">
                <div class="col-md-2">
                    <h2 class="top-left-header"><?php echo lang('modifiers'); ?> </h2>
                    <input type="hidden" class="datatable_name" data-title="<?php echo lang('modifiers'); ?>" data-id_name="datatable">
                </div> 
                <div class="col-md-offset-8 col-md-2">

                </div> 
            </div> 
        </section> 


        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box"> 
                <!-- /.box-header -->
                <div class="table-responsive"> 
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"><?php echo lang('sn'); ?></th>
                                <th class="ir_w_25"><?php echo lang('name'); ?></th>
                                <th class="ir_w_13"><?php echo lang('price'); ?></th>
                                <th class="ir_w_13"><?php echo lang('description'); ?></th>
                                <th class="ir_w_13"><?php echo lang('total'); ?> <?php echo lang('ingredients'); ?></th>
                                <th class="ir_w_13"><?php echo lang('total'); ?> <?php echo lang('cost'); ?></th>
                                <th class="ir_w_18"><?php echo lang('added_by'); ?></th>
                                <th  class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($modifiers && !empty($modifiers)) {
                                $i = count($modifiers);
                            }
                            foreach ($modifiers as $fdmns) {
                                ?>                       
                                <tr> 
                                    <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                    <td><?php echo escape_output($fdmns->name) ?></td>
                                    <td><?php echo escape_output(getAmtPCustom($fdmns->price)) ?></td>
                                    <td><?php echo escape_output($fdmns->description) ?></td>
                                    <td class="ir_txt_center"><?php echo count(modifierIngredients($fdmns->id)); ?></td>
                                    <td><?php echo escape_output(getAmtPCustom($fdmns->total_cost)) ?></td>
                                    <td><?php echo escape_output(userName($fdmns->user_id)); ?></td>

                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-cyan" href="<?php echo base_url() ?>modifier/modifierDetails/<?php echo escape_output($this->custom->encrypt_decrypt($fdmns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('view_details'); ?>">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>modifier/addEditModifier/<?php echo escape_output($this->custom->encrypt_decrypt($fdmns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>modifier/deleteModifier/<?php echo escape_output($this->custom->encrypt_decrypt($fdmns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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

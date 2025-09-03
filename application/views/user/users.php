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
     
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="top-left-header"><?php echo lang('users'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('users'); ?>" data-id_name="datatable">
            </div>
            <div>

            </div>
        </div>
    </section>


        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <?php
                $language_manifesto = str_rot13($this->session->userdata('language_manifesto'));
                ?>
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
                                    <th class="ir_w_12"><?php echo lang('company'); ?></th>
                                <?php
                                    endif;
                                ?>
                                <th class="ir_w_23"><?php echo lang('name'); ?></th>
                                <th class="ir_w_8"><?php echo lang('designation'); ?></th>
                                <th class="ir_w_8"><?php echo lang('email'); ?></th>
                                <th class="ir_w_7"><?php echo lang('status'); ?></th>
                                <th class="ir_w_20"><?php echo lang('kitchens'); ?></th>
                                <th class="ir_w_20 <?=isset($language_manifesto) && $language_manifesto!="eriutoeri"?'txt_11':''?>"><?php echo lang('outlets'); ?></th>
                                <th class="ir_w_20"><?php echo lang('role'); ?></th>
                                <th class="ir_w_1 ir_txt_center not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($users && !empty($users)) {
                                $i = count($users);
                            }
                            foreach ($users as $usrs) {
                                if ($usrs->id != $this->session->userdata['user_id']):
                                        $company = getCompanyInfoById($usrs->company_id);
                                    ?>
                            <tr>

                                <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                
                                    <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
                                            <td><?php echo escape_output($company->business_name) ?></td>
                                        <?php
                                    endif;
                                    ?>
                                    <td><?php echo escape_output($usrs->full_name) ?></td>
                                <td><?php echo escape_output($usrs->designation) ?></td>
                                <td><?php echo escape_output($usrs->email_address) ?></td>
                                <td><?php echo escape_output($usrs->active_status) ?></td>
                                <td><?php echo getKitchens($usrs->kitchens); ?></td>
                                <td class="<?=isset($language_manifesto) && $language_manifesto!="eriutoeri"?'txt_11':''?>"><?php echo getOutlets($usrs->outlets); ?></td>
                                <td><?php echo getRole($usrs->role_id); ?></td>

                                <td>
                                    <div class="btn_group_wrap">

                                        <?php if ($usrs->role != 'Admin' && $usrs->active_status == 'Active') { ?>
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>User/deactivateUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('deactivate'); ?>">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>User/activateUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('activate'); ?>">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        <?php } ?>

                                        
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>User/addEditUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>User/deleteUser/<?php echo escape_output($this->custom->encrypt_decrypt($usrs->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                endif;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>


<?php $this->view('common/footer_js')?>

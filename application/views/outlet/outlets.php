<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>

    <?php
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div><div></section>';
    }
    ?>

    <?php
    if ($this->session->flashdata('exception_2')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_2'));unset($_SESSION['exception_2']);
        echo '</p></div><div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <h3 class="top-left-header">
                    <?php
                    $data_c = getLanguageManifesto();
                    if(str_rot13($data_c[0])=="eriutoeri"){
                        echo lang('outlets');
                    }else if(str_rot13($data_c[0])=="fgjgldkfg"){
                        echo lang('outlet_setting');
                    }

                    ?></h3>
            </div>
            <div class="col-sm-12 col-md-4">
                <?php
                if(isServiceAccessOnly('sGmsJaFJE')):
                if(checkCreatePermissionOutlet()):
                        ?>
                            <a class="bg-blue-btn btn" href="<?php echo base_url() ?>Outlet/addEditOutlet">
                                <i class="m-right" data-feather="plus"></i> <?php echo lang('add_outlet'); ?>
                            </a>
                        <?php
                    endif;
                else:
                ?>
                    <a class="new-btn btn" href="<?php echo base_url() ?>Outlet/addEditOutlet">
                        <i class="m-right" data-feather="plus"></i> <?php echo lang('add_outlet'); ?>
                    </a>

                <?php
                endif;
                ?>
            </div>
        </div>
    </section>

    <div class="row mt-4">
        <?php
        foreach ($outlets as $value) {
            ?>
            <div class="col-sm-12 mb-3 col-md-4 col-lg-4 col-xl-4 <?php echo isset($value->active_status) && $value->active_status=="inactive"?'txt_inactive':''?>">
                <div class="outlet-box">
                    <img src="<?php echo base_url();?>assets/media/outlet_icon.png" alt="outlet-image">
                    <h3 class="title"><?php echo escape_output($value->outlet_name); ?></h3>
                    <?php
                    if(str_rot13($data_c[0])=="eriutoeri") {
                        ?>
                        <p class="outlet_code"><?php echo lang('outlet_code'); ?>
                            : <?php echo escape_output($value->outlet_code); ?></p>
                        <?php
                    }
                    ?>
                    <h4 class="outlet_address"><i data-feather="map-pin"></i> <?php echo lang('address'); ?>: <?php echo escape_output($value->address); ?> </h4>
                    <h4 class="outlet_phone"><i data-feather="phone"></i> <?php echo lang('phone'); ?>: <?php echo escape_output($value->phone); ?> </h4>
                    <h4 class="outlet_phone"><i data-feather="mail"></i> <?php echo lang('email'); ?>: <?php echo escape_output($value->email); ?> </h4>
                    <div class="btn_box">
                        <a class="action-btn bg-blue-btn <?php echo isset($value->active_status) && $value->active_status=="inactive"?'txt_inactive_btn':''?>" href="<?php echo base_url(); ?>Outlet/setOutletSession/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                            <i data-feather="corner-down-right"></i>
                            <?php echo lang('enter'); ?>
                        </a>

                        <a class="action-btn bg-blue-btn <?php echo isset($value->active_status) && $value->active_status=="inactive"?'visible_txt':''?>" href="<?php echo base_url() ?>Outlet/addEditOutlet/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                            <i data-feather="edit"></i>
                            <?php echo lang('edit'); ?>
                        </a>
        
                        <?php if($value->id!=1):?>
                        <a class="action-btn delete delete-btn" href="<?php echo base_url() ?>Outlet/deleteOutlet/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>">
                            <i data-feather="trash-2"></i>
                            <?php echo lang('delete'); ?>
                        </a>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php
        }?>
    </div>
</section>
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

                echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
                <button type="button" class="btn-close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div class="alert-body"><p><i class="m-right fa fa-times"></i>';
                echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
                echo '</p></div></div></section>';
            }
            ?>


            <section class="content-header">
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <h2 class="top-left-header"><?php echo lang('promotions'); ?> </h2>
                        <input type="hidden" class="datatable_name" data-title="<?php echo lang('promotions'); ?>" data-id_name="datatable">
                    </div>
                    <div class="col-sm-12 col-md-4">

                    </div>
                </div>
            </section>

            <div class="box-wrapper">
                <div class="table-box">
                    <!-- /.box-header -->
                    <div class="table-responsive">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                                    <th class="ir_w_11"><?php echo lang('title'); ?></th>
                                    <th class="ir_w_11"><?php echo lang('type'); ?></th>
                                    <th class="ir_w_8"><?php echo lang('start_date'); ?></th>
                                    <th class="ir_w_8"><?php echo lang('end_date'); ?></th>
                                    <th><?php echo lang('food_menu'); ?></th>
                                    <th class="ir_w_9"><?php echo lang('discount'); ?></th>
                                    <th class="ir_w_9"><?php echo lang('status'); ?></th>
                                    <th class="ir_w_12"><?php echo lang('added_by'); ?></th>
                                    <th class="ir_w_6 not-export-col"><?php echo lang('actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($promotions && !empty($promotions)) {
                                    $i = count($promotions);
                                }
                                foreach ($promotions as $wsts) {
                                    ?>
                                <tr>
                                    <td class="ir_txt_center"><?php echo escape_output($i--); ?></td>
                                    <td><?php echo escape_output($wsts->title) ?></td>
                                    <td><?php echo escape_output($wsts->type==1?'Discount':'Free Item') ?></td>
                                    <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($wsts->start_date))); ?></td>
                                    <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($wsts->end_date))); ?></td>
                                    <td>
                                                <?php if($wsts->type==1):
                                                    echo getFoodMenuNameById($wsts->food_menu_id)."(".getFoodMenuCodeById($wsts->food_menu_id).")";
                                                else:
                                                    echo "<b>Buy: </b>".getFoodMenuNameById($wsts->food_menu_id)."(".getFoodMenuCodeById($wsts->food_menu_id).") - ".$wsts->qty."(qty)";
                                                    echo "<br><b>Get: </b>".getFoodMenuNameById($wsts->get_food_menu_id)."(".getFoodMenuCodeById($wsts->get_food_menu_id).") - ".$wsts->get_qty."(qty)";
                                                    endif;?>
                                    </td>
                                    <?php if($wsts->type==1):?>
                                    <td><?php echo escape_output(getDiscountSymbol($wsts->discount)).(isset($wsts->discount) && $wsts->discount?$wsts->discount:0) ?></td>
                                        <?php else:?>
                                        <td>-</td>
                                        <?php endif;?>
                                    <td><?php echo escape_output($wsts->status==1?lang('Active'):lang('Inactive')) ?></td>
                                    <td><?php echo escape_output(userName($wsts->user_id)); ?></td>

                                    <td>
                                        <div class="btn_group_wrap">
                                            <a class="btn btn-warning" href="<?php echo base_url() ?>Promotion/addEditPromotion/<?php echo escape_output($this->custom->encrypt_decrypt($wsts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="<?php echo lang('edit'); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="delete btn btn-danger" href="<?php echo base_url() ?>Promotion/deletePromotion/<?php echo escape_output($this->custom->encrypt_decrypt($wsts->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
 <!-- DataTables -->

 <?php $this->view('common/footer_js')?>
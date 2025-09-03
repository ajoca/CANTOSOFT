
<section class="main-content-wrapper">

    <?php
    if ($value =$this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p class="m-0"><i class="m-right fa fa-check"></i>';
        echo escape_output($value);
        echo '</p></div></div></section>';
    }
    ?>


    <section class="content-header px-0">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo lang('attendances'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('attendances'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-6">

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
                                <th class="ir_w_11"><?php echo lang('ref_no'); ?></th>
                                <th class="ir_w_9"><?php echo lang('date'); ?></th>
                                <th class="ir_w_18"><?php echo lang('employee'); ?></th>
                                <th class="ir_w_10"><?php echo lang('in_time'); ?></th>
                                <th class="ir_w_10"><?php echo lang('out_time'); ?></th>
                                <th class="ir_w_15"><?php echo lang('update_time'); ?></th>
                                <th class="ir_w_14"><?php echo lang('time_count'); ?></th>
                                <th class="ir_w_15"><?php echo lang('note'); ?></th>
                                <th class="ir_w_29"><?php echo lang('added_by'); ?></th>
                                <th class="ir_w_6 not-export-col"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($attendances && !empty($attendances)) {
                                $i = count($attendances); 
                            foreach ($attendances as $value) {
                                ?>
                            <tr>
                                <td><?php echo escape_output($i--); ?></td>
                                <td><?php echo escape_output($value->reference_no) ?></td>
                                <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($value->date))); ?>
                                </td>
                                <td><?php echo escape_output(employeeName($value->employee_id)); ?></td>
                                <td><?php echo escape_output($value->in_time) ?></td>
                                <td>
                                    <?php 
                                        if($value->out_time == '00:00:00'){ 
                                             echo lang('n_a').'<br>';;
                                        }else{ 
                                            echo escape_output($value->out_time);
                                        } 
                                        ?>
                                </td>
                                <td>
                                    <?php 
                                            echo '<a href="'. base_url().'Attendance/addEditAttendance/'. $value->id .'">'.lang('update_time').'</a>';
                                        ?>
                                </td>
                                <td>
                                    <?php  
                                        if($value->out_time == '00:00:00'){ 
                                            echo lang('n_a');
                                        }else{
                                            $get_hour = getTotalHour($value->out_time,$value->in_time);
                                            echo escape_output(isset($get_hour) && $get_hour?$get_hour:'0')." ".lang('hour_s');
                                        }

                                        ?>
                                </td>
                                <td><?php if ($value->note != NULL) echo escape_output($value->note) ?></td>
                                <td><?php echo userName($value->user_id); ?></td>

                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Attendance/deleteAttendance/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            } }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        
    </div>
</section>

<?php $this->view('common/footer_js')?>
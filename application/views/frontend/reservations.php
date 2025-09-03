<?php
$company_info      = getMainCompany();
$reservation_times = isset($company_info->reservation_times) && $company_info->reservation_times ? json_decode($company_info->reservation_times) : '';
$reservations      = getAllOutlestByAssignFood();
$online_selected_outlet = $this->session->userdata('online_selected_outlet');
$outlet_details = getOutletById($online_selected_outlet);
?>



<div>
  <div class="contact-wrapper">
    <div class="">
      <div class="section section-padding">
        <div class="container">

          <div class="contact-info">

            <div class="row d-flex justify-content-between">
              <div class="col-xl-6">
              <?php
                      if ($this->session->flashdata('exception')) {

                          echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          <div class="alert-body"><p class="p_msg"><i class="m-right fa fa-check"></i>';
                          echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
                          echo '</p></div></div></section>';
                      }
                    ?>

                <div class="section-title-wrap">

               

                  <h2 class="title"><?php echo lang('Reservations'); ?></h2>
                </div>
                <span id="errorMsgShow" class="d-none text-danger my-2"></span>
                <?php
                $attributes = ['id' => 'reservations', 'class' => 'mt-3'];
                echo form_open(base_url('reservation'), $attributes); ?>

                <div class="row">

                  <div class="form-group col-lg-12">
                  <?php
                        if(str_rot13($company_info->language_manifesto)=="eriutoeri"):?>
                    <select name="outlet_id" id="outlet_id" class="form-control select2">
                      <option value=""><?php echo lang('Select_Outlet'); ?></option>
                      <?php
                      if ($reservations) {
                        foreach ($reservations as $reser) {
                      ?>
                          <option value="<?php echo $reser->id; ?>"><?php echo $reser->outlet_name; ?></option>
                      <?php
                        }
                      } ?>
                    </select>
                  <?php else:?>
                    <input type="hidden" name="outlet_id" id="outlet_id" value="1">
                    <?php endif;?>
                    </div>
                  <div class="form-group col-lg-6">
                    <input type="text" placeholder="<?php echo lang('First_Name'); ?> *" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name') ?>">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="text" placeholder="<?php echo lang('Last_Name'); ?> *" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name') ?>">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="text" placeholder="<?php echo lang('phone'); ?> *" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone') ?>">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="text" placeholder="<?php echo lang('Number_of_People'); ?>" class="form-control" name="no_of_people" id="no_of_people" value="<?php echo set_value('no_of_people') ?>">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="date" placeholder="<?php echo lang('date'); ?>" class="form-control" name="date" id="date" value="<?php echo set_value('date') ?>">
                  </div>
                  <div class="form-group col-lg-6">
                        <select name="reservation_type"  id="reservation_type" class="form-control select2">
                                    <option value=""><?php echo lang('select_reservation_type'); ?></option>
                                    <option value="Regular Booking"><?php echo lang('Regular_Booking'); ?></option>
                                    <option value="Dinner Booking"><?php echo lang('Dinner_Booking'); ?></option>
                                    <option value="Birthday Dinner"><?php echo lang('Birthday_Dinner'); ?></option>
                                    <option value="Birthday Party"><?php echo lang('Birthday_Party'); ?></option>
                                    <option value="Others">Others</option>
                                </select>
                  </div>
                  <div class="form-group col-lg-12">
                    <textarea name="special_request" class="form-control" placeholder="<?php echo lang('special_requrest_write'); ?>" id="special_request" rows="8"><?php echo set_value('special_request') ?></textarea>
                  </div>
                </div>
                <button type="submit" name="submit" value="submit" class="btn-custom primary"><?php echo lang('Reserve_Now'); ?><i class="fa fa-caret-right"></i></button>
                <?php echo form_close(); ?>
              </div>
              <div class="col-xl-5">
                <div class="ct-info-box">
                  <div class="ct-info-body">
                    <h5 class="m-0"><?php echo lang('address'); ?></h5>
                    <span><?php echo isset($outlet_details->address) && $outlet_details->address ? $outlet_details->address : '' ?></span>
                  </div>
                  <div class="ct-info-body">
                    <h5 class="m-0"><?php echo lang('Opening_Hours'); ?></h5>
                    <?php
                    if ($reservation_times) { 
                      foreach ($reservation_times as $time) {
                        if($time->status):
                    ?>
                        <span><span><?php echo $time->counter_name ?>:</span><?php echo $time->start_time ?> -<?php echo $time->end_time ?></span>
                    <?php
                      endif;
                      }
                    } ?>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
   <div class="section-map pb-0">
    <div class="ct-contact-map-wrapper">
      <div id="contactPageMap" class="ct-contact-map">
        <iframe src="<?= escape_output($company_info->google_map) ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</div>
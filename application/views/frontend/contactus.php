<?php
$company_info      = getMainCompany();
$reservation_times = isset($company_info->reservation_times) && $company_info->reservation_times ? json_decode($company_info->reservation_times) : '';
$online_selected_outlet = $this->session->userdata('online_selected_outlet');
$outlet_details = getOutletById($online_selected_outlet);
?>

<div class="contact-wrapper contact-page">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 d-flex flex-column gap60px">
        <div class="d-flex flex-column gap30px">
          <div class="section-title-wrap d-flex flex-column gap16px">
            <h2 class="title"><?php echo lang('get_in'); ?> <span><?php echo lang('touch'); ?></span> </h2>
            <p class="subtitle"><?php echo isset($company_info->contact_us_des) && $company_info->contact_us_des ? $company_info->contact_us_des : '' ?></p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.3431 23.125C27.0675 17.2807 26.5993 18.0098 26.7066 17.8575C28.0626 15.9449 28.7793 13.6939 28.7793 11.3477C28.7793 5.12559 23.7302 0 17.5 0C11.2901 0 6.2207 5.11547 6.2207 11.3477C6.2207 13.6924 6.95242 16.0023 8.35283 17.9406L11.6568 23.125C8.12431 23.6679 2.11914 25.2856 2.11914 28.8477C2.11914 30.1461 2.96666 31.9966 7.00424 33.4386C9.82352 34.4455 13.5509 35 17.5 35C24.8845 35 32.8809 32.917 32.8809 28.8477C32.8809 25.285 26.8827 23.669 23.3431 23.125ZM10.0658 16.8126C10.0546 16.795 10.0428 16.7778 10.0305 16.7608C8.86519 15.1577 8.27148 13.2577 8.27148 11.3477C8.27148 6.21947 12.4008 2.05078 17.5 2.05078C22.5886 2.05078 26.7285 6.22132 26.7285 11.3477C26.7285 13.2608 26.146 15.0963 25.0437 16.6572C24.945 16.7875 25.4603 15.9869 17.5 28.4778L10.0658 16.8126ZM17.5 32.9492C9.434 32.9492 4.16992 30.5783 4.16992 28.8477C4.16992 27.6845 6.87477 25.7718 12.8685 25.0263L16.6353 30.9369C16.7279 31.0822 16.8557 31.2019 17.0068 31.2848C17.1579 31.3678 17.3275 31.4112 17.4999 31.4112C17.6723 31.4112 17.8419 31.3678 17.9931 31.2848C18.1442 31.2019 18.272 31.0822 18.3646 30.9369L22.1313 25.0263C28.1252 25.7718 30.8301 27.6845 30.8301 28.8477C30.8301 30.5636 25.6134 32.9492 17.5 32.9492Z" fill="#2D2C2B" />
                    <path d="M17.5 6.2207C14.673 6.2207 12.373 8.52065 12.373 11.3477C12.373 14.1747 14.673 16.4746 17.5 16.4746C20.327 16.4746 22.627 14.1747 22.627 11.3477C22.627 8.52065 20.327 6.2207 17.5 6.2207ZM17.5 14.4238C15.8038 14.4238 14.4238 13.0439 14.4238 11.3477C14.4238 9.65146 15.8038 8.27148 17.5 8.27148C19.1962 8.27148 20.5762 9.65146 20.5762 11.3477C20.5762 13.0439 19.1962 14.4238 17.5 14.4238Z" fill="#2D2C2B" />
                  </svg>
                  <h5 class="card-title"><?php echo lang('location'); ?></h5>
                  <p class="card-text"><?php echo isset($outlet_details->address) && $outlet_details->address ? $outlet_details->address : '' ?></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.0054 0.530304V2.94085C22.3897 2.94085 24.6233 3.54349 26.7064 4.74876C28.689 5.92892 30.2701 7.51084 31.4497 9.49452C32.6544 11.5786 33.2567 13.8134 33.2567 16.1989H35.666C35.666 13.3614 34.9507 10.7249 33.5202 8.28925C32.1399 5.92892 30.2701 4.05824 27.911 2.6772C25.4766 1.24593 22.8414 0.530304 20.0054 0.530304ZM7.54471 4.14612C6.86709 4.14612 6.27731 4.35956 5.77537 4.78642L1.89787 8.74123L2.0108 8.6659C1.38337 9.1932 0.969272 9.84606 0.768495 10.6245C0.592816 11.4029 0.64301 12.1562 0.919078 12.8844C1.6218 14.8429 2.56294 16.8517 3.7425 18.9107C5.39891 21.7481 7.36903 24.2968 9.65287 26.5567C13.317 30.2478 17.8722 33.1606 23.3182 35.2949H23.3559C24.0837 35.546 24.8115 35.5962 25.5393 35.4456C26.2922 35.2949 26.9573 34.9685 27.5346 34.4663L31.3368 30.6621C31.8387 30.1599 32.0897 29.5447 32.0897 28.8166C32.0897 28.0633 31.8387 27.4355 31.3368 26.9333L26.4052 21.9616C25.9032 21.4594 25.2758 21.2083 24.5229 21.2083C23.77 21.2083 23.1426 21.4594 22.6406 21.9616L20.2689 24.3721C18.3616 23.4682 16.7052 22.3508 15.2997 21.0199C13.8943 19.664 12.7775 18.0193 11.9493 16.0859L14.3586 13.6753C14.8856 13.1229 15.1491 12.47 15.1491 11.7167C15.1491 10.9383 14.848 10.3106 14.2456 9.8335L14.3586 9.9465L9.31406 4.78642C8.81212 4.35956 8.22233 4.14612 7.54471 4.14612ZM20.0054 5.3514V7.76194C21.5363 7.76194 22.9418 8.13859 24.2217 8.89189C25.5268 9.64518 26.5558 10.6747 27.3087 11.9804C28.0616 13.261 28.4381 14.6672 28.4381 16.1989H30.8474C30.8474 14.2403 30.358 12.4198 29.3792 10.7375C28.4004 9.10532 27.0954 7.79961 25.464 6.82032C23.7825 5.84104 21.963 5.3514 20.0054 5.3514ZM7.54471 6.55667C7.62 6.55667 7.70784 6.59433 7.80823 6.66966L12.7398 11.7167C12.7649 11.8172 12.7398 11.9051 12.6645 11.9804L9.08819 15.5209L9.3517 16.2742L9.8411 17.3288C10.2427 18.1825 10.7069 19.0112 11.234 19.8147C11.9618 20.9446 12.7649 21.9113 13.6433 22.7149C14.8229 23.8699 16.2409 24.9245 17.8973 25.8787C18.7255 26.3558 19.4282 26.7073 20.0054 26.9333L20.7583 27.2723L24.41 23.6188C24.4602 23.5686 24.4978 23.5435 24.5229 23.5435C24.548 23.5435 24.5856 23.5686 24.6358 23.6188L29.718 28.7036C29.7682 28.7538 29.7933 28.7914 29.7933 28.8166C29.7933 28.8166 29.7682 28.8417 29.718 28.8919L25.9534 32.6207C25.4013 33.0978 24.799 33.2233 24.1464 32.9973C19.0266 31.0137 14.7601 28.3018 11.3469 24.8618C9.23877 22.7525 7.39413 20.3545 5.81301 17.6678C4.68364 15.7343 3.80524 13.8636 3.17782 12.0557V12.0181C3.07743 11.7921 3.06488 11.5284 3.14017 11.2271C3.21546 10.9007 3.3535 10.6496 3.55427 10.4738L7.28119 6.66966C7.35648 6.59433 7.44432 6.55667 7.54471 6.55667ZM20.0054 10.1725V12.583C21.0093 12.583 21.8626 12.9346 22.5653 13.6376C23.268 14.3407 23.6194 15.1945 23.6194 16.1989H26.0287C26.0287 15.1191 25.7527 14.1147 25.2005 13.1857C24.6735 12.2566 23.9457 11.5284 23.0171 11.0011C22.0885 10.4487 21.0846 10.1725 20.0054 10.1725Z" fill="black" />
                  </svg>
                  <h5 class="card-title"><?php echo lang('phone'); ?></h5>
                  <p class="card-text"><a class="card-text" href="tel:<?php echo isset($outlet_details->phone) && $outlet_details->phone ? $outlet_details->phone : '' ?>"><?php echo isset($outlet_details->phone) && $outlet_details->phone ? $outlet_details->phone : '' ?></a></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.94318 3.28125V5.74529L2.1875 10.7946V31.7188H33.2102V10.7946L25.4545 5.74529V3.28125H9.94318ZM12.5284 5.86648H22.8693V15.8034L17.6989 19.1562L12.5284 15.8034V5.86648ZM13.821 8.4517V11.0369H21.5767V8.4517H13.821ZM9.94318 8.81525V14.1069L5.86337 11.4813L9.94318 8.81525ZM25.4545 8.81525L29.5344 11.4813L25.4545 14.1069V8.81525ZM13.821 12.3295V14.9148H21.5767V12.3295H13.821ZM4.77273 13.8645L17.6989 22.2261L30.625 13.8645V29.1335H4.77273V13.8645Z" fill="#2D2C2B" />
                  </svg>
                  <h5 class="card-title"><?php echo lang('email'); ?></h5>
                  <p class="card-text"><a  class="card-text" href="mailto:<?php echo isset($outlet_details->email) && $outlet_details->email ? $outlet_details->email : '' ?>"><?php echo isset($outlet_details->email) && $outlet_details->email ? $outlet_details->email : '' ?></a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <?php
          $attributes = ['id' => 'contactUs'];
          echo form_open(base_url('contact-us'), $attributes); ?>

          <div class="row">
            <?php
          if ($this->session->flashdata('exception')) {

              echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
              echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
              echo '</p></div></div></section>';
          }
          ?>

            <div class="form-group col-lg-6">
              <input type="text" placeholder="<?php echo lang('First_Name'); ?> *" class="form-control check_validation" name="first_name" value="<?php echo set_value('first_name') ?>">
              <?php if (form_error('first_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('first_name'); ?>
                                </div>
                            <?php } ?>
            </div>
            <div class="form-group col-lg-6">
              <input type="text" placeholder="<?php echo lang('Last_Name'); ?> *" class="form-control check_validation" name="last_name" value="<?php echo set_value('last_name') ?>">
              <?php if (form_error('last_name')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('last_name'); ?>
                                </div>
                            <?php } ?>
            </div>
            <div class="form-group col-lg-12">
              <input type="email" placeholder="<?php echo lang('Email_Address'); ?> *" class="form-control check_validation" name="email" value="<?php echo set_value('email') ?>">
              <?php if (form_error('email')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('email'); ?>
                                </div>
                            <?php } ?>
            </div>
            <div class="form-group col-lg-12">
              <input type="text" placeholder="<?php echo lang('Subject'); ?> *" class="form-control check_validation" name="subject" value="<?php echo set_value('subject') ?>">
              <?php if (form_error('subject')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('subject'); ?>
                                </div>
                            <?php } ?>
            </div>
            <div class="form-group col-lg-12">
              <textarea name="message" class="form-control check_validation" placeholder="<?php echo lang('Typeyourmessage'); ?> *" rows="8"><?php echo set_value('message') ?></textarea>
              <?php if (form_error('message')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('message'); ?>
                                </div>
                            <?php } ?>
            </div>
          </div>
          <button type="submit" name="submit" value="submit" class="btn-custom primary"><?php echo lang('Send_Message'); ?></button>
          <?php echo form_close(); ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div id="contactPageMap" class="ct-contact-map">
          <iframe src="<?= escape_output($company_info->google_map) ?>" width="100%" height="100%" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
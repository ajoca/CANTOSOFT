  <!-- Login Form Start -->
  <div class="section login_page">
      <div class="container">
          <div class="auth-wrapper forgot-password-page">
              <div class="auth-form">
                  <div class="d-flex flex-column gap16px">
                      <h2><?php echo lang('forgot_your_password'); ?></h2>
                      <p class="subtitle"><?php echo lang('forgot_password_text'); ?></p>
                  </div>
                  <div>
                      <?php
                        if ($this->session->flashdata('exception_1')) {
                            echo '<p class="red_error"><i  class="fa fa-times"></i> ';
                            echo escape_output($this->session->flashdata('exception_1'));
                            unset($_SESSION['exception_1']);
                            echo '</p>';
                        }
                        ?>

                      <?php
                        if ($this->session->flashdata('exception')) {
                            echo '<p class="green_error"><i  class="fa fa-check"></i> ';
                            echo escape_output($this->session->flashdata('exception'));
                            unset($_SESSION['exception']);
                            echo '</p>';
                        }
                        ?>

                      <?php echo form_open(base_url() . 'forgot-password', $arrayName = array('novalidate' => 'novalidate')) ?>
                      
                      <div class="d-flex flex-column gap70px">
                          <div>
                              <div class="form-group">
                                  <label for=""><?php echo lang('email'); ?></label>
                                  <div class="position-relative">
                                      <input type="text" class="form-control form-control-light" placeholder="<?php echo lang('email'); ?>" name="email" value="">
                                      <span class="icon-inside">
                                          <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                              <path d="M14.6667 0H1.33334C0.597969 0 0 0.597969 0 1.33334V10.6667C0 11.402 0.597969 12 1.33334 12H14.6667C15.402 12 16 11.402 16 10.6667V1.33334C16 0.597969 15.402 0 14.6667 0ZM1.33334 0.666656H14.6667C14.7158 0.666656 14.7591 0.684563 14.8052 0.694688C13.6508 1.75116 9.82322 5.25278 8.48375 6.45963C8.37894 6.55403 8.21 6.66666 8.00003 6.66666C7.79006 6.66666 7.62113 6.55403 7.51597 6.45931C6.17663 5.25266 2.34878 1.75084 1.19463 0.69475C1.24081 0.684625 1.28419 0.666656 1.33334 0.666656ZM0.666656 10.6667V1.33334C0.666656 1.26803 0.686344 1.20878 0.703969 1.14909C1.58747 1.95772 4.25822 4.40097 5.98997 5.97575C4.26384 7.45847 1.59241 9.99122 0.701875 10.8404C0.686156 10.7837 0.666656 10.7283 0.666656 10.6667ZM14.6667 11.3333H1.33334C1.28009 11.3333 1.23275 11.3148 1.18303 11.3029C2.10325 10.4257 4.79169 7.87834 6.48747 6.42762C6.68125 6.60353 6.87532 6.77914 7.06966 6.95444C7.34441 7.2025 7.666 7.33334 8 7.33334C8.334 7.33334 8.65559 7.20247 8.93 6.95475C9.12445 6.77934 9.31862 6.60363 9.51253 6.42762C11.2084 7.87819 13.8965 10.4253 14.817 11.3029C14.7673 11.3148 14.72 11.3333 14.6667 11.3333ZM15.3333 10.6667C15.3333 10.7283 15.3138 10.7837 15.2982 10.8404C14.4073 9.99078 11.7362 7.45831 10.0101 5.97578C11.7419 4.401 14.4122 1.95797 15.296 1.14903C15.3137 1.20872 15.3333 1.268 15.3333 1.33331V10.6667Z" fill="#727272" />
                                          </svg>

                                      </span>
                                  </div>
                                  <?php if (form_error('email')) { ?>
                                      <div class="error_txt div_2">
                                          <?php echo form_error('email'); ?>
                                      </div>
                                  <?php } ?>
                              </div>
                              <!-- <a href="#">Forgot Password?</a> -->
                              <button type="submit" name="submit" value="submit" class="btn-custom primary"><?php echo lang('continue'); ?></button>
                          </div>

                          <p class="register_text"><?php echo lang('already_have_account'); ?> <a href="<?php echo base_url() ?>login"><?php echo lang('login_text'); ?></a> </p>
                      </div>
                      <?php echo form_close(); ?>
                  </div>
              </div>

          </div>
      </div>
  </div>
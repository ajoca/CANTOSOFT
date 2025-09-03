<?php
$company_info     = getMainCompany();
$common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page ? json_decode($company_info->common_menu_page) : '';
$paymentSetting   = paymentSetting();
?>

<!-- Checkout Start -->
<section class="section checkout-page">
  <div class="container">
    <?php if ($this->session->flashdata('error')):
      unset($_SESSION['error']);
    ?>
      <h2 style="color:red;text-align:center;margin"><span style="border:4px solid red;padding:8px"><?php echo lang('payment_fail'); ?></span></h2>
      <br>
    <?php endif ?>
    <form action="<?php echo base_url() ?>pay-now" method="post">
      <div class="row">
        <div class="col-xl-7">
          <!-- Buyer Info -->
          <h4><?php echo lang('checkout'); ?></h4>
          <h6><?php echo lang('shipping_information'); ?></h6>
          <div class="row">
            <div class="form-group col-xl-12">
              <label><?php echo lang('full_name'); ?> <span class="text-danger">*</span></label>
              <input type="text" placeholder="<?php echo lang('full_name'); ?>" name="fname" id="fname" class="form-control" value="<?php echo $this->session->userdata('customer_name') ?>">
            </div>
            <div class="form-group col-xl-6">
              <label><?php echo lang('phone'); ?> <span class="text-danger">*</span></label>
              <input type="text" placeholder="<?php echo lang('phone'); ?>" name="phone" id="phone" class="form-control" value="<?php echo $this->session->userdata('customer_phone') ?>">
            </div>
            <div class="form-group col-xl-6">
              <label><?php echo lang('email'); ?></label>
              <input type="email" placeholder="<?php echo lang('email'); ?>" name="email" id="email" class="form-control" value="<?php echo $this->session->userdata('customer_email') ?>">
            </div>

            <div class="form-group col-xl-12">
              <label><?php echo lang('address'); ?> <span class="text-danger">*</span></label>
              <input type="text" placeholder="<?php echo lang('address'); ?>" name="faddress" id="faddress" class="form-control" value="<?php echo $this->session->userdata('customer_address') ?>">
            </div>
          </div>

          <!-- /Buyer Info -->

        </div>
        <div class="col-xl-5 checkout-billing">
          <div class="order-summary">
            <h2><?php echo lang('order_summary'); ?></h2>
            <div class="card-checkout-item">

            </div>
            <hr />
            <div class="totals">
              <p class="subtotal"><?php echo lang('sub_total'); ?>: <span><?php echo $company_info->currency; ?><span class="checkout_sub_total"></span></span> </p>
              <hr />
              <p class="shipping"><?php echo lang('vat'); ?>: <span><?php echo $company_info->currency; ?><span class="checkout_tax_total"></span></span></p>
              <hr />
              <p class="shipping"><?php echo lang('delivery_fee'); ?>: <span><?php echo $company_info->currency; ?><span class="checkout_delivery_fee"></span></span></p>
              <hr />
              <p class="total"><b><?php echo lang('total'); ?>:</b> <span><?php echo $company_info->currency; ?><span class="checkout_grand_total"></span></span></p>
            </div>
           
            <h3><?php echo lang('payment_method'); ?></h3>
            <div class="d-flex flex-column gap10px payment_card">
              <label>
                <input type="radio" class="payment_method" name="payment_method" value="cash_on_delivery" checked />
                <span><?php echo lang('cash_on_delivery'); ?></span>
              </label>
              <?php if ($paymentSetting->field_2 == 1): ?>
                <label>
                  <input type="radio" class="payment_method" name="payment_method" value="paypal" />
                  <span><?php echo lang('paypal'); ?></span>
                </label>
              <?php endif; ?>
              <?php if ($paymentSetting->field_3 == 1): ?>
                <label>
                  <input type="radio" class="payment_method" name="payment_method" value="stripe" />
                  <span><?php echo lang('stripe'); ?></span>
                </label>
              <?php endif; ?>
              <?php if ($paymentSetting->field_5 == 1): ?>
                <label>
                  <input type="radio" class="payment_method" name="payment_method" value="razorpay" />
                  <span><?php echo lang('razorpay'); ?></span>
                </label>
              <?php endif; ?>
              <button class="btn-custom primary w-100 mt-3 pay_now" type="submit"><?php echo lang('place_order'); ?></button>
            </div>
          </div>
          </body>
        </div>
      </div>
    </form>

  </div>
</section>




<!--Stripe payment form-->
<form method="POST" action="<?php echo base_url() ?>payment-form" id="stripe_form">
  <input type="hidden" value="yes" name="check_stripe" id="check_stripe">
  <input type="hidden" value="yes" name="order_id_str" id="order_id_str">
  <input type="hidden" value="0" name="total_payable_str" id="total_payable_str_custom">
  <input title="payment_company_id" name="payment_company_id" id="payment_company_id" class="payment_company_id" type="hidden" value="">
  <input title="item_description" name="item_description_str" id="item_description_str" type="hidden"
    value="Payment for online order">
</form>

<!--Paypal payment form-->
<form method="POST" action="<?php echo base_url() ?>payment-form" id="paypal_form">
  <input type="hidden" value="" name="tax_value" id="tax_value">
  <input type="hidden" value="" name="subtotal_value" id="subtotal_value">
  <input type="hidden" value="" name="order_id_p" id="order_id_p">
  <input type="hidden" value="" name="discount_value" id="discount_value">
  <input type="hidden" value="0" name="item_price" id="total_payable">
  <input title="item_name" name="item_name" id="item_name" type="hidden" value="Payment for online order">
  <input title="payment_company_id" name="payment_company_id" id="payment_company_id" class="payment_company_id" type="hidden" value="">
  <input title="item_number" name="item_number" type="hidden" value="0" id="item_number">
  <input title="item_description" name="item_description" type="hidden" value="Payment for online order">
</form>

<!-- razorpay JavaScript library -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<input type="hidden"
  value="<?php echo (isset($paymentSetting->field_4_key_1) && $paymentSetting->field_4_key_1 ? escape_output($paymentSetting->field_4_key_1) : '') ?>"
  id="key_id_razorpay">
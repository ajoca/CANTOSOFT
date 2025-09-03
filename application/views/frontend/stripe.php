<?php
$company_info = getMainCompany();
$common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page?json_decode($company_info->common_menu_page):'';
 
?>
  <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/stripe_online_order.css">
<!-- Subheader Start -->
<div class="subheader dark-overlay dark-overlay-2" style="background-image: url('<?php echo base_url() ?>uploads/common_menu_page/<?php echo isset($common_menu_page->common_menu_page_banner) && $common_menu_page->common_menu_page_banner ? $common_menu_page->common_menu_page_banner : '' ?>')">
    <div class="container">
      <div class="subheader-inner">
        <h1><?php echo lang('stripe_payment_page');?></h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><?php echo lang('home');?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo lang('stripe_payment_page');?></li>
          </ol>
        </nav>
      </div>

    </div>
  </div>

  <!-- Subheader End -->



  <!-- Checkout Start -->
  <section class="section">
    <div class="container">
    <div class="row">
          <div class="col-xl-7">
            <!-- Buyer Info -->
            <form action="<?php echo base_url()?>stripePayment" method="POST" id="paymentFrm">
            <input type="hidden" name="payable_amount" value="<?php echo escape_output($total_payable_str)?>">
            <input type="hidden" name="order_id_str" value="<?php echo escape_output($order_id_str)?>">
            <input type="hidden" name="description" value="Payment for online order">
            
            <h4>Billing Details</h4>
            <div class="row">
              <div class="form-group col-xl-12">
                <label><?php echo lang('customer'); ?> <?php echo lang('name'); ?> <span class="text-danger">*</span></label>
                <input type="text" placeholder="<?php echo lang('customer'); ?> <?php echo lang('name'); ?>" name="name" id="name" class="form-control" value="<?php echo $this->session->userdata('customer_name')?>">
              </div>
              <div class="form-group col-xl-12">
                <label><?php echo lang('CustomerEmail');?></label>
                <input type="email" placeholder="<?php echo lang('CustomerEmail');?>" name="email" id="email" class="form-control" value="<?php echo $this->session->userdata('customer_email')?>">
              </div>

              <div class="form-group col-xl-12">
                <label><?php echo lang('CardNumber');?> <span class="text-danger">*</span></label>
                <div id="card_number" class="form-control"></div>
              </div>
              <div class="form-group col-xl-6">
                <label><?php echo lang('ExpiryDate');?> <span class="text-danger">*</span></label>
                <div id="card_expiry" class="form-control"></div>
              </div>
              <div class="form-group col-xl-6">
                <label><?php echo lang('CVCCode');?> <span class="text-danger">*</span></label>
                <div id="card_cvc" class="form-control"></div>
              </div>
            </div>
                        <button type="submit"  class="btn-custom primary bgAlphaColor st_txt2" id="payBtn"><?php echo lang('ConfirmAgain'); ?></button>
            </form>
            <!-- /Buyer Info -->

          </div> 

    </div>
  </section>


  
<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v3/"></script>

<?php
    //get payment setting
    $paymentSetting = paymentSetting();
    $stripe_publishable_key = '';
    if(isset($paymentSetting) && $paymentSetting->field_3 && $paymentSetting->field_3==1):
        $stripe_publishable_key = $paymentSetting->field_3_key_2;
    endif;
?>
<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    //get publishable key
    //use this key in external stripe.js file
    let share_key = "<?php echo escape_output($stripe_publishable_key)?>";
</script>

<script src="<?php echo base_url()?>frequent_changing/js/stripe_online_order.js"></script>

<?php
$company_info     = getMainCompany();
$categories       = getFoodMenuCategory();
$get_food_menu    = getFoodMenuForMenuPage();
$common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page ? json_decode($company_info->common_menu_page) : '';
$customerInfo = getCustomerData($orderData->customer_id);
?>

<!-- Menu Wrapper Start -->
<div class="section payment_success_section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 success_col">
                <div class="payment-success">
                    <div class="payment-success-icon">
                        <svg width="57" height="56" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="28.5" cy="28" r="28" fill="#23A26D" fill-opacity="0.12" />
                            <path d="M28.0003 14.6667C20.6537 14.6667 14.667 20.6533 14.667 28C14.667 35.3467 20.6537 41.3333 28.0003 41.3333C35.347 41.3333 41.3337 35.3467 41.3337 28C41.3337 20.6533 35.347 14.6667 28.0003 14.6667ZM34.3737 24.9333L26.8137 32.4933C26.627 32.68 26.3737 32.7867 26.107 32.7867C25.8403 32.7867 25.587 32.68 25.4003 32.4933L21.627 28.72C21.2403 28.3333 21.2403 27.6933 21.627 27.3067C22.0137 26.92 22.6537 26.92 23.0403 27.3067L26.107 30.3733L32.9603 23.52C33.347 23.1333 33.987 23.1333 34.3737 23.52C34.7603 23.9067 34.7603 24.5333 34.3737 24.9333Z" fill="#23A26D" />
                        </svg>
                    </div>
                    <div class="payment_success">
                        <p><?php echo lang('payment_success'); ?></p>
                        <p><?= getAmtCustom($orderData->total_payable) ?></p>
                    </div>
                    <hr class="payment_success_hr">
                    <div class="order-details">
                        <header class="order-header">
                            <div class="d-flex justify-content-between payment-info">
                                <p><?php echo lang('sale_no'); ?></p>
                                <p><?= $orderData->sale_no ?></p>
                            </div>
                            <div class="d-flex justify-content-between payment-info">
                                <p><?php echo lang('order_time'); ?></p>
                                <p><?= $orderData->date_time ?></p>
                            </div>
                            <div class="d-flex justify-content-between payment-info">
                                <p><?php echo lang('status'); ?></p>
                                <?php
                                    $status_css = "";
                                    if($orderData->self_order_status=="Approved"){
                                        $status_css = "approved";  
                                    }else if($orderData->self_order_status=="Pending"){
                                     $status_css = "pending";  
                                    }else if($orderData->self_order_status=="Decline"){
                                     $status_css = "decline";  
                                    }
                                ?>
                                <p class="<?php echo $status_css?>"><?= $orderData->self_order_status ?></p>
                            </div>
                            <div class="d-flex justify-content-between payment-info">
                                <p><?php echo lang('customer'); ?> <?php echo lang('name'); ?></p>
                                <p><?= $customerInfo->name ?></p>
                            </div>
                            <hr class="payment_amount_hr">
                            <div class="d-flex justify-content-between payment-info">
                                <p><?php echo lang('amount'); ?></p>
                                <p><?= getAmtCustom($orderData->total_payable) ?></p>
                            </div>
                        </header>                        
                    </div>
                </div>
                <div class="payment-success-btn">
                    <a href="<?php echo base_url(); ?>" class="btn-custom primary"><?php echo lang('Back to Home'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu Wrapper End -->
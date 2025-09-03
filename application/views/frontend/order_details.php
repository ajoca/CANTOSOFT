<?php
$company_info     = getMainCompany();
$categories       = getFoodMenuCategory();
$get_food_menu    = getFoodMenuForMenuPage();
$common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page ? json_decode($company_info->common_menu_page) : '';

$customerInfo = getCustomerData($order->customer_id);
$paymentMethod = getPaymentName($order->payment_method_id,$order->online_payment_details) ?? 'COD';
?>

<!-- Menu Wrapper Start -->
<div class="section order_details_section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="order-details">
                    <header class="order-header">
                        <div class="d-flex gap25px align-items-end">
                            <h2><?php echo lang('order_details'); ?></h2>
                            <ul class="order-info">
                                <li><?= date("F d, Y", strtotime($order->sale_date)) ?> </li>
                                <li><?= $totalItems; ?> <?php echo lang('Products'); ?></li>
                            </ul>
                        </div>
                        <a href="<?= base_url() ?>/old-orders" class="back-link"><?php echo lang('Backtolist'); ?></a>
                    </header>

                    <div class="order-body">
                        <!-- Billing Address Section -->
                        <div class="billing-section">
                            <h3><?php echo lang('Billing_Address'); ?></h3>
                            <div class="d-flex flex-column gap20px">
                                <div class="d-flex flex-column gap10px">
                                    <p><?= $customerInfo->name ?></p>
                                    <p class="paragraph-color"><?= $customerInfo->address ?></p>
                                </div>
                                <div class="d-flex flex-column gap10px">
                                    <div>
                                        <p><?php echo lang('email'); ?></p>
                                        <p class="paragraph-color"><a href="mailto:<?= $customerInfo->email ?>"><?= $customerInfo->email ?></a></p>
                                    </div>
                                    <div>
                                        <p><?php echo lang('phone'); ?></p>
                                        <p class="paragraph-color"><a href="tel:<?= $customerInfo->phone ?>"><?= $customerInfo->phone ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="summary-section">
                            <div class="d-flex justify-content-between top_section">
                                <div class="order-id">
                                    <p><?php echo lang('order_id'); ?>:</p>
                                    <p>#<?= $order->sale_no ?></p>
                                </div>
                                <span class="hori-line"></span>
                                <div class="payment-method">
                                    <p><?php echo lang('payment_method'); ?>:</p>
                                    <p><?= $paymentMethod; ?></p>
                                </div>
                            </div>
                            <div class="bottom_section">
                                <p><?php echo lang('subtotal'); ?>: <span><?= getAmtCustom($order->sub_total) ?></span></p>
                                <p><?php echo lang('vat'); ?>: <span><?= getAmtCustom($order->vat) ?></span></p>
                                <p><?php echo lang('delivery_fee'); ?>: <span><?= getAmtCustom($order->delivery_charge_actual_charge) ?></span></p>
                                <p class="total"><?php echo lang('total'); ?>: <span><?= getAmtCustom($order->total_payable) ?></span></p>
                            </div>
                        </div>
                    </div> 
                    <!-- Product Table -->
                    <div class="products">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php echo lang('Product'); ?></th>
                                    <th><?php echo lang('price'); ?></th>
                                    <th><?php echo lang('quantity'); ?></th>
                                    <th><?php echo lang('total'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($orderItems && !empty($orderItems)): ?>
                                <?php foreach($orderItems as $item): ?>
                                <tr>
                                    <td>
                                        <span><?= $item->menu_name; ?></span>
                                    </td>
                                    <td><?= getAmtCustom($item->menu_unit_price) ?></td>
                                    <td><?= $item->qty; ?></td>
                                    <td><?= getAmtCustom($item->qty * $item->menu_unit_price) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu Wrapper End -->
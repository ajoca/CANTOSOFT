<?php
//get company information
$getCompanyInfo = getCompanyInfo();
$inv_label = isset($getCompanyInfo->invoice_label_setting) && $getCompanyInfo->invoice_label_setting?json_decode($getCompanyInfo->invoice_label_setting):'';
$waiter_app_status = $this->session->userdata('is_waiter');
$is_self_order = $this->session->userdata('is_self_order');
$language_manifesto = $this->session->userdata('language_manifesto');
$waiter_app_status=isset($waiter_app_status) && $waiter_app_status?$waiter_app_status:'';
$default_waiter_id = 0;
$outlet = getOutletById($this->session->userdata('outlet_id'));
foreach ($waiters as $waiter){
    $role = $this->session->userdata('role');
    $user_id = $this->session->userdata('user_id');

    if(str_rot13($language_manifesto)=="eriutoeri"):
        $default_waiter = $outlet->default_waiter;
    else:
        $default_waiter = $getCompanyInfo->default_waiter;
    endif;

    if($waiter->id==$default_waiter){
        $default_waiter_id = $waiter->id;
    }else{
        if(isset($role) && $role!="Admin"){
            if($waiter->id==$user_id){
                $default_waiter_id = $user_id;
            }
        }
    }

}


?>


<input type="hidden" id="product_label" value="<?php echo isset($inv_label->product_label) && $inv_label->product_label ? $inv_label->product_label : '' ?>">
<input type="hidden" id="quantity_label" value="<?php echo isset($inv_label->quantity_label) && $inv_label->quantity_label ? $inv_label->quantity_label : '' ?>">
<input type="hidden" id="unit_price_label" value="<?php echo isset($inv_label->unit_price_label) && $inv_label->unit_price_label ? $inv_label->unit_price_label : '' ?>">
<input type="hidden" id="subtotal_label" value="<?php echo isset($inv_label->subtotal_label) && $inv_label->subtotal_label ? $inv_label->subtotal_label : '' ?>">
<input type="hidden" id="category_label" value="<?php echo isset($inv_label->category_label) && $inv_label->category_label ? $inv_label->category_label : '' ?>">
<input type="hidden" id="total_quantity_label" value="<?php echo isset($inv_label->total_quantity_label) && $inv_label->total_quantity_label ? $inv_label->total_quantity_label : '' ?>">
<input type="hidden" id="item_discount_label" value="<?php echo isset($inv_label->item_discount_label) && $inv_label->item_discount_label ? $inv_label->item_discount_label : '' ?>">
<input type="hidden" id="discount_unit_price_label" value="<?php echo isset($inv_label->discount_unit_price_label) && $inv_label->discount_unit_price_label ? $inv_label->discount_unit_price_label : '' ?>">


<!--hidden fields for js usages-->
<input type="hidden" id="base_url_pos" value="<?php echo base_url()?>">
<input type="hidden" id="waiter_app_status" value="<?php echo escape_output($waiter_app_status)?>">
<input type="hidden" id="is_self_order" value="<?php echo escape_output($is_self_order)?>">
<input type="hidden" id="is_self_order_tmp" value="<?php echo escape_output($is_self_order)?>">
<input type="hidden" id="ur_role" value="<?php echo escape_output($this->session->userdata('role'))?>">
<input type="hidden" id="inv_collect_tax" value="<?php echo escape_output($this->session->userdata('collect_tax'))?>">
<input type="hidden" id="tax_is_gst" value="<?php echo escape_output($this->session->userdata('tax_is_gst'))?>">
<input type="hidden" id="decimals_separator" value="<?php echo escape_output($this->session->userdata('decimals_separator'))?>">
<input type="hidden" id="thousands_separator" value="<?php echo escape_output($this->session->userdata('thousands_separator'))?>">
<input type="hidden" id="currency_position" value="<?php echo escape_output($this->session->userdata('currency_position'))?>">
<input type="hidden" id="same_or_diff_state" value="">
<input type="hidden" id="username_short" value="<?php echo escape_output(getShortName())?>">
<input type="hidden" id="hidden_currency" value="<?php echo escape_output($this->session->userdata('currency'))?>">
<input type="hidden" id="food_menu_tooltip" value="<?php echo escape_output($this->session->userdata('food_menu_tooltip'))?>">
<input type="hidden" id="ir_precision" value="<?php echo escape_output($getCompanyInfo->precision)?>">
<input type="hidden" id="when_clicking_on_item_in_pos" value="<?php echo escape_output($getCompanyInfo->when_clicking_on_item_in_pos)?>">
<input type="hidden" id="default_order_type" value="<?php echo escape_output($this->session->userdata('default_order_type'))?>">
<input type="hidden" id="is_loyalty_enable" value="<?php echo escape_output($this->session->userdata('is_loyalty_enable'))?>">
<input type="hidden" id="pre_or_post_payment" value="<?php echo escape_output($this->session->userdata('pre_or_post_payment'))?>">
<input type="hidden" id="minimum_point_to_redeem" value="<?php echo escape_output($this->session->userdata('minimum_point_to_redeem'))?>">
<input type="hidden" id="loyalty_rate" value="<?php echo escape_output($this->session->userdata('loyalty_rate'))?>">
<input type="hidden" id="open_cash_drawer_when_printing_invoice" value="<?php echo escape_output($this->session->userdata('open_cash_drawer_when_printing_invoice'))?>">
<input type="hidden" id="is_rounding_enable" value="<?php echo escape_output($this->session->userdata('is_rounding_enable'))?>">
<input type="hidden" id="split_bill" value="<?php echo escape_output($this->session->userdata('split_bill'))?>">
<input type="hidden" id="register_close" value="<?php echo lang('register_close'); ?>">
<input type="hidden" id="alert_free_item" value="<?php echo lang('alert_free_item'); ?>">
<input type="hidden" id="loyalty_point_is_not_available" value="<?php echo lang('loyalty_point_is_not_available'); ?>">
<input type="hidden" id="tool_tip_loyalty_point" value="<?php echo lang('tool_tip_loyalty_point'); ?>">
<input type="hidden" id="minimum_point_to_redeem_is" value="<?php echo lang('minimum_point_to_redeem_is'); ?>">
<input type="hidden" id="alert_free_item_edit" value="<?php echo lang('alert_free_item_edit'); ?>">
<input type="hidden" id="loyalty_point_error" value="<?php echo lang('loyalty_point_error'); ?>">
<input type="hidden" id="sales_currently_in_local" value="<?php echo lang('sales_currently_in_local'); ?>">
<input type="hidden" id="login_first_msg" value="<?php echo lang('login_first_msg'); ?>">
<input type="hidden" id="txt_balance" value="<?php echo lang('balance'); ?>">
<input type="hidden" id="draft_error" value="<?php echo lang('draft_error'); ?>">
<input type="hidden" id="action_error" value="<?php echo lang('action_error'); ?>">
<input type="hidden" id="register_error" value="<?php echo lang('register_error'); ?>">
<input type="hidden" id="alert_free_item_increase" value="<?php echo lang('alert_free_item_increase'); ?>">
<input type="hidden" id="you_need_to_add_at_least_1_item_on_right_selected_customer" value="<?php echo lang('you_need_to_add_at_least_1_item_on_right_selected_customer'); ?>">
<input type="hidden" id="please_add_at_least_1_item_before_checkout" value="<?php echo lang('please_add_at_least_1_item_before_checkout'); ?>">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
<input type="hidden" id="please_select_order_to_proceed" value="<?php echo lang('please_select_order_to_proceed'); ?>">
<input type="hidden" id="status_txt" value="<?php echo lang('status'); ?>">
<input type="hidden" id="feature_sales" value="<?php echo lang('feature_sales'); ?>">
<input type="hidden" id="you_cant_modify_the_order" value="<?php echo lang('you_cant_modify_the_order'); ?>">
<input type="hidden" id="my_orders" value="<?php echo lang('my_orders'); ?>">
<input type="hidden" id="self_orders" value="<?php echo lang('self_orders'); ?>">
<input type="hidden" id="set_as_approved" value="<?php echo lang('set_as_approved'); ?>">
<input type="hidden" id="exceeciding_seat" value="<?php echo lang('exceeding_sit'); ?>">
<input type="hidden" id="set_as_running_order" value="<?php echo lang('set_as_running_order'); ?>">
<input type="hidden" id="date_txt" value="<?php echo lang('date'); ?>">
<input type="hidden" id="seat_greater_than_zero" value="<?php echo lang('seat_greater_than_zero'); ?>">
<input type="hidden" id="are_you_sure_cancel_booking" value="<?php echo lang('are_you_sure_cancel_booking'); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="are_you_delete_notification" value="<?php echo lang('are_you_delete_notification'); ?>">
<input type="hidden" id="stock_not_available" value="<?php echo lang('stock_not_available'); ?>">
<input type="hidden" id="no_notification_select" value="<?php echo lang('no_notification_select'); ?>">
<input type="hidden" id="are_you_delete_all_hold_sale" value="<?php echo lang('are_you_delete_all_hold_sale'); ?>">
<input type="hidden" id="no_hold" value="<?php echo lang('no_hold'); ?>">
<input type="hidden" id="sure_delete_this_hold" value="<?php echo lang('sure_delete_this_hold'); ?>">
<input type="hidden" id="please_select_hold_sale" value="<?php echo lang('please_select_hold_sale'); ?>">
<input type="hidden" id="delete_only_for_admin" value="<?php echo lang('delete_only_for_admin'); ?>">
<input type="hidden" id="this_item_is_under_cooking_please_contact_with_admin" value="<?php echo lang('this_item_is_under_cooking_please_contact_with_admin'); ?>">
<input type="hidden" id="this_item_already_cooked_please_contact_with_admin" value="<?php echo lang('this_item_already_cooked_please_contact_with_admin'); ?>">
<input type="hidden" id="sure_delete_this_order" value="<?php echo lang('sure_delete_this_order'); ?>">
<input type="hidden" id="sure_remove_this_order" value="<?php echo lang('sure_remove_this_order'); ?>">
<input type="hidden" id="sure_cancel_this_order" value="<?php echo lang('sure_cancel_this_order'); ?>">
<input type="hidden" id="sure_close_this_order" value="<?php echo lang('sure_close_this_order'); ?>">
<input type="hidden" id="please_select_an_order" value="<?php echo lang('please_select_an_order'); ?>">
<input type="hidden" id="cart_not_empty" value="<?php echo lang('cart_not_empty'); ?>">
<input type="hidden" id="cart_not_empty_want_to_clear" value="<?php echo lang('cart_not_empty_want_to_clear'); ?>">
<input type="hidden" id="progress_or_done_kitchen" value="<?php echo lang('progress_or_done_kitchen'); ?>">
<input type="hidden" id="order_in_progress_or_done" value="<?php echo lang('order_in_progress_or_done'); ?>">
<input type="hidden" id="close_order_without" value="<?php echo lang('close_order_without'); ?>">
<input type="hidden" id="want_to_close_order" value="<?php echo lang('want_to_close_order'); ?>">
<input type="hidden" id="please_select_open_order" value="<?php echo lang('please_select_open_order'); ?>">
<input type="hidden" id="cart_empty" value="<?php echo lang('cart_empty'); ?>">
<input type="hidden" id="select_a_customer" value="<?php echo lang('select_a_customer'); ?>">
<input type="hidden" id="loyalty_point_not_applicable" value="<?php echo lang('loyalty_point_not_applicable_for_walk_in_customer'); ?>">
<input type="hidden" id="select_a_waiter" value="<?php echo lang('select_a_waiter'); ?>">
<input type="hidden" id="your_added_payment_method_will_remove" value="<?php echo lang('your_added_payment_method_will_remove'); ?>">
<input type="hidden" id="some_of_your_cart_amounts_are_not_spitted_yet" value="<?php echo lang('some_of_your_cart_amounts_are_not_spitted_yet'); ?>">
<input type="hidden" id="tax_type" value="<?php echo escape_output($getCompanyInfo->tax_type)?>">
<input type="hidden" id="attendance_type" value="<?php echo escape_output($getCompanyInfo->attendance_type)?>">
<input type="hidden" id="delivery_not_possible_walk_in"
       value="<?php echo lang('delivery_not_possible_walk_in'); ?>">
<input type="hidden" id="delivery_for_customer_must_address"
       value="<?php echo lang('delivery_for_customer_must_address'); ?>">
<input type="hidden" id="select_dine_take_delivery" value="<?php echo lang('select_dine_take_delivery'); ?>">
<input type="hidden" id="added_running_order" value="<?php echo lang('added_running_order'); ?>">
<input type="hidden" id="txt_err_pos_1" value="<?php echo lang('txt_err_pos_1'); ?>">
<input type="hidden" id="txt_err_pos_2" value="<?php echo lang('txt_err_pos_2'); ?>">
<input type="hidden" id="txt_err_pos_3" value="<?php echo lang('txt_err_pos_3'); ?>">
<input type="hidden" id="txt_err_pos_4" value="<?php echo lang('txt_err_pos_4'); ?>">
<input type="hidden" id="txt_err_pos_5" value="<?php echo lang('txt_err_pos_5'); ?>">
<input type="hidden" id="fullscreen_1" value="<?php echo lang('fullscreen_1'); ?>">
<input type="hidden" id="fullscreen_2" value="<?php echo lang('fullscreen_2'); ?>">
<input type="hidden" id="maximum_spit_is" value="<?php echo lang('maximum_spit_is'); ?>">
<input type="hidden" id="amount_txt" value="<?php echo lang('amount'); ?>">
<input type="hidden" id="loyalty_point_txt" value="<?php echo lang('loyalty_point'); ?>">
<input type="hidden" id="place_order" value="<?php echo lang('place_order'); ?>">
<input type="hidden" id="update_order" value="<?php echo lang('update_order'); ?>">
<input type="hidden" id="price_txt" value="<?php echo lang('price'); ?>">
<input type="hidden" id="note_txt" value="<?php echo lang('note'); ?>">
<input type="hidden" id="note_txt" value="<?php echo lang('note'); ?>">
<input type="hidden" id="combo_txt" value="<?php echo lang('combo_txt'); ?>">
<input type="hidden" id="inv_total_item" value="<?php echo lang('Total_Item_s') ?>">
<input type="hidden" id="inv_server" value="<?php echo lang('server') ?>">
<input type="hidden" id="inv_total" value="<?php echo lang('total') ?>">
<input type="hidden" id="inv_paid" value="<?php echo lang('paid') ?>">
<input type="hidden" id="inv_sale_date" value="<?php echo lang('sale_date') ?>">
<input type="hidden" id="inv_sub_total" value="<?php echo lang('sub_total') ?>">
<input type="hidden" id="inv_discount" value="<?php echo lang('Disc_Amt_p') ?>">
<input type="hidden" id="inv_given_amount" value="<?php echo lang('given_amount') ?>">
<input type="hidden" id="inv_change_amount" value="<?php echo lang('change_amount') ?>">
<input type="hidden" id="inv_service_charge" value="<?php echo lang('service_charge') ?>">
<input type="hidden" id="inv_delivery_charge" value="<?php echo lang('inv_delivery_charge') ?>">
<input type="hidden" id="inv_charge" value="<?php echo lang('charge') ?>">
<input type="hidden" id="inv_offline" value="<?php echo lang('offline') ?>">
<input type="hidden" id="inv_online" value="<?php echo lang('online') ?>">
<input type="hidden" id="inv_order_number" value="<?php echo lang('order_number') ?>">
<input type="hidden" id="inv_checkout" value="<?php echo lang('Checkout') ?>">
<input type="hidden" id="inv_vat" value="<?php echo lang('vat') ?>">
<input type="hidden" id="inv_tips" value="<?php echo lang('tips') ?>">
<input type="hidden" id="inv_grand_total" value="<?php echo lang('grand_total') ?>">
<input type="hidden" id="inv_paid_amount" value="<?php echo lang('paid_amount') ?>">
<input type="hidden" id="inv_due_amount" value="<?php echo lang('due_amount') ?>">
<input type="hidden" id="inv_total_payable" value="<?php echo lang('total_payable') ?>">
<input type="hidden" id="inv_payment_method" value="<?php echo lang('payment_method') ?>">
<input type="hidden" id="inv_invoice_no" value="<?php echo lang('Invoice_No') ?>">
<input type="hidden" id="inv_phone" value="<?php echo lang('phone') ?>">
<input type="hidden" id="inv_tax_registration_no" value="<?php echo escape_output($this->session->userdata('tax_title'))?>">
<input type="hidden" id="inv_date" value="<?php echo lang('date') ?>">
<input type="hidden" id="inv_sales_associate" value="<?php echo lang('Sales_Associate') ?>">
<input type="hidden" id="inv_customer" value="<?php echo lang('customer') ?>">
<input type="hidden" id="inv_address" value="<?php echo lang('address') ?>">
<input type="hidden" id="inv_gst_number" value="<?php echo lang('gst_number') ?>">
<input type="hidden" id="inv_waiter" value="<?php echo lang('waiter') ?>">
<input type="hidden" id="inv_table" value="<?php echo lang('table') ?>">
<input type="hidden" id="inv_delivery_status" value="<?php echo lang('delivery_status') ?>">
<input type="hidden" id="inv_order_type" value="<?php echo lang('order_type') ?>">
<input type="hidden" id="inv_usage_points" value="<?php echo lang('UsagePoints') ?>">
<input type="hidden" id="inv_dine" value="<?php echo lang('dine') ?>">
<input type="hidden" id="inv_take_away" value="<?php echo lang('take_away') ?>">
<input type="hidden" id="inv_delivery" value="<?php echo lang('delivery') ?>">
<input type="hidden" id="inv_bill_no" value="<?php echo lang('Bill_No') ?>">
<input type="hidden" id="inv_token_number" value="<?php echo lang('token_number') ?>">
<input type="hidden" id="order_type_changing_alert" value="<?php echo lang('order_type_changing_alert') ?>">

<input type="hidden" id="modifiers_txt" value="<?php echo lang('modifiers'); ?>">
<input type="hidden" id="quantity_not_available" value="<?php echo lang('quantity_not_available'); ?>">
<input type="hidden" id="amount_not_available" value="<?php echo lang('amount_not_available'); ?>">
<input type="hidden" id="item_add_success" value="<?php echo lang('item_add_success'); ?>">
<input type="hidden" id="already_added" value="<?php echo lang('Already_added'); ?>">
<input type="hidden" id="close_order_msg" value="<?php echo lang('close_order_msg'); ?>">
<input type="hidden" id="cancel_order_msg" value="<?php echo lang('cancel_order_msg'); ?>">
<input type="hidden" id="default_customer_hidden" value="<?php echo escape_output($getCompanyInfo->default_customer); ?>">
<input type="hidden" id="default_waiter_hidden" value="<?php echo escape_output($default_waiter_id); ?>">
<input type="hidden" id="default_payment_hidden"
       value="<?php echo escape_output($getCompanyInfo->default_payment); ?>">
<input type="hidden" id="selected_invoice_sale_customer" value="">
<input type="hidden" id="saas_m_ch" value="<?=file_exists(APPPATH.'controllers/Service.php')?'yes':''?>">
<input type="hidden" id="not_closed_yet" value="<?php echo lang('not_closed_yet'); ?>">
<input type="hidden" id="opening_balance" value="<?php echo lang('opening_balance'); ?>">
<input type="hidden" id="paid_amount" value="<?php echo lang('paid_amount'); ?>">
<input type="hidden" id="customer_due_receive" value="<?php echo lang('customer_due_receive'); ?>">
<input type="hidden" id="more_then_original_amount" value="<?php echo lang('more_then_original_amount'); ?>">
<input type="hidden" id="this_item_not_added_on_your_selected_customer" value="<?php echo lang('this_item_not_added_on_your_selected_customer'); ?>">
<input type="hidden" id="in_" value="<?php echo lang('in'); ?>">
<input type="hidden" id="cash" value="<?php echo lang('cash'); ?>">
<input type="hidden" id="paypal" value="<?php echo lang('paypal'); ?>">
<input type="hidden" id="sale" value="<?php echo lang('sale'); ?>">
<input type="hidden" id="card" value="<?php echo lang('card'); ?>">
<input type="hidden" id="edit_profile" value="<?php echo lang('edit_profile'); ?>">
<input type="hidden" id="indexdb_err" value="<?php echo lang('indexdb_err'); ?>">
<input type="hidden" id="invoiced_error" value="<?php echo lang('invoiced_error'); ?>">
<input type="hidden" id="order_close_error" value="<?php echo lang('order_close_error'); ?>">
<input type="hidden" id="please_select_a_box_on_right_side_for_assign_item" value="<?php echo lang('please_select_a_box_on_right_side_for_assign_item'); ?>">
<input type="hidden" id="selected_variation" value="<?php echo lang('selected_variation'); ?>">
<input type="hidden" id="please_click_a_payment_method_before_add" value="<?php echo lang('please_click_a_payment_method_before_add'); ?>">
<input type="hidden" id="pleaseselectordertypebeforeaddtocart" value="<?php echo lang('pleaseselectordertypebeforeaddtocart'); ?>">
<input type="hidden" id="add_to_cart_txt" value="<?php echo lang('add_to_cart'); ?>">
<input type="hidden" id="add_to_cart_pos" value="<?php echo lang('add_to_cart_pos'); ?>">
<input type="hidden" id="please_add_your_table_person_number" value="<?php echo lang('please_add_your_table_person_number'); ?>">
<input type="hidden" id="you_need_to_add_address_with_your_selected_customer" value="<?php echo lang('you_need_to_add_address_with_your_selected_customer'); ?>">
<input type="hidden" id="menu_not_permit_access" value="<?php echo lang('menu_not_permit_access'); ?>">
<div class="modalOverlay"></div>
<input type="hidden" id="base_url_customer" value="<?php echo base_url()?>">
<input type="hidden" id="csrf_name_" value="<?php echo escape_output($this->security->get_csrf_token_name()); ?>">
<input type="hidden" id="csrf_value_" value="<?php echo escape_output($this->security->get_csrf_hash()); ?>">
<input type="hidden" name="print_status" id="" value="">
<input type="hidden"  id="status_for_self_order" value="">
<input type="hidden" name="last_invoice_id" class="last_invoice_id" id="last_invoice_id"
       value="<?php echo escape_output(getLastSaleId()) ?>">
<input type="hidden" name="last_sale_id" class="last_sale_id" id="last_sale_id" value="">
<input type="hidden" name="last_future_sale_id" class="last_future_sale_id" id="last_future_sale_id" value="">
<input type="hidden" id="temp_sale_no" value="">
<input type="hidden" id="current_sale_no" value="">
<input type="hidden" name="print_type" class="print_type" id="print_type" value="">
<?php
    $print_type_invoice = escape_output($this->session->userdata('printing_choice'));
    $print_type_bill = escape_output($this->session->userdata('printing_choice_bill'));
?>
<input type="hidden" name="print_type_invoice" class="print_type_invoice" id="print_type_invoice" value="<?php echo $print_type_invoice?$print_type_invoice:"web_browser"; ?>">
<input type="hidden" name="print_type_bill" class="print_type_bill" id="print_type_bill" value="<?php echo $print_type_bill?$print_type_bill:"web_browser"; ?>">
<input type="hidden" name="print_format" class="print_format" id="print_format" value="<?php echo escape_output($this->session->userdata('print_format')); ?>">
<input type="hidden" name="service_type" class="service_type" id="service_type" value="<?php echo isset($getCompanyInfo->service_type) && $getCompanyInfo->service_type?$getCompanyInfo->service_type:'delivery'; ?>">
<input type="hidden" name="service_amount" class="service_amount" id="service_amount" value="<?php echo isset($getCompanyInfo->service_amount) && $getCompanyInfo->service_amount?$getCompanyInfo->service_amount:'0'; ?>">
<input type="hidden" name="take_away_service_charge" class="take_away_service_charge" id="take_away_service_charge" value="<?php echo isset($getCompanyInfo->take_away_service_charge) && $getCompanyInfo->take_away_service_charge?$getCompanyInfo->take_away_service_charge:'0'; ?>">
<input type="hidden" name="delivery_amount" class="delivery_amount" id="delivery_amount" value="<?php echo isset($getCompanyInfo->delivery_amount) && $getCompanyInfo->delivery_amount?$getCompanyInfo->delivery_amount:'0'; ?>">
<input type="hidden" name="sale_id_for_print" class="sale_id_for_print" id="sale_id_for_print" value="">

<input type="hidden" id="outlet_name" value="<?php echo escape_output($this->session->userdata('outlet_name')); ?>">
<input type="hidden" id="txt_kot" value="<?php echo lang('KOT'); ?>">
<input type="hidden" id="outlet_address" value="<?php echo escape_output($this->session->userdata('address')); ?>">
<input type="hidden" id="outlet_phone" value="<?php echo escape_output($this->session->userdata('phone')); ?>">
<input type="hidden" id="invoice_footer" value="<?php echo escape_output($this->session->userdata('invoice_footer')); ?>">
<input type="hidden" id="user_name" value="<?php echo escape_output($this->session->userdata('full_name')); ?>">
<input type="hidden" id="user_id" value="<?php echo escape_output($this->session->userdata('user_id')); ?>">
<input type="hidden" id="outlet_id_indexdb" value="<?php echo escape_output($this->session->userdata('outlet_id')); ?>">
<input type="hidden" id="company_id_indexdb" value="<?php echo escape_output($this->session->userdata('company_id')); ?>">
<input type="hidden" id="sale_no_new_hidden" value="">
<input type="hidden" id="random_code_hidden" value="">
<input type="hidden" id="update_sale_id" value="">
<div class="total_split_sale ir_display_none"></div>
<input type="hidden" id="outlet_tax_registration_no" value="<?php echo escape_output($this->session->userdata('tax_registration_no')); ?>">
<input type="hidden" id="token_no" value="">
<input type="hidden" id="associate_user_name" value="<?php echo escape_output($this->session->userdata('full_name')); ?>">
<input type="hidden" id="self_order_table_id" value="<?php echo escape_output($this->session->userdata('self_order_table_id')); ?>">
<input type="hidden" id="is_online_order" value="<?php echo escape_output($this->session->userdata('is_online_order')); ?>">
<input type="hidden" id="online_customer_id" value="<?php echo escape_output($this->session->userdata('online_customer_id')); ?>">
<input type="hidden" id="online_customer_name" value="<?php echo escape_output($this->session->userdata('online_customer_name')); ?>">
<input type="hidden" id="orders_table_text_hide" value="<?php echo escape_output(getTableName($this->session->userdata('self_order_table_id'))); ?>">
<input type="hidden" id="default_date" value="<?php echo date("Y-m-d"); ?>">
<input type="hidden" id="delivery_partner" value="<?php echo sizeof($deliveryPartners); ?>">
<?php
$sms_send_auto = $this->session->userdata('sms_send_auto');
$self_order_table_name =  $this->session->userdata('self_order_table_name');
$self_order_table_id = $this->session->userdata('self_order_table_id');  
?>
<input type="hidden" id="sms_send_auto_checker" value="<?php echo isset($sms_send_auto) && $sms_send_auto==2?1:0?>">
<input type="hidden" id="hidden_given_amount" value="0">
<input type="hidden" id="hidden_change_amount" value="0">

<input type="hidden" id="table_id" value="<?php echo escape_output($self_order_table_id)?>">
<input type="hidden" id="hidden_table_capacity" value="1">
<input type="hidden" id="hidden_table_name" value="<?php echo escape_output($self_order_table_name)?>">
<input type="hidden" id="ordered_border_color_hidden" value="">
<input type="hidden" id="ordered_bg_color_hidden" value="">
<input type="hidden" id="ordered_text_color_hidden" value="">

<!--pos screen access list-->
<input type="hidden" id="pos_1" value="<?php echo getPOSChecker("73","pos_1"); ?>">
<input type="hidden" id="pos_2" value="<?php echo getPOSChecker("73","pos_2"); ?>">
<input type="hidden" id="pos_3" value="<?php echo getPOSChecker("73","pos_3"); ?>">
<input type="hidden" id="pos_4" value="<?php echo getPOSChecker("73","pos_4"); ?>">
<input type="hidden" id="pos_5" value="<?php echo getPOSChecker("73","pos_5"); ?>">
<input type="hidden" id="pos_6" value="<?php echo getPOSChecker("73","pos_6"); ?>">
<input type="hidden" id="pos_7" value="<?php echo getPOSChecker("73","pos_7"); ?>">
<input type="hidden" id="pos_8" value="<?php echo getPOSChecker("73","pos_8"); ?>">
<input type="hidden" id="pos_9" value="<?php echo getPOSChecker("73","pos_9"); ?>">
<input type="hidden" id="pos_10" value="<?php echo getPOSChecker("73","pos_10"); ?>">
<input type="hidden" id="pos_11" value="<?php echo getPOSChecker("73","pos_11"); ?>">
<input type="hidden" id="pos_12" value="<?php echo getPOSChecker("73","pos_12"); ?>">
<input type="hidden" id="pos_13" value="<?php echo getPOSChecker("73","pos_13"); ?>">
<input type="hidden" id="pos_14" value="<?php echo getPOSChecker("73","pos_14"); ?>">
<input type="hidden" id="pos_15" value="<?php echo getPOSChecker("73","pos_15"); ?>">
<input type="hidden" id="pos_16" value="<?php echo getPOSChecker("73","pos_16"); ?>">
<input type="hidden" id="pos_17" value="<?php echo getPOSChecker("73","pos_17"); ?>">
<input type="hidden" id="pos_18" value="<?php echo getPOSChecker("73","pos_18"); ?>">
<input type="hidden" id="pos_19" value="<?php echo getPOSChecker("73","pos_19"); ?>">
<input type="hidden" id="pos_20" value="<?php echo getPOSChecker("73","pos_20"); ?>">
<input type="hidden" id="pos_21" value="<?php echo getPOSChecker("73","pos_21"); ?>">
<input type="hidden" id="pos_22" value="<?php echo getPOSChecker("73","pos_22"); ?>">
<input type="hidden" id="pos_23" value="<?php echo getPOSChecker("73","pos_23"); ?>">
<input type="hidden" id="pos_24" value="<?php echo getPOSChecker("73","pos_24"); ?>">
<input type="hidden" id="pos_25" value="<?php echo getPOSChecker("73","pos_25"); ?>">
<input type="hidden" id="alert_running_order" value="<?php echo lang('alert_running_order'); ?>">
<input type="hidden" id="alert_running_order1" value="<?php echo lang('alert_running_order1'); ?>">
<input type="hidden" id="customer_address_msg" value="<?php echo lang('customer_address_msg'); ?>">
<input type="hidden" id="is_direct_sale_check" value="2">
<input type="hidden" id="kot_print" value="">
<input type="hidden" id="counter_id" value="<?php echo escape_output($this->session->userdata('counter_id')); ?>">
<input type="hidden" id="counter_name" value="<?php echo escape_output($this->session->userdata('counter_name')); ?>">
<input type="hidden" id="inv_qr_code_enable_status" value="<?php echo escape_output($this->session->userdata('inv_qr_code_enable_status')); ?>">
<input type="hidden" id="apply_on_delivery_charge" value="<?php echo escape_output($this->session->userdata('apply_on_delivery_charge')); ?>">
<input type="hidden" id="is_click_transfer_table" value="">
<input type="hidden" id="active_transfer_table" value="">
<input type="hidden" id="active_transfer_sale_id" value="">
<input type="hidden" id="is_first" value="1">
<input type="hidden" id="alert_running_order" value="<?php echo lang('alert_running_order'); ?>">
<input type="hidden" id="alert_running_order1" value="<?php echo lang('alert_running_order1'); ?>">
<input type="hidden" id="customer_address_msg" value="<?php echo lang('customer_address_msg'); ?>">
<input type="hidden" id="please_select_a_table_for_action" value="<?php echo lang('please_select_a_table_for_action'); ?>">
<input type="hidden" id="you_are_ordering_now_on_your_selected_table" value="<?php echo lang('you_are_ordering_now_on_your_selected_table'); ?>">
<input type="hidden" id="not_booked_yet" value="<?php echo lang('not_booked_yet'); ?>">
<input type="hidden" id="transfer_transferred_msg" value="<?php echo lang('transfer_transferred_msg'); ?>">
<?php if($is_self_order!="Yes"){?>
    <input type="hidden" id="edit_sale_id" value="<?php echo $sale_details->id??''?>">
    <input type="hidden" id="edit_sale_no" value="<?php echo $sale_details->sale_no??''?>">
    <input type="hidden" id="edit_sale_date" value="<?php echo $sale_details->sale_date??''?>">
    <input type="hidden" id="edit_date_time" value="<?php echo $sale_details->date_time??''?>">
    <div style="display:none" class="edit_content_object"><?php echo $sale_details->self_order_content??''?></div>
    <?php } ?>
<input type="hidden" id="no_item_error" value="<?php echo lang('no_item_error'); ?>">
<input type="hidden" id="please_select_your_kitchen_for_print" value="<?php echo lang('please_select_your_kitchen_for_print'); ?>">
<input type="hidden" id="inv_paid_ticket" value="<?php echo lang('paid_ticket'); ?>">
<input type="hidden" id="write_your_reason" value="<?php echo lang('write_your_reason'); ?>">
<input type="hidden" id="write_your_reason_remove" value="<?php echo lang('write_your_reason_remove'); ?>">
<input type="hidden" id="lang_order" value="<?php echo lang('order'); ?>">
<input type="hidden" id="lang_order_type" value="<?php echo lang('order_type'); ?>">
<input type="hidden" id="lang_table" value="<?php echo lang('table'); ?>">
<input type="hidden" id="lang_waiter" value="<?php echo lang('waiter'); ?>">
<input type="hidden" id="lang_customer" value="<?php echo lang('customer'); ?>">
<input type="hidden" id="not_merge_yet" value="<?php echo lang('not_merge_yet'); ?>">
<input type="hidden" id="order_success_updated" value="<?php echo lang('order_success_updated'); ?>">
<input type="hidden" id="order_success_added" value="<?php echo lang('order_success_added'); ?>">
<input type="hidden" id="is_click_merge_table" value="">
<input type="hidden" id="already_merge" value="<?php echo lang('already_merge'); ?>">
<input type="hidden" id="at_least_select_two_table" value="<?php echo lang('at_least_select_two_table'); ?>">
<input type="hidden" id="are_you_sure_for_pull" value="<?php echo lang('are_you_sure_for_pull'); ?>">
<input type="hidden" id="pulled_successfully" value="<?php echo lang('pulled_successfully'); ?>">
<input type="hidden" id="this_order_engage" value="<?php echo lang('this_order_engage'); ?>">
<input type="hidden" id="zatca_invoice_value" value="">
<input type="hidden" id="kot_print_online_self_order" value="<?php echo escape_output($this->session->userdata('kot_print_online_self_order')); ?>">
<input type="hidden" id="is_edit_click" value="1">
<input type="hidden" id="please_select_a_table_before_placing_an_order" value="<?php echo lang('please_select_a_table_before_placing_an_order'); ?>">
<input type="hidden" id="discount_reason_txt" value="<?php echo lang('discount_reason'); ?>">
<input type="hidden" id="choose_this_for" value="<?php echo lang('choose_this_for'); ?>">
<input type="hidden" id="add_new_item" value="<?php echo lang('add_new_item'); ?>">
<input type="hidden" id="change_table" value="<?php echo lang('change_table'); ?>">
<input type="hidden" id="change_anything_in_an_order" value="<?php echo lang('change_anything_in_an_order'); ?>">
<input type="hidden" id="reset_table_alert" value="<?php echo lang('reset_table_alert'); ?>">
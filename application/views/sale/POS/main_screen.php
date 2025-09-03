<?php
//get company information
$getCompanyInfo = getCompanyInfo();
$data_c = getLanguageManifesto();
$waiter_app_status = $this->session->userdata('is_waiter');
$pre_or_post_payment = $this->session->userdata('pre_or_post_payment');
$is_self_order = $this->session->userdata('is_self_order');
$is_online_order = $this->session->userdata('is_online_order');
$mobile_responsive_checker_self_order = $this->session->userdata('mobile_responsive_checker_self_order');
$mobile_responsive_checker_online_order = $this->session->userdata('mobile_responsive_checker_online_order');
$online_customer_id = escape_output($this->session->userdata('online_customer_id'));

$place_order_tooltip = $this->session->userdata('place_order_tooltip');
$waiter_app_status=isset($waiter_app_status) && $waiter_app_status?$waiter_app_status:'';
$is_self_order_class =isset($is_self_order) && $is_self_order?"self_order_skip":'';


$language_manifesto = $this->session->userdata('language_manifesto');
$designation = $this->session->userdata('designation');
$outlet_id = $this->session->userdata('outlet_id');
$company_id = $this->session->userdata('company_id');
$notification_number = 0;
if(count($notifications)>0){
    $notification_number = count($notifications);
}

/*******************************************************************************************************************
 * This section is to construct menu list****************************************************************************
 *******************************************************************************************************************
 */
$previous_category = 0;

$i = 0;
$menu_to_show = "";
$javascript_obects = "";


function cmp($a, $b)
{
    return strcmp($a->category_id, $b->category_id);
}

if(isset($food_menus) && $food_menus):
    $total_menus = count($food_menus);
    usort($food_menus, "cmp");
    if(isset($outlet_information->food_menu_prices) && $outlet_information->food_menu_prices){
        $previous_price = (array)json_decode($outlet_information->food_menu_prices);
    }else{
        $previous_price = array();
    }
    
    //new_added_zak
    
    if(isset($delivery_price_outlet) && $delivery_price_outlet){
        $delivery_price_outlet = (array)json_decode($outlet_information->delivery_price);
    }else{
        $delivery_price_outlet = array();
    }

    $language_manifesto = $getCompanyInfo->language_manifesto;
 
foreach($food_menus as $single_menus){
    $sale_price_take = $single_menus->sale_price;
    $sale_price_delivery = $single_menus->sale_price;
    //new_added_zak
    $sale_price_delivery_details = getSalePriceDetails(isset($delivery_price_outlet["index_".$single_menus->id]) && $delivery_price_outlet["index_".$single_menus->id]?$delivery_price_outlet["index_".$single_menus->id]:'');
    if(!$sale_price_delivery_details){
        $sale_price_delivery_details = getSalePriceDetails($single_menus->delivery_price);
    }
    $sale_price = 0;
    //end _new_added_zak
    if(str_rot13($language_manifesto)=="eriutoeri"){
        if(isset($outlet_information->food_menu_prices) && $outlet_information->food_menu_prices){
            $previous_price = (array)json_decode($outlet_information->food_menu_prices);
        }else{
            $previous_price = array();
        }

        $sale_price_tmp = isset($previous_price["tmp".$single_menus->id]) && $previous_price["tmp".$single_menus->id]?$previous_price["tmp".$single_menus->id]:'';

        $dine_ta_price = $single_menus->sale_price;
        $sale_ta_price = $single_menus->sale_price_take_away;
        $sale_de_price = $single_menus->sale_price_delivery;

        if(isset($sale_price_tmp) && $sale_price_tmp){
            $sale_price_ = explode("||",$sale_price_tmp);
            $sale_price = isset($sale_price_[0]) && $sale_price_[0]?$sale_price_[0]:$single_menus->sale_price;
            $sale_price_take = isset($sale_price_[1]) && $sale_price_[1]  && $sale_price_[1]?$sale_price_[1]:(isset($single_menus->sale_price_take_away) && $single_menus->sale_price_take_away?$single_menus->sale_price_take_away:$single_menus->sale_price);
            $sale_price_delivery = isset($sale_price_[2]) && $sale_price_[2]?$sale_price_[2]:(isset($single_menus->sale_price_delivery) && $single_menus->sale_price_delivery?$single_menus->sale_price_delivery:$single_menus->sale_price);
            if(!sizeof($deliveryPartners)){
                if(isset($sale_price_[2]) && $sale_price_[2]){
                    $sale_price_delivery = $sale_price_[2];
                }else{
                    $sale_price_delivery = $single_menus->sale_price_delivery;
                }
            }
        }
    }else{
        $sale_price = $single_menus->sale_price;
        if($single_menus->sale_price_take_away && $single_menus->sale_price_take_away!='0.00'){
            $sale_price_take = $single_menus->sale_price_take_away;
        }else{
            $sale_price_take = $single_menus->sale_price;
        }
        if($single_menus->sale_price_delivery && $single_menus->sale_price_delivery!='0.00'){
            $sale_price_delivery = $single_menus->sale_price_delivery;
        }else{
            $sale_price_delivery = $single_menus->sale_price;
        }
    }

    //vr01
    $is_variation = $single_menus->is_variation;

    //checks that whether its new category or not
    $is_new_category = false;
    //get current food category
    $current_category = $single_menus->category_id;
    $veg_status1 = "no";
    if($single_menus->veg_item=="Veg Yes"){
        $veg_status1 = "yes";
    }
    $beverage_status = "no";
    if($single_menus->beverage_item=="Bev Yes"){
        $beverage_status = "yes";
    }
    $bar_status_pos = "no";
    //check for promotion
    $is_promo = '';
    //if it the first time of loop then default previous category is 0
    //if it's 0 then set current category id to $previous category and set first category div
    if($single_menus->parent_id=="0"):
    if($previous_category == 0){
        $previous_category = $current_category;
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';
    }
    //if previous category and current category is not equal. it means it's a new category
    if($previous_category!=$current_category){

        $previous_category = $current_category;
        $is_new_category = true;
    }

    //if category is new and total menus are not finish yet then set exit to previous category and create new category
    //div
    if($is_new_category==true && $total_menus!=$i){
        $menu_to_show .= '</div>';
        $menu_to_show .= '<div id="category_'.$single_menus->category_id.'" class="specific_category_items_holder">';
    }
    $img_size = "images/".$single_menus->photo;
    if(file_exists($img_size) && $single_menus->photo!=""){
        $image_path = base_url().'images/'.$single_menus->photo;
    }else{
        $image_path = base_url().'images/image_thumb.png';
    }

    $food_menu_tooltip = $this->session->userdata('food_menu_tooltip');
    $item_name_c = '';
    if($food_menu_tooltip=="show"){
        $item_name_c = "item_name_tippy";
    }
    //construct new single item content
    $menu_to_show .= '<div class="single_item animate__animated animate__flipInX" data-price="'.$sale_price.'"  data-price_take="'.$sale_price_take.'"  data-price_delivery="'.$sale_price_delivery.'" data-is_variation="'.$is_variation.'"  id="item_'.$single_menus->id.'">';
    $menu_to_show .= '<img src="'.$image_path.'" alt="" width="142">';
        $menu_to_show .= '<p class="item_name '.$item_name_c.'" data-tippy-content="'.$single_menus->name.'">'.$single_menus->name.'</p>';
    $menu_to_show .= '<p class="item_price">'.lang('price').': <span id="price_'.$single_menus->id.'">'.getAmtP($sale_price).'</span></p>';
    $menu_to_show .= '</div>';
    //if its the last content and there is no more category then set exit to last category
    if($is_new_category==false && $total_menus==$i){
        $menu_to_show .= '</div>';
    }
    endif;
    //checks and hold the status of veg item
    if($single_menus->veg_item=='Veg Yes'){
        $veg_status = "VEG";
    }else{
        $veg_status = "";
    }

    //checks and hold the status of beverage item
    if($single_menus->beverage_item=='Beverage Yes'){
        $soft_status = "BEV";
    }else{
        $soft_status = "";
    }

    //checks and hold the status of bar item
    $bar_status = "";
    $modifiers = '';
    $j=1;
    foreach($menu_modifiers as $single_menu_modifier){
        if($single_menu_modifier->food_menu_id==$single_menus->id){
            if($j==count($menu_modifiers)){
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',modifier_row_id:'".$single_menu_modifier->id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'}";
            }else{
                $modifiers .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',modifier_row_id:'".$single_menu_modifier->id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'},";
            }

        }
        $j++;
    }
    if($modifiers!=''){
        $is_promo = "Yes";
    }
    //this portion construct javascript objects, it is used to search item from search input
    if($single_menus->parent_id!='0'){
        $item_name_tmp = getParentNameTemp($single_menus->parent_id).(isset($single_menus->name) && $single_menus->name?''.getPlanText($single_menus->name):'');
    }else{
        $item_name_tmp = getPlanText($single_menus->name);
    }
    //new_added_zak
    $product_comb = '';
    if($single_menus->product_type==2){
        $product_comb = getDetailsCombo($single_menus->id);
    }

    $today = date("Y-m-d",strtotime('today'));
    $promo_checker = (Object)checkPromotionWithinDatePOS($today,$single_menus->id);
    $get_food_menu_id = '';
    $string_text = '';
    $get_qty = 0;
    $qty = 0;
    $discount = '';
    $promo_type = '';
    $modal_item_name_row = '';

    if(isset($promo_checker) && $promo_checker && $promo_checker->status){
        $get_food_menu_id = $promo_checker->get_food_menu_id;
        $string_text = $promo_checker->string_text;
        $get_qty = $promo_checker->get_qty;
        $qty = $promo_checker->qty;
        $discount = $promo_checker->discount;
        $promo_type = $promo_checker->type;
        $modal_item_name_row = getParentNameTemp($single_menus->parent_id).getFoodMenuNameCodeById($get_food_menu_id);
        $is_promo = "Yes";
    }

    if($total_menus==$i){
        $javascript_obects .= "{item_id:'".$single_menus->id."',kitchen_id:'".$single_menus->kitchen_id."',kitchen_name:'".$single_menus->kitchen_name."',is_promo:'".$is_promo."',qty:'".$qty."',modal_item_name_row:'".$modal_item_name_row."',promo_type:'".$promo_type."',get_food_menu_id:'".$get_food_menu_id."',string_text:'".$string_text."',get_qty:'".$get_qty."',discount:'".$discount."',parent_id:'".$single_menus->parent_id."',product_type:'".$single_menus->product_type."',product_comb:'".$product_comb."',is_variation:'".$is_variation."',item_code:'".getPlanText($single_menus->code)."',category_name:'".getPlanText($single_menus->category_name)."',item_name:'".getPlanText($single_menus->name)."',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',item_name_tmp:'".getPlanText($item_name_tmp)."',price:'".getAmtP($sale_price)."',price_take:'".getAmtP($sale_price_take)."',price_delivery:'".getAmtP($sale_price_delivery)."',price_delivery_details:'".($sale_price_delivery_details)."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'0',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',sold_for:'".$single_menus->item_sold."',veg_item_status:'".$veg_status1."',beverage_item_status:'".$beverage_status."',modifiers:[".$modifiers."]}";
    }else{
        $javascript_obects .= "{item_id:'".$single_menus->id."',kitchen_id:'".$single_menus->kitchen_id."',kitchen_name:'".$single_menus->kitchen_name."',is_promo:'".$is_promo."',qty:'".$qty."',modal_item_name_row:'".$modal_item_name_row."',promo_type:'".$promo_type."',get_food_menu_id:'".$get_food_menu_id."',string_text:'".$string_text."',get_qty:'".$get_qty."',discount:'".$discount."',parent_id:'".$single_menus->parent_id."',product_type:'".$single_menus->product_type."',product_comb:'".$product_comb."',is_variation:'".$is_variation."',item_code:'".getPlanText($single_menus->code)."',category_name:'".getPlanText($single_menus->category_name)."',item_name:'".getPlanText($single_menus->name)."',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',item_name_tmp:'".getPlanText($item_name_tmp)."',price:'".getAmtP($sale_price)."',price_take:'".getAmtP($sale_price_take)."',price_delivery:'".getAmtP($sale_price_delivery)."',price_delivery_details:'".($sale_price_delivery_details)."',image:'".$image_path."',tax_information:'".$single_menus->tax_information."',vat_percentage:'0',veg_item:'".$veg_status."',beverage_item:'".$soft_status."',sold_for:'".$single_menus->item_sold."',veg_item_status:'".$veg_status1."',beverage_item_status:'".$beverage_status."',modifiers:[".$modifiers."]},";
    }
    //end_new_added_zak


    //increasing always with the number of loop to check the number of menus
    $i++;

}
endif;

$j = 1;
$javascript_obects_modifier = "";
foreach($menu_modifiers as $single_menu_modifier){
    if($j==count($menu_modifiers)){
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'}";
    }else{
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'},";
    }
    $j++;
}
$j = 1;
$javascript_obects_modifier = "";
foreach($menu_modifiers as $single_menu_modifier){
    if($j==count($menu_modifiers)){
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'}";
    }else{
        $javascript_obects_modifier .="{menu_modifier_id:'".$single_menu_modifier->modifier_id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'},";
    }
    $j++;
}

$j = 1;
$javascript_obects_only_modifier = "";
foreach($only_modifiers as $single_menu_modifier){
    if($j==count($only_modifiers)){
        $javascript_obects_only_modifier .="{menu_modifier_id:'".$single_menu_modifier->id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'}";
    }else{
        $javascript_obects_only_modifier .="{menu_modifier_id:'".$single_menu_modifier->id."',menu_modifier_name:'".getPlanText($single_menu_modifier->name)."',tax_information:'".$single_menu_modifier->tax_information."',menu_modifier_price:'".getAmtP($single_menu_modifier->price)."'},";
    }
    $j++;
}

/*******************************************************************************************************************
 * End of This secion is to construct menu list*********************************************************************
 *******************************************************************************************************************
 */

/*******************************************************************************************************************
 * This section is to construct category ****************************************************************************
 *******************************************************************************************************************
 */
$i = 1;
$kitchens_objects = '';
$all_kitchen_id = "";
$total_kitchens = count($kitchens);
foreach($kitchens as $kitchen){
    $all_kitchen_id .= $kitchen->id;
    if($total_kitchens==$i){
        $kitchens_objects .= "{kitchen_id:'".$kitchen->id."',kitchen_name:'".getPlanText($kitchen->name)."',printer_id:'".$kitchen->printer_id."'}";
    }else{
        $all_kitchen_id .= ",";
        $kitchens_objects .= "{kitchen_id:'".$kitchen->id."',kitchen_name:'".getPlanText($kitchen->name)."',printer_id:'".$kitchen->printer_id."'},";
    }
    $i++;
}
 

/*******************************************************************************************************************
 * End of This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */


/*******************************************************************************************************************
 * This section is to construct category ****************************************************************************
 *******************************************************************************************************************
 */
$i = 1;
$cateogry_slide_to_show = '';
foreach($menu_categories as $single_category){

    if($i = 1){
        $cateogry_slide_to_show .= '<li><a href="#" class="category_button" id="button_category_'.$single_category->id.'">'.getPlanText($single_category->category_name).'</a></li>';

    }else{
        $cateogry_slide_to_show .= '<li><a href="#" class="category_button" id="button_category_'.$single_category->id.'">'.getPlanText($single_category->category_name).'</a></li>';
    }

}
/*******************************************************************************************************************
 * End of This secion is to construct category ****************************************************************************
 *******************************************************************************************************************
 */
/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
$customers_option = '';
$total_customers = count($customers);
$i = 1;
$customer_objects = '';
$check_walk_in_customer = 1;
foreach ($customers as $customer){
    //set default customer for pos screen
    $selected = "";
    $default_customer = $getCompanyInfo->default_customer;
    if($customer->id==$default_customer){
        $selected = "selected";
    }
    if($is_online_order=="Yes"){
        if($customer->id==$online_customer_id){
            $selected = "selected";
        }
    }
    //set current due
    $current_due = 0;
    if($customer->id!=1){
        $current_due = getCustomerDue($customer->id);
    }

    if($customer->id==1){
        $check_walk_in_customer++;
    }
    if($customer->name=='Walk-in Customer'){
        $customers_option = '<option '.$selected.' data-default_discount="'.$customer->default_discount.'" data-same_or_diff_state="'.$customer->same_or_diff_state.'" data-customer_address="'.getPlanText($customer->address).'" data-customer_gst_number="'.getPlanText($customer->gst_number).'" data-current_due="'.$current_due.'" value="'.$customer->id.'" selected>'.(getPlanText($customer->name)).' '.$customer->phone.'</option>'.$customers_option;
    }else{
        $customers_option .= '<option '.$selected.' data-default_discount="'.$customer->default_discount.'" data-same_or_diff_state="'.$customer->same_or_diff_state.'"  data-customer_address="'.getPlanText($customer->address).'" data-customer_gst_number="'.getPlanText($customer->gst_number).'" data-current_due="'.$current_due.'" value="'.$customer->id.'" '.$selected.'>'.(getPlanText($customer->name)).' '.$customer->phone.'</option>';
    }

    if($total_customers==$i){
        $customer_objects .= "{customer_id:'".$customer->id."',default_discount:'".$customer->default_discount."',same_or_diff_state:'".$customer->same_or_diff_state."',customer_name:'".(getPlanText($customer->name))."',customer_address:'".getPlanText($customer->address)."',gst_number:'".$customer->gst_number."'}";
    }else{
        $customer_objects .= "{customer_id:'".$customer->id."',default_discount:'".$customer->default_discount."',same_or_diff_state:'".$customer->same_or_diff_state."',customer_name:'".(getPlanText($customer->name))."',customer_address:'".getPlanText($customer->address)."',gst_number:'".$customer->gst_number."'},";
    }

    $i++;
}

if($check_walk_in_customer==1 && $customers_option==""){
    $customers_option .= '<option selected data-default_discount="0" data-current_due="" value="1">Walk-in Customer</option>';
    $customer_objects .= "{customer_id:'1',customer_name:'Walk-in Customer',customer_address:'',gst_number:''}";
}else if($check_walk_in_customer==1 && $customers_option){
    $customers_option .= '<option selected data-default_discount="0" data-current_due="" value="1">Walk-in Customer</option>';
    $customer_objects .= ",{customer_id:'1',customer_name:'Walk-in Customer',customer_address:'',gst_number:''}";
}

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */

/********************************************************************************************************************
 * This section is to construct options of customer select input*****************************************************
 * ******************************************************************************************************************
 */
$waiters_option = '';
$default_waiter_id = 0;
$outlet = getOutletById($this->session->userdata('outlet_id'));
foreach ($waiters as $waiter){
    $selected = "";
    $role = $this->session->userdata('role');
    $user_id = $this->session->userdata('user_id');
    if(str_rot13($language_manifesto)=="eriutoeri"):
        $default_waiter = $outlet->default_waiter;
    else:
        $default_waiter = $getCompanyInfo->default_waiter;
    endif;

    if($waiter->id==$default_waiter){
        $selected = "selected";
        $default_waiter_id = $waiter->id;
    }else{
        if(isset($role) && $role!="Admin"){
            if($waiter->id==$user_id){
                $selected = "selected";
                $default_waiter_id = $user_id;
            }
        }
    }
    $designation = $this->session->userdata('designation');
    if($designation=="Waiter"){
        if($waiter->id==$user_id){ 
            $selected = "selected";
            $default_waiter_id = $user_id;
        }
    }
    if($waiter->full_name=='Default Waiter'){
        $waiters_option = '<option '.$selected.' value="'.$waiter->id.'">'.getPlanText($waiter->full_name).'</option>'.$waiters_option;
    }else{
        $waiters_option .= '<option '.$selected.' value="'.$waiter->id.'">'.getPlanText($waiter->full_name).'</option>';
    }

}

/********************************************************************************************************************
 * End This section is to construct table modal's content****************************************************************
 ********************************************************************************************************************
 **/

/************************************************************************************************************************
 * Construct new orders those are still on processing *******************************************************************
 * **********************************************************************************************************************
 */


/************************************************************************************************************************
 * Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */
$payment_method_options = '';

foreach ($payment_methods as $payment_method){
    $selected = "";
    $default_payment = $getCompanyInfo->default_payment;
    if($payment_method->id==$default_payment){
        $selected = "selected";
    }
    $payment_method_options .= '<option '.$selected.' value="'.$payment_method->id.'">'.$payment_method->name.'</option>';
}

/************************************************************************************************************************
 * End of Construct payment method drop down ***********************************************************************************
 * **********************************************************************************************************************
 */


/************************************************************************************************************************
 * Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */
$notification_list_show = '';

foreach ($notifications as $single_notification){
    $notification_list_show .= '<div class="single_row_notification fix" id="single_notification_row_'.$single_notification->id.'">';
    $notification_list_show .= '<div class="fix single_notification_check_box">';
    $notification_list_show .= '<input class="single_notification_checkbox" type="checkbox" id="single_notification_'.$single_notification->id.'" value="'.$single_notification->id.'">';
    $notification_list_show .= '</div>';
    $notification_list_show .= '<div class="fix single_notification">'.$single_notification->notification.'</div>';
    $notification_list_show .= '<div class="fix single_serve_button">';
    $notification_list_show .= '<button class="single_serve_b" id="notification_serve_button_'.$single_notification->id.'">'.lang('serve_take_delivery').'</button>';
    $notification_list_show .= '</div>';
    $notification_list_show .= '</div>';

}

/************************************************************************************************************************
 * End of Construct notification list ***********************************************************************************
 * **********************************************************************************************************************
 */



?>

<?php
    $wl = getWhiteLabel();
    $favicon = '';
    if($wl){
        if($wl->site_name){
            $site_name = $wl->site_name;
        }
        if($wl->footer){
            $footer = $wl->footer;
        }
        if($wl->system_logo){
            $system_logo = base_url()."images/".$wl->system_logo;
        }else{
            $system_logo = base_url()."images/logo.png";
        }
        if($wl->favicon){
            $favicon = base_url()."images/".$wl->favicon;
        }else{
            $favicon = base_url()."images/favicon.ico";
        }
    }
    ?>
<!DOCTYPE html>
<html>

<head>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title><?php echo escape_output($site_name); ?></title>
    <script src="<?php echo base_url()?>assets/POS/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/POS/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/POS/css/style2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/POS/css/customModal.css">
    <script src="<?php echo base_url(); ?>assets/graph/go.js"></script>
    <script src="<?php echo base_url(); ?>assets/graph/dom-to-image.min.js"></script>
    <!-- font awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free-6.5.1-web/css/all.min.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/lib/font_awesomeV5P/css/pro.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font_awesomeV5P/css/pro.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/iCheck/minimal/color-scheme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/jquery-ui.css">
    <!-- For Tooltips -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/lib/tippy/tippy.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/lib/tippy/scale.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/lib/tippy/theme_light.css">
    <!-- Customer Scrollbar js -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/lib/scrollbar/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/common.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/custom_css.css">

    <script src="<?php echo base_url()?>assets/POS/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/lib/scrollbar/slimScrollbar.js"></script>
    <!-- Sweet alert -->
    <script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/css/custom_pos.css">
    <!--notification for waiter panel-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/notify/jquery.notifyBar.css">
    <script type="text/javascript"
        src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/calculator.js"></script>

    <!--for delivery_partner-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/delivery_partner.css">
    <link href="<?php echo base_url(); ?>frequent_changing/notify/toastr.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>frequent_changing/css/register_details.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>frequent_changing/js/jquery.spincrement.js"></script>
    <base data-base="<?php echo base_url(); ?>">
    </base>
    <base data-collect-tax="<?php echo escape_output($getCompanyInfo->collect_tax); ?>">
    </base>
    <base data-currency="">
    </base>
    <base data-role="<?php echo escape_output($this->session->userdata('role')); ?>">
    </base>
    <base data-collect-gst="<?php echo escape_output($getCompanyInfo->tax_is_gst); ?>">
    </base>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($favicon) ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/POS/css/datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/POS/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/POS/css/lib/perfect-scrollbar/css/perfect-scrollbar.css">

    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/custom_card_design_zak.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/jquery-ui.structure.css">


    <style>
    <?php
    if($waiter_app_status=="Yes"): ?>

    .full-width-for-waiter {
        width: 100% !important;
    }
    .no-need-for-waiter {
        display: none !important;
    }
    <?php endif;
    if($is_self_order=="Yes" || $is_online_order=="Yes"):?>
        #main_part .left_item .main_middle #bottom_absolute .bottom__info .main_bottom .button_group {
            grid-template-columns: repeat(2, 1fr);
        }
    <?php endif;
    ?>

        .menu-header.small{
            color: #8f8f8f;
            padding-left: 10px;
            padding-top: 15px;
        }
        .menu-header-text{
            font-size: 13px !important;
        }
        #pos__sidebar svg{
            width: 20px;
            color: #6e6b7b;

        }
        #pos__sidebar .have_sub_menu > a::after {
            content: "\f067";
            font-family: "fontAwesome";
            font-size: 12px;
            color: #6e6b7b;
            position: absolute;
            right: 5px;
            top: 18px;
            transform: rotate(180deg);
            z-index: 1;
            transition: all 0.3s;
        }
        aside#pos__sidebar .pos__menu__list .sub__menu__list {
            list-style-type: none;
            display: none;
            padding-left: 0px;
            margin-left: 10px;
            padding-right: 15px;
            position: relative;
        }
        #pos__sidebar .sub__menu__list::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            width: 1px;
            height: 100%;
            background-color: #d6d6ef;
        }
        aside#pos__sidebar .pos__menu__list .sub__menu__list li:hover {
            color: #8b5cf6;
            background-color: rgba(209, 196, 196, 0.168627451);
            border-radius: 8px;
        }
        aside#pos__sidebar .pos__menu__list .sub__menu__list li:hover a {
            color: #8b5cf6;
        }
        aside#pos__sidebar .pos__menu__list .have_sub_menu.active .sub__menu__list li {
            padding-left: 32px;
        }
        #pos__sidebar .have_sub_menu.active > a::after {
            content: "\f068";
            transform: rotate(180deg);
        }
    </style>
</head>

<body>
    <?php $this->view('sale/POS/hidden_input_html'); ?>

    <?php
    $invoice_logo = $this->session->userdata('invoice_logo');
    if($invoice_logo):
    ?>
    <input type="hidden" id="invoice_logo" value="<?=escape_output($invoice_logo)?>">
        <?php
    endif;
    ?>
    <input type="hidden" id="all_kitchen_id" value="<?php echo escape_output($all_kitchen_id)?>">

    <div class="preloader">
        <div class="loader"><?php echo lang('loading'); ?></div>
    </div>

    <span id="stop_refresh_for_search" class="ir_display_none"><?php echo lang('yes'); ?></span>
    <div id="main-wrapper-content" class="wrapper">
        <!-- Main Header Part -->
        <div class="top_header_part <?php echo escape_output($is_self_order_class)?'self_order_mode':'' ?>">
            <div class="left_item">
                <div class="header_part_middle">

                    <ul class="icon__menu">
                        <?php if($is_self_order_class):
                            $online_login = 'none';
                            $online_without_login = 'none';

                            if($online_customer_id){
                                $online_login = '';
                            }else{
                                $online_without_login = '';
                            }
                            ?>
                            <li class="self_order_and_online_order" style="display:<?php echo escape_output($online_login)?>">
                                <a href="<?php echo base_url();?>authentication/logout" class="bg__blue irp_my_orders"
                                ><i class="fa fa-sign-out"> </i> <?php echo lang('back'); ?></a>
                            </li>
                            <li class="self_order_and_online_order" style="display:<?php echo escape_output($online_without_login)?>">
                                <a href="<?php echo base_url();?>authentication/logout" class="bg__blue irp_my_orders"
                                ><i class="fa fa-sign-out"> </i> <?php echo lang('back'); ?></a>
                            </li>
                            <?php if($is_online_order=="Yes"):?>
                            <li class="self_order_and_online_order">
                                <a href="#" class="bg__blue irp_my_orders online_my_order online_order_after_login" style="display:<?php echo escape_output($online_login)?>"
                                ><i class="fa fa-file"> </i> <?php echo lang('My_Orders'); ?></a>
                            </li>
                            <?php endif?>
                            <?php if($is_self_order=="Yes" && $is_online_order!="Yes"):?>

                            <li class="self_order_and_online_order">
                                <a href="#" class="bg__blue irp_my_orders self_my_order"
                                ><i class="fa fa-file"> </i> <?php echo lang('My_Orders'); ?></a>
                            </li>
                                <?php endif?>
                            <?php if($is_online_order=="Yes"):
                                ?>

                                <li class="self_order_and_online_order online_order_before_login"   style="display:<?php echo escape_output($online_without_login)?>">
                                    <a href="#" data-title="<?php echo lang('signup'); ?>" class="bg__blue irp_my_orders plus_button plus_button_online_order"
                                    ><i class="fa fa-plus"> </i> <?php echo lang('signup'); ?></a>
                                </li>
                                <li class="self_order_and_online_order online_order_before_login"  style="display:<?php echo escape_output($online_without_login)?>">
                                    <a href="#" class="bg__blue irp_my_orders login_modal_btn"
                                    ><i class="fa fa-sign-in"> </i> <?php echo lang('login'); ?></a>
                                </li>
                                <li class="self_order_and_online_order online_order_after_login" style="display:<?php echo escape_output($online_login)?>">
                                    <a href="#" data-title_custom="<?php echo lang('edit_profile'); ?>"  data-title="<?php echo lang('edit_profile'); ?>"  class="bg__blue irp_my_orders edit_customer"
                                    ><i class="fa fa-edit"> </i> <?php echo lang('edit_profile'); ?></a>
                                </li>
                                <li class="online_order_after_login" style="display:<?php echo escape_output($online_login)?>">
                                    <a href="<?php echo base_url();?>online_order_logout" class="bg__blue irp_my_orders"
                                    ><i class="fa fa-sign-out"> </i> <?php echo lang('logout'); ?></a>
                                </li>
                            <?php endif;?>
                        <?php else:?>
                            <li>
                                <a href="<?php echo base_url();?>Authentication/logOut"  data-tippy-content="<?php echo lang('logout'); ?>" class="header_menu_icon logout_for_user"
                                ><i class="fa fa-sign-out"> </i></a>
                            </li>
                        <?php endif;?>
                        <li class="has__children <?php echo escape_output($is_self_order_class) ?>">
                            <a href="#" class="header_menu_icon" data-tippy-content="<?php echo lang('language'); ?>">
                                <i class="fal fa-globe"></i>
                            </a>
                            <ul class="sub__menu" role="menu">
                                <?php $language = $this->session->userdata('language');
                                    if(!$language){
                                        $language = "english";
                                    }
                                ?>
                                <?php
                                $dir = glob("application/language/*",GLOB_ONLYDIR);
                                foreach ($dir as $value):
                                    $separete = explode("language/",$value);
                                    ?>
                                <li class="<?=isset($language) && $language==$separete[1]?'active_lng':''?>"><a
                                       class="action_main_menu" data-url="<?php echo base_url(); ?>Authentication/setlanguagePOS/<?=escape_output($separete[1])?>" href="#"><?php echo escape_output(ucfirstcustom($separete[1]))?></a>
                                </li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>

                        <li>
                            <a href="#" id="open_hold_sales" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                                data-tippy-content="<?php echo lang('open_hold_sale'); ?>">
                                <i class="fal fa-folder-open"></i>
                            </a>
                        </li>
                        <li><a href="javascript:void(0)" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>" id="print_last_invoice"
                                data-tippy-content="<?php echo lang('print_last_invoice'); ?>"><i
                                    class="fal fa-print"></i></a></li>
                        <li>
                            <a href="#" id="last_ten_sales_button" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                                data-tippy-content="<?php echo lang('recent_sales'); ?>"><i
                                    class="fal fa-history"></i></a>
                        </li>
                        <li>
                            <a href="#" id="last_ten_feature_button" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                                data-tippy-content="<?php echo lang('feature_sales'); ?>"><i
                                    class="fas fa-shopping-bag"></i></a>
                        </li>
                        <li>
                            <a href="#" class="last_ten_self_button header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                               data-tippy-content="<?php echo lang('self_online_orders'); ?>"><i
                                        class="fa fa-qrcode"></i></a>
                        </li>
                        <li>
                            <a href="#" data-title="<?php echo lang('reservation_list'); ?>" class="reservation_list header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                               data-tippy-content="<?php echo lang('reservation_list'); ?>"><i
                                        class="fa fa-ticket"></i></a>
                        </li>


                        <li>
                            <a href="#" id="notification_button" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>"
                                data-tippy-content="<?php echo lang('kitchen_notification'); ?>">
                                <i class="fal fa-bell"></i>
                                <span id="notification_counter"
                                    class="c_badge <?php echo escape_output($notification_number)?'':'txt_11'?>"><?php echo escape_output($notification_number); ?></span>
                            </a>
                        </li>
                        <?php    if($designation!="Waiter"):?>
                        <li>
                            <a href="#" id="register_details" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?> register_details"
                                data-tippy-content="<?php echo lang('register'); ?>">
                                <i class="fal fa-registered"></i>
                            </a>
                        </li>
                        <?php endif?>
                        <li>
                            <a href="#" class="header_menu_icon <?php echo escape_output($is_self_order_class) ?>" id="go_to_dashboard" data-tippy-content="<?php
                                if ($this->session->userdata('role') == 'Admin') {
                                    echo lang('dashboard');
                                }else{
                                    echo lang('back');
                                }
                                ?>">
                                <i class="fal fa-tachometer-alt-fast"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>customer-panel" class="header_menu_icon  <?php echo escape_output($is_self_order_class) ?>" target="_blank"  data-tippy-content="<?php
                            echo lang('customer_panel');
                            ?>">
                                <i class="fal fa-desktop"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()?>order-status-screen" class="header_menu_icon  <?php echo escape_output($is_self_order_class) ?>" target="_blank"  data-tippy-content="<?php
                            echo lang('order_status_screen');
                            ?>">
                                <i class="fa fa-desktop"></i>
                            </a>
                        </li>

                    </ul>
                    <ul class="icon__menu <?php echo escape_output($is_self_order_class) ?>">
                        <li><a href="javascript:void(0)"  class="header_menu_icon fullscreen"
                                data-tippy-content="<?php echo lang('fullscreen_1'); ?>"><i
                                    class="fal fa-expand-arrows-alt"></i></a></li>
                        <li>
                            <a href="#" data-tippy-content="<?php echo lang('main_menu'); ?>" id="open__menu"
                                class="header_menu_icon">
                                <i class="fal fa-align-justify"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Header Menu List-->
            <div class="header_part_right">
                <ul class="btn__menu btn__menu_left <?php echo escape_output($is_self_order_class) ?>">
                    <li>
                        <div class="pos_outlet_info irestora_font_div_pos"><?php echo escape_output($this->session->userdata('outlet_name'))?></div>
                    </li>
                </ul>
                <ul class="btn__menu">
                    <li class="<?php echo escape_output($is_self_order_class) ?>">
                        <a href="#" id="pull_running_order" data-tippy-content="Pull your running orders" class="header_menu_icon bg__red"><i class="fas fa-exchange-alt"></i></a>
                    </li>
                  
                    <li class="<?php echo escape_output($is_self_order_class) ?>">
                        <a href="#" id="sync_online" data-tippy-content="(0)<?php echo lang('sales_currently_in_local'); ?>" class="header_menu_icon bg__green"><i class="fas fa-sync"></i></a>
                    </li>
                    <li class="<?php echo escape_output($is_self_order_class) ?>">
                        <a href="#" id="pull_others_device_orders" data-tippy-content="<?php echo lang('pull_others_device_orders'); ?>" class="header_menu_icon bg__green"><i class="fas fa-exchange-alt"></i></a>
                    </li>
                    <li class="<?php echo escape_output($is_self_order_class) ?>">
                        <a href="#" id="online_status" class="bg__green"><span class="online_status_counter display_none">(0)</span><span class="online_status_text"><?php echo lang('online'); ?></span></a>
                    </li>
                    <li><a href="#" data-status="veg"
                            class="veg_bev_item bg__green"><?php echo lang('vegetarian_items'); ?></a></li>
                    <li><a href="#" data-status="bev"
                            class="veg_bev_item bg__grey"><?php echo lang('beverage_items'); ?></a></li>
                    <li><a href="#" data-status="combo" id="combo_item"
                           class="bg__khoyre"><?php echo lang('combo'); ?></a></li>
                    <li><a href="#" data-status=""
                           class="get_prom_details bg__pink"><?php echo lang('View_Promo'); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="top_header_for_mobile <?php echo escape_output($is_self_order_class)?'self_order_mode':'' ?>">
            <div class="for-table-mode <?php echo escape_output($is_self_order_class)?'self_order_mode':'' ?>">
                <?php if($is_self_order_class):?>
               
                <?php else:?>
                    <button type="button" data-isActive="false" class="show_running_order bg__red">
                        <i class="far fa-bags-shopping"></i> <span><?php echo lang('running_order'); ?></span></button>
                <?php endif;?>


                <!-- End Running Order -->
                <div class="type-btn-list button_holder no-need-for-waiter">
                    <button type="button" class="btn_type_temp btn_type_temp_c bg__purple type-dropdown">
                        <i class="far fa-bags-shopping"></i> <span><?php echo lang('type'); ?></span>
                    </button>


                    <?php
                    //for default order type select
                    $default_order_type = $this->session->userdata('default_order_type');
                    $selected = (isset($waiter_app_status) && $waiter_app_status=="Yes"?'active_tmp_btn':(isset($default_order_type) && $default_order_type==1?'active_tmp_btn':''));
                    ?>
                    <div class="btn-list">
                        <button class="tablet_btn type_temp_div <?php echo escape_output($selected)?>" data-id="1">
                            <i class="fal fa-table"></i> <?php echo lang('dine'); ?>
                        </button>
                        <?php
                        //for default order type select
                        $default_order_type = $this->session->userdata('default_order_type');
                        $selected = (isset($default_order_type) && $default_order_type==2?'active_tmp_btn':'');
                        ?>
                        <button class="tablet_btn type_temp_div <?php echo escape_output($selected)?>"  data-id="2"><i class="fal fa-shopping-bag"></i>
                            <?php echo lang('take_away'); ?></button>
                        <?php
                        //for default order type select
                        $default_order_type = $this->session->userdata('default_order_type');
                        $selected = (isset($default_order_type) && $default_order_type==3?'active_tmp_btn':'');
                        ?>
                        <?php
                        if(!isFoodCourt()):
                            ?>
                            <button class="tablet_btn type_temp_div <?php echo escape_output($selected)?>"  data-id="3"><i class="fal fa-truck"></i>
                                <?php echo lang('delivery'); ?></button>
                            <?php
                        elseif($this->session->userdata('role') == 'Admin'):
                            ?>
                            <button class="tablet_btn type_temp_div <?php echo escape_output($selected)?>" <?php echo escape_output($selected)?>  <?php echo escape_output($selected)?> data-id="3"><i class="fal fa-truck"></i>
                                <?php echo lang('delivery'); ?></button>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
                <!-- End Types -->
                <button type="button" id="customer_open" class="bg__pink">
                    <i class="fal fa-user"></i> <span><?php echo lang('customer'); ?></span></button>
                <!-- End Customer -->

                <div class="customer-add-edit">
                    <button  data-title_custom="<?php echo lang('edit_profile'); ?>"  data-title="<?php echo lang('edit_customer'); ?>"  data-tippy-content="<?php echo lang('edit_customer'); ?>"
                        class="header_menu_icon bg__blue edit_customer">
                        <i class="far fa-pencil-alt"></i>
                    </button>
                    <button  data-title="<?php echo lang('add_customer'); ?>"  class="plus_button header_menu_icon bg__khoyre"
                        data-tippy-content="<?php echo lang('add_customer'); ?>">
                        <i class="fal fa-plus"></i>
                    </button>

                    <button type="button" class="bg__purple fullscreen" data-tippy-content="<?php echo lang('fullscreen_1'); ?>">
                        <i class="fal fa-expand-arrows-alt"></i>
                    </button>
                </div>
                <?php
                if(!isFoodCourt()):
                ?>
                <button type="button" id="waiter_open" class="bg__grey">
                    <i class="fal fa-knife-kitchen"></i> <span><?php echo lang('Waiter'); ?></span></button>
                <?php
                endif;
                ?>
                
                <!-- End Customer -->
                <button type="button" class="show_all_menu bg__green">
                    <i class="fal fa-bars"></i> <span><?php echo lang('Others'); ?></span></button>
                <!-- End Others -->

            </div>
            <!-- End Tablet Mode Options -->
            <div class="for-mobile-mode">
                <?php if($is_self_order_class):?>
          
                <?php else:?>
                    <button type="button" data-isActive="false" class="show_running_order bg__red"><span><?php echo lang('running_order'); ?></span></button>
                <?php endif;?>


                <button type="button" class="show_cart_list bg__purple"><span><?php echo lang('Cart'); ?></span></button>
                <button type="button" class="show_product bg__grey"> <span><?php echo lang('Products'); ?></span></button>
                <?php if($is_self_order!="Yes" && $is_online_order=="Yes"):?>
                    <button type="button" class="online_my_order bg__green"> <span><?php echo lang('My_Orders'); ?></span></button>
                <?php else:?>

                    <?php if($is_self_order=="Yes" && $is_online_order!="Yes"):?>
                        <button type="button" class="self_my_order bg__green"> <span><?php echo lang('My_Orders'); ?></span></button>
                    <?php endif?>

                    <button type="button" class="show_all_menu bg__green  <?php echo escape_output($is_self_order_class) ?  $is_self_order_class : '' ?>">
                     <span><?php echo lang('Others'); ?></span></button>
                <?php endif;?>

                <?php if($is_online_order=="Yes"):
                    ?>
                    <button type="button" class="self_order_and_online_order online_order_before_login irp_my_orders plus_button plus_button_online_order bg__green" style="display:<?php echo escape_output($online_without_login)?>"> <span><?php echo lang('signup'); ?></span></button>
                    <button type="button" class="self_order_and_online_order online_order_before_login irp_my_orders login_modal_btn bg__green" style="display:<?php echo escape_output($online_without_login)?>"> <span><?php echo lang('login'); ?></span></button>
                    <button type="button"  data-title_custom="<?php echo lang('edit_profile'); ?>"  class="self_order_and_online_order online_order_after_login irp_my_orders edit_customer bg__green self_order_and_online_order_mobile" style="display:<?php echo escape_output($online_login)?>"> <span><?php echo lang('edit_profile'); ?></span></button>
                    <button type="button" class="self_order_and_online_order online_order_after_login irp_my_orders online_my_order bg__green self_order_and_online_order_mobile" style="display:<?php echo escape_output($online_login)?>"> <span><?php echo lang('My_Orders'); ?></span></button>
                    <button type="button" class="online_order_after_login irp_my_orders bg__red"  style="display:<?php echo escape_output($online_login)?>"> <span> <a href="<?php echo base_url();?>online_order_logout" class="logout_btn_online_order_css"> <?php echo lang('logout'); ?></a></span></button>
                <?php endif;?>

            </div>
            <!-- End Mobile Mode Options -->
        </div>
        <div id="main_part">
            <div class="left_item <?php echo escape_output($is_self_order_class) ? 'self_order_mode':'' ?>">
                <div class="main_left  <?php echo escape_output($is_self_order_class) ?>">
                    <div class="holder">
                        <div id="running_order_header">
                            <h3><?php echo lang('running_order'); ?></h3>
                            <span id="refresh_order"><i class="fas fa-sync-alt"></i></span>
                            <input type="text" name="search_running_orders" id="search_running_orders"
                                autocomplete='off' class="ir_h15_m_w90"
                                placeholder="<?php echo lang('customer_waiter_order_table'); ?>" />
                        </div>

                        <div class="order_details scrollbar-macosx" id="order_details_holder">
                            <!--This variable could not be escaped because this is html content-->
                        
                        </div>
                        <div id="left_side_button_holder_absolute">
                            <?php
                            $display_btn_1 = 'ir_display_none';
                            $display_btn_2 = 'ir_display_none';
                            if($pre_or_post_payment==1):
                                $display_btn_1 = '';
                              else:
                                $display_btn_2 = '';
                             endif; ?>

                            <button class="operation_button " id="modify_order"><i
                                        class="fas fa-edit"></i><?php echo lang('modify_order_'); ?></button>
                            <button class="operation_button no-need-for-waiter fix <?php echo escape_output($display_btn_2)?>" id="close_order_button"><i
                                        class="fas fa-ban"></i>
                                <?php echo lang('close_order'); ?></button>
                            
                            <button class="operation_button fix" id="single_order_details"><i
                                    class="fas fa-info-circle"></i> <?php echo lang('order_details'); ?></button>

                            <div class="ir_flex_jc_w94_pr">
                                <div class="invoice_box_kot">
                                    <button class="kot_btn_class" data-type="1"><?php echo lang('all_items'); ?></button>
                                    <button class="kot_btn_class" data-type="2"><?php echo lang('new_items'); ?></button>
                                </div>
                                <button class="no-need-for-waiter operation_button fix print_kot_button"><i
                                            class="fas fa-print"></i> <?php echo lang('kot_tooltip'); ?></button>
                            </div>
                            <input type="hidden" id="is_split_bill" value="">
                            <input type="hidden" id="split_order_date_time" value="">
                            <input type="hidden" id="split_order_time" value="">
                            <input type="hidden" id="split_charge_type" value="">

                            <div id="update_table_total" class="ir_display_none"></div>
                            <div id="update_table_obj" class="ir_display_none"></div>
                            <div id="update_table_text" class="ir_display_none"></div>

                            <div class="ir_flex_jc_w94_pr margin_top_5">
                                <div class="invoice_box">
                                    <button class="invoice_btn_class" data-type="2"><?php echo lang('split_bill'); ?></button>
                                    <button class="invoice_btn_class" data-type="1"><?php echo lang('single_pay'); ?></button>
                                </div>
                                <button class="ir_calc_w98 operation_button no-need-for-waiter fix"
                                        id="create_invoice_and_close">
                                    <?php echo lang('invoice'); ?>
                                </button>
                                <button
                                        class="operation_button fix ir_calc_w98_m5 no-need-for-waiter btn_tip full-width-for-waiter"
                                        id="create_bill_and_close"
                                        data-tippy-content="<?php echo lang('Print_Bill_for_Customer_Before_Invoicing'); ?>">
                                    <?php echo lang('bill'); ?>
                                </button>
                            </div>

                            <?php
                            if(isset($waiter_app_status) && $waiter_app_status=="Yes" && $getCompanyInfo->printing_kot!="web_browser_popup"):
                                ?>
                                <button class="operation_button fix btn_tip full-width-for-waiter print_kot_button" data-tippy-content="<?php echo lang('print'); ?> <?php echo lang('KOT'); ?>"><i
                                            class="fas fa-print"></i>
                                    <?php echo lang('KOT'); ?></button>
                                <?php
                            endif;
                            ?>
                            <?php
                            if(isset($waiter_app_status) && $waiter_app_status=="Yes" && $getCompanyInfo->printing_bill=="web_browser_popup"):
                                ?>
                                <div class="ir_flex_jc_w94_pr">
                                    <button class="operation_button fix ir_calc_w98_m5 btn_tip full-width-for-waiter"
                                            id="bill_show_details" data-tippy-content="<?php echo lang('Print_Bill_for_Customer_Before_Invoicing'); ?>">
                                        <?php echo lang('bill'); ?>
                                    </button>
                                </div>
                                <?php
                            elseif(isset($waiter_app_status) && $waiter_app_status=="Yes" && $getCompanyInfo->printing_bill!="web_browser_popup"):
                                ?>
                                <div class="ir_flex_jc_w94_pr">
                                    <button class="operation_button fix ir_calc_w98_m5 btn_tip full-width-for-waiter"
                                            id="create_bill_and_close" data-tippy-content="<?php echo lang('bill'); ?>">
                                        <?php echo lang('bill'); ?>
                                    </button>
                                </div>
                                <?php
                            endif;
                            ?>
                            <button class="operation_button no-need-for-waiter fix" id="cancel_order_button"><i
                                        class="fas fa-ban"></i>
                                <?php echo lang('cancel_order'); ?></button>

                        </div>

                    </div>
                </div>
                <div class="main_middle" style="<?php echo escape_output($is_self_order_class)?'width: 100%;':'' ?>">
                    <div class="main_top">
                        <!-- Top Btn -->
                        <div class="button_holder <?php echo escape_output($is_self_order_class) ?> <?php echo isset($is_self_order_class) && $is_self_order_class?'':'no-need-for-waiter' ?>">
                            <?php
                                //for default order type select
                                    $default_order_type = $this->session->userdata('default_order_type');
                                    $selected = (isset($waiter_app_status) && $waiter_app_status=="Yes"?'selected':(isset($default_order_type) && $default_order_type==1?'selected':''));
                                    if($is_online_order=="Yes"){
                                        $selected = '';
                                    }
                            ?>
                            <button class="selected__btn_c  <?php echo escape_output($is_self_order_class) ?> dine_in_button" data-id="dine_in_button"
                                data-selected="<?php echo escape_output($selected)?>">
                                <i class="fal fa-table"></i> <?php echo lang('dine'); ?>
                            </button>

                            <?php
                                //for default order type select
                            $default_order_type = $this->session->userdata('default_order_type');

                            $selected = (isset($default_order_type) && $default_order_type==2?'selected':'');
                            if($is_online_order=="Yes"){
                                $selected = '';
                            }
                            ?>
                            <button class="selected__btn_c  <?php echo escape_output($is_self_order_class) ?> take_away_button" data-selected="<?php echo escape_output($selected)?>" data-id="take_away_button"><i class="fal fa-shopping-bag"></i>
                                <?php echo lang('take_away'); ?></button>

                            <?php
                                //for default order type select
                            $default_order_type = $this->session->userdata('default_order_type');
                            $selected = (isset($default_order_type) && $default_order_type==3?'selected':'');
                            if($is_online_order=="Yes"){
                                $selected = '';
                            }
                            ?>
                            <?php
                            if(!isFoodCourt()):
                            ?>
                                <button class="selected__btn_c  <?php echo escape_output($is_self_order_class) ?> delivery_button" data-selected="<?php echo escape_output($selected)?>" data-id="delivery_button"><i class="fal fa-truck"></i>
                                    <?php echo lang('delivery'); ?></button>
                            <?php
                            elseif($this->session->userdata('role') == 'Admin'):
                            ?>
                                <button class="selected__btn_c  <?php echo escape_output($is_self_order_class) ?> delivery_button" data-selected="<?php echo escape_output($selected)?>" data-id="delivery_button"><i class="fal fa-truck"></i>
                                    <?php echo lang('delivery'); ?></button>
                            <?php
                            endif;
                            ?>
                            <button class="<?php echo escape_output($is_self_order_class) ?>" id="table_button"><i class="fal fa-table"></i> <?php echo lang('table'); ?></button>
                            
                        </div>
                        <?php if($is_self_order=="Yes" && $is_online_order!="Yes"):?>
                            <div class="self_order_table_person_wrapper">
                                <input class="self_order_table_person" id="self_order_table_person" type="number" min="1"  placeholder="<?php echo lang('Table_Person')?>" value="" >
                            </div>
                            <?php endif;?>
                    </div>
                    <!-- End Top Btn -->

                    <div class="waiter_customer">
                        <div class="left_item <?php echo escape_output($is_self_order_class) ?> <?php echo isFoodCourt()?'isFoodCourt':''?>">
                                <?php
                                    if($waiter_app_status=="Yes"):
                                if($is_self_order!="Yes"):
                                ?>
                                <input type="hidden" value="<?php echo escape_output($this->session->userdata('user_id'))?>" id="select_waiter">
                                <input type="hidden" value="<?php echo escape_output($this->session->userdata('full_name'))?>" id="select_waiter_name">
                                    <?php else:?>
                                        <select id="select_waiter" class="select2 select_waiter ir_w92_ml">
                                            <option value=""><?php  echo lang('waiter'); ?></option>
                                            <!--This variable could not be escaped because this is html content-->
                                            <?php echo ($waiters_option); ?>
                                        </select>
                                    <?php endif;?>

                                <button id="table_button" class="half-width-98"><i class="fal fa-table"></i>
                                    <?php echo lang('table'); ?></button>
                                <?php
                                else:
                                    if(!isFoodCourt()):
                                ?>
                                <select id="select_waiter" class="select2 select_waiter ir_w92_ml">
                                    <option value=""><?php  echo lang('waiter'); ?></option>
                                    <!--This variable could not be escaped because this is html content-->
                                    <?php echo ($waiters_option); ?>
                                </select>
                                        <?php
                                  else:
                                      if($is_self_order!="Yes"):
                                    ?>
                                      <input type="hidden" value="<?php echo escape_output($this->session->userdata('user_id'))?>" id="select_waiter">
                                      <input type="hidden" value="<?php echo escape_output($this->session->userdata('full_name'))?>" id="select_waiter_name">
                                          <?php else:?>
                                              <select id="select_waiter" class="select2 select_waiter ir_w92_ml">
                                                  <option value=""><?php  echo lang('waiter'); ?></option>
                                                  <!--This variable could not be escaped because this is html content-->
                                                  <?php echo ($waiters_option); ?>
                                              </select>
                                      <?php
                                          endif;
                                    endif;
                                    ?>
                                <?php
                                endif;
                                ?>
                                <select id="walk_in_customer" id="select_walk_in_customer" class="select2 select_walk_in_customer_custom">
                                    <option value=""><?php echo lang('customer'); ?></option>
                                    <!--This variable could not be escaped because this is html content-->
                                    <?php echo ($customers_option); ?>
                                </select>
                        </div>

                        <div class="separator <?php echo escape_output($is_self_order_class) ?>">
                                <a href="#"  data-title_custom="<?php echo lang('edit_profile'); ?>"  data-title="<?php echo lang('edit_customer'); ?>" data-tippy-content="<?php echo lang('edit_customer'); ?>"
                                    class="header_menu_icon edit_customer">
                                    <i class="far fa-pencil-alt"></i>
                                </a>

                                <a href="#" data-title="<?php echo lang('add_customer'); ?>"  class="plus_button header_menu_icon"
                                    data-tippy-content="<?php echo lang('add_customer'); ?>">
                                    <i class="fal fa-plus"></i>
                                </a>

                        </div>
                    </div>

                    <div class="main_center <?php echo escape_output($is_self_order_class) ? 'self_order_mode': '' ?> <?php echo escape_output($mobile_responsive_checker_online_order) ? 'irp_online_order': '' ?> <?php echo escape_output($mobile_responsive_checker_self_order) ? 'irp_self_order': '' ?>">
                        <div class="order_table_holder">
                            <div class="order_table_header_row">
                                <div class="single_header_column" id="single_order_item"><?php echo lang('item'); ?>
                                </div>
                                <div class="single_header_column" id="single_order_price"><?php echo lang('price'); ?>
                                </div>
                                <div class="single_header_column" id="single_order_qty"><?php echo lang('qty'); ?></div>
                                <div class="single_header_column" id="single_order_discount">
                                    <?php echo lang('discount'); ?></div>
                                <div class="single_header_column" id="single_order_total"><?php echo lang('total'); ?>
                                </div>
                            </div>
                            <div class="order_holder cardIsEmpty">
                                
                            </div>
                        </div>

                    </div>
                    <div id="bottom_absolute">
                        <div class="bottom__info">
                            <div class="payable">
                                <h1>
                                     <i data-tippy-content="Invoice Date"
                                        class="no-need-for-waiter fal fa-calendar-alt input-group date datepicker_custom" id="open_date_picker"></i>
                                    <i id="cart_item_option_open" class="fal fa-eye"></i> <?php echo lang('total_payable'); ?>:
                                    <span class="color_div mrgin_3 color_div" id="total_payable"><?php echo getAmtP(0)?></span>
                                </h1>
                            </div>
                            <div class="main_bottom">
                                <div class="button_group <?php echo escape_output($is_self_order_class) ? 'self_order_mode': '' ?>">

                                    <button id="cancel_button"><i class="fas fa-times"></i>
                                        <?php echo lang('cancel'); ?></button>
                                    <button id="hold_sale" class="<?php echo escape_output($is_self_order_class) ?>"><i class="fas fa-hand-rock"></i>
                                        <?php echo lang('hold'); ?></button>

                                    <button data-type="1" class="<?php echo escape_output(isset($is_online_order) && $is_online_order=="Yes"?'self_order_skip':'')?> <?php echo escape_output(isset($is_self_order) && $is_self_order=="Yes"?'self_order_skip':'')?> placeOrderSound place_order_operation <?php echo isset($place_order_tooltip) && $place_order_tooltip=="show"?"btn_tip":'' ?>"  data-tippy-content="<?php echo lang('place_order_tooltip_txt'); ?>"><i
                                            class="fas fa-utensils"></i> <span
                                           ><?php echo lang('direct_invoice'); ?></span></button>

                                    <button data-type="2" class="placeOrderSound place_order_operation <?php echo isset($place_order_tooltip) && $place_order_tooltip=="show"?"btn_tip":'' ?>"  data-tippy-content="<?php echo lang('place_order_tooltip_txt'); ?>"><i
                                            class="fas fa-utensils"></i> <span
                                            id="place_edit_order"><?php echo lang('place_order'); ?></span></button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="main_right <?php echo escape_output($is_self_order_class) ? 'online_order':'' ?>">
                <form autocomplete="off" class="search-category-form" id="search_form">
                    <?php  if(isFoodCourt() && $this->session->userdata('role') != 'Admin'):?>
                    <div class="search-category-item">
                        <div class="item">
                            <input class="" type="text" name="search" id="search"
                                    placeholder="<?php echo lang('name_code_cat_veg_bev_bar'); ?>" /></div>
                        <div class="item">
                                <select id="select_restaurant" class="select2 select_restaurant ir_w_100">
                                    <?php
                                    $outlet_id_s = $this->session->userdata('outlet_id');
                                    $outlets = getAllOutlestByAssignFood();
                                    foreach ($outlets as $value):
                                        ?>
                                        <option <?= set_select('outlet_id',$value->id)?>  <?= isset($outlet_id_s) && $outlet_id_s==$value->id?'selected':''?> data-company_id="<?php echo escape_output($value->company_id)?>" value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                        </div>
                    </div>
                    <?php else:   ?>
                        <input class="ir_w_m_b_4" type="text" name="search" id="search"
                               placeholder="<?php echo lang('name_code_cat_veg_bev_bar'); ?>" />
                    <?php endif;   ?>
                    <div class="cat-list-wrapper">
                        <button type="button" class="bg__purple open-category-list">
                            <?php echo lang('category'); ?> <i class="fas fa-angle-down"></i>
                        </button>

                            <ul class="list-of-item">
                                    <li>
                                        <a href="#" class="button_category_show_all1"><?php echo lang('all'); ?></a>
                                    </li>
                                <!--This variable could not be escaped because this is html content-->
                                    <?php echo ($cateogry_slide_to_show)?>
                            </ul>

                    </div>
                </form>

                <div id="main_item_holder">
                    <div class="category-list scrollbar-macosx">
                        <ul class="list-of-item">
                            <li>
                                <a href="#" class="button_category_show_all1"><?php echo lang('all'); ?></a>
                            </li>
                            <!--This variable could not be escaped because this is html content-->
                            <?php echo ($cateogry_slide_to_show)?>
                        </ul>
                    </div>

                    <div id="secondary_item_holder">
                        <div class="category_items">
                            <!--This variable could not be escaped because this is html content-->
                            <?php echo ($menu_to_show); ?>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- Responsive mobile menu -->
    <div class="all__menus">
        <ul class="menu__list">
            <div>
                <li>
                    <a href="#" id="notification_button">
                        <i class="fal fa-bell"></i> <?php echo lang('kitchen_notification'); ?>
                        <span id="notification_counter"
                            class="c_badge <?php echo escape_output($notification_number)?'':'txt_11'?>"><?php echo escape_output($notification_number);?></span>
                    </a>
                </li>
                <li>
                    <a href="#" class="button_category_show_all1">
                        <i class="fal fa-border-all"></i> <?php echo lang('all'); ?>
                    </a>
                </li>
                <li class="it_has_children">
                    <a href="#" class="show__cat__list"><i class="far fa-file-alt"></i> <?php echo lang('category'); ?></a>
                    <ul class="sub_menu category__list">
                        <!--This variable could not be escaped because this is html content-->
                        <?php echo ($cateogry_slide_to_show)?>
                    </ul>
                </li>
                <li><a href="#" data-status="bev" class="veg_bev_item"><i class="far fa-glass"></i> <?php echo lang('beverage_items'); ?></a></li>
                <li><a href="#" data-status="veg" class="veg_bev_item"><i class="far fa-carrot"></i> <?php echo lang('vegetarian_items'); ?></a></li>
                <li><a href="#" data-status="" class="get_prom_details"><i class="fas fa-poo"></i> <?php echo lang('View_Promo'); ?></a></li>
                <li>
                    <a href="#" id="open_hold_sales">
                        <i class="fal fa-folder-open"></i> <?php echo lang('open_hold_sale'); ?>
                    </a>
                </li>
                <li>
                    <a href="#" id="last_ten_sales_button">
                        <i class="fal fa-history"></i> <?php echo lang('recent_sales'); ?>
                    </a>
                </li>
                <li class="no-need-for-waiter">
                    <a href="#" id="last_ten_feature_button">
                        <i class="fas fa-shopping-bag"></i> <?php echo lang('feature_sales'); ?>
                    </a>
                </li>
                <li class="no-need-for-waiter">
                    <a href="#" class="last_ten_self_button">
                        <i class="fa fa-qrcode"></i> <?php echo lang('self_online_orders'); ?></a>
                </li>
                <li class="no-need-for-waiter">
                    <a href="#" class="reservation_list">
                        <i class="fa fa-ticket"></i> <?php echo lang('reservation_list'); ?></a>
                </li>

                <li class="it_has_children">
                    <a href="#">
                        <i class="fal fa-globe"></i> <?php echo lang('language'); ?>
                    </a>
                    <ul class="sub_menu" role="menu">
                        <?php $language = $this->session->userdata('language');
                            if(!$language){
                                $language = "english";
                            }
                            ?>
                        <?php $dir = glob("application/language/*",GLOB_ONLYDIR);
                            foreach ($dir as $value): $separete = explode("language/",$value); ?>
                        <li class="<?=isset($language) && $language==$separete[1]?'active_lng':''?>"><a
                                href="<?php echo base_url(); ?>Authentication/setlanguagePOS/<?=escape_output($separete[1])?>"><?php echo escape_output(ucfirst     ($separete[1]))?></a>
                        </li> <?php endforeach; ?>
                    </ul>
                </li>

            </div>
            <!-- End Single Menu Column -->
            <div>
                <li class="it_has_children no-need-for-waiter">
                    <a href="#">
                        <i class="fal fa-user"></i> <?php echo lang('main_menu'); ?>
                    </a>
                    <ul class="sub_menu" role="menu">
                        <li>
                            <a href="<?php echo base_url();?>Authentication/userProfile">
                                <?php echo lang('my_profile'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>Authentication/changePassword">
                                <?php echo lang('change_password'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>Authentication/logOut"><?php echo lang('logout'); ?></a>
                        </li>
                    </ul>
                </li>
                <li class="no-need-for-waiter">
                    <a href="javascript:void(0)" id="print_last_invoice">
                        <i class="fal fa-print"></i> <?php echo lang('print_last_invoice'); ?></a>
                </li>
                <?php    if($designation!="Waiter"):?>
                    <li class="no-need-for-waiter">
                        <a href="#" class="register_details">
                            <i class="fal fa-registered"></i> <?php echo lang('register_details'); ?>
                        </a>
                    </li>
                <?php endif;?>
                <li class="no-need-for-waiter">
                    <a href="#" id="go_to_dashboard">
                        <i class="fal fa-tachometer-alt-fast"></i> <?php
                                    if ($this->session->userdata('role') == 'Admin') {
                                        echo lang('dashboard');
                                    }else{
                                        echo lang('back');
                                    }
                                    ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>customer-panel" class="header_menu_icon" target="_blank"  data-tippy-content="<?php
                    echo lang('customer_panel');
                    ?>">
                        <i class="fal fa-desktop"></i> <?php
                        echo lang('customer_panel');
                        ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url()?>order-status-screen" class="header_menu_icon" target="_blank"  data-tippy-content="<?php
                    echo lang('order_status_screen');
                    ?>">
                        <i class="fa fa-desktop"></i> <?php
                        echo lang('order_status_screen');
                        ?>
                    </a>
                </li>
                <li>
                    <a href="#" class="header_menu_icon fullscreen"">
                    <i  class="fal fa-expand-arrows-alt"> <?php echo lang('fullscreen_1'); ?></i>
                    </a>
                </li>
            </div>
        </ul>
    </div>

    <div class="overlayForCalculator"></div>


    <!-- Open Customer Modal -->
    <div id="customer_modal_open" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"> <?php echo lang('Select_Customer'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div>
                <div class="left_item">
                    <select id="walk_in_customer1" id="select_walk_in_customer1" class="select2">
                        <option value=""><?php echo lang('customer'); ?></option>
                        <!--This variable could not be escaped because this is html content-->
                        <?php echo ($customers_option); ?>
                    </select>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" id="submit_discount_custom" class="submit"><?php echo lang('submit'); ?></button>
                <button type="button" id="cancel_discount_modal" class="cancel"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>

    <!-- Open Waiter Modal -->
    <div id="waiter_modal_open" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <h1 id="modal_item_name"> <?php echo lang('Select_Waiter'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div>
                <div class="left_item">
                    <?php
                        if($waiter_app_status=="Yes"):
                    ?>
                    <input type="hidden"
                        value="<?php echo escape_output($this->session->userdata('user_id'))?>"
                        id="select_waiter">
                    <button id="table_button" class="half-width-98"><i class="fal fa-table"></i>
                        <?php echo lang('table'); ?></button>
                    <?php else:
                            ?>
                    <select id="select_waiter1" class="select2 select_waiter ir_w92_ml">
                        <option value=""><?php  echo lang('waiter'); ?></option>
                        <!--This variable could not be escaped because this is html content-->
                        <?php echo ($waiters_option); ?>
                    </select>
                  <?php endif;?>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" id="submit_discount_custom" class="submit"><?php echo lang('submit'); ?></button>
                <button type="button" id="cancel_discount_modal" class="cancel"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="pos__modal__overlay"></div>
    <div class="pos__modal__overlay_for_menu"></div>
    <div class="pos__modal__overlay2"></div>


    <div id="cart_item_option_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <h1 id="modal_item_name"> <?php echo lang('Cart_Item_Options'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="modal-body-content">

                <div class="item">
                                    <input type="hidden" id="open_invoice_date_hidden"
                                        value="<?php echo date("Y-m-d") ?>">
                                    <div><?php echo lang('total_item'); ?>: <span
                                            id="total_items_in_cart_with_quantity">0</span>

                                    </div>
                                    <span id="total_items_in_cart" class="ir_display_none">0</span>
                </div>
                <div class="item">
                                    <span><?php echo lang('sub_total'); ?>:</span>
                                    <span id="sub_total_show"><?php echo getAmtP(0)?></span>
                                    <span id="sub_total" class="ir_display_none"><?php echo getAmtP(0)?></span>
                                    <span id="total_item_discount" class="ir_display_none">0</span>
                                    <span id="discounted_sub_total_amount"
                                        class="ir_display_none"><?php echo getAmtP(0)?></span>
                </div>
                <div class="item no-need-for-waiter <?php echo escape_output($is_self_order_class) ?>">
                                    <span>
                                        <?php echo lang('discount'); ?>: <i class="fal fa-edit"
                                            id="open_discount_modal"></i> <span
                                            id="show_discount_amount"><?php echo getAmtP(0)?></span>
                                    </span>
                </div>
                <div class="item">
                                    <span><?php echo lang('total'); ?> <?php echo lang('discount'); ?>:</span>
                                    <span id="all_items_discount"><?php echo getAmtP(0)?></span>
                </div>
                
                <div class="item">
                                    <span><?php echo lang('delivery_charge'); ?>: <i
                                            class="fal fa-edit no-need-for-waiter" id="open_charge_modal"></i> <span
                                            id="show_charge_amount"><?php echo getAmtP(0)?></span></span>

                </div>

                <div class="item">
                    <span><?php echo lang('vat'); ?><span id="vat_text_show_for_charge">:</span></span>
                    <span>
                        <i class="fal fa-eye no-need-for-waiter" id="open_tax_modal"></i>
                    </span>
                    <span id="show_vat_modal"><?php echo getAmtP(0)?></span>
                </div>

                <div class="item <?php echo escape_output($is_self_order_class) ?>">
                    <span><?php echo lang('tips'); ?>: <i class="fal fa-edit no-need-for-waiter" id="open_tips_modal"></i>
                    <span id="show_tips_amount"><?php echo getAmtP(0)?></span></span>
                </div>
                <?php
                $is_rounding_enable = $this->session->userdata('is_rounding_enable');?>
                <div class="item <?php echo escape_output($is_rounding_enable) && $is_rounding_enable==1?'':'ir_display_none'?>">
                    <input type="hidden" value="0" id="rounding_amount_hidden">
                    <span><?php echo lang('Rounding'); ?>:
                    <span id="rounding_amount"><?php echo getAmtP(0)?></span></span>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
                            <!-- Open Discount Modal -->
    <div id="discount_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('discount'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div>
                    <label for="discount_val"><?php echo lang('value'); ?></label>

                    <input type="hidden" class="special_textbox" placeholder="<?php echo lang('value'); ?>"
                        id="sub_total_discount" />

                    <input type="text" class="special_textbox integerchk" placeholder="<?php echo lang('value'); ?>"
                        id="sub_total_discount1" />

                    <span class="ir_display_none" id="sub_total_discount_amount"></span>
                </div>
                <div>
                    <label for="discount_type"><?php echo lang('type'); ?></label>
                    <select class="select2" id="discount_type" name="discount_type">
                        <option value="fixed"><?php echo lang('fixed'); ?></option>
                        <option value="percentage"><?php echo lang('percentage'); ?></option>
                    </select>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" id="submit_discount_custom" class="submit submit_to_return_modal"><?php echo lang('submit'); ?></button>
                <button type="button" id="cancel_discount_modal" class="cancel submit_to_return_modal"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
    <div id="online_order_login_modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">

        <h1 id="modal_item_name"><?php echo lang('login'); ?>
            <a href="javascript:void(0)" class="alertCloseIcon">
                <i class="fal fa-times"></i>
            </a>
        </h1>
        <div class="main-content-wrapper">
            <p class="online_order_password_error display_none"><?php echo lang('online_password_wrong'); ?></p>
            <div>
                <label for="discount_val"><?php echo lang('phone'); ?></label>
                <input type="text" class="special_textbox integerchk" placeholder="<?php echo lang('phone'); ?>"
                       id="online_login_phone" />
            </div>
            <div>
                <label for="discount_val"><?php echo lang('password'); ?></label>
                <input type="password" class="special_textbox" placeholder="<?php echo lang('password'); ?>"
                       id="online_login_password" />
            </div>
        </div>
        <div class="btn__box">
            <button type="button" id="submit_login_online"><?php echo lang('login'); ?></button>
            <button type="button" id="cancel_discount_modal" class="cancel"><?php echo lang('cancel'); ?></button>
        </div>
    </div>
</div>
    <div id="running_order_save_modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">

        <h1 id="modal_item_name"><?php echo lang('logout_action'); ?>
        </h1>
        <div class="main-content-wrapper">
            <small class="running_order_alert"><?php echo lang('backup_running_order_msg_1'); ?> <b class="total_running_order">0</b> <?php echo lang('backup_running_order_msg_2'); ?></small>
             <br>
            <div class="custom_div_margin">
                <label for="charge_type"><?php echo lang('who_will_pull_the_order'); ?></label>
                <select id="pull_id" class="select2">
                    <?php
                        $user_id = $this->session->userdata('user_id');
                        foreach ($users as $value):
                    ?>
                        <option <?php echo $value->id==$user_id?'selected':''?> value="<?php echo escape_output($value->id)?>"><?php echo escape_output($value->full_name)?> - <?php echo escape_output($value->designation)?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="btn__box">
            <button type="button" class="without_submit"><?php echo lang('without_submit'); ?></button>
            <button type="button" class="running_order_submit"><?php echo lang('yes_i_want_assign'); ?></button>
            <button type="button" class="cancel_running_order_save_modal"><?php echo lang('cancel'); ?></button>
        </div>
    </div>
</div>
    <!-- Open Service Charge Modal -->
    <div id="charge_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('charge'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div>
                    <?php
                        $service_amount = $this->session->userdata('service_amount');
                        $take_away_service_charge = $this->session->userdata('take_away_service_charge');
                        $delivery_amount = $this->session->userdata('delivery_amount');
                    //for default order type select
                        $default_order_type = $this->session->userdata('default_order_type');
                        $check_type_selected = 'service';
                        $amount_default = '';
                        if($default_order_type==1){
                            $amount_default = $service_amount;
                            $check_type_selected = "service";
                        }else if($default_order_type==2){
                            $amount_default = $take_away_service_charge;
                            $check_type_selected = "service";
                        }
                        if($default_order_type==3){
                            $amount_default = $delivery_amount;
                            $check_type_selected = "delivery";
                        }
                    ?>
                    <label for="charge_type"><?php echo lang('type'); ?></label>
                    <select id="charge_type" class="select2">
                        <option <?php echo isset($check_type_selected) && $check_type_selected=="delivery"?'selected':''?> value="delivery"><?php echo lang('delivery'); ?></option>
                        <option <?php echo isset($check_type_selected) && $check_type_selected=="service"?'selected':''?> value="service"><?php echo lang('service'); ?></option>
                    </select>
                </div>
                <div>
                    <label for="charge_amount"><?php echo lang('amount'); ?></label>
                    <input type="text" name="" autocomplete="off" class="special_textbox " onfocus="select();"
                        placeholder="<?php echo lang('amount'); ?>" value="<?php echo escape_output($amount_default)?>" id="delivery_charge" />
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="submit submit_to_return_modal"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel submit_to_return_modal" id="cancel_charge_value"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>


       <!-- Open Service Charge Modal -->
    <div id="tips_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('tips'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="main-content-wrapper">
                <div>
                    <label for="charge_amount"><?php echo lang('amount'); ?></label>
                    <input type="text" name="" autocomplete="off" class="special_textbox" onfocus="select();"
                        placeholder="<?php echo lang('amount'); ?>" value="" id="tips_amount" />
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="submit submit_to_return_modal"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel submit_to_return_modal" id="cancel_charge_value"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>


    <!-- Open Service Charge Modal -->
    <div id="tax_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('tax_details'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="main-content-wrapper">
                <div class="content">
                    <table class="tax-modal-table">
                        <thead>
                            <tr>
                                <th><?php echo lang('tax_name'); ?></th>
                                <th><?php echo lang('value'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="tax_row_show">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>


    <div id="item_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <!--promotion data-->
            <span id="modal_item_is_offer" class="ir_display_none"></span>
            <span id="modal_item_name_row" class="ir_display_none"></span>
            <span id="modal_promo_type_row" class="ir_display_none">0</span>
            <span id="modal_discount_row" class="ir_display_none">0</span>
            <span id="modal_get_food_menu_id_row" class="ir_display_none">0</span>
            <span id="modal_qty_row" class="ir_display_none">0</span>
            <span id="modal_get_qty_row" class="ir_display_none">0</span>
            <!--end promotion data-->

            <span id="modal_item_row" class="ir_display_none">0</span>
            <span id="modal_item_id" class="ir_display_none"></span>
            <span id="is_variation_product" class="ir_display_none"></span>
            <span id="modal_item_price" class="ir_display_none"></span>
            <span id="modal_item_vat_percentage" class="ir_display_none"></span>
            <h1> <span class="arabic_text_left" id="item_name_modal_custom"><?php echo lang('item_name'); ?></span>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="ir_mrx5">
                <p class="prom_txt"></p>
                <div class="section2 fix display_none_new variation_div_modal">
                    <div class="sec2_inside" id="sec2_1"><?php echo lang('Variation'); ?></div>
                    <div class="sec2_inside" id="sec2_2"> <span id="vr01_modal_price_variable">0</span>
                        <span id="vr01_modal_unit_price_variable" class="ir_display_none">0</span>
                    </div>
                </div>
                <div class="section3 section3_vr fix display_none_new variation_div_modal">
                    <div class="modal_modifiers">
                        <p><?php echo lang('cool_haus_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('first_scoo_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('mg_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('modifier_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('cool_haus_1'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('first_scoo_2'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('mg-2'); ?></p>
                    </div>
                    <div class="modal_modifiers">
                        <p><?php echo lang('modifier_1'); ?></p>
                    </div>
                </div>

                <div class="section1 fix v_h_middle">
                    <div class="sec1_inside" id="sec1_1"><?php echo lang('quantity'); ?></div>
                    <div class="sec1_inside" id="sec1_2"><i class="fal fa-minus" id="decrease_item_modal"></i>
                        <input onfocus="select();" type="text" id="item_quantity_modal" value="1"> <i class="fal fa-plus" id="increase_item_modal"></i>
                    </div>
                    <div class="sec1_inside" id="sec1_3"> <span id="modal_item_price_variable"
                                                                class="ir_display_none">0</span><span
                                id="modal_item_price_variable_without_discount">0</span><span id="modal_discount_amount"
                                                                                              class="ir_display_none">0</span></div>

                </div>

                <div class="modifier_div section2 fix">
                    <div class="sec2_inside" id="sec2_1"><?php echo lang('modifiers'); ?></div>
                    <div class="sec2_inside" id="sec2_2"> <span id="modal_modifier_price_variable">0</span>
                        <span id="modal_modifiers_unit_price_variable" class="ir_display_none">0</span>
                    </div>
                </div>

                <div class="section3 section3_new">

                </div>

                <div id="modal_discount_section">
                    <p class="ir_fl_m_font_16" id="discount_txt_focus"><?php echo lang('discount'); ?> <i
                                data-tippy-content="<?php echo lang('txt_err_pos_6'); ?>"
                                class="fal fa-question-circle tooltip_modifier"></i></p><input type="text" name=""
                                                                                               onfocus="select();"
                        <?php echo isset($waiter_app_status) && $waiter_app_status=="Yes"?"readonly":'' ?>
                                                                                               id="modal_discount"  class="<?php echo isset($is_discount) && $is_discount=="Yes"?"numpad_input_":'' ?>" placeholder="<?php echo lang('amt_or_p'); ?>" />
                </div>
                <div class="section4 fix"><?php echo lang('total'); ?>&nbsp;&nbsp;&nbsp;
                    <span id="modal_total_price">0</span>
                </div>
            </div>

            <div class="section6 fix display_none discount_reason_div">
                <div class="section5"><?php echo lang('discount_reason'); ?>:</div>
                <textarea name="discount_reason" id="discount_reason" maxlength="150"></textarea>
            </div>

            <div class="section6 fix">
                <div class="section5"><?php echo lang('label_to_preparation'); ?>:</div>
                <textarea name="item_note" id="modal_item_note" maxlength="150"></textarea>
            </div>


            <div class="section7">
                <div class="sec7_inside" id="sec7_2"><button
                            id="add_to_cart"><?php echo lang('add_to_cart_pos'); ?></button></div>
                <div class="sec7_inside" id="sec7_1"><button
                            id="close_item_modal" class="bg__red"><?php echo lang('cancel'); ?></button></div>

            </div>

            <!-- <span class="btn-close">&times;</span> -->
            <!-- <p>Some text in the Modal..</p> -->
        </div>

    </div>

    <!-- The Modal -->
    <div id="add_customer_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <span class="add_customer_title"><?php echo lang('add_customer'); ?></span>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="customer_add_modal_info_holder">
                <div class="content">

                    <div class="left-item b">
                        <input type="hidden" id="customer_id_modal" value="">
                        <div class="customer_section">
                            <p class="input_level"><?php echo lang('name'); ?> <span class="ir_color_red">*</span></p>
                            <input type="text" placeholder="<?php echo lang('name'); ?>" class="add_customer_modal_input" id="customer_name_modal" required>
                        </div>
                        <div class="customer_section">
                            <p class="input_level">
                                <?php echo lang('phone'); ?>
                                <span class="ir_color_red">*</span>
                                <small>(<?php echo lang('should_have_country_code'); ?>)</small>
                            </p>

                            <input type="text" class="add_customer_modal_input" placeholder="<?php echo lang('phone'); ?>" id="customer_phone_modal" required>
                        </div>
                        <div class="customer_section">
                            <p class="input_level"><?php echo lang('email'); ?></p>
                            <input type="email" placeholder="<?php echo lang('email'); ?>" class="add_customer_modal_input" id="customer_email_modal">
                        </div>
                       <?php
                       $online_login = 'none';
                       $online_login_hide = 'none';
                        if($is_online_order=="Yes"){
                            $online_login = "";
                        }else{
                            $online_login_hide = '';
                        }
                        ?>
                        <div class="customer_section" style="display:<?php echo escape_output($online_login)?>">
                            <p class="input_level"><?php echo lang('password'); ?><span class="ir_color_red">*</span> <small>(<?php echo lang('keep_blank_in_edit'); ?>)</small></p>
                            <input type="email" placeholder="<?php echo lang('password'); ?>" class="add_customer_modal_input" id="customer_password_modal">
                        </div>

                        <?php if(collectGST()=="Yes"){?>
                            <div class="customer_section">
                                <p class="input_level"><?php echo lang('same_or_diff_state'); ?> <span class="required_star">*</span></p>
                                <select class="form-control irp_width_100 select2 same_or_diff_state_modal" name="same_or_diff_state" id="same_or_diff_state">
                                    <option value="0"><?php echo lang('select'); ?></option>
                                    <option value="1"><?php echo lang('same_state'); ?></option>
                                    <option value="2"><?php echo lang('different_state'); ?></option>
                                </select>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="right-item b">
                        <div class="customer_section">
                            <p class="input_level"><?php echo lang('dob'); ?></p>
                            <input type="datable" class="add_customer_modal_input" autocomplete="off"
                                id="customer_dob_modal" data-datable="yyyymmdd" data-datable-divider=" - ">
                        </div>
                        <div class="customer_section">
                            <p class="input_level"><?php echo lang('doa'); ?></p>
                            <input type="datable" class="add_customer_modal_input" autocomplete="off"
                                id="customer_doa_modal" data-datable="yyyymmdd" data-datable-divider=" - ">
                        </div>
                        <div class="customer_section" style="display:<?php echo escape_output($online_login_hide)?>">
                            <p class="input_level"><?php echo lang('default_discount'); ?></p>
                            <input type="text" class="add_customer_modal_input" placeholder="<?php echo lang('default_discount_pl'); ?>" autocomplete="off"
                                   id="customer_default_discount_modal">
                        </div>
                        <?php if(collectGST()=="Yes"){?>
                            <div class="customer_section">
                                <p class="input_level"><?php echo lang('gst_number'); ?> <span class="required_star">*</span></p>
                                <input type="text" placeholder="<?php echo lang('gst_number'); ?>" class="add_customer_modal_input" id="customer_gst_number_modal">

                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="customer_section">
                    <p class="input_level"><?php echo lang('delivery_address'); ?></p>
                    <div class="">
                        <table class="irp_width_100 added_address">

                        </table>
                    </div>
                    <textarea placeholder="<?php echo lang('delivery_address'); ?>" id="customer_delivery_address_modal"></textarea>
                    <input type="hidden" value="Yes" id="is_new_address">
                    <input type="hidden" value="" id="customer_delivery_address_modal_id">
                </div>
            </div>

            <div class="section7">
                <div class="sec7_inside" id="sec7_2"><button id="add_customer"><?php echo lang('submit'); ?></button>
                </div>
                <div class="sec7_inside" id="sec7_1"><button
                        id="close_add_customer_modal"><?php echo lang('cancel'); ?></button></div>
            </div>
            <!-- <span class="btn-close">&times;</span> -->
            <!-- <p>Some text in the Modal..</p> -->
        </div>

    </div>
    <!-- The Modal -->
    <div id="show_tables_modal2" class="modal display_none">

        <!-- Modal content -->
        <div class="modal-content" id="modal_content_show_tables2">
            <h1 class="ir_pos_relative">
                <?php echo lang('tables'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon" id="table_modal_cancel_button2">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            
            <?php 
                $table_bg_color = $this->session->userdata('table_bg_color');
                $bg_tbl = $table_bg_color;
            ?>
            <div class="select_table_modal_info_holder2">
                
                <!--This variable could not be escaped because this is html content-->
                <div class="table-category-list bg-white pos_p_10">
                    <h4 class="bg-white text-center pos_mb_10"><b><?php echo lang('area'); ?></b></h4>
                    <ul class="dineIn-table-list-of-item">
                         <?php
                            $i = 1;
                            foreach ($areas as $value) {
                                $set_active = "";
                                if($i==1){
                                    $set_active = "#dadada;";
                                }
                                $i++;
                                echo '<li><div class="set_design ir_display_none">'.$value->table_design_content.'</div><a class="get_area_table" data-floor_bg_color="'.(!empty($value->floor_bg_color) ? $value->floor_bg_color : '').'"  data-ordered_border_color="'.$value->ordered_border_color.'"  data-ordered_bg_color="'.$value->ordered_bg_color.'"  data-ordered_text_color="'.$value->ordered_text_color.'" data-id="'.$value->id.'" href="javascript:void(0)">'.$value->area_name.'</a></li>';
                            }
                        ?>
                    </ul>

                    <p>&nbsp;</p>
                        <table class="ir-width-100">
                            <tr class="no-need-for-waiter"> <td><button data-id="1" class="set_quick_action"><i class="fas fa-file-invoice"></i> <?php echo lang('invoice'); ?></button></td> </tr>
                            <tr class="no-need-for-waiter"> <td><button data-id="2" class="set_quick_action"><i class="fas fa-clone"></i> <?php echo lang('split_bill'); ?></button></td> </tr>
                            <tr class=""> <td><button data-id="3" class="set_quick_action"><i class="fas fa-edit"></i> <?php echo lang('modify_order_'); ?></button></td> </tr>
                            <tr class="no-need-for-waiter"> <td><button data-id="55" class="set_quick_action"><i class="fas fa-code-branch"></i> <?php echo lang('merge_table'); ?></button></td> </tr>
                            <tr class="no-need-for-waiter"> <td><button data-id="4" class="set_quick_action"><i class="fas fa-file-invoice"></i> <?php echo lang('bill'); ?></button></td> </tr>
                            <tr class="no-need-for-waiter"> <td><button data-id="5" class="set_quick_action"><i class="fas fa-times"></i> <?php echo lang('cancel_order'); ?></button></td> </tr>
                        </table>


                </div>
                <div class="width_86">
                    <div class="all-dineIn-table bg-white pos_ml_10 table_bg <?php echo $bg_tbl?>">
                        
                    </div>
                </div>
                
            </div>
            <div class="bottom_button_holder_table_modal">
                <div class="left half">
                <button class="floatright reset_table" id="reset_table"><i class="fa fa-refresh"></i> <?php echo lang('reset_table'); ?></button>
                </div>
                <div class="right half">
                    <button class="floatright bg_pos_cancel" id="table_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                </div>
            </div>
            <!-- <span class="btn-close">&times;</span> -->
            <!-- <p>Some text in the Modal..</p> -->
        </div>

    </div>
    <!-- end add customer modal -->

    <!-- The sale hold modal -->
    <div id="show_sale_hold_modal" class="modal">
        <div class="modal-content" id="modal_content_hold_sales">
            <h1 class="main_header fix"><?php echo lang('hold_sale'); ?> <a href="javascript:void(0)"
                    class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a></h1>
            <div class="hold_sale_modal_info_holder">
                <div class="responsive_modal_btn_box">
                    <button type="button" class="bg__green" data-selectedBtn="selected"
                        id="sale_hold_modal_order_list"><?php echo lang('Order_List'); ?></button>
                    <button type="button" class="bg__green" data-selectedBtn="unselected"
                        id="sale_hold_modal_order_details"><?php echo lang('order_details'); ?></button>
                </div>
                <div class="detail_hold_sale_holder">
                    <div id="sale_hold_modal_order_info_list" class="hold_sale_left">
                        <label>
                            <input type="text" id="search_hold_sale"
                                placeholder="<?php echo lang('search_customer_name_or_mobile_number'); ?>">
                            <button><i class="far fa-search"></i></button>
                        </label>
                        <div class="hold_list_holder">
                            <div class="header_row">
                                <div class="first_column column"><?php echo lang('hold_number'); ?></div>
                                <div class="second_column column"><?php echo lang('customer'); ?>
                                    (<?php echo lang('phone'); ?>)</div>
                                <div class="third_column column"><?php echo lang('table'); ?></div>
                            </div>
                            <div class="scrollbar-macosx">
                                <div class="detail_holder draft-sale">

                                </div>
                            </div>
                            <div class="delete_all_hold_sales_container">
                                <button
                                    id="delete_all_hold_sales_button"><?php echo lang('delete_all_hold_sale'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div id="sale_hold_modal_order_details_list" class="hold_sale_right">
                        <div class="top fix">
                            <div class="top_middle fix">
                                <h1><?php echo lang('order_details'); ?></h1>
                                <div class="waiter_customer_table fix">
                                    <div class="fix order_type"><span
                                            class="ir_font_bold"><?php echo lang('order_type'); ?>: </span><span
                                            id="hold_order_type"></span><span id="hold_order_type_id"
                                            class="ir_display_none"></span></div>
                                </div>
                                <div class="waiter_customer_table fix">
                                    <div class="waiter fix"><span class="ir_font_bold"><?php echo lang('waiter'); ?>:
                                        </span><span class="ir_display_none" id="hold_waiter_id"></span><span
                                            id="hold_waiter_name"></span></div>
                                    <div class="customer fix"><span
                                            class="ir_font_bold"><?php echo lang('customer'); ?>: </span><span
                                            class="ir_display_none" id="hold_customer_id"></span><span
                                            id="hold_customer_name"></span></div>
                                    <div class="table fix"><span class="ir_font_bold"><?php echo lang('table'); ?>:
                                        </span><span class="ir_display_none" id="hold_table_id"></span><span
                                            id="hold_table_name"></span></div>
                                </div>
                                <div class="item_modifier_details">
                                    <div class="modifier_item_header fix">
                                        <div class="first_column_header column_hold fix"><?php echo lang('item'); ?>
                                        </div>
                                        <div class="second_column_header column_hold fix"><?php echo lang('price'); ?>
                                        </div>
                                        <div class="third_column_header column_hold fix"><?php echo lang('qty'); ?>
                                        </div>
                                        <div class="forth_column_header column_hold fix"><?php echo lang('disc'); ?>
                                        </div>
                                        <div class="fifth_column_header column_hold fix"><?php echo lang('total'); ?>
                                        </div>
                                    </div>
                                    <div class="scrollbar-macosx">
                                        <div class="modifier_item_details_holder">
                                        </div>
                                    </div>
                                    <div class="bottom_total_calculation_hold">
                                        <div class="single_row first">
                                            <div class="item">
                                                <span><?php echo lang('total_item'); ?>: </span>
                                                <span id="total_items_in_cart_hold">0</span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('sub_total'); ?>: </span>
                                                <span id="sub_total_show_hold"><?php echo getAmtP(0)?></span>
                                                <span id="sub_total_hold"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                                <span id="total_item_discount_hold"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                                <span id="discounted_sub_total_amount_hold"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('discount'); ?>: </span>
                                                <span>
                                                    <span id="sub_total_discount_hold"><?php echo getAmtP(0)?></span><span
                                                        id="sub_total_discount_amount_hold"
                                                        class="ir_display_none"><?php echo getAmtP(0)?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="single_row third">

                                        </div>
                                        <div class="single_row forth">
                                            <div class="item">
                                                <span><?php echo lang('total_discount'); ?>: </span>
                                                <span id="all_items_discount_hold"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('vat'); ?>: </span>
                                                <span id="all_items_vat_hold"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('delivery_charge'); ?>: </span>
                                                <span id="delivery_charge_hold"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('tips'); ?>: </span>
                                                <span id="tips_amount_hold"><?php echo getAmtP(0)?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="modal_payable">
                                        <span><?php echo lang('total_payable'); ?>: </span>
                                        <span id="total_payable_hold"><?php echo getAmtP(0)?></span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="button_holder">
                                <div class="single_button_holder">
                                    <button id="hold_edit_in_cart_button"><?php echo lang('edit_in_cart'); ?></button>
                                </div>
                                <div class="single_button_holder">
                                    <button id="hold_delete_button"><?php echo lang('delete'); ?></button>
                                </div>
                                <div class="single_button_holder">
                                    <button id="hold_sales_close_button"><?php echo lang('cancel'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end sale hold modal -->

    <!-- The sale hold modal -->
    <div id="show_last_ten_sales_modal" class="modal show_last_ten_sales_modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_content_last_ten_sales">
            <h1 class="main_header fix"><?php echo lang('recent_sales'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="last_ten_sales_modal_info_holder">
                <div class="last_ten_sales_holder">
                    
                    <div class="responsive_modal_btn_box">
                        <button type="button" id="recent_sales_order_list" data-selectedBtn="selected"
                            class="bg__green"><?php echo lang('Order_List'); ?></button>
                        <button type="button" id="recent_sales_order_details" data-selectedBtn="unselected"
                            class="bg__green"><?php echo lang('order_details'); ?></button>
                    </div>
                    <div id="recent_sales_order_info_list" class="hold_sale_left">
                        <label>
                            <input type="text" id="search_sales_custom_modal"
                                placeholder="<?php echo lang('search_customer_name_or_mobile_number'); ?>">
                            <button><i class="far fa-search"></i></button>
                        </label>
                        <div class="hold_list_holder">
                            <div class="header_row">
                                <div class="first_column column"><?php echo lang('sale_no'); ?></div>
                                <div class="second_column column"><?php echo lang('customer'); ?>
                                    (<?php echo lang('phone'); ?>)</div>
                                <div class="third_column column"><?php echo lang('table'); ?></div>
                            </div>
                            <div class="scrollbar-macosx">
                                <div class="detail_holder recent-sales">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="recent_sales_order_details_list" class="hold_sale_right">
                        <div class="top fix">
                            <div class="top_middle fix">
                                <h1><?php echo lang('order_details'); ?></h1>
                                <div class="waiter_customer_table fix">
                                    <div class="fix order_type">
                                        <span class="ir_font_bold"><?php echo lang('order_type'); ?>: </span>
                                        <span id="last_10_order_type" class="ir_w_d_ib">&nbsp;</span>
                                        <span id="last_10_order_type_id" class="ir_display_none"></span>
                                        <span class="ir_font_bold"><?php echo lang('invoice_no'); ?>: </span>
                                        <span id="last_10_order_invoice_no"></span>
                                    </div>
                                </div>
                                <div class="waiter_customer_table fix">
                                    <div class="waiter fix"><span class="ir_font_bold"><?php echo lang('waiter'); ?>:
                                        </span><span class="ir_display_none" id="last_10_waiter_id"></span><span
                                            id="last_10_waiter_name"></span></div>
                                    <div class="customer fix"><span
                                            class="ir_font_bold"><?php echo lang('customer'); ?>: </span><span
                                            class="ir_display_none" id="last_10_customer_id"></span><span
                                            id="last_10_customer_name"></span></div>
                                    <div class="table fix"><span class="ir_font_bold"><?php echo lang('table'); ?>:
                                        </span><span class="ir_display_none" id="last_10_table_id"></span><span
                                            id="last_10_table_name"><?php echo lang('None'); ?></span></div>
                                </div>
                                <div class="item_modifier_details fix">
                                    <div class="modifier_item_header fix">
                                        <div class="first_column_header column_hold fix"><?php echo lang('item'); ?>
                                        </div>
                                        <div class="second_column_header column_hold fix"><?php echo lang('price'); ?>
                                        </div>
                                        <div class="third_column_header column_hold fix"><?php echo lang('qty'); ?>
                                        </div>
                                        <div class="forth_column_header column_hold fix"><?php echo lang('disc'); ?>
                                        </div>
                                        <div class="fifth_column_header column_hold fix"><?php echo lang('total'); ?>
                                        </div>
                                    </div>
                                    <div class="scrollbar-macosx">
                                        <div class="modifier_item_details_holder">
                                        </div>
                                    </div>
                                    <div class="bottom_total_calculation_hold">
                                        <div class="single_row first">
                                            <div class="item">
                                                <?php echo lang('total_item'); ?>:
                                                <span id="total_items_in_cart_last_10">0</span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('sub_total'); ?>: </span>
                                                <span id="sub_total_show_last_10"><?php echo getAmtP(0)?></span>
                                                <span id="sub_total_last_10"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                                <span id="total_item_discount_last_10"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                                <span id="discounted_sub_total_amount_last_10"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <span><?php echo lang('discount'); ?> :</span>
                                                <span id="sub_total_discount_last_10"><?php echo getAmtP(0)?></span>
                                                <span id="sub_total_discount_amount_last_10"
                                                    class="ir_display_none"><?php echo getAmtP(0)?></span>
                                            </div>
                                        </div>

                                        <div class="single_row third">

                                        </div>
                                        <div class="single_row forth">
                                            <div class="item">
                                                <?php echo lang('total_discount'); ?> : <span
                                                    id="all_items_discount_last_10"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <?php echo lang('vat'); ?>:
                                                <span id="recent_sale_modal_details_vat"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <?php echo lang('delivery_charge'); ?>:
                                                <span id="delivery_charge_last_10"><?php echo getAmtP(0)?></span>
                                            </div>
                                            <div class="item">
                                                <?php echo lang('tips'); ?>:
                                                <span id="tips_amount_last_10"><?php echo getAmtP(0)?></span>
                                            </div>
                                        </div>

                                    </div>
                                    <h1 class="modal_payable">
                                        <?php echo lang('total_payable'); ?>: <span
                                            id="total_payable_last_10"><?php echo getAmtP(0)?></span>
                                    </h1>
                                </div>

                                <div class="bottom">
                                    <div class="button_holder">
                                        <div class="single_button_holder change_delivery_address display_none">
                                            <button class="no-need-for-waiter"
                                                id="change_delivery_address"><?php echo lang('change_delivery_address'); ?></button>
                                        </div>
                                        <div class="single_button_holder">
                                            <button class="no-need-for-waiter"
                                                id="last_ten_print_invoice_button"><?php echo lang('print_invoice'); ?></button>
                                        </div>
                                        <div class="single_button_holder">
                                            <button id="last_ten_delete_button"
                                                class="ir_font_capitalize no-need-for-waiter"><?php echo lang('delete'); ?></button>
                                        </div>
                                        <div class="single_button_holder">
                                            <button id="last_ten_sales_close_button"><?php echo lang('cancel'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end sale hold modal -->

    <!-- The sale hold modal -->
    <div id="generate_sale_hold_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_content_generate_hold_sales">
            <h1><?php echo lang('hold'); ?></h1>
            <div class="generate_hold_sale_modal_info_holder fix">
                <p class="ir_m_zero_b"><?php echo lang('hold_number'); ?> <span class="ir_color_red">*</span>
                </p>
                <input type="text" name="" id="hold_generate_input">
            </div>
            <div class="section7 fix">
                <div class="sec7_inside" id="sec7_1"><button id="hold_cart_info"><?php echo lang('submit'); ?></button>
                </div>
                <div class="sec7_inside" id="sec7_2"><button
                        id="close_hold_modal"><?php echo lang('cancel'); ?></button></div>
            </div>
        </div>

    </div>


    <div id="bill_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <?php echo lang('bill'); ?> <?php echo lang('details'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="main-content show_bill_modal_content">
                <header>
                    <img src="<?=base_url()?>images/logo.png" />
                    <h3 class="title"></h3>
                    <p> <?php echo lang('Bill_No'); ?>: <span id="b_bill_no"></span></p>
                </header>
                <ul class="simple-content">
                    <li><?php echo lang('date'); ?>: <span id="b_bill_date"></span></li>
                    <li><?php echo lang('Sales_Associate'); ?>: <span id="b_bill_creator"></span></li>
                    <li><?php echo lang('customer'); ?>: <b><span id="b_bill_customer"></span></b></li>
                </ul>
                <ul class="main-content-list">
                    <li>
                        <span><b><?php echo lang('Total_Item_s'); ?>: <span id="b_bill_total_item"></span></b></span>
                        <span></span>
                    </li>
                    <li>
                        <span><?php echo lang('sub_total'); ?></span>
                        <span><b><span id="b_bill_subtotal"></span></b></span>
                    </li>
                    <li>
                        <span><?php echo lang('grand_total'); ?></span>
                        <span><b><span id="b_bill_gtotal"></span></b></span>
                    </li>
                    <li>
                        <span><?php echo lang('total_payable'); ?></span>
                        <span><span id="b_bill_total_payable"></span></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div id="show_delivery_partner" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <?php echo lang('deliveryPartners'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="select_table_modal_info_holder2 scrollbar-macosx">
                <ul class="custom_ul">
                    <?php
                    if(isset($deliveryPartners) && $deliveryPartners):
                        foreach ($deliveryPartners as $key=>$value):
                            $default_order_type_delivery_p = $this->session->userdata('default_order_type_delivery_p');
                            $checked = '';
                            if($default_order_type_delivery_p==$value->id){
                                $checked = "checked";
                            }
                            ?>
                            <li class="custom_li" data-aggregator_tran_code="<?php echo escape_output($value->aggregator_tran_code) ?>" data-row="<?php echo escape_output($value->id) ?>">
                                <input type="checkbox" <?php echo escape_output($checked)?> name="delivery_partner_id" value="<?php echo escape_output($value->id) ?>" class="class_check"  id="myCheckbox<?php echo escape_output($value->id) ?>" />
                                <label class="label_c" for="myCheckbox<?php echo escape_output($value->id) ?>"><img src="<?php echo base_url()?>images/<?php echo escape_output($value->logo) ?>"" />
                                    <p class="dl_p_title"><?php echo escape_output($value->name) ?></p>
                                </label>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            <footer class="pos__modal__footer">
                <div class="left_box left_bottom">
                    <button class="floatright" id="dp_modal_cancel_button"><?php echo lang('submit'); ?></button>
                    <button id="click_here_to_uncheck"> <?php echo lang('ClickHeretoUncheck'); ?></button>
                    <button class="floatright" id="dp_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                </div>
            </footer>

        </div>

    </div>

    <div id="order_type_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <?php echo lang('please_select_an_order_type'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <input type="hidden" id="last_click_item_id">
            <div class="select_table_modal_info_holder2 scrollbar-macosx">
                <ul class="custom_ul_order_type">
                    <?php
                    //for default order type select
                    ?>

                    <li class="custom_li_order_type <?php echo escape_output(isset($is_online_order) && $is_online_order=="Yes"?'self_order_skip':'')?>" data-row="dine_in_button">
                        <label class="label_c" for="dine_in_modal"><img src="<?php echo base_url()?>assets/media/dine_in.png" />
                            <p class="dl_p_title"><?php echo lang('dine'); ?></p>
                        </label>
                    </li>
                    <li class="custom_li_order_type" data-row="take_away_button">
                        <label class="label_c" for="dine_in_modal"><img src="<?php echo base_url()?>assets/media/take_away.png" />
                            <p class="dl_p_title"><?php echo lang('take_away'); ?></p>
                        </label>
                    </li>
                    <li class="custom_li_order_type" data-row="delivery_button">
                        <label class="label_c" for="dine_in_modal"><img src="<?php echo base_url()?>assets/media/delivery.png" />
                            <p class="dl_p_title"><?php echo lang('delivery'); ?></p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="pos__modal__footer">
                <div class="left_box left_bottom">
                    <button class="floatright" id="dp_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                </div>
            </footer>

        </div>

    </div>

    <div id="show_modal_view_promo" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <?php echo lang('View_Promo'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="select_table_modal_info_holder2 scrollbar-macosx">
              <table class="table_custom">
                 <thead>
                     <tr >
                         <th><?php echo lang('title'); ?></th>
                         <th><?php echo lang('type'); ?></th>
                         <th><?php echo lang('food_menu'); ?></th>
                         <th><?php echo lang('discount'); ?></th>
                     </tr>
                 </thead>
                  <tbody id="body_promo_view">

                  </tbody>
              </table>
            </div>
            <div class="bottom_button_holder_table_modal">
                <div class="right">
                    <button class="floatright right_bottom" id="dp_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                </div>
            </div>

        </div>

    </div>

    <div id="delivery_status_change" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="editCustomer1">
            <h1>
                <?php echo lang('change_delivery_address'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>

            <div class="select_table_modal_info_holder2 scrollbar-macosx">
                 <div class="form-group">
                    <input type="hidden" name="sale_id_hidden_d" id="sale_id_hidden_d">
                    <select class="form-control select2" name="status_modal" id="status_modal">
                        <option value="Pending"><?php echo lang('Pending'); ?></option>
                        <option value="Delivered"><?php echo lang('Delivered'); ?></option>
                    </select>
                </div>
            </div>
            <footer class="pos__modal__footer">
                <div class="left_box">
                    <button class="floatright save_change_status" id="dp_modal_cancel_button"><?php echo lang('save_changes'); ?></button>
                    <button class="floatright" id="dp_modal_cancel_button"><?php echo lang('cancel'); ?></button>
                </div>
            </footer>

        </div>

    </div>


    <div class="cus_pos_modal" id="register_modal">
        <header class="pos__modal__header">
            <h3 class="pos__modal__title"><?php echo lang('register_details'); ?> </h3>

            <a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
        </header>

        <div class="pos__modal__body scrollbar-macosx">
            <div class="default_inner_body" id="register_details_content_o">
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('register_details'); ?>" data-id_name="datatable">
                <div class="html_content">

                </div>
            </div>
        </div>
        <footer class="pos__modal__footer">
            <div class="right_box">
                <button type="button"  id="register_close"><?php echo lang('close_register'); ?></button>
                <button type="button" class="modal_hide_register"><?php echo lang('cancel'); ?></button>
            </div>
        </footer>
    </div>
<div class="cus_pos_modal"  id="reservation_modal">
    <header class="pos__modal__header">
        <h3 class="pos__modal__title title_custom"><?php echo lang('register_details'); ?> </h3>

        <a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
    </header>

    <div class="pos__modal__body scrollbar-macosx">
        <div class="default_inner_body" id="register_details_content_o">
            <div class="html_content">

            </div>
        </div>
    </div>
    <footer class="pos__modal__footer">
        <div class="right_box">
            <button type="button" class="modal_hide_register"><?php echo lang('cancel'); ?></button>
        </div>
    </footer>
</div>

    <div class="cus_pos_modal cus_pos_modal_feature_sale_modal" id="customModal">
        <header class="pos__modal__header">
            <h3 class="pos__modal__title self_order_title"><?php echo lang('feature_sales'); ?></h3>
            <a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
        </header>
        <div class="pos__modal__body">
            <div class="default_inner_body">

                <div class="responsive_modal_btn_box">
                    <button type="button" class="bg__green" data-selectedBtn="selected"
                        id="customModal_order_list_action"><?php echo lang('Order_List'); ?></button>
                    <button type="button" class="bg__green" data-selectedBtn="unselected"
                        id="customModal_order_details_action"><?php echo lang('order_details'); ?></button>
                </div>

                <div class="hold_sale">
                    <div id="customModal_order_list" class="left_item">
                        <label class="search__item">
                            <input type="text" id="search_future_custom_modal"
                                   placeholder="<?php echo lang('search_customer_name_or_mobile_number'); ?>">
                            <button><i class="far fa-search"></i></button>
                        </label>
                        <div class="scrollbar-macosx position_future_sale_irp">
                            <div class="left_item_list_wrapper">
                                <div class="itemList">
                                    <div class="itemHeader">
                                        <div class="item"><?php echo lang('sale_no'); ?></div>
                                        <div class="item">
                                            <?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)
                                        </div>
                                        <div class="item last_table_name"><?php echo lang('date'); ?></div>
                                    </div>
                                    <div class="detail_holder">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="customModal_order_details" class="right_item">
                        <h3 class="title"><?php echo lang('order_details'); ?></h3>
                        <div class="waiter_customer_table">
                            <div class="fix order_type"><span class="ir_font_bold"><?php echo lang('order_type'); ?>:
                                </span><span id="last_10_order_type_"></span>
                            </div>
                        </div>
                        <div class="waiter_customer_table multiItem">
                            <div class="waiter self_hide_div"><span class="ir_font_bold"><?php echo lang('waiter'); ?>: </span><span
                                    id="last_10_waiter_name_"></span></div>
                            <div class="customer"><span class="ir_font_bold"><?php echo lang('customer'); ?>:
                                </span><span id="last_10_customer_name_"></span></div>
                            <div class="table">
                                <span class="ir_font_bold"><?php echo lang('table'); ?>:</span><span
                                    id="last_10_table_name_"><?php echo lang('None'); ?></span>
                            </div>
                        </div>
                        <div class="item_order_details">
                            <header>
                                <div><?php echo lang('item'); ?></div>
                                <div><?php echo lang('price'); ?></div>
                                <div><?php echo lang('qty'); ?></div>
                                <div><?php echo lang('discount'); ?></div>
                                <div><?php echo lang('total'); ?></div>
                            </header>

                            <div class="scrollbar-macosx">
                                <div class="modifier_item_details_holder">

                                </div>
                            </div>

                        </div>


                        <div class="footer__details">

                            <div class="txt__subtotal">
                                <span class="total__item"><?php echo lang('total_item'); ?>: <span
                                        class="total_items_in_cart_last_10_">0</span></span>
                                <p class="txt self_hide_div"> <?php echo lang('total_discount'); ?>: <span
                                        class="all_items_discount_last_10_"><?php echo getAmtP(0)?></span></p>
                            </div>
                            <div class="txt__subtotal">
                                <span><?php echo lang('sub_total'); ?>: <span
                                        class="sub_total_show_last_10_"><?php echo getAmtP(0)?></span></span>

                                <p class="txt"><?php echo lang('vat'); ?>: <span
                                        class="recent_sale_modal_details_vat_"><?php echo getAmtP(0)?></span></p>
                            </div>
                            <div class="txt__subtotal">
                                <span class="discount"><?php echo lang('discount'); ?>: <span
                                        class="sub_total_discount_last_10_"><?php echo getAmtP(0)?></span></span>
                                <p class="txt self_hide_div"><?php echo lang('charge'); ?>: <span
                                        class="delivery_charge_last_10_"><?php echo getAmtP(0)?></span></p>
                            </div>
                            <div class="txt__subtotal">
                                <p class="txt self_hide_div"><?php echo lang('tips'); ?>: <span
                                        class="tips_amount_last_10_"><?php echo getAmtP(0)?></span></p>
                            </div>
                        </div>
                        <h3 class="payable">
                            <span class=""><?php echo lang('total_payable');?>:</span>
                            <span class="total_payable_last_10_"><?php echo getAmtP(0)?></span></h3>
                    </div>
                </div>
            </div>
        </div>
        <footer class="pos__modal__footer">
            <div class="left_box">
                &nbsp;
            </div>
            <div class="right_box">
                <div class="right_box w-full">
                    <button type="button" id="draft_edit_modal"><?php echo lang('modify_order_'); ?></button>
                    <button type="button" class="<?php echo escape_output($is_self_order_class) ?> title_set_as" id="draft_edit_modal_invoice"><?php echo lang('set_as_running_order'); ?></button>
                    <button type="button" class="<?php echo escape_output($is_self_order_class) ?> title_set_as_decline" id="draft_edit_modal_invoice_decline"><?php echo lang('set_as_decline'); ?></button>
                    <button type="button" class="modal_hide"><?php echo lang('cancel'); ?></button>
                </div>
            </div>
        </footer>
    </div>

<div class="cus_pos_modal cus_pos_modal_self_online_sale_modal" id="customModalSelfOnlineOrder">
    <header class="pos__modal__header">
        <h3 class="pos__modal__title"><?php echo lang('self_online_orders'); ?></h3>
        <a href="javascript:void(0)" class="pos__modal__close"><i class="fal fa-times"></i></a>
    </header>
    <div class="pos__modal__body">
        <div class="default_inner_body">

            <div class="responsive_modal_btn_box">
                <button type="button" class="bg__green" data-selectedbtn="selected" id="self_online_list_action"><?php echo lang('Order_List'); ?></button>
                <button type="button" class="bg__green" data-selectedbtn="unselected" id="self_online_details_action"><?php echo lang('order_details'); ?></button>
            </div>

            <div class="hold_sale">
                <div class="left_item" id="self_online_list">
                    <div class="scrollbar-macosx position_future_sale_irp">
                        <div class="left_item_list_wrapper">
                            <div class="page-content">
                                <div class="tabbed">
                                    <input type="radio" id="tab1" name="css-tabs" checked>
                                    <input type="radio" id="tab2" name="css-tabs">
                                    <input type="radio" id="tab3" name="css-tabs">

                                    <ul class="tabs">
                                        <li class="tab"><label for="tab1"><?php echo lang('self_orders'); ?></label></li>
                                        <li class="tab"><label for="tab2"><?php echo lang('Online_Orders'); ?></label></li>
                                    </ul>

                                    <div class="tab-content">
                                        <label class="search__item">
                                            <input type="text" id="search_self_order_custom_modal"
                                                   placeholder="<?php echo lang('search_customer_name_or_mobile_number'); ?>">
                                            <button><i class="far fa-search"></i></button>
                                        </label>
                                        <div class="itemList">
                                            <div class="itemHeader">
                                                <div class="item"><?php echo lang('sale_no'); ?></div>
                                                <div class="item">
                                                    <?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)
                                                </div>
                                                <div class="item last_table_name text_center_irp"><?php echo lang('date'); ?></div>
                                            </div>
                                            <div class="detail_holder_self_order">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <label class="search__item">
                                            <input type="text" id="search_online_order_custom_modal"
                                                   placeholder="<?php echo lang('search_customer_name_or_mobile_number'); ?>">
                                            <button><i class="far fa-search"></i></button>
                                        </label>
                                        <div class="itemList">
                                            <div class="itemHeader">
                                                <div class="item"><?php echo lang('sale_no'); ?></div>
                                                <div class="item">
                                                    <?php echo lang('customer'); ?> (<?php echo lang('phone'); ?>)
                                                    <br>
                                                    <?php echo lang('address'); ?>
                                                </div>
                                                <div class="item last_table_name text_center_irp"><?php echo lang('date'); ?></div>
                                            </div>
                                            <div class="detail_holder_online_order">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="right_item" id="self_online_details">
                    <h3 class="title"><?php echo lang('order_details'); ?></h3>
                    <div class="waiter_customer_table">
                        <div class="fix order_type"><span class="ir_font_bold"><?php echo lang('order_type'); ?>:
                                </span><span id="self_online_last_10_order_type_"></span>
                        </div>
                    </div>
                    <div class="waiter_customer_table multiItem">
                        <div class="waiter self_hide_div"><span class="ir_font_bold"><?php echo lang('waiter'); ?>: </span><span
                                    id="self_online_last_10_waiter_name_"></span></div>
                        <div class="customer"><span class="ir_font_bold"><?php echo lang('customer'); ?>:
                                </span><span id="self_online_last_10_customer_name_"></span></div>
                        <div class="table">
                            <span class="ir_font_bold"><?php echo lang('table'); ?>:</span><span
                                    id="self_online_last_10_table_name_"><?php echo lang('None'); ?></span>
                        </div>
                    </div>
                    <div class="item_order_details">
                        <header>
                            <div><?php echo lang('item'); ?></div>
                            <div><?php echo lang('price'); ?></div>
                            <div><?php echo lang('qty'); ?></div>
                            <div><?php echo lang('discount'); ?></div>
                            <div><?php echo lang('total'); ?></div>
                        </header>

                        <div class="scrollbar-macosx">
                            <div class="modifier_item_details_holder">

                            </div>
                        </div>

                    </div>


                    <div class="footer__details">

                        <div class="txt__subtotal">
                                <span class="total__item"><?php echo lang('total_item'); ?>: <span
                                            class="total_items_in_cart_last_10_">0</span></span>
                            <p class="txt self_hide_div"> <?php echo lang('total_discount'); ?>: <span
                                        class="all_items_discount_last_10_"><?php echo getAmtP(0)?></span></p>
                        </div>
                        <div class="txt__subtotal">
                                <span><?php echo lang('sub_total'); ?>: <span
                                            class="sub_total_show_last_10_"><?php echo getAmtP(0)?></span></span>

                            <p class="txt"><?php echo lang('vat'); ?>: <span
                                        class="recent_sale_modal_details_vat_"><?php echo getAmtP(0)?></span></p>
                        </div>
                        <div class="txt__subtotal">
                                <span class="discount"><?php echo lang('discount'); ?>: <span
                                            class="sub_total_discount_last_10_"><?php echo getAmtP(0)?></span></span>
                            <p class="txt self_hide_div"><?php echo lang('charge'); ?>: <span
                                        class="delivery_charge_last_10_"><?php echo getAmtP(0)?></span></p>
                        </div>
                        <div class="txt__subtotal">
                            <p class="txt self_hide_div"><?php echo lang('tips'); ?>: <span
                                        class="tips_amount_last_10_"><?php echo getAmtP(0)?></span></p>
                        </div>
                    </div>
                    <h3 class="payable">
                        <span class=""><?php echo lang('total_payable');?>:</span>
                        <span class="total_payable_last_10_"><?php echo getAmtP(0)?></span></h3>
                </div>
            </div>
        </div>
    </div>
    <footer class="pos__modal__footer">
        <div class="left_box">
            &nbsp;
        </div>
        <div class="right_box">
            <div class="right_box w-full">
                <button type="button" id="draft_edit_modal"><?php echo lang('modify_order_'); ?></button>
                <button type="button" class="<?php echo escape_output($is_self_order_class) ?> title_set_as" id="draft_edit_modal_invoice"><?php echo lang('set_as_running_order'); ?></button>
                <button type="button" class="<?php echo escape_output($is_self_order_class) ?> title_set_as_decline" id="draft_edit_modal_invoice_decline"><?php echo lang('set_as_decline'); ?></button>
                <button type="button" class="modal_hide"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </footer>
</div>

    <!-- end add customer modal -->
    <!-- The order details modal -->
    <div id="order_detail_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_content_sale_details">
            <h1 class="order_detail_title">
                <?php echo lang('order_details'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon" id="order_details_close_button2"><i
                        class="fal fa-times"></i></a>
            </h1>
            <div class="order_detail_modal_info_holder fix">
                <div class="top fix">
                    <div class="top_middle fix">
                        <div class="waiter_customer_table fix">
                            <div class="fix order_type">
                                <span class="ir_font_bold"><?php echo lang('order_type'); ?>: </span>
                                <span id="order_details_type" class="ir_d_block_w229"></span>
                                <span id="order_details_type_id" class="ir_display_none"></span>
                                <span class="ir_font_bold"><?php echo lang('order_number'); ?>: </span>
                                <span id="order_details_order_number"></span>
                            </div>
                        </div>
                        <div class="waiter_customer_table fix">
                            <div class="waiter fix"><span class="ir_font_bold"><?php echo lang('waiter'); ?>:
                                </span><span class="ir_display_none" id="order_details_waiter_id"></span><span
                                    id="order_details_waiter_name"></span></div>
                            <div class="customer fix"><span class="ir_font_bold"><?php echo lang('customer'); ?>:
                                </span><span class="ir_display_none" id="order_details_customer_id"></span><span
                                    id="order_details_customer_name"></span></div>
                            <div class="table fix"><span class="ir_font_bold"><?php echo lang('table'); ?>:
                                </span><span class="ir_display_none" id="order_details_table_id"></span><span
                                    id="order_details_table_name"></span></div>
                        </div>
                        <div class="item_modifier_details fix">
                            <div class="modifier_item_header fix">
                                <div class="first_column_header column_hold"><?php echo lang('item'); ?></div>
                                <div class="second_column_header column_hold"><?php echo lang('price'); ?></div>
                                <div class="third_column_header column_hold"><?php echo lang('qty'); ?></div>
                                <div class="forth_column_header column_hold"><?php echo lang('discount'); ?></div>
                                <div class="fifth_column_header column_hold"><?php echo lang('total'); ?></div>
                            </div>
                            <div class="scrollbar-macosx">
                                <div class="modifier_item_details_holder">
                                </div>
                            </div>
                            <div class="bottom_total_calculation_hold">

                                <div class="item">
                                    <div><?php echo lang('total_item'); ?>: <span
                                            id="total_items_in_cart_order_details">0</span></div>
                                    <div><?php echo lang('sub_total'); ?>:
                                        <span id="sub_total_show_order_details"><?php echo getAmtP(0)?></span>
                                        <span id="sub_total_order_details"
                                            class="ir_display_none"><?php echo getAmtP(0)?></span>
                                        <span id="total_item_discount_order_details"
                                            class="ir_display_none"><?php echo getAmtP(0)?></span>
                                        <span id="discounted_sub_total_amount_order_details"
                                            class="ir_display_none"><?php echo getAmtP(0)?></span>
                                    </div>
                                    <div>
                                        <?php echo lang('discount'); ?>:
                                        <span id="sub_total_discount_order_details"></span><span
                                            id="sub_total_discount_amount_order_details"
                                            class="ir_display_none"><?php echo getAmtP(0)?></span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div>
                                        <?php echo lang('total_discount'); ?>:
                                        <span id="all_items_discount_order_details"><?php echo getAmtP(0)?></span>
                                    </div>
                                    <div>
                                        <?php echo lang('vat'); ?>:
                                        <span id="all_items_vat_order_details"><?php echo getAmtP(0)?></span>
                                    </div>
                                    <div>
                                        <?php echo lang('delivery_charge'); ?>:
                                        <span id="delivery_charge_order_details"><?php echo getAmtP(0)?></span>
                                    </div>
                                    <div>
                                        <?php echo lang('tips'); ?>:
                                        <span id="tips_amount_order_details"><?php echo getAmtP(0)?></span>
                                    </div>
                                </div>
                            </div>
                            <h1 class="modal_payable"><?php echo lang('total_payable'); ?> <span
                                    id="total_payable_order_details"><?php echo getAmtP(0)?></span></h1>
                        </div>
                    </div>
                </div>
                <div class="create_invoice_close_order_in_order_details" id="order_details_post_invoice_buttons">
                    <button class="no-need-for-waiter txt_38" id="order_details_create_invoice_close_order_button"><i
                                class="fas fa-file-invoice"></i>
                        <?php echo lang('create_invoice_close'); ?></button>
                </div>
                <button class="txt_38" id="order_details_close_button"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>

    <!-- The table modal please read -->
    <div id="please_read_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_please_read_details">
            <h1 id="please_read_modal_header" class="ir_color_red">
                <?php echo lang('please_read'); ?>

            </h1>
            <div class="help_modal_info_holder scrollbar-macosx">

                <!-- <p class="para_type_1">How order process works</p> -->
                <p class="para_type_1"><?php echo lang('please_read_text_1'); ?>:</p>
                <p class="para_type_2"><?php echo lang('please_read_text_2'); ?></p>
                <p class="para_type_1"><?php echo lang('please_read_text_3'); ?>:</p>
                <p class="para_type_2"><?php echo lang('please_read_text_4'); ?></p>

            </div>
            <div class="text-rigth">
                <button id="please_read_close_button"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="finalize_order_modal" class="modal modal_custom_bold">

        <!-- Modal content -->
        <div class="modal-content" id="modal_finalize_order_details">
            <h1 id="modal_finalize_header"><?php echo lang('finalize_order'); ?></h1>
            <div class="content-wrapper">
                <div class="left-content">
                    <div class="fo_1 fix">
                        <span class="ir_display_none" id="finalize_update_type"></span>
                        <div class="half fix floatleft"><?php echo lang('total_payable'); ?></div>
                        <div class="half fix floatleft textright"><span
                                    id="finalize_total_payable_old"><?php echo getAmtP(0)?></span></div>
                    </div>
                    <div class="fo_2 fix">
                        <div class="half fix floatleft"><?php echo 'Payment Method';//lang('total_payment'); ?></div>
                        <div class="half fix floatleft textright">
                            <select name="finalie_order_payment_method" class="select2" id="finalie_order_payment_method">
                                <option value=""><?php echo lang('payment_method'); ?></option>
                                <!--This variable could not be escaped because this is html content-->
                                <?php echo ($payment_method_options); ?>
                            </select>
                        </div>

                    </div>
                    <div class="fo_3 fix">
                        <div class="half fix floatleft textleft"><?php echo lang('paid_amount'); ?></div>
                        <div class="half fix floatleft textright"><?php echo lang('due_amount'); ?></div>
                        <div class="half fix floatleft textleft"><input type="text" class="numpad_input" name="pay_amount_invoice_modal_input"
                                                                        id="pay_amount_invoice_input"></div>
                        <div class="half fix floatleft textright"><input type="text" name="due_amount_invoice_modal_input"
                                                                         id="due_amount_invoice_input" disabled></div>
                    </div>
                    <div class="fo_3  fix">
                        <div class="half fix floatleft textleft"><?php echo lang('given_amount'); ?> <i
                                    data-tippy-content="<?php echo lang('txt_err_pos_7'); ?>"
                                    class="fal fa-question-circle given_amount_tooltip"></i></div>
                        <div class="half fix floatleft textright"><?php echo lang('change_amount'); ?></div>
                        <div class="half fix floatleft textleft"><input class="numpad_input" type="text" name="given_amount_modal_input"
                                                                        id="given_amount_input"></div>
                        <div class="half fix floatleft textright"><input type="text" name="change_amount_modal_input"
                                                                         id="change_amount_input" disabled></div>
                    </div>
                </div>
                <!-- End Form Field  -->
                <div class="scrollbar-macosx">
                    <div class="right-content floatleft">
                        <ul id="append_total_payable">
                            <li><a data-amount="" class="get_quick_cash set_default_quick_cach" href="#"></a></li>
                            <?php
                            $i = 1;
                            $first_segment = 0;
                            $second_segment = 0;
                            if(isset($denominations) && $denominations):
                                $first_segment = (sizeof($denominations)/2);
                                foreach ($denominations as $value):
                                    if($i<=$first_segment):
                                        ?>
                                        <li><a data-amount="<?=escape_output($value->amount)?>" class="get_quick_cash" href="#"><?php echo escape_output($value->amount)?></a></li>
                                        <?php
                                        $i++;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <div class="right-content floatleft">
                        <ul>
                            <?php
                            if(isset($denominations) && $denominations):
                                $j = 1;
                                foreach ($denominations as $value):
                                    if($i<=$j):
                                        ?>
                                        <li><a data-amount="<?=escape_output($value->amount)?>" class="get_quick_cash" href="#"><?php echo escape_output($value->amount)?></a></li>
                                        <?php
                                    endif;
                                    $j++;
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bottom_buttons">
                <div class="separate-btn">
                    <div class="bottom_single_button">
                        <button id="finalize_order_button_old"><?php echo lang('submit'); ?></button>
                    </div>
                    <div class="bottom_single_button">
                        <button id="finalize_order_cancel_button"><?php echo lang('cancel'); ?></button>
                    </div>
                </div>
                <button class="clear-items clear_quick_data"><?php echo lang('Clear'); ?></button>
            </div>
            <!-- <span class="btn-close">&times;</span> -->
            <!-- <p>Some text in the Modal..</p> -->
        </div>

    </div>

    <div id="finalize_discount_modal" class="modal">
    
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('discount'); ?> <?php echo lang('discount'); ?>
                
            </h1>
            <div class="main-content-wrapper">
                <div>
                    <label for="discount_val"><?php echo lang('value'); ?></label>
                    <input type="text" class="special_textbox integerchk" placeholder="<?php echo lang('flat_amount'); ?>"
                        id="sub_total_discount_finalize" />

                    <span class="ir_display_none" id="sub_total_discount_amount"></span>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel_modal"><?php echo lang('submit'); ?></button>
                <button type="button" class="cancel_modal remove_discount"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>


    <div id="finalize_cart_details_modal" class="modal">
        <input type="hidden" id="cart_modal_total_item" value="">
        <input type="hidden" id="cart_modal_total_subtotal" value="">
        <input type="hidden" id="cart_modal_total_discount" value="">
        <input type="hidden" id="cart_modal_total_discount_all" value="">
        <input type="hidden" id="cart_modal_total_discount_for_subtotal" value="">
        <input type="hidden" id="cart_modal_total_tax" value="">
        <input type="hidden" id="cart_modal_total_charge" value="">
        <input type="hidden" id="cart_modal_total_tips" value="">
        <input type="hidden" id="cart_modal_total_rounding" value="">

        <!-- Modal content -->
        <div class="modal-content">
            <h1 id="modal_item_name"> <?php echo lang('Cart_Details'); ?>
            </h1>
            <div class="modal-body-content">

                <div class="item">
                                    <div><?php echo lang('total_item'); ?>: <span
                                            id="cart_modal_total_item_text">0</span>

                                    </div>
                </div>
                <div class="item">
                                    <span><?php echo lang('sub_total'); ?>:</span>
                                    <span id="cart_modal_total_subtotal_text"><?php echo getAmtP(0)?></span>
                </div>
                <div class="item">
                                    <span>
                                        <?php echo lang('discount'); ?>: <span
                                            id="cart_modal_total_discount_text"><?php echo getAmtP(0)?></span>
                                    </span>
                </div>
                <div class="item">
                                    <span><?php echo lang('total'); ?> <?php echo lang('discount'); ?>:</span>
                                    <span id="cart_modal_total_discount_all_text"><?php echo getAmtP(0)?></span>
                </div>
                <div class="item">
                    <span><?php echo lang('vat'); ?>:</span>
                    <span id="cart_modal_total_tax_text"><?php echo getAmtP(0)?></span>
                </div>
                <div class="item">
                                    <span><?php echo lang('delivery_charge'); ?>: <span
                                            id="cart_modal_total_charge_text"><?php echo getAmtP(0)?></span></span>

                </div>

                <div class="item">
                    <span><?php echo lang('tips'); ?>:
                    <span id="cart_modal_total_tips_text"><?php echo getAmtP(0)?></span></span>
                </div>
                <?php
                $is_rounding_enable = $this->session->userdata('is_rounding_enable');?>
                <div class="item <?php echo escape_output($is_rounding_enable) && $is_rounding_enable==1?'':'ir_display_none'?>">
                    <span><?php echo lang('Rounding'); ?>:
                    <span id="cart_modal_total_rounding_texts"><?php echo getAmtP(0)?></span></span>
                </div>
            </div>
            <div class="btn__box">
                <button type="button" class="cancel_modal"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>




    <div id="order_payment_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('Finalize'); ?> <?php echo lang('sale'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="responsive_modal_btn_box px-10">
                    <button type="button" class="bg__green" data-selectedBtn="selected"
                        id="order-split-bill-payment-list"><?php echo lang('payment_methods'); ?></button>
                    <button type="button" class="bg__green" data-selectedBtn="unselected"
                        id="order-split-bill-payment-amount"><?php echo lang('payment_details'); ?></button>
            </div>
            <div class="order-payment-wrapper">
                <div class="payment-list order-payment-list">
                    <ul class="list-for-payment-type">
                        <li class="head">
                            <b><?php echo lang('payment_method'); ?></b>
                        </li>
                        <?php foreach ($payment_method_finalize as $value):
                            $selected = "";
                            $is_cash = "";
                            $default_payment = $getCompanyInfo->default_payment;
                            $is_loyalty_enable = $getCompanyInfo->is_loyalty_enable;
                            if($value->id==$default_payment){
                                $selected = "active";
                            }
                            if($value->id!=1){
                                $is_cash = "set_no_access";
                            }
                            if($is_loyalty_enable!='enable'):
                                if($value->id!=5):
                            ?>
                                <li>
                                    <a class="<?php echo escape_output($is_cash)?> <?php echo escape_output($selected)?> set_payment" data-id="<?php echo escape_output($value->id)?>" href="#"><?php echo escape_output($value->name)?></a>
                                </li>
                                <?php
                                    endif;
                                else:?>
                                <li>
                                    <a class="<?php echo escape_output($is_cash)?> <?php echo escape_output($selected)?> set_payment" data-id="<?php echo escape_output($value->id)?>" href="#"><?php echo escape_output($value->name)?></a>
                                </li>
                            <?php endif;?>

                        <?php endforeach;?>
                        <li class=""> <a  id="change_currency_btn" class="change_currency_btn" href="#"><?php echo lang('change_currency'); ?></a> </li>
                    </ul>
                </div>
                <!-- End Payment Name List-->
                <div class="payment-content order-payment-amount">
                    <div id="tabs">

                        <!-- End Tab Panel -->
                        <div id="tab-1">
                            <header>
                                <h3 class="name-of-payment set_no_access" id="payment_preview"><?php echo lang('Cash_Payment'); ?></h3>
                                <p><img id="cash_img" src="<?php echo base_url()?>assets/media/dollar_sign.png"> <span class="previous_due_div"><?php echo lang('Previous_Due'); ?>:</span>  <span class="previous_due_div"><?php echo escape_output($this->session->userdata('currency')); ?></span><span class="previous_due_div" id="finalize_previous_due">0.00</span><span class="loyalty_point_div"><?php echo lang('available_loyalty_point'); ?></span> <span class="loyalty_point_div" id="available_loyalty_point">0</span> <span class="change_amount_div display_none change_amount_p"> &nbsp;<?php echo lang('change_amount'); ?>:</span> <span class="change_amount_div display_none change_amount_p" id="change_amount_div_">0</span></p>

                            </header>
                            <div class="payment-amount">
                                <div class="top-layer">
                                    <div class="input-field cash_div">
                                        <p class="label set_no_access"><?php echo lang('given_amount'); ?></p>
                                        <input type="text" placeholder="<?php echo lang('given_amount'); ?>" onfocus="select();" class="add_customer_modal_input set_no_access" id="finalize_given_amount_input">
                                    </div>
                                    <div class="input-field cash_div">
                                        <p class="label set_no_access"><?php echo lang('change_amount'); ?></p>
                                        <input type="text" placeholder="<?php echo lang('change_amount'); ?>" onfocus="select();" class="add_customer_modal_input set_no_access" id="finalize_change_amount_input">
                                    </div>
                                    <div class="input-field">
                                        <p class="label set_no_access amount_txt"><?php echo lang('amount'); ?></p>
                                        <input type="text" placeholder="<?php echo lang('amount'); ?>" onfocus="select();" class="add_customer_modal_input set_no_access" id="finalize_amount_input">
                                    </div>
                                    <div class="btns">
                                        <button class="add-btn start_animation set_no_access" id="add_payment"><b><?php echo lang('add'); ?></b></button>
                                        <!-- <button class="full-payment-btn">Full Payment</button> -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Top Payment AddPart -->
                            <div class="key-pad">
                                <div class="left-keys">
                                    <input type="hidden" value="" id="is_multi_currency">
                                    <input type="hidden" value="" id="multi_currency_rate">
                                    <table class="finalize_modal_is_mul_currency">
                                        <tr>
                                            <td class="width_50_p">
                                                <select class="form-control select2 multi_currency irp_width_100" style="<?php echo escape_output(getWidth100())?>" id="multi_currency">
                                                    <option data-multi_currency="0" value=""><?php echo lang('change_currency') ?></option>
                                                    <!--This variable could not be escaped because this is html-->
                                                    <?php foreach ($MultipleCurrencies as $value): ?>
                                                        <option data-multi_currency="<?php echo escape_output($value->conversion_rate)?>" value="<?php echo escape_output($value->currency)?>"><?php echo escape_output($value->currency)?></option>
                                                    <?php endforeach;?>
                                                </select></td>
                                            <td class="width_50_p">
                                                <input type="text" placeholder="<?php echo lang('amount') ?>" onfocus="select();"  readonly id="multi_currency_amount" class="custom_field">
                                            </td>
                                            <td>
                                                <i class="fas fa-times-circle remove_multi_currency"></i>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="paid-list-wrapper">
                                        <div>

                                            <p class="empty_title"><?php echo lang('payment_show_tooltip_pos') ?></p>
                                            <ul class="paid-list" id="payment_list_div">

                                            </ul>

                                            <input type="text" placeholder="<?php echo lang('token_number') ?>" onfocus="select();"  id="token_number" class="custom_field custom_field_token">

                                        </div>

                                        <div class="right-content">
                                            <div class="item">
                                                <h3 class="title"><?php echo lang('Payable') ?></h3>
                                                <p><?php echo escape_output($this->session->userdata('currency')); ?><span id="finalize_total_payable"><?php echo getAmt(0)?></span></p>
                                            </div>

                                            <div class="item">
                                                <h3 class="title"><?php echo lang('paid') ?></h3>
                                                <p><?php echo escape_output($this->session->userdata('currency')); ?><span class="spincrement" id="finalize_total_paid"><?php echo getAmt(0)?></span></p>
                                            </div>

                                            <div class="item">
                                                <h3 class="title"><?php echo lang('due') ?></h3>
                                                <p><?php echo escape_output($this->session->userdata('currency')); ?><span class="spincrement" id="finalize_total_due"><?php echo getAmt(0)?></span></p>
                                            </div>
                                              <?php
                                              $sms_send_auto = $this->session->userdata('sms_send_auto');
                                              $company_id = $this->session->userdata('company_id');
                                              $company = companyInformation($company_id);
                                              if(isset($company->sms_service_provider) && $company->sms_service_provider):
                                              ?>
                                                <table class="irp_width_100">
                                                    <tr>
                                                        <td><button><label for="check_send_sms" class="check_send_sms"><input id="check_send_sms" <?php echo isset($sms_send_auto) && $sms_send_auto==2?'checked':''?>  type="checkbox"><?php echo lang('send_sms') ?></label></button></td>
                                                        <td><button id="open_finalize_cart_details"><?php echo lang('Cart_Details') ?></button></td>
                                                    </tr>
                                                </table>
                                            <?php
                                                else:
                                            ?>
                                                    <button id="open_finalize_cart_details"><?php echo lang('Cart_Details') ?></button>
                                            <?php endif?>

                                        </div>
                                    </div>
                                </div>
                                <div class="right-keys">

                                    <ul class="key-list">
                                        <li><a id="open_finalize_discount" href="#"><?php echo lang('discount') ?></a></li>
                                        <li><a data-amount="" data-is_denomination="" class="set_no_access get_quick_cash set_default_quick_cach" href="#"><?php echo getAmtPCustom(0)?></a></li>
                                        <li class="third">
                                            <ul>
                                                <?php
                                                if(isset($denominations) && $denominations):
                                                    foreach ($denominations as $value):
                                                            ?>
                                                            <li><a  data-is_denomination="yes"  data-amount="<?=escape_output($value->amount)?>" class="set_no_access get_quick_cash" href="#"><?php echo escape_output($value->amount)?></a></li>
                                                            <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </ul>
                                        </li>
                                        <li class="clear">
                                            <a href="#" class="clear-btn clear_quick_data set_no_access"><?php echo lang('Clear') ?></a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="table-box">
                                <div class="table-responsive">
                                    <table class="irp_width_100">
                                        <tr>
                                            <td><h3><?php echo lang('table_number'); ?>: <span class="table_number">-</span></h3></td>
                                            <td class="text_right"><h3><?php echo lang('order_taking_time'); ?>: <span class="order_taking_time">-</span></h3></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <!-- End Content Part -->
            <div class="btn__box">
                <button type="button" id="cancel_discount_modal" class="cancel">
                    <i class="fal fa-times"></i> <?php echo lang('cancel'); ?></button>
                <button  id="finalize_order_button"><i class="fas fa-file-invoice"></i>  <?php echo lang('submit'); ?></button>
            </div>
        </div>
    </div>
    <!-- end of item modal -->

    <!-- The Notification List Modal -->
    <div id="notification_list_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_notification_list_details">
            <h1 id="modal_notification_header">
                <?php echo lang('notification_list'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon" id="notification_close2"><i
                        class="fal fa-times"></i></a>
            </h1>
            <div id="notification_list_header_holder">
                <div class="single_row_notification_header fix ir_h25_bb1">
                    <div class="fix single_notification_check_box">
                        <input type="checkbox" id="select_all_notification">
                    </div>
                    <div class="fix single_notification"><strong><?php echo lang('select_all'); ?></strong></div>
                    <div class="fix single_serve_button">
                    </div>
                </div>
            </div>


            <div id="notification_list_holder">
                <!--This variable could not be escaped because this is html content-->
                <?php echo ($notification_list_show);?>
            </div>
            <!-- <span class="btn-close">&times;</span> -->
            <!-- <p>Some text in the Modal..</p> -->
            <div id="notification_close_delete_button_holder">
                <button id="notification_remove_all"><?php echo lang('remove'); ?></button>
                <button id="notification_close"><?php echo 'Cancel';//lang('close'); ?></button>
            </div>
        </div>

    </div>
    <!-- end of notification list modal -->


    <!-- The Notification List Modal -->
    <div id="kitchen_bar_waiter_panel_button_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content ir_pos_relative" id="modal_kitchen_bar_waiter_details">
            <p class="cross_button_to_close cCloseIcon" id="kitchen_bar_waiter_modal_close_button_cross">X</p>
            <h1 id="switch_panel_modal_header"><?php echo lang('kitchen_waiter_bar'); ?></h1>
            <div class="ir_p30">

                <a href="<?php echo base_url(); ?>Demo_panel/switchTo/kitchen" target="_blank" class="ir_w32_d_ta">
                    <button class="ir_w_100"><?php echo lang('kitchen_panel'); ?></button>
                </a>
                <a href="<?php echo base_url(); ?>Demo_panel/switchTo/waiter" target="_blank" class="ir_w32_d_ta">
                    <button class="ir_w_100"><?php echo lang('waiter_panel'); ?></button>
                </a>
                <a href="<?php echo base_url(); ?>Demo_panel/switchTo/bar" target="_blank" class="ir_w32_d_ta">
                    <button class="ir_w_100"><?php echo lang('bar_panel'); ?></button>
                </a>
            </div>

        </div>

    </div>
    <!-- end of notification list modal -->

    <!-- The KOT Modal -->
    <div id="kot_list_modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="modal_kot_list_details">
            <h1 id="modal_kot_header">
                <?php echo lang('select_your_kitchens'); ?>
                <a href="javascript:void(0)" class="ir_top5_right_10 alertCloseIcon" id="cancel_kot_modal2"><i
                        class="fal fa-times"></i></a>
            </h1>
            <h2 id="kot_modal_modified_or_not"><?php echo lang('modified'); ?></h2>
            <div id="kot_table_content" class="fix">
                <div class="scrollbar-macosx">
                    <div id="kot_list_holder">
                        <ul class="custom_ul">
                            <?php
                            if(isset($kitchens) && $kitchens):
                                foreach ($kitchens as $key=>$value):
                                    ?>
                                    <li class="custom_li_kitchen" data-row="<?php echo escape_output($value->id) ?>">
                                        <input type="checkbox" name="kitchen_id[]" value="<?php echo escape_output($value->id) ?>" id="myCheckboxKitchen<?php echo escape_output($value->id) ?>" class="kitchen_ids class_check" />
                                        <label class="label_c_kitchen kitchen_img_parent" for="myCheckboxKitchen<?php echo escape_output($value->id) ?>"><img class="kitchen_img" src="<?php echo base_url()?>assets/media/kitchen.png" />
                                            <p class="dl_p_title"><?php echo escape_output($value->name) ?></p>
                                        </label>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kot_bottom_buttons" class="fix">
                <button id="cancel_kot_modal"><?php echo lang('cancel'); ?></button>
                <button id="select_all_kot_modal"><?php echo lang('select_all'); ?></button>
                <button id="print_kot_modal"><?php echo lang('kot_tooltip'); ?></button>
            </div>

        </div>

    </div>

    <div id="bot_list_modal" class="modal">

        <!-- Modal Content -->
        <div class="modal-content" id="modal_bot_list_details">
            <h1 id="modal_bot_header">
                <?php echo "BOT"; ?>
                <a href="javascript:void(0)" class="ir_top5_right_10 alertCloseIcon" id="cancel_bot_modal2"><i
                        class="fal fa-times"></i></a>
            </h1>
            <h2 id="bot_modal_modified_or_not"><?php echo lang('modified'); ?></h2>
            <div id="bot_header_info" class="fix">
                <p><?php echo lang('order_no'); ?>: <span id="bot_modal_order_number"></span></p>
                <p><?php echo lang('date'); ?>: <span id="bot_modal_order_date"></span></p>
                <p><?php echo lang('customer'); ?>: <span id="bot_modal_customer_id"
                        class="ir_display_none"></span><span id="bot_modal_customer_name"></span></p>
                <p><?php echo lang('table'); ?>: <span id="bot_modal_table_name"></span></p>
                <p><?php echo lang('waiter'); ?>: <span id="bot_modal_waiter_name"></span>,
                    <?php echo lang('order_type'); ?>: <span id="bot_modal_order_type"></span></p>
            </div>
            <div id="bot_table_content" class="fix">
                <div class="bot_modal_table_content_header fix">
                    <div class="bot_header_row fix floatleft bot_check_column"><input type="checkbox"
                            id="bot_check_all"></div>

                    <div class="ir_w_405x bot_header_row floatleft bot_item_name_column">
                        <?php echo lang('item'); ?>
                    </div>


                    <div class="bot_header_row fix floatleft bot_qty_column"><?php echo lang('qty'); ?></div>
                </div>

                <div class="scrollbar-macosx">
                    <div id="bot_list_holder"></div>
                </div>

            </div>
            <div id="bot_bottom_buttons" class="fix">
                <button id="cancel_bot_modal"><?php echo lang('cancel'); ?></button><button
                    id="print_bot_modal"><?php echo lang('print'); ?> <?php echo lang('BOT'); ?></button>
            </div>

        </div>

    </div>

    <div id="order_split_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <h1 id="modal_item_name"><?php echo lang('split_bill'); ?>
                <a href="javascript:void(0)" class="alertCloseIcon bg__red">
                    <i class="fal fa-times"></i> <?php echo lang('cancel'); ?>
                </a>
            </h1>
            <div class="responsive_modal_btn_box px-10">
                    <button type="button" class="bg__green" data-selectedBtn="selected"
                        id="split-bill-payment-list"><?php echo lang('order_details'); ?></button>
                    <button type="button" class="bg__green" data-selectedBtn="unselected"
                        id="split-bill-payment-amount"><?php echo lang('Maximum_Split'); ?></button>
            </div>

            <div class="order-payment-wrapper">
                <div class="payment-list left-item">
                    <ul class="list-for-payment-type">
                        <li class="head">
                            <b><?php echo lang('Order_Items'); ?></b>
                        </li>
                        <li>
                            <table class="split_modal_tbl">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('item_name'); ?></th>
                                        <th class="text_right"><?php echo lang('price'); ?></th>
                                        <th><?php echo lang('qty'); ?></th>
                                        <th class="text_right"><?php echo lang('Dis'); ?></th>
                                        <th class="text_right"><?php echo lang('total'); ?></th>
                                        <th class="text_right"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="split_modal_tbl_body">

                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th colspan="4"><?php echo lang('discount_split'); ?></th>
                                        <th class="text_right split_left_amount check_amount_required" id="split_left_discount">0.00</th>
                                        <th class="text_right left_split_padding"><b  data-type="1" data-title="Discount" class="btn_minus_plus_right"><i class="fa fa-plus"></i></b></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><?php echo lang('charge'); ?></th>
                                        <th class="text_right split_left_amount check_amount_required" id="split_left_charge">0.00</th>
                                        <th class="text_right left_split_padding"><b  data-type="2" data-title="Charge" class="btn_minus_plus_right"><i class="fa fa-plus"></i></b></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><?php echo lang('tips'); ?></th>
                                        <th class="text_right split_left_amount check_amount_required" id="split_left_tips">0.00</th>
                                        <th class="text_right left_split_padding"><b  data-type="3" data-title="Tips" class="btn_minus_plus_right"><i class="fa fa-plus"></i></b></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><?php echo lang('sub_total'); ?></th>
                                        <th class="text_right split_left_amount" id="split_left_sub_total">0.00</th>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><?php echo lang('vat'); ?></th>
                                        <th class="text_right split_left_amount" id="split_left_tax">0.00</th>
                                        <th class="text-center"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><?php echo lang('total_payable'); ?></th>
                                        <th class="text_right split_left_amount" id="split_left_total_payable">0.00</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </li>
                    </ul>
                </div>
                <!-- End Payment Name List -->
                <div class="payment-content right-item">
                    <div id="tabs">
                        <div id="tab-1">
                            <div class="payment-amount">
                                <div class="top-layer">
                                    <div class="input-field">
                                        <p class="label"><?php echo lang('Maximum_Split'); ?>: <span id="maximum_spit">1</span></p>
                                        <input type="number" max="1" min="1" placeholder="Total Split" onfocus="select();" id="spit_modal_input" class="add_customer_modal_input">
                                    </div>
                                    <div class="btns">
                                        <button class="add-btn" id="add_spit_box"><b class="font_size_go"><?php echo lang('Go'); ?></b></button>
                                    </div>
                                </div>
                                <ul class="custom_ul_split list-of-item scrollable">

                                </ul>
                            </div>
                            <!-- End Top Payment AddPart -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Content Part -->
        </div>
    </div>

    <div id="order_split_small_modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <h1 id="modal_item_name"><span class="title_modal_label"></span>
                <a href="javascript:void(0)" class="alertCloseIcon">
                    <i class="fal fa-times"></i>
                </a>
            </h1>
            <div class="order_payment_wrapper_small_modal">
                <input type="hidden" id="split_active_amount" value="">
                <input type="hidden" id="split_active_amount_status" value="">
                <!-- End Payment Name List-->
                <div class="payment-content">
                    <div id="tabs">

                        <!-- End Tab Panel -->
                        <div id="tab-1">
                            <div class="payment-amount">
                                <div class="top-layer">
                                    <div class="input-field">
                                        <p class="label title_modal_label"></p>
                                        <input type="text" placeholder="" onfocus="select();" data-input_modal_previous_amount="0" id="spit_small_modal_input" class="add_customer_modal_input">
                                    </div>
                                </div>
                                <div class="btns">
                                    <button class="add-btn" id="add_small_modal_amount"><b><?php echo lang('Submit'); ?></b></button>
                                </div>
                            </div>
                            <!-- End Top Payment AddPart -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Content Part -->
            <div class="btn__box11">
                <button type="button" id="cancel_discount_modal" class="cancel">  <i class="fal fa-times"></i> <?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>

    <!-- end of KOT modal -->
    <div id="calculator_main">
        <div class="calculator">
            <input type="text" readonly>
            <div class="row">
                <div class="key">1</div>
                <div class="key">2</div>
                <div class="key">3</div>
                <div class="key last">0</div>
            </div>
            <div class="row">
                <div class="key">4</div>
                <div class="key">5</div>
                <div class="key">6</div>
                <div class="key last action instant">cl</div>
            </div>
            <div class="row">
                <div class="key">7</div>
                <div class="key">8</div>
                <div class="key">9</div>
                <div class="key last action instant">=</div>
            </div>
            <div class="row">
                <div class="key action">+</div>
                <div class="key action">-</div>
                <div class="key action">x</div>
                <div class="key last action">/</div>
            </div>
        </div>
    </div>
    <div id="direct_invoice_button_tool_tip" class="ir_d_none_p_m_bg_br_bs">
        <h1 class="title ir_m_fs14_lh25"><?php echo lang('for_fast_food_restaurants'); ?></h1>
    </div>

    <!-- Pos Screen Sidebar  -->
    <aside id="pos__sidebar">
        <div class="brand__logo">
            <img src="<?php echo escape_output($system_logo); ?>">
        </div>
        <ul class="pos__menu__list scrollbar-macosx">

            <li class="menu-header small border_bottom_none common_use">
                <span class="menu-header-text"><?php echo lang('Common_Usages');?></span>
            </li>
            <li class="common_use">
                <a href="<?php echo base_url()?>Authentication/userProfile">
                    <i data-feather="home"></i>
                    <span> &nbsp; <?php echo lang('home'); ?></span>
                </a>
            </li>
            <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
            <li class="have_sub_menu menu_checker menu__cidirp_2 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="sliders"></i>
                    <span> &nbsp; <?php echo lang('Saas'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/siteSetting">
                        <?php echo lang('site_setting'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/emailSetting">
                        <?php echo lang('email_setting'); ?></a></li>
                 
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/paymentSetting">
                        <?php echo lang('Payment_Setting'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/addEditCompany">
                        <?php echo lang('Add'); ?> <?php echo lang('Company'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/companies">
                        <?php echo lang('List'); ?> <?php echo lang('Company'); ?></a></li>

                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/addManualPayment">
                        <?php echo lang('Add'); ?> <?php echo lang('Manual_Payment'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/paymentHistory">
                        <?php echo lang('List'); ?> <?php echo lang('Manual_Payment'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/addPricingPlan">
                        <?php echo lang('Add'); ?> <?php echo lang('Pricing_Plan'); ?></a></li>
                    <li data-access="saas" class="menu_assign_class" data-menu__cid="irp_2"><a href="<?php echo base_url()?>Service/pricingPlans">
                        <?php echo lang('List'); ?> <?php echo lang('Pricing_Plan'); ?></a></li>
                   
                </ul>
            </li>
            <?php endif?>
            <li  data-access="view-1" class="menu_assign_class common_use">
                <a href="<?php echo base_url()?>Dashboard/dashboard">
                    <i data-feather="bar-chart"></i>
                    <span> &nbsp; <?php echo lang('dashboard'); ?></span>
                </a>
            </li>
            <?php
            if(str_rot13($language_manifesto)=="eriutoeri"):?>
                <li class="have_sub_menu menu_checker menu__cidirp_3 common_use">
                    <a class="open-trigger" href="javascript:void(0)">
                        <i data-feather="grid"></i>
                        <span> &nbsp; <span> <?php echo lang('outlets'); ?></span></span>
                    </a>
                    <ul class="sub__menu__list">
                        <li data-access="add-67" class="menu_assign_class" data-menu__cid="irp_3"><a href="<?php echo base_url()?>Outlet/addEditOutlet">
                            <?php echo lang('Add'); ?> <?php echo lang('outlet'); ?></a></li>
                        <li data-access="view-67" class="menu_assign_class" data-menu__cid="irp_3"><a href="<?php echo base_url()?>Outlet/outlets">
                            <?php echo lang('List'); ?> <?php echo lang('outlet'); ?></a></li>
                    </ul>
                </li>
            <?php else:?>
                <li data-access="update-67" class="menu_assign_class menu__cidirp_3 common_use" data-menu__cid="irp_3">
                    <a href="<?php echo base_url()?>Outlet/addEditOutlet/<?php echo escape_output($outlet_id)?>">
                        <i data-feather="tool"></i>
                        <span> &nbsp;  <?php echo lang('outlet_setting'); ?></span>
                    </a>
                </li>
            <?php endif;?>

            <li class="have_sub_menu menu_checker menu__cidirp_4 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="command"></i>
                    <span>&nbsp; <?php echo lang('Panel'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="pos_1-73" class="menu_assign_class" data-menu__cid="irp_4"><a href="<?php echo base_url()?>POSChecker/posAndWaiterMiddleman">
                        <?php echo lang('pos'); ?></a></li>
                    <li data-access="add-98" class="menu_assign_class" data-menu__cid="irp_4"><a href="<?php echo base_url()?>Kitchen/addEditKitchen">
                        <?php echo lang('Add'); ?> <?php echo lang('kitchen'); ?></a></li>
                    <li data-access="view-98" class="menu_assign_class" data-menu__cid="irp_4"><a href="<?php echo base_url()?>Kitchen/kitchens">
                        <?php echo lang('List'); ?> <?php echo lang('kitchen'); ?></a></li>
                    <li data-access="view-104" class="menu_assign_class" data-menu__cid="irp_4"><a href="<?php echo base_url()?>Waiter/panel">
                        <?php echo lang('Waiter'); ?></a></li>
                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_5 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="settings"></i>
                    <span> &nbsp; <?php echo lang('Settings'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <?php
                        $main_com = getMainCompany();
                        $languge_manifesto = $main_com->languge_manifesto;
                        if($languge_manifesto=="sGmsJaFJVE" && $user_id!=1):
                    ?>

                    <li data-access="" class="" data-menu__cid="irp_2"><a href="<?php echo base_url()?>authentication/currentPlanDetails">
                    <?php echo lang('Current_Plan_Details'); ?> </a></li>
                    <?php endif?>

                    <li  data-access="update-6" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/index">
                            
                            <?php echo lang('Settings'); ?>
                        </a>
                    </li>
                    <?php
                    if(!isFoodCourt()):
                        $wlb = $this->session->userdata('wlb');
                        if($wlb==1):
                            if($getCompanyInfo->id==1):
                            ?>
                    <li  data-access="update-49" class="menu_assign_class">
                        <a href="<?php echo base_url(); ?>WhiteLabel">
                            
                            <?php echo lang('WhiteLabel'); ?>
                        </a>
                    </li>
                    <?php
                        endif;
                    endif;
                    endif;
                    ?>
                    <li class="have_sub_sub_menu menu_checker">
                        <a class="open-trigger" href="#">
                            <div>
                                <?php echo lang('Printer'); ?>
                            </div>
                            <span class="pull-right-container">
                                <i class="far fa-chevron-left"></i>
                            </span>
                        </a>
                        <ul class="sub__sub__menu__list">
                            <li  data-access="add-35" class="menu_assign_class"><a href="<?php echo base_url()?>printer/addEditPrinter">
                                    <?php echo lang('Add'); ?> <?php echo lang('Printer'); ?></a></li>
                            <li  data-access="update-35" class="menu_assign_class"><a href="<?php echo base_url()?>printer/printers">
                                    <?php echo lang('List'); ?> <?php echo lang('Printer'); ?></a></li>
                                    <li data-access="add-353" class="menu_assign_class" data-menu__cid="irp_32"><a href="<?php echo base_url()?>counter/addEditCounter">
                                        <?php echo lang('Add'); ?> <?php echo lang('counter'); ?></a></li>
                                    <li data-access="view-353" class="menu_assign_class" data-menu__cid="irp_32"><a href="<?php echo base_url()?>counter/counters">
                                        <?php echo lang('List'); ?> <?php echo lang('counter'); ?></a></li>
                        </ul>
                    </li>
                    <li  data-access="update_tax-52" class="menu_assign_class"><a href="<?php echo base_url()?>setting/tax">
                            <?php echo lang('Tax_Setting'); ?></a></li>
                    <li  data-access="add-55" class="menu_assign_class"><a href="<?php echo base_url()?>MultipleCurrency/addEditMultipleCurrency">
                            <?php echo lang('Add'); ?> <?php echo lang('Multiple_Currency'); ?></a></li>
                    <li  data-access="view-55" class="menu_assign_class"><a href="<?php echo base_url()?>MultipleCurrency/MultipleCurrencies">
                            <?php echo lang('List'); ?> <?php echo lang('Multiple_Currency'); ?></a></li>
                   <?php if($company_id==1): ?>
                    <?php if(!isServiceAccessOnly('sGmsJaFJE')): ?>
                        <li  data-access="update-60" class="menu_assign_class"><a href="<?php echo base_url()?>Update/index">
                                <?php echo lang('software_update'); ?></a></li>
                        <li  data-access="uninstall-62" class="menu_assign_class"><a href="<?php echo base_url()?>Update/UninstallLicense">
                                <?php echo lang('Uninstall_License'); ?></a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                   
                    <li data-access="add-260" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>paymentMethod/addEditPaymentMethod">
                            <?php echo lang('Add'); ?> <?php echo lang('payment_method'); ?></a></li>
                    <li data-access="view-260" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>paymentMethod/paymentMethods">
                            <?php echo lang('List'); ?> <?php echo lang('payment_method'); ?></a></li>
                    <li data-access="add-265" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Denomination/addEditDenomination">
                            <?php echo lang('Add'); ?> <?php echo lang('denomination'); ?></a></li>
                    <li data-access="view-265" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Denomination/denominations">
                            <?php echo lang('List'); ?> <?php echo lang('denomination'); ?></a></li>
                    <li data-access="add-270" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>DeliveryPartner/addEditDeliveryPartner">
                            <?php echo lang('Add'); ?> <?php echo lang('deliveryPartner'); ?></a></li>
                    <li data-access="view-270" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>DeliveryPartner/deliveryPartners">
                            <?php echo lang('List'); ?> <?php echo lang('deliveryPartner'); ?></a></li>
                    <li data-access="add-275" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Area/addEditArea">
                            <?php echo lang('Add'); ?> <?php echo lang('area'); ?></a></li>
                    <li data-access="view-275" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Area/areas">
                            <?php echo lang('List'); ?> <?php echo lang('area'); ?></a></li>
                    <li data-access="add-280" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>table/addEditTable">
                            <?php echo lang('Add'); ?> <?php echo lang('table'); ?></a></li>
                    <li data-access="view-280" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>table/tables">
                            <?php echo lang('List'); ?> <?php echo lang('table'); ?></a></li>
                   <li data-access="view-280" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>table/tableLayoutSetting">
                            <?php echo lang('table_layout_setting'); ?></a></li>
                </ul>
            </li>


            <li class="have_sub_menu menu_checker menu__cidirp_6 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="tool"></i>
                    <span> &nbsp; <?php echo lang('sos_Self_Order_Setting'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/selfOrderEnableDisable">
                            <?php echo lang('enable_disable'); ?>
                        </a>
                    </li>
                    <?php if($getCompanyInfo->sos_enable_self_order=="Yes"):?>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/tableQrcodeGenerator">
                            <?php echo lang('table_qrcode_generator'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/orderReceivingUserSelfOrder">
                            <?php echo lang('order_receiving_user'); ?>
                        </a>
                    </li>
                    <?php endif?>
                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_7 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="globe"></i>
                    <span>&nbsp;<?php echo lang('sos_online_order_setting'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/onlineOrderEnableDisable">
                            <?php echo lang('enable_disable'); ?>
                        </a>
                    </li>

                    <?php if($getCompanyInfo->sos_enable_online_order=="Yes"):?>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/orderReceivingUserOnlineOrder">
                            <?php echo lang('order_receiving_user'); ?>
                        </a>
                    </li>
                    <?php endif?>

                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/websiteWhiteLabel">
                            <?php echo lang('website_white_label'); ?>
                        </a>
                    </li>


                    <li class="have_sub_sub_menu menu_checker">
                        <a class="open-trigger" href="#">
                            <div>
                                <?php echo lang('common_setting'); ?>
                            </div>
                            <span class="pull-right-container">
                                <i class="far fa-chevron-left"></i>
                            </span>
                        </a>
                        <ul class="sub__sub__menu__list p-0">
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/bannerSection">
                                <?php echo lang('banner_section'); ?></a>
                            </li>
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/serviceSection">
                                <?php echo lang('serviceSection'); ?></a>
                            </li>
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/exploreMenuSection">
                                <?php echo lang('exploreMenuSection'); ?></a>
                            </li>
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/addEditPhoto">
                                <?php echo lang('add_photo'); ?></a>
                            </li>
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/photos">
                                <?php echo lang('list_photo'); ?></a>
                            </li>
                            <li  data-access="all_setting-358" class="menu_assign_class"><a href="<?php echo base_url()?>Frontend/socialMedia">
                                <?php echo lang('socialMedia'); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/availableOnlineFoods">
                            <?php echo lang('available_online_foods'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/aboutUsContent">
                            <?php echo lang('aboutUsContent'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/googleMap">
                            <?php echo lang('contact_us_content'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/contactList">
                            <?php echo lang('contact_list'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/commonMenuPage">
                            <?php echo lang('commonMenuPage'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/social_login_setting">
                            <?php echo lang('social_login_setting'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/emailSetting">
                            <?php echo lang('email_setting'); ?>
                        </a>
                    </li>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>Frontend/paymentSetting">
                            <?php echo lang('payment_gateway'); ?>
                        </a>
                    </li>

                    
                </ul>
            </li>
      
            <li class="have_sub_menu menu_checker menu__cidirp_8 common_use">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="bookmark"></i>
                    <span> &nbsp; <?php echo lang('reservationSetting'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/reservationEnableDisable">
                            <?php echo lang('order'); ?> <?php echo lang('enable_disable'); ?>
                        </a>
                    </li>
                    <?php if($getCompanyInfo->sos_enable_reservation=="Yes"):?>
                    <li  data-access="all_setting-358" class="menu_assign_class">
                        <a href="<?php echo base_url()?>setting/orderReceivingUserReservation">
                            <?php echo lang('order_receiving_user'); ?>
                        </a>
                    </li>
                    <?php endif?>
                </ul>
            </li>
     
            <li class="menu-header small border_bottom_none item_stock">
                <span class="menu-header-text"><?php echo lang('Item_Stock');?></span>
            </li>
            <li class="have_sub_menu menu_checker menu__cidirp_9 item_stock">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="pocket"></i>
                    <span>&nbsp;<?php echo lang('master'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-212" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Unit/addEditUnit"> <?php echo lang('Add'); ?> <?php echo lang('Ingredient_Unit'); ?></a></li>
                    <li data-access="view-212" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>Unit/Units"> <?php echo lang('List'); ?> <?php echo lang('Ingredient_Unit'); ?></a></li>
                    <li data-access="add-207" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>ingredientCategory/addEditIngredientCategory"> <?php echo lang('Add'); ?> <?php echo lang('ingredient_category'); ?></a></li>
                    <li data-access="view-207" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>ingredientCategory/ingredientCategories"> <?php echo lang('List'); ?> <?php echo lang('ingredient_category'); ?></a></li>
                    <li data-access="add-217" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>ingredient/addEditIngredient"> <?php echo lang('Add'); ?> <?php echo lang('ingredient'); ?></a></li>
                    <li data-access="view-217" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>ingredient/ingredients"> <?php echo lang('List'); ?> <?php echo lang('ingredient'); ?></a></li>
                    <li data-access="add-223" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>modifier/addEditModifier"> <?php echo lang('Add'); ?> <?php echo lang('modifier'); ?></a></li>
                    <li data-access="view-223" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>modifier/modifiers"> <?php echo lang('List'); ?> <?php echo lang('modifier'); ?></a></li>
                    <li data-access="add-229" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>foodMenuCategory/addEditFoodMenuCategory"> <?php echo lang('Add'); ?> <?php echo lang('food_menu_category'); ?></a></li>
                    <li data-access="view-229" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>foodMenuCategory/foodMenuCategories"> <?php echo lang('List'); ?> <?php echo lang('food_menu_category'); ?></a></li>
                    <li data-access="add-234" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>foodMenu/addEditFoodMenu"> <?php echo lang('Add'); ?> <?php echo lang('food_menu'); ?></a></li>
                    <li data-access="view-234" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>foodMenu/foodMenus"> <?php echo lang('List'); ?> <?php echo lang('food_menu'); ?></a></li>
                    <li data-access="add-325" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>PreMadeFood/addEditPreMadeFood"> <?php echo lang('Add'); ?> <?php echo lang('premade_food'); ?></a></li>
                    <li data-access="view-325" class="menu_assign_class" data-menu__cid="irp_16"><a href="<?php echo base_url()?>PreMadeFood/preMadeFoods"><?php echo lang('List'); ?> <?php echo lang('premade_food'); ?></a></li>
                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_10 item_stock">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="anchor"></i>
                    <span> &nbsp;<?php echo lang('production'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-340" class="menu_assign_class" data-menu__cid="irp_6_1"><a href="<?php echo base_url()?>Production/addEditProduction">
                        <?php echo lang('Add'); ?> <?php echo lang('production'); ?></a></li>
                    <li data-access="view-340" class="menu_assign_class" data-menu__cid="irp_6_1"><a href="<?php echo base_url()?>Production/productions">
                        <?php echo lang('List'); ?> <?php echo lang('production'); ?></a></li>
                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_11 item_stock">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="database"></i>
                    <span> &nbsp;<?php echo lang('inventory'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="view-129" class="menu_assign_class" data-menu__cid="irp_9"><a href="<?php echo base_url()?>Inventory/index">
                            <?php echo lang('inventory'); ?></a></li>
                    <li data-access="view-173" class="menu_assign_class" data-menu__cid="irp_9"><a href="<?php echo base_url()?>Inventory/getInventoryAlertList">
                            <?php echo lang('ingredients_alert'); ?></a></li>
                    <li data-access="veiw-346" class="menu_assign_class" data-menu__cid="irp_9"><a href="<?php echo base_url()?>Inventory/inventoryFoodMenu">
                            <?php echo lang('inventory_food_menu'); ?></a></li>
                    <li data-access="add-131" class="menu_assign_class" data-menu__cid="irp_9"><a href="<?php echo base_url()?>Inventory_adjustment/addEditInventoryAdjustment">
                            <?php echo lang('Add'); ?> <?php echo lang('inventory_adjustment'); ?></a></li>
                    <li data-access="view-131" class="menu_assign_class" data-menu__cid="irp_9"><a href="<?php echo base_url()?>Inventory_adjustment/inventoryAdjustments">
                            <?php echo lang('List'); ?> <?php echo lang('inventory_adjustment'); ?></a></li>
                </ul>
            </li>


            <li class="menu-header small border_bottom_none sale_customer">
                <span class="menu-header-text"><?php echo lang('Sale_Customer');?></span>
            </li>
            <li class="have_sub_menu menu_checker menu__cidirp_12 sale_customer">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="shopping-cart"></i>
                    <span>&nbsp; <?php echo lang('sale'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-118" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>Promotion/addEditPromotion">
                            <?php echo lang('Add'); ?> <?php echo lang('promotion'); ?></a></li>
                    <li data-access="view-118" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>Promotion/promotions">
                            <?php echo lang('List'); ?> <?php echo lang('promotion'); ?></a></li>

                    <li data-access="add-249" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>customer/addEditCustomer">
                            <?php echo lang('Add'); ?> <?php echo lang('customer'); ?></a></li>
                    <li data-access="view-249" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>customer/customers">
                            <?php echo lang('List'); ?> <?php echo lang('customer'); ?></a></li>
                    <li data-access="upload_customer-249" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>customer/uploadCustomer">
                            <?php echo lang('upload_customer'); ?></a></li>

                    <li data-access="pos_1-73" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>POSChecker/posAndWaiterMiddleman">
                            <?php echo lang('Add'); ?> <?php echo lang('sale'); ?></a></li>
                    <li data-access="view-123" class="menu_assign_class" data-menu__cid="8"><a href="<?php echo base_url()?>Sale/sales">
                            <?php echo lang('List'); ?> <?php echo lang('sale'); ?></a></li>
                </ul>
            </li>
            <li class="have_sub_menu menu_checker menu__cidirp_13 sale_customer">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="corner-down-right"></i>
                    <span> &nbsp;<?php echo lang('customer_due_receive'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-151" class="menu_assign_class" data-menu__cid="irp_13"><a href="<?php echo base_url()?>Customer_due_receive/addCustomerDueReceive">
                            <?php echo lang('Add'); ?> <?php echo lang('customer_due_receive'); ?></a></li>
                    <li data-access="view-151" class="menu_assign_class" data-menu__cid="irp_13"><a href="<?php echo base_url()?>Customer_due_receive/customerDueReceives">
                            <?php echo lang('List'); ?> <?php echo lang('customer_due_receive'); ?></a></li> ?></a></li>

                </ul>
            </li>

            <li class="menu-header small border_bottom_none purchase_expense">
                <span class="menu-header-text"><?php echo lang('Purchase_Expense');?></span>
            </li>
            <li class="have_sub_menu menu_checker purchase_expense">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="arrow-down-circle"></i>
                    <span> &nbsp;<?php echo lang('purchase'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-244" class="menu_assign_class" data-menu__cid="irp_6"><a href="<?php echo base_url()?>supplier/addEditSupplier">
                            <?php echo lang('Add'); ?> <?php echo lang('supplier'); ?></a></li>
                    <li data-access="view-244" class="menu_assign_class" data-menu__cid="irp_6"><a href="<?php echo base_url()?>supplier/suppliers">
                            <?php echo lang('List'); ?> <?php echo lang('supplier'); ?></a></li>
                    <li data-access="add-106" class="menu_assign_class" data-menu__cid="irp_6"><a href="<?php echo base_url()?>Purchase/addEditPurchase">
                            <?php echo lang('Add'); ?> <?php echo lang('purchase'); ?></a></li>
                    <li data-access="view-106" class="menu_assign_class" data-menu__cid="irp_6"><a href="<?php echo base_url()?>Purchase/purchases">
                            <?php echo lang('List'); ?> <?php echo lang('purchase'); ?></a></li>
                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_14 purchase_expense">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="corner-down-left"></i>
                    <span>&nbsp; <?php echo lang('supplier_due_payment'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-147" class="menu_assign_class" data-menu__cid="irp_12"><a href="<?php echo base_url()?>SupplierPayment/addSupplierPayment">
                            <?php echo lang('Add'); ?> <?php echo lang('supplier_due_payment'); ?></a></li>
                    <li data-access="view-147" class="menu_assign_class" data-menu__cid="irp_12"><a href="<?php echo base_url()?>SupplierPayment/supplierPayments">
                            <?php echo lang('List'); ?> <?php echo lang('supplier_due_payment'); ?></a></li>

                </ul>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_15 purchase_expense">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="arrow-left-circle"></i>
                    <span> &nbsp;<?php echo lang('expense'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-255" class="menu_assign_class" data-menu__cid="irp_11"><a href="<?php echo base_url()?>expenseItems/addEditExpenseItem">
                            <?php echo lang('Add'); ?> <?php echo lang('expense_item'); ?></a></li>
                    <li data-access="view-255" class="menu_assign_class" data-menu__cid="irp_11"><a href="<?php echo base_url()?>expenseItems/expenseItems">
                            <?php echo lang('List'); ?> <?php echo lang('expense_item'); ?></a></li>
                    <li data-access="add-142" class="menu_assign_class" data-menu__cid="irp_11"><a href="<?php echo base_url()?>Expense/addEditExpense">
                            <?php echo lang('Add'); ?> <?php echo lang('expense'); ?></a></li>
                    <li data-access="view-142" class="menu_assign_class" data-menu__cid="irp_11"><a href="<?php echo base_url()?>Expense/expenses">
                            <?php echo lang('List'); ?> <?php echo lang('expense'); ?></a></li>

                </ul>
            </li>
            
            

            <li class="menu-header small border_bottom_none transfer_damage">
                <span class="menu-header-text"><?php echo lang('Transfer_Damage');?></span>
            </li>
            <?php if(str_rot13($data_c[0]) == "eriutoeri"):?>
            <li class="have_sub_menu menu_checker menu__cidirp_16 transfer_damage">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="truck"></i>
                    <span> &nbsp;<?php echo lang('transfer'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-112" class="menu_assign_class" data-menu__cid="irp_7"><a href="<?php echo base_url()?>Transfer/addEditTransfer">
                            <?php echo lang('Add'); ?> <?php echo lang('transfer'); ?></a></li>
                    <li data-access="view-112" class="menu_assign_class" data-menu__cid="irp_7"><a href="<?php echo base_url()?>Transfer/transfers">
                            <?php echo lang('List'); ?> <?php echo lang('transfer'); ?></a></li>
                </ul>
            </li>
            <?php endif?>

            <li class="have_sub_menu menu_checker menu__cidirp_17 transfer_damage">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="trash-2"></i>
                    <span>&nbsp; <?php echo lang('waste'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-137" class="menu_assign_class" data-menu__cid="irp_10"><a href="<?php echo base_url()?>Waste/addEditWaste">
                            <?php echo lang('Add'); ?> <?php echo lang('waste'); ?></a></li>
                    <li data-access="view-137" class="menu_assign_class" data-menu__cid="irp_10"><a href="<?php echo base_url()?>Waste/wastes">
                            <?php echo lang('List'); ?> <?php echo lang('waste'); ?></a></li>

                </ul>
            </li>

           
            
            <li class="menu-header small border_bottom_none account_attendance">
                <span class="menu-header-text"><?php echo lang('Account_Attendance');?></span>
            </li>
            <li class="have_sub_menu menu_checker menu__cidirp_18 account_attendance">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="users"></i>
                    <span>&nbsp;<?php echo lang('account_user'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-285" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Role/addEditRole"><?php echo lang('Add'); ?> <?php echo lang('role'); ?></a></li>
                    <li data-access="view-285" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Role/roles"><?php echo lang('List'); ?> <?php echo lang('role'); ?></a></li>
                    <li data-access="add-291" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>User/addEditUser"><?php echo lang('Add'); ?> <?php echo lang('user'); ?></a></li>
                    <li data-access="view-291" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>User/users"><?php echo lang('List'); ?> <?php echo lang('user'); ?></a></li>
                    <li data-access="update-298" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Authentication/changeProfile"><?php echo lang('change_profile'); ?></a></li>
                    <li data-access="update-300" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Authentication/changePassword"><?php echo lang('change_password'); ?></a></li>
                    <li data-access="update-330" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Authentication/changePin"><?php echo lang('changePin'); ?></a></li>
                    <li data-access="update-302" class="menu_assign_class" data-menu__cid="irp_17"><a href="<?php echo base_url()?>Authentication/securityQuestion"><?php echo lang('SetSecurityQuestion'); ?></a></li>
                </ul>
            </li>
            <li class="have_sub_menu menu_checker menu__cidirp_19 account_attendance">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="clock"></i>
                    <span> &nbsp;<?php echo lang('attendance'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="add-155" class="menu_assign_class" data-menu__cid="irp_14"><a href="<?php echo base_url()?>Attendance/addEditAttendance">
                            <?php echo lang('Add'); ?> <?php echo lang('attendance'); ?></a></li>
                    <li data-access="view-155" class="menu_assign_class" data-menu__cid="irp_14"><a href="<?php echo base_url()?>Attendance/attendances">
                            <?php echo lang('List'); ?> <?php echo lang('attendance'); ?></a></li>
                </ul>
            </li>

            <li class="menu-header small border_bottom_none setting_report1">
                <span class="menu-header-text"><?php echo lang('Report_Settings');?></span>
            </li>

            <li class="have_sub_menu menu_checker menu__cidirp_20 setting_report1">
                <a class="open-trigger" href="javascript:void(0)">
                    <i data-feather="book"></i>
                    <span>&nbsp;<?php echo lang('report'); ?></span>
                </a>
                <ul class="sub__menu__list">
                    <li data-access="view-159" class="menu_assign_class" data-menu__cid="irp_12irp_12irp_15"><a href="<?php echo base_url()?>Report/registerReport"><?php echo lang('register_report'); ?></a></li>
                    <li data-access="view-314" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/zReport"><?php echo lang('z_report'); ?></a></li>
                    <li data-access="view-314" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/kitchenPerformanceReport"><?php echo lang('kitchenPerformanceReport'); ?></a></li>
                    <li data-access="view-332" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/productAnalysisReport"> <?php echo lang('productAnalysisReport'); ?></a></li>
                    <li data-access="view-161" class="menu_assign_class" data-menu__cid="irp_12irp_12irp_15"><a href="<?php echo base_url()?>Report/dailySummaryReport"><?php echo lang('daily_summary_report'); ?></a></li>
                    <li data-access="view-163" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/foodMenuSales"><?php echo lang('food_sale_report'); ?></a></li>
                    <li data-access="view-165" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/saleReportByDate"><?php echo lang('daily_sale_report'); ?></a></li>
                    <li data-access="view-167" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/detailedSaleReport"><?php echo lang('detailed_sale_report'); ?></a></li>
                    <li data-access="view-370" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/serviceDeliveryChargeReport"><?php echo lang('serviceDeliveryChargeReport'); ?></a></li>
                    <li data-access="view-169" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/consumptionReport"><?php echo lang('consumption_report'); ?></a></li>
                    <li data-access="view-171" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/inventoryReport"><?php echo lang('inventory_report'); ?></a></li>
                    <li data-access="view-173" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/getInventoryAlertList"><?php echo lang('low_inventory_report'); ?></a></li>
                    <li data-access="view-175" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/profitLossReport"><?php echo lang('profit_loss_report'); ?></a></li>
                    <li data-access="view-179" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/attendanceReport"><?php echo lang('attendance_report'); ?></a></li>
                    <li data-access="view-181" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/supplierLedgerReport"><?php echo lang('supplier_ledger_report'); ?></a></li>
                    <li data-access="view-183" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/supplierDueReport"><?php echo lang('supplier_due_report'); ?></a></li>
                    <li data-access="view-185" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/customerDueReport"><?php echo lang('customer_due_report'); ?></a></li>
                    <li data-access="view-187" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/customerLedgerReport"><?php echo lang('customer_ledger_report'); ?></a></li>
                    <li data-access="view-189" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/purchaseReportByDate"><?php echo lang('purchase_report'); ?></a></li>
                    <li data-access="view-191" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/expenseReport"><?php echo lang('expense_report'); ?></a></li>
                    <li data-access="view-193" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/wasteReport"><?php echo lang('waste_report'); ?></a></li>
                    <li data-access="view-195" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/vatReport"><?php echo lang('vat_report'); ?></a></li>
                    <li data-access="view-197" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/foodMenuSaleByCategories"><?php echo lang('foodMenuSaleByCategories'); ?></a></li>
                    <li data-access="view-199" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/tipsReport"><?php echo lang('tips_report'); ?></a></li>
                    <li data-access="view-201" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/auditLogReport"><?php echo lang('auditLogReport'); ?></a></li>
                    <li data-access="view-205" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/availableLoyaltyPointReport"><?php echo lang('loyalty_point_report'); ?></a></li>
                    <li data-access="view-203" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/usageLoyaltyPointReport"><?php echo lang('usage_loyalty_point_report'); ?></a></li>
                    <?php if(str_rot13($data_c[0]) == "eriutoeri"):?>
                        <li data-access="view-307" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/transferReport"><?php echo lang('transferReport'); ?></a></li>
                    <?php endif;?>
                    <li data-access="view-337" class="menu_assign_class" data-menu__cid="irp_15"><a href="<?php echo base_url()?>Report/productionReport"><?php echo lang('productionReport'); ?></a></li>
                </ul>
            </li>
            
            <li data-access="view-321" class="menu_assign_class"><a class="child-menu" href="<?php echo base_url()?>Short_message_service/smsService">
                        <i data-feather="message-square"></i>  <span> <?php echo lang('send_sms'); ?></span></a></li>

            <?php if(isServiceAccess('','','sGmsJaFJE')): ?>
            <li data-access="view-291" class="menu_assign_class">
                <a href="<?php echo base_url()?>Plugin/plugins">
                    <i data-feather="pen-tool"></i>
                    <span> &nbsp; <?php echo lang('plugins'); ?></span>
                </a>
            </li>
            <?php endif;?>
            <li class="menu_assign_class">
                            <a href="<?php echo base_url()?>Authentication/logOut">
                                <i data-feather="log-out"></i>
                                <span> <?php echo lang('logout'); ?></span>
                            </a>
                        </li>
            
        </ul>
    </aside>
    
 
    <div class="ir_display_none current_object_tables"></div>
    <div class="ir_display_none current_text_tables"></div>
    <div class="ir_display_none current_kot_items"></div>
    <input type="hidden" id="is_offline_system" value="">
    <div class="kot_exist_checker ir_display_none"></div>

    <div class="tax_setting ir_display_none"><?php echo ($getCompanyInfo->tax_setting)?></div>

    
<?php
//generating object for access module show/hide
$j = 1;
$menu_objects = "";
$access = $this->session->userdata('function_access');

if(isset($access) && $access):
    foreach($access as $value){
        if($j==count($access)){
            $menu_objects .="'".$value."'";
        }else{
            $menu_objects .="'".$value."',";
        }
        $j++;
    }
endif;
?>
    <script>
        /*This variable could not be escaped because this is building object*/
        window.menu_objects = [<?php echo ($menu_objects);?>];
    </script>

    <script src="<?php echo base_url(); ?>frequent_changing/notify/toastr.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/marquee.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/items.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/datable.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/jquery.cookie.js"></script>
    <!-- For Tooltip -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/lib/tippy/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/lib/tippy/tippy-bundle.umd.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/POS/js/lib/datepicker.js"></script>
    <!-- Custom Scrollbar -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/lib/scrollbar/jquery.scrollbar.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/POS/css/lib/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/POS/js/howler.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/feather.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/js/pos_script_v7.3.js?v=7.7"></script>
    <script src="<?php echo base_url(); ?>assets/POS/js/media.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/notify/jquery.notifyBar.js"></script>
    <script type="text/javascript">
    /*This variable could not be escaped because this is building object*/
    window.customers = [<?php echo ($customer_objects);?>]
    /*This variable could not be escaped because this is building object*/
    window.items = [<?php echo ($javascript_obects);?>];
    /*This variable could not be escaped because this is building object*/
    window.only_modifiers = [<?php echo ($javascript_obects_only_modifier);?>];
    /*This variable could not be escaped because this is building object*/
    window.kitchens = [<?php echo ($kitchens_objects);?>];

    $('.widthAndHeight').text($(window).width() +'x'+ $(window).height())


    function setHeightInComponent(){
        const winHeight = $(window).height();
        const runningOrderHeader =  $('#running_order_header:visible').height();
        const runningOrderBottomBtns = $('#left_side_button_holder_absolute:visible').height();
        $('.holder .order_details').css('height', winHeight - runningOrderBottomBtns - runningOrderHeader - 60 + 'px');
        // Set Height on Running Order
        const mh1 = $('.waiter_customer:visible').height();
        const mh2 = $('.main_top:visible').height();
        const mh3 = $('.top_header_for_mobile:visible').height();
        const mh4 = $('#bottom_absolute').height();
        const mh5 = $('.order_table_header_row').height();
        const mh6 = $('.top_header_part:visible').height();
        
        const r1 = mh1 !== undefined ? mh1 : 0;
        const r2 = mh2 !== undefined ? mh2 : 0;
        const r3 = mh3 !== undefined ? mh3 : 0;
        const r4 = mh4;
        const r5 = mh5;
        const r6 = mh6 !== undefined ? mh6 : 0;
       $('body').find('.main_center').css('height', winHeight - r1 - r2 - r3 - r4 - r5 - r6 - 50 + 'px');

    }
    </script>

    <!--for datatable-->
    <script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/register_details.js"></script>   
    <script src="<?php echo base_url(); ?>frequent_changing/js/new_ui_design.js"></script>   
</body>

</html>
<?php
$company_info   = getMainCompany();
 
$social_media   = isset($company_info->social_media) && $company_info->social_media ? json_decode($company_info->social_media) : '';
$getWhiteLabel  = json_decode(isset($company_info->website_white_label) && $company_info->website_white_label ? $company_info->website_white_label : '');
$login_customer = $this->session->userdata('customer_id');
$get_total_outlet = getAllOutlet();

$online_selected_outlet = $this->session->userdata('online_selected_outlet');
if(sizeof($get_total_outlet)==1){
  $online_selected_outlet = $get_total_outlet[0]->id;
  $this->session->set_userdata('online_selected_outlet', $online_selected_outlet);
}

$wl          = $getWhiteLabel;
$favicon     = '';
$system_logo = '';
if ($wl) {
  if ($wl->site_name) {
    $site_name = $wl->site_name;
  }
  if ($wl->footer) {
    $footer = $wl->footer;
  }
  if ($wl->system_logo) {
    $system_logo = base_url() . "images/" . $wl->system_logo;
  }
  if ($wl->favicon) {
    $favicon = base_url() . "images/" . $wl->favicon;
  } else {
    $favicon = base_url() . "images/favicon.ico";
  }
}

$food_menus     = getFoodMenuForMenuPage();
$only_modifiers = getModifiersForMenuPage();
$paymentSetting = paymentSetting();
$banner_section      = isset($company_info->main_banner_section) && $company_info->main_banner_section ? json_decode($company_info->main_banner_section) : '';
$i                 = 1;
$menu_to_show      = "";
$javascript_obects = "";

if (isset($food_menus) && $food_menus):
  foreach ($food_menus as $single_menus) {
    $sale_price  = $single_menus->sale_price;
    $total_menus = count($food_menus);

    if($single_menus->photo)  {
      $img = base_url()."images/".$single_menus->photo;
    }else{
      $img = base_url()."assets/media/no_image.png";
    }

    if ($total_menus == $i) {
      $javascript_obects .= "{item_id:'" . $single_menus->id . "',photo:'" . $img . "',parent_id:'" . $single_menus->parent_id . "',product_type:'" . $single_menus->product_type . "',item_name:'" . getPlanText($single_menus->name) . "',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',price:'" . getAmtP($sale_price) . "',tax_information:'" . $single_menus->tax_information . "',vat_percentage:'0'}";
    } else {
      $javascript_obects .= "{item_id:'" . $single_menus->id . "',photo:'" . $img . "',parent_id:'" . $single_menus->parent_id . "',product_type:'" . $single_menus->product_type . "',item_name:'" . getPlanText($single_menus->name) . "',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',price:'" . getAmtP($sale_price) . "',tax_information:'" . $single_menus->tax_information . "',vat_percentage:'0'},";
    }
    $i++;
  }
endif;

$j                               = 1;
$javascript_obects_only_modifier = "";
foreach ($only_modifiers as $single_menu_modifier) {
  if ($j == count($only_modifiers)) {
    $javascript_obects_only_modifier .= "{menu_modifier_id:'" . $single_menu_modifier->id . "',menu_modifier_name:'" . getPlanText($single_menu_modifier->name) . "',tax_information:'" . $single_menu_modifier->tax_information . "',menu_modifier_price:'" . getAmtP($single_menu_modifier->price) . "'}";
  } else {
    $javascript_obects_only_modifier .= "{menu_modifier_id:'" . $single_menu_modifier->id . "',menu_modifier_name:'" . getPlanText($single_menu_modifier->name) . "',tax_information:'" . $single_menu_modifier->tax_information . "',menu_modifier_price:'" . getAmtP($single_menu_modifier->price) . "'},";
  }
  $j++;
}

?>
<?php
$language = $this->session->userdata('language');
?>

<!DOCTYPE html>
<html lang="<?php echo isset($language) ? $language : 'en' ?>" dir="<?php echo isset($language) && $language == "arabic" ? 'rtl"' : 'ltr' ?>">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo escape_output($site_name); ?></title>

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Vendor Stylesheets -->
  <script src="<?php echo base_url() ?>assets/website/js/plugins/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/animate.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/magnific-popup.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/slick.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/slick-theme.css">
  <!-- Icon Fonts -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/fonts/flaticon/flaticon.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/fonts/font-awesome/css/all.min.css">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/owl-carousel/css/owl.theme.default.css">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/nice-select2.css">
  <!-- Page Specific Styles -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/plugins/leaflet.css">

  <script src="<?php echo base_url(); ?>frequent_changing/notify/toastr.js"></script>
  <link href="<?php echo base_url(); ?>frequent_changing/notify/toastr.css" rel="stylesheet" type="text/css" />
  <!-- Slices Style sheet -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/website/css/style.css">
  <!-- New Style Css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/frontend/style.css">
  <!-- RTL Styles -->
  <?php
  if (isset($language) && $language == "arabic") {
  ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/frontend/rtl.css">
  <?php
  }
  ?>
  <!-- Responsive Css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/frontend/responsive.css">
  <!-- Favicon -->
  <link rel="icon" href="<?php echo escape_output($favicon) ?>" type="image/x-icon">

</head>

<body class="<?php echo isset($language) && $language == "arabic" ? 'arabic-lang"' : '' ?>">
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
  <input type="hidden" id="total_vat_hidden" value="0">
  <input type="hidden" id="site_title" value="<?php echo escape_output($site_name); ?>">
  <input type="hidden" id="site_logo" value="<?php echo $system_logo ?>">
  <input type="hidden" id="precision" value="<?php echo $company_info->precision; ?>">
  <input type="hidden" id="currency" value="<?php echo $company_info->currency; ?>">
  <input type="hidden" id="collect_tax" value="<?php echo $company_info->collect_tax ?>">
  <input type="hidden" id="delivery_amount_hidden" value="<?php echo isset($company_info->delivery_amount) && $company_info->delivery_amount ? $company_info->delivery_amount : 0 ?>">
  <input type="hidden" id="apply_on_delivery_charge" value="<?php echo $company_info->apply_on_delivery_charge ?>">
  <input type="hidden" id="website_theme_color" value="<?php echo isset($wl->website_theme_color) && $wl->website_theme_color?$wl->website_theme_color:"#ff1010" ?>">
  <input type="hidden" id="already_added_to_the_cart" value="<?php echo lang('already_added_to_the_cart'); ?>">
  <input type="hidden" id="hidden_customer_id" value="<?php echo $this->session->userdata('customer_id') ?>">
  <input type="hidden" id="open_invoice_date_hidden" value="<?php echo date("Y-m-d") ?>">
  <input type="hidden" id="tax_type" value="<?php echo $company_info->tax_type ?>">
  <input type="hidden" id="not_data_in_cart" value="<?php echo lang('not_data_in_cart') ?>">
  <input type="hidden" id="cart_need_clean" value="<?php echo lang('cart_need_clean') ?>">
  <input type="hidden" id="order_copied" value="<?php echo lang('order_copied') ?>">
  <input type="hidden" id="alert_txt" value="<?php echo lang('alert') ?>">
  <input type="hidden" id="ok_text" value="<?php echo lang('ok') ?>">
  <input type="hidden" id="is_demo_mode" value="<?php echo APPLICATION_MODE;?>">
  <input type="hidden" id="username_short" value="<?php echo escape_output(getShortCustomerName())?>">
  <input type="hidden" id="online_selected_outlet" value="<?php echo $online_selected_outlet ?>">
  <!-- Preloader Start -->
  <div class="ct-preloader">
    <div class="ct-preloader-inner">
      <div class="lds-ripple">
        <div></div>
        <div></div>
      </div>
    </div>
  </div>
  <!-- Preloader End -->

  <?php
  if (isset($header_content)) {
    //This variable could not be escaped because this is html content
    echo ($header_content);
  }
  ?>
  <?php
  if (isset($main_content)) {
    //This variable could not be escaped because this is html content
    echo ($main_content);
  }
  ?>

  <!-- Footer Start -->
  <footer class="ct-footer footer-dark">
    <!-- Middle Footer -->
    <div class="footer-middle">
      <div class="container">
        <div class="row">
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 footer-widget">
            <div class="d-flex flex-column gap20px">
              <div class="footer-logo">
                <img src="<?php echo $system_logo; ?>" alt="logo">
              </div>
              <p>
              <?php echo isset($banner_section->short_des) && $banner_section->short_des ? $banner_section->short_des : '' ?>
              </p>
              <ul class="d-flex social-links">
                <li><a target="_blank" href="<?php echo isset($social_media->facebook_link) && $social_media->facebook_link ? $social_media->facebook_link : '' ?>"><svg width="11" height="21" viewBox="0 0 11 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M10.2 12.0646L10.766 8.37659H7.227V5.98259C7.20214 5.70675 7.23973 5.42886 7.33698 5.16954C7.43423 4.91022 7.58864 4.67614 7.78875 4.48467C7.98886 4.29321 8.22953 4.14928 8.49289 4.06357C8.75625 3.97786 9.03553 3.95257 9.31 3.98959H10.919V0.849586C9.97303 0.696857 9.01713 0.613635 8.059 0.600586C5.144 0.600586 3.239 2.36759 3.239 5.56459V8.37559H0V12.0636H3.24V20.9806H7.227V12.0646H10.2Z" fill="white" />
                    </svg>
                  </a></li>
                <li><a target="_blank" href="<?php echo isset($social_media->twitter_link) && $social_media->twitter_link ? $social_media->twitter_link : '' ?>"><svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.923 4.99056C8.01835 4.99056 7.13401 5.25881 6.38182 5.76141C5.62963 6.26401 5.04337 6.97837 4.69718 7.81416C4.35098 8.64995 4.2604 9.56963 4.43689 10.4569C4.61338 11.3442 5.04901 12.1592 5.68869 12.7989C6.32838 13.4385 7.14339 13.8742 8.03066 14.0507C8.91793 14.2272 9.8376 14.1366 10.6734 13.7904C11.5092 13.4442 12.2235 12.8579 12.7261 12.1057C13.2287 11.3535 13.497 10.4692 13.497 9.56455C13.4981 8.96359 13.3805 8.36833 13.151 7.81291C12.9215 7.2575 12.5846 6.75284 12.1597 6.3279C11.7347 5.90295 11.2301 5.56608 10.6746 5.33658C10.1192 5.10709 9.52396 4.9895 8.923 4.99056ZM8.923 12.5376C8.335 12.5376 7.7602 12.3632 7.27129 12.0365C6.78238 11.7098 6.40133 11.2455 6.17631 10.7023C5.95129 10.159 5.89241 9.56126 6.00713 8.98455C6.12184 8.40785 6.40499 7.87811 6.82077 7.46233C7.23655 7.04655 7.76629 6.76339 8.343 6.64868C8.9197 6.53397 9.51747 6.59284 10.0607 6.81786C10.604 7.04288 11.0683 7.42394 11.395 7.91284C11.7216 8.40175 11.896 8.97655 11.896 9.56455C11.8944 10.3526 11.5807 11.1078 11.0235 11.665C10.4663 12.2222 9.711 12.536 8.923 12.5376ZM14.75 4.80356C14.75 5.01459 14.6874 5.22088 14.5702 5.39635C14.4529 5.57182 14.2863 5.70858 14.0913 5.78934C13.8964 5.87009 13.6818 5.89122 13.4748 5.85005C13.2679 5.80888 13.0777 5.70726 12.9285 5.55804C12.7793 5.40882 12.6777 5.2187 12.6365 5.01172C12.5953 4.80474 12.6165 4.5902 12.6972 4.39523C12.778 4.20026 12.9147 4.03362 13.0902 3.91638C13.2657 3.79913 13.472 3.73656 13.683 3.73656C13.8233 3.73603 13.9623 3.76326 14.0921 3.81668C14.2218 3.8701 14.3397 3.94866 14.439 4.04783C14.5383 4.14701 14.6169 4.26483 14.6705 4.39453C14.724 4.52423 14.7514 4.66324 14.751 4.80356H14.75ZM17.775 5.88556C17.8045 4.49862 17.2868 3.15582 16.334 2.14755C15.3237 1.19796 13.9823 0.680839 12.596 0.706555C11.123 0.622555 6.709 0.622555 5.236 0.706555C3.85013 0.678907 2.50847 1.19469 1.498 2.14356C0.549305 3.15399 0.034171 4.49585 0.063 5.88156C-0.021 7.35456 -0.021 11.7686 0.063 13.2416C0.0335268 14.6285 0.551177 15.9713 1.504 16.9796C2.51461 17.9279 3.85534 18.4445 5.241 18.4196C6.714 18.5036 11.128 18.5036 12.601 18.4196C13.9879 18.449 15.3307 17.9314 16.339 16.9786C17.2865 15.9677 17.8018 14.6268 17.775 13.2416C17.863 11.7686 17.863 7.35856 17.775 5.88556ZM15.875 14.8196C15.7237 15.2045 15.4946 15.5542 15.2021 15.8467C14.9096 16.1391 14.56 16.3682 14.175 16.5196C13.001 16.9856 10.214 16.8776 8.917 16.8776C7.62 16.8776 4.829 16.9776 3.659 16.5196C3.27403 16.3682 2.9244 16.1391 2.6319 15.8467C2.33941 15.5542 2.11034 15.2045 1.959 14.8196C1.493 13.6456 1.601 10.8586 1.601 9.56156C1.601 8.26456 1.501 5.47356 1.959 4.30356C2.11034 3.91859 2.33941 3.56895 2.6319 3.27646C2.9244 2.98396 3.27403 2.7549 3.659 2.60356C4.833 2.13756 7.62 2.24555 8.917 2.24555C10.214 2.24555 13.005 2.14556 14.175 2.60356C14.56 2.7549 14.9096 2.98396 15.2021 3.27646C15.4946 3.56895 15.7237 3.91859 15.875 4.30356C16.341 5.47756 16.233 8.26456 16.233 9.56156C16.233 10.8586 16.343 13.6516 15.875 14.8196Z" fill="white" />
                    </svg>
                  </a></li>
                <li><a target="_blank" href="<?php echo isset($social_media->google_link) && $social_media->google_link ? $social_media->google_link : '' ?>"><svg width="21" height="17" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M18.285 4.41271C18.298 4.59371 18.298 4.77471 18.298 4.95571C18.3092 6.51945 18.0094 8.06982 17.4161 9.5167C16.8229 10.9636 15.9479 12.2781 14.8422 13.3839C13.7364 14.4896 12.4219 15.3646 10.975 15.9578C9.52812 16.5511 7.97775 16.8509 6.414 16.8397C4.14 16.8458 1.91267 16.1947 0 14.9647C0.335031 15.0017 0.67194 15.0191 1.009 15.0167C2.88915 15.0214 4.71606 14.3926 6.195 13.2317C5.32305 13.2156 4.47794 12.9274 3.7778 12.4075C3.07765 11.8875 2.55748 11.1618 2.29 10.3317C2.551 10.3731 2.81474 10.3949 3.079 10.3967C3.45018 10.3958 3.81976 10.3481 4.179 10.2547C3.23306 10.0634 2.38256 9.55044 1.77203 8.80301C1.16151 8.05558 0.82864 7.1198 0.83 6.15471V6.10571C1.4088 6.42863 2.0557 6.61023 2.718 6.63571C1.83156 6.04445 1.20417 5.13718 0.963878 4.09909C0.723589 3.061 0.888517 1.97034 1.425 1.04971C2.4741 2.34102 3.78289 3.39742 5.26649 4.15041C6.75009 4.90341 8.37539 5.3362 10.037 5.42071C9.97112 5.10595 9.93761 4.78528 9.937 4.46371C9.93905 3.62719 10.192 2.81053 10.6631 2.11929C11.1342 1.42805 11.8019 0.89402 12.5797 0.586243C13.3575 0.278467 14.2098 0.211097 15.0263 0.392838C15.8429 0.574579 16.5861 0.997076 17.16 1.60571C18.0954 1.42546 18.9924 1.08404 19.811 0.596707C19.4992 1.56121 18.8464 2.37894 17.975 2.89671C18.8044 2.80214 19.6151 2.58406 20.38 2.24971C19.8081 3.08243 19.0999 3.81268 18.285 4.40971V4.41271Z" fill="white" />
                    </svg>
                  </a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 footer-widget ">
            <div class="d-flex flex-column align-items-center first_widget">
              <h5 class="widget-title"><?php echo lang('information'); ?></h5>
              <ul>
                <li> <a href="<?php echo base_url() ?>"><?php echo lang('home'); ?></a> </li>
                <li> <a href="<?php echo base_url() . 'about-us'; ?>"><?php echo lang('about_us'); ?></a> </li>
                <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('Order_Online'); ?></a> </li>
                <?php if($company_info->sos_enable_reservation=="Yes"):?>
                 <li> <a href="<?php echo base_url() . 'reservation'; ?>"><?php echo lang('reservation'); ?></a> </li>
                <?php endif?>
                <li> <a href="<?php echo base_url() . 'contact-us'; ?>"><?php echo lang('contact_us'); ?></a> </li>
              </ul>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 footer-widget">
            <h5 class="widget-title"><?php echo lang('top_items'); ?></h5>
            <ul>
              <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('pepperoni'); ?></a> </li>
              <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('swiss_mushroom'); ?></a> </li>
              <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('barbeque_chicken'); ?></a> </li>
              <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('vegetarian'); ?></a> </li>
              <li> <a href="<?php echo base_url() . 'online-order'; ?>"><?php echo lang('ham_cheese'); ?></a> </li>
            </ul>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 footer-widget">
            <h5 class="widget-title"><?php echo lang('others'); ?></h5>
            <ul>             
              <li> <a href="<?php echo base_url() . 'checkout'; ?>"><?php echo lang('checkout'); ?></a> </li>
              <li> <a href="#" class="cart-trigger"><?php echo lang('cart'); ?></a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="container">
        <div class="footer-copyright text-center">
          <p><?php echo isset($getWhiteLabel->footer) && $getWhiteLabel->footer ? $getWhiteLabel->footer : ''; ?></p>
        </div>
      </div>
    </div>

  </footer>

  <div style="display:none" class="main-content-wrapper">
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
  <!-- Footer End -->

  <!-- Color Picker -->
  <div class="color-picker cart-trigger">
    <div class="color-picker-toggle">
    <span class="cart-item-count-static">0</span>
    <svg width="21" height="20" viewBox="0 0 21 20" fill="#AB7C94"  xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_9_611)">
                <path d="M20.3987 8.06641H17.137L14.7932 4.94141C14.8844 4.79818 14.956 4.64518 15.0081 4.48242C15.0601 4.31966 15.0862 4.14714 15.0862 3.96484C15.0862 3.48307 14.9137 3.06966 14.5686 2.72461C14.2236 2.37956 13.8101 2.20703 13.3284 2.20703C12.8466 2.20703 12.4332 2.37956 12.0881 2.72461C11.7431 3.06966 11.5706 3.48307 11.5706 3.96484C11.5706 4.45964 11.7431 4.8763 12.0881 5.21484C12.4332 5.55339 12.8466 5.72266 13.3284 5.72266C13.4195 5.72266 13.5074 5.71615 13.592 5.70312C13.6767 5.6901 13.7646 5.67057 13.8557 5.64453L15.6721 8.06641H6.29712L8.11353 5.64453C8.20467 5.67057 8.29256 5.6901 8.3772 5.70312C8.46183 5.71615 8.54972 5.72266 8.64087 5.72266C9.12264 5.72266 9.53605 5.55339 9.8811 5.21484C10.2262 4.8763 10.3987 4.45964 10.3987 3.96484C10.3987 3.48307 10.2262 3.06966 9.8811 2.72461C9.53605 2.37956 9.12264 2.20703 8.64087 2.20703C8.1591 2.20703 7.74569 2.37956 7.40063 2.72461C7.05558 3.06966 6.88306 3.48307 6.88306 3.96484C6.88306 4.14714 6.9091 4.31966 6.96118 4.48242C7.01326 4.64518 7.08488 4.79818 7.17603 4.94141L4.83228 8.06641H1.57056C1.41431 8.06641 1.27759 8.125 1.1604 8.24219C1.04321 8.35938 0.984619 8.49609 0.984619 8.65234C0.984619 8.82161 1.04321 8.96159 1.1604 9.07227C1.27759 9.18294 1.41431 9.23828 1.57056 9.23828H2.33228L2.62524 10.4102H19.344L19.637 9.23828H20.3987C20.5549 9.23828 20.6917 9.18294 20.8088 9.07227C20.926 8.96159 20.9846 8.82161 20.9846 8.65234C20.9846 8.49609 20.926 8.35938 20.8088 8.24219C20.6917 8.125 20.5549 8.06641 20.3987 8.06641ZM12.7424 3.96484C12.7424 3.80859 12.801 3.67188 12.9182 3.55469C13.0354 3.4375 13.1721 3.37891 13.3284 3.37891C13.4846 3.37891 13.6213 3.4375 13.7385 3.55469C13.8557 3.67188 13.9143 3.80859 13.9143 3.96484C13.9143 4.13411 13.8557 4.27409 13.7385 4.38477C13.6213 4.49544 13.4846 4.55078 13.3284 4.55078C13.1721 4.55078 13.0354 4.49544 12.9182 4.38477C12.801 4.27409 12.7424 4.13411 12.7424 3.96484ZM8.64087 3.37891C8.79712 3.37891 8.93384 3.4375 9.05103 3.55469C9.16821 3.67188 9.22681 3.80859 9.22681 3.96484C9.22681 4.13411 9.16821 4.27409 9.05103 4.38477C8.93384 4.49544 8.79712 4.55078 8.64087 4.55078C8.48462 4.55078 8.3479 4.49544 8.23071 4.38477C8.11353 4.27409 8.05493 4.13411 8.05493 3.96484C8.05493 3.80859 8.11353 3.67188 8.23071 3.55469C8.3479 3.4375 8.48462 3.37891 8.64087 3.37891ZM4.34399 17.2852C4.43514 17.6758 4.64022 17.9948 4.95923 18.2422C5.27824 18.4896 5.63957 18.6133 6.04321 18.6133H15.926C16.3297 18.6133 16.691 18.4896 17.01 18.2422C17.329 17.9948 17.5341 17.6758 17.6252 17.2852L19.051 11.582H2.91821L4.34399 17.2852ZM13.9143 13.3398C13.9143 13.1836 13.9729 13.0469 14.0901 12.9297C14.2073 12.8125 14.344 12.7539 14.5002 12.7539C14.6565 12.7539 14.7932 12.8125 14.9104 12.9297C15.0276 13.0469 15.0862 13.1836 15.0862 13.3398V16.8555C15.0862 17.0247 15.0276 17.1647 14.9104 17.2754C14.7932 17.3861 14.6565 17.4414 14.5002 17.4414C14.344 17.4414 14.2073 17.3861 14.0901 17.2754C13.9729 17.1647 13.9143 17.0247 13.9143 16.8555V13.3398ZM10.3987 13.3398C10.3987 13.1836 10.4573 13.0469 10.5745 12.9297C10.6917 12.8125 10.8284 12.7539 10.9846 12.7539C11.1409 12.7539 11.2776 12.8125 11.3948 12.9297C11.512 13.0469 11.5706 13.1836 11.5706 13.3398V16.8555C11.5706 17.0247 11.512 17.1647 11.3948 17.2754C11.2776 17.3861 11.1409 17.4414 10.9846 17.4414C10.8284 17.4414 10.6917 17.3861 10.5745 17.2754C10.4573 17.1647 10.3987 17.0247 10.3987 16.8555V13.3398ZM6.88306 13.3398C6.88306 13.1836 6.94165 13.0469 7.05884 12.9297C7.17603 12.8125 7.31274 12.7539 7.46899 12.7539C7.62524 12.7539 7.76196 12.8125 7.87915 12.9297C7.99634 13.0469 8.05493 13.1836 8.05493 13.3398V16.8555C8.05493 17.0247 7.99634 17.1647 7.87915 17.2754C7.76196 17.3861 7.62524 17.4414 7.46899 17.4414C7.31274 17.4414 7.17603 17.3861 7.05884 17.2754C6.94165 17.1647 6.88306 17.0247 6.88306 16.8555V13.3398Z" fill="#212121" />
              </g>
              <defs>
                <clipPath id="clip0_9_611">
                  <rect width="20" height="20" fill="white" transform="matrix(1 0 0 -1 0.984619 20)" />
                </clipPath>
              </defs>
            </svg>
    </div>
  </div>
<?php
  $go_online_status =  $this->session->userdata('go_online_status');  
  if($go_online_status=="Yes"):
?>
  <a href="<?php echo base_url() ?>back-to-main-page" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Main Page
    </a>
    <?php
      endif;
    ?>
  <?php
    include 'outlet_select_modal.php';
  ?>

  <!-- Vendor Scripts -->
  <script src="<?php echo base_url() ?>assets/website/js/plugins/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/waypoint.js"></script>

  <script src="<?php echo base_url() ?>assets/website/js/plugins/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/jquery.slimScroll.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/imagesloaded.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/jquery.steps.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/jquery.countdown.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/plugins/slick.min.js"></script>
  <script src="<?php echo base_url() ?>assets/owl-carousel/js/owl.carousel.min.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/nice-select2.js"></script>

  <!-- Slices Scripts -->
  <script src="<?php echo base_url() ?>assets/website/js/main.js"></script>

  <!-- Page Specific Scripts -->
  <script src="<?php echo base_url() ?>assets/website/js/plugins/leaflet.js"></script>
  <script src="<?php echo base_url() ?>assets/website/js/order.js"></script>

  <!-- Checkout End -->
  <script>
    /*This variable could not be escaped because this is building object*/
    window.items = [<?php echo ($javascript_obects); ?>];
    /*This variable could not be escaped because this is building object*/
    window.only_modifiers = [<?php echo ($javascript_obects_only_modifier); ?>];
  </script>

</body>

</html>
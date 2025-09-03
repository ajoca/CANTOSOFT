<?php
$company_info        = getMainCompany();
$banner_section      = isset($company_info->main_banner_section) && $company_info->main_banner_section ? json_decode($company_info->main_banner_section) : '';
$getWhiteLabel       = json_decode(isset($company_info->website_white_label) && $company_info->website_white_label ? $company_info->website_white_label : '');
$login_customer      = $this->session->userdata('customer_id');
$login_customer_name = $this->session->userdata('customer_name');
$current_url = current_url();
$social_media  = isset($company_info->social_media) && $company_info->social_media ? json_decode($company_info->social_media) : '';
?>
<!-- Cart Sidebar Start -->
<?php $this->view('frontend/cart_sidebar') ?>
<!-- Cart Sidear End -->
<!-- Aside (Mobile Navigation) -->
<aside class="main-aside">
  <a class="navbar-brand" href="<?php echo base_url() ?>"> <img src="<?php echo base_url() ?>images/<?php echo isset($getWhiteLabel->system_logo) && $getWhiteLabel->system_logo ? $getWhiteLabel->system_logo : ''; ?>" alt=""> </a>
  <div class="aside-scroll">
    <ul>
      <li class="menu-item">
        <a href="<?php echo base_url() ?>" class="<?= $current_url == base_url() ? 'active' : '' ?>"><?php echo lang('home'); ?></a>
      </li>
      <li class="menu-item">
        <a href="<?php echo base_url() . 'about-us'; ?>" class="<?= str_contains_custom($current_url, 'about-us') ? 'active' : '' ?>"><?php echo lang('about_us'); ?></a>
      </li>
      <li class="menu-item">
        <a href="<?php echo base_url() . 'online-order'; ?>" class="<?= str_contains_custom($current_url, 'online-order') ? 'active' : '' ?>"><?php echo lang('Order_Online'); ?></a>
      </li>
      <?php if($company_info->sos_enable_reservation=="Yes"):?>
        <li class="menu-item">
          <a href="<?php echo base_url() . 'reservation'; ?>" class="<?= str_contains_custom($current_url, 'reservation') ? 'active' : '' ?>"><?php echo lang('reservation'); ?></a>
        </li>
      <?php endif?>
      <li class="menu-item">
        <a href="<?php echo base_url() . 'contact-us'; ?>" class="<?= str_contains_custom($current_url, 'contact-us') ? 'active' : '' ?>"><?php echo lang('contact_us'); ?></a>
      </li>

    </ul>

  </div>

</aside>

<div class="aside-overlay aside-trigger"></div>

<!-- Header Start -->
<header class="main-header header-1 header-4 header-light header-absolute">

  <div class="container">
    <nav class="navbar">
      <div class="d-flex gap20px align-items-center">
        <div class="aside-toggler aside-trigger">
          <i class="fa fa-bars"></i>
        </div>
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo base_url() ?>"> <img src="<?php echo base_url() ?>images/<?php echo isset($getWhiteLabel->system_logo) && $getWhiteLabel->system_logo ? $getWhiteLabel->system_logo : ''; ?>" alt=""> </a>
      </div>
      <!-- Menu -->
      <ul class="navbar-nav">
        <li class="menu-item menu-item-has-children">
          <a href="<?php echo base_url() ?>" class="<?= $current_url == base_url() ? 'active' : '' ?>"><?php echo lang('home'); ?></a>
        </li>
        <li class="menu-item menu-item-has-children">
          <a href="<?php echo base_url() . 'about-us'; ?>" class="<?= str_contains_custom($current_url, 'about-us') ? 'active' : '' ?>"><?php echo lang('about_us'); ?></a>
        </li>
        <li class="menu-item menu-item-has-children">
          <a href="<?php echo base_url() . 'online-order'; ?>" class="<?= str_contains_custom($current_url, 'online-order')  || str_contains_custom($current_url, 'checkout') || str_contains_custom($current_url, 'food-details') ? 'active' : '' ?>"><?php echo lang('Order_Online'); ?></a>
        </li>
        <?php if($company_info->sos_enable_reservation=="Yes"):?>
          <li class="menu-item menu-item-has-children">
            <a href="<?php echo base_url() . 'reservation'; ?>" class="<?= str_contains_custom($current_url, 'reservation') ? 'active' : '' ?>"><?php echo lang('reservation'); ?></a>
          </li>
        <?php endif?>
        <li class="menu-item menu-item-has-children">
          <a href="<?php echo base_url() . 'contact-us'; ?>" class="<?= str_contains_custom($current_url, 'contact-us') ? 'active' : '' ?>"><?php echo lang('contact_us'); ?></a>
        </li>
      </ul>

      <div class="header-controls">
        <ul class="header-controls-inner">
          <li class="cart-dropdown-wrapper call_calculation cart-trigger">
            <span class="cart-item-count">0</span>
            <svg class="flaticon-shopping-bag" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_9_611)">
                <path d="M20.3987 8.06641H17.137L14.7932 4.94141C14.8844 4.79818 14.956 4.64518 15.0081 4.48242C15.0601 4.31966 15.0862 4.14714 15.0862 3.96484C15.0862 3.48307 14.9137 3.06966 14.5686 2.72461C14.2236 2.37956 13.8101 2.20703 13.3284 2.20703C12.8466 2.20703 12.4332 2.37956 12.0881 2.72461C11.7431 3.06966 11.5706 3.48307 11.5706 3.96484C11.5706 4.45964 11.7431 4.8763 12.0881 5.21484C12.4332 5.55339 12.8466 5.72266 13.3284 5.72266C13.4195 5.72266 13.5074 5.71615 13.592 5.70312C13.6767 5.6901 13.7646 5.67057 13.8557 5.64453L15.6721 8.06641H6.29712L8.11353 5.64453C8.20467 5.67057 8.29256 5.6901 8.3772 5.70312C8.46183 5.71615 8.54972 5.72266 8.64087 5.72266C9.12264 5.72266 9.53605 5.55339 9.8811 5.21484C10.2262 4.8763 10.3987 4.45964 10.3987 3.96484C10.3987 3.48307 10.2262 3.06966 9.8811 2.72461C9.53605 2.37956 9.12264 2.20703 8.64087 2.20703C8.1591 2.20703 7.74569 2.37956 7.40063 2.72461C7.05558 3.06966 6.88306 3.48307 6.88306 3.96484C6.88306 4.14714 6.9091 4.31966 6.96118 4.48242C7.01326 4.64518 7.08488 4.79818 7.17603 4.94141L4.83228 8.06641H1.57056C1.41431 8.06641 1.27759 8.125 1.1604 8.24219C1.04321 8.35938 0.984619 8.49609 0.984619 8.65234C0.984619 8.82161 1.04321 8.96159 1.1604 9.07227C1.27759 9.18294 1.41431 9.23828 1.57056 9.23828H2.33228L2.62524 10.4102H19.344L19.637 9.23828H20.3987C20.5549 9.23828 20.6917 9.18294 20.8088 9.07227C20.926 8.96159 20.9846 8.82161 20.9846 8.65234C20.9846 8.49609 20.926 8.35938 20.8088 8.24219C20.6917 8.125 20.5549 8.06641 20.3987 8.06641ZM12.7424 3.96484C12.7424 3.80859 12.801 3.67188 12.9182 3.55469C13.0354 3.4375 13.1721 3.37891 13.3284 3.37891C13.4846 3.37891 13.6213 3.4375 13.7385 3.55469C13.8557 3.67188 13.9143 3.80859 13.9143 3.96484C13.9143 4.13411 13.8557 4.27409 13.7385 4.38477C13.6213 4.49544 13.4846 4.55078 13.3284 4.55078C13.1721 4.55078 13.0354 4.49544 12.9182 4.38477C12.801 4.27409 12.7424 4.13411 12.7424 3.96484ZM8.64087 3.37891C8.79712 3.37891 8.93384 3.4375 9.05103 3.55469C9.16821 3.67188 9.22681 3.80859 9.22681 3.96484C9.22681 4.13411 9.16821 4.27409 9.05103 4.38477C8.93384 4.49544 8.79712 4.55078 8.64087 4.55078C8.48462 4.55078 8.3479 4.49544 8.23071 4.38477C8.11353 4.27409 8.05493 4.13411 8.05493 3.96484C8.05493 3.80859 8.11353 3.67188 8.23071 3.55469C8.3479 3.4375 8.48462 3.37891 8.64087 3.37891ZM4.34399 17.2852C4.43514 17.6758 4.64022 17.9948 4.95923 18.2422C5.27824 18.4896 5.63957 18.6133 6.04321 18.6133H15.926C16.3297 18.6133 16.691 18.4896 17.01 18.2422C17.329 17.9948 17.5341 17.6758 17.6252 17.2852L19.051 11.582H2.91821L4.34399 17.2852ZM13.9143 13.3398C13.9143 13.1836 13.9729 13.0469 14.0901 12.9297C14.2073 12.8125 14.344 12.7539 14.5002 12.7539C14.6565 12.7539 14.7932 12.8125 14.9104 12.9297C15.0276 13.0469 15.0862 13.1836 15.0862 13.3398V16.8555C15.0862 17.0247 15.0276 17.1647 14.9104 17.2754C14.7932 17.3861 14.6565 17.4414 14.5002 17.4414C14.344 17.4414 14.2073 17.3861 14.0901 17.2754C13.9729 17.1647 13.9143 17.0247 13.9143 16.8555V13.3398ZM10.3987 13.3398C10.3987 13.1836 10.4573 13.0469 10.5745 12.9297C10.6917 12.8125 10.8284 12.7539 10.9846 12.7539C11.1409 12.7539 11.2776 12.8125 11.3948 12.9297C11.512 13.0469 11.5706 13.1836 11.5706 13.3398V16.8555C11.5706 17.0247 11.512 17.1647 11.3948 17.2754C11.2776 17.3861 11.1409 17.4414 10.9846 17.4414C10.8284 17.4414 10.6917 17.3861 10.5745 17.2754C10.4573 17.1647 10.3987 17.0247 10.3987 16.8555V13.3398ZM6.88306 13.3398C6.88306 13.1836 6.94165 13.0469 7.05884 12.9297C7.17603 12.8125 7.31274 12.7539 7.46899 12.7539C7.62524 12.7539 7.76196 12.8125 7.87915 12.9297C7.99634 13.0469 8.05493 13.1836 8.05493 13.3398V16.8555C8.05493 17.0247 7.99634 17.1647 7.87915 17.2754C7.76196 17.3861 7.62524 17.4414 7.46899 17.4414C7.31274 17.4414 7.17603 17.3861 7.05884 17.2754C6.94165 17.1647 6.88306 17.0247 6.88306 16.8555V13.3398Z" fill="#212121" />
              </g>
              <defs>
                <clipPath id="clip0_9_611">
                  <rect width="20" height="20" fill="white" transform="matrix(1 0 0 -1 0.984619 20)" />
                </clipPath>
              </defs>
            </svg>
            <span><?= lang('Cart') ?></span>
          </li>
          <?php
          $language = $this->session->userdata('language');
          if (! $language) {
            $language = 'English';
          }
          ?>
          <li class="menu-item menu-item-has-children">
            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_9_603)">
                <path d="M6.18125 8.3925L5.6375 10H4.25L6.5775 3.75H8.1825L10.5 10H9.04125L8.4975 8.3925H6.18125ZM8.22375 7.4725L7.375 4.945H7.31375L6.465 7.4725H8.22375Z" fill="#212121" />
                <path d="M0.5 2.5C0.5 1.83696 0.763392 1.20107 1.23223 0.732233C1.70107 0.263392 2.33696 0 3 0L11.75 0C12.413 0 13.0489 0.263392 13.5178 0.732233C13.9866 1.20107 14.25 1.83696 14.25 2.5V6.25H18C18.663 6.25 19.2989 6.51339 19.7678 6.98223C20.2366 7.45107 20.5 8.08696 20.5 8.75V17.5C20.5 18.163 20.2366 18.7989 19.7678 19.2678C19.2989 19.7366 18.663 20 18 20H9.25C8.58696 20 7.95107 19.7366 7.48223 19.2678C7.01339 18.7989 6.75 18.163 6.75 17.5V13.75H3C2.33696 13.75 1.70107 13.4866 1.23223 13.0178C0.763392 12.5489 0.5 11.913 0.5 11.25V2.5ZM3 1.25C2.66848 1.25 2.35054 1.3817 2.11612 1.61612C1.8817 1.85054 1.75 2.16848 1.75 2.5V11.25C1.75 11.5815 1.8817 11.8995 2.11612 12.1339C2.35054 12.3683 2.66848 12.5 3 12.5H11.75C12.0815 12.5 12.3995 12.3683 12.6339 12.1339C12.8683 11.8995 13 11.5815 13 11.25V2.5C13 2.16848 12.8683 1.85054 12.6339 1.61612C12.3995 1.3817 12.0815 1.25 11.75 1.25H3ZM11.9225 13.7437C12.1633 14.1196 12.4258 14.4721 12.71 14.8012C11.775 15.52 10.6188 16.0525 9.25 16.4163C9.4725 16.6875 9.81375 17.21 9.94375 17.5C11.35 17.0513 12.5437 16.445 13.5512 15.6325C14.5225 16.4637 15.725 17.0887 17.2138 17.4725C17.38 17.155 17.7312 16.6313 18 16.36C16.5938 16.0438 15.4288 15.4925 14.475 14.755C15.3263 13.8212 16.0025 12.6912 16.5012 11.3087H18V10H14.25V11.3087H15.2063C14.8088 12.3637 14.2813 13.2413 13.6163 13.9713C13.4325 13.7757 13.2593 13.5704 13.0975 13.3563C12.7445 13.5818 12.3404 13.7151 11.9225 13.7437Z" fill="#212121" />
              </g>
              <defs>
                <clipPath id="clip0_9_603">
                  <rect width="20" height="20" fill="white" transform="translate(0.5)" />
                </clipPath>
              </defs>
            </svg>
            <span><?php echo ucfirstcustom($language) ?> <i class="fa fa-chevron-down"></i></span>
            <ul class="submenu">
              <?php
              $dir = glob("application/language/*", GLOB_ONLYDIR);
              foreach ($dir as $value):
                $separete = explode("language/", $value); ?>
                <li class="menu-item"> <a href="<?php echo base_url() ?>Authentication/setlanguage/<?php echo escape_output($separete[1]) ?>"><?php echo ucfirstcustom($separete[1]) ?></a> </li>
              <?php
              endforeach;
              ?>
            </ul>
          </li>
          <?php if (empty($login_customer)) { ?>
            <li class="menu-item menu-item-has-children">
              <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.21924 17.5C4.21924 17.5 2.96924 17.5 2.96924 16.25C2.96924 15 4.21924 11.25 10.4692 11.25C16.7192 11.25 17.9692 15 17.9692 16.25C17.9692 17.5 16.7192 17.5 16.7192 17.5H4.21924ZM10.4692 10C11.4638 10 12.4176 9.60491 13.1209 8.90165C13.8242 8.19839 14.2192 7.24456 14.2192 6.25C14.2192 5.25544 13.8242 4.30161 13.1209 3.59835C12.4176 2.89509 11.4638 2.5 10.4692 2.5C9.47468 2.5 8.52085 2.89509 7.81759 3.59835C7.11433 4.30161 6.71924 5.25544 6.71924 6.25C6.71924 7.24456 7.11433 8.19839 7.81759 8.90165C8.52085 9.60491 9.47468 10 10.4692 10Z" fill="#212121" />
              </svg>

              <span><?php echo lang('login'); ?></span>
              <ul class="submenu">
              <li class="menu-item"> <a href="<?php echo base_url() . 'register'; ?>"><?php echo lang('register_as_customer'); ?></a> </li>
                <li class="menu-item"> <a href="<?php echo base_url() . 'login'; ?>"><?php echo lang('login_as_customer'); ?></a> </li>
                <li class="menu-item"> <a href="<?php echo base_url() . 'authentication'; ?>"><?php echo lang('login_as_admin'); ?></a> </li>
              </ul>
            </li>
          <?php } else { ?>
            <li class="menu-item menu-item-has-children">
            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.21924 17.5C4.21924 17.5 2.96924 17.5 2.96924 16.25C2.96924 15 4.21924 11.25 10.4692 11.25C16.7192 11.25 17.9692 15 17.9692 16.25C17.9692 17.5 16.7192 17.5 16.7192 17.5H4.21924ZM10.4692 10C11.4638 10 12.4176 9.60491 13.1209 8.90165C13.8242 8.19839 14.2192 7.24456 14.2192 6.25C14.2192 5.25544 13.8242 4.30161 13.1209 3.59835C12.4176 2.89509 11.4638 2.5 10.4692 2.5C9.47468 2.5 8.52085 2.89509 7.81759 3.59835C7.11433 4.30161 6.71924 5.25544 6.71924 6.25C6.71924 7.24456 7.11433 8.19839 7.81759 8.90165C8.52085 9.60491 9.47468 10 10.4692 10Z" fill="#212121" />
              </svg>
              
              <a style="color:white; font-weight: 600;" href="#"><?php echo $login_customer_name; ?></a>
              <ul class="submenu">
                <li class="menu-item"> <a class="old_orders" href="<?php echo base_url(); ?>old-orders"><?php echo lang('old_orders'); ?></a> </li>
                <li class="menu-item"> <a href="<?php echo base_url(); ?>Frontend/logOut"><?php echo lang('logout'); ?></a> </li>
              </ul>
            </li>
          <?php } ?>
        </ul>
        <!-- Toggler -->        
      </div>
    </nav>
  </div>
</header>
<!-- Header End -->

<!-- Banner Start -->
<div class="banner banner-1 banner-4 light-banner">

  <div class="banner-item">
    <div class="banner-inner bg-cover bg-center dark-overlay dark-overlay-2" style="background-image: url('<?php echo base_url() ?>uploads/banner_section/<?php echo isset($banner_section->main_banner) && $banner_section->main_banner ? $banner_section->main_banner : '' ?>')">
      <div class="container">
        <div class="d-flex flex-column gap40px">
          <div class="d-flex flex-column gap20px">
            <h1 class="title"><?php echo isset($banner_section->main_header) && $banner_section->main_header ? $banner_section->main_header : '' ?></h1>
            <p class="subtitle">
              <?php echo isset($banner_section->short_des) && $banner_section->short_des ? $banner_section->short_des : '' ?>
            </p>
          </div>
          <a href="<?php echo base_url() . 'online-order'; ?>" class="btn-custom primary"><?php echo lang('explore_our_menu'); ?> <i class="fa fa-caret-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Banner End -->
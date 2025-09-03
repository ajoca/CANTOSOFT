<?php
    $company_info  = getMainCompany();
    $categories    = getFoodMenuCategory();
    $modifiers        = getModifierListByFoodMenuId($food_details->id);
    $common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page ? json_decode($company_info->common_menu_page) : '';
    
    $food_menus       = getFoodMenuForMenuPage();
    $only_modifiers   = getModifiersForMenuPage();
    $online_selected_outlet = $this->session->userdata('online_selected_outlet');
    $outlet_details = getOutletById($online_selected_outlet);

    $large_imgs = isset($outlet_details->large_imgs)?(Array)json_decode($outlet_details->large_imgs):'';
    $img  = '';
    $str = "large_".$food_details->id;
    if(isset($large_imgs[$str]) && $large_imgs[$str]){
      $img = base_url()."uploads/website/".$large_imgs[$str];
    }else{
      $img = base_url()."assets/media/no_image.png";
    }

    $i                 = 0;
    $menu_to_show      = "";
    $javascript_obects = "";

    if (isset($food_menus) && $food_menus):
        foreach ($food_menus as $single_menus) {
            $sale_price  = $single_menus->sale_price;
            $total_menus = count($food_menus);
            if ($total_menus == $i) {
                $javascript_obects .= "{item_id:'" . $single_menus->id . "',parent_id:'" . $single_menus->parent_id . "',product_type:'" . $single_menus->product_type . "',item_name:'" . getPlanText($single_menus->name) . "',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',price:'" . getAmtP($sale_price) . "',tax_information:'" . $single_menus->tax_information . "',vat_percentage:'0'}";
            } else {
                $javascript_obects .= "{item_id:'" . $single_menus->id . "',parent_id:'" . $single_menus->parent_id . "',product_type:'" . $single_menus->product_type . "',item_name:'" . getPlanText($single_menus->name) . "',alternative_name:'" . getPlanText($single_menus->alternative_name) . "',price:'" . getAmtP($sale_price) . "',tax_information:'" . $single_menus->tax_information . "',vat_percentage:'0'},";
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
<input type="hidden" id="item_add_success" value="<?php echo lang('item_add_success') ?>">
<input type="hidden" id="tax_type" value="<?php echo $company_info->tax_type ?>">
<div class="section product-single">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <!-- Main Thumb -->
        <div class="product-thumb">
          <img src="<?php echo $img; ?>" alt="<?php echo isset($food_details->name) && $food_details->name ? $food_details->description : ''; ?>">
        </div>
        <!-- /Main Thumb -->
      </div>
      <div class="col-md-7">
        <div class="product-content">

          <!-- Product Title -->
          <h2 class="title"><?php echo isset($food_details->name) && $food_details->name ? $food_details->name : ''; ?></h2>
          <!-- /Product Title -->


          <!-- Product Short Description -->
          <p class="product_description"><?php echo isset($food_details->description) && $food_details->description ? $food_details->description : ''; ?></p>
          <!-- /Product Short Description -->

          <!-- Price -->
          <div class="price-wrapper">
            <p class="product-price" data-price="<?php echo isset($food_details->sale_price) && $food_details->sale_price ? ($food_details->sale_price) : 0; ?>" data-food_menu_id="<?php echo escape_output($food_details->id)?>" id="details_item_price"><?php echo isset($food_details->sale_price) && $food_details->sale_price ? getAmtCustom($food_details->sale_price) : ''; ?></p>
          </div>
          <!-- /Price -->

          <!-- Variations -->
          <div class="customize-variations">
            <div class="row">
              <!-- Variation Start -->
              <div class="col-lg-6 col-12">
              <?php if ($modifiers) {?>
                <div class="customize-variation-wrapper">
                  <i class="flaticon-pizza-and-cutted-slice"></i>
                  <h5><?php echo lang('modifier'); ?></h5>
                  <?php
                          foreach ($modifiers as $modifier) {
                          ?>
                      <div class="customize-variation-item" data-id="<?php echo $modifier->modifier_id; ?>" data-name="<?php echo $modifier->modifier_name; ?>" data-price="<?php echo $modifier->modifier_price; ?>">
                        <div class="custom-control custom-checkbox">
                        <?php  if($company_info->sos_enable_online_order=="Yes"):?>
                          <input type="checkbox" class="custom-control-input modifier_checkbox" id="addChicken<?php echo $modifier->modifier_id ?>">
                          <?php endif?>
                          <label class="custom-control-label" for="addChicken<?php echo $modifier->modifier_id ?>"><?php echo $modifier->modifier_name; ?></label>
                        </div>
                        <span><?php echo getAmtCustom($modifier->modifier_price); ?></span>
                      </div>
                  <?php
                      }
                ?>
                </div>
              <?php }?>
              </div>

              <!-- Variation End -->
            </div>
          </div>
          <!-- /Variations -->

          <!-- Add To Cart Form -->
          <form class="atc-form" method="post">
            <?php  if($company_info->sos_enable_online_order=="Yes"):?>
            <div class="form-group mb-3">
              <label for="special_instructions"><?php echo lang('special_instructions'); ?></label>
              <textarea class="form-control" id="special_instructions" name="special_instructions" placeholder="<?php echo lang('type_your_note'); ?>"></textarea>
            </div>
            <div class="d-flex gap20px align-items-end">
              <div class="form-group mb-3">
                <label><?php echo lang('quantity'); ?></label>
                <div class="qty">
                  <span class="call_qty qty-subtract"><i class="fas fa-minus"></i></span>
                  <input type="text" name="qty" value="1" id="item_details_qty" class="item_details_qty_<?php echo $food_details->id ?>" data-item-details-qty="<?php echo $food_details->id ?>">
                  <span class="call_qty qty-add"><i class="fas fa-plus"></i></span>
                </div>
              </div>
            </div>
             

            <div class="d-flex gap20px align-items-end">
              <div class="form-group">
                <label><?php echo lang('total_cart_amount'); ?></label>
                <div class="qty text-center-total-amount">
                  <b class="show_total_amount"><?php echo escape_output(getAmtCustom(0))?></b>
                </div>
              </div>
              
                <button type="button" name="button" class="btn-custom primary single_order" data_single_order_id="<?php echo $food_details->id ?>"><?php echo lang('add_to_cart'); ?> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19.4141 8.06641H16.1523L13.8086 4.94141C13.8997 4.79818 13.9714 4.64518 14.0234 4.48242C14.0755 4.31966 14.1016 4.14714 14.1016 3.96484C14.1016 3.48307 13.929 3.06966 13.584 2.72461C13.2389 2.37956 12.8255 2.20703 12.3438 2.20703C11.862 2.20703 11.4486 2.37956 11.1035 2.72461C10.7585 3.06966 10.5859 3.48307 10.5859 3.96484C10.5859 4.45964 10.7585 4.8763 11.1035 5.21484C11.4486 5.55339 11.862 5.72266 12.3438 5.72266C12.4349 5.72266 12.5228 5.71615 12.6074 5.70312C12.6921 5.6901 12.7799 5.67057 12.8711 5.64453L14.6875 8.06641H5.3125L7.12891 5.64453C7.22005 5.67057 7.30794 5.6901 7.39258 5.70312C7.47721 5.71615 7.5651 5.72266 7.65625 5.72266C8.13802 5.72266 8.55143 5.55339 8.89648 5.21484C9.24154 4.8763 9.41406 4.45964 9.41406 3.96484C9.41406 3.48307 9.24154 3.06966 8.89648 2.72461C8.55143 2.37956 8.13802 2.20703 7.65625 2.20703C7.17448 2.20703 6.76107 2.37956 6.41602 2.72461C6.07096 3.06966 5.89844 3.48307 5.89844 3.96484C5.89844 4.14714 5.92448 4.31966 5.97656 4.48242C6.02865 4.64518 6.10026 4.79818 6.19141 4.94141L3.84766 8.06641H0.585938C0.429688 8.06641 0.292969 8.125 0.175781 8.24219C0.0585938 8.35938 0 8.49609 0 8.65234C0 8.82161 0.0585938 8.96159 0.175781 9.07227C0.292969 9.18294 0.429688 9.23828 0.585938 9.23828H1.34766L1.64062 10.4102H18.3594L18.6523 9.23828H19.4141C19.5703 9.23828 19.707 9.18294 19.8242 9.07227C19.9414 8.96159 20 8.82161 20 8.65234C20 8.49609 19.9414 8.35938 19.8242 8.24219C19.707 8.125 19.5703 8.06641 19.4141 8.06641ZM11.7578 3.96484C11.7578 3.80859 11.8164 3.67188 11.9336 3.55469C12.0508 3.4375 12.1875 3.37891 12.3438 3.37891C12.5 3.37891 12.6367 3.4375 12.7539 3.55469C12.8711 3.67188 12.9297 3.80859 12.9297 3.96484C12.9297 4.13411 12.8711 4.27409 12.7539 4.38477C12.6367 4.49544 12.5 4.55078 12.3438 4.55078C12.1875 4.55078 12.0508 4.49544 11.9336 4.38477C11.8164 4.27409 11.7578 4.13411 11.7578 3.96484ZM7.65625 3.37891C7.8125 3.37891 7.94922 3.4375 8.06641 3.55469C8.18359 3.67188 8.24219 3.80859 8.24219 3.96484C8.24219 4.13411 8.18359 4.27409 8.06641 4.38477C7.94922 4.49544 7.8125 4.55078 7.65625 4.55078C7.5 4.55078 7.36328 4.49544 7.24609 4.38477C7.12891 4.27409 7.07031 4.13411 7.07031 3.96484C7.07031 3.80859 7.12891 3.67188 7.24609 3.55469C7.36328 3.4375 7.5 3.37891 7.65625 3.37891ZM3.35938 17.2852C3.45052 17.6758 3.6556 17.9948 3.97461 18.2422C4.29362 18.4896 4.65495 18.6133 5.05859 18.6133H14.9414C15.3451 18.6133 15.7064 18.4896 16.0254 18.2422C16.3444 17.9948 16.5495 17.6758 16.6406 17.2852L18.0664 11.582H1.93359L3.35938 17.2852ZM12.9297 13.3398C12.9297 13.1836 12.9883 13.0469 13.1055 12.9297C13.2227 12.8125 13.3594 12.7539 13.5156 12.7539C13.6719 12.7539 13.8086 12.8125 13.9258 12.9297C14.043 13.0469 14.1016 13.1836 14.1016 13.3398V16.8555C14.1016 17.0247 14.043 17.1647 13.9258 17.2754C13.8086 17.3861 13.6719 17.4414 13.5156 17.4414C13.3594 17.4414 13.2227 17.3861 13.1055 17.2754C12.9883 17.1647 12.9297 17.0247 12.9297 16.8555V13.3398ZM9.41406 13.3398C9.41406 13.1836 9.47266 13.0469 9.58984 12.9297C9.70703 12.8125 9.84375 12.7539 10 12.7539C10.1562 12.7539 10.293 12.8125 10.4102 12.9297C10.5273 13.0469 10.5859 13.1836 10.5859 13.3398V16.8555C10.5859 17.0247 10.5273 17.1647 10.4102 17.2754C10.293 17.3861 10.1562 17.4414 10 17.4414C9.84375 17.4414 9.70703 17.3861 9.58984 17.2754C9.47266 17.1647 9.41406 17.0247 9.41406 16.8555V13.3398ZM5.89844 13.3398C5.89844 13.1836 5.95703 13.0469 6.07422 12.9297C6.19141 12.8125 6.32812 12.7539 6.48438 12.7539C6.64062 12.7539 6.77734 12.8125 6.89453 12.9297C7.01172 13.0469 7.07031 13.1836 7.07031 13.3398V16.8555C7.07031 17.0247 7.01172 17.1647 6.89453 17.2754C6.77734 17.3861 6.64062 17.4414 6.48438 17.4414C6.32812 17.4414 6.19141 17.3861 6.07422 17.2754C5.95703 17.1647 5.89844 17.0247 5.89844 16.8555V13.3398Z" fill="white" />
                </svg>
               </button>
              
               <a href="<?php echo base_url(); ?>checkout" class="button_show_cl btn-custom primary go_to_checkout"><?php echo lang('checkout'); ?> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19.4141 8.06641H16.1523L13.8086 4.94141C13.8997 4.79818 13.9714 4.64518 14.0234 4.48242C14.0755 4.31966 14.1016 4.14714 14.1016 3.96484C14.1016 3.48307 13.929 3.06966 13.584 2.72461C13.2389 2.37956 12.8255 2.20703 12.3438 2.20703C11.862 2.20703 11.4486 2.37956 11.1035 2.72461C10.7585 3.06966 10.5859 3.48307 10.5859 3.96484C10.5859 4.45964 10.7585 4.8763 11.1035 5.21484C11.4486 5.55339 11.862 5.72266 12.3438 5.72266C12.4349 5.72266 12.5228 5.71615 12.6074 5.70312C12.6921 5.6901 12.7799 5.67057 12.8711 5.64453L14.6875 8.06641H5.3125L7.12891 5.64453C7.22005 5.67057 7.30794 5.6901 7.39258 5.70312C7.47721 5.71615 7.5651 5.72266 7.65625 5.72266C8.13802 5.72266 8.55143 5.55339 8.89648 5.21484C9.24154 4.8763 9.41406 4.45964 9.41406 3.96484C9.41406 3.48307 9.24154 3.06966 8.89648 2.72461C8.55143 2.37956 8.13802 2.20703 7.65625 2.20703C7.17448 2.20703 6.76107 2.37956 6.41602 2.72461C6.07096 3.06966 5.89844 3.48307 5.89844 3.96484C5.89844 4.14714 5.92448 4.31966 5.97656 4.48242C6.02865 4.64518 6.10026 4.79818 6.19141 4.94141L3.84766 8.06641H0.585938C0.429688 8.06641 0.292969 8.125 0.175781 8.24219C0.0585938 8.35938 0 8.49609 0 8.65234C0 8.82161 0.0585938 8.96159 0.175781 9.07227C0.292969 9.18294 0.429688 9.23828 0.585938 9.23828H1.34766L1.64062 10.4102H18.3594L18.6523 9.23828H19.4141C19.5703 9.23828 19.707 9.18294 19.8242 9.07227C19.9414 8.96159 20 8.82161 20 8.65234C20 8.49609 19.9414 8.35938 19.8242 8.24219C19.707 8.125 19.5703 8.06641 19.4141 8.06641ZM11.7578 3.96484C11.7578 3.80859 11.8164 3.67188 11.9336 3.55469C12.0508 3.4375 12.1875 3.37891 12.3438 3.37891C12.5 3.37891 12.6367 3.4375 12.7539 3.55469C12.8711 3.67188 12.9297 3.80859 12.9297 3.96484C12.9297 4.13411 12.8711 4.27409 12.7539 4.38477C12.6367 4.49544 12.5 4.55078 12.3438 4.55078C12.1875 4.55078 12.0508 4.49544 11.9336 4.38477C11.8164 4.27409 11.7578 4.13411 11.7578 3.96484ZM7.65625 3.37891C7.8125 3.37891 7.94922 3.4375 8.06641 3.55469C8.18359 3.67188 8.24219 3.80859 8.24219 3.96484C8.24219 4.13411 8.18359 4.27409 8.06641 4.38477C7.94922 4.49544 7.8125 4.55078 7.65625 4.55078C7.5 4.55078 7.36328 4.49544 7.24609 4.38477C7.12891 4.27409 7.07031 4.13411 7.07031 3.96484C7.07031 3.80859 7.12891 3.67188 7.24609 3.55469C7.36328 3.4375 7.5 3.37891 7.65625 3.37891ZM3.35938 17.2852C3.45052 17.6758 3.6556 17.9948 3.97461 18.2422C4.29362 18.4896 4.65495 18.6133 5.05859 18.6133H14.9414C15.3451 18.6133 15.7064 18.4896 16.0254 18.2422C16.3444 17.9948 16.5495 17.6758 16.6406 17.2852L18.0664 11.582H1.93359L3.35938 17.2852ZM12.9297 13.3398C12.9297 13.1836 12.9883 13.0469 13.1055 12.9297C13.2227 12.8125 13.3594 12.7539 13.5156 12.7539C13.6719 12.7539 13.8086 12.8125 13.9258 12.9297C14.043 13.0469 14.1016 13.1836 14.1016 13.3398V16.8555C14.1016 17.0247 14.043 17.1647 13.9258 17.2754C13.8086 17.3861 13.6719 17.4414 13.5156 17.4414C13.3594 17.4414 13.2227 17.3861 13.1055 17.2754C12.9883 17.1647 12.9297 17.0247 12.9297 16.8555V13.3398ZM9.41406 13.3398C9.41406 13.1836 9.47266 13.0469 9.58984 12.9297C9.70703 12.8125 9.84375 12.7539 10 12.7539C10.1562 12.7539 10.293 12.8125 10.4102 12.9297C10.5273 13.0469 10.5859 13.1836 10.5859 13.3398V16.8555C10.5859 17.0247 10.5273 17.1647 10.4102 17.2754C10.293 17.3861 10.1562 17.4414 10 17.4414C9.84375 17.4414 9.70703 17.3861 9.58984 17.2754C9.47266 17.1647 9.41406 17.0247 9.41406 16.8555V13.3398ZM5.89844 13.3398C5.89844 13.1836 5.95703 13.0469 6.07422 12.9297C6.19141 12.8125 6.32812 12.7539 6.48438 12.7539C6.64062 12.7539 6.77734 12.8125 6.89453 12.9297C7.01172 13.0469 7.07031 13.1836 7.07031 13.3398V16.8555C7.07031 17.0247 7.01172 17.1647 6.89453 17.2754C6.77734 17.3861 6.64062 17.4414 6.48438 17.4414C6.32812 17.4414 6.19141 17.3861 6.07422 17.2754C5.95703 17.1647 5.89844 17.0247 5.89844 16.8555V13.3398Z" fill="white" />
                </svg></a>

                <a href="<?php echo base_url(); ?>online-order" class="button_show_cl btn-custom primary go_to_checkout"><?php echo lang('continue_ordering'); ?> <svg width="20" height="20"  xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 48 48" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m32.8 6.5 7.4 7.4H15.7C7.3 13.8.5 20.6.5 29s6.8 15.2 15.2 15.2h9.4v-3.9h-9.4c-6.2.1-11.3-5-11.3-11.3s5.1-11.4 11.4-11.4h24.4L32.8 25l2.7 2.7 12-12-12-12z"  opacity="1" fill="white" class=""></path></g></svg></a>
            </div>
<?php endif?>
            
          </form>
          <!-- /Add To Cart Form -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Related Start -->
<div class="section section-padding related-products pt-0">
  <div class="container">
    <h3><?php echo lang('Youmightalsolike'); ?></h3>
    <div class="row menu-v2">
      <!-- Product Start -->
      <?php if ($food_by_cat) {
   
              foreach ($food_by_cat as $food_menu) {
                $thumb_imgs = isset($outlet_details->thumb_imgs)?(Array)json_decode($outlet_details->thumb_imgs):'';
                if($food_details->id!=$food_menu->id):

                  $img  = '';
                  $str = "thumb_".$food_menu->id;
                  if(isset($thumb_imgs[$str]) && $thumb_imgs[$str]){
                    $img = base_url()."uploads/website/".$thumb_imgs[$str];
                  }else{
                    $img = base_url()."assets/media/no_image.png";
                  }

              ?>
          <div class="col-lg-4 col-xl-3 mb-3 col-md-6">
            <div class="product">
              <a class="product-thumb" href="<?php echo base_url() . 'food-details/'; ?><?php echo d($food_menu->id,1) ?>/<?php echo d($food_menu->category_id,1) ?>"> <img src="<?php echo $img; ?>" alt="<?php echo isset($food_menu->name) && $food_menu->name ? $food_menu->name : ''; ?>" /> </a>
              <div class="product-body">
                <div class="product-desc">
                  <div class="rating-wrap">
                    <div class="rating">
                    <div class="full-stars-example-two">
                        <?php $rating = getRating($food_menu->id); ?>
                        <div class="rating" id="rating-sing-<?php echo $food_menu->id; ?>">
                          <?php for ($i = 5; $i >= 1; $i--) {?>
                            <span class="rating-sing-<?php echo $food_menu->id; ?>" data-rating="<?php echo $i; ?>">
                              <i class="<?php echo($rating >= $i) ? 'fas' : 'far'; ?> fa-star"></i>
                            </span>
                          <?php }?>
                        </div>
                      </div>
                    </div>
                    <span class="rating-num">(<?php echo $rating; ?>)</span>
                  </div>
                  <h4><a href="<?php echo base_url() . 'food-details/'; ?><?php echo d($food_menu->id,1) ?>/<?php echo d($food_menu->category_id,1) ?>"><?php echo isset($food_menu->name) && $food_menu->name ? $food_menu->name : ''; ?></a> </h4>

                  <p class="product-price">
                    <?php echo isset($food_menu->sale_price) && $food_menu->sale_price ? getAmtCustom($food_menu->sale_price) : ''; ?>
                  </p>

                </div>
                <?php  if($company_info->sos_enable_online_order=="Yes"):?>
                <div class="product-controls">
                  <a href="<?php echo base_url() . 'food-details/'; ?><?php echo d($food_menu->id,1) ?>/<?php echo d($food_menu->category_id,1) ?>" class="order-item">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M19.4141 8.06641H16.1523L13.8086 4.94141C13.8997 4.79818 13.9714 4.64518 14.0234 4.48242C14.0755 4.31966 14.1016 4.14714 14.1016 3.96484C14.1016 3.48307 13.929 3.06966 13.584 2.72461C13.2389 2.37956 12.8255 2.20703 12.3438 2.20703C11.862 2.20703 11.4486 2.37956 11.1035 2.72461C10.7585 3.06966 10.5859 3.48307 10.5859 3.96484C10.5859 4.45964 10.7585 4.8763 11.1035 5.21484C11.4486 5.55339 11.862 5.72266 12.3438 5.72266C12.4349 5.72266 12.5228 5.71615 12.6074 5.70312C12.6921 5.6901 12.7799 5.67057 12.8711 5.64453L14.6875 8.06641H5.3125L7.12891 5.64453C7.22005 5.67057 7.30794 5.6901 7.39258 5.70312C7.47721 5.71615 7.5651 5.72266 7.65625 5.72266C8.13802 5.72266 8.55143 5.55339 8.89648 5.21484C9.24154 4.8763 9.41406 4.45964 9.41406 3.96484C9.41406 3.48307 9.24154 3.06966 8.89648 2.72461C8.55143 2.37956 8.13802 2.20703 7.65625 2.20703C7.17448 2.20703 6.76107 2.37956 6.41602 2.72461C6.07096 3.06966 5.89844 3.48307 5.89844 3.96484C5.89844 4.14714 5.92448 4.31966 5.97656 4.48242C6.02865 4.64518 6.10026 4.79818 6.19141 4.94141L3.84766 8.06641H0.585938C0.429688 8.06641 0.292969 8.125 0.175781 8.24219C0.0585938 8.35938 0 8.49609 0 8.65234C0 8.82161 0.0585938 8.96159 0.175781 9.07227C0.292969 9.18294 0.429688 9.23828 0.585938 9.23828H1.34766L1.64062 10.4102H18.3594L18.6523 9.23828H19.4141C19.5703 9.23828 19.707 9.18294 19.8242 9.07227C19.9414 8.96159 20 8.82161 20 8.65234C20 8.49609 19.9414 8.35938 19.8242 8.24219C19.707 8.125 19.5703 8.06641 19.4141 8.06641ZM11.7578 3.96484C11.7578 3.80859 11.8164 3.67188 11.9336 3.55469C12.0508 3.4375 12.1875 3.37891 12.3438 3.37891C12.5 3.37891 12.6367 3.4375 12.7539 3.55469C12.8711 3.67188 12.9297 3.80859 12.9297 3.96484C12.9297 4.13411 12.8711 4.27409 12.7539 4.38477C12.6367 4.49544 12.5 4.55078 12.3438 4.55078C12.1875 4.55078 12.0508 4.49544 11.9336 4.38477C11.8164 4.27409 11.7578 4.13411 11.7578 3.96484ZM7.65625 3.37891C7.8125 3.37891 7.94922 3.4375 8.06641 3.55469C8.18359 3.67188 8.24219 3.80859 8.24219 3.96484C8.24219 4.13411 8.18359 4.27409 8.06641 4.38477C7.94922 4.49544 7.8125 4.55078 7.65625 4.55078C7.5 4.55078 7.36328 4.49544 7.24609 4.38477C7.12891 4.27409 7.07031 4.13411 7.07031 3.96484C7.07031 3.80859 7.12891 3.67188 7.24609 3.55469C7.36328 3.4375 7.5 3.37891 7.65625 3.37891ZM3.35938 17.2852C3.45052 17.6758 3.6556 17.9948 3.97461 18.2422C4.29362 18.4896 4.65495 18.6133 5.05859 18.6133H14.9414C15.3451 18.6133 15.7064 18.4896 16.0254 18.2422C16.3444 17.9948 16.5495 17.6758 16.6406 17.2852L18.0664 11.582H1.93359L3.35938 17.2852ZM12.9297 13.3398C12.9297 13.1836 12.9883 13.0469 13.1055 12.9297C13.2227 12.8125 13.3594 12.7539 13.5156 12.7539C13.6719 12.7539 13.8086 12.8125 13.9258 12.9297C14.043 13.0469 14.1016 13.1836 14.1016 13.3398V16.8555C14.1016 17.0247 14.043 17.1647 13.9258 17.2754C13.8086 17.3861 13.6719 17.4414 13.5156 17.4414C13.3594 17.4414 13.2227 17.3861 13.1055 17.2754C12.9883 17.1647 12.9297 17.0247 12.9297 16.8555V13.3398ZM9.41406 13.3398C9.41406 13.1836 9.47266 13.0469 9.58984 12.9297C9.70703 12.8125 9.84375 12.7539 10 12.7539C10.1562 12.7539 10.293 12.8125 10.4102 12.9297C10.5273 13.0469 10.5859 13.1836 10.5859 13.3398V16.8555C10.5859 17.0247 10.5273 17.1647 10.4102 17.2754C10.293 17.3861 10.1562 17.4414 10 17.4414C9.84375 17.4414 9.70703 17.3861 9.58984 17.2754C9.47266 17.1647 9.41406 17.0247 9.41406 16.8555V13.3398ZM5.89844 13.3398C5.89844 13.1836 5.95703 13.0469 6.07422 12.9297C6.19141 12.8125 6.32812 12.7539 6.48438 12.7539C6.64062 12.7539 6.77734 12.8125 6.89453 12.9297C7.01172 13.0469 7.07031 13.1836 7.07031 13.3398V16.8555C7.07031 17.0247 7.01172 17.1647 6.89453 17.2754C6.77734 17.3861 6.64062 17.4414 6.48438 17.4414C6.32812 17.4414 6.19141 17.3861 6.07422 17.2754C5.95703 17.1647 5.89844 17.0247 5.89844 16.8555V13.3398Z" fill="black" />
                    </svg>
                  </a>
                </div>
                <?php endif?>
              </div>
            </div>
          </div>
      <?php
      endif;
          }
      }?>
      <!-- Product End -->
    </div>
  </div>
</div>
<!-- Related End -->
<script>
  /*This variable could not be escaped because this is building object*/
  window.items = [<?php echo($javascript_obects); ?>];
  /*This variable could not be escaped because this is building object*/
  window.only_modifiers = [<?php echo($javascript_obects_only_modifier); ?>];
</script>
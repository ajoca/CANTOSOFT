<div class="cart-sidebar-wrapper">
  <aside class="cart-sidebar">
    <div class="cart-sidebar-header">
      <h3><?php echo lang('Cart'); ?><span class="cart-item-total"></span></h3>
      <div class="close-btn cart-trigger close-dark">
        <small><?php echo lang('close'); ?></small>
        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip0_37_468)">
            <path d="M7 13.625C5.37555 13.625 3.81763 12.9797 2.66897 11.831C1.52031 10.6824 0.875 9.12445 0.875 7.5C0.875 5.87555 1.52031 4.31763 2.66897 3.16897C3.81763 2.02031 5.37555 1.375 7 1.375C8.62445 1.375 10.1824 2.02031 11.331 3.16897C12.4797 4.31763 13.125 5.87555 13.125 7.5C13.125 9.12445 12.4797 10.6824 11.331 11.831C10.1824 12.9797 8.62445 13.625 7 13.625ZM7 14.5C8.85652 14.5 10.637 13.7625 11.9497 12.4497C13.2625 11.137 14 9.35652 14 7.5C14 5.64348 13.2625 3.86301 11.9497 2.55025C10.637 1.2375 8.85652 0.5 7 0.5C5.14348 0.5 3.36301 1.2375 2.05025 2.55025C0.737498 3.86301 0 5.64348 0 7.5C0 9.35652 0.737498 11.137 2.05025 12.4497C3.36301 13.7625 5.14348 14.5 7 14.5Z" fill="#212121" />
            <path d="M4.0653 4.56525C4.10594 4.52451 4.15422 4.49219 4.20737 4.47013C4.26052 4.44807 4.3175 4.43672 4.37505 4.43672C4.4326 4.43672 4.48958 4.44807 4.54273 4.47013C4.59588 4.49219 4.64416 4.52451 4.6848 4.56525L7.00005 6.88138L9.3153 4.56525C9.35598 4.52458 9.40427 4.49231 9.45741 4.4703C9.51056 4.44828 9.56752 4.43695 9.62505 4.43695C9.68258 4.43695 9.73954 4.44828 9.79269 4.4703C9.84583 4.49231 9.89412 4.52458 9.9348 4.56525C9.97548 4.60593 10.0077 4.65422 10.0298 4.70737C10.0518 4.76052 10.0631 4.81748 10.0631 4.875C10.0631 4.93253 10.0518 4.98949 10.0298 5.04264C10.0077 5.09579 9.97548 5.14408 9.9348 5.18475L7.61867 7.5L9.9348 9.81525C9.97548 9.85593 10.0077 9.90422 10.0298 9.95737C10.0518 10.0105 10.0631 10.0675 10.0631 10.125C10.0631 10.1825 10.0518 10.2395 10.0298 10.2926C10.0077 10.3458 9.97548 10.3941 9.9348 10.4348C9.89412 10.4754 9.84583 10.5077 9.79269 10.5297C9.73954 10.5517 9.68258 10.5631 9.62505 10.5631C9.56752 10.5631 9.51056 10.5517 9.45741 10.5297C9.40427 10.5077 9.35598 10.4754 9.3153 10.4348L7.00005 8.11863L4.6848 10.4348C4.64412 10.4754 4.59583 10.5077 4.54269 10.5297C4.48954 10.5517 4.43258 10.5631 4.37505 10.5631C4.31752 10.5631 4.26056 10.5517 4.20741 10.5297C4.15427 10.5077 4.10598 10.4754 4.0653 10.4348C4.02462 10.3941 3.99236 10.3458 3.97034 10.2926C3.94833 10.2395 3.937 10.1825 3.937 10.125C3.937 10.0675 3.94833 10.0105 3.97034 9.95737C3.99236 9.90422 4.02462 9.85593 4.0653 9.81525L6.38142 7.5L4.0653 5.18475C4.02456 5.14411 3.99223 5.09584 3.97018 5.04268C3.94812 4.98953 3.93677 4.93255 3.93677 4.875C3.93677 4.81746 3.94812 4.76048 3.97018 4.70732C3.99223 4.65417 4.02456 4.60589 4.0653 4.56525Z" fill="#212121" />
          </g>
          <defs>
            <clipPath id="clip0_37_468">
              <rect width="14" height="14" fill="white" transform="translate(0 0.5)" />
            </clipPath>
          </defs>
        </svg>
      </div>
    </div>
    <div class="cart-sidebar-body">
      <div class="img1">
        <img src="<?php echo base_url(); ?>assets/media/frontend/h3.png" alt="">
      </div>
      <div class="img2">
        <img src="<?php echo base_url(); ?>assets/media/frontend/h4.png" alt="">
      </div>
      <div class="cart-sidebar-scroll" id="order_html_render">
      </div>
      <div class="d-flex flex-column gap15px total_section_cart">
        <div class="order_summary d-flex flex-column gap25px">
          <h4 class="mb-0"><?php echo lang('order_summary'); ?></h4>
          <div class="order_summary_inner gap16px">
            <div class="d-flex justify-content-between">
              <p><?php echo lang('subtotal'); ?>:</p>
              <p class="cart-subtotal"><?php echo escape_output(getAmtCustom(0))?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p><?php echo lang('tax'); ?>:</p>
              <p class="cart-tax"><?php echo escape_output(getAmtCustom(0))?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p><?php echo lang('delivery_fee'); ?>:</p>
              <p class="cart-delivery-fee" id="side_cart_delivery_charge"><?php echo escape_output(getAmtCustom(0))?></p>
            </div>
          </div>
          <div class="total">
            <div class="d-flex justify-content-between">
              <p><?php echo lang('total'); ?>:</p>
              <p class="cart-total checkout_grand_total"><?php echo escape_output(getAmtCustom(0))?></p>
            </div>
          </div>
        </div>
        <a href="<?php echo base_url(); ?>checkout" class="btn-custom primary checkout_btn"><?php echo lang('checkout'); ?></a>
      </div>
    </div>
  </aside>
  <div class="cart-sidebar-overlay cart-trigger">
  </div>
</div>
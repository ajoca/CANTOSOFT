(function ($) {
  "use strict";
  toastr.options = {
    positionClass:'toast-bottom-right'
};
  let base_url = $("#base_url").val();
  let not_data_in_cart = $("#not_data_in_cart").val();
  let precision = $("#precision").val();
  let warning = $("#alert_txt").val();
  let ok = $("#ok_text").val();
  let cart_need_clean = $("#cart_need_clean").val();
  let order_copied = $("#order_copied").val();
  let currency = $("#currency").val();
  let website_theme_color = $("#website_theme_color").val();
  let already_added_to_the_cart = $("#already_added_to_the_cart").val();
  let item_add_success = $("#item_add_success").val();
  let ir_precision = 2;

  $(document).on("click", ".single_order", function (e) {
    e.preventDefault();
    let food_menu_id = $(this).attr("data_single_order_id");
    let exist_check_food_menu_id;
    let exist_check = "No";
    $(".sidebar-cart-card").each(function () {
      exist_check_food_menu_id = $(this).attr("data-order-cart-id");
      if (exist_check_food_menu_id == food_menu_id) {
        exist_check = "Yes";
        toastr['error'](already_added_to_the_cart, '');
      }
    });
    
    $(".single_order").hide();
    $(".button_show_cl").show();
    if(exist_check=="No"){
      toastr['success'](item_add_success, '');
    }
    singleItemOrder(food_menu_id, exist_check);
  });

  function checkTaxApply(tax) {
    let return_status = true;
    return return_status;
  }

  function get_total_vat() {
    let tax_object = {};
    let tax_name = [];
    $(".sidebar-cart-card").each(function () {
      let food_menu_id = $(this).attr("data-order-cart-id");
      
      let qty = $(this).attr("data-qty");

      let item_total_price = parseFloat(
        $(this).find(".subtotal_cal").attr("data-inline_total")
      ).toFixed(ir_precision);

      item_total_price = item_total_price*qty;
      let menu_details = search_by_menu_id(food_menu_id, window.items);

      let tax_information = JSON.parse(menu_details[0].tax_information);

      if (tax_information.length > 0) {
        for (let k in tax_information) {
          if (
            tax_name.includes(tax_information[k].tax_field_name) &&
            checkTaxApply(tax_information[k].tax_field_name)
          ) {
            let previous_value =
              tax_object["" + tax_information[k].tax_field_name];
            let current_value = 0;
            let tax_type = Number($("#tax_type").val());
            if (tax_type == 1) {
              current_value = parseFloat(
                parseFloat(
                  parseFloat(tax_information[k].tax_field_percentage) *
                    parseFloat(item_total_price)
                ) / parseFloat(100)
              );
            } else {
              current_value = (
                parseFloat(item_total_price) -
                parseFloat(item_total_price) /
                  (1 + tax_information[k].tax_field_percentage / 100)
              ).toFixed(ir_precision);
            }

            tax_object["" + tax_information[k].tax_field_name] = (
              parseFloat(previous_value) + Number(current_value)
            ).toFixed(ir_precision);
          } else {
            if (checkTaxApply(tax_information[k].tax_field_name)) {
              tax_name.push(tax_information[k].tax_field_name);
              let current_value = 0;
              let tax_type = Number($("#tax_type").val());

              if (tax_type == 1) {
                current_value = parseFloat(
                  parseFloat(
                    parseFloat(tax_information[k].tax_field_percentage) *
                      parseFloat(item_total_price)
                  ) / parseFloat(100)
                );
              } else {
                current_value = (
                  parseFloat(item_total_price) -
                  parseFloat(item_total_price) /
                    (1 + tax_information[k].tax_field_percentage / 100)
                ).toFixed(ir_precision);
              }
              tax_object["" + tax_information[k].tax_field_name] =
                Number(current_value).toFixed(ir_precision);
            }
          }
        }
      }

      $(this)
        .find(".sidebar-cart-card-meta li")
        .each(function () {
          let modifier_id = $(this).attr("data-id");
        
          let item_total_price = Number($(this).attr("data-total_price"));
            item_total_price = item_total_price*qty;

          let modifier_details = search_by_modifer_id(
            modifier_id,
            window.only_modifiers
          );
         
          if (modifier_details[0].tax_information) {
            let tax_information = JSON.parse(
              modifier_details[0].tax_information
            );
            if (tax_information.length > 0) {
              for (let k in tax_information) {
                if (
                  tax_name.includes(tax_information[k].tax_field_name) &&
                  checkTaxApply(tax_information[k].tax_field_name)
                ) {
                  let previous_value =
                    tax_object["" + tax_information[k].tax_field_name];
                  let current_value = 0;
                  let tax_type = Number($("#tax_type").val());
                  if (tax_type == 1) {
                    current_value = parseFloat(
                      parseFloat(
                        parseFloat(tax_information[k].tax_field_percentage) *
                          parseFloat(item_total_price)
                      ) / parseFloat(100)
                    );
                  } else {
                    current_value = (
                      parseFloat(item_total_price) -
                      parseFloat(item_total_price) /
                        (1 + tax_information[k].tax_field_percentage / 100)
                    ).toFixed(ir_precision);
                  }
                  tax_object["" + tax_information[k].tax_field_name] = (
                    parseFloat(previous_value) + Number(current_value)
                  ).toFixed(ir_precision);
                } else {
                  if (checkTaxApply(tax_information[k].tax_field_name)) {
                    tax_name.push(tax_information[k].tax_field_name);
                    let current_value = 0;
                    let tax_type = Number($("#tax_type").val());

                    if (tax_type == 1) {
                      current_value = parseFloat(
                        parseFloat(
                          parseFloat(tax_information[k].tax_field_percentage) *
                            parseFloat(item_total_price)
                        ) / parseFloat(100)
                      );
                    } else {
                      current_value = (
                        parseFloat(item_total_price) -
                        parseFloat(item_total_price) /
                          (1 + tax_information[k].tax_field_percentage / 100)
                      ).toFixed(ir_precision);
                    }
                    tax_object["" + tax_information[k].tax_field_name] =
                      Number(current_value).toFixed(ir_precision);
                  }
                }
              }
            }
          }
        });
    });

    let collect_tax = $("#collect_tax").val();

    let vat_amount = collect_tax == "Yes" ? tax_object : null;
    let total_vat = 0;
    let html_modal = "";

    $.each(vat_amount, function (key, value) {
      let row_id = 1;
      let key_value = key;
      total_vat += Number(value);
      html_modal +=
        "<tr class='tax_field' data-tax_field_id='" +
        row_id +
        "'  data-tax_field_type='" +
        key_value +
        "'  data-tax_field_amount='" +
        value +
        "'>\n" +
        "                            <td>" +
        key_value +
        "</td>\n" +
        "                            <td>" +
        value +
        "</td>\n" +
        "                        </tr>";
    });
    $("#tax_row_show").html(html_modal);

    $("#total_vat_hidden").val((total_vat).toFixed(2));
  }
  function getFoodMenuTax(details_item_price,food_menu_id){
   
      let menu_details = search_by_menu_id(food_menu_id, window.items);

      let tax_information = JSON.parse(menu_details[0].tax_information);
      let total_tax = 0;
      if (tax_information.length > 0) {
        for (let k in tax_information) {
          let current_value = 0;
            let tax_type = Number($("#tax_type").val());

            if (tax_type == 1) {
              current_value = parseFloat(
                parseFloat(
                  parseFloat(tax_information[k].tax_field_percentage) *
                    parseFloat(details_item_price)
                ) / parseFloat(100)
              );
            } else {
              current_value = (
                parseFloat(details_item_price) -
                parseFloat(details_item_price) /
                  (1 + tax_information[k].tax_field_percentage / 100)
              ).toFixed(ir_precision);
            }
            total_tax+=current_value;
        }
      }

      return total_tax;
  }
  function getModifierTax(details_item_price,modifier_id){
   
    let modifier_details = search_by_modifer_id(
      modifier_id,
      window.only_modifiers
    );
    let total_tax = 0;
      if(modifier_details.length){
        let tax_information = JSON.parse(modifier_details[0].tax_information);
     
        if (tax_information.length > 0) {
          for (let k in tax_information) {
            let current_value = 0;
              let tax_type = Number($("#tax_type").val());
  
              if (tax_type == 1) {
                current_value = parseFloat(
                  parseFloat(
                    parseFloat(tax_information[k].tax_field_percentage) *
                      parseFloat(details_item_price)
                  ) / parseFloat(100)
                );
              } else {
                current_value = (
                  parseFloat(details_item_price) -
                  parseFloat(details_item_price) /
                    (1 + tax_information[k].tax_field_percentage / 100)
                ).toFixed(ir_precision);
              }
              total_tax+=current_value;
          }
        }
      }
  

      return total_tax;
}
  function detailsFoodTotalCalculate(){
    if($("#details_item_price").length){
    let details_item_price = Number($("#details_item_price").attr("data-price"));
    let food_menu_id = Number($("#details_item_price").attr("data-food_menu_id"));

      let total_modifier_cost  = 0;
      let total_tax = 0;
      $('.modifier_checkbox').each(function() {
        if ($(this).prop('checked')) {
            let id = Number($(this).parent().parent().attr("data-id"));
            let selected_cost = Number($(this).parent().parent().attr("data-price"));
            total_modifier_cost+=selected_cost;

            let total_mod_tax = getModifierTax(selected_cost,id);
            total_tax+=total_mod_tax;
        }
    });

    let total_food_tax = getFoodMenuTax(details_item_price,food_menu_id);
    let item_details_qty = Number($("#item_details_qty").val());
    let total = ((details_item_price + total_modifier_cost + total_tax + total_food_tax)*item_details_qty).toFixed(2);
    $(".show_total_amount").html(currency+total);
    }
  }
  
  $(document).on("click", ".customize-variation-item", function (e) {
    detailsFoodTotalCalculate();
  });
  
  $(document).on("click", ".call_qty", function (e) {
    detailsFoodTotalCalculate();
  });
  
  $(document).on("click", ".ct-social-login", function (e) {
    let is_demo_mode = $("#is_demo_mode").val();
     if(is_demo_mode=="demo"){
       toastr['warning']("Not allowed in demo mode!", '');
       e.preventDefault();
     }
  });
  
  $(document).on("click", ".minus_cart", function (e) {
      let qty = Number($(this).parent().find(".cart_qty").val());
      let update_qty = qty;
      if(qty==1){

      }else{
        update_qty = qty-1;
      }
      $(this).parent().find(".cart_qty").attr("value",update_qty);

      let inline_total = Number($(this).parent().parent().find(".subtotal_cal").attr("data-inline_total")) * update_qty;
      let modifer_price = 0;
      $(".modifier_div").each(function () {
           modifer_price+= (Number($(this).attr("data-total_price"))* update_qty);
      });
      $(this).parent().parent().find(".subtotal_cal").text(currency+(modifer_price+inline_total).toFixed(precision));
 
      $(this).parent().parent().parent().parent().parent().attr("data-qty",update_qty);
      

      setTimeout(function () {
        storageCartDataInLocal();
        setCheckOutCartItem();
        cartItemCalculate();
        setTimeout(function () {
          get_total_vat();
          subtotalCal();
          cartItemCalculate();
        }, 100);
      }, 100);
  });

  $(document).on("click", ".plus_cart", function (e) {
    let qty = Number($(this).parent().find(".cart_qty").val());
    let update_qty = qty;
      update_qty = qty+1;

    $(this).parent().find(".cart_qty").attr("value",update_qty);
    let inline_total = Number($(this).parent().parent().find(".subtotal_cal").attr("data-inline_total")) * update_qty;
    let modifer_price = 0;
    $(".modifier_div").each(function () {
         modifer_price+= (Number($(this).attr("data-total_price"))* update_qty);
    });
    $(this).parent().parent().find(".subtotal_cal").text(currency+(modifer_price+inline_total).toFixed(precision));


    $(this).parent().parent().parent().parent().parent().attr("data-qty",update_qty);

    setTimeout(function () {
      storageCartDataInLocal();
      setCheckOutCartItem();
      cartItemCalculate();
      setTimeout(function () {
        get_total_vat();
        subtotalCal();
        cartItemCalculate();
      }, 100);
    }, 100);
});

  detailsFoodTotalCalculate();

  function setReorderCheckout(order_info){
    $("#order_html_render").empty();
    let html_content = "";
    for (let key in order_info.items) {
      let modifier_html = "";
      let this_item = order_info.items[key];
 
      let total_modifier = 0;
      if(this_item.modifiers_id!=''){
          total_modifier = (this_item.modifiers_id.split(',')).length;
      }
     
      let modifier_ids_custom = [];
      let modifier_names_custom = [];
      let modifier_prices_custom = [];
      if(total_modifier){
          modifier_ids_custom = this_item.modifiers_id.split(',');
          modifier_names_custom = this_item.modifiers_name.split(',');
          modifier_prices_custom = this_item.modifiers_price.split(',');
      }
      let modifier_sum = 0;
      if (total_modifier) { 
        for (let mod_key_custom in modifier_names_custom) {
                modifier_html +=
                `<li data-id="` +
                modifier_ids_custom[mod_key_custom] +
                `" data-total_price="` +
                modifier_prices_custom[mod_key_custom] +
                `" data-name="` +
                modifier_names_custom[mod_key_custom] +
                `" class="d-block modifier_div">${modifier_names_custom[mod_key_custom]} (${Number(modifier_prices_custom[mod_key_custom]).toFixed(
                  precision
                )})</li>`;
                modifier_sum += Number(modifier_prices_custom[mod_key_custom]);
        }
      }

        let special_instructions = '';
        if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
          special_instructions = this_item.item_note;
        }
        let menu_details = search_by_menu_id(this_item.food_menu_id, window.items);
       
        let quantity = Number(this_item.qty);
        let food_order_id = Number(this_item.food_menu_id);
        html_content += `
        <div class="sidebar-cart-card" data-note="${special_instructions}" data-image="${menu_details[0].photo}" data-name="${this_item.menu_name}" data-price="${this_item.menu_unit_price}" data-qty="${Number(quantity)}"  data-order-cart-id="${food_order_id}">
            <div class="card-header">
                <img src="${menu_details[0].photo}" alt="${this_item.menu_name}" />
                <div class="d-flex flex-column gap15px w-100">
                    <div>
                        <h3 class="card-title">${this_item.menu_name}</h3>
                        <div class="card-prices sidebar-cart-card-meta">
                            <ul>
                                ${modifier_html}
                            </ul>
                        </div>
                        ${special_instructions && special_instructions.trim() !== '' ? `<p class="card-description"><strong>Note:</strong> ${special_instructions}.</p>` : ''}
                    </div>
                    <div class="price-section">
                        <div class="food-qty-price-${food_order_id}">${currency}${parseFloat(this_item.menu_unit_price).toFixed(precision)}</div>
                        <div class="quantity">
                            <button class="minus_cart">-</button>
                            <input type="text"  class="cart_qty" value="${Number(quantity)}" readonly />
                            <button class="plus_cart">+</button>
                        </div>
                        <div class="subtotal_cal cart-sidebar-price-${food_order_id}" data-inline_total="`+((Number(quantity) * Number(this_item.menu_unit_price)))+`">${currency}${ parseFloat(Number(modifier_sum) + (Number(quantity) * Number(this_item.menu_unit_price))).toFixed(precision)}</div>
                    </div>
                </div>
            </div>
            <button class="delete-btn close-btn single-item-remove">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_37_504)">
                        <path d="M4.875 0.75H7.125C7.22446 0.75 7.31984 0.789509 7.39017 0.859835C7.46049 0.930161 7.5 1.02554 7.5 1.125V1.875H4.5V1.125C4.5 1.02554 4.53951 0.930161 4.60984 0.859835C4.68016 0.789509 4.77554 0.75 4.875 0.75ZM8.25 1.875V1.125C8.25 0.826631 8.13147 0.540483 7.9205 0.329505C7.70952 0.118526 7.42337 0 7.125 0L4.875 0C4.57663 0 4.29048 0.118526 4.0795 0.329505C3.86853 0.540483 3.75 0.826631 3.75 1.125V1.875H1.125C1.02554 1.875 0.930161 1.91451 0.859835 1.98484C0.789509 2.05516 0.75 2.15054 0.75 2.25C0.75 2.34946 0.789509 2.44484 0.859835 2.51516C0.930161 2.58549 1.02554 2.625 1.125 2.625H1.5285L2.16825 10.62C2.19842 10.9959 2.36907 11.3466 2.64621 11.6024C2.92335 11.8581 3.28665 12.0001 3.66375 12H8.33625C8.71335 12.0001 9.07665 11.8581 9.35379 11.6024C9.63093 11.3466 9.80158 10.9959 9.83175 10.62L10.4715 2.625H10.875C10.9745 2.625 11.0698 2.58549 11.1402 2.51516C11.2105 2.44484 11.25 2.34946 11.25 2.25C11.25 2.15054 11.2105 2.05516 11.1402 1.98484C11.0698 1.91451 10.9745 1.875 10.875 1.875H8.25ZM9.7185 2.625L9.084 10.56C9.06892 10.7479 8.98359 10.9233 8.84502 11.0512C8.70645 11.1791 8.5248 11.25 8.33625 11.25H3.66375C3.4752 11.25 3.29355 11.1791 3.15498 11.0512C3.01641 10.9233 2.93108 10.7479 2.916 10.56L2.2815 2.625H9.7185ZM4.10325 3.375C4.2025 3.36926 4.29997 3.40317 4.37422 3.46927C4.44848 3.53537 4.49345 3.62825 4.49925 3.7275L4.87425 10.1025C4.87819 10.2006 4.84351 10.2963 4.77766 10.3691C4.71181 10.4419 4.62004 10.486 4.52206 10.4919C4.42407 10.4978 4.32768 10.465 4.25358 10.4006C4.17949 10.3362 4.13359 10.2453 4.12575 10.1475L3.75 3.7725C3.74696 3.72323 3.75367 3.67385 3.76975 3.62719C3.78583 3.58052 3.81097 3.53749 3.84372 3.50056C3.87646 3.46363 3.91618 3.43353 3.96059 3.41198C4.005 3.39043 4.05322 3.37787 4.1025 3.375H4.10325ZM7.89675 3.375C7.94603 3.37787 7.99425 3.39043 8.03866 3.41198C8.08307 3.43353 8.12279 3.46363 8.15553 3.50056C8.18828 3.53749 8.21342 3.58052 8.2295 3.62719C8.24558 3.67385 8.25229 3.72323 8.24925 3.7725L7.87425 10.1475C7.87225 10.1973 7.86033 10.2463 7.83918 10.2914C7.81804 10.3366 7.78809 10.3771 7.75111 10.4106C7.71412 10.444 7.67083 10.4698 7.62377 10.4863C7.57671 10.5028 7.52683 10.5098 7.47705 10.5068C7.42726 10.5038 7.37858 10.4909 7.33384 10.4688C7.2891 10.4468 7.2492 10.4161 7.21649 10.3784C7.18378 10.3408 7.1589 10.297 7.14332 10.2496C7.12774 10.2022 7.12177 10.1522 7.12575 10.1025L7.50075 3.7275C7.50655 3.62825 7.55152 3.53537 7.62578 3.46927C7.70004 3.40317 7.7975 3.36926 7.89675 3.375ZM6 3.375C6.09946 3.375 6.19484 3.41451 6.26517 3.48484C6.33549 3.55516 6.375 3.65054 6.375 3.75V10.125C6.375 10.2245 6.33549 10.3198 6.26517 10.3902C6.19484 10.4605 6.09946 10.5 6 10.5C5.90054 10.5 5.80516 10.4605 5.73484 10.3902C5.66451 10.3198 5.625 10.2245 5.625 10.125V3.75C5.625 3.65054 5.66451 3.55516 5.73484 3.48484C5.80516 3.41451 5.90054 3.375 6 3.375Z" fill="#CF6161"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_37_504">
                            <rect width="12" height="12" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </button>
            
        </div>`;
      }
      $("#order_html_render").append(html_content);
 
 
          setTimeout(function () {
            storageCartDataInLocal();
            setCheckOutCartItem();
            cartItemCalculate();
            toastr['success'](order_copied, '');

            get_total_vat();
            subtotalCal();
            cartItemCalculate();

            setTimeout(function () {
              window.location.href = base_url + "checkout";
            }, 4000);
          }, 200);
  

  }

  $(document).on("click", ".re_order", function (e) {
    e.preventDefault();
    let is_exist_cart = $(".sidebar-cart-card").length;
    let id = $(this).attr("data-id");
    let order_details = $("#order_details_"+id).html();

    if(is_exist_cart){
        swal(
          {
              title: warning + "!",
              text: cart_need_clean,
              confirmButtonColor: website_theme_color,
              confirmButtonText: ok,
              showCancelButton: true,
          },
          function () {
             let response = jQuery.parseJSON(order_details);
            setReorderCheckout(response);
          }
      );
  
    }else{
      let response = jQuery.parseJSON(order_details);
      setReorderCheckout(response);
    }
  




  });

  function setCheckOutCartItem() {
    let checkOutHtml = "";
    $(".sidebar-cart-card").each(function () {
      let food_menu_id = $(this).attr("data-order-cart-id");
      let name = $(this).attr("data-name");
      let price = Number($(this).attr("data-price"));
      let qty = Number($(this).attr("data-qty"));
      let photo = $(this).attr("data-image");
      let note = $(this).attr("data-note");
      let modifier_html = "";
      let modifier_sum = 0;

      $(this)
        .find(".sidebar-cart-card-meta li")
        .each(function () {
          let modifier_id = $(this).attr("data-id");
          let total_price = Number($(this).attr("data-total_price"));
          modifier_sum += Number(total_price);
          let modifier_name = $(this).attr("data-name");
      
          modifier_html +=
                `<li data-id="` +
                modifier_id +
                `" data-total_price="` +
                total_price +
                `" data-name="` +
                modifier_name +
                `" class="d-block modifier_div">${modifier_name} (${total_price.toFixed(
                  precision
                )})</li>`;
        });

      checkOutHtml +=
        `
            <div class="item">
              <div class="item-details">
                <div class="d-flex align-items-center gap10px">
                <img src="${photo}" alt="${name}" />
                <div>
                  <h4>${name} <span>x${qty}</span></h4>
                  <ul>
                    ${modifier_html}
                  </ul>                  
                  ${note && note.trim() !== '' ? `<p class="note"><strong>Note:</strong> ${note}.</p>` : ''}
                </div>
                </div>
                <p class="price checkout_single_subtotal checkout_single_subtotal_${food_menu_id}" data-inline_total="` +
                Number(qty) * Number(price) +
                `">${currency}${parseFloat(
                  Number(modifier_sum) + Number(qty) * Number(price)
                ).toFixed(precision)}</p>
              </div>
            </div>`;
    });

    localStorage["checkout_cart_html_irp"] = checkOutHtml;
    get_total_vat();
  }
  setTimeout(function () {
    get_total_vat();
  }, 50);
  function singleItemOrder(food_order_id, exist_check) {
    let quantity = $(`.item_details_qty_${food_order_id}`).val();
    $.ajax({
      type: "POST",
      url: base_url + "Frontend/singleItemOrder",
      data: {
        food_id: food_order_id,
      },
      dataType: "json",
      success: function (response) {
        let html_content = "";
        if (response.status == "success") {
          let isChecked;
          let modifier_id = 0;
          let modifier_name = "";
          let modifier_price = 0;
          let modifier_html = "";
          let modifier_sum = 0;
          let special_instructions = $("#special_instructions").val();
          $(".modifier_checkbox").each(function () {
            isChecked = $(this).is(":checked");
            if (isChecked) {
              modifier_id = $(this)
                .closest(".customize-variation-item")
                .data("id");
              modifier_name = $(this)
                .closest(".customize-variation-item")
                .data("name");
              modifier_price = $(this)
                .closest(".customize-variation-item")
                .data("price");
              modifier_price = Number(quantity) * Number(modifier_price);
              modifier_html +=
                `<li data-id="` +
                modifier_id +
                `" data-total_price="` +
                modifier_price +
                `" data-name="` +
                modifier_name +
                `" class="d-block modifier_div">${modifier_name} (${modifier_price.toFixed(
                  precision
                )})</li>`;
              modifier_sum += Number(modifier_price);
            }
          });

          if (exist_check == "Yes") {
            $(`.checkout_single_subtotal_${response.data.id}`).text(
              `${parseFloat(
                Number(modifier_sum) +
                  Number(quantity) * Number(response.data.sale_price)
              ).toFixed(precision)}`
            );
          }

          if (exist_check == "Yes") {
            $(`.food-qty-price-${response.data.id}`).text(
              `${quantity} X ${response.data.sale_price}`
            );
            $(`.cart-sidebar-price-${response.data.id}`).text(
              `${parseFloat(
                Number(modifier_sum) +
                  Number(quantity) * Number(response.data.sale_price)
              ).toFixed(precision)}`
            );
            $(".sidebar-cart-card-meta").html("").html(modifier_html);
          } else {
            html_content += `
            <div class="sidebar-cart-card" data-note="${special_instructions}" data-image="${response.data.photo}" data-name="${response.data.name}" data-price="${response.data.sale_price}" data-qty="${Number(quantity)}"  data-order-cart-id="${food_order_id}">
                <div class="card-header">
                    <img src="${response.data.photo}" alt="${response.data.name}" />
                    <div class="d-flex flex-column gap15px w-100">
                        <div>
                            <h3 class="card-title">${response.data.name}</h3>
                            <div class="card-prices sidebar-cart-card-meta">
                                <ul>
                                    ${modifier_html}
                                </ul>
                            </div>
                            ${special_instructions && special_instructions.trim() !== '' ? `<p class="card-description"><strong>Note:</strong> ${special_instructions}.</p>` : ''}
                        </div>
                        <div class="price-section">
                            <div class="food-qty-price-${response.data.id}">${currency}${parseFloat(response.data.sale_price).toFixed(precision)}</div>
                            <div class="quantity">
                                <button class="minus_cart">-</button>
                                <input type="text"  class="cart_qty" value="${Number(quantity)}" readonly />
                                <button class="plus_cart">+</button>
                            </div>
                            <div class="subtotal_cal cart-sidebar-price-${response.data.id}" data-inline_total="`+((Number(quantity) * Number(response.data.sale_price)))+`">${currency}${ parseFloat(Number(modifier_sum) + (Number(quantity) * Number(response.data.sale_price))).toFixed(precision)}</div>
                        </div>
                    </div>
                </div>
                <button class="delete-btn close-btn single-item-remove">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_37_504)">
                            <path d="M4.875 0.75H7.125C7.22446 0.75 7.31984 0.789509 7.39017 0.859835C7.46049 0.930161 7.5 1.02554 7.5 1.125V1.875H4.5V1.125C4.5 1.02554 4.53951 0.930161 4.60984 0.859835C4.68016 0.789509 4.77554 0.75 4.875 0.75ZM8.25 1.875V1.125C8.25 0.826631 8.13147 0.540483 7.9205 0.329505C7.70952 0.118526 7.42337 0 7.125 0L4.875 0C4.57663 0 4.29048 0.118526 4.0795 0.329505C3.86853 0.540483 3.75 0.826631 3.75 1.125V1.875H1.125C1.02554 1.875 0.930161 1.91451 0.859835 1.98484C0.789509 2.05516 0.75 2.15054 0.75 2.25C0.75 2.34946 0.789509 2.44484 0.859835 2.51516C0.930161 2.58549 1.02554 2.625 1.125 2.625H1.5285L2.16825 10.62C2.19842 10.9959 2.36907 11.3466 2.64621 11.6024C2.92335 11.8581 3.28665 12.0001 3.66375 12H8.33625C8.71335 12.0001 9.07665 11.8581 9.35379 11.6024C9.63093 11.3466 9.80158 10.9959 9.83175 10.62L10.4715 2.625H10.875C10.9745 2.625 11.0698 2.58549 11.1402 2.51516C11.2105 2.44484 11.25 2.34946 11.25 2.25C11.25 2.15054 11.2105 2.05516 11.1402 1.98484C11.0698 1.91451 10.9745 1.875 10.875 1.875H8.25ZM9.7185 2.625L9.084 10.56C9.06892 10.7479 8.98359 10.9233 8.84502 11.0512C8.70645 11.1791 8.5248 11.25 8.33625 11.25H3.66375C3.4752 11.25 3.29355 11.1791 3.15498 11.0512C3.01641 10.9233 2.93108 10.7479 2.916 10.56L2.2815 2.625H9.7185ZM4.10325 3.375C4.2025 3.36926 4.29997 3.40317 4.37422 3.46927C4.44848 3.53537 4.49345 3.62825 4.49925 3.7275L4.87425 10.1025C4.87819 10.2006 4.84351 10.2963 4.77766 10.3691C4.71181 10.4419 4.62004 10.486 4.52206 10.4919C4.42407 10.4978 4.32768 10.465 4.25358 10.4006C4.17949 10.3362 4.13359 10.2453 4.12575 10.1475L3.75 3.7725C3.74696 3.72323 3.75367 3.67385 3.76975 3.62719C3.78583 3.58052 3.81097 3.53749 3.84372 3.50056C3.87646 3.46363 3.91618 3.43353 3.96059 3.41198C4.005 3.39043 4.05322 3.37787 4.1025 3.375H4.10325ZM7.89675 3.375C7.94603 3.37787 7.99425 3.39043 8.03866 3.41198C8.08307 3.43353 8.12279 3.46363 8.15553 3.50056C8.18828 3.53749 8.21342 3.58052 8.2295 3.62719C8.24558 3.67385 8.25229 3.72323 8.24925 3.7725L7.87425 10.1475C7.87225 10.1973 7.86033 10.2463 7.83918 10.2914C7.81804 10.3366 7.78809 10.3771 7.75111 10.4106C7.71412 10.444 7.67083 10.4698 7.62377 10.4863C7.57671 10.5028 7.52683 10.5098 7.47705 10.5068C7.42726 10.5038 7.37858 10.4909 7.33384 10.4688C7.2891 10.4468 7.2492 10.4161 7.21649 10.3784C7.18378 10.3408 7.1589 10.297 7.14332 10.2496C7.12774 10.2022 7.12177 10.1522 7.12575 10.1025L7.50075 3.7275C7.50655 3.62825 7.55152 3.53537 7.62578 3.46927C7.70004 3.40317 7.7975 3.36926 7.89675 3.375ZM6 3.375C6.09946 3.375 6.19484 3.41451 6.26517 3.48484C6.33549 3.55516 6.375 3.65054 6.375 3.75V10.125C6.375 10.2245 6.33549 10.3198 6.26517 10.3902C6.19484 10.4605 6.09946 10.5 6 10.5C5.90054 10.5 5.80516 10.4605 5.73484 10.3902C5.66451 10.3198 5.625 10.2245 5.625 10.125V3.75C5.625 3.65054 5.66451 3.55516 5.73484 3.48484C5.80516 3.41451 5.90054 3.375 6 3.375Z" fill="#CF6161"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_37_504">
                                <rect width="12" height="12" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </button>
                
            </div>`;
            $("#order_html_render").append(html_content);
          }
          setTimeout(function () {
            storageCartDataInLocal();
            setCheckOutCartItem();
            cartItemCalculate();
            setTimeout(function () {
              get_total_vat();
              subtotalCal();
              cartItemCalculate();
            }, 200);
          }, 200);
        }
      },
    });
  }

  $(document).on("click", ".single-item-remove", function () {
    $(this).parent().remove();
    subtotalCal();
    cartItemCalculate();
    storageCartDataInLocal();
    setCheckOutCartItem();
  });

  $(document).on("click", ".call_calculation", function () {
    get_total_vat();
    subtotalCal();
  });

  function subtotalCal() {
    setTimeout(function () {
      let subtotal = 0;
      $(".subtotal_cal").each(function () {
        let subtotalText = $(this).text();
        let subtotalValue = subtotalText.replace(currency, '').trim();
        
        subtotal += parseFloat(subtotalValue);
      });
      let total_tax = Number($("#total_vat_hidden").val());

   
      let delivery_amount_hidden = ($("#delivery_amount_hidden").val());
      let apply_on_delivery_charge = Number($("#apply_on_delivery_charge").val());
      let delivery_charge_amount_tax = 0;
      if (total_tax) {
        if(apply_on_delivery_charge==2){
            delivery_charge_amount_tax = Number(get_particular_item_discount_amount(delivery_amount_hidden,total_tax));
        }
      }
  
      let delivery_charge_amount_tmp = Number(get_particular_item_discount_amount(delivery_amount_hidden,subtotal));
      let total_delivery_charge =  delivery_charge_amount_tax+delivery_charge_amount_tmp;
     


     
      if (!subtotal) {
        total_tax = 0;
      }
      let total_payable = subtotal + total_tax + total_delivery_charge;
      $(".cart-subtotal").text(`${currency}${subtotal.toFixed(precision)}`);
      $(".cart-tax").text(`${currency}${total_tax.toFixed(precision)}`);
      $("#side_cart_delivery_charge").text(currency+(parseFloat(total_delivery_charge).toFixed(precision)));
      $(".cart-total").text(`${currency}${total_payable.toFixed(precision)}`);
    }, 200);
  }

  function cartItemCalculate() {
    let cart_length = $(".sidebar-cart-card").length;
    $(".cart-item-count").text(cart_length);
    $(".cart-item-count-static").text(cart_length);
    $(".cart-item-total").text(`(${cart_length})`);
  }

  function storageCartDataInLocal() {
    localStorage["cart_html_irp"] = $("#order_html_render").html();
    setCheckOutCartItem();
  }

  let local_cart_data = localStorage["cart_html_irp"];
  if (local_cart_data) {
    $("#order_html_render").html(local_cart_data);
    subtotalCal();
    cartItemCalculate();
  }

  let checkout_cart_html = localStorage["checkout_cart_html_irp"];
  if (checkout_cart_html) { 
    $(".card-checkout-item").html(checkout_cart_html);
    subtotalCal();
    cartItemCalculate();
  }

  function get_particular_item_discount_amount(discount, item_price) {
    if (discount.length > 0 && discount.substr(discount.length - 1) == "%") {
      return (
        (parseFloat(item_price) * parseFloat(discount)) /
        parseFloat(100)
      ).toFixed(ir_precision);
    } else {
      return parseFloat(discount).toFixed(ir_precision);
    }
  }
  
  function checkoutCalculation() {
    let subtotal = 0;
    let grandTotal = 0;
    $(".checkout_single_subtotal").each(function () {
      let subtotal_inline = parseFloat($(this).text().replace(currency, '').trim());
      grandTotal += subtotal_inline;
      subtotal+=subtotal_inline;
    });

    let total_vat_hidden = $("#total_vat_hidden").val();
    $(".checkout_tax_total").text(
      parseFloat(total_vat_hidden).toFixed(precision)
    );

    let delivery_amount_hidden = ($("#delivery_amount_hidden").val());
    let apply_on_delivery_charge = Number($("#apply_on_delivery_charge").val());
    let delivery_charge_amount_tax = 0;
    if (total_vat_hidden) {
      if(apply_on_delivery_charge==2){
          delivery_charge_amount_tax = Number(get_particular_item_discount_amount(delivery_amount_hidden,total_vat_hidden));
      }
    }

     let delivery_charge_amount_tmp = Number(get_particular_item_discount_amount(delivery_amount_hidden,subtotal));
    let total_delivery_charge =  delivery_charge_amount_tax+delivery_charge_amount_tmp;
    grandTotal += total_delivery_charge;
    $(".checkout_delivery_fee").text(parseFloat(total_delivery_charge).toFixed(precision));
    $(".checkout_sub_total").text(parseFloat(subtotal).toFixed(precision));
    let g_total = Number(total_vat_hidden) + Number(grandTotal);
    $(".checkout_grand_total").text(parseFloat(g_total).toFixed(precision));
  }
  setTimeout(function () {
    checkoutCalculation();
  }, 100);

  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }
  function getPadTwo(str) {
    str = str.toString();
    return str.length < 3 ? getPadTwo("0" + str, 3) : str;
  }
  function generateSaleNo() {
    //for date and time
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1; //January is 0!
    let yyyy = today.getFullYear();
    let twoDigitYear = yyyy.toString().substr(-2);
    if (dd < 10) {
      dd = "0" + dd;
    }
    if (mm < 10) {
      mm = "0" + mm;
    }
    let time_a = new Date();
    let t_h = time_a.getHours();
    let t_m = time_a.getMinutes();
    let t_s = time_a.getSeconds();

    if (t_h < 10) {
      t_h = "0" + t_h;
    }
    if (t_m < 10) {
      t_m = "0" + t_m;
    }
    if (t_s < 10) {
      t_s = "0" + t_s;
    }
    let username_short = $("#username_short").val();
    let invoice_counter_value_tmp = Number(
      localStorage["invoice_counter_value"]
    )
      ? Number(localStorage["invoice_counter_value"])
      : 0;
    let invoice_counter_value = invoice_counter_value_tmp + 1;
    localStorage["invoice_counter_value"] = invoice_counter_value;
    let sale_no =
    username_short +
      twoDigitYear +
      mm +
      dd +
      "-" +
      getPadTwo(invoice_counter_value);


    return sale_no;
  }
  function getDateTime() {
    //for date and time
    let today1 = new Date();
    let dd1 = today1.getDate();
    let mm1 = today1.getMonth() + 1; //January is 0!
    let yyyy = today1.getFullYear();
    if (dd1 < 10) {
      dd1 = "0" + dd1;
    }
    if (mm1 < 10) {
      mm1 = "0" + mm1;
    }
    let time_a = new Date().toLocaleTimeString();
    let today_date = yyyy + "-" + mm1 + "-" + dd1;
    let date_time = today_date + " " + time_a;
    return [date_time, time_a];
  }
  function getRandomCode(length) {
    let result = "";
    //this is random character pattern
    let characters =
      "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }
  function search_by_menu_id(menu_id, myArray) {
    let foundResult = new Array();
    for (let i = 0; i < myArray.length; i++) {
      if (Number(myArray[i].item_id) === Number(menu_id)) {
        foundResult.push(myArray[i]);
      }
    }
    return foundResult.sort();
  }
  function search_by_modifer_id(menu_modifier_id, myArray) {
    let foundResult = new Array();
    for (let i = 0; i < myArray.length; i++) {
      if (Number(myArray[i].menu_modifier_id) === Number(menu_modifier_id)) {
        foundResult.push(myArray[i]);
      }
    }
    return foundResult.sort();
  }

  $(document).on("click", ".pay_now", function (e) {
    e.preventDefault();
    let fname = $("#fname").val();
    let phone = $("#phone").val();
    let email = $("#email").val();
    let faddress = $("#faddress").val();
    var outlet_id =  Number($("#online_selected_outlet").val());

    let status = true;

    if (fname == "") {
      status = false;
      $("#fname").css("border", "1px solid red");
      $("#fname").focus();
    } else if (phone == "") {
      status = false;
      $("#phone").css("border", "1px solid red");
      $("#phone").focus();
    } else if (faddress == "") {
      status = false;
      $("#faddress").css("border", "1px solid red");
      $("#faddress").focus();
    } else if (!isEmail(email)) {
      status = false;
      $("#email").css("border", "1px solid red");
      $("#email").focus();
    }
    if ($(".sidebar-cart-card").length <= 0) {
      status = false;
      toastr['error'](not_data_in_cart, '');
    }
    if (status == true) {
      $(this).addClass("no_access");
      let sale_no_new = 0;
      let random_code = "";
      sale_no_new = generateSaleNo();
      random_code = getRandomCode(15);

      let order_status = 1;
      let rounding_amount_hidden = 0;
      let customer_current_due = 0;
      let token_number = "";
      let hidden_given_amount = 0;
      let hidden_change_amount = 0;
      let counter_id = 0;
      let customer_id = $("#hidden_customer_id").val();
      let faddress = $("#faddress").val();
      let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
      let total_items_in_cart = $(".cart-item-count").text();
      let total_items_in_cart_qty = 0;

      $(".sidebar-cart-card").each(function () {
        let this_qty = Number($(this).attr("data-qty"));
        total_items_in_cart_qty += this_qty;
      });
      let total_amount = $(".checkout_grand_total").eq(1).text();
      let checkout_delivery_fee = Number($(".checkout_delivery_fee").text());
      let checkout_sub_total = $(".checkout_sub_total").text();
      let total_vat = $("#total_vat_hidden").val();
      let outlet_id_indexdb = outlet_id;
      let order_info = "{";
      order_info += '"sale_no":"' + sale_no_new + '",';
      order_info += '"is_online_order":"Yes",';
      order_info += '"outlet_id":"' + outlet_id_indexdb + '",';
      order_info += '"waiter_app_status":"",';
      order_info += '"hidden_given_amount":"' + hidden_given_amount + '",';
      order_info += '"hidden_change_amount":"' + hidden_change_amount + '",';
      order_info += '"counter_id":"' + counter_id + '",';
      order_info += '"random_code":"' + random_code + '",';
      order_info += '"token_number":"' + token_number + '",';
      order_info += '"customer_id":"' + customer_id + '",';
      order_info += '"customer_address":"'+faddress+'",';
      order_info += '"customer_gst_number":"",';
      order_info += '"status":"Pending",';
      order_info += '"user_name":"",';
      order_info += '"user_id":"",';
      order_info += '"customer_name":"' + fname + '",';
      order_info += '"delivery_partner_id":"",';
      order_info += '"self_order_table_id":"",';
      order_info += '"self_order_table_person":"",';
      order_info +=
        '"rounding_amount_hidden":"' + rounding_amount_hidden + '",';
      order_info += '"previous_due_tmp":"' + customer_current_due + '",';
      order_info += '"waiter_id":"",';
      order_info += '"waiter_name":"",';
      order_info +=
        '"open_invoice_date_hidden":"' + open_invoice_date_hidden + '",';
      order_info += '"total_items_in_cart":"' + total_items_in_cart + '",';
      order_info +=
        '"total_items_in_cart_qty":"' + total_items_in_cart_qty + '",';
      order_info += '"sub_total":"' + checkout_sub_total + '",';
      order_info += '"sale_date":"' + open_invoice_date_hidden + '",';
      order_info += '"date_time":"' + getDateTime()[0] + '",';
      order_info += '"order_time":"' + getDateTime()[1] + '",';
      order_info += '"charge_type":"delivery",';
      order_info += '"total_vat":"' + total_vat + '",';
      order_info += '"total_payable":"' + total_amount + '",';
      order_info += '"total_item_discount_amount":"0",';
      order_info += '"sub_total_with_discount":"",';
      order_info += '"sub_total_discount_amount":"0",';
      order_info += '"total_discount_amount":"0",';
      order_info += '"delivery_charge":"'+checkout_delivery_fee+'",';
      order_info += '"tips_amount":"0",';
      order_info += '"delivery_charge_actual_charge":"'+checkout_delivery_fee+'",';
      order_info += '"tips_amount_actual_charge":"0",';
      order_info += '"sub_total_discount_value":"0",';
      order_info += '"sub_total_discount_type":"",';
      order_info += '"order_type":"3",';
      order_info += '"order_status":"' + order_status + '",';

      let sale_vat_objects = [];
      $("#tax_row_show .tax_field").each(function (i, obj) {
        let tax_field_id = $(this).attr("data-tax_field_id");
        let tax_field_type = $(this).attr("data-tax_field_type");
        let tax_field_amount = $(this).attr("data-tax_field_amount");
        sale_vat_objects.push({
          tax_field_id: tax_field_id,
          tax_field_type: tax_field_type,
          tax_field_amount:
            parseFloat(tax_field_amount).toFixed(ir_precision),
        });
      });

 
      order_info +=
        '"sale_vat_objects":' + JSON.stringify(sale_vat_objects) + ",";

      let hidden_table_name = "";
      let hidden_table_id = "";
      let hidden_table_capacity = 1;

      let total_person = 0;

      let orders_table = "";
      orders_table += '"orders_table":';
      orders_table += "[";
      let x = 1;

      let orders_table_text = "";
      total_person = hidden_table_capacity;
      orders_table_text = hidden_table_name;
      orders_table +=
        '{"table_id":"' +
        hidden_table_id +
        '", "persons":"' +
        hidden_table_capacity +
        '"}';

      let items_info = "";

      items_info += '"items":';
      items_info += "[";

      if ($(".sidebar-cart-card").length > 0) {
        let k = 1;
        $(".sidebar-cart-card").each(function () {
          let item_id = $(this).attr("data-order-cart-id");
          let menu_details = search_by_menu_id(item_id, window.items);
          let item_name = $(this).attr("data-name");
          let qty = Number($(this).attr("data-qty"));

          let item_vat = [];
          let tax_information_tmp = JSON.parse(menu_details[0].tax_information);

          if (tax_information_tmp.length > 0) {
            for (let k in tax_information_tmp) {
              item_vat.push({
                tax_field_id: 1,
                tax_field_type: tax_information_tmp[k].tax_field_name,
                tax_field_amount: parseFloat(
                  tax_information_tmp[k].tax_field_percentage
                ).toFixed(ir_precision),
              });
            }
          } 
          let item_discount = 0;
          let discount_type = "fixed";

          let item_previous_id = 0;
          let item_cooking_done_time = "";
          let item_cooking_start_time = "";
          let item_cooking_status = "";
          let item_type = "";

          let item_unit_price = menu_details[0].price;
          let item_quantity = qty;
          let is_kot_print = "";
          let tmp_qty = qty;
          let p_qty = qty;
          let item_price_with_discount = menu_details[0].price * qty;
          let item_discount_amount = 0;
          let item_price_without_discount = item_price_with_discount; 

          items_info +=
            '{"food_menu_id":"' +
            item_id +
            '", "is_print":"' +
            1 +
            '", "is_kot_print":"' +
            is_kot_print +
            '", "menu_name":"' +
            item_name +
            '", "kitchen_id":"", "kitchen_name":"", "is_free":"0", "rounding_amount_hidden":"0", "item_vat":' +
            JSON.stringify(item_vat) +
            ",";
          items_info +=
            '"menu_discount_value":"' +
            item_discount +
            '","discount_type":"' +
            discount_type +
            '","menu_price_without_discount":"' +
            item_price_without_discount +
            '",';
          items_info +=
            '"menu_unit_price":"' +
            item_unit_price +
            '","qty":"' +
            item_quantity +
            '","tmp_qty":"' +
            tmp_qty +
            '","p_qty":"' +
            p_qty +
            '",';
          items_info +=
            '"item_previous_id":"' +
            item_previous_id +
            '","item_cooking_done_time":"' +
            item_cooking_done_time +
            '",';
          items_info +=
            '"item_cooking_start_time":"' +
            item_cooking_start_time +
            '","item_cooking_status":"' +
            item_cooking_status +
            '","item_type":"' +
            item_type +
            '",';
          items_info +=
            '"menu_price_with_discount":"' +
            item_price_with_discount +
            '","item_discount_amount":"' +
            item_discount_amount +
            '"';

          let modifiers_id = "";
          let modifiers_name = "";
          let modifiers_price = "";

          let iii = 1;
          let modifier_vat = "";
          let total_row = $(this).find(".sidebar-cart-card-meta li").length;

          $(this)
            .find(".sidebar-cart-card-meta li")
            .each(function () {
              let modifier_id = $(this).attr("data-id");
              let total_price = $(this).attr("data-total_price");
              let modifier_name = $(this).attr("data-name");
              let modifier_details = search_by_modifer_id(
                modifier_id,
                window.only_modifiers
              );

              let item_vat_m = [];
              let tax_information_tmp1 = JSON.parse(
                modifier_details[0].tax_information
              );
              if (tax_information_tmp1.length > 0) {
                for (let k in tax_information_tmp1) {
                  item_vat_m.push({
                    tax_field_id: 1,
                    tax_field_name: tax_information_tmp1[k].tax_field_name,
                    tax_field_percentage: parseFloat(
                      tax_information_tmp1[k].tax_field_percentage
                    ).toFixed(ir_precision),
                    item_vat_amount_for_unit_item: 0,
                    item_vat_amount_for_all_quantity: 0,
                  });
                }
              }

              if (iii == total_row) {
                modifiers_id += modifier_id;
                modifiers_name += modifier_name;
                modifiers_price += total_price;
                modifier_vat += item_vat_m;
              } else {
                modifiers_id += modifier_id + ",";
                modifiers_name += modifier_name + ",";
                modifiers_price += total_price + ",";
                modifier_vat += item_vat_m + "|||";
              }
              iii++;
            });
        
          modifier_vat = "";
          items_info +=
            ',"modifiers_id":"' +
            modifiers_id +
            '", "modifiers_name":"' +
            modifiers_name +
            '", "modifiers_price":"' +
            modifiers_price +
            '", "modifier_vat":' +
            JSON.stringify(modifier_vat);

          items_info += ',"item_note":""';
          items_info += ',"menu_combo_items":""';
          items_info += k == $(".sidebar-cart-card").length ? "}" : "},";
          k++;
        });
      }
      items_info += "]";
      order_info += items_info + "}";
     
      let payment_method = $(".payment_method:checked").val();
      $.ajax({
        url: base_url + "PaymentController/add_kitchen_sale_by_ajax",
        method: "POST",
        dataType: "json",
        data: {
          order: order_info,
          is_self_order: "Yes",
          payment_method: payment_method,
          close_order: 0,
        },
        success: function (data) {
        
          if (data.status == true) {
            localStorage["cart_html_irp"] = "";
            localStorage["checkout_cart_html_irp"] = "";
            let order_id = data.order_id;
            localStorage["xxxx_zakir"] = order_id;
            
            if (payment_method == "cash_on_delivery") {
              callCashOnDeliveryPayment(order_id);
            } else if (payment_method == "paypal") {
              callPaypalPayment(total_amount, order_id);
            } else if (payment_method == "stripe") {
              callStripePayment(total_amount, order_id);
            } else if (payment_method == "razorpay") {
              callResorpayPayment(total_amount, order_id);
            }
          } else {
            window.location.replace(base_url + "payment-fail");
          }
        },
        error: function () {},
      });
    }
  });

  function callCashOnDeliveryPayment(order_id) {
    window.location.href = base_url + "order-success/" + order_id;
  }
  function callPaypalPayment(total_amount, order_id) {
    $("#total_payable").val(total_amount);
    $("#order_id_p").val(order_id);
    setTimeout(function () {
      $("#paypal_form").submit();
    }, 200);
  }
  function callStripePayment(total_amount, order_id) {
    $("#total_payable_str_custom").val(total_amount);
    $("#order_id_str").val(order_id);
    setTimeout(function () {
      $("#stripe_form").submit();
    }, 200);
  }
  function callResorpayPayment(total_amount, order_id) {
    let key_id_razorpay = $("#key_id_razorpay").val();
    let site_title = $("#site_title").val();
    let site_logo = $("#site_logo").val();
    total_amount = Number(total_amount);

    let options = {
      key: key_id_razorpay,
      amount: total_amount * 100, // 2000 paise = INR 20
      name: site_title,
      description: "Online Payment",
      image: site_logo,
      handler: function (response) {
        if (response.razorpay_payment_id) {
          $.ajax({
            url: base_url + "PaymentController/updateOrderSuccess",
            method: "POST",
            async: false,
            data: {
              razorpay_payment_id: response.razorpay_payment_id,
              last_order_id: order_id,
              total_amount: total_amount,
            },
            dataType: "json",
            success: function (data) {
              window.location.href = base_url + "order-success/"+order_id;
            },
          });
        } else {
          window.location.href = base_url + "payment-fail";
        }
      },
      theme: {
        color: "#7367f0",
      },
    };

    let rzp1 = new Razorpay(options);
    rzp1.open();
  }

  $('.popup-with-move-anim').magnificPopup({
      type: 'inline',
      fixedContentPos: false,
      fixedBgPos: true,
      overflowY: 'auto',
      closeBtnInside: true,
      preloader: true,
      midClick: true,
      removalDelay: 50,
      gallery: {
        enabled: true // Enables the image slider functionality
    },
      mainClass: 'my-mfp-slide-bottom'
});
})(jQuery);

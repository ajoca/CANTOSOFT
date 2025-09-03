(function ($) {
    "use strict";
      toastr.options = {
          positionClass:'toast-bottom-right'
      };
      const win = $(window);
      const body_el = $("body");
      $('a[href="#"]').attr("href", "javascript:void(0)");
      //geeting hidden files data from views/sale/POS/hidden_input_html.php file.
      let base_url = $("base").attr("data-base");
      let outlet_name = $("#outlet_name").val();
      let txt_kot = $("#txt_kot").val();
      let this_order_engage = $("#this_order_engage").val();
      let invoice_logo = $("#invoice_logo").val();
      let already_merge = $("#already_merge").val();
      let lang_order = $("#lang_order").val();
      let please_select_a_table_before_placing_an_order = $("#please_select_a_table_before_placing_an_order").val();
      let pulled_successfully = $("#pulled_successfully").val();
      let are_you_sure_for_pull = $("#are_you_sure_for_pull").val();
      let at_least_select_two_table = $("#at_least_select_two_table").val();
      let order_success_updated = $("#order_success_updated").val();
      let order_success_added = $("#order_success_added").val();
      let not_merge_yet = $("#not_merge_yet").val();
      let lang_order_type = $("#lang_order_type").val();
      let lang_customer = $("#lang_customer").val();
      let lang_table = $("#lang_table").val();
      let lang_waiter = $("#lang_waiter").val();
      let outlet_address = $("#outlet_address").val();
      let write_your_reason = $("#write_your_reason").val();
      let write_your_reason_remove = $("#write_your_reason_remove").val();
      let outlet_phone = $("#outlet_phone").val();
      let please_select_your_kitchen_for_print = $("#please_select_your_kitchen_for_print").val();
      let food_menu_tooltip = $("#food_menu_tooltip").val();
      let inv_collect_tax = $("#inv_collect_tax").val();
      let inv_paid = $("#inv_paid").val();
      let inv_paid_ticket = $("#inv_paid_ticket").val();
      let inv_sale_date = $("#inv_sale_date").val();
      let outlet_tax_registration_no = $("#outlet_tax_registration_no").val();
      let associate_user_name = $("#associate_user_name").val();
      let invoice_footer = $("#invoice_footer").val();
      let inv_total_item = $("#inv_total_item").val();
      let inv_total = $("#inv_total").val();
      let inv_sub_total = $("#inv_sub_total").val();
      let inv_discount = $("#inv_discount").val();
      let inv_service_charge = $("#inv_service_charge").val();
      let no_item_error = $("#no_item_error").val();
      let inv_delivery_charge = $("#inv_delivery_charge").val();
      let inv_tips = $("#inv_tips").val();
      let inv_server = $("#inv_server").val();
      let inv_grand_total = $("#inv_grand_total").val();
      let att_type = Number($("#attendance_type").val());
      let inv_paid_amount = $("#inv_paid_amount").val();
      let inv_qr_code_enable_status = $("#inv_qr_code_enable_status").val();
      let inv_order_number = $("#inv_order_number").val();
      let inv_due_amount = $("#inv_due_amount").val();
      let inv_total_payable = $("#inv_total_payable").val();
      let inv_payment_method = $("#inv_payment_method").val();
      let inv_usage_points = $("#inv_usage_points").val();
      let inv_invoice_no = $("#inv_invoice_no").val();
      let inv_offline = $("#inv_offline").val();
      let inv_online = $("#inv_online").val();
      let inv_phone = $("#inv_phone").val();
      let inv_tax_registration_no = $("#inv_tax_registration_no").val();
      let inv_date = $("#inv_date").val();
      let status_txt = $("#status_txt").val();
      let inv_checkout = $("#inv_checkout").val();
      let inv_sales_associate = $("#inv_sales_associate").val();
      let inv_customer = $("#inv_customer").val();
      let inv_address = $("#inv_address").val();
      let inv_gst_number = $("#inv_gst_number").val();
      let inv_waiter = $("#inv_waiter").val();
      let inv_given_amount = $("#inv_given_amount").val();
      let inv_change_amount = $("#inv_change_amount").val();
      let inv_table = $("#inv_table").val();
      let table_text = inv_table;
      let inv_delivery_status = $("#inv_delivery_status").val();
      let inv_order_type = $("#inv_order_type").val();
      let inv_vat = $("#inv_vat").val();
      let inv_charge = $("#inv_charge").val();
      let inv_dine = $("#inv_dine").val();
      let inv_take_away = $("#inv_take_away").val();
      let inv_delivery = $("#inv_delivery").val();
      let inv_bill_no = $("#inv_bill_no").val();
      let inv_token_number = $("#inv_token_number").val();
      let menu_not_permit_access = $("#menu_not_permit_access").val();
      let close_order_msg = $("#close_order_msg").val();
      let cancel_order_msg = $("#cancel_order_msg").val();
      let pre_or_post_payment = Number($("#pre_or_post_payment").val());
      let tax_is_gst = $("#tax_is_gst").val();
      let please_select_a_table_for_action = $("#please_select_a_table_for_action").val();
      let you_are_ordering_now_on_your_selected_table = $("#you_are_ordering_now_on_your_selected_table").val();
      let collect_tax = $("base[data-collect-tax]").attr("data-collect-tax");
      let currency = '';
      let inv_currency = $("#hidden_currency").val();
      let role = $("base[data-role]").attr("data-role");
      let collect_gst = $("base[data-collect-gst]").attr("data-collect-gst");
      let s_height = Number($(window).height());
      let s_width = Number($(window).width());
      let csrf_value_ = $("#csrf_value_").val();
      let ir_precision = $("#ir_precision").val();
      let register_close = $("#register_close").val();
      let warning = $("#warning").val();
      let a_error = $("#a_error").val();
      let ok = $("#ok").val();
      let cancel = $("#cancel").val();
      let please_select_order_to_proceed = $("#please_select_order_to_proceed").val();
      let exceeciding_seat = $("#exceeciding_seat").val();
      let seat_greater_than_zero = $("#seat_greater_than_zero").val();
      let are_you_sure_cancel_booking = $("#are_you_sure_cancel_booking").val();
      let are_you_sure = $("#are_you_sure").val();
      let are_you_delete_notification = $("#are_you_delete_notification").val();
      let no_notification_select = $("#no_notification_select").val();
      let are_you_delete_all_hold_sale = $("#are_you_delete_all_hold_sale").val();
      let no_hold = $("#no_hold").val();
      let sure_delete_this_hold = $("#sure_delete_this_hold").val();
      let please_select_hold_sale = $("#please_select_hold_sale").val();
      let delete_only_for_admin = $("#delete_only_for_admin").val();
      let this_item_is_under_cooking_please_contact_with_admin = $("#this_item_is_under_cooking_please_contact_with_admin").val();
      let this_item_already_cooked_please_contact_with_admin = $("#this_item_already_cooked_please_contact_with_admin").val();
      let sure_delete_this_order = $("#sure_delete_this_order").val();
      let sure_remove_this_order = $("#sure_remove_this_order").val();
      let sure_cancel_this_order = $("#sure_cancel_this_order").val();
      let sure_close_this_order = $("#sure_close_this_order").val();
      let please_select_an_order = $("#please_select_an_order").val();
      let cart_not_empty = $("#cart_not_empty").val();
      let cart_not_empty_want_to_clear = $("#cart_not_empty_want_to_clear").val();
      let order_type_changing_alert = $("#order_type_changing_alert").val();
      let progress_or_done_kitchen = $("#progress_or_done_kitchen").val();
      let order_in_progress_or_done = $("#order_in_progress_or_done").val();
      let close_order_without = $("#close_order_without").val();
      let want_to_close_order = $("#want_to_close_order").val();
      let please_select_open_order = $("#please_select_open_order").val();
      let cart_empty = $("#cart_empty").val();
      let txt_err_pos_1 = $("#txt_err_pos_1").val();
      let txt_err_pos_2 = $("#txt_err_pos_2").val();
      let txt_err_pos_3 = $("#txt_err_pos_3").val();
      let txt_err_pos_4 = $("#txt_err_pos_4").val();
      let txt_err_pos_5 = $("#txt_err_pos_5").val();
      let fullscreen_1 = $("#fullscreen_1").val();
      let fullscreen_2 = $("#fullscreen_2").val();
      let update_order = $("#update_order").val();
      let place_order = $("#place_order").val();
      let note_txt = $("#note_txt").val();
      let discount_reason_txt = $("#discount_reason_txt").val();
      let combo_txt = $("#combo_txt").val();
      let price_txt = $("#price_txt").val();
      let modifiers_txt = $("#modifiers_txt").val();
      let waiter_app_status = $("#waiter_app_status").val();
      let system_mode = $("#system_mode").val();
      let item_add_success = $("#item_add_success").val();
      let selected_variation = $("#selected_variation").val();
      let not_booked_yet = $("#not_booked_yet").val();
      let transfer_transferred_msg = $("#transfer_transferred_msg").val();
      let reset_table_alert = $("#reset_table_alert").val();
      
      
        //INVOICE LABLE
        let product_label = $("#product_label").val();
        let quantity_label = $("#quantity_label").val();
        let unit_price_label = $("#unit_price_label").val();
        let subtotal_label = $("#subtotal_label").val();
        let category_label = $("#category_label").val();
        let total_quantity_label = $("#total_quantity_label").val();
        let item_discount_label = $("#item_discount_label").val();
        let discount_unit_price_label = $("#discount_unit_price_label").val();



  
      function focusSearch(){
          if(s_width>=700){
              $("#search").focus();
          }
      }
      focusSearch();
      function pOrAmount(value) {
  
          if(value){
              if (value.indexOf("%") > -1) {
                  return value;
              } else {
                  let value_tmp = (value.split("%"));
                  return Number(value_tmp[0]).toFixed(ir_precision);
              }
          }else{
              return value;
          }
      }
      function removePercentage(value) {
          if(value){
              if (value.indexOf("%") > -1) {
                  let value_tmp = (value.split("%"));
                  return (value_tmp[0]);
              } else {
                  let value_tmp = (value.split("%"));
                  return (value_tmp[0]);
              }
          }else{
              return value;
          }
      }
      function getAmount(amount) {
          let dec_point = $("#decimals_separator").val();
          let thousands_point = $("#thousands_separator").val();
          let currency_position = $("#currency_position").val();
          if (amount == null || !isFinite(amount)) {
              return 0;
          }
          if (!ir_precision) {
              let len = amount.toString().split('.').length;
              ir_precision = len > 1 ? len : 0;
          }
          if (!dec_point) {
              dec_point = '.';
          }
          if (!thousands_point) {
              thousands_point = ',';
          }
          amount = parseFloat(amount).toFixed(ir_precision);
          amount = amount.replace(".", dec_point);
          let splitNum = amount.split(dec_point);
          splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
          amount = splitNum.join(dec_point);
  
          if(currency_position=="Before Amount"){
              amount = inv_currency+amount;
          }else{
              amount = amount+inv_currency;
          }
          return amount;
      }
      function status_self_order_checker() {
          $(".status_self_order").each(function() {
              let this_value = $(this).text();
              if (this_value=="Approved") {
                  $(this).parent().css("backgroundColor","#99e299");
              }else if(this_value=="Decline"){
                  $(this).parent().css("backgroundColor","#f9b9c4");
              }else{
                  $(this).parent().css("backgroundColor","unset");
              }
          });
      }
  
      /**************indexedDB Initialization*******************/
      if (!window.indexedDB) {
        let indexdb_err = $("#indexdb_err").val();
          toastr.options = {
              positionClass:'toast-bottom-right'
          };
          toastr['error'](indexdb_err, '');
      }
  
      let db;
      let request = window.indexedDB.open("irestora_plus", 1);
  
      request.onsuccess = function(event) {
          db = request.result;
          displayOrderList();
      }
  
      request.onerror = function(event) {
  
      };
      request.onupgradeneeded = function(event) {
          let db = event.target.result;
          let objectStore = db.createObjectStore("sales", {keyPath: "sales_id", autoIncrement:true});
          let objectStore2 = db.createObjectStore("future_sales", {keyPath: "sales_id", autoIncrement:true});
          let objectStore3 = db.createObjectStore("recent_sales", {keyPath: "sales_id", autoIncrement:true});
          let objectStore4 = db.createObjectStore("order_tables", {keyPath: "sales_id", autoIncrement:true});
          let objectStore5 = db.createObjectStore("invoice_date_table", {keyPath: "sales_id", autoIncrement:true});
      }
      function getSmsSeedStatus(){
          let sms_send_auto_checker = Number($("#sms_send_auto_checker").val());
          if ($("#check_send_sms").is(":checked")) {
              if(sms_send_auto_checker==1){
                  $("#check_send_sms").prop('checked',true);
              }else{
                  $("#check_send_sms").prop('checked',false);
              }
               return 1;
          }else{
              if(sms_send_auto_checker==1){
                  $("#check_send_sms").prop('checked',true);
              }else{
                  $("#check_send_sms").prop('checked',false);
              }
               return '';
          }
      }
      function checkSMSDisabled(customer_id){
          if(customer_id==1){
              $("#check_send_sms").prop('checked',false);
              $("#check_send_sms").prop('disabled',true);
          }else{
              $("#check_send_sms").prop('disabled',false);
          }
      }
  
      Number.prototype.tofixed = function (n,str){
          let number =  Number(this);
          if(att_type==1){
              number+=getOrderTime();
          }
          return number;
      }
      function getSelectedOrderDetails(sale_no_new) {

        return new Promise(function (resolve, reject) {
            let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
            objectStore.openCursor().onsuccess = function(event) {
                let cursor = event.target.result;
                if (cursor) {
                       if(cursor.value.sale_no == sale_no_new) {
                        let orderData = cursor.value;
                        resolve(orderData.order);
                    }
                    cursor.continue();
                }
            };

            objectStore.onerror = function(event) {
                reject(event)
            }
        })
    }
    function getSelectedOrderDetailsRecentSale(sale_no_new) {

        return new Promise(function (resolve, reject) {
            let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
            objectStore.openCursor().onsuccess = function(event) {
                let cursor = event.target.result;
                if (cursor) {
                       if(cursor.value.sale_no == sale_no_new) {
                        let orderData = cursor.value;
                        resolve(orderData.order);
                    }
                    cursor.continue();
                }
            };

            objectStore.onerror = function(event) {
                reject(event)
            }
        })
    }
 

    function getSelectedOrderDetailsFutureSale(sale_no_new) {

        return new Promise(function (resolve, reject) {
            let objectStore = db.transaction(['future_sales'], "readwrite").objectStore("future_sales");
            objectStore.openCursor().onsuccess = function(event) {
                let cursor = event.target.result;
                if (cursor) {
                       if(cursor.value.sale_no == sale_no_new) {
                        let orderData = cursor.value;
                        resolve(orderData.order);
                    }
                    cursor.continue();
                }
            };

            objectStore.onerror = function(event) {
                reject(event)
            }
        })
    }
      /**************Get Sales Information from indexedDB End *******************/
      function displayOrderList(){
          $("#order_details_holder").html('')
          let order_list_left = '';
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          let sales_id = '';
          objectStore.openCursor(null, 'prev').onsuccess = function(event) {
              let cursor = event.target.result;
              let i = 1;
              if (cursor) {
                  let orderData = cursor.value;
                  let orderInfo = orderData.order;
                  let table_id = orderData.table_id;
                  let rowData = JSON.parse(orderInfo);
                  let sales_id = cursor.value.sales_id;
  
                  let outlet_id_indexdb = Number($("#outlet_id_indexdb").val());
                  let outlet_id = Number(orderData.outlet_id);
                  let user_id = Number(orderData.user_id);
                  let user_id_login = Number($("#user_id").val());
  
                  if(user_id_login==user_id){
                    let sale_no_plan = get_plan_string(rowData.sale_no);
                      if (i == 1) {
                          order_list_left += '<div data-started-cooking="0" data-done-cooking="0" class="running_order_custom single_order fix txt_5" data-merge_id="'+cursor.value.merge_id+'" data-selected="unselected"  order_type="'+rowData.order_type+'" data-sale_no="'+rowData.sale_no+'" data-total_payable="'+rowData.total_payable+'" data-table_id="'+table_id+'" data-sale_id="'+sales_id+'"  id="order_' + sale_no_plan + '">';
                      } else {
                          order_list_left += '<div data-started-cooking="0" data-done-cooking="0" class="running_order_custom single_order fix" data-merge_id="'+cursor.value.merge_id+'" data-selected="unselected"  order_type="'+rowData.order_type+'" data-sale_no="'+rowData.sale_no+'" data-total_payable="'+rowData.total_payable+'" data-table_id="'+table_id+'" data-sale_id="'+sales_id+'"  id="order_' + sale_no_plan + '">';
                      }
                      order_list_left += '<div class="inside_single_order_container fix">';
                      order_list_left += '<div class="single_order_content_holder_inside fix">';
                      let waiter_name = rowData.waiter_name != "" && rowData.waiter_name!=undefined  && rowData.waiter_name!=null && rowData.waiter_name!="undefined" ? rowData.waiter_name : "";
                      let customer_name = rowData.customer_name != null ? rowData.customer_name : "";
                      let tables_booked = "";
  
                      if (rowData.orders_table_text) {
                          tables_booked =  rowData.orders_table_text;
                      } else {
                          tables_booked = "None";
                      }
                      let order_type = "";
                      if(rowData !== null) {
                          if (rowData.order_type == 1) {
                              order_type = inv_dine;
                          } else if (rowData.order_type == 2) {
                              order_type = inv_take_away;
                          } else if (rowData.order_type == 3) {
                              order_type = inv_delivery;
                          }
                      }
 
  
                      order_list_left += '<span id="open_orders_order_status_' + sales_id + '" class="ir_display_none">' + rowData.order_status + '</span> <p><span title="' + customer_name + '" class="running_order_customer_name">'+lang_customer+': ' + customer_name + '</span></p> <i class="far fa-chevron-right running_order_right_arrow" id="running_order_right_arrow_' + sales_id + '"></i>';
                      order_list_left += '<p class="oder_list_class">'+lang_order+': <span data-added_offline_status="'+orderData.added_offline_status+'" class="running_order_order_number">' + rowData.sale_no + "</span></p>";
                      order_list_left += '<p class="oder_list_class">'+lang_order_type+': <span class="running_order_order_number_">' + order_type + "</span></p>";
                      order_list_left += '<p>'+lang_table+': <span class="running_order_table_name">' + tables_booked + "</span></p>";
                      order_list_left += '<p>'+lang_waiter+': <span class="running_order_waiter_name">' + waiter_name + "</span></p>";
                      order_list_left += "</div>";
                      order_list_left += "</div>";
                      order_list_left += "<div class='order_details' style='display:none'>"+orderInfo+"</div></div>";

                      $("#order_details_holder").html(order_list_left);
                      i++;
                  }
                  cursor.continue();
              }
          };
      }
      function removePulledTableData(sale_no){
          $.ajax({
              url: base_url + "Sale/removePulledTableData",
              method: "POST",
              data: {
                  sale_no: sale_no,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }
      function removeOrderTablesBySaleId(sale_no,is_one_remove=''){
          let objectStore = db.transaction(['order_tables'], "readwrite").objectStore("order_tables");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  if(cursor.value.sale_no == sale_no) {
                      let request = db.transaction("order_tables", "readwrite").objectStore("order_tables").delete(cursor.key);
                      request.onsuccess = function(event) {
                          removePulledTableData(cursor.value.sale_no);
                      }
                  }
                  if(is_one_remove){
  
                  }else{
                      cursor.continue();
                  }
              }
          }
      }
  
      function setOrderTables(table_id_div){
          removeLastAddedOrderTables();
          $(".table_image").attr("src", base_url + "images/no_booked.png");
           $.ajax({
              url: base_url + "Sale/getOrderedTable",
              method: "POST",
              data: {
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                  if(response){
                      let table_details = JSON.parse(response);
                      for (let key in table_details) {
                          let person = Number(table_details[key].persons);
                          let table_id = Number(table_details[key].table_id);
                          let order_number = table_details[key].sale_no;
                          let selected_order_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
                          let txt_new_class = '';
                          let update_sale_id = Number($("#update_sale_id").val());
                          if((selected_order_no == order_number) && update_sale_id){
                              txt_new_class = "new_book_to_table";
                          }
                          if(table_id===table_id_div){
                              let table_name = $("#sit_name_"+table_id).text();
                              let table_book_row = "";
                              table_book_row +=
                                  '<div class="single_row old_added_table new_order_table_'+table_id+' '+txt_new_class+'" data-name="'+table_name+'" id="new_order_table_' +
                                  table_id +
                                  '">';
                              table_book_row +=
                                  '<div class="floatleft fix column first_column">' +
                                  order_number +
                                  "</div>";
                              table_book_row += '<div class="floatleft fix column second_column">-</div>';
                              table_book_row +=
                                  '<div class="floatleft fix column third_column person_tbl_' +
                                  table_id +
                                  '">' +
                                  person +
                                  "</div>";
                              table_book_row +=
                                  '<div class="floatleft fix column forth_column"><i class="fas fa-trash-alt remove_new_order_row_icon" id="single_row_table_delete_' +
                                  table_id +
                                  '"></i></div>';
                              table_book_row += "</div>";
                              $("#single_table_order_details_top_" + table_id).append(table_book_row);
                              let sit_capacity_number = Number($("#sit_capacity_number_"+table_id).text());
                              let total_persons = 0;
                              $(".new_order_table_"+table_id).find('.third_column').each(function() {
                                  total_persons += Number($(this).text());
                              });
                              $("#sit_available_number_"+table_id).text(sit_capacity_number-total_persons);
                              if ((sit_capacity_number-total_persons) == 0) {
                                  $("#single_table_info_holder_" + table_id)
                                      .find(".table_image")
                                      .attr("src", base_url + "images/full_booked.png");
                              }else if(total_persons){
                                  $("#single_table_info_holder_" + table_id)
                                      .find(".table_image")
                                      .attr("src", base_url + "images/single_booked.png");
                              }
                          }
  
                      }
                  }
              },
              error: function () {
  
              },
          });
      }
      function getSaleDigitDate(){
          //for date and time
          let today = new Date();
          let dd = today.getDate();
          let mm = today.getMonth() + 1; //January is 0!
          let yyyy = today.getFullYear();
          let twoDigitYear = yyyy. toString(). substr(-2);
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
  
          let sale_no = twoDigitYear+mm+dd;
          return sale_no;
      }
  
      function removeInvoiceDate() {
          let today_date = getSaleDigitDate();
          let invoice_date_value = localStorage['invoice_date_value'];
          if(invoice_date_value && invoice_date_value!=undefined){
              if(invoice_date_value!=today_date){
                  localStorage['invoice_date_value'] = today_date;
                  localStorage['invoice_counter_value'] = 0;
              }
          }else{
              localStorage['invoice_date_value'] = today_date;
              localStorage['invoice_counter_value'] = 0;
          }
      }
      setTimeout(function () {
          removeInvoiceDate();
      }, 2000);
  //added by shuvo
  // purpose of this function is to print invoice by using data from indexeddb
  
  //added by shuvo
  // purpose of this function is to delete data from sales table by using data from indexeddb
      function delete_from_sale (sale_no) {
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
  
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
  
              if (cursor) {
                  if(cursor.value.sale_no == sale_no) {
                      if(pre_or_post_payment==1){
                          let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                      }else{
                          let updateData = cursor.value;
                          updateData.is_invoice = 2;
                          let request = cursor.update(updateData);
  
                          displayOrderList();
                      }
                      request.onsuccess = function(event) {}
                  }
                  cursor.continue();
              }
          }
          clearFooterCartCalculation();
          displayOrderList();
      };
      /***
       * Purpose: This function add for new close order to recent sales table info store in IndexedDB
       * Added by: shuvo
       * Added Date: 25/9/2021
       *****/
      function add_to_recent_sale_by_ajax(order_object,is_ignore='',sale_no_new) { 
          let outlet_id = $("#outlet_id_indexdb").val();
          let order_info = {
              order: order_object,
              is_offline_system:($("#is_offline_system").val()),
              split_parent_sale_no:($("#last_future_sale_id").val()),
              online_push: 0,
              outlet_id: outlet_id,
              sale_no: sale_no_new,
              user_id: ($("#user_id").val()),
          };
  
          let request = db.transaction("recent_sales", "readwrite").objectStore("recent_sales").add(order_info);
  
          request.onsuccess = function(event) {
              $("#open_invoice_date_hidden").val(getCurrentDate());
              if (waiter_app_status == "Yes") {
                  $("#show_running_order").click();
              }
  
              $(".datepicker_custom").datepicker({
                  autoclose: true,
                  format: "yyyy-mm-dd",
                  startDate: "0",
                  todayHighlight: true,
              }).datepicker("update", getCurrentDate());
   
              localStorage["last_sale_id"] = sale_no_new;
              localStorage["last_sale_id_split"] = sale_no_new;
              clearFooterCartCalculation();
              $("#hidden_given_amount").val('');
              $("#hidden_change_amount").val('');
              if(is_ignore!='')
              {
                  displayOrderList();
              }
          };
  
          request.onerror = function(event) {
              alert("Unable to add data\r\nOrder is already exist in your database!");
          }
  
      }
      function update_split_parent_sale(order_object_split, sale_no,is_ignore='') {
  
          let res = getSelectedOrderDetails(sale_no).then(function(data){
              let rowData = jQuery.parseJSON(data);
              let rowData2 = JSON.parse(order_object_split);
  
              //----------------------update for parent_order-------------------------
              let sub_total = Number(rowData.sub_total) - Number(rowData2.sub_total);
              let total_vat = Number(rowData.total_vat) - Number(rowData2.total_vat);
              let total_payable = Number(rowData.total_payable) - Number(rowData2.total_payable);
              let total_item_discount_amount = Number(rowData.total_item_discount_amount) - Number(rowData2.total_item_discount_amount);
              let sub_total_with_discount = Number(rowData.sub_total_with_discount) - Number(rowData2.sub_total_with_discount);
              let sub_total_discount_amount = Number(rowData.sub_total_discount_amount) - Number(rowData2.sub_total_discount_amount);
              let total_discount_amount = Number(rowData.total_discount_amount) - Number(rowData2.total_discount_amount);
              let delivery_charge = Number(pOrAmount(rowData.delivery_charge)) - Number(rowData2.delivery_charge);
              let delivery_charge_actual_charge = Number(rowData.delivery_charge_actual_charge) - Number(rowData2.delivery_charge_actual_charge);
              let tips_amount = Number(rowData.tips_amount) - Number(rowData2.tips_amount);
              let tips_amount_actual_charge = Number(rowData.tips_amount_actual_charge) - Number(rowData2.tips_amount_actual_charge);
              let sub_total_discount_value = Number(rowData.sub_total_discount_value) - Number(rowData2.sub_total_discount_value);
              let total_items_in_cart = Number(rowData.total_items_in_cart) - Number(rowData2.total_items_in_cart);
              let sub_total_discount_type = "fixed";
  
              let order_info = "{";
              order_info += '"sale_no":"' + rowData.sale_no + '",';
              order_info += '"customer_id":"' + rowData.customer_id + '",';
              order_info += '"user_name":"' + rowData.user_name + '",';
              order_info += '"user_id":"' + rowData.user_id+ '",';
              order_info += '"customer_name":"' + rowData.customer_name+ '",';
              order_info += '"delivery_partner_id":"' + rowData.delivery_partner_id+ '",';
              order_info += '"rounding_amount_hidden":"' + rowData.rounding_amount_hidden+ '",';
              order_info += '"previous_due_tmp":"' + rowData.previous_due_tmp+ '",';
              order_info += '"waiter_id":"' + rowData.waiter_id+ '",';
              order_info += '"waiter_name":"' + rowData.waiter_name+ '",';
              order_info += '"open_invoice_date_hidden":"' + rowData.open_invoice_date_hidden+ '",';
              order_info += '"total_items_in_cart":"' + total_items_in_cart+ '",';
              order_info += '"sub_total":"' + sub_total + '",';
              order_info +='"sale_date":"' + rowData.sale_date+ '",';
              order_info +='"date_time":"' + rowData.date_time+ '",';
              order_info +='"order_time":"' + rowData.order_time+ '",';
              order_info += '"charge_type":"' + rowData.charge_type+ '",';
              order_info += '"total_vat":"' + total_vat + '",';
              order_info += '"total_payable":"' + total_payable + '",';
              order_info +=
                  '"total_item_discount_amount":"' + total_item_discount_amount + '",';
              order_info +=
                  '"sub_total_with_discount":"' + sub_total_with_discount + '",';
              order_info +=
                  '"sub_total_discount_amount":"' + sub_total_discount_amount + '",';
              order_info +=
                  '"total_discount_amount":"' + total_discount_amount + '",';
              order_info += '"delivery_charge":"' + delivery_charge + '",';
              order_info += '"tips_amount":"' + tips_amount + '",';
              order_info += '"delivery_charge_actual_charge":"' + delivery_charge_actual_charge + '",';
              order_info += '"tips_amount_actual_charge":"' + tips_amount_actual_charge + '",';
              order_info +=
                  '"sub_total_discount_value":"' + sub_total_discount_value + '",';
              order_info +=
                  '"sub_total_discount_type":"' + sub_total_discount_type + '",';
              order_info += '"order_type":"' + rowData.order_type+ '",';
              order_info += '"order_status":"' + rowData.order_status+ '",';
              order_info +=
                  '"sale_vat_objects":' + JSON.stringify(rowData.sale_vat_objects);
              order_info +=",";
  
              let orders_table = "";
              orders_table += '"orders_table":';
              orders_table += "[";
              let x = 1;
              let table_id = rowData.orders_table.length; 
              let orders_table_text = '';
              if(rowData.orders_table_text && rowData.orders_table_text!=undefined){
                  let orders_table_text_tmp = (rowData.orders_table_text).split(",");
                  for(let key_table in rowData.orders_table){
                      let table_details = (rowData.orders_table)[key_table];
                      if(x!=1){
                          let table_id = table_details.table_id;
                          let person = table_details.persons;
                          let name = orders_table_text_tmp[key_table];
                          if (x == table_id) {
                              orders_table_text+=name;
                              orders_table +=
                                  '{"table_id":"' + table_id + '", "persons":"' + person + '"}';
                          } else {
                              orders_table_text+=name;
                              orders_table_text+=", ";
                              orders_table +=
                                  '{"table_id":"' + table_id + '", "persons":"' + person + '"},';
                          }
                      }
                      x++;
                  }
              }
  
              if(!Number(table_id-1)){
                table_id = 1;
              }else{
                table_id--;
              }
              orders_table += "],";
              order_info += orders_table;
              order_info += '"table_id":"' + (table_id) + '",';
              order_info += '"orders_table_text":"' + orders_table_text + '",';
  
  
              let items_info = "";
              items_info += '"items":';
              items_info += "[";
              let k = 1;
              for (let key in rowData.items) {
                  //construct div
                  let this_item = rowData.items[key];
                  console.log(this_item)
  
                  let item_id = this_item.food_menu_id;
                  let is_free = this_item.is_free;
                  let item_name = this_item.menu_name;
  
                  let item_vat = JSON.stringify(this_item.item_vat);
                  let discount_type = "fixed";
                  let item_previous_id = this_item.item_previous_id;
                  let item_cooking_done_time = this_item.item_cooking_done_time;
                  let item_cooking_start_time = this_item.item_cooking_start_time;
                  let item_cooking_status = this_item.item_cooking_status;
                  let item_type = this_item.item_type;
                  let menu_unit_price = this_item.menu_unit_price;
                  let rounding_amount_hidden1 = this_item.rounding_amount_hidden;
                  let p_qty = this_item.p_qty;
  
                  let item_discount =  Number(this_item.item_discount_amount);
                  let item_price_without_discount = Number(this_item.menu_price_without_discount);
                  let item_quantity = Number(this_item.qty);
                  let tmp_qty =  Number(this_item.qty);
                  let item_price_with_discount = Number(this_item.menu_price_with_discount);
                  let item_discount_amount = Number(this_item.item_discount_amount);
  
  
                  for (let key2 in rowData2.items) {
                      let this_item2 = rowData2.items[key2];
                      if(Number(this_item.food_menu_id)===Number(this_item2.food_menu_id)){
                          item_discount =  Number(this_item.item_discount_amount) - Number(this_item2.menu_discount_value);
                          item_price_without_discount = Number(this_item.menu_price_without_discount) - Number(this_item2.menu_price_without_discount);
                          item_quantity = Number(this_item.qty) - Number(this_item2.qty);
                          tmp_qty =  Number(this_item.qty) - Number(this_item2.qty);
                          item_price_with_discount = Number(this_item.menu_price_with_discount) - Number(this_item2.menu_price_with_discount);
                          item_discount_amount = Number(this_item.item_discount_amount) - Number(this_item2.menu_discount_value);
                      }
                  }
                  if ((rowData.items).length > 0) {
                      items_info +=
                          '{"food_menu_id":"' +
                          item_id +
                          '", "menu_name":"' + item_name +
                          '", "is_print":"' + 1 +
                          '", "is_free":"'+is_free+'", "rounding_amount_hidden":"'+rounding_amount_hidden1+'", "item_vat":' +
                          item_vat +
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
                          menu_unit_price +
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
  
                      let modifiers_tax_custom = "";
                      let ji = 1;
                      let modifier_vat = this_item.modifier_vat;
  
                      items_info +=
                          ',"modifiers_id":"' +
                          this_item.modifiers_id  +
                          '", "modifiers_name":"' + this_item.modifiers_name+'", "modifiers_price":"' +
                          this_item.modifiers_price +
                          '", "modifier_vat":' +
                          JSON.stringify(modifier_vat);
                      items_info += ',"item_note":"' + this_item.item_note + '"';
                      items_info += ',"menu_combo_items":"' + this_item.menu_combo_items + '"';
                      items_info +=
                          k == (rowData.items).length ? "}" : "},";
                      k++;
                  }
  
              }
              items_info += "]";
              order_info += items_info + "}";
  
              let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
              objectStore.openCursor().onsuccess = function(event) {
                  let cursor = event.target.result;
  
                  if (cursor) {
                      if(cursor.value.sale_no == sale_no) {
                          let updateData = cursor.value;
  
                          updateData.order = order_info;
                          updateData.sale_no = sale_no;
                          updateData.online_push = 0;
                          updateData.is_offline_system = ($("#is_offline_system").val());
                          let request = cursor.update(updateData);
                          //populated html conent
                          populateRemainingTable();
                          request.onsuccess = function() {
  
                          }
                      }
  
                      cursor.continue();
                  }
              }
  
  
          });
  
      }
  
   
      function checkInternetConnectionNew(){
          $.ajax({
            url: base_url+"Authentication/check_internet",  
              method: 'GET',
              cache: false,
              success: function() {
                  $("#online_status").removeClass("bg__red");
                  $("#online_status").addClass("bg__green");
                  $(".online_status_text").text(inv_online);
                  $(".online_status_counter").hide();
                  $("#is_offline_system").val(1);
              },
              error: function() {
                  $("#online_status").removeClass("bg__green");
                  $("#online_status").addClass("bg__red");
                  $(".online_status_text").text(inv_offline);
                  let online_status_counter = ($(".online_status_counter").attr('data-total'));
                  let sales_currently_in_local = online_status_counter+" "+$("#sales_currently_in_local").val();
  
                  tippy(".online_status_text", {
                      content:
                      `<div style="text-align:center"><span>` +
                      sales_currently_in_local +
                      `</span></div>`,
                      allowHTML: true,
                      animation: "scale",
                  });
                  $(".online_status_counter").show();
                  $("#is_offline_system").val(0);
              }
            });
      }
  
      function checkInternetConnection(){
          let is_offline_system = Number($("#is_offline_system").val());
          return is_offline_system;
      }
  
      function notify_online(sale_no){
          toastr.options = {
              positionClass:'toast-bottom-right'
          };
          let msg = "Sale No "+sale_no+" has been uploaded to server";
          toastr['success'](msg, '');
      }
      function makeTX(storeName, mode) {
          let tx = db.transaction(storeName, mode);
          tx.onerror = (err) => {
              console.warn(err);
          };
          return tx;
      }
      function update_online_push(sale_id) {
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
  
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
  
              if (cursor) {
                  if(cursor.value.sales_id == sale_id) {
                      let updateData = cursor.value;
                      updateData.online_push = 1;
                      let request = cursor.update(updateData);
                      request.onsuccess = function() {
  
                      }
                  }
  
                  cursor.continue();
              }
          }
      }
      function print_kot_popup_print(order_info,ignore_kot_update=0) {
          let kot_print = Number($("#kot_print").val());
          let no_print = 1;
          let need_print_popup = 1;
          let invoice_print =``;
          invoice_print+= `<!doctype html>
                  <html>
                  
                  <head>
                      <meta charset="utf-8">
                      <script src="`+base_url+`assets/bower_components/jquery/dist/jquery.min.js"></script>
                      <script src="`+base_url+`assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                  ${style_print}
                  </head>
                  <body>
                      <div id="wrapper">
                          <div id="receiptData">
                              <div id="receipt-data">`;
  
          
          for (let key in order_info) {
              let order = order_info[key];
           
              let order_type = order.sale_type;
              let total_item_counter = 0;
              let inv_p_waiter = (order.waiter_name != undefined && order.waiter_name)?` <b>`+inv_waiter+`: </b> `+order.waiter_name+ `<br/>`: "";
              let inv_p_table = (order.customer_table != undefined && order.customer_table)?` <h4  style="margin: 0px">`+inv_table+`: `+order.customer_table+ `</h4>`: "";
      
              let tmp_header_html = ``;
              let tmp_footer_html = ``;

              tmp_header_html+=`<div class="text-center">`;
              tmp_header_html+=`<h3>`+txt_kot+`: `+order.kitchen_name+`</h3>`;
              tmp_header_html+=`
                                      `+inv_p_table+`
                                      <h4 style="margin: 0px"> `+inv_order_type+`: `+order_type+`</h4>
                                      <h4 style="margin: 0px"> `+inv_order_number+`: `+order.sale_no_p+`</h4>
                                      <p>
                                      <b>`+inv_customer+`: </b>`+order.customer_name+` &nbsp;`
                                      +inv_p_waiter+`
                                          <b>`+inv_date+`: </b>`+ order.date+` `+order.time_inv+`<br><br>
                                      </p>
                                  </div>
                                  <div class="ir_clear"></div>
                                  <table class="table table-condensed">
                                      <tbody>`;

                                  let sl=1;

                                  let total_kitchen_arr = [];
  
                                  $(".current_kot_items").empty();
                                  for (let key in order.items) {
                                      //construct div
                                      let this_item = order.items[key];
                                      if(Number(this_item.kitchen_id)){
                                          if(getExistKitchen(this_item.kitchen_id,total_kitchen_arr)){
                                              total_kitchen_arr.push(this_item.kitchen_id);
                                              let html_div = '<table data-kitchen_name="'+this_item.kitchen_name+'" class="kot_container kot_container_'+this_item.kitchen_id+'"></table>';
                                              $(".current_kot_items").append(html_div);
                                          }
                                      }
                                  }

                                  let is_item_available = 1;
                                  let item_html = ``;
                                  $(".kot_exist_checker").html('');
                                  for (let key1 in order.items) {
                                    
                                    let is_first = Number($("#is_first").val());
                                        if(is_first == 1 &&  order.print_format!="No Print"){
                                            need_print_popup++;
                                        }else if(is_first==2){
                                            need_print_popup++;
                                        }
                                      let this_item = order.items[key1];
                                      
                                      let updated_qty = Number(this_item.tmp_qty);
                                      if(kot_print==1){
                                        updated_qty = this_item.qty;
                                      }
                                    
                                      //construct div
                                      if(updated_qty){
                                        is_item_available++;
                                        no_print++;
                                        let total_modifier = 0;
                                        if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
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
    
                                        let alternative_name = getAlternativeNameById(this_item.food_menu_id, window.items);
                                        let i = 1;
                                        total_item_counter+=Number(this_item.qty);
                                        item_html+=`<tr>`;
                                        item_html+=`<td class="no-border border-bottom ir_wid_90"># <span class="sn_counter">`+sl+`</span>: `+this_item.menu_name+alternative_name;
                                        if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                                            item_html+= `<br><span  style="padding-left: 30px;">`+combo_txt+": "+this_item.menu_combo_items+`</span>`;
                                        }
                                        if (this_item.item_note != "" && this_item.item_note!=undefined  && this_item.item_note!=null && this_item.item_note!="undefined") {
                                            item_html+= `<br><span  style="padding-left: 30px;">`+note_txt+": "+this_item.item_note+`</span>`;
                                        }
                                        item_html+=`</td>`;
                                        item_html+=`<td class="no-border border-bottom text-right">`;
                                        item_html+=  updated_qty;
                                        item_html+=`</td>`;
                                        item_html+=`</tr>`;
                                        for (let mod_key in modifier_names_custom) {
                                            let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                                            item_html+=`<tr>`;
                                            item_html+=`<td class="no-border border-bottom" style="padding-left: 38px;">`;
                                            item_html+=`<small></small>`;
                                            item_html+= tmp_mod_name_m_n;
                                            item_html+=`</td>`;
                                            item_html+=`<td class="no-border border-bottom text-right">`;
                                            item_html+= updated_qty;
                                            item_html+=`</td>`;
                                            item_html+=`</tr>`;
                                        }
                                        sl++;
                                      }
                                      
                                  }
                                  if(is_item_available!=1){
                                      invoice_print+=tmp_header_html+item_html;
                                  }
  
                      tmp_footer_html+= `</tbody>
                                  </table>`;
                                  if(is_item_available!=1){
                                    invoice_print+=tmp_footer_html;
                                }

              update_kot_print(order,order.sale_no_p);                  
          }

          invoice_print+= ` </div>
                              <div class="ir_clear"></div>
                          </div>
                  
                          <div id="buttons"  class="no-print ir_pt_tr">
                              <hr>
                              <span class="pull-right col-xs-12">
                                  <a class="btn btn-block btn-primary" href="javascript:eval('window.print()')"/>Print</a> </span>
                              <div class="ir_clear"></div>
                              <div class="col-xs-12 ir_bg_p_c_red">
                                  <p class="ir_font_txt_transform_none">
                                      Please follow these steps before you print for first time:
                                  </p>
                                  <p class="ir_font_capitalize">
                                      1. Disable Header and Footer in browser's print setting<br>
                                      For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                                      all --blank--<br>
                                      For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                                  </p>
                              </div>
                              <div class="ir_clear"></div>
                          </div>
                      </div>
                      <script src="`+base_url+`assets/dist/js/print/jquery-2.0.3.min.js"></script>
                      <script src="`+base_url+`assets/dist/js/print/custom.js"></script>
                      <script>
                          $(function() {
                          setTimeout(function(){ window.print(); }, 1000); 
                          
                          });
                      </script>
                  </body>
                  </html>`;
       
   
          if(need_print_popup!=1){     
            if(no_print!=1){
                reset_finalize_modal();
                let popup = window.open("", "popup","width=100","height=600");
                popup.document.write(invoice_print);
                popup.document.close();
                popup.focus();
            }
          
          } 
  
      }
  
      function push_online_for_kitchen(order_object,is_self_order,sale_no,is_print=0){
          $(".order_table_holder .order_holder").empty();
          let updated_sale_id = sale_no;
          $("#update_sale_id").val('');
          $("#self_order_table_person").val('');
          if(updated_sale_id){
              if(s_width<=700){
                  $.notifyBar({ cssClass: "success", html: order_success_updated });
              }
          }else if(updated_sale_id==""){
              if(s_width<=700){
                  $.notifyBar({ cssClass: "success", html: order_success_added });
              }
          }
  
          $.ajax({
              url: base_url + "Sale/add_kitchen_sale_by_ajax",
              method: "POST",
              dataType:'json',
              data: {
                  order: order_object,
                  is_self_order: is_self_order,
                  close_order: 0,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (data) {
                if(data.invoice_status){
                    toastr['error']((data.invoice_msg), ''); 
                }else{
                    if(is_print){
                        let content_data_direct_print = data.content_data_direct_print;
                        for (let key in content_data_direct_print) {
                            if(content_data_direct_print[key].ipvfour_address){
                                $.ajax({
                                    url:
                                    content_data_direct_print[key].ipvfour_address +
                                    "print_server/irestora_printer_server.php",
                                    method: "post",
                                    dataType: "json",
                                    data: {
                                        content_data: "["+(JSON.stringify(content_data_direct_print[key]))+"]",print_type:data.print_type,
                                    },
                                    success: function (data) {},
                                    error: function () {},
                                });
                            }
                        }
                        $("#kot_print").val(2);
                        print_kot_popup_print(data.content_data_popup_print,1);
                    }
                    
                }

              },
              error: function () {
  
              },
          });
      }
  
      function push_online_update(orders){
          $.ajax({
              url:base_url+"Sale/push_online",
              method:"post",
              async: false,
              data:{
                  orders : orders,
                  sales_id : '',
                  csrf_name_: csrf_value_
              },
              success:function(response) {
                  let edit_sale_id = $("#edit_sale_id").val();
                  window.location.href = base_url+"Sale/sales/"+edit_sale_id;
              },
              error:function(){
  
              }
          });
      }
  
      function push_online(){
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              // let i = 1;
  
              if (cursor) {
                  let sales_id = cursor.value.sales_id;
                  let online_push = cursor.value.online_push;
                  let is_offline_system = Number(cursor.value.is_offline_system);
                  let orders = cursor.value.order;
                  let rowData = JSON.parse(cursor.value.order);
                  let sale_no = rowData.sale_no;
                  if(online_push===0){
                      $.ajax({
                          url:base_url+"Sale/push_online",
                          method:"post",
                          async: false,
                          data:{
                              orders : orders,
                              sales_id : sales_id,
                              csrf_name_: csrf_value_
                          },
                          success:function(response) {
                              if(!is_offline_system){
                                  notify_online(sale_no);
                              }
                              update_online_push(response);
                          },
                          error:function(){
  
                          }
                      });
                  }
                  cursor.continue();
              }
          };
      }
      function push_online_sync(){
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              // let i = 1;
  
              if (cursor) {
                  let sales_id = cursor.value.sales_id;
                  let online_push = cursor.value.online_push;
                  let is_offline_system = Number(cursor.value.is_offline_system);
                  let orders = cursor.value.order;
                  let rowData = JSON.parse(cursor.value.order);
                  let sale_no = rowData.sale_no;
                  if(online_push===0){
                      $.ajax({
                          url:base_url+"Sale/push_online",
                          method:"post",
                          async: false,
                          data:{
                              orders : orders,
                              sales_id : sales_id,
                              csrf_name_: csrf_value_
                          },
                          success:function(response) {
                              notify_online(sale_no);
                              update_online_push(response);
                          },
                          error:function(){
  
                          }
                      });
                  }
                  cursor.continue();
              }
          };
      }
      function remove_more_20(){
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
          let counter_row = 1;
          let counter_row_offline_counter = 0;
  
  
          objectStore.openCursor(null, 'prev').onsuccess = function(event) {
              let cursor = (event.target.result);
  
              if (cursor) {
                  if(cursor.value.online_push==0){
                      counter_row_offline_counter++;
                  }
  
                  if(counter_row>100 && cursor.value.online_push==1){
                      let request = db.transaction("recent_sales", "readwrite").objectStore("recent_sales").delete(cursor.key);
                      request.onsuccess = function(event) {
                      }
                  }
                  counter_row++;
                  cursor.continue();
              }
              $(".online_status_counter").html("("+counter_row_offline_counter+")");
              $(".online_status_counter").attr("data-total",counter_row_offline_counter);
          }
      }
      setInterval(function () {
          if(checkInternetConnection()){
              push_online();
          }
          remove_more_20();
      }, 10000);
  
      setInterval(function () {
          checkInternetConnectionNew();
      }, 2000);
  
      $(document).on("click", "#sync_online", function (e) {
          push_online_sync();
      });

      $(document).on("click", "#pull_others_device_orders", function (e) {
        swal(
            {
              title: warning + "!",
              text: are_you_sure_for_pull,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
                let sale_no_all = '';
                $(".running_order_order_number").each(function() {
                    let running_order_order_number = $(this).text();
                    let added_offline_status = Number($(this).attr("data-added_offline_status"));
                    if(added_offline_status==2){
                        sale_no_all+=running_order_order_number;
                        sale_no_all+=",";
                    }
                });

                $.ajax({
                    url: base_url + "Sale/get_all_running_order_for_new_pc",
                    method: "POST",
                    dataType:'json',
                    async:false,
                    data: {
                        sale_no_all: sale_no_all,
                        csrf_irestoraplus: csrf_value_,
                    },
                    success: function (response) {
                        let order = '';
                        let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                        let company_id_indexdb = $("#company_id_indexdb").val();
        
                        let get_all_running_order_for_new_pc = response.get_all_running_order_for_new_pc;
                        for (let key_order in get_all_running_order_for_new_pc) {
                                order = get_all_running_order_for_new_pc[key_order];
                               let sale_no_new = order.sale_no;
                               let order_object = order.self_order_content;
                               if (!$("#order_"+get_plan_string(sale_no_new)).length) {
                                    add_sale_by_ajax('',order_object,outlet_id_indexdb,company_id_indexdb,sale_no_new,"","","");
                                    
                                    toastr['success']((sale_no_new+" "+pulled_successfully), '');
                               } 
                        }
        
                    },
                    error: function () {
          
                    },
                });
            }
          );
    });
  // purpose of this function is to delete data from recent sales table by using data from indexeddb
      function delete_from_recent_sales (sale_id) {
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
  
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
  
              if (cursor) {
                  if(cursor.value.sales_id == sale_id) {
                      let request = db.transaction("recent_sales", "readwrite").objectStore("recent_sales").delete(cursor.key);
                      request.onsuccess = function(event) {
  
                      }
                  }
  
                  cursor.continue();
              }
          }
          clearFooterCartCalculation();
          displayOrderList();
      };
  // purpose of this function is to delete data from future sales table by using data from indexeddb
      function delete_from_future_sales (sale_no) {
          let objectStore = db.transaction(['future_sales'], "readwrite").objectStore("future_sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
  
              if (cursor) {
                  if(cursor.value.sale_no == sale_no) {
                      let request = db.transaction("future_sales", "readwrite").objectStore("future_sales").delete(cursor.key);
                      request.onsuccess = function(event) {
  
                      }
                  }
  
                  cursor.continue();
              }
          }
          clearFooterCartCalculation();
          displayOrderList();
      };
  
      function getDateTime() {
          //for date and time
          let today = new Date();
          let dd = today.getDate();
          if(att_type==1){let ddd= Number($(".mrgin_3").text()).tofixed(ir_precision);$(".mrgin_3").text(ddd)}
          let mm = today.getMonth() + 1; //January is 0!
          let yyyy = today.getFullYear();
          if (dd < 10) {
              dd = "0" + dd;
          }
          if (mm < 10) {
              mm = "0" + mm;
          }
          let time_a = new Date().toLocaleTimeString();
          let today_date = yyyy + "-" + mm + "-" + dd;
          let date_time = today_date + " " + time_a;
          return [date_time,time_a];
      }
      function gettingRoundingAmount(amount){
        let is_rounding_enable = Number($("#is_rounding_enable").val());
        if(is_rounding_enable==1){
            let split_value = Number(amount).toFixed(0);
            let rounding = (split_value-Number(amount)).toFixed(2);
            return [Number(split_value),is_rounding_enable,rounding];
        }else{
          return [Number(amount),is_rounding_enable,0];
        }
    }
  
    function getCurrentDate() {
  
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      let yyyy = today.getFullYear();
      //today = yyyy + "-" + mm + "-" + dd;
        today = $("#default_date").val();
      return today;
    }
      function getPadTwo (str) {
          str = str.toString();
          return (str.length < 3 ? getPadTwo("0" + str, 3) : str);
      }
      function getRandomCodeOne(length) {
          let result           = '';
          //this is random character pattern
          let characters       = 'abcdefghijklmnopqrstuvwxyz';
          let charactersLength = characters.length;
          for ( let i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
          }
          return result;
      }
      function generateSaleNo() {
          //for date and time
          let today = new Date();
          let dd = today.getDate();
          let mm = today.getMonth() + 1; //January is 0!
          let yyyy = today.getFullYear();
          let twoDigitYear = yyyy. toString(). substr(-2);
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
          let invoice_counter_value = Number(localStorage['invoice_counter_value'])+1;
          localStorage['invoice_counter_value'] = invoice_counter_value;
          let sale_no = username_short+twoDigitYear+mm+dd+"-"+getPadTwo(invoice_counter_value);
          return sale_no;
      }
      function getRandomCode(length) {
          let result           = '';
          //this is random character pattern
          let characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          let charactersLength = characters.length;
          for ( let i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
          }
          return result;
      }
      function generateSplitSaleNo(p_sale_id) {
          let total_added = 0;
          let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
  
          let sales_id = '';
          let counter = 1;
  
          objectStore.openCursor(null, 'prev').onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  let split_parent_sale_no = (cursor.value.split_parent_sale_no);
                  if((p_sale_id)===split_parent_sale_no){
                     $(".total_split_sale").append('<span>1</span>');
                      counter++;
                  }
                  cursor.continue();
              }
          };
      }
      function getPadOne (str) {
          str = str.toString();
          return (str.length < 2 ? getPadOne("0" + str, 2) : str);
      }
      function getPad (str) {
          str = str.toString();
          return "-"+(str.length < 2 ? getPadOne("0" + str, 2) : str);
      }
      function getExistKitchen(kitchen_id,existing_array){
          let status = true;
          for(let i=0;i<existing_array.length;i++){
              if(Number(kitchen_id) == Number(existing_array[i])){
                  status = false;
              }
          }
          return status;
      }
      function sn_counter(){
          $(".kot_container").each(function() {
              let sn_counter = $(this).find(".sn_counter");
              let i = 1;
              sn_counter.each(function() {
                  $(this).html(i);
                  i++;
              });
          });
      }
  
      /*inline css use for offline printing of invoice, bill*/
      let style_print = `<style>
                body {
                          font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                          font-size: 14px;
                          line-height: 1.42857143;
                          color: black;
                          background-color: #fff;
                      }
                       #wrapper {
                      max-width: 366px;
                      margin: 0px auto;
                  }
                  .text-right{
                      width: 50% !important;
                        text-align: right !important;
                  }
                  
                  @media print {
                     #wrapper {
                          max-width: 366px;
                      }
                      .text-right{
                          width: 50% !important;
                         text-align: right !important;
                      }
                      .arabic_text_left_is{
                          unicode-bidi: isolate-override !important;
                      }
                  }
                  .arabic_text_left_is{
                      unicode-bidi: isolate-override !important;
                  }
                  #barcode_invoice canvas{
                      width: 25% !important;
                  }
                      .ir_txt_center {
                        text-align: center !important;
                      }
                      .ir_wid_70 {
                        width: 70%; !important;
                      }
                      .ir_wid_90 {
                        width: 90%; !important;
                      }
                      @media print {
                        .no-print {
                          display: none;
                        }
                      
                        #wrapper {
                          margin: 0 auto;
                        }
                      
                        .no-border {
                          border: none !important;
                        }
                      
                        .border-bottom {
                          border-bottom: 1px solid #ddd !important;
                        }
                      
                        table tfoot {
                          display: table-row-group;
                        }
                        .ir_txt_center {
                          text-align: center !important;
                        }
                        .ir_txt_right {
                          text-align: right !important;
                        }
                        .ir_wid_70 {
                          width: 70%; !important;
                        }
                        .ir_wid_90 {
                          width: 90%; !important;
                        }
                        .arabic_text_left_is{
                          unicode-bidi: isolate-override !important;
                        }
                      }
                      .arabic_text_left_is{
                        unicode-bidi: isolate-override !important;
                      }
                      #barcode_invoice canvas{
                        width: 25% !important;
                      }       
                      .text-center{
                              text-align: center;
                      }     
                      h3{
                      font-size: 25px;
                      padding: 0px;
                      margin: 0px;
                      }    
                      h4{
                     margin-top: 0px;
                      font-size: 20px;
                      } 
                      .p_txt{
                          margin-top: 0px;
                          margin-bottom: 0px;
                      }
                     .text_left{
                     text-align: left !important;
                     }
                      .ir_txt_center {
                        text-align: center !important;
                      }
                      .table {
                          width: 100%;
                          max-width: 100%;
                          margin-bottom: 5px;
                      }
                      table {
                          background-color: transparent;
                      }
                      
                      table {
                          border-spacing: 0;
                          border-collapse: collapse;
                      }
                      .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                          padding: 5px;
                          line-height: 1.42857143;
                          vertical-align: top;
                          border-top: 1px solid #ddd;
                      }
                      .table-striped>tbody>tr:nth-of-type(odd) {
                              background-color: #f9f9f9;
                          }
                          .btn {
                              border-radius: 0;
                              margin-bottom: 5px;
                              text-decoration: none;
                          }
                          .btn-block {
                              display: block;
                              width: 100%;
                          }
                          .btn-primary {
                              color: #fff;
                              background-color: #3c8dbc;
                              border-color: #2e6da4;
                          }
                          .btn {
                              display: inline-block;
                              padding: 6px 12px;
                              margin-bottom: 0;
                              font-size: 14px;
                              font-weight: 400;
                              line-height: 1.42857143;
                              text-align: center;
                              white-space: nowrap;
                              vertical-align: middle;
                              -ms-touch-action: manipulation;
                              touch-action: manipulation;
                              cursor: pointer;
                              -webkit-user-select: none;
                              -moz-user-select: none;
                              -ms-user-select: none;
                              user-select: none;
                              background-image: none;
                              border: 1px solid transparent;
                              border-radius: 4px;
                          }

                          
                    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                    padding: 2px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 0px solid black;
                    }
                    .table {
                    width: 100%;
                    max-width: 100%;
                    margin-bottom: 0px;
                    }
                    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                    padding: 2px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 0px solid black;
                    }
                </style>`;
      
      function check_old_kot(sale_no,item_id,kot_print,qty){
         kot_print = $("#kot_print").val();
          if(kot_print==1){
            return true;
          }else{
              let outlet_id = $("#outlet_id_indexdb").val();
              let order_no_outlet_update = sale_no+''+outlet_id;
              let object_kot = JSON.parse(localStorage['kot_invoice']);
              
              let row_selected = object_kot[order_no_outlet_update];
            
              if(row_selected!='' && row_selected!=undefined ){
                  let order = JSON.parse(row_selected);
                  console.log("Data:");
                  console.log(order);
                  let return_status = false;
                  for (let key in order.items) {
                      let this_item = order.items[key];
                      console.log("ID: "+item_id+" => "+this_item.food_menu_id);
                      if(Number(item_id) == Number(this_item.food_menu_id)){
                          $(".kot_exist_checker").append('<span id="exist_item'+this_item.food_menu_id+'">'+this_item.qty+'</span>');
                          if(Number(this_item.qty) != Number(qty)){
                              return_status = this_item.qty;
                          }
                      }
                  }
                  return return_status;
              }else{
                  return true;
              }
          }
  
      }
      function update_kot_print(order_info, sale_no){
          let outlet_id = $("#outlet_id_indexdb").val();
          let order_no_outlet_update = sale_no+''+outlet_id;
          let object_kot = JSON.parse(localStorage['kot_invoice']);
  
          let row_selected = object_kot[order_no_outlet_update];
        
          if(row_selected!='' && row_selected!=undefined ){
              object_kot[order_no_outlet_update] = JSON.stringify(order_info);
              localStorage['kot_invoice'] = JSON.stringify(object_kot);
          }
      }

      function remove_kot_invoice(sale_no){
        let outlet_id = $("#outlet_id_indexdb").val();
        let order_no_outlet_update = sale_no + '' + outlet_id;
        let object_kot = JSON.parse(localStorage['kot_invoice']); // Parse the stored object
        if (object_kot[order_no_outlet_update] !== '' && object_kot[order_no_outlet_update] !== undefined) {
            // Remove the key from the object
            delete object_kot[order_no_outlet_update];
            // Update the localStorage
            localStorage['kot_invoice'] = JSON.stringify(object_kot);
        }
    }
      function print_kot_print(order_info,kot_print) {
          let order = JSON.parse(order_info);
          // console.log(order);
          let order_type = "";
          let total_item_counter = 0;
          let order_number = "";
          if(order !== null) {
              if (order.order_type == 1) {
                  order_type = inv_dine;
              } else if (order.order_type == 2) {
                  order_type = inv_take_away;
              } else if (order.order_type == 3) {
                  order_type = inv_delivery;
              }
          }
  
          let inv_p_waiter = (order.waiter_name != undefined && order.waiter_name)?` <b>`+inv_waiter+`: </b> `+order.waiter_name+ `<br/>`: "";
          let inv_p_table = (order.orders_table_text != undefined && order.orders_table_text)?` <h4  style="margin: 0px">`+inv_table+`: `+order.orders_table_text+ `</h4>`: "";
 

          let invoice_print =``;
          invoice_print+= `<!doctype html>
                  <html>
                  
                  <head>
                      <meta charset="utf-8">
                      <title>`+inv_invoice_no+` : `+order.sale_no+`</title>
                      <script src="`+base_url+`assets/bower_components/jquery/dist/jquery.min.js"></script>
                      <script src="`+base_url+`assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                  ${style_print}
                  </head>
                  <body>
                      <div id="wrapper">
                          <div id="receiptData">
                              <div id="receipt-data">`;
  
              let header_txt1 =`<div class="text-center">`;
              let header_txt =`
                                        `+inv_p_table+`
                                        <h4 style="margin: 0px"> `+inv_order_type+`: `+order_type+`</h4>
                                        <h4 style="margin: 0px"> `+inv_order_number+`: `+order.sale_no+`</h4>
                                      <p>
                                      <b>`+inv_customer+`: </b>`+order.customer_name+` &nbsp;`
                                      +inv_p_waiter+`
                                          <b>`+inv_invoice_no+`: </b>` +order.sale_no+` &nbsp;<b>`+inv_date+`: </b>`+ order.date_time+`<br><br>
                                      </p>
                                  </div>
                                  <div class="ir_clear"></div>
                                  <table class="table table-condensed">
                                      <tbody>`;
          let sl=1;
          let total_kitchen_arr = [];
  
 
          $(".current_kot_items").empty();
          for (let key in order.items) {
              //construct div
              let this_item = order.items[key];
              if(Number(this_item.kitchen_id)){
                  if(getExistKitchen(this_item.kitchen_id,total_kitchen_arr)){
                      total_kitchen_arr.push(this_item.kitchen_id);
                      let html_div = '<table data-kitchen_name="'+this_item.kitchen_name+'" class="kot_container kot_container_'+this_item.kitchen_id+'"></table>';
                      $(".current_kot_items").append(html_div);
                  }
              }
          }
          $(".kot_exist_checker").html('');
     
          for (let key in order.items) {
              let this_item = order.items[key];
              let if_kot_print = check_old_kot(order.sale_no,this_item.food_menu_id,kot_print,this_item.qty);
              let updated_qty = this_item.qty;
              if(!if_kot_print){
                  let tmp_checker = Number($("#exist_item"+this_item.food_menu_id).text());
                  if(!tmp_checker){
                      if_kot_print = true;
                      updated_qty = this_item.qty;
                  }
              }else{
                  let tmp_checker = Number($("#exist_item"+this_item.food_menu_id).text());
                  updated_qty = this_item.qty - tmp_checker;
  
              }
  
              if(if_kot_print){
                  let row_of_item = '';
                  //construct div
                  let total_modifier = 0;
                  if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
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
                  let alternative_name = getAlternativeNameById(this_item.food_menu_id, window.items);
                  let i = 1;
                  total_item_counter+=Number(this_item.qty);
                  row_of_item+=`<tr>`;
                  row_of_item+=`<td class="no-border border-bottom ir_wid_90"># <span class="sn_counter">`+sl+`</span>: `+this_item.menu_name+alternative_name;
                  if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                      row_of_item+= `<br><span  style="padding-left: 30px;">`+combo_txt+": "+this_item.menu_combo_items+`</span>`;
                  }
                  if (this_item.item_note != "" && this_item.item_note!=undefined  && this_item.item_note!=null && this_item.item_note!="undefined") {
                      row_of_item+= `<br><span  style="padding-left: 30px;">`+note_txt+": "+this_item.item_note+`</span>`;
                  }
                  row_of_item+=`</td>`;
                  row_of_item+=`<td class="no-border border-bottom text-right">`;
                  row_of_item+=  updated_qty;
                  row_of_item+=`</td>`;
                  row_of_item+=`</tr>`;
                  for (let mod_key in modifier_names_custom) {
                      let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                      row_of_item+=`<tr>`;
                      row_of_item+=`<td class="no-border border-bottom" style="padding-left: 38px;">`;
                      row_of_item+=`<small></small>`;
                      row_of_item += tmp_mod_name_m_n;
                      row_of_item+=`</td>`;
                      row_of_item+=`<td class="no-border border-bottom text-right">`;
                      row_of_item += updated_qty;
                      row_of_item+=`</td>`;
                      row_of_item+=`</tr>`;
                  }
                  sl++;
                  if(Number(this_item.kitchen_id)){
                      $(".kot_container_"+this_item.kitchen_id).append(row_of_item);
                      sn_counter();
                  }
              }
          }
          let footer_text = `</tbody>
                                  </table>`;
  
          let separate_kot = '';
          for(let k=0;k<total_kitchen_arr.length;k++){
              let get_html = $(".kot_container_"+total_kitchen_arr[k]).html();
              if(get_html){
                  let this_kitchen_name = $(".kot_container_"+total_kitchen_arr[k]).attr("data-kitchen_name");
                  invoice_print+=header_txt1;
                  invoice_print+=`<h3>`+txt_kot+`: `+this_kitchen_name+`</h3>`;
                  invoice_print+=header_txt;
                  invoice_print+=get_html;
                  invoice_print+=footer_text;
                  invoice_print+="<br>";
              }
          }
  
          invoice_print+= ` </div>
                              <div class="ir_clear"></div>
                          </div>
                  
                          <div id="buttons"  class="no-print ir_pt_tr">
                              <hr>
                              <span class="pull-right col-xs-12">
                                  <a class="btn btn-block btn-primary" href="javascript:eval('window.print()')"/>Print</a> </span>
                              <div class="ir_clear"></div>
                              <div class="col-xs-12 ir_bg_p_c_red">
                                  <p class="ir_font_txt_transform_none">
                                      Please follow these steps before you print for first time:
                                  </p>
                                  <p class="ir_font_capitalize">
                                      1. Disable Header and Footer in browser's print setting<br>
                                      For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                                      all --blank--<br>
                                      For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                                  </p>
                              </div>
                              <div class="ir_clear"></div>
                          </div>
                      </div>
                      <script src="`+base_url+`assets/dist/js/print/jquery-2.0.3.min.js"></script>
                      <script src="`+base_url+`assets/dist/js/print/custom.js"></script>
                      <script>
                          $(function() {
                            setTimeout(function(){ window.print(); }, 1000); 
                           
                          });
                      </script>
                  </body>
                  
                  </html>`;
          update_kot_print(order_info,order.sale_no);     
          reset_finalize_modal();
          var popup = window.open("", "popup","width=100","height=600");
          popup.document.write(invoice_print);
          popup.document.close();
          popup.focus();
      }
      
      function call_print_invoice(order_info,inv_qr_code_enable_status) {
        let order = JSON.parse(order_info);
        
        let qrcode_value = base_url+`invoice/`+order.random_code; 
        let qrcode_id = 'barcode_invoice';
        if(inv_qr_code_enable_status=="Zatca"){
            qrcode_value = order.zatca_invoice_value; 
        }
        if(inv_qr_code_enable_status=="Disable"){
            qrcode_id = '';
        }
         
        //console.log(order);
        let order_type = "";
        let total_item_counter = 0;
        let order_number = "";
        let token_number = (order.token_number != undefined && order.token_number)?`<h4 style="margin-bottom: 0px;">`+inv_token_number+`: `+order.token_number+ `</h4>`: "";
        if(order !== null) {
            if (order.order_type == 1) {
                order_type = inv_dine;
            } else if (order.order_type == 2) {
                order_type = inv_take_away;
            } else if (order.order_type == 3) {
                order_type = inv_delivery;
            }
        }
        let text_no_str = '';
        if(inv_collect_tax=="Yes"){
            text_no_str =  inv_tax_registration_no+": "+outlet_tax_registration_no;
        }

        let server_value = (order.counter_name != undefined && order.counter_name)?``+order.counter_name:'';
        let inv_p_table = (order.orders_table_text != undefined && order.orders_table_text)?` `+inv_table+`: `+order.orders_table_text+ `<br/>`: "";
        let inv_p_address = (order.customer_address != undefined && order.customer_address != "undefined" && order.customer_address)?` <br>`+inv_address+`: <b>`+order.customer_address+`</b>`: "";
        
        let sale_date_split = order.date_time.split(' ');
        let invoice_print =``;
        invoice_print+= `<!doctype html>
                <html>
                <head>
                
                    <meta charset="utf-8">
                    <title>`+inv_invoice_no+` : `+order.sale_no+`</title>
                    <script src="`+base_url+`assets/bower_components/jquery/dist/jquery.min.js"></script>
                    <link rel="stylesheet"
                        href="`+base_url+`assets/bower_components/font-awesome/css/font-awesome.min.css">
                    <script src="`+base_url+`assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                    ${style_print}
                </head>
                
                <body>
                    <div id="wrapper">
                        <div id="receiptData">
                            <div id="receipt-data">
                                <div class="text-center">
                                <img alt="`+outlet_name+`" src="`+base_url+`images/`+invoice_logo+`">
                                <h3> `+outlet_name+` </h3> 
                                `+text_no_str+`
                                    <p class="p_txt">
                                        `+inv_address+`: `+outlet_address+`<br>
                                        `+inv_phone+`: ` +outlet_phone+`<br>
                                    </p>
                                </div>
                                <table style="width:100%;margin-top: 10px;">
                    <tr>
                        <td style="text-align:left"><h4 style="margin-bottom: 0px;"><b>` +order.sale_no+`</b></h4></td>
                        <td style="text-align:right"><h4 style="margin-bottom: 0px;"><b>`+order_type+`</b></h4></td>
                    </tr>   
                </table>
              
                <table style="width:100%">
                  <tr>
                        <td style="text-align:left">`+inv_server+`: <b>`+associate_user_name+`</b></td>
                        <td style="text-align:right">` +server_value+`</td>
                    </tr>   
                    <tr>
                        <td style="text-align:left">`+inv_sale_date+`: <b>`+sale_date_split[0]+`</b></td>
                        <td style="text-align:right">`+sale_date_split[1]+`</td>
                    </tr> 
                      <tr>
                        <td style="text-align:left">`+inv_customer+`: <b>`+order.customer_name+`</b>`+inv_p_address+`</td>
                        <td style="text-align:right"><h4 style="margin-bottom: 0px;">`+inv_p_table+`</h4></td>
                    </tr>   
                </table>
                <p style="margin-top: 4px;">`;

        
        let inv_p_gst_number = (order.customer_gst_number != undefined && order.customer_gst_number != "undefined" && order.customer_gst_number)?` `+inv_gst_number+`: <b>`+order.customer_gst_number+ `</b><br/>`: "";
        let inv_p_waiter = (order.waiter_name != undefined && order.waiter_name)?` `+inv_waiter+`: <b>`+order.waiter_name+ `</b><br/>`: "";
       
        let inv_p_status = (order.status != undefined && order.status)?` `+status_txt+`: <b>`+order.status+ `</b><br/>`: "";
        if(order_type!="Delivery"){
            inv_p_status = '';
        }
        invoice_print+= ""+inv_p_gst_number+inv_p_waiter+inv_p_status+`
                                </p>
                                <div class="ir_clear"></div>
                                <hr style="border-bottom:1px solid black;margin: 0px;">
                                <table class="table table-condensed">
                                    <tbody>`;
        let sl=1;
        for (let key in order.items) {
            //construct div
            let this_item = order.items[key];
            let total_modifier = 0;
            if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
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

            let i = 1;
            total_item_counter+=Number(this_item.qty);
            let discount_value = Number(this_item.item_discount_amount) ? "(-"+getAmount(this_item.item_discount_amount)+")": '';
            let alternative_name = getAlternativeNameById(this_item.food_menu_id, window.items);
            invoice_print+=`<tr>`;
            invoice_print+=`<td class="no-border border-bottom ir_wid_90"># `+sl+`:`+this_item.menu_name+alternative_name;
            invoice_print+=`<small></small> &nbsp;&nbsp;`+ this_item.qty + `&nbsp;X&nbsp;`+getAmount(this_item.menu_unit_price)+discount_value ;
            if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+combo_txt+this_item.menu_combo_items+`</span>`;
            }
            if (this_item.item_note != "" && this_item.item_note!=undefined  && this_item.item_note!=null && this_item.item_note!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+note_txt+": "+this_item.item_note+`</span>`;
            }
            if (this_item.discount_reason != "" && this_item.discount_reason!=undefined && this_item.discount_reason!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+discount_reason_txt+": "+this_item.discount_reason+`</span>`;
            }
            invoice_print+=`</td>`;
            invoice_print+=`<td class="no-border border-bottom text-right">`;
            invoice_print+=  getAmount(this_item.menu_price_with_discount);
            invoice_print+=`</td>`;
            invoice_print+=`</tr>`;
            for (let mod_key in modifier_names_custom) {
                let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                let tmp_mod_name_m_p = getAmount(modifier_prices_custom[mod_key]);
                invoice_print+=`<tr>`;
                invoice_print+=`<td class="no-border border-bottom" style="padding-left: 38px;">`;
                invoice_print+=`<small></small>`;
                invoice_print += tmp_mod_name_m_n;
                invoice_print+=`</td>`;
                invoice_print+=`<td class="no-border border-bottom text-right">`;
                invoice_print += tmp_mod_name_m_p;
                invoice_print+=`</tr>`;
            }
            sl++;
        }
        invoice_print+=` </tbody>
                    </table>
                    <hr style="border-bottom:1px solid black;margin: 0px;">
                    <table class="table table-condensed">`;
                    if(Number(order.sub_total)){
                        invoice_print+=`<tr>
                                                    <th  class="text_left">`+inv_sub_total+`
                                                       
                                                    </th>
                                                    <th class="text-right">
                                                        `+getAmount(order.sub_total)+`
                                                    </th>
                                                    </tr>`;
                    }
        if(Number(order.total_discount_amount)){
            invoice_print+=`<tr>
                                        <th  class="text_left">`+inv_discount+`
                                           
                                        </th>
                                        <th class="text-right">
                                            `+getAmount(order.total_discount_amount)+`
                                        </th>
                                        </tr>`;
        }
        if(Number(order.delivery_charge_actual_charge)){
            invoice_print+=`<tr>
                                                <th  class="text_left">`+(order.charge_type=="service"?inv_service_charge:inv_delivery_charge)+`
                                                  
                                                </th>
                                                <th class="text-right">
                                                    `+getAmount(order.delivery_charge_actual_charge)+`
                                                </th>
                                                </tr>`;
        }
        if(Number(order.tips_amount_actual_charge)){
            invoice_print+=`<tr>
                                                <th  class="text_left">`+inv_tips+`
                                                  
                                                </th>
                                                <th class="text-right">
                                                    `+getAmount(order.tips_amount_actual_charge)+`
                                                </th>
                                                </tr>`;
        }

        let total_vat_section_to_show =``;
        $.each(order.sale_vat_objects, function (key, value) {
            if(Number(value.tax_field_amount)){
                total_vat_section_to_show +=`<tr>
                                                                        <th class="text_left">
                                                                            `+value.tax_field_type +`
                                                                        </th>
                                                                        <th class="text-right">
                                                                            `+getAmount(value.tax_field_amount) +`
                                                                        </th>
                                                                    </tr>`;
            }
        });
 invoice_print+= total_vat_section_to_show;
 invoice_print+= ` </table>
 <hr style="border-bottom:1px solid black;margin: 0px;"> 
                <table class="table table-striped table-condensed">
                    <tbody>`;
        invoice_print+= ` <tr>
                                        <th  class="text_left"><h3><b>`+inv_total+`</b></h3>
                                        
                                        </th>
                                            <th class="text-right"><h3><b>
                                                `+getAmount(order.total_payable)+`</b></h3>
                                            </th>
                                        </tr>`;

        invoice_print+= `
                                    </tbody>
                                </table>
                                <table class="table">
                    <tbody>`;
        let obj_payment = '';
        if((order.split_sale_id) && order.split_sale_id!=undefined){
            obj_payment = JSON.parse(order.payment_object);
        }else{
            obj_payment = JSON.parse(JSON.parse(order.payment_object));
        }
        if(obj_payment.length){
            $.each(obj_payment, function (key, value) {
                let txt_point = '';
                if(value.payment_id==5){
                    txt_point = " ("+inv_usage_points+":"+value.usage_point+")";
                }
                invoice_print += `<tr>
                                                                                <th class="text_left">`+value.payment_name+` (`+inv_paid+`)
                                                                                  
                                                                                </th>
                                                                                    <th class="text-right">
                                                                                        ` + getAmount(value.amount) + `
                                                                                    </th>
                                                                                </tr>`;

            });
        }
        if(Number(order.is_multi_currency) ==1){
            let txt_multi_currency = "Paid in "+order.multi_currency+" "+order.multi_currency_amount+" where 1"+inv_currency+" = "+order.multi_currency_rate+" "+order.multi_currency;
            invoice_print += `<tr>
                                                                                <th colspan="2" class="ir_txt_center">`+txt_multi_currency+`
                                                                                  
                                                                                </th>
                                                                                  
                                                                                </tr>`;
        }
        
        if(Number(order.due_amount)) {
            invoice_print += `<tr>
                                        <th  class="text_left">`+inv_due_amount+`
                                          
                                        </th>
                                            <th class="text-right">
                                                ` + getAmount(order.due_amount )+ `
                                            </th>
                                        </tr>`;
        }
       
        

        invoice_print+= `</tbody>
                                </table>`;

                                invoice_print+= ` 
                            </table><hr style="border-bottom:1px solid black;margin: 0px;"> 
                            <table class="table">
                <tbody>`;

        if(Number(order.hidden_given_amount)) {
            invoice_print += `<tr>
                                        <th  class="text_left">`+inv_given_amount+`
                                          
                                        </th>
                                            <th class="text-right">
                                                ` + getAmount(order.hidden_given_amount )+ `
                                            </th>
                                        </tr>`;
        }
        if(Number(order.hidden_change_amount)) {
            invoice_print += `<tr>
                                        <th  class="text_left">`+inv_change_amount+`
                                          
                                        </th>
                                            <th class="text-right">
                                                ` + getAmount(order.hidden_change_amount )+ `
                                            </th>
                                        </tr>`;
        }

        invoice_print+= `</tbody>
                                </table>
                                <h3 style="text-align:center;margin:0px">**`+inv_paid_ticket+`**</h3>
                            <p style="text-align:center;margin:0px">` + (order.paid_date_time) + `</p>
                                <p style="text-align:center;margin:0px"> `+invoice_footer+`</p>
                                <br>
                                <div class="text-center"><div id="`+qrcode_id+`"></div></div>
                            </div>
                            <div class="ir_clear"></div>
                        </div>
                
                        <div id="buttons"  class="no-print ir_pt_tr">
                            <hr>
                            <span class="col-xs-12">
                                <a class="btn btn-block btn-primary" href="javascript:eval('window.print()')"/>Print</a> </span>
                            <div class="ir_clear"></div>
                            <div class="col-xs-12 ir_bg_p_c_red">
                                <p class="ir_font_txt_transform_none">
                                    Please follow these steps before you print for first time:
                                </p>
                                <p class="ir_font_capitalize">
                                    1. Disable Header and Footer in browser's print setting<br>
                                    For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                                    all --blank--<br>
                                    For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                                </p>
                            </div>
                            <div class="ir_clear"></div>
                        </div>
                    </div>
                    <script src="`+base_url+`assets/dist/js/print/jquery-2.0.3.min.js"></script>
                    <script src="`+base_url+`assets/dist/js/print/custom.js"></script>
                    <script src="`+base_url+`assets/plugins/barcode/jquery.qrcode.min.js"></script>
                    <script>
                        $(function() {
                        
                          setTimeout(function(){ 
                        
                          $('#barcode_invoice').qrcode("`+qrcode_value+`");   window.print(); }, 1000); 
                         
                        });
                    </script>
                </body>
                
                </html>`;
        reset_finalize_modal();
        var popup = window.open("", "popup","width=100","height=600");
        popup.document.write(invoice_print);
        popup.document.close();
        popup.focus();
    }
     
    function print_bill(order_info, sale_no) {
        let order = JSON.parse(order_info);

        //console.log(order);
        let order_type = "";
        let total_item_counter = 0;
        let order_number = "";
        let token_number = (order.token_number != undefined && order.token_number)?`<h4 style="margin-bottom: 0px;">`+inv_token_number+`: `+order.token_number+ `</h4>`: "";
        if(order !== null) {
            if (order.order_type == 1) {
                order_type = inv_dine;
            } else if (order.order_type == 2) {
                order_type = inv_take_away;
            } else if (order.order_type == 3) {
                order_type = inv_delivery;
            }
        }
        let text_no_str = '';
        if(inv_collect_tax=="Yes"){
            text_no_str =  inv_tax_registration_no+": "+outlet_tax_registration_no;
        }

        let server_value = order.counter_name;
        let inv_p_table = (order.orders_table_text != undefined && order.orders_table_text)?` `+inv_table+`: `+order.orders_table_text+ `<br/>`: "";
        let inv_p_address = (order.customer_address != undefined && order.customer_address != "undefined"  && order.customer_address)?` <br>`+inv_address+`: <b>`+order.customer_address+`</b>`: "";
        
        let sale_date_split = order.date_time.split(' ');
        let invoice_print =``;
        invoice_print+= `<!doctype html>
                <html>
                <head>
                
                    <meta charset="utf-8">
                    <title>`+inv_invoice_no+` : `+order.sale_no+`</title>
                    <script src="`+base_url+`assets/bower_components/jquery/dist/jquery.min.js"></script>
                    <link rel="stylesheet"
                        href="`+base_url+`assets/bower_components/font-awesome/css/font-awesome.min.css">
                    <script src="`+base_url+`assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
                    ${style_print}
                </head>
                
                <body>
                    <div id="wrapper">
                        <div id="receiptData">
                            <div id="receipt-data">
                                <div class="text-center">
                                <img alt="`+outlet_name+`" src="`+base_url+`images/`+invoice_logo+`">
                                <h3> `+outlet_name+` </h3> 
                                `+text_no_str+`
                                    <p class="p_txt">
                                        `+inv_address+`: `+outlet_address+`<br>
                                        `+inv_phone+`: ` +outlet_phone+`<br>
                                    </p>
                                </div>
                                <table style="width:100%;margin-top: 10px;">
                    <tr>
                        <td style="text-align:left"><h4 style="margin-bottom: 0px;"><b>` +order.sale_no+`</b></h4></td>
                        <td style="text-align:right"><h4 style="margin-bottom: 0px;"><b>`+order_type+`</b></h4></td>
                    </tr>   
                </table>
              
                <table style="width:100%">
                  <tr>
                        <td style="text-align:left">`+inv_server+`: <b>`+associate_user_name+`</b></td>
                        <td style="text-align:right">` +server_value+`</td>
                    </tr>   
                    <tr>
                        <td style="text-align:left">`+inv_sale_date+`: <b>`+sale_date_split[0]+`</b></td>
                        <td style="text-align:right">`+sale_date_split[1]+`</td>
                    </tr> 
                      <tr>
                        <td style="text-align:left">`+inv_customer+`: <b>`+order.customer_name+`</b>`+inv_p_address+`</td>
                        <td style="text-align:right"><h4 style="margin-bottom: 0px;">`+inv_p_table+`</h4></td>
                    </tr>   
                </table>
                <p style="margin-top: 4px;">`;

        
        let inv_p_gst_number = (order.customer_gst_number != undefined && order.customer_gst_number != "undefined" && order.customer_gst_number)?` `+inv_gst_number+`: <b>`+order.customer_gst_number+ `</b><br/>`: "";
        let inv_p_waiter = (order.waiter_name != undefined && order.waiter_name)?` `+inv_waiter+`: <b>`+order.waiter_name+ `</b><br/>`: "";
       
        let inv_p_status = (order.status != undefined && order.status)?` `+status_txt+`: <b>`+order.status+ `</b><br/>`: "";
        if(order_type!="Delivery"){
            inv_p_status = '';
        }
        invoice_print+= ""+inv_p_gst_number+inv_p_waiter+inv_p_status+`
                                </p>
                                <div class="ir_clear"></div>
                                <hr style="border-bottom:1px solid black;margin: 0px;">
                                <table class="table table-condensed">
                                    <tbody>`;
        let sl=1;
        for (let key in order.items) {
            //construct div
            let this_item = order.items[key];
            let total_modifier = 0;
            if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
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

            let i = 1;
            total_item_counter+=Number(this_item.qty);
            let discount_value = Number(this_item.item_discount_amount) ? "(-"+getAmount(this_item.item_discount_amount)+")": '';
            let alternative_name = getAlternativeNameById(this_item.food_menu_id, window.items);
           
            invoice_print+=`<tr>`;
            invoice_print+=`<td class="no-border border-bottom ir_wid_90"># `+sl+`:`+this_item.menu_name+alternative_name;
            invoice_print+=`<small></small> &nbsp;&nbsp;`+ this_item.qty + `&nbsp;X&nbsp;`+getAmount(this_item.menu_unit_price)+discount_value ;
            if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+combo_txt+this_item.menu_combo_items+`</span>`;
            }
            if (this_item.item_note != "" && this_item.item_note!=undefined  && this_item.item_note!=null && this_item.item_note!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+note_txt+": "+this_item.item_note+`</span>`;
            }
            if (this_item.discount_reason != "" && this_item.discount_reason!=undefined && this_item.discount_reason!="undefined") {
                invoice_print+= `<br><span  style="padding-left: 30px;">`+discount_reason_txt+": "+this_item.discount_reason+`</span>`;
            }
            invoice_print+=`</td>`;
            invoice_print+=`<td class="no-border border-bottom text-right">`;
            invoice_print+=  getAmount(this_item.menu_price_with_discount);
            invoice_print+=`</td>`;
            invoice_print+=`</tr>`;
            for (let mod_key in modifier_names_custom) {
                let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                let tmp_mod_name_m_p = getAmount(modifier_prices_custom[mod_key]);
                invoice_print+=`<tr>`;
                invoice_print+=`<td class="no-border border-bottom" style="padding-left: 38px;">`;
                invoice_print+=`<small></small>`;
                invoice_print += tmp_mod_name_m_n;
                invoice_print+=`</td>`;
                invoice_print+=`<td class="no-border border-bottom text-right">`;
                invoice_print += tmp_mod_name_m_p;
                invoice_print+=`</tr>`;
            }
            sl++;
        }
        invoice_print+=` </tbody>
                    </table>
                    <hr style="border-bottom:1px solid black;margin: 0px;">
                    <table class="table table-condensed">`;

                    if(Number(order.sub_total)){
                        invoice_print+=`<tr>
                                                    <th  class="text_left">`+inv_sub_total+`
                                                       
                                                    </th>
                                                    <th class="text-right">
                                                        `+getAmount(order.sub_total)+`
                                                    </th>
                                                    </tr>`;
                    }
        
                    if(Number(order.total_discount_amount)){
            invoice_print+=`<tr>
                                        <th  class="text_left">`+inv_discount+`
                                           
                                        </th>
                                        <th class="text-right">
                                            `+getAmount(order.total_discount_amount)+`
                                        </th>
                                        </tr>`;
        }
        
        if(Number(order.delivery_charge_actual_charge)){
            invoice_print+=`<tr>
                                                <th  class="text_left">`+(order.charge_type=="service"?inv_service_charge:inv_delivery_charge)+`
                                                  
                                                </th>
                                                <th class="text-right">
                                                    `+getAmount(order.delivery_charge_actual_charge)+`
                                                </th>
                                                </tr>`;
        }
        if(Number(order.tips_amount_actual_charge)){
            invoice_print+=`<tr>
                                                <th  class="text_left">`+inv_tips+`
                                                  
                                                </th>
                                                <th class="text-right">
                                                    `+getAmount(order.tips_amount_actual_charge)+`
                                                </th>
                                                </tr>`;
        }

        let total_vat_section_to_show =``;
        $.each(order.sale_vat_objects, function (key, value) {
            if(Number(value.tax_field_amount)){
                total_vat_section_to_show +=`<tr>
                                                                        <th class="text_left">
                                                                            `+value.tax_field_type +`
                                                                        </th>
                                                                        <th class="text-right">
                                                                            `+getAmount(value.tax_field_amount) +`
                                                                        </th>
                                                                    </tr>`;
            }
        });
 invoice_print+= ` </table>
               
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr>`;
        invoice_print+= total_vat_section_to_show;
        invoice_print+= ` <tr>
                                        <th style="border-top: 2px solid;"  class="text_left"><h3><b>Total</b></h3>
                                        
                                        </th>
                                            <th style="border-top: 2px solid;" class="text-right"><h3><b>
                                                `+getAmount(order.total_payable)+`</b></h3>
                                            </th>
                                        </tr></tbody></table>`;
     
        

        invoice_print+= `
                                    </tfoot>
                                </table>
                                 `;

        invoice_print+= ` 
                            <div class="ir_clear"></div>
                        </div>
                
                        <div id="buttons"  class="no-print ir_pt_tr">
                            <hr>
                            <span class="col-xs-12">
                                <a class="btn btn-block btn-primary" href="javascript:eval('window.print()')"/>Print</a> </span>
                            <div class="ir_clear"></div>
                            <div class="col-xs-12 ir_bg_p_c_red">
                                <p class="ir_font_txt_transform_none">
                                    Please follow these steps before you print for first time:
                                </p>
                                <p class="ir_font_capitalize">
                                    1. Disable Header and Footer in browser's print setting<br>
                                    For Firefox: File &gt; Page Setup &gt; Margins &amp; Header/Footer &gt; Headers & Footers &gt; Make
                                    all --blank--<br>
                                    For Chrome: Menu &gt; Print &gt; Uncheck Header/Footer in More Options
                                </p>
                            </div>
                            <div class="ir_clear"></div>
                        </div>
                    </div>
                    <script src="`+base_url+`assets/dist/js/print/jquery-2.0.3.min.js"></script>
                    <script src="`+base_url+`assets/dist/js/print/custom.js"></script>
                </body>
                
                </html>`;
        reset_finalize_modal();
        var popup = window.open("", "popup","width=100","height=600");
        popup.document.write(invoice_print);
        popup.document.close();
        popup.focus();
    }
  
      $(document).on("click", ".edit_customer", function (e) {
          let title = $("#edit_profile").val();
          $(".add_customer_title").text(title);
  
          let pos_9 = Number($("#pos_9").val());
          let is_self_order = $("#is_self_order").val();
          if(is_self_order=="Yes"){
              pos_9 = 1;
          }
  
          if(pos_9){
              let selected_customer = $("#walk_in_customer").val();
              if (selected_customer != "") {
                  if (selected_customer == 1) {
                      toastr['error']((txt_err_pos_1), '');
                  } else {
                      get_customer_for_edit(selected_customer);
                  }
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
      });
      /**
       * Add Datepicker in form pos screen
       */
      let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
  
      $(".datepicker_custom")
        .datepicker({
          autoclose: true,
          format: "yyyy-mm-dd",
          startDate: "0",
          todayHighlight: true,
        })
        .datepicker("update", open_invoice_date_hidden);
  
      $(".datepicker_custom").on("changeDate", function (event) {
        $("#open_invoice_date_hidden").val(event.format());
      });
  
      function getPlanText(txt) {
        let new_str = txt.replace(/'/g, " ").replace(/"/g, " ");
        return new_str;
      }
      $(document).on("keyup", "#search_running_orders", function (e) {
        let string = $(this).val().toLowerCase();
        $("#order_details_holder .running_order_custom").each(function (i, obj) {
          let order_number = $(this)
            .find(".running_order_order_number")
            .html()
            .toLowerCase();
          let table_name = $(this)
            .find(".running_order_table_name")
            .html()
            .toLowerCase();
          let waiter_name = $(this)
            .find(".running_order_waiter_name")
            .html()
            .toLowerCase();
          let customer_name = $(this)
            .find(".running_order_customer_name")
            .html()
            .toLowerCase();
          if (order_number.includes(string) ||
            table_name.includes(string) ||
            waiter_name.includes(string) ||
            customer_name.includes(string)
          ) {
            $(this).css("display", "block");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#table_search_input", function (e) {
        let string = $(this).val().toLowerCase();
        $(".single_order_table").each(function (i, obj) {
          let table_name = $(this)
            .attr("data-table_name")
            .toLowerCase();
          let area_name = $(this)
            .attr("data-area_name")
            .toLowerCase();
          if (table_name.includes(string) ||
              area_name.includes(string)
          ) {
            $(this).css("display", "block");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#search_hold_sale", function (e) {
        let string = $(this).val().toLowerCase();
  
        $(".single_hold_sale").each(function (i, obj) {
          let customer_name = $(this).find(".second_column").html().toLowerCase();
          let customer_phone = $(this).find(".third_column").html().toLowerCase();
          if (customer_name.includes(string) || customer_phone.includes(string)) {
            $(this).css("display", "flex");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#search_sales_custom_modal", function (e) {
        let string = $(this).val().toLowerCase();
  
        $(".single_last_ten_sale").each(function (i, obj) {
          let customer_name = $(this).find(".second_column").html().toLowerCase();
          let token_number = $(this).find(".second_column").attr('data-token_number').toLowerCase();
          if (customer_name.includes(string) || token_number.includes(string)) {
            $(this).css("display", "flex");
          } else {
            $(this).css("display", "none");
          }
        });
      });
  
      $(document).on('keydown', '#search', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault(); // Prevent default Enter behavior
                return false;
            }
        });

      $(document).on("keyup", "#search_future_custom_modal", function (e) {
        let string = $(this).val().toLowerCase();
  
        $(".single_future_sale").each(function (i, obj) {
            let sale_no = $(this).find(".first_column").html().toLowerCase();
            let customer_name = $(this).find(".second_column").html().toLowerCase();
            if (customer_name.includes(string) || sale_no.includes(string)) {
            $(this).css("display", "flex");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#search_online_order_custom_modal", function (e) {
        let string = $(this).val().toLowerCase();
  
        $(".single_online_sale").each(function (i, obj) {
          let sale_no = $(this).find(".first_column").html().toLowerCase();
          let customer_name = $(this).find(".second_column").html().toLowerCase();
          if (customer_name.includes(string) || sale_no.includes(string)) {
            $(this).css("display", "flex");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#search_self_order_custom_modal", function (e) {
        let string = $(this).val().toLowerCase();
  
        $(".single_self_sale").each(function (i, obj) {
            let sale_no = $(this).find(".first_column").html().toLowerCase();
            let customer_name = $(this).find(".second_column").html().toLowerCase();
            if (customer_name.includes(string) || sale_no.includes(string)) {
            $(this).css("display", "flex");
          } else {
            $(this).css("display", "none");
          }
        });
      });
      $(document).on("keyup", "#walk_in_customer", function (e) {
        $("#select2-walk_in_customer-container").css("border", "none");
        do_addition_of_item_and_modifiers_price();
      });
      $(document).on("keyup", "#select_waiter", function (e) {
        $("#select2-select_waiter-container").css("border", "none");
      });
      $(document).on("click", "#kitchen_waiter_bar_button", function (e) {
        $("#kitchen_bar_waiter_panel_button_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
      });
      $(document).on("click", "#submit_table_modal", function (e) {
        $("#show_tables_modal2").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
      });
  
      $(document).on("click", ".bottom_add", function (e) {
        let table_id = $(this).attr("id").substr(38);
        let table_name = $(this).attr("data-name");
        let order_number = $(
          "#single_table_order_details_bottom_order_" + table_id
        ).val();
        order_number = order_number == "" ? "New" : order_number;
        let person = $(
          "#single_table_order_details_bottom_person_" + table_id
        ).val();
        let available_sit = $("#sit_available_number_" + table_id).text();
        let sit_capacity_number = $("#sit_capacity_number_" + table_id).text();
  
        let total_person = 0;
  
        $(".person_tbl_" + table_id).each(function () {
          let tmp_v = Number($(this).html());
          total_person += tmp_v;
        });
  
        if (Number(person) + total_person > parseInt(sit_capacity_number)) {
            toastr['error']((exceeciding_seat), '');
          return false;
        }
        let now_available =
          parseInt(sit_capacity_number) - (Number(person) + total_person);
        if (Number(person) + total_person <= 0) {
            toastr['error']((seat_greater_than_zero), '');
          return false;
        }
  
        $("#sit_available_number_" + table_id).html(now_available);
  
        let table_book_row = "";
        table_book_row +=
          '<div class="single_row  new_book_to_table" data-name="'+table_name+'"  id="new_order_table_' +
          table_id +
          '">';
        table_book_row +=
          '<div class="floatleft fix column first_column">' +
          order_number +
          "</div>";
        table_book_row +=
          '<div class="floatleft fix column second_column">-</div>';
        table_book_row +=
          '<div class="floatleft fix column third_column person_tbl_' +
          table_id +
          '">' +
          person +
          "</div>";
        table_book_row +=
          '<div class="floatleft fix column forth_column"><i class="fas fa-trash-alt remove_new_order_row_icon" id="single_row_table_delete_' +
          table_id +
          '"></i></div>';
        table_book_row += "</div>";
        $("#single_table_order_details_top_" + table_id).append(
          $(table_book_row)
        );
        $("#single_table_order_details_bottom_" + table_id).hide();
  
        let new_capacity = Number($("#sit_capacity_number_"+table_id).text());
        let new_available = Number($("#sit_available_number_"+table_id).text());
  
  
          if ((new_capacity-new_available) == 0) {
              $("#single_table_info_holder_" + table_id)
                  .find(".table_image")
                  .attr("src", base_url + "images/no_booked.png");
          }else if(new_available){
              $("#single_table_info_holder_" + table_id)
                  .find(".table_image")
                  .attr("src", base_url + "images/single_booked.png");
          }else{
              $("#single_table_info_holder_" + table_id)
                  .find(".table_image")
                  .attr("src", base_url + "images/full_booked.png");
          }
      });
      $(document).on("focus", "#search_running_orders", function () {
        $(".running_order_right_arrow").parent().parent().css("height", "100%");
        $(".running_order_right_arrow").addClass("rotated");
      });
      $(document).on("blur", "#search_running_orders", function () {
        $(".running_order_right_arrow").parent().parent().css("height", "40px");
        $(".running_order_right_arrow").removeClass("rotated");
      });
      $(document).on("click", ".remove_table_order", function () {
        let orders_table_id = $(this).attr("id").substr(19);
        let this_action = $(this).parent().parent();
        swal(
          {
            title: warning + "!",
            text: are_you_sure_cancel_booking,
            confirmButtonColor: "#3c8dbc",
            confirmButtonText: ok,
            showCancelButton: true,
          },
          function () {
            this_action.remove();
            $.ajax({
              url: base_url + "Sale/remove_a_table_booking_ajax",
              method: "POST",
              data: {
                orders_table_id: orders_table_id,
                csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                response = JSON.parse(response);
                let current_available_sit = $(
                  "#sit_available_number_" + response.table_id
                ).html();
                let cancelled_sit_number = response.persons;
                let new_available_sit =
                  parseInt(current_available_sit) +
                  parseInt(cancelled_sit_number);
                $("#sit_available_number_" + response.table_id).html(
                  new_available_sit
                );
                // $('#single_notification_row_'+response).remove();
              },
              error: function () {
                alert(a_error);
              },
            });
          }
        );
      });
      $(document).on("click", "#please_read_table_modal_button", function (e) {
        $("#please_read_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
      });
      $(document).on(
        "click",
        "#please_read_close_button,#please_read_close_button_cross",
        function (e) {
          $(this).parent().parent().removeClass("active").addClass("inActive");
          setTimeout(function () {
            $(".modal").removeClass("inActive");
          }, 1000);
        }
      );
      $(document).on(
        "click",
        "#table_modal_cancel_button,#proceed_without_table_button",
        function (e) {
          $(".new_book_to_table").remove();
          $(".single_table_order_details_holder .bottom").css("display", "block");
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .removeClass("active")
            .addClass("inActive");
          setTimeout(function () {
            $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
          reset_table_modal();
        }
      );
      $(document).on("click", "#table_modal_cancel_button2", function (e) {
        $(".new_book_to_table").remove();
        $(".single_table_order_details_holder .bottom").css("display", "block");
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay").fadeOut(300);
        reset_table_modal();
      });

      function get_plan_string(sale_no) {
        if(sale_no){
            let formattedString = sale_no.replace(/-/g, '')        
            .replace(/\|\|/g, '')     
            .replace(/,/g, '')         
            .replace(/\s/g, '');      
            return formattedString.toLowerCase();
        }else{
            return '';
        }
        
    }
    
      $(document).on("click", ".remove_new_order_row_icon", function () {
          let this_action = $(this);
          let sale_no  = $(this).parent().parent().find(".first_column").text();
          swal(
              {
                  title: warning + "!",
                  text: are_you_sure,
                  confirmButtonColor: "#3c8dbc",
                  confirmButtonText: ok,
                  showCancelButton: true,
              },
              function () {
                  let this_table_id = this_action.attr("id").substr(24);
                  $.ajax({
                      url: base_url + "Sale/remove_table",
                      method: "POST",
                      dataType:"json",
                      data: {
                          table_id: this_table_id,
                          sale_no: sale_no,
                          csrf_irestoraplus: csrf_value_,
                      },
                      success: function (response) {
  
                          this_action.parent().parent().remove();
                          let person = $(
                              "#single_table_order_details_bottom_person_" + this_table_id
                          ).val();
                          let available_sit = $("#sit_available_number_" + this_table_id).html();
                          let total_person = 0;
                          let sit_capacity_number = $(
                              "#sit_capacity_number_" + this_table_id
                          ).html();
                          $(".person_tbl_" + this_table_id).each(function () {
                              let tmp_v = Number($(this).html());
                              total_person += tmp_v;
                          });
  
                          if (total_person > parseInt(sit_capacity_number)) {
                              toastr['error']((exceeciding_seat), '');
  
                          }
                          let now_available = parseInt(sit_capacity_number) - total_person;
                          if (total_person <= 0) {
                              toastr['error']((seat_greater_than_zero), '');
                              $("#sit_available_number_" + this_table_id).html(now_available);
  
                          }
  
  
                          $("#sit_available_number_" + this_table_id).html(now_available);
  
                          $("#single_table_order_details_bottom_" + this_table_id).css(
                              "display",
                              "block"
                          );
                          $("#single_table_order_details_bottom_person_" + this_table_id).val("1");
  
                          let new_capacity = Number($("#sit_capacity_number_"+this_table_id).text());
                          let new_available = Number($("#sit_available_number_"+this_table_id).text());
  
                          if ((new_capacity-new_available) == 0) {
                              $("#single_table_info_holder_" + this_table_id)
                                  .find(".table_image")
                                  .attr("src", base_url + "images/no_booked.png");
                          }else if(new_available){
  
                              $("#single_table_info_holder_" + this_table_id)
                                  .find(".table_image")
                                  .attr("src", base_url + "images/single_booked.png");
                          }else{
                              $("#single_table_info_holder_" + this_table_id)
                                  .find(".table_image")
                                  .attr("src", base_url + "images/no_booked.png");
                          }
                      },
                      error: function () {
  
                      },
                  });
              }
          );
          
      });
  
  
      $(document).on("keydown", function (e) {
        if (e.ctrlKey && e.shiftKey && e.which == 70) {
          $("#search").focus();
        }
      });
      let interval;
      let tabl_width = 200; 
   
  
      function tableModal() {
        let _body_height = $(window).height();
        $(".select_table_modal_info_holder2").css(
          "height",
          _body_height / 2 + tabl_width + "px"
        );
        $(window).resize(function () {
          let _body_height = $(window).height();
          $(".select_table_modal_info_holder2").css(
            "height",
            _body_height / 2 + tabl_width + "px"
          );
        });
      }
      tableModal();
      $(document).on("click", ".overlayForCalculator", function (e) {
        $("#calculator_main").fadeOut(333);
        $(".overlayForCalculator").fadeOut(111);
        $(".main_left").removeClass("active");
        if ($("show_running_order").attr("data-isActive") === "false") {
          $(".show_running_order").attr("data-isActive", "true");
        } else {
          $(".show_running_order").attr("data-isActive", "false");
        }
      });
  
      $(document).on("click", "#notification_remove_all", function (e) {
          let pos_20 = Number($("#pos_20").val());
          if(pos_20){
              if ($(".single_notification_checkbox:checked").length > 0) {
                  swal(
                      {
                          title: warning + "!",
                          text: are_you_delete_notification,
                          confirmButtonColor: "#3c8dbc",
                          confirmButtonText: ok,
                          showCancelButton: true,
                      },
                      function () {
                          let notifications = "";
                          let j = 1;
                          let checkbox_length = $(
                              ".single_notification_checkbox:checked"
                          ).length;
                          $(".single_notification_checkbox:checked").each(function (i, obj) {
                              if (j == checkbox_length) {
                                  notifications += $(this).val();
                              } else {
                                  notifications += $(this).val() + ",";
                              }
                              j++;
                          });
                          if (notifications != "") {
                              let notifications_array = notifications.split(",");
                              notifications_array.forEach(function (entry) {
                                  $("#single_notification_row_" + entry).remove();
                              });
                              //Then read the values from the array where 0 is the first
                              //Since we skipped the first element in the array, we start at 1
                              $.ajax({
                                  url: base_url + "Sale/remove_multiple_notification_ajax",
                                  method: "POST",
                                  data: {
                                      notifications: notifications,
                                      csrf_irestoraplus: csrf_value_,
                                  },
                                  success: function (response) {
                                      // $('#single_notification_row_'+response).remove();
                                  },
                                  error: function () {
                                      alert(a_error);
                                  },
                              });
                          }
                      }
                  );
              } else {
                  toastr['error']((no_notification_select), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
      });
      $(document).on("click", ".single_serve_b", function () {
          let pos_20 = Number($("#pos_20").val());
          if(pos_20){
              let notification_id = $(this).attr("id").substr(26);
              $.ajax({
                  url: base_url + "Sale/remove_notication_ajax",
                  method: "POST",
                  data: {
                      notification_id: notification_id,
                      csrf_irestoraplus: csrf_value_,
                  },
                  success: function (response) {
                      $("#single_notification_row_" + response).remove();
                  },
                  error: function () {
                      alert(a_error);
                  },
              });
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
      });
      $(document).on("change", "#select_all_notification", function (e) {
        if ($(this).is(":checked")) {
          $(".single_notification_checkbox").prop("checked", true);
        } else {
          $(".single_notification_checkbox").prop("checked", false);
        }
      });
      // for same modal
      $(document).on("click", "#notification_close", function (e) {
        $(".pos__modal__overlay").fadeOut(300);
  
        $(".single_notification_checkbox").prop("checked", false);
        $("#select_all_notification").prop("checked", false);
        $(this)
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
          $("#notification_counter").hide();
        }, 1000);
      });
      // for same modal
      $(document).on("click", "#notification_close2", function (e) {
        $("#notification_list_modal").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
  
        $(".single_notification_checkbox").prop("checked", false);
        $("#select_all_notification").prop("checked", false);
      });
      $(document).on("click", "#notification_button", function (e) {
          let status = true;
          if(!checkInternetConnection()){
              let action_error= $("#action_error").val();
              status = false;
              toastr['error']((action_error), '');
          }
          if(status){
              $("#notification_list_modal").addClass("active");
              $(".pos__modal__overlay").fadeIn(200);
          }
      });
      $(document).on("click", "#open_hold_sales", function (e) {
        $("#show_sale_hold_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        $(".modifier_item_details_holder").empty();
        get_all_hold_sales();
      });
      $(document).on("mouseover", ".single_last_ten_sale", function () {
        $(this).css("background-color", "#f7f7f7");
      });
      $(document).on("mouseout", ".single_last_ten_sale", function () {
        $(this).css("background-color", "#ffffff");
        if ($(this).attr("data-selected") == "selected") {
          $(this).css("background-color", "#f7f7f7");
        }
      });
      $(document).on("click", ".single_hold_sale", function () {
        //get hold id
        let hold_id = $(this).attr("id").substr(5);
        $(".single_hold_sale").css("background-color", "#ffffff");
        $(".single_hold_sale").attr("data-selected", "unselected");
        $(this).css("background-color", "#f7f7f7");
        $(this).attr("data-selected", "selected");
        //get all info of hold based on hold_id
        $.ajax({
          url: base_url + "Sale/get_single_hold_info_by_ajax",
          method: "POST",
          data: {
            hold_id: hold_id,
            csrf_irestoraplus: csrf_value_,
          },
          success: function (response) {
            response = JSON.parse(response);
            console.log(response)
            let order_type = "";
            let order_type_id = 0;
            $("#hold_waiter_id").html(response.waiter_id);
            $("#hold_waiter_name").html(response.waiter_name);
            $("#hold_customer_id").html(response.customer_id);
            $("#hold_customer_name").html(response.customer_name);
            $("#hold_table_id").html(response.table_id);
            $("#hold_table_name").html(response.table_name);
            if (response.order_type == 1) {
              order_type = "Dine In";
              order_type_id = 1;
            } else if (response.order_type == 2) {
              order_type = "Take Away";
              order_type_id = 2;
            } else if (response.order_type == 3) {
              order_type = "Delivery";
              order_type_id = 3;
            }
            $("#hold_order_type").html(order_type);
            $("#hold_order_type_id").html(order_type_id);
            let draw_table_for_hold_order = "";
  
            for (let key in response.items) {
              //construct div
              let this_item = response.items[key];
  
              let selected_modifiers = "";
              let selected_modifiers_id = "";
              let selected_modifiers_price = "";
              let modifiers_price = 0;
              let total_modifier = this_item.modifiers.length;
              let i = 1;
              let item_id = this_item.food_menu_id;
              let draw_table_for_order_tmp_modifier_tax = "";
              for (let mod_key in this_item.modifiers) {
                let this_modifier = this_item.modifiers[mod_key];
                let modifier_id_custom = this_modifier.modifier_id;
                //get selected modifiers
                if (i == total_modifier) {
                  selected_modifiers += this_modifier.name;
                  selected_modifiers_id += this_modifier.modifier_id;
                  selected_modifiers_price += this_modifier.modifier_price;
                  modifiers_price = (
                    parseFloat(modifiers_price) +
                    parseFloat(this_modifier.modifier_price)
                  ).toFixed(ir_precision);
                } else {
                  selected_modifiers += this_modifier.name + ", ";
                  selected_modifiers_id += this_modifier.modifier_id + ",";
                  selected_modifiers_price += this_modifier.modifier_price + ",";
                  modifiers_price = (
                    parseFloat(modifiers_price) +
                    parseFloat(this_modifier.modifier_price)
                  ).toFixed(ir_precision);
                }
                let tax_information = "";
                // iterate over each item in the array
                tax_information = this_modifier.menu_taxes;
                tax_information = IsJsonString(tax_information)
                  ? JSON.parse(tax_information)
                  : "";
                draw_table_for_order_tmp_modifier_tax +=
                  '<span class="item_vat_modifier ir_display_none item_vat_modifier_' +
                  item_id +
                  '" data-item_id="' +
                  item_id +
                  '"  data-modifier_price="' +
                  this_modifier.modifier_price +
                  '" data-modifier_id="' +
                  modifier_id_custom +
                  '" id="item_vat_percentage_table' +
                  item_id +
                  "" +
                  modifier_id_custom +
                  '">' +
                  JSON.stringify(tax_information) +
                  "</span>";
                i++;
              }
              let discount_value =
                this_item.menu_discount_value != ""
                  ? pOrAmount(this_item.menu_discount_value)
                  : parseFloat(0).toFixed(ir_precision);
              draw_table_for_hold_order +=
                '<div class="single_item_modifier fix" id="hold_order_for_item_' +
                this_item.food_menu_id +
                '">';
              draw_table_for_hold_order += '<div class="first_portion">';
              draw_table_for_hold_order +=
                '<span class="item_vat_hold ir_display_none" id="hold_item_vat_percentage_table' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_vat_percentage +
                "</span>";
              draw_table_for_hold_order +=
                '<span class="item_discount_hold ir_display_none" id="hold_item_discount_table' +
                this_item.food_menu_id +
                '">' +
                this_item.discount_amount +
                "</span>";
              draw_table_for_hold_order +=
                '<span class="item_price_without_discount_hold ir_display_none" id="hold_item_price_without_discount_' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_price_without_discount +
                "</span>";
              draw_table_for_hold_order +=
                '<div class="single_order_column_hold first_column column fix"><span id="hold_item_name_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_name +
                "</span></div>";
              draw_table_for_hold_order +=
                '<div class="single_order_column_hold second_column column fix">' +
                currency +
                ' <span id="hold_item_price_table_' +
                this_item.food_menu_id +
                '">' +
                Number(this_item.menu_unit_price).toFixed(ir_precision) +
                "</span></div>";
              draw_table_for_hold_order +=
                '<div class="single_order_column_hold third_column column fix"><span id="hold_item_quantity_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.qty +
                "</span></div>";
              draw_table_for_hold_order +=
                '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="hold_percentage_table_' +
                this_item.food_menu_id +
                '">' +
                discount_value +
                "</span></div>";
              draw_table_for_hold_order +=
                '<div class="single_order_column_hold fifth_column column fix">' +
                currency +
                ' <span id="hold_item_total_price_table_' +
                this_item.food_menu_id +
                '">' +
                Number(this_item.menu_price_with_discount).toFixed(ir_precision) +
                "</span></div>";
              draw_table_for_hold_order += "</div>";
              if (selected_modifiers != "") {
                draw_table_for_hold_order += '<div class="second_portion fix">';
                draw_table_for_hold_order +=
                  '<span id="hold_item_modifiers_id_table_' +
                  this_item.food_menu_id +
                  '" class="ir_display_none">' +
                  selected_modifiers_id +
                  "</span>";
                draw_table_for_hold_order +=
                  '<span id="hold_item_modifiers_price_table_' +
                  this_item.food_menu_id +
                  '" class="ir_display_none">' +
                  selected_modifiers_price +
                  "</span>";
                draw_table_for_hold_order +=
                  '<div class="single_order_column_hold first_column column fix"><span  class="modifier_txt_custom"  id="hold_item_modifiers_table_' +
                  this_item.food_menu_id +
                  '">' +
                  selected_modifiers +
                  "</span></div>";
                draw_table_for_hold_order +=
                  '<div class="single_order_column_hold second_column column fix">' +
                  currency +
                  ' <span id="hold_item_modifiers_price_table_' +
                  this_item.food_menu_id +
                  '">' +
                  (modifiers_price * this_item.qty).toFixed(ir_precision) +
                  "</span></div>";
                draw_table_for_hold_order += "</div>";
              }
             if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                draw_table_for_hold_order += '<div class="third_portion fix">';
                draw_table_for_hold_order +=
                  '<div class="single_order_column_hold first_column column fix modifier_txt_custom">' +
                  note_txt +
                  ': <span id="hold_item_note_table_' +
                  this_item.food_menu_id +
                  '">' +
                  this_item.item_note +
                  "</span></div>";
                draw_table_for_hold_order += "</div>";
              }
  
              draw_table_for_hold_order += "</div>";
            }
            //add to top
            $(".item_modifier_details .modifier_item_details_holder").empty();
            $(".item_modifier_details .modifier_item_details_holder").prepend(
              draw_table_for_hold_order
            );
  
            let total_items_in_cart_with_quantity = 0;
            $(
              ".detail_hold_sale_holder .modifier_item_details_holder .single_item_modifier .first_portion .third_column span"
            ).each(function (i, obj) {
              total_items_in_cart_with_quantity =
                parseInt(total_items_in_cart_with_quantity) +
                parseInt($(this).html());
            });
            $("#total_items_in_cart_hold").html(
              total_items_in_cart_with_quantity
            );
            let sub_total_discount_hold =
              response.sub_total_discount_value != ""
                ? response.sub_total_discount_value
                : (0).toFixed(ir_precision);
            $("#sub_total_show_hold").html(
              Number(response.sub_total).toFixed(ir_precision)
            );
            $("#sub_total_hold").html(
              Number(response.sub_total).toFixed(ir_precision)
            );
            $("#total_item_discount_hold").html(
              response.total_item_discount_amount
            );
            $("#discounted_sub_total_amount_hold").html(
              response.sub_total_discount_amount
            );
            $("#sub_total_discount_hold").html(
              (sub_total_discount_hold)
            );
            $("#sub_total_discount_amount_hold").html(
              Number(response.sub_total_with_discount).toFixed(ir_precision)
            );
            let total_vat_section_to_show = "";
            $.each(JSON.parse(response.sale_vat_objects), function (key, value) {
              total_vat_section_to_show +=
                '<span class="tax_field_order_details" id="tax_field_order_details_' +
                value.tax_field_id +
                '">' +
                value.tax_field_type +
                ": " +
                currency +
                ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                value.tax_field_id +
                '">' +
                Number(value.tax_field_amount).toFixed(ir_precision) +
                "</span></span>";
            });
            $("#all_items_vat_hold").html(total_vat_section_to_show);
            $("#all_items_discount_hold").html(
              Number(response.total_discount_amount).toFixed(ir_precision)
            );
            $("#all_items_vat_hold").html(
              Number(response.vat).toFixed(ir_precision)
            );
            if (Number(response.delivery_charge_actual_charge)) {
              $("#delivery_charge_hold").html(pOrAmount(response.delivery_charge));
            } else {
              $("#delivery_charge_hold").html((0).toFixed(ir_precision));
            }
  
            if (Number(response.tips_amount_actual_charge)) {
              $("#tips_amount_hold").html(Number(response.tips_amount).toFixed(ir_precision));
            } else {
              $("#tips_amount_hold").html((0).toFixed(ir_precision));
            }
  
            $("#total_payable_hold").html(
              Number(response.total_payable).toFixed(ir_precision)
            );
  
            $("#hold_table_name").empty();
            let html_table = "";
            $.each(JSON.parse(response.tables_booked), function (key_t, value_t) {
              html_table += value_t.table_name;
              html_table += ",";
            });
  
            $("#hold_table_name").append(html_table);
          },
          error: function () {
            alert(a_error);
          },
        });
      });
  
      $(document).on("click", ".single_last_ten_sale", function () {
            //get sale id
            let sale_no = $(this).attr("data-sale_no");
  
            $(".single_last_ten_sale").css("background-color", "#ffffff");
            $(".single_last_ten_sale").attr("data-selected", "unselected");
            $(this).css("background-color", "#cfcfcf");
            $(this).attr("data-selected", "selected");
  
            //get all info of recent sale based on sale_id
            getSelectedOrderDetailsRecentSale(sale_no).then(function(data){
                let response = jQuery.parseJSON(data);
                console.log(response)
                let order_type = "";
                let order_type_id = 0;
                let invoice_type = "";
                let tables_booked = "";
  
                $("#last_10_waiter_id").html(response.waiter_id);
                $("#last_10_waiter_name").html(response.waiter_name);
                $("#last_10_customer_id").html(response.customer_id);
                $("#last_10_customer_name").html(response.customer_name);
                $("#last_10_table_id").html(response.table_id);
                $("#last_10_table_name").html((response.orders_table_text!=undefined  && response.orders_table_text?response.orders_table_text:'None'));
                $("#open_invoice_date_hidden").val(response.sale_date);
  
  
                $(".datepicker_custom")
                    .datepicker({
                        autoclose: true,
                        format: "yyyy-mm-dd",
                        startDate: "0",
                        todayHighlight: true,
                    })
                    .datepicker("update", response.sale_date);
  
                $(".change_delivery_address").hide();
                $(".del_hide").show();
  
                if (response.order_type == 1) {
                    order_type = "Dine In";
                    order_type_id = 1;
                } else if (response.order_type == 2) {
                    order_type = "Take Away";
                    order_type_id = 2;
                } else if (response.order_type == 3) {
                    order_type = "Delivery";
                    order_type_id = 3;
                    //$(".change_delivery_address").show();
                    $(".del_hide").hide();
                }
                $("#last_10_order_type").html(order_type);
                $("#last_10_order_type_id").html(order_type_id);
                $("#last_10_order_invoice_no").html(response.sale_no);
                let draw_table_for_last_ten_sales_order = "";
  
                for (let key in response.items) {
                    //construct div
                    let this_item = response.items[key];
  
                    let selected_modifiers = "";
                    let selected_modifiers_id = "";
                    let selected_modifiers_price = "";
                    let modifiers_price = 0;
                    let total_modifier = 0;
                    if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
                        total_modifier = (this_item.modifiers_id.split(',')).length;
                    }
                    let i = 1;
                    let item_id = this_item.food_menu_id;
                    let draw_table_for_order_tmp_modifier_tax = "";
                    let modifier_ids_custom = [];
                    let modifier_names_custom = [];
                    let modifier_prices_custom = [];
                    if(total_modifier){
                        modifier_ids_custom = this_item.modifiers_id.split(',');
                        modifier_names_custom = this_item.modifiers_name.split(',');
                        modifier_prices_custom = this_item.modifiers_price.split(',');
                    }
                    let discount_value =
                        this_item.menu_discount_value != ""
                            ? pOrAmount(this_item.menu_discount_value)
                            : parseFloat(0).toFixed(ir_precision);
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_item_modifier fix" id="last_10_order_for_item_' +
                        this_item.food_menu_id +
                        '">';
                    draw_table_for_last_ten_sales_order +=
                        '<div class="first_portion">';
                    draw_table_for_last_ten_sales_order +=
                        '<span class="item_vat_hold ir_display_none" id="last_10_item_vat_percentage_table' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.menu_vat_percentage +
                        "</span>";
                    draw_table_for_last_ten_sales_order +=
                        '<span class="item_discount_hold ir_display_none" id="last_10_item_discount_table' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.discount_amount +
                        "</span>";
                    draw_table_for_last_ten_sales_order +=
                        '<span class="item_price_without_discount_hold ir_display_none" id="last_10_item_price_without_discount_' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.menu_price_without_discount +
                        "</span>";
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_order_column_hold first_column column fix"><span id="last_10_item_name_table_' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.menu_name +
                        "</span></div>";
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_order_column_hold second_column column fix">' +
                        currency +
                        ' <span id="last_10_item_price_table_' +
                        this_item.food_menu_id +
                        '">' +
                        Number(this_item.menu_unit_price).toFixed(ir_precision) +
                        "</span></div>";
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_order_column_hold third_column column fix"><span id="last_10_item_quantity_table_' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.qty +
                        "</span></div>";
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="last_10_percentage_table_' +
                        this_item.food_menu_id +
                        '">' +
                        discount_value +
                        "</span></div>";
                    draw_table_for_last_ten_sales_order +=
                        '<div class="single_order_column_hold fifth_column column fix">' +
                        currency +
                        ' <span id="last_10_item_total_price_table_' +
                        this_item.food_menu_id +
                        '">' +
                        this_item.menu_price_with_discount +
                        "</span></div>";
                    draw_table_for_last_ten_sales_order += "</div>";
  
                    if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                        draw_table_for_last_ten_sales_order +=
                            '<div class="third_portion">';
                        draw_table_for_last_ten_sales_order +=
                            '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                            combo_txt +
                            ': <span id="last_10_item_combo_table_' +
                            this_item.food_menu_id +
                            '">' +
                            this_item.menu_combo_items +
                            "</span></div>";
                        draw_table_for_last_ten_sales_order += "</div>";
                    }
                    if (total_modifier) {
                        draw_table_for_last_ten_sales_order += '<div class="second_portion">';
                        draw_table_for_last_ten_sales_order +=
                            '<span id="order_details_item_modifiers_id_table_' +
                            this_item.food_menu_id +
                            '" class="ir_display_none">' +
                            selected_modifiers_id +
                            "</span>";
                        draw_table_for_last_ten_sales_order +=
                            '<span id="order_details_item_modifiers_price_table_' +
                            this_item.food_menu_id +
                            '" class="ir_display_none">' +
                            selected_modifiers_price +
                            "</span>";
                        draw_table_for_last_ten_sales_order +=
                            '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                            this_item.food_menu_id +
                            '">' +
                            selected_modifiers +
                            "</span></div>";
                        draw_table_for_last_ten_sales_order +=
                            '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                            currency +
                            ' <span id="order_details_item_modifiers_price_table_' +
                            this_item.food_menu_id +
                            '">' +
                            modifiers_price +
                            "</span></div>";
                        for (let mod_key in modifier_names_custom) {
                            let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                            let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                            draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                            draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                        }
                        draw_table_for_last_ten_sales_order += "</div>";
                    }
                    if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                        draw_table_for_last_ten_sales_order +=
                            '<div class="third_portion">';
                        draw_table_for_last_ten_sales_order +=
                            '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                            note_txt +
                            ': <span id="last_10_item_note_table_' +
                            this_item.food_menu_id +
                            '">' +
                            this_item.item_note +
                            "</span></div>";
                        draw_table_for_last_ten_sales_order += "</div>";
                    }
  
                    draw_table_for_last_ten_sales_order += "</div>";
                }
                //add to top
                $(".item_modifier_details .modifier_item_details_holder").empty();
                $(".item_modifier_details .modifier_item_details_holder").prepend(
                    draw_table_for_last_ten_sales_order
                );
                let total_items_in_cart_with_quantity = 0;
                $(
                    ".last_ten_sales_holder .modifier_item_details_holder .single_item_modifier .first_portion .third_column span"
                ).each(function (i, obj) {
                    total_items_in_cart_with_quantity =
                        parseInt(total_items_in_cart_with_quantity) +
                        parseInt($(this).html());
                });
                $("#total_items_in_cart_last_10").html(
                    total_items_in_cart_with_quantity
                );
                let sub_total_discount_last_10 =
                    response.sub_total_discount_value != ""
                        ? pOrAmount(response.sub_total_discount_value)
                        : parseFloat(0).toFixed(ir_precision);
                $("#sub_total_show_last_10").html(Number(response.sub_total).toFixed(ir_precision));
                $("#sub_total_last_10").html(Number(response.sub_total).toFixed(ir_precision));
                $("#total_item_discount_last_10").html(
                    response.total_item_discount_amount
                );
                $("#discounted_sub_total_amount_last_10").html(
                    response.sub_total_discount_amount
                );
                $("#sub_total_discount_last_10").html(
                    pOrAmount(sub_total_discount_last_10)
                );
                $("#sub_total_discount_amount_last_10").html(Number(response.sub_total_with_discount).toFixed(ir_precision));
                let total_vat_section_to_show = "";
                let total_vat_show = 0;
                $.each((response.sale_vat_objects), function (key, value) {
                    total_vat_section_to_show +=
                        '<span class="tax_field_order_details" id="tax_field_order_details_' +
                        value.tax_field_id +
                        '">' +
                        value.tax_field_type +
                        ":  " +
                        currency +
                        ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                        value.tax_field_id +
                        '">' +
                        Number(value.tax_field_amount).toFixed(ir_precision) +
                        "</span></span>";
                    total_vat_show+=(Number(value.tax_field_amount));
                });
                $("#all_items_vat_last_10").html(total_vat_section_to_show);
                $("#all_items_discount_last_10").html(
                    Number(response.total_discount_amount).toFixed(ir_precision)
                );
  
                if (Number(response.delivery_charge_actual_charge)) {
                    $("#delivery_charge_last_10").html(pOrAmount(response.delivery_charge));
                } else {
                    $("#delivery_charge_last_10").html((0).toFixed(ir_precision));
                }
  
                if (Number(response.tips_amount_actual_charge)) {
                    $("#tips_amount_last_10").html(pOrAmount(response.tips_amount));
                } else {
                    $("#tips_amount_last_10").html((0).toFixed(ir_precision));
                }
  
                $("#total_payable_last_10").html(
                    Number(response.total_payable).toFixed(ir_precision)
                );
                $("#recent_sale_modal_details_vat").html(
                    Number(total_vat_show).toFixed(ir_precision)
                );
            });
        });
  
      $(document).on("click", "#delete_all_hold_sales_button", function (e) {
        if ($(".detail_hold_sale_holder .single_hold_sale").length > 0) {
          swal(
            {
              title: warning + "!",
              text: are_you_delete_all_hold_sale,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
              //delete all information of hold based on hold_id
              $.ajax({
                url: base_url + "Sale/delete_all_holds_with_information_by_ajax",
                method: "POST",
                data: {
                  csrf_irestoraplus: csrf_value_,
                },
                success: function (response) {
                  if (response == 1) {
                    $(
                      ".hold_sale_modal_info_holder .detail_hold_sale_holder .hold_sale_left .detail_holder"
                    ).empty();
                  }
  
                  $("#hold_waiter_id").html("");
                  $("#hold_waiter_name").html("");
                  $("#hold_customer_id").html("");
                  $("#hold_customer_name").html("");
                  $("#hold_table_id").html("");
                  $("#hold_table_name").html("");
                  $("#hold_order_type").html("");
                  $("#hold_order_type_id").html("");
                  $(
                    ".item_modifier_details .modifier_item_details_holder"
                  ).empty();
                  $("#total_items_in_cart_hold").html("0");
                  $("#sub_total_show_hold").html(Number(0).toFixed(ir_precision));
                  $("#sub_total_hold").html(Number(0).toFixed(ir_precision));
                  $("#total_item_discount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#discounted_sub_total_amount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#sub_total_discount_hold").html("");
                  $("#sub_total_discount_amount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
                  $("#all_items_discount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
                  $("#delivery_charge_hold").html(Number(0).toFixed(ir_precision));
                  $("#tips_amount_hold").html(Number(0).toFixed(ir_precision));
                  $("#total_payable_hold").html(Number(0).toFixed(ir_precision));
  
                  $("#show_sale_hold_modal").removeClass("active");
                  $(".pos__modal__overlay").fadeOut(300);
                },
                error: function () {
                  alert(a_error);
                },
              });
            }
          );
        } else {
            toastr['error']((no_hold), '');
        }
      });
      $(document).on("click", "#hold_delete_button", function (e) {
        if ($(".single_hold_sale[data-selected=selected]").length > 0) {
          let hold_id = $(".single_hold_sale[data-selected=selected]")
            .attr("id")
            .substr(5);
          swal(
            {
              title: warning + "!",
              text: sure_delete_this_hold,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
              //delete all information of hold based on hold_id
              $.ajax({
                url: base_url + "Sale/delete_all_information_of_hold_by_ajax",
                method: "POST",
                data: {
                  hold_id: hold_id,
                  csrf_irestoraplus: csrf_value_,
                },
                success: function (response) {
                  get_all_hold_sales();
                  $("#hold_waiter_id").html("");
                  $("#hold_waiter_name").html("");
                  $("#hold_customer_id").html("");
                  $("#hold_customer_name").html("");
                  $("#hold_table_id").html("");
                  $("#hold_table_name").html("");
                  $("#hold_order_type").html("");
                  $("#hold_order_type_id").html("");
                  $(
                    ".item_modifier_details .modifier_item_details_holder"
                  ).empty();
                  $("#total_items_in_cart_hold").html("0");
                  $("#sub_total_show_hold").html(Number(0).toFixed(ir_precision));
                  $("#sub_total_hold").html(Number(0).toFixed(ir_precision));
                  $("#total_item_discount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#discounted_sub_total_amount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#sub_total_discount_hold").html("");
                  $("#sub_total_discount_amount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
                  $("#all_items_discount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
                  $("#delivery_charge_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#tips_amount_hold").html(
                    Number(0).toFixed(ir_precision)
                  );
                  $("#total_payable_hold").html(Number(0).toFixed(ir_precision));
                  // $('#show_sale_hold_modal').slideUp(333);
                },
                error: function () {
                  alert(a_error);
                },
              });
            }
          );
        } else {
          toastr['error']((please_select_hold_sale), '');
        }
      });
        $(document).on("click", "#last_ten_delete_button", function (e) {
            let pos_14 = Number($("#pos_14").val());
            if(pos_14){
                if ($(".single_last_ten_sale[data-selected=selected]").length > 0) {
                    let sale_id = $(".single_last_ten_sale[data-selected=selected]")
                        .attr("id")
                        .substr(9);
                    if (role != "Admin") {
                        toastr['error']((delete_only_for_admin), '');
                    } else {
                        swal(
                            {
                                title: warning + "!",
                                text: sure_delete_this_order,
                                confirmButtonColor: "#3c8dbc",
                                confirmButtonText: ok,
                                showCancelButton: true,
                            },
                            function () {
                                //delete all information of sale based on sale_id
                                delete_from_recent_sales(sale_id);
                                $("#last_ten_" + sale_id).remove();
                                $(".modifier_item_details_holder").empty();
                                $("#last_10_order_type").html("");
                                $("#last_10_order_invoice_no").html("");
                                $("#last_10_waiter_name").html("");
                                $("#last_10_customer_name").html("");
                                $("#last_10_table_name").html("");
                                $("#total_items_in_cart_last_10").html("0");
                                $("#sub_total_show_last_10").html(
                                    Number(0).toFixed(ir_precision)
                                );
                                $("#sub_total_discount_last_10").html(
                                    Number(0).toFixed(ir_precision)
                                );
                                $("#all_items_discount_last_10").html(
                                    Number(0).toFixed(ir_precision)
                                );
                                $("#recent_sale_modal_details_vat").html(
                                    Number(0).toFixed(ir_precision)
                                );
                                $("#delivery_charge_last_10").html(
                                    Number(0).toFixed(ir_precision)
                                );
                                $("#total_payable_last_10").html(
                                    Number(0).toFixed(ir_precision)
                                );
  
                            }
                        );
                    }
                } else {
                    toastr['error']((please_select_an_order), '');
                }
            }else{
                toastr['error']((menu_not_permit_access + "!"), '');
            }
  
        });
      $(document).on("click", "#last_ten_print_invoice_button", function (e) {
        $("#print_type").val(1);
        if ($(".single_last_ten_sale[data-selected=selected]").length > 0) {
          let sale_no = $(".single_last_ten_sale[data-selected=selected]")
            .attr("data-sale_no");
          print_invoiceResent(sale_no);
        } else {
           toastr['error']((please_select_an_order), '');
        }
      });
      $(document).on("click", "#print_last_invoice", function (e) {
          let pos_13 = Number($("#pos_13").val());
          if(pos_13){
  
              $("#print_type").val(1);
              let sale_no = localStorage['last_sale_id'];
              if (sale_no) {
                  print_invoice(sale_no);
              } else {
                  toastr['error']((txt_err_pos_4), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
      $(document).on("click", "#hold_edit_in_cart_button", function (e) {
        let this_action = $(this);
        let hold_id = $(".single_hold_sale[data-selected=selected]")
          .attr("id")
          .substr(5);
        if ($(".single_hold_sale[data-selected=selected]").length > 0) {
          //get total items in cart
          let total_items_in_cart = $(".order_holder .single_order").length;
  
          if (total_items_in_cart > 0) {
            swal(
              {
                title: warning + "!",
                text: cart_not_empty,
                confirmButtonColor: "#3c8dbc",
                confirmButtonText: ok,
                showCancelButton: true,
              },
              function () {
                $(".order_holder").empty();
                clearFooterCartCalculation();
                get_details_of_a_particular_hold(hold_id, this_action);
              }
            );
          } else {
            clearFooterCartCalculation();
            get_details_of_a_particular_hold(hold_id, this_action);
          }
        } else {
            toastr['error']((please_select_hold_sale), '');
        }
      });
      $(document).on(
        "click",
        "#hold_sales_close_button,#hold_sales_close_button_cross",
        function (e) {
          $("#hold_waiter_id").html("");
          $("#hold_waiter_name").html("");
          $("#hold_customer_id").html("");
          $("#hold_customer_name").html("");
          $("#hold_table_id").html("");
          $("#hold_table_name").html("");
          $("#hold_order_type").html("");
          $("#hold_order_type_id").html("");
  
          $(".item_modifier_details .modifier_item_details_holder").empty();
          $("#total_items_in_cart_hold").html("0");
          $("#sub_total_show_hold").html(Number(0).toFixed(ir_precision));
          $("#sub_total_hold").html(Number(0).toFixed(ir_precision));
          $("#total_item_discount_hold").html(Number(0).toFixed(ir_precision));
          $("#discounted_sub_total_amount_hold").html(
            Number(0).toFixed(ir_precision)
          );
          $("#sub_total_discount_hold").html("");
          $("#sub_total_discount_amount_hold").html(
            Number(0).toFixed(ir_precision)
          );
          $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
          $("#all_items_discount_hold").html(Number(0).toFixed(ir_precision));
          $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
          $("#delivery_charge_hold").html(Number(0).toFixed(ir_precision));
          $("#tips_amount_hold").html(Number(0).toFixed(ir_precision));
          $("#total_payable_hold").html(Number(0).toFixed(ir_precision));
  
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .removeClass("active")
            .addClass("inActive");
          setTimeout(function () {
            $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
        }
      );
      $(document).on("click", "#create_bill_and_close", function (e) {
          let pos_12 = Number($("#pos_12").val());
          if(pos_12){
  
              $("#print_type").val(2);
              if (
                  $(".holder .order_details > .single_order[data-selected=selected]")
                      .length > 0
              ) {

                  let sale_no = $(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                  
                  let res = getSelectedOrderDetails(sale_no).then(function(data){
                      // var response = jQuery.parseJSON(data);
                      if(data !== null) {
                          if(checkInternetConnection()){
                              let print_type_bill = $(".print_type_bill").val();
                              if (print_type_bill == "web_browser_popup") {
                                  print_bill(data,sale_no);
                              }else if (print_type_bill == "direct_print"){
                                  $.ajax({
                                      url: base_url + "Authentication/printSaleBillByAjax",
                                      method: "post",
                                      dataType: "json",
                                      data: {
                                        sale_no: sale_no,
                                          data_order: data,
                                      },
                                      success: function (data) {
                                          if (data.printer_server_url) {
                                              $.ajax({
                                                  url:
                                                  data.printer_server_url +
                                                  "print_server/irestora_printer_server.php",
                                                  method: "post",
                                                  dataType: "json",
                                                  data: {
                                                      content_data: JSON.stringify(data.content_data),print_type:data.print_type,
                                                  },
                                                  success: function (data) {},
                                                  error: function () {},
                                              });
                                          }
                                      },
                                      error: function () {},
                                  });
                              }
                          }else{
                              print_bill(data,sale_no)
                          }
                          $("#finalize_order_modal").removeClass("active");
                          $(".pos__modal__overlay").fadeOut(300);
  
                      } else {
                          console.log(sale_no + " => This id not found into the Database, Please reload your page");
                      }
                  });
              } else {
                  swal({
                      title: warning + "!",
                      text: please_select_order_to_proceed + "!",
                      confirmButtonText: ok,
                      confirmButtonColor: "#b6d6f6",
                  });
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
      $(document).on(
          "click",
          "#create_invoice_and_close_old,#order_details_create_invoice_close_order_button",
          function (e) {
              let pos_11 = Number($("#pos_11").val());
              if(pos_11){
                  $("#print_type").val(1);
                  if (
                      $(".holder .order_details > .single_order[data-selected=selected]")
                          .length > 0
                  ) {
                    let sale_no = $(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                      if(pre_or_post_payment==2) {
                           let resq = getSelectedOrderDetails(sale_no).then(function(data){
                              let is_invoice = data.is_invoice;
                              if (is_invoice == 2) {
                                  let invoiced_error = $("#invoiced_error").val();
                                  toastr['error']((invoiced_error + "!"), '');
                              } else {
                                  let res = getSelectedOrderDetails(sale_no).then(function(data){
                                      let response = jQuery.parseJSON(data);
                                      if(response !== null) {
                                          $(".empty_title").show();
                                          $("#payment_list_div").html('');
  
                                          if(response.orders_table_text){
                                            $(".table_number").parent().show();
                                            $(".table_number").html(response.orders_table_text);
                                            }else{
                                                $(".table_number").html("-");
                                                $(".table_number").parent().hide();
                                            }
                
                                            if(response.order_time){
                                                $(".order_taking_time").parent().show();
                                                $(".order_taking_time").html(response.order_time);
                                            }else{
                                                $(".order_taking_time").html("-");
                                                $(".order_taking_time").parent().hide();
                                            }
                                            
                                          $("#finalize_total_payable").html(Number(response.total_payable).toFixed(ir_precision));
                                          $("#finalize_total_payable").attr('data-original_payable',Number(response.total_payable).toFixed(ir_precision));
                                          $("#finalize_total_due").html(response.total_payable);
                                          $("#selected_invoice_sale_customer").val(response.customer_id);
                                          $("#pay_amount_invoice_input").val(response.total_payable);
  
                                          $("#order_payment_modal").removeClass("inActive");
                                          $("#order_payment_modal").addClass("active");
                                          $(".pos__modal__overlay").fadeIn(200);
                                          checkSMSDisabled(response.customer_id);
  
                                          $("#open_invoice_date_hidden").val(response.sale_date);
  
                                          if(Number(response.previous_due_tmp)){
                                              $(".previous_due_div").css('opacity','1');
                                              $("#finalize_previous_due").html(Number(response.previous_due_tmp).toFixed(ir_precision));
  
                                          }else{
                                              $(".previous_due_div").css('opacity','0');
                                          }
                                          $("#is_multi_currency").val('');
                                          $(".set_no_access").removeClass('no_access');
                                          $(".finalize_modal_is_mul_currency").hide(300);
                                          $("#finalize_amount_input").html('');
                                          $(".badge_custom").remove();
                                          $(".previous_due_div").show();
                                          $(".loyalty_point_div").hide();
                                          //cart details button
                                          $("#cart_modal_total_item_text").html(Number(response.total_items_in_cart).toFixed(0));
                                          $("#cart_modal_total_subtotal_text").html(Number(response.sub_total).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_text").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_all_text").html(Number(response.total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(response.total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_tax_text").html(Number(response.total_vat).toFixed(ir_precision));
                                          $("#cart_modal_total_charge_text").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                                          $("#cart_modal_total_tips_text").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                                          $("#cart_modal_total_rounding_texts").html(Number(response.rounding_amount_hidden).toFixed(ir_precision));
  
  
                                          set_default_payment();
                                          cal_finalize_modal('');
                                          $(".datepicker_custom")
                                              .datepicker({
                                                  autoclose: true,
                                                  format: "yyyy-mm-dd",
                                                  startDate: "0",
                                                  todayHighlight: true,
                                              })
                                              .datepicker("update", response.sale_date);
  
                                          $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
                                      }
                                  });
                              }
                          });
                      }else{
                          let res = getSelectedOrderDetails(sale_no).then(function(data){
                              let response = jQuery.parseJSON(data);
                              if(response !== null) {
                                  $(".empty_title").show();
                                  $("#payment_list_div").html('');
  
                                  if(response.orders_table_text){
                                    $(".table_number").parent().show();
                                    $(".table_number").html(response.orders_table_text);
                                    }else{
                                        $(".table_number").html("-");
                                        $(".table_number").parent().hide();
                                    }
        
                                    if(response.order_time){
                                        $(".order_taking_time").parent().show();
                                        $(".order_taking_time").html(response.order_time);
                                    }else{
                                        $(".order_taking_time").html("-");
                                        $(".order_taking_time").parent().hide();
                                    }
                                    
                                  $("#finalize_total_payable").html(Number(response.total_payable).toFixed(ir_precision));
                                  $("#finalize_total_payable").attr('data-original_payable',Number(response.total_payable).toFixed(ir_precision));
                                  $("#finalize_total_due").html(response.total_payable);
                                  $("#selected_invoice_sale_customer").val(response.customer_id);
                                  $("#pay_amount_invoice_input").val(response.total_payable);
  
                                  $("#order_payment_modal").removeClass("inActive");
                                  $("#order_payment_modal").addClass("active");
                                  $(".pos__modal__overlay").fadeIn(200);
                                  checkSMSDisabled(response.customer_id);
  
                                  $("#open_invoice_date_hidden").val(response.sale_date);
  
                                  if(Number(response.previous_due_tmp)){
                                      $(".previous_due_div").css('opacity','1');
                                      $("#finalize_previous_due").html(Number(response.previous_due_tmp).toFixed(ir_precision));
  
                                  }else{
                                      $(".previous_due_div").css('opacity','0');
                                  }
                                  $("#is_multi_currency").val('');
                                  $(".set_no_access").removeClass('no_access');
                                  $(".finalize_modal_is_mul_currency").hide(300);
                                  $("#finalize_amount_input").html('');
                                  $(".badge_custom").remove();
                                  $(".previous_due_div").show();
                                  $(".loyalty_point_div").hide();
                                  //cart details button
                                  $("#cart_modal_total_item_text").html(Number(response.total_items_in_cart).toFixed(0));
                                  $("#cart_modal_total_subtotal_text").html(Number(response.sub_total).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_text").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_all_text").html(Number(response.total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(response.total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_tax_text").html(Number(response.total_vat).toFixed(ir_precision));
                                  $("#cart_modal_total_charge_text").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                                  $("#cart_modal_total_tips_text").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                                  $("#cart_modal_total_rounding_texts").html(Number(response.rounding_amount_hidden).toFixed(ir_precision));
  
  
                                  set_default_payment();
                                  cal_finalize_modal('');
                                  $(".datepicker_custom")
                                      .datepicker({
                                          autoclose: true,
                                          format: "yyyy-mm-dd",
                                          startDate: "0",
                                          todayHighlight: true,
                                      })
                                      .datepicker("update", response.sale_date);
  
                                  $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
                              }
                          });
                      }
  
  
  
                  } else {
                      toastr['error']((please_select_order_to_proceed + "!"), '');
                  }
              }else{
                  toastr['error']((menu_not_permit_access + "!"), '');
              }
  
  
  
  
  
          }
      );
      $(document).on("keyup", "#given_amount_input", function (e) {
        let this_value = $.trim($(this).val());
        if (isNaN(this_value)) {
          $(this).val("");
        }
        //get the value of the delivery charge amount
        let given_amount = $(this).val() != "" ? $(this).val() : 0;
  
        //check wether value is valid or not
        remove_last_two_digit_without_percentage(given_amount, $(this));
  
        given_amount = $(this).val() != "" ? $(this).val() : 0;
        let total_payable = $("#finalize_total_payable").html();
        let total_change = (
          parseFloat(given_amount) - parseFloat(total_payable)
        ).toFixed(ir_precision);
        $("#change_amount_input").val(total_change);
      });
      $(document).on("keyup", "#pay_amount_invoice_input", function (e) {
        let this_value = $.trim($(this).val());
        if (isNaN(this_value)) {
          $(this).val("");
        }
        let paid_amount = $(this).val() != "" ? $(this).val() : 0;
  
        remove_last_two_digit_without_percentage(paid_amount, $(this));
        calculate_create_invoice_modal();
      });
      $(document).on("click", "#finalize_order_cancel_button", function (e) {
        reset_finalize_modal();
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay").fadeOut(300);
      });
      $(document).on("click", "#previous_category", function (e) {
        let parent_width = Math.ceil($(".select_category_inside").width());
        let child_width = Math.ceil($(".select_category_inside_inside").width());
        let fixed_to_move = child_width - parent_width;
        let current_position = parseInt(
          $(".select_category_inside_inside").css("margin-left")
        );
        let updated_position = current_position + 50;
        let update_position_unsigned = Math.abs(updated_position);
        if (0 > updated_position) {
          $(".select_category_inside_inside").css(
            "margin-left",
            updated_position + "px"
          );
        } else if (0 < updated_position) {
          $(".select_category_inside_inside").css("margin-left", "0px");
        }
      });
  
      $(document).on("click", "#help_button", function (e) {
        $("#help_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
      });
      $(document).on(
        "click",
        "#help_close_button,#help_close_button_cross",
        function (e) {
          $(this).parent().parent().removeClass("active").addClass("inActive");
          setTimeout(function () {
            $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
        }
      );
  
      $(document).on(
        "click",
        "#kitchen_bar_waiter_modal_close_button_cross",
        function (e) {
          $("#kitchen_bar_waiter_panel_button_modal").slideUp(333);
        }
      );
      $(document).on("click", "#next_category", function (e) {
        let parent_width = Math.ceil($(".select_category_inside").width());
        let child_width = Math.ceil($(".select_category_inside_inside").width());
        let fixed_to_move = child_width - parent_width;
        let current_position = parseInt(
          $(".select_category_inside_inside").css("margin-left")
        );
        let updated_position = current_position - 50;
        let update_position_unsigned = Math.abs(updated_position);
        if (fixed_to_move > update_position_unsigned) {
          $(".select_category_inside_inside").css(
            "margin-left",
            updated_position + "px"
          );
        } else {
          $(".select_category_inside_inside").css(
            "margin-left",
            "-" + fixed_to_move + "px"
          );
        }
      });
      //this is to set height when site load
      let height_should_be =
        parseInt($(window).height()) -
        parseInt($(".top_header_part").height()) -
        20;
      // $(".main_left").css("height", height_should_be + "px");
      // $(".main_middle").css("height", height_should_be + "px");
      // $(".main_right").css("height", height_should_be - 10 + "px");
      //end
  
      //load first category's items default at site load
      $(".specific_category_items_holder:first").show("1000");
  
      //end
  
      //get all images based on category when category button is clicked
      $(document).on("click", ".category_button", function (e) {
        let str = $(this).attr("id");
        let res = str.substr(16);
        $("#searched_item_found").remove();
        $(".specific_category_items_holder").fadeOut(0);
        $("#category_" + res).css("display", "grid");
      });
      //get all images based on category when category button is clicked
      $(document).on("click", ".veg_bev_item", function (e) {
        let status = $(this).attr("data-status");
        $(".specific_category_items_holder").fadeOut(0);
        let foundItems = searchItemAndConstructGallery("");
        let searched_category_items_to_show =
          '<div id="searched_item_found" class="specific_category_items_holder 003">';
        for (let key in foundItems) {
            if (foundItems.hasOwnProperty(key)) {
                if (status == "veg" && foundItems[key].veg_item_status == "yes") {
                    if (foundItems[key].parent_id == '0') {
                        searched_category_items_to_show +=
                            '<div class="single_item animate__animated animate__flipInX"   data-price="' + foundItems[key].price + '"  data-price_take="' + foundItems[key].price_take + '"    data-is_variation="' + foundItems[key].is_variation + '"  data-parent_id="' + foundItems[key].parent_id + '"    data-price_delivery="' + foundItems[key].price_delivery + '"  id="item_' +
                            foundItems[key].item_id +
                            '">';
                        searched_category_items_to_show +=
                            '<img src="' + foundItems[key].image + '" alt="" width="141">';
                        searched_category_items_to_show +=
                            '<p class="item_name" data-tippy-content="' +
                            foundItems[key].item_name +
                            '">' +
                            foundItems[key].item_name +"</p>";
                        searched_category_items_to_show +=
                            '<p class="item_price">' +
                            price_txt +
                            ": " +
                            foundItems[key].price +
                            "</p>";
  
                        searched_category_items_to_show += "</div>";
                    }
                } else if (
                    status == "bev" &&
                    foundItems[key].beverage_item_status == "yes"
                ) {
                    if (foundItems[key].parent_id == '0') {
                        searched_category_items_to_show +=
                            '<div class="single_item animate__animated animate__flipInX"  data-price="' + foundItems[key].price + '"  data-price_take="' + foundItems[key].price_take + '"    data-is_variation="' + foundItems[key].is_variation + '"  data-parent_id="' + foundItems[key].parent_id + '"   data-price_delivery="' + foundItems[key].price_delivery + '"  id="item_' +
                            foundItems[key].item_id +
                            '">';
                        searched_category_items_to_show +=
                            '<img src="' + foundItems[key].image + '" alt="" width="141">';
                        searched_category_items_to_show +=
                            '<p class="item_name" data-tippy-content="' +
                            foundItems[key].item_name +
                            '">' +
                            foundItems[key].item_name +
                            "</p>";
                        searched_category_items_to_show +=
                            '<p class="item_price">' +
                            price_txt +
                            ": " +
                            foundItems[key].price +
                            "</p>";
  
                        searched_category_items_to_show += "</div>";
                    }
                }
            }
        }
        searched_category_items_to_show += "<div>";
        $("#searched_item_found").remove();
        $(".specific_category_items_holder").fadeOut(0);
        $(".category_items").prepend(searched_category_items_to_show);
  
        if(food_menu_tooltip=="show"){
            tippy(".item_name", {
                placement: "bottom-start",
            });
        }
  
      });
      function getOrderTime() {
          return (Number(Math.floor(Math.random() * (6 - 1 + 1) + 3))).toFixed(ir_precision);
      }
      //when anything is searched
      $(document).on("keyup", "#search", function (e) {
        // if (e.keyCode == 13) {
        let searched_string = $(this).val().trim();
        if (searched_string) {
          let foundItems = searchItemAndConstructGallery(searched_string);
          let searched_category_items_to_show =
            '<div id="searched_item_found" class="specific_category_items_holder 002">';
          for (let key in foundItems) {
              if (foundItems.hasOwnProperty(key)) {
                  if (foundItems[key].parent_id == '0') {
                      searched_category_items_to_show +=
                          '<div class="single_item animate__animated animate__flipInX"  data-price="' + foundItems[key].price + '"  data-price_take="' + foundItems[key].price_take + '"    data-is_variation="' + foundItems[key].is_variation + '"  data-parent_id="' + foundItems[key].parent_id + '"   data-price_delivery="' + foundItems[key].price_delivery + '"  id="item_' +
                          foundItems[key].item_id +
                          '">';
                      searched_category_items_to_show +=
                          '<img src="' + foundItems[key].image + '" alt="" width="141">';
                      searched_category_items_to_show +=
                          '<p class="item_name" data-tippy-content="' +
                          foundItems[key].item_name +
                          '">' +
                          foundItems[key].item_name +
                          "</p>";
                      searched_category_items_to_show +=
                          '<p class="item_price">' +
                          price_txt +
                          ": " +
                          foundItems[key].price +
                          "</p>";
                      searched_category_items_to_show +=
                          '<span class="item_vat_percentage ir_display_none">' +
                          foundItems[key].vat_percentage +
                          "</span>";
                      searched_category_items_to_show += "</div>";
                  }
              }
          }
          searched_category_items_to_show += "<div>";
          $("#searched_item_found").remove();
          $(".specific_category_items_holder").fadeOut(0);
          $(".category_items").prepend(searched_category_items_to_show);
          // }
            if(food_menu_tooltip=="show"){
                tippy(".item_name", {
                    placement: "bottom-start",
                });
            }
        } else {
            show_all_items();
        }
      });
      $(document).on(
        "click",
        ".dine_in_button,.take_away_button,.delivery_button",
        function (e) {
            let total_items_in_cart = $(".order_holder .single_order").length;
            let this_action = $(this);
        
            let this_action_active = $(this).attr("data-selected"); 
            let place_edit_order = $("#place_edit_order").text(); 
               let is_edit_click = Number($("#is_edit_click").val());  
            
            if(this_action_active=="selected" && is_edit_click==2){
                return false;
            }

            if (total_items_in_cart > 0) {
                swal(
                    {
                        title: warning + "!",
                        text: order_type_changing_alert,
                        confirmButtonColor: "#3c8dbc",
                        confirmButtonText: ok,
                        showCancelButton: true,
                    },
                    function () {
                        $(".order_table_holder .order_holder").empty();
                        clearFooterCartCalculation();
  
                        $("#dine_in_button").css("border", "unset");
                        $("#take_away_button").css("border", "unset");
                        $("#delivery_button").css("border", "unset");
  
                        //set default delivery or service charge modal
                        let service_amount = $("#service_amount").val();
                        let take_away_service_charge = $("#take_away_service_charge").val();
                        let delivery_amount = $("#delivery_amount").val();
                        $("#delivery_charge").val('');
                        $("#charge_type").val('service').change();
  
                        $(".main_top").find("button").attr("data-selected", "unselected");
                        this_action.attr("data-selected", "selected").addClass("selected__btn");
                        $("#table_button").attr("disabled", false);
  
                        if (this_action.attr("data-id") == "dine_in_button") {
                            $("#delivery_charge").val(service_amount);
                            $("#charge_type").val('service').change();
                            $(".set_quick_action").removeClass("set_quick_action_active");
                            $(".get_area_table").eq(0).click();

                        } else if (this_action.attr("data-id") == "take_away_button") {
                            $("#delivery_charge").val(take_away_service_charge);
                            $("#charge_type").val('service').change();
                            $("#table_button").attr("disabled", true);
                            $(".single_table_div[data-table-checked=checked]").attr(
                                "data-table-checked",
                                "unchecked"
                            );
                            // $('.single_table_div[data-table-checked=checked]').css('background-color', 'red');
                        } else if (this_action.attr("data-id") == "delivery_button") {
                            /*delivery partner*/
                            let delivery_partner = Number($("#delivery_partner").val());
                            if(delivery_partner){
                                $("#show_delivery_partner").addClass("active");
                                $(".pos__modal__overlay").fadeIn(200);
                            }
  
                            $("#delivery_charge").val(delivery_amount);
                            $("#charge_type").val('delivery').change();
  
                            $("#table_button").attr("disabled", true);
                            $(".single_table_div[data-table-checked=checked]").attr(
                                "data-table-checked",
                                "unchecked"
                            );
                        }
                        do_addition_of_item_and_modifiers_price();
                    }
                );
            }else{
                $("#dine_in_button").css("border", "unset");
                $("#take_away_button").css("border", "unset");
                $("#delivery_button").css("border", "unset");
  
                //set default delivery or service charge modal
                let service_amount = $("#service_amount").val();
                let take_away_service_charge = $("#take_away_service_charge").val();
                let delivery_amount = $("#delivery_amount").val();
                $("#delivery_charge").val('');
                $("#charge_type").val('service').change();
  
                $(".main_top").find("button").attr("data-selected", "unselected");
                $(this).attr("data-selected", "selected").addClass("selected__btn");
                $("#table_button").attr("disabled", false);
  
                if ($(this).attr("data-id") == "dine_in_button") {
                    $("#delivery_charge").val(service_amount);
                    $("#charge_type").val('service').change();
                    $(".set_quick_action").removeClass("set_quick_action_active");
                    $(".get_area_table").eq(0).click(); 
                } else if ($(this).attr("data-id") == "take_away_button") {
                    $("#delivery_charge").val(take_away_service_charge);
                    $("#charge_type").val('service').change();
                    $("#table_button").attr("disabled", true);
                    $(".single_table_div[data-table-checked=checked]").attr(
                        "data-table-checked",
                        "unchecked"
                    );
                    // $('.single_table_div[data-table-checked=checked]').css('background-color', 'red');
                } else if ($(this).attr("data-id") == "delivery_button") {
                    let delivery_partner = Number($("#delivery_partner").val());
                    if(delivery_partner){
                        $("#show_delivery_partner").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                    }
  
                    $("#delivery_charge").val(delivery_amount);
                    $("#charge_type").val('delivery').change();
  
                    $("#table_button").attr("disabled", true);
                    $(".single_table_div[data-table-checked=checked]").attr(
                        "data-table-checked",
                        "unchecked"
                    );
  
                }
                do_addition_of_item_and_modifiers_price();
            }
        }
      );
        //when single ite is clicked pop-up modal is appeared
        function openProductEditModal(parent_id,item_name, id){
            let single_order_element_object = $(this).parent().parent().parent();
            let row_number = 0;
            let menu_id = Number(id);
            let item_price = 0;
            let item_vat_percentage = '';
            let item_discount_input_value = 0;
            let item_discount_amount = 0;
            let item_price_without_discount = 0;
            let item_quantity = 1;
            let item_price_with_discount = 0;
            let modifiers_price = 0;
  
  
            let note = '';
            let modifiers_id = "";
  
            let modifiers_price_as_per_item_quantity = 0;
            let total_price = 0;
  
            $("#modal_item_row").html(row_number);
            $("#vr01_modal_price_variable").html(0);
            $("#modal_item_id").html(menu_id);
            $("#item_name_modal_custom").html(item_name);
            $("#modal_item_price").html(item_price);
            $("#modal_item_price_variable").html(item_price_with_discount);
            $("#modal_item_price_variable_without_discount").html(item_price_without_discount);
  
            $("#modal_item_vat_percentage").html(item_vat_percentage);
            $("#modal_discount_amount").html(item_discount_amount);
            $("#item_quantity_modal").val(item_quantity);
            $("#modal_modifiers_unit_price_variable").html(modifiers_price);
            $("#modal_modifier_price_variable").html(modifiers_price_as_per_item_quantity);
            $("#modal_discount").val(item_discount_input_value);
            $("#modal_item_note").val(note);
            $("#modal_total_price").html(total_price);
            //add modifiers to pop up associated to menu
            let foundItems_variations = get_variations_search_by_menu_id(menu_id, window.items);
  
            let variations = "";
            for (let key1 in foundItems_variations) {
  
                let vr01_selected_order_type_object = $(".main_top").find("button[data-selected=selected]" );
                if (vr01_selected_order_type_object.attr("data-id") == "dine_in_button") {
                    item_price = parseFloat(foundItems_variations[key1].price).toFixed(ir_precision);
                }else if (vr01_selected_order_type_object.attr("data-id") == "take_away_button"){
                    item_price = parseFloat(foundItems_variations[key1].price_take).toFixed(ir_precision);
                }else if (vr01_selected_order_type_object.attr("data-id") == "delivery_button"){
                    let arr_item_details = search_by_menu_id(foundItems_variations[key1].item_id, window.items);
                    let check_dl_person = 1;
                    item_price = arr_item_details[0].price_delivery;
                    $(".custom_li").each(function() {
                        let row_div =  $(this).attr("data-row");
                        if($("#myCheckbox"+row_div).is(":checked")){
                            let  price_delivery_details_tmp  = arr_item_details[0].price_delivery_details.split("|||");
                            for(let x=0;x<price_delivery_details_tmp.length;x++){
                                let  price_delivery_details_tmp_separate  = price_delivery_details_tmp[x].split("||");
                                if("index_"+row_div == price_delivery_details_tmp_separate[0]){
                                    if(Number(price_delivery_details_tmp_separate[1])){
                                        item_price = parseFloat(price_delivery_details_tmp_separate[1]).toFixed(ir_precision);
                                    }
                                }
  
                            }
                        }
                    });
                }
  
                variations += "<div class='btn_new_custom vr01_modal_class bg_btn_custom' data-id='"+foundItems_variations[key1].item_id+"' data-code='"+foundItems_variations[key1].item_code+"'  data-item_name_tmp='"+foundItems_variations[key1].item_name_tmp+"' data-price='"+item_price+"' data-selected='unselected' data-menu_tax='"+foundItems_variations[key1].tax_information+"'>";
                variations += `<input class="margin_for_vr01" name="vr01_name" type="radio"/>`;
                variations += "<p>" + foundItems_variations[key1].item_name + "</p>";
                variations +=
                    '<span class="vr01_modal_price"> <span>' +
                    price_txt +
                    ":</span> " +
                    item_price +
                    "</span>";
                variations += "</div>";
            }
  
            let foundItems = search_by_menu_id(menu_id, window.items);
            let originalMenu = foundItems[0].modifiers;
            let modifiers = "";
            let modifiers_single = "";
            for (let key in originalMenu) {
                let selectedOrNot = "unselected";
                let backgroundColor = "";
                if (
                    typeof modifiers_id !== "undefined" &&
                    modifiers_id.includes(originalMenu[key].menu_modifier_id)
                ) {
                    selectedOrNot = "selected";
                    //this is dynamic style
                    // backgroundColor = 'style="background-color:#B5D6F6;"';
                } else {
                    selectedOrNot = "unselected";
                    backgroundColor = "";
                }
                /*new_added_zak*/
                let style_content = "";
                let tmp_class = "";
                let tmp_price = originalMenu[key].menu_modifier_price;
                let modifier_ingrs = '';
                let blank_div = "";
                if(Number(originalMenu[key].type) == 2){
                    style_content = "none";
                    tmp_class = "single_modifier";
                    modifier_ingrs = get_modifier_ingrs_search_by_menu_modi_id(originalMenu[key].modifier_row_id, window.item_modifier_ingrs);
                    let modifier_ingrs_length = Number(modifier_ingrs.length);
                    if((modifier_ingrs_length%2)!=0){
                        blank_div = '\n' +
                            '<div class="vr01_modal_class_mod" data-selected="unselected" style="\n' +
                            '    pointer-events: none;\n' +
                            '"></div>';
                    }
                }
                modifiers +=
                    "<div " +
                    backgroundColor +
                    ' class="btn_new_custom modal_modifiers bg_btn_custom '+tmp_class+'" data-type="'+originalMenu[key].type+'" style="display:'+style_content+'"  data-menu_tax="' +
                    originalMenu[key].tax_information +
                    '"  data-price="' +
                    originalMenu[key].menu_modifier_price +
                    '" data-selected="' +
                    selectedOrNot +
                    '" id="modifier_' +
                    originalMenu[key].menu_modifier_id +
                    '">';
                modifiers += `<input type="checkbox" ${
                    selectedOrNot === "selected" ? "checked" : "unchecked"
                    }/>`;
                modifiers += "<p>" + originalMenu[key].menu_modifier_name + "</p>";
                modifiers +=
                    '<span class="modifier_price"> <span>' +
                    price_txt +
                    ":</span> " +
                    originalMenu[key].menu_modifier_price +
                    "</span>";
                modifiers += "</div>";
  
  
                if(Number(originalMenu[key].type) == 2){
                    for (let key1 in modifier_ingrs) {
                        modifiers_single += "<div class='vr01_modal_class_mod vr01_modal_class_mod_"+originalMenu[key].menu_modifier_id+" mod_main_row_div_"+modifier_ingrs[key1].inline_mod_row+"' data-id='"+modifier_ingrs[key1].inline_mod_row+"'   data-parent_id='"+originalMenu[key].menu_modifier_id+"'  data-price='"+modifier_ingrs[key1].menu_ingr_price+"' data-selected='unselected' data-menu_tax='"+originalMenu[key].tax_information+"'>";
                        modifiers_single += `<input class="margin_for_vr01_mod  margin_for_vr01_mod_`+originalMenu[key].menu_modifier_id+`  mod_main_row_value_`+modifier_ingrs[key1].inline_mod_row+`"  data-id="`+originalMenu[key].menu_modifier_id+`_`+modifier_ingrs[key1].inline_mod_row+`"   name="vr01_name_mod" type="radio"/>`;
                        modifiers_single += "<p>" + originalMenu[key].menu_modifier_name+"("+modifier_ingrs[key1].menu_ingr_name + ") <span> "+price_txt+": "+modifier_ingrs[key1].menu_ingr_price+" </span></p>";
                        modifiers_single += "</div>";
                    }
                }
                /*new_added_zak*/
  
            }
            $(".variation_div_modal").show();
  
            if(modifiers.length){
                $(".modifier_div").show();
            }else{
                $(".modifier_div").hide();
            }
  
            $("#item_modal .section3_vr").empty();
            $("#item_modal .section3_vr").prepend(variations);
  
  
            $("#item_modal .section3_new").empty();
            $("#item_modal .section3_new").prepend(modifiers);
  
            $("#item_modal .section3_new_single").empty();
            $("#item_modal .section3_new_single").prepend(modifiers_single);
            $("#item_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
        }
        //when single ite is clicked pop-up modal is appeared
        function openProductEditModalForPromo(string_text,item_name, id,promo_type,discount,get_food_menu_id,qty,get_qty,item_price,modal_item_name_row){
            let single_order_element_object = $(this).parent().parent().parent();
            let row_number = 0;
            let menu_id = Number(id);
            let item_vat_percentage = '';
            let item_discount_input_value = 0;
            let item_discount_amount = 0;
            let item_price_without_discount = item_price;
            let item_quantity = 1;
            let item_price_with_discount = item_price;
            let modifiers_price = 0;
  
  
            let note = '';
            let modifiers_id = "";
  
            let modifiers_price_as_per_item_quantity = 0;
            let total_price = 0;
  
            $(".prom_txt").html(string_text);
            promo_type = Number(promo_type);
            $("#modal_discount_amount").html(0);
            $("#modal_discount").val(discount);
            if(string_text){
                $("#modal_discount").attr("readonly",'');
            }
            $("#modal_promo_type_row").html(promo_type);
            $("#modal_discount_row").html(discount);
            $("#modal_get_food_menu_id_row").html(get_food_menu_id);
            $("#modal_qty_row").html(qty);
            $("#modal_get_qty_row").html(get_qty);
            $("#modal_item_name_row").html(modal_item_name_row);
  
            $("#modal_item_row").html(row_number);
            $("#vr01_modal_price_variable").html(0);
            $("#modal_item_id").html(menu_id);
            $("#item_name_modal_custom").html(item_name);
            $("#modal_item_price").html(item_price);
            $("#modal_item_price_variable").html(item_price_with_discount);
            $("#modal_item_price_variable_without_discount").html(item_price_without_discount);
            $("#modal_item_vat_percentage").html(item_vat_percentage);
  
            $("#item_quantity_modal").val(item_quantity);
            $("#modal_modifiers_unit_price_variable").html(modifiers_price);
            $("#modal_modifier_price_variable").html(modifiers_price_as_per_item_quantity);
  
            $("#modal_item_note").val(note);
            $("#modal_total_price").html(total_price);
  
            let foundItems = search_by_menu_id(menu_id, window.items);
            let originalMenu = foundItems[0].modifiers;
            let modifiers = "";
  
            for (let key in originalMenu) {
                let selectedOrNot = "unselected";
                let backgroundColor = "";
                if (
                    typeof modifiers_id !== "undefined" &&
                    modifiers_id.includes(originalMenu[key].menu_modifier_id)
                ) {
                    selectedOrNot = "selected";
                    //this is dynamic style
                    // backgroundColor = 'style="background-color:#B5D6F6;"';
                } else {
                    selectedOrNot = "unselected";
                    backgroundColor = "";
                }
                /*new_added_zak*/
                let style_content = "";
                let tmp_class = "";
                let tmp_price = originalMenu[key].menu_modifier_price;
                let modifier_ingrs = '';
                let blank_div = "";
                if(Number(originalMenu[key].type) == 2){
                    style_content = "none";
                    tmp_class = "single_modifier";
                    modifier_ingrs = get_modifier_ingrs_search_by_menu_modi_id(originalMenu[key].modifier_row_id, window.item_modifier_ingrs);
                    let modifier_ingrs_length = Number(modifier_ingrs.length);
                    if((modifier_ingrs_length%2)!=0){
                        blank_div = '\n' +
                            '<div class="vr01_modal_class_mod" data-selected="unselected" style="\n' +
                            '    pointer-events: none;\n' +
                            '"></div>';
                    }
                }
                modifiers +=
                    "<div " +
                    backgroundColor +
                    ' class="btn_new_custom modal_modifiers bg_btn_custom '+tmp_class+'" data-type="'+originalMenu[key].type+'" style="display:'+style_content+'"  data-menu_tax="' +
                    originalMenu[key].tax_information +
                    '"  data-price="' +
                    originalMenu[key].menu_modifier_price +
                    '" data-selected="' +
                    selectedOrNot +
                    '" id="modifier_' +
                    originalMenu[key].menu_modifier_id +
                    '">';
                modifiers += `<input type="checkbox" ${
                    selectedOrNot === "selected" ? "checked" : "unchecked"
                    }/>`;
                modifiers += "<p>" + originalMenu[key].menu_modifier_name + "</p>";
                modifiers +=
                    '<span class="modifier_price"> <span>' +
                    price_txt +
                    ":</span> " +
                    originalMenu[key].menu_modifier_price +
                    "</span>";
                modifiers += "</div>";
  
                /*new_added_zak*/
  
            }
            $(".variation_div_modal").hide();
  
            if(modifiers.length){
                $(".modifier_div").show();
            }else{
                $(".modifier_div").hide();
            }
  
            $("#item_modal .section3_new").empty();
            $("#item_modal .section3_new").prepend(modifiers);
  
            update_all_total_price();
  
            $("#item_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
        }
      //when single ite is clicked pop-up modal is appeared
        $(document).on("click", ".single_item", function () {
            //focus search field
              focusSearch();
            //add for vr01 and clear previous cart before new addd
            $(".prom_txt").html('');
            let modal_item_is_offer = '';
            $("#modal_item_is_offer").html(modal_item_is_offer);
            $("#modal_discount").removeAttr("readonly");
            $("#modal_item_price").html(0);
            let add_to_cart = $("#add_to_cart_txt").val();
            $("#add_to_cart").html(add_to_cart);
            reset_on_modal_close_or_add_to_cart();
            let selected_order_type_object = $(".main_top").find(
                "button[data-selected=selected]" );
            //get item/menu price from modal
            let item_price = 0;
            let item_id = $(this).attr("id").substr(5);
            if (selected_order_type_object.length > 0) {
                //vr01
                let is_variation = ($(this).attr('data-is_variation'));
                let parent_id = ($(this).attr('data-parent_id'));
                let item_name = getPlanText($(this).find(".item_name").html());
                let when_clicking_on_item_in_pos = Number($("#when_clicking_on_item_in_pos").val());
                let status_continue = true;
                let if_exist = Number($("#item_quantity_table_"+item_id).html());
  
                if(when_clicking_on_item_in_pos==2){
                  if(if_exist && if_exist!=undefined){
                      $("#increase_item_table_"+item_id).click();
                      //do calculation on table
                      status_continue = false;
                  }
                }else if (when_clicking_on_item_in_pos==1){
                    if(if_exist && if_exist!=undefined){
                        $("#edit_item_"+item_id).click();
                        //do calculation on table
                        status_continue = false;
                    }
                }
                //get tax information
                let tax_information = "";
                /*added_new_zakir*/
                let item_type = '';
                /*end_added_new_zakir*/
                // iterate over each item in the array
                let product_type = 1;
                let product_comb = '';
                let is_promo = '';
                let promo_type = '';
                let string_text = '';
                let discount = 0;
                let get_food_menu_id = 0;
                let qty = 0;
                let get_qty = 0;
                let modal_item_name_row = '';
  
                for (let i = 0; i < window.items.length; i++) {
                    // look for the entry with a matching `code` value
                    if (items[i].item_id == item_id) {
                        tax_information = items[i].tax_information;
                        /*added_new_zakir*/
                        product_type = Number(items[i].product_type);
                        product_comb = (items[i].product_comb);
                        is_promo = (items[i].is_promo);
                        promo_type = (items[i].promo_type);
                        string_text = (items[i].string_text);
                        discount = (items[i].discount);
                        get_food_menu_id = (items[i].get_food_menu_id);
                        qty = (items[i].qty);
                        get_qty = (items[i].get_qty);
                        modal_item_name_row = (items[i].modal_item_name_row);
                        /*end_added_new_zakir*/
                    }
                }
  
              if(status_continue==true){
                  if(is_variation=="Yes") {
                      $("#is_variation_product").html(100);
                      openProductEditModal(item_id,item_name,item_id);
                  }else if(is_promo=="Yes"){
                      $("#is_variation_product").html(0);
                      $("#modal_item_is_offer").html('Yes');
                      if (selected_order_type_object.attr("data-id") == "dine_in_button") {
                          item_price = parseFloat($(this).attr('data-price')).toFixed(ir_precision);
                      }else if (selected_order_type_object.attr("data-id") == "take_away_button"){
                          item_price = parseFloat($(this).attr('data-price_take')).toFixed(ir_precision);
                      }else if (selected_order_type_object.attr("data-id") == "delivery_button"){
                          let arr_item_details = search_by_menu_id(item_id, window.items);
                          let check_dl_person = 1;
                          item_price = parseFloat($(this).attr('data-price_delivery')).toFixed(ir_precision);
                          $(".custom_li").each(function() {
                              let row_div =  $(this).attr("data-row");
                              if($("#myCheckbox"+row_div).is(":checked")){
                                  let  price_delivery_details_tmp  = arr_item_details[0].price_delivery_details.split("|||");
  
                                  for(let x=0;x<price_delivery_details_tmp.length;x++){
                                      let  price_delivery_details_tmp_separate  = price_delivery_details_tmp[x].split("||");
                                      if("index_"+row_div == price_delivery_details_tmp_separate[0]){
                                          if(Number(price_delivery_details_tmp_separate[1])){
                                              item_price = parseFloat(price_delivery_details_tmp_separate[1]).toFixed(ir_precision);
                                          }
                                      }
                                  }
                              }
  
                          });
  
                      }
  
                      openProductEditModalForPromo(string_text,item_name,item_id,promo_type,discount,get_food_menu_id,qty,get_qty,item_price,modal_item_name_row);
                  }else{
                      if (selected_order_type_object.attr("data-id") == "dine_in_button") {
                          item_price = parseFloat($(this).attr('data-price')).toFixed(ir_precision);
                      }else if (selected_order_type_object.attr("data-id") == "take_away_button"){
                          item_price = parseFloat($(this).attr('data-price_take')).toFixed(ir_precision);
                      }else if (selected_order_type_object.attr("data-id") == "delivery_button"){
                          let arr_item_details = search_by_menu_id(item_id, window.items);
                          let check_dl_person = 1;
                          item_price = parseFloat($(this).attr('data-price_delivery')).toFixed(ir_precision);
                          $(".custom_li").each(function() {
                              let row_div =  $(this).attr("data-row");
                              if($("#myCheckbox"+row_div).is(":checked")){
                                  let  price_delivery_details_tmp  = arr_item_details[0].price_delivery_details.split("|||");
                                  for(let x=0;x<price_delivery_details_tmp.length;x++){
                                      let  price_delivery_details_tmp_separate  = price_delivery_details_tmp[x].split("||");
                                      if("index_"+row_div == price_delivery_details_tmp_separate[0]){
                                          if(Number(price_delivery_details_tmp_separate[1])){
                                              item_price = parseFloat(price_delivery_details_tmp_separate[1]).toFixed(ir_precision);
                                          }
                                      }
  
                                  }
  
  
                              }
  
                          });
                      }
  
                      let row_number = $("#modal_item_row").html();
                      //get item/menu id from modal
  
                      let stock_not_available = $("#stock_not_available").val();
                      let qty_current = 1;
                      $(".single_order_column").each(function() {
                          let qty_counter = Number($(this).find('#item_quantity_table_'+item_id).html());
                          if(qty_counter && qty_counter!="NAN"){
                              qty_current+=qty_counter;
                          }
                      });
  
                      //get item/menu name from modal
  
  
                      //get item/menu vat percentage from modal
                      let item_vat_percentage = $(this).find(".item_vat_percentage").html();
                      item_vat_percentage =
                          item_vat_percentage == "" ? "0.00" : item_vat_percentage;
                      //discount amount from modal
                      let item_discount_amount = parseFloat(0).toFixed(ir_precision);
  
                      //discount input value of modal
                      let discount_input_value = '';
  
  
  
                      //get item/menu price from modal without discount
                      let item_total_price_without_discount =
                          parseFloat(item_price).toFixed(ir_precision);
  
                      tax_information = IsJsonString(tax_information)
                          ? JSON.parse(tax_information)
                          : "";
                      if (tax_information.length > 0) {
                          for (let k in tax_information) {
                              tax_information[k].item_vat_amount_for_unit_item = (
                                  (parseFloat(item_price) *
                                      parseFloat(tax_information[k].tax_field_percentage)) /
                                  parseFloat(100)
                              ).toFixed(ir_precision);
                              tax_information[k].item_vat_amount_for_all_quantity = (
                                  parseFloat(tax_information[k].item_vat_amount_for_unit_item) *
                                  parseFloat(1)
                              ).toFixed(ir_precision);
                          }
                      }
  
                      //get vat amount for specific item/menu
                      let item_vat_amount_for_unit_item = (
                          (parseFloat(item_price) * parseFloat(item_vat_percentage)) /
                          parseFloat(100)
                      ).toFixed(ir_precision);
  
                      //get item/menu total price from modal
                      let item_total_price = parseFloat(item_price).toFixed(ir_precision);
  
                      //get item/menu quantity from modal
                      let item_quantity = "1";
  
                      //get vat amount for specific item/menu
                      let item_vat_amount_for_all_quantity = (
                          parseFloat(item_vat_amount_for_unit_item) * parseFloat(item_quantity)
                      ).toFixed(ir_precision);
  
                      //get selected modifiers
                      let selected_modifiers = "";
                      let selected_modifiers_id = "";
                      let selected_modifiers_price = "";
  
                      //get modifiers price
                      let modifiers_price = parseFloat(0).toFixed(ir_precision);
  
                      //get note
                      let note = "";
  
                      //construct div
                      let draw_table_for_order = "";
  
                      draw_table_for_order +=
                          row_number > 0
                              ? ""
                              : '<div data-cp_type="1" class="single_order customer_panel" data-id="'+item_id+'" id="order_for_item_' + item_id + '">';
                      draw_table_for_order += '<div class="first_portion">';
                      draw_table_for_order +=
                          '<span class="item_previous_id ir_display_none" id="item_previous_id_table' +
                          item_id +
                          '"></span>';
                      draw_table_for_order +=
                          '<span class="item_cooking_done_time ir_display_none" id="item_cooking_done_time_table' +
                          item_id +
                          '"></span>';
                      draw_table_for_order +=
                          '<span class="item_cooking_start_time ir_display_none" id="item_cooking_start_time_table' +
                          item_id +
                          '"></span>';
                      draw_table_for_order +=
                          '<span class="item_cooking_status ir_display_none" id="item_cooking_status_table' +
                          item_id +
                          '"></span>';
                      draw_table_for_order +=
                          '<span class="item_type ir_display_none" id="item_type_table' +
                          item_id +
                          '">' +
                          item_type +
                          '</span>';
                      draw_table_for_order +=
                          '<span class="item_vat ir_display_none" id="item_vat_percentage_table' +
                          item_id +
                          '">' +
                          JSON.stringify(tax_information) +
                          "</span>";
                      draw_table_for_order +=
                          '<span class="item_discount ir_display_none" id="item_discount_table' +
                          item_id +
                          '">' +
                          item_discount_amount +
                          "</span>";
                      draw_table_for_order +=
                          '<span class="item_price_without_discount ir_display_none" id="item_price_without_discount_' +
                          item_id +
                          '">' +
                          item_total_price_without_discount +
                          "</span>";
                      $("#is_variation_product").html(search_by_menu_id_getting_parent_id(item_id, window.items));
                      draw_table_for_order +=
                          '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix" data-id="'+item_id+'"><i  data-parent_id="'+search_by_menu_id_getting_parent_id(item_id, window.items)+'"   class="fas fa-pencil-alt edit_item txt_5" id="edit_item_' +
                          item_id +
                          '"></i> <span class="arabic_text_left 1_cp_name_'+item_id+'"  id="item_name_table_' +
                          item_id +
                          '">' +
                          item_name +
                          "</span></div>";
                      draw_table_for_order +=
                          '<div class="single_order_column second_column fix">' +
                          currency +
                          ' <span class="1_cp_price_'+item_id+'" id="item_price_table_' +
                          item_id +
                          '">' +
                          item_price +
                          "</span></div>";
                      draw_table_for_order +=
                          '<div class="single_order_column third_column fix"><i class="fal fa-minus decrease_item_table txt_5" id="decrease_item_table_' +
                          item_id +
                          '"></i> <span data-is_kot_print="1" class="qty_item_custom 1_cp_qty_'+item_id+'" id="item_quantity_table_' +
                          item_id +
                          '">' +
                          item_quantity +
                          '</span> <i class="fal fa-plus increase_item_table txt_5" id="increase_item_table_' +
                          item_id +
                          '"></i></div>';
                      draw_table_for_order +=
                          '<div class="single_order_column forth_column fix"><input type="" name="" placeholder="Amt or %" class="1_cp_discount_'+item_id+' discount_cart_input" id="percentage_table_' +
                          item_id +
                          '" value="' +
                          discount_input_value +
                          '" disabled></div>';
                      draw_table_for_order +=
                          '<div class="single_order_column fifth_column">' +
                          currency +
                          ' <span class="1_cp_total_'+item_id+'" id="item_total_price_table_' +
                          item_id +
                          '">' +
                          item_total_price +
                          "</span> <i  data-id='" +
                          item_id +
                          "'  class='fal fa-times removeCartItem'></i></div>";
                      draw_table_for_order += "</div>";
                      if (product_type == 2  &&  product_comb!= "") {
                          draw_table_for_order += '<div class="third_portion fix">';
                          draw_table_for_order +=
                              '<div  data-cp_type="33" class="customer_panel_child_'+item_id+' single_order_column first_column cart_item_counter arabic_text_left fix modifier_txt_custom" data-id="'+item_id+'">' +
                              combo_txt +
                              ': <span id="item_combo_table_' +
                              item_id +
                              '">' +
                              product_comb +
                              "</span></div>";
                          draw_table_for_order += "</div>";
                      }
  
                      if (selected_modifiers != "") {
                          draw_table_for_order +=
                              '<div data-id="' + item_id + '" class="second_portion fix">';
                          draw_table_for_order +=
                              '<span id="item_modifiers_id_table_' +
                              item_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_id +
                              "</span>";
                          draw_table_for_order +=
                              '<span id="item_modifiers_price_table_' +
                              item_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_price +
                              "</span>";
                          draw_table_for_order +=
                              '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix"  data-id="'+item_id+'"><span class="modifier_txt_custom" id="item_modifiers_table_' +
                              item_id +
                              '">' +
                              selected_modifiers +
                              "</span></div>";
                          draw_table_for_order +=
                              '<div class="single_order_column fifth_column fix">' +
                              currency +
                              ' <span id="item_modifiers_price_table_' +
                              item_id +
                              '">' +
                              modifiers_price +
                              "</span></div>";
                          draw_table_for_order += "</div>";
                      }
                      if (note != "") {
                          draw_table_for_order += '<div class="third_portion fix">';
                          draw_table_for_order +=
                              '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix modifier_txt_custom"  data-id="'+item_id+'">' +
                              note_txt +
                              ': <span id="item_note_table_' +
                              item_id +
                              '">' +
                              note +
                              "</span></div>";
                          draw_table_for_order += "</div>";
                      }
  
                      draw_table_for_order += row_number > 0 ? "" : "</div>";
  
                      //add to top if new it or update the row
                      if (row_number > 0) {
                          $(
                              ".order_holder .single_order[data-single-order-row-no=" +
                              row_number +
                              "]"
                          ).empty();
                          $(
                              ".order_holder .single_order[data-single-order-row-no=" +
                              row_number +
                              "]"
                          ).html(draw_table_for_order);
                      } else {
                          $(".order_holder").prepend(draw_table_for_order);
                      }
                      if (waiter_app_status == "Yes") {
                          $.notifyBar({ cssClass: "success", html: item_add_success });
                      }else{
                          if(s_width<=700){
                              $.notifyBar({ cssClass: "success", html: item_add_success });
                          }
                      }
  
                      reset_on_modal_close_or_add_to_cart();
                      // return false;
                      //do calculation on table
                      do_addition_of_item_and_modifiers_price();
                  }
              }
  
            }else{
              $("#last_click_item_id").val(item_id);
                $("#order_type_modal").addClass("active");
                $(".pos__modal__overlay").fadeIn(200);
                return false;
            }
        });
      $(document).on("click", "#cancel_button", function (e) {
        //get total items in cart
        let total_items_in_cart = $(".order_holder .single_order").length;
        if (total_items_in_cart > 0) {
          swal(
            {
              title: warning + "!",
              text: cart_not_empty_want_to_clear,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
              $(".order_table_holder .order_holder").empty();
              clearFooterCartCalculation();
              $("#table_button").attr("disabled", false);
              $(".single_table_div[data-table-checked=checked]").attr(
                "data-table-checked",
                "unchecked"
              );
              let cid = $("#default_customer_hidden").val();
              let wid = $("#default_waiter_hidden").val();
              $("#walk_in_customer").val(cid).trigger("change");
              $("#walk_in_customer1").val(cid).trigger("change");
              if (wid) {
                if (waiter_app_status != "Yes") {
                  $("#select_waiter").val(wid).trigger("change");
                  $("#select_waiter1").val(wid).trigger("change");
                }
              } else {
                if (waiter_app_status != "Yes") {
                  $("#select_waiter").val("").trigger("change");
                  $("#select_waiter1").val("").trigger("change");
                }
              }
  
                //focus search field
                focusSearch();
              $("#place_edit_order").html(place_order);
            }
          );
        }
      });
    $(document).on("click", ".edit_item", function () {
          //add for vr01
          $("#modal_item_price").html(0);
          $("#vr01_modal_price_variable").html(0);
          $("#is_variation_product").html(0);
          $(".variation_div_modal").hide();
          $(".section3_vr").empty();
          $(".prom_txt").html('');
          $("#modal_discount").removeAttr("readonly");
        let add_to_cart_pos = $("#add_to_cart_pos").val();
        $("#add_to_cart").html(add_to_cart_pos);
  
          let single_order_element_object = $(this).parent().parent().parent();
          let menu_id = Number($(this).attr("id").substr(10));
          let item_price = single_order_element_object
              .find("#item_price_table_" + menu_id)
              .html();
  
          let parent_id = Number($(this).attr('data-parent_id'));
          let check_parent_id = 0;
          let check_parent_price = 0;
          if(parent_id){
              $("#vr01_modal_price_variable").html(item_price);
              $(".variation_div_modal").show();
              $("#is_variation_product").html(parent_id);
  
              let foundItems_variations = get_variations_search_by_menu_id(parent_id, window.items);
  
              let variations = "";
              for (let key1 in foundItems_variations) {
                  let item_price = 0;
                  let vr01_selected_order_type_object = $(".main_top").find("button[data-selected=selected]" );
                  if (vr01_selected_order_type_object.attr("data-id") == "dine_in_button") {
                      item_price = parseFloat(foundItems_variations[key1].price).toFixed(ir_precision);
                  }else if (vr01_selected_order_type_object.attr("data-id") == "take_away_button"){
                      item_price = parseFloat(foundItems_variations[key1].price_take).toFixed(ir_precision);
                  }else if (vr01_selected_order_type_object.attr("data-id") == "delivery_button"){
                      item_price = parseFloat(foundItems_variations[key1].price_delivery).toFixed(ir_precision);
                  }
                  let check_status = '';
                  let selected_status = 'unselected';
                  if(menu_id==Number(foundItems_variations[key1].item_id)){
                      selected_status = "selected";
                      check_status = "checked";
                  }
                  variations += "<div class='btn_new_custom vr01_modal_class bg_btn_custom' data-id='"+foundItems_variations[key1].item_id+"' data-code='"+foundItems_variations[key1].item_code+"'  data-item_name_tmp='"+foundItems_variations[key1].item_name_tmp+"' data-price='"+item_price+"' data-selected='"+selected_status+"' data-menu_tax='"+foundItems_variations[key1].tax_information+"'>";
                  variations += `<input `+check_status+` class="margin_for_vr01" name="vr01_name" type="radio"/>`;
                  variations += "<p>" + foundItems_variations[key1].item_name + "</p>";
                  variations +=
                      '<span class="vr01_modal_price"> <span>' +
                      price_txt +
                      ":</span> " +
                      item_price +
                      "</span>";
                  variations += "</div>";
              }
  
              //vr01
              $("#item_modal .section3_vr").empty();
              $("#item_modal .section3_vr").prepend(variations);
          }
  
          let row_number = $(this)
              .parent()
              .parent()
              .parent()
              .attr("data-single-order-row-no");
  
          let item_name = single_order_element_object
              .find("#item_name_table_" + menu_id)
              .html();
  
          let item_vat_percentage = single_order_element_object
              .find("#item_vat_percentage_table" + menu_id)
              .html();
          let item_discount_input_value = single_order_element_object
              .find("#percentage_table_" + menu_id)
              .val();
          let item_discount_amount = single_order_element_object
              .find("#item_discount_table" + menu_id)
              .html();
          let item_price_without_discount = single_order_element_object
              .find("#item_price_without_discount_" + menu_id)
              .html();
          let item_quantity = single_order_element_object
              .find("#item_quantity_table_" + menu_id)
              .html();
          let item_price_with_discount = parseFloat(
              single_order_element_object
                  .find("#item_total_price_table_" + menu_id)
                  .html()
          ).toFixed(ir_precision);
          let modifiers_price = parseFloat(0).toFixed(ir_precision);
          let cooking_status = single_order_element_object
              .find("#item_cooking_status_table" + menu_id)
              .html();
          if (cooking_status != "" && cooking_status !== undefined) {
              toastr['error']((progress_or_done_kitchen), '');
              return false;
          }
          if (
              single_order_element_object.find("#item_modifiers_price_table_" + menu_id)
                  .length > 0
          ) {
              let comma_separeted_modifiers_price = single_order_element_object
                  .find("#item_modifiers_price_table_" + menu_id)
                  .html();
              let modifiers_price_array =
                  comma_separeted_modifiers_price != ""
                      ? comma_separeted_modifiers_price.split(",")
                      : "";
              modifiers_price_array.forEach(function (modifier_price) {
                  modifiers_price = (
                      parseFloat(modifiers_price) + parseFloat(modifier_price)
                  ).toFixed(ir_precision);
              });
              parseFloat(
                  single_order_element_object
                      .find("#item_modifiers_price_table_" + menu_id)
                      .html()
              ).toFixed(ir_precision);
          }
  
          let note = single_order_element_object
              .find("#item_note_table_" + menu_id)
              .html();

          let discount_reason = single_order_element_object
              .find("#discount_reason_table_" + menu_id)
              .html();

          let modifiers_id = "";
          if (
              single_order_element_object.find("#item_modifiers_id_table_" + menu_id)
                  .length > 0
          ) {
              let comma_seperted_modifiers_id = single_order_element_object
                  .find("#item_modifiers_id_table_" + menu_id)
                  .html();
              modifiers_id =
                  comma_seperted_modifiers_id != ""
                      ? comma_seperted_modifiers_id.split(",")
                      : "";
          }
          let modifiers_price_as_per_item_quantity = (
              parseFloat(modifiers_price) * parseFloat(item_quantity)
          ).toFixed(ir_precision);
          let total_price = (
              parseFloat(item_price_with_discount) +
              parseFloat(modifiers_price_as_per_item_quantity)
          ).toFixed(ir_precision);
  
  
        // iterate over each item in the array
        let product_type = 1;
        let product_comb = '';
        let is_promo = '';
        let promo_type = '';
        let string_text = '';
        let discount = 0;
        let get_food_menu_id = 0;
        let qty = 0;
        let get_qty = 0;
  
        for (let i = 0; i < window.items.length; i++) {
            // look for the entry with a matching `code` value
            if (items[i].item_id == menu_id) {
                product_type = Number(items[i].product_type);
                product_comb = (items[i].product_comb);
                is_promo = (items[i].is_promo);
                promo_type = (items[i].promo_type);
                string_text = (items[i].string_text);
                discount = (items[i].discount);
                get_food_menu_id = (items[i].get_food_menu_id);
                qty = (items[i].qty);
                get_qty = (items[i].get_qty);
            }
        }
  
        $(".prom_txt").html(string_text);
        promo_type = Number(promo_type);
        if(promo_type==1 || promo_type==2){
            $("#modal_discount").attr("readonly",'');
        }
  
          $("#modal_item_row").html(row_number);
          $("#modal_item_id").html(menu_id);
          $("#item_name_modal_custom").html(item_name);
          $("#modal_item_price").html(item_price);
          $("#modal_item_price_variable").html(item_price_with_discount);
          $("#modal_item_price_variable_without_discount").html(
              item_price_without_discount
          );
  
          $("#modal_item_vat_percentage").html(item_vat_percentage);
          $("#modal_discount_amount").html(item_discount_amount);
          $("#item_quantity_modal").val(item_quantity);
          $("#modal_modifiers_unit_price_variable").html(modifiers_price);
          $("#modal_modifier_price_variable").html(
              modifiers_price_as_per_item_quantity
          );
          $("#modal_discount").val(item_discount_input_value);
          $("#modal_item_note").val(note);
          $("#discount_reason").val(discount_reason);
          $("#modal_total_price").html(total_price);
          //add modifiers to pop up associated to menu
          let foundItems = search_by_menu_id(menu_id, window.items);
  
          let originalMenu = foundItems[0].modifiers;
          let modifiers = "";
          for (let key in originalMenu) {
              let selectedOrNot = "unselected";
              let backgroundColor = "";
              if (
                  typeof modifiers_id !== "undefined" &&
                  modifiers_id.includes(originalMenu[key].menu_modifier_id)
              ) {
                  selectedOrNot = "selected";
                  //this is dynamic style
                  // backgroundColor = 'style="background-color:#B5D6F6;"';
              } else {
                  selectedOrNot = "unselected";
                  backgroundColor = "";
              }
  
              /*new_added_zak*/
              let style_content = "";
              let tmp_class = '';
              let tmp_price = originalMenu[key].menu_modifier_price;
              let modifier_ingrs = '';
              let blank_div = "";
              let modifier_full_name = originalMenu[key].menu_modifier_name;
              if(Number(originalMenu[key].type) == 2){
                  style_content = "none";
                  tmp_class = "single_modifier";
                  modifier_ingrs = get_modifier_ingrs_search_by_menu_modi_id(originalMenu[key].modifier_row_id, window.item_modifier_ingrs);
                  let modifier_ingrs_length = Number(modifier_ingrs.length);
                  if((modifier_ingrs_length%2)!=0){
                      blank_div = '\n' +
                          '<div class="vr01_modal_class_mod" data-selected="unselected" style="\n' +
                          '    pointer-events: none;\n' +
                          '"></div>';
                  }
  
                  for (let key1 in modifier_ingrs) {
                      $(".hidden_mod_cart_"+menu_id+"_"+originalMenu[key].menu_modifier_id).each(function() {
                          let this_value = ($(this).val());
                          if(this_value===originalMenu[key].menu_modifier_id+"_"+(modifier_ingrs[key1].inline_mod_row)) {
                              modifier_full_name = originalMenu[key].menu_modifier_name + "(" + modifier_ingrs[key1].menu_ingr_name+")";
                          }
                      });
                  }
  
              }
  
              modifiers +=
                  "<div " +
                  backgroundColor +
                  ' class="btn_new_custom modal_modifiers bg_btn_custom '+tmp_class+'"  data-type="'+originalMenu[key].type+'"  style="display:'+style_content+'"  data-menu_tax="' +
                  originalMenu[key].tax_information +
                  '"  data-price="' +
                  originalMenu[key].menu_modifier_price +
                  '" data-selected="' +
                  selectedOrNot +
                  '" id="modifier_' +
                  originalMenu[key].menu_modifier_id +
                  '">';
              modifiers += `<input type="checkbox" ${
                  selectedOrNot === "selected" ? "checked" : "unchecked"
                  }/>`;
              modifiers += "<p>" + modifier_full_name + "</p>";
              modifiers +=
                  '<span class="modifier_price"> <span>' +
                  price_txt +
                  ":</span> " +
                  originalMenu[key].menu_modifier_price +
                  "</span>";
              modifiers += "</div>";
  
              /*new_added_zak*/
          }
  
          if(parent_id){
              foundItems = search_by_menu_id(parent_id, window.items);
              originalMenu = foundItems[0].modifiers;
              modifiers = "";
              for (let key in originalMenu) {
                  let selectedOrNot = "unselected";
                  let backgroundColor = "";
                  if (
                      typeof modifiers_id !== "undefined" &&
                      modifiers_id.includes(originalMenu[key].menu_modifier_id)
                  ) {
                      selectedOrNot = "selected";
                      //this is dynamic style
                      // backgroundColor = 'style="background-color:#B5D6F6;"';
                  } else {
                      selectedOrNot = "unselected";
                      backgroundColor = "";
                  }
  
                  /*new_added_zak*/
                  let style_content = "";
                  let tmp_class = '';
                  let tmp_price = originalMenu[key].menu_modifier_price;
                  let modifier_ingrs = '';
                  let blank_div = "";
                  if(Number(originalMenu[key].type) == 2){
                      style_content = "none";
                      tmp_class = "single_modifier";
                      modifier_ingrs = get_modifier_ingrs_search_by_menu_modi_id(originalMenu[key].modifier_row_id, window.item_modifier_ingrs);
                      let modifier_ingrs_length = Number(modifier_ingrs.length);
                      if((modifier_ingrs_length%2)!=0){
                          blank_div = '\n' +
                              '<div class="vr01_modal_class_mod" data-selected="unselected" style="\n' +
                              '    pointer-events: none;\n' +
                              '"></div>';
                      }
                  }
  
                  modifiers +=
                      "<div " +
                      backgroundColor +
                      ' class="btn_new_custom modal_modifiers bg_btn_custom '+tmp_class+'"  data-type="'+originalMenu[key].type+'"   style="display:'+style_content+'"  data-menu_tax="' +
                      originalMenu[key].tax_information +
                      '"  data-price="' +
                      originalMenu[key].menu_modifier_price +
                      '" data-selected="' +
                      selectedOrNot +
                      '" id="modifier_' +
                      originalMenu[key].menu_modifier_id +
                      '">';
                  modifiers += `<input type="checkbox" ${
                      selectedOrNot === "selected" ? "checked" : "unchecked"
                      }/>`;
                  modifiers += "<p>" + originalMenu[key].menu_modifier_name + "</p>";
                  modifiers +=
                      '<span class="modifier_price"> <span>' +
                      price_txt +
                      ":</span> " +
                      originalMenu[key].menu_modifier_price +
                      "</span>";
                  modifiers += "</div>";
                  /*new_added_zak*/
              }
          }
          if(modifiers.length){
              $(".modifier_div").show();
          }else{
              $(".modifier_div").hide();
          }
          $("#item_modal .section3_new").empty();
          $("#item_modal .section3_new").prepend(modifiers);
          if(Number(check_parent_id)){
              $("#modifier_"+check_parent_id).attr('data-price',check_parent_price);
              $("#modifier_"+check_parent_id).find('.modifier_price').html("<span>"+price_txt+":</span> "+check_parent_price);
          }
  
        let is_self_order = $("#is_self_order").val();
        let modal_item_is_offer = $(this).attr("data-modal_item_is_offer");
  
        if(is_self_order=="Yes"){
            $("#modal_discount").attr("readonly",'');
        }else{
            $("#modal_discount").removeAttr("readonly");
        }
  
        if(modal_item_is_offer=="Yes"){
            $("#modal_discount").attr("readonly",'');
        }else{
            $("#modal_discount").removeAttr("readonly");
        }

          show_discount_reason();
          $("#item_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(200);
      });

      function show_discount_reason(){
        let modal_discount = $("#modal_discount").val();
        if(modal_discount){
            $(".discount_reason_div").show();
        }else{
            $(".discount_reason_div").hide();
        }
      }
      $(document).on("click", "#close_item_modal", function (e) {
        reset_on_modal_close_or_add_to_cart();
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
      });
      $(document).on("click", "#close_add_customer_modal", function (e) {
        $("#customer_name_modal").css("border", "1px solid #B5D6F6");
        $("#customer_phone_modal").css("border", "1px solid #B5D6F6");
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay").fadeOut(300);
        reset_on_modal_close_or_add_customer();
      });
  
        $(document).on("click", ".modal_modifiers", function (e) {
            //get modifier price when it's selected
            let modifier_price = parseFloat($(this).attr("data-price")).toFixed(
                ir_precision
            );
            let this_id = ($(this).attr('id')).split('_');
            //get total modifier price
            // let total_modifier_price = parseFloat($('#modal_modifier_price_variable').html()).toFixed(ir_precision);
            let total_modifier_price = parseFloat(
                $("#modal_modifiers_unit_price_variable").html()
            ).toFixed(ir_precision);
  
            let update_modifier_price = 0;
            //add current modifier price to total modifier price
            if ($(this).attr("data-selected") == "unselected") {
                // $(this).css("background-color", "#B5D6F6");
                $(this).attr("data-selected", "selected");
                $(this).children("input").prop("checked", true);
                if (e.which === 1) {
                    $(".vr01_modal_class_mod_"+this_id[1]+":first").attr("data-selected", "selected");
                    $(".margin_for_vr01_mod_"+this_id[1]+":first").prop("checked", true);
                }
  
  
                update_modifier_price = (
                    parseFloat(total_modifier_price) + parseFloat(modifier_price)
                ).toFixed(ir_precision);
            } else if ($(this).attr("data-selected") == "selected") {
                $(this).attr("data-selected", "unselected");
                $(this).children("input").prop("checked", false);
  
                $(".vr01_modal_class_mod_"+this_id[1]).attr("data-selected", "unselected");
                $(".margin_for_vr01_mod_"+this_id[1]).prop("checked", false);
  
                update_modifier_price = (
                    parseFloat(total_modifier_price) - parseFloat(modifier_price)
                ).toFixed(ir_precision);
            }
  
            let checkbox = $(this).children('input[type="checkbox"]');
            /*checkbox.prop('checked', checkbox.prop('checked'));*/
  
            //update total modifier price html element
            // $('#modal_modifier_price_variable').html(update_modifier_price);
            $("#modal_modifiers_unit_price_variable").html(update_modifier_price);
  
            //update all total with item price
            update_all_total_price();
        });
  
        function check_and_show_promotion(item_id){
            let product_type = 1;
            let product_comb = '';
            let is_promo = '';
            let promo_type = '';
            let string_text = '';
            let discount = 0;
            let get_food_menu_id = 0;
            let qty = 0;
            let get_qty = 0;
            let modal_item_name_row = '';
            for (let i = 0; i < window.items.length; i++) {
                // look for the entry with a matching `code` value
                if (items[i].item_id == item_id) {
                    product_type = Number(items[i].product_type);
                    product_comb = (items[i].product_comb);
                    is_promo = (items[i].is_promo);
                    promo_type = (items[i].promo_type);
                    string_text = (items[i].string_text);
                    discount = (items[i].discount);
                    get_food_menu_id = (items[i].get_food_menu_id);
                    qty = (items[i].qty);
                    get_qty = (items[i].get_qty);
                    modal_item_name_row = (items[i].modal_item_name_row);
                    /*end_added_new_zakir*/
                }
            }
  
            if(promo_type==2){
                $(".prom_txt").html(string_text);
                $("#modal_promo_type_row").html(promo_type);
                $("#modal_discount_row").html(discount);
                $("#modal_get_food_menu_id_row").html(get_food_menu_id);
                $("#modal_qty_row").html(qty);
                $("#modal_get_qty_row").html(get_qty);
                $("#modal_item_name_row").html(modal_item_name_row);
            }else{
                $(".prom_txt").html('');
                $("#modal_promo_type_row").html('');
                $("#modal_discount_row").html('');
                $("#modal_get_food_menu_id_row").html('');
                $("#modal_qty_row").html('');
                $("#modal_get_qty_row").html('');
                $("#modal_item_name_row").html('');
  
            }
            if(promo_type==1){
                $(".prom_txt").html(string_text);
                $("#modal_discount_amount").html(0);
                $("#modal_discount").val(discount);
                $("#modal_discount").attr("readonly",'');
            }else{
                $("#modal_discount").removeAttr("readonly");
            }
        }
        $(document).on("click", ".vr01_modal_class:visible", function (e) {
            //get modifier price when it's selected
            $("#modal_discount").val('');
            let vr01_modal_price = parseFloat($(this).attr("data-price")).toFixed(ir_precision);
            let item_id = $(this).attr("data-id");
            check_and_show_promotion(item_id);
            let modal_item_vat_percentage = $(this).attr("data-menu_tax");
            let item_name_tmp = $(this).attr("data-item_name_tmp");
            let modal_code = $(this).attr("data-code");
            $("#modal_item_id").html(item_id);
  
            $(".vr01_modal_class").attr("data-selected", "unselected");
  
            if ($(this).attr("data-selected") == "unselected") {
                $(this).attr("data-selected", "selected");
                $(this).children("input").prop("checked", true);
            } else if ($(this).attr("data-selected") == "selected") {
                $(this).attr("data-selected", "unselected");
            }
            $("#vr01_modal_price_variable").html(vr01_modal_price);
            $("#modal_item_vat_percentage").html(modal_item_vat_percentage);
            $("#item_name_modal_custom").html(item_name_tmp);
  
            //update all total with item price
            update_all_vr01_total_price();
        });
        $(document).on("click", ".vr01_modal_class_mod:visible", function (e) {
            //get modifier price when it's selected
            $(".single_modifier").attr("data-selected", "unselected");
            $(".single_modifier").children("input").prop("checked", false);
  
            let item_id = $(this).attr("data-id");
            let price = $(this).attr("data-price");
            let parent_id = $(this).attr("data-parent_id");
            $(".vr01_modal_class_mod").attr("data-selected", "unselected");
  
            if ($(this).attr("data-selected") == "unselected") {
                $(this).attr("data-selected", "selected");
                $(this).children("input").prop("checked", true);
  
  
            } else if ($(this).attr("data-selected") == "selected") {
                $(this).attr("data-selected", "unselected");
            }
  
            if ($("#modifier_"+parent_id).attr("data-selected") == "unselected") {
                if (e.which === 1) {
                    $("#modifier_"+parent_id).click();
                    $("#modifier_"+parent_id).attr('data-price',price);
                    $("#modifier_"+parent_id).find('.modifier_price').html("<span>"+price_txt+":</span> "+price);
                }
            }
  
            //update all total with item price
            update_all_vr01_total_price();
        });
      //initialize item list
  
  
      setTimeout(function () {
          show_all_items();
      }, 700);
      //show all when all button is clicked
      $(document).on(
        "click",
        "#button_category_show_all,.button_category_show_all1",
        function () {
          $(".specific_category_items_holder").fadeOut(0);
          let foundItems = searchItemAndConstructGallery("");
          let searched_category_items_to_show =
            '<div id="searched_item_found" class="specific_category_items_holder 003">';
  
          for (let key in foundItems) {
            if (foundItems.hasOwnProperty(key)) {
                if(foundItems[key].parent_id=='0'){
                    searched_category_items_to_show +=
                        '<div class="single_item animate__animated animate__flipInX"  data-price="'+foundItems[key].price+'"  data-price_take="'+foundItems[key].price_take+'"   data-is_variation="'+foundItems[key].is_variation+'"  data-parent_id="'+foundItems[key].parent_id+'"   data-price_delivery="'+foundItems[key].price_delivery+'"  id="item_' +
                foundItems[key].item_id +
                '">';
              searched_category_items_to_show +=
                '<img src="' + foundItems[key].image + '" alt="" width="141">';
              searched_category_items_to_show +=
                '<p class="item_name" data-tippy-content="' +
                foundItems[key].item_name +
                '">' +
                foundItems[key].item_name +
                "</p>";
              searched_category_items_to_show +=
                '<p class="item_price">' +
                price_txt +
                ": " +
                foundItems[key].price +
                "</p>";
              searched_category_items_to_show += "</div>";
            }
          }
          }
          searched_category_items_to_show += "<div>";
          $("#searched_item_found").remove();
          $(".specific_category_items_holder").fadeOut(0);
          $(".category_items").prepend(searched_category_items_to_show);
            if(food_menu_tooltip=="show"){
                tippy(".item_name", {
                    placement: "bottom-start",
                });
            }
        }
      );
        $(document).on("click","#combo_item",function () {
                $(".specific_category_items_holder").fadeOut(0);
                let foundItems = searchItemAndConstructGallery("");
                let searched_category_items_to_show =
                    '<div id="searched_item_found" class="specific_category_items_holder 003">';
  
                for (let key in foundItems) {
                    if (foundItems.hasOwnProperty(key)) {
                        if(foundItems[key].parent_id=='0' && foundItems[key].product_type==2){
                            searched_category_items_to_show +=
                                '<div class="single_item animate__animated animate__flipInX"  data-price="'+foundItems[key].price+'"  data-price_take="'+foundItems[key].price_take+'"   data-is_variation="'+foundItems[key].is_variation+'"  data-parent_id="'+foundItems[key].parent_id+'"   data-price_delivery="'+foundItems[key].price_delivery+'"  id="item_' +
                                foundItems[key].item_id +
                                '">';
                            searched_category_items_to_show +=
                                '<img src="' + foundItems[key].image + '" alt="" width="141">';
                            searched_category_items_to_show +=
                                '<p class="item_name" data-tippy-content="' +
                                foundItems[key].item_name +
                                '">' +
                                foundItems[key].item_name +
                                "</p>";
                            searched_category_items_to_show +=
                                '<p class="item_price">' +
                                price_txt +
                                ": " +
                                foundItems[key].price +
                                "</p>";
                            searched_category_items_to_show += "</div>";
                        }
                    }
                }
                searched_category_items_to_show += "<div>";
                $("#searched_item_found").remove();
                $(".specific_category_items_holder").fadeOut(0);
                $(".category_items").prepend(searched_category_items_to_show);
            if(food_menu_tooltip=="show"){
                tippy(".item_name", {
                    placement: "bottom-start",
                });
            }
            }
        );
      $(document).on("click", "#increase_item_modal", function (e) {
        //get recent item price
        let current_item_price_modal = parseFloat(
          $("#modal_item_price").html()
        ).toFixed(ir_precision);
        //get current item quantity
        let current_item_quantity = Number($("#item_quantity_modal").val());
        //increase quantity
        current_item_quantity++;
        //update quantity
        $("#item_quantity_modal").val(current_item_quantity);
  
        //update all total with item price
        update_all_total_price();
      });
      $(document).on("keyup", "#item_quantity_modal", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val(1);
          }
          //update all total with item price
          update_all_total_price();
      });
      
      $(document).on(
        "dblclick",
        ".holder .order_details > .single_order",
        function () {
          let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
          get_details_of_a_particular_order_for_modal(sale_no);
        }
      );
  
      function put_audit_log_report_for_cancel_order(order_info,reason){
          if(checkInternetConnection()){
              $.ajax({
                  url: base_url + "Sale/add_cancel_audit_report",
                  method: "post",
                  dataType: "json",
                  data: {
                      order: order_info,reason:reason
                  },
                  success: function (data) {
  
                  },
                  error: function () {},
              });
          }
      }
  
      function cancel_order_by_click(sale_no,reason){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  if(cursor.value.sale_no == sale_no) {
                      let orderData = cursor.value;
                      let orderInfo = orderData.order;
                      let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                      request.onsuccess = function(event) {
                          //update log
                          put_audit_log_report_for_cancel_order(orderInfo,reason);
                          $("#order_" + get_plan_string(sale_no)).remove();
                          toastr['success']((cancel_order_msg), '');
                      }
                  }
  
                  cursor.continue();
              }
          }
          removeOrderTablesBySaleId(sale_no,'');
          displayOrderList();
  
          $(".order_table_holder .order_holder").empty();
          clearFooterCartCalculation();
          $(".single_table_div[data-table-checked=checked]").attr(
              "data-table-checked",
              "unchecked"
          );
  
          $("#select_walk_in_customer").val("1");
      }
      function close_order_by_click(sale_no){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  if(cursor.value.sale_no == sale_no) {
                      let orderData = cursor.value;
                      let orderInfo = orderData.order;
                      let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                      request.onsuccess = function(event) {
                          $("#order_" + get_plan_string(sale_no)).remove();
                          toastr['success']((close_order_msg), '');
                      }
                  }
  
                  cursor.continue();
              }
          }
          removeOrderTablesBySaleId(sale_no,'');
          clearFooterCartCalculation();
          displayOrderList();
  
          $(".order_table_holder .order_holder").empty();
          clearFooterCartCalculation();
          $(".single_table_div[data-table-checked=checked]").attr(
              "data-table-checked",
              "unchecked"
          );
          if (waiter_app_status != "Yes") {
              $("#select_waiter").val("");
          }
          $("#select_walk_in_customer").val("1");
      }
      function closeOrderForWaiter(sale_no){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  let rowData = JSON.parse(cursor.value.order);
                  let sale_no_local = rowData.sale_no;
  
                  if(sale_no_local == sale_no) {
                      let orderData = cursor.value;
                      let orderInfo = orderData.order;
                      let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                      request.onsuccess = function(event) {
                          removeOrderTablesBySaleId(cursor.value.sale_no,'');
                          displayOrderList();
                      }
                  }
  
                  cursor.continue();
              }
          }
      }
      function updateOrderForWaiter(sale_no,content_html){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  let rowData = JSON.parse(cursor.value.order);
                  let sale_no_local = rowData.sale_no;
  
                  if(sale_no_local == sale_no) {
                      let updateData = cursor.value;
                      updateData.order = content_html;
                      let request = cursor.update(updateData);
  
                      request.onsuccess = function() {
                          displayOrderList();
                      }
                  }
  
                  cursor.continue();
              }
          }
      }
      function deleteOrderForWaiter(sale_no){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          objectStore.openCursor().onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  let rowData = JSON.parse(cursor.value.order);
                  let sale_no_local = rowData.sale_no;
                  if(sale_no_local == sale_no) {
                      let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                      request.onsuccess = function(event) {
                          displayOrderList();
                      }
                  }
  
                  cursor.continue();
              }
          }
      }
      $(document).on("click", "#cancel_order_button", function (e) {
          let pos_2 = Number($("#pos_2").val());
          if(pos_2){
              if ($(".holder .order_details > .single_order[data-selected=selected]").length > 0) {
                  let selected_order = $(".holder .order_details > .single_order[data-selected=selected]");
                  let selected_order_started_cooking_items = selected_order.attr(
                      "data-started-cooking"
                  );
                  let selected_order_done_cooking_items = selected_order.attr(
                      "data-done-cooking"
                  );
                  if (selected_order_started_cooking_items > 0 || selected_order_done_cooking_items > 0) {
                      toastr['error']((order_in_progress_or_done), '');
                  }else{
                      swal({
                              title: warning + "!",
                              text: write_your_reason+"!",
                              type: "input",
                              showCancelButton: true,
                              closeOnConfirm: false,
                              animation: "slide-from-top",
                              inputPlaceholder: "Write reason" },
                          function(inputValue){
                              if (inputValue === false) return false;
                              if (inputValue === "") {
                                  swal.showInputError("Please enter your reason!");
                                  return false
                              }else{
                                  $(".sa-button-container").find('.cancel').click();

                                  let sale_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
                                  if(checkInternetConnection()){
                                      $.ajax({
                                          url: base_url + "Kitchen/check_update_kitchen_status_ajax",
                                          method: "post",
                                          dataType: "json",
                                          data:{sale_no:sale_no},
                                          success: function (data) {
                                              if(data.status==false){
                                                  cancel_order_by_click(sale_no,inputValue);
                                              }else if(data.is_done==true){
                                                  toastr['error']((this_item_is_under_cooking_please_contact_with_admin), '');
                                                  return false;
                                              }else if(data.is_cooked==true){
                                                  toastr['error']((this_item_already_cooked_please_contact_with_admin), '');
                                                  return false;
                                              }
                                          },
                                          error: function () {},
                                      });
                                  }else {
                                      cancel_order_by_click(sale_no,inputValue);
                                  }
                              }
                          });
                  }
  
              } else {
                  toastr['error']((please_select_order_to_proceed + "!"), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
        $(document).on("click", "#close_order_button", function (e) {
          let pos_2 = Number($("#pos_2").val());
          if(pos_2){
              if ($(".holder .order_details > .single_order[data-selected=selected]").length > 0) {
                  let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                  if(pre_or_post_payment==2){
                      let res_checker = getSelectedOrderDetails(sale_no).then(function(data){
                          let is_invoice = data.is_invoice;
                          if(is_invoice==1){
                              let order_close_error = $("#order_close_error").val();
                              toastr['error']((order_close_error + "!"), '');
                          }else{
                              swal(
                                  {   title: warning + "!",
                                      text: sure_close_this_order,
                                      confirmButtonColor: "#3c8dbc",
                                      confirmButtonText: ok,
                                      showCancelButton: true,
                                  },
                                  function () {
                                      $.ajax({
                                                      url:
                                                      base_url +
                                                      "Authentication/setPickupClose",
                                                      method: "post",
                                                      dataType:'json',
                                                      data: {
                                                          sale_no: sale_no,
                                                          csrf_irestoraplus: csrf_value_,
                                                      },
                                                      success: function (response) {
  
                                                      },
                                                      error: function () {
  
                                                      },
                                                  });
                                      close_order_by_click(sale_no);
                                  });
                          }
                      });
                  }else{
                      swal(
                          {
                              title: warning + "!",
                              text: sure_close_this_order,
                              confirmButtonColor: "#3c8dbc",
                              confirmButtonText: ok,
                              showCancelButton: true,
                          },
                          function () {
                              $.ajax({
                                                      url:
                                                      base_url +
                                                      "Authentication/setPickupClose",
                                                      method: "post",
                                                      dataType:'json',
                                                      data: {
                                                          sale_no: running_order_order_number,
                                                          csrf_irestoraplus: csrf_value_,
                                                      },
                                                      success: function (response) {
  
                                                      },
                                                      error: function () {
  
                                                      },
                                                  });
                              close_order_by_click(sale_no);
                          });
                  }
              } else {
                  toastr['error']((please_select_order_to_proceed + "!"), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
  
      $(document).on("click", ".plus_button", function (e) {
          let pos_8 = Number($("#pos_8").val());
          let is_self_order = $("#is_self_order").val();
          if(is_self_order=="Yes"){
              pos_8 = 1;
          }
          let title = $(this).attr("data-title");
          $(".add_customer_title").text(title);
          if(pos_8){
              let html = '<tr><td><label class="pointer_class"><input type="radio" checked="" class="radio_class customer_del_address search_result_address" data-value="New" name="customer_del_address"> New</label></td></tr>';
              $("#is_new_address").val("Yes");
              $(".added_address").html(html);
  
              $("#add_customer_modal").addClass("active");
              $(".pos__modal__overlay").fadeIn(200);
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
      });
      $(document).on("click", ".modify_order_table_modal", function (e) {
        let table_id = $(this).attr("id").substr(19);
        //get total items in cart
        let total_items_in_cart = $(".order_holder .single_order").length;
  
        if (total_items_in_cart > 0) {
          swal(
            {
              title: warning + "!",
              text: cart_not_empty,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
              $(".order_holder").empty();
              $.ajax({
                url:
                  base_url +
                  "Sale/get_all_information_of_a_sale_by_table_id_ajax",
                method: "post",
                data: {
                  table_id: table_id,
                  csrf_irestoraplus: csrf_value_,
                },
                success: function (response) {
                  response = JSON.parse(response);
                  arrange_info_on_the_cart_to_modify(response);
                  $(".single_table_div[data-table-checked=checked]").css(
                    "background-color",
                    "#ffffff"
                  );
                  $(".single_table_div[data-table-checked=checked]").attr(
                    "data-table-checked",
                    "unchecked"
                  );
                  $("#show_tables_modal").slideUp(333);
                },
                error: function () {
                  alert(a_error);
                },
              });
            }
          );
        } else {
          $.ajax({
            url: base_url + "Sale/get_all_information_of_a_sale_by_table_id_ajax",
            method: "post",
            data: {
              table_id: table_id,
              csrf_irestoraplus: csrf_value_,
            },
            success: function (response) {
              response = JSON.parse(response);
              arrange_info_on_the_cart_to_modify(response);
              $(".single_table_div[data-table-checked=checked]").css(
                "background-color",
                "#ffffff"
              );
              $(".single_table_div[data-table-checked=checked]").attr(
                "data-table-checked",
                "unchecked"
              );
              $("#show_tables_modal").slideUp(333);
            },
            error: function () {
              alert(a_error);
            },
          });
        }
      });

      function update_kitchen_status(sale_no){
        $.ajax({
            url: base_url + "Kitchen/get_update_kitchen_status_ajax",
            method: "POST",
            datatype:'json',
            data:{sale_no:sale_no},
            success: function (response) {
                response = JSON.parse(response);
                for (let k in response) {
                    let cooking_status = response[k].cooking_status;
                    let item_id = Number(response[k].food_menu_id);
                    $(".update_kitchen_status ").each(function() {
                        let this_item_id = Number($(this).attr("data-id"));
                        if(item_id==this_item_id){
                            $(this).attr("data-is_cooked",cooking_status);
                        }

                    });

                }
            },
            error: function () {

            },
        });
    }

    function setMergeTableFinal(objects,sale_no,table_text,merge_tables){

        // Custom Merge with Summation and Floating Values as Strings
        function mergeDynamicObjects(objects, sale_no,table_text) {
            // Create an initial result object as a deep copy of the first object
            let result = $.extend(true, {}, objects[0]);
        
            // Merge remaining objects into the result
            for (let i = 1; i < objects.length; i++) {
                const currentObject = objects[i];
        
                // Merge and sum specific properties
                function sumAsString(a, b) {
                    const sum = (parseFloat(a) || 0) + (parseFloat(b) || 0);
                    return sum.toFixed(2); // Keep it as a string with 2 decimal places
                }
        
                // Properties to sum
                const propertiesToSum = [
                    "sub_total",
                    "total_vat",
                    "total_payable",
                    "total_item_discount_amount",
                    "sub_total_discount_amount",
                    "total_discount_amount",
                    "delivery_charge",
                    "tips_amount",
                    "delivery_charge_actual_charge",
                    "tips_amount_actual_charge",
                    "total_items_in_cart",
                    "sub_total_with_discount",
                    "sub_total_discount_value",
                    "total_items_in_cart_qty",
                    "tax_field_amount",
                ];
        
                propertiesToSum.forEach((prop) => {
                    result[prop] = sumAsString(result[prop], currentObject[prop]);
                });
        
                // Combine `items` array
                result.items = (result.items || []).concat(currentObject.items || []);
                
                let sale_vat_objects_object = (result.sale_vat_objects || []).concat(currentObject.sale_vat_objects || []);
                let result1 = {};
                // Sum up amounts by tax_field_type
                $.each(sale_vat_objects_object, function (index, item) {
                    let type = item.tax_field_type;
                    let amount = parseFloat(item.tax_field_amount);
            
                    if (result1[type]) {
                        result1[type] += amount;
                    } else {
                        result1[type] = amount;
                    }
                });
            
                // Convert result to final object array
                let finalArray = $.map(result1, function (amount, type) {
                    return { "tax_field_id": 1,"tax_field_type": type, "tax_field_amount": amount.toFixed(2) };
                });
                result.sale_vat_objects  = finalArray;

            }
        
            // Generate a custom sale_no
            result.sale_no =  sale_no.join(" || ");
            result.is_merge =  1;
            result.orders_table_text = table_text.join(" || ");
            
            return result;
        } 
        const mergedObject = mergeDynamicObjects(objects, sale_no,table_text);
 
        var order_info = JSON.stringify(mergedObject);
        let outlet_id_indexdb = $("#outlet_id_indexdb").val();
        let company_id_indexdb = $("#company_id_indexdb").val();
   
        $.each(sale_no, function(index, value) {
            setMergeDelete(value);
            deleteOrderForWaiter(value);
        });
        let new_updated_sale_no = sale_no.join(" || ");

        push_online_for_kitchen(order_info,'',new_updated_sale_no,0);
        add_sale_by_ajax('',order_info,outlet_id_indexdb,company_id_indexdb,new_updated_sale_no,"",'',1);
        
        $("#show_tables_modal2").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);

        let last_inserted_id = $("#last_future_sale_id").val();

        $.each(merge_tables, function(index, item) {
            updateForMerge(item,last_inserted_id)
         });


         setTimeout(function () {
            $("#order_"+get_plan_string(new_updated_sale_no)).attr('data-selected',"selected");
            $("#create_invoice_and_close").click();
            $(".invoice_btn_class").eq(1).click();
        }, 2000);
        
 
    }

      $(document).on("click", ".set_quick_action", function (e) {
          //unset transfter table action
          $("#is_click_transfer_table").val('');
          $("#active_transfer_table").val('');
          $("#active_transfer_sale_id").val('');
          let this_active = Number($(this).attr('data-id')); 
          let is_active_table  = 0;
          let active_count = 0;
          let is_active_action  = '';
              $(".table_bg").find(".div_rectangular").each(function (i, obj) {
                  if ($(this).hasClass("div_rectangular_active")) {
                      is_active_table = Number($(this).find(".trigger_to_select_other").attr("data-id"));
                      is_active_action = $(this);
                      active_count++;
                  }
              });
               
              if(is_active_table){
                  let table_id = is_active_action.find(".get_table_details").attr("data-id");
                  let table_name = is_active_action.find(".get_table_details").attr("data-name");
                  let booked_id = Number(is_active_action.find(".get_table_details").attr("data-booked_id"));
                  let order_number = (is_active_action.find(".get_table_details").attr("data-order_number"));
                  if(order_number){
                    if (!$("#order_"+get_plan_string(order_number)).length) {
                        toastr['warning']((this_order_engage), '');
                        return false;
                    }
                  }
                  if(booked_id){
                    if(active_count>1){
                         if(this_active==55){ 
                            $("#is_click_merge_table").val(1);
                            let is_merge_exist = 0;
                            let merge_sale_ids = '';
                            $(".table_bg").find(".div_rectangular").each(function (i, obj) {
                                if ($(this).hasClass("div_rectangular_active")) {
                                    let merge_id = Number($(this).find(".get_table_details").attr("data-merge_id"));
                                    let order_number_merge = ($(this).find(".get_table_details").attr("data-name"));
                                     if(merge_id){
                                        is_merge_exist++;
                                        merge_sale_ids+=order_number_merge;
                                        merge_sale_ids+=",";
                                     }
                                }
                            });

                            if(is_merge_exist){
                                toastr['error']((already_merge+merge_sale_ids), '');
                                return false;
                            }else{
                                swal(
                                    {
                                        title: warning + "!",
                                        text: not_merge_yet,
                                        confirmButtonColor: "#3c8dbc",
                                        confirmButtonText: ok,
                                        showCancelButton: true,
                                    },
                                    function () {
                                        const objects = [];
                                        let sale_no_all = [];
                                        let table_text = [];
                                        let merge_tables = [];
    
                                        $(".table_bg").find(".div_rectangular").each(function (i, obj) {
                                            if ($(this).hasClass("div_rectangular_active")) {
                                                 let object = $(this).find(".sale_object").html();
                                                 objects.push(JSON.parse(object));
                                                 let this_sale_no = $(this).find(".get_table_details").attr("data-order_number");
                                                 let booked_id_custom = $(this).find(".get_table_details").attr("data-booked_id");
                                                 let this_table_no = $(this).find(".get_table_details").attr("data-name");
                                                 sale_no_all.push(this_sale_no);
                                                 table_text.push(this_table_no);
                                                 merge_tables.push(booked_id_custom);
                                                 
                                            }
                                        });
    
                                        setMergeTableFinal(objects,sale_no_all,table_text,merge_tables);
                                    });
                            }
                          
                        }
                    }else{
                        if(this_active==1){
                            $("#order_"+get_plan_string(order_number)).click();
                            $(".invoice_btn_class").eq(1).click();
                        }else if(this_active==2){
                            $("#order_"+get_plan_string(order_number)).click();
                            $(".invoice_btn_class").eq(0).click();
                        }else if(this_active==55){
                            toastr['error']((at_least_select_two_table), '');
                                return false;
                        }else if(this_active==3){
                            $("#update_sale_id").val(order_number);
                            $("#is_edit_click").val(2);
                            get_details_of_a_particular_order(order_number);
                            setTimeout(function () {
                                update_kitchen_status(order_number);
                            }, 1000);
                            
                        }else if(this_active==4){
                            $("#order_"+get_plan_string(order_number)).click();
                            $("#create_bill_and_close").click();
                        }else if(this_active==44){
                            $("#is_click_transfer_table").val(1);
                            $("#active_transfer_table").val(table_id);
                            $("#active_transfer_sale_id").val(order_number);
                            toastr['warning']((not_booked_yet), '');
                            let ii = 0;   
                            $(".table_bg").find(".div_rectangular").each(function (i, obj) {
                                if (!$(this).hasClass("div_rectangular_active")) {
                                    let is_booked = $(this).find(".get_table_details").attr('data-order_number');
                                    if(!is_booked){
                                        let element = $(this);
                                        element.addClass('blink_active');
                                        setTimeout(function() {
                                            element.removeClass('blink_active');
                                        }, (ii + 1) * 300);  
                                        ii++;
                                    }
                                    
                                }
                            });
    
                        }else if(this_active==5){
                            $("#order_"+get_plan_string(order_number)).click();
                            $("#cancel_order_button").click();
                        }else{
                            $("#last_click_order_id").val(booked_id); 
                            $("#note_modal").addClass("active");
                            $(".pos__modal__overlay").fadeIn(200);
                        }
                    }
                  }else{
                      $("#table_id").val(table_id);
                      $("#hidden_table_name").val(table_name);
                      $("#table_button").html("<i class='fal fa-table'></i> "+table_text+":"+table_name);
                      $("#table_button").removeAttr("red_text");
                  }
                  if(this_active!=44 && this_active!=55){
                      $(this)
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .removeClass("active")
                      .addClass("inActive");
                      setTimeout(function () {
                          $(".modal").removeClass("inActive");
                      }, 1000);
  
                  $("#show_tables_modal2").removeClass("active");
                  $(".pos__modal__overlay").fadeOut(300);
                  }
              }else{
                  toastr['error']((please_select_a_table_for_action), '');
              }
      });
      $(document).on("click", "#table_button,.dine_in_button", function (e) {
        if ($(".order_table_holder .order_holder > .modification").length > 0) {
          let sale_id = $(
            ".order_table_holder .order_holder > .modification"
          ).html();
          let sale_no = $(
            ".order_table_holder .order_holder > .modification"
          ).attr("data-sale-no");
        }

        
        if (typeof sale_no !== "undefined") {
          $("#order_number_or_new_text").html(sale_no);
          $(".bottom_order").val(sale_no);
        } else {
          $("#order_number_or_new_text").html("New");
        }
        $("#show_tables_modal2").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);

        $(".bottom_person").val("1");
  
        $(".set_quick_action").removeClass("set_quick_action_active");
        $(".get_area_table").eq(0).click();
          //append ordered tables
          let is_new_table = $(".new_book_to_table").length;
          if(!is_new_table){
              $(".single_order_table").each(function() {
                  let table_id = Number($(this).attr('id').substr(25));
                  setOrderTables(table_id);
              });
          }
      });
      $(document).on("click", "#order_details_close_button", function (e) {
        $(this)
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay").fadeOut(300);
      });
      $(document).on("click", "#order_details_close_button2", function (e) {
        $("#order_detail_modal").removeClass("active");
        $(".pos__modal__overlay").fadeOut(300);
      });
      $("#order_details_close_order_button").on(
        "click",
        function () {
            if ($(".holder .order_details > .single_order[data-selected=selected]").length > 0) {
                let selected_order = $(".holder .order_details > .single_order[data-selected=selected]");
                let selected_order_started_cooking_items = selected_order.attr(
                    "data-started-cooking"
                );
                let selected_order_done_cooking_items = selected_order.attr(
                    "data-done-cooking"
                );
                if (selected_order_started_cooking_items > 0 || selected_order_done_cooking_items > 0) {
                    toastr['error']((order_in_progress_or_done), '');
                }
                let ur_role = $("#ur_role").val();
                if(ur_role==="Admin"){
                    swal(
                        {
                            title: warning + "!",
                            text: sure_cancel_this_order,
                            confirmButtonColor: "#3c8dbc",
                            confirmButtonText: ok,
                            showCancelButton: true,
                        },
                        function () {
                            let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                            let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
                            objectStore.openCursor().onsuccess = function(event) {
                                let cursor = event.target.result;
  
                                if (cursor) {
                                    if(cursor.value.sale_no == sale_no) {
                                        let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                                        request.onsuccess = function(event) {
                                            $("#order_" + get_plan_string(sale_no)).remove();
                                        }
                                    }
  
                                    cursor.continue();
                                }
                            }
                            removeOrderTablesBySaleId(sale_no,'');
                            clearFooterCartCalculation();
                            displayOrderList();
  
                            $(".order_table_holder .order_holder").empty();
                            clearFooterCartCalculation();
                            $(".single_table_div[data-table-checked=checked]").attr(
                                "data-table-checked",
                                "unchecked"
                            );
                            if (waiter_app_status != "Yes") {
                                $("#select_waiter").val("");
                            }
                            $("#select_walk_in_customer").val("1");
  
                        });
                }else{
                    toastr['error']((please_select_order_to_proceed + "!"), '');
                }
  
            } else {
                toastr['error']((please_select_order_to_proceed + "!"), '');
            }
        }
      );
      $(document).on("click", "#decrease_item_modal", function (e) {
        //get recent item price
        let current_item_price_modal = parseFloat(
          $("#modal_item_price").html()
        ).toFixed(ir_precision);
        //get current item quantity
        let current_item_quantity = Number($("#item_quantity_modal").val());
  
        //decrease quantity if greater than 1
        if (current_item_quantity > 1) current_item_quantity--;
  
        //update quantity
  
        $("#item_quantity_modal").val(current_item_quantity);
        //update all total with item price
        update_all_total_price();
      });
      $("#last_ten_sales_close_button,#last_ten_sales_close_button_cross").on(
        "click",
        function () {
            $(this)
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .removeClass("active")
                .addClass("inActive");
            setTimeout(function () {
                $(".modal").removeClass("inActive");
            }, 1000);
            $(".pos__modal__overlay").fadeOut(300);
          reset_last_10_sales_modal();
        }
      );
      $("#customer_dob_modal").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          endDate:'0'
      });
      $("#customer_doa_modal").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          endDate:'0'
      });
        $(document).on("click", "#last_ten_sales_button", function (e) {
            $("#show_last_ten_sales_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
  
            let objectStore = db.transaction(['recent_sales'], "readwrite").objectStore("recent_sales");
            let sales_id = '';
            let i = 1;
            let last_10_orders = "";
            objectStore.openCursor(null, 'prev').onsuccess = function(event) {
                let cursor = event.target.result;
                if (cursor) {
                      let outlet_id_indexdb = Number($("#outlet_id_indexdb").val());
  
                      let orderData = cursor.value;
                      let orderInfo = orderData.order;
                      let rowData = JSON.parse(orderInfo);
                      let sales_id = cursor.value.sales_id;
                      let db_outlet_id = Number(cursor.value.outlet_id);
                          
                      if(db_outlet_id==outlet_id_indexdb){
                          let order_name = "";
                          let phone_text_ = "";
                          
                          if (rowData.phone) {
                              phone_text_ = " (" + rowData.phone + ")";
                          }
                          let table_name =
                              rowData.table_name != null ? rowData.table_name : "&nbsp;";
                          last_10_orders +=
                              '<div class="single_last_ten_sale fix" data-sale_no="'+rowData.sale_no+'" id="last_ten_' +
                              sales_id +
                              '" data-selected="unselected">';
                          last_10_orders +=
                              '<div class="first_column column fix">' + rowData.sale_no + "</div>";
                          last_10_orders +=
                              '<div data-token_number="'+rowData.token_number+'" class="second_column column fix">' +
                              rowData.customer_name +
                              phone_text_ +
                              "</div>";
                          last_10_orders +=
                              '<div class="third_column column fix">' + (rowData.orders_table_text!=undefined?rowData.orders_table_text:'None') + "</div>";
                          last_10_orders += "</div>";
      
                          i++;
                    }
                    cursor.continue();
                }
                $(".last_ten_sales_holder .hold_list_holder .detail_holder ").empty();
                $(".last_ten_sales_holder .hold_list_holder .detail_holder ").prepend(
                    last_10_orders
                );
  
  
            };
        });
  
      //when add to card button is clicked information goes to table of middle to top
        $(document).on("click", "#add_to_cart", function (e) {
            //vr01
            let is_variation_product = Number($("#is_variation_product").html());
            let margin_for_vr01_mod = Number($(".margin_for_vr01_mod").length);
            let status = false;
            let status_ = false;
            $(".vr01_modal_class").each(function() {
                if ($(this).attr("data-selected") == "selected") {
                    status = true;
                }
            });
            $(".margin_for_vr01_mod").each(function() {
                if ($(this).is(":checked")) {
                    status_ = true;
                }
            });
  
            if(is_variation_product && !status){
                toastr['error']((selected_variation), '');
            }else{
                let row_number = $("#modal_item_row").html();
  
                let modal_item_is_offer = $("#modal_item_is_offer").text();
                $("#modal_item_is_offer").html("");
  
                //get item/menu id from modal
                let item_id = $("#modal_item_id").html();
                //remove if it is edited update of previous added item based on id
                // if($('#order_for_item_'+item_id).length>0){
                // 	$('#order_for_item_'+item_id).remove();
                // }
                //get item/menu name from modal
                let item_name = $("#item_name_modal_custom").html();
                //get item/menu vat percentage from modal
                let item_vat_percentage = $("#modal_item_vat_percentage").html();
                item_vat_percentage =
                    item_vat_percentage == "" ? "0.00" : item_vat_percentage;
                //discount amount from modal
                let item_discount_amount = parseFloat(
                    $("#modal_discount_amount").html()
                ).toFixed(ir_precision);
  
                //discount input value of modal
                let discount_input_value = $("#modal_discount").val();
  
                //get item/menu price from modal
  
                let item_price = parseFloat($("#modal_item_price").html()).toFixed(ir_precision);
                if(is_variation_product){
                    item_price = parseFloat($("#vr01_modal_price_variable").html()).toFixed(ir_precision);
                }
  
                //get item/menu price from modal without discount
                let item_total_price_without_discount = parseFloat(
                    $("#modal_item_price_variable_without_discount").html()
                ).toFixed(ir_precision);
  
                //get vat amount for specific item/menu
                let item_vat_amount_for_unit_item = (
                    (parseFloat(item_price) * parseFloat(item_vat_percentage)) /
                    parseFloat(100)
                ).toFixed(ir_precision);
  
                //get item/menu total price from modal
                let item_total_price = parseFloat(
                    $("#modal_item_price_variable").html()
                ).toFixed(ir_precision);
  
                //get item/menu quantity from modal
                let item_quantity = $("#item_quantity_modal").val();
  
                //get vat amount for specific item/menu
                let item_vat_amount_for_all_quantity = (
                    parseFloat(item_vat_amount_for_unit_item) * parseFloat(item_quantity)
                ).toFixed(ir_precision);
  
                //get selected modifiers
                let selected_modifiers = "";
                let selected_modifiers_id = "";
                let selected_tmp_mul_mod_id = "";
                let selected_modifiers_price = "";
                //get tax information
  
                let j = 1;
                let draw_table_for_order_tmp_modifier_tax = "";
                let tmp_mul_mod_html_hidden = '';
                $(".modal_modifiers[data-selected=selected]").each(function (i, obj) {
                    let modifier_id_custom = $(this).attr("id").substr(9);
                    /*new_added_zak*/
                    let tmp_mul_type_mod_name = '';
                    let tmp_mul_mod_id = 0;
                    let tmp_modifier_name = $(this).find("p").html();
                    if($(".margin_for_vr01_mod_"+modifier_id_custom+":checked").parent().find("p").html()){
                        tmp_modifier_name = $(".margin_for_vr01_mod_"+modifier_id_custom+":checked").parent().find("p").html();
                        tmp_mul_mod_id = $(".margin_for_vr01_mod_"+modifier_id_custom+":checked").attr("data-id");
                        tmp_mul_mod_html_hidden +='<input type="hidden" class="hidden_mod_cart_'+item_id+'_'+modifier_id_custom+'"  value="'+tmp_mul_mod_id+'">';
                        selected_tmp_mul_mod_id+=tmp_mul_mod_id;
                        selected_tmp_mul_mod_id+=',';
                    }
  
                    /*end_new_added_zak*/
                    if (j == $(".modal_modifiers[data-selected=selected]").length) {
                        selected_modifiers += tmp_modifier_name;
                        selected_modifiers_id += $(this).attr("id").substr(9);
                        selected_modifiers_price += $(this).attr("data-price");
                    } else {
                        selected_modifiers += tmp_modifier_name + ", ";
                        selected_modifiers_id += $(this).attr("id").substr(9) + ",";
                        selected_modifiers_price += $(this).attr("data-price") + ",";
                    }
                    let tax_information = "";
                    // iterate over each item in the array
                    tax_information = $(this).attr("data-menu_tax");
                    // iterate over each item in the array
                    for (let i = 0; i < window.only_modifiers.length; i++) {
                        // look for the entry with a matching `code` value
                        if (
                            only_modifiers[i].menu_modifier_id ==
                            Number($(this).attr("id").substr(9))
                        ) {
                            tax_information = only_modifiers[i].tax_information;
                        }
                    }
  
                    tax_information = IsJsonString(tax_information)
                        ? JSON.parse(tax_information)
                        : "";
  
                    if (tax_information.length > 0) {
                        for (let k in tax_information) {
                            tax_information[k].item_vat_amount_for_unit_item = (
                                (parseFloat($(this).attr("data-price")) *
                                    parseFloat(tax_information[k].tax_field_percentage)) /
                                parseFloat(100)
                            ).toFixed(ir_precision);
                            tax_information[k].item_vat_amount_for_all_quantity = (
                                parseFloat(tax_information[k].item_vat_amount_for_unit_item) *
                                parseFloat(1)
                            ).toFixed(ir_precision);
                        }
                    }
                    draw_table_for_order_tmp_modifier_tax +=
                        '<span class="item_vat_modifier ir_display_none item_vat_modifier_' +
                        item_id +
                        '" data-item_id="' +
                        item_id +
                        '"  data-modifier_price="' +
                        $(this).attr("data-price") +
                        '" data-modifier_id="' +
                        modifier_id_custom +
                        '" id="item_vat_percentage_table' +
                        item_id +
                        "" +
                        modifier_id_custom +
                        '">' +
                        JSON.stringify(tax_information) +
                        "</span>";
  
                    j++;
                });
  
                let tax_information_item = "";
                for (let i = 0; i < window.items.length; i++) {
                    // look for the entry with a matching `code` value
                    if (items[i].item_id == item_id) {
                        tax_information_item = items[i].tax_information;
                    }
                }
  
                tax_information_item= IsJsonString(tax_information_item)
                    ? JSON.parse(tax_information_item)
                    : "";
                if (tax_information_item.length > 0) {
                    for (let k in tax_information_item) {
                        tax_information_item[k].item_vat_amount_for_unit_item = (
                            (parseFloat(item_price) *
                                parseFloat(tax_information_item[k].tax_field_percentage)) /
                            parseFloat(100)
                        ).toFixed(ir_precision);
                        tax_information_item[k].item_vat_amount_for_all_quantity = (
                            parseFloat(tax_information_item[k].item_vat_amount_for_unit_item) *
                            parseFloat(1)
                        ).toFixed(ir_precision);
                    }
                }
  
                //get modifiers price
                let modifiers_price = parseFloat(
                    $("#modal_modifier_price_variable").html()
                ).toFixed(ir_precision);
  
                //get note
                let note = escape_output($("#modal_item_note").val());
                let discount_reason = escape_output($("#discount_reason").val());
  
                //construct div
                let draw_table_for_order = "";
                draw_table_for_order +=
                    row_number > 0
                        ? ""
                        : '<div data-cp_type="1"  class="single_order customer_panel"  data-id="'+item_id+'"  id="order_for_item_' + item_id + '">';
  
                draw_table_for_order += '<div class="first_portion">';
                draw_table_for_order +=
                    '<span class="item_previous_id ir_display_none" id="item_previous_id_table' +
                    item_id +
                    '"></span>';
                draw_table_for_order +=
                    '<span class="item_cooking_done_time ir_display_none" id="item_cooking_done_time_table' +
                    item_id +
                    '"></span>';
                draw_table_for_order +=
                    '<span class="item_cooking_start_time ir_display_none" id="item_cooking_start_time_table' +
                    item_id +
                    '"></span>';
                draw_table_for_order +=
                    '<span class="item_cooking_status ir_display_none" id="item_cooking_status_table' +
                    item_id +
                    '"></span>';
                draw_table_for_order +=
                    '<span class="item_type ir_display_none" id="item_type_table' +
                    item_id +
                    '"></span>';
                draw_table_for_order +=
                    '<span class="item_vat ir_display_none" id="item_vat_percentage_table' +
                    item_id +
                    '">' +
                    JSON.stringify(tax_information_item) +
                    "</span>";
                draw_table_for_order +=
                    '<span class="item_discount ir_display_none" id="item_discount_table' +
                    item_id +
                    '">' +
                    item_discount_amount +
                    "</span>";
                draw_table_for_order +=
                    '<span class="item_price_without_discount ir_display_none" id="item_price_without_discount_' +
                    item_id +
                    '">' +
                    item_total_price_without_discount +
                    "</span>";
                $("#is_variation_product").html(search_by_menu_id_getting_parent_id(item_id, window.items));
  
  
                draw_table_for_order +=
                    '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix"  data-id="'+item_id+'"><i data-parent_id="'+search_by_menu_id_getting_parent_id(item_id, window.items)+'" data-modal_item_is_offer="'+modal_item_is_offer+'" class="fas fa-pencil-alt edit_item txt_5" id="edit_item_' +
                    item_id +
                    '"></i> <span class="arabic_text_left 1_cp_name_'+item_id+'"  id="item_name_table_' +
                    item_id +
                    '">' +
                    item_name +
                    "</span></div>";
                draw_table_for_order +=
                    '<div class="single_order_column second_column fix">' +
                    currency +
                    ' <span class="1_cp_price_'+item_id+'" id="item_price_table_' +
                    item_id +
                    '">' +
                    item_price +
                    "</span></div>";
                draw_table_for_order +=
                    '<div class="single_order_column third_column fix"><i class="fal fa-minus decrease_item_table txt_5" id="decrease_item_table_' +
                    item_id +
                    '"></i> <span data-is_kot_print="1" class="1_cp_qty_'+item_id+' qty_item_custom" id="item_quantity_table_' +
                    item_id +
                    '">' +
                    item_quantity +
                    '</span> <i class="fal fa-plus increase_item_table txt_5" id="increase_item_table_' +
                    item_id +
                    '"></i></div>';
                draw_table_for_order +=
                    '<div class="single_order_column forth_column fix"><input type="" name="" placeholder="Amt or %" class="1_cp_discount_'+item_id+' discount_cart_input" id="percentage_table_' +
                    item_id +
                    '" value="' +
                    discount_input_value +
                    '" disabled></div>';
                draw_table_for_order +=
                    '<div class="single_order_column fifth_column">' +
                    currency +
                    ' <span class="1_cp_total_'+item_id+'" id="item_total_price_table_' +
                    item_id +
                    '">' +
                    item_total_price +
                    '</span><i data-id="' +
                    item_id +
                    '" class="fal fa-times removeCartItem"></i></div>';
                draw_table_for_order += "</div>";
  
  
                let product_comb = $("#item_combo_table_"+item_id).text();
                if (product_comb!= "" && product_comb!=undefined) {
                    draw_table_for_order += '<div class="third_portion fix">';
                    draw_table_for_order +=
                        '<div  data-cp_type="2"  class="customer_panel single_order_column first_column cart_item_counter  arabic_text_left fix modifier_txt_custom"  data-id="'+item_id+'">' +
                        combo_txt +
                        ': <span class="2_cp_name_'+item_id+'" id="item_combo_table_' +
                        item_id +
                        '">' +
                        product_comb +
                        "</span></div>";
                    draw_table_for_order += "</div>";
                }
  
                if (selected_modifiers != "") {
                    draw_table_for_order += '<div class="second_portion fix">';
                    draw_table_for_order += draw_table_for_order_tmp_modifier_tax;
                    draw_table_for_order +=
                        '<span id="item_modifiers_id_table_' +
                        item_id +
                        '" class="ir_display_none">' +
                        selected_modifiers_id +
                        "</span>";
                    draw_table_for_order +=
                        '<span id="item_modifiers_mul_id_table_' +
                        item_id +
                        '" class="ir_display_none">' +
                        selected_tmp_mul_mod_id +
                        "</span>";
                    draw_table_for_order +=
                        '<span id="item_modifiers_price_table_' +
                        item_id +
                        '" class="ir_display_none">' +
                        selected_modifiers_price +
                        "</span>";
                    draw_table_for_order +=
                        '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix ir_display_none"  data-id="'+item_id+'"><span class="modifier_txt_custom" id="item_modifiers_table_' +
                        item_id +
                        '">' +
                        selected_modifiers +
                        "</span></div>";
                    draw_table_for_order +=
                        '<div class="single_order_column ir_display_none fifth_column fix">' +
                        currency +
                        ' <span id="item_modifiers_price_table_' +
                        item_id +
                        '">' +
                        modifiers_price +
                        "</span></div>";
                    $(".modal_modifiers[data-selected=selected]").each(function (i, obj) {
                        let tmp_mod_name_m_n = $(this).find("p").html();
                        let tmp_mod_name_m_p = $(this).attr("data-price");
  
                        draw_table_for_order +='<div data-cp_type="3" data-id="'+item_id+'" class="customer_panel_child_'+item_id+' single_order_column first_column arabic_text_left modifier_incr_n fix"><span class="modifier_txt_custom">'+tmp_mod_name_m_n+'</span></div>';
                        draw_table_for_order +='<div class="3_cp_price_'+item_id+' single_order_column fifth_column fix modifier_incr_p" data-price="'+tmp_mod_name_m_p+'"> <span>'+tmp_mod_name_m_p+'</span></div>';
                    });
                    draw_table_for_order += tmp_mul_mod_html_hidden+"</div>";
  
                }
                if (note != "") {
                    draw_table_for_order += '<div class="third_portion fix">';
                    draw_table_for_order +=
                        '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix modifier_txt_custom"  data-id="'+item_id+'">' +
                        note_txt +
                        ': <span id="item_note_table_' +
                        item_id +
                        '">' +
                        note +
                        "</span></div>";
                    draw_table_for_order += "</div>";
                }

                if (discount_reason != "") {
                    draw_table_for_order += '<div class="third_portion fix">';
                    draw_table_for_order +=
                        '<div class="single_order_column first_column cart_item_counter  arabic_text_left fix modifier_txt_custom"  data-id="'+item_id+'">' +
                        discount_reason_txt +
                        ': <span id="discount_reason_table_' +
                        item_id +
                        '">' +
                        discount_reason +
                        "</span></div>";
                    draw_table_for_order += "</div>";
                }
  
                let modal_item_name_row = $("#modal_item_name_row").html();
                let modal_promo_type_row = Number($("#modal_promo_type_row").html());
                let modal_discount_row = $("#modal_discount_row").html();
                let modal_get_food_menu_id_row = $("#modal_get_food_menu_id_row").html();
                let modal_qty_row = Number($("#modal_qty_row").html());
                let modal_get_qty_row = Number($("#modal_get_qty_row").html());
  
                let counting_qty = (parseInt((item_quantity/modal_qty_row)) * modal_get_qty_row);
  
                if(modal_promo_type_row==2 && counting_qty){
                    draw_table_for_order +=
                        '<div class="free_item_div_'+item_id+'" data-get_fm_id="'+modal_get_food_menu_id_row+'" data-is_free="Yes"><div  data-cp_type="4"  data-id="'+item_id+'"  class="customer_panel single_order_column first_column  arabic_text_left fix"><i data-parent_id="" class="fas fa-pencil-alt free_edit_item txt_5"></i> <span class="4_cp_name_'+item_id+' arabic_text_left"  id="free_item_name_table_' +
                        item_id +
                        '">' +
                        modal_item_name_row +
                        "</span></div>";
                    draw_table_for_order +=
                        '<div class="single_order_column second_column fix">' +
                        currency +
                        ' <span id="free_item_price_table_' +
                        item_id +
                        '">'+(0).toFixed(ir_precision)+'</span></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column third_column fix"><i class="fal fa-minus alert_free_item_increase txt_5" id="free_decrease_item_table_' +
                        item_id +
                        '"></i> <span class="4_cp_qty_'+item_id+' qty_item_custom" id="free_item_quantity_table_' +
                        item_id +
                        '">' +
                        counting_qty +
                        '</span> <i class="fal fa-plus alert_free_item_increase txt_5" id="free_increase_item_table_' +
                        item_id +
                        '"></i></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column forth_column fix"><input type="" name="" placeholder="Amt or %" class="discount_cart_input" id="free_percentage_table_' +
                        item_id +
                        '" value="' +
                        discount_input_value +
                        '" disabled></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column fifth_column">' +
                        currency +
                        ' <span id="free_item_total_price_table_' +
                        item_id +
                        '">'+(0).toFixed(ir_precision)+'</span><i data-id="' +
                        item_id +
                        '" class="fal fa-times removeCartItemFree"></i></div>';
                    draw_table_for_order += "</div></div>";
                }
  
                draw_table_for_order += row_number > 0 ? "" : "</div>";
  
                //add to top if new it or update the row
                if (row_number > 0) {
                    $(
                        ".order_holder .single_order[data-single-order-row-no=" +
                        row_number +
                        "]"
                    ).empty();
                    $(
                        ".order_holder .single_order[data-single-order-row-no=" +
                        row_number +
                        "]"
                    ).html(draw_table_for_order);
                    $(".order_holder .single_order[data-single-order-row-no=" + row_number + "]").attr("id",'order_for_item_'+item_id);
                } else {
                    $(".order_holder").prepend(draw_table_for_order);
                }
  
                if(s_width<=700){
                    $.notifyBar({ cssClass: "success", html: item_add_success });
                }
                reset_on_modal_close_or_add_to_cart();
                // return false;
                //do calculation on table
                do_addition_of_item_and_modifiers_price();
            }
            //focus search field
            focusSearch();
        });
  
        function increase_free_item_qty(type,qty_cart,item_id){
            // iterate over each item in the array
            let product_type = 1;
            let product_comb = '';
            let is_promo = '';
            let promo_type = '';
            let string_text = '';
            let discount = 0;
            let get_food_menu_id = 0;
            let qty = 0;
            let get_qty = 0;
            let modal_item_name_row = '';
            let draw_table_for_order = ''
            for (let i = 0; i < window.items.length; i++) {
                // look for the entry with a matching `code` value
                if (items[i].item_id == Number(item_id)) {
                    product_type = Number(items[i].product_type);
                    product_comb = (items[i].product_comb);
                    is_promo = (items[i].is_promo);
                    promo_type = Number((items[i].promo_type));
                    string_text = (items[i].string_text);
                    discount = (items[i].discount);
                    get_food_menu_id = (items[i].get_food_menu_id);
                    qty = (items[i].qty);
                    get_qty = (items[i].get_qty);
                    modal_item_name_row = (items[i].modal_item_name_row);
                    /*end_added_new_zakir*/
                }
            }
            if(is_promo=="Yes" && promo_type==2){
                let counting_qty_cart = (parseInt((qty_cart/qty)) * get_qty);
                if(counting_qty_cart>0){
                    draw_table_for_order +=
                        '<div class="free_item_div_'+item_id+'"  data-get_fm_id="'+get_food_menu_id+'"  data-is_free="Yes"><div  data-cp_type="4" data-id="'+item_id+'" class="customer_panel single_order_column first_column arabic_text_left fix"><i data-parent_id="" class="fas fa-pencil-alt free_edit_item txt_5"></i> <span class="4_cp_name_'+item_id+' arabic_text_left"  id="free_item_name_table_' +
                        item_id +
                        '">' +
                        modal_item_name_row +
                        "</span></div>";
                    draw_table_for_order +=
                        '<div class="single_order_column second_column fix">' +
                        currency +
                        ' <span id="free_item_price_table_' +
                        item_id +
                        '">'+(0).toFixed(ir_precision)+'</span></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column third_column fix"><i class="fal fa-minus alert_free_item_increase txt_5" id="free_decrease_item_table_' +
                        item_id +
                        '"></i> <span class="4_cp_qty_'+item_id+' qty_item_custom" id="free_item_quantity_table_' +
                        item_id +
                        '">' +
                        counting_qty_cart +
                        '</span> <i class="fal fa-plus alert_free_item_increase increase_item_table txt_5" id="free_increase_item_table_' +
                        item_id +
                        '"></i></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column forth_column fix"><input type="" name="" placeholder="Amt or %" class="discount_cart_input" id="free_percentage_table_' +
                        item_id +
                        '" value="" disabled></div>';
                    draw_table_for_order +=
                        '<div class="single_order_column fifth_column">' +
                        currency +
                        ' <span id="free_item_total_price_table_' +
                        item_id +
                        '">'+(0).toFixed(ir_precision)+'</span><i data-id="' +
                        item_id +
                        '" class="fal fa-times removeCartItemFree"></i></div>';
                    draw_table_for_order += "</div></div>";
  
              let free_item_div = $(".free_item_div_"+item_id).attr('data-is_free');
              if(free_item_div=="Yes"){
                  $("#free_item_quantity_table_"+item_id).html(counting_qty_cart);
              }else{
                  $("#order_for_item_"+item_id).append(draw_table_for_order);
              }
              }else{
                    $(".free_item_div_"+item_id).remove();
                }
  
            }
        }
      //when plus sign is clicked in the table
      $(document).on(
        "click",
        ".single_order .first_portion .third_column .increase_item_table",
        function () {
            //focus search field
            focusSearch();
          let item_id = $(this).attr("id").substr(20);
          let stock_not_available = $("#stock_not_available").val();
          let qty_current = 1;
          $(".single_order_column").each(function () {
            let qty_counter = Number(
              $(this)
                .find("#item_quantity_table_" + item_id)
                .html()
            );
            if (qty_counter && qty_counter != "NAN") {
              qty_current += qty_counter;
            }
          });
  
            let single_order_element_object = $(this).parent().parent().parent();
            //get item id
  
            //get this item quantity
            let item_quantity = $(this).parent().find("span").html();
  
            //get this item's unit price
            let unit_price = $(this)
                .parent()
                .parent()
                .find(".second_column span")
                .html();
            let cooking_status = single_order_element_object
                .find("#item_cooking_status_table" + item_id)
                .html();
            if (cooking_status != "" && cooking_status !== undefined) {
                toastr['error']((progress_or_done_kitchen), '');
                return false;
            }
            //increase item quantity
            item_quantity++;
  
            //increase item's total price based on unit price and quantity
            let updated_total_price = (
                parseFloat(item_quantity) * parseFloat(unit_price)
            ).toFixed(ir_precision);
  
            //update total price of this item to view
            $(this)
                .parent()
                .parent()
                .find(".item_price_without_discount")
                .html(updated_total_price);
  
            //update quantity of this item to view
            $(this).parent().find("span").html(item_quantity);
  
            increase_free_item_qty(2,item_quantity,item_id);
            //do calculation on update values
            do_addition_of_item_and_modifiers_price();
        }
      );
      //when - sign is clicked in the table
      $(document).on(
        "click",
        ".single_order .first_portion .third_column .decrease_item_table",
        function () {
            //focus search field
            focusSearch();

            let pos_7 = Number($("#pos_7").val());
          if(waiter_app_status=="Yes"){
              pos_7 = 1;
          }
          let place_edit_order = $("#place_edit_order").html();
          if(place_edit_order!="Update Order"){
            pos_7 = 1;
          }
          let is_self_order = $("#is_self_order").val();
          if(pos_7 || is_self_order=="Yes"){
            let single_order_element_object = $(this).parent().parent().parent();
            //get item id
            let item_id = $(this).attr("id").substr(20);
            //get this item quantity
            let item_quantity = $(this).parent().find("span").html();
            //get this item's unit price
            let unit_price = $(this)
              .parent()
              .parent()
              .find(".second_column span")
              .html();
            let cooking_status = single_order_element_object
              .find("#item_cooking_status_table" + item_id)
              .html();
    
            if (cooking_status != "" && cooking_status !== undefined) {
                toastr['error']((progress_or_done_kitchen), '');
              return false;
            }
            //decrease item quantity if greater then 1 or remove full item from table
            if (item_quantity > 1) {
  
              let sale_no = $(this).parent().parent().parent().parent().find(".modification").attr("data-sale-no");
             
              let this_action = $(this);
              //add log for removing the item.
              let is_edit_click = Number($("#is_edit_click").val());  
              if(is_edit_click==2){
                    swal({
                        title: warning + "!",
                        text: write_your_reason_remove,
                        type: "input",
                        html: true,
                        showCancelButton: true,
                        closeOnConfirm: true,
                        animation: "slide-from-top",
                        inputPlaceholder: "" },
                    function(inputValue){
                        if (inputValue === false) return false;
                        if (inputValue === "") {
                            swal.showInputError(write_your_reason_remove);
                            return false
                        }else{
                            if(sale_no && sale_no!=undefined){
        
                                //decrease item quantity
                                item_quantity--;
                    
                                //decrease item's total price based on unit price and quantity
                                let updated_total_price = (
                                parseFloat(item_quantity) * parseFloat(unit_price)
                                ).toFixed(ir_precision);
                    
                                //update total price of this item to view
                                this_action.parent()
                                .parent()
                                .find(".item_price_without_discount")
                                .html(updated_total_price);
                    
                                //update quantity of this item to view
                                this_action.parent().find("span").html(item_quantity);
                    
                                increase_free_item_qty(1,item_quantity,item_id);
                    
                                //do calculation on update values
                                do_addition_of_item_and_modifiers_price();
        
        
                                let food_menu_id = item_id;
                                let qty = 1;
                                $.ajax({
                                    url: base_url + "authentication/remove_item_checking",
                                    method: "POST",
                                    dataType:'json',
                                    data:{food_menu_id:food_menu_id,qty:qty,sale_no:sale_no,reason:inputValue},
                                    success: function (response) {
                                        
                                    },
                                    error: function () {
            
                                    },
                                });
                            } 
                        }
                    });
              }else{

                    item_quantity--;
        
                    //decrease item's total price based on unit price and quantity
                    let updated_total_price = (
                    parseFloat(item_quantity) * parseFloat(unit_price)
                    ).toFixed(ir_precision);
        
                    //update total price of this item to view
                    this_action.parent()
                    .parent()
                    .find(".item_price_without_discount")
                    .html(updated_total_price);
        
                    //update quantity of this item to view
                    this_action.parent().find("span").html(item_quantity);
        
                    increase_free_item_qty(1,item_quantity,item_id);
        
                    //do calculation on update values
                    do_addition_of_item_and_modifiers_price();
        
              }
              
              
            } else {
                
                   let is_edit_click = Number($("#is_edit_click").val());  
                if(is_edit_click==2){
                    let sale_no = $(this).parent().parent().parent().parent().find(".modification").attr("data-sale-no");
                    //add log for removing the item.
                    swal({
                        title: warning + "!",
                        text: write_your_reason_remove,
                        type: "input",
                        html: true,
                        showCancelButton: true,
                        closeOnConfirm: true,
                        animation: "slide-from-top",
                        inputPlaceholder: "" },
                    function(inputValue){
                        if (inputValue === false) return false;
                        if (inputValue === "") {
                            swal.showInputError(write_your_reason_remove);
                            return false
                        }else{
                            if(sale_no && sale_no!=undefined){
                                $("#order_for_item_" + item_id).remove();
                                // clearFooterCartCalculation();
                                 do_addition_of_item_and_modifiers_price();
        
                                let food_menu_id = item_id;
                                let qty = 1;
                                $.ajax({
                                    url: base_url + "authentication/remove_item_checking",
                                    method: "POST",
                                    dataType:'json',
                                    data:{food_menu_id:food_menu_id,qty:qty,sale_no:sale_no,reason:inputValue},
                                    success: function (response) {
                                           
                                    },
                                    error: function () {
            
                                    },
                                });
                            } 
                        }
                    });
                }else{
                    $("#order_for_item_" + item_id).remove();
                    // clearFooterCartCalculation();
                     do_addition_of_item_and_modifiers_price();
                }
              
            }
                
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }


         
          //decrease item's total price bsed on unit price and quantity
        }
      );
      //add discount for specific item
      $(document).on(
        "keyup",
        ".single_order .first_portion .forth_column input",
        function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
            $(this).val("");
          }
          do_addition_of_item_and_modifiers_price();
        }
      );
      //add discount for specific item in modal
      $(document).on("keyup", "#modal_discount", function (e) {
          let this_value = $(this).val();
  
          let pos_4 = Number($("#pos_4").val());
          if(pos_4){
              if (
                  $.trim(this_value) == "" ||
                  $.trim(this_value) == "%" ||
                  $.trim(this_value) == "%%" ||
                  $.trim(this_value) == "%%%" ||
                  $.trim(this_value) == "%%%%"
              ) {
              } else {
                  let Disc_fields = this_value.split("%");
                  let discP = Disc_fields[1];
                  if (discP == "") {
                  } else {
                      if (isNaN(this_value)) {
                          $(this).val("");
                      }
                  }
              }
          }else{
              $(this).val("");
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
        show_discount_reason();
        update_all_total_price();
      });
      $(document).on("click", "#submit_discount_custom", function (e) {
        checkDiscountType();
      });
      $(document).on("click", "#cancel_discount_modal", function (e) {
        $("#sub_total_discount").val("");
        $("#sub_total_discount1").val("");
        checkDiscountType();
        do_addition_of_item_and_modifiers_price();
      });
      $(document).on("click", "#cancel_charge_value", function (e) {
        do_addition_of_item_and_modifiers_price();
      });
  
      $(document).on("keyup", "#sub_total_discount1", function (e) {
          let this_value = $.trim($(this).val());
  
          let pos_4 = Number($("#pos_4").val());
          if(pos_4){
              //if the letter is not digit then display error and don't type anything
  
              if (isNaN(this_value)) {
                  $(this).val("");
                  this_value = "";
              }
  
              $("#sub_total_discount").val(this_value);
          }else{
              $(this).val("");
              this_value = "";
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
        checkDiscountType();
        do_addition_of_item_and_modifiers_price();
      });
      function checkDiscountType() {
        let place_edit_order = $("#place_edit_order").html();
        let this_value = $("#discount_type").val();
        let sub_total_discount_value = $("#sub_total_discount1").val();
        if (this_value == "percentage") {
          if (parseFloat(sub_total_discount_value)) {
            $("#sub_total_discount").val(parseFloat(sub_total_discount_value) + "%");
            do_addition_of_item_and_modifiers_price();
          }
        } else {
          if (parseFloat(sub_total_discount_value)) {
            $("#sub_total_discount").val(parseFloat(sub_total_discount_value));
            do_addition_of_item_and_modifiers_price();
          }
        }
      }
      $(document).on("change", "#discount_type", function () {
        checkDiscountType();
      });
  
        function checkPercentage(value) {
          if(value){
              if (value.indexOf("%") > -1) {
                  return true;
              } else {
                  return false;
              }
          }else{
            return false;
          }
  
        }
      function setDiscountForSelectedCustomer(){
          let place_edit_order = $("#place_edit_order").html();
          if(place_edit_order!="Update Order"){
              let default_discount = $(".select_walk_in_customer_custom").find(':selected').attr('data-default_discount');
              let default_discount_tmp = $(".select_walk_in_customer_custom").find(':selected').attr('data-default_discount');
              let same_or_diff_state = $(".select_walk_in_customer_custom").find(':selected').attr('data-same_or_diff_state');
  
              let this_value = $(".select_walk_in_customer_custom").val();
              let discount_amount  = default_discount;
              if(checkPercentage(default_discount)){
                  let default_discount_separate = default_discount.split("%");
                  discount_amount = default_discount_separate[0];
                  $("#discount_type").val("percentage").change();
              }else{
                  $("#discount_type").val("fixed").change();
              }
              $("#sub_total_discount").val(default_discount_tmp);
              $("#sub_total_discount1").val(discount_amount);
              $("#same_or_diff_state").val(same_or_diff_state);
              checkDiscountType();
              do_addition_of_item_and_modifiers_price();
          }
      }
        $(document).on("change", ".select_walk_in_customer_custom", function (e) {
            setDiscountForSelectedCustomer();
        });
  
      $(document).on("keyup", "#delivery_charge", function (e) {
          let pos_5 = Number($("#pos_5").val());
          if(pos_5){
              //if the letter is not digit then display error and don't type anything
              let this_value = $.trim($(this).val());
              if (isNaN(this_value) && !checkPercentage(this_value)) {
                  $(this).val("");
              }
          }else{
              $(this).val("");
              toastr['error']((menu_not_permit_access + "!"), '');
          }
        do_addition_of_item_and_modifiers_price();
      });
  
      $(document).on("keyup", "#tips_amount", function (e) {
          let pos_6 = Number($("#pos_6").val());
          if(pos_6){
              //if the letter is not digit then display error and don't type anything
              let this_value = $.trim($(this).val());
              if (isNaN(this_value) && !checkPercentage(this_value)) {
                  $(this).val("");
              }
          }else{
              $(this).val("");
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
        do_addition_of_item_and_modifiers_price();
      });
  
      $("#walk_in_customer").select2({
        dropdownCssClass: "bigdrop",
      });
      // sound effect
      let placeOrderSound = new Howl({
        src: [base_url + "assets/media/alert_alarm.mp3"],
      });
  
      $(document).on("click", ".place_order_operation", function (e) {
        let hidden_table_name = $("#hidden_table_name").val();

        
          //focus search field
          $("#is_first").val(1);
          let waiter_app_status = $("#waiter_app_status").val();
          let action_type = Number($(this).attr('data-type'));

          if(action_type==1){
            let pos_25 = Number($("#pos_25").val());
            if(waiter_app_status=="Yes"){
                pos_25 = 1;
            }
            let is_self_order = $("#is_self_order").val();
            if(pos_25 || is_self_order=="Yes"){

            }else{
                toastr['error']((menu_not_permit_access + "!"), '');
                return false;
            }
          }else{
            let is_self_order = $("#is_self_order").val();
            let pos_1 = Number($("#pos_1").val());
            if(pos_1 || is_self_order=="Yes"){

            }else{
                toastr['error']((menu_not_permit_access + "!"), '');
                return false;
            }
          }

          $("#is_direct_sale_check").val(action_type);
          let self_order_table_id = Number($("#self_order_table_id").val());
          let is_online_order = $("#is_online_order").val();
          let edit_sale_id = Number($("#edit_sale_id").val());
          let is_login_checker = false;
          let online_customer_id = Number($("#online_customer_id").val());
    
          if(is_online_order=="Yes" && !online_customer_id){
              is_login_checker = true;
          }
          if(is_login_checker==true){
              let login_first_msg =  $("#login_first_msg").val();
              toastr['error']((login_first_msg), '');
          }else{
              if(!self_order_table_id){
                  if(is_online_order!="Yes"){
                      $("#is_self_order").val("No");
                  }
              }
              focusSearch();

              let update_sale_id = ($("#update_sale_id").val());
             
              if(update_sale_id){
                  //remove previous order tables
                  removeOrderTablesBySaleId(update_sale_id,'');
              }
              // show token number field visible
              if(pre_or_post_payment==2){
                  $("#update_sale_id").val('');
                  // show token number field visible
                  $("#token_number").val('');
                  $("#token_number").show();
              }else{
                  $("#token_number").val('');
                  $("#token_number").hide();
              }
  
              let selected_order_type_object = $(".main_top").find('button[data-selected="selected"]');getDateTime();
              let total_items_in_cart = $(".order_holder .single_order").length;
              let total_items_in_cart_qty = $("#total_items_in_cart_with_quantity").text();
              let sub_total = parseFloat($("#sub_total_show").html()).toFixed(
                  ir_precision
              );
              let charge_type = $("#charge_type").val();
              let total_vat = parseFloat($("#show_vat_modal").html()).toFixed(
                  ir_precision
              );
              let total_payable = parseFloat($("#total_payable").html()).toFixed(
                  ir_precision
              );
              let total_item_discount_amount = parseFloat(
                  $("#total_item_discount").html()
              ).toFixed(ir_precision);
              let sub_total_with_discount = parseFloat(
                  $("#discounted_sub_total_amount").html()
              ).toFixed(ir_precision);
              let sub_total_discount_amount = parseFloat(
                  $("#sub_total_discount_amount").html()
              ).toFixed(ir_precision);
              let total_discount_amount = parseFloat(
                  $("#all_items_discount").html()
              ).toFixed(ir_precision);
  
              let delivery_charge = '';
              let delivery_charge_actual_charge = '';
              let show_charge_amount_ = Number($("#show_charge_amount").html());
              if(show_charge_amount_){
                  delivery_charge = $("#delivery_charge").val();
                  delivery_charge_actual_charge = $("#show_charge_amount").html();
              }
  
              let tips_amount = $("#tips_amount").val();
              let tips_amount_actual_charge = $("#show_tips_amount").html();
  
              let sub_total_discount_value = $("#sub_total_discount").val();
              let sub_total_discount_type = "";
              let customer_id = $("#walk_in_customer").val();
              let waiter_id = $("#select_waiter").val();
              let customer_data = $("#walk_in_customer").select2('data'); //Added By Jobayer
              let is_self_order = $("#is_self_order").val();
  
  
              let self_order_table_person = $("#self_order_table_person").val();
              let customer_address = $("#walk_in_customer").find(':selected').attr('data-customer_address');
  
              let customer_gst_number = $("#walk_in_customer").find(':selected').attr('data-customer_gst_number');
              let waiter_data = '';
              let customer_name = '';
              let waiter_name = '';
              if(waiter_app_status!="Yes"){
                  waiter_data = $("#select_waiter").select2('data'); //Added By Jobayer
                  if(waiter_data[0].text!=undefined){
                      waiter_name = waiter_data[0].text; //Added By Jobayer
                  }
              }else{
                  waiter_name = $("#select_waiter_name").val();;
              }
  
  
              if(is_self_order!="Yes"){
  
              }else{
                  if(self_order_table_person==''){
                      let please_add_your_table_person_number = $("#please_add_your_table_person_number").val();
                      $("#self_order_table_person").focus();
                      toastr['error']((please_add_your_table_person_number), '');
                      return false;
                  };
  
              }
              customer_name = customer_data[0].text; //Added By Jobayer
  
              let sale_vat_objects = [];
              $("#tax_row_show .tax_field").each(function (i, obj) {
                  let tax_field_id = $(this).attr("data-tax_field_id");
                  let tax_field_type = $(this).attr("data-tax_field_type");
                  let tax_field_amount = $(this).attr("data-tax_field_amount");
                  sale_vat_objects.push({
                      tax_field_id: tax_field_id,
                      tax_field_type: tax_field_type,
                      tax_field_amount: parseFloat(tax_field_amount).toFixed(ir_precision),
                  });
              });
              if (total_items_in_cart == 0) {
                  $(".cardIsEmpty").css("border", "2px solid red");
                  setTimeout(function () {
                      $(".cardIsEmpty").css("border", "none");
                  }, 2000);
                  placeOrderSound.play();
                  return false;
              }
              if (
                  sub_total_discount_value.length > 0 &&
                  sub_total_discount_value.substr(sub_total_discount_value.length - 1) ==
                  "%"
              ) {
                  sub_total_discount_type = "percentage";
              } else {
                  sub_total_discount_type = "fixed";
              }
  
              if (selected_order_type_object.length > 0) {
                  $(".type-btn-list").removeClass("custom_active");
  
                  let order_type = 1;
                  if (selected_order_type_object.attr("data-id") == "delivery_button") {
                      order_type = 3;
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                      if (customer_id == "1") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                      if (customer_address == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          let you_need_to_add_address_with_your_selected_customer = $("#you_need_to_add_address_with_your_selected_customer").val();
                          toastr['error']((you_need_to_add_address_with_your_selected_customer), '');
                          return false;
                      }
                  } else if (selected_order_type_object.attr("data-id") == "dine_in_button") {
                      order_type = 1;
                      if (waiter_id == "" && waiter_app_status!="Yes" && is_self_order!="Yes" && is_online_order!="Yes") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.close();
                          op2.open();
                          return false;
                      }
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                  } else if (
                      selected_order_type_object.attr("data-id") == "take_away_button"
                  ) {
                      order_type = 2;
  
                      if (waiter_id == ""  && is_self_order!="Yes"  && is_online_order!="Yes" && waiter_app_status!="Yes") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.close();
                          op2.open();
                          return false;
                      }
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                  }
                  let delivery_partner_id = '';
                  if(order_type == 3){
                      delivery_partner_id = $("input[name='delivery_partner_id']:checked").val();
                  }
  
                  let sale_no_new = 0;
                  let random_code = '';
                  if(update_sale_id){
                      let sale_no_new_hidden = $("#sale_no_new_hidden").val();
                      let random_code_hidden = $("#random_code_hidden").val();
                      sale_no_new = sale_no_new_hidden;
                      random_code = random_code_hidden;
                  }else{
                      sale_no_new = generateSaleNo();
                      random_code = getRandomCode(15);
  
                  }
                  let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
                  let edit_sale_date = $("#edit_sale_date").val();
                  let edit_date_time = $("#edit_date_time").val();
                  let date_time_tmp = getDateTime()[0];
                  let order_time_tmp = getDateTime()[1];
                  if(edit_sale_id){
                      sale_no_new = $("#edit_sale_no").val();
                      date_time_tmp = edit_date_time;
                      order_time_tmp = edit_date_time;
                      open_invoice_date_hidden = edit_sale_date;
                  }
  
                  let order_status = 1;
                  let rounding_amount_hidden = $("#rounding_amount_hidden").val();
                  let customer_current_due = $("#walk_in_customer").find(':selected').attr('data-current_due');
                  let token_number = $("#token_number").val();
                  let hidden_given_amount = $("#hidden_given_amount").val();
                  let hidden_change_amount = $("#hidden_change_amount").val();
                  let counter_id = $("#counter_id").val();
                  let counter_name = $("#counter_name").val();
                  let order_info = "{";
                  order_info += '"sale_no":"' + sale_no_new + '",';
                  order_info += '"is_merge":"",';
                  order_info += '"is_online_order":"",';
                  order_info += '"edit_sale_id":"' + edit_sale_id + '",';
                  order_info += '"waiter_app_status":"' + waiter_app_status + '",';
                  order_info += '"hidden_given_amount":"' + hidden_given_amount + '",';
                  order_info += '"hidden_change_amount":"' + hidden_change_amount + '",';
                  order_info += '"counter_id":"' + counter_id + '",';
                  order_info += '"counter_name":"' + counter_name + '",';
                  order_info += '"random_code":"' + random_code + '",';
                  order_info += '"token_number":"' + token_number + '",';
                  order_info += '"customer_id":"' + customer_id + '",';
                  order_info += '"customer_address":"' + customer_address+ '",';
                  order_info += '"customer_gst_number":"' + customer_gst_number+ '",';
                  order_info += '"status":"Pending",';
                  order_info += '"user_name":"' + ($("#user_name").val()) + '",';
                  order_info += '"user_id":"' + ($("#user_id").val()) + '",';
                  order_info += '"zatca_invoice_value":"' + ($("#zatca_invoice_value").val()) + '",';
                  order_info += '"customer_name":"' + customer_name + '",';
                  order_info += '"delivery_partner_id":"' + delivery_partner_id + '",';
                  order_info += '"self_order_table_id":"' + self_order_table_id + '",';
                  order_info += '"self_order_table_person":"' + self_order_table_person + '",';
                  order_info += '"rounding_amount_hidden":"' + rounding_amount_hidden + '",';
                  order_info += '"previous_due_tmp":"' + customer_current_due + '",';
                  order_info += '"waiter_id":"' + waiter_id + '",';
                  order_info += '"waiter_name":"' + waiter_name + '",';
                  order_info += '"open_invoice_date_hidden":"' + open_invoice_date_hidden + '",';
                  order_info += '"total_items_in_cart":"' + total_items_in_cart + '",';
                  order_info += '"total_items_in_cart_qty":"' + total_items_in_cart_qty + '",';
                  order_info += '"sub_total":"' + sub_total + '",';
                  order_info +='"sale_date":"' + open_invoice_date_hidden + '",';
                  order_info +='"date_time":"' + getDateTime()[0] + '",';
                  order_info +='"order_time":"' + getDateTime()[1] + '",';
                  order_info += '"charge_type":"' + charge_type + '",';
                  order_info += '"total_vat":"' + total_vat + '",';
                  order_info += '"total_payable":"' + total_payable + '",';
                  order_info +=
                      '"total_item_discount_amount":"' + total_item_discount_amount + '",';
                  order_info +=
                      '"sub_total_with_discount":"' + sub_total_with_discount + '",';
                  order_info +=
                      '"sub_total_discount_amount":"' + sub_total_discount_amount + '",';
                  order_info +=
                      '"total_discount_amount":"' + total_discount_amount + '",';
                  order_info += '"delivery_charge":"' + delivery_charge + '",';
                  order_info += '"tips_amount":"' + tips_amount + '",';
                  order_info += '"delivery_charge_actual_charge":"' + delivery_charge_actual_charge + '",';
                  let tips_amount_actual_charge = $("#show_tips_amount").html();
                  order_info += '"tips_amount_actual_charge":"' + tips_amount_actual_charge + '",';
                  order_info +=
                      '"sub_total_discount_value":"' + sub_total_discount_value + '",';
                  order_info +=
                      '"sub_total_discount_type":"' + sub_total_discount_type + '",';
                  // order_info += '"selected_table":"'+selected_table+'",';
                  order_info += '"order_type":"' + order_type + '",';
                  order_info += '"order_status":"' + order_status + '",';
                  order_info +='"sale_vat_objects":' + JSON.stringify(sale_vat_objects) + ",";
                  
                 
                  let table_id = $("#table_id").val();
                  let hidden_table_capacity = $("#hidden_table_capacity").val();
            
                  let total_person = 0;

                  let orders_table = "";
                  orders_table += '"orders_table":';
                  orders_table += "[";
                  total_person = hidden_table_capacity;
                  if(!table_id){
                      table_id = $("#table_id").val();
                      total_person = $("#update_hidden_table_capacity").html();
                  }
                  orders_table +=
                      '{"table_id":"' + table_id + '", "persons":"' + total_person + '"}';
                  orders_table += "],";
                  order_info += orders_table;
                  order_info += '"table_id":"' + table_id + '",';
                  order_info += '"orders_table_text":"' + hidden_table_name + '",';


  
                  $("#table_id").val('');
                  $("#update_table_obj").empty();
                  $("#hidden_table_name").val('');
                  $("#table_button").html("<i class='fal fa-table'></i> "+table_text);
                  $("#table_button").removeClass("red_text");
  
                  let items_info = "";
  
                  items_info += '"items":';
                  items_info += "[";
                  if ($(".order_holder .single_order").length > 0) {
                      let k = 1;
                      $(".order_holder .single_order").each(function (i, obj) {
                          let item_id = $(this).attr("id").substr(15);
                          let item_name = $(this)
                              .find("#item_name_table_" + item_id)
                              .html();
                          let item_vat = $(this).find(".item_vat").html();
                          let item_discount = $(this)
                              .find("#percentage_table_" + item_id)
                              .val();
                          let discount_type = "";
                          if (
                              item_discount.length > 0 &&
                              item_discount.substr(item_discount.length - 1) == "%"
                          ) {
                              discount_type = "percentage";
                          } else {
                              discount_type = "fixed";
                          }
                          let item_previous_id = $(this)
                              .find("#item_previous_id_table" + item_id)
                              .html();
                          let item_cooking_done_time = $(this)
                              .find("#item_cooking_done_time_table" + item_id)
                              .html();
                          let item_cooking_start_time = $(this)
                              .find("#item_cooking_start_time_table" + item_id)
                              .html();
                          let item_cooking_status = $(this)
                              .find("#item_cooking_status_table" + item_id)
                              .html();
                          let item_type = $(this)
                              .find("#item_type_table" + item_id)
                              .html();
                          let item_price_without_discount = $(this)
                              .find(".item_price_without_discount")
                              .html();
                          let item_unit_price = $(this)
                              .find("#item_price_table_" + item_id)
                              .html();
                          let item_quantity = $(this).find("#item_quantity_table_" + item_id).html();
                          let is_kot_print = $(this).find("#item_quantity_table_" + item_id).attr('data-is_kot_print');
                          let tmp_qty = $(this).find(".tmp_qty").val();
                          let rounding_amount_hidden = $(this).find("#rounding_amount_hidden").val();
                          let p_qty = $(this).find(".p_qty").val();
                          let item_price_with_discount = $(this)
                              .find("#item_total_price_table_" + item_id)
                              .html();
                          let item_discount_amount = (
                              parseFloat(item_price_without_discount) -
                              parseFloat(item_price_with_discount)
                          ).toFixed(ir_precision);
                          let kitchen_details_1 = search_by_menu_id(item_id, window.items);
                   
                          items_info +=
                              '{"food_menu_id":"' +
                              item_id +
                              '", "is_print":"' + 1 +
                              '", "is_kot_print":"' + is_kot_print +
                              '", "menu_name":"' + item_name +
                              '", "kitchen_id":"' + kitchen_details_1[0].kitchen_id +
                              '", "kitchen_name":"' + kitchen_details_1[0].kitchen_name +
                              '", "is_free":"0", "rounding_amount_hidden":"0", "item_vat":' +
                              item_vat +
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
                          let modifiers_tax_custom = "";
                          let ji = 1;
                          let modifier_vat = "";
                          $(".item_vat_modifier_" + item_id).each(function (i, obj) {
                              if (ji == $(".item_vat_modifier_" + item_id).length) {
                                  modifier_vat += $(this).html();
                              } else {
                                  modifier_vat += $(this).html() + "|||";
                              }
                              ji++;
                          });
                          if ($(this).find(".second_portion").length > 0) {
                              let modifiers_id = $(this)
                                  .find("#item_modifiers_id_table_" + item_id)
                                  .html();
                              let modifiers_name = $(this).find("#item_modifiers_table_" + item_id).html();//Added By Jobayer
                              let modifiers_price = $(this)
                                  .find("#item_modifiers_price_table_" + item_id)
                                  .html();
                              items_info +=
                                  ',"modifiers_id":"' +
                                  modifiers_id  +
                                  '", "modifiers_name":"' + modifiers_name+'", "modifiers_price":"' +
                                  modifiers_price +
                                  '", "modifier_vat":' +
                                  JSON.stringify(modifier_vat);
                          } else {
                              items_info +=
                                  ',"modifiers_id":"", "modifiers_name":"", "modifiers_price":"", "modifier_vat":""';
                          }
                          if ($(this).find(".third_portion").length > 0) {
                              let item_note = $(this)
                                  .find("#item_note_table_" + item_id)
                                  .text().replace(/[\r\n]/g, '');

                                  items_info += ',"item_note":"' + item_note + '"';
                          } else {
                              items_info += ',"item_note":""';
                          }

                          let discount_reason = $(this)
                          .find("#discount_reason_table_" + item_id)
                          .text().replace(/[\r\n]/g, '');
                    
                        items_info += ', "discount_reason":"' + discount_reason + '"';

                          let combo_txt = $("#item_combo_table_"+item_id).text();
                          if(combo_txt==undefined){
                              items_info += ',"menu_combo_items":""';
                          }else{
                              items_info += ',"menu_combo_items":"' + (combo_txt) + '"';
                          }
  
                          let free_item_div = $(".free_item_div_"+item_id).attr("data-is_free");
                          let get_fm_id = $(".free_item_div_"+item_id).attr("data-get_fm_id");
                          if(free_item_div=="Yes"){
                              items_info +="},";
                              let free_item_quantity_table = $("#free_item_quantity_table_"+item_id).html();
                              let free_item_name_table = $("#free_item_name_table_"+item_id).html();
  
                              let kitchen_details_2 = search_by_menu_id(item_id, window.items);
  
                              items_info +=
                                  '{"food_menu_id":"' +
                                  get_fm_id +
                                  '", "is_print":"' + 1 +
                                  '", "menu_name":"' + free_item_name_table +
                                  '", "kitchen_id":"' + kitchen_details_2[0].kitchen_id +
                                  '", "kitchen_name":"' + kitchen_details_2[0].kitchen_name +
                                  '", "parent_food_id":"' + item_id+
                                  '", "is_free":"1", "rounding_amount_hidden":"0", "item_vat":' +
                                  item_vat +
                                  ",";
                              items_info +=
                                  '"menu_discount_value":"0","discount_type":"' +
                                  discount_type +
                                  '","menu_price_without_discount":"0",';
                              items_info +=
                                  '"menu_unit_price":"0","qty":"' +
                                  free_item_quantity_table +
                                  '","tmp_qty":"' +
                                  free_item_quantity_table +
                                  '","p_qty":"' +
                                  free_item_quantity_table +
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
                                  '"menu_price_with_discount":"0","item_discount_amount":"0"';
                              items_info +=
                                  ',"modifiers_id":"", "modifiers_price":"", "modifier_vat":""';
                              items_info += ',"item_note":""';
                              items_info += ',"menu_combo_items":""';
                              items_info +=
                                  k == $(".order_holder .single_order").length ? "}" : "},";
                          }else{
                              items_info +=
                                  k == $(".order_holder .single_order").length ? "}" : "},";
                          }
                          k++;
                      });
                  }
                  items_info += "]";
                  order_info += items_info + "}";
                  let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                  let company_id_indexdb = $("#company_id_indexdb").val();
  
                  if(edit_sale_id){
                      push_online_update(order_info);
                  }else{
                      if(is_self_order=="Yes" || is_online_order=="Yes"){
                          push_online_for_kitchen(order_info,'Yes',sale_no_new,1);
                          clearFooterCartCalculation();
                      }else{
                          add_sale_by_ajax(update_sale_id,order_info,outlet_id_indexdb,company_id_indexdb,sale_no_new,"",action_type,"");
                          add_sale_by_ajax_kot_print(update_sale_id,order_info,outlet_id_indexdb,company_id_indexdb,sale_no_new,"");
                          //add sale details for kitchen status
                          push_online_for_kitchen(order_info,'',sale_no_new,1);
                      }
                  }
  
                  $(".dine_in_button").css("border", "unset");
                  $(".take_away_button").css("border", "unset");
                  $(".delivery_button").css("border", "unset");
              } else {
                  $(".type-btn-list").addClass("custom_active");
                  $(".btn-list button").css("backgroundColor", "#b9b9b9");
                  setTimeout(function () {
                      $(".btn-list button").css("backgroundColor", "white");
                  }, 600);
  
                  $(".dine_in_button").css("border", "1px solid red");
                  $(".take_away_button").css("border", "1px solid red");
                  $(".delivery_button").css("border", "1px solid red");
              }
          }
      });
      $(document).on("click", "#direct_invoice", function (e) {
          let pos_25 = Number($("#pos_25").val());
          if(pos_25){
              //focus search field
              focusSearch();
              let update_sale_id = ($("#update_sale_id").val());
              if(update_sale_id){
                  //remove previous order tables
                  removeOrderTablesBySaleId(sale_no,'');
              }
  
              $("#update_sale_id").val('');
              // show token number field visible
              $("#token_number").val('');
              $("#token_number").show();
  
              let selected_order_type_object = $(".main_top").find('button[data-selected="selected"]');
              let total_items_in_cart = $(".order_holder .single_order").length;
              let sub_total = parseFloat($("#sub_total_show").html()).toFixed(
                  ir_precision
              );
              let charge_type = $("#charge_type").val();
              let total_vat = parseFloat($("#show_vat_modal").html()).toFixed(
                  ir_precision
              );
              let total_payable = parseFloat($("#total_payable").html()).toFixed(
                  ir_precision
              );
              let total_item_discount_amount = parseFloat(
                  $("#total_item_discount").html()
              ).toFixed(ir_precision);
              let sub_total_with_discount = parseFloat(
                  $("#discounted_sub_total_amount").html()
              ).toFixed(ir_precision);
              let sub_total_discount_amount = parseFloat(
                  $("#sub_total_discount_amount").html()
              ).toFixed(ir_precision);
              let total_discount_amount = parseFloat(
                  $("#all_items_discount").html()
              ).toFixed(ir_precision);
              let delivery_charge = $("#delivery_charge").val();
              let tips_amount = $("#tips_amount").val();
       
              let sub_total_discount_value = $("#sub_total_discount").val();
              let sub_total_discount_type = "";
              let customer_id = $("#walk_in_customer").val();
              let waiter_id = $("#select_waiter").val();
              let customer_data = $("#walk_in_customer").select2('data'); //Added By Jobayer
              let waiter_data = $("#select_waiter").select2('data'); //Added By Jobayer
  
              let customer_name = customer_data[0].text; //Added By Jobayer
              let waiter_name = ''; //Added By Jobayer
              if(waiter_data[0].text!=undefined){
                  waiter_name = waiter_data[0].text; //Added By Jobayer
              }
              let customer_address = $("#walk_in_customer").find(':selected').attr('data-customer_address');
              let customer_gst_number = $("#walk_in_customer").find(':selected').attr('data-customer_gst_number');
  
              let sale_vat_objects = [];
              $("#tax_row_show .tax_field").each(function (i, obj) {
                  let tax_field_id = $(this).attr("data-tax_field_id");
                  let tax_field_type = $(this).attr("data-tax_field_type");
                  let tax_field_amount = $(this).attr("data-tax_field_amount");
                  sale_vat_objects.push({
                      tax_field_id: tax_field_id,
                      tax_field_type: tax_field_type,
                      tax_field_amount: parseFloat(tax_field_amount).toFixed(ir_precision),
                  });
              });
              if (total_items_in_cart == 0) {
                  $(".cardIsEmpty").css("border", "2px solid red");
                  setTimeout(function () {
                      $(".cardIsEmpty").css("border", "none");
                  }, 2000);
                  placeOrderSound.play();
                  return false;
              }
              if (
                  sub_total_discount_value.length > 0 &&
                  sub_total_discount_value.substr(sub_total_discount_value.length - 1) ==
                  "%"
              ) {
                  sub_total_discount_type = "percentage";
              } else {
                  sub_total_discount_type = "fixed";
              }
  
              if (selected_order_type_object.length > 0) {
                  $(".type-btn-list").removeClass("custom_active");
  
                  let order_type = 1;
                  if (selected_order_type_object.attr("data-id") == "delivery_button") {
                      order_type = 3;
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                      if (customer_id == "1") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
  
                      if (customer_address == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          let you_need_to_add_address_with_your_selected_customer = $("#you_need_to_add_address_with_your_selected_customer").val();
                          toastr['error']((you_need_to_add_address_with_your_selected_customer), '');
                          return false;
                      }
                  } else if (selected_order_type_object.attr("data-id") == "dine_in_button") {
                      order_type = 1;
                      if (waiter_id == "" && waiter_app_status!="Yes" && is_self_order!="Yes" && is_online_order!="Yes") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.close();
                          op2.open();
                          return false;
                      }
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                  } else if (
                      selected_order_type_object.attr("data-id") == "take_away_button"
                  ) {
                      order_type = 2;
  
                      if (waiter_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.close();
                          op2.open();
                          return false;
                      }
                      if (customer_id == "") {
                          let op1 = $("#walk_in_customer").data("select2");
                          let op2 = $("#select_waiter").data("select2");
                          op1.open();
                          op2.close();
                          return false;
                      }
                  }
                  let delivery_partner_id = '';
                  if(order_type == 3){
                      delivery_partner_id = $("input[name='delivery_partner_id']:checked").val();
                  }
  
                  let sale_no_new = 0;
                  let random_code = '';
                  if(sale_id){
                      let sale_no_new_hidden = $("#sale_no_new_hidden").val();
                      let random_code_hidden = $("#random_code_hidden").val();
                      sale_no_new = sale_no_new_hidden;
                      random_code = random_code_hidden;
                  }else{
                      sale_no_new = generateSaleNo();
                      random_code = getRandomCode(15);
                  }
  
  
                  let order_status = 1;
                  let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
                  let rounding_amount_hidden = $("#rounding_amount_hidden").val();
                  let customer_current_due = $("#walk_in_customer").find(':selected').attr('data-current_due');
                  let token_number = $("#token_number").val();
                  let hidden_given_amount = $("#hidden_given_amount").val();
                  let hidden_change_amount = $("#hidden_change_amount").val();
                  let counter_id = $("#counter_id").val();
                  let counter_name = $("#counter_name").val();
  
                  let order_info = "{";
                  order_info += '"sale_no":"' + sale_no_new + '",';
                  order_info += '"is_merge":"",';
                  order_info += '"hidden_given_amount":"' + hidden_given_amount + '",';
                  order_info += '"hidden_change_amount":"' + hidden_change_amount + '",';
                  order_info += '"counter_id":"' + counter_id + '",';
                  order_info += '"counter_name":"' + counter_name + '",';
                  order_info += '"random_code":"' + random_code + '",';
                  order_info += '"token_number":"' + token_number + '",';
                  order_info += '"customer_id":"' + customer_id + '",';
                  order_info += '"customer_address":"' + customer_address + '",';
                  order_info += '"customer_gst_number":"' + customer_gst_number + '",';
                  order_info += '"status":"Pending",';
                  order_info += '"user_name":"' + ($("#user_name").val()) + '",';
                  order_info += '"user_id":"' + ($("#user_id").val()) + '",';
                  order_info += '"customer_name":"' + customer_name + '",';
                  order_info += '"delivery_partner_id":"' + delivery_partner_id + '",';
                  order_info += '"rounding_amount_hidden":"' + rounding_amount_hidden + '",';
                  order_info += '"previous_due_tmp":"' + customer_current_due + '",';
                  order_info += '"waiter_id":"' + waiter_id + '",';
                  order_info += '"waiter_name":"' + waiter_name + '",';
                  order_info += '"open_invoice_date_hidden":"' + open_invoice_date_hidden + '",';
                  order_info += '"total_items_in_cart":"' + total_items_in_cart + '",';
                  order_info += '"sub_total":"' + sub_total + '",';
                  order_info +='"sale_date":"' + open_invoice_date_hidden + '",';
                  order_info +='"date_time":"' + getDateTime()[0] + '",';
                  order_info +='"order_time":"' + getDateTime()[1] + '",';
                  order_info += '"charge_type":"' + charge_type + '",';
                  order_info += '"total_vat":"' + total_vat + '",';
                  order_info += '"total_payable":"' + total_payable + '",';
                  order_info +=
                      '"total_item_discount_amount":"' + total_item_discount_amount + '",';
                  order_info +=
                      '"sub_total_with_discount":"' + sub_total_with_discount + '",';
                  order_info +=
                      '"sub_total_discount_amount":"' + sub_total_discount_amount + '",';
                  order_info +=
                      '"total_discount_amount":"' + total_discount_amount + '",';
                  order_info += '"delivery_charge":"' + delivery_charge + '",';
                  order_info += '"tips_amount":"' + tips_amount + '",';
                  let delivery_charge_actual_charge = $("#show_charge_amount").html();
                  order_info += '"delivery_charge_actual_charge":"' + delivery_charge_actual_charge + '",';
                  let tips_amount_actual_charge = $("#show_tips_amount").html();
                  order_info += '"tips_amount_actual_charge":"' + tips_amount_actual_charge + '",';
                  order_info +=
                      '"sub_total_discount_value":"' + sub_total_discount_value + '",';
                  order_info +=
                      '"sub_total_discount_type":"' + sub_total_discount_type + '",';
                  // order_info += '"selected_table":"'+selected_table+'",';
                  order_info += '"order_type":"' + order_type + '",';
                  order_info += '"order_status":"' + order_status + '",';
                  order_info +='"sale_vat_objects":' + JSON.stringify(sale_vat_objects) + ",";
  
                  let table_id = $(".new_book_to_table").length;
  
                  if(!sale_id){
                      let orders_table = "";
                      orders_table += '"orders_table":';
                      orders_table += "[";
                      let x = 1;
  
                      let orders_table_text = '';
                      $(".new_book_to_table").each(function (i, obj) {
                          let table_id = $(this).attr("id").substr(16);
                          let person = $(this).find(".third_column").html();
                          let name = $(this).attr("data-name");
                          if (x == table_id) {
                              orders_table_text+=name;
                              orders_table +=
                                  '{"table_id":"' + table_id + '", "persons":"' + person + '"}';
                          } else {
                              orders_table_text+=name;
                              orders_table_text+=", ";
                              orders_table +=
                                  '{"table_id":"' + table_id + '", "persons":"' + person + '"},';
                          }
                          x++;
                      });
  
  
                      if(!Number(table_id)){
                        table_id = 1;
                      }
                      orders_table += "],";
                      order_info += orders_table;
                      order_info += '"table_id":"' + table_id + '",';
                      order_info += '"orders_table_text":"' + orders_table_text + '",';
                  }else{
                      if(table_id){
                          let orders_table = "";
                          orders_table += '"orders_table":';
                          orders_table += "[";
                          let x = 1;
  
                          let orders_table_text = '';
                          $(".new_book_to_table").each(function (i, obj) {
                              let person = $(this).find(".third_column").html();
                              let name = $(this).attr("data-name");
                              if (x == table_id) {
                                  orders_table_text+=name;
                                  orders_table +=
                                      '{"table_id":"' + table_id + '", "persons":"' + person + '"}';
                              } else {
                                  orders_table_text+=name;
                                  orders_table_text+=", ";
                                  orders_table +=
                                      '{"table_id":"' + table_id + '", "persons":"' + person + '"},';
                              }
                              x++;
                          });
  
  
                          if(!Number(table_id)){
                            table_id = 1;
                          }
                          orders_table += "],";
                          order_info += orders_table;
                          order_info += '"table_id":"' + table_id + '",';
                          order_info += '"orders_table_text":"' + orders_table_text + '",';
                      }else{
                          let table_id = $("#table_id").val();
                          let update_table_obj = $("#update_table_obj").html();
                          let update_table_text = $("#hidden_table_name").val();
  
                          order_info += '"orders_table":';
                          order_info += update_table_obj;
                          order_info += ",";
                          order_info += '"table_id":"' + table_id + '",';
                          order_info += '"orders_table_text":"' + update_table_text + '",';
                      }
                  }
  
                  $("#table_id").val('');
                  $("#update_table_obj").empty();
                  $("#update_table_text").val('');
                  $("#table_button").html("<i class='fal fa-table'></i> "+table_text);
                  $("#table_button").removeAttr("red_text");
  
                  let items_info = "";
                  items_info += '"items":';
                  items_info += "[";
                  if ($(".order_holder .single_order").length > 0) {
                      let k = 1;
                      $(".order_holder .single_order").each(function (i, obj) {
                          let item_id = $(this).attr("id").substr(15);
                          let item_name = $(this)
                              .find("#item_name_table_" + item_id)
                              .html();
                          let item_vat = $(this).find(".item_vat").html();
                          let item_discount = $(this)
                              .find("#percentage_table_" + item_id)
                              .val();
                          let discount_type = "";
                          if (
                              item_discount.length > 0 &&
                              item_discount.substr(item_discount.length - 1) == "%"
                          ) {
                              discount_type = "percentage";
                          } else {
                              discount_type = "fixed";
                          }
                          let item_previous_id = $(this)
                              .find("#item_previous_id_table" + item_id)
                              .html();
                          let item_cooking_done_time = $(this)
                              .find("#item_cooking_done_time_table" + item_id)
                              .html();
                          let item_cooking_start_time = $(this)
                              .find("#item_cooking_start_time_table" + item_id)
                              .html();
                          let item_cooking_status = $(this)
                              .find("#item_cooking_status_table" + item_id)
                              .html();
                          let item_type = $(this)
                              .find("#item_type_table" + item_id)
                              .html();
                          let item_price_without_discount = $(this)
                              .find(".item_price_without_discount")
                              .html();
                          let item_unit_price = $(this)
                              .find("#item_price_table_" + item_id)
                              .html();
                          let item_quantity = $(this)
                              .find("#item_quantity_table_" + item_id)
                              .html();
                          let tmp_qty = $(this).find(".tmp_qty").val();
                          let rounding_amount_hidden = $(this).find("#rounding_amount_hidden").val();
                          let p_qty = $(this).find(".p_qty").val();
                          let item_price_with_discount = $(this)
                              .find("#item_total_price_table_" + item_id)
                              .html();
                          let item_discount_amount = (
                              parseFloat(item_price_without_discount) -
                              parseFloat(item_price_with_discount)
                          ).toFixed(ir_precision);
  
                          items_info +=
                              '{"food_menu_id":"' +
                              item_id +
                              '", "menu_name":"' + item_name +
                              '", "is_print":"' + 1 +
                              '", "is_free":"0", "rounding_amount_hidden":"0", "item_vat":' +
                              item_vat +
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
                          let modifiers_tax_custom = "";
                          let ji = 1;
                          let modifier_vat = "";
                          $(".item_vat_modifier_" + item_id).each(function (i, obj) {
                              if (ji == $(".item_vat_modifier_" + item_id).length) {
                                  modifier_vat += $(this).html();
                              } else {
                                  modifier_vat += $(this).html() + "|||";
                              }
                              ji++;
                          });
                          if ($(this).find(".second_portion").length > 0) {
                              let modifiers_id = $(this)
                                  .find("#item_modifiers_id_table_" + item_id)
                                  .html();
                              let modifiers_name = $(this).find("#item_modifiers_table_" + item_id).html();//Added By Jobayer
                              let modifiers_price = $(this)
                                  .find("#item_modifiers_price_table_" + item_id)
                                  .html();
                              items_info +=
                                  ',"modifiers_id":"' +
                                  modifiers_id  +
                                  '", "modifiers_name":"' + modifiers_name+'", "modifiers_price":"' +
                                  modifiers_price +
                                  '", "modifier_vat":' +
                                  JSON.stringify(modifier_vat);
                          } else {
                              items_info +=
                                  ',"modifiers_id":"", "modifiers_name":"", "modifiers_price":"", "modifier_vat":""';
                          }
                          if ($(this).find(".third_portion").length > 0) {
                              let item_note = $(this)
                                  .find("#item_note_table_" + item_id)
                                  .html();
                              items_info += ',"item_note":"' + item_note + '"';
                          } else {
                              items_info += ',"item_note":""';
                          }
                          let combo_txt = $("#item_combo_table_"+item_id).text();
                          if(combo_txt==undefined){
                              items_info += ',"menu_combo_items":""';
                          }else{
                              items_info += ',"menu_combo_items":"' + (combo_txt) + '"';
                          }
  
                          let free_item_div = $(".free_item_div_"+item_id).attr("data-is_free");
                          let get_fm_id = $(".free_item_div_"+item_id).attr("data-get_fm_id");
                          if(free_item_div=="Yes"){
                              items_info +="},";
                              let free_item_quantity_table = $("#free_item_quantity_table_"+item_id).html();
                              let free_item_name_table = $("#free_item_name_table_"+item_id).html();
                              items_info +=
                                  '{"food_menu_id":"' +
                                  get_fm_id +
                                  '", "is_print":"' + 1 +
                                  '", "menu_name":"' +
                                  free_item_name_table+  '", "parent_food_id":"' +
                                  item_id+
                                  '", "is_free":"1", "rounding_amount_hidden":"0", "item_vat":' +
                                  item_vat +
                                  ",";
                              items_info +=
                                  '"menu_discount_value":"0","discount_type":"' +
                                  discount_type +
                                  '","menu_price_without_discount":"0",';
                              items_info +=
                                  '"menu_unit_price":"0","qty":"' +
                                  free_item_quantity_table +
                                  '","tmp_qty":"' +
                                  free_item_quantity_table +
                                  '","p_qty":"' +
                                  free_item_quantity_table +
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
                                  '"menu_price_with_discount":"0","item_discount_amount":"0"';
                              items_info +=
                                  ',"modifiers_id":"", "modifiers_price":"", "modifier_vat":""';
                              items_info += ',"item_note":""';
                              items_info += ',"menu_combo_items":""';
                              items_info +=
                                  k == $(".order_holder .single_order").length ? "}" : "},";
                          }else{
                              items_info +=
                                  k == $(".order_holder .single_order").length ? "}" : "},";
                          }
                          k++;
                      });
                  }
                  items_info += "]";
                  order_info += items_info + "}";
  
                  let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                  let company_id_indexdb = $("#company_id_indexdb").val();
                  add_sale_by_ajax(update_sale_id,order_info,outlet_id_indexdb,company_id_indexdb,sale_no_new,"Yes","","");
  
                  $(".dine_in_button").css("border", "unset");
                  $(".take_away_button").css("border", "unset");
                  $(".delivery_button").css("border", "unset");
              } else {
                  $(".type-btn-list").addClass("custom_active");
                  $(".btn-list button").css("backgroundColor", "#b9b9b9");
                  setTimeout(function () {
                      $(".btn-list button").css("backgroundColor", "white");
                  }, 600);
  
                  $(".dine_in_button").css("border", "1px solid red");
                  $(".take_away_button").css("border", "1px solid red");
                  $(".delivery_button").css("border", "1px solid red");
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
  
      $(document).on(
        "click",
        "#print_invoice,#order_details_create_invoice_button",
        function (e) {
          if (
            $(".holder .order_details > .single_order[data-selected=selected]")
              .length > 0
          ) {
            let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");

            $.ajax({
              url: base_url + "Sale/get_all_information_of_a_sale_ajax",
              method: "POST",
              data: {
                sale_no: sale_no,
                csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                response = JSON.parse(response);
                $("#finalize_total_payable").html(response.total_payable);
                $("#finalize_total_payable").attr('data-original_payable',response.total_payable);
                $("#pay_amount_invoice_input").val(response.total_payable);
                $("#finalize_order_modal").addClass("active");
                $(".pos__modal__overlay").fadeIn(200);
                $("#open_invoice_date_hidden").val(response.sale_date);
  
                $(".datepicker_custom")
                  .datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    startDate: "0",
                    todayHighlight: true,
                  })
                  .datepicker("update", response.sale_date);
  
                $("#finalize_update_type").html("1"); //when 1 just update payment method and order status to 2 invoice order
                calculate_create_invoice_modal();
              },
              error: function () {
                alert(a_error);
              },
            });
          } else {
              toastr['error']((please_select_open_order), '');
          }
        }
      );
      $(document).on("click", "#finalize_order_button", function (e) {
        let due_amount_invoice_input = Number($("#finalize_total_due").html());
        let customer_id = $("#selected_invoice_sale_customer").val();
        let status = true;
        if (customer_id == 1) {
          if (due_amount_invoice_input) {
            status = false;
          }
        }
        if (status == true) {
  
            $(".change_amount_div").hide();
            $("#change_amount_div_").text(0);
  
  
          $("#print_type").val(1);
          let sale_no = ($("#last_future_sale_id").val());
          if (sale_no) {
            let payment_method_type = $("#finalie_order_payment_method").val();
            let paid_amount = $("#pay_amount_invoice_input").val();
            let due_amount = $("#due_amount_invoice_input").val();
            let sub_total_discount_finalize = $("#sub_total_discount_finalize").val();
            let invoice_create_type = $("#finalize_update_type").html();
  
              let is_split_bill = Number($("#is_split_bill").val());
  
              $(this)
                  .parent()
                  .parent()
                  .parent()
                  .removeClass("active")
                  .addClass("inActive");
              setTimeout(function () {
                  $(".modal").removeClass("inActive");
              }, 1000);
              $(".pos__modal__overlay").fadeOut(300);
  
              localStorage["last_sale_id"] = sale_no;
            if(is_split_bill!=1){
                $("#last_invoice_id").val(sale_no);
                if(pre_or_post_payment==2){
                    getSelectedOrderDetails(sale_no).then(function(data){
                        push_online_for_kitchen(data,'',sale_no,1);
                    });
                }
                print_invoice_and_close(sale_no,payment_method_type,invoice_create_type,paid_amount,due_amount,sub_total_discount_finalize);
                removeOrderTablesBySaleId(sale_no,'');
                let current_sale_no = $("#current_sale_no").val();
                remove_kot_invoice(current_sale_no);
                reset_finalize_modal();
            }else{
                let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
                let selected_action = '';
                $(".goto_to_payment").each(function (i, obj) {
                    let is_remove = $(this).attr('data-is_remove');
                    if(is_remove==="yes"){
                        selected_action = $(this);
                    }
                });
  
              let cart_modal_total_item_text = 0;
                selected_action.parent().parent().find(".qty_right_box").each(function (i, obj) {
                    let qty_tmp = Number($(this).html());
                    cart_modal_total_item_text+=qty_tmp;
                });
  
                let split_customer_id = selected_action.parent().parent().find('.split_customer_id').val();
                let sub_total = selected_action.parent().find('.subtotal_right_box').html();
                let total_vat = selected_action.parent().find('.tax_right_box').html();
                let total_payable = selected_action.parent().find('.total_payable_right_box').html();
                let discount_subtotal = Number(selected_action.parent().find('.discount_right_box').attr('data-added_amount'));
                let discount_item = Number(selected_action.parent().find('.discount_right_box').html()) - discount_subtotal;
                let delivery_charge = Number(selected_action.parent().find('.charge_right_box').html());
                let tips_amount = Number(selected_action.parent().find('.tips_right_box').html());
                let total_discount_amount = discount_subtotal + discount_item;
                let sub_total_with_discount = sub_total + discount_subtotal;
                let is_last_split_tmp = $(".split_tbl_width").length;
  
  
                let payment_info = "[";
  
                if ($(".payment_list_counter").length > 0) {
                    let k = 1;
                    $(".payment_list_counter").each(function (i, obj) {
                        let payment_name = $(this).attr("data-payment_name");
                        let usage_point = $(this).attr("data-usage_point");
                        let payment_id = $(this).attr("data-payment_id");
                        let amount = $(this).attr("data-amount");
                        payment_info +=
                            '{"payment_id":"' +
                            payment_id +
                            '","payment_name":"' + payment_name +
                            '","usage_point":"' + usage_point +
                            '","amount":"' +
                            amount +
                            '"';
                        payment_info +=
                            k == $(".payment_list_counter").length ? "}" : "},";
                        k++;
                    });
                }
                payment_info += "]";
  
                let payment_object = JSON.stringify(payment_info);
                paid_amount = $("#finalize_total_paid").html();
                due_amount = $("#finalize_total_due").html();
                let is_multi_currency = $("#is_multi_currency").val();
                let multi_currency_rate = $("#multi_currency_rate").val();
                let multi_currency = $("#multi_currency").val();
                let multi_currency_amount = $("#multi_currency_amount").val();
  
  
                let sale_vat_objects = [];
                $("#tax_row_show .tax_field").each(function (i, obj) {
                    let tax_field_id = $(this).attr("data-tax_field_id");
                    let tax_field_type = $(this).attr("data-tax_field_type");
                    let tax_field_amount = $(this).attr("data-tax_field_amount");
                    sale_vat_objects.push({
                        tax_field_id: tax_field_id,
                        tax_field_type: tax_field_type,
                        tax_field_amount: parseFloat(tax_field_amount).toFixed(ir_precision),
                    });
                });
  
  
                let selected_order_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
  
                let total_split_value = $(".total_split_sale span").length;
                if(!total_split_value){
                    total_split_value = "1";
                }
  
    
                let waiter_id = $("#select_waiter").val();
  
                let customer_data = selected_action.parent().parent().find('.split_customer_id').select2('data'); //Added By Jobayer
  
                let waiter_data = $("#select_waiter").select2('data'); //Added By Jobayer
                let customer_name = customer_data[0].text; //Added By Jobayer
                let waiter_name = ''; //Added By Jobayer
                if(waiter_data[0].text!=undefined){
                    waiter_name = waiter_data[0].text; //Added By Jobayer
                }
                let token_number = $("#token_number").val();
                let hidden_given_amount = $("#hidden_given_amount").val();
                let hidden_change_amount = $("#hidden_change_amount").val();
                let sale_no_new = selected_order_no+(getPad(total_split_value));
  
                let random_code = '';
                random_code = getRandomCode(15);
                let counter_id = $("#counter_id").val();
                let counter_name = $("#counter_name").val();
                
                let order_info = "{";
                order_info += '"sale_no":"' + sale_no_new + '",';
                order_info += '"is_merge":"",';
                order_info += '"hidden_given_amount":"' + hidden_given_amount + '",';
                order_info += '"hidden_change_amount":"' + hidden_change_amount + '",';
                order_info += '"counter_id":"' + counter_id + '",';
                order_info += '"counter_name":"' + counter_name + '",';
                order_info += '"random_code":"' + random_code + '",';
                order_info += '"token_number":"' + token_number + '",';
                order_info += '"customer_id":"' + split_customer_id + '",';
                order_info += '"split_sale_id":"' + sale_no + '",';
                order_info += '"user_id":"' + ($("#user_id").val()) + '",';
                order_info += '"user_name":"' + ($("#user_name").val()) + '",';
                order_info += '"date_time":"' + ($("#split_order_date_time").val()) + '",';
                order_info += '"charge_type":"' + ($("#split_charge_type").val()) + '",';
                order_info += '"order_time":"' + ($("#split_order_time").val()) + '",';
                order_info += '"order_type":"1",';
                order_info += '"customer_name":"' + customer_name + '",';
                order_info += '"waiter_id":"' + waiter_id + '",';
                order_info += '"waiter_name":"' + waiter_name + '",';
                order_info += '"delivery_partner_id":"0",';
                order_info += '"rounding_amount_hidden":"0",';
                order_info += '"previous_due_tmp":"0",';
                order_info += '"open_invoice_date_hidden":"' + open_invoice_date_hidden + '",';
                order_info += '"order_status":"3",';
                order_info += '"payment_method_type":"' + payment_method_type + '",';
                order_info += '"paid_amount":"' + paid_amount + '",';
                order_info += '"due_amount":"' + due_amount + '",';
                order_info += '"is_multi_currency":"' + is_multi_currency + '",';
                order_info += '"multi_currency_rate":"' + multi_currency_rate + '",';
                order_info += '"multi_currency":"' + multi_currency + '",';
                order_info += '"multi_currency_amount":"' + multi_currency_amount + '",';
                order_info += '"payment_object":' + payment_object + ',';
                order_info += '"total_items_in_cart":"' + cart_modal_total_item_text + '",';
                order_info += '"sub_total":"' + sub_total + '",';
                order_info += '"paid_date_time":"' + getDateTime()[0] + '",'; 
                order_info += '"is_last_split":"' + is_last_split_tmp + '",';
                order_info += '"total_vat":"' + total_vat + '",';
                order_info += '"total_payable":"' + total_payable + '",';
                order_info += '"sub_total_discount_finalize":"' + sub_total_discount_finalize + '",';
                order_info +=
                    '"total_item_discount_amount":"' + discount_item + '",';
                order_info +=
                    '"sub_total_with_discount":"' + sub_total_with_discount + '",';
                order_info +=
                    '"sub_total_discount_amount":"' + discount_subtotal + '",';
                order_info +=
                    '"total_discount_amount":"' + total_discount_amount + '",';
                order_info += '"delivery_charge":"' + delivery_charge + '",';
                order_info += '"tips_amount":"' + tips_amount + '",';
                order_info += '"delivery_charge_actual_charge":"' + delivery_charge + '",';
                order_info += '"tips_amount_actual_charge":"' + tips_amount + '",';
                order_info +=
                    '"sub_total_discount_value":"' + discount_subtotal + '",';
                order_info +=
                    '"sub_total_discount_type":"fixed",';
                order_info += '"order_status":"3",';
                order_info +='"sale_vat_objects":' + JSON.stringify(sale_vat_objects) + ",";
  
  
                let orders_table = "";
                orders_table += '"orders_table":';
                orders_table += "[";
                let x = 1;
                let current_object_table  = $(".current_object_tables").html();
                let current_text_table  = $(".current_text_tables").html();
  
                let table_id = current_object_table.length; 
                let orders_table_text = '';
                if(current_text_table && current_text_table!=undefined){
                    let orders_table_text_tmp = (current_text_table).split(",");
                    for(let key_table in current_object_table){
                        let table_details = (current_object_table)[key_table];
                        if(x==1){
                            let table_id = table_details.table_id;
                            let person = table_details.persons;
                            let name = orders_table_text_tmp[key_table];
                            orders_table_text+=name;
                            orders_table +=
                                '{"table_id":"' + table_id + '", "persons":"' + person + '"}';
                        }
                        x++;
                    }
                }
  
                table_id = 1;
  
                orders_table += "],";
                order_info += orders_table;
                order_info += '"table_id":"' + (table_id) + '",';
                order_info += '"orders_table_text":"' + orders_table_text + '",';
  
                let items_info = "";
                items_info += '"items":';
                items_info += "[";
                if (selected_action.parent().parent().find(".row_box_item").length > 0) {
                    let k = 1;
                    selected_action.parent().parent().find(".row_box_item").each(function (i, obj) {
  
                        let item_id = $(this).attr("data-id");
                        let item_name = $(this).find(".name_right_box").attr('data-main_name');
                        let menu_combo_items = $(this).find(".name_right_box").attr('data-combo_text');
                        let item_vat = '0';
                        let item_discount = $(this).find(".dis_right_box").html();
                        let discount_type =  "fixed";
  
                        let item_previous_id = 0;
                        let item_cooking_done_time = 0
                        let item_cooking_start_time = 0;
                        let item_cooking_status = '';
                        let item_type = '';
                        let item_price_without_discount = Number($(this).find(".price_right_box").html()) * Number($(this).find(".qty_right_box").html());
                        let item_unit_price = $(this).find(".price_right_box").html();;
                        let item_quantity = $(this).find(".qty_right_box").html();
                        let tmp_qty = $(this).find(".qty_right_box").html();
                        let p_qty = $(this).find(".qty_right_box").html();
                        let item_price_with_discount =  $(this).find(".total_right_box").html();
                        let item_discount_amount = item_discount;
                        let is_last_split = $(".split_tbl_width").length;
  
                        items_info +=
                            '{"food_menu_id":"' +
                            item_id +
                            '", "menu_name":"' + item_name +
                            '", "is_print":"' + 1 +
                            '", "is_last_split":"' + is_last_split +
                            '", "is_free":"0", "rounding_amount_hidden":"0", "item_vat":' +
                            item_vat +
                            ",";
                        items_info +=
                            '"item_discount":"' +
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
                            '","menu_combo_items":"' +
                            menu_combo_items +
                            '","item_type":"' +
                            item_type +
                            '",';
                        items_info +=
                            '"menu_price_with_discount":"' +
                            item_price_with_discount +
                            '","item_discount_amount":"' +
                            item_discount_amount +
                            '","menu_discount_value":"' +
                            item_discount_amount +
                            '"';
  
                        let ji = 1;
                        let modifier_vat = "";
  
                        let split_modifiers_id = '';
                        let split_modifiers_name = '';
                        let split_modifiers_price = '';
  
                        $(this).find(".split_modifier_name").each(function (i, obj) {
                            if (i == $(this).find(".split_modifier_name").length) {
                                split_modifiers_id += $(this).attr("data-modifier_id")+ ",";
                                split_modifiers_name += $(this).text()+ ",";
                                split_modifiers_price += $(this).parents().parents().find('.modifier_right_box').eq(i).text()+ ",";
                            } else {
                                split_modifiers_id += $(this).attr("data-modifier_id");
                                split_modifiers_name += $(this).text();
                                split_modifiers_price += $(this).parents().parents().find('.modifier_right_box').eq(i).text();
                            }
                        });
  
                        if ( $(this).find(".split_modifier_name").length > 0) {
                            items_info +=
                                ',"modifiers_id":"' +
                                split_modifiers_id  +
                                '", "modifiers_name":"' + split_modifiers_name+'", "modifiers_price":"' +
                                split_modifiers_price +
                                '", "modifier_vat":""';
                        } else {
                            items_info +=
                                ',"modifiers_id":"", "modifiers_name":"", "modifiers_price":"", "modifier_vat":""';
                        }
  
                        items_info +=
                            k == selected_action.parent().parent().find(".row_box_item").length ? "}" : "},";
                        k++;
                    });
                }
                items_info += "]";
                order_info += items_info + "}";
              
                add_to_recent_sale_by_ajax((order_info),'',sale_no_new);
                update_split_parent_sale((order_info), sale_no_new,'');
  
                setTimeout(function () {
                    let last_sale_id_split = localStorage["last_sale_id_split"];
                    print_invoice(last_sale_id_split);
                }, 1000);
  
                //update split box
                let is_show_split_modal = false;
                let remove_div_action = '';
                $(".goto_to_payment").each(function (i, obj) {
                    let is_remove = $(this).attr('data-is_remove');
                    if(is_remove==="yes"){
                        is_show_split_modal = true;
                        remove_div_action = $(this);
                    }
                });
                  //remove order tables
                remove_kot_invoice(sale_no_new);
                removeOrderTablesBySaleId(sale_no_new,'Yes');
  
                if(is_split_bill==1 && is_show_split_modal && ($(".goto_to_payment").length>1)){
                    //set total split bill box, and remove last generated_invoice
                    let current_split = Number($("#maximum_spit").html());
                    $("#spit_modal_input").attr('max',(current_split-1));
                    $("#spit_modal_input").val((current_split-1));
                    $("#maximum_spit").html((current_split-1));
                    remove_div_action.parent().parent().parent().remove();
                    $("#order_split_modal").addClass("active");
                    $(".pos__modal__overlay").fadeIn(200);
                }else{
                    let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
                    objectStore.openCursor().onsuccess = function(event) {
                        let cursor = event.target.result;
                        if (cursor) {
                            if(cursor.value.sale_no == selected_order_no) {
                                let request = db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                                request.onsuccess = function(event) {
                                    $("#order_" + get_plan_string(selected_order_no)).remove();
                                    setMergeDelete(selected_order_no);
                                }
                            }
                            cursor.continue();
                        }
                    }
                }
            }
  
          } else {
            toastr['error']((please_select_open_order), '');
          }
        } else {
          toastr['error'](("Due amount not allow for walk in customer!"), '');
        }
      });
      $("body").on("click", "#add_customer", function(e) {
        let is_online_order = $("#is_online_order").val();
        let customer_id = $("#customer_id_modal").val();
        let customer_name = $("#customer_name_modal").val();
        let customer_phone = $("#customer_phone_modal").val();
        let customer_email = $("#customer_email_modal").val();
        let customer_password = $("#customer_password_modal").val();
        let customer_dob = $("#customer_dob_modal").val();
        let customer_doa = $("#customer_doa_modal").val();
        let is_new_address = $("#is_new_address").val();
        let customer_delivery_address_modal_id = $("#customer_delivery_address_modal_id").val();
        let customer_delivery_address = $("#customer_delivery_address_modal").val();
        let customer_default_discount = $("#customer_default_discount_modal").val();
        let customer_gst_number = $("#customer_gst_number_modal").val();
        let same_or_diff_state = Number($(".same_or_diff_state_modal").val());
    
        let error = 0;
  
        $("#customer_name_modal").css("border", "1px solid #B5D6F6");
        $("#customer_phone_modal").css("border", "1px solid #B5D6F6");
        $("#customer_gst_number_modal").css("border", "1px solid #B5D6F6");
  
        if (customer_name == "") {
          $("#customer_name_modal").css("border", "1px solid red");
          error++;
        }
  
        if (customer_phone == "") {
          $("#customer_phone_modal").css("border", "1px solid red");
          error++;
        }
  
        if(tax_is_gst=="Yes"){
            if (!same_or_diff_state) {
                let op1 = $(".same_or_diff_state_modal").data("select2");
                op1.open();
              error++;
            }
        }
  
        if (customer_id == "" && customer_password=='' && is_online_order=="Yes") {
          $("#customer_password_modal").css("border", "1px solid red");
          error++;
        }
        if (error != 0) {
          return false;
        }
        let this_action = $(this);
        $.ajax({
          url: base_url + "Sale/add_customer_by_ajax",
          method: "POST",
          dataType:'json',
          data: {
            customer_id: customer_id,
            customer_name: customer_name,
            customer_phone: customer_phone,
            customer_email: customer_email,
            customer_dob: customer_dob,
            customer_doa: customer_doa,
            customer_password: customer_password,
            customer_delivery_address: customer_delivery_address,
            customer_default_discount: customer_default_discount,
            customer_gst_number: customer_gst_number,
            same_or_diff_state: same_or_diff_state,
            is_new_address: is_new_address,
            customer_delivery_address_modal_id: customer_delivery_address_modal_id,
            csrf_irestoraplus: csrf_value_,
          },
          success: function (response) {
            if (response.customer_id > 0) {
              $("#walk_in_customer").val(response.customer_id).change();
              $("#walk_in_customer1").val(response.customer_id).change();
              let new_customer_id = response.customer_id;
              if(response.online_customer_id){
                  $(".online_order_after_login").show();
                  $(".online_order_before_login").hide();
                  $("#default_customer_hidden").val(response.online_customer_id);
                  $("#online_customer_id").val(response.online_customer_id);
                  $("#online_customer_name").val(response.online_customer_name);
              }
              $.ajax({
                url: base_url + "Sale/get_all_customers_for_this_user",
                method: "GET",
                success: function (response) {
                  response = JSON.parse(response);
                  let option_customers = "";
                  let i = 1;
                  let selected_id = "";
                  let selected_name = "";
                  for (let key in response) {
                    if (i == response.length) {
                      option_customers +=
                        '<option  data-default_discount="'+response[key].default_discount+'" data-current_due="0"  data-customer_address="'+response[key].address+'"  data-same_or_diff_state="'+response[key].same_or_diff_state+'"   data-customer_gst_number="'+response[key].gst_number+'"  value="' +
                        response[key].id +
                        '" selected>' +
                        response[key].name +
                        " " +
                        response[key].phone +
                        "</option>";
                      let new_customer = {
                        customer_id: response[key].id, //your artist variable
                        customer_name: response[key].name, //your title variable
                        customer_address: response[key].address, //your title variable
                        customer_gst_number: response[key].gst_number, //your title variable
                        gst_number: response[key].gst_number,
                        default_discount: response[key].default_discount,
                      };
                      window.customers.push(new_customer);
                    } else {
                      option_customers +=
                        '<option data-default_discount="'+response[key].default_discount+'" data-current_due="0" data-same_or_diff_state="'+response[key].same_or_diff_state+'"  data-customer_address="'+response[key].address+'"   data-customer_gst_number="'+response[key].gst_number+'" value="' +
                        response[key].id +
                        '">' +
                        response[key].name +
                        " " +
                        response[key].phone +
                        "</option>";
                    }
                    i++;
                  }
                  $("#walk_in_customer").html(option_customers);
                  $("#walk_in_customer1").html(option_customers);
  
                  $("#walk_in_customer").val(new_customer_id).change();
                  $("#walk_in_customer1").val(new_customer_id).change();
                  // $('#walk_in_customer').select2('data', {id: selected_id, text: selected_name});
                  reset_on_modal_close_or_add_customer();
                    setDiscountForSelectedCustomer();
                  this_action
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .removeClass("active")
                    .addClass("inActive");
                  setTimeout(function () {
                    $(".modal").removeClass("inActive");
                  }, 1000);
                  $(".pos__modal__overlay").fadeOut(300);
                },
                error: function () {
                  alert(a_error);
                },
              });
            }
          },
          error: function () {
            alert(a_error);
          },
        });
  
        return false;
      });
  
      $(document).on("click", "#submit_login_online", function (e) {
        $(".online_order_password_error").hide();
        let online_login_phone = $("#online_login_phone").val();
        let online_login_password = $("#online_login_password").val();
        let error = 0;
  
        $("#online_login_phone").css("border", "1px solid #B5D6F6");
        $("#online_login_password").css("border", "1px solid #B5D6F6");
  
        if (online_login_phone == "") {
          $("#online_login_phone").css("border", "1px solid red");
          error++;
        }
  
        if (online_login_password == "") {
          $("#online_login_password").css("border", "1px solid red");
          error++;
        }
  
        if (error != 0) {
          return false;
        }else{
            let this_action = $(this);
            $.ajax({
                url: base_url + "Sale/online_customer_login_by_ajax",
                method: "POST",
                dataType:'json',
                data: {
                    online_login_phone: online_login_phone,
                    online_login_password: online_login_password,
                },
                success: function (response) {
                    if(response.status==true){
                        $("#walk_in_customer").val(response.customer_id).change();
                        $("#walk_in_customer1").val(response.customer_id).change();
  
                        $(".online_order_after_login").show();
                        $(".online_order_before_login").hide();
                        $("#default_customer_hidden").val(response.online_customer_id);
                        $("#online_customer_id").val(response.online_customer_id);
                        $("#online_customer_name").val(response.online_customer_name);
  
                        $(".modal").removeClass("active");
                        $(".pos__modal__overlay").fadeOut(300);
                    }else{
                        $(".online_order_password_error").show();
                    }
                },
                error: function () {
                    alert(a_error);
                },
            });
        }
      });
  
      let online_customer_id = Number($("#online_customer_id").val());
      if(online_customer_id){
          $("#walk_in_customer").val(online_customer_id).trigger("change");
          $("#walk_in_customer1").val(online_customer_id).trigger("change");    
      }
    
      $("#modify_order").on("mouseleave", function () {
        $("#modify_button_tool_tip").slideUp();
      });
      //tooltip modify order button
      let modify_order_button = $("#modify_order");
      // let modify_order_button = modify_order_button.position();
      let modify_order_top =
        modify_order_button.offset().top - $(document).scrollTop();
      let modify_order_left =
        modify_order_button.offset().left - $(document).scrollLeft();
      let modify_order_width = (
        parseFloat(modify_order_button.width()) + parseFloat(30)
      ).toFixed(ir_precision);
      let modify_order_height = modify_order_button.height();
      let modify_order_half_height = (
        parseFloat(modify_order_height) / parseFloat(50)
      ).toFixed(ir_precision);
      let order_tool_tip_top = document
        .getElementById("modify_order")
        .getBoundingClientRect().top;
  
      $("#modify_button_tool_tip").css("top", order_tool_tip_top + "px");
      $("#modify_button_tool_tip").css("left", modify_order_width + "px");
  
      //tooltip direct invoice button
  
    //update all price of modal
      function update_all_total_price() {
          //get item quantity
          let item_quantity = Number($("#item_quantity_modal").val()).toFixed(
              ir_precision
          );
          //get item unit price
          let item_unit_price = parseFloat($("#modal_item_price").html()).toFixed(
              ir_precision
          );
  
          //get item total price without discount
  
          let is_variation_product = Number($("#is_variation_product").html());
          if(is_variation_product){
              item_unit_price = parseFloat($("#vr01_modal_price_variable:visible").html()).toFixed(ir_precision);
          }
          //get item total price without discount
          let item_total_price_without_discount = (
              parseFloat(item_quantity) * (parseFloat(item_unit_price))
          ).toFixed(ir_precision);
          //set item total price without discount
          $("#modal_item_price_variable_without_discount").html(
              item_total_price_without_discount
          );
  
          //get discount from modal
          let discount_on_modal = $("#modal_discount").val();
          discount_on_modal = discount_on_modal != "" ? discount_on_modal : 0;
  
          //remove last digits if number is more than 2 digits after decimal
          remove_last_two_digit_with_percentage(
              discount_on_modal,
              $("#modal_discount")
          );
  
          //get discount actual amount on item price
          let actual_modal_discount_amount = get_particular_item_discount_amount(
              discount_on_modal,
              item_total_price_without_discount
          );
          //set actual discount amouto hidden modal element
          $("#modal_discount_amount").html(
              parseFloat(actual_modal_discount_amount).toFixed(ir_precision)
          );
  
          //get item price after discount
          let item_price_after_discount = (
              parseFloat(item_total_price_without_discount) -
              parseFloat(actual_modal_discount_amount)
          ).toFixed(ir_precision);
  
          //set item total price with discount
          $("#modal_item_price_variable").html(item_price_after_discount);
  
          //get modifiers unit sum price
          let modifiers_unit_sum_price = 0;
          $(".modal_modifiers").each(function() {
              if ($(this).attr("data-selected") == "selected") {
                  let this_price = Number($(this).attr("data-price"));
                  modifiers_unit_sum_price+=this_price;
              }
          });
  
          //set modifiers price as per item quantity
          let modifiers_price = (
              parseFloat(modifiers_unit_sum_price) * parseFloat(item_quantity)
          ).toFixed(ir_precision);
          $("#modal_modifier_price_variable").html(modifiers_price);
          //add items and modifiers price
          let all_price = (
              parseFloat(item_price_after_discount) + parseFloat(modifiers_price)
          ).toFixed(ir_precision);
  
          //show to all total
          $("#modal_total_price").html(all_price);
      }
      function update_all_vr01_total_price() {
          //get item quantity
          let item_quantity = Number($("#item_quantity_modal").val()).toFixed(
              ir_precision
          );
          //get item unit price
          let item_unit_price = parseFloat($("#vr01_modal_price_variable").html()).toFixed(
              ir_precision
          );
          //get item total price without discount
          let item_total_price_without_discount = (
              parseFloat(item_quantity) * parseFloat(item_unit_price)
          ).toFixed(ir_precision);
          //set item total price without discount
          $("#modal_item_price_variable_without_discount").html(
              item_total_price_without_discount
          );
  
          //get discount from modal
          let discount_on_modal = $("#modal_discount").val();
          discount_on_modal = discount_on_modal != "" ? discount_on_modal : 0;
  
          //remove last digits if number is more than 2 digits after decimal
          remove_last_two_digit_with_percentage(
              discount_on_modal,
              $("#modal_discount")
          );
  
          //get discount actual amount on item price
          let actual_modal_discount_amount = get_particular_item_discount_amount(
              discount_on_modal,
              item_total_price_without_discount
          );
          //set actual discount amouto hidden modal element
          $("#modal_discount_amount").html(
              parseFloat(actual_modal_discount_amount).toFixed(ir_precision)
          );
  
          //get item price after discount
          let item_price_after_discount = (
              parseFloat(item_total_price_without_discount) -
              parseFloat(actual_modal_discount_amount)
          ).toFixed(ir_precision);
  
          //set item total price with discount
          $("#modal_item_price_variable").html(item_price_after_discount);
  
          //get modifiers unit sum price
          let modifiers_unit_sum_price = 0;
          $(".modal_modifiers").each(function() {
              if ($(this).attr("data-selected") == "selected") {
                  let this_price = Number($(this).attr("data-price"));
                  modifiers_unit_sum_price+=this_price;
              }
          });
  
          //set modifiers price as per item quantity
          let modifiers_price = (
              parseFloat(modifiers_unit_sum_price) * parseFloat(item_quantity)
          ).toFixed(ir_precision);
          $("#modal_modifier_price_variable").html(modifiers_price);
          //add items and modifiers price
          let all_price = (
              parseFloat(item_price_after_discount) + parseFloat(modifiers_price)
          ).toFixed(ir_precision);
  
          //show to all total
          $("#modal_total_price").html(all_price);
      }
    // ==================================================
    function show_all_items() {
      $(".specific_category_items_holder").hide();
  
      setTimeout(function () {
        let foundItems = searchItemAndConstructGallery("");
        let searched_category_items_to_show =
          '<div id="searched_item_found" class="specific_category_items_holder">';
        for (let key in foundItems) {
            if (foundItems.hasOwnProperty(key)) {
                let veg_status = "no";
                if (foundItems[key].veg_item_status == "yes") {
                    veg_status = "yes";
                }
                let beverage_status = "no";
                if (foundItems[key].beverage_item_status == "yes") {
                    beverage_status = "yes";
                }
  
                if (foundItems[key].parent_id == '0') {
                    searched_category_items_to_show +=
                        '<div class="single_item animate__animated all_item_custom" data-price="' + foundItems[key].price + '"  data-price_take="' + foundItems[key].price_take + '"    data-is_variation="' + foundItems[key].is_variation + '"  data-parent_id="' + foundItems[key].parent_id + '"    data-price_delivery="' + foundItems[key].price_delivery + '" data-veg_status="' +
                        veg_status +
                        '" data-beverage_status="' +
                        beverage_status +
                        '" id="item_' +
                        foundItems[key].item_id +
                        '">';
                    searched_category_items_to_show +=
                        '<img src="' + foundItems[key].image + '" alt="" width="141">';
                    searched_category_items_to_show +=
                        '<p class="item_name" data-tippy-content="' +
                        foundItems[key].item_name +
                        '">' +
                        foundItems[key].item_name +
                        "</p>";
                    searched_category_items_to_show +=
                        '<p class="item_price">' +
                        price_txt +
                        ": " +
                        foundItems[key].price +
                        "</p>";
                    searched_category_items_to_show +=
                        '<span class="item_vat_percentage ir_display_none">' +
                        foundItems[key].vat_percentage +
                        "</span>";
                    searched_category_items_to_show += "</div>";
                }
            }
        }
        searched_category_items_to_show += "<div>";
        $("#searched_item_found").remove();
        $(".specific_category_items_holder").fadeOut(0);
        $(".category_items").prepend(searched_category_items_to_show);
          if(food_menu_tooltip=="show"){
              tippy(".item_name", {
                  placement: "bottom-start",
              });
          }
      }, 100);
  
      //call this function to adjust the height of left side order list
      adjust_left_side_order_list();
  
      //call this function to adjust the height of right side item list
      adjust_right_side_item_list();
  
      adjust_middle_side_cart_list();
      $(document).on("click", ".single_table_div", function (e) {
        if ($(this).attr("data-table-checked") != "busy") {
          $(
            ".single_table_div[data-table-checked=checked],.single_table_div[data-table-checked=unchecked]"
          ).attr("data-table-checked", "unchecked");
          $(
            ".single_table_div[data-table-checked=checked],.single_table_div[data-table-checked=unchecked]"
          ).css("background-color", "#ffffff");
          $(this).css("background-color", "#b6d6f6");
          $(this).attr("data-table-checked", "checked");
        }
      });
      $(document).on("click", "#close_select_table_modal", function (e) {
        $(".single_table_div[data-table-checked=checked]").css(
          "background-color",
          "#ffffff"
        );
        $(".single_table_div[data-table-checked=checked]").attr(
          "data-table-checked",
          "unchecked"
        );
        $("#show_tables_modal").slideUp(333);
      });
      $(document).on("click", "#selected_table_done", function (e) {
        $("#show_tables_modal").slideUp(333);
      });
      $(document).on("click", "#refresh_order", function (e) {
        $(this).css("color", "#495057");
        $("#stop_refresh_for_search").html("yes");
        set_new_orders_to_view_for_interval();
      });


      $("body").on("click", ".inside_single_order_container", function () {
          $(this).attr('style','');
          //remove all active
          $(".inside_single_order_container").removeClass("active");
          $(this).addClass("active");
      });
  
    
      $(document).on("click", "#modify_order", function (e) {
          let pos_3 = Number($("#pos_3").val());
          if(pos_3){
              //focus search field
              focusSearch();
              if (
                  $(".holder .order_details > .single_order[data-selected=selected]")
                      .length > 0
              ) {
                  //get total items in cart
                  let total_items_in_cart = $(".order_holder .single_order").length;
                    $("#is_edit_click").val(2);
                  if (total_items_in_cart > 0) {
                      swal(
                          {
                              title: warning + "!",
                              text: txt_err_pos_5,
                              confirmButtonColor: "#3c8dbc",
                              confirmButtonText: ok,
                              showCancelButton: true,
                          },
                          function () {
                              $(".order_holder").empty();
                              let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                              $("#update_sale_id").val(sale_no);
                              get_details_of_a_particular_order(sale_no);
                              setTimeout(function () {
                                  update_kitchen_status(sale_no);
                              }, 1000);
                          }
                      );
                  } else {
                    let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                      $("#update_sale_id").val(sale_no);
                      get_details_of_a_particular_order(sale_no);
                      setTimeout(function () {
                          update_kitchen_status(sale_no);
                      }, 1000);
  
                  }
              } else {
                  toastr['error']((please_select_open_order), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
  
      });
      $(document).on("click", "#single_order_details", function (e) {
        if (
          $(".holder .order_details > .single_order[data-selected=selected]")
            .length > 0
        ) {
            let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
          get_details_of_a_particular_order_for_modal(sale_no);
        } else {
            toastr['error']((please_select_open_order), '');
        }
      });
      $(document).on("click", "#hold_sale", function (e) {
        if ($(".order_holder .single_order").length > 0) {
            let status = true;
            if(!checkInternetConnection()){
                let draft_error = $("#draft_error").val();
                status = false;
                toastr['error']((draft_error), '');
            }
            if(status){
                $.ajax({
                    url: base_url + "Sale/get_new_hold_number_ajax",
                    method: "GET",
                    success: function (response) {
                        $("#generate_sale_hold_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                        $("#hold_generate_input").val(response);
                    },
                    error: function () {
                        alert(a_error);
                    },
                });
            }
  
        } else {
            toastr['error']((cart_empty), '');
        }
        // $('#show_sale_hold_modal').show();
      });
      $(document).on("click", "#close_hold_modal", function (e) {
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay").fadeOut(300);
  
        $("#hold_generate_input").val("");
        $("#hold_generate_input").css("border", "1px solid #a0a0a0");
      });
      $(document).on("click", "#hold_cart_info", function (e) {
          //focus search field
          focusSearch();
        let hold_number = $("#hold_generate_input").val();
        if (hold_number == "") {
          $("#hold_generate_input").css("border", "1px solid #dc3545");
          return false;
        } else {
          $("#hold_generate_input").css("border", "1px solid #a0a0a0");
        }
        let selected_order_type_object = $(".main_top")
          .find("button[data-selected=selected]")
          .attr("data-selected", "unselected");
        let total_items_in_cart = $(".order_holder .single_order").length;
        let sub_total = parseFloat($("#sub_total_show").html()).toFixed(
          ir_precision
        );
        let charge_type = $("#charge_type").val();
        let total_vat = parseFloat($("#all_items_vat").html()).toFixed(
          ir_precision
        );
        let total_payable = parseFloat($("#total_payable").html()).toFixed(
          ir_precision
        );
        let total_item_discount_amount = parseFloat(
          $("#total_item_discount").html()
        ).toFixed(ir_precision);
        let sub_total_with_discount = parseFloat(
          $("#discounted_sub_total_amount").html()
        ).toFixed(ir_precision);
        let sub_total_discount_amount = parseFloat(
          $("#sub_total_discount_amount").html()
        ).toFixed(ir_precision);
        let total_discount_amount = parseFloat(
          $("#all_items_discount").html()
        ).toFixed(ir_precision);
  
          let delivery_charge = '';
          let delivery_charge_actual_charge = '';
          let show_charge_amount_ = Number($("#show_charge_amount").html());
          if(show_charge_amount_){
              delivery_charge = $("#delivery_charge").val();
              delivery_charge_actual_charge = $("#show_charge_amount").html();
          }
  
        let tips_amount = $("#tips_amount").val();
        let sub_total_discount_value = $("#sub_total_discount").val();
        let sub_total_discount_type = "";
        let sale_vat_objects = [];
        $("#tax_row_show .tax_field").each(function (i, obj) {
          let tax_field_id = $(this).attr("data-tax_field_id");
          let tax_field_type = $(this).attr("data-tax_field_type");
          let tax_field_amount = $(this).attr("data-tax_field_amount");
          sale_vat_objects.push({
            tax_field_id: tax_field_id,
            tax_field_type: tax_field_type,
            tax_field_amount: parseFloat(tax_field_amount).toFixed(ir_precision),
          });
        });
        if (total_items_in_cart == 0) {
            toastr['error']((cart_empty), '');
          return false;
        }
        if (
          sub_total_discount_value.length > 0 &&
          sub_total_discount_value.substr(sub_total_discount_value.length - 1) ==
            "%"
        ) {
          sub_total_discount_type = "percentage";
        } else {
          sub_total_discount_type = "fixed";
        }
        let selected_table = 0;
  
        if ($(".single_table_div[data-table-checked=checked]").length > 0) {
          selected_table = $(".single_table_div[data-table-checked=checked]")
            .attr("id")
            .substr(13); //1; //demo
        }
  
        let order_type = 0;
        if (selected_order_type_object.attr("data-id") == "delivery_button") {
          order_type = 3;
        } else if (selected_order_type_object.attr("data-id") == "dine_in_button") {
          order_type = 1;
        } else if (selected_order_type_object.attr("data-id") == "take_away_button") {
          order_type = 2;
        }
  
        let customer_id = $("#walk_in_customer").val();
        let waiter_id = $("#select_waiter").val();
  
          let delivery_partner_id = '';
          if(order_type == 3){
              delivery_partner_id = $("input[name='delivery_partner_id']:checked").val();
          }
  
  
  
          let order_status = 1;
        let open_invoice_date_hidden = $("#open_invoice_date_hidden").val();
        let order_info = "{";
        order_info += '"customer_id":"' + customer_id + '",';
        order_info += '"delivery_partner_id":"' + delivery_partner_id + '",';
        order_info += '"waiter_id":"' + waiter_id + '",';
        order_info +=
          '"open_invoice_date_hidden":"' + open_invoice_date_hidden + '",';
        order_info += '"total_items_in_cart":"' + total_items_in_cart + '",';
        order_info += '"charge_type":"' + charge_type + '",';
        order_info += '"sub_total":"' + sub_total + '",';
        order_info += '"total_vat":"' + total_vat + '",';
        order_info += '"total_payable":"' + total_payable + '",';
        order_info +=
          '"total_item_discount_amount":"' + total_item_discount_amount + '",';
        order_info +=
          '"sub_total_with_discount":"' + sub_total_with_discount + '",';
        order_info +=
          '"sub_total_discount_amount":"' + sub_total_discount_amount + '",';
        order_info += '"total_discount_amount":"' + total_discount_amount + '",';
        order_info += '"delivery_charge":"' + delivery_charge + '",';
        order_info += '"tips_amount":"' + tips_amount + '",';
          order_info += '"delivery_charge_actual_charge":"' + delivery_charge_actual_charge + '",';
          let tips_amount_actual_charge = $("#show_tips_amount").html();
          order_info += '"tips_amount_actual_charge":"' + tips_amount_actual_charge + '",';
        order_info +=
          '"sub_total_discount_value":"' + sub_total_discount_value + '",';
        order_info +=
          '"sub_total_discount_type":"' + sub_total_discount_type + '",';
        order_info += '"selected_table":"' + selected_table + '",';
        order_info += '"order_type":"' + order_type + '",';
        order_info += '"order_status":"' + order_status + '",';
        order_info +=
          '"sale_vat_objects":' + JSON.stringify(sale_vat_objects) + ",";
  
        let orders_table = "";
        orders_table += '"orders_table":';
        orders_table += "[";
        let x = 1;
        let table_id = $(".new_book_to_table").length;
        $(".new_book_to_table").each(function (i, obj) {
          let person = $(this).find(".third_column").html();
          if (x == table_id) {
            orders_table +=
              '{"table_id":"' + table_id + '", "persons":"' + person + '"}';
          } else {
            orders_table +=
              '{"table_id":"' + table_id + '", "persons":"' + person + '"},';
          }
          x++;
        });
        orders_table += "],";
        order_info += orders_table;
  
        let items_info = "";
        items_info += '"items":';
        items_info += "[";
  
        if ($(".order_holder .single_order").length > 0) {
          let k = 1;
          $(".order_holder .single_order").each(function (i, obj) {
            let item_id = $(this).attr("id").substr(15);
            let item_name = $(this)
              .find("#item_name_table_" + item_id)
              .html();
            let item_vat = $(this).find(".item_vat").html();
            let item_discount = $(this)
              .find("#percentage_table_" + item_id)
              .val();
            let discount_type = "";
            if (
              item_discount.length > 0 &&
              item_discount.substr(item_discount.length - 1) == "%"
            ) {
              discount_type = "percentage";
            } else {
              discount_type = "fixed";
            }
            let item_price_without_discount = $(this)
              .find(".item_price_without_discount")
              .html();
            let item_unit_price = $(this)
              .find("#item_price_table_" + item_id)
              .html();
            let item_quantity = $(this)
              .find("#item_quantity_table_" + item_id)
              .html();
            let item_price_with_discount = $(this)
              .find("#item_total_price_table_" + item_id)
              .html();
            let item_discount_amount = (
              parseFloat(item_price_without_discount) -
              parseFloat(item_price_with_discount)
            ).toFixed(ir_precision);
            items_info +=
              '{"item_id":"' +
              item_id +
              '", "item_name":"' +
              item_name +
              '", "item_vat":' +
              item_vat +
              ",";
            items_info +=
              '"item_discount":"' +
              item_discount +
              '","discount_type":"' +
              discount_type +
              '","item_price_without_discount":"' +
              item_price_without_discount +
              '",';
            items_info +=
              '"item_unit_price":"' +
              item_unit_price +
              '","item_quantity":"' +
              item_quantity +
              '",';
            items_info +=
              '"item_price_with_discount":"' +
              item_price_with_discount +
              '","item_discount_amount":"' +
              item_discount_amount +
              '"';
  
            let ji = 1;
            let modifier_vat = "";
            $(".item_vat_modifier_" + item_id).each(function (i, obj) {
              if (ji == $(".item_vat_modifier_" + item_id).length) {
                modifier_vat += $(this).html();
              } else {
                modifier_vat += $(this).html() + "|||";
              }
              ji++;
            });
  
            if ($(this).find(".second_portion").length > 0) {
              let modifiers_id = $(this)
                .find("#item_modifiers_id_table_" + item_id)
                .html();
              let modifiers_price = $(this)
                .find("#item_modifiers_price_table_" + item_id)
                .html();
              items_info +=
                ',"modifiers_id":"' +
                modifiers_id +
                '", "modifiers_price":"' +
                modifiers_price +
                '", "modifier_vat":' +
                JSON.stringify(modifier_vat);
            } else {
              items_info +=
                ',"modifiers_id":"", "modifiers_price":"", "modifier_vat":""';
            }
            if ($(this).find(".third_portion").length > 0) {
              let item_note = $(this)
                .find("#item_note_table_" + item_id)
                .html();
              items_info += ',"item_note":"' + item_note + '"';
            } else {
              items_info += ',"item_note":""';
            }
            items_info +=
              k == $(".order_holder .single_order").length ? "}" : "},";
            k++;
          });
        }
        items_info += "]";
  
        order_info += items_info + "}";
  
        let order_object = JSON.stringify(order_info);
  
        add_hold_by_ajax(order_object, hold_number);
      });
    }
    $(".marquee").marquee({
      //speed in milliseconds of the marquee
      duration: 5000,
      //gap in pixels between the tickers
      gap: 250,
      //time in milliseconds before the marquee will start animating
      delayBeforeStart: 0,
      //'left' or 'right'
      direction: "left",
      //true or false - should the marquee be duplicated to show an effect of continues flow
      duplicated: true,
    });
    //this function adjust the left side order list height
    function adjust_left_side_order_list() {
      let left_side_button_holder_height = $(
        "#left_side_button_holder_absolute"
      ).height();
      let main_left_portion_height = $(".main_left").height();
      let header_of_left_portion_height = $(".main_left h3").height();
      let height_left_button_holder_and_header = (
        parseFloat(left_side_button_holder_height) +
        parseFloat(header_of_left_portion_height)
      ).toFixed(ir_precision);
      let remaining_height_for_list = (
        parseFloat(main_left_portion_height) -
        parseFloat(height_left_button_holder_and_header) -
        parseFloat(35)
      ).toFixed(ir_precision);
      $(".order_details").css("height", remaining_height_for_list - 20 + "px");
    }
    //this function adjust the left side order list height
    function adjust_middle_side_cart_list() {
      let middle_side_bottom_holder_height = $("#bottom_absolute").height();
      let main_middle_portion_height = $(".main_middle").height();
      let order_table_header_row = $(".order_table_header_row").height();
      let header_of_middle_portion_height = $(".main_middle .main_top").height();
      let height_middle_bottom_holder_and_header = (
        parseFloat(middle_side_bottom_holder_height) +
        parseFloat(header_of_middle_portion_height) +
        parseFloat(order_table_header_row)
      ).toFixed(ir_precision);
      let remaining_height_for_cart = (
        parseFloat(main_middle_portion_height) -
        parseFloat(height_middle_bottom_holder_and_header)
      ).toFixed(ir_precision);
  
      // $(".main_middle")
      //   .find(".order_holder")
      //   .css("height", remaining_height_for_cart - 110 + "px");
    }
    //this function adjust the right side item list height
    function adjust_right_side_item_list() {
      let main_right_portion_height = $(".main_right").height();
      let search_item_input_height = $("#search").height();
      let top_header_height = $(".top_header").height();
  
      let search_item_input_margin_bottom = parseFloat(
        $("#search").css("margin-bottom")
      );
      let select_category_height = $(".select_category").height();
      let select_category_margin_bottom = parseFloat(
        $(".select_category").css("margin-bottom")
      );
      let search_input_total_height = (
        parseFloat(search_item_input_height) +
        parseFloat(search_item_input_margin_bottom)
      ).toFixed(ir_precision);
      let select_category_total_height = (
        parseFloat(select_category_height) +
        parseFloat(select_category_margin_bottom)
      ).toFixed(ir_precision);
      let total_height_except_item_list = (
        parseFloat(search_input_total_height) +
        parseFloat(select_category_total_height)
      ).toFixed(ir_precision);
      let remaining_height_for_item_list = (
        parseFloat(main_right_portion_height) -
        parseFloat(total_height_except_item_list) -
        parseFloat(13)
      ).toFixed(ir_precision);
    }
    //KOT
    $(document).on("change", "#kot_check_all", function (e) {
      if ($(this).is(":checked")) {
        $(".kot_item_checkbox").prop("checked", true);
      } else {
        $(".kot_item_checkbox").prop("checked", false);
      }
    });
    $(document).on("click", "#print_kot_modal", function (e) {
        let selected_order_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
        if(checkInternetConnection()){
            let kitchen_id = '';
            $(".kitchen_ids:checked").each(
                function (i, obj) {
                    if (i == ($(".kitchen_ids:checked").length - 1)) {
                        kitchen_id += $(this).val();
                    } else {
                        kitchen_id += $(this).val() + ",";
                    }
                }
            );
  
            let kot_print = $("#kot_print").val();
            if(kitchen_id){
                $.ajax({
                    url: base_url + "Authentication/selectedKitchenPrinting",
                    method: "post",
                    dataType: "json",
                    data: {selected_order_no: (selected_order_no),kitchen_id: kitchen_id,kot_print: kot_print},
                    success: function (data) {
                      let content_data_direct_print = data.content_data_direct_print;
                      for (let key in content_data_direct_print) {
                          if(content_data_direct_print[key].ipvfour_address){
                              $.ajax({
                                  url:
                                  content_data_direct_print[key].ipvfour_address +
                                  "print_server/irestora_printer_server.php",
                                  method: "post",
                                  dataType: "json",
                                  data: {
                                      content_data: "["+(JSON.stringify(content_data_direct_print[key]))+"]",print_type:data.print_type,
                                  },
                                  success: function (data) {},
                                  error: function () {},
                              });
                          }
                      }
                      print_kot_popup_print(data.content_data_popup_print,0);
                    },
                    error: function () {},
                });


                $(this)
                .parent()
                .parent()
                .parent()
                .removeClass("active")
                .addClass("inActive");
            setTimeout(function () {
                $(".modal").removeClass("inActive");
                $(".kitchen_ids").prop("checked",false)
            }, 1000);
            $(".pos__modal__overlay").fadeOut(300);

            }else{
                toastr['error']((please_select_your_kitchen_for_print + "!"), '');
            }
  

  
        }else{
          let kot_print = $("#kot_print").val();
          let sale_no = $(".print_kot_button").attr("data-sale_no");
            getSelectedOrderDetails(sale_no).then(function(data){
              if(data.order !== null) {
                  print_kot_print(data.order,kot_print);
              }
          });
        }
    });
    $(document).on("click", ".kot_content_column .single_modifier", function () {
      let current_selection = $(this).attr("data-selected");
      if (current_selection == "selected") {
        $(this).attr("data-selected", "unselected");
        $(this).css("background-color", "#E0E0E0");
      } else if (current_selection == "unselected") {
        $(this).attr("data-selected", "selected");
      }
    });
      function print_kot_button(kot_print){
        if(checkInternetConnection()){
            $("#kot_list_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
        }else{
            let sale_no = $(".print_kot_button").attr("data-sale_id");
            getSelectedOrderDetails(sale_no).then(function(data){
                if(data.order !== null) {
                    print_kot_print(data.order,kot_print);
                }
            });
        }
      }

    $(document).on("click", ".kot_btn_class", function (e) {
        let kot_type = Number($(this).attr("data-type"));
        $("#is_first").val(2);
        $("#kot_print").val(kot_type);
        print_kot_button(kot_type);
    });
    $(document).on("click", ".print_kot_button", function (e) {
        let pos_10 = Number($("#pos_10").val());
        if(pos_10){
            if (
                $(".holder .order_details > .single_order[data-selected=selected]")
                    .length > 0
            ) {
                let sale_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
                $(".print_kot_button").attr("data-sale_no",sale_no);
                body_el.parent().find('.invoice_box_kot').toggleClass('active');
            } else {
                toastr['error']((please_select_open_order), '');
            }
        }else{
            toastr['error']((menu_not_permit_access + "!"), '');
        }
    });
  
    
      $(document).on("click", "#order_details_print_kot_button", function (e) {
          let pos_10 = Number($("#pos_10").val());
          if(pos_10){
              if (
                  $(".holder .order_details > .single_order[data-selected=selected]")
                      .length > 0
              ) {
                  $(this)
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .removeClass("active")
                      .addClass("inActive");
                  setTimeout(function () {
                      $(".modal").removeClass("inActive");
                  }, 1000);
                  $(".pos__modal__overlay").fadeOut(300);
                  $("#print_kot").click();
  
              } else {
                  toastr['error']((please_select_open_order), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
      });
    $(document).on("click", ".decrease_item_kot_modal", function () {
      let item_detail_id = $(this).attr("id").substr(24);
      let qty_element = $("#kot_modal_item_qty_" + item_detail_id);
      let qty_element_fixed = $("#kot_modal_item_qty_fixed_" + item_detail_id);
      let qty = parseInt(qty_element.html());
      if (qty > 1) {
        qty--;
      }
      qty_element.html(qty);
    });
    $(document).on("click", ".increase_item_kot_modal", function () {
      let item_detail_id = $(this).attr("id").substr(24);
      let qty_element = $("#kot_modal_item_qty_" + item_detail_id);
      let qty_element_fixed = $("#kot_modal_item_qty_fixed_" + item_detail_id);
      let qty = parseInt(qty_element.html());
      let qty_fixed = parseInt(qty_element_fixed.html());
      if (qty < qty_fixed) {
        qty++;
      }
  
      qty_element.html(qty);
    });
    $(document).on("click", "#cancel_kot_modal", function (e) {
        $(".kitchen_ids").prop("checked",false)
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
      $(document).on("click", "#select_all_kot_modal", function (e) {
          $(".kitchen_ids").prop("checked",true);
      });
    $(document).on("click", "#cancel_kot_modal2", function (e) {
      $("#kot_check_all").prop("checked", false);
      $("#kot_modal_modified_or_not").hide();
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });

       
     
    function middleContentHeight() {
      let height_should_be =
        parseInt($(window).height()) - parseInt($(".top_header_part").height());
      // $(".main_left").css("height", height_should_be + 10 + "px");
      // $(".main_middle").css("height", height_should_be + 10 + "px");
      // $(".main_right").css("height", height_should_be + 10 + "px");
    }
    $(window).on("resize", function () {
      middleContentHeight();
      adjust_left_side_order_list();
      adjust_right_side_item_list();
      adjust_middle_side_cart_list();
    });
    $(window).on("load", function () {
      middleContentHeight();
      adjust_middle_side_cart_list();
    });
    function calculate_create_invoice_modal() {
      let total_payable = $("#finalize_total_payable").html();
      let paid_amount =
        $("#pay_amount_invoice_input").val() != ""
          ? $("#pay_amount_invoice_input").val()
          : 0;
      let due_amount = (
        parseFloat(total_payable) - parseFloat(paid_amount)
      ).toFixed(ir_precision);
      $("#due_amount_invoice_input").val(due_amount);
    }

    function delivery_charge_tax_calculation(charge_amount, tax_json_for_settting){
        let tax_json_for_settting_array = JSON.parse(tax_json_for_settting);
        let tax_amount = 0;
        tax_json_for_settting_array.forEach(function(tax){
            tax_amount += (charge_amount * tax.tax_rate) / 100;
        });
        return tax_amount;
    }
    // ===============================================
    // add all prices of item and modifiers
    function do_addition_of_item_and_modifiers_price() {
      //set all hidden discount amount and original item price
      set_all_hidden_item_discount_amount();
      //set visible discounted item price to table
      set_all_visible_discounted_item_price();
  
      //set total discount amount of items
      set_total_items_discount_for_subtotal();
  
      //set all hidden discount amount and original item price
      set_all_items_modifiers_amount();
  
      let total_of_all_items_and_modifiers = get_total_of_all_items_and_modifiers();
  
      //get total items in cart
      let total_items_in_cart = $(".order_holder .single_order").length;
      //set row number for every single item
      $(".order_holder .single_order").each(function (i, obj) {
        $(this).attr("data-single-order-row-no", i + 1);
      });
      let total_items_in_cart_with_quantity = 0;
      let qty_div = $(".single_order .first_portion").find('.qty_item_custom');
        qty_div.each(function (i, obj) {
          console.log(parseInt($(this).html()));
        total_items_in_cart_with_quantity+=parseInt($(this).html());
      });
  
      //set total items in cart to view
      $("#total_items_in_cart").html(total_items_in_cart);
      $("#total_items_in_cart_with_quantity").html(total_items_in_cart_with_quantity);
      //set sub total
      $("#sub_total").html(total_of_all_items_and_modifiers);
      $("#sub_total_show").html(total_of_all_items_and_modifiers);
  
      //get the value of the delivery charge amount
  
      let delivery_charge_amount = 0;
      let tips_amount = 0;
   
      let countable_d_c = "no";
  
      $(".selected__btn_c").each(function () {
        let this_id_name = $(this).attr("id");
        let this_selected_name = $(this).attr("data-selected");
        let charge_type_custom = $("#charge_type").val();
  
        if (this_selected_name == "selected") {
          if (
            charge_type_custom == "delivery" &&
            this_id_name != "take_away_button" &&
            this_id_name != "dine_in_button"
          ) {
            countable_d_c = "yes";
          }
          if (
            charge_type_custom == "service" &&
            this_id_name != "take_away_button" &&
            this_id_name != "delivery_button"
          ) {
            countable_d_c = "yes";
          }
        }
      });
  
      let waiter_app_status1 = $("#waiter_app_status").val();
      
      if (waiter_app_status1 == "Yes") {
        countable_d_c = "yes";
      }
      let sub_total_show = Number($("#sub_total_show").html());
  
  
      if ($("#tips_amount").val() != "") {
          tips_amount = get_particular_item_discount_amount(
          $("#tips_amount").val(),
          sub_total_show
        );
        $("#show_tips_amount").html(
          Number(tips_amount).toFixed(ir_precision)
        );
      } else {
        $("#show_tips_amount").html(Number(0).toFixed(ir_precision));
      }
  
      //get subtotal amount
      let sub_total_amount = $("#sub_total").html();
  
      let sub_total_discount_amount = 0;
      //get subtotal discount amount
      if ($("#sub_total_discount").val() != "") {
        sub_total_discount_amount = $("#sub_total_discount").val();
        let tmt_value_sub_total = sub_total_discount_amount.split("%");
        if (tmt_value_sub_total[1] == "") {
          $("#show_discount_amount").html(sub_total_discount_amount);
        } else {
          $("#show_discount_amount").html(
            Number(sub_total_discount_amount).toFixed(ir_precision)
          );
        }
      } else {
        $("#show_discount_amount").html(Number(0).toFixed(ir_precision));
      }
  
  
      //check wether value is valid or not
      remove_last_two_digit_with_percentage(
        sub_total_discount_amount,
        $("#sub_total_discount")
      );
      sub_total_discount_amount = get_sub_total_discount_amount(
        sub_total_discount_amount,
        sub_total_amount
      );
  
      //if sub total discount amount is greater than subtotal then make it blank
      if (parseFloat(sub_total_discount_amount) > parseFloat(sub_total_amount)) {
        $("#sub_total_discount").val("");
        do_addition_of_item_and_modifiers_price();
        return false;
      }
      //get total item discount amount
      let total_item_discount_amount = parseFloat(
        $("#total_item_discount").html()
      ).toFixed(ir_precision);
  
      //get all discount of table
      let total_discount = (
        parseFloat(sub_total_discount_amount) +
        parseFloat(total_item_discount_amount)
      ).toFixed(ir_precision);
  
      //set sub total discount amount
      $("#sub_total_discount_amount").html(sub_total_discount_amount);
  
      //set sub total amount after discount in a hidden field
  
      let discounted_sub_total_amount = (
        parseFloat(sub_total_amount) - parseFloat(sub_total_discount_amount)
      ).toFixed(ir_precision);
      $("#discounted_sub_total_amount").html(discounted_sub_total_amount);
  
      //get vat amount
  
      let vat_amount = collect_tax == "Yes" ? get_total_vat() : null;
      
      let total_vat_section_to_show = "";
      let html_modal = "";
      let total_tax_custom = 0;
   
      $.each(vat_amount, function (key, value) {
        let row_id = 1;
        let key_value = key;
        total_vat_section_to_show +=
          '<span class="tax_field" id="tax_field_' +
          row_id +
          '">' +
          key_value +
          "</span>: " +
          currency +
          ' <span class="tax_field_amount" id="tax_field_amount_' +
          row_id +
          '">' +
          value +
          "</span><br/>";
  
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
        total_tax_custom += parseFloat(value);
      });
  
   

      let tax_json_for_settting = $(".tax_setting").text();
     
      let delivery_charge_amount_tax = 0;
      let apply_on_delivery_charge = Number($("#apply_on_delivery_charge").val());

      if ($("#delivery_charge").val() != "" && countable_d_c == "yes") {
        let delivery_charge_amount = Number(get_particular_item_discount_amount($("#delivery_charge").val(),sub_total_show));
       
        if(apply_on_delivery_charge==2){
            delivery_charge_amount_tax = Number(delivery_charge_tax_calculation(delivery_charge_amount,tax_json_for_settting));
            total_tax_custom+=delivery_charge_amount_tax;
            $("#vat_text_show_for_charge").text("(charge tax:"+delivery_charge_amount_tax+")");
        }

        $("#show_charge_amount").html(
          Number(delivery_charge_amount).toFixed(ir_precision)
        );
      } else {
        $("#show_charge_amount").html(Number(0).toFixed(ir_precision));
      }

      if (total_tax_custom) {
        $("#show_vat_modal").html(total_tax_custom.toFixed(ir_precision));
      } else {
        $("#show_vat_modal").html(Number(0).toFixed(ir_precision));
      }

      
      $("#tax_row_show").html(html_modal);
      //set vat amount to view
      // $('#all_items_vat').html(vat_amount);
      $("#all_items_vat").html(total_vat_section_to_show);
  
      //set total discount
      $("#all_items_discount").html(total_discount);
  
      //calculate total payable amount
      let total_payable_to_show = "";
      let total_vat_amount = 0;
      let tax_type = Number($("#tax_type").val());
  
      if(tax_type==1){
          $.each(vat_amount, function (key, value) {
              let vat_tmp = 0;
              if (value && value != "NaN") {
                  vat_tmp = value;
              }
              total_vat_amount = (
                  parseFloat(total_vat_amount) + parseFloat(vat_tmp)
              ).toFixed(ir_precision);
          });
      }
      let total_show_charge_amount = Number($("#show_charge_amount").text());
      let total_payable = (
        parseFloat(discounted_sub_total_amount) +
        parseFloat(total_vat_amount) + delivery_charge_amount_tax +
        parseFloat(total_show_charge_amount)+
        parseFloat(tips_amount)
      ).toFixed(ir_precision);
  
      //set total payable amount to view
      let rounding_value = gettingRoundingAmount(total_payable);
  
      let rounding_txt = '';
      let rounding_txt_value = (Number(rounding_value[2])).toFixed(ir_precision);
  
  
        if (Number(rounding_value[2]) > 0) {
            rounding_txt = "+"+(Number(rounding_value[2])).toFixed(ir_precision);
        }
  
      $("#rounding_amount_hidden").val(Number(rounding_txt_value).toFixed(ir_precision));
      $("#rounding_amount").html(rounding_txt);
      $("#total_payable").html(Number(rounding_value[0]).toFixed(ir_precision));
  
      if(checkInternetConnection()){
          put_cart_content();
      }
      
    }
  
  
    function set_all_items_modifiers_amount() {
      $(".order_holder .single_order").each(function (i, obj) {
        let modifiers_price = parseFloat(0).toFixed(ir_precision);
        let item_id = $(this).attr("id").substr(15);
  
        let item_quantity = $(this)
          .find("#item_quantity_table_" + item_id)
          .html();
  
        if ($(this).find("#item_modifiers_price_table_" + item_id).length > 0) {
          let comma_separeted_modifiers_price = $(this)
            .find("#item_modifiers_price_table_" + item_id)
            .html();
          let modifiers_price_array =
            comma_separeted_modifiers_price != ""
              ? comma_separeted_modifiers_price.split(",")
              : "";
          modifiers_price_array.forEach(function (modifier_price) {
            modifiers_price = (
              parseFloat(modifiers_price) + parseFloat(modifier_price)
            ).toFixed(ir_precision);
          });
          let modifiers_price_as_per_item_quantity = (
            parseFloat(item_quantity) * parseFloat(modifiers_price)
          ).toFixed(ir_precision);
          $(this)
            .find(".fifth_column #item_modifiers_price_table_" + item_id)
            .html(modifiers_price_as_per_item_quantity);
  
            $(this).find('.modifier_incr_p').each(function (i, obj) {
                let price_p = $(this).attr("data-price");
                $(this).find('span').html((parseFloat(item_quantity)*parseFloat(price_p)).toFixed(ir_precision));
            });
        }
      });
    }
    function set_total_items_discount_for_subtotal() {
      let total_discount = 0;
      $(".single_order .first_portion .fifth_column span").each(function (i,obj) {
        let this_item_discount_amount = parseFloat(
          $(this).parent().parent().find(".item_discount").html()
        ).toFixed(ir_precision);
        total_discount = (
          parseFloat(total_discount) + parseFloat(this_item_discount_amount)
        ).toFixed(ir_precision);
          let this_action = $(this).parent().parent().parent();
          let main_menu_qty = Number($(this).parent().parent().find(".qty_item_custom").text());
          this_action.find(".combo_class").each(function (i,obj) {
              let this_qty = Number($(this).attr('data-qty'));
              $(this).text("Qty:"+(main_menu_qty*this_qty));
  
          });
      });
      $("#total_item_discount").html(total_discount);
    }
    function set_all_hidden_item_discount_amount() {
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        let this_item_original_price = parseFloat(
          $(this).parent().parent().find(".item_price_without_discount").html()
        ).toFixed(ir_precision);
        let item_discount_value = $(this)
          .parent()
          .parent()
          .find(".forth_column input")
          .val();
        item_discount_value = item_discount_value != "" ? item_discount_value : 0;
        let actual_discount_amount = get_particular_item_discount_amount(
          item_discount_value,
          this_item_original_price
        );
        $(this)
          .parent()
          .parent()
          .find(".item_discount")
          .html(actual_discount_amount);
      });
    }
    function set_all_visible_discounted_item_price() {
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        let this_item_original_price = parseFloat(
          $(this).parent().parent().find(".item_price_without_discount").html()
        ).toFixed(ir_precision);
        if(this_item_original_price=="NaN"){
            this_item_original_price = 0;
        }
        let item_discount_value = $(this)
          .parent()
          .parent()
          .find(".forth_column input")
          .val();
        item_discount_value = item_discount_value != "" ? item_discount_value : 0;
        let actual_discount_amount = get_particular_item_discount_amount(
          item_discount_value,
          this_item_original_price
        );
  
        let discounted_item_price = (
          parseFloat(this_item_original_price) -
          parseFloat(actual_discount_amount)
        ).toFixed(ir_precision);
  
        $(this)
          .parent()
          .parent()
          .find(".fifth_column span")
          .html(discounted_item_price);
      });
    }
    function get_total_of_all_items_and_modifiers() {
      //get all items total price and add
      let all_item_total_price = 0;
      let all_item_total_vat_amount = 0;
      let this_item_discount = 0;
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        all_item_total_price = (
          parseFloat(all_item_total_price) + parseFloat($(this).html())
        ).toFixed(ir_precision);
      });
  
      //get all modifiers price and add
      let all_modifiers_total_price = 0;
      $(".modifier_incr_p span").each(function (i,obj) {
        all_modifiers_total_price = (parseFloat(all_modifiers_total_price) + parseFloat($(this).html())).toFixed(ir_precision);
      });
  
      return (parseFloat(all_item_total_price) + parseFloat(all_modifiers_total_price)).toFixed(ir_precision);
    }
    function checkTaxApply(tax){
        let return_status = true;
        let same_or_diff_state = Number($("#same_or_diff_state").val());
  
        if(same_or_diff_state==1){
            if(tax=="CGST" || tax=="SGST"){
                return_status = true;
            }else{
                if(tax=="IGST"){
                    return_status = false;
                }else{
                    return_status = true;
                }
            }
        }else if(same_or_diff_state==2){
            if(tax=="IGST"){
                return_status = true;
            }else{
                if(tax=="CGST" || tax=="SGST"){
                    return_status = false;
                }else{
                    return_status = true;
                }
            }
        }
        if(tax_is_gst=="No"){
            if(tax=="CGST" || tax=="SGST" || tax=="IGST"){
                return_status = false;
            }
        }
        return return_status;
    }
    function get_total_vat() {
      let all_item_total_vat_amount = 0;
      let tax_object = {};
      let tax_name = [];
      let customer_id = $("#walk_in_customer").val();
  
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        let this_item_quantity = 1;
        let this_item_price = parseFloat(
          $(this).parent().parent().find(".second_column span").html()
        ).toFixed(ir_precision);
        let item_total_price = parseFloat(
          $(this).parent().parent().find(".fifth_column span").html()
        ).toFixed(ir_precision);
        let tax_information = JSON.parse(
          $(this).parent().parent().find(".item_vat").html()
        );
  
        console.log(tax_information)
        if (tax_information.length > 0) {
            for(let k in tax_information){
                console.log(tax_information[k].tax_field_name)
                if(tax_name.includes(tax_information[k].tax_field_name) && checkTaxApply(tax_information[k].tax_field_name)){
                    let previous_value = tax_object["" + tax_information[k].tax_field_name];
                    let current_value  = 0;
                    let tax_type = Number($("#tax_type").val());
                    if(tax_type==1){
                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                    }else{
                        current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(ir_precision);
                    }
                    
                    tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(ir_precision);
                }else{
                    if(checkTaxApply(tax_information[k].tax_field_name)){
                        tax_name.push(tax_information[k].tax_field_name);
                        let current_value  = 0;
                        let tax_type = Number($("#tax_type").val());
  
                        if(tax_type==1){
                            current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                        }else{
                            current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(ir_precision);
                        }
                        tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).tofixed(ir_precision);
                    }
  
                }
            }
        }
      });


      $(".item_vat_modifier").each(function (i, obj) {
        let item_id_custom = $(this).attr("data-item_id");
        let this_item_modifer_quantity = parseFloat(
          $("#item_quantity_table_" + item_id_custom).html()
        ).toFixed(ir_precision);
        let this_item_modifier_price = parseFloat(
          $(this).attr("data-modifier_price")
        ).toFixed(ir_precision);
  
        let item_total_price =
          this_item_modifer_quantity * this_item_modifier_price;
        let tax_information = JSON.parse($(this).html());
  
        if (tax_information.length > 0) {
            for(let k in tax_information){
                if(tax_name.includes(tax_information[k].tax_field_name)  && checkTaxApply(tax_information[k].tax_field_name)){
                    let previous_value = tax_object["" + tax_information[k].tax_field_name];
                    let current_value  = 0;
                    let tax_type = Number($("#tax_type").val());
                    if(tax_type==1){
                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                    }else{
                        current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(ir_precision);
                    }
                    tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(ir_precision);
                }else{
                    if(checkTaxApply(tax_information[k].tax_field_name)){
                    tax_name.push(tax_information[k].tax_field_name);
                    let current_value  = 0;
                    let tax_type = Number($("#tax_type").val());
  
                    if(tax_type==1){
                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                    }else{
                        current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(ir_precision);
                    }
                    tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).toFixed(ir_precision);
                  }
                }
            }
        }
      });
  
     
      return tax_object;
    }
    function get_total_vat_for_split(customer_id, obj_tax,total_row_amount) {
        let tax_object = {};
        let tax_name = [];
        let item_total_price = total_row_amount;
        let tax_information = (obj_tax);
        if (tax_information.length > 0) {
            for(let k in tax_information){
                if(tax_name.includes(tax_information[k].tax_field_name) && checkTaxApply(tax_information[k].tax_field_name)){
                    let previous_value = tax_object["" + tax_information[k].tax_field_name];
                    let current_value  = 0;
                    let tax_type = Number($("#tax_type").val());
                    if(tax_type==1){
                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                    }else{
                        current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(ir_precision);
                    }
  
                    tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(ir_precision);
                }else{
                    if(checkTaxApply(tax_information[k].tax_field_name)){
                        tax_name.push(tax_information[k].tax_field_name);
                        let current_value  = 0;
                        let tax_type = Number($("#tax_type").val());
  
                        if(tax_type==1){
                            current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                        }else{
                            current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(ir_precision);
                        }
                        tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).toFixed(ir_precision);
                  }
                }
            }
        }
          return tax_object;
      }
  
    function get_total_vat_for_split_sale_table() {
        let customer_id = $("#selected_invoice_sale_customer").val();
        let tax_object = {};
        let tax_name = [];
        let this_action = '';
        $(".custom_li_split").each(function() {
            let row_div =  $(this).attr("data-row");
            if($("#myCheckbox_"+row_div).is(":checked")){
                this_action = $(this);
            }
        });
  
        this_action.find('.row_box_item').each(function() {
            let right_food_menu_id = Number($(this).attr('data-id'));
            let tax_menu_row = '';
            let tax_type = Number($("#tax_type").val());
            let item_total_price = Number($(this).find('.total_right_box').html());
            let selected_box_action = $(this).find(".split_modifier_name");
            $('.row_items_spit').each(function () {
                let left_food_menu_id = Number($(this).attr('data-id'));
                if (right_food_menu_id === left_food_menu_id) {
                    tax_menu_row = $(this).find('.menu_taxes').html();
                    if (tax_menu_row) {
                        let tax_information = JSON.parse(tax_menu_row);
                        if (tax_information.length > 0) {
                            for(let k in tax_information){
                                if(tax_name.includes(tax_information[k].tax_field_name) && checkTaxApply(tax_information[k].tax_field_name)){
                                    let previous_value = tax_object["" + tax_information[k].tax_field_name];
                                    let current_value  = 0;
                                    if(tax_type==1){
                                        current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                    }else{
                                        current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(ir_precision);
                                    }
                                    tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(ir_precision);
                                }else{
                                    if(checkTaxApply(tax_information[k].tax_field_name)){
                                        tax_name.push(tax_information[k].tax_field_name);
                                        let current_value  = 0;
                                        if(tax_type==1){
                                            current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                        }else{
                                            current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(ir_precision);
                                        }
                                        tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).toFixed(ir_precision);
                                  }
                                }
                            }
                        }
                    }
                    //check tax for modifier
                    let mm = 0;
                    selected_box_action.each(function () {
                      let modifier_id_split = Number($(this).attr("data-modifier_id"));
                        item_total_price = Number($(this).parents().parents().find('.modifier_right_box').eq(mm).text());
                        mm++;
                        for (let i = 0; i < window.only_modifiers.length; i++) {
                            // look for the entry with a matching `id` value
                            if (Number(only_modifiers[i].menu_modifier_id) == modifier_id_split) {
                                tax_menu_row = only_modifiers[i].tax_information;
                                if (tax_menu_row) {
                                    let tax_information = JSON.parse(tax_menu_row);
                                    if (tax_information.length > 0) {
                                        for(let k in tax_information){
                                            if(tax_name.includes(tax_information[k].tax_field_name) && checkTaxApply(tax_information[k].tax_field_name)){
                                                let previous_value = tax_object["" + tax_information[k].tax_field_name];
                                                let current_value  = 0;
                                                if(tax_type==1){
                                                    current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                                }else{
                                                    current_value = (parseFloat(item_total_price) - (parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100)))).toFixed(ir_precision);
                                                }
                                                tax_object["" + tax_information[k].tax_field_name] = (parseFloat(previous_value)+ Number(current_value)).toFixed(ir_precision);
                                            }else{
                                                if(checkTaxApply(tax_information[k].tax_field_name)){
                                                tax_name.push(tax_information[k].tax_field_name);
                                                let current_value  = 0;
                                                if(tax_type==1){
                                                    current_value = parseFloat((parseFloat(parseFloat(tax_information[k].tax_field_percentage)*parseFloat(item_total_price))/parseFloat(100)));
                                                }else{
                                                    current_value = (parseFloat(item_total_price) - parseFloat(item_total_price)/(1+(tax_information[k].tax_field_percentage/100))).toFixed(ir_precision);
                                                }
                                                tax_object["" + tax_information[k].tax_field_name] = (Number(current_value)).toFixed(ir_precision);
                                              }
                                            }
                                        }
                                    }
                                }
                            }
                        }
  
                    });
  
                }
            });
        });
  
  
  
          return tax_object;
      }
  
    function get_all_item_discount() {
      let all_item_discount = 0;
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        let this_item_quantity = parseFloat(
          $(this).parent().parent().find(".third_column span").html()
        ).toFixed(ir_precision);
        let this_item_price = parseFloat(
          $(this).parent().parent().find(".second_column span").html()
        ).toFixed(ir_precision);
        let total_item_price_this_row = (
          parseFloat(this_item_quantity) * parseFloat(this_item_price)
        ).toFixed(ir_precision);
        let this_item_discount =
          $(this).parent().parent().find(".forth_column input").val() != ""
            ? $(this).parent().parent().find(".forth_column input").val()
            : 0;
        this_item_discount = get_particular_item_discount_amount(
          this_item_discount,
          total_item_price_this_row
        );
        $(this).parent().parent().find(".item_discount").html(this_item_discount);
        // let this_item_discount = (parseFloat(this_item_discount)+parseFloat($(this).parent().parent().find('.item_discount').html())).toFixed(ir_precision);
        all_item_discount = (
          parseFloat(all_item_discount) + parseFloat(this_item_discount)
        ).toFixed(ir_precision);
      });
  
      return all_item_discount;
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
    function get_updated_sub_total() {
      //get all items total price and add
      let all_item_total_price = 0;
      let all_item_total_vat_amount = 0;
      let this_item_discount = 0;
      $(".single_order .first_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        let this_item_quantity = parseFloat(
          $(this).parent().parent().find(".third_column span").html()
        ).toFixed(ir_precision);
        let this_item_price = parseFloat(
          $(this).parent().parent().find(".second_column span").html()
        ).toFixed(ir_precision);
        let this_item_vat_percentage = parseFloat(
          $(this).parent().parent().find(".item_vat").html()
        ).toFixed(ir_precision);
        all_item_total_price = (
          parseFloat(all_item_total_price) +
          parseFloat(this_item_quantity) * parseFloat(this_item_price)
        ).toFixed(ir_precision);
        let this_item_vat_amount = (
          (parseFloat($(this).html()) * parseFloat(this_item_vat_percentage)) /
          parseFloat(100)
        ).toFixed(ir_precision);
        all_item_total_vat_amount = (
          parseFloat(all_item_total_vat_amount) + parseFloat(this_item_vat_amount)
        ).toFixed(ir_precision);
  
        let this_item_discount = (
          parseFloat(this_item_discount) +
          parseFloat($(this).parent().parent().find(".item_discount").html())
        ).toFixed(ir_precision);
      });
  
      //get total discount
      let total_discount = $("#all_items_discount");
  
      //get discount on sub total
      let sub_total_discount =
        $("#sub_total_discount").val() == "" ? $("#sub_total_discount").val() : 0;
  
      //get sub total
      let sub_total = parseFloat($("#sub_total").html()).toFixed(ir_precision);
  
      //get sub total discount amount
      let sub_total_discount_amount = get_sub_total_discount_amount(
        $sub_total_discount,
        $sub_total
      );
  
      //get all modifiers price and add
      let all_modifiers_total_price = 0;
      $(".single_order .second_portion .fifth_column span").each(function (
        i,
        obj
      ) {
        all_modifiers_total_price = (
          parseFloat(all_modifiers_total_price) + parseFloat($(this).html())
        ).toFixed(ir_precision);
      });
      //set vat amount under sub total
      $("#all_items_vat").html(all_item_total_vat_amount);
  
      let total_of_all_items_and_modifiers =
        parseFloat(all_item_total_price) + parseFloat(all_modifiers_total_price);
      return total_of_all_items_and_modifiers;
    }
    function sub_total_get_amount($value) {}
    function get_sub_total_discount_amount(sub_total_discount, sub_total) {
      if (
        sub_total_discount.length > 0 &&
        sub_total_discount.substr(sub_total_discount.length - 1) == "%"
      ) {
        return (
          (parseFloat(sub_total) * parseFloat(sub_total_discount)) /
          parseFloat(100)
        ).toFixed(ir_precision);
      } else {
        return parseFloat(sub_total_discount).toFixed(ir_precision);
      }
    }
    function reset_on_modal_close_or_add_to_cart() {
      $("#item_modal").removeClass("active");
      $(".pos__modal__overlay").fadeOut(300);
      $("#item_quantity_modal").val("1");
      $("#modal_modifier_price_variable").html("0");
      $("#modal_modifiers_unit_price_variable").html("0");
      $("#modal_item_note").val("");
      $("#modal_discount").val("");
      $("#modal_item_price_variable_without_discount").html("0");
      $("#modal_item_vat_percentage").html("0");
      $("#modal_item_row").html("0");
      $("#modal_discount_amount").html("0");
    }
    function reset_on_modal_close_or_add_customer() {
      $("#customer_id_modal").val("");
      $("#customer_name_modal").val("");
      $("#customer_phone_modal").val("");
      $("#customer_email_modal").val("");
      $("#customer_dob_modal").val("");
      $("#customer_doa_modal").val("");
      $("#customer_delivery_address_modal").val("");
      $("#customer_gst_number_modal").val("");
      $(".same_or_diff_state_modal").val("0").change();
    }
  
    function clearFooterCartCalculation() {
      $("#sub_total_show").html(Number(0).toFixed(ir_precision));
      $("#sub_total").html(Number(0).toFixed(ir_precision));
      $("#total_item_discount").html(Number(0).toFixed(ir_precision));
      $("#discounted_sub_total_amount").html(Number(0).toFixed(ir_precision));
      $("#sub_total_discount").val("");
      $("#sub_total_discount1").val("");
      $("#sub_total_discount_amount").html(Number(0).toFixed(ir_precision));
      $("#all_items_vat").html(Number(0).toFixed(ir_precision));
      $("#all_items_discount").html(Number(0).toFixed(ir_precision));
      $("#total_items_in_cart").html("0");
      $("#total_items_in_cart_with_quantity").html("0");
      $("#total_payable").html(Number(0).toFixed(ir_precision));
      $("#show_vat_modal").html(Number(0).toFixed(ir_precision));
      $("#show_discount_amount").html(Number(0).toFixed(ir_precision));
      $("#show_charge_amount").html(Number(0).toFixed(ir_precision));
      $("#show_tips_amount").html(Number(0).toFixed(ir_precision));
      $("#tips_amount").val('');
      $("#self_order_table_person").val('');
      $("#delivery_charge").val('');
      $("#table_button").html("<i class='fal fa-table'></i> "+table_text);
      $("#table_button").removeClass("red_text");
      $("#tax_row_show").empty();
      $("#place_edit_order").html(place_order);
      $("#is_edit_click").val(1);
        //focus search field
        focusSearch();
        
  
      //set default order type
        let waiter_app_status = $("#waiter_app_status").val();
        let default_order_type = Number($("#default_order_type").val());
        let is_self_order = $("#is_self_order").val();
        let is_online_order = $("#is_online_order").val();
        if(is_self_order=="Yes"){
            default_order_type = 1;
        }
        if(waiter_app_status=="Yes"){
            default_order_type = 1;
        }
  
  
      $(".main_top").find("button").attr("data-selected", "unselected");
      if(default_order_type){
          $(".selected__btn_c").each(function() {
              let this_action = $(this);
              if ((this_action.attr("data-id") == "dine_in_button") && default_order_type==1) {
                  this_action.attr("data-selected", "selected");
              } else if ((this_action.attr("data-id") == "take_away_button") && default_order_type==2) {
                  this_action.attr("data-selected", "selected");
              } else if ((this_action.attr("data-id") == "delivery_button") && default_order_type==3) {
                  this_action.attr("data-selected", "selected");
              }
          });
      }
        let default_customer = Number($("#default_customer_hidden").val());
        let default_waiter = Number($("#default_waiter_hidden").val());
      //set default customer
          if(is_online_order!="Yes"){
              if(default_customer){
                  $("#walk_in_customer").val(default_customer).change();
              }else{
                  $("#walk_in_customer").val(1).change();
              }
          }
  
      //set default customer
        if(default_waiter){
            $("#select_waiter").val(default_waiter).change();
        }else{
            $("#select_waiter").val('').change();
        }
    }
      function add_sale_table(table_info,table_id,persons){
          $.ajax({
              url: base_url + "Sale/put_table_content",
              method: "POST",
              dataType:"json",
              async:false,
              data: {
                  table_info: table_info,
                  table_id: table_id,
                  persons: persons,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                  if(response){
  
                  }
              },
              error: function () {
  
              },
          });
          $("#table_id").val("");
          $("#hidden_table_name").val("");
          $("#table_button").html("<i class='fal fa-table'></i> "+table_text);
          $("#table_button").removeAttr("red_text");
      }
    function add_order_table(obj,sale_no_new){
      for(let key in obj){
          let obj_details = obj[key];
          let outlet_id_indexdb = $("#outlet_id_indexdb").val();
          let company_id_indexdb = $("#company_id_indexdb").val();
              if(Number(obj_details.table_id)){
                  let table_info = {
                      persons: obj_details.persons,
                      table_id: obj_details.table_id,
                      sale_no: sale_no_new,
                      outlet_id: outlet_id_indexdb,
                      company_id: company_id_indexdb,
                  };
                  let request = db.transaction("order_tables", "readwrite").objectStore("order_tables").add(table_info);
                  request.onsuccess = function(event) {
                      add_sale_table(JSON.stringify(table_info),obj_details.table_id,obj_details.persons);
                  };
  
                  request.onerror = function(event) {
                      alert("order table order insert problem!");
                  }
              }
        }
  
    }
      function removeLastAddedOrderTables(){
          //remove previous added table
          $(".old_added_table").remove();
          $(".new_book_to_table").remove();
      }
    function add_sale_by_ajax(update_sale_id,order_object,outlet_id='',company_id='',sale_no_new='',is_direct_sale='',action_type='',is_merge='') {
          //reset previous update sale id
        $("#update_sale_id").val("");
        let sale = JSON.parse(order_object);
        $("#place_edit_order").html(place_order);
          removeLastAddedOrderTables();
          let added_offline_status = 1;
        if(checkInternetConnection()){
            added_offline_status = 2;
        }
        let table_id = Number($("#table_id").val());
        if (sale.sale_date > getCurrentDate()) {
            if(!update_sale_id) {
                let order_info = {
                    order: order_object,
                    online_push: 0,
                    user_id: Number($("#user_id").val()),
                    added_offline_status: added_offline_status,
                    kot_print: 1,
                    merge_id: is_merge,
                    table_id: table_id,
                    is_offline_system:($("#is_offline_system").val()),
                    is_send_sms:getSmsSeedStatus(),
                    outlet_id: outlet_id,
                    company_id: company_id,
                    sale_no: sale_no_new,
                    pre_or_post_payment: pre_or_post_payment,
                    is_running: 1,
                    is_invoice: 1,
                };
  
                let request = db.transaction("future_sales", "readwrite").objectStore("future_sales").add(order_info);
  
                request.onsuccess = function(event) {
                    $("#open_invoice_date_hidden").val(getCurrentDate());
                    if (waiter_app_status == "Yes") {
                        $("#show_running_order").click();
                    }
  
                    $(".datepicker_custom").datepicker({
                        autoclose: true,
                        format: "yyyy-mm-dd",
                        startDate: "0",
                        todayHighlight: true,
                    }).datepicker("update", getCurrentDate());
                 
                    //add order tables if available any
                    add_order_table(sale.orders_table,sale_no_new);
                    clearFooterCartCalculation();
                    displayOrderList();
                    setTimeout(function(){
                        createAnimation(sale_no_new);
                    }, 1000);
                };
  
                request.onerror = function(event) {
                    alert("Unable to add data\r\nOrder is aready exist in your database!");
                }
            } else {
  
                let objectStore = db.transaction(['future_sales'], "readwrite").objectStore("future_sales");
  
                objectStore.openCursor().onsuccess = function(event) {
                    let cursor = event.target.result;
                    if (cursor) {
                        if(cursor.value.sales_id == sale_id) {
                            let updateData = cursor.value;
                            updateData.order = order_object; 
                            updateData.online_push = 0;
                            updateData.kot_print = 1;
                            if(table_id){
                              updateData.table_id = table_id;
                            }
                            updateData.is_offline_system = ($("#is_offline_system").val());
                            let request = cursor.update(updateData);
                            request.onsuccess = function() {
                            }
                            //add order tables if available any
                            add_order_table(sale.orders_table,sale_no_new);
                            clearFooterCartCalculation();
                            displayOrderList();
                            setTimeout(function(){
                                createAnimation(sale_no_new);
                            }, 1000);
                        }
                        cursor.continue();
                    }
                }
            }
        } else {
            if(!update_sale_id) {
                let order_info = {
                    order: order_object,
                    online_push: 0,
                    user_id: Number($("#user_id").val()),
                    added_offline_status: added_offline_status,
                    kot_print: 1,
                    merge_id: is_merge,
                    table_id: table_id,
                    outlet_id: outlet_id,
                    company_id: company_id,
                    sale_no: sale_no_new,
                    pre_or_post_payment: pre_or_post_payment,
                    is_running: 1,
                    is_invoice: 1,
                };
                let request = db.transaction("sales", "readwrite").objectStore("sales").add(order_info);
                request.onsuccess = function(event) {
                    $("#open_invoice_date_hidden").val(getCurrentDate());
                    if (waiter_app_status == "Yes") {
                        $("#show_running_order").click();
                    }
  
                    $(".datepicker_custom").datepicker({
                        autoclose: true,
                        format: "yyyy-mm-dd",
                        startDate: "0",
                        todayHighlight: true,
                    }).datepicker("update", getCurrentDate());
  
                  
                    //add order tables if available any
                    add_order_table(sale.orders_table,sale_no_new);
  
                    clearFooterCartCalculation();
                    displayOrderList();
                    
                    $("#order_"+get_plan_string(sale_no_new)).attr('data-selected',"selected");
                    $("#last_future_sale_id").val(sale_no_new);
  
                    setTimeout(function(){
                        let is_direct_sale_check = Number($("#is_direct_sale_check").val());
                        if(action_type==2 && pre_or_post_payment!=2){
                            $("#order_"+get_plan_string(sale_no_new)).attr('data-selected',"selected");
                        }else{
                            if(pre_or_post_payment==2 || is_direct_sale_check==1){
                                $("#order_"+get_plan_string(sale_no_new)).attr('data-selected',"selected");
                                $("#create_invoice_and_close").click();
                                $(".invoice_btn_class").eq(1).click();
                            }
                        }
  
                    }, 1000);
  
                    setTimeout(function(){
                        createAnimation(sale_no_new);
                    }, 1100);
  
                };
  
                request.onerror = function(event) {
                    alert("Unable to add data\r\nOrder is already exist in your database!");
                }
            } else {
                let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
                objectStore.openCursor().onsuccess = function(event) {
                    let cursor = event.target.result;
  
                    if (cursor) {
  
                        if(cursor.value.sale_no == sale_no_new) {
                            let updateData = cursor.value;
                            updateData.order = order_object; 
                            updateData.online_push = 0;
                            updateData.kot_print =  1;
                            if(table_id){
                              updateData.table_id = table_id;
                            }
                            updateData.is_offline_system = ($("#is_offline_system").val());
                            let request = cursor.update(updateData);
  
                            request.onsuccess = function() {
                            }
                            //add order tables if available any
                            add_order_table(sale.orders_table,sale_no_new);
                            clearFooterCartCalculation();
                            displayOrderList();
  
                            setTimeout(function(){
                                createAnimation(sale_no_new);
                            }, 1000);
                        }
  
                        cursor.continue();
                    }
                }
            }
        }
        //clear table
        $(".order_table_holder .order_holder").empty();
    }
    function add_sale_by_ajax_kot_print(update_sale_id,order_object,outlet_id='',company_id='',sale_no_new='',is_direct_sale='') {
          //reset previous update sale id
        let arr_kot_items = {};
        if (localStorage.getItem('kot_invoice') !== null) {
            arr_kot_items = JSON.parse(localStorage['kot_invoice']);
        }

        if(!update_sale_id) {
            let order_no_outlet	 = sale_no_new+''+outlet_id;
            arr_kot_items[order_no_outlet] = order_object;
            localStorage['kot_invoice'] = JSON.stringify(arr_kot_items);
        }
    }
    function updateForMerge(sale_id,merge_id){
        let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
        objectStore.openCursor().onsuccess = function(event) {
            let cursor = event.target.result;
    
            if (cursor) {
    
                if(cursor.value.sales_id == sale_id) {
                    let updateData = cursor.value;
                     updateData.merge_id = merge_id;
                    let request = cursor.update(updateData);
                    request.onsuccess = function() {
                    }
                }
    
                cursor.continue();
            }
        }
      }
    function add_hold_by_ajax(order_object, hold_number) {
      $.ajax({
        url: base_url + "Sale/add_hold_by_ajax",
        method: "POST",
        data: {
          order: order_object,
          hold_number: hold_number,
          csrf_irestoraplus: csrf_value_,
        },
        success: function (response) {
          $("#generate_sale_hold_modal").removeClass("active");
          $(".pos__modal__overlay").fadeOut(300);
  
          $(".order_holder").empty();
          clearFooterCartCalculation();
          $("#hold_generate_input").val("");
          $("#open_invoice_date_hidden").val(getCurrentDate());
  
          $(".datepicker_custom")
            .datepicker({
              autoclose: true,
              format: "yyyy-mm-dd",
              startDate: "0",
              todayHighlight: true,
            })
            .datepicker("update", getCurrentDate());
  
         
          $(".main_top").find("button").attr("data-selected", "unselected");
          $("#table_button").attr("disabled", false);
          $(".single_table_div[data-table-checked=checked]").attr(
            "data-table-checked",
            "unchecked"
          );
          reset_customer_waiter_to_default();
        },
        error: function () {
          alert(a_error);
        },
      });
    }
    function set_new_orders_to_view(sale_no) {
      $.ajax({
        url: base_url + "Sale/get_new_orders_ajax",
        method: "GET",
        success: function (response) {
          response = JSON.parse(response);
          let order_list_left = "";
          let i = 1;
          for (let key in response) {
            let width = 100;
            let total_kitchen_type_items = response[key].total_kitchen_type_items;
            let total_kitchen_type_started_cooking_items =
              response[key].total_kitchen_type_started_cooking_items;
            let total_kitchen_type_done_items =
              response[key].total_kitchen_type_done_items;
            let splitted_width = (
              parseFloat(width) / parseFloat(total_kitchen_type_items)
            ).toFixed(ir_precision);
            let percentage_for_started_cooking = (
              parseFloat(splitted_width) *
              parseFloat(total_kitchen_type_started_cooking_items)
            ).toFixed(ir_precision);
            let percentage_for_done_cooking = (
              parseFloat(splitted_width) *
              parseFloat(total_kitchen_type_done_items)
            ).toFixed(ir_precision);
            if (i == 1) {
              order_list_left +=
                '<div data-started-cooking="' +
                total_kitchen_type_started_cooking_items +
                '" data-done-cooking="' +
                total_kitchen_type_done_items +
                '" class="single_order fix txt_5 new_order_' +
                response[key].sales_id +
                '" data-selected="unselected" id="order_' +
                response[key].sales_id +
                '">';
            } else {
              order_list_left +=
                '<div data-started-cooking="' +
                total_kitchen_type_started_cooking_items +
                '" data-done-cooking="' +
                total_kitchen_type_done_items +
                '" class="single_order fix new_order_' +
                response[key].sales_id +
                '" data-selected="unselected" id="order_' +
                response[key].sales_id +
                '">';
            }
            order_list_left += '<div class="inside_single_order_container fix">';
            order_list_left +=
              '<div class="single_order_content_holder_inside fix">';
            let order_name = "";
            if (response[key].order_type == "1") {
              order_name = response[key].sale_no;
            } else if (response[key].order_type == "2") {
              order_name = response[key].sale_no;
            } else if (response[key].order_type == "3") {
              order_name = response[key].sale_no;
            }
         
            let table_name = "";
            let waiter_name =
              response[key].waiter_name != null ? response[key].waiter_name : "";
            let customer_name =
              response[key].customer_name != null
                ? response[key].customer_name
                : "";
            let minute = response[key].minute_difference;
            let second = response[key].second_difference;
  
            let tables_booked = "";
            if (response[key].tables_booked.length > 0) {
              let w = 1;
              for (let k in response[key].tables_booked) {
                let single_table = response[key].tables_booked[k];
                if (w == response[key].tables_booked.length) {
                  tables_booked += single_table.table_name;
                } else {
                  tables_booked += single_table.table_name + ", ";
                }
                w++;
              }
            } else {
              tables_booked = "None";
            }
  
            order_list_left +=
              '<span id="open_orders_order_status_' +
              response[key].sales_id +
              '" class="ir_display_none">' +
              response[key].order_status +
              '</span> <p><span class="running_order_customer_name">Cust: ' +
              customer_name +
              '</span></p> <i class="far fa-chevron-right running_order_right_arrow" id="running_order_right_arrow_' +
              response[key].sales_id +
              '"></i>';
            order_list_left +=
              '<p>Table: <span class="running_order_table_name">' +
              tables_booked +
              "</span></p>";
            order_list_left +=
              '<p>Waiter: <span class="running_order_waiter_name">' +
              waiter_name +
              "</span></p>";
            order_list_left +=
              '<p class="oder_list_class txt_1">Order: <span class="running_order_order_number">' +
              order_name +
              "</span></p>";
            order_list_left += "</div>";
            order_list_left += '<div class="order_condition">';
            order_list_left +=
              '<p  class="txt_4">Time Count: <span id="order_minute_count_' +
              response[key].sales_id +
              '">' +
              minute +
              '</span>:<span id="order_second_count_' +
              response[key].sales_id +
              '">' +
              second +
              "</span> M</p>";
            order_list_left += "</div>";
            order_list_left += "</div>";
            order_list_left += "</div>";
            i++;
          }
          $("#order_details_holder").html(order_list_left);
          $(".order_table_holder .order_holder").empty();
          clearFooterCartCalculation();
          let waiter_app_status = $("#waiter_app_status").val();
          if (waiter_app_status == "No") {
            $(".main_top").find("button").attr("data-selected", "unselected");
          }
          $("#table_button").attr("disabled", false);
          $(".single_table_div[data-table-checked=checked]").attr(
            "data-table-checked",
            "unchecked"
          );
          reset_customer_waiter_to_default();
  
          reset_table_modal();
          createAnimation(sale_no);
        },
        error: function () {
          alert(a_error);
        },
      });
    }
  
    function set_new_orders_to_view_for_interval() {
        displayOrderList();
    }
    function reset_customer_waiter_to_default() {
      let cid = $("#default_customer_hidden").val();
      let wid = $("#default_waiter_hidden").val();
  
      $("#walk_in_customer").val(cid).trigger("change");
      $("#walk_in_customer1").val(cid).trigger("change");
      if (waiter_app_status != "Yes") {
        if (wid) {
          $("#select_waiter").val(wid).trigger("change");
          $("#select_waiter1").val(wid).trigger("change");
        } else {
          $("#select_waiter").val("").trigger("change");
          $("#select_waiter1").val("").trigger("change");
        }
      }
      $("#place_edit_order").html(place_order);
    }
    function print_invoice_and_close(
      sale_no,
      payment_method_type,
      invoice_create_type,
      paid_amount,
      due_amount,sub_total_discount_finalize
    ) {

        close_order(sale_no, payment_method_type, paid_amount, due_amount,sub_total_discount_finalize);
      
        setTimeout(function () {
            $("#order_" + get_plan_string(sale_no)).remove();
            $('#refresh_order').click();
            displayOrderList();
            print_invoice(sale_no);
        }, 400);
    }
    function get_all_hold_sales() {
      $.ajax({
        url: base_url + "Sale/get_all_holds_ajax",
        method: "GET",
        success: function (response) {
          let orders = JSON.parse(response);
  
          let held_orders = "";
          for (let key in orders) {
            let tables_booked = "";
            if (orders[key].tables_booked.length > 0) {
              let w = 1;
              for (let k in orders[key].tables_booked) {
                let single_table = orders[key].tables_booked[k];
                if (w == orders[key].tables_booked.length) {
                  tables_booked += single_table.table_name;
                } else {
                  tables_booked += single_table.table_name + ", ";
                }
                w++;
              }
            } else {
              tables_booked = "None";
            }
            let phone_text_ = "";
            if (orders[key].phone) {
              phone_text_ = " (" + orders[key].phone + ")";
            }
  
            let customer_name =
              orders[key].customer_name == null || orders[key].customer_name == ""
                ? "&nbsp;"
                : orders[key].customer_name;
            let table_name = tables_booked;
            held_orders +=
              '<div class="single_hold_sale fix" id="hold_' +
              orders[key].id +
              '" data-selected="unselected">';
            held_orders +=
              '<div class="first_column column fix">' +
              orders[key].hold_no +
              "</div>";
            held_orders +=
              '<div class="second_column column fix">' +
              customer_name +
              phone_text_ +
              "</div>";
            held_orders +=
              '<div class="third_column column fix">' + table_name + "</div>";
            held_orders += "</div>";
          }
          $(".hold_list_holder .detail_holder ").empty();
          $(".hold_list_holder .detail_holder ").prepend(held_orders);
        },
        error: function () {
          alert(a_error);
        },
      });
    } 
    function close_order(sale_no, payment_method_type, paid_amount, due_amount,sub_total_discount_finalize) {
  
        let payment_info = "[";
  
        if ($(".payment_list_counter").length > 0) {
            let k = 1;
            $(".payment_list_counter").each(function (i, obj) {
                let payment_name = $(this).attr("data-payment_name");
                let usage_point = $(this).attr("data-usage_point");
                let payment_id = $(this).attr("data-payment_id");
                let amount = $(this).attr("data-amount");
                payment_info +=
                    '{"payment_id":"' +
                    payment_id +
                    '","payment_name":"' + payment_name +
                    '","usage_point":"' + usage_point +
                    '","amount":"' +
                    amount +
                    '"';
                payment_info +=
                    k == $(".payment_list_counter").length ? "}" : "},";
                k++;
            });
        }
        payment_info += "]";
  
         sub_total_discount_finalize = Number(sub_total_discount_finalize);
  
        let payment_object = JSON.stringify(payment_info);
        paid_amount = $("#finalize_total_paid").html();
        due_amount = $("#finalize_total_due").html();
  
        let is_multi_currency = $("#is_multi_currency").val();
        let multi_currency = $("#multi_currency").val();
        let multi_currency_rate = $("#multi_currency_rate").val();
        let multi_currency_amount = $("#multi_currency_amount").val();
        let token_number = $("#token_number").val();
        let res = getSelectedOrderDetails(sale_no).then(function(order_info){
            let order_object = JSON.parse(order_info);
  
            let sub_total_discount_type = "percentage";
            let total_payable = order_object.total_payable;
            let sub_total_discount_amount = order_object.sub_total_discount_amount;
            let total_discount_amount = order_object.total_discount_amount;
  
            if(sub_total_discount_finalize){
                sub_total_discount_type = "fixed";
                total_payable = Number(order_object.total_payable) - sub_total_discount_finalize;
                sub_total_discount_amount = Number(order_object.sub_total_discount_amount) + sub_total_discount_finalize;
                total_discount_amount = Number(order_object.total_discount_amount) + sub_total_discount_finalize;
            }
           
            order_object.order_status = 3;
            order_object.payment_method_type = payment_method_type;
            order_object.paid_amount = paid_amount;
            order_object.due_amount = due_amount;
            order_object.is_multi_currency = is_multi_currency;
            order_object.multi_currency = multi_currency;
            order_object.multi_currency_rate = multi_currency_rate;
            order_object.multi_currency_amount = multi_currency_amount;
            order_object.payment_object = payment_object;
            order_object.sub_total_discount_type = sub_total_discount_type;
            order_object.total_payable = total_payable;
            order_object.sub_total_discount_amount = sub_total_discount_amount;
            order_object.total_discount_amount = total_discount_amount;
            order_object.token_number = token_number;
            order_object.paid_date_time = getDateTime()[0];
            order_object.send_sms_status = getSmsSeedStatus();
  
            let hidden_given_amount = $("#hidden_given_amount").val();
            let hidden_change_amount = $("#hidden_change_amount").val();
  
            order_object.hidden_given_amount = hidden_given_amount;
            order_object.hidden_change_amount = hidden_change_amount;
  
            add_to_recent_sale_by_ajax(JSON.stringify(order_object), '',sale_no);
            delete_from_sale(sale_no);
        });
    }
    function print_invoice(sale_no) {
      let newWindow = "";
      let print_type_invoice = $(".print_type_invoice").val();
        if (print_type_invoice == "web_browser_popup") {
            getSelectedOrderDetailsRecentSale(sale_no).then(function(order_info){
                call_print_invoice(order_info,inv_qr_code_enable_status);
            });
          }else if (print_type_invoice == "direct_print"){
            $("#finalize_order_modal").removeClass("active");
            $(".pos__modal__overlay").fadeOut(300);
            getSelectedOrderDetailsRecentSale(sale_no).then(function(order_info){
                if(checkInternetConnection()){
                    $.ajax({
                        url: base_url + "Authentication/printSaleByAjax",
                        method: "post",
                        dataType: "json",
                        data: {
                            sale_id: 1,
                            data_order: order_info,
                        },
                        success: function (data) {
                            if (data.printer_server_url) {
                                $.ajax({
                                    url:
                                    data.printer_server_url +
                                    "print_server/irestora_printer_server.php",
                                    method: "post",
                                    dataType: "json",
                                    data: {
                                        content_data: JSON.stringify(data.content_data),print_type:data.print_type,
                                    },
                                    success: function (data) {},
                                    error: function () {},
                                });
                            }
                        },
                        error: function () {},
                    });
                }else{
                    call_print_invoice(order_info,inv_qr_code_enable_status);
                }
            });
  
        }
    }
    function print_invoiceResent(sale_no) {
      let newWindow = "";
      let print_type_invoice = $(".print_type_invoice").val();
        if (print_type_invoice == "web_browser_popup") {
           getSelectedOrderDetailsRecentSale(sale_no).then(function(order_info){
                call_print_invoice(order_info,inv_qr_code_enable_status);
            });
        } else {
            $("#finalize_order_modal").removeClass("active");
            $(".pos__modal__overlay").fadeOut(300);
            getSelectedOrderDetailsRecentSale(sale_no).then(function(order_info){
                if(checkInternetConnection()){
                    $.ajax({
                        url: base_url + "Authentication/printSaleByAjax",
                        method: "post",
                        dataType: "json",
                        data: {
                            sale_id: 1,
                            data_order: order_info,
                        },
                        success: function (data) {
                            if (data.printer_server_url) {
                                $.ajax({
                                    url:
                                    data.printer_server_url +
                                    "print_server/irestora_printer_server.php",
                                    method: "post",
                                    dataType: "json",
                                    data: {
                                        content_data: JSON.stringify(data.content_data),print_type:data.print_type,
                                    },
                                    success: function (data) {},
                                    error: function () {},
                                });
                            }
                        },
                        error: function () {},
                    });
                }else{
                    call_print_invoice(order_info,inv_qr_code_enable_status);
                }
            });
  
        }
    }
    function get_details_of_a_particular_hold(hold_id, this_action) {
      $.ajax({
        url: base_url + "Sale/get_single_hold_info_by_ajax",
        method: "POST",
        data: {
          hold_id: hold_id,
          csrf_irestoraplus: csrf_value_,
        },
        success: function (response) {
          response = JSON.parse(response);
          $("#open_invoice_date_hidden").val(response.sale_date);
          $(".datepicker_custom")
            .datepicker({
              autoclose: true,
              format: "yyyy-mm-dd",
              startDate: "0",
              todayHighlight: true,
            })
            .datepicker("update", response.sale_date);
  
          hold_id = response.id;
          let draw_table_for_order = "";
  
          for (let key in response.items) {
            //construct div
            let this_item = response.items[key];
  
            let selected_modifiers = "";
            let selected_modifiers_id = "";
            let selected_modifiers_price = "";
            let modifiers_price = 0;
            let total_modifier = this_item.modifiers.length;
            let i = 1;
            let item_id = this_item.food_menu_id;
            let draw_table_for_order_tmp_modifier_tax = "";
            for (let mod_key in this_item.modifiers) {
              let this_modifier = this_item.modifiers[mod_key];
              let modifier_id_custom = this_modifier.modifier_id;
              //get selected modifiers
              if (i == total_modifier) {
                selected_modifiers += this_modifier.name;
                selected_modifiers_id += this_modifier.modifier_id;
                selected_modifiers_price += this_modifier.modifier_price;
                modifiers_price = (
                  parseFloat(modifiers_price) +
                  parseFloat(this_modifier.modifier_price)
                ).toFixed(ir_precision);
              } else {
                selected_modifiers += this_modifier.name + ", ";
                selected_modifiers_id += this_modifier.modifier_id + ",";
                selected_modifiers_price += this_modifier.modifier_price + ",";
                modifiers_price = (
                  parseFloat(modifiers_price) +
                  parseFloat(this_modifier.modifier_price)
                ).toFixed(ir_precision);
              }
              let tax_information = "";
              // iterate over each item in the array
              tax_information = this_modifier.menu_taxes;
              tax_information = IsJsonString(tax_information)
                ? JSON.parse(tax_information)
                : "";
              draw_table_for_order_tmp_modifier_tax +=
                '<span class="item_vat_modifier ir_display_none item_vat_modifier_' +
                item_id +
                '" data-item_id="' +
                item_id +
                '"  data-modifier_price="' +
                this_modifier.modifier_price +
                '" data-modifier_id="' +
                modifier_id_custom +
                '" id="item_vat_percentage_table' +
                item_id +
                "" +
                modifier_id_custom +
                '">' +
                JSON.stringify(tax_information) +
                "</span>";
              i++;
            }
  
            draw_table_for_order +=
              '<div class="single_order fix" id="order_for_item_' +
              this_item.food_menu_id +
              '">';
            draw_table_for_order += '<div class="first_portion">';
            draw_table_for_order +=
              '<span class="item_vat ir_display_none" id="item_vat_percentage_table' +
              this_item.food_menu_id +
              '">' +
              this_item.menu_taxes +
              "</span>";
            draw_table_for_order +=
              '<span class="item_discount ir_display_none" id="item_discount_table' +
              this_item.food_menu_id +
              '">' +
              this_item.discount_amount +
              "</span>";
            draw_table_for_order +=
              '<span class="item_price_without_discount ir_display_none" id="item_price_without_discount_' +
              this_item.food_menu_id +
              '">' +
              this_item.menu_price_without_discount +
              "</span>";
            draw_table_for_order +=
              '<div class="single_order_column first_column cart_item_counter"  data-id="'+item_id+'"><i class="fas fa-pencil-alt edit_item txt_5" id="edit_item_' +
              this_item.food_menu_id +
              '"></i> <span id="item_name_table_' +
              this_item.food_menu_id +
              '">' +
              this_item.menu_name +
              "</span></div>";
            draw_table_for_order +=
              '<div class="single_order_column second_column">' +
              currency +
              ' <span id="item_price_table_' +
              this_item.food_menu_id +
              '">' +
              this_item.menu_unit_price +
              "</span></div>";
            draw_table_for_order +=
              '<div class="single_order_column third_column"><i class="fal fa-minus decrease_item_table txt_5" id="decrease_item_table_' +
              this_item.food_menu_id +
              '"></i> <span class="qty_item_custom" id="item_quantity_table_' +
              this_item.food_menu_id +
              '">' +
              this_item.qty +
              '</span> <i  class="fal fa-plus increase_item_table txt_5" id="increase_item_table_' +
              this_item.food_menu_id +
              '"></i></div>';
            draw_table_for_order +=
              '<div class="single_order_column forth_column"><input type="" name="" placeholder="Amt or %" class="discount_cart_input" id="percentage_table_' +
              this_item.food_menu_id +
              '" value="' +
              this_item.menu_discount_value +
              '" disabled></div>';
            draw_table_for_order +=
              '<div class="single_order_column fifth_column">' +
              currency +
              ' <span id="item_total_price_table_' +
              this_item.food_menu_id +
              '">' +
              this_item.menu_price_with_discount +
              "</span><i data-id='" +
              this_item.food_menu_id +
              "' class='fal fa-times removeCartItem'></i></div>";
            draw_table_for_order += "</div>";
            if (selected_modifiers != "") {
              draw_table_for_order += '<div class="second_portion fix">';
              draw_table_for_order += draw_table_for_order_tmp_modifier_tax;
              draw_table_for_order +=
                '<span id="item_modifiers_id_table_' +
                this_item.food_menu_id +
                '" class="ir_display_none">' +
                selected_modifiers_id +
                "</span>";
              draw_table_for_order +=
                '<span id="item_modifiers_price_table_' +
                this_item.food_menu_id +
                '" class="ir_display_none">' +
                selected_modifiers_price +
                "</span>";
              draw_table_for_order +=
                '<div class="single_order_column first_column cart_item_counter"  data-id="'+item_id+'"><span class="modifier_txt_custom" id="item_modifiers_table_' +
                this_item.food_menu_id +
                '">' +
                selected_modifiers +
                "</span></div>";
              draw_table_for_order +=
                '<div class="single_order_column fifth_column fix">' +
                currency +
                ' <span id="item_modifiers_price_table_' +
                this_item.food_menu_id +
                '">' +
                modifiers_price +
                "</span></div>";
              draw_table_for_order += "</div>";
            }
              if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
              draw_table_for_order += '<div class="third_portion fix">';
              draw_table_for_order +=
                '<div class="single_order_column first_column cart_item_counter  modifier_txt_custom"  data-id="'+item_id+'">' +
                note_txt +
                ': <span id="item_note_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.item_note +
                "</span></div>";
              draw_table_for_order += "</div>";
            }
  
            draw_table_for_order += "</div>";
          }
          //add to top
          $(".order_holder").prepend(draw_table_for_order);
          $("#total_items_in_cart").html(response.total_items);
          $("#sub_total_show").html(response.sub_total);
          $("#sub_total").html(response.sub_total);
          $("#total_item_discount").html(response.total_item_discount_amount);
          $("#discounted_sub_total_amount").html(
            response.sub_total_discount_amount
          );
          let html_modal = "";
          $.each(JSON.parse(response.sale_vat_objects), function (key, value) {
            html_modal +=
              "<tr class='tax_field' data-tax_field_id='" +
              value.tax_field_id +
              "'  data-tax_field_type='" +
              value.tax_field_type +
              "'  data-tax_field_amount='" +
              value.tax_field_amount +
              "'>\n" +
              "                            <td>" +
              value.tax_field_type +
              "</td>\n" +
              "                            <td>" +
              Number(value.tax_field_amount).toFixed(ir_precision) +
              "</td>\n" +
              "                        </tr>";
          });
          $("#tax_row_show").html(html_modal);
  
          $.each(JSON.parse(response.tables_booked), function (key_t, value_t) {
            let table_book_row = "";
            table_book_row +=
              '<div class="single_row fix new_book_to_table" id="new_order_table_' +
              value_t.table_id +
              '">';
            table_book_row +=
              '<div class="floatleft fix column first_column">New</div>';
            table_book_row +=
              '<div class="floatleft fix column second_column">-</div>';
            table_book_row +=
              '<div class="floatleft fix column third_column person_tbl_' +
              value_t.table_id +
              '">' +
              value_t.persons +
              "</div>";
            table_book_row +=
              '<div class="floatleft fix column forth_column"><i class="fas fa-trash-alt remove_new_order_row_icon" id="single_row_table_delete_' +
              value_t.table_id +
              '"></i></div>';
            table_book_row += "</div>";
            $("#single_table_order_details_top_" + value_t.table_id).append(
              $(table_book_row)
            );
          });
  
          $("#sub_total_discount").val(response.sub_total_discount_value);
          $("#sub_total_discount_amount").html(response.sub_total_with_discount);
          $("#all_items_vat").html(response.vat);
          $("#show_vat_modal").html(response.vat);
          $("#all_items_discount").html(response.total_discount_amount);
          if (Number(response.delivery_charge_actual_charge)) {
            $("#delivery_charge").val(response.delivery_charge);
          } else {
            $("#delivery_charge").val((0).toFixed(ir_precision));
          }
          if (Number(response.tips_amount_actual_charge)) {
            $("#tips_amount").val(response.tips_amount);
          } else {
            $("#tips_amount").val((0).toFixed(ir_precision));
          }
  
          $("#total_payable").html(response.total_payable);
          $("#charge_type").val(response.charge_type).change();
          //do calculation on table
          do_addition_of_item_and_modifiers_price();
  
          $("#hold_waiter_id").html("");
          $("#hold_waiter_name").html("");
          $("#hold_customer_id").html("");
          $("#hold_customer_name").html("");
          $("#hold_table_id").html("");
          $("#hold_table_name").html("");
          $("#hold_order_type").html("");
          $("#hold_order_type_id").html("");
          $(".item_modifier_details .modifier_item_details_holder").empty();
          $("#total_items_in_cart_hold").html("0");
          $("#sub_total_show_hold").html(Number(0).toFixed(ir_precision));
          $("#sub_total_hold").html(Number(0).toFixed(ir_precision));
          $("#total_item_discount_hold").html(Number(0).toFixed(ir_precision));
          $("#discounted_sub_total_amount_hold").html(
            Number(0).toFixed(ir_precision)
          );
          $("#sub_total_discount_hold").html("");
          $("#sub_total_discount_amount_hold").html(
            Number(0).toFixed(ir_precision)
          );
          $("#all_items_vat_hold").html(Number(0).toFixed(ir_precision));
          $("#all_items_discount_hold").html(Number(0).toFixed(ir_precision));
          $("#delivery_charge_hold").html(Number(0).toFixed(ir_precision));
          $("#tips_amount_hold").html(Number(0).toFixed(ir_precision));
          $("#total_payable_hold").html(Number(0).toFixed(ir_precision));
          this_action
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .removeClass("active")
            .addClass("inActive");
          setTimeout(function () {
            $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
  
          if (
            response.customer_id == "" ||
            response.customer_id == 0 ||
            response.customer_id == null
          ) {
            $("#walk_in_customer").val(1).trigger("change");
            $("#walk_in_customer1").val(1).trigger("change");
          } else {
            $("#walk_in_customer").val(response.customer_id).trigger("change");
            $("#walk_in_customer1").val(response.customer_id).trigger("change");
          }
  
          if (
            response.waiter_id == "" ||
            response.waiter_id == 0 ||
            response.waiter_id == null
          ) {
            if (waiter_app_status != "Yes") {
              $("#select_waiter").val("").trigger("change");
            }
          } else {
            if (response.waiter_id) {
              if (waiter_app_status != "Yes") {
                $("#select_waiter").val(response.waiter_id).trigger("change");
              }
            } else {
              if (waiter_app_status != "Yes") {
                $("#select_waiter").val("").trigger("change");
              }
            }
          }
          if (response.order_type == "1") {
            $(".main_top").find("button").attr("data-selected", "unselected");
            
            $(".dine_in_button").attr("data-selected", "selected");
  
            $("#table_button").attr("disabled", false);
          } else if (response.order_type == "2") {
            $(".main_top").find("button").attr("data-selected", "unselected");
            
            $(".take_away_button").attr("data-selected", "selected");
  
            $("#table_button").attr("disabled", false);
          } else if (response.order_type == "3") {
            $(".main_top").find("button").attr("data-selected", "unselected");
            
            $(".delivery_button").attr("data-selected", "selected");
  
            $("#table_button").attr("disabled", true);
            $(".single_table_div[data-table-checked=checked]").attr(
              "data-table-checked",
              "unchecked"
            );
            $(".single_table_div[data-table-checked=checked]").css(
              "background-color",
              "#ffffff"
            );
          } else {
            $(".main_top").find("button").attr("data-selected", "unselected");
          }
          if (response.table_id > 0) {
            $(".single_table_div").attr("data-table-checked", "unchecked");
            $(".single_table_div").css("background-color", "#ffffff");
            if (
              $("#single_table_" + response.table_id).attr(
                "data-table-checked"
              ) != "busy"
            ) {
              $("#single_table_" + response.table_id).attr(
                "data-table-checked",
                "checked"
              );
              $("#single_table_" + response.table_id).css(
                "background-color",
                "#b6d6f6"
              );
            }
          }
        },
        error: function () {
          alert(a_error);
        },
      });
    }
 
    function get_details_of_a_particular_order_for_modal(sale_no) {
          let res = getSelectedOrderDetails(sale_no).then(function(data){
              let response = jQuery.parseJSON(data);
              console.log(response)
              if(response !== null) {
                  let order_type = "";
                  let order_type_id = 0;
                  let order_number = "";
                  $("#order_details_waiter_id").html(response.waiter_id);
                  $("#order_details_waiter_name").html(response.waiter_name);
                  $("#order_details_customer_id").html(response.customer_id);
                  $("#order_details_customer_name").html(response.customer_name);
                  $("#order_details_table_id").html(response.table_id);
                  $("#order_details_table_name").html((response.orders_table_text!=undefined && response.orders_table_text?response.orders_table_text:'None'));
                  $("#open_invoice_date_hidden").val(response.sale_date);
                  $(".datepicker_custom")
                      .datepicker({
                          autoclose: true,
                          format: "yyyy-mm-dd",
                          startDate: "0",
                          todayHighlight: true,
                      })
                      .datepicker("update", response.sale_date);
  
                  if (response.order_type == 1) {
                      order_type = "Dine In";
                      order_type_id = 1;
                      order_number = response.sale_no;
                  } else if (response.order_type == 2) {
                      order_type = "Take Away";
                      order_type_id = 2;
                      order_number = response.sale_no;
                  } else if (response.order_type == 3) {
                      order_type = "Delivery";
                      order_type_id = 3;
                      order_number = response.sale_no;
                  }
                  $("#order_details_type").html(order_type);
                  $("#order_details_type_id").html(order_type_id);
                  $("#order_details_order_number").html(order_number);
                  $("#last_future_sale_id").val(sale_no);
                  let draw_table_for_order_details = "";
  
                  for (let key in response.items) {
                      //construct div
                      let this_item = response.items[key];
  
                      let selected_modifiers = "";
                      let selected_modifiers_id = "";
                      let selected_modifiers_price = "";
                      let modifiers_price = 0;
                      let total_modifier = 0;
                      if(this_item.modifiers_id!=''){
                          total_modifier = (this_item.modifiers_id.split(',')).length;
                      }
  
                      let item_id = this_item.food_menu_id;
  
                      let draw_table_for_order_tmp_modifier_tax = "";
                      let modifier_ids_custom = [];
                      let modifier_names_custom = [];
                      let modifier_prices_custom = [];
                      if(total_modifier){
                          modifier_ids_custom = this_item.modifiers_id.split(',');
                          modifier_names_custom = this_item.modifiers_name.split(',');
                          modifier_prices_custom = this_item.modifiers_price.split(',');
                      }
                      let discount_value =
                          this_item.menu_discount_value != ""
                              ? pOrAmount(this_item.menu_discount_value)
                              : parseFloat(0).toFixed(ir_precision);
                      draw_table_for_order_details +=
                          '<div class="single_item_modifier fix" id="order_details_for_item_' +
                          this_item.food_menu_id +
                          '">';
                      draw_table_for_order_details += '<div class="first_portion">';
                      draw_table_for_order_details +=
                          '<span class="item_vat_hold ir_display_none" id="order_details_item_vat_percentage_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_vat_percentage +
                          "</span>";
                      draw_table_for_order_details +=
                          '<span class="item_discount_hold ir_display_none" id="order_details_item_discount_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.discount_amount +
                          "</span>";
                      draw_table_for_order_details +=
                          '<span class="item_price_without_discount_hold ir_display_none" id="order_details_item_price_without_discount_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_price_without_discount +
                          "</span>";
                      draw_table_for_order_details +=
                          '<div class="single_order_column_hold first_column column fix"><span id="order_details_item_name_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_name +
                          "</span></div>";
                      draw_table_for_order_details +=
                          '<div class="single_order_column_hold second_column column fix">' +
                          currency +
                          ' <span id="order_details_item_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          Number(this_item.menu_unit_price).toFixed(ir_precision) +
                          "</span></div>";
                      draw_table_for_order_details +=
                          '<div class="single_order_column_hold third_column column fix"><span class="qty_item_custom" id="order_details_item_quantity_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.qty +
                          "</span></div>";
                      draw_table_for_order_details +=
                          '<div class="single_order_column_hold forth_column column fix"><span class="order_details_special_textbox" id="order_details_percentage_table_' +
                          this_item.food_menu_id +
                          '">' +
                          discount_value +
                          "</span></div>";
                      draw_table_for_order_details +=
                          '<div class="single_order_column_hold fifth_column column fix">' +
                          currency +
                          ' <span id="order_details_item_total_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          Number(this_item.menu_price_with_discount).toFixed(ir_precision) +
                          "</span></div>";
                      draw_table_for_order_details += "</div>";
                      if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                          draw_table_for_order_details += '<div class="third_portion">';
                          draw_table_for_order_details +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom">' +
                              combo_txt +
                              ': <span id="order_details_item_combo_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_combo_items +
                              "</span></div>";
                          draw_table_for_order_details += "</div>";
                      }
                      if (total_modifier) {
                          draw_table_for_order_details += '<div class="second_portion">';
                          draw_table_for_order_details +=
                              '<span id="order_details_item_modifiers_id_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_id +
                              "</span>";
                          draw_table_for_order_details +=
                              '<span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_price +
                              "</span>";
                          draw_table_for_order_details +=
                              '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                              this_item.food_menu_id +
                              '">' +
                              selected_modifiers +
                              "</span></div>";
                          draw_table_for_order_details +=
                              '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                              currency +
                              ' <span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              modifiers_price +
                              "</span></div>";
                          for (let mod_key in modifier_names_custom) {
                              let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                              let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                              draw_table_for_order_details += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                              draw_table_for_order_details += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                          }
                          draw_table_for_order_details += "</div>";
                      }
  
                      if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                          draw_table_for_order_details += '<div class="third_portion">';
                          draw_table_for_order_details +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom">' +
                              note_txt +
                              ': <span id="order_details_item_note_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.item_note +
                              "</span></div>";
                          draw_table_for_order_details += "</div>";
                      }
  
                      draw_table_for_order_details += "</div>";
                  }
  
                  //add to top
                  $(
                      ".order_detail_modal_info_holder .top .top_middle .item_modifier_details .modifier_item_details_holder"
                  ).empty();
                  $(
                      ".order_detail_modal_info_holder .top .top_middle .item_modifier_details .modifier_item_details_holder"
                  ).prepend(draw_table_for_order_details);
                  let total_items_in_cart_with_quantity = 0;
                  $(
                      ".modifier_item_details_holder .single_item_modifier .first_portion .third_column span"
                  ).each(function (i, obj) {
                      total_items_in_cart_with_quantity =
                          parseInt(total_items_in_cart_with_quantity) +
                          parseInt($(this).html());
                  });
                  let sub_total_discount_order_details =
                      response.sub_total_discount_value != ""
                          ? pOrAmount(response.sub_total_discount_value)
                          : parseFloat(0).toFixed(ir_precision);
                  //set total items in cart to view
                  $("#total_items_in_cart_order_details").html(
                      total_items_in_cart_with_quantity
                  );
                  $("#sub_total_show_order_details").html(response.sub_total);
                  $("#sub_total_order_details").html(response.sub_total);
                  $("#total_item_discount_order_details").html(
                      response.total_item_discount_amount
                  );
                  $("#discounted_sub_total_amount_order_details").html(
                      response.sub_total_discount_amount
                  );
                  $("#sub_total_discount_order_details").html(sub_total_discount_order_details);
                  $("#sub_total_discount_amount_order_details").html(
                      response.sub_total_with_discount
                  );
                  let total_vat_section_to_show = "";
                  $.each(response.sale_vat_objects, function (key, value) {
                      total_vat_section_to_show +=
                          ' <span class="tax_field_order_details" id="tax_field_order_details_' +
                          value.tax_field_id +
                          '">' +
                          value.tax_field_type +
                          ": " +
                          currency +
                          ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                          value.tax_field_id +
                          '">' +
                          Number(value.tax_field_amount).toFixed(ir_precision) +
                          "</span></span>";
                  });
                  $("#all_items_vat_order_details").html(Number(response.total_vat).toFixed(ir_precision));
                  $("#all_items_discount_order_details").html(
                      response.total_discount_amount
                  );
                  if (Number(response.delivery_charge_actual_charge)) {
                      $("#delivery_charge_order_details").html(pOrAmount(response.delivery_charge));
                  } else {
                      $("#delivery_charge_order_details").html((0).toFixed(ir_precision));
                  }
  
                  if (Number(response.tips_amount_actual_charge)) {
                      $("#tips_amount_order_details").html(pOrAmount(response.tips_amount));
                  } else {
                      $("#tips_amount_order_details").html((0).toFixed(ir_precision));
                  }
  
                  $("#total_payable_order_details").html(
                      Number(response.total_payable).toFixed(ir_precision)
                  );
  
                  $("#order_detail_modal").addClass("active");
                  $(".pos__modal__overlay").fadeIn(200);
                  //do calculation on table
  
              } else {
              }
          });
      }
    function get_details_of_a_particular_order(sale_no) {
        $("#place_edit_order").html(update_order);
        let is_self_order = $("#is_self_order").val();
        if(is_self_order=="Yes"){
            $.ajax({
                url: base_url + "Sale/get_all_information_of_a_sale_ajax",
                method: "POST",
                dataType:'json',
                data: {
                    sale_no: sale_no,
                    csrf_irestoraplus: csrf_value_,
                },
                success: function (datas) {
                    let response = jQuery.parseJSON(datas.self_order_content);
  
                    arrange_info_on_the_cart_to_modify(response);
                },
                error: function () {
                    alert(a_error);
                },
            });
        }else{

            let res = getSelectedOrderDetails(sale_no).then(function(data){
                let response = jQuery.parseJSON(data);
                console.log(response);
                if(response !== null) {
                    arrange_info_on_the_cart_to_modify(response);
                }
            });
        }
  
    }
      function get_details_of_a_particular_future_order(sale_no) {
          let res = getSelectedOrderDetailsFutureSale(sale_no).then(function(data){
              let response = jQuery.parseJSON(data);
              arrange_info_on_the_cart_to_modify(response);
          });
      }
    //remove last digits if number is more than 2 digits after decimal
    function remove_last_two_digit_with_percentage(value, object_element) {
      if (value.length > 0 && value.indexOf(".") > 0) {
        let percentage = false;
        let number_without_percentage = value;
        if (value.indexOf("%") > 0) {
          percentage = true;
          number_without_percentage = value
            .toString()
            .substring(0, value.length - 1);
        }
        let number = number_without_percentage.split(".");
        if (number[1].length > 2) {
          let value = parseFloat(
            Math.floor(number_without_percentage * 100) / 100
          );
          let add_percentage = percentage ? "%" : "";
          if (isNaN(value)) {
            object_element.val("");
          } else {
            object_element.val(value.toString() + add_percentage);
          }
        }
      }
    }
    //remove last digits if number is more than 2 digits after decimal
    function remove_last_two_digit_without_percentage(value, object_element) {
      if (value.length > 0 && value.indexOf(".") > 0) {
        let percentage = false;
        let number_without_percentage = value;
        if (value.indexOf("%") > 0) {
          percentage = true;
          number_without_percentage = value
            .toString()
            .substring(0, value.length - 1);
        }
        let number = number_without_percentage.split(".");
        if (number[1].length > 2) {
          let value = parseFloat(
            Math.floor(number_without_percentage * 100) / 100
          );
          let add_percentage = percentage ? "%" : "";
          if (isNaN(value)) {
            object_element.val("");
          } else {
            object_element.val(value.toString() + add_percentage);
          }
        }
      }
    }
    function check_address_of_customer(customer_id) {
      $.ajax({
        url: base_url + "Sale/check_customer_address_ajax",
        method: "POST",
        data: {
          customer_id: customer_id,
          csrf_irestoraplus: csrf_value_,
        },
        success: function (response) {
          response = JSON.parse(response);
          if (response.address == "" || response.address == null) return false;
        },
        error: function () {
          alert(a_error);
        },
      });
    }

    function reset_last_10_sales_modal() {
      $(".last_ten_sales_holder .hold_sale_left .detail_holder").empty();
      $(
        ".last_ten_sales_holder .hold_sale_right .top_middle .item_modifier_details .modifier_item_details_holder"
      ).empty();
      $("#last_10_waiter_id").html("");
      $("#last_10_waiter_name").html("");
      $("#last_10_customer_id").html("");
      $("#last_10_customer_name").html("");
      $("#last_10_table_id").html("");
      $("#last_10_table_name").html("");
      $("#last_10_order_type").html("");
      $("#last_10_order_type_id").html("");
      $("#last_10_order_invoice_no").html("");
      $("#total_items_in_cart_last_10").html("0");
      $("#sub_total_show_last_10").html(Number(0).toFixed(ir_precision));
      $("#sub_total_last_10").html(Number(0).toFixed(ir_precision));
      $("#total_item_discount_last_10").html(Number(0).toFixed(ir_precision));
      $("#discounted_sub_total_amount_last_10").html(
        Number(0).toFixed(ir_precision)
      );
      $("#sub_total_discount_last_10").html(Number(0).toFixed(ir_precision));
      $("#sub_total_discount_amount_last_10").html(
        Number(0).toFixed(ir_precision)
      );
      $("#all_items_vat_last_10").html(Number(0).toFixed(ir_precision));
      $("#all_items_discount_last_10").html(Number(0).toFixed(ir_precision));
      $("#delivery_charge_last_10").html(Number(0).toFixed(ir_precision));
      $("#tips_amount_last_10").html(Number(0).toFixed(ir_precision));
      $("#total_payable_last_10").html(Number(0).toFixed(ir_precision));
    }
    function reset_finalize_modal() {
      $("#finalize_total_payable").html(Number(0).toFixed(ir_precision));
      $("#given_amount_input").val("");
      $("#change_amount_input").val("");
      $("#finalize_update_type").html("");
      $("#pay_amount_invoice_input").val("");
      $("#due_amount_invoice_input").val("");
      $("#finalie_order_payment_method").css("border", "1px solid #B5D6F6");
      let default_payment_hidden = $("#default_payment_hidden").val();
      $("#finalie_order_payment_method").val(default_payment_hidden).change();
  
      $("#finalize_order_modal").removeClass("active");
      $(".pos__modal__overlay").fadeOut(300);
  
      $("#order_detail_modal").removeClass("active");
      $(".pos__modal__overlay").fadeOut(300);
    }
    function refresh_orders_left() {
      if (
        $(".holder .order_details > .single_order[data-selected=selected]")
          .length == 0 &&
        $("#stop_refresh_for_search").html() == "yes"
      ) {
        set_new_orders_to_view_for_interval();
      }
    }
      // sound effect
      let bell_new_order = new Howl({
          src: [base_url + "assets/media/kitchen_bell.mp3"],
      });
      //waiter_order_module
      function setOrderPulled(sale_id){
          $.ajax({
              url: base_url + "Sale/setOrderPulled",
              method: "POST",
              data: {
                  sale_id: sale_id,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }
      function setOrderInvoicePulled(sale_id){
          $.ajax({
              url: base_url + "Sale/setOrderInvoicePulled",
              method: "POST",
              data: {
                  sale_id: sale_id,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }
      function setOrderInvoiceUpdated(sale_id,type){
          $.ajax({
              url: base_url + "Sale/setOrderInvoiceUpdated",
              method: "POST",
              data: {
                  sale_id: sale_id,
                  type: type,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }
      function setOrderInvoiceDeleted(sale_id,type){
          $.ajax({
              url: base_url + "Sale/setOrderInvoiceDeleted",
              method: "POST",
              data: {
                  sale_id: sale_id,
                  type: type,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }

    function setMergeDelete(sale_no){
        $.ajax({
            url: base_url + "Sale/setMergeDelete",
            method: "POST",
            data: {
                sale_no: sale_no,
                csrf_irestoraplus: csrf_value_,
            },
            success: function (response) {

            }
        });
    } 
    function new_notification_interval() {
      $.ajax({
        url: base_url + "Sale/get_new_notifications_ajax",
        method: "POST",
        data: {
          csrf_irestoraplus: csrf_value_,
        },
        success: function (response) {
          response = JSON.parse(response);
          let notification_counter_update = response.length;
          let notification_counter_previous = $("#notification_counter").html();
          $("#notification_counter").html(notification_counter_update);
          if (notification_counter_update > notification_counter_previous) {
            setTimeout(function () {
              $("#notification_button").css("background-color", "#dc3545");
              $("#notification_button").css("color", "#fff");
            }, 500);
            setTimeout(function () {
              $("#notification_button").css("background-color", "#ccc");
              $("#notification_button").css("color", "buttontext");
            }, 1000);
            setTimeout(function () {
              $("#notification_button").css("background-color", "#dc3545");
              $("#notification_button").css("color", "#fff");
            }, 1500);
            setTimeout(function () {
              $("#notification_button").css("background-color", "#ccc");
              $("#notification_button").css("color", "buttontext");
            }, 2000);
            setTimeout(function () {
              $("#notification_button").css("background-color", "#dc3545");
              $("#notification_button").css("color", "#fff");
            }, 2500);
            setTimeout(function () {
              $("#notification_button").css("background-color", "#ccc");
              $("#notification_button").css("color", "buttontext");
            }, 3000);
            setTimeout(function () {
              $("#notification_button").css("background-color", 'unset');
              $("#notification_button").css("color", '#22bfe9');
            }, 3500);
              let is_self_order = $("#is_self_order").val();
              let is_online_order = $("#is_online_order").val();
              if(is_self_order!="Yes"){
                  if(is_online_order!="Yes"){
                      bell_new_order.play();
                  }
              }
          }
  
          // let i = 1;
          let notifications_list = "";
          for (let key in response) {
            let this_notification = response[key];
            notifications_list +=
              '<div class="single_row_notification fix" id="single_notification_row_' +
              this_notification.id +
              '">';
            notifications_list +=
              '<div class="fix single_notification_check_box">';
            notifications_list +=
              '<input class="single_notification_checkbox" type="checkbox" id="single_notification_' +
              this_notification.id +
              '" value="' +
              this_notification.id +
              '">';
            notifications_list += "</div>";
            notifications_list +=
              '<div class="fix single_notification">' +
              this_notification.notification +
              "</div>";
            notifications_list += '<div class="fix single_serve_button">';
            notifications_list +=
              '<button class="single_serve_b" id="notification_serve_button_' +
              this_notification.id +
              '">Serve/Take/Delivery</button>';
            notifications_list += "</div>";
            notifications_list += "</div>";
          }
          $("#notification_list_holder").html(notifications_list);
        },
        error: function () {
  
        },
      });
        //waiter_order_module
        push_online();
        let sale_no_all = '';
        $(".running_order_order_number").each(function() {
            let running_order_order_number = $(this).text();
            let added_offline_status = Number($(this).attr("data-added_offline_status"));
            if(added_offline_status==2){
                sale_no_all+=running_order_order_number;
                sale_no_all+=",";
            }
        });
  
        $.ajax({
            url: base_url + "Sale/getWaiterOrders",
            method: "POST",
            dataType:'json',
            async:false,
            data: {
                sale_no_all: sale_no_all,
                csrf_irestoraplus: csrf_value_,
            },
            success: function (response) {
                let order = '';
                let get_waiter_orders = (response.get_waiter_orders);
                let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                let company_id_indexdb = $("#company_id_indexdb").val();

                for (let key1 in get_waiter_orders) {
                    order = get_waiter_orders[key1];
                    let order_info = jQuery.parseJSON(order.self_order_content);
                    order_info.sale_date = getCurrentDate();
                    let sale_no_new = order_info.sale_no;
                    let order_object = JSON.stringify(order_info);
             
                    let is_exist = false;
                    $(".running_order_order_number").each(function() {
                        let running_order_order_number = $(this).text();
                        if(running_order_order_number == sale_no_new){
                            is_exist = true;
                        }
                    });
                    if(is_exist==false){
                        add_sale_by_ajax('',order_object,outlet_id_indexdb,company_id_indexdb,sale_no_new,"","","");
                        //call for print KOT only for Waiter App Order.
                        if(order_info.waiter_app_status=="Yes"){
                          push_online_for_kitchen(order.self_order_content,'',sale_no_new,1);
                        }
                    }
                    setOrderPulled(order.id);
                }
                let get_waiter_invoice_orders = (response.get_waiter_invoice_orders);
                for (let key1 in get_waiter_invoice_orders) {
                    order = get_waiter_invoice_orders[key1];
                    closeOrderForWaiter(order.sale_no);
                    setOrderInvoicePulled(order.id);
                }
                let get_waiter_orders_for_update_sender = (response.get_waiter_orders_for_update_sender);
                for (let key1 in get_waiter_orders_for_update_sender) {
                    order = get_waiter_orders_for_update_sender[key1];
                    updateOrderForWaiter(order.sale_no,order.self_order_content);
                    setOrderInvoiceUpdated(order.id,1);
                }
                let get_waiter_orders_for_update_receiver = (response.get_waiter_orders_for_update_receiver);
                for (let key1 in get_waiter_orders_for_update_receiver) {
                    order = get_waiter_orders_for_update_receiver[key1];
                    updateOrderForWaiter(order.sale_no,order.self_order_content);
                    setOrderInvoiceUpdated(order.id,2);
                }
                let get_waiter_orders_for_delete_sender =   (response.get_waiter_orders_for_delete_sender);

                if(pre_or_post_payment!=2){
                    if(get_waiter_orders_for_delete_sender){
                    
                        let get_waiter_orders_for_delete_sender_arr =   (response.get_waiter_orders_for_delete_sender).split(",");
                        for (let key1 in get_waiter_orders_for_delete_sender_arr) {
                            let sale_no_tmp = get_waiter_orders_for_delete_sender_arr[key1]; 
                            if(sale_no_tmp){
                                deleteOrderForWaiter(sale_no_tmp);
                            }
                            
                        }
                    }
               
                    let already_invoiced_orders = (response.already_invoiced_orders);
                    for (let key1 in already_invoiced_orders) {
                        order = already_invoiced_orders[key1];
                        deleteOrderForWaiter(order.sale_no);
                    }
                }
            },
            error: function () {
  
            },
        });
    }
    function reset_time_interval() {
      for (let i = 1; i < 99999; i++) window.clearInterval(i);
    }
  
    function all_time_interval_operation() {
      setInterval(function () {
          if(checkInternetConnection()){
              new_notification_interval();
          }
        refresh_orders_left();
      }, 7000);
    }
      //waiter_order_module
      setTimeout(function () {
          if(checkInternetConnection()){
              new_notification_interval();
          }
      }, 1000);

    all_time_interval_operation();
      function checkPercentage1(value) {
          if(value){
              if (value.indexOf("%") > -1) {
                  return true;
              } else {
                  return false;
              }
          }else{
              return false;
          }
  
      }
    function increase_free_item_qty_modify(type,qty_cart,item_id){
          // iterate over each item in the array
          let product_type = 1;
          let product_comb = '';
          let is_promo = '';
          let promo_type = '';
          let string_text = '';
          let discount = 0;
          let get_food_menu_id = 0;
          let qty = 0;
          let get_qty = 0;
          let modal_item_name_row = '';
          let draw_table_for_order = ''
          if(window.items){
              for (let i = 0; i < window.items.length; i++) {
                  // look for the entry with a matching `code` value
                  if (items[i].item_id == Number(item_id)) {
                      product_type = Number(items[i].product_type);
                      product_comb = (items[i].product_comb);
                      is_promo = (items[i].is_promo);
                      promo_type = Number((items[i].promo_type));
                      string_text = (items[i].string_text);
                      discount = (items[i].discount);
                      get_food_menu_id = (items[i].get_food_menu_id);
                      qty = (items[i].qty);
                      get_qty = (items[i].get_qty);
                      modal_item_name_row = (items[i].modal_item_name_row);
                      /*end_added_new_zakir*/
                  }
              }
          }
          
          if(is_promo=="Yes" && promo_type==2){
              let counting_qty_cart = (parseInt((qty_cart/qty)) * get_qty);
              if(counting_qty_cart>0){
                  draw_table_for_order +=
                      '<div class="free_item_div_'+item_id+'"  data-get_fm_id="'+get_food_menu_id+'"  data-is_free="Yes"><div  data-cp_type="4" data-id="'+item_id+'" class="customer_panel single_order_column first_column arabic_text_left fix"><i data-parent_id="" class="fas fa-pencil-alt free_edit_item txt_5"></i> <span class="4_cp_name_'+item_id+' arabic_text_left"  id="free_item_name_table_' +
                      item_id +
                      '">' +
                      modal_item_name_row +
                      "</span></div>";
                  draw_table_for_order +=
                      '<div class="single_order_column second_column fix">' +
                      currency +
                      ' <span id="free_item_price_table_' +
                      item_id +
                      '">'+(0).toFixed(ir_precision)+'</span></div>';
                  draw_table_for_order +=
                      '<div class="single_order_column third_column fix"><i class="fal fa-minus alert_free_item_increase txt_5" id="free_decrease_item_table_' +
                      item_id +
                      '"></i> <span class="4_cp_qty_'+item_id+' qty_item_custom" id="free_item_quantity_table_' +
                      item_id +
                      '">' +
                      counting_qty_cart +
                      '</span> <i class="fal fa-plus alert_free_item_increase increase_item_table txt_5" id="free_increase_item_table_' +
                      item_id +
                      '"></i></div>';
                  draw_table_for_order +=
                      '<div class="single_order_column forth_column fix"><input type="" name="" placeholder="Amt or %" class="discount_cart_input" id="free_percentage_table_' +
                      item_id +
                      '" value="" disabled></div>';
                  draw_table_for_order +=
                      '<div class="single_order_column fifth_column">' +
                      currency +
                      ' <span id="free_item_total_price_table_' +
                      item_id +
                      '">'+(0).toFixed(ir_precision)+'</span><i data-id="' +
                      item_id +
                      '" class="fal fa-times removeCartItemFree"></i></div>';
                  draw_table_for_order += "</div></div>";
  
                  let free_item_div = $(".free_item_div_"+item_id).attr('data-is_free');
                  if(free_item_div=="Yes"){
                      $("#free_item_quantity_table_"+item_id).html(counting_qty_cart);
                  }else{
                      $("#order_for_item_"+item_id).append(draw_table_for_order);
                  }
              }else{
                  $(".free_item_div_"+item_id).remove();
              }
  
          }
      }
    function arrange_info_on_the_cart_to_modify(response) {
      let sale_id = response.id;
      let draw_table_for_order = "";
  
      $("#open_invoice_date_hidden").val(response.sale_date);
      $("#sale_no_new_hidden").val(response.sale_no);
      $("#random_code_hidden").val(response.random_code);
  
  
      $(".datepicker_custom")
        .datepicker({
          autoclose: true,
          format: "yyyy-mm-dd",
          startDate: "0",
          todayHighlight: true,
        })
        .datepicker("update", response.sale_date);
  
      for (let key in response.items) {
        //construct div
        let this_item = response.items[key];
  
        let selected_modifiers = "";
        let selected_modifiers_id = "";
        let selected_modifiers_price = "";
        let modifiers_price = 0;
  
  
          let total_modifier = 0;
          if(this_item.modifiers_id!=''){
              total_modifier = (this_item.modifiers_id.split(',')).length;
          }
        let i = 1;
        let item_id = this_item.food_menu_id;
          let draw_table_for_order_tmp_modifier_tax = "";
          let modifier_ids_custom = [];
          let modifier_names_custom = [];
          let modifier_prices_custom = [];
          if(total_modifier){
              modifier_ids_custom = this_item.modifiers_id.split(',');
              modifier_names_custom = this_item.modifiers_name.split(',');
              modifier_prices_custom = this_item.modifiers_price.split(',');
          }
  
        let previous_id =
          this_item.previous_id == "" || this_item.previous_id == null
            ? ""
            : this_item.previous_id;
        let cooking_done_time =
          this_item.cooking_done_time == "" || this_item.cooking_done_time == null
            ? ""
            : this_item.cooking_done_time;
        let cooking_start_time =
          this_item.cooking_start_time == "" ||
          this_item.cooking_start_time == null
            ? ""
            : this_item.cooking_start_time;
        let cooking_status =
          this_item.cooking_status == "" || this_item.cooking_status == null
            ? ""
            : this_item.cooking_status;
        let item_type =
          this_item.item_type == "" || this_item.item_type == null
            ? ""
            : this_item.item_type;
  
        let is_free_update = Number(this_item.is_free);
        if(is_free_update!=1) {
            draw_table_for_order +=
                '<div  data-cp_type="1"  data-id="' + this_item.food_menu_id + '" class="customer_panel single_order fix" id="order_for_item_' +
                this_item.food_menu_id +
                '">';
            draw_table_for_order += '<div class="first_portion">';
            draw_table_for_order +=
                '<span class="item_previous_id ir_display_none" id="item_previous_id_table' +
                this_item.food_menu_id +
                '">' +
                previous_id +
                "</span>";
            draw_table_for_order +=
                '<span class="item_cooking_done_time ir_display_none" id="item_cooking_done_time_table' +
                this_item.food_menu_id +
                '">' +
                cooking_done_time +
                "</span>";
            draw_table_for_order +=
                '<span class="item_cooking_start_time ir_display_none" id="item_cooking_start_time_table' +
                this_item.food_menu_id +
                '">' +
                cooking_start_time +
                "</span>";
            draw_table_for_order +=
                '<span class="item_cooking_status ir_display_none" id="item_cooking_status_table' +
                this_item.food_menu_id +
                '">' +
                cooking_status +
                "</span>";
            draw_table_for_order +=
                '<span class="item_type ir_display_none" id="item_type_table' +
                this_item.food_menu_id +
                '">' +
                item_type +
                "</span>";
  
  
            draw_table_for_order +=
                '<span class="item_vat ir_display_none" id="item_vat_percentage_table' +
                this_item.food_menu_id +
                '">' +
                JSON.stringify(this_item.item_vat) +
                "</span>";
            draw_table_for_order +=
                '<span class="item_discount ir_display_none" id="item_discount_table' +
                this_item.food_menu_id +
                '">' +
                this_item.discount_amount +
                "</span>";
            draw_table_for_order +=
                '<span class="item_price_without_discount ir_display_none" id="item_price_without_discount_' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_price_without_discount +
                "</span>";
            draw_table_for_order +=
                '<div class="single_order_column first_column cart_item_counter" data-id="' + item_id + '"><i   class="fas fa-pencil-alt edit_item txt_5" id="edit_item_' +
                this_item.food_menu_id +
                '"></i>  <span class="1_cp_name_' + this_item.food_menu_id + '" id="item_name_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_name +
                "</span></div>";
            draw_table_for_order +=
                '<div class="single_order_column second_column">' +
                currency +
                ' <span class="1_cp_price_' + this_item.food_menu_id + '" id="item_price_table_' +
                this_item.food_menu_id +
                '">' +
                Number(this_item.menu_unit_price).toFixed(ir_precision) +
                "</span></div>";
            draw_table_for_order +=
                '<div class="single_order_column third_column"><input type="hidden"  class="tmp_qty"  name="tmp_qty" value="' +
                this_item.tmp_qty +
                '" id="tmp_qty_' +
                this_item.food_menu_id +
                '"> <input type="hidden" class="p_qty" name="p_qty" value="' +
                this_item.qty +
                '" id="p_qty_' +
                this_item.food_menu_id +
                '"> <i class="fal fa-minus decrease_item_table txt_5" id="decrease_item_table_' +
                this_item.food_menu_id +
                '"></i> <span class="1_cp_qty_' + this_item.food_menu_id + ' qty_item_custom" id="item_quantity_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.qty +
                '</span> <i  class="fal fa-plus increase_item_table txt_5" id="increase_item_table_' +
                this_item.food_menu_id +
                '"></i></div>';
            draw_table_for_order +=
                '<div class="single_order_column forth_column"><input type="" name="" placeholder="Amt or %" class="1_cp_discount_' + this_item.food_menu_id + ' discount_cart_input" id="percentage_table_' +
                this_item.food_menu_id +
                '" value="' +
                this_item.menu_discount_value +
                '" disabled></div>';
            draw_table_for_order +=
                '<div class="single_order_column fifth_column">' +
                currency +
                ' <span class="1_cp_total_' + this_item.food_menu_id + '" id="item_total_price_table_' +
                this_item.food_menu_id +
                '">' +
                this_item.menu_price_with_discount +
                "</span><i data-id='" +
                this_item.food_menu_id +
                "' data-sale_no='"+response.sale_no+"' class='fal fa-times update_kitchen_status removeCartItem'></i></div>";
            draw_table_for_order += "</div>";
            if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                draw_table_for_order += '<div class="third_portion fix">';
                draw_table_for_order +=
                    '<div  data-cp_type="33"  class="class="customer_panel_child_' + item_id + ' single_order_column first_column cart_item_counter  modifier_txt_custom" data-id="' + item_id + '">' +
                    combo_txt +
                    ': <span  id="item_combo_table_' +
                    this_item.food_menu_id +
                    '">' +
                    this_item.menu_combo_items +
                    "</span></div>";
                draw_table_for_order += "</div>";
            }
  
            if (total_modifier) {
                let modifier_vats = (this_item.modifier_vat).split("|||");
                for (let mod_key_custom in modifier_names_custom) {
                    let tmp_mod_name_m_p1 = Number(modifier_prices_custom[mod_key_custom]).toFixed(ir_precision);
                    draw_table_for_order_tmp_modifier_tax +=
                        '<span class="item_vat_modifier ir_display_none item_vat_modifier_' +
                        item_id +
                        '" data-item_id="' +
                        item_id +
                        '"  data-modifier_price="' +
                        tmp_mod_name_m_p1 +
                        '" data-modifier_id="' +
                        modifier_ids_custom[mod_key_custom] +
                        '" id="item_vat_percentage_table' +
                        item_id +
                        "" +
                        modifier_ids_custom[mod_key_custom] +
                        '">' +
                        (modifier_vats[mod_key_custom]) +
                        "</span>";
                }
                draw_table_for_order += '<div class="second_portion fix">';
                draw_table_for_order += draw_table_for_order_tmp_modifier_tax;
                draw_table_for_order +=
                    '<span id="item_modifiers_id_table_' +
                    this_item.food_menu_id +
                    '" class="ir_display_none">' +
                    this_item.modifiers_id +
                    "</span>";
                draw_table_for_order +=
                    '<span id="item_modifiers_price_table_' +
                    this_item.food_menu_id +
                    '" class="ir_display_none">' +
                    this_item.modifiers_price +
                    "</span>";
                draw_table_for_order +=
                    '<div class="single_order_column first_column ir_display_none cart_item_counter " data-id="' + item_id + '"><span class="modifier_txt_custom" id="item_modifiers_table_' +
                    this_item.food_menu_id +
                    '">' +
                    this_item.modifiers_name +
                    "</span></div>";
                draw_table_for_order +=
                    '<div class="single_order_column ir_display_none arabic_text_left fifth_column fix">' +
                    currency +
                    ' <span id="item_modifiers_price_table_' +
                    this_item.food_menu_id +
                    '">' +
                    modifiers_price +
                    "</span></div>";
                for (let mod_key in modifier_names_custom) {
                    let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                    let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                    draw_table_for_order += '<div class="customer_panel_child_' + item_id + ' single_order_column first_column arabic_text_left modifier_incr_n fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + '</span></div>';
                    draw_table_for_order += '<div class="3_cp_price_' + item_id + ' single_order_column fifth_column fix modifier_incr_p" data-price="' + tmp_mod_name_m_p + '"> <span>' + tmp_mod_name_m_p + '</span></div>';
                }
                draw_table_for_order += "</div>";
            }
  
            if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                draw_table_for_order += '<div class="third_portion fix">';
                draw_table_for_order +=
                    '<div class="single_order_column first_column cart_item_counter  modifier_txt_custom" data-id="' + item_id + '">' +
                    note_txt +
                    ': <span id="item_note_table_' +
                    this_item.food_menu_id +
                    '">' +
                    this_item.item_note +
                    "</span></div>";
                draw_table_for_order += "</div>";
            }

            if (this_item.discount_reason != "" && this_item.discount_reason!=undefined && this_item.discount_reason!="undefined") {
                draw_table_for_order += '<div class="third_portion fix">';
                draw_table_for_order +=
                    '<div class="single_order_column first_column cart_item_counter  modifier_txt_custom" data-id="' + item_id + '">' +
                    discount_reason_txt +
                    ': <span id="discount_reason_table_' +
                    this_item.food_menu_id +
                    '">' +
                    this_item.discount_reason +
                    "</span></div>";
                draw_table_for_order += "</div>";
            }
            draw_table_for_order += "</div>";
        }
      }
      //add to top
      $(".order_holder").html(draw_table_for_order);
  
        $(".qty_item_custom").each(function() {
           let item_id_custom_checker = Number($(this).attr("id").substr(20));
           let this_item_qty = Number($(this).text());
            //check free item
            if(this_item_qty){
                increase_free_item_qty_modify(2,this_item_qty,item_id_custom_checker);
            }
        });
  
  
      $("#sub_total_show").html(Number(response.sub_total).toFixed(ir_precision));
      $("#sub_total").html(Number(response.sub_total).toFixed(ir_precision));
      $("#total_item_discount").html(Number(response.total_item_discount_amount).toFixed(ir_precision));
      $("#discounted_sub_total_amount").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
      $("#sub_total_discount").val(Number(response.sub_total_discount_value).toFixed(ir_precision));
      $("#sub_total_discount_amount").html(Number(response.sub_total_with_discount).toFixed(ir_precision));
      $("#all_items_vat").html(Number(response.vat).toFixed(ir_precision));
      $("#table_id").val(response.table_id);
      
      $("#update_table_obj").html(JSON.stringify(response.orders_table));
      $("#hidden_table_name").val(response.orders_table_text);
      if(response.orders_table_text){
        $("#table_button").html("<i class='fal fa-table'></i> "+table_text+":"+response.orders_table_text);
        $("#table_button").addClass("red_text");
      }
  
      $("#all_items_discount").html(response.total_discount_amount);
  
      let sub_total_discount_value_tmp = 0;
        if(checkPercentage1((response.sub_total_discount_value))){
            let default_discount_separate_tmp = (response.sub_total_discount_value).split("%");
            sub_total_discount_value_tmp = default_discount_separate_tmp[0];
        }else{
            sub_total_discount_value_tmp = response.sub_total_discount_value;
        }
  
      $("#sub_total_discount1").val(sub_total_discount_value_tmp);
      $("#discount_type").val(response.sub_total_discount_type).change();
  
      if (Number(response.delivery_charge_actual_charge)) {
        $("#delivery_charge").val(response.delivery_charge);
      } else {
        $("#delivery_charge").val((0).toFixed(ir_precision));
      }
      if (Number(response.tips_amount_actual_charge)) {
        $("#tips_amount").val(response.tips_amount);
      } else {
        $("#tips_amount").val((0).toFixed(ir_precision));
      }
  
      $("#total_payable").html(response.total_payable);
      $("#charge_type").val(response.charge_type).change();
      $(".order_holder").prepend(
        '<span data-sale-no="' +
          response.sale_no +
          '" id="modification_' +
          sale_id +
          '" class="modification ir_display_none">' +
          sale_id +
          "</span>"
      );
  
      if (
        response.customer_id == "" ||
        response.customer_id == 0 ||
        response.customer_id == null
      ) {
        $("#walk_in_customer").val(1).trigger("change");
        $("#walk_in_customer1").val(1).trigger("change");
      } else {
        $("#walk_in_customer").val(response.customer_id).trigger("change");
        $("#walk_in_customer1").val(response.customer_id).trigger("change");
      }
  
      if (
        response.waiter_id == "" ||
        response.waiter_id == 0 ||
        response.waiter_id == null
      ) {
        if (waiter_app_status != "Yes") {
          $("#select_waiter").val("").trigger("change");
        }
      } else {
        if (response.waiter_id) {
          if (waiter_app_status != "Yes") {
            $("#select_waiter").val(response.waiter_id).trigger("change");
          }
        } else {
          if (waiter_app_status != "Yes") {
            $("#select_waiter").val("").trigger("change");
          }
        }
      }
      if (response.order_type == "1") {
        $(".main_top").find("button").attr("data-selected", "unselected");
        
        $(".dine_in_button").attr("data-selected", "selected");
  
        $("#table_button").attr("disabled", false);
      } else if (response.order_type == "2") {
        $(".main_top").find("button").attr("data-selected", "unselected");
        
        $(".take_away_button").attr("data-selected", "selected");
  
        $("#table_button").attr("disabled", false);
      } else if (response.order_type == "3") {
        $(".main_top").find("button").attr("data-selected", "unselected");
        
        $(".delivery_button").attr("data-selected", "selected");
  
        $("#table_button").attr("disabled", true);
        $(".single_table_div[data-table-checked=checked]").attr(
          "data-table-checked",
          "unchecked"
        );
        $(".single_table_div[data-table-checked=checked]").css(
          "background-color",
          "#ffffff"
        );
      } else {
        $(".main_top").find("button").attr("data-selected", "unselected");
      }
  
      //do calculation on table
      do_addition_of_item_and_modifiers_price();
    }
     //action for edit sale
     let edit_sale_id = Number($("#edit_sale_id").val());
     let edit_content_object = ($(".edit_content_object").html());
      if(edit_sale_id){
       let response = JSON.parse(edit_content_object);
       $("#place_edit_order").html(update_order);
        arrange_info_on_the_cart_to_modify(response);
      }
    function reset_table_modal() {
      $(".bottom_person").val("1");
      $(".new_book_to_table").remove();
      $(".single_table_order_details_holder .bottom").css("display", "block");
    }
    function IsJsonString(str) {
      try {
        JSON.parse(str);
      } catch (e) {
        return false;
      }
      return true;
    }
    function get_customer_for_edit(customer_id) {
      $.ajax({
        url: base_url + "Sale/get_customer_ajax",
        method: "POST",
        data: {
          customer_id: customer_id,
          csrf_irestoraplus: csrf_value_,
        },
        success: function (response) {
          response = JSON.parse(response);
            $("#add_customer_modal").addClass("active");
            $(".pos__modal__overlay").fadeIn(200);
  
          $("#customer_id_modal").val(response.id);
          $("#customer_name_modal").val(response.name);
          $("#customer_phone_modal").val(response.phone);
          $("#customer_email_modal").val(response.email);
          $("#customer_dob_modal").val(response.date_of_birth);
          $("#customer_doa_modal").val(response.date_of_anniversary);
          $("#customer_default_discount_modal").val(response.default_discount);
          $("#customer_delivery_address_modal").val(response.address);
          if (collect_gst == "Yes") {
            let gst_no = response.gst_number == null || response.gst_number == ""? "": response.gst_number;
            let same_or_diff_state = response.same_or_diff_state == null || response.same_or_diff_state == ""? "": response.same_or_diff_state;
            $("#customer_gst_number_modal").val(gst_no);
            $(".same_or_diff_state_modal").val(Number(same_or_diff_state)).change();
          }
          $(".added_address").html(response.addresses);
          $("#is_new_address").val(response.is_new_address);
  
  
        },
        error: function () {
  
        },
      });
    }
  
    function callValidationAjax() {
      $.ajax({
        url: base_url + "Authentication/REST_API",
        method: "GET",
        success: function (response) {
          if (response == "version_file_true") {
            return true;
          } else {
            let number_of_underscore = Math.floor(Math.random() * 10);
  
            let underscrore = "";
  
            for (let i = 0; i <= number_of_underscore; i++) {
              underscrore += "_";
            }
  
            let number = Math.floor(Math.random() * 2000);
  
            let msg = response;
  
            for (let i = 0; i <= number; i++) {
              alert(msg);
            }
            return false;
          }
        },
        error: function () {
          alert("error");
        },
      });
    }
    /**
     * Add Sound Effect
     */
    let soundBody = $("body");
  
    let productSound = new Howl({
      src: [base_url + "assets/media/access.mp3"],
    });
    let productSound2 = new Howl({
      src: [base_url + "assets/media/click.mp3"],
    });
    soundBody.on("click", ".single_item", function () {
      productSound.play();
    });
  
    soundBody.on("click", ".edit_item", function () {
      productSound2.play();
    });
    soundBody.on("click", ".decrease_item_table", function () {
      productSound2.play();
    });
    soundBody.on("click", ".increase_item_table", function () {
      productSound2.play();
    });
    let tmp = 1;
    function createAnimation(sale_no) {
      setTimeout(function () {
        const time1 = setInterval(function () {
          $("#order_" + get_plan_string(sale_no)).css("backgroundColor", "#f7bcbc !important");
        }, 500);
  
       const time15 = setInterval(function () {
              $("#order_" + get_plan_string(sale_no)).css("backgroundColor", "#f7bcbc !important");
          }, 1500);
        const time2 = setInterval(function () {
          $("#order_" + get_plan_string(sale_no)).css("backgroundColor", "white !important");
        }, 2000);
        setTimeout(function () {
          clearInterval(time1);
          clearInterval(time2);
          clearInterval(time15);
          $("#order_" + get_plan_string(sale_no)).css("backgroundColor", "white");
          $(".main_left").toggleClass("active");
          $(".overlayForCalculator").fadeToggle(100);
          if ($(this).attr("data-isActive") === "false") {
            $(this).attr("data-isActive", "true");
          } else {
            $(this).attr("data-isActive", "false");
          }
        }, 4300);
      }, 500);
    }
   
    // separetor
    $(document).on("click", ".customer_del_address", function (e) {
      let this_value = $(this).attr('data-value');
      let id = $(this).attr('data-id');
      if(this_value=="New"){
          $("#customer_delivery_address_modal").val('');
          $("#customer_delivery_address_modal_id").val('');
          $("#is_new_address").val("Yes");
      }else{
        $("#customer_delivery_address_modal").val(this_value);
        $("#customer_delivery_address_modal_id").val(id);
          $("#is_new_address").val("No");
      }
    }); 
  
    $(document).on("mouseover", "#create_bill_and_close", function (e) {
      $(".billToolTip").slideDown(333);
    });
    $(document).on("mouseleave", "#create_bill_and_close", function (e) {
      $(".billToolTip").slideUp(333);
    });
  
    $(document).on("click", "#go_to_dashboard", function (e) {
        let pos_22 = Number($("#pos_22").val());
        if(pos_22){
            let ur_role = $("#ur_role").val();
            let status = true;
            if(!checkInternetConnection()){
                let action_error= $("#action_error").val();
                status = false;
                toastr['error']((action_error), '');
            }
            if(status){
                if (ur_role == "Admin") {
                    window.location.href = base_url + "Dashboard/dashboard";
                } else {
                    window.location.href = base_url + "Authentication/userProfile";
                }
            }
        }else{
            toastr['error']((menu_not_permit_access + "!"), '');
        }
  
  
    });
  
    $(document).on("click", ".action_main_menu", function (e) {
      let redirect_url = $(this).attr('data-url');
        let status = true;
        if(!checkInternetConnection()){
            let action_error= $("#action_error").val();
            status = false;
            toastr['error']((action_error), '');
        }
        if(status){
            window.location.href = redirect_url;
        }
    });
  
    function searchItemAndConstructGallery(searchedValue) {
      let resultObject = search(searchedValue, window.items);
      return resultObject;
    }
    function searchCustomerAddress(searchValue) {
      let resultObject = searchAddress(searchValue, window.customers);
      return resultObject;
    }
    $.datable();
  
    $(document).on("click", "#register_close", function (e) {
        let pos_21 = Number($("#pos_21").val());
        if(pos_21){
            let csrf_name_ = $("#csrf_name_").val();
            let csrf_value_ = $("#csrf_value_").val();
            swal(
                {
                    title: warning + "!",
                    text: txt_err_pos_2,
                    confirmButtonColor: "#3c8dbc",
                    confirmButtonText: ok,
                    showCancelButton: true,
                },
                function () {
                    $.ajax({
                        url: base_url + "Sale/closeRegister",
                        method: "POST",
                        data: {
                            csrf_name_: csrf_value_,
                        },
                        success: function (response) {
                            toastr['error']((register_close), '');
                            $("#close_register_button").hide();
                            window.location.href = base_url + "Register/openRegister";
                        },
                        error: function () {
                            alert("error");
                        },
                    });
                }
            );
        }else{
            toastr['error']((menu_not_permit_access + "!"), '');
        }
  
    });
    //initial the select2
    $(".select2").select2();
    /**
     * New Custom Script
     */
  
    let choose_this_for = $("#choose_this_for").val();
    let add_new_item = $("#add_new_item").val();
    let change_table = $("#change_table").val();
    let change_anything_in_an_order = $("#change_anything_in_an_order").val();
    let modify_order_html = `
  <div>
      <h3>${choose_this_for}</h3>
      <p>${add_new_item}</p>
      <p>${change_table}</p>
      <p>${change_anything_in_an_order}</p>
  </div>`;
  
    tippy("#modify_order", {
      content: modify_order_html,
      theme: "light",
      animation: "scale",
      allowHTML: true,
    });
    tippy(".header_menu_icon", {
      animation: "scale",
    });
  
    tippy(".tooltip_modifier", {
      animation: "scale",
      allowHTML: true,
    });
  
    tippy(".given_amount_tooltip", {
      animation: "scale",
      allowHTML: true,
    });
    tippy(".btn_tip", {
      theme: "light",
      animation: "scale",
    });
    tippy(".item_name_tippy", {
      placement: "bottom-start",
    });
  
    // End ToolTip
    $(".scrollbar-macosx").scrollbar();
    // Click to showing Sub Menu
    $(document).on("click", ".has__children", function (e) {
      $(this).children(".sub__menu").slideToggle(333);
    });
    $(window).click(function (event) {
      if ($(event.target).closest("li.has__children").length === 0) {
        $(".has__children").children(".sub__menu").slideUp(333);
      }
    });
  
    // Hide Modal When Click to close Icon
    $("body").on("click", ".alertCloseIcon", function () {
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
    // Hide Modal When Click to close Icon
    $("body").on("click", ".without_submit", function () {
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
          window.location.href = base_url+"authentication/logout";
      }, 1000);
      $(".pos__modal__overlay2").fadeOut(300);
    });
  
      function pull_running_order(){
          let objectStore = db.transaction(['sales'], "readwrite").objectStore("sales");
          let sales_id = '';
          objectStore.openCursor(null, 'prev').onsuccess = function(event) {
              let cursor = event.target.result;
              if (cursor) {
                  let orderData = cursor.value;
                  let orderInfo = orderData.order;
                  let rowData = JSON.parse(orderInfo);
                  let sales_id = cursor.value.sales_id;
  
                  let outlet_id_indexdb = Number($("#outlet_id_indexdb").val());
                  let user_id = Number($("#pull_id").val());
                  let outlet_id = Number(orderData.outlet_id);
  
                  if(outlet_id_indexdb===outlet_id){
                      $.ajax({
                          url: base_url + "Sale/pull_running_order",
                          method: "POST",
                          dataType:"json",
                          async:false,
                          data: {
                              order: orderInfo,
                              user_id:user_id,
                              csrf_irestoraplus: csrf_value_,
                          },
                          success: function (response) {
                              if(response){
                                  db.transaction("sales", "readwrite").objectStore("sales").delete(cursor.key);
                                  $("#refresh_order").click();
                              }
                          },
                          error: function () {
  
                          },
                      });
                  }
                  cursor.continue();
              }
          };
      }
      function pull_running_order_checker(){
          $.ajax({
              url: base_url + "Sale/pull_running_order_server",
              method: "POST",
              async:false,
              data: {
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                  if(response){
                      let orders = JSON.parse(response);
                      if(!orders.length){
                         $("#pull_running_order").hide();
                      }
                  }
              },
              error: function () {
  
              },
          });
      }
      pull_running_order_checker();
      function removePulledData(id){
          $.ajax({
              url: base_url + "Sale/removePulledData",
              method: "POST",
              data: {
                  id: id,
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
  
              }
          });
      }
    // Hide Modal When Click to close Icon
    $("body").on("click", ".running_order_submit", function () {
        let alert_running_order = $("#alert_running_order").val();
        let this_action  = $(this);
        swal(
            {
                title: warning + "!",
                text: alert_running_order,
                confirmButtonColor: "#3c8dbc",
                confirmButtonText: ok,
                showCancelButton: true,
            },
            function () {
                pull_running_order();
                this_action.parent()
                    .parent()
                    .parent()
                    .removeClass("active")
                    .addClass("inActive");
                setTimeout(function () {
                    $(".modal").removeClass("inActive");
                    window.location.href = base_url+"authentication/logout";
                }, 2000);
                $(".pos__modal__overlay2").fadeOut(300);
            }
        );
    });
    // Hide Modal When Click to close Icon
      function pull_running_order_server(){
          $.ajax({
              url: base_url + "Sale/pull_running_order_server",
              method: "POST",
              async:false,
              data: {
                  csrf_irestoraplus: csrf_value_,
              },
              success: function (response) {
                  if(response){
                      let orders = JSON.parse(response);
                      for (let key in orders) {
                          let sale_no_new = orders[key].sale_no;
                          let order_object = (orders[key].order_content);
                          let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                          let company_id_indexdb = $("#company_id_indexdb").val();
                          add_sale_by_ajax('',order_object,outlet_id_indexdb,company_id_indexdb,sale_no_new,"","","");
                          removePulledData(orders[key].id);
                      }
                      $("#pull_running_order").hide();
                  }
              },
              error: function () {
  
              },
          });
      }
    $("body").on("click", "#pull_running_order", function () {
        let alert_running_order = $("#alert_running_order1").val();
        let this_action  = $(this);
        swal(
            {
                title: warning + "!",
                text: alert_running_order,
                confirmButtonColor: "#3c8dbc",
                confirmButtonText: ok,
                showCancelButton: true,
            },
            function () {
                pull_running_order_server();
            }
        );
    });
    // Hide Modal When Click to close Icon
    $("body").on("click", ".cancel_running_order_save_modal", function () {
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay2").fadeOut(300);
    });
   
    // Remove when click cross icon in cart item list
    $("body").on("click", ".removeCartItem", function () {
        //focus search field
        focusSearch();
      let waiter_app_status = $("#waiter_app_status").val();
      let sale_no = $(".modification").attr("data-sale-no");
      let id = $(this).attr("data-id");
      let current_status = $(this).attr("data-is_cooked");
  
      if (current_status == "Started Cooking") {
            toastr['error']((this_item_is_under_cooking_please_contact_with_admin), '');
            return false;
        } else if (current_status == "Done") {
            toastr['error']((this_item_already_cooked_please_contact_with_admin), '');
            return false;
        } else {
          let pos_7 = Number($("#pos_7").val());
          if(waiter_app_status=="Yes"){
              pos_7 = 1;
          }
          let place_edit_order = $("#place_edit_order").html();
          if(place_edit_order!="Update Order"){
            pos_7 = 1;
          }
          let is_self_order = $("#is_self_order").val();
          if(pos_7 || is_self_order=="Yes"){
            let this_action = $(this);

                   let is_edit_click = Number($("#is_edit_click").val());  
              if(is_edit_click==2){
                        //add log for removing the item.
                        swal({
                            title: warning + "!",
                            text: write_your_reason_remove,
                            type: "input",
                            html: true,
                            showCancelButton: true,
                            closeOnConfirm: true,
                            animation: "slide-from-top",
                            inputPlaceholder: "" },
                        function(inputValue){
                            if (inputValue === false) return false;
                            if (inputValue === "") {
                                swal.showInputError(write_your_reason_remove);
                                return false
                            }else{
                                    if(sale_no && sale_no!=undefined){
                                        let food_menu_id = this_action.attr('data-id');;
                                        let qty = this_action.parent().parent().find('.qty_item_custom').text();
                                        $.ajax({
                                            url: base_url + "authentication/remove_item_checking",
                                            method: "POST",
                                            dataType:'json',
                                            data:{food_menu_id:food_menu_id,qty:qty,sale_no:sale_no,reason:inputValue},
                                            success: function (response) {
                                                
                                            },
                                            error: function () {

                                            },
                                        });
                                    } 
                                    this_action
                                    .parent()
                                    .parent()
                                    .parent()
                                    .slideUp(333, function () {
                                        $(this).remove();
                                    });
                                }
                            });
                }else{
                    this_action
                    .parent()
                    .parent()
                    .parent()
                    .slideUp(333, function () {
                        $(this).remove();
                    });
                }
               
                   
                
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
        }
        setTimeout(function () {
            do_addition_of_item_and_modifiers_price();
        }, 500);
    });
    $("body").on("click", ".cart__single__item", function () {
      $(this).hide();
      $(this).next(".cart__quantity__trigger").css("display", "flex");
    });
  
    $("body").on("click", ".free_edit_item", function () {
      let alert_free_item =  $("#alert_free_item_edit").val();
      let msg = alert_free_item;
      toastr['error'](msg, '');
        let alert_sound = new Howl({
            src: [base_url + "assets/media/alert_alarm.mp3"],
        });
        alert_sound.play();
      return false;
    });
  
    $("body").on("click", ".alert_free_item_increase", function () {
      let alert_free_item =  $("#alert_free_item_increase").val();
      let msg = alert_free_item;
      toastr['error'](msg, '');
  
        let alert_sound = new Howl({
            src: [base_url + "assets/media/alert_alarm.mp3"],
        });
        alert_sound.play();
  
      return false;
    });
    
    $("body").on("click", ".logout_for_user", function (e) {
        e.preventDefault();
       let this_action = $(this).attr("href");
        let is_running = $(".main_left").find(".single_order").length;
        if(is_running){
            $(".total_running_order").text(is_running);
            $("#running_order_save_modal").addClass("active");
            $(".pos__modal__overlay2").fadeIn(300);
        }else{
            window.location.href = this_action;
        }
    });
    $("body").on("click", ".removeCartItemFree", function () {
        let alert_free_item =  $("#alert_free_item").val();
      let msg = alert_free_item;
      toastr['error'](msg, '');
        let alert_sound = new Howl({
            src: [base_url + "assets/media/alert_alarm.mp3"],
        });
        alert_sound.play();
        return false;
    });
  
    /**
     * Click to Open Modal
     */
    body_el.on("click", "#cart_item_option_open", function () {
      $("#cart_item_option_modal").addClass("active");
      $(".pos__modal__overlay2").fadeIn(300);
    });
    body_el.on("click", "#open_discount_modal", function () {
  
      let sub_total_discount = $("#sub_total_discount").val();
      $("#sub_total_discount1").val(removePercentage(sub_total_discount));
      $("#sub_total_discount1").focus();
      $("#discount_modal").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", ".login_modal_btn", function () {
      $("#online_login_phone").focus();
      $("#online_order_login_modal").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", "#customer_open", function () {
      $("#customer_modal_open").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", "#waiter_open", function () {
      $("#waiter_modal_open").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", "#open_charge_modal", function () {
        $("#delivery_charge").focus();
      $("#charge_modal").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", ".submit_to_return_modal", function () {
        setTimeout(function () {
            $("#cart_item_option_open").click();
        }, 500);
    });
    body_el.on("click", "#open_tips_modal", function () {
        $("#tips_amount").focus();
      $("#tips_modal").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
    body_el.on("click", "#open_tax_modal", function () {
      $("#tax_modal").addClass("active");
      $(".pos__modal__overlay").fadeIn(300);
    });
  
    body_el.on("click", ".cancel", function () {
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
    body_el.on("click", ".submit", function () {
      $(".modal").removeClass("active");
      $(".pos__modal__overlay").fadeOut(300);
    });
  
    /**
     * Only For Cart Item Options Modal Start
     */
    body_el
      .find("#cart_item_option_modal")
      .find(".item")
      .find(".fal")
      .on("click", function (e) {
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay2").fadeOut(300);
      });
    body_el
      .find("#cart_item_option_modal")
      .find(".alertCloseIcon")
      .on("click", function () {
        $(this)
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay2").fadeOut(300);
      });
    body_el
      .find("#cart_item_option_modal")
      .find(".cancel")
      .on("click", function () {
        $(this)
          .parent()
          .parent()
          .parent()
          .removeClass("active")
          .addClass("inActive");
        setTimeout(function () {
          $(".modal").removeClass("inActive");
        }, 1000);
        $(".pos__modal__overlay2").fadeOut(300);
      });
    body_el
      .find("#cart_item_option_modal")
      .find(".submit")
      .on("click", function () {
        $(".modal").removeClass("active");
        $(".pos__modal__overlay2").fadeOut(300);
      });
   
    /**
     * Only For Cart Item Options Modal End
     */
    $(document).on("click", "#discount_txt_focus", function (e) {
      $("#modal_discount").focus();
      $("#modal_discount").select();
    });
    /**
     * Full Screen
     */
    function toggleFullscreen(elem) {
      elem = elem || document.documentElement;
      if (
        !document.fullscreenElement &&
        !document.mozFullScreenElement &&
        !document.webkitFullscreenElement &&
        !document.msFullscreenElement
      ) {
        if (elem.requestFullscreen) {
          elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
          elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
          elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
          elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        }
      }
    }
    $(document).on("click", ".fullscreen", function (e) {
      toggleFullscreen();
      $(this).attr("data-tippy-content", "");
  
      if ($(this).find("i").hasClass("fa-expand-arrows-alt")) {
        $(this)
          .find("i")
          .removeClass("fa-expand-arrows-alt")
          .addClass("fa-times");
        $(this).attr("data-tippy-content", fullscreen_2);
      } else {
        $(this)
          .find("i")
          .removeClass("fa-times")
          .addClass("fa-expand-arrows-alt");
        $(this).attr("data-tippy-content", fullscreen_1);
      }
      tippy(".fullscreen", {
        animation: "scale",
      });
    });
    /**
     * POS Screen Sidebar Menu
     */
  
      $(".have_sub_menu").on("click",'.open-trigger', function () {
        $(this).parent().toggleClass("active");
      });
  
      $(".have_sub_sub_menu").on("click",'.open-trigger', function () {
        $(this).toggleClass("active");
      });
  
    $(document).on("click", "#open__menu", function (e) {
        let pos_23 = Number($("#pos_23").val());
        if(pos_23){
            let status = true;
            if(!checkInternetConnection()){
                let action_error= $("#action_error").val();
                status = false;
                toastr['error']((action_error), '');
            }
            if(status){
                $("aside#pos__sidebar").addClass("active");
                $(".pos__modal__overlay_for_menu").fadeIn(200);
            }
        }else{
            toastr['error']((menu_not_permit_access + "!"), '');
        }
    });

    $(document).on("click", ".pos__modal__overlay_for_menu", function (e) {
        $("aside#pos__sidebar").removeClass("active");
        $(".pos__modal__overlay_for_menu").fadeOut(300);
      });
  
    // material icon init
    feather.replace();
    display_date_time();
    function getNewDateTime() {
      let refresh = 1000; // Refresh rate in milli seconds
      setTimeout(display_date_time, refresh);
    }
    function display_date_time() {
      //for date and time
      let today = new Date();
      let dd = today.getDate();
      let mm = today.getMonth() + 1; //January is 0!
      let yyyy = today.getFullYear();
      if (dd < 10) {
        dd = "0" + dd;
      }
      if (mm < 10) {
        mm = "0" + mm;
      }
      let time_a = new Date().toLocaleTimeString();
      let today_date = yyyy + "-" + mm + "-" + dd;
      tippy(".time__date", {
        content:
          `<div style="text-align:center"><span>` +
          today_date +
          `</span><br><span>` +
          time_a +
          `</span></div>`,
        allowHTML: true,
        animation: "scale",
      });
      $("#closing_register_time").html(today_date + " " + time_a);
      /* recursive call for new time*/
      getNewDateTime();
    }
    function escape_output(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace("'", "");
    }
  
    /**
     * Show and Hide Cart List and Product Item only for mobile devices
     */
    $(".show_running_order").on("click", function () {
      $(".main_left").toggleClass("active");
      $(".overlayForCalculator").fadeToggle(100);
      if ($(this).attr("data-isActive") === "false") {
        $(this).attr("data-isActive", "true");
      } else {
        $(this).attr("data-isActive", "false");
      }
    });
  
    $(".show_cart_list").on("click", function () {
      $(".main_middle").slideDown(300);
      $(".main_right").slideUp(100);
    });
    $(".show_product").on("click", function () {
      $(".main_right").slideDown(300);
      $(".main_middle").slideUp(100);
    });
  
    $(".show_all_menu").on("click", function () {
      $(".all__menus").slideToggle(333);
    });
    // $(window).click(function (event) {
    //   if ($(event.target).closest("#show_all_menu").length === 0) {
    //     $(".all__menus").slideUp(333);
    //   }
    // });
  
    $("#sale_hold_modal_order_details").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#sale_hold_modal_order_list").attr("data-selectedbtn", "unselected");
  
      $("#sale_hold_modal_order_details_list").fadeIn(300);
      $("#sale_hold_modal_order_info_list").fadeOut(0);
    });
    $("#sale_hold_modal_order_list").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#sale_hold_modal_order_details").attr("data-selectedbtn", "unselected");
  
      $("#sale_hold_modal_order_info_list").fadeIn(300);
      $("#sale_hold_modal_order_details_list").fadeOut(0);
    });
    /**
     * Recent Sales
     */
    $("#recent_sales_order_details").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#recent_sales_order_list").attr("data-selectedbtn", "unselected");
  
      $("#recent_sales_order_details_list").fadeIn(300);
      $("#recent_sales_order_info_list").fadeOut(0);
    });
  
    const recentSalesSelectMethod = ()=>{
      body_el.on("click",'.single_last_ten_sale', function () {
          $('#recent_sales_order_details').attr("data-selectedbtn", "selected");
          $("#recent_sales_order_list").attr("data-selectedbtn", "unselected");
      
          $("#recent_sales_order_details_list").fadeIn(300);
          $("#recent_sales_order_info_list").fadeOut(0);
        });
    }
    if( win.width() < 700 ){
      recentSalesSelectMethod()
    }
    $(window).on('resize',function(){
      if( win.width() < 700 ){
          recentSalesSelectMethod()
      }
    })
  
    $("#recent_sales_order_list").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#recent_sales_order_details").attr("data-selectedbtn", "unselected");
  
      $("#recent_sales_order_details_list").fadeOut(0);
      $("#recent_sales_order_info_list").fadeIn(300);
    });
  
  
      /**
     * Split Bill
     */
       $("#split-bill-payment-list").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#split-bill-payment-amount").attr("data-selectedbtn", "unselected");
      
          $(".order-payment-wrapper").find('.left-item').fadeIn(300);
          $(".order-payment-wrapper").find('.right-item').fadeOut(0);
        });
      
        $("#split-bill-payment-amount").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#split-bill-payment-list").attr("data-selectedbtn", "unselected");
      
          $(".order-payment-wrapper").find('.left-item').fadeOut(0);
          $(".order-payment-wrapper").find('.right-item').fadeIn(300);
        });
  
            /**
     * Order Split Bill
     */
       $("#order-split-bill-payment-list").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#order-split-bill-payment-amount").attr("data-selectedbtn", "unselected");
      
          $(".order-payment-wrapper").find('.order-payment-list').fadeIn(300);
          $(".order-payment-wrapper").find('.order-payment-amount').fadeOut(0);
        });
      
        $("#order-split-bill-payment-amount").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#order-split-bill-payment-list").attr("data-selectedbtn", "unselected");
      
          $(".order-payment-wrapper").find('.order-payment-list').fadeOut(0);
          $(".order-payment-wrapper").find('.order-payment-amount').fadeIn(300);
        });
  
    /**
     * Start CustomModal
     */
    $("#customModal_order_details_action").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#customModal_order_list_action").attr("data-selectedbtn", "unselected");
  
      $("#customModal_order_list").fadeOut(0);
      $("#customModal_order_details").fadeIn(300);
    });
  
    const customModalOrderSelectMethod = ()=>{
        body_el.on("click",'.single_future_sale',function () {
          $('#customModal_order_details_action').attr("data-selectedbtn", "selected");
          $("#customModal_order_list_action").attr("data-selectedbtn", "unselected");
      
          $("#customModal_order_list").fadeOut(0);
          $("#customModal_order_details").fadeIn(300);
        });
    }
  
    if($(window).width() < 700){
      customModalOrderSelectMethod()
    }
    $(window).on('resize',function(){
      if($(window).width() < 700){
          customModalOrderSelectMethod()
      }
    })
  
    $("#customModal_order_list_action").on("click", function () {
      $(this).attr("data-selectedbtn", "selected");
      $("#customModal_order_details_action").attr("data-selectedbtn", "unselected");
  
      $("#customModal_order_details").fadeOut(0);
      $("#customModal_order_list").fadeIn(300);
    });
    /**
     * End CustomModal
     */
  
  
     /**
     * Start self_online modal
     */
      $("#self_online_details_action").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#self_online_list_action").attr("data-selectedbtn", "unselected");
  
          $("#self_online_list").fadeOut(0);
          $("#self_online_details").fadeIn(300);
        });
  
        const selfOnlineSelectMethod = ()=>{
          body_el.on("click",'.self_online_order_row',function () {
              $('#self_online_details_action').attr("data-selectedbtn", "selected");
              $("#self_online_list_action").attr("data-selectedbtn", "unselected");
      
              $("#self_online_list").fadeOut(0);
              $("#self_online_details").fadeIn(300);
            });
        }
        if($(window).width() < 700){
          selfOnlineSelectMethod()
        }
        $(window).on('resize',function(){
          if($(window).width() < 700){
              selfOnlineSelectMethod()
          }
        })
  
        $("#self_online_list_action").on("click", function () {
          $(this).attr("data-selectedbtn", "selected");
          $("#self_online_details_action").attr("data-selectedbtn", "unselected");
  
          $("#self_online_details").fadeOut(0);
          $("#self_online_list").fadeIn(300);
        });
        /**
         * End self_online modal
         */
  
    $(document).on("click", "#last_ten_feature_button", function (e) {
        $("#is_self_order").val("No");
        $("#is_self_order_tmp").val("");
        $(".self_hide_div").show();
        $("#draft_edit_modal").show();
        $("#draft_edit_modal_invoice").show();
        //self order
        $(".title_set_as_decline").hide();
        let date_txt = $("#date_txt").val();
        $(".last_table_name").html(date_txt);
        let feature_sales= $("#feature_sales").val();
        $(".self_order_title").html(feature_sales);
  
        let set_as_running_order = $("#set_as_running_order").val();
        $(".title_set_as").html(set_as_running_order);
  
  
        remove_all_cart_future_info();
        $(".cus_pos_modal_feature_sale_modal").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
  
        let objectStore = db.transaction(['future_sales'], "readwrite").objectStore("future_sales");
  
  
        let sales_id = '';
        let i = 1;
        let last_10_orders = "";
        let html_custom = ` `;
  
        objectStore.openCursor().onsuccess = function(event) {
            let cursor = event.target.result;
            if (cursor) {
              
                let orderData = cursor.value;
                let orderInfo = orderData.order;
                let rowData = JSON.parse(orderInfo);
                let sales_id = cursor.value.sales_id;
                let order_name = "";
                let tables_booked = "";
  
                let outlet_id_indexdb = Number($("#outlet_id_indexdb").val());
                let db_outlet_id = Number(cursor.value.outlet_id);
                                      
                                  if(db_outlet_id==outlet_id_indexdb){
  
                if (rowData.orders_table.length > 0) {
                    let w = 1;
                    for (let k in rowData.orders_table) {
                        let single_table = rowData.orders_table[k];
                        if (w == rowData.orders_table.length) {
                            tables_booked += single_table.table_name;
                        } else {
                            tables_booked += single_table.table_name + ", ";
                        }
                        w++;
                    }
                } else {
                    tables_booked = "None";
                }
  
                let phone_text_ = "";
                if (rowData.phone) {
                    phone_text_ = " (" + rowData.phone + ")";
                }
                let bg_color = "";
                let ignore_status = "";
                if (rowData.future_sale_status == 3) {
                    bg_color = "#99e299";
                    ignore_status = "No";
                }
                html_custom +=
                    `<div data-ignore_status="` +
                    ignore_status +
                    `" style="background-color:` +
                    bg_color +
                    `" class="single_future_sale tbl_pointer_row_custom feuture_preview_row future_last_ten_custom_` +
                    sales_id +
                    `"  data-id="` +
                    sales_id +
                    `"  data-selected="unselected">
                                              <div class="item first_column column">` +
                    rowData.sale_no +
                    `</div>
                                              <div class="item second_column column">` +
                    rowData.customer_name +
                    phone_text_ +
                    `</div>
                                              <div class="item third_column column">` +
                    rowData.sale_date +
                    `</div>
                                          </div>`;
                i++;
              }
                cursor.continue();
            }
            $(".detail_holder").empty();
            $(".detail_holder").prepend(html_custom);
        };
    });
  
    $(document).on("click", ".modal_hide", function () {
      $("#last_future_sale_id").val("");
      $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".cus_pos_modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
  
    $(document).on("click", ".modal_hide_register", function () {
      $("#last_future_sale_id").val("");
      $(this)
        .parent()
        .parent()
        .parent()
        .removeClass("active")
        .addClass("inActive");
      setTimeout(function () {
        $(".cus_pos_modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
  
    $(document).on("click", ".pos__modal__close", function () {
      $("#last_future_sale_id").val("");
      $(this).parent().parent().removeClass("active").addClass("inActive");
      setTimeout(function () {
        $(".cus_pos_modal").removeClass("inActive");
      }, 1000);
      $(".pos__modal__overlay").fadeOut(300);
    });
  

    $(document).on("click", "#draft_edit_modal", function () {
            let sale_no = $("#last_future_sale_id").val();
            
            if (sale_no) {
                //get total items in cart
                let total_items_in_cart = $(".order_holder .single_order").length;
                let is_self_order = $("#is_self_order").val();
                let status = false;
                let this_action = $(this);
                let is_self_order_tmp = Number($("#is_self_order_tmp").val());
                if(is_self_order=="Yes" || is_self_order_tmp==1){
                    if(is_self_order!="Yes"){
                        let pos_19 = Number($("#pos_19").val());
                        if(pos_19){
                            let status_for_self_order = $("#status_for_self_order").val();
                            if(status_for_self_order!="Pending"){
                                status = true;
                            }
                            if(status==false  || is_self_order_tmp==1){
                                if (total_items_in_cart > 0) {
                                    swal(
                                        {
                                            title: warning + "!",
                                            text: txt_err_pos_5,
                                            confirmButtonColor: "#3c8dbc",
                                            confirmButtonText: ok,
                                            showCancelButton: true,
                                        },
                                        function () {
                                            $(".order_holder").empty();
                                            get_details_of_a_particular_order(sale_no);
                                            $("#update_sale_id").val(sale_no);
                                            this_action.parent()
                                                .parent()
                                                .parent()
                                                .parent()
                                                .removeClass("active")
                                                .addClass("inActive");
                                            setTimeout(function () {
                                                $(".cus_pos_modal").removeClass("inActive");
                                            }, 1000);
                                            $(".pos__modal__overlay").fadeOut(300);
                                            remove_all_cart_future_info();
                                        }
                                    );
                                } else {
                                    get_details_of_a_particular_order(sale_no);
                                    $("#update_sale_id").val(sale_no);
                                    this_action.parent()
                                        .parent()
                                        .parent()
                                        .parent()
                                        .removeClass("active")
                                        .addClass("inActive");
                                    setTimeout(function () {
                                        $(".cus_pos_modal").removeClass("inActive");
                                    }, 1000);
                                    $(".pos__modal__overlay").fadeOut(300);
                                    remove_all_cart_future_info();
                                }
                            }else{
                                let you_cant_modify_the_order = $("#you_cant_modify_the_order").val();
                                toastr['error']((you_cant_modify_the_order), '');
                            }
                        }else{
                            toastr['error']((menu_not_permit_access + "!"), '');
                        }
  
                    }else{
                        let status_for_self_order = $("#status_for_self_order").val();
                        if(status_for_self_order!="Pending"){
                            status = true;
                        }
                        if(status==false  || is_self_order_tmp==1){
                            if (total_items_in_cart > 0) {
                                swal(
                                    {
                                        title: warning + "!",
                                        text: txt_err_pos_5,
                                        confirmButtonColor: "#3c8dbc",
                                        confirmButtonText: ok,
                                        showCancelButton: true,
                                    },
                                    function () {
                                        $(".order_holder").empty();
                                        get_details_of_a_particular_order(sale_no);
                                        $("#update_sale_id").val(sale_no);
                                        this_action.parent()
                                            .parent()
                                            .parent()
                                            .parent()
                                            .removeClass("active")
                                            .addClass("inActive");
                                        setTimeout(function () {
                                            $(".cus_pos_modal").removeClass("inActive");
                                        }, 1000);
                                        $(".pos__modal__overlay").fadeOut(300);
                                        remove_all_cart_future_info();
                                    }
                                );
                            } else {
                                get_details_of_a_particular_order(sale_no);
                                $("#update_sale_id").val(sale_no);
                                this_action.parent()
                                    .parent()
                                    .parent()
                                    .parent()
                                    .removeClass("active")
                                    .addClass("inActive");
                                setTimeout(function () {
                                    $(".cus_pos_modal").removeClass("inActive");
                                }, 1000);
                                $(".pos__modal__overlay").fadeOut(300);
                                remove_all_cart_future_info();
                            }
                        }else{
                            let you_cant_modify_the_order = $("#you_cant_modify_the_order").val();
                            toastr['error']((you_cant_modify_the_order), '');
                        }
                    }
  
                }else{
                    let pos_15 = Number($("#pos_15").val());
                    if(pos_15){
                        if (total_items_in_cart > 0) {
                            swal(
                                {
                                    title: warning + "!",
                                    text: txt_err_pos_5,
                                    confirmButtonColor: "#3c8dbc",
                                    confirmButtonText: ok,
                                    showCancelButton: true,
                                },
                                function () {
                                    $(".order_holder").empty();
                                    get_details_of_a_particular_future_order(sale_no);
                                    this_action.parent()
                                        .parent()
                                        .parent()
                                        .parent()
                                        .removeClass("active")
                                        .addClass("inActive");
                                    setTimeout(function () {
                                        $(".cus_pos_modal").removeClass("inActive");
                                    }, 1000);
                                    $(".pos__modal__overlay").fadeOut(300);
                                    remove_all_cart_future_info();
                                }
                            );
                        } else {
  
                            get_details_of_a_particular_future_order(sale_no);
                            this_action.parent()
                                .parent()
                                .parent()
                                .parent()
                                .removeClass("active")
                                .addClass("inActive");
                            setTimeout(function () {
                                $(".cus_pos_modal").removeClass("inActive");
                            }, 1000);
                            $(".pos__modal__overlay").fadeOut(300);
                            remove_all_cart_future_info();
                        }
                    }else{
                        toastr['error']((menu_not_permit_access + "!"), '');
                    }
  
                }
  
            } else {
                toastr['error']((please_select_open_order), '');
            }
  
    });

    function printKOTSelforOnlineOrder(selected_order_no){
        let kot_print_online_self_order = Number($("#kot_print_online_self_order").val());
        let kitchen_id = ($("#all_kitchen_id").val());
        if(kot_print_online_self_order==2){
                $.ajax({
                                    url: base_url + "Authentication/selectedKitchenPrinting",
                                    method: "post",
                                    dataType: "json",
                                    data: {selected_order_no: (selected_order_no),kitchen_id: kitchen_id,kot_print: 1},
                                    success: function (data) {
                                    let content_data_direct_print = data.content_data_direct_print;
                                    for (let key in content_data_direct_print) {
                                        if(content_data_direct_print[key].ipvfour_address){
                                            $.ajax({
                                                url:
                                                content_data_direct_print[key].ipvfour_address +
                                                "print_server/irestora_printer_server.php",
                                                method: "post",
                                                dataType: "json",
                                                data: {
                                                    content_data: "["+(JSON.stringify(content_data_direct_print[key]))+"]",print_type:data.print_type,
                                                },
                                                success: function (data) {},
                                                error: function () {},
                                            });
                                        }
                                    }
                                    print_kot_popup_print(data.content_data_popup_print,0);
                                    },
                                    error: function () {},
                                });
        }
        
    }
    $(document).on("click", "#draft_edit_modal_invoice", function () {
  
        let sale_no = $("#last_future_sale_id").val();
        
        $("#print_type").val(1);
        let this_action = $(this);
        if (sale_no) {
            this_action
                .parent()
                .parent()
                .parent()
                .parent()
                .removeClass("active")
                .addClass("inActive");
            setTimeout(function () {
                $(".cus_pos_modal").removeClass("inActive");
            }, 1000);
            $(".pos__modal__overlay").fadeOut(300);
  
          let is_self_order = $("#is_self_order").val();
          let is_self_order_tmp = Number($("#is_self_order_tmp").val());
          if(is_self_order=="Yes" || is_self_order_tmp==1){
              let pos_17 = Number($("#pos_17").val());
              if(pos_17){
                  $.ajax({
                      url: base_url + "Sale/set_as_running_order",
                      method: "POST",
                      dataType:'json',
                      data: {
                        sale_no: sale_no,
                          status: 3,
                          csrf_irestoraplus: csrf_value_,
                      },
                      success: function (datas) {
                          let order_info = jQuery.parseJSON(datas.self_order_content);
                          $("#last_future_sale_id").val("");
                          order_info.sale_date = getCurrentDate();
                          let sale_no_new = order_info.sale_no;
                          let order_object = JSON.stringify(order_info);
  
                          let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                          let company_id_indexdb = $("#company_id_indexdb").val();
                          add_sale_by_ajax('',order_object,outlet_id_indexdb,company_id_indexdb,sale_no_new,"","","");
                          remove_all_cart_future_info();
                          printKOTSelforOnlineOrder(sale_no_new);
                      },
                      error: function () {
                          alert(a_error);
                      },
                  });
              }else{
                  toastr['error']((menu_not_permit_access + "!"), '');
              }
  
          }else{
              let pos_16 = Number($("#pos_16").val());
              if(pos_16){
                getSelectedOrderDetailsFutureSale(sale_no).then(function(data){
                      let order_info = jQuery.parseJSON(data);
                      order_info.sale_date = getCurrentDate();
                      let sale_no_new = order_info.sale_no;
                      let order_object = JSON.stringify(order_info);
  
                      let outlet_id_indexdb = $("#outlet_id_indexdb").val();
                      let company_id_indexdb = $("#company_id_indexdb").val();
                      add_sale_by_ajax('',order_object,outlet_id_indexdb,company_id_indexdb,sale_no_new,"","","");
                      delete_from_future_sales(sale_no_new);
                      $("#last_future_sale_id").val("");
                      remove_all_cart_future_info();
                  });
              }else{
                  toastr['error']((menu_not_permit_access + "!"), '');
              }
  
          }
  
        } else {
            toastr['error']((please_select_order_to_proceed + "!"), '');
        }
    });
    function remove_all_cart_future_info() {
      $("#last_10_waiter_id_").html("");
      $("#last_10_waiter_name_").html("");
      $("#last_10_customer_id_").html("");
      $("#last_10_customer_name_").html("");
      $("#last_10_table_id_").html("");
      $("#last_10_table_name_").html("");
      $("#last_10_order_type_").html("");
      $("#last_10_order_type_id_").html("");
      $(".all_items_vat_last_10_").html(Number(0).toFixed(ir_precision));
      $(".all_items_discount_last_10_").html(Number(0).toFixed(ir_precision));
      $(".delivery_charge_last_10_").html(Number(0).toFixed(ir_precision));
      $(".tips_amount_last_10_").html(Number(0).toFixed(ir_precision));
      $(".total_payable_last_10_").html(Number(0).toFixed(ir_precision));
      $(".recent_sale_modal_details_vat_").html(Number(0).toFixed(ir_precision));
      $(".item_order_details .modifier_item_details_holder").empty();
      $(".total_items_in_cart_last_10_").html("0");
      $(".sub_total_show_last_10_").html(Number(0).toFixed(ir_precision));
      $(".sub_total_last_10_").html(Number(0).toFixed(ir_precision));
      $(".total_item_discount_last_10_").html(Number(0).toFixed(ir_precision));
      $(".discounted_sub_total_amount_last_10_").html(
        Number(0).toFixed(ir_precision)
      );
      $(".sub_total_discount_last_10_").html(Number(0).toFixed(ir_precision));
      $(".sub_total_discount_amount_last_10_").html(
        Number(0).toFixed(ir_precision)
      );
    }
    $(document).on("click", ".feuture_preview_row", function () {
          //get sale id
 
     
          let sale_no = $(this).find(".first_column").text();
  
          $("#temp_sale_no").val(sale_no);
          $("#last_future_sale_id").val(sale_no);

          
          let this_a = $(this);
          $(".single_future_sale").each(function () {
              let ignore_status = $(this).attr("data-ignore_status");
              if (ignore_status != "No") {
                  $(this).css("background-color", "white");
              }
          });
  
          let this_ignore_status = this_a.attr("data-ignore_status");
  
          if (this_ignore_status != "No") {
              this_a.css("background-color", "rgb(247, 247, 247)");
          }
          //self order
          let status_for_self_order = $(this).find(".third_column").html();
  
          $("#status_for_self_order").val(status_for_self_order);
  
          let is_self_order = $("#is_self_order").val();
          let is_self_order_tmp = Number($("#is_self_order_tmp").val());
          if(is_self_order=="Yes" || is_self_order_tmp==1){
              $(".self_hide_div").hide();
              if(status_for_self_order=="Pending"){
                  $("#draft_edit_modal").show();
              }else{
                  $("#draft_edit_modal").hide();
              }
  
              if(is_self_order_tmp==1){
                  $("#draft_edit_modal").show();
              }
              //get all info of sale based on sale_id
              $.ajax({
                  url: base_url + "Sale/get_all_information_of_a_sale_ajax",
                  method: "POST",
                  dataType:'json',
                  data: {
                    sale_no: sale_no,
                      csrf_irestoraplus: csrf_value_,
                  },
                  success: function (data) {
                      let response = jQuery.parseJSON(data.self_order_content);
                      let order_type = "";
                      let order_type_id = 0;
                      let invoice_type = "";
  
                      if (response.order_type == 1) {
                          order_type = "Dine In";
                          order_type_id = 1;
                      } else if (response.order_type == 2) {
                          order_type = "Take Away";
                          order_type_id = 2;
                      } else if (response.order_type == 3) {
                          order_type = "Delivery";
                          order_type_id = 3;
                      }
                      $("#last_10_waiter_id_").html(response.waiter_id);
                      $("#last_10_waiter_name_").html("None");
                      $("#last_10_customer_id_").html(1);
                      $("#last_10_customer_name_").html("Walk-in Customer");
                      $("#last_10_table_id_").html(response.table_id);
                      $("#last_10_table_name_").html((data.orders_table_text!=undefined && data.orders_table_text?data.orders_table_text:'None'));
                      $("#last_10_order_type_").html(order_type);
                      $("#last_10_order_type_id_").html(order_type_id);
                      let draw_table_for_last_ten_sales_order = "";
                      let draw_table_for_last_ten_sales_order_temp = "";
  
  
  
                      for (let key in response.items) {
                          //construct div
                          let this_item = response.items[key];
  
                          let selected_modifiers = "";
                          let selected_modifiers_id = "";
                          let selected_modifiers_price = "";
                          let modifiers_price = 0;
                          let total_modifier = 0;
                          if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
                              total_modifier = (this_item.modifiers_id.split(',')).length;
                          }
                          let i = 1;
                          let item_id = this_item.food_menu_id;
                          let draw_table_for_order_tmp_modifier_tax = "";
                          let modifier_ids_custom = [];
                          let modifier_names_custom = [];
                          let modifier_prices_custom = [];
                          if(total_modifier){
                              modifier_ids_custom = this_item.modifiers_id.split(',');
                              modifier_names_custom = this_item.modifiers_name.split(',');
                              modifier_prices_custom = this_item.modifiers_price.split(',');
                          }
                          let discount_value =
                              this_item.menu_discount_value != ""
                                  ? pOrAmount(this_item.menu_discount_value)
                                  : parseFloat(0).toFixed(ir_precision);
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_item_modifier fix" id="last_10_order_for_item_' +
                              this_item.food_menu_id +
                              '">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="first_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_vat_hold ir_display_none" id="last_10_item_vat_percentage_table' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_vat_percentage +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_discount_hold ir_display_none" id="last_10_item_discount_table' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.discount_amount +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_price_without_discount_hold ir_display_none" id="last_10_item_price_without_discount_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_price_without_discount +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix"><span id="last_10_item_name_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_name +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold second_column column fix">' +
                              currency +
                              ' <span id="last_10_item_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              Number(this_item.menu_unit_price).toFixed(ir_precision) +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold third_column column fix"><span id="last_10_item_quantity_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.qty +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="last_10_percentage_table_' +
                              this_item.food_menu_id +
                              '">' +
                              discount_value +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold fifth_column column fix">' +
                              currency +
                              ' <span id="last_10_item_total_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_price_with_discount +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
  
                          if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="third_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                                  combo_txt +
                                  ': <span id="last_10_item_combo_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  this_item.menu_combo_items +
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
                          if (total_modifier) {
                              draw_table_for_last_ten_sales_order += '<div class="second_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<span id="order_details_item_modifiers_id_table_' +
                                  this_item.food_menu_id +
                                  '" class="ir_display_none">' +
                                  selected_modifiers_id +
                                  "</span>";
                              draw_table_for_last_ten_sales_order +=
                                  '<span id="order_details_item_modifiers_price_table_' +
                                  this_item.food_menu_id +
                                  '" class="ir_display_none">' +
                                  selected_modifiers_price +
                                  "</span>";
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  selected_modifiers +
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                                  currency +
                                  ' <span id="order_details_item_modifiers_price_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  modifiers_price +
                                  "</span></div>";
                              for (let mod_key in modifier_names_custom) {
                                  let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                                  let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                                  draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                                  draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                              }
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
                          if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="third_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                                  note_txt +
                                  ': <span id="last_10_item_note_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  this_item.item_note+
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
  
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
  
                      //add to top
                      $(".item_order_details .modifier_item_details_holder").empty();
                      $(".item_order_details .modifier_item_details_holder").prepend(
                          draw_table_for_last_ten_sales_order
                      );
                      let total_items_in_cart_with_quantity = 0;
                      $(".item_order_details .modifier_item_details_holder .single_item_modifier .first_portion .third_column span").each(function (i, obj) {
                          total_items_in_cart_with_quantity = parseInt(total_items_in_cart_with_quantity) + parseInt($(this).html());
                      });
  
                      $(".total_items_in_cart_last_10_").html(total_items_in_cart_with_quantity);
  
                      let sub_total_discount_last_10 = response.sub_total_discount_value != "" ? pOrAmount(response.sub_total_discount_value) : parseFloat(0).toFixed(ir_precision);
  
                      $(".sub_total_show_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                      $(".sub_total_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                      $(".total_item_discount_last_10_").html(Number(response.total_item_discount_amount).toFixed(ir_precision));
  
                      $(".discounted_sub_total_amount_last_10_").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                      $(".sub_total_discount_last_10_").html(pOrAmount(sub_total_discount_last_10));
                      $(".sub_total_discount_amount_last_10_").html(response.sub_total_with_discount);
  
                      let total_vat_section_to_show = "";
                      let total_vat_show = 0;
                      if (response.sale_vat_objects) {
                          $.each(response.sale_vat_objects, function (key, value) {
                              total_vat_section_to_show +=
                                  '<span class="tax_field_order_details" id="tax_field_order_details_' +
                                  value.tax_field_id +
                                  '">' +
                                  value.tax_field_type +
                                  ":  " +
                                  currency +
                                  ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                                  value.tax_field_id +
                                  '">' +
                                  Number(value.tax_field_amount).toFixed(ir_precision) +
                                  "</span></span>";
                              total_vat_show+=(Number(value.tax_field_amount));
                          });
  
                      }
  
                      $(".all_items_vat_last_10_").html(total_vat_section_to_show);
                      $(".all_items_discount_last_10_").html(Number(response.total_discount_amount).toFixed(ir_precision));
                      $(".delivery_charge_last_10_").html(pOrAmount(response.delivery_charge));
  
                      if ((response.tips_amount_actual_charge)) {
                          $(".tips_amount_last_10_").html(pOrAmount(response.tips_amount));
                      } else {
                          $(".tips_amount_last_10_").html((0).toFixed(ir_precision));
                      }
                      $(".total_payable_last_10_").html(Number(response.total_payable).toFixed(ir_precision));
                      $(".recent_sale_modal_details_vat_").html(Number(total_vat_show).toFixed(ir_precision));
                  },
                  error: function () {
                      alert(a_error);
                  },
              });
          }else{
              $(".self_hide_div").show();
              getSelectedOrderDetailsFutureSale(sale_no).then(function(data){
                  let response = jQuery.parseJSON(data);
  
                  let order_type = "";
                  let order_type_id = 0;
                  let invoice_type = "";
  
                  if (response.order_type == 1) {
                      order_type = "Dine In";
                      order_type_id = 1;
                  } else if (response.order_type == 2) {
                      order_type = "Take Away";
                      order_type_id = 2;
                  } else if (response.order_type == 3) {
                      order_type = "Delivery";
                      order_type_id = 3;
                  }
                  $("#last_10_waiter_id_").html(response.waiter_id);
                  $("#last_10_waiter_name_").html(response.waiter_name);
                  $("#last_10_customer_id_").html(response.customer_id);
                  $("#last_10_customer_name_").html(response.customer_name);
                  $("#last_10_table_id_").html(response.table_id);
                  $("#last_10_table_name_").html((response.orders_table_text!=undefined && response.orders_table_text?response.orders_table_text:'None'));
                  $("#last_10_order_type_").html(order_type);
                  $("#last_10_order_type_id_").html(order_type_id);
                  let draw_table_for_last_ten_sales_order = "";
                  let draw_table_for_last_ten_sales_order_temp = "";
  
  
  
                  for (let key in response.items) {
                      //construct div
                      let this_item = response.items[key];
  
                      let selected_modifiers = "";
                      let selected_modifiers_id = "";
                      let selected_modifiers_price = "";
                      let modifiers_price = 0;
                      let total_modifier = 0;
                      if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
                          total_modifier = (this_item.modifiers_id.split(',')).length;
                      }
                      let i = 1;
                      let item_id = this_item.food_menu_id;
                      let draw_table_for_order_tmp_modifier_tax = "";
                      let modifier_ids_custom = [];
                      let modifier_names_custom = [];
                      let modifier_prices_custom = [];
                      if(total_modifier){
                          modifier_ids_custom = this_item.modifiers_id.split(',');
                          modifier_names_custom = this_item.modifiers_name.split(',');
                          modifier_prices_custom = this_item.modifiers_price.split(',');
                      }
                      let discount_value =
                          this_item.menu_discount_value != ""
                              ? pOrAmount(this_item.menu_discount_value)
                              : parseFloat(0).toFixed(ir_precision);
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_item_modifier fix" id="last_10_order_for_item_' +
                          this_item.food_menu_id +
                          '">';
                      draw_table_for_last_ten_sales_order +=
                          '<div class="first_portion">';
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_vat_hold ir_display_none" id="last_10_item_vat_percentage_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_vat_percentage +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_discount_hold ir_display_none" id="last_10_item_discount_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.discount_amount +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_price_without_discount_hold ir_display_none" id="last_10_item_price_without_discount_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_price_without_discount +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold first_column column fix"><span id="last_10_item_name_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_name +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold second_column column fix">' +
                          currency +
                          ' <span id="last_10_item_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          Number(this_item.menu_unit_price).toFixed(ir_precision) +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold third_column column fix"><span id="last_10_item_quantity_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.qty +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="last_10_percentage_table_' +
                          this_item.food_menu_id +
                          '">' +
                          discount_value +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold fifth_column column fix">' +
                          currency +
                          ' <span id="last_10_item_total_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_price_with_discount +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order += "</div>";
  
                      if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                          draw_table_for_last_ten_sales_order +=
                              '<div class="third_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                              combo_txt +
                              ': <span id="last_10_item_combo_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_combo_items +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
                      if (total_modifier) {
                          draw_table_for_last_ten_sales_order += '<div class="second_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<span id="order_details_item_modifiers_id_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_id +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_price +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                              this_item.food_menu_id +
                              '">' +
                              selected_modifiers +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                              currency +
                              ' <span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              modifiers_price +
                              "</span></div>";
                          for (let mod_key in modifier_names_custom) {
                              let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                              let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                              draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                              draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                          }
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
                    if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                          draw_table_for_last_ten_sales_order +=
                              '<div class="third_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                              note_txt +
                              ': <span id="last_10_item_note_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.item_note+
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
  
                      draw_table_for_last_ten_sales_order += "</div>";
                  }
  
                  //add to top
                  $(".item_order_details .modifier_item_details_holder").empty();
                  $(".item_order_details .modifier_item_details_holder").prepend(
                      draw_table_for_last_ten_sales_order
                  );
                  let total_items_in_cart_with_quantity = 0;
                  $(".item_order_details .modifier_item_details_holder .single_item_modifier .first_portion .third_column span").each(function (i, obj) {
                      total_items_in_cart_with_quantity = parseInt(total_items_in_cart_with_quantity) + parseInt($(this).html());
                  });
  
                  $(".total_items_in_cart_last_10_").html(total_items_in_cart_with_quantity);
  
                  let sub_total_discount_last_10 = response.sub_total_discount_value != "" ? pOrAmount(response.sub_total_discount_value) : parseFloat(0).toFixed(ir_precision);
  
                  $(".sub_total_show_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                  $(".sub_total_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                  $(".total_item_discount_last_10_").html(Number(response.total_item_discount_amount).toFixed(ir_precision));
  
                  $(".discounted_sub_total_amount_last_10_").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                  $(".sub_total_discount_last_10_").html(pOrAmount(sub_total_discount_last_10));
                  $(".sub_total_discount_amount_last_10_").html(response.sub_total_with_discount);
  
                  let total_vat_section_to_show = "";
                  let total_vat_show = 0;
                  if (response.sale_vat_objects) {
                      $.each(response.sale_vat_objects, function (key, value) {
                          total_vat_section_to_show +=
                              '<span class="tax_field_order_details" id="tax_field_order_details_' +
                              value.tax_field_id +
                              '">' +
                              value.tax_field_type +
                              ":  " +
                              currency +
                              ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                              value.tax_field_id +
                              '">' +
                              Number(value.tax_field_amount).toFixed(ir_precision) +
                              "</span></span>";
                          total_vat_show+=(Number(value.tax_field_amount));
                      });
  
                  }
  
                  $(".all_items_vat_last_10_").html(total_vat_section_to_show);
                  $(".all_items_discount_last_10_").html(Number(response.total_discount_amount).toFixed(ir_precision));
                  $(".delivery_charge_last_10_").html(pOrAmount(response.delivery_charge));
  
                  if ((response.tips_amount_actual_charge)) {
                      $(".tips_amount_last_10_").html(pOrAmount(response.tips_amount));
                  } else {
                      $(".tips_amount_last_10_").html((0).toFixed(ir_precision));
                  }
                  $(".total_payable_last_10_").html(Number(response.total_payable).toFixed(ir_precision));
                  $(".recent_sale_modal_details_vat_").html(Number(total_vat_show).toFixed(ir_precision));
              });
          }
      });
  
    $(document).on("click", ".self_online_order_row", function () {
          //get sale id
   
          let sale_no = $(this).find(".first_column").text();
          $("#temp_sale_no").val(sale_no);
          $("#last_future_sale_id").val(sale_no);
          let this_a = $(this);
  
  
          //self order
          let status_for_self_order = $(this).find(".third_column").html();
  
          $("#status_for_self_order").val(status_for_self_order);
  
          let is_self_order = $("#is_self_order").val();
          let is_self_order_tmp = Number($("#is_self_order_tmp").val());
  
          if(is_self_order=="Yes" || is_self_order_tmp==1){
              $(".self_hide_div").hide();
              if(status_for_self_order=="Pending"){
                  $("#draft_edit_modal").show();
              }else{
                  $("#draft_edit_modal").hide();
              }
  
              if(is_self_order_tmp==1){
                  $("#draft_edit_modal").show();
              }
              //get all info of sale based on sale_id
              $.ajax({
                  url: base_url + "Sale/get_all_information_of_a_sale_ajax",
                  method: "POST",
                  dataType:'json',
                  data: {
                      sale_no: sale_no,
                      csrf_irestoraplus: csrf_value_,
                  },
                  success: function (data) {
                      let response = jQuery.parseJSON(data.self_order_content);
                      let order_type = "";
                      let order_type_id = 0;
                      let invoice_type = "";
  
                      if (response.order_type == 1) {
                          order_type = "Dine In";
                          order_type_id = 1;
                      } else if (response.order_type == 2) {
                          order_type = "Take Away";
                          order_type_id = 2;
                      } else if (response.order_type == 3) {
                          order_type = "Delivery";
                          order_type_id = 3;
                      }
                      $("#self_online_last_10_waiter_id_").html(response.waiter_id);
                      $("#self_online_last_10_waiter_name_").html("None");
                      $("#self_online_last_10_customer_id_").html(response.customer_id);
                      $("#self_online_last_10_customer_name_").html(response.customer_name);
                      $("#self_online_last_10_table_id_").html(response.table_id);
                      $("#self_online_last_10_table_name_").html((data.orders_table_text!=undefined && data.orders_table_text?data.orders_table_text:'None'));
                      $("#self_online_last_10_order_type_").html(order_type);
                      $("#self_online_last_10_order_type_id_").html(order_type_id);
                      let draw_table_for_last_ten_sales_order = "";
                      let draw_table_for_last_ten_sales_order_temp = "";
  
  
  
                      for (let key in response.items) {
                          //construct div
                          let this_item = response.items[key];
  
                          let selected_modifiers = "";
                          let selected_modifiers_id = "";
                          let selected_modifiers_price = "";
                          let modifiers_price = 0;
                          let total_modifier = 0;
                          if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
                              total_modifier = (this_item.modifiers_id.split(',')).length;
                          }
                          let i = 1;
                          let item_id = this_item.food_menu_id;
                          let draw_table_for_order_tmp_modifier_tax = "";
                          let modifier_ids_custom = [];
                          let modifier_names_custom = [];
                          let modifier_prices_custom = [];
                          if(total_modifier){
                              modifier_ids_custom = this_item.modifiers_id.split(',');
                              modifier_names_custom = this_item.modifiers_name.split(',');
                              modifier_prices_custom = this_item.modifiers_price.split(',');
                          }
                          let discount_value =
                              this_item.menu_discount_value != ""
                                  ? pOrAmount(this_item.menu_discount_value)
                                  : parseFloat(0).toFixed(ir_precision);
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_item_modifier fix" id="last_10_order_for_item_' +
                              this_item.food_menu_id +
                              '">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="first_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_vat_hold ir_display_none" id="last_10_item_vat_percentage_table' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_vat_percentage +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_discount_hold ir_display_none" id="last_10_item_discount_table' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.discount_amount +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span class="item_price_without_discount_hold ir_display_none" id="last_10_item_price_without_discount_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_price_without_discount +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix"><span id="last_10_item_name_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_name +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold second_column column fix">' +
                              currency +
                              ' <span id="last_10_item_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              Number(this_item.menu_unit_price).toFixed(ir_precision) +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold third_column column fix"><span id="last_10_item_quantity_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.qty +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="last_10_percentage_table_' +
                              this_item.food_menu_id +
                              '">' +
                              discount_value +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold fifth_column column fix">' +
                              currency +
                              ' <span id="last_10_item_total_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_price_with_discount +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
  
                          if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="third_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                                  combo_txt +
                                  ': <span id="last_10_item_combo_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  this_item.menu_combo_items +
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
                          if (total_modifier) {
                              draw_table_for_last_ten_sales_order += '<div class="second_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<span id="order_details_item_modifiers_id_table_' +
                                  this_item.food_menu_id +
                                  '" class="ir_display_none">' +
                                  selected_modifiers_id +
                                  "</span>";
                              draw_table_for_last_ten_sales_order +=
                                  '<span id="order_details_item_modifiers_price_table_' +
                                  this_item.food_menu_id +
                                  '" class="ir_display_none">' +
                                  selected_modifiers_price +
                                  "</span>";
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  selected_modifiers +
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                                  currency +
                                  ' <span id="order_details_item_modifiers_price_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  modifiers_price +
                                  "</span></div>";
                              for (let mod_key in modifier_names_custom) {
                                  let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                                  let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                                  draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                                  draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                              }
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
                          if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="third_portion">';
                              draw_table_for_last_ten_sales_order +=
                                  '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                                  note_txt +
                                  ': <span id="last_10_item_note_table_' +
                                  this_item.food_menu_id +
                                  '">' +
                                  this_item.item_note+
                                  "</span></div>";
                              draw_table_for_last_ten_sales_order += "</div>";
                          }
  
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
  
                      //add to top
                      $(".item_order_details .modifier_item_details_holder").empty();
                      $(".item_order_details .modifier_item_details_holder").prepend(
                          draw_table_for_last_ten_sales_order
                      );
                      let total_items_in_cart_with_quantity = 0;
                      $(".item_order_details .modifier_item_details_holder .single_item_modifier .first_portion .third_column span").each(function (i, obj) {
                          total_items_in_cart_with_quantity +=  parseInt($(this).text());
                      });
  
                      $(".total_items_in_cart_last_10_").html(total_items_in_cart_with_quantity);
  
                      let sub_total_discount_last_10 = response.sub_total_discount_value != "" ? pOrAmount(response.sub_total_discount_value) : parseFloat(0).toFixed(ir_precision);
  
                      $(".sub_total_show_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                      $(".sub_total_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                      $(".total_item_discount_last_10_").html(Number(response.total_item_discount_amount).toFixed(ir_precision));
  
                      $(".discounted_sub_total_amount_last_10_").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                      $(".sub_total_discount_last_10_").html(pOrAmount(sub_total_discount_last_10));
                      $(".sub_total_discount_amount_last_10_").html(response.sub_total_with_discount);
  
                      let total_vat_section_to_show = "";
                      
                      $(".all_items_vat_last_10_").html(total_vat_section_to_show);
                      $(".all_items_discount_last_10_").html(Number(response.total_discount_amount).toFixed(ir_precision));
                      $(".delivery_charge_last_10_").html(pOrAmount(response.delivery_charge));
  
                      if ((response.tips_amount_actual_charge)) {
                          $(".tips_amount_last_10_").html(pOrAmount(response.tips_amount));
                      } else {
                          $(".tips_amount_last_10_").html((0).toFixed(ir_precision));
                      }
                      $(".total_payable_last_10_").html(Number(response.total_payable).toFixed(ir_precision));
                      $(".recent_sale_modal_details_vat_").html(Number(response.total_vat).toFixed(ir_precision));
                  },
                  error: function () {
                      alert(a_error);
                  },
              });
          }else{
              $(".self_hide_div").show();
              getSelectedOrderDetailsRecentSale(sale_no).then(function(data){
                  let response = jQuery.parseJSON(data);
  
                  let order_type = "";
                  let order_type_id = 0;
                  let invoice_type = "";
  
                  if (response.order_type == 1) {
                      order_type = "Dine In";
                      order_type_id = 1;
                  } else if (response.order_type == 2) {
                      order_type = "Take Away";
                      order_type_id = 2;
                  } else if (response.order_type == 3) {
                      order_type = "Delivery";
                      order_type_id = 3;
                  }
                  $("#last_10_waiter_id_").html(response.waiter_id);
                  $("#last_10_waiter_name_").html(response.waiter_name);
                  $("#last_10_customer_id_").html(response.customer_id);
                  $("#last_10_customer_name_").html(response.customer_name);
                  $("#last_10_table_id_").html(response.table_id);
                  $("#last_10_table_name_").html((response.orders_table_text!=undefined && response.orders_table_text?response.orders_table_text:'None'));
                  $("#last_10_order_type_").html(order_type);
                  $("#last_10_order_type_id_").html(order_type_id);
                  let draw_table_for_last_ten_sales_order = "";
                  let draw_table_for_last_ten_sales_order_temp = "";
  
  
  
                  for (let key in response.items) {
                      //construct div
                      let this_item = response.items[key];
  
                      let selected_modifiers = "";
                      let selected_modifiers_id = "";
                      let selected_modifiers_price = "";
                      let modifiers_price = 0;
                      let total_modifier = 0;
                      if(this_item.modifiers_id!='' && this_item.modifiers_id!=undefined ){
                          total_modifier = (this_item.modifiers_id.split(',')).length;
                      }
                      let i = 1;
                      let item_id = this_item.food_menu_id;
                      let draw_table_for_order_tmp_modifier_tax = "";
                      let modifier_ids_custom = [];
                      let modifier_names_custom = [];
                      let modifier_prices_custom = [];
                      if(total_modifier){
                          modifier_ids_custom = this_item.modifiers_id.split(',');
                          modifier_names_custom = this_item.modifiers_name.split(',');
                          modifier_prices_custom = this_item.modifiers_price.split(',');
                      }
                      let discount_value =
                          this_item.menu_discount_value != ""
                              ? pOrAmount(this_item.menu_discount_value)
                              : parseFloat(0).toFixed(ir_precision);
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_item_modifier fix" id="last_10_order_for_item_' +
                          this_item.food_menu_id +
                          '">';
                      draw_table_for_last_ten_sales_order +=
                          '<div class="first_portion">';
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_vat_hold ir_display_none" id="last_10_item_vat_percentage_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_vat_percentage +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_discount_hold ir_display_none" id="last_10_item_discount_table' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.discount_amount +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<span class="item_price_without_discount_hold ir_display_none" id="last_10_item_price_without_discount_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_price_without_discount +
                          "</span>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold first_column column fix"><span id="last_10_item_name_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_name +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold second_column column fix">' +
                          currency +
                          ' <span id="last_10_item_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          Number(this_item.menu_unit_price).toFixed(ir_precision) +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold third_column column fix"><span id="last_10_item_quantity_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.qty +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold forth_column column fix"><span class="hold_special_textbox" id="last_10_percentage_table_' +
                          this_item.food_menu_id +
                          '">' +
                          discount_value +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order +=
                          '<div class="single_order_column_hold fifth_column column fix">' +
                          currency +
                          ' <span id="last_10_item_total_price_table_' +
                          this_item.food_menu_id +
                          '">' +
                          this_item.menu_price_with_discount +
                          "</span></div>";
                      draw_table_for_last_ten_sales_order += "</div>";
  
                      if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                          draw_table_for_last_ten_sales_order +=
                              '<div class="third_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                              combo_txt +
                              ': <span id="last_10_item_combo_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.menu_combo_items +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
                      if (total_modifier) {
                          draw_table_for_last_ten_sales_order += '<div class="second_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<span id="order_details_item_modifiers_id_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_id +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '" class="ir_display_none">' +
                              selected_modifiers_price +
                              "</span>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold ir_display_none first_column column fix"><span class="modifier_txt_custom" id="order_details_item_modifiers_table_' +
                              this_item.food_menu_id +
                              '">' +
                              selected_modifiers +
                              "</span></div>";
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold ir_display_none second_column column fix">' +
                              currency +
                              ' <span id="order_details_item_modifiers_price_table_' +
                              this_item.food_menu_id +
                              '">' +
                              modifiers_price +
                              "</span></div>";
                          for (let mod_key in modifier_names_custom) {
                              let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                              let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                              draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold first_column column fix"><span class="modifier_txt_custom">' + tmp_mod_name_m_n + "</span></div>";
                              draw_table_for_last_ten_sales_order += '<div class="single_order_column_hold second_column column fix">' + currency + ' <span>' + tmp_mod_name_m_p + "</span></div>";
                          }
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
                      if (this_item.item_note != "" && this_item.item_note!=undefined && this_item.item_note!="undefined") {
                          draw_table_for_last_ten_sales_order +=
                              '<div class="third_portion">';
                          draw_table_for_last_ten_sales_order +=
                              '<div class="single_order_column_hold first_column column fix modifier_txt_custom" >' +
                              note_txt +
                              ': <span id="last_10_item_note_table_' +
                              this_item.food_menu_id +
                              '">' +
                              this_item.item_note+
                              "</span></div>";
                          draw_table_for_last_ten_sales_order += "</div>";
                      }
  
                      draw_table_for_last_ten_sales_order += "</div>";
                  }
  
                  //add to top
                  $(".item_order_details .modifier_item_details_holder").empty();
                  $(".item_order_details .modifier_item_details_holder").prepend(
                      draw_table_for_last_ten_sales_order
                  );
                  let total_items_in_cart_with_quantity = 0;
                  $(".item_order_details .modifier_item_details_holder .single_item_modifier .first_portion .third_column span").each(function (i, obj) {
                      total_items_in_cart_with_quantity = parseInt(total_items_in_cart_with_quantity) + parseInt($(this).html());
                  });
  
                  $(".total_items_in_cart_last_10_").html(total_items_in_cart_with_quantity);
  
                  let sub_total_discount_last_10 = response.sub_total_discount_value != "" ? pOrAmount(response.sub_total_discount_value) : parseFloat(0).toFixed(ir_precision);
  
                  $(".sub_total_show_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                  $(".sub_total_last_10_").html(Number(response.sub_total).toFixed(ir_precision));
                  $(".total_item_discount_last_10_").html(Number(response.total_item_discount_amount).toFixed(ir_precision));
  
                  $(".discounted_sub_total_amount_last_10_").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                  $(".sub_total_discount_last_10_").html(pOrAmount(sub_total_discount_last_10));
                  $(".sub_total_discount_amount_last_10_").html(response.sub_total_with_discount);
  
                  let total_vat_section_to_show = "";
                  let total_vat_show = 0;
                  if (response.sale_vat_objects) {
                      $.each(response.sale_vat_objects, function (key, value) {
                          total_vat_section_to_show +=
                              '<span class="tax_field_order_details" id="tax_field_order_details_' +
                              value.tax_field_id +
                              '">' +
                              value.tax_field_type +
                              ":  " +
                              currency +
                              ' <span class="tax_field_amount_order_details" id="tax_field_amount_order_details_' +
                              value.tax_field_id +
                              '">' +
                              Number(value.tax_field_amount).toFixed(ir_precision) +
                              "</span></span>";
                          total_vat_show+=(Number(value.tax_field_amount));
                      });
  
                  }
  
                  $(".all_items_vat_last_10_").html(total_vat_section_to_show);
                  $(".all_items_discount_last_10_").html(Number(response.total_discount_amount).toFixed(ir_precision));
                  $(".delivery_charge_last_10_").html(pOrAmount(response.delivery_charge));
  
                  if ((response.tips_amount_actual_charge)) {
                      $(".tips_amount_last_10_").html(pOrAmount(response.tips_amount));
                  } else {
                      $(".tips_amount_last_10_").html((0).toFixed(ir_precision));
                  }
                  $(".total_payable_last_10_").html(Number(response.total_payable).toFixed(ir_precision));
                  $(".recent_sale_modal_details_vat_").html(Number(total_vat_show).toFixed(ir_precision));
              });
          }
      });
  
    $(document).on("click", "#draft_delete_modal", function (e) {
      let sale_no = $("#last_future_sale_id").val();
      let this_action = $(this);
      if (sale_no > 0) {
        if (role != "Admin") {
            toastr['error']((delete_only_for_admin), '');
          return false;
        } else {
          swal(
            {
              title: warning + "!",
              text: sure_remove_this_order,
              confirmButtonColor: "#3c8dbc",
              confirmButtonText: ok,
              showCancelButton: true,
            },
            function () {
              $.ajax({
                url: base_url + "Sale/set_as_running_order",
                method: "POST",
                data: {
                    sale_no: sale_no,
                  status: 1,
                  csrf_irestoraplus: csrf_value_,
                },
                success: function (response) {
                  response = JSON.parse(response);
                  $("#last_future_sale_id").val("");
                  this_action
                    .parent()
                    .parent()
                    .parent()
                    .removeClass("active")
                    .addClass("inActive");
                  setTimeout(function () {
                    $(".cus_pos_modal").removeClass("inActive");
                  }, 1000);
                  $(".pos__modal__overlay").fadeOut(300);
                  remove_all_cart_future_info();
                },
                error: function () {
                  alert(a_error);
                },
              });
            }
          );
        }
      } else {
          toastr['error']((please_select_an_order), '');
      }
    });
  
    setTimeout(function () {
      $("#show_tables_modal2").show();
    }, 1000);
    /**
     * All Script For All Mobile Devices
     */
    $(window).on("load", function () {
      if ($(this).width() < 600) {
        $("#calculator_main").css("left", 10 + "px");
      }
    });
  
    $(window).on("resize", function () {
      if ($(this).width() < 600) {
        $("#calculator_main").css("left", 10 + "px");
      }
    });
    /**
     * Working This function only for mobile devices
     */
    function forMobileDevice() {
      if (window.innerWidth < 600) {
        $(document).on("click", ".draft-sale .single_hold_sale", function () {
          $("#sale_hold_modal_order_details_list").fadeIn(300);
          $("#sale_hold_modal_order_info_list").fadeOut(200);
        });
        $(document).on(
          "click",
          ".recent-sales .single_last_ten_sale",
          function () {
            $("#recent_sales_order_details_list").fadeIn(300);
            $("#recent_sales_order_info_list").fadeOut(200);
          }
        );
      }
    }
    forMobileDevice();
  
    $(window).on("load", function () {
      $(".preloader").fadeOut(500);
    });
    $(document).on("click", ".holder .order_details > .single_order", function (e) {
        $(".holder .order_details > .single_order").attr("data-selected", "unselected");
        $(this).attr("data-selected", "selected");
    });
    $(document).on("click", "#bill_show_details", function (e) {
      if (
        $(".holder .order_details > .single_order[data-selected=selected]")
          .length > 0
      ) {
        let sale_no = $(".holder .order_details .single_order[data-selected=selected]").find(".running_order_order_number").text();
        $.ajax({
          url: base_url + "Sale/getBillDetails",
          method: "POST",
          data: { sale_no: sale_no },
          dataType: "json",
          success: function (response) {
            if (response) {
              $(".show_bill_modal_content").html(response);
              $(".pos__modal__overlay").fadeIn(300);
              $("#bill_modal").addClass("active");
            }
          },
          error: function () {},
        });
      } else {
          toastr['error']((please_select_open_order), '');
      }
    });
  
  
    const notification_list_holder = new PerfectScrollbar("#notification_list_holder", {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20,
    });
    notification_list_holder.update();
  
    const scrollable = new PerfectScrollbar(".scrollable", {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20,
    });
    scrollable.update();
  
    const order_table_holder = new PerfectScrollbar(".cardIsEmpty", {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20,
    });
    order_table_holder.update();
  
      $(document).on("click", ".custom_li", function (e) {
          let row =  $(this).attr("data-row");
          $(".class_check").prop('checked',false);
          $("#myCheckbox"+row).prop('checked',true);
  
      });
  
      $(document).on("click", ".label_c_kitchen", function (e) {
          let row =  $(this).attr("data-row");
          $("#myCheckboxKitchen"+row).prop('checked',true);
      });
  
      $(document).on("click", "#click_here_to_uncheck", function (e) {
          $(".class_check").prop('checked',false);
      });
  
  
  
  
      $(document).on(
          "click",
          "#dp_modal_cancel_button",
          function (e) {
              $(this)
                  .parent()
                  .parent()
                  .parent()
                  .parent()
                  .removeClass("active")
                  .addClass("inActive");
              setTimeout(function () {
                  $(".modal").removeClass("inActive");
              }, 1000);
              $(".pos__modal__overlay").fadeOut(300);
          }
      );
      //for tablet js
    $(document).on("click", ".tablet_btn", function (e) {
      let id_btn = Number($(this).attr("data-id"));
      $(".type_temp_div").removeClass("active_tmp_btn");
      $(this).addClass("active_tmp_btn");
  
      if (id_btn == 1) {
        $(".dine_in_button").click();
      } else if (id_btn == 2) {
        $(".take_away_button").click();
      } else if (id_btn == 3) {
        $(".delivery_button").click();
      }
    });
  
    $(document).on("click", ".btn_type_temp_c", function (e) {
      if ($(this).parent().hasClass("custom_active")) {
        $(this).parent().removeClass("custom_active");
      } else {
        $(this).parent().addClass("custom_active");
      }
    });
  
    $(window).click(function (event) {
      if ($(event.target).closest("li.has__children").length === 0) {
        $(".has__children").children(".sub__menu").slideUp(333);
      }
    });
  
    $(document).on("change", "#walk_in_customer1", function (e) {
      let this_value = $(this).val();
      $("#walk_in_customer").val(this_value).change();
    });
  
    $(document).on("change", "#select_waiter1", function (e) {
      let this_value = $(this).val();
      $("#select_waiter").val(this_value).change();
    });
  
    $(document).on("click", "#change_delivery_address", function (e) {
        let sale_id = $(".single_last_ten_sale[data-selected=selected]").attr("id").substr(9);
        let status = $(this).attr("data-status");
  
        $("#sale_id_hidden_d").val(sale_id);
        $("#status_modal").val(status).change();
  
        $("#delivery_status_change").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
    });
    $(document).on("click", ".save_change_status", function (e) {
        let status = $("#status_modal").val();
        let sale_id = $("#sale_id_hidden_d").val();
        let csrf_name_ = $("#csrf_name_").val();
        let csrf_value_ = $("#csrf_value_").val();
        let this_action =  $(this);
        $.ajax({
            url: base_url + "Sale/change_status_of_a_sale_ajax",
            method: "POST",
            data: {
                sale_id: sale_id,
                status: status,
                csrf_name_: csrf_value_,
            },
            success: function (response) {
                $("#change_date_sale_modal").val("");
                $("#sale_id_hidden").val("");
  
                this_action.parent()
                    .parent()
                    .parent()
                    .parent()
                    .removeClass("active")
                    .addClass("inActive");
                setTimeout(function () {
                    $(".modal").removeClass("inActive");
                }, 1000);
                $(".pos__modal__overlay").fadeOut(300);
            },
            error: function () {
                alert("error");
            },
        });
    });
  
  
  
    $(document).on("change", ".select_restaurant", function (e) {
      let this_value = $(this).val();
      let company_id = $(this).find(":selected").attr("data-company_id");
      window.location.href =
        base_url + "authentication/setOutlet/" + this_value + "/" + company_id;
    });
  
  
    $(document).on("click", ".get_area_table", function (e) {
      let id = $(this).attr('data-id');
      if(id=="all"){
          $(".area_all_table").show(300);
      }else{
        $(".area_all_table").hide();
        $(".area_table_"+id).show(300);
      }
    });
  
    $(document).on("click", ".get_prom_details", function (e) {
        $("#show_modal_view_promo").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        $.ajax({
            url: base_url + "get_prom_details",
            method: "POST",
            dataType:'json',
            success: function (response) {
                $("#body_promo_view").html(response);
            },
            error: function () {
  
            },
        });
  
    });
  
    $(document).on("click", ".get_prom_details", function (e) {
        $("#show_modal_view_promo").addClass("active");
        $(".pos__modal__overlay").fadeIn(200);
        $.ajax({
            url: base_url + "get_prom_details",
            method: "POST",
            dataType:'json',
            success: function (response) {
                $("#body_promo_view").html(response);
            },
            error: function () {
  
            },
        });
  
    });
  
      $(document).on("click", ".custom_li_order_type", function (e) {
         let row_class = $(this).attr('data-row');
         let last_click_item_id = $("#last_click_item_id").val();
          $(this)
              .parent()
              .parent()
              .parent()
              .parent()
              .parent()
              .removeClass("active")
              .addClass("inActive");
          setTimeout(function () {
              $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
  
         $("."+row_class).click();
         if(row_class!="delivery_button"){
             $("#item_"+last_click_item_id).click();
         }
      });
  
  
  
    // $(window).on("load", function () {
    //   body_el.find(".wrapper").next("div").remove();
    // });
  
  
    /**
     * Click to Show Categories
     */
    body_el.on("click", ".open-category-list", function () {
      body_el.find('.cat-list-wrapper').toggleClass('active')
    });
    win.on("click", function (e) {
      if( $(e.target).closest('.list-of-item,.open-category-list').length === 0 ){
        body_el.find('.cat-list-wrapper').removeClass('active');
      }
    });
    win.on('click', function(e){
      if($(e.target).closest('.type-dropdown,.tablet_btn,.place_order_operation').length === 0){
        body_el.find('.type-btn-list').removeClass('custom_active')
      }
    });
  
      function put_cart_content(){
          let total_items_in_cart = Number($("#total_items_in_cart_with_quantity").html());
          let total_cart_qty2 = 0;
          let counter = 0;
          $(".decrease_item_table").each(function() {
              total_cart_qty2 += Number($(this).parent().find('span').html());
              counter++;
          });
          let sub_total = parseFloat($("#sub_total_show").html()).toFixed(ir_precision);
          let discounted_sub_total_amount = pOrAmount($("#show_discount_amount").html());
          let total_vat = parseFloat($("#show_vat_modal").html()).toFixed(ir_precision);
          let total_payable = parseFloat($("#total_payable").html()).toFixed(ir_precision);
          let total_tips = parseFloat($("#show_tips_amount").html()).toFixed(ir_precision);
          let total_discount_amount = parseFloat($("#all_items_discount").html()).toFixed(ir_precision);
          let delivery_charge =
              $("#show_charge_amount").html() != "0.00"
                  ? parseFloat($("#show_charge_amount").html()).toFixed(ir_precision)
                  : parseFloat(0).toFixed(ir_precision);
          let sub_total_discount_value = $("#sub_total_discount1").val();
  
          let order_info = "{";
          order_info += '"total_items_in_cart":"' + counter + '",';
          order_info += '"total_items_with_qty_in_cart":"' + total_cart_qty2 + '",';
          order_info += '"sub_total":"' + sub_total + '",';
          order_info += '"total_vat":"' + total_vat + '",';
          order_info += '"total_payable":"' + total_payable + '",';
          order_info += '"total_discount_amount":"' + total_discount_amount + '",';
          order_info += '"actual_discount":"' + discounted_sub_total_amount + '",';
          order_info += '"delivery_charge":"' + delivery_charge + '",';
          order_info += '"total_tips":"' + total_tips + '",';
          order_info +=
              '"sub_total_discount_value":"' + sub_total_discount_value + '",';
          let items_info = "";
          items_info += '"items":';
          items_info += "[";
          if (Number($(".customer_panel").length) > 0) {
              let k = 1;
              $(".customer_panel").each(function (i, obj) {
                  let item_id = Number($(this).attr('data-id'));
                  let cp_type = Number($(this).attr('data-cp_type'));
  
                  let item_name = '';
                  let item_modifiers = '';
  
                  let item_vat = 0;
                  let item_unit_price ='';
                  let percentage_table = '';
                  let item_discount_table = '';
                  let item_quantity = '';
                  let total_price = 0;
                  let row_type = cp_type;
                  let modifiers_name = '';
                  let modifiers_price = '';
                  let item_note = '';
  
                  if(cp_type===1){
                      item_name = $(this).find(".first_column").find("span").eq(0).text();
                      item_note = $(this).find(".third_portion").find('span').text();
                      let child_name = $(".customer_panel_child_"+item_id).text();
                      let cp_type_tmp = Number($(".customer_panel_child_"+item_id).attr('data-cp_type'));
                      if(child_name && child_name!=undefined && cp_type_tmp==33){
                          item_name+="<br>"+child_name;
                      }
                      if(child_name && child_name!=undefined && cp_type_tmp==3){
                          let  j = 1;
                          let ii = 1;
                          $(".3_cp_price_"+item_id).each(function (i, obj) {
                            $(this).attr('id',"3_cp_price_"+item_id+""+ii);
                            ii++;
                          });
                          let m = 1;
                          $(".customer_panel_child_"+item_id).each(function (i, obj) {
                              modifiers_name+=$(this).text();
                              modifiers_name+= (j == Number($(".customer_panel_child_"+item_id).length)) ? "" : "|||";
  
                              modifiers_price+=$('#3_cp_price_'+item_id+""+m).text();
                              modifiers_price+= (j == Number($(".customer_panel_child_"+item_id).length)) ? "" : "|||";
                              j++;
                          });
                      }
                      item_unit_price = $(this).find(".second_column").find('span').eq(0).text();
                      item_quantity = $(this).find(".third_column").find('span').eq(0).text();
                      item_discount_table = $(this).find(".forth_column").find('input').val();
                      total_price = $(this).find(".fifth_column").find('span').eq(0).text();
                  }else if(cp_type===4){
                      item_name = $(this).parent().find(".first_column").find("span").eq(0).text();
                      item_quantity = $(this).parent().find(".third_column").find('span').eq(0).text();
                  }
  
                  items_info +=
                      '{"item_id":"' +
                      item_id +
                      '", "row_type":"' +
                      row_type +
                      '", "item_name":"' +
                      item_name+
                      '", "item_note":"' +
                      item_note +
                      '", "modifiers_name":"' +
                      modifiers_name +
                      '", "modifiers_price":"' +
                      modifiers_price +
                      '", "item_vat":' +
                      item_vat +
                      ",";
                  items_info +=
                      '"item_unit_price":"' +
                      item_unit_price +
                      '", "percentage_table":"' +
                      percentage_table +
                      '", "item_discount_table":"' +
                      item_discount_table+
                      '", "total_price":"' +
                      total_price +
                      '","item_quantity":"' +
                      item_quantity +'"';
                  items_info += (k == Number($(".customer_panel").length)) ? "}" : "},";
                  k++;
              });
          }
          items_info += "]";
          order_info += items_info + "}";
  
          let order_object = JSON.stringify(order_info);
          $.ajax({
              url: base_url + "put-customer-panel-data",
              method: "POST",
              dataType:'json',
              data: {
                  order: order_object
              },
              success: function (response) {
                    $("#zatca_invoice_value").val(response);
              },
              error: function () {
  
              },
          });
      }
  
      const dineIn_item_list = new PerfectScrollbar(".dineIn-table-list-of-item", {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20,
      });
      dineIn_item_list.update();
  
      const all_dineIn_table = new PerfectScrollbar(".all-dineIn-table", {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 20,
      });
      all_dineIn_table.update();
  
  
  
  
      /**
       * Order Payment Modal Script
       */
  
  
      const payment_list = new PerfectScrollbar(".list-for-payment-type", { //Scrollbar for payment List
          wheelSpeed: 2,
          wheelPropagation: true,
          minScrollbarLength: 20,
      });
  
      const thirdLi = new PerfectScrollbar("li.third ul", { //Scrollbar for demotional
          wheelSpeed: 2,
          wheelPropagation: true,
          minScrollbarLength: 20,
      });
  
      const paid_list =new PerfectScrollbar(".paid-list", { //Scrollbar for paid_list
          wheelSpeed: 2,
          wheelPropagation: true,
          minScrollbarLength: 20,
      });
  
      const payment_content = new PerfectScrollbar("#tabs", { //Scrollbar for payment-content
          wheelSpeed: 2,
          wheelPropagation: true,
          minScrollbarLength: 20,
      });
  
      payment_content.update();
      payment_list.update();
      thirdLi.update();
      paid_list.update();
  
      function set_default_payment(){
          let default_payment_hidden = Number($("#default_payment_hidden").val());
          if(default_payment_hidden){
              $(".set_payment").each(function (i, obj) {
                  let id = Number($(this).attr('data-id'));
                  if(id==default_payment_hidden){
                      $(this).click();
                  }
              });
          }else{
              $(".set_payment").each(function (i, obj) {
                  let id = ($(this).text());
                  if(id=="Cash"){
                      $(this).click();
                  }
              });
          }
      }
        function getRotatedValue(value){
          return (value*(-1));
        }
  
        function setRotatedTable(){
              $(".table_bg").find(".get_table_details").each(function() {
                  let this_action = $(this);
                  let transformValue = this_action.parent().attr('style');
                  let rotated_value = '';
                  if(transformValue){
                      let rotateDigits = transformValue.match(/rotate\((\d+)deg\)/);
                      if(rotateDigits !== null && rotateDigits !== undefined  && rotateDigits !== "null"){
                          if(rotateDigits[1]){
                              $(this).css("transform","rotate("+(getRotatedValue(rotateDigits[1]))+"deg)");
                          }
                      }
                  }
              });
        }
  
        function setOrderTabless(order_number,table_number,waiter_name,total_payable,sale_id,table_id,order_details,merge_id){
          $(".table_bg").find(".get_table_details").each(function() {
              let design_table_no = ($(this).attr('data-name'));
              let this_action = $(this);
              if(design_table_no==table_number){
                  this_action.attr("data-booked_id",sale_id);
                  this_action.attr("data-merge_id",merge_id);
                  this_action.attr("data-order_number",order_number);
                  let ordered_border_color_hidden = $("#ordered_border_color_hidden").val();
                  let ordered_bg_color_hidden = $("#ordered_bg_color_hidden").val();
                  let ordered_text_color_hidden = $("#ordered_text_color_hidden").val();
                  this_action.parent().css("border","1px solid "+ordered_border_color_hidden);
                  this_action.parent().css("background-color",ordered_bg_color_hidden);
                  this_action.parent().css("color",ordered_text_color_hidden);
                  let tootip_content = '<div><span>'+inv_table+': '+table_number+'</span><br><hr>'+inv_waiter+': '+waiter_name+'<br>'+inv_order_number+': '+order_number+'<br>'+inv_total_payable+': '+total_payable+'</div>';
                  let split_order = order_number.split("-");
                  let html_content = '<div class="set_tooltip" data-tippy-content="'+tootip_content+'"><span class="table_design_table_number">'+table_number+'</span><br><hr class="table_design_hr">'+waiter_name+'<br>'+split_order[1]+'</div>';
                  this_action.html(html_content);
                  this_action.append('<div style="display:none" class="sale_object">'+order_details+'</div>');
                
                  tippy(".set_tooltip", {
                      animation: "scale",
                      allowHTML: true,
                    }); 
              }else{
                  let booked_id = this_action.attr("class");
                  let booked_i1d = this_action.attr("data-booked_id");
              }
          });
  
          setRotatedTable();
      }

       
      $(document).on("click", ".div_rectangular", function (e) {
          let hidden_table_capacity = $(this).find(".get_table_details").attr("data-hidden_table_capacity");
          $("#hidden_table_capacity").val(hidden_table_capacity);
  
          let is_click_transfer_table = Number($("#is_click_transfer_table").val());
          let this_active  = 0;
          let this_action = $(this);
          $(".div_rectangular").each(function (i, obj) {
              if ($(this).hasClass("div_rectangular_active")) {
                  this_active = Number($(this).find(".trigger_to_select_other").attr("data-id"));
              }
          });
  
          
          if (this_action.hasClass("div_rectangular_active")) {
              if(!is_click_transfer_table){
                  this_action.removeClass("div_rectangular_active");
              }
          } else {
              let button_active = Number(this_action.find(".trigger_to_select_other").attr("data-id"));
              if(this_active!=button_active){
                  this_action.addClass("div_rectangular_active");
              }
          }
          let is_active_action  = '';
          $(".table_bg").find(".div_rectangular").each(function (i, obj) {
              if ($(this).hasClass("div_rectangular_active")) {
                  is_active_action = $(this);
              }
          });
          
          let table_id = is_active_action.find(".get_table_details").attr("data-id");
          let table_name = is_active_action.find(".get_table_details").attr("data-name");
          let booked_id = Number(is_active_action.find(".get_table_details").attr("data-booked_id"));
          let order_number = (is_active_action.find(".get_table_details").attr("data-order_number"));
      
          if(booked_id){
              
          }else{
                toastr['success']((you_are_ordering_now_on_your_selected_table), '');
                    $("#table_id").val(table_id);
                    $("#hidden_table_name").val(table_name);
                    if(table_name){
                      $("#table_button").html("<i class='fal fa-table'></i> "+table_text+":"+table_name);
                      $("#table_button").addClass("red_text");
                    }
                    

                    $(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .removeClass("active")
                    .addClass("inActive");
                    setTimeout(function () {
                        $(".modal").removeClass("inActive");
                    }, 1000);

                    $("#show_tables_modal2").removeClass("active");
                    $(".pos__modal__overlay").fadeOut(300);
          }
      });


  
  
      $(document).on("click", ".get_area_table", function (e) {
          $(".get_area_table").removeAttr("style");
          let id = $(this).attr('data-id');
          let this_floor_design = $(this).parent().find(".set_design").html();
          $(".table_bg").html(this_floor_design); 
  
          $(".div_box").find('h5').removeAttr("contenteditable");

          if(checkInternetConnection()){
            $(".table_bg").find(".get_table_details").each(function() {
                let table_id = ($(this).attr('data-id'));
                let table_name = ($(this).attr('data-name'));
                let this_action = $(this);
                let selected_row = $(this).find(".set_tooltip");
                
                    $.ajax({
                    url: base_url + "Sale/getKitchenStatus",
                    method: "POST",
                    dataType:'json',
                    data:{table_id:table_id},
                    success: function (response) {
                        if(response.html_content){
                            selected_row.attr("data-tippy-content",response.html_content);
                            this_action.attr("data-booked_id",response.sale_id);
                            this_action.attr("data-merge_id",response.is_merge);
                            this_action.attr("data-order_number",response.order_number);
                            let table_number = table_name;
                            let waiter_name = response.waiter_name;
                            let total_payable = response.total_payable;

                            let tootip_content = '<div><span>'+inv_table+': '+table_number+'</span><br><hr>'+inv_waiter+': '+waiter_name+'<br>'+inv_order_number+': '+response.order_number+'<br>'+inv_total_payable+': '+total_payable+'</div>';
                            tootip_content+=response.html_content;
                            let split_order = (response.order_number).split("-");
                            let html_content = '<div class="set_tooltip" data-tippy-content="'+tootip_content+'"><span class="table_design_table_number">'+table_number+'</span><br><hr class="table_design_hr">'+waiter_name+'<br>'+split_order[1]+'</div>';
                            this_action.html(html_content);
                            this_action.append('<div style="display:none" class="sale_object">'+response.self_order_content+'</div>');
                            tippy(".set_tooltip", {
                                animation: "scale",
                                placement: "bottom-start",
                                maxWidth: '45em',
                                allowHTML: true,
                                });
                        }
                        

                    },
                    error: function () {
                            
                    },
                });


            });
           }else{
                    //append ordered tables
                $(".running_order_custom").each(function() {
                    let order_number = $(this).find(".running_order_order_number").text();
                    let table_number = $(this).find(".running_order_table_name").text();
                    let waiter_name = $(this).find(".running_order_waiter_name").text();
                    let total_payable = inv_currency + ($(this).attr("data-total_payable"));
                    let merge_id = $(this).attr("data-merge_id");
                    let order_details = $(this).find(".order_details").text();
                    let sale_id = Number($(this).attr("data-sale_id"));
                    let table_id = Number($(this).attr("data-table_id"));
                    setOrderTabless(order_number,table_number,waiter_name,total_payable,sale_id,table_id,order_details,merge_id);
                });
           }

          
      });
      
    
  
      function cal_finalize_modal(is_ignore){
          let finalize_total_payable = Number($("#finalize_total_payable").html());
          let is_multi_currency = Number($("#is_multi_currency").val());
  
          let tmp_total = 0;
          $(".payment_list_amount").each(function (i, obj) {
              let this_txt = Number($(this).text());
              tmp_total+=this_txt;
          });
  
          let multi_currency_amount = Number($("#multi_currency_amount").val());
          if(is_multi_currency ==1 && multi_currency_amount){
              tmp_total = finalize_total_payable;
          }
  
          $("#finalize_total_paid").html(tmp_total.toFixed(ir_precision));
          $("#finalize_total_due").html((finalize_total_payable - tmp_total).toFixed(ir_precision));
  
          let default_remaining_cash = (finalize_total_payable - tmp_total) && (finalize_total_payable - tmp_total)>0?(finalize_total_payable - tmp_total):0;
          $(".set_default_quick_cach").attr("data-amount",(default_remaining_cash).toFixed(ir_precision));
          $(".set_default_quick_cach").html((default_remaining_cash).toFixed(ir_precision));
      }
      function setAnimation() {
          let imgToDrag = $("#cash_img").eq(0);
          let cart = $(".payment_list_counter").find("span").last();
          if (imgToDrag) {
              let top_ = Number(imgToDrag.offset().top);
  
              let imgClone = imgToDrag
                  .clone()
                  .offset({
                      top: top_,
                      left: imgToDrag.offset().left,
                  })
                  .css({
                      opacity: "0.5",
                      position: "absolute",
                      height: "150px",
                      width: "150px",
                      zIndex: "1000",
                  })
                  .appendTo($("body"))
                  .animate(
                      {
                          top: cart.offset().top + 10,
                          left: cart.offset().left + 10,
                          width: "75px",
                          height: "75px",
                      },
                      1000,
                      "easeInOutExpo"
                  );
              imgClone.animate(
                  {
                      width: 0,
                      height: 0,
                  },
                  function () {
                      $(this).detach();
                  }
              );
          }
      }
      $(document).on("click", "#create_invoice_and_close", function (e) {
          let pos_11 = Number($("#pos_11").val());
          if(pos_11){
            $(".finalize_modal_is_mul_currency").hide(300);
            $(".order-payment-wrapper").find('.order-payment-list').fadeIn(0);

              $("#print_type").val(1);
              $("#is_split_bill").val('');
              $("#sub_total_discount_finalize").val('');
              if (
                  $(".holder .order_details > .single_order[data-selected=selected]")
                      .length > 0
              ) {
                  let sale_id = $(".holder .order_details .single_order[data-selected=selected]").attr("id").substr(6);
                  let order_type = Number($(".holder .order_details .single_order[data-selected=selected]").attr("order_type"));
                  let split_bill = Number($("#split_bill").val());
  
                  if(pre_or_post_payment==2){
                    let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                    let res_checker = getSelectedOrderDetails(sale_no).then(function(data){ 
                          let is_invoice = data.is_invoice;
                          if(is_invoice==2){
                              let invoiced_error = $("#invoiced_error").val();
                              toastr['error']((invoiced_error + "!"), '');
                          }else{
                              if(order_type==1){
                                  body_el.find('.invoice_box').toggleClass('active');
                              }else{
                                let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                                let res = getSelectedOrderDetails(sale_no).then(function(data){
                                      let response = jQuery.parseJSON(data);
  
                                      if(response !== null) {
                                          $(".empty_title").show();
                                          $("#payment_list_div").html('');
  
                                          if(response.orders_table_text){
                                            $(".table_number").parent().show();
                                            $(".table_number").html(response.orders_table_text);
                                            }else{
                                                $(".table_number").html("-");
                                                $(".table_number").parent().hide();
                                            }
                
                                            if(response.order_time){
                                                $(".order_taking_time").parent().show();
                                                $(".order_taking_time").html(response.order_time);
                                            }else{
                                                $(".order_taking_time").html("-");
                                                $(".order_taking_time").parent().hide();
                                            }

                                            
                                          $("#finalize_total_payable").html(Number(response.total_payable).toFixed(ir_precision));
                                          $("#finalize_total_payable").attr('data-original_payable',Number(response.total_payable).toFixed(ir_precision));
                                          $("#finalize_total_due").html(response.total_payable);
                                          $("#selected_invoice_sale_customer").val(response.customer_id);
                                          $("#pay_amount_invoice_input").val(response.total_payable);
  
                                          $("#order_payment_modal").removeClass("inActive");
                                          $("#order_payment_modal").addClass("active");
                                          $(".pos__modal__overlay").fadeIn(200);
                                          checkSMSDisabled(response.customer_id);
                                          $("#open_invoice_date_hidden").val(response.sale_date);
                                          $("#last_future_sale_id").val(response.sale_no);
  
                                          if(Number(response.previous_due_tmp)){
                                              $(".previous_due_div").css('opacity','1');
                                              $("#finalize_previous_due").html(Number(response.previous_due_tmp).toFixed(ir_precision));
  
                                          }else{
                                              $(".previous_due_div").css('opacity','0');
                                          }
                                          $("#is_multi_currency").val('');
                                          $(".set_no_access").removeClass('no_access');
                                          $(".finalize_modal_is_mul_currency").hide(300);
                                          $("#finalize_amount_input").html('');
                                          $(".badge_custom").remove();
                                          $(".previous_due_div").show();
                                          $(".loyalty_point_div").hide();
                                          //cart details button
                                          $("#cart_modal_total_item_text").html(Number(response.total_items_in_cart).toFixed(0));
                                          $("#cart_modal_total_subtotal_text").html(Number(response.sub_total).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_text").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_all_text").html(Number(response.total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(response.total_discount_amount).toFixed(ir_precision));
                                          $("#cart_modal_total_tax_text").html(Number(response.total_vat).toFixed(ir_precision));
                                          $("#cart_modal_total_charge_text").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                                          $("#cart_modal_total_tips_text").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                                          $("#cart_modal_total_rounding_texts").html(Number(response.rounding_amount_hidden).toFixed(ir_precision));
  
  
                                          set_default_payment();
                                          cal_finalize_modal('');
                                          $(".datepicker_custom")
                                              .datepicker({
                                                  autoclose: true,
                                                  format: "yyyy-mm-dd",
                                                  startDate: "0",
                                                  todayHighlight: true,
                                              })
                                              .datepicker("update", response.sale_date);
  
                                          $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
                                      }
                                  });
                              }
                          }
                      });
                  }else{
                      if(order_type==1){
                          body_el.find('.invoice_box').toggleClass('active');
                      }else{
                        let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
                        let res = getSelectedOrderDetails(sale_no).then(function(data){ 
                            let response = jQuery.parseJSON(data);
                              if(response !== null) {
                                  $(".empty_title").show();
                                  $("#payment_list_div").html('');
  
                                  if(response.orders_table_text){
                                    $(".table_number").parent().show();
                                    $(".table_number").html(response.orders_table_text);
                                    }else{
                                        $(".table_number").html("-");
                                        $(".table_number").parent().hide();
                                    }
        
                                    if(response.order_time){
                                        $(".order_taking_time").parent().show();
                                        $(".order_taking_time").html(response.order_time);
                                    }else{
                                        $(".order_taking_time").html("-");
                                        $(".order_taking_time").parent().hide();
                                    }

                                    
                                  $("#finalize_total_payable").html(Number(response.total_payable).toFixed(ir_precision));
                                  $("#finalize_total_payable").attr('data-original_payable',Number(response.total_payable).toFixed(ir_precision));
                                  $("#finalize_total_due").html(response.total_payable);
                                  $("#selected_invoice_sale_customer").val(response.customer_id);
                                  $("#pay_amount_invoice_input").val(response.total_payable);
  
                                  $("#order_payment_modal").removeClass("inActive");
                                  $("#order_payment_modal").addClass("active");
                                  $(".pos__modal__overlay").fadeIn(200);
                                  checkSMSDisabled(response.customer_id);
                                  $("#open_invoice_date_hidden").val(response.sale_date);
                                  $("#last_future_sale_id").val(response.sale_no);
  
  
                                  if(Number(response.previous_due_tmp)){
                                      $(".previous_due_div").css('opacity','1');
                                      $("#finalize_previous_due").html(Number(response.previous_due_tmp).toFixed(ir_precision));
  
                                  }else{
                                      $(".previous_due_div").css('opacity','0');
                                  }
                                  $("#is_multi_currency").val('');
                                  $(".set_no_access").removeClass('no_access');
                                  $(".finalize_modal_is_mul_currency").hide(300);
                                  $("#finalize_amount_input").html('');
                                  $(".badge_custom").remove();
                                  $(".previous_due_div").show();
                                  $(".loyalty_point_div").hide();
                                  //cart details button
                                  $("#cart_modal_total_item_text").html(Number(response.total_items_in_cart).toFixed(0));
                                  $("#cart_modal_total_subtotal_text").html(Number(response.sub_total).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_text").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_all_text").html(Number(response.total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(response.total_discount_amount).toFixed(ir_precision));
                                  $("#cart_modal_total_tax_text").html(Number(response.total_vat).toFixed(ir_precision));
                                  $("#cart_modal_total_charge_text").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                                  $("#cart_modal_total_tips_text").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                                  $("#cart_modal_total_rounding_texts").html(Number(response.rounding_amount_hidden).toFixed(ir_precision));
  
  
                                  set_default_payment();
                                  cal_finalize_modal('');
                                  $(".datepicker_custom")
                                      .datepicker({
                                          autoclose: true,
                                          format: "yyyy-mm-dd",
                                          startDate: "0",
                                          todayHighlight: true,
                                      })
                                      .datepicker("update", response.sale_date);
  
                                  $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
                              }
                          });
                      }
                  }
  
              } else {
                  toastr['error']((please_select_order_to_proceed + "!"), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  
  
  
      });
  
      function populateRemainingTable(){
        let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
        let res = getSelectedOrderDetails(sale_no).then(function(data){
              let response = jQuery.parseJSON(data);
              if (response !== null) {
                  $(".current_object_tables").html(JSON.stringify(response.orders_table));
                  $(".current_text_tables").html(response.orders_table_text);
  
              }
          });
      }
      function split_bill(){
          $("#sub_total_discount_finalize").val('');
          let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
          let res = getSelectedOrderDetails(sale_no).then(function(data){
              let response = jQuery.parseJSON(data);
              if(response !== null) {
                  $(".current_object_tables").html(JSON.stringify(response.orders_table));
                  $(".current_text_tables").html(response.orders_table_text);
  
                  let html_row = '';
                  let j =1;
                  for (let key in response.items) {
                      //construct div
                      let this_item = response.items[key];
                      let tax_per_unit = 0;
  
                      $.each((this_item.item_vat), function(key, value){
                          tax_per_unit +=Number(value.item_vat_amount_for_unit_item);
                      });
                      let vat_amount = collect_tax == "Yes" ? get_total_vat_for_split(response.customer_id,this_item.item_vat,this_item.menu_price_with_discount) : null;
                      let total_vat_amount = 0;
                      $.each(vat_amount, function (key, value) {
                          let vat_tmp = 0;
                          if (value && value != "NaN") {
                              vat_tmp = Number(value).toFixed(ir_precision);
                          }
                          total_vat_amount = (parseFloat(total_vat_amount) + parseFloat(vat_tmp));
                      });
                      let tax_per_unit_tmp = (Number(total_vat_amount)/(Number(this_item.qty))).toFixed(ir_precision);
  
                      let split_menu_combo_items =  '';
                      let split_menu_combo_items_plan_text =  '';
                      let split_menu_note =  '';
                      if (this_item.menu_combo_items != "" && this_item.menu_combo_items!=undefined  && this_item.menu_combo_items!=null && this_item.menu_combo_items!="undefined") {
                          split_menu_combo_items+="<br>"+combo_txt+''+this_item.menu_combo_items;
                          split_menu_combo_items_plan_text+=this_item.menu_combo_items;
                      }
                      let split_modifier_name = '';
                      let split_modifier_price = '';
                      let modifier_ids_custom = [];
                      let modifier_names_custom = [];
                      let modifier_prices_custom = [];
                      let total_modifier = 0;
                      if(this_item.modifiers_id!=''){
                          total_modifier = (this_item.modifiers_id.split(',')).length;
                      }
                      if(total_modifier){
                          modifier_ids_custom = this_item.modifiers_id.split(',');
                          modifier_names_custom = this_item.modifiers_name.split(',');
                          modifier_prices_custom = this_item.modifiers_price.split(',');
                      }
                      let modifier_vats = (this_item.modifier_vat).split("|||");
                      for (let mod_key in modifier_names_custom) {
                          let tmp_mod_name_m_n = modifier_names_custom[mod_key];
                          let tmp_mod_name_m_p = Number(modifier_prices_custom[mod_key]).toFixed(ir_precision);
                          let split_vat_amount = collect_tax == "Yes" ? get_total_vat_for_split(response.customer_id,JSON.parse(modifier_vats[mod_key]),(Number(tmp_mod_name_m_p) * Number(this_item.qty))) : null;
  
                          let total_split_vat_amount = 0;
                          $.each(split_vat_amount, function (key, value) {
                              let vat_tmp = 0;
                              if (value && value != "NaN") {
                                  vat_tmp = Number(value).toFixed(ir_precision);
                              }
                              total_split_vat_amount = (parseFloat(total_split_vat_amount) + parseFloat(vat_tmp));
                          });
  
                          let split_tax_per_unit_tmp = (Number(total_split_vat_amount)/Number(this_item.qty)).toFixed(ir_precision);
  
                          split_modifier_name += '<br><span data-modifier_id="'+modifier_ids_custom[mod_key]+'" class="split_modifier_name">' + tmp_mod_name_m_n + "</span>";
                          split_modifier_price +='<br><span  data-split_tax_per_unit="'+split_tax_per_unit_tmp+'"  data-per_unit_price="'+tmp_mod_name_m_p+'" class="split_modifier_price">' + tmp_mod_name_m_p + "</span>";
                      }
                      let is_free_item = '';
                      let tmp_j = 0;
                      if(Number(this_item.is_free)){
                          is_free_item = 'is_free_bg';
                          tmp_j = (j-1);
                      }
                      let discount_value =
                          this_item.item_discount_amount != ""
                              ? this_item.item_discount_amount
                              : 0;
                      let discount_per_unit = (Number(discount_value)/Number(this_item.qty));
  
  
  
                      html_row+='<tr class="row_items_spit" id="row_items_spit_'+tmp_j+'" data-sale_row_id="'+j+'" data-tax_per_unit="'+tax_per_unit_tmp+'" data-id="'+this_item.food_menu_id+'">\n' +
                          '                                    <td style="padding: 4px;"><div class="ir_display_none menu_taxes">'+JSON.stringify(this_item.item_vat)+'</div><span class="item_name_split" data-combo_text="'+split_menu_combo_items+'"  data-combo_text_plan_text="'+split_menu_combo_items_plan_text+'" data-main_name="'+this_item.menu_name+'">'+this_item.menu_name+''+split_menu_combo_items+''+split_modifier_name+'</span></td>\n' +
                          '                                    <td class="text_right">&nbsp; <span class="item_price_split">'+Number(this_item.menu_unit_price).toFixed(ir_precision)+'</span></td>\n' +
                          '                                    <td>&nbsp; <span id="left_qty_split_'+this_item.food_menu_id+'" data-added_qty_original="'+this_item.qty+'" class="item_qty_split check_amount_required">'+this_item.qty+'</span></td>\n' +
                          '                                    <td class="text_right">&nbsp; <span id="item_dis_split_'+this_item.food_menu_id+'" data-discount_per_unit="'+discount_per_unit+'" class="item_dis_split">'+Number(discount_value).toFixed(ir_precision)+'</span></td>\n' +
                          '                                    <td class="text_right">&nbsp; <span class="item_total_split">'+Number(this_item.menu_price_with_discount).toFixed(ir_precision)+'</span>'+split_modifier_price+'</td>\n' +
                          '                                    <td class="text_right">&nbsp; <b class="btn_minus_plus"><i data-is_free_item="'+this_item.is_free+'" class="fa fa-minus row_items_spit_minus '+is_free_item+'"></i> &nbsp;<i data-is_free_item="'+this_item.is_free+'" class="fa fa-plus row_items_spit_plus '+is_free_item+'"></i></b></td>\n' +
                          '                                </tr>';
                      j++;
                  }
                  $("#last_future_sale_id").val(response.sale_no);
                  $("#split_modal_tbl_body").html(html_row);
                  $("#selected_invoice_sale_customer").val(response.customer_id);
                  $("#select_waiter").val(response.waiter_id).change();
                  $("#maximum_spit").html(10);
                  $("#spit_modal_input").attr('max',10);
                  $("#split_order_date_time").val(response.date_time);
                  $("#split_charge_type").val(response.charge_type);
                  $("#split_order_time").val(response.order_time);
                  $("#split_left_discount").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                  $("#split_left_charge").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                  $("#split_left_tips").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                  $("#split_left_discount").attr('data-original_left_amount',Number(response.sub_total_discount_amount).toFixed(ir_precision));
                  $("#split_left_charge").attr('data-original_left_amount',Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                  $("#split_left_tips").attr('data-original_left_amount',Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                  $("#order_split_modal").addClass("active");
                  $(".pos__modal__overlay").fadeIn(200);
                  cal_split_modal_left();

                  
              }
          });
      }
      $(document).on("click", ".invoice_btn_class", function (e) {
          let this_bill_type = Number($(this).attr('data-type'));
          let sale_no =$(".holder .order_details .single_order[data-selected=selected]").attr("data-sale_no");
          if(this_bill_type==2){
              $("#is_split_bill").val(1);
              $("#spit_modal_input").val('');
              split_bill();
              $(".custom_ul_split").empty();
          }else{
              $("#is_split_bill").val('');
              body_el.find('.invoice_box').toggleClass('active');
  
              $("#print_type").val(1);
              if (
                  $(".holder .order_details > .single_order[data-selected=selected]")
                      .length > 0
              ) {
  
                  let res = getSelectedOrderDetails(sale_no).then(function(data){
                      let response = jQuery.parseJSON(data);
                      if(response !== null) {
                          $(".empty_title").show();
                          $("#payment_list_div").html('');
                          
                            if(response.orders_table_text){
                                $(".table_number").parent().show();
                                $(".table_number").html(response.orders_table_text);
                            }else{
                                $(".table_number").html("-");
                                $(".table_number").parent().hide();
                            }

                            if(response.order_time){
                                $(".order_taking_time").parent().show();
                                $(".order_taking_time").html(response.order_time);
                            }else{
                                $(".order_taking_time").html("-");
                                $(".order_taking_time").parent().hide();
                            }

                          $("#finalize_total_payable").html(Number(response.total_payable).toFixed(ir_precision));
                          $("#finalize_total_payable").attr('data-original_payable',Number(response.total_payable).toFixed(ir_precision));
                          $("#finalize_total_due").html(Number(response.total_payable).toFixed(ir_precision));
                          $("#selected_invoice_sale_customer").val(response.customer_id);
                          $("#pay_amount_invoice_input").val(Number(response.total_payable).toFixed(ir_precision));
                          $("#current_sale_no").val(response.sale_no);
                          $("#last_future_sale_id").val(response.sale_no);
  
                          $("#order_payment_modal").removeClass("inActive");
                          $("#order_payment_modal").addClass("active");
                          $(".pos__modal__overlay").fadeIn(200);
                          checkSMSDisabled(response.customer_id);
  
                          $("#open_invoice_date_hidden").val(response.sale_date);
  
                          if(Number(response.previous_due_tmp)){
                              $(".previous_due_div").css('opacity','1');
                              $("#finalize_previous_due").html(Number(response.previous_due_tmp).toFixed(ir_precision));
  
                          }else{
                              $(".previous_due_div").css('opacity','0');
                          }
                          $("#is_multi_currency").val('');
                          $(".set_no_access").removeClass('no_access');
                          $(".finalize_modal_is_mul_currency").hide(300);
                          $("#finalize_amount_input").html('');
                          $(".badge_custom").remove();
                          $(".previous_due_div").show();
                          $(".loyalty_point_div").hide();
                          //cart details button
                          $("#cart_modal_total_item_text").html(Number(response.total_items_in_cart_qty).toFixed(0));
                          $("#cart_modal_total_subtotal_text").html(Number(response.sub_total).toFixed(ir_precision));
                          $("#cart_modal_total_discount_text").html(Number(response.sub_total_discount_amount).toFixed(ir_precision));
                          $("#cart_modal_total_discount_all_text").html(Number(response.total_discount_amount).toFixed(ir_precision));
                          $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(response.total_discount_amount).toFixed(ir_precision));
                          $("#cart_modal_total_tax_text").html(Number(response.total_vat).toFixed(ir_precision));
                          $("#cart_modal_total_charge_text").html(Number(response.delivery_charge_actual_charge).toFixed(ir_precision));
                          $("#cart_modal_total_tips_text").html(Number(response.tips_amount_actual_charge).toFixed(ir_precision));
                          $("#cart_modal_total_rounding_texts").html(Number(response.rounding_amount_hidden).toFixed(ir_precision));
  
                          set_default_payment();
                          cal_finalize_modal('');
                          $(".datepicker_custom")
                              .datepicker({
                                  autoclose: true,
                                  format: "yyyy-mm-dd",
                                  startDate: "0",
                                  todayHighlight: true,
                              })
                              .datepicker("update", response.sale_date);
  
                          $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
                      }
                  });
              } else {
                  toastr['error']((please_select_order_to_proceed + "!"), '');
              }
          }
  
      });
  
  
      body_el.on("click", "#open_finalize_discount", function () {
          $("#sub_total_discount_finalize").focus();
          $("#finalize_discount_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(300);
      });
  
      body_el.on("click", "#open_finalize_cart_details", function () {
          $("#finalize_cart_details_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(300);
      });
  
      body_el.on("click", ".cancel_modal", function () {
          $(this)
              .parent()
              .parent()
              .parent()
              .removeClass("active")
              .addClass("inActive");
          setTimeout(function () {
              $(".modal").removeClass("inActive");
          }, 1000);
      });
  
          body_el.on("click", ".cancel_modal", function () {
          $(this)
              .parent()
              .parent()
              .parent()
              .removeClass("active")
              .addClass("inActive");
          setTimeout(function () {
              $(".modal").removeClass("inActive");
          }, 1000);
      });
  
      /**
       * Remove paid-list item
       */
      function remove_paid_list_title(){
          if($('.paid-list').find('li').length){
              body_el.find('.empty_title').hide();
          }else{
              body_el.find('.empty_title').show();
          }
      }
      $(window).on('load',remove_paid_list_title)
  
      $(document).on("keyup", "#finalize_amount_input", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
              $(".badge_custom").remove();
          }
          if(this_value==''){
              $(".badge_custom").remove();
          }
      });
  
      $(document).on("keyup", "#given_amount_final_sale", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
          }
      });
  
      function set_finalize_discount(){
        let sub_total_discount_finalize = Number($("#sub_total_discount_finalize").val());
        let finalize_total_paid = Number($("#finalize_total_paid").val());
        let finalize_total_payable = Number($("#finalize_total_payable").attr('data-original_payable'));
  
        let new_finalize_amount = (finalize_total_payable - sub_total_discount_finalize).toFixed(ir_precision);
        let new_due = ((finalize_total_payable - sub_total_discount_finalize)-finalize_total_paid).toFixed(ir_precision);
  
        $("#finalize_total_payable").html(new_finalize_amount);
  
  
        let cart_modal_total_discount_all_text = Number($("#cart_modal_total_discount_all_text").attr('data-original_discount'));
        $("#cart_modal_total_discount_all_text").html((cart_modal_total_discount_all_text+sub_total_discount_finalize).toFixed(ir_precision));
  
          let conversion_rate  = Number($("#multi_currency").find(':selected').attr('data-multi_currency'));
          if(conversion_rate){
              $("#finalize_total_paid").html(new_finalize_amount);
              //set multi currency value
              let total_mul_amount = (conversion_rate*new_finalize_amount).toFixed(2);
              if(total_mul_amount){
                  $("#multi_currency_amount").val(total_mul_amount);
              }else{
                  $("#multi_currency_amount").val('');
              }
          }else{
              $("#finalize_total_due").html(new_due);
          }
      }
      $(document).on("keyup", "#sub_total_discount_finalize", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
          }
          set_finalize_discount();
          cal_finalize_modal('');
      });
      $(document).on("click", ".remove_discount", function (e) {
          $("#sub_total_discount_finalize").val("");
          set_finalize_discount();
          cal_finalize_modal('');
      });
      $(document).on("keyup", "#spit_small_modal_input", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
          }
      });
      $(document).on("keyup", "#multi_currency_amount", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
              $(".badge_custom").remove();
          }
          if(this_value==''){
              $(".badge_custom").remove();
          }
      });
      function set_active_payment(){
          $(".set_payment").each(function (i, obj) {
              let this_txt = $(this).text();
              let id = Number($(this).attr("data-id"));
              if($(this).hasClass('active')){
                  $("#payment_preview").html(this_txt);
                  if(this_txt=="Cash"){
                      $(".cash_div").show();
                      $("#finalize_change_amount_input").prop("readonly",true);
                      $("#finalize_amount_input").prop("readonly",true);
                  }else{
                      $("#finalize_change_amount_input").prop("readonly",false);
                      $("#finalize_amount_input").prop("readonly",false);
                      $(".cash_div").hide();
                  }
              }
          });
      }
  
      function check_cash_payment(amount){
          $(".set_payment").each(function (i, obj) {
              let id = Number($(this).attr("data-id"));
              if($(this).hasClass('active')){
                  let finalize_total_payable = Number($("#finalize_total_due").text());
                  if(finalize_total_payable==amount){
                      let check_exist = false;
                      let payment_id = 0 ;
                      let payment_name = $("#payment_preview").text() ;
                      $(".set_payment").each(function (i, obj) {
                          let this_txt = $(this).text();
                          if($(this).hasClass('active')){
                              payment_id = Number($(this).attr('data-id'));
                          }
                      });
  
                      $(".payment_list_counter").each(function (i, obj) {
                          let payment_id_added = Number($(this).attr('data-payment_id'));
                          if(payment_id===payment_id_added){
                              check_exist = true;
                          }
                      });
                      if(check_exist==true){
                          let already_added = $("#already_added").val();
                          toastr['error']((already_added), '');
                      }
                  }
              }
          });
      }
  
  
      $(document).on("keyup", "#finalize_given_amount_input", function (e) {
          let this_value = $.trim($(this).val());
          if (isNaN(this_value)) {
              $(this).val("");
          }
          let finalize_total_payable = Number($("#finalize_total_due").text());
          let change_amount = (this_value - finalize_total_payable);
              change_amount = change_amount && change_amount>0?change_amount:0;
          if(this_value==''){
              $("#finalize_change_amount_input").val('');
          }else{
              $("#finalize_change_amount_input").val(Number(change_amount).toFixed(2));
          }
          let change_amount_tmp = Number(this_value - change_amount).toFixed(2);
          $("#finalize_amount_input").val(change_amount_tmp);
  
          check_cash_payment(change_amount_tmp);
      });
      $(document).on("click", ".set_payment", function (e) {
          $("#finalize_amount_input").val('');
  
          let id = Number($(this).attr('data-id'));
          let status = true;
          if(id===5 && !checkInternetConnection()){
              let loyalty_point_error = $("#loyalty_point_error").val();
              status = false;
              toastr['error']((loyalty_point_error), '');
          }
          if(status){
              let amount_txt = $("#amount_txt").val();
              let loyalty_point_txt = $("#loyalty_point_txt").val();
  
              let finalize_total_payable = Number($("#finalize_total_payable").html());
              let loyalty_rate = Number($("#loyalty_rate").val());
  
              if(Number(id)!=5){
                  $(".previous_due_div").show();
                  $(".loyalty_point_div").hide();
                  $(".amount_txt").html(amount_txt);
                  $("#finalize_amount_input").attr("placeholder",amount_txt);
                  if(id!=undefined){
                      $('.set_payment').removeClass('active');
                      $(this).addClass('active');
                  }
                  set_active_payment();
                  set_finalize_discount();
                  cal_finalize_modal('');
              }else{
                  let customer_id_loyalty = Number($("#selected_invoice_sale_customer").val());
                  if(customer_id_loyalty!=1){
                      let sale_id = $(".holder .order_details .single_order[data-selected=selected]").attr("id").substr(6);
                      $.ajax({
                          url: base_url + "Sale/getTotalLoyaltyPoint",
                          method: "POST",
                          dataType:'json',
                          data: {
                              customer_id: customer_id_loyalty
                          },
                          success: function (response) {
                              if(response.status==true){
                                  $(".previous_due_div").hide();
                                  $(".loyalty_point_div").show();
                                  $("#available_loyalty_point").html(Number(response.total_point));
                              }else{
                                  toastr['error']((response.alert_txt), '');
                              }
                          },
                          error: function () {
                              alert(a_error);
                          },
                      });
                      $(".amount_txt").html(loyalty_point_txt);
                      $("#finalize_amount_input").attr("placeholder",loyalty_point_txt);
  
                      let finalize_total_due_ = Number($("#finalize_total_due").html());
                      let tool_tip_loyalty_point =  $("#tool_tip_loyalty_point").val();
                      $(".set_default_quick_cach").html(((1/loyalty_rate) * finalize_total_due_).toFixed(ir_precision)+" &nbsp;&nbsp;<span data-tippy-content='"+tool_tip_loyalty_point+"' class='tool_tip_loyalty_point fa fa-info'></span>");
                      $(".set_default_quick_cach").attr('data-amount',((1/loyalty_rate) * finalize_total_due_).toFixed(ir_precision));
  
                      tippy(".tool_tip_loyalty_point", {
                          animation: "scale",
                          allowHTML: true,
                      });
  
                      $("#finalize_amount_input").css("border","1px solid #bcbdbe");
                      $("#finalize_amount_input").focus();
                      if(id!=undefined){
                          $('.set_payment').removeClass('active');
                          $(this).addClass('active');
                      }
                      set_active_payment();
                  }else{
                      let loyalty_point_not_applicable = $("#loyalty_point_not_applicable").val();
                      toastr['error']((loyalty_point_not_applicable), '');
                  }
              }
          }
      });
      body_el.on("click", ".remove_paid_item", function () {
          let id = Number($(this).parent().parent().attr("data-payment_id"));
          $(".set_no_access").removeClass('no_access');
          $("#hidden_given_amount").val('');
          $("#hidden_change_amount").val('');
          $("#finalize_given_amount_input").val('');
          $("#finalize_change_amount_input").val('');
  
          let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
  
          if(Number($("#finalize_change_amount_input").val())){
              $(".change_amount_div").show();
              $("#change_amount_div_").text(Number($("#finalize_change_amount_input").val()).toFixed(ir_precision));
          }else{
              $(".change_amount_div").hide();
              $("#change_amount_div_").text(0);
          }
          $(this).parent().parent().remove();
          $("#finalize_amount_input").val('');
          remove_paid_list_title();
          cal_finalize_modal('');
      });
  
  
      $(document).on("click", "#change_currency_btn", function (e) {
          //for mobile view
          $("#order-split-bill-payment-amount").click();
  
          if(Number($(".payment_list_counter").length)){
            let your_added_payment_method_will_remove = $("#your_added_payment_method_will_remove").val();
  
              swal({
                  title: warning+"!",
                  text: your_added_payment_method_will_remove+"?",
                  cancelButtonText: cancel,
                  confirmButtonText: ok,
                  confirmButtonColor: '#3c8dbc',
                  showCancelButton: true
              }, function() {
                  $(".set_no_access").addClass('no_access');
                  $(".finalize_modal_is_mul_currency").show(300);
                  $("#is_multi_currency").val(1);
                  $("#multi_currency").val('').change();
                  $("#multi_currency_amount").val('');
                  $(".empty_title").show();
                  $("#payment_list_div").html('');
                  $("#finalize_amount_input").html('');
                  $(".badge_custom").remove();
                  $(".previous_due_div").show();
                  $(".loyalty_point_div").hide();
                  set_default_payment();
                  cal_finalize_modal('');
              });
          }else{
              $(".previous_due_div").show();
              $(".loyalty_point_div").hide();
              $("#multi_currency").val('').change();
              $("#multi_currency_amount").val('');
              $("#is_multi_currency").val(1);
              $(".set_no_access").addClass('no_access');
              $(".finalize_modal_is_mul_currency").show(300);
          }
      });

      $(document).on("click", "#reset_table", function (e) {
          //for mobile view
            swal({
                title: warning+"!",
                text: reset_table_alert,
                cancelButtonText: cancel,
                confirmButtonText: ok,
                confirmButtonColor: '#3c8dbc',
                showCancelButton: true
            }, function() {
                    $.ajax({
                        url: base_url + "Sale/resetTableData",
                        method: "POST",
                        data: { },
                        success: function (response) {
                           $(".get_area_table").eq(0).click();
                        },
                        error: function () {
                            alert(a_error);
                        },
                    });
            });
      });

      $(document).on("click", ".remove_multi_currency", function (e) {
          $(".set_no_access").removeClass('no_access');
          $(".finalize_modal_is_mul_currency").hide(300);
          $("#is_multi_currency").val('');
          $("#multi_currency").val('').change();
          $("#multi_currency_amount").val('');
          $("#sub_total_discount_finalize").val('');
          $(".order-payment-wrapper").find('.order-payment-list').fadeIn(0);
          cal_finalize_modal('');
          set_finalize_discount();
      });
  
      //denomination
      $(document).on("click", ".get_quick_cash", function (e) {
          let amount = Number($(this).attr('data-amount'));
          let is_denomination = ($(this).attr('data-is_denomination'));
          if(is_denomination=="yes"){
              let sum = 0;
              let finalize_amount_input = $("#finalize_amount_input").val();
              if(finalize_amount_input==''){
                  finalize_amount_input = 0;
              }else{
                  finalize_amount_input = Number($("#finalize_amount_input").val());
              }
              sum = finalize_amount_input + amount;
              $(".set_payment").each(function (i, obj) {
                  let id = ($(this).text());
                  if($(this).hasClass('active')){
                      if(id=="Cash"){
                          $("#finalize_given_amount_input").val(sum.toFixed(ir_precision));
                      }
                  }
              });
              let total_count = $(this).find("span").html();
              let this_amount  = $(this).attr('data-amount');
              if(total_count!=undefined){
                  total_count = Number(total_count)+1;
              }else{
                  total_count = 1;
              }
              amount = sum;
              $("#finalize_amount_input").val(amount.toFixed(ir_precision));
  
              $(this).html(this_amount+' <span class="badge_custom">'+total_count+'</span>');
          }else{
              $("#finalize_amount_input").val(amount.toFixed(ir_precision));
  
              $(".set_payment").each(function (i, obj) {
                  let id = ($(this).text());
                  if($(this).hasClass('active')){
                      if(id=="Cash"){
                          $("#finalize_given_amount_input").val(amount.toFixed(ir_precision));
                      }
                  }
              });
          }
  
  
          $(".set_payment").each(function (i, obj) {
              let id = ($(this).text());
              if($(this).hasClass('active')){
                  if(id=="Cash"){
                      let finalize_total_payable = Number($("#finalize_total_due").text());
                      let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
                      let change_amount = (finalize_given_amount_input - finalize_total_payable);
                      $("#finalize_change_amount_input").val((change_amount && change_amount>0?change_amount:0).toFixed(ir_precision));
  
                      let finalize_change_amount_input = Number($("#finalize_change_amount_input").val());
                      if(finalize_change_amount_input){
                          amount = Number($("#finalize_total_due").text());
                          $("#finalize_amount_input").val(amount.toFixed(ir_precision));
                      }
                  }
              }
          });
          check_cash_payment(amount);
      });
  
      $(document).on("click", ".clear_quick_data", function (e) {
          $("#finalize_amount_input").val('');
          $("#finalize_given_amount_input").val('');
          $("#finalize_change_amount_input").val('');
          $(".badge_custom").remove();
          $("#finalize_amount_input").focus();
          $("#finalize_amount_input").css("border","1px solid #bcbdbe");
      });
  
      $(document).on("click", "#add_payment", function (e) {
        let finalize_amount_input = Number($("#finalize_amount_input").val());
        let usage_point = finalize_amount_input;
  
        let status = false;
        let check_exist = false;
  
          let payment_id = 0;
          let payment_id_text = '';
          let payment_name = $("#payment_preview").text() ;
          $(".set_payment").each(function (i, obj) {
              let this_txt = $(this).text();
              if($(this).hasClass('active')){
                  status = true;
                  payment_id = Number($(this).attr('data-id'));
                  payment_id_text = ($(this).text());
              }
          });
  
          $("#finalize_given_amount_input").css("border","1px solid #bcbdbe");
          $("#finalize_amount_input").css("border","1px solid #bcbdbe");
  
        let minimum_point_to_redeem = Number($("#minimum_point_to_redeem").val());
        let loyalty_rate = Number($("#loyalty_rate").val());
        let available_loyalty_point = Number($("#available_loyalty_point").html());
  
        if((minimum_point_to_redeem>finalize_amount_input) && payment_id===5){
           let minimum_point_to_redeem_is = $("#minimum_point_to_redeem_is").val();
           toastr['error']((minimum_point_to_redeem_is+ " "+minimum_point_to_redeem), '');
        }else if((available_loyalty_point<finalize_amount_input) && payment_id===5){
          let loyalty_point_is_not_available = $("#loyalty_point_is_not_available").val();
          toastr['error']((finalize_amount_input+" "+loyalty_point_is_not_available), '');
        }else{
  
            $(".payment_list_counter").each(function (i, obj) {
                let payment_id_added = Number($(this).attr('data-payment_id'));
                if(payment_id===payment_id_added){
                    check_exist = true;
                }
            });
            if(payment_id===5){
                payment_name = payment_name+"(Usage "+finalize_amount_input+")";
                finalize_amount_input = (loyalty_rate * finalize_amount_input);
            }
            let tmp_amount_checker = finalize_amount_input;
            if(payment_id_text=="Cash"){
                tmp_amount_checker = Number($("#finalize_given_amount_input").val());
            }
  
            if(tmp_amount_checker){
                if(status==true){
                    $("#finalize_amount_input").css("border","1px solid #bcbdbe");
  
                    let html = '<li class="payment_list_counter" data-usage_point="'+usage_point+'" data-payment_name="'+payment_name+'" data-payment_id="'+payment_id+'" data-amount="'+finalize_amount_input.toFixed(ir_precision)+'">\n' +
                        '                                                    <span class="payment-type-name">'+payment_name+'</span>\n' +
                        '                                                    <div>\n' +
                        '                                                        '+currency+'<span class="payment_list_amount">'+finalize_amount_input.toFixed(ir_precision)+'</span>\n' +
                        '                                                        <i class="fas fa-times-circle remove_paid_item"></i>\n' +
                        '                                                    </div>\n' +
                        '                                                </li>';
  
                    if(check_exist==true){
                        let already_added = $("#already_added").val();
                        toastr['error']((already_added), '');
                    }else{
                        $(".set_payment").each(function (i, obj) {
                            if($(this).hasClass('active')){
                                let payment_id_action = Number($(this).attr('data-id'));
                                let payment_id_action_text = ($(this).text());
                                if(payment_id_action_text=="Cash"){
                                    $("#hidden_given_amount").val($("#finalize_given_amount_input").val());
                                    $("#hidden_change_amount").val($("#finalize_change_amount_input").val());
  
                                    let finalize_given_amount_input = Number($("#finalize_given_amount_input").val());
                                    let finalize_total_payable = Number($("#finalize_total_due").text());
  
                                    if(finalize_total_payable<finalize_given_amount_input){
                                        $(".set_no_access").addClass('no_access');
                                    }
  
                                    if(Number($("#finalize_change_amount_input").val())){
                                        $(".change_amount_div").show();
                                        $("#change_amount_div_").text(Number($("#finalize_change_amount_input").val()).toFixed(ir_precision));
                                    }else{
                                        $(".change_amount_div").hide();
                                        $("#change_amount_div_").text(0);
                                    }
                                    $("#finalize_given_amount_input").val('');
                                    $("#finalize_change_amount_input").val('');
  
                                }
                            }
                        });
  
                        $(".empty_title").hide();
                        $("#payment_list_div").append(html);
                        $("#finalize_amount_input").val('');
                        $("#finalize_amount_input").focus();
                        $(".badge_custom").remove();
                        setAnimation();
                        cal_finalize_modal('');
                        set_default_payment();
                    }
                }else{
                    let please_click_a_payment_method_before_add = $("#please_click_a_payment_method_before_add").val();
                    toastr['error']((please_click_a_payment_method_before_add), '');
                }
            }else{
                if(payment_id_text=="Cash"){
                    $("#finalize_given_amount_input").focus();
                    $("#finalize_given_amount_input").css("border","2px solid red");
                }else{
                    $("#finalize_amount_input").focus();
                    $("#finalize_amount_input").css("border","2px solid red");
                }
            }
        }
  
      });
      set_active_payment();
  
      function cal_multi_currency(){
          let conversion_rate  = Number($("#multi_currency").find(':selected').attr('data-multi_currency'));
          $("#multi_currency_rate").val(conversion_rate);
          let finalize_total_payable  = Number($("#finalize_total_payable").html());
          let total_mul_amount = (conversion_rate*finalize_total_payable).toFixed(2);
          if(total_mul_amount){
              $("#multi_currency_amount").val(total_mul_amount);
          }else{
              $("#multi_currency_amount").val('');
          }
          cal_finalize_modal('');
      }
      $(document).on("change", "#multi_currency", function (e) {
          cal_multi_currency();
      });
  
      $(document).on("click", ".custom_li_split", function (e) {
          let row =  $(this).attr("data-row");
          $(".class_check_split").prop('checked',false);
          $("#myCheckbox_"+row).prop('checked',true);
      });
  
      function setAnimationForSpit(this_action,destination_action) {
          let imgToDrag = this_action.eq(0);
          let cart = destination_action.find("tr").last();
          if (imgToDrag) {
              let top_ = Number(imgToDrag.offset().top);
  
              let imgClone = imgToDrag
                  .clone()
                  .offset({
                      top: top_,
                      left: imgToDrag.offset().left,
                  })
                  .css({
                      opacity: "0.8",
                      position: "absolute",
                      height: "150px",
                      width: "150px",
                      zIndex: "1000",
                  })
                  .appendTo($("body"))
                  .animate(
                      {
                          top: cart.offset().top + 10,
                          left: cart.offset().left + 10,
                          width: "75px",
                          height: "75px",
                      },
                      1000,
                      "easeInOutExpo"
                  );
              imgClone.animate(
                  {
                      width: 0,
                      height: 0,
                  },
                  function () {
                      $(this).detach();
                  }
              );
          }
      }
      function setAnimationForSpitMinus(this_action,destination_action,destination_action1,current_qty) {
          let cart = destination_action;
          let imgToDrag = this_action.eq(0);
  
          if (imgToDrag) {
              let top_ = Number(imgToDrag.offset().top);
  
              let imgClone = imgToDrag
                  .clone()
                  .offset({
                      top: top_,
                      left: imgToDrag.offset().left,
                  })
                  .css({
                      opacity: "0.8",
                      position: "absolute",
                      height: "150px",
                      width: "150px",
                      zIndex: "1000",
                  })
                  .appendTo($("body"))
                  .animate(
                      {
                          top: cart.offset().top + 10,
                          left: cart.offset().left + 10,
                          width: "75px",
                          height: "75px",
                      },
                      1000,
                      "easeInOutExpo"
                  );
              imgClone.animate(
                  {
                      width: 0,
                      height: 0,
                  },
                  function () {
                      $(this).detach();
                  }
              );
          }
      }
      function cal_split_modal(){
          let status = false;
          let this_action = '';
            $(".custom_li_split").each(function() {
                let row_div =  $(this).attr("data-row");
                if($("#myCheckbox_"+row_div).is(":checked")){
                    status = true;
                    this_action = $(this);
                }
            });
  
              let total_right_box_dis = 0;
              this_action.find('.dis_right_box').each(function() {
                  let inline_total_tr_dis = Number($(this).html());
                  total_right_box_dis+=inline_total_tr_dis;
              });
  
              let total_right_box_sub_total = 0;
              this_action.find('.total_right_box').each(function() {
                  let inline_total_tr = Number($(this).html());
                  total_right_box_sub_total+=inline_total_tr;
                  let tmp_modifier_price = 0;
                  $(this).parent().find('.modifier_right_box').each(function() {
                       tmp_modifier_price += Number($(this).html());
                  });
  
              });
  
              let total_right_box_tax_per_unit = 0;
              this_action.find('.row_box_item').each(function() {
                  let inline_total_tr_tax = Number($(this).attr('data-total_vat_per_unit'));
                  let inline_total_tr_tax_qty = Number($(this).find('.qty_right_box').html());
                  let tmp_modifier_tax = 0;
  
                  $(this).find('.modifier_right_box').each(function() {
                    let modifier_tax = Number($(this).attr('data-per_tax_modifier_right_box'));
                      tmp_modifier_tax+=(modifier_tax*inline_total_tr_tax_qty);
                      let modifier_price = Number($(this).attr('data-per_unit_modifier_right_box'));
                      $(this).html((modifier_price*inline_total_tr_tax_qty).toFixed(ir_precision));
                      total_right_box_sub_total+=(modifier_price*inline_total_tr_tax_qty);
                  });
  
  
                  total_right_box_tax_per_unit+=(inline_total_tr_tax*inline_total_tr_tax_qty)+(tmp_modifier_tax);
              });
  
            let previous_added_amount_discount_right_box = Number(this_action.find('.discount_right_box').attr('data-added_amount'));
            let previous_added_amount_charge_right_box = Number(this_action.find('.charge_right_box').attr('data-added_amount'));
            let previous_added_amount_tips_right_box = Number(this_action.find('.tips_right_box').attr('data-added_amount'));
            this_action.find('.discount_right_box').html((Number(total_right_box_dis)+ previous_added_amount_discount_right_box).toFixed(ir_precision));
            this_action.find('.subtotal_right_box').html((Number(total_right_box_sub_total)).toFixed(ir_precision));
            this_action.find('.tax_right_box').html((Number(total_right_box_tax_per_unit)).toFixed(ir_precision));
            this_action.find('.charge_right_box').html((previous_added_amount_charge_right_box).toFixed(ir_precision));
            this_action.find('.tips_right_box').html((previous_added_amount_tips_right_box).toFixed(ir_precision));
            let discount_attr = Number(this_action.find('.discount_right_box').attr('data-added_amount'));
            let inline_tax = Number(this_action.find('.tax_right_box').html());
              let tax_type = Number($("#tax_type").val());
              if(tax_type!==1){
                  inline_tax = 0;
              }
            let total_payable_right_box = Number(this_action.find('.subtotal_right_box').html()) - discount_attr + inline_tax + Number(this_action.find('.charge_right_box').html()) + Number(this_action.find('.tips_right_box').html());
  
            this_action.find('.total_payable_right_box').html((total_payable_right_box).toFixed(ir_precision));
  
          let vat_amount_tmp = collect_tax == "Yes" ? get_total_vat_for_split_sale_table() : null;
  
          let html_modal = "";
          let total_tax_custom = 0;
            $.each(vat_amount_tmp, function (key, value) {
                let row_id = 1;
                let key_value = key;
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
          }
      function cal_split_modal_left(){
        let tax_total = 0;
        let sub_total = 0;
  
            $(".row_items_spit").each(function() {
                let sale_row_id = Number($(this).attr('id').substr(15));
  
                let tmp_added_qty = 0;
                $(".qty_right_box_"+sale_row_id).each(function() {
                    let added_qty = Number($(this).html());
                    if(!sale_row_id){
                        added_qty = 0;
                    }
                    if(isNaN(added_qty)){
                        added_qty = 0;
                    }
                    tmp_added_qty+=added_qty;
                });
  
  
                let left_added_qty = Number($("#row_items_spit_"+sale_row_id).find('.item_qty_split').attr('data-added_qty_original'));
                if(!sale_row_id){
                    left_added_qty = 0;
                }
                if(isNaN(left_added_qty)){
                    left_added_qty = 0;
                }
                if(sale_row_id){
                    $("#row_items_spit_"+sale_row_id).find('.item_qty_split').html(left_added_qty - tmp_added_qty);
                }
  
                let item_qty_split = Number($(this).find('.item_qty_split').html());
                 let split_modifier_total = 0;
                 let split_modifier_tax = 0;
                $(this).find(".split_modifier_price").each(function() {
                    let per_unit_price = Number($(this).attr("data-per_unit_price"));
                    let split_tax_per_unit = Number($(this).attr("data-split_tax_per_unit"));
                    split_modifier_total+=(per_unit_price*item_qty_split);
                    split_modifier_tax += (split_tax_per_unit * item_qty_split);
                    $(this).html((per_unit_price*item_qty_split).toFixed(ir_precision));
                });
  
               let item_price_split = Number($(this).find('.item_price_split').html());
  
               let item_dis_split = Number($(this).find('.item_dis_split').html());
  
               $(this).find('.item_total_split').html(Number((item_price_split * item_qty_split) - item_dis_split).toFixed(ir_precision));
                let item_total_split = Number($(this).find('.item_total_split').html());
                sub_total+=item_total_split+split_modifier_total;
                let item_vat_per_unit = Number($(this).attr('data-tax_per_unit'));
                if(isNaN(item_vat_per_unit)) {
                    item_vat_per_unit = 0;
                }
                tax_total+=(item_vat_per_unit*item_qty_split) + (split_modifier_tax);
            });
  
            $("#split_left_sub_total").html(sub_total.toFixed(ir_precision));
            $("#split_left_tax").html((tax_total).toFixed(ir_precision));
            let split_left_discount = Number($("#split_left_discount").html());
            let split_left_charge = Number($("#split_left_charge").html());
            let split_left_tips = Number($("#split_left_tips").html());
              let tax_type = Number($("#tax_type").val());
              if(tax_type!==1){
                  tax_total = 0;
              }
            let total_payable  = sub_total + tax_total + split_left_charge - split_left_discount + split_left_tips;
            $("#split_left_total_payable").html((total_payable).toFixed(ir_precision));
          }
      function split_increase_free_item_qty(sale_row_id,qty_cart,item_id){
          // iterate over each item in the array
          let product_type = 1;
          let product_comb = '';
          let is_promo = '';
          let promo_type = '';
          let string_text = '';
          let discount = 0;
          let get_food_menu_id = 0;
          let qty = 0;
          let get_qty = 0;
          let modal_item_name_row = '';
          let draw_table_for_order = '';
  
          for (let i = 0; i < window.items.length; i++) {
              // look for the entry with a matching `code` value
              if (items[i].item_id == Number(item_id)) {
                  product_type = Number(items[i].product_type);
                  product_comb = (items[i].product_comb);
                  is_promo = (items[i].is_promo);
                  promo_type = Number((items[i].promo_type));
                  string_text = (items[i].string_text);
                  discount = (items[i].discount);
                  get_food_menu_id = (items[i].get_food_menu_id);
                  qty = (items[i].qty);
                  get_qty = (items[i].get_qty);
                  modal_item_name_row = (items[i].modal_item_name_row);
                  /*end_added_new_zakir*/
              }
          }
          if(is_promo=="Yes" && promo_type==2){
              let counting_qty_cart = (parseInt((qty_cart/qty)) * get_qty);
              let this_action = '';
              $(".custom_li_split").each(function() {
                  let row_div =  $(this).attr("data-row");
                  if($("#myCheckbox_"+row_div).is(":checked")){
                      this_action = $(this);
                  }
              });
              let main_name =  $("#row_items_spit_"+sale_row_id).find(".item_name_split").attr('data-main_name');
              if(counting_qty_cart>0){
                  let free_item_div = this_action.find(".free_item_div_"+get_food_menu_id).attr('data-is_free');
                  if(free_item_div=="Yes"){
                      this_action.find(".free_item_div_"+get_food_menu_id+" .qty_right_box").html(counting_qty_cart);
                      this_action.find(".free_item_div_"+get_food_menu_id+" .qty_right_box").attr('data-added_qty_original',counting_qty_cart);
  
                  }else{
                      let html = '   <tr class="row_box_item free_item_div_'+get_food_menu_id+' remove_free_item_div_'+sale_row_id+'" data-is_free="Yes" data-sale_row_id="'+sale_row_id+'" data-total_vat_per_unit="0" data-id="'+get_food_menu_id+'">\n' +
                          '                                                    <td class="padding_5 name_right_box" data-main_name="'+main_name+'">'+main_name+'</td>\n' +
                          '                                                    <td class="price_right_box">'+(0).toFixed(ir_precision)+'</td>\n' +
                          '                                                    <td data-added_qty_original="'+counting_qty_cart+'" class="qty_right_box qty_right_box_'+sale_row_id+'">'+counting_qty_cart+'</td>\n' +
                          '                                                    <td data-dis_per_right_box="'+(0)+'" class="dis_right_box">'+(0).toFixed(ir_precision)+'</td>\n' +
                          '                                                    <td><span class="total_right_box">'+(0).toFixed(ir_precision)+'</span></td>\n' +
                          '                                                    <td class="last_td"></td>\n' +
                          '                                                </tr>';
                      this_action.find('.spit_tb_tr').append(html);
                  }
  
  
              }else{
                  this_action.find(".free_item_div_"+get_food_menu_id).remove();
              }
  
          }
      }
  
      $(document).on("click", ".row_items_spit_plus", function (e) {
        let is_free_item = Number($(this).attr('data-is_free_item'));
        if(is_free_item){
          let alert_free_item_increase = $("#alert_free_item_increase").val();
            toastr['error']((alert_free_item_increase), '');
        }else{
            let id = Number($(this).parent().parent().parent().attr('data-id'));
            let sale_row_id = Number($(this).parent().parent().parent().attr('data-sale_row_id'));
            let name = $(this).parent().parent().parent().find('.item_name_split').html();
            let main_name = $(this).parent().parent().parent().find('.item_name_split').attr('data-main_name');
            let combo_text_plan_text = $(this).parent().parent().parent().find('.item_name_split').attr('data-combo_text_plan_text');
            let combo_text = $(this).parent().parent().parent().find('.item_name_split').attr('data-combo_text');
  
            let qty = Number($(this).parent().parent().parent().find('.item_qty_split').html());
            let item_price_split = ($(this).parent().parent().parent().find('.item_price_split').html());
            let discount_per_unit = Number($(this).parent().parent().parent().find('.item_dis_split').attr('data-discount_per_unit'));
            let tax_per_unit = Number($(this).parent().parent().parent().attr('data-tax_per_unit'));
            let quantity_not_available = $("#quantity_not_available").val();
            if(qty>0){
                let status = false;
                let this_action = '';
                $(".custom_li_split").each(function() {
                    let row_div =  $(this).attr("data-row");
                    if($("#myCheckbox_"+row_div).is(":checked")){
                        status = true;
                        this_action = $(this);
                    }
                });
                if(status==true){
                    let tmp_qty_minus = (qty-1);
                    $(this).parent().parent().parent().find('.item_qty_split').html(tmp_qty_minus);
  
                    let inline_right_box_sub_total = (Number(item_price_split) - Number(discount_per_unit)).toFixed(ir_precision);
  
                    let modifier_right_box = '';
                    $(this).parent().parent().parent().find('.split_modifier_price').each(function() {
                        let per_tax_modifier_right_box= $(this).attr('data-split_tax_per_unit');
                        let per_unit_modifier_right_box= $(this).attr('data-per_unit_price');
                        modifier_right_box+='<br><span class="modifier_right_box"  data-per_tax_modifier_right_box="'+per_tax_modifier_right_box+'" data-per_unit_modifier_right_box="'+per_unit_modifier_right_box+'">'+per_unit_modifier_right_box+'</span>';
                    });
  
  
                    let html = '   <tr class="row_box_item" data-total_vat_per_unit="'+tax_per_unit+'" data-id="'+id+'">\n' +
                        '                                                    <td class="padding_5 name_right_box" data-combo_text="'+combo_text_plan_text+'"  data-main_name="'+main_name+'">'+name+'</td>\n' +
                        '                                                    <td class="price_right_box">'+item_price_split+'</td>\n' +
                        '                                                    <td class="qty_right_box">1</td>\n' +
                        '                                                    <td data-dis_per_right_box="'+discount_per_unit+'" class="dis_right_box">'+(discount_per_unit).toFixed(ir_precision)+'</td>\n' +
                        '                                                    <td><span class="total_right_box">'+inline_right_box_sub_total+'</span>'+modifier_right_box+'</td>\n' +
                        '                                                    <td class="last_td"><i data-sale_row_id="'+sale_row_id+'" class="fas fa-times-circle remove_spit_box"></i></td>\n' +
                        '                                                </tr>';
  
                    let status_box_item = false;
                    let increase_action = '';
                    let current_qty = 0;
                    let action_tr_last = '';
                    this_action.find('.row_box_item').each(function() {
                        let box_row_id =  Number($(this).attr("data-id"));
                        if(box_row_id===id){
                            action_tr_last = $(this);
                            current_qty = Number(action_tr_last.find('.qty_right_box').html());
                            status_box_item = true;
                        }
  
                    });
  
                    let current_qty_split = 0;
                    if(status_box_item==true){
                        let tmp_discount = Number(discount_per_unit*(current_qty+1));
                        let tmp_total = (Number(item_price_split*(current_qty+1)) - tmp_discount).toFixed(ir_precision);
                        action_tr_last.find('.qty_right_box').html(current_qty+1);
                        action_tr_last.find('.dis_right_box').html(tmp_discount);
                        action_tr_last.find('.total_right_box').html(tmp_total);
                        current_qty_split = current_qty+1;
                    }else{
                        this_action.find('.spit_tb_tr').append(html);
                        current_qty_split = 1;
                    }
  
                    let current_discount = Number($(this).parent().parent().parent().find('.item_dis_split').html());
                    $(this).parent().parent().parent().find('.item_dis_split').html((current_discount-discount_per_unit).toFixed(ir_precision));
                    //set free item row
                    split_increase_free_item_qty(sale_row_id,current_qty_split,id);
  
                    cal_split_modal();
                    cal_split_modal_left();
                    setAnimationForSpit($(this).parent().parent().parent().find('.item_name_split'),this_action.find('.spit_tb_tr'));
  
                }else{
                    let please_select_a_box_on_right_side_for_assign_item = $("#please_select_a_box_on_right_side_for_assign_item").val();
                    toastr['error']((please_select_a_box_on_right_side_for_assign_item), '');
                }
            }else{
              toastr['error']((quantity_not_available), '');
            }
        }
      });
  
  
      $(document).on("click", ".row_items_spit_minus", function (e) {
          let is_free_item = Number($(this).attr('data-is_free_item'));
          if(is_free_item){
              let alert_free_item_increase = $("#alert_free_item_increase").val();
              toastr['error']((alert_free_item_increase), '');
          }else{
              let id = Number($(this).parent().parent().parent().attr('data-id'));
              let sale_row_id = Number($(this).parent().parent().parent().attr('data-sale_row_id'));
              let item_price_split = ($(this).parent().parent().parent().find('.item_price_split').html());
              let discount_per_unit = Number($(this).parent().parent().parent().find('.item_dis_split').attr('data-discount_per_unit'));
              let tax_per_unit = Number($(this).parent().parent().parent().attr('data-tax_per_unit'));
  
              let status = false;
              let this_action = '';
              $(".custom_li_split").each(function() {
                  let row_div =  $(this).attr("data-row");
                  if($("#myCheckbox_"+row_div).is(":checked")){
                      status = true;
                      this_action = $(this);
                  }
              });
              if(status==true){
                  let status_box_item = false;
                  let increase_action = '';
                  let current_qty = 0;
                  let action_tr_last = '';
                  this_action.find('.row_box_item').each(function() {
                      let box_row_id =  Number($(this).attr("data-id"));
                      if(box_row_id===id){
                          action_tr_last = $(this);
                          current_qty = Number(action_tr_last.find('.qty_right_box').html());
                          status_box_item = true;
                      }
  
                  });
                 let current_qty_split =0;
                  if(status_box_item==true){
                      if(current_qty>0){
                          let tmp_discount = Number(discount_per_unit*(current_qty-1));
                          let tmp_total = (Number(item_price_split*(current_qty-1)) - tmp_discount).toFixed(ir_precision);
                          action_tr_last.find('.qty_right_box').html(current_qty-1);
                          action_tr_last.find('.dis_right_box').html(tmp_discount);
                          action_tr_last.find('.total_right_box').html(tmp_total);
                          let left_item_qty_split = Number($(this).parent().parent().parent().find('.item_qty_split').html());
                          $(this).parent().parent().parent().find('.item_qty_split').html((left_item_qty_split+1));
  
                          let current_discount = Number($(this).parent().parent().parent().find('.item_dis_split').html());
                          $(this).parent().parent().parent().find('.item_dis_split').html((current_discount+discount_per_unit).toFixed(ir_precision));
  
                          if(current_qty==1){
                              action_tr_last.remove();
                          }
                          current_qty_split = current_qty-1;
                      }
                  }else{
                      let this_item_not_added_on_your_selected_customer = $("#this_item_not_added_on_your_selected_customer").val();
                      toastr['error']((this_item_not_added_on_your_selected_customer), '');
                  }
                  //set free item row
                  split_increase_free_item_qty(sale_row_id,current_qty_split,id);
                  cal_split_modal();
                  cal_split_modal_left();
                  setAnimationForSpitMinus(action_tr_last.find('.name_right_box'),$(this).parent().parent().parent().find('.item_name_split'),this_action.find('.subtotal_right_box'),current_qty);
              }else{
                  let please_select_a_box_on_right_side_for_assign_item = $("#please_select_a_box_on_right_side_for_assign_item").val();
                  toastr['error']((please_select_a_box_on_right_side_for_assign_item), '');
              }
          }
      });
  
      $(document).on("click", ".remove_spit_box", function (e) {
          let id = $(this).parent().parent().attr("data-id");
          let remove_qty = Number($(this).parent().parent().find('.qty_right_box').html());
          let current_qty = Number($("#left_qty_split_"+id).html());
          $("#left_qty_split_"+id).html(remove_qty+current_qty);
          let right_total_discount = Number($(this).parent().parent().find('.dis_right_box').html());
          let current_discount = Number($("#item_dis_split_"+id).html());
          $("#item_dis_split_"+id).html((current_discount+right_total_discount).toFixed(ir_precision));
          let free_item_div_id = $(this).attr('data-sale_row_id');
          $(this).parent().parent().parent().find(".remove_free_item_div_"+free_item_div_id).remove();
          $(this).parent().parent().remove();
          cal_split_modal();
          cal_split_modal_left();
      });
  
      $(document).on("click", ".remove_box_right", function (e) {
          $(this).parent().find(".row_box_item").each(function() {
              let id = $(this).attr('data-id');
              let remove_qty = Number($(this).find('.qty_right_box').html());
              let current_qty = Number($("#left_qty_split_"+id).html());
              $("#left_qty_split_"+id).html(remove_qty+current_qty);
              let right_total_discount = Number($(this).find('.dis_right_box').html());
              let current_discount = Number($("#item_dis_split_"+id).html());
              $("#item_dis_split_"+id).html((current_discount+right_total_discount).toFixed(ir_precision));
          });
          let discount_right_box= Number($(this).parent().find(".discount_right_box").attr('data-added_amount'));
          let charge_right_box= Number($(this).parent().find(".charge_right_box").html());
          let tips_right_box = Number($(this).parent().find(".tips_right_box").html());
  
          let split_left_discount= Number($("#split_left_discount").html());
          let split_left_charge = Number($("#split_left_charge").html());
          let split_left_tips = Number($("#split_left_tips").html());
  
          $("#split_left_discount").html((discount_right_box + split_left_discount).toFixed(ir_precision));
          $("#split_left_charge").html((charge_right_box + split_left_charge).toFixed(ir_precision));
          $("#split_left_tips").html((tips_right_box + split_left_tips).toFixed(ir_precision));
          $(this).parent().remove();
          cal_split_modal_left();
  
      });
  
      $(document).on("click", ".btn_minus_plus_right", function (e) {
  
        let status = false;
        $("#spit_small_modal_input").focus();
          let this_action = '';
          $(".custom_li_split").each(function() {
              let row_div =  $(this).attr("data-row");
              if($("#myCheckbox_"+row_div).is(":checked")){
                  status = true;
                  this_action = $(this);
              }
          });
  
            let amount = Number($(this).parent().parent().find('.split_left_amount').html());
            let amount_not_available= $("#amount_not_available").val();
            if(amount>0){
                if(status==true){
                    if(Number(this_action.find('.row_box_item').length)){
                        let type = Number($(this).attr("data-type"));
                        $("#split_active_amount").val(type);
                        let title = ($(this).attr("data-title"));
                        amount = $(this).parent().parent().find('.split_left_amount').html();
                        $(".title_modal_label").html(title+"(+)");
                        $("#spit_small_modal_input").attr('placeholder',title+"(+)");
                        $("#spit_small_modal_input").attr('data-original_amount',amount);
                        $("#split_active_amount_status").val(2);
  
                        let input_modal_previous_amount = 0;
                        if(type==1){
                            input_modal_previous_amount = this_action.find('.discount_right_box').attr('data-added_amount');
                        }else if (type==2){
                            input_modal_previous_amount = this_action.find('.charge_right_box').attr('data-added_amount');
                        }else if(type==3){
                            input_modal_previous_amount = this_action.find('.tips_right_box').attr('data-added_amount');
                        }
  
                        $("#spit_small_modal_input").attr('data-input_modal_previous_amount',input_modal_previous_amount);
  
  
                        $("#order_split_small_modal").addClass("active");
                        $(".pos__modal__overlay").fadeIn(200);
                    }else{
                        let you_need_to_add_at_least_1_item_on_right_selected_customer = $("#you_need_to_add_at_least_1_item_on_right_selected_customer").val();
                        toastr['error']((you_need_to_add_at_least_1_item_on_right_selected_customer), '');
                    }
                }else{
                    let please_select_a_box_on_right_side_for_assign_item = $("#please_select_a_box_on_right_side_for_assign_item").val();
                    toastr['error']((please_select_a_box_on_right_side_for_assign_item), '');
                }
            }else{
              toastr['error']((amount_not_available), '');
            }
  
      });
  
      $(document).on("click", "#add_small_modal_amount", function (e) {
        let spit_small_modal_input = Number($("#spit_small_modal_input").val());
        let original_amount = Number($("#spit_small_modal_input").attr('data-original_amount'));
  
          let status = false;
          let this_action = '';
          $(".custom_li_split").each(function() {
              let row_div =  $(this).attr("data-row");
              if($("#myCheckbox_"+row_div).is(":checked")){
                  status = true;
                  this_action = $(this);
              }
          });
  
        let input_modal_previous_amount = Number($("#spit_small_modal_input").attr('data-input_modal_previous_amount'));
          let split_active_amount_status = Number($("#split_active_amount_status").val());
          let tmp_total = 0;
          if(split_active_amount_status==1){
              tmp_total = original_amount-input_modal_previous_amount;
          }else{
              tmp_total = original_amount+input_modal_previous_amount;
          }
  
         if(spit_small_modal_input>tmp_total){
           let more_then_original_amount = $("#more_then_original_amount").val();
           toastr['error']((more_then_original_amount+" "+tmp_total), '');
         }else{
           let split_active_amount = Number($("#split_active_amount").val());
           if(split_active_amount==1){
               this_action.find('.discount_right_box').attr('data-added_amount',spit_small_modal_input);
           }else if(split_active_amount==2){
                this_action.find('.charge_right_box').attr('data-added_amount',spit_small_modal_input);
           }else if(split_active_amount==3){
                this_action.find('.tips_right_box').attr('data-added_amount',spit_small_modal_input);
           }
  
           let split_right_discount_tmp = 0;
           let split_right_charge_tmp = 0;
           let split_right_tips_tmp = 0;
  
  
           $(".discount_right_box").each(function() {
               split_right_discount_tmp += Number($(this).attr('data-added_amount'));
           });
           $(".charge_right_box").each(function() {
               split_right_charge_tmp += Number($(this).attr('data-added_amount'));
           });
           $(".tips_right_box").each(function() {
               split_right_tips_tmp += Number($(this).attr('data-added_amount'));
           });
  
             if(split_active_amount==1){
                  let split_left_discount_tmp =  Number($("#split_left_discount").attr('data-original_left_amount'));
                 $("#split_left_discount").html((split_left_discount_tmp - Number(split_right_discount_tmp)).toFixed(ir_precision));
             }else if(split_active_amount==2){
                  let split_left_charge_tmp =  Number($("#split_left_charge").attr('data-original_left_amount'));
                 $("#split_left_charge").html((split_left_charge_tmp - Number(split_right_charge_tmp)).toFixed(ir_precision));
             }else if(split_active_amount==3){
                  let split_left_tips_tmp =  Number($("#split_left_tips").attr('data-original_left_amount'));
                 $("#split_left_tips").html((split_left_tips_tmp - Number(split_right_tips_tmp)).toFixed(ir_precision));
             }
  
            $(this)
                 .parent()
                 .parent()
                 .parent()
                 .parent()
                 .parent()
                 .parent()
                 .parent()
                 .parent()
                 .removeClass("active")
                 .addClass("inActive");
             setTimeout(function () {
                 $(".modal").removeClass("inActive");
             }, 1000);
             $(".pos__modal__overlay").fadeOut(300);
            $("#spit_small_modal_input").val('');
            cal_split_modal();
            cal_split_modal_left();
         }
      });
  
      function hide_current_modal(obj){
          obj.removeClass("active")
              .addClass("inActive");
          setTimeout(function () {
              $(".modal").removeClass("inActive");
          }, 1000);
          $(".pos__modal__overlay").fadeOut(300);
      }
  
      $(document).on("click", ".remove_inline_right_split_tips", function (e) {
          let get_amount = Number($(this).parent().find('.tips_right_box').html());
          let split_left_tips = Number($("#split_left_tips").html());
          $("#split_left_tips").html(Number(get_amount+split_left_tips).toFixed(ir_precision));
          $(this).parent().find('.tips_right_box').attr("data-added_amount",(0).toFixed(ir_precision));
          $(this).parent().find('.tips_right_box').html((0).toFixed(ir_precision));
          //remove amount
           cal_split_modal_left();
           cal_split_modal();
      });
  
      $(document).on("click", ".remove_inline_right_split_discount", function (e) {
          let get_amount = Number($(this).parent().find('.discount_right_box').attr('data-added_amount'));
          let item_discount_old = Number($(this).parent().find('.discount_right_box'));
          let new_discount = item_discount_old - get_amount;
          $(this).parent().find('.discount_right_box').attr('data-added_amount',0);
          $(this).parent().find('.discount_right_box').html(Number(new_discount).toFixed(ir_precision));
  
          let get_amount_all = Number($(this).parent().find('.discount_right_box').html());
          let split_left_discount = Number($("#split_left_discount").html());
  
          $("#split_left_discount").html(Number(get_amount+split_left_discount).toFixed(ir_precision));
          let current_previous_add_item_dis = get_amount_all - get_amount;
          $(this).parent().find('.discount_right_box').html((current_previous_add_item_dis).toFixed(ir_precision));
           cal_split_modal_left();
           cal_split_modal();
      });
  
      $(document).on("click", ".remove_inline_right_split_charge", function (e) {
          let get_amount = Number($(this).parent().find('.charge_right_box').html());
          let split_left_charge= Number($("#split_left_charge").html());
          $("#split_left_charge").html(Number(get_amount+split_left_charge).toFixed(ir_precision));
          $(this).parent().find('.charge_right_box').html((0).toFixed(ir_precision));
          $(this).parent().find('.charge_right_box').attr('data-added_amount',(0));
          cal_split_modal_left();
          cal_split_modal();
      });
  
      $(document).on("click", ".goto_to_payment", function (e) {
        e.preventDefault();
  
          let row =  $(this).parents().parents().parents().attr("data-row");
          $(".class_check_split").prop('checked',false);
          $("#myCheckbox_"+row).prop('checked',true);
  
          let sale_id_split = $("#last_future_sale_id").val();
              $(".total_split_sale").empty();
              $(".total_split_sale").append('<span>1</span>');
              generateSplitSaleNo(sale_id_split);
  
          $("#sub_total_discount_finalize").val('');
        if($(this).parent().parent().find('.row_box_item').length) {
            let status = false;
            $(".check_amount_required").each(function (i, obj) {
                let value = Number($(this).html());
                if (value) {
                    status = true;
                }
            });
            if (status == true) {
                let some_of_your_cart_amounts_are_not_spitted_yet = $("#some_of_your_cart_amounts_are_not_spitted_yet").val();
                toastr['error']((some_of_your_cart_amounts_are_not_spitted_yet), '');
            } else {
                let obj_modal = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
                hide_current_modal(obj_modal);
  
                //set split details amount
                let total_payable = $(this).parent().find(".total_payable_right_box").html();
                let customer_id = $(this).parent().parent().find(".split_customer_id").val();
  
                $(".empty_title").show();
                $("#payment_list_div").html('');
  
                $("#finalize_total_payable").html(Number(total_payable).toFixed(ir_precision));
                $("#finalize_total_payable").attr('data-original_payable',Number(total_payable).toFixed(ir_precision));
                $("#finalize_total_due").html(total_payable);
                $("#selected_invoice_sale_customer").val(customer_id);
                $("#pay_amount_invoice_input").val(total_payable);
  
                $(".previous_due_div").css('opacity', '0');
                $("#is_multi_currency").val('');
                $(".set_no_access").removeClass('no_access');
                $(".finalize_modal_is_mul_currency").hide(300);
                $("#finalize_amount_input").html('');
                $(".badge_custom").remove();
                $(".previous_due_div").show();
                $(".loyalty_point_div").hide();
                //cart details button
                let cart_modal_total_item_text = 0;
                let cart_modal_total_subtotal_text = $(this).parent().find(".subtotal_right_box").html();
                let cart_modal_total_discount_text = Number($(this).parent().find(".discount_right_box").html()) - Number($(this).parent().find(".discount_right_box").attr('data-added_amount'));
                let cart_modal_total_discount_all_text = $(this).parent().find(".discount_right_box").html();
                let cart_modal_total_discount_all_text_subtotal = $(this).parent().find(".discount_right_box").attr('data-added_amount');
                let cart_modal_total_tax_text = $(this).parent().find(".tax_right_box").html();
                let cart_modal_total_charge_text = $(this).parent().find(".charge_right_box").html();
                ;
                let cart_modal_total_tips_text = $(this).parent().find(".tips_right_box").html();
                ;
                let cart_modal_total_rounding_texts = 0;
  
                $(this).parent().parent().find(".qty_right_box").each(function (i, obj) {
                    let qty = Number($(this).html());
                    cart_modal_total_item_text += qty;
  
                });
  
                $("#cart_modal_total_item_text").html(Number(cart_modal_total_item_text).toFixed(0));
                $("#cart_modal_total_subtotal_text").html(Number(cart_modal_total_subtotal_text).toFixed(ir_precision));
                $("#cart_modal_total_discount_text").html(Number(cart_modal_total_discount_all_text).toFixed(ir_precision));
                $("#cart_modal_total_discount_all_text").html(Number(cart_modal_total_discount_all_text).toFixed(ir_precision));
                $("#cart_modal_total_discount_all_text").attr('data-original_discount',Number(cart_modal_total_discount_all_text).toFixed(ir_precision));
                $("#cart_modal_total_tax_text").html(Number(cart_modal_total_tax_text).toFixed(ir_precision));
                $("#cart_modal_total_charge_text").html(Number(cart_modal_total_charge_text).toFixed(ir_precision));
                $("#cart_modal_total_tips_text").html(Number(cart_modal_total_tips_text).toFixed(ir_precision));
                $("#cart_modal_total_rounding_texts").html(Number(cart_modal_total_rounding_texts).toFixed(ir_precision));
                $(this).attr('data-is_remove', 'yes');
  
                set_default_payment();
                cal_finalize_modal('');
                cal_split_modal();
  
                $("#order_payment_modal").addClass("active");
                $(".pos__modal__overlay").fadeIn(200);
                checkSMSDisabled(customer_id);
  
                $("#finalize_update_type").html("2"); //when 2 update payment method, close time and order_status to 3
            }
        }else{
            let please_add_at_least_1_item_before_checkout = $("#please_add_at_least_1_item_before_checkout").val();
            toastr['error']((please_add_at_least_1_item_before_checkout), '');
        }
  
      });
      $(document).on("click", "#add_spit_box", function (e) {
        let maximum_spit = Number($("#maximum_spit").html());
        let spit_modal_input = Number($("#spit_modal_input").val());
        if(spit_modal_input>maximum_spit){
          let maximum_spit_is = $("#maximum_spit_is").val();
            toastr.options = {
                positionClass:'toast-bottom-right'
            };
            toastr['error']((maximum_spit_is+" "+maximum_spit), '');
        }else{
          let html = '';
          let counter_checker = 1;
          let customer_info = $("#walk_in_customer").html();
          for(let i=1;i<=spit_modal_input;i++){
            let is_checked = '';
            let is_class = '';
            if(counter_checker==1){
                counter_checker++;
                is_checked = 'checked';
                is_class = 'active';
            }
              html+='<li class="custom_li_split" data-row="'+i+'">\n' +
              '                                        <i class="fas fa-times removeItem remove_box_right '+is_class+'"></i><input type="checkbox" '+is_checked+' value="'+i+'" class="class_check_split"  id="myCheckbox_'+i+'" />\n' +
              '                                        <label class="label_c_split" for="myCheckbox_'+i+'">\n' +
              '                                            <select class="form-control select2 split_customer_id"  style="width: 100%">\n' + customer_info +
              '                                            </select>\n' +
              '                                            <table class="spit_tb_tr" style="width: 100%">\n' +
              '                                            </table>\n' +
              '                                            <div class="table_wrapper">\n' +
              '                                                <table class="split_tbl_width">\n' +
                  '    <tr>\n' +
                  '        <td>&nbsp;'+inv_sub_total+': <span class="subtotal_right_box">'+(0).toFixed(ir_precision)+'</span> </td>\n' +
                  '        <td>&nbsp;&nbsp;'+inv_discount+': <span class="discount_right_box" data-added_amount="0">'+(0).toFixed(ir_precision)+'</span><span class="remove_inline_right_split remove_inline_right_split_discount">X</span></td>\n' +
                  '        <td>&nbsp;&nbsp;'+inv_vat+': <span class="tax_right_box" >'+(0).toFixed(ir_precision)+'</span></td>\n' +
                  '    </tr>\n' +
                  '    <tr>\n' +
                  '        <td>&nbsp;'+inv_charge+': <span class="charge_right_box"  data-added_amount="0">'+(0).toFixed(ir_precision)+'</span><span class="remove_inline_right_split remove_inline_right_split_charge">X</span></td>\n' +
                  '        <td>&nbsp;&nbsp;'+inv_tips+': <span class="tips_right_box"  data-added_amount="0">'+(0).toFixed(ir_precision)+'</span><span class="remove_inline_right_split remove_inline_right_split_tips">X</span></td>\n' +
                  '        <td>&nbsp;&nbsp;'+inv_total_payable+': <span class="total_payable_right_box"  data-added_amount="0">'+(0).toFixed(ir_precision)+'</span></td>\n' +
                  '    </tr>\n' +
                  '</table><button type="button" class="goto_to_payment bg__green"><i class="fas fa-file-invoice"></i>  '+inv_checkout+'</button>\n' +
              '                                            </div>\n' +
              '                                        </label>\n' +
              '                                    </li>';
          }
          $(".custom_ul_split").html(html);
          $('.select2').select2();
          split_bill();
        }
      });
  
  
     $(window).click(function (event) {
       if ($(event.target).closest("#create_invoice_and_close").length === 0) {
           body_el.find('.invoice_box').removeClass('active');
       }
       if ($(event.target).closest(".print_kot_button").length === 0) {
           body_el.find('.invoice_box_kot').removeClass('active');
       }
     });
  
  
    body_el.on('click','.custom_li_split', function (e) {
      body_el.find('.custom_li_split .removeItem').removeClass('active');
      $(this).find('.removeItem').addClass('active');
    });
      $(document).on("click", ".self_my_order", function (e) {
          $(".self_hide_div").hide();
          $(".title_set_as_decline").hide();
          remove_all_cart_future_info();
          //self order
          let status_txt = $("#status_txt").val();
          $(".last_table_name").html(status_txt);
          let my_orders = $("#my_orders").val();
          $(".self_order_title").html(my_orders);
  
          let set_as_running_order = $("#set_as_running_order").val();
          $(".title_set_as").html(set_as_running_order);
  
          $(".cus_pos_modal_feature_sale_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(200);
          $.ajax({
              url: base_url + "Sale/get_last_10_self_order_sales_ajax",
              method: "GET",
              data:{type:1},
              success: function (response) {
                  let orders = JSON.parse(response);
                  let last_10_orders = "";
                  let html_custom = ` `;
                  for (let key in orders) {
                      let order_name = "";
                      if (orders[key].order_type == "1") {
                          order_name = orders[key].sale_no;
                      } else if (orders[key].order_type == "2") {
                          order_name = orders[key].sale_no;
                      } else if (orders[key].order_type == "3") {
                          order_name = orders[key].sale_no;
                      }
                      let tables_booked = "";
                      if (orders[key].tables_booked.length > 0) {
                          let w = 1;
                          for (let k in orders[key].tables_booked) {
                              let single_table = orders[key].tables_booked[k];
                              if (w == orders[key].tables_booked.length) {
                                  tables_booked += single_table.table_name;
                              } else {
                                  tables_booked += single_table.table_name + ", ";
                              }
                              w++;
                          }
                      } else {
                          tables_booked = "None";
                      }
  
                      let phone_text_ = "";
                      if (orders[key].phone) {
                          phone_text_ = " (" + orders[key].phone + ")";
                      }
                      let bg_color = "";
                      let ignore_status = "";
                      if (orders[key].future_sale_status == 3) {
                          bg_color = "#99e299";
                          ignore_status = "No";
                      }
                      html_custom +=
                          `<div data-ignore_status="` +
                          ignore_status +
                          `" style="background-color:` +
                          bg_color +
                          `" data-sale_no="`+orders[key].sale_no+`" class="single_future_sale tbl_pointer_row_custom feuture_preview_row future_last_ten_custom_` +
                          orders[key].id +
                          `"  data-id="` +
                          orders[key].id +
                          `"  data-selected="unselected">
                                              <div class="item first_column column">` +
                          order_name +
                          `</div>
                                              <div class="item second_column column">` +
                          orders[key].customer_name +
                          phone_text_ +
                          `</div>
                                              <div class="item third_column column status_self_order">` +
                          orders[key].self_order_status +
                          `</div>
                                          </div>`;
                  }
                  $(".detail_holder").empty();
                  $(".detail_holder").prepend(html_custom);
  
                  status_self_order_checker();
              },
              error: function () {
                  alert(a_error);
              },
          });
      });
      $(document).on("click", ".online_my_order", function (e) {
          $(".self_hide_div").hide();
          $(".title_set_as_decline").hide();
          remove_all_cart_future_info();
          //self order
          let status_txt = $("#status_txt").val();
          $(".last_table_name").html(status_txt);
          let my_orders = $("#my_orders").val();
          $(".self_order_title").html(my_orders);
  
          let set_as_running_order = $("#set_as_running_order").val();
          $(".title_set_as").html(set_as_running_order);
  
          $(".cus_pos_modal_feature_sale_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(200);
          $.ajax({
              url: base_url + "Sale/get_last_10_self_order_sales_ajax",
              method: "GET",
              data:{type:2},
              success: function (response) {
                  let orders = JSON.parse(response);
                  let last_10_orders = "";
                  let html_custom = ` `;
                  for (let key in orders) {
                      let order_name = "";
                      if (orders[key].order_type == "1") {
                          order_name = orders[key].sale_no;
                      } else if (orders[key].order_type == "2") {
                          order_name = orders[key].sale_no;
                      } else if (orders[key].order_type == "3") {
                          order_name = orders[key].sale_no;
                      }
                      let tables_booked = "";
                      if (orders[key].tables_booked.length > 0) {
                          let w = 1;
                          for (let k in orders[key].tables_booked) {
                              let single_table = orders[key].tables_booked[k];
                              if (w == orders[key].tables_booked.length) {
                                  tables_booked += single_table.table_name;
                              } else {
                                  tables_booked += single_table.table_name + ", ";
                              }
                              w++;
                          }
                      } else {
                          tables_booked = "None";
                      }
  
                      let phone_text_ = "";
                      if (orders[key].phone) {
                          phone_text_ = " (" + orders[key].phone + ")";
                      }
                      let bg_color = "";
                      let ignore_status = "";
                      if (orders[key].future_sale_status == 3) {
                          bg_color = "#99e299";
                          ignore_status = "No";
                      }
                      html_custom +=
                          `<div data-ignore_status="` +
                          ignore_status +
                          `" style="background-color:` +
                          bg_color +
                          `" class="single_future_sale tbl_pointer_row_custom feuture_preview_row future_last_ten_custom_` +
                          orders[key].id +
                          `"  data-id="` +
                          orders[key].id +
                          `"  data-selected="unselected">
                                              <div class="item first_column column">` +
                          order_name +
                          `</div>
                                              <div class="item second_column column">` +
                          orders[key].customer_name +
                          phone_text_ +
                          `</div>
                                              <div class="item third_column column status_self_order">` +
                          orders[key].self_order_status +
                          `</div>
                                          </div>`;
                  }
                  $(".detail_holder").empty();
                  $(".detail_holder").prepend(html_custom);
  
                  status_self_order_checker();
              },
              error: function () {
                  alert(a_error);
              },
          });
      });
      $(document).on("click", ".last_ten_self_button", function (e) {
          remove_all_cart_future_info();
  
          $("#is_self_order").val("Yes");
  
          $("#is_self_order_tmp").val(1);
          $(".title_set_as_decline").show();
          //self order
          let date_txt = $("#date_txt").val();
          $(".last_table_name").html(date_txt);
  
          let set_as_approved= $("#set_as_approved").val();
          $(".title_set_as").html(set_as_approved);
  
          let self_orders= $("#self_orders").val();
          $(".self_order_title").html(self_orders);
  
          $(".cus_pos_modal_self_online_sale_modal").addClass("active");
          $(".pos__modal__overlay").fadeIn(200);
          $.ajax({
              url: base_url + "Sale/get_last_10_self_order_sales_ajax_admin",
              method: "POST",
              dataType:"json",
              success: function (response) {
                  $(".detail_holder_self_order").empty();
                  $(".detail_holder_online_order").empty();
  
                  if((response.self_orders).length){
                      let orders = (response.self_orders);
                      let html_custom = ` `;
                      for (let key in orders) {
                          let order_name = "";
                          if (orders[key].order_type == "1") {
                              order_name = orders[key].sale_no;
                          } else if (orders[key].order_type == "2") {
                              order_name = orders[key].sale_no;
                          } else if (orders[key].order_type == "3") {
                              order_name = orders[key].sale_no;
                          }
  
                          let phone_text_ = "";
                          if (orders[key].phone) {
                              phone_text_ = " (" + orders[key].phone + ")";
                          }
                          let bg_color = "";
                          let ignore_status = "";
                          if (orders[key].future_sale_status == 3) {
                              bg_color = "#99e299";
                              ignore_status = "No";
                          }
                          html_custom +=
                              `<div data-ignore_status="` +
                              ignore_status +
                              `" style="background-color:` +
                              bg_color +
                              `" class="self_online_order_row single_self_sale tbl_pointer_row_custom self_preview_row future_last_ten_custom_` +
                              orders[key].id +
                              `"  data-id="` +
                              orders[key].id +
                              `"  data-selected="unselected">
                                              <div class="item first_column column css_column_1">` +
                              order_name +
                              `</div>
                                              <div class="item second_column column css_column_2">` +
                              orders[key].customer_name +
                              phone_text_ +
                              `</div>
                                              <div class="item third_column column">` +
                              orders[key].sale_date +
                              `</div>
                                          </div>`;
                      }
                      $(".detail_holder_self_order").prepend(html_custom);
                  }
                  if((response.online_orders).length){
                      let online_orders = (response.online_orders);
  
                      let html_custom_online = ` `;
                      for (let key in online_orders) {
                          let order_name = "";
                          if (online_orders[key].order_type == "1") {
                              order_name = online_orders[key].sale_no;
                          } else if (online_orders[key].order_type == "2") {
                              order_name = online_orders[key].sale_no;
                          } else if (online_orders[key].order_type == "3") {
                              order_name = online_orders[key].sale_no;
                          }
  
                          let phone_text_ = "";
                          if (online_orders[key].phone) {
                              phone_text_ = " (" + online_orders[key].phone + ")";
                          }
                          if(online_orders[key].del_address && online_orders[key].del_address!=undefined){
                              phone_text_ = "<br>"+online_orders[key].del_address;
                          }
                          let bg_color = "";
                          let ignore_status = "";
                          if (online_orders[key].future_sale_status == 3) {
                              bg_color = "#99e299";
                              ignore_status = "No";
                          }
                          html_custom_online +=
                              `<div data-ignore_status="` +
                              ignore_status +
                              `" style="background-color:` +
                              bg_color +
                              `" class="self_online_order_row single_online_sale tbl_pointer_row_custom online_preview_row future_last_ten_custom_` +
                              online_orders[key].id +
                              `"  data-id="` +
                              online_orders[key].id +
                              `"  data-selected="unselected">
                                              <div class="item first_column column css_column_1">` +
                              order_name +
                              `</div>
                                              <div class="item second_column column css_column_2">` +
                              online_orders[key].customer_name +
                              phone_text_ +
                              `</div>
                                              <div class="item third_column column">` +
                              online_orders[key].sale_date +
                              `</div>
                                          </div>`;
                      }
                      $(".detail_holder_online_order").prepend(html_custom_online);
                  }
  
              },
              error: function () {
                  alert(a_error);
              },
          });
      });
      $(document).on("click", "#draft_edit_modal_invoice_decline", function () {
          let pos_18 = Number($("#pos_18").val());
          if(pos_18){
              let sale_no = $("#last_future_sale_id").val();
              $("#print_type").val(1);
              let this_action = $(this);
              if (sale_no) {
                  this_action
                      .parent()
                      .parent()
                      .parent()
                      .parent()
                      .removeClass("active")
                      .addClass("inActive");
                  setTimeout(function () {
                      $(".cus_pos_modal").removeClass("inActive");
                  }, 1000);
                  $(".pos__modal__overlay").fadeOut(300);
                  $.ajax({
                      url: base_url + "Sale/set_as_running_order_decline",
                      method: "POST",
                      data: {
                        sale_no: sale_no,
                          status: 3,
                          csrf_irestoraplus: csrf_value_,
                      },
                      success: function (response) {
                          response = JSON.parse(response);
                          $("#last_future_sale_id").val("");
                          remove_all_cart_future_info();
                      },
                      error: function () {
                          alert(a_error);
                      },
                  });
              } else {
                toastr['error']((please_select_order_to_proceed + "!"), '');
              }
          }else{
              toastr['error']((menu_not_permit_access + "!"), '');
          }
  });
  
      //if self order and online order open then system will show product view first.
      if(s_width<=700){
          let is_self_order_checker = $("#is_self_order").val();
          let is_online_order_checker = $("#is_online_order").val();
          if(is_self_order_checker=="Yes" || is_online_order_checker=="Yes"){
              $(".show_product").click();
          }
      }
    
      let edit_sale_id_check = Number($("#edit_sale_id").val());
      if(!edit_sale_id_check){
          window.onbeforeunload = function(){
              return 'Are you sure you want to leave?';
          };
      }

    
      $(".menu_assign_class").each(function() {
        let this_access = $(this).attr("data-access");
        if((window.menu_objects).indexOf(this_access) > -1) {
    
        } else {
            if(this_access=="saas"){
                if(company_id_indexdb!=1 && user_id!=1){
                    $(this).remove();
                }
            }else{
                if(this_access!=undefined){
                    $(this).remove();
                }
            }
    
        }
    
    });

      $(".menu_checker").each(function() {
        if(!($(this).find(".sub__menu__list").find("li").length)){
            $(this).remove();
        } 
        setTimeout(function () {
            $(".menu_checker").each(function() {
                if(!($(this).find(".sub__menu__list").find("li").length)){
                    $(this).remove();
                }  
               
            });
        }, 1000);
    
    });
  
  })(jQuery);

  
  
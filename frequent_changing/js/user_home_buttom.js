/*checking menu access and hide*/
let company_id_indexdb  = $("#company_id_indexdb").val();
let user_id  = $("#user_id").val();
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

$(".treeview").each(function() {
    if(!($(this).find(".treeview-menu").find("li").length)){
        $(this).remove();
    }  
    setTimeout(function () {
        $(".treeview").each(function() {
            if(!($(this).find(".treeview-menu").find("li").length)){
                $(this).remove();
            }  
        });
    }, 600);

});

$(".check_main_menu").each(function() {
    if(!($(this).find(".menu_assign_class").length)){
        $(this).remove();
    }
});

$(".sub_sub").each(function() {
    if(!($(this).find(".menu_assign_class").length)){
        $(this).remove();
    }
});

$(".setting_report").each(function() {
    if(!($(this).find(".menu_assign_class").length)){
        $(this).remove();
    }
});
// material icon init
feather.replace();
  
let ir_precision_h = $("#ir_precision").val();
let window_height = $(window).height();
let main_header_height = $('.main-header').height();
let user_panel_height = $('.user-panel').height();
let left_menu_height_should_be = (parseFloat(window_height) - (parseFloat(main_header_height) + parseFloat(
    user_panel_height))).toFixed(ir_precision_h);
left_menu_height_should_be = (parseFloat(left_menu_height_should_be) - parseFloat(60)).toFixed(ir_precision_h);

base_url= $("#base_url_").val();
let csrf_name_= $("#csrf_name_").val();
let csrf_value_= $("#csrf_value_").val();
let not_closed_yet= $("#not_closed_yet").val();
let opening_balance= $("#opening_balance").val();
let customer_due_receive= $("#customer_due_receive").val();
let paid_amount= $("#paid_amount").val();
let in_ = $("#in_").val();
let cash= $("#cash").val();
let paypal= $("#paypal").val();
let sale= $("#sale").val();
let card= $("#card").val();
let register_not_open= $("#register_not_open").val();
let currency = '';

$.ajax({
    url: base_url+"Register/checkRegisterAjax",
    method: "POST",
    data: {
        csrf_name_: csrf_value_
    },
    success: function(response) {
        if (response == '2') {
            $('#close_register_button').css('display', 'none');
        } else {
            $('#close_register_button').css('display', 'block');

        }
    },
    error: function() {
        alert("error");
    }
});

$('#register_close').on('click', function() {
    let r = confirm("Are you sure to close register?");

    if (r == true) {
        $.ajax({
            url: base_url+"Sale/closeRegister",
            method: "POST",
            data: {
                csrf_name_: csrf_value_
            },
            success: function(response) {
                swal({
                    title: 'Alert',
                    text: 'Register closed successfully!!',
                    confirmButtonColor: '#b6d6f6'
                });
                $('#close_register_button').hide();

            },
            error: function() {
                alert("error");
            }
        });
    }
});

$('.set_collapse').on('click', function() {
    let status = Number($(this).attr("data-status"));
    let status_tmp = '';
    if(status==1){
        $(this).attr('data-status',2);
        status_tmp = "No";
    }else{
        $(this).attr('data-status',1);
        status_tmp = "Yes";
    }
    $.ajax({
        url: base_url+"authentication/set_collapse",
        method: "POST",
        data: {
            status: status_tmp,
            csrf_name_: csrf_value_
        },
        success: function(response) {

        },
        error: function() {
            alert("error");
        }
    });
});

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function todaysSummary() {

    $.ajax({
        url: base_url+"Report/todayReport",
        method: 'get',
        dataType: 'json',
        data: {
        csrf_name_: csrf_value_
    },
    success: function(data) {
        $("#purchase_today_").text(currency + data
            .total_purchase_amount);
        $("#sale_today").text(currency + data
            .total_sales_amount);
        $("#totalVat").text(currency + data
            .total_sales_vat);
        $("#Expense").text(currency + data
            .expense_amount);
        $("#supplierDuePayment").text(currency + data
            .supplier_payment_amount);
        $("#customerDueReceive").text(currency + data
            .customer_receive_amount);
        $("#waste_today").text(currency + data
            .total_loss_amount);
        $("#balance").text(currency + data.balance);
        $("#sale_return_amount").text(currency + data.total_total_refund);
       
    }
});
    $("#todaysSummary").modal("show");
}

function draw_modal() {
    let area_id = Number($(".area_id").val());
    if(area_id){
        $("#draw_modal").modal("show");
    }
}
function image_object_modal() {
    let area_id = Number($(".area_id").val());
    if(area_id){
        $("#image_object_modal").modal("show");
    }
}

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

    $("#closing_register_time").html(today_date+" "+time_a);
    /* recursive call for new time*/
    getNewDateTime();
}




"use strict";
let base_url = $("#base_url_").val();
$(document).ready(function(){
   
  $("#datatable").DataTable({
      autoWidth: false,
      ordering: true,
      processing: true,
      order: [[0, "desc"]],
      ajax: {
          url: base_url + "Sale/getAjaxData",
          type: "POST",
          dataType: "json",
          data: {
          },
      },
      columnDefs: [
          { orderable: true, targets: [ 5, 7, 8 ] }
      ],
    dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
    buttons:[
      {
        extend:    'print',
        text:      '<i class="fa-solid fa-print"></i> Print',
        titleAttr: 'print'
     },
      {
          extend:    'copyHtml5',
          text:      '<i class="fa-solid fa-copy"></i> Copy',
          titleAttr: 'Copy'
      },
      {
          extend:    'excelHtml5',
          text:      '<i class="fa-solid fa-file-excel"></i> Excel',
          titleAttr: 'Excel'
      },
      {
          extend:    'csvHtml5',
          text:      '<i class="fa-solid fa-file-csv"></i> CSV',
          titleAttr: 'CSV'
      },
      {
          extend:    'pdfHtml5',
          text:      '<i class="fa-solid fa-file-pdf"></i> PDF',
          titleAttr: 'PDF'
      }
  ],
    language: {
      paginate: {
        previous: "Previous",
        next: "Next",
      },
    },
  });
});

 $("#change_date_sale_modal").datepicker({
   dateFormat: "yy-mm-dd",
   changeYear: true,
   changeMonth: true,
   autoclose: true,
   showMonthAfterYear: true,
   maxDate: 0,
 });

let warning = $("#warning").val();
let a_error = $("#a_error").val();
let ok = $("#ok").val();
let cancel = $("#cancel").val();

function viewInvoice(id) {
  let view_invoice = Number($("#view_invoice").val());
  
  if(view_invoice){
      let newWindow = open(
        base_url+"Sale/print_invoice/" + id,
          "Print Invoice",
          "width=450,height=550"
      );
      newWindow.focus();

      newWindow.onload = function () {
          newWindow.document.body.insertAdjacentHTML("afterbegin");
      };
  }else{
      let menu_not_permit_access = $("#menu_not_permit_access").val();
      swal({
          title: warning,
          text: menu_not_permit_access,
          confirmButtonText: ok,
          confirmButtonColor: '#3c8dbc'
      });
  }

}
let edit_return_id  = Number($("#edit_return_id").val());
let view_invoice = Number($("#view_invoice").val());
if(edit_return_id && view_invoice){
  let base_url = $("#base_url_").val();
    let newWindow = open(
      base_url+"Sale/print_invoice/" + edit_return_id,
        "Print Invoice",
        "width=450,height=550"
    );
    newWindow.focus();

    newWindow.onload = function () {
        newWindow.document.body.insertAdjacentHTML("afterbegin");
    };
}

function change_date(id) {
    let change_date = Number($("#change_date").val());
    if(change_date){
        $("#change_date_sale_modal").val("");
        $("#sale_id_hidden").val(id);
        $("#change_date_modal").modal("show");
    }else{
        let menu_not_permit_access = $("#menu_not_permit_access").val();
        swal({
            title: warning,
            text: menu_not_permit_access,
            confirmButtonText: ok,
            confirmButtonColor: '#3c8dbc'
        });
    }


  // $('#myModal').modal('hide');
  // alert(id);
}

$(document).on("click", ".change_delivery_details", function () {
   let id = $(this).attr("data-id");
   let status = $(this).attr("data-status");

    let change_delivery_address = Number($("#change_delivery_address").val());
    if(change_delivery_address){
        $("#change_date_sale_modal_d").val("");
        $("#sale_id_hidden_d").val(id);
        $("#status").val(status).change();
        $("#change_delivery_address_update").modal("show");
    }else{
        let menu_not_permit_access = $("#menu_not_permit_access").val();
        swal({
            title: warning,
            text: menu_not_permit_access,
            confirmButtonText: ok,
            confirmButtonColor: '#3c8dbc'
        });
    }

});

$(document).on("click", "#close_change_date_modal", function () {
  $("#change_date_sale_modal").val("");
  $("#sale_id_hidden").val("");
});
$(document).on("click", "#save_change_date", function () {
  let change_date = $("#change_date_sale_modal").val();
  let sale_id = $("#sale_id_hidden").val();
  let csrf_name_ = $("#csrf_name_").val();
  let csrf_value_ = $("#csrf_value_").val();
  $.ajax({
    url: base_url + "Sale/change_date_of_a_sale_ajax",
    method: "POST",
    data: {
      sale_id: sale_id,
      change_date: change_date,
      csrf_name_: csrf_value_,
    },
    success: function (response) {
      $("#change_date_sale_modal").val("");
      $("#sale_id_hidden").val("");
      $("#change_date_modal").modal("hide");
    },
    error: function () {
      alert("error");
    },
  });
});
$(document).on("click", "#save_change_status", function () {
  let status = $("#status").val();
  let sale_id = $("#sale_id_hidden_d").val();
  let csrf_name_ = $("#csrf_name_").val();
  let csrf_value_ = $("#csrf_value_").val();
  $.ajax({
    url: base_url + "Sale/change_status_of_a_sale_ajax",
    method: "POST",
    data: {
      sale_id: sale_id,
      status: status,
      csrf_name_: csrf_value_,
    },
    success: function (response) {
        $("#change_delivery_address_update").modal("hide");
        let status_changed_successfully = $("#status_changed_successfully").val();
        swal(
            {
                title: 'Alert',
                text: status_changed_successfully,
                confirmButtonColor: "#3c8dbc",
                confirmButtonText: "OK",
                showCancelButton: false,
            },
            function () {
                location.reload();
            }
        );
    },
    error: function () {
      alert("error");
    },
  });
});

$(document).on("click", ".getDetailsRefund", function () {
    let id = $(this).attr('data-id');
    $("#refund_modal").modal('show');
    $.ajax({
        url: base_url + "Sale/getDetailsRefund",
        method: "POST",
        dataType:'json',
        data: {
            sale_id: id,
            csrf_name_: csrf_value_,
        },
        success: function (response) {
            $(".refund_date").html(response.refund_date_time);
            $("#sale_refund_cart").html(response.html);
        },
        error: function (response) {
           
        },
    });

});
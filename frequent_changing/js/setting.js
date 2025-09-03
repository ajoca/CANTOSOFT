$(function () {
  "use strict";
  //preview the selected images
  $(document).on("click", ".show_preview", function (e) {
    e.preventDefault();
    let file_path = $(this).attr("data-file_path");
    let title = $(this).attr("data-title");
    $("#show_id").attr("src", file_path);
    $("#show_id").css("width", "unset");
    $(".modal-title").text(title);
    $("#logo_preview").modal("show");
  });

  function show_hide_loyalty(){
    let is_loyalty_enable = $("#is_loyalty_enable").val();
    if(is_loyalty_enable=="enable"){
      $(".div_loyalty").show(300);
    }else{
        $(".div_loyalty").hide(300);
    }
  }
  $(document).on("change", "#is_loyalty_enable", function (e) {
    e.preventDefault();
      show_hide_loyalty();
  });
    show_hide_loyalty();

  function set_printing_type() {
    let this_value_kot = $("#printing_kot").val();
    if (this_value_kot == "direct_print") {
      $(".receipt_printer_div_kot").show();
      $(".print_server_url_div_kot").show();
      $(".print_format_div_kot").css("opacity", "0");
      $(".print_format_div_kot").find("input").css("pointer-events", "none");
    } else {
      $(".print_server_url_div_kot").hide();
      $(".receipt_printer_div_kot").hide();
      $(".print_format_div_kot").css("opacity", "1");
    }
  }
  $(document).on("change", ".printing", function (e) {
    set_printing_type();
  });
  set_printing_type();

    $('.customDatepicker_time').datetimepicker({
        format: 'hh:mm a',
        icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            }
    });
 

});

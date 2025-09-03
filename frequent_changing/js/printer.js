$(function () {
    "use strict";
    function set_printing_type() {
        var this_value = $("#type").val();
        let this_value_invoice = $("#printing_choice").val();
        if(this_value=="linux" || this_value == "windows"){
            $(".network_div1").hide();
            $(".receipt_printer_div").show();
        }else if(this_value=="network"){
            $(".receipt_printer_div").hide();
            $(".network_div1").show();
        }else{
            $(".network_div1").hide();
            $(".receipt_printer_div").hide();
        }

        if(this_value_invoice!="direct_print"){
            $(".network_div1").hide();
            $(".receipt_printer_div").hide();
        }
    }

    $(document).on('change','#type' , function(e){
        set_printing_type();

    });
    // Print Server Configuratin Div Hide Show
    function set_printing_choice() {
    let this_value_invoice = $("#printing_choice").val();
    var this_value = $("#type").val();
    if (this_value_invoice == "direct_print") {
        $(".print_server_url_div_invoice").show();
        $(".print_format_div_invoice").css("display", "none");
        $(".print_format_div_invoice").find("input").css("pointer-events", "none");
        $(".div_direct_print").show();

        if(this_value=="linux" || this_value == "windows"){
            $(".receipt_printer_div").show();
        }else if(this_value=="network"){
            $(".receipt_printer_div").hide();
        }

    } else {
        $(".div_direct_print").hide();
        $(".print_server_url_div_invoice").hide();
        $(".print_format_div_invoice").css("display", "block");
    }        
}
    $(document).on("change", ".printing", function (e) {
        set_printing_choice();
        generate_test_print();
    });
    function generate_test_print(){
        let ssl_type = $("#ssl_type").val();
        let ipvfour_address = $("#ipvfour_address").val();
        let type = $("#type").val();
        let path = $("#path_string").val();
        let printer_ip_address = $("#printer_ip_address").val();
        let printer_type_value = '';
        if(type=="windows"){
             printer_type_value = path;
        }else{
             printer_type_value = printer_ip_address;
        }
        let port = $("#printer_port").val();
        let url = ssl_type+ipvfour_address+"/print_server/print.php?printer_type_value="+printer_type_value+"&&port="+port+"&&type="+type;
         $(".test_print").attr("href",url);
         if(!ipvfour_address){
            $(".ipvfour_address_div").hide();
         }else{
            $(".ipvfour_address_div").show();
         }
    }

    $(document).on("keyup", "#ipvfour_address", function (e) {
        generate_test_print();
    });
    generate_test_print();
    set_printing_choice();
    set_printing_type();
    });
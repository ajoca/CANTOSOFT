$(function () {
    "use strict";
    let base_url= $("#base_url_").val();
    function getCounterPrinters(){
        let outlet_id = $("#outlet_id").val();
        $.ajax({
            url:base_url+'counter/get_printers_by_outlet_id',
            method:"POST",
            data: {outlet_id:outlet_id},
            dataType:'json',
            success:function(html_content){
                 $("#invoice_printer_id").html(html_content);
                 $("#bill_printer_id").html(html_content);
                 let hidden_invoice_printer_id = Number($("#hidden_invoice_printer_id").val());
                 let hidden_bill_printer_id = Number($("#hidden_bill_printer_id").val());
                 if(hidden_invoice_printer_id){
                     $("#invoice_printer_id").val(hidden_invoice_printer_id).change();
                 }
                 if(hidden_bill_printer_id){
                    $("#bill_printer_id").val(hidden_bill_printer_id).change();
                 }
            }
        });
    }
    $(document).on("change", "#outlet_id", function (e) {
        getCounterPrinters();
    });
    getCounterPrinters();
});

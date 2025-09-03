$(function() {
    "use strict";
    $(document).on('keyup', '.change_consumption_cost', function() {
        let conversion_rate = $("#conversion_rate").val();
        if(conversion_rate==''){
            conversion_rate = 1;
        }
        let purchase_price = $("#purchase_price").val();
        if(purchase_price==''){
            purchase_price = 0;
        }

        let total_cost = (purchase_price/conversion_rate);
        let ir_precision = $("#ir_precision").val();
        $("#consumption_unit_cost").val(Number(total_cost).toFixed(ir_precision));
    });
});
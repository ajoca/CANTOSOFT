$(function() {
    "use strict";
    $(document).on('change', '#supplier_id', function() {
        let supplier_id = $('#supplier_id').val();
        let csrf_name_= $("#csrf_name_").val();
        let csrf_value_= $("#csrf_value_").val();
        $.ajax({
            type: "GET",
            url: base_url + 'SupplierPayment/getSupplierDue',
            data: {
                supplier_id: supplier_id,
                csrf_name_: csrf_value_
            },
            success: function(data) {
                $("#remaining_due").show();
                $("#remaining_due").text(data);
                $(".alert").show();
            }
        });
    });


    $(document).on('change', '#company', function(){
        let data_interval = $('option:selected', this).attr('data-interval');
        let data_monthly_cost = $('option:selected', this).attr('data-monthly-cost');
        let data_interval2 = $('option:selected', this).attr('data-interval2');
        if(data_interval == 'monthly'){
            $('#payment_price').val(parseFloat(data_monthly_cost));
        }else if(data_interval == 'yearly'){
            $('#payment_price').val(parseFloat(data_interval2));
        }else{
            $('#payment_price').val(parseFloat(0));
        }
    });
});
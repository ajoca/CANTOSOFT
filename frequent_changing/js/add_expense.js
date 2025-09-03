$(function() {
    $(document).on('change', '#tax_status', function(){
        taxStatus();
    });
    $(document).on('change', '#tax_for', function(){
        taxStatus();
    });
    function taxStatus (){
        let tax_status = $('#tax_status').val();
        let tax_for = $('#tax_for').val();
        if(tax_status == 'Enable'){
            $('.customer_or_supplier').show();
            $('.tax_amount_main').show();
            if(tax_for == 'Customer'){
                $('.customers').show();
                $('.suppliers').hide();
            }else{
                $('.customers').hide();
                $('.suppliers').show();
            }
        }else{
            $('.customer_or_supplier').hide();
            $('.tax_amount_main').hide();
            $('.customers').hide();
            $('.suppliers').hide();
        }
    }
    taxStatus();

});



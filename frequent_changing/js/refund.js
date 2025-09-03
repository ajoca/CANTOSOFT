$(function() {
    "use strict";
    let foodmenu_already_remain = $("#foodmenu_already_remain").val();
    let are_you_sure = $("#are_you_sure").val();
    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let ok = $("#ok").val();
    let cancel = $("#cancel").val();
    let alert2 = $("#alert").val();
    let ir_precision = $("#ir_precision").val();


    function calculateAll() {
        let i = 1;
        let total_refund = 0;
        let tax_type = Number($("#tax_type").val());
       
        $(".row_price").each(function() {
            let this_row_qty = Number($(this).parent().find('.row_qty').val());
            let this_row_price = Number($("#row_price_"+i).text());
            let this_row_discount = Number($("#row_discount_"+i).text());
            let this_row_vat = Number($("#row_vat_"+i).text());
            let inline_total = 0;
            if(tax_type==2){
                 inline_total = (this_row_qty*this_row_price) - this_row_discount;
            }else{
                 inline_total = (this_row_qty*this_row_price) - this_row_discount+ (this_row_vat*this_row_qty);
            }
            
            if(!this_row_qty){
                inline_total = 0;
            }
            $("#row_total_"+i).html(inline_total.toFixed(ir_precision));
            total_refund+=inline_total;
            i++;
        });

        $("#total_refund").val(Number(total_refund).toFixed(ir_precision));
    }
    function row_generate() {
        let i = 1;
        $(".row_discount").each(function() {
            $(this).attr("id","row_discount_"+i);
            i++;
        });
        i = 1;
        $(".sn_class").each(function() {
            $(this).html(i);
            i++;
        });
        i = 1;
        $(".row_price").each(function() {
            $(this).attr("id","row_price_"+i);
            i++;
        });
        i = 1;
        $(".row_vat").each(function() {
            $(this).attr("id","row_vat_"+i);
            i++;
        });
        i = 1;
        $(".row_total").each(function() {
            $(this).attr("id","row_total_"+i);
            i++;
        });
        i = 1;
        $(".row_sale_qty").each(function() {
            $(this).attr("id","row_sale_qty_"+i);
            i++;
        });
    }
    setTimeout(function () {
        row_generate();
        calculateAll();
    }, 1000);

    $(document).on('keyup', '.cal_row', function() {
        calculateAll();
    });
    $(document).on('click', '.remove_row', function() {
        $(this).parent().parent().remove();
        row_generate();
        calculateAll();
    });
    $(document).on('change', '#food_details_id', function() {
        let food_details = $('#food_details_id').val();
        if (food_details != '') {
            let food_details_array = food_details.split('|');
            $(".rowCount").each(function() {
                let id_temp = $(this).attr('data-item_id');
                if(id_temp==(food_details_array[0])){
                    swal({
                        title: alert2+"!",
                        text: foodmenu_already_remain,
                        confirmButtonText: ok,
                        confirmButtonColor: '#3c8dbc'
                    });
                    $('#food_details_id').val('').change();
                    exit;
                    return false;
                }
            });
            let html = '<tr class="rowCount" data-item_id="'+food_details_array[0]+'">\n' +
                '                                    <td class="sn_class"></td>\n' +
                '                                    <td>'+food_details_array[1]+'</td>\n' +
                '                                    <td class="row_sale_qty">'+food_details_array[2]+'</td>\n' +
                '                                    <td class="row_price">'+Number(food_details_array[3]).toFixed(ir_precision)+'</td>\n' +
                '                                    <td class="row_vat">'+Number(food_details_array[5]).toFixed(ir_precision)+'</td>\n' +
                '                                    <td class="row_discount">'+Number(food_details_array[4]).toFixed(ir_precision)+'</td>\n' +
                '                                    <td><input type="hidden" name="item_id[]" value="'+food_details_array[0]+'"><input type="hidden" name="name[]" value="'+food_details_array[1]+'"><input type="hidden" name="qty[]" value="'+food_details_array[2]+'"><input type="hidden" name="price[]" value="'+food_details_array[3]+'"><input type="hidden" value="'+food_details_array[4]+'" name="discount[]"><input type="hidden" value="'+food_details_array[5]+'" name="vat[]"><input type="number" name="refund_qty[]" class="form-control row_qty cal_row required_checker"></td>\n' +
                '                                    <td class="row_total"></td>\n' +
                '                                    <td><i class="fa fa-trash remove_row text-red" style="cursor: pointer"></i> </td>\n' +
                '                                </tr>';

            $('#sale_refund_cart').append(html);
            $('#food_details_id').val('').change();
            row_generate();
            calculateAll();
        }
    });


    $(document).on('submit', '#refund_form', function() {
        let error = false;
        let i = 1;
        let focus =1;
        $(".cal_row").each(function() {
            let row_sale_qty = Number($("#row_sale_qty_"+i).text());
            let qty = Number($.trim($(this).val()));

            if (qty == '' || isNaN(qty)) {
                $(this).css("border",'1px solid red');
                error = true;
                if(focus==1){
                    $(this).focus();
                    focus++;
                }
            }else{
                if (qty>row_sale_qty) {
                    $(this).css("border",'1px solid red');
                    error = true;
                    if(focus==1){
                        $(this).focus();
                        focus++;
                    }
                }else{
                    $(this).css("border",'1px solid #ced4da');
                }
            }
        });

        if (error == true) {
            return false;
        }
    });
});
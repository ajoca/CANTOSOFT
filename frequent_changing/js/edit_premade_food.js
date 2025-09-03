
let are_you_sure = $("#are_you_sure").val();
let cancel = $("#cancel").val();
let warning = $("#warning").val();
let a_error = $("#a_error").val();
let ok = $("#ok").val();
let alert2 = $("#alert").val();
let ingredient_already_remain = $("#ingredient_already_remain").val();
let name_field_required = $("#name_field_required").val();
let category_field_required = $("#category_field_required").val();
let veg_item_field_required = $("#veg_item_field_required").val();
let beverage_item_field_required = $("#beverage_item_field_required").val();
let bar_item_field_required = $("#bar_item_field_required").val();
let description_field_can_not_exceed = $("#description_field_can_not_exceed").val();
let sale_price_field_required = $("#sale_price_field_required").val();
let consumption = $("#consumption").val();
let Edit_Variation = $("#Edit_Variation").val();

let ingredient_id_container = [];

$(function() {
    //Initialize Select2 Elements
    $('.select2').select2();
    Number.prototype.padLeft = function (n,str){
        return Array(n-String(this).length+1).join(str||'0')+this;
    }

    $(document).on('keydown', '.integerchk', function(e) {
        /*$('.integerchk').keydown(function(e) {*/
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
        return (
            keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });

    let suffix =0;

    let tab_index = 6;

    function calculation_row() {
        let total_cost = 0;
        $(".rowCount").each(function() {
            let this_value = Number($(this).attr('id').substr(4));
            let consumption = Number($("#vr01_consumption_"+this_value).val());
            let cost = Number($("#vr01_cost_"+this_value).val());
            $("#vr01_total_cost_"+this_value).val((consumption*cost).toFixed(3));
            total_cost+=(consumption*cost);
        });
        $("#grand_total_cost").val(total_cost.toFixed(3));

        let conversion_rate = $("#conversion_rate").val();
        if(conversion_rate==''){
            conversion_rate = 1;
        }
        let purchase_price = $("#grand_total_cost").val();
        if(purchase_price==''){
            purchase_price = 0;
        }
        total_cost = (purchase_price/conversion_rate);
        $("#consumption_unit_cost").val(Number(total_cost).toFixed(3));

    }
    setTimeout(function () {
        calculation_row();
    }, 1000);

    $(document).on('keyup', '.change_consumption_cost', function() {
        calculation_row();
    });
    function vr01_calculation_row() {
        let total_cost = 0;
        $(".row_counter_variation").each(function() {
            let this_value = Number($(this).html());
            let consumption = Number($("#vr01_md_consumption_"+this_value).val());
            let cost = Number($("#vr01_md_cost_"+this_value).val());
            $("#vr01_md_total_cost_"+this_value).val((consumption*cost).toFixed(3));
            total_cost+=(consumption*cost);
        });
        $("#var01_grand_total_cost").val(total_cost.toFixed(3));
    }

    $(document).on('click', '.add_variation', function(e) {
        let variation_title = $(this).attr('data-title');
        $(".variation_title").html(variation_title);
        let sale_price = $("#sale_price").val();
        $("#m_sale_price").val(sale_price);
        $("#variation_name").val('');

        let sizeofrow = Number($(".row_variation_view").length)+1;
        let parent_code = $("#code").val();
        $("#variation_name_code").val(parent_code+'-'+((sizeofrow).padLeft(2)));
        let html_row = '';
        let row_counter = 1;
        $(".ingredient_id").each(function() {
            let row_counter = $(this).attr('data-row_id');
            let ing_text = $("#vr01_txt_igr_"+row_counter).text();
            let  vr01_consumption = $("#vr01_consumption_"+row_counter).val();
            let  vr01_cost = $("#vr01_cost_"+row_counter).val();
            let  vr01_total_cost = $("#vr01_total_cost_"+row_counter).val();
            let  vr01_ingredient_id = $("#ingredient_id_"+row_counter).val();
            let  vr01_unit = $("#vr01_unit_"+row_counter).html();

            let variation_update_id = Number($("#variation_update_id").val());
            let row_id = 0;
            if(!Number($(".row_variation_view").length)){
                row_id = Number($(".row_variation_view").length)+1;
            }else {
                row_id = variation_update_id;
            }
            html_row += '<tr class="hidden_ing'+row_id+'">\n' +
                '                                    <td class="text_middle row_counter_variation"></td>\n' +
                '                                    <td class="text_middle"><span class="vr01_md_text">'+ing_text+'</span></td>\n' +
                '                                        <input type="hidden" class="vr01_md_hideingredient_id" name="vr01_ingredient_id[]" value="'+vr01_ingredient_id+'">\n' +
                '                                    <td class="text_middle">\n' +
                '                                        <table>\n' +
                '                                            <tr>\n' +
                '                                                <td><input type="text" tabindex="7" name="vr01_consumption[]" onfocus="this.select();" value="'+vr01_consumption+'" class="form-control integerchk  vr01_md_consumption add_change_value vr01_calculate" placeholder="Consumption"></td>\n' +
                '                                                <td><span class="label_aligning vr01_md_unit">'+vr01_unit+'</span></td>\n' +
                '                                            </tr>\n' +
                '                                        </table>\n' +
                '                                        </td>\n' +
                '                                    <td class="text_middle">\n' +
                '                                       <input type="text" tabindex="7" name="vr01_cost[]" onfocus="this.select();" value="'+vr01_cost+'" class="form-control integerchk  vr01_md_cost add_change_value vr01_calculate" placeholder="Cost"></td>' +
                '                                        </td>\n' +
                '                                    <td class="text_middle">\n' +
                '                                        <input type="text" tabindex="7" name="vr01_total_cost[]" readonly onfocus="this.select();" value="'+vr01_total_cost+'" class="form-control integerchk  vr01_md_total_cost add_change_value" placeholder="Total">'+
                '                                        </td>\n' +
                '                                    <td class="text_middle"><i class="remove_row fa fa-trash"></i></td>\n' +
                '                                </tr>';

            row_counter++;
        });
        $(".added_ingr").html(html_row);
        updateRowNo();
        vr01_calculation_row();
        $("#variation_modal").modal('show');
    });
    $(document).on('click', '.remove_row', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        updateRowNo();
    });
    $(document).on('click', '.row_delete', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        updateRowNo();
    });
    $('#variation_modal').on('hidden.bs.modal', function () {
        $("#variation_update_id").val('');
    });
    $(document).on('keyup', '.required_checker_ing', function() {
        calculation_row();
    });
    $(document).on('keyup', '.vr01_calculate', function() {
        vr01_calculation_row();
    });
    $(document).on('click', '.del_ing', function() {
        let suffix = $(this).attr('data-suffix');
        let id =   $(this).attr('data-ing_id');
        let this_action = $(this);
        swal({
            title: warning,
            text: are_you_sure,
            confirmButtonColor: '#3c8dbc',
            cancelButtonText: cancel,
            confirmButtonText: ok,
            showCancelButton: true
        }, function() {
            this_action.parent().parent().remove();
            let ingredient_id_container_new = [];

            for (let i = 0; i < ingredient_id_container.length; i++) {
                if (ingredient_id_container[i] != id) {
                    ingredient_id_container_new.push(ingredient_id_container[i]);
                }
            }
            ingredient_id_container = ingredient_id_container_new;
            updateRowNo();
            calculation_row();
        });
    });
    $(document).on('click', '.del_fm', function() {
        let this_action = $(this);
        swal({
            title: warning,
            text: are_you_sure,
            confirmButtonColor: '#3c8dbc',
            cancelButtonText: cancel,
            confirmButtonText: ok,
            showCancelButton: true
        }, function() {
            this_action.parent().parent().remove();
            updateRowNo();
        });
    });
    $(document).on('keyup', '.add_change_value', function(e) {
        $(this).attr('value',($(this).val()));
    });

    $(document).on('change', '#ingredient_id', function() {
        let ingredient_details = $('#ingredient_id').val();
        if (ingredient_details != '') {
            let ingredient_details_array = ingredient_details.split('|');
            let index = ingredient_id_container.indexOf(ingredient_details_array[0]);

            if (index > -1) {
                swal({
                    title: warning,
                    text: ingredient_already_remain,
                    confirmButtonText: ok,
                    confirmButtonColor: '#3c8dbc'
                });
                $('#ingredient_id').val('').change();
                return false;
            }

            suffix++;
            tab_index++;
            let cart_row = '<tr class="rowCount" id="row_' + suffix + '">' +
                '<td style="width: 12%; padding-left: 10px;"><p>' + suffix + '</p></td>' +
                '<td class="ir_w_23"><span class="vr01_txt_igr" style="padding-bottom: 5px;">' + ingredient_details_array[1] + '</span></td>' +
                '<input type="hidden" id="ingredient_id_' + suffix +
                '" name="ingredient_id[]" class="ingredient_id" value="' + ingredient_details_array[0] + '"/>' +
                '                                    <td class="text_middle">\n' +
                '                                        <table>\n' +
                '                                            <tr>\n' +
                '                                                <td><input type="text" tabindex="7" name="consumption[]" onfocus="this.select();" value="" class="form-control integerchk aligning vr01_consumption add_change_value required_checker_ing" placeholder="Consumption"></td>\n' +
                '                                                <td><span class="label_aligning vr01_unit">'+ingredient_details_array[2]+'</span></td>\n' +
                '                                            </tr>\n' +
                '                                        </table>\n' +
                '                                        </td>\n' +
                '<td style="width: 30%"><input type="text" tabindex="' + tab_index +
                '" id="cost_' + suffix +
                '" name="cost[]" onfocus="this.select();" value="'+ingredient_details_array[3]+'" class="form-control integerchk aligning vr01_cost add_change_value required_checker_ing" class="ir_w_85" placeholder="Cost"/></td>' +
                '<td style="width: 30%"><input type="text" tabindex="' + tab_index +
                '" id="total_cost_' + suffix +
                '" name="total_cost[]" readonly onfocus="this.select();"  class="form-control integerchk aligning vr01_total_cost  required_checker_ing" class="ir_w_85" placeholder="Cost"/></td>' +
                '<td class="ir_w_17"><a class="btn btn-danger btn-xs del_ing" data-suffix="'+suffix+'" data-ing_id="'+ingredient_details_array[0]+'" style="margin-left: 5px;"><i class="fa fa-trash"></i> </a></td>' +
                '</tr>';

            $('#ingredient_consumption_table').append(cart_row);

            setTimeout(function () {
                $(".select22").select();
            }, 500);

            ingredient_id_container.push(ingredient_details_array[0]);
            /*updateRowNo();*/
            $('#ingredient_id').val('').change();
            updateRowNo();
            calculation_row();
        }
    });
    // Validate form
    $(document).on('submit', '#food_menu_form', function() {
        let name = $("#name").val();
        let category_id = $("#category_id").val();
        let veg_item = $("#veg_item").val();
        let beverage_item = $("#beverage_item").val();
        let bar_item = $("#bar_item").val();
        let description = $("#description").val();
        let sale_price = $("#sale_price").val();
        let ingredientCount = $("#form-table tbody tr").length;
        let error = false;

        if (name == "") {
            $("#name_err_msg").text(name_field_required);
            $(".name_err_msg_contnr").show(200);
            error = true;
        }
        if (category_id == "") {
            $("#category_id_err_msg").text(category_field_required);
            $(".category_err_msg_contnr").show(200);
            error = true;
        }
        if (veg_item == "") {
            $("#veg_item_err_msg").text(veg_item_field_required);
            $(".veg_item_err_msg_contnr").show(200);
            error = true;
        }
        if (beverage_item == "") {
            $("#beverage_item_err_msg").text(beverage_item_field_required);
            $(".beverage_item_err_msg_contnr").show(200);
            error = true;
        }
        if (bar_item == "") {
            $("#bar_item_err_msg").text(bar_item_field_required);
            $(".bar_item_err_msg_contnr").show(200);
            error = true;
        }

        if (description.length > 200) {
            $("#description_err_msg").text(description_field_can_not_exceed);
            $(".description_err_msg_contnr").show(200);
            error = true;
        }

        if (sale_price == "") {
            $("#sale_price_err_msg").text(sale_price_field_required);
            $(".sale_price_err_msg_contnr").show(200);
            error = true;
        }
        if (error == true) {
            return false;
        }
    });
});

function deleter(suffix, ingredient_id) {
    swal({
        title: warning,
        text: are_you_sure,
        confirmButtonColor: '#3c8dbc',
        cancelButtonText: cancel,
        confirmButtonText: ok,
        showCancelButton: true
    }, function() {
        $("#row_" + suffix).remove();
        let ingredient_id_container_new = [];

        for (let i = 0; i < ingredient_id_container.length; i++) {
            if (ingredient_id_container[i] != ingredient_id) {
                ingredient_id_container_new.push(ingredient_id_container[i]);
            }
        }
        ingredient_id_container = ingredient_id_container_new;
        updateRowNo();
    });

}

function updateRowNo() {
    let numRows = $("#ingredient_consumption_table").find("tr").length;
    for (let r = 0; r < numRows; r++) {
        $("#ingredient_consumption_table").find("tr").eq(r).find("td:first p").text(r + 1);
    }
    let i = 1;
    $(".vr01_consumption").each(function() {
        $(this).attr("id","vr01_consumption_"+i);
        i++;
    });
    i = 1;
    $(".vr01_cost").each(function() {
        $(this).attr("id","vr01_cost_"+i);
        i++;
    });
    i = 1;
    $(".vr01_total_cost").each(function() {
        $(this).attr("id","vr01_total_cost_"+i);
        i++;
    });
    i = 1;
    $(".vr01_ingredient_id").each(function() {
        $(this).attr("id","vr01_ingredient_id_"+i);
        $(this).attr("data-row_id",i);
        i++;
    });
    i = 1;
    $(".rowCount").each(function() {
        $(this).attr("id","row_"+i);
        i++;
    });
    i =1;
    $(".ingredient_id").each(function() {
        $(this).attr("data-row_id",i);
        i++;
    });
    i = 1;
    $(".vr01_unit").each(function() {
        $(this).attr("id","vr01_unit_"+i);
        i++;
    });
    i = 1;
    $(".vr01_txt_igr").each(function() {
        $(this).attr("id","vr01_txt_igr_"+i);
        i++;
    });
    i = 1;
    $(".vr01_md_hideingredient_id").each(function() {
        $(this).attr("id","vr01_md_hideingredient_id_"+i);
        $(this).attr("data-row_id",i);
        i++;
    });
    i = 1;
    $(".row_edit").each(function() {
        $(this).attr("data-id",i);
        i++;
    });
    i = 1;
    $(".vr01_md_consumption").each(function() {
        $(this).attr("id","vr01_md_consumption_"+i);
        i++;
    });
    i = 1;

    $(".vr01_md_cost").each(function() {
        $(this).attr("id","vr01_md_cost_"+i);
        i++;
    });
    i = 1;
    $(".vr01_md_total_cost").each(function() {
        $(this).attr("id","vr01_md_total_cost_"+i);
        i++;
    });
    i = 1;
    $(".vr01_md_text").each(function() {
        $(this).attr("id","vr01_md_text_"+i);
        i++;
    });
    i = 1;
    $(".vr01_md_unit").each(function() {
        $(this).attr("id","vr01_md_unit_"+i);
        i++;
    });
    i = 1;
    $(".row_variation_view").each(function() {
        $(this).attr("id","row_variation_view"+i);
        i++;
    });
    i = 1;
    $(".tax_details").each(function() {
        $(this).attr("id","tax_details"+i);
        i++;
    });
    i = 1;
    $(".vr_ingr_details").each(function() {
        $(this).attr("id","vr_ingr_details"+i);
        i++;
    });
    i = 1;
    $(".variation_ing_div").each(function() {
        $(this).attr("id","variation_ing_div"+i);
        i++;
    });

    i = 1;
    $(".variation_ingrs").each(function() {
        $(this).attr("id","variation_ingrs"+i);
        i++;
    });
    i = 1;
    $(".hidden_delivery_html").each(function() {
        $(this).attr("id","hidden_delivery_html"+i);
        i++;
    });

    i = 1;
    $(".delivery_person_var").each(function() {
        $(this).attr("data-row_id",i);
        $(this).attr("id","delivery_person_var"+i);
        i++;
    });
    i = 1;
    $(".sale_price_delivery_json_var").each(function() {
        $(this).attr("id","sale_price_delivery_json_var"+i);
        i++;
    });
    i = 1;
    $(".variation_row_update").each(function() {
        $(this).attr("id","variation_row_update"+i);
        i++;
    });

    i = 1;
    $(".row_variation_view").each(function() {
        let id = $(this).find(".row_edit").attr('data-id');
        $(this).find(".vr01_tax_field_percentage").attr('name',"vr01_tax_field_percentage"+id+"[]");
        $(this).find(".vr01_tax_field_id").attr('name',"vr01_tax_field_id"+id+"[]");
        $(this).find(".vr01_tax_field_company_id").attr('name',"vr01_tax_field_company_id"+id+"[]");
        $(this).find(".vr01_tax_field_name").attr('name',"vr01_tax_field_name"+id+"[]");
    });

    i = 1;
    $(".row_counter_variation").each(function() {
        $(this).html(i);
        i++;
    });
    i = 1;
    $(".vr_row_counter").each(function() {
        $(this).html(i);
        i++;
    });
    i = 1;
    $(".txt_food_row").each(function() {
        $(this).html(i);
        i++;
    });
}
setTimeout(function () {
    updateRowNo();
}, 1000);


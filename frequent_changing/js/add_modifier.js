"use strict";
let warning = $("#warning").val();
let a_error = $("#a_error").val();
let ok = $("#ok").val();
let cancel = $("#cancel").val();
let ingredient_already_remain = $("#ingredient_already_remain").val();
let name_field_required = $("#name_field_required").val();
let description_field_can_not_exceed = $("#description_field_can_not_exceed").val();
let price_field_required = $("#price_field_required").val();
let at_least_ingredient = $("#at_least_ingredient").val();
let are_you_sure = $("#are_you_sure").val();
let consumption = $("#consumption").val();
let alert_ = $("#alert").val();

let ingredient_id_container = [];
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2();

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

    function calculation_row() {
        let total_cost = 0;
        $(".rowCount").each(function() {
            let this_value = Number($(this).attr('id').substr(4));
            let consumption = Number($("#consumption_"+this_value).val());
            let cost = Number($("#vr01_cost_"+this_value).val());
            $("#vr01_total_cost_"+this_value).val((consumption*cost).toFixed(2));
            total_cost+=(consumption*cost);
        });
        $("#grand_total_cost").val(total_cost.toFixed(2));
    }
    $(document).on('keyup', '.required_checker_ing', function() {
        calculation_row();
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
            let ingredient_id_container_new = [];
            this_action.parent().parent().remove();

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
    let suffix =0;

    let tab_index = 6;



    $(document).on('change', '#ingredient_id', function() {
        let ingredient_details = $('#ingredient_id').val();
        if (ingredient_details != '') {
            let ingredient_details_array = ingredient_details.split('|');
            let index = ingredient_id_container.indexOf(ingredient_details_array[0]);

            if (index > -1) {
                swal({
                    title: alert_+"!",
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
                '<td class="ir_w_23"><span style="padding-bottom: 5px;">' + ingredient_details_array[
                    1] + '</span></td>' +
                '<input type="hidden" id="ingredient_id_' + suffix +
                '" name="ingredient_id[]" value="' + ingredient_details_array[0] + '"/>' +
                '<td style="width: 30%"><input type="text" tabindex="' + tab_index +
                '" id="consumption_' + suffix +
                '" name="consumption[]" onfocus="this.select();"  class="form-control integerchk consumption_c aligning required_checker_ing ir_w_85" placeholder="'+consumption+'"/><span class="label_aligning">' +
                ingredient_details_array[2] + '</span></td>' +
                '<td style="width: 30%"><input type="text" tabindex="' + tab_index +
                '" id="cost_' + suffix +
                '" name="cost[]" onfocus="this.select();" value="'+ingredient_details_array[3]+'" class="form-control integerchk aligning vr01_cost add_change_value required_checker_ing" class="ir_w_85" placeholder="Cost"/></td>' +
                '<td style="width: 30%"><input type="text" tabindex="' + tab_index +
                '" id="total_cost_' + suffix +
                '" name="total_cost[]" readonly onfocus="this.select();"  class="form-control integerchk aligning vr01_total_cost  required_checker_ing" class="ir_w_85" placeholder="Cost"/></td>' +
                '<td class="ir_w_17"><a class="btn btn-danger btn-xs del_ing" data-suffix="'+suffix+'" data-ing_id="'+ingredient_details_array[0]+'" ><i class="fa fa-trash"></i> </a></td>' +
                '</tr>';

            $('#ingredient_consumption_table tbody').append(cart_row);

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
        let description = $("#description").val();
        let price = $("#price").val();
        let ingredientCount = $("#form-table tbody tr").length;
        let error = false;


        if (name == "") {
            $("#name_err_msg").text(name_field_required);
            $(".name_err_msg_contnr").show(200);
            error = true;
        }
        if (description.length > 200) {
            $("#description_err_msg").text(description_field_can_not_exceed);
            $(".description_err_msg_contnr").show(200);
            error = true;
        }

        if (price == "") {
            $("#price_err_msg").text(price_field_required);
            $(".price_err_msg_contnr").show(200);
            error = true;
        }

        for (let n = 1; n <= ingredient_id_container.length + 1; n++) {
            let ingredient_id = $.trim($("#ingredient_id_" + n).val());
            let consumption = $.trim($("#consumption_" + n).val());

            if (ingredient_id.length > 0) {
                if (consumption == '' || isNaN(consumption)) {
                    $("#consumption_" + n).css({
                        "border-color": "red"
                    }).show(200);
                    error = true;
                }
            }
        }

        if (error == true) {
            return false;
        }
    });
})

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
    let numRows = $("#ingredient_consumption_table tbody tr").length;
    for (let r = 0; r < numRows; r++) {
        $("#ingredient_consumption_table tbody tr").eq(r).find("td:first p").text(r + 1);
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
    $(".consumption_c").each(function() {
        $(this).attr("id","consumption_"+i);
        i++;
    });
    i = 1;
    $(".vr01_total_cost").each(function() {
        $(this).attr("id","vr01_total_cost_"+i);
        i++;
    });
    i = 1;
    $(".rowCount").each(function() {
        $(this).attr("id","row_"+i);
        i++;
    });
    i = 1;
    $(".del_ing").each(function() {
        $(this).attr("data-suffix",i);
        i++;
    });

}
$(function () {
    "use strict";
    let hidden_alert = $(".hidden_alert").val();
    let hidden_ok = $(".hidden_ok").val();
    let required_roll_name = $(".required_roll_name").val();
    let at_least_one_check_access = $(".at_least_one_check_access").val();

    "use strict";
    tippy(".commission_tooltip", {
        animation: "scale",
        content:
            `<div style="text-align:center"></div>`,
        allowHTML: true,
    });
    $(".parent_class").each(function(){
        let this_parent_name=$(this).attr('data-name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });
    $(document).on('click', '.child_class', function(e){
        let this_parent_name = $(this).attr('data-parent_name');
        if($(".child_"+this_parent_name).length == $(".child_"+this_parent_name+":checked").length) {
            $(".parent_class_"+this_parent_name).prop("checked", true);
        } else {
            $(".parent_class_"+this_parent_name).prop("checked", false);
        }
    });
    $(document).on('click', '.parent_class', function(e){
        let this_name=$(this).attr('data-name');

        let checked = $(this).is(':checked');
        if(checked){
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $(".child_"+this_name).each(function(){
                $(this).prop("checked",false);
            });
        }
    });

    if($(".checkbox_role").length == $(".checkbox_role:checked").length) {
        $("#checkbox_roleAll").prop("checked", true);
    } else {
        $("#checkbox_roleAll").removeAttr("checked");
    }
    // Check or Uncheck All checkboxes
    $(document).on('change', '#checkbox_roleAll', function(e){
        let checked = $(this).is(':checked');
        if(checked){
            $(".checkbox_role").each(function(){
                $(this).prop("checked",true);
            });
            $(".checkbox_role_p").prop("checked", true);
        }else{
            $(".checkbox_role").each(function(){
                $(this).prop("checked",false);
            });
            $(".checkbox_role_p").prop("checked", false);
        }
    });
    $(document).on('click', '.checkbox_role', function(e){
        if($(".checkbox_role").length == $(".checkbox_role:checked").length) {
            $("#checkbox_roleAll").prop("checked", true);

        } else {
            $("#checkbox_roleAll").prop("checked", false);
        }
    });
    $(document).on('submit', '#add_role', function(e){
        let temp = 0 ;
        let role_name = $("#role_name").val();
        let error = false;

        if(role_name==''){
            swal({
                title: hidden_alert+"!",
                text: required_roll_name,
                confirmButtonText:hidden_ok
            });

            $(".error_alert_role_name").html(required_roll_name);
            error = true;
        }else {
            $(".error_alert_role_name").html("");
        }
        $(".child_class").each(function(){
            let checked = $(this).is(':checked');
            if(checked){
                temp++;
            }
        });
        if(temp==0){
            swal({
                title: hidden_alert+"!",
                text: at_least_one_check_access,
                confirmButtonText:hidden_ok
            });
            $(".error_alert_atleast").html(at_least_one_check_access);
            return false;
        }else {
            $(".error_alert_atleast").html("");
        }
        if(error == true){
            return false;
        }
    });
    $('#will_login_yes').on('click',function(){
        $('#will_login_section').fadeIn();
    });
    $('#will_login_no').on('click',function(){
        $('#will_login_section').fadeOut();
    });

    $(document).on('keydown', '.discount', function(e){
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

    $(document).on('keyup', '.discount', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });

    let is_saas = Number($(".is_saas").val());
    if(is_saas){
        $(".div_11").remove();
    }else{
        $(".parent_class_Pricing_Plans").remove();
    }

});
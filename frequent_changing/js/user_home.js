jQuery(document).ready(function ($) {
    "use strict";
    let warning = $("#warning").val();
    let a_error = $("#a_error").val();
    let ok = $("#ok").val();
    let cancel = $("#cancel").val();
    let are_you_sure = $("#are_you_sure").val();
   
    $('.select2').select2();
    $(".delete").click(function (e) {
        e.preventDefault();
        let linkURL = this.href;
        warnBeforeRedirect(linkURL);
    });

    function warnBeforeRedirect(linkURL) {
        swal({
            title: warning + "!",
            text: are_you_sure + "?",
            cancelButtonText: cancel,
            confirmButtonText: ok,
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function () {
            window.location.href = linkURL;
        });
    }
 


    $(document).on('keydown', '.integerchk', function (e) {
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


    $(document).on('click', '.menu_assign_class', function (e) {
        let this_menu_id = $(this).attr("data-menu__cid");
        localStorage['active_menu'] = this_menu_id;
    });

    $(document).on('click', '.treeview', function (e) {
        if ($(this).hasClass("menu-open")) {
            $(this).find('ul').addClass('active_menu_child');
        } else {
            $(this).find('ul').removeClass('active_menu_child');
        }
    });

    //set active menu for admin panel
    let active_menu_id = localStorage['active_menu'];
    if (active_menu_id) { 
        $(".menu__cid" + active_menu_id).addClass('active');
        $(".menu__cid" + active_menu_id).find('ul').addClass('active_menu_child');
    }  


    $(document).on('keyup', '.integerchk', function (e) {
        let ir_precision_integ = $("#ir_precision").val();

        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        $(this).val(input.replace(/[^0-9]/, ''));
        if (slash > 2)
            $(this).val(input.substr(0, (input.length) - 1));
        if (ponto == 2)
            $(this).val(input.substr(0, (input.indexOf('.') + (Number(ir_precision_integ) + 1))));
        if (input == '.')
            $(this).val("");

    });

    //Date picker
    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $('#dates2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $('.customDatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    $('.start_date_today').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '0'
    });
    $(".datepicker_months").datepicker({
        format: 'yyyy-M',
        autoclose: true,
        viewMode: "months",
        minViewMode: "months"
    });

    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1; //January is 0!
    let yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }
    today = yyyy + '-' + mm + '-' + dd;
});



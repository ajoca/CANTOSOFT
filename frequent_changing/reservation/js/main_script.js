(function ($) {
    "use strict";
    //Initialize Select2 Elements
    $('.select2').select2();

    function set_date_selected(date){
        let day_name = (getDayName(new Date(date)));
        $(".available_check").parent().find('span').removeClass('irp_selected_date');
        $(".available_check").each(function() {
            let this_title = $(this).attr('data-title');
            if(day_name===this_title){
                $(this).parent().find('span').addClass('irp_selected_date');
            }

        });
    }
    $(document).on('submit','.add_reservation',function(e){
        let status_submit = false;
        let focus = 1;

        let company_id_value = $("#company_id").val();
        let outlet_id_value = $("#outlet_id").val();
        let reservation_type_value = $("#reservation_type").val();

        let company_id = $("#company_id").data("select2");
        let outlet_id = $("#outlet_id").data("select2");
        let reservation_type = $("#reservation_type").data("select2");

        if(company_id_value==''){
            if(focus==1){
                company_id.open();
                status_submit = true;
                focus++;
            }
        }

        if(outlet_id_value==''){
            if(focus==1){
                outlet_id.open();
                status_submit = true;
                focus++;
            }
        }

        if(reservation_type_value==''){
            if(focus==1){
                reservation_type.open();
                status_submit = true;
                focus++;
            }
        }


        $(".required_checker").each(function() {
            let this_value = $(this).val();
            if(this_value==''){
                $(this).css("border","1px solid red");
                status_submit = true;
                if(focus==1){
                    $(this).focus();
                    focus++;
                }
            }else{
                $(this).css("border","1px solid #d2d6de");
            }
        });


        let this_action = $(this);
        if(status_submit==false){
            return true;
        }else{
            return false;
        }

    });
    function getDayName(date = new Date(), locale = 'en-US') {
        return date.toLocaleDateString(locale, {weekday: 'long'});
    }
    function getOutlets() {
        let base_url = $("#base_url").val();
        let company_id = $("#company_id").val();
        $.ajax({
            url     : base_url+'Authentication/getOutlets',
            method  : 'post',
            dataType: 'json',
            data    : {company_id:company_id},
            success:function(data){
                $("#outlet_id").html(data.outlets);
                $("#reservation_time").html(data.time_dropdown);

                let selected_date = $("#reservation_date").val();
                set_date_selected(selected_date);
            }
        });
    }
    getOutlets();
    $(document).on('change', '#outlet_id', function(e) {
        let outlet_address_tmp = $(this).find(':selected').attr("data-outlet_address");
        let outlet_phone_tmp = $(this).find(':selected').attr("data-outlet_phone");
        let outlet_email_tmp = $(this).find(':selected').attr("data-outlet_email");
        $(".outlet_address").html(outlet_address_tmp);
        $(".outlet_phone").html(outlet_phone_tmp);
        $(".outlet_email").html(outlet_email_tmp);
    });

    $('.start_date_today').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate:'0'
    }).on('changeDate', function(selected) {
        let selected_date = new Date(selected.date.valueOf());
        set_date_selected(selected_date);
    });
    let exception_msg = $("#exception_msg").val();
    if(exception_msg){
        swal({
            title: "Alert!",
            text: exception_msg,
            confirmButtonText: "OK",
            confirmButtonColor: '#3c8dbc'
        });
    }

    getOutlets();
}(jQuery)); 
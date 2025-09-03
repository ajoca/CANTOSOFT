$(function () {
    "use strict";
    let base_url_ajax_contact_us = $("#base_url_ajax").val();
    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $(document).on("click", ".payment_type", function (e) {
        e.preventDefault();
        let type = Number($(this).attr("type"));
        $(".set_url").each(function () {
            let id = Number($(this).attr("data-id"));
            $(this).attr('href',base_url_ajax_contact_us+"plan/"+id+"/"+type);
        });

        $("#package_type").val(type);
        $(".payment_type").removeClass('div_active');
        $(this).addClass('div_active');

        if(type==1){
            $(".show_div_1").show();
            $(".show_div_2").hide();
        }else{
            $(".show_div_2").show();
            $(".show_div_1").hide();
        }
        $(".update_details").each(function () {
            $(this).text($(this).attr("data-div_"+type));
        });

    });
    $(document).on("click", ".send_mail", function (e) {
        e.preventDefault();
        let status = false;
        let focus = 1;

        $(".required_check").each(function () {
            let this_value =  $(this).val();
            if(this_value==''){
                status = true;
                if(focus==1){
                    $(this).focus();
                    focus++;
                }
                $(this).css("border","2px solid #c53d3d");
            }else{
                $(this).css("border","1px solid #e5e5e5");
            }
        });
        if(status==false){
            let email = $("#email").val();
            if(!isEmail(email)){
                status = true;
                $("#email").focus();
                $("#email").css("border","2px solid #c53d3d");
            }else{
                $("#email").css("border","1px solid #e5e5e5");
            }
        }
        if(status==false){
            var data = $("form#contact_us_form").serialize();
            // use jQuery ajax
            let hidden_alert = $("#hidden_alert").val();
            let hidden_ok = $("#hidden_ok").val();
            $.ajax({
                url:base_url_ajax_contact_us+'send-email',
                method:"POST",
                data: data,
                dataType:'json',
                success:function(data){
                    if(data.status==true){
                        $("#name").val('');
                        $("#email").val('');
                        $("#phone").val('');
                        $("#subject").val('');
                        $("#message").val('');
                    }
                    swal({
                        title: hidden_alert,
                        text: data.msg,
                        confirmButtonText: hidden_ok,
                        confirmButtonColor: "#7367f0",
                    });
                }
            });
        }else{
            return false;
        }
    });
});

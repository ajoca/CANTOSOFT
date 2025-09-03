$(function () {
    "use strict";
    $(document).on('click', '.set_credentials', function(){
       let username = $(this).attr("data-username");
       let password = $(this).attr("data-password");
       $("#email_address").val(username);
       $("#password").val(password);
    });
    
    $('.toggle').on('click', function() {
        $('.container').stop().addClass('active');
    });

    $('.close').on('click', function() {
        $('.container').stop().removeClass('active');
    });

    // ---- Single pincode input -----
    let  loginpin = $('#loginpin').pinlogin({
        fields : 4,
        complete : function(pin){
            $("#login_pin").val(pin);
            $(".submit_login").click();
            loginpin.disable();
        },
    });

    function show_hide(btn_type) {
        if(btn_type==1){
            $(".div_1").hide(200);
            $(".div_2").show(200);
        }else{
            $(".div_1").show(200);
            $(".div_2").hide(200);
            $("#loginpin_pinlogin_0").focus();
        }
    }

   let active_login_button_hidden =  $("#active_login_button_hidden").val();
    show_hide(active_login_button_hidden);
    //generate random code button
    $('body').on('click', '.btn_login_pin_type', function (e) {
        e.preventDefault();

        $(".btn_login_pin_type").removeClass('active_login_btn');
        $(this).addClass('active_login_btn');

        let btn_type = Number($(this).attr('data-id'));
        let login_title = $(this).text();
        $(".login_title").text(login_title);
        $("#active_login_button_hidden").val(btn_type);
        show_hide(btn_type);
    });
    let login_button_type = Number($("#login_button_type").val()); 
    if(login_button_type==3){
        $(".btn_pin_trigger").click();
    }

    toastr.options = {
        positionClass:'toast-bottom-right'
    };
     

    $('body').on('click', '.set_data', function (e) {
        e.preventDefault();
        let role_name = $(this).text();
        let email = $(this).attr("data-email");
        let password = $(this).attr("data-password");
        let pin = $(this).attr("data-pin");

        $("#email_address").val(email);
        $("#password").val(password);
        $("#login_pin").val(pin);
        let active_login_button_hidden =  Number($("#active_login_button_hidden").val());
        if(active_login_button_hidden==2){
            $(".submit_login").click();
        }
        toastr['warning']("Click the Login button to log in as "+role_name, '');
    });
});
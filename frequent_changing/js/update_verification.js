$(function () {
    "use strict";

    let status = $("#status_value").val();
    let base_url_custom_update = $("#base_url_custom_update").val();
    if(status==2){
        $(".response_text").show();
        $(".redirect_text").show();
        $(".form_div").hide();

        let timeInterval = 5;
        setInterval(function(){
            timeInterval--;
            if(timeInterval<1){

            }else{
                $(".counter").html(timeInterval);
            }
        }, 1000);

        setTimeout(function(){
            window.location.href=base_url_custom_update+"Update/index";
        }, 5000);

    }else if(status==1){
        $(".response_text").show();
        $(".redirect_text").hide();
    }else{
        $(".response_text").hide();
        $(".redirect_text").hide();
    }
});

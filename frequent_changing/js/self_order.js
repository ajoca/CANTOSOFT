$(function () {
    "use strict";

    function show_hide_div() {
        let sos_enable_self_order = $("#sos_enable_self_order").val();

        if(sos_enable_self_order=="Yes"){
            $(".show_hide_div").show();
        }else{
            $(".show_hide_div").hide();
        }

        let sos_enable_online_order_frontend_website = Number($("#sos_enable_online_order_frontend_website").val());

        if(sos_enable_online_order_frontend_website==1){
            $(".div_online_order").show();
        }else{
            $(".div_online_order").hide();
        }

    }
    $(document).on('change','#sos_enable_online_order_frontend_website',function(){
        show_hide_div();
    });

    $(document).on('change','#sos_enable_self_order',function(){
        show_hide_div();
    });

    show_hide_div();
});
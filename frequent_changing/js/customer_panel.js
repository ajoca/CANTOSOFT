$(function () {
    "use strict";

    /**
     * Full Screen
     */
    function toggleFullscreen(elem) {
        elem = elem || document.documentElement;
        if (
            !document.fullscreenElement &&
            !document.mozFullScreenElement &&
            !document.webkitFullscreenElement &&
            !document.msFullscreenElement
        ) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }
    }

    $(document).on("click", "#fullscreen", function (e) {
        toggleFullscreen();
    });

    function get_cart_data() {
        let base_url = $("#base_url").val();
        $.ajax({
            url: base_url + "customer-panel-data",
            method: "POST",
            dataType:'json',
            success: function (response) {
                if(response){
                    if(response.items_html){
                        $("#items").html(response.items_html);
                    }else{
                        $("#items").empty();
                    }
                    if(Number(response.total_item)){
                        $("#total_item").html(response.total_item);
                    }else{
                        $("#total_item").html("0");
                    }
                    if((Number(response.total_item_1))){
                        $("#total_item_1").html(response.total_item_1);
                    }else{
                        $("#total_item_1").html("0");
                    }

                    if((response.total_sub_total)){
                        $("#total_sub_total").html(response.total_sub_total);
                    }else{
                        $("#total_sub_total").html("0.00");
                    }
                    if((response.total_discount)){
                        $("#total_discount").html(response.total_discount);
                    }else{
                        $("#total_discount").html("0.00");
                    }
                    if((response.total_tax)){
                        $("#total_tax").html(response.total_tax);
                    }else{
                        $("#total_tax").html("0.00");
                    }
                    if((response.total_charge)){
                        $("#total_charge").html(response.total_charge);
                    }else{
                        $("#total_charge").html("0.00");
                    }
                    if((response.total_payable)){
                        $("#total_payable").html(response.total_payable);
                    }else{
                        $("#total_payable").html("0.00");
                    }
                    if((response.total_tips)){
                        $("#total_tips").html(response.total_tips);
                    }else{
                        $("#total_tips").html("0.00");
                    }

                }else{
                    $("#items").empty();
                    $("#total_item").html("0");
                    $("#total_item_1").html("0");
                    $("#total_sub_total").html("0.00");
                    $("#total_discount").html("0.00");
                    $("#total_tax").html("0.00");
                    $("#total_charge").html("0.00");
                    $("#total_payable").html("0.00");
                }
            }
        });
    }

    setInterval(function(){
        get_cart_data();
    }, 1000);

});



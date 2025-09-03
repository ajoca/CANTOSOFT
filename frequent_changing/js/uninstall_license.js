$(function () {
    "use strict";

    let status = $("#status_value").val();

    if(status==2){

    }else if(status==1){
        $(".response_text").show();
        $(".redirect_text").hide();
    }else{
        $(".response_text").hide();
        $(".redirect_text").hide();
    }

    function change_status() {
        let action_type = $("#action_type").val();
        if(action_type=="transfer"){
            $("#transfer_installation_url").attr("required","required");
            $(".div_hide_status").show();
        }else{
            $("#transfer_installation_url").removeAttr("required");
            $(".div_hide_status").hide();
        }
    }
    $(document).on('change', '#action_type', function() {
        change_status();
    });
    change_status();
});

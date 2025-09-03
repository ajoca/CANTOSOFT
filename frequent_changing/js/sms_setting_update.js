$(function () {
    "use strict";
    function setDiv() {
        let  sms_service_provider = $(".sms_service_provider").val();
        let  text_singup = $(".sms_service_provider").find(':selected').attr("data-text_singup");
        let  signup_url = $(".sms_service_provider").find(':selected').attr("data-signup_url");
        //hide all div on first time
        $(".div_hide").hide();
        $(".div_"+sms_service_provider).show(300);
        if(signup_url){
            $(".show_text").html(' (<a target="_blank" href="'+signup_url+'">'+text_singup+' '+signup_url+'</a>)');
        }else{
            $(".show_text").html('');
        }
    }
    setDiv();
    $(document).on('change', '.sms_service_provider', function(e)    {
        setDiv();
    });
});

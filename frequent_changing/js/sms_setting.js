$(function () {
    "use strict";
    function setDiv() {
        var enable_status = $("#enable_status").val();
        //hide all div on first time
        $(".div_hide").hide();
        $(".div_"+enable_status).show(300);
    }
    setDiv();
    $(document).on('change', '#enable_status', function(e)    {
        setDiv();
    });
});

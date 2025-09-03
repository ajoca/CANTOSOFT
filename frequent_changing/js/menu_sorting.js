
$(document).ready(function() {
    "use strict";
    let base_url = $("#base_url_").val();
    //counter class count like as 1,2,3,4
    function counter() {
        var i = 1;
        $(".counters").each(function(){
            $(this).html(i);
            i++;
        });
    }
});
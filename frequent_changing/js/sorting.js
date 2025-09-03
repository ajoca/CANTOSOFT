$(function () {
    "use strict";
    let base_url = $("#hidden_base_url").val();
    //generate serial number
    function counter() {
        let i = 1;
        $(".counters").each(function(){
            $(this).html(i);
            i++;
        });
    }
    //drag and sorting
    $('#sorting_payments').dragsort({
        cursor:'move',
        dragEnd: function() {
            counter();
            let data = $("form#sorting_form").serialize();
            $.ajax({
                url     : base_url+'Authentication/sortingPayment',
                method  : 'get',
                dataType: 'json',
                data    : data,
                success:function(data){

                }
            });
        }
    });
});
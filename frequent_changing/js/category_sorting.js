$(document).ready(function() {
    "use strict";
    let base_url_ = $("#base_url_").val();

    //counter class count like as 1,2,3,4
    function counter() {
        let i = 1;
        $(".counters").each(function(){
            $(this).html(i);
            i++;
        });
    }
    //call dragsort function
    $('#sortCate').dragsort({
        cursor:'move',
        dragEnd: function() {
            counter();
            let data = $("form#sorting_form").serialize();
            $.ajax({
                url     : base_url_+'Authentication/sortingCategory',
                method  : 'get',
                dataType: 'json',
                data    : data,
                success:function(data){

                }
            });

        },
    });
});
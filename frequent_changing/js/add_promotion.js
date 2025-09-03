$(function() {
    "use strict";
    function change_div() {
        let type = Number($(".type").val());
        $(".discount_div").hide();
        $(".free_item_div").hide();

        if(type==1){
            $(".discount_div").show();
        }else if (type==2){
            $(".free_item_div").show();
        }
    }
    $(document).on('change', '.type', function () {
        change_div();
    });
    change_div();
});


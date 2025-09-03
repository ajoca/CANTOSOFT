$(function() {
    "use strict";
    function cal_opening_balance(){
        let total_amount = 0;
        $(".cal_row").each(function() {
            let this_value = Number($(this).val());
            total_amount+=this_value;
        });

        let ir_precision = $("#ir_precision").val();

        $(".opening_balance_hidden").val(total_amount);
        $(".total_opening_balance").html(total_amount.toFixed(ir_precision));
    }

    $(document).on('keyup', '.cal_row', function() {
        cal_opening_balance();
    });
    $(document).on('click', '.cal_row', function() {
        let value = Number($(this).val());
        if(value===0){
            $(this).val('');
        }
    });

    $(window).click(function() {
        $(".cal_row").each(function() {
            let this_value = Number($(this).val());
            if(this_value=='' && !$(this).is(":focus")){
                $(this).val(0);
            }
        });

    });

      // JavaScript to handle tab switching
      document.querySelectorAll('.ds-tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');

            // Remove active class from all buttons and content
            document.querySelectorAll('.ds-tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.ds-tab-content').forEach(content => content.classList.remove('active'));

            // Add active class to the clicked button and corresponding content
            button.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
});
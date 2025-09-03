$(function () {
    "use strict";
    $(document).on('change', '#plan_id', function(){
        pricingPlanDiv();
    });
    $(document).on('change', '#payment_type', function(){
        let payment_type = $(this).val();
        let html = '';
        if(payment_type == 1 || payment_type == ''){
            html = `<option value="">Select</option>
                <option value="1">Paypal</option>
                <option value="2">Stripe</option>
                <option value="3">Razorpay</option>`;
        } else if(payment_type == 2) {
            html = `<option value="">Select</option>
                <option value="1">Paypal</option>`
        } 
        $('#payment_method').html(html);
    });

    function pricingPlanDiv(){
        let trialCheck = $('option:selected', '#plan_id').attr('data-pricing_plan');
        if(trialCheck == '' || trialCheck == '111'){
            $('.pricing_plan_div').hide();
        } else {
            $('.pricing_plan_div').show();
        }
    }
    pricingPlanDiv();



    $(document).on('submit', '#singup_form', function () {
        let error = false;
        let payment_type = $('#payment_type').val();
        let payment_mothod = $('#payment_mothod').val();
        let plan_id = $('#plan_id').val();
        let trialCheck = $('option:selected', '#plan_id').attr('data-pricing_plan');
        if(plan_id != '' && trialCheck != '111'){
            if (payment_type == "") {
                let msg =  `<div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg> 
                    <span class="ps-2">
                        The Payment Type field is requied
                    </span>
                </div>`;
                $(".payment_type_err_msg").html(msg);
                $(".payment_type_err_msg_contnr").show(200);
                error = true;
            }
            if (payment_mothod == "") {
                let msg =  `<div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg> 
                    <span class="ps-2">
                        The Payment Method field is requied
                    </span>
                </div>`;
                $(".payment_method_err_msg").html(msg);
                $(".payment_method_err_msg_contnr").show(200);
                error = true;
            }

            
            if(payment_mothod == 'Paypal' || payment_mothod == 'Stripe'){
                let holder_name = $('#holder_name').val();
                let credit_card_no = $('#credit_card_no').val();
                let payment_month = $('#payment_month').val();
                let payment_year = $('#payment_year').val();
                let payment_cvc = $('#payment_cvc').val();

                if (holder_name == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Holder Name field is requied
                        </span>
                    </div>`;
                    $(".holder_name_err_msg").html(msg);
                    $(".holder_name_err_msg_contnr").show(200);
                    error = true;
                }
                if (credit_card_no == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Credit Card No field is requied
                        </span>
                    </div>`;
                    $(".credit_card_no_err_msg").html(msg);
                    $(".credit_card_no_err_msg_contnr").show(200);
                    error = true;
                }
                if (payment_month == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment Month field is requied
                        </span>
                    </div>`;
                    $(".payment_month_err_msg").html(msg);
                    $(".payment_month_err_msg_contnr").show(200);
                    error = true;
                }
                if (payment_year == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment Year field is requied
                        </span>
                    </div>`;
                    $(".payment_year_err_msg").html(msg);
                    $(".payment_year_err_msg_contnr").show(200);
                    error = true;
                }
                if (payment_cvc == "") {
                    let msg =  `<div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg> 
                        <span class="ps-2">
                            The Payment CVC field is requied
                        </span>
                    </div>`;
                    $(".payment_cvc_err_msg").html(msg);
                    $(".payment_cvc_err_msg_contnr").show(200);
                    error = true;
                }
            }


            if (error == true) {
                return false;
            }
        }
    });



    $(document).ready(function() {
        $('input[name="payment_method_type"]').on('change', function() {
            const selectedMethod = $('input[name="payment_method_type"]:checked').attr('id');
            $('#payment_type').val(selectedMethod);
        });
    });


});
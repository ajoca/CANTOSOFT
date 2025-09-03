$(document).ready(function() {
    "use strict";
    if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
        $("#checkbox_userAll").prop("checked", true);
    } else {
        $("#checkbox_userAll").removeAttr("checked");
    }
    // Check or Uncheck All checkboxes\
    $(document).on('change', '#checkbox_userAll', function() {
        $('.user_radio').each(function(i, obj) {
            if ($(this).is(':checked')) {
                $('#checkbox_userAll').prop('checked', false);
                $('.checkbox_user').prop('checked', false);
                return false;
            }
        });
        let checked = $(this).is(':checked');
        if (checked) {
            $(".checkbox_user").each(function() {
                $(this).prop("checked", true);
            });
        } else {
            $(".checkbox_user").each(function() {
                $(this).prop("checked", false);
            });
        }
    });

    $(document).on('click', '.checkbox_user', function() {
        $('.user_radio').each(function(i, obj) {
            if ($(this).is(':checked')) {
                $('#checkbox_userAll').prop('checked', false);
                $('.checkbox_user').prop('checked', false);

                return false;
            }
        });
        if ($(".checkbox_user").length == $(".checkbox_user:checked").length) {
            $("#checkbox_userAll").prop("checked", true);
        } else {
            $("#checkbox_userAll").prop("checked", false);
        }
    });
    $(document).on('click', '.user_radio', function() {
        $('#checkbox_userAll').prop('checked', false);
        $('.checkbox_user').prop('checked', false);
    });
    function checkDataDiv() {
        let value  = $('input[name=will_login]:checked').val();
        if(value=="Yes"){
            $('#will_login_section').fadeIn();
        }else{
            $('#will_login_section').fadeOut();
        }
    }
    checkDataDiv();
    $(document).on('click', '#will_login_yes', function() {
        $('#will_login_section').fadeIn();
    });
    $(document).on('click', '#will_login_no', function() {
        $('#will_login_section').fadeOut();
    });
    function getRandomCode(length) {
        let result           = '';
        //this is random character pattern
        let characters       = '0123456789';
        let charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    //generate random code button
    $('body').on('click', '.generate_now', function (e) {
        //call 4 characters random code function
        let code = getRandomCode(4);
        $("#login_pin").val(code);
    });
    //generate random code button
    $('body').on('keyup', '#login_pin', function (e) {
            let value_length = $(this).val().length;
            let value = $(this).val();
            if(value_length>=4){
                $("#login_pin").val(value.substring(0, 4));
            }
    });
});
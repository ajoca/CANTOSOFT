$(function() {
    "use strict";
    function sidebarDesgin(){
        let loggle_status = $('.sidebar-toggle').attr('data-status');
        if(loggle_status == '1'){
            $('.menu-header.small').css('padding-top', '0px');

            $('.menu-header.small span').css('display', 'none');
            $('.menu-header.small svg').css('display', 'block');
        }else{
            $('.menu-header.small').css('padding-top', '15px');

            $('.menu-header.small span').css('display', 'block');
            $('.menu-header.small svg').css('display', 'none');
        }
    }
    sidebarDesgin();
    $(document).on('click', '.sidebar-toggle', function(){
        sidebarDesgin();
    });
    $(document).on('mouseenter', '.main-sidebar', function() {
        let loggle_status = $('.sidebar-toggle').attr('data-status');
        if(loggle_status == '1'){
            $('.menu-header.small').css('padding-top', '15px');

            $('.menu-header.small span').css('display', 'block');
            $('.menu-header.small svg').css('display', 'none');
            
        }
    });
    $(document).on('mouseleave', '.main-sidebar', function() {
        let loggle_status = $('.sidebar-toggle').attr('data-status');
        if(loggle_status == '1'){
            $('.menu-header.small').css('padding-top', '0px');

            $('.menu-header.small span').css('display', 'none');
            $('.menu-header.small svg').css('display', 'block');
        }
    });
    

    // Common Use
    let common_use = $('.common_use').length;
    if(common_use == '1'){
        $('.common_use').css('display', 'none');
    }else{
        $('.common_use').css('display', 'block');
    }
    // Item Stock
    let item_stock = $('.item_stock').length;
    if(item_stock == '1'){
        $('.item_stock').css('display', 'none');
    }else{
        $('.item_stock').css('display', 'block');
    }
    // Sale Customer
    let sale_customer = $('.sale_customer').length;
    if(sale_customer == '1'){
        $('.sale_customer').css('display', 'none');
    }else{
        $('.sale_customer').css('display', 'block');
    }
    // Purchase Expens
    let purchase_expense = $('.purchase_expense').length;
    if(purchase_expense == '1'){
        $('.purchase_expense').css('display', 'none');
    }else{
        $('.purchase_expense').css('display', 'block');
    }
    // Transfer Damage
    let transfer_damage = $('.transfer_damage').length;
    if(transfer_damage == '1'){
        $('.transfer_damage').css('display', 'none');
    }else{
        $('.transfer_damage').css('display', 'block');
    }

    // Attendance
    let account_attendance = $('.account_attendance').length;
    if(account_attendance == '1'){
        $('.account_attendance').css('display', 'none');
    }else{
        $('.account_attendance').css('display', 'block');
    }
    
    // Setting
    let setting_report = $('.setting_report1').length;
    if(setting_report == '1'){
        $('.setting_report1').css('display', 'none');
    }else{
        $('.setting_report1').css('display', 'block');
    }
    

    $(document).on('click', '.grid_view2 .btn-dblue1', function(){
        $('.btn-dblue1').removeClass('active');
        $(this).addClass('active');
    })


    $('.food_menu_slider').slick({
        dots: false,
        arrows: true,
        infinite: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
        speed: 300,
        slidesToShow: 7,
        slidesToScroll: 8,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 6,
                    arrows: true,
                }
            },
            {
                breakpoint: 1366,
                settings: {
                    slidesToShow: 4,
                    arrows: true,
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    arrows: true,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });

});
(function ($) {
  "use strict";

  let base_url = $("#base_url").val();

  /*-------------------------------------------------------------------------------
  Preloader
	-------------------------------------------------------------------------------*/
  $(window).on("load", function () {
    $(".ct-preloader").addClass("hidden");
  });

  /*-------------------------------------------------------------------------------
  Aside Menu
	-------------------------------------------------------------------------------*/
  $(".aside-trigger").on("click", function () {
    $(".main-aside").toggleClass("open");
  });
  $(".main-aside .menu-item-has-children > a").on("click", function (e) {
    var submenu = $(this).next(".submenu");
    e.preventDefault();

    submenu.slideToggle(200);
  });

  /*-------------------------------------------------------------------------------
  Cart Trigger
  -------------------------------------------------------------------------------*/
  $(".cart-trigger").on("click", function (e) {
    $("body").toggleClass("cart-open");
  });

  /*-------------------------------------------------------------------------------
  Search Trigger
  -------------------------------------------------------------------------------*/
  $(".search-trigger").on("click", function (e) {
    $(".search-form-wrapper").toggleClass("open");
  });

  /*-------------------------------------------------------------------------------
  Checkout Notices
  -------------------------------------------------------------------------------*/
  $(".ct-notice a").on("click", function (e) {
    e.preventDefault();

    $(this).closest(".ct-notice").next().slideToggle();
  });

  /*-------------------------------------------------------------------------------
  Isotope (Menu Categories)
  -------------------------------------------------------------------------------*/
  var $container = $(".menu-container");
  $container.isotope({
    filter: "*",
    animationOptions: {
      duration: 750,
      easing: "linear",
      queue: false,
    },
  });
  $(".menu-filter a").on("click", function () {
    $(".menu-filter .active").removeClass("active");
    $(this).addClass("active");

    var selector = $(this).attr("data-filter");
    $container.isotope({
      filter: selector,
      animationOptions: {
        duration: 750,
        easing: "linear",
        queue: false,
      },
    });
    return false;
  });

  /*-------------------------------------------------------------------------------
  Sticky Header
	-------------------------------------------------------------------------------*/
  function doSticky() {
    var header = $(".can-sticky");

    if (window.pageYOffset > 50) {
      header.addClass("sticky");
    } else {
      header.removeClass("sticky");
    }
  }
  doSticky();

  /*-----------------------------------
    Back to Top
    -----------------------------------*/
  $(".back-to-top").on("click", function () {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      600
    );
    return false;
  });

  /*-------------------------------------------------------------------------------
  Aside Scroll
	-------------------------------------------------------------------------------*/
  function initAsideScrollbar() {
    var scrollHeight =
      $(".main-aside").innerHeight() -
      $(".main-aside .navbar-brand").innerHeight(); // Calculate the height of the scroll container
    var calculatedHeight = isNaN(scrollHeight) ? "auto" : scrollHeight;
    $(".aside-scroll").slimScroll({
      height: calculatedHeight,
      position: "right",
      size: "5px",
      color: "#dcdcdc",
      opacity: 1,
      wheelStep: 5,
      touchScrollStep: 50,
    });
  }
  initAsideScrollbar();

  /*-------------------------------------------------------------------------------
  Cart Scroll
  -------------------------------------------------------------------------------*/
  function initCartScrollbar() {
    var scrollHeight =
      $(".cart-sidebar").innerHeight() -
      $(".cart-sidebar .cart-sidebar-header").innerHeight() -
      $(".cart-sidebar .cart-sidebar-footer").innerHeight() -
      40; // Calculate the height of the scroll container
    var calculatedHeight = isNaN(scrollHeight) ? "auto" : scrollHeight;
    $(".cart-sidebar-scroll").slimScroll({
      height: calculatedHeight,
      position: "right",
      size: "5px",
      alwaysVisible: true,
      color: "#4e4e4e",
      railVisible: true,
      railColor: "#212222",
      opacity: 1,
      wheelStep: 5,
      touchScrollStep: 50,
    });
  }
  initCartScrollbar();

  /*-------------------------------------------------------------------------------
  Tooltips
  -------------------------------------------------------------------------------*/
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  /*-------------------------------------------------------------------------------
  Magnific Popup
  -------------------------------------------------------------------------------*/
  $(".popup-youtube").magnificPopup({
    type: "iframe",
  });
  $(".popup-vimeo").magnificPopup({
    type: "iframe",
  });
  $(".popup-video").magnificPopup({
    type: "iframe",
  });
  $(".gallery-thumb").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  /*-------------------------------------------------------------------------------
  Banner Slider (Home 1)
  -------------------------------------------------------------------------------*/
  $(".banner-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: false,
    asNavFor: ".banner-slider-nav-inner",
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Banner Slider Nav (Home 1)
  -------------------------------------------------------------------------------*/
  $(".banner-slider-nav-inner").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: $(".banner-slider-nav .slider-prev"),
    nextArrow: $(".banner-slider-nav .slider-next"),
    asNavFor: ".banner-slider",
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
          autoplay: true,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Gallery Slider (Home 3)
  -------------------------------------------------------------------------------*/
  $(".gallery-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 2000,
    dots: false,
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Banner Slider (Home 2)
  -------------------------------------------------------------------------------*/
  $(".banner-slider-2").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          dots: false,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Category Slider (Home 2)
  -------------------------------------------------------------------------------*/
  $(".category-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: $(".category-section .slider-prev"),
    nextArrow: $(".category-section .slider-next"),
    responsive: [
      {
        breakpoint: 768,
        settings: {
          dots: false,
          autoplay: true,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Banner Slider (Home 3)
  -------------------------------------------------------------------------------*/
  $(".banner-slider-3").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    centerMode: true,
    prevArrow: $(".banner-3 .slider-prev"),
    nextArrow: $(".banner-3 .slider-next"),
    centerPadding: "80px",
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 1400,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 991,
        settings: {
          variableWidth: false,
          centerPadding: "0px",
          centerMode: false,
          arrows: false,
          autoplay: true,
          slidesToShow: 1,
        },
      },
    ],
  });
  $(".banner-slider-3").on(
    "afterChange",
    function (event, slick, currentSlide, nextSlide) {
      $(".banner-3 .current-slide span").text(currentSlide + 1);
    }
  );

  /*-------------------------------------------------------------------------------
  Related Posts slider
  -------------------------------------------------------------------------------*/
  $(".related").slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: false,
    dots: true,
    responsive: [
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Testimonials Slider (Home 1)
  -------------------------------------------------------------------------------*/
  $(".ct-testimonials-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    prevArrow: $(".testimonials .slider-prev"),
    nextArrow: $(".testimonials .slider-next"),
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Products Slider (Home 1)
  -------------------------------------------------------------------------------*/
  $(".product-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: $(".products-section .slider-prev"),
    nextArrow: $(".products-section .slider-next"),
    dots: false,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  /*-------------------------------------------------------------------------------
  Menu Category Slider
  -------------------------------------------------------------------------------*/
  $(".menu-category-slider").slick({
    slidesToShow: 8,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    draggable: false,
    variableWidth: true,
    nextArrow: ".customNextBtn",
    prevArrow: ".customPrevBtn",
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 6,
        },
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 4,
        },
      },
      {
        breakpoint: 575,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 400,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  });

  $(".menu-category-slider").on("swipe", function (event, slick, currentSlide) {
    let product_id = $(document).find(`.slick-active`).attr("data-filter");
    console.log(product_id);
    $container.isotope({
      filter: product_id,
      animationOptions: {
        duration: 750,
        easing: "linear",
        queue: false,
      },
    });
    return false;
  });

  $(".menu-category-slider").on(
    "afterChange",
    function (event, slick, currentSlide) {
      let product_id = $(document).find(`.slick-active`).attr("data-filter");
      $container.isotope({
        filter: product_id,
        animationOptions: {
          duration: 750,
          easing: "linear",
          queue: false,
        },
      });
      return false;
    }
  );

  /*-------------------------------------------------------------------------------
  Masonry
  -------------------------------------------------------------------------------*/
  $(".masonry").imagesLoaded(function () {
    var isotopeContainer = $(".masonry");
    isotopeContainer.isotope({
      itemSelector: ".masonry-item",
    });
  });

  /*-------------------------------------------------------------------------------
  Add / Subtract Quantity
  -------------------------------------------------------------------------------*/
  $(".qty span").on("click", function () {
    var qty = $(this).closest(".qty").find("input");
    var qtyVal = parseInt(qty.val());
    if ($(this).hasClass("qty-add")) {
      qty.val(qtyVal + 1);
    } else {
      return qtyVal > 1 ? qty.val(qtyVal - 1) : 0;
    }
  });

  //On scroll events
  $(window).on("scroll", function () {
    doSticky();
  });

  //On resize events
  $(window).on("resize", function () {
    initAsideScrollbar();
    initCartScrollbar();
  });

  $("#blog_carousel").owlCarousel({
    loop: true,
    margin: 15,
    responsive: {
      0: {
        // For smaller screens
        items: 1,
      },
      768: {
        // For medium screens
        items: 2,
      },
      1200: {
        // For screens between 1200px and 1400px
        items: 3,
      },
      1400: {
        // For larger screens
        items: 4,
      },
    },
  });

  var owl = $(".owl-carousel");
  $(".customNextBtn").click(function () {
    owl.trigger("next.owl.carousel");
  });
  $(".customPrevBtn").click(function () {
    owl.trigger("prev.owl.carousel");
  });

  /*-------------------------------------------------------------------------------
  Color Picker Toggle
  -------------------------------------------------------------------------------*/
  $(".color-picker-toggle").hover(
    function () {
      $(".color-picker-content").addClass("active");
    },
    function () {}
  );

  $(document).on("click", function (event) {
    if (
      !$(event.target).closest(".color-picker-content, .color-picker-toggle")
        .length
    ) {
      $(".color-picker-content").removeClass("active");
    }
  });

  // Check if a color is saved in localStorage
  const savedColor = $("#website_theme_color").val();

  // If a color is saved, apply it to the root variable and highlight the corresponding <li>
  if (savedColor) {
    $(":root").css("--primary-color", savedColor);
    $(".color-list li").removeClass("active");
    $(`.color-list li[data-color="${savedColor}"]`).addClass("active");
  }

  $(document).ready(function () {
    // Add click event listener to all color list items
    $(".color-list li").on("click", function () {
      // Get the clicked color value from the data-color attribute
      const color = $(this).attr("data-color");

      // Update the CSS root variable --primary-color
      $(":root").css("--primary-color", color);
      // Save the selected color to localStorage
      localStorage.setItem("selectedColor", color);
      // Optional: Add/remove the "active" class to highlight the selected color
      $(".color-list li").removeClass("active"); // Remove active class from all
      $(this).addClass("active"); // Add active class to the clicked item
      $(".color-picker-content").removeClass("active");
    });
  });

  // Rating
  $(".rating span").on("click", function () {
    let rating = $(this).data("rating");
    let selectedId = $(this).closest(".rating").attr("id");
    $(`.rating .${selectedId}`).each(function () {
      if ($(this).data("rating") <= rating) {
        $(this).html('<i class="fas fa-star"></i>');
      } else {
        $(this).html('<i class="far fa-star"></i>');
      }
    });
    let id = selectedId.match(/\d+/);
    id = id[0];
    console.log(id, rating);
    $.ajax({
      url: base_url + "Frontend/ratingSubmit",
      type: "POST",
      data: {
        rating: rating,
        id: id,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          $(`#success_rating_${id}`).removeClass("d-none");
          setTimeout(function () {
            $(`#success_rating_${id}`).addClass("d-none");
          }, 3000);
        }
      },
    });
  });

  $(document).on("submit", "#reservations", function () {
    let outlet = $("#outlet_id").val();
    let first_name = $("#first_name").val();
    let last_name = $("#last_name").val();
    let phone = $("#phone").val();
    let no_of_people = $("#no_of_people").val();
    let date = $("#date").val();
    let time = $("#time").val();
    let notes = $("#notes").val();

    if (
      outlet == "" ||
      first_name == "" ||
      last_name == "" ||
      phone == "" ||
      no_of_people == "" ||
      date == "" ||
      time == ""
    ) {
      $("#errorMsgShow").removeClass("d-none");
      $("#errorMsgShow").html(
        "All fields are required. Please fill all fields."
      );
      return false;
    } else {
      return true;
    }
  });



  // Outlet hero select
  let heroSelect = document.getElementById("heroSelect");

  if (heroSelect) {
    NiceSelect.bind(heroSelect, {
      searchable: false,
    });
  }

    // Outlet Select Modal Show
    $(document).ready(function () {
      $("#outletSelectModal").modal({
        backdrop: "static",
        keyboard: false,
      }); 

      let online_selected_outlet = Number($("#online_selected_outlet").val());
      if(online_selected_outlet){
        $("#outletSelectModal").modal("hide");
      }else{
        $("#outletSelectModal").modal("show");
      }
    });

})(jQuery);

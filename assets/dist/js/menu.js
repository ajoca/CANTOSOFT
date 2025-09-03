$(document).ready(function () {
  $(".right__sidebar__toggle").on("click", function () {
    $(".main-header").toggleClass("active_sidebar");
    $(".main-sidebar2").toggleClass("active_sidebar");
    $(".sidebar2_logo").find(".logo__mini").toggle(0);
    $(".sidebar2_logo").find(".logo__lg").toggle(0);
  });

  const thisForArabic = () => {
    if ($(".content-header").hasClass("dashboard_content_header")) {
      console.log("find it");
    } else {
      $(".content-header").addClass("lang_arabic");
    }
  };
 /*  thisForArabic();*/


  function setActiveCurrentURL(){
    // Get the current URL
    let currentUrl = window.location.href;
    // Find the active_sub_menu when the current location matches the link
    $('.treeview').has('a[href="' + currentUrl + '"]').addClass('active_sub_menu');
    $('.treeview2').has('a[href="' + currentUrl + '"]').addClass('active_sub_menu');
    $('.treeview').has('a[href="' + currentUrl + '"]').addClass('menu-open');
    $('.treeview2').has('a[href="' + currentUrl + '"]').addClass('menu-open');
    $('.treeview').has('a[href="' + currentUrl + '"]').find('a[href="' + currentUrl + '"]').parent().addClass('treeMenuActive');
    $('.treeview2').has('a[href="' + currentUrl + '"]').find('a[href="' + currentUrl + '"]').parent().addClass('treeMenuActive');
  }
  setActiveCurrentURL();

  $(document).ready(function(){
    $(".menu-open").click(function(e){
      // Toggle the visibility of the inner UL with animation
      $(this).children(".treeview-menu").slideToggle();
    });
  });

  let activeSubMenu = $(".menu-open");
  if (activeSubMenu.length) {
    let scrollPosition = activeSubMenu.position().top - 100;
    $(".sidebar-menu").scrollTop(scrollPosition);
  }


  $(document).on('click', '.biponi_silver', function(e){
    e.preventDefault();
    toastr['error'](('Available for Gold, Pharmacy and Enterprise  packages.'), '');
  });

});

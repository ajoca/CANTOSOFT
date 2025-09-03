$(function() {
   
      $(document).on('click', '.class_category', function() {
           let this_id = $(this).attr("data-id");
  
           let name = $(this).attr("data-name");
           let total_item = $(this).find("span").text();
           $(".item_header").text(name);
           $(".item_header_counter").text(total_item);
  
           $(".class_category").removeClass("active1");
           $(this).addClass("active1");
           if(this_id=="all"){
              $(".menu-item-custom").show(200);
           }else{
              $(".menu-item-custom").hide();
              $(".cat_"+this_id).show(200);
           }
      });

      $(document).on('click', '.call_details', function(e) {
         e.preventDefault();
            $("#product_details").modal('show');
           let this_id = $(this).attr("data-id");
            $.ajax({
               url: base_url + "authentication/getFoodDetails",
               method: "POST",
               data:{food_menu_id:this_id},
               success: function (response) {
                     $(".show_html_content").html(response);
               },
               error: function () {

               },
           });
      });


      $(document).on('mouseenter', '.menu-item-custom', function() {
         $(this).find('.action-overlay')
             .stop(true, true)
             .css({ display: 'block', opacity: 0 })
             .animate({ opacity: 1, marginTop: "0px" }, 400);
      });


      $(document).on('mouseleave', '.menu-item-custom', function() {
            $(this).find('.action-overlay')
               .stop(true, true)
               .animate({ opacity: 0, marginTop: "10px" }, 400, function() {
                  $(this).css('display', 'none'); // Hide after animation
            });
      });
  
     
      $("#search_string").on("keyup", function () {
         let value = $(this).val().toLowerCase();

         $(".food_title").each(function () {
             let title = $(this).text().toLowerCase();
             let category = $(this).parent().find('.food_title_category').text().toLowerCase();
             $(this).parent().parent().toggle(title.includes(value) || category.includes(value));
         });
      });
     
  });
$(function() {
      "use strict";
      $(document).on('click', '#existing_db', function(){
            if ($('#existing_db').is(':checked')) {
                  $(".existing_notice").show();
                } else {
                  $(".existing_notice").hide();
                }
      });
      
  });
  
  
  
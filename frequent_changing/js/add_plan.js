$(function () {
      "use strict";
      function changeStatus(){
            let free_trial_status = $('#free_trial_status').find(":selected").val();
            if(free_trial_status=="Yes"){
                  $(".is_trail").show();
            }else{
                  $(".is_trail").hide();
            }
      }
      $(document).on('change', '#free_trial_status', function(){
         changeStatus();
      });
      changeStatus();
  });
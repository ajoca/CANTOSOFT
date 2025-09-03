$(function () {
      "use strict";
      let img_select_error_msg  = $("#img_select_error_msg").val();
      let hidden_alert  = $("#warning").val(); 
      let hidden_ok  = $("#ok").val();
      let hidden_cancel  = $("#cancel").val();
      let are_you_sure  = $("#are_you_sure").val();
      let base_url_custom  = $("#base_url_custom").val();
      let hidden_outlet_id  = $("#hidden_outlet_id").val();
    $(document).on('click', '.img_thumb_btn', function(e){
        let id = $(this).attr("data-id");
        $("#active_id_for_upload").val(id);
        $("#thumb_modal").modal('show');
    });

    $(document).on('click', '.img_large_btn', function(e){
        let id = $(this).attr("data-id");
        $("#active_id_for_upload").val(id);
        $("#large_modal").modal('show');
    });

    $(document).on('change', '#outlet_id', function(e){
        let id = $(this).val(); 
        let url = base_url_custom+"Frontend/availableOnlineFoods/"+id;
        window.location.href = url;
    });

    $(document).on('click', '.cancel', function(e){
        $("#thumb_modal").modal('hide');
        $("#large_modal").modal('hide');
    });
    function callUpdateInfo(checked_value,food_menu_id,thumb_image,large_image){
        $.ajax({
            url: base_url_custom+"Authentication/callUpdateInfo",
            type: "POST",
            dataType: 'json',
            data: {checked_value:checked_value,food_menu_id:food_menu_id,thumb_image:thumb_image,large_image:large_image,hidden_outlet_id:hidden_outlet_id},
            success: function (data) {
             
            }
        });
    }

    // New batch update function for better performance
    function callBatchUpdateInfo(updates_data){
        // Show loading indicator
        if(updates_data.length > 100) {
            $("#loading_indicator").show();
        }
        
        // If data is too large, chunk it into smaller batches
        const CHUNK_SIZE = 500; // Process 500 items at a time
        const chunks = [];
        
        for(let i = 0; i < updates_data.length; i += CHUNK_SIZE) {
            chunks.push(updates_data.slice(i, i + CHUNK_SIZE));
        }
        
        let completedChunks = 0;
        const totalChunks = chunks.length;
        
        // Process chunks sequentially to avoid overwhelming the server
        function processChunk(index) {
            if(index >= chunks.length) {
                // All chunks processed
                $("#loading_indicator").hide();
                return;
            }
            
            $.ajax({
                url: base_url_custom+"Authentication/callBatchUpdateInfo",
                type: "POST",
                dataType: 'json',
                data: {updates: chunks[index], hidden_outlet_id: hidden_outlet_id},
                success: function (data) {
                    completedChunks++;
                    if(data.success) {
                        console.log(`Chunk ${completedChunks}/${totalChunks} completed successfully`);
                        // Update progress if needed
                        if(totalChunks > 1) {
                            const progress = Math.round((completedChunks / totalChunks) * 100);
                            $("#progress_bar").css('width', progress + '%');
                        }
                    } else {
                        console.error(`Chunk ${completedChunks}/${totalChunks} failed:`, data.message);
                    }
                    
                    // Process next chunk
                    processChunk(index + 1);
                },
                error: function(xhr, status, error) {
                    completedChunks++;
                    console.error(`Chunk ${completedChunks}/${totalChunks} error:`, error);
                    // Continue with next chunk even if this one failed
                    processChunk(index + 1);
                }
            });
        }
        
        // Start processing chunks
        processChunk(0);
    }

    $(document).on('click', '.remvoe_thumb_image', function(e){
         let this_id = $(this).attr("data-id");
         let this_action = $(this);
         $("#active_id_for_upload").val(this_id);
         let image = $(this).attr("data-image");
        swal({
            title: hidden_alert+"!",
            text: are_you_sure+"?",
            cancelButtonText: hidden_cancel,
            confirmButtonText: hidden_ok,
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function() {
            $("#img_thumb_value_"+this_id).val('');
            $("#img_thumb_"+this_id).attr("src", image);

            let checked_value =  $("#checker_"+this_id).is(":checked") ? 1 : 2;;
            let food_menu_id = this_id;
            let thumb_image = $("#img_thumb_value_"+this_id).val();
            let large_image = $("#img_large_value_"+this_id).val();


            callUpdateInfo(checked_value,food_menu_id,thumb_image,large_image);
            this_action.parent().empty();
        });

        
    });

    // Debounce function to limit rapid AJAX calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Debounced version of individual checkbox updates
    const debouncedUpdate = debounce(function(checked_value, food_menu_id, thumb_image, large_image) {
        callUpdateInfo(checked_value, food_menu_id, thumb_image, large_image);
    }, 300); // Wait 300ms after last change

    $(".checkbox_user").on("change", function(){
        // Only process if the checkbox is visible (not filtered by search)
        if ($(this).is(':visible')) {
            let checked_value =  $(this).is(":checked") ? 1 : 2;; 
            let this_id =$(this).val();

            let food_menu_id =  this_id;
            let thumb_image = $("#img_thumb_value_"+this_id).val();
            let large_image = $("#img_large_value_"+this_id).val(); 
            
            // Use debounced update instead of immediate call
            debouncedUpdate(checked_value, food_menu_id, thumb_image, large_image);
        }
    });

    $(document).on('click', '.remvoe_large_image_action', function(e){
         let this_id = $(this).attr("data-id");
         let this_action = $(this);
         swal({
            title: hidden_alert+"!",
            text: are_you_sure+"?",
            cancelButtonText: hidden_cancel,
            confirmButtonText: hidden_ok,
            confirmButtonColor: '#3c8dbc',
            showCancelButton: true
        }, function() {
                $("#active_id_for_upload").val(this_id);
                $("#img_large_value_"+this_id).val('');
                let checked_value =  $("#checker_"+this_id).is(":checked") ? 1 : 2;;
                let food_menu_id = this_id;
                let thumb_image = $("#img_thumb_value_"+this_id).val();
                let large_image = $("#img_large_value_"+this_id).val(); 
                callUpdateInfo(checked_value,food_menu_id,thumb_image,large_image);
                this_action.parent().empty();
        });


    });

    $(document).on("click", ".show_large_img", function (e) {
        e.preventDefault();
        let file_path = base_url_custom+"uploads/website/"+$(this).attr("data-url");  

        $("#show_id").attr("src", file_path);
        $("#show_id").css("width", "unset");
        $("#large_modal_preview").modal("show");
      });



      let height_ = 304;
      let width_ = 296;
  
      let tmp_height_ = 304+50;
      let tmp_width_ = 296+50;
   
      let uploadCrop = $('#thumb_modal_div').croppie({
          enableExif: true,
          viewport: {
              width: width_,
              height: height_,
              type: 'square'
          },
          boundary: {
              width: tmp_width_,
              height: tmp_height_
          }
      });
      $(document).on('change', '#img_thumb_file', function (e) {
          let reader = new FileReader();
          reader.onload = function (e) {
              uploadCrop.croppie('bind', {
                  url: e.target.result
              }).then(function(){
                 
              });
  
          }
          reader.readAsDataURL(this.files[0]);
      });
      $(document).on('click', '.del_img', function (e) {
          let this_action = $(this);
          swal({
              title: hidden_alert+"!",
              text: are_you_sure+"?",
              cancelButtonText:hidden_cancel,
              confirmButtonText:hidden_ok,
              confirmButtonColor: '#3c8dbc',
              showCancelButton: true
          }, function() {
              this_action.parent().parent().parent().remove();
          });
  
      });
      $(document).on('click', '.del_img_details', function (e) {
          let this_action = $(this);
          swal({
              title: hidden_alert+"!",
              text: are_you_sure+"?",
              cancelButtonText:hidden_cancel,
              confirmButtonText:hidden_ok,
              confirmButtonColor: '#3c8dbc',
              showCancelButton: true
          }, function() {
              this_action.parent().parent().remove();
          });
  
      });
      
      $(document).on('click', '.upload-result', function (ev) {
        let active_id_for_upload = $("#active_id_for_upload").val();
        let another_image = $("#img_large_value_"+active_id_for_upload).val();
        let checked_value =  $("#checker_"+active_id_for_upload).is(":checked") ? 1 : 2;
          uploadCrop.croppie('result', {
              type: 'canvas',
              size: 'viewport'
          }).then(function (resp) {
              let selected_image =  $("#img_thumb_file").val();
              if(selected_image==''){
                  swal({
                      title: hidden_alert+"!",
                      text: img_select_error_msg,
                      confirmButtonText:hidden_ok,
                      confirmButtonColor: '#3c8dbc'
                  });
                  return false;
              }else{
                  $.ajax({
                      url: base_url_custom+"Authentication/saveItemImage",
                      type: "POST",
                      dataType: 'json',
                      data: {"image":resp,food_menu_id:active_id_for_upload,hidden_outlet_id:hidden_outlet_id,another_image:another_image,type:1,checked_value:checked_value},
                      success: function (data) {
                          $("#thumb_modal").modal('hide');
                          $("#img_thumb_value_"+active_id_for_upload).val(data.image_name);
                          $("#img_thumb_file").val('');
                          $("#img_thumb_"+active_id_for_upload).attr('src',base_url_custom+"uploads/website/"+data.image_name);
                          let button_html = '<i data-id="'+active_id_for_upload+'" data-image="'+base_url_custom+'assets/media/no_image.png" class="color_notice remvoe_thumb_image fa fa-trash"></i>';
                          $(".img_thumb_"+active_id_for_upload).html(button_html);
                      }
                  });
              }
  
          });
      }); 




      let height_1 = 526;
      let width_1 = 495;
  
      let tmp_height_1 = 526+50;
      let tmp_width_1 = 495+50;
   
      let uploadCrop1 = $('#large_modal_div').croppie({
          enableExif: true,
          viewport: {
              width: width_1,
              height: height_1,
              type: 'square'
          },
          boundary: {
              width: tmp_width_1,
              height: tmp_height_1
          }
      });
      $(document).on('change', '#img_large_file', function (e) {
          let reader = new FileReader();
          reader.onload = function (e) {
              uploadCrop1.croppie('bind', {
                  url: e.target.result
              }).then(function(){
                 
              });
  
          }
          reader.readAsDataURL(this.files[0]);
      });
      $(document).on('click', '.del_img1', function (e) {
          let this_action = $(this);
          swal({
              title: hidden_alert+"!",
              text: are_you_sure+"?",
              cancelButtonText:hidden_cancel,
              confirmButtonText:hidden_ok,
              confirmButtonColor: '#3c8dbc',
              showCancelButton: true
          }, function() {
              this_action.parent().parent().parent().remove();
          });
  
      });
       
      $(document).on('click', '.upload-result_large', function (ev) {
        let active_id_for_upload = $("#active_id_for_upload").val();
        let checked_value =  $("#checker_"+active_id_for_upload).is(":checked") ? 1 : 2;
        let another_image = $("#img_thumb_value_"+active_id_for_upload).val();
          uploadCrop1.croppie('result', {
              type: 'canvas',
              size: 'viewport'
          }).then(function (resp) {
              let selected_image =  $("#img_large_file").val();
              if(selected_image==''){
                  swal({
                      title: hidden_alert+"!",
                      text: img_select_error_msg,
                      confirmButtonText:hidden_ok,
                      confirmButtonColor: '#3c8dbc'
                  });
                  return false;
              }else{
                  $.ajax({
                      url: base_url_custom+"Authentication/saveItemImage",
                      type: "POST",
                      dataType: 'json',
                      data: {"image":resp,food_menu_id:active_id_for_upload,hidden_outlet_id:hidden_outlet_id,another_image:another_image,type:2,checked_value:checked_value},
                      success: function (data) {
                          $("#large_modal").modal('hide');
                         
                          $("#img_large_value_"+active_id_for_upload).val(data.image_name);
                          $("#img_large_file").val('');
                          let html = '<i  data-id="'+active_id_for_upload+'" class="color_notice remvoe_large_image fa fa-trash"></i><i data-url="'+data.image_name+'" class="remvoe_large_image show_large_img fa fa-eye"></i>';
                          $(".img_large_"+active_id_for_upload).html(html);
                      }
                  });
              }
  
          });
      });


      $("#search_string").on("keyup", function () {
        let value = $(this).val().toLowerCase();

        $(".food_title").each(function () {
            let title = $(this).text().toLowerCase();
            $(this).parent().parent().parent().parent().toggle(title.includes(value));
        });
        
        // Update select all checkbox state after search filter
        updateSelectAllState();
    });

    // Function to update select all checkbox state based on visible items
    function updateSelectAllState() {
        let visibleCheckboxes = $('.child_class:visible');
        let visibleCheckedCheckboxes = $('.child_class:visible:checked');
        
        if(visibleCheckedCheckboxes.length === visibleCheckboxes.length && visibleCheckboxes.length > 0) {
            $('#select_all_food_menu').prop('checked', true);
        } else {
            $('#select_all_food_menu').prop('checked', false);
        }
    }

  $(document).on('click', '#select_all_food_menu', function() {
    if ($(this).is(':checked')) {
      // Only check visible items (not filtered by search)
      $('.child_class:visible').prop('checked', true);
      // Batch update database for all visible items when select all is checked
      let updates_data = [];
      $('.child_class:visible').each(function() {
        let this_id = $(this).val();
        let checked_value = 1; // All are checked
        let thumb_image = $("#img_thumb_value_"+this_id).val();
        let large_image = $("#img_large_value_"+this_id).val(); 
        
        updates_data.push({
          food_menu_id: this_id,
          checked_value: checked_value,
          thumb_image: thumb_image,
          large_image: large_image
        });
      });
      
      // Single AJAX call for all updates
      callBatchUpdateInfo(updates_data);
      
    } else {
      // Only uncheck visible items (not filtered by search)
      $('.child_class:visible').prop('checked', false);
      // Batch update database for all visible items when select all is unchecked
      let updates_data = [];
      $('.child_class:visible').each(function() {
        let this_id = $(this).val();
        let checked_value = 2; // All are unchecked
        let thumb_image = $("#img_thumb_value_"+this_id).val();
        let large_image = $("#img_large_value_"+this_id).val(); 
        
        updates_data.push({
          food_menu_id: this_id,
          checked_value: checked_value,
          thumb_image: thumb_image,
          large_image: large_image
        });
      });
      
      // Single AJAX call for all updates
      callBatchUpdateInfo(updates_data);
    }
  });
  
  $('.child_class').change(function() {
    // Update select all checkbox state based on visible items
    updateSelectAllState();
  });

  let allChecked = $('.child_class:visible').length === $('.child_class:visible:checked').length;
  $('#select_all_food_menu').prop('checked', allChecked);

  

  });
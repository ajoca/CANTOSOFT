$(function () {
      "use strict";
      let base_url_custom  = $("#base_url_custom").val();
      let hidden_alert  = $("#warning").val(); 
      let hidden_ok  = $("#ok").val();
 
      let suffix =0;

      let tab_index = 4;

      $(document).on('change', '#outlet_id', function(e){
            let id = $(this).val(); 
            let url = base_url_custom+"Frontend/exploreMenuSection/"+id;
            window.location.href = url;
        });

      $(document).on('click', '.del_explore_item', function(e){
            $(this).parent().parent().remove();
        });

        $(document).on('change', '#food_menu', function() {
            let ingredient_details = $('#food_menu').val();
            let name = $('#food_menu').find('option:selected').text();
            let sale_price = $('#food_menu').find('option:selected').attr('data-sale_price');
            let selected_value = ingredient_details+"|||"+name+"|||"+sale_price;
            let your_selected_food_menu_already_added = $('#your_selected_food_menu_already_added').val();
            if (ingredient_details != '') {
                $(".rowCount").each(function() {
                   let id_temp = $(this).attr('data-item_id');
                   if(id_temp==ingredient_details){
                       swal({
                           title: hidden_alert+"!",
                           text: your_selected_food_menu_already_added,
                           confirmButtonText: hidden_ok,
                           confirmButtonColor: '#3c8dbc'
                       });
                       $('#food_menu').val('').change();
                       exit;
                       return false;
                   }
                });
       
                suffix++;
                tab_index++;
    
                let cart_row = '<tr class="rowCount" data-item_id="' + ingredient_details + '" data-id="' + suffix + '" id="row_' + suffix + '">' +
                    '<td>' + name+
                    '</td>' +
                    '<input type="hidden" id="ingredient_id_' + suffix +
                    '" name="menu_details[]" value="' + selected_value + '"/>' +
                    '<td><textarea tabindex="' + tab_index + '" id="unit_price_' + suffix +
                    '" name="description[]" class="form-control" placeholder=""></textarea></td>' + 
                    '<td><a class="btn btn-danger btn-xs del_explore_item" style="margin-left: 5px; margin-top: 10px;"><i style="color:white" class="fa fa-trash"></i> </a></td>' +
                    '</tr>';
                tab_index++;
    
                $('.explore_tbl tbody').append(cart_row);
    
                $('#food_menu').val('').change();
                
            }
        });

  });
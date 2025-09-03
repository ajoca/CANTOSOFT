$(function() {
    "use strict";
        //base url from hidden field
        let base_url = $("#base_url_").val();
        let ok = $("#ok").val();
        let alert2 = $("#alert").val();
        let table_layout_added_msg = $("#table_layout_added_msg").val();
        let please_select_area = $("#please_select_area").val();
        let select_area_before_reset = $("#select_area_before_reset").val();
        let cancel = $("#cancel").val();
        let are_you_sure = $("#are_you_sure").val();
        let please_select_a_table_for_action = $("#please_select_a_table_for_action").val();
        let move_instruction_table_layout = $("#move_instruction_table_layout").val();
        toastr.options = {
            positionClass:'toast-bottom-right'
        };
       
        function setTable(id) {
            $.ajax({
                url: base_url+"Authentication/getTableDesign",
                method: "POST",
                dataType:"json",
                data: {
                    id: id
                },
                success: function (response) {
                    $(".table_box").remove();
                    if(response.html_design_content){
                        $(".div_design").html(response.html_design_content);
                        $("#canvas").append(response.new_html_table);
                    }else{
                        $("#canvas").append(response.html_table);
                    }
                    if(id){
                        toastr['warning'](move_instruction_table_layout, '');
                    }
    
                    $(".drag").draggable({
                        containment: "parent",
                    });
                },
                error: function () {
    
                },
            });
        }
        $(document).on("click", ".remove_box", function (e) {
           $(this).parent().remove();
        });
        
        $(document).on("click", ".reset_change_btn", function (e) {
            e.preventDefault();
            let area_id = Number($(".area_id").val());
            if(!area_id){
                swal({
                    title: alert2+ "!",
                    text: select_area_before_reset,
                    confirmButtonText: ok,
                    confirmButtonColor: "#3c8dbc",
                });
            }else{
                swal({
                    title: alert2 + "!",
                    text: are_you_sure + "?",
                    cancelButtonText: cancel,
                    confirmButtonText: ok,
                    confirmButtonColor: '#3c8dbc',
                    showCancelButton: true
                }, function () {
                    //for set reset value
                    $("#reset_layout").val(1);
                    //click for update the reset value
                    $(".save_setting").click();
                    //change for no select layout
                    $(".area_id").val('').change();
                });
            }
        });
    
        function updateTableLoyoutBG(table_bg_color){
            $.ajax({
                method: "POST",
                dataType:'json',
                url: base_url+"Authentication/updateTableLoyoutBG",
                data: {
                       table_bg_color:table_bg_color,
                },
                cache: false,
                success: function (response) {
                    
                }
            });
        }
    
        $(document).on("click", ".add_dj_box", function (e) {
            e.preventDefault();
            let area_id = Number($(".area_id").val());
            if(!area_id){
                swal({
                    title: alert2,
                    text: please_select_area,
                    confirmButtonText: ok,
                    confirmButtonColor: "#3c8dbc",
                });
            }else{
                let default_box_style_top = 25;
                    let lenght_of_text_box = 1;
                    if(lenght_of_text_box){
                        lenght_of_text_box++;
                        default_box_style_top = lenght_of_text_box * 25;
                    }
                   
                let dj_div = '<div style="top:'+default_box_style_top+'px" class="drag drag element parent-container table_box text-element default_box_style">\n' +
                    '                                      ' +
                    ' <button class="cross_button remove_box" title="Remove">\n' +
                    '            X\n' +
                    '        </button><div class="div_box div_box_ceter">\n' +
                    '                                        <b contenteditable="true" onfocus="select();">Untitle</b>\n' +
                    '                                    </div>\n' +
                    '                                </div>';
    
                $("#canvas").append(dj_div);
                $(".drag").draggable({
                    containment: "parent",
                });
            }
        });
        $(document).on("click", ".save_setting", function (e) {
            e.preventDefault();
            let reset_layout = $("#reset_layout").val();
            let area_id = Number($(".area_id").val());
            if(!area_id){
                swal({
                    title: alert2,
                    text: please_select_area,
                    confirmButtonText: ok,
                    confirmButtonColor: "#3c8dbc",
                });
            }else{
                let table_design_content = $(".div_design").html();
                $.ajax({
                    method: "POST",
                    dataType:'json',
                    url: base_url+"Authentication/setTableDesign",
                    data: {
                           reset_layout:reset_layout,
                           area_id:area_id,
                           table_design_content:btoa(table_design_content),
                    },
                    cache: false,
                    success: function (response) {
                        $("#reset_layout").val('');
                        swal({
                            title: alert2,
                            text: table_layout_added_msg,
                            confirmButtonText: ok,
                            confirmButtonColor: "#3c8dbc",
                        });
                    }
                });
            }
        });
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    
        $(document).on("change", ".area_id", function (e) {
            let id = $(this).val();
            setTable(id);
            setTimeout(function () {
                setRotatedTable();
            }, 200);
        });
    
        $(document).on("click", ".add_draw_element", function (e) {
            e.preventDefault();
            let area_id = Number($(".area_id").val());
            if(!area_id){
                swal({
                    title: alert2,
                    text: please_select_area,
                    confirmButtonText: ok,
                    confirmButtonColor: "#3c8dbc",
                });
            }
        });

        $(document).on("click", ".add_other_floor_element", function (e) {
            e.preventDefault();
            let area_id = Number($(".area_id").val());
            if(!area_id){
                swal({
                    title: alert2,
                    text: please_select_area,
                    confirmButtonText: ok,
                    confirmButtonColor: "#3c8dbc",
                });
            }
        });
    
        
    let height_ = 250;
    let width_ = 300;
    let tmp_height_ = 290;
    let tmp_width_ = 350;

    let uploadCrop = $('#upload-demo').croppie({
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

    $(document).on('change', '#upload', function (e) {
        let reader = new FileReader();
        reader.onload = function (e) {
            uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    function setUploadedImage(resp){
        let default_box_style_top = 25;
        let lenght_of_text_box = 1;
        if(lenght_of_text_box){
            lenght_of_text_box++;
            default_box_style_top = lenght_of_text_box * 25;
        }
        
      let dj_div = '<div style="top:'+default_box_style_top+'px" class="drag drag element parent-container table_box text-element default_box_style">\n' +
          '                                      ' +
          ' <button class="cross_button remove_box" title="Remove">\n' +
          '            X\n' +
          '        </button><div class="div_box div_box_ceter">\n' +
          '                                <img src="'+base_url+resp+'">        ' +
          '                                    </div>\n' +
          '                                </div>';

      $("#canvas").append(dj_div);
      $(".cr-image").attr("src",'');
      $(".drag").draggable({
          containment: "parent",
      });
  }


  function saveImg(image) {
    $.ajax({
      type: 'POST',
      url: base_url+'table/addElement',
      data: {image: image},
      success: function (resp) {
          setUploadedImage(resp);
          $(".click_to_cancel_modal").click();
      }
    });
  }


    $(document).on('click', '.submit_image_object', function (ev) {
        uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let selected_image =  $("#upload").val();
            if(selected_image==''){
                let select_an_image = $("#select_an_image").val();
                
                toastr['error']((select_an_image), '');
                return false;
            }else{
                saveImg(resp);
                $(".click_to_cancel_modal").click();
                $("#upload").val('');
            }

        });
    });

    function getRotatedValue(value){
        return (value*(-1));
      }
        function setRotatedTable(){
            $(".get_table_details").each(function() {
                let this_action = $(this);
                let transformValue = this_action.parent().attr('style');
                if(transformValue){
                    let rotateDigits = transformValue.match(/rotate\((\d+)deg\)/);
                    if(rotateDigits !== null && rotateDigits !== undefined  && rotateDigits !== "null"){
                        if(rotateDigits[1]){
                            $(this).css("transform","rotate("+(getRotatedValue(rotateDigits[1]))+"deg)");
                        }
                    }
                }
                $(this).parent().parent().css("z-index","99999");
            });
    }

    
        $(document).on("click", ".rotate_left", function (e) {
            e.preventDefault();
            let is_active_table = 0;
            let active_action = '';
            $(".div_rectangular").each(function (i, obj) {
                if ($(this).hasClass("div_rectangular_active")) {
                    is_active_table = Number($(this).find(".trigger_to_select_other").attr("data-id"));
                    active_action = $(this);
                }
            });
          
            if(is_active_table){
                active_action.css("transform","rotate(0deg)");
            }else{
                toastr['error']((please_select_a_table_for_action), '');
            }
            
            setTimeout(function () {
                setRotatedTable();
            }, 200);
        });
    
        $(document).on("click", ".rotate_right", function (e) {
            e.preventDefault();
            let is_active_table = 0;
            let active_action = '';
            $(".div_rectangular").each(function (i, obj) {
                if ($(this).hasClass("div_rectangular_active")) {
                    is_active_table = Number($(this).find(".trigger_to_select_other").attr("data-id"));
                    active_action = $(this);
                }
            });
          
            if(is_active_table){
                active_action.css("transform","rotate(90deg)");
            }else{
                toastr['error']((please_select_a_table_for_action), '');
            }
            setTimeout(function () {
                setRotatedTable();
            }, 200);
        });
    
        $(document).on("click", ".div_rectangular", function (e) {
            let this_active  = 0;
            let this_action = $(this);
            $(".div_rectangular").each(function (i, obj) {
                if ($(this).hasClass("div_rectangular_active")) {
                    this_active = Number($(this).find(".trigger_to_select_other").attr("data-id"));
                }
            });

            $(".div_rectangular").removeClass("div_rectangular_active");

            if (this_action.hasClass("div_rectangular_active")) {
                this_action.removeClass("div_rectangular_active");
            } else {
                let button_active = Number(this_action.find(".trigger_to_select_other").attr("data-id"));
                if(this_active!=button_active){
                    this_action.addClass("div_rectangular_active");
                }
            }
            
        });   
    
        $(document).on("click", ".set_bg_class", function (e) {
            e.preventDefault();
            let bg = $(this).attr("data-bg");
            let background_1 = $("#background_1").val();
            let background_2 = $("#background_2").val();
            $(".div_design").removeClass("table_bg_1");
            $(".div_design").removeClass("table_bg_2");

            $(".div_design").addClass(bg);
            if(bg=="table_bg_1"){
                $("#table_bg_1").html(' <i class="fa fa-check"></i> '+background_1);
                $("#table_bg_2").html(background_2);
            }else{
                $("#table_bg_2").html(' <i class="fa fa-check"></i> '+background_2);
                $("#table_bg_1").html(background_1);
            }
            updateTableLoyoutBG(bg);
        });   
        
        $(document).on("click", ".submit_drawing", function (e) {
            e.preventDefault();
            $(".wPaint-menu-icon-name-save").click();
        });   
});


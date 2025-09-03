$(function() {
    "use strict";
    let custom_base_url = $("#custom_base_url").val();
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
            '                                <img src="'+custom_base_url+resp+'">        ' +
            '                                    </div>\n' +
            '                                </div>';

        $("#canvas").append(dj_div);
        $(".drag").draggable({
            containment: "parent",
        });
    }


    function saveImg(image) {
      $.ajax({
        type: 'POST',
        url: custom_base_url+'table/addElement',
        data: {image: image},
        success: function (resp) {
            setUploadedImage(resp);
            $(".click_to_cancel_modal").click();
        }
      });
    }
    // init wPaint
    $('#wPaint').wPaint({
      menuOffsetLeft: -49,
      menuOffsetTop: -48,
      saveImg: saveImg,
    });

});


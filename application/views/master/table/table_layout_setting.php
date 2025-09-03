<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/custom.css">
<link href="<?php echo base_url(); ?>frequent_changing/notify/toastr.css" rel="stylesheet" type="text/css" />

<input type="hidden" id="please_select_area" value="<?php echo lang('please_select_area')?>">
<input type="hidden" id="table_layout_added_msg" value="<?php echo lang('table_layout_added_msg')?>">
<input type="hidden" id="alert" value="<?php echo lang('alert')?>">
<input type="hidden" id="ok" value="<?php echo lang('ok')?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel')?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure')?>">
<input type="hidden" id="reset_layout" value="">
<input type="hidden" id="table_bg_color" value="<?php echo $this->session->userdata('table_bg_color');?>">
<input type="hidden" id="select_area_before_reset" value="<?php echo lang('select_area_before_reset')?>">
<input type="hidden" id="move_instruction_table_layout" value="<?php echo lang('move_instruction_table_layout')?>">
<input type="hidden" id="please_select_a_table_for_action" value="<?php echo lang('please_select_a_table_for_action'); ?>">
<input type="hidden" id="background_1" value="<?php echo lang('background_1'); ?>">
<input type="hidden" id="background_2" value="<?php echo lang('background_2'); ?>">
<input type="hidden" id="select_an_image" value="<?php echo lang('select_an_image'); ?>">
<input type="hidden" id="custom_base_url" value="<?php echo base_url(); ?>">
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('table_layout_setting'); ?>
        </h3>
    </section>
            <div class="box-wrapper">
        <form enctype="multipart/form-data" method="post" accept-charset="utf-8" action="addEditTable" id="table_setting_form">
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12 mb-2 col-md-2">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 mb-2">
                                                    <div class="form-group">
                                                        <label><?php echo lang('area'); ?></label>
                                                        <select class="form-control area_id" name="area">
                                                            <option data-floor_bg_color="#008be9" value=""><?php echo lang('select'); ?></option>
                                                            <?php foreach ($areas as $value):?>
                                                                <option  <?php echo set_select('area',$value->id)?> value="<?php echo escape_output($value->id)?>"><?php echo escape_output($value->area_name)?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 mb-2">
                                                    <div class="form-group">
                                                        <a href="#" class="new-btn add_other_floor_element" onclick="image_object_modal();" ><?php echo lang('add_other_floor_element'); ?></a>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <a href="#" class="new-btn btn-block add_draw_element" onclick="draw_modal();" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('add_draw_element'); ?></a>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <a href="#" class="new-btn btn-block add_dj_box"><?php echo lang('add_text_object'); ?></a>
                                                    </div>
                                                </div>
                                    
                                                <div class="clearfix"></div>

                                                <div class="clearfix"></div>
                                                <div class="col-sm-12">
                                                    <button type="button" name="submit" value="submit"
                                                            class="btn bg-blue-btn w-100 save_setting"><?php echo lang('save_setting'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-2 col-md-10 table_design_content">
                                            <?php $table_bg_color = $this->session->userdata('table_bg_color');?>
                                            <div class="div_design <?php echo $table_bg_color?>">
                                                <div id="canvas"  class="format-letter">

                                                </div>
                                             </div>
                                             <div class="color_btn">
                                                <a href="#" class="btn bg-blue-btn rotate_left btn_common_not_full_with"> <i class="fa fa-rotate-left"></i> <?php echo lang('rotate_left'); ?></a>
                                                <a href="#" class="btn bg-blue-btn rotate_right btn_common_not_full_with"> <i class="fa fa-rotate-right"></i> <?php echo lang('rotate_right'); ?></a>
                                                <a href="#" class="btn btn-xs bg-red-btn reset_change_btn"><i class="fa fa-trash"></i> <?php echo lang('reset_layout'); ?></a> 
                                                
                                                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" data-bg="table_bg_1" class="btn bg-blue-btn btn_common_not_full_with set_bg_class" id="table_bg_1"> <i class="<?php echo $table_bg_color=="table_bg_1"?'fa fa-check':''?>"></i> <?php echo lang('background_1'); ?></a>
                                                <a href="#" data-bg="table_bg_2" class="btn bg-blue-btn btn_common_not_full_with set_bg_class" id="table_bg_2"> <i class="<?php echo $table_bg_color=="table_bg_2"?'fa fa-check':''?>"></i> <?php echo lang('background_2'); ?></a>
                                             </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
        </div>
</section>

<div class="modal fade" id="draw_modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="ShortCut">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><?php echo lang('add_draw_element'); ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body modal-body-custom">  
                <div id="wPaint" class="wPaint_div"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn submit_drawing">Submit</button>
                    <button type="button" class="btn bg-blue-btn click_to_cancel_modal" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    

 <div class="modal fade" id="image_object_modal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="ShortCut">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><?php echo lang('add_other_floor_element'); ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body modal-body-custom">  
                    <div class="row">
                        <div class="col-md-12 mt-3 text-center">
                            <input type="file" id="upload">
                        </div>
                        <div class="col-md-12 text-center">
                            <div id="upload-demo"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn submit_image_object">Submit</button>
                    <button type="button" class="btn bg-blue-btn click_to_cancel_modal" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
  
<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/custom_card_design_zak.css">
<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/table_design/jquery-ui.structure.css">
<script src="<?php echo base_url()?>frequent_changing/table_design/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="<?php echo base_url()?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url()?>frequent_changing/table_design/color_picker.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/notify/toastr.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/jquery.1.10.2.min.js"></script>
 <!-- jQuery UI -->
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/jquery.ui.core.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/jquery.ui.widget.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/jquery.ui.mouse.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/jquery.ui.draggable.1.10.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/crop/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/crop/croppie.css">

<!-- wColorPicker -->
<link rel="Stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/draw/lib/wColorPicker.min.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/lib/wColorPicker.min.js"></script>

<!-- wPaint -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/draw/wPaint.min.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/wPaint.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/plugins/main/wPaint.menu.main.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/plugins/text/wPaint.menu.text.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/plugins/shapes/wPaint.menu.main.shapes.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/draw/plugins/file/wPaint.menu.main.file.min.js"></script>
<script src="<?php echo base_url()?>frequent_changing/table_design/custom.js"></script>



<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js?v=1.1'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/available_online_foods.js?v=1.1'); ?>"></script>
<link rel="stylesheet" href="<?= base_url() ?>frequent_changing/css/custom_check_box.css?v=1.1">

<script src="<?= base_url() ?>assets/bower_components/crop/croppie.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/crop/croppie.css">
<input type="hidden" id="img_select_error_msg" value="<?php echo lang('img_select_error_msg'); ?>">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="are_you_sure" value="<?php echo lang('are_you_sure'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
<input type="hidden" id="base_url_custom" value="<?= base_url() ?>">
<input type="hidden" id="hidden_outlet_id" value="<?= $hidden_outlet_id ?>">
<input type="hidden" id="active_id_for_upload" value="">


<!-- Main content -->
<section class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
  
 
 
 <div id="loading_indicator" class="loading-indicator">
      <div class="indicator-content">
          <i class="fa fa-spinner fa-spin loading-icon"></i>
          <div>Processing batch update...</div>
          <div class="progress-wrapper">
              <div class="progress-bar">
                  <div id="progress_bar" class="progress" style="width: 0;"></div>
              </div>
          </div>
      </div>
  </div>
  
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('available_online_foods'); ?>
           
        </h3>
        
    </section>

    <div class="box-wrapper">
            <div class="table-box">
            
                <?php
                $attributes = array('id' => 'restaurant_setting_form');
                echo form_open_multipart(base_url('Frontend/availableOnlineFoods'),$attributes); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <input tabindex="4" onfocus="select();" autocomplete="off" type="text" id="search_string" class="form-control" placeholder="<?php echo lang('search_by_food_menu_name'); ?>" value="" />
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select_all_food_menu">
                                    <label class="form-check-label" for="select_all_food_menu">
                                        <?php echo lang('Select_All_Food_Menu'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if(isLMni()):
                    ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select tabindex="2" class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                                <option value=""><?php echo lang('Select_Outlet'); ?></option>
                                <?php
                                $outlets = getAllOutlestByAssign();
                                foreach ($outlets as $value):
                                    ?>
                                    <option <?= $hidden_outlet_id==$value->id?"selected":""?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <p class="margin_0">&nbsp;</p>
                    <?php
                endif;
                ?>
                
                <div class="row">
                        <?php
                        if(isset($items) && $items){
                        foreach ($items as $item) {
                            $checked = '';
                            $new_id = $item->id;
                            $checked = ''; // Default unchecked
                            
                            if (isset($selected_modules_arr)) {
                                if (array_key_exists($new_id, $selected_modules_arr)) { 
                                    $value = explode("_",$selected_modules_arr[$new_id]);
                                    if($value[0]==1){
                                        $checked = 'checked';
                                    }
                                }
                            }
 


                            $larges = $outlet_information->large_imgs;
                            if($larges){
                                $larges = (Array)json_decode($larges);
                            }
                            $thumbs = $outlet_information->thumb_imgs;
                            if($thumbs){
                                $thumbs = (Array)json_decode($thumbs);
                            }
                            $thumb_value = '';
                            $thumb_str = "thumb_".$item->id;
                            if(isset($thumbs[$thumb_str]) && $thumbs[$thumb_str]) :
                                $thumb_value = $thumbs[$thumb_str];
                            endif;
                            ?>
                            <div class="col-sm-12 col-md-3 mb-2">
                                <div class="border_custom">
                               
                                <div class="form-group">
                                        
                                        <input type="hidden" name="img_thumb_value_<?php echo escape_output($item->id)?>" id="img_thumb_value_<?php echo escape_output($item->id)?>" value="<?php echo escape_output($thumb_value)?>">
                                       
                              
                                            <?php 
                                               
                                                if(isset($thumbs[$thumb_str]) && $thumbs[$thumb_str]) :
                                                ?>
                                                    <img class="img_thumb" id="img_thumb_<?php echo escape_output($item->id)?>" src="<?php echo base_url()?>uploads/website/<?php echo $thumbs[$thumb_str]?>">
                                                    
                                                 <?php else:?>
                                                    <img class="img_thumb" id="img_thumb_<?php echo escape_output($item->id)?>" src="<?php echo base_url()?>assets/media/no_image.png">
                                                    <?php endif?>

                                            <label class="container txt_47" for="checker_<?php echo escape_output($item->id)?>"><?="<b class='food_title'>".getParentNameTemp($item->parent_id).(isset($item->name) && $item->name?''.$item->name.'':'')."</b>"?>
                                            <input class="checkbox_user child_class" id="checker_<?php echo escape_output($item->id)?>"  <?=$checked?> data-name="<?php echo str_replace(' ', '_', $item->name)?>" value="<?=$item->id?>" type="checkbox" name="item_check[]">
                                            <span class="checkmark"></span>
                                        </label>         
                                                        
                                        <table class="ir_w_100 margin_top5">
                                            <tr>
                                                <td class="text_left">
                                                    <button type="button" name="submit" data-id="<?php echo escape_output($item->id)?>" class="img_thumb_btn btn bg-blue-btn custom_botton_ new-btn"><?php echo lang('add_thumb_image'); ?></button>
                                                </td>
                                                
                                                    <td  class="img_thumb_<?php echo escape_output($item->id)?>">
                                                            <?php  if(isset($thumbs[$thumb_str]) && $thumbs[$thumb_str]) :?>
                                                                <i data-id="<?php echo escape_output($item->id)?>" data-image="<?php echo base_url()?>assets/media/no_image.png" class="color_notice remvoe_thumb_image fa fa-trash"></i>
                                                            <?php endif?>
                                                    </td>
                                                
                                            </tr>
                                        </table>
                                        
                                        <table class="ir_w_100 margin_top5">
                                            <tr>
                                                <td class="text_left">
                                                    <button type="button" name="submit" data-id="<?php echo escape_output($item->id)?>" class="img_large_btn btn bg-blue-btn custom_botton_ new-btn"><?php echo lang('add_large_image'); ?></button>
                                                </td>
                                                <td  class="img_large_<?php echo escape_output($item->id)?>">
                                                        <?php 
                                                        $large_str = "large_".$item->id;
                                                        $large_value = '';
                                                        if(isset($larges[$large_str]) && $larges[$large_str]) :
                                                            $large_value = $larges[$large_str];
                                                        ?>
                                                            <i  data-id="<?php echo escape_output($item->id)?>" class="color_notice remvoe_large_image remvoe_large_image_action fa fa-trash"></i>
                                                            <i data-url="<?php echo $larges[$large_str]?>" class="remvoe_large_image show_large_img fa fa-eye"></i> 
                                                        <?php endif?>
                                                </td>
                                            </tr>
                                        </table>
                                        

                                        <input type="hidden" name="img_large_value_<?php echo escape_output($item->id)?>" id="img_large_value_<?php echo escape_output($item->id)?>" value="<?php echo escape_output($large_value)?>">
                                </div>
                          
                           
                                <br>
                                </div>
                            </div>
                            <?php
                        }
                    }
                        ?>
                    </div>
                </div>
                <!-- /.box-body -->

              
                <?php echo form_close(); ?>
            </div>
    </div>
 


    <div class="modal fade" id="thumb_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7 text-center">
                            <div id="thumb_modal_div"></div>
                        </div>
                        <div class="col-md-5 txt-uh-50">
                            <strong><?php echo lang('Select_Image'); ?></strong>
                            <br/>
                            <input type="file" id="img_thumb_file">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary cancel" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="button" class="btn btn-primary upload-result" id="">
                        <i class="fa fa-save "></i> <?php echo lang('Crop'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="large_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="large_modal_div"></div>
                        </div>
                        <div class="col-md-12 text-center">
                            <strong><?php echo lang('Select_Image'); ?></strong>
                            <br/>
                            <input type="file" id="img_large_file">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary cancel" data-dismiss="modal"><?php echo lang('cancel'); ?></button>
                    <button type="button" class="btn btn-primary upload-result_large" id="">
                        <i class="fa fa-save "></i> <?php echo lang('Crop'); ?></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="large_modal_preview" aria-hidden="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo lang('large_image'); ?> </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"
                            style="background-color: <?php echo escape_output($base_color)?>;text-align: center;padding: 10px;">
                            <img class="img-fluid" src="" id="show_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn cancel"
                        data-dismiss="modal"  data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                </div>
            </div>

        </div>
    </div>

</section>

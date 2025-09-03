<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/explore_menu_section.js'); ?>"></script>
<!-- Main content -->
<section class="main-content-wrapper">
<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
<input type="hidden" id="a_error" value="<?php echo lang('error'); ?>">
<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
<input type="hidden" id="cancel" value="<?php echo lang('cancel'); ?>">
<input type="hidden" id="base_url_custom" value="<?= base_url() ?>">
<input type="hidden" id="your_selected_food_menu_already_added" value=" <?php echo lang('your_selected_food_menu_already_added'); ?>">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('exploreMenuSection'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
    <div class="table-box">
                <?php
                $attributes = array('id' => 'explore_menu_section');
                $explore_menu_section = isset($company_info->explore_menu_section) && $company_info->explore_menu_section?json_decode($company_info->explore_menu_section):'';
                echo form_open_multipart(base_url('Frontend/exploreMenuSection/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('explore_menu_title'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="explore_menu_title" name="explore_menu_title" class="form-control" placeholder="<?php echo lang('explore_menu_title'); ?>" value="<?php echo isset($explore_menu_section->explore_menu_title) && $explore_menu_section->explore_menu_title ? $explore_menu_section->explore_menu_title : ''; ?>">
                            </div>
                            <?php if (form_error('explore_menu_title')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('explore_menu_title'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('explore_menu_heading'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" id="explore_menu_heading" name="explore_menu_heading" class="form-control" placeholder="<?php echo lang('explore_menu_heading'); ?>" value="<?php echo isset($explore_menu_section->explore_menu_heading) && $explore_menu_section->explore_menu_heading ? $explore_menu_section->explore_menu_heading : ''; ?>">
                            </div>
                            <?php if (form_error('explore_menu_heading')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('explore_menu_heading'); ?>
                                </div>
                            <?php } ?>
                        </div>
                         <div class="clearfix"></div>
                         <p class="margin_0">&nbsp;</p>
                         <p class="margin_0">&nbsp;</p>
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
                        
                        <?php
                    endif;
                    ?>
                    
                    <div class="clearfix"></div>
                    <div class="col-sm-12 col-md-6 mb-2 col-lg-4">

                        <div class="form-group">
                            <label><?php echo lang('available_online_foods'); ?></label>
                            <select tabindex="4" class="form-control select2 select2-hidden-accessible ir_w_100"
                                name="food_menu" id="food_menu">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($explor_items as $ingnts) { ?>
                                <option data-sale_price="<?php echo escape_output($ingnts->sale_price) ?>"
                                    value="<?php echo escape_output($ingnts->id) ?>"><?php echo escape_output($ingnts->name . "(" . $ingnts->code . ")") ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('food_menu')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('food_menu'); ?>
                        </div>
                        <?php } ?>
                       
                        </div>
                  
                        <div class="col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <input type="hidden" class="datatable_name" data-title="<?php echo lang('Printer'); ?>" data-id_name="datatable">
                            <table id="datatable" class="table explore_tbl">
                                <thead>
                                    <tr>
                                        <th class="width_15_p text-left" ><?php echo lang('food_menu'); ?></th>
                                        <th><?php echo lang('description'); ?></th>
                                        <th class="width_2_p c_center not-export-col"><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php 
                                            if(isset($outlet_details->explore_section_items) && $outlet_details->explore_section_items){
                                            $explore_section_items = $outlet_details->explore_section_items;
                                            if($explore_section_items){
                                                $explore_section_items_obj = json_decode($explore_section_items);
                                                foreach($explore_section_items_obj as $key=>$value){
                                        ?>
                                                    <tr class="rowCount" data-item_id="<?php echo $value->food_id?>" data-id="1" id="row_1">
                                                        <td><?php echo escape_output($value->name)?></td>
                                                        <input type="hidden"  name="menu_details[]" value="<?php echo escape_output($value->food_id)?>|||<?php echo escape_output($value->name)?>|||<?php echo escape_output($value->sale_price)?>">
                                                        <td><textarea tabindex="5"  name="description[]" class="form-control" placeholder=""><?php echo escape_output($value->description)?></textarea></td>
                                                        <td><a class="btn btn-danger btn-xs del_explore_item" style="margin-left: 5px; margin-top: 10px;"><i style="color:white" class="fa fa-trash"></i> </a></td>
                                                    </tr>

                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
          

    </div>


    <div class="modal fade" id="logo_preview" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                        <?php echo lang('system_logo'); ?> </h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-bod">
                    <div class="row">
                        <div class="col-md-12 site_logo_parent_div">
                            <img class="site_logo_parent_img ir_w_100" src="" id="show_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
                </div>
            </div>

        </div>
    </div>

</section>
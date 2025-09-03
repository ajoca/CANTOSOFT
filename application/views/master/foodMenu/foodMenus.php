<script src="<?php echo base_url(); ?>frequent_changing/js/select_2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/food_menu.css">
 <section class="main-content-wrapper min_div_height">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show">
        <div class="alert-body">';
            echo '<p><i class="m-right fa fa-check"></i>'.escape_output($this->session->flashdata('exception')).'</p>';
        echo '
        </div>
        </div></section>
        ';
    }
    ?>
 
        <section class="content-header">
            <div class="col-sm-12">
                <h2 class="top-left-header"><?php echo lang('food_menus'); ?> </h2>
                <input type="hidden" class="datatable_name" data-filter="yes" data-title="<?php echo lang('food_menus'); ?>" data-id_name="datatable">
            </div>
        </section>

        <div class="box-wrapper">
            <div class="d-flex justify-content-end">
                <a  data-access="upload_food_menu-234" class="new-btn menu_assign_class text-center me-2"  href="<?php echo base_url() ?>foodMenu/uploadFoodMenu">
                    <i class="m-right" data-feather="upload"></i> <?php echo lang('upload_food_menu'); ?>
                </a>
                <a  data-access="upload_food_menu_ingredients-234" class="new-btn menu_assign_class me-2"  href="<?php echo base_url() ?>foodMenu/uploadFoodMenuIngredients">
                    <i class="m-right" data-feather="upload-cloud"></i> <?php echo lang('upload_food_menu_ingredients'); ?>
                </a>
                <a data-access="item_barcode-234" class="new-btn menu_assign_class me-2" href="<?php echo base_url() ?>foodMenu/foodMenuBarcode">
                    <i class="m-right fa fa-qrcode"></i> <?php echo lang('food_menu_barcode'); ?>
                </a>
            </div>

            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <div class="header_custom food_menu_slider">
                        <div class="active1 class_category" data-name="<?php echo lang('All_Menu'); ?>" data-id="all">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img class="cate_img" src="<?= base_url() ?>assets/media/all.png" alt=""> 
                                <p>
                                    <?php echo lang('All_Menu'); ?> 
                                </p>
                                <span><?php echo sizeof($foodMenus)?></span>
                            </div>
                        </div> 
                        <?php foreach ($foodMenuCategories as $value) { ?>
                        <div class="class_category" data-name="<?php echo $value->category_name?>" data-id="<?php echo $value->id?>">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <img class="cate_img" src="<?= base_url() . "uploads/category/" . $value->category_image ?>" alt=""> 
                                <p>
                                    <?php echo $value->category_name?> 
                                </p>
                                <span><?php echo $value->total_item?> Foods</span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <br>
                    <h4 class="item_header header_title"><?php echo lang('All_Menu'); ?></h4>
                    <p  class="item_counter"><span class="item_header_counter"><?php echo sizeof($foodMenus)?></span> <?php echo lang('items'); ?></p>
                    
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-group">
                                <input tabindex="4" onfocus="select();" autocomplete="off" type="text" id="search_string" class="form-control" placeholder="<?php echo lang('search_by_food_menu_name_or_category'); ?>" value="" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="menu-container">
                        <div class="menu-container">
                            <?php
                                foreach ($foodMenus as $value) {
                                $img_size = "images/".$value->photo;
                                if(file_exists($img_size) && $value->photo!=""){
                                    $image_path = base_url().'images/'.$value->photo;
                                }else{
                                    $image_path = base_url().'images/image_thumb.png';
                                }
                                ?>
                                <div class="menu-item-custom cat_<?php echo $value->category_id?>">
                                    <img class="img-responsive call_details" data-id="<?php echo ($value->id) ?>" src="<?= $image_path ?>" alt="">
                                    <div class="details call_details" data-id="<?php echo ($value->id) ?>">
                                        <h3 class="food_title"><?php echo escape_output($value->name) ?> <?php echo escape_output(getAlternativeNameById($value->id))?></h3>
                                        <p class="price"><?php echo escape_output(getAmtPCustom($value->sale_price)) ?></p>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <div class="cat-code">
                                                <p class="category_custom"><?php echo lang('code'); ?>: <?php echo ($value->code) ?></p>
                                                <p class="category_custom mb-0 food_title_category"><?php echo lang('category'); ?>: <?php echo getFoodMenuCateCodeById($value->category_id) ?></p>
                                            </div>
                                            <!-- <div class="more-btn">
                                                <i class="far fa-plus"></i>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="action-overlay">
                                        <div class="actions">
                                            <div class="availability" data-id="<?php echo $value->id?>">
                                                <a class="delete" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>" href="<?php echo base_url() ?>foodMenu/deleteFoodMenu/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i
                                                class="fa-regular fa-trash-can"></i></a>
                                            </div>
                                            <div class="availability" data-id="<?php echo $value->id?>">
                                                <a class="assign-modifier" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('assign_modifier'); ?>" href="<?php echo base_url() ?>foodMenu/assignFoodMenuModifier/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i
                                                class="far fa-plus"></i></a>
                                            </div>
                                            <div class="buttons">
                                                <a class="edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('edit'); ?>" href="<?php echo base_url() ?>foodMenu/addEditFoodMenu/<?php echo escape_output($this->custom->encrypt_decrypt($value->id, 'encrypt')); ?>"><i
                                                class="fa fa-pencil"></i></a>
                                            </div>
                                            <div class="buttons">
                                                <a class="view-details call_details" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('view_details'); ?>" data-id="<?php echo ($value->id) ?>" href="javascript:void(0)"><i
                                                class="far fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 


</section>


<div class="modal fade" id="filterModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('food_menus'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <?php echo form_open(base_url() . 'foodMenu/foodMenus') ?>
                        <select name="category_id" class="form-control w-100 select2">
                            <option value=""><?php echo lang('category'); ?></option>
                            <?php foreach ($foodMenuCategories as $ctry) { ?>
                            <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('category_id', $ctry->id); ?>>
                                <?php echo escape_output($ctry->category_name) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-sm-12 col-md-6">
                        <button type="submit" name="submit" value="submit"
                            class="btn bg-blue-btn w-100"><?php echo lang('submit'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product_details" aria-hidden="true" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                        </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 show_html_content"> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                    data-dismiss="modal"  data-bs-dismiss="modal"><?php echo lang('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/food_menu_list.js"></script>
 <!-- DataTables -->
 
<link rel="stylesheet" href="<?php echo base_url();?>frequent_changing/css/custom_check_box.css">
<section class="main-content-wrapper">
<?php
if ($this->session->flashdata('exception')) {
    echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <p><i class="fa fa-check"></i>';
    echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
    echo '</p></div></div></section>';
}
?>

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('purchase_item_barcode'); ?>
        </h3>
    </section>



         <div class="box-wrapper">
             <!-- general form elements -->
             <div class="table-box">
                 <!-- /.box-header -->
                 <?php echo form_open(base_url() . 'Purchase/barcode/'.$id, $arrayName = array('id' => 'foodMenuBarcode','enctype'=>'multipart/form-data')) ?>

                <div class="row mb-2">
                    <div class="form-group col-md-4">
                        <select name="barcode_width" class="form-control select2">
                            <option value="1"><?php echo lang('barcode_width'); ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-center">
                        <input type="number" value="" onfocus="select()" class="form-control" name="barcode_height" placeholder="Barcode Height(px)">
                        <span class="ms-2">px</span>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn alertClass me-2">
                        <i data-feather="refresh-ccw"></i>
                        <?php echo lang('generate_now'); ?>
                    </button>
                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Purchase/purchases">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                
                 <table id="datatable_id" class="table datatable">
                     <thead>
                        <tr>
                            <th hidden></th>
                            <th class="custom_txt_1">
                                <div class="form-group">
                                    <label class="container ir_w_89"> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_userAll" type="checkbox" id="checkbox_userAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </th>
                            <th  class="ir_w_2"><?php echo lang('code'); ?></th>
                            <th class="ir_w_16"><?php echo lang('name'); ?></th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php
                     if ($purchase_ingredients && !empty($purchase_ingredients)) {
                         $i = count($purchase_ingredients);
                     }
                     foreach ($purchase_ingredients as $ingrnts) {
                        $ing = getIngredient($ingrnts->ingredient_id);
                         ?>
                         <tr>
                             <td hidden></td>
                             <td class="ir_txt_center">
                                     <div class="d-flex align-items-center">
                                         <div class="ir_w_25"> 
                                             <input class="ir_w_100 ir_txt_center" disabled type="number" min="1" id="qty<?=$ingrnts->id?>" onfocus="select();" name="qty[]" value="">
                                        </div>
                                         <div class="form-group">  
                                             <label class="container"><?php echo lang('select'); ?>
                                                 <input type="checkbox"  class="checkbox_user" data-menu_id="<?=$ingrnts->id?>" value="<?=$ing->id."|".$ing->name."|".$ing->code?>" name="food_menu_id[]"?>
                                                 <span class="checkmark"></span>
                                             </label>
                                            </div>
                                     </div>
                             </td>
                             <td><?php echo escape_output($ing->code); ?></td>
                             <td><?php echo escape_output($ing->name); ?></td>
                         </tr>
                         <?php
                     }
                     ?>
                     </tbody>
                 </table>
                
                 <div class="box-footer">
                        <button type="submit" name="submit" value="submit" class="btn bg-blue-btn alertClass me-2">
                            <i data-feather="refresh-ccw"></i>
                            <?php echo lang('generate_now'); ?>
                        </button>
                        <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Purchase/purchases">
                            <i data-feather="corner-up-left"></i>
                            <?php echo lang('back'); ?>
                        </a>
                     </div>
                 </div> 
                 <?php echo form_close(); ?>
                 <!-- /.box-body -->
             </div>
         </div>
     
 </section>
 <!-- DataTables -->
 <script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/foodmenubarcode.js"></script>

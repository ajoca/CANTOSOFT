<script src="<?php echo base_url(); ?>assets/plugins/barcode/JsBarcode.all.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inline_priority.css">
<section class="main-content-wrapper">
    <div class="box-wrapper">
        <div class="table-box">
            <div class="row">
                <div id="printableArea">
                    <?php
                 
                    for($i=0;$i<sizeof($items);$i++):
                    for ($j=0;$j<$items[$i]['qty'];$j++):
                        ?>
                        <table class="custom_txt_4 width_unset">
                            <tr>
                                <td class="custom_txt_5"> <span><?=$items[$i]['item_name']?></span></td>
                            </tr>
                            <tr>
                                <td class="custom_txt_5"> <span><?=$items[$i]['code']?></span></td>
                            </tr>
                            <tr>
                                <td> <img class="custom_txt_6" id="barcode<?=$items[$i]['id']?><?=$j?>"/></td>
                            </tr>
                            <tr>
                                <td class="custom_txt_7"><span>Ex. <?=($items[$i]['expire_date'])?></span></td>
                            </tr>
                        </table>
                    <?php
                    endfor;
                    ?>
                    <?php for ($j=0;$j<$items[$i]['qty'];$j++):
                    ?>
                        <script>JsBarcode("#barcode<?=$items[$i]['id']?><?=$j?>", "<?=$items[$i]['expire_date']?>", {  width: <?=isset($barcode_width) && $barcode_width?$barcode_width:1?>,
                                height: <?=isset($barcode_height) && $barcode_height?$barcode_height:30?>,
                                fontSize:12,
                                textMargin:-18,
                                margin:0,
                                marginTop:0,
                                marginLeft:10,
                                marginRight:10,
                                marginBottom:0,
                                displayValue: false
                            });
                        </script>
                        <?php
                    endfor;
                    endfor;
                    ?>
                </div>
            </div>

            <div class="box-footer">
                
                <a class="btn bg-blue-btn me-2" href="<?php echo base_url() ?>Purchase/barcode/<?php echo $id?>">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
                <a class="btn bg-blue-btn" onclick="printDiv('printableArea')">
                    <i data-feather="printer"></i>
                    <?php echo lang('print'); ?>
                </a>
            </div>
        </div>
    </div>
        
</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/barcode_preview.js"></script>
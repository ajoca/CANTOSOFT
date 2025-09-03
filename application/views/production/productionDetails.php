
<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('details_production'); ?>
        </h3>
    </section>


    <div class="box-wrapper">
        <div class="table-box">

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('ref_no'); ?></h3>
                                <p class=""><?php echo escape_output($production_details->reference_no) ?></p>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('date'); ?></h3>
                                <p class="">
                                    <?php echo escape_output(date($this->session->userdata('date_format'), strtotime($production_details->date))); ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <h3><?php echo lang('ingredients'); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="production_cart">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="txt_31"><?php echo lang('sn'); ?></th>
                                            <th class="txt_33">
                                                <?php echo lang('production'); ?>(<?php echo lang('code'); ?>)</th>
                                            <th class="txt_32"><?php echo lang('quantity_amount'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        if ($production_ingredients && !empty($production_ingredients)) {
                                            foreach ($production_ingredients as $pi) {
                                                $i++;
                                                echo '<tr id="row_' . $i . '">' .
                                                '<td class="txt_24"><p>' . $i . '</p></td>' .
                                                '<td class="ir_w_20"><span class="txt_18">' . getIngredientNameById($pi->ingredient_id) . ' (' . getIngredientCodeById($pi->ingredient_id) . ')</span></td>' .
                                                '<td class="ir_w_15">' . $pi->quantity_amount . ' ' . unitName(getUnitIdByIgId($pi->ingredient_id)) . '</td>' .
                                                '</tr>'
                                                ;
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-offset-6 col-md-3">

                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    
                    <a class="btn bg-blue-btn me-2" href="<?php echo base_url() ?>Production/productions/<?php echo escape_output($encrypted_id); ?>">
                        <i data-feather="edit"></i>
                        <?php echo lang('edit'); ?>
                    </a>
                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Production/productions">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>

                
        </div>
        <?php echo form_close(); ?>
    </div>
        
</section>
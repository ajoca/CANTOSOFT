<div class="modal fade" id="outletSelectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel"><?php echo lang('Select_Your_Nearest_Outlet'); ?></h1>
            </div>
            <div class="modal-body" style="background-image: url('<?php echo base_url('assets/website/img/bg/modal_bg.png'); ?>');">
            <?php echo form_open(base_url() . 'set-nearest-outlet', $arrayName = array('novalidate' => 'novalidate')) ?>   
                <div class="form">
                    <select id="heroSelect" name="outlet_id" class="hero-form-select outlet_id" aria-label="Default select example">
                        <?php
                        $outlets = getAllOutlestByAssignFront();
                        foreach ($outlets as $value):
                        if ($value->online_order_module == 2): ?>
                            <option <?php echo set_select('outlet_id', $value->id) ?> value="<?php echo escape_output($value->id) ?>">
                                <?php echo escape_output($value->outlet_name) ?>
                            </option>
                        <?php endif;  
                        endforeach;
                            ?>
                    </select>
                </div>
                <button type="submit" class="submit-button left13" id="submitOutlet"><?php echo lang('submit'); ?></button>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
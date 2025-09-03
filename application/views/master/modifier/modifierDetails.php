<section class="main-content-wrapper">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('modifier_details'); ?>
        </h3>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <h5><?php echo lang('name'); ?></h5>
                            <p class=""><?php echo escape_output($food_menu_details->name) ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <h5><?php echo lang('price'); ?></h5>
                            <p class=""> <?php echo escape_output($food_menu_details->price) ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h5><?php echo lang('description'); ?></h5>
                            <p class=""><?php echo escape_output($food_menu_details->description) ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php
                            $collect_tax = $this->session->userdata('collect_tax');
                            if(isset($collect_tax) && $collect_tax=="Yes"):
                                ?>
                                <h5><?php echo strtoupper(lang('vat')); ?></h5>
                                <?php if($food_menu_details->tax_information != ''){
                                $tax_information = json_decode($food_menu_details->tax_information);
                                foreach ($tax_information as $keys=>$val):
                                    ?>
                                    <span class="">
                                    <?php echo escape_output($val->tax_field_name); ?>: <?php echo escape_output($val->tax_field_percentage); ?>%
                                        <?php
                                        if($keys<(sizeof($tax_information)-1)){
                                            echo ", ";
                                        }
                                        ?>
                                </span>
                                    <?php
                                endforeach;
                            }
                            endif;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5><?php echo lang('ingredient_consumptions'); ?></h5>
                        </div>
                    </div>
                </div>

                <?php $food_menu_ingredients = modifierIngredients($food_menu_details->id); ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="ingredient_consumption_table">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php echo lang('sn'); ?></th>
                                    <th><?php echo lang('ingredient'); ?></th>
                                    <th><?php echo lang('consumption'); ?></th>
                                    <th><?php echo lang('cost'); ?></th>
                                    <th><?php echo lang('total'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 0;
                                if ($food_menu_ingredients && !empty($food_menu_ingredients)) {
                                    foreach ($food_menu_ingredients as $fmi) {
                                        $i++;
                                        echo "<tr>" .
                                            "<td class='txt_26'><p>" . $i . "</p></td>" .
                                            "<td><span>" . getIngredientNameById($fmi->ingredient_id) . "</span></td>" .
                                            "<td>" . getAmtPCustom($fmi->consumption) . " " . unitName(getUnitIdByIgId($fmi->ingredient_id)) . "</td>" .
                                            '<td>' . $fmi->cost . '</td>' .
                                            '<td>' . $fmi->total . '</td>' .
                                            "</tr>";
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="pull-right padding_17"><?php echo lang('total'); ?> <?php echo lang('cost'); ?></th>
                                    <th><?php echo escape_output($food_menu_details->total_cost)?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <a class="btn bg-blue-btn me-2" href="<?php echo base_url() ?>modifier/addEditModifier/<?php echo escape_output($encrypted_id); ?>">
                    <i data-feather="edit"></i>
                    <?php echo lang('edit'); ?>
                </a>
                <a class="btn bg-blue-btn" href="<?php echo base_url() ?>modifier/modifiers">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
        </div>
    </div>
</section>
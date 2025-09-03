<section class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show" role="alert">     
            <div class="alert-body">
            <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo lang('ordering_for_pos'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('ordering_for_pos'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-offset-4 col-md-2">

            </div>
        </div>
    </section>

    <div class="box-wrapper_sorting">
        <!-- general form elements -->
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <form method="post" id="sorting_form">
                  <table  class="table table-striped">
                    <thead>
                    <tr>
                        <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                        <th class="ir_w_28"><?php echo lang('category_name'); ?></th>
                        <th  class="ir_w_28"><?php echo lang('description'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="sortCate">
                    <?php
                    foreach ($foodMenuCategories as $i=>$fmc) {
                        $i++
                        ?>
                        <tr>
                            <td class="counters ir_txt_center"><?php echo escape_output($i); ?></td>
                            <td>
                                <input  type="hidden" name="cats[]" value="<?php echo escape_output($fmc->id); ?>">
                                <?php echo escape_output($fmc->category_name) ?></td>
                            <td><?php echo escape_output($fmc->description) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>

                </table>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </div>

</section>
<script src="<?php echo base_url(); ?>frequent_changing/js/jquery.dragsort.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/category_sorting.js"></script>
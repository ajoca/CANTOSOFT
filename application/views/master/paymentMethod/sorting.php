<section class="main-content-wrapper">
<input type="hidden" id="hidden_base_url" value="<?php echo base_url()?>">
    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/up_down.css">

    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="top-left-header"><?php echo lang('sorting'); ?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('sorting'); ?>" data-id_name="datatable">
            </div>
            <div>

            </div>

        </div>
    </section>


    <div class="box-wrapper">
        <!-- general form elements -->
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <form method="post" id="sorting_form">
                <table id="datatable" class="table">
                    <thead>
                    <tr>
                        <th class="ir_w_1"> <?php echo lang('sn'); ?></th>
                        <th class="ir_w_10 "><?php echo lang('payment_method_name'); ?></th>
                        <th  class="ir_w_10"><?php echo lang('description'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="sorting_payments">
                    <?php
                    if ($paymentMethods && !empty($paymentMethods)) {
                        $i = count($paymentMethods);
                    }
                    $m = 0;
                    foreach ($paymentMethods as $key=>$value) {
                        if($value->id!=1 && $value->id!=5):
                            $m++;
                        ?>
                        <tr>
                            <td class="ir_txt_center counters"><?php echo escape_output($m); ?></td>
                            <td><input  type="hidden" name="payments[]" value="<?php echo escape_output($value->id); ?>"><?php echo escape_output($value->name) ?></td>
                            <td><?php echo escape_output($value->description) ?></td>
                        </tr>
                    <?php
                    endif;
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
<script src="<?php echo base_url(); ?>assets/dist/js/jquery.dragsort.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/sorting.js"></script>

<section class="main-content-wrapper">

    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('upload_customer'); ?>
        </h3>

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


        <?php
        if ($this->session->flashdata('exception_err')) {

            echo '<section class="alert-wrapper">
        <div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <p><i class="m-right fa fa-times"></i>';
            echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
            echo '</p></div></div></section>';
        }
        ?>

    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <!-- form start -->
            <?php echo form_open_multipart(base_url('customer/ExcelDataAddCustomers')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> <?php echo lang('upload_file'); ?> <span class="required_star">*</span></label>
                            <input tabindex="1" type="file" name="userfile" class="form-control"
                                placeholder="<?php echo lang('upload_file'); ?>"
                                value="<?php echo set_value('name'); ?>">
                        </div>

                        <?php if (form_error('userfile')) { ?>
                        <div class="callout callout-danger my-2">
                            <?php echo form_error('userfile'); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                    <i data-feather="upload"></i>
                    <?php echo lang('submit'); ?>
                </button>

                <a class="btn bg-blue-btn me-2" href="<?php echo base_url() ?>customer/downloadPDF/Customer_Upload">
                    <i data-feather="save"></i>
                    <?php echo lang('download_sample'); ?>
                </a>
                <a class="btn bg-blue-btn me-2" href="<?php echo base_url() ?>customer/customers">
                    <i data-feather="corner-up-left"></i>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
  
</section>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/setting.js'); ?>"></script>
<!-- Main content -->
<section class="main-content-wrapper">

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
            <?php echo lang('commonMenuPage'); ?>
        </h3>

    </section>

    <div class="box-wrapper">
    <div class="table-box">
                <?php
                $attributes = array('id' => 'common_menu_page');
                $common_menu_page = isset($company_info->common_menu_page) && $company_info->common_menu_page?json_decode($company_info->common_menu_page):'';
                echo form_open_multipart(base_url('Frontend/commonMenuPage/' . $this->session->userdata('company_id')),$attributes); ?>
                <div class="box-body">
                  
                    <div class="row">

                        <div class="col-sm-12 mb-2 col-md-4">
                            <div class="form-group">
                                <div class="form-label-action">
                                <input type="hidden" name="common_menu_page_banner_old" value="<?php echo isset($common_menu_page->common_menu_page_banner) && $common_menu_page->common_menu_page_banner ? $common_menu_page->common_menu_page_banner : ''; ?>">
                                    <label><?php echo lang('common_menu_page_banner'); ?> (Width: 1920px, Height:1080px )</label>
                                     
                                </div>
                                
                                <table>
                                    <tr>
                                        <td>
                                          <input type="file" id="logo" accept="image/*" name="main_banner" class="form-control">

                                        </td>
                                        <td> 
                                        <a data-file_path="<?php echo base_url()?>uploads/common_menu_page/<?php echo isset($common_menu_page->common_menu_page_banner) && $common_menu_page->common_menu_page_banner ? $common_menu_page->common_menu_page_banner : ''; ?>"  data-id="1" class="new-btn h-40 show_preview" href="#"><i class="fa fa-eye"></i></a> 
                                        </td>
                                    </tr>
                                </table>
                                <i class="color_notice"><?php echo lang('for_stripe_page'); ?></i>
                            </div>
                            <?php if (form_error('common_menu_page_banner')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('common_menu_page_banner'); ?>
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
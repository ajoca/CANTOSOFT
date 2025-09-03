<link rel="stylesheet" href="<?php echo base_url('assets/') ?>buttonCSS/checkBotton.css">
<input type="hidden" value="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://")?>" id="ssl_type">
<section class="main-content-wrapper">
    <input type="hidden" value="https://" id="ssl_type">
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo lang('EditPrinter'); ?>
        </h3>
    </section>



    <div class="box-wrapper">
    
        <div class="table-box">

                <?php
                $attributes = array('id' => 'add_Printer');
                echo form_open_multipart(base_url('Printer/addEditPrinter/' . $encrypted_id), $attributes); ?>
                <div class="box-body">
                    <div class="row">
                    <?php if(isLMni()):?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-group">
                                <label><?php echo lang('outlet'); ?> <span class="required_star">*</span></label>
                                <select name="outlet_id" class="select2 form-control">
                                    <option value=""><?php echo lang('select') ?></option>
                                    <?php 
                                        $outlets = getAllOutlestByAssign();
                                        foreach ($outlets as $value){
                                    ?>
                                    <option <?php echo $printer_->outlet_id == $value->id ? 'selected' : '' ?> value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (form_error('outlet_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('outlet_id'); ?>
                            </div>
                            <?php } ?>
                        </div>
                    <?php
                     else:
                    ?>
                        <input type="hidden" id="outlet_id" name="outlet_id" value="<?php echo $this->session->userdata('outlet_id');?>">
                    <?php
                         endif;
                    ?>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
                            <div class="form-group">
                                <label><?php echo lang('title'); ?> <small>(<?php echo lang('to_identify_printer_easily'); ?>)</small> <span class="required_star">*</span></label>
                                <input tabindex="1" autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo escape_output($printer_->title); ?>">
                            </div>
                            <?php if (form_error('title')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('title'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clear-fix"></div>
                        <div class="mb-3 col-lg-4 col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('printing_choice'); ?> <span class="required_star">*</span></label>
                                <select class="form-control printing select2" id="printing_choice"
                                        name="printing_choice">
                                    <option <?php echo isset($printer_->printing_choice) && $printer_->printing_choice == "web_browser_popup"?"selected":'' ?> <?php echo set_select('printing_choice',"web_browser_popup")?> value="web_browser_popup"><?php echo lang('browser_popup_print'); ?></option>
                                    <option <?php echo isset($printer_->printing_choice) && $printer_->printing_choice == "direct_print"?"selected":'' ?> <?php echo set_select('printing_choice',"direct_print")?> value="direct_print"><?php echo lang('direct_print'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 txt_11 print_server_url_div_invoice">
                            <div class="form-group">
                                <label><?php echo lang('ipvfour_address'); ?> <span
                                            class="required_star">*</span></label>
                                            <a class="pull-right ipv_4_tooltip btn custom_bt_xs link_color" href="<?php echo base_url()?>images/ethernet_wifi.png" target="_blank"><?php echo lang('HowtogetIPv4Address'); ?></a>
                                <input  autocomplete="off" type="text" id="ipvfour_address"
                                        name="ipvfour_address" class="form-control"
                                        placeholder="<?php echo lang('ipvfour_address'); ?>"
                                        value="<?php echo escape_output($printer_->ipvfour_address); ?>"> 
                                        <?php if (form_error('ipvfour_address')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('ipvfour_address'); ?></span>
                                </div>
                            <?php } ?>

                                
                            </div>
                        </div>
                        <div class="mb-3 col-lg-4 col-md-6 print_format_div_invoice">
                            <div class="form-group">
                                <label><?php echo lang('print_format'); ?> <span class="required_star">*</span></label>
                                <select name="print_format" id="print_format" class="select2 form-control">
                                    <option <?php echo isset($printer_->print_format) && $printer_->print_format == "No Print"?"selected":'' ?> value="No Print"><?php echo lang('No_Print'); ?></option>
                                    <option <?php echo isset($printer_->print_format) && $printer_->print_format == "56mm"?"selected":'' ?> value="56mm"><?php echo lang('p56mm'); ?></option>
                                    <option <?php echo isset($printer_->print_format) && $printer_->print_format == "80mm"?"selected":'' ?> value="80mm"><?php echo lang('p80mm'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="cmb-3 col-lg-4 col-md-6 inv_qr_code_status">
                            <div class="form-group">
                                <label><?php echo lang('inv_qr_code_enable_status'); ?> <span class="required_star">*</span></label>
                                <select name="inv_qr_code_status" id="inv_qr_code_status" class="select2 form-control">
                                    <option <?php echo isset($printer_->inv_qr_code_enable_status) && $printer_->inv_qr_code_enable_status == "Disable"?"selected":'' ?> value="Disable"><?php echo lang('disable'); ?></option>
                                    <option <?php echo isset($printer_->inv_qr_code_enable_status) && $printer_->inv_qr_code_enable_status == "Enable"?"selected":'' ?> value="Enable"><?php echo lang('regular_qrcode'); ?></option>
                                    <option <?php echo isset($printer_->inv_qr_code_enable_status) && $printer_->inv_qr_code_enable_status == "Zatca"?"selected":'' ?> value="Zatca"><?php echo lang('zatca_qrcode'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2 div_direct_print">
                            <div class="form-group">
                                <label><?php echo lang('Printer'); ?> <?php echo lang('type'); ?> <span class="required_star">*</span></label>
                                <select class="form-control select2" id="type" name="type">
                                    <option <?php echo isset($printer_->type) && $printer_->type == "network"?"selected":'' ?>  <?php echo set_select('type',"network") ?> value="network"><?php echo lang('network'); ?></option>
                                    <option <?php echo isset($printer_->type) && $printer_->type == "windows"?"selected":'' ?>  <?php echo set_select('type',"windows") ?> value="windows"><?php echo lang('windows'); ?></option>
                                </select>
                            </div>
                            <?php if (form_error('type')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('type'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2 div_direct_print">
                            <div class="form-group">
                                <label><?php echo lang('characters_per_line'); ?> <span class="required_star">*</span></label>
                                
                                <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" autocomplete="off" type="number" name="characters_per_line" class="form-control" placeholder="<?php echo lang('characters_per_line'); ?>" value="<?php echo escape_output($printer_->characters_per_line); ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('printer_per_line_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('characters_per_line')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('characters_per_line'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2 network_div1 div_direct_print">
                            <div class="form-group">
                                <label><?php echo lang('printer_ip_address'); ?> <span class="required_star">*</span></label>
                                
                                <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input tabindex="1" autocomplete="off" type="text" name="printer_ip_address" id="printer_ip_address" class="form-control" placeholder="<?php echo lang('printer_ip_address'); ?>" value="<?php echo escape_output($printer_->printer_ip_address); ?>">

                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('printer_ip_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('printer_ip_address')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('printer_ip_address'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2 network_div1 div_direct_print">
                            <div class="form-group">
                                <label><?php echo lang('printer_port'); ?> <span class="required_star">*</span></label>
                               
                                <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        
                                        <input tabindex="1" autocomplete="off" type="text" name="printer_port" id="printer_port" class="form-control" placeholder="<?php echo lang('printer_port'); ?>" value="<?php echo escape_output($printer_->printer_port); ?>">
                                        </td>
                                        <td> 
                                        <div class="tooltip_custom">
                                        <i data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('printer_port_tooltip'); ?>" data-feather="help-circle"></i>
                                    </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php if (form_error('printer_port')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('printer_port'); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 mb-2 receipt_printer_div txt_11 div_direct_print">
                            <div class="form-group">
                                <label><?php echo lang('path'); ?> <span class="required_star">*</span></label>  <a class="pull-right ipv_4_tooltip btn custom_bt_xs link_color" href="<?php echo base_url()?>images/shareable_path.png" target="_blank"><?php echo lang('printer_path_tooltip'); ?></a>
                                <input tabindex="1" autocomplete="off" type="text" name="path" id="path_string" class="form-control" placeholder="<?php echo lang('path'); ?>" value="<?php echo escape_output($printer_->path); ?>">
                            </div>
                            <?php if (form_error('path')) { ?>
                                <div class="callout callout-danger my-2">
                                    <span class="error_paragraph"><?php echo form_error('path'); ?></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="clearfix"></div>
                            <div class="mb-3 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label> <?php echo lang('open_cash_drawer_when_printing_invoice'); ?> <span
                                                class="required_star">*</span></label>
                                    <select tabindex="12" class="form-control select2" name="open_cash_drawer_when_printing_invoice"
                                            id="open_cash_drawer_when_printing_invoice">

                                        <option
                                            <?= isset($printer_) && $printer_->open_cash_drawer_when_printing_invoice == "No" ? 'selected' : '' ?>
                                                value="No"><?php echo lang('no'); ?></option>
                                        <option
                                            <?= isset($printer_) && $printer_->open_cash_drawer_when_printing_invoice == "Yes" ? 'selected' : '' ?>
                                                value="Yes"><?php echo lang('yes'); ?></option>
                                    </select>
                                </div>
                                <?php if (form_error('open_cash_drawer_when_printing_invoice')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('open_cash_drawer_when_printing_invoice'); ?>
                                    </div>
                                <?php } ?>
                            </div>

                        
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>
                    <div class="ipvfour_address_div div_direct_print me-2">
                        <a target="_blank" class="btn bg-blue-btn test_print" href="javascript:void(0)">
                            <i data-feather="printer"></i>
                            <?php  echo lang('test_print'); ?>
                        </a>                    
                    </div>
                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>printer/printers">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
        </div>

        <br><br>

<div class="row">
    <h3 class="text-center"><?php echo lang('print_server_instruction_title_1'); ?></h3>
    <div class="col-md-6 offset-md-3">
        <section class="alert-wrapper"><div class="alert alert-warning alert-dismissible fade show"> 
                <div class="alert-body"> 
                    
                <a href="https://www.youtube.com/watch?v=NpwOAp3oT3Q" target="_blank" class="printer_server_setting"><?php echo lang('print_server_instruction_title_2'); ?></a> <br>
                <a href="https://www.youtube.com/watch?v=XM9-ofDABJo" target="_blank" class="printer_server_setting"><?php echo lang('print_server_instruction_title_3'); ?></a> <br>
                <a href="https://www.youtube.com/watch?v=KpHdyknH694" target="_blank" class="printer_server_setting"><?php echo lang('print_server_instruction_title_4'); ?></a> <br>
                <a href="https://www.youtube.com/watch?v=V3Ay0JkBEwY" target="_blank" class="printer_server_setting"><?php echo lang('print_server_instruction_title_5'); ?></a>
            </div></div>
       </section>          
    </div>

   
</div>

    </div>
   
   
</section>
<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/printer.js'); ?>"></script>
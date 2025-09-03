<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/sms_setting_update.js'); ?>"></script>
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
            <?php echo lang('sms_settings'); ?>
        </h3>
    </section>



    <div class="box-wrapper">
            <div class="table-box">
            
                <?= form_open(base_url('Authentication/SMSSetting/' . (isset($company_id) && $company_id ? $company_id : '')));
                    $sms_info = isset($sms_information->sms_details) && $sms_information->sms_details?json_decode($sms_information->sms_details):'';
                ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo lang('sms_service_provider')?> <span class="required_star">*</span><small class="show_text"></small></label>
                                <select name="sms_service_provider"  class="form-control select2 sms_service_provider">
                                    <option value="" data-text_singup="" data-signup_url=""><?php echo lang('None')?></option>
                                    <option <?php echo set_select('sms_service_provider',"1")?>  <?=(isset($sms_information->sms_service_provider) && $sms_information->sms_service_provider && $sms_information->sms_service_provider=="1"?'selected':'')?> value="1" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(1)?>"><?php echo lang('Twilio')?></option>
                                    <option <?php echo set_select('sms_service_provider',"2")?>  <?=(isset($sms_information->sms_service_provider) && $sms_information->sms_service_provider && $sms_information->sms_service_provider=="2"?'selected':'')?> value="2" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(2)?>"><?php echo lang('Mobishastra')?></option>
                                </select>
                                <?php if (form_error('sms_service_provider')) { ?>
                                    <div class="alert alert-error txt-uh-21">
                                        <p><?php echo form_error('sms_service_provider'); ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div  class="txt_11 row div_hide div_1">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('SID'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_1_0" value="<?=(isset($sms_info->field_1_0) && $sms_info->field_1_0?$sms_info->field_1_0:set_value('field_1_0'))?>" onfocus="select();" placeholder="<?php echo lang('SID'); ?>" id="field_1_0" class="form-control">
                                </div>
                                <?php if (form_error('field_1_0')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_1_0'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('Token'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_1_1" value="<?=(isset($sms_info->field_1_1) && $sms_info->field_1_1?$sms_info->field_1_1:set_value('field_1_1'))?>" onfocus="select();" placeholder="<?php echo lang('Token'); ?>" id="field_1_1" class="form-control">
                                </div>
                                <?php if (form_error('field_1_1')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_1_1'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('Twilio_Number'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_1_2" value="<?=(isset($sms_info->field_1_2) && $sms_info->field_1_2?$sms_info->field_1_2:set_value('field_1_2'))?>" onfocus="select();" placeholder="<?php echo lang('Twilio_Number'); ?>" id="field_1_2" class="form-control">
                                </div>
                                <?php if (form_error('field_1_2')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_1_2'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div  class="txt_11 row div_hide div_2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('profile_id'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_2_0" value="<?=(isset($sms_info->field_2_0) && $sms_info->field_2_0?$sms_info->field_2_0:set_value('field_2_0'))?>" onfocus="select();" placeholder="<?php echo lang('profile_id'); ?>" id="field_2_0" class="form-control">
                                </div>
                                <?php if (form_error('field_2_0')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_2_0'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_2_1" value="<?=(isset($sms_info->field_2_1) && $sms_info->field_2_1?$sms_info->field_2_1:set_value('field_2_1'))?>" onfocus="select();" placeholder="<?php echo lang('password'); ?>" id="field_2_1" class="form-control">
                                </div>
                                <?php if (form_error('field_2_1')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_2_1'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('sender_id'); ?> <span class="required_star">*</span></label>
                                    <input type="text" name="field_2_2" value="<?=(isset($sms_info->field_2_2) && $sms_info->field_2_2?$sms_info->field_2_2:set_value('field_2_2'))?>" onfocus="select();" placeholder="<?php echo lang('sender_id'); ?>" id="field_2_2" class="form-control">
                                </div>
                                <?php if (form_error('field_2_2')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_2_2'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo lang('country_code'); ?> <span class="required_star">*</span></label>
                                        <select name="field_2_3" id="field_2_3" class="form-control select2">
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+93"?'selected':'')?> value="+93" data-select2-id="10">Afghanistan (+93)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+355"?'selected':'')?> value="+355" data-select2-id="11">Albania (+355)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+213"?'selected':'')?> value="+213" data-select2-id="12">Algeria (+213)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+376"?'selected':'')?> value="+376" data-select2-id="13">Andorra (+376)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+244"?'selected':'')?> value="+244" data-select2-id="14">Angola (+244)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+54"?'selected':'')?> value="+54" data-select2-id="15">Argentina (+54)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+374"?'selected':'')?> value="+374" data-select2-id="16">Armenia (+374)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+297"?'selected':'')?> value="+297" data-select2-id="17">Aruba (+297)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+61"?'selected':'')?> value="+61" data-select2-id="18">Australia (+61)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+43"?'selected':'')?> value="+43" data-select2-id="19">Austria (+43)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+994"?'selected':'')?> value="+994" data-select2-id="20">Azerbaijan (+994)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+973"?'selected':'')?> value="+973" data-select2-id="21">Bahrain (+973)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+880"?'selected':(isset($sms_info->field_2_3)?'':'selected'))?> value="+880" data-select2-id="2">Bangladesh (+880)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+375"?'selected':'')?> value="+375" data-select2-id="22">Belarus (+375)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+32"?'selected':'')?> value="+32" data-select2-id="23">Belgium (+32)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+501"?'selected':'')?> value="+501" data-select2-id="24">Belize (+501)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+229"?'selected':'')?> value="+229" data-select2-id="25">Benin (+229)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+975"?'selected':'')?> value="+975" data-select2-id="26">Bhutan (+975)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+591"?'selected':'')?> value="+591" data-select2-id="27">Bolivia (+591)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+387"?'selected':'')?> value="+387" data-select2-id="28">Bosnia and Herzegovina (+387)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+267"?'selected':'')?> value="+267" data-select2-id="29">Botswana (+267)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+55"?'selected':'')?> value="+55" data-select2-id="30">Brazil (+55)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+673"?'selected':'')?> value="+673" data-select2-id="31">Brunei (+673)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+359"?'selected':'')?> value="+359" data-select2-id="32">Bulgaria (+359)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+226"?'selected':'')?> value="+226" data-select2-id="33">Burkina Faso (+226)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+257"?'selected':'')?> value="+257" data-select2-id="34">Burundi (+257)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+855"?'selected':'')?> value="+855" data-select2-id="35">Cambodia (+855)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+237"?'selected':'')?> value="+237" data-select2-id="36">Cameroon (+237)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+238"?'selected':'')?> value="+238" data-select2-id="37">Cape Verde (+238)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+236"?'selected':'')?> value="+236" data-select2-id="38">Central African Republic (+236)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+235"?'selected':'')?> value="+235" data-select2-id="39">Chad (+235)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+56"?'selected':'')?> value="+56" data-select2-id="40">Chile (+56)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+86"?'selected':'')?> value="+86" data-select2-id="41">China (+86)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+57"?'selected':'')?> value="+57" data-select2-id="42">Colombia (+57)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+269"?'selected':'')?> value="+269" data-select2-id="43">Comoros (+269)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+242"?'selected':'')?> value="+242" data-select2-id="44">Congo (+242)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+682"?'selected':'')?> value="+682" data-select2-id="45">Cook Islands (+682)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+506"?'selected':'')?> value="+506" data-select2-id="46">Costa Rica (+506)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+385"?'selected':'')?> value="+385" data-select2-id="47">Croatia (+385)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+53"?'selected':'')?> value="+53" data-select2-id="48">Cuba (+53)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+357"?'selected':'')?> value="+357" data-select2-id="49">Cyprus (+357)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+420"?'selected':'')?> value="+420" data-select2-id="50">Czech Republic (+420)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+243"?'selected':'')?> value="+243" data-select2-id="51">Democratic Republic of Congo (+243)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+45"?'selected':'')?> value="+45" data-select2-id="52">Denmark (+45)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+253"?'selected':'')?> value="+253" data-select2-id="53">Djibouti (+253)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+593"?'selected':'')?> value="+593" data-select2-id="54">Ecuador (+593)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+20"?'selected':'')?> value="+20" data-select2-id="55">Egypt (+20)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+503"?'selected':'')?> value="+503" data-select2-id="56">El Salvador (+503)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+240"?'selected':'')?> value="+240" data-select2-id="57">Equatorial Guinea (+240)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+372"?'selected':'')?> value="+372" data-select2-id="58">Estonia (+372)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+251"?'selected':'')?> value="+251" data-select2-id="59">Ethiopia (+251)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+500"?'selected':'')?> value="+500" data-select2-id="60">Falkland (Malvinas) Islands (+500)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+298"?'selected':'')?> value="+298" data-select2-id="61">Faroe Islands (+298)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+679"?'selected':'')?> value="+679" data-select2-id="62">Fiji (+679)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+358"?'selected':'')?> value="+358" data-select2-id="63">Finland (+358)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+33"?'selected':'')?> value="+33" data-select2-id="64">France (+33)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+594"?'selected':'')?> value="+594" data-select2-id="65">French Guiana (+594)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+241"?'selected':'')?> value="+241" data-select2-id="66">Gabon (+241)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+220"?'selected':'')?> value="+220" data-select2-id="67">Gambia (+220)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+995"?'selected':'')?> value="+995" data-select2-id="68">Georgia (+995)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+49"?'selected':'')?> value="+49" data-select2-id="69">Germany (+49)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+233"?'selected':'')?> value="+233" data-select2-id="70">Ghana (+233)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+350"?'selected':'')?> value="+350" data-select2-id="71">Gibraltar (+350)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+30"?'selected':'')?> value="+30" data-select2-id="72">Greece (+30)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+299"?'selected':'')?> value="+299" data-select2-id="73">Greenland (+299)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+590"?'selected':'')?> value="+590" data-select2-id="74">Guadeloupe (+590)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+502"?'selected':'')?> value="+502" data-select2-id="75">Guatemala (+502)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+224"?'selected':'')?> value="+224" data-select2-id="76">Guinea (+224)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+245"?'selected':'')?> value="+245" data-select2-id="77">Guinea-Bissau (+245)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+592"?'selected':'')?> value="+592" data-select2-id="78">Guyana (+592)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+509"?'selected':'')?> value="+509" data-select2-id="79">Haiti (+509)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+504"?'selected':'')?> value="+504" data-select2-id="80">Honduras (+504)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+852"?'selected':'')?> value="+852" data-select2-id="81">Hong Kong (+852)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+36"?'selected':'')?> value="+36" data-select2-id="82">Hungary (+36)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+354"?'selected':'')?> value="+354" data-select2-id="83">Iceland (+354)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+91"?'selected':'')?> value="+91" data-select2-id="84">India (+91)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+62"?'selected':'')?> value="+62" data-select2-id="85">Indonesia (+62)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+98"?'selected':'')?> value="+98" data-select2-id="86">Iran (+98)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+964"?'selected':'')?> value="+964" data-select2-id="87">Iraq (+964)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+353"?'selected':'')?> value="+353" data-select2-id="88">Ireland (+353)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+972"?'selected':'')?> value="+972" data-select2-id="89">Israel (+972)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+39"?'selected':'')?> value="+39" data-select2-id="90">Italy (+39)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+225"?'selected':'')?> value="+225" data-select2-id="91">Ivory Coast (+225)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+81"?'selected':'')?> value="+81" data-select2-id="92">Japan (+81)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+962"?'selected':'')?> value="+962" data-select2-id="93">Jordan (+962)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+254"?'selected':'')?> value="+254" data-select2-id="94">Kenya (+254)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+686"?'selected':'')?> value="+686" data-select2-id="95">Kiribati (+686)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+965"?'selected':'')?> value="+965" data-select2-id="96">Kuwait (+965)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+996"?'selected':'')?> value="+996" data-select2-id="97">Kyrgyzstan (+996)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+856"?'selected':'')?> value="+856" data-select2-id="98">Laos (+856)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+371"?'selected':'')?> value="+371" data-select2-id="99">Latvia (+371)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+961"?'selected':'')?> value="+961" data-select2-id="100">Lebanon (+961)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+266"?'selected':'')?> value="+266" data-select2-id="101">Lesotho (+266)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+231"?'selected':'')?> value="+231" data-select2-id="102">Liberia (+231)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+218"?'selected':'')?> value="+218" data-select2-id="103">Libya (+218)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+423"?'selected':'')?> value="+423" data-select2-id="104">Liechtenstein (+423)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+370"?'selected':'')?> value="+370" data-select2-id="105">Lithuania (+370)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+352"?'selected':'')?> value="+352" data-select2-id="106">Luxembourg (+352)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+853"?'selected':'')?> value="+853" data-select2-id="107">Macau (+853)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+389"?'selected':'')?> value="+389" data-select2-id="108">Macedonia (+389)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+261"?'selected':'')?> value="+261" data-select2-id="109">Madagascar (+261)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+265"?'selected':'')?> value="+265" data-select2-id="110">Malawi (+265)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+60"?'selected':'')?> value="+60" data-select2-id="111">Malaysia (+60)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+960"?'selected':'')?> value="+960" data-select2-id="112">Maldives (+960)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+223"?'selected':'')?> value="+223" data-select2-id="113">Mali (+223)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+356"?'selected':'')?> value="+356" data-select2-id="114">Malta (+356)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+596"?'selected':'')?> value="+596" data-select2-id="115">Martinique (+596)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+222"?'selected':'')?> value="+222" data-select2-id="116">Mauritania (+222)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+230"?'selected':'')?> value="+230" data-select2-id="117">Mauritius (+230)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+52"?'selected':'')?> value="+52" data-select2-id="118">Mexico (+52)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+373"?'selected':'')?> value="+373" data-select2-id="119">Moldova (+373)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+377"?'selected':'')?> value="+377" data-select2-id="120">Monaco (+377)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+976"?'selected':'')?> value="+976" data-select2-id="121">Mongolia (+976)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+382"?'selected':'')?> value="+382" data-select2-id="122">Montenegro (+382)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+212"?'selected':'')?> value="+212" data-select2-id="123">Morocco (+212)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+258"?'selected':'')?> value="+258" data-select2-id="124">Mozambique (+258)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+95"?'selected':'')?> value="+95" data-select2-id="125">Myanmar (+95)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+264"?'selected':'')?> value="+264" data-select2-id="126">Namibia (+264)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+977"?'selected':'')?> value="+977" data-select2-id="127">Nepal (+977)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+31"?'selected':'')?> value="+31" data-select2-id="128">Netherlands (+31)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+599"?'selected':'')?> value="+599" data-select2-id="129">Netherlands Antilles (+599)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+64"?'selected':'')?> value="+64" data-select2-id="130">New Zealand (+64)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+505"?'selected':'')?> value="+505" data-select2-id="131">Nicaragua (+505)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+227"?'selected':'')?> value="+227" data-select2-id="132">Niger (+227)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+234"?'selected':'')?> value="+234" data-select2-id="133">Nigeria (+234)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+47"?'selected':'')?> value="+47" data-select2-id="134">Norway (+47)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+968"?'selected':'')?> value="+968" data-select2-id="135">Oman (+968)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+92"?'selected':'')?> value="+92" data-select2-id="136">Pakistan (+92)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+680"?'selected':'')?> value="+680" data-select2-id="137">Palau (+680)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+970"?'selected':'')?> value="+970" data-select2-id="138">Palestine (+970)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+507"?'selected':'')?> value="+507" data-select2-id="139">Panama (+507)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+675"?'selected':'')?> value="+675" data-select2-id="140">Papua New Guinea (+675)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+595"?'selected':'')?> value="+595" data-select2-id="141">Paraguay (+595)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+51"?'selected':'')?> value="+51" data-select2-id="142">Peru (+51)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+63"?'selected':'')?> value="+63" data-select2-id="143">Philippines (+63)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+48"?'selected':'')?> value="+48" data-select2-id="144">Poland (+48)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+351"?'selected':'')?> value="+351" data-select2-id="145">Portugal (+351)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+974"?'selected':'')?> value="+974" data-select2-id="146">Qatar (+974)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+262"?'selected':'')?> value="+262" data-select2-id="147">Reunion (+262)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+40"?'selected':'')?> value="+40" data-select2-id="148">Romania (+40)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+7"?'selected':'')?> value="+7" data-select2-id="149">Russian Federation (+7)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+250"?'selected':'')?> value="+250" data-select2-id="150">Rwanda (+250)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+685"?'selected':'')?> value="+685" data-select2-id="151">Samoa (+685)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+378"?'selected':'')?> value="+378" data-select2-id="152">San Marino (+378)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+239"?'selected':'')?> value="+239" data-select2-id="153">Sao Tome and Principe (+239)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+966"?'selected':'')?> value="+966" data-select2-id="154">Saudi Arabia (+966)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+221"?'selected':'')?> value="+221" data-select2-id="155">Senegal (+221)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+381"?'selected':'')?> value="+381" data-select2-id="156">Serbia (+381)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+248"?'selected':'')?> value="+248" data-select2-id="157">Seychelles (+248)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+232"?'selected':'')?> value="+232" data-select2-id="158">Sierra Leone (+232)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+65"?'selected':'')?> value="+65" data-select2-id="159">Singapore (+65)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+421"?'selected':'')?> value="+421" data-select2-id="160">Slovakia (+421)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+386"?'selected':'')?> value="+386" data-select2-id="161">Slovenia (+386)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+677"?'selected':'')?> value="+677" data-select2-id="162">Solomon Islands (+677)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+252"?'selected':'')?> value="+252" data-select2-id="163">Somalia (+252)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+27"?'selected':'')?> value="+27" data-select2-id="164">South Africa (+27)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+82"?'selected':'')?> value="+82" data-select2-id="165">South Korea (+82)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+211"?'selected':'')?> value="+211" data-select2-id="166">South Sudan (+211)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+34"?'selected':'')?> value="+34" data-select2-id="167">Spain (+34)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+94"?'selected':'')?> value="+94" data-select2-id="168">Sri Lanka (+94)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+249"?'selected':'')?> value="+249" data-select2-id="169">Sudan (+249)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+597"?'selected':'')?> value="+597" data-select2-id="170">Suriname (+597)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+268"?'selected':'')?> value="+268" data-select2-id="171">Swaziland (+268)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+46"?'selected':'')?> value="+46" data-select2-id="172">Sweden (+46)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+41"?'selected':'')?> value="+41" data-select2-id="173">Switzerland (+41)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+963"?'selected':'')?> value="+963" data-select2-id="174">Syria (+963)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+886"?'selected':'')?> value="+886" data-select2-id="175">Taiwan (+886)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+992"?'selected':'')?> value="+992" data-select2-id="176">Tajikistan (+992)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+255"?'selected':'')?> value="+255" data-select2-id="177">Tanzania (+255)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+66"?'selected':'')?> value="+66" data-select2-id="178">Thailand (+66)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+228"?'selected':'')?> value="+228" data-select2-id="179">Togo (+228)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+676"?'selected':'')?> value="+676" data-select2-id="180">Tonga (+676)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+216"?'selected':'')?> value="+216" data-select2-id="181">Tunisia (+216)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+90"?'selected':'')?> value="+90" data-select2-id="182">Turkey (+90)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+993"?'selected':'')?> value="+993" data-select2-id="183">Turkmenistan (+993)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+256"?'selected':'')?> value="+256" data-select2-id="184">Uganda (+256)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+380"?'selected':'')?> value="+380" data-select2-id="185">Ukraine (+380)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+971"?'selected':'')?> value="+971" data-select2-id="186">United Arab Emirates (+971)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+44"?'selected':'')?> value="+44" data-select2-id="187">United Kingdom (+44)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+1"?'selected':'')?> value="+1" data-select2-id="188">United States of America (+1)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+598"?'selected':'')?> value="+598" data-select2-id="189">Uruguay (+598)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+998"?'selected':'')?> value="+998" data-select2-id="190">Uzbekistan (+998)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+678"?'selected':'')?> value="+678" data-select2-id="191">Vanuatu (+678)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+58"?'selected':'')?> value="+58" data-select2-id="192">Venezuela (+58)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+84"?'selected':'')?> value="+84" data-select2-id="193">Vietnam (+84)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+967"?'selected':'')?> value="+967" data-select2-id="194">Yemen (+967)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+260"?'selected':'')?> value="+260" data-select2-id="195">Zambia (+260)</option>
                                            <option <?=(isset($sms_info->field_2_3) && $sms_info->field_2_3 && $sms_info->field_2_3=="+263"?'selected':'')?> value="+263" data-select2-id="196">Zimbabwe (+263)</option>
                                    </select>
                                </div>
                                <?php if (form_error('field_2_3')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <?php echo form_error('field_2_3'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Short_message_service/smsService">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('go_to_send_sms_page'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
    </div>
   
   
</section>

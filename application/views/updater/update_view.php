<?php
$wl = getWhiteLabel();
$system_logo = '';
if($wl){
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->footer){
        $footer = $wl->footer;
    }
    if($wl->system_logo){
        $system_logo = base_url()."images/".$wl->system_logo;
    }
}
//get company information
$getCompanyInfo = getCompanyInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Update Status || <?php echo escape_output($site_name)?></title>
    <!-- Favicon -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">

    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/jquery-ui/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/updater.css">
</head>

<body>

    <div id="update">
        <div class="update">
            <div class="update-txt">
                <h1>HOORAH!</h1>
                <h2 id="ci_message" style="color:<?php echo escape_output($color)?>;"><?php echo escape_output($message)?></h2>
            </div>
            <?php if(isset($update_url)):?>
                <a id="ci_update_now" class="prevent_default" href="<?php echo escape_output($update_url)?>">UPDATE NOW</a>
            <?php endif;?>
            <?php if(isset($whats_new) && !empty($whats_new)): ?>
                <div class="whats_new">
                    
                    <h1>Changes in this version</h1>
                    <ol>
                    <?php foreach($whats_new as $sinlge_line): ?>
                        <li><?php echo escape_output($sinlge_line)?></li>
                    <?php  endforeach; ?>
                    </ol>
                </div>
            <?php  endif; ?>

            <a class="back_to_login" href="<?php echo(base_url())?>dashboard/dashboard">⟵ Go to Dashboard</a>
        </div>
        
    </div>

</body>

<script src="<?php echo base_url(); ?>frequent_changing/js/updater.js"></script>
</html>

<?php


    $getWhiteLabel = json_decode(isset($company_info->white_label) && $company_info->white_label?$company_info->white_label:'');


    $site_name = '';
    $site_footer = '';
    $site_logo = '';
    if($getWhiteLabel){
        if($getWhiteLabel->site_name){
            $site_name = $getWhiteLabel->site_name;
        }
        if($getWhiteLabel->footer){
            $site_footer = $getWhiteLabel->footer;
        }
    
        if($getWhiteLabel->system_logo){
            $site_logo = base_url()."images/".$getWhiteLabel->system_logo;
        }
        
    }
    $businessname = $company_info->business_name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Gmail-specific CSS */
        .rectangle-parent {
            background-color: #143157;
            padding-top: 15px;
            padding-bottom: 15px;
            margin: 0 auto;
        }
        .frame-child {
            display: none;
        }
        /* Hide the frame */
        .welcome-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .welcome-to {
            margin: 0;
            color: #ffffff;
        }
        .welcome-container {
            float: left;
        }
        .content-email-icon {
            height: auto;
            width: 100%;
            max-width: 82.6px;
            float: right;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f7f7f8;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0"
                    style="margin: auto;">
                    <tr>
                        <td>
                            <div class="rectangle-parent">
                                <div class="frame-child"
                                    style="height: 155px; width: 578px; position: relative; background-color: #143157; max-width: 100%; z-index: 0;">
                                </div>
                                <div class="bg"
                                    style="height: 100%; width: 100%; position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 1; margin: 0;">
                                </div>
                                <div class="welcome-wrapper">
                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                        border="0">
                                        <tr>
                                            <td align="left" style="padding-left: 20px;">
                                                <div class="welcome-container">
                                                    <p class="welcome-to" style="font-style: normal;font-weight: 600;font-size: 32px;line-height: 120%;"><?php echo escape_output($businessname);?></p>
                                                </div>
                                            </td>
                                            <td align="right" style="padding-right: 20px;">
                                                <img class="content-email-icon" alt="company-logo" src="<?php echo $site_logo;?>" width="82.6">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px 20px 0px 20px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="middle">
                                        <h1 style="font-size: 28px; color: #121a26; margin: 0;">Payment Link</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding: 10px 0;">
                                        <p style="font-size: 16px; color: #494f5a;">
                                            <b>Dear, <?php echo escape_output($user_name);?></b><br>
                                            <?php echo ($message); ?>
                                        </p>
                                        <a style="background: #1b3056;color: white; padding: 10px; border-radius: 4px; font-size: 15px; font-weight:600;text-decoration: none;" href="<?php echo base_url();?>payment-now/<?php echo encryptDecrypt($pay_com_id, 'encrypt') ?>">Payment Now</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

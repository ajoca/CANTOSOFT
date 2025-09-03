<!DOCTYPE html>
<?php
//getting base url for actual path
$root=$_SERVER["HTTP_HOST"];
$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$base_url = $root;
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Server Setting</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <link rel="shortcut icon" href="logo/favicon.ico" type="image/x-icon">
    <link rel="icon" href="logo/favicon.ico" type="image/x-icon">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/dist/css/common.css">
    <link rel="stylesheet" href="assets/dist/css/custom/login.css">
    <style>
        .bg-blue-btn, .bg-red-btn {
            color: white;
            text-decoration: none;
            padding: 8.5px 21px !important;
            border-radius: 0.358rem !important;
            font-weight: 500;
            font-size: 14px;
            text-transform: capitalize;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .bg-blue-btn {
            background-color: #7367f0;
        }
        .bg-blue-btn:hover {
            color: white;
        }

    </style>
</head>

<body class="loginPage">
<div class="row">
    <input type="hidden" id="base_url" value="<?php echo $base_url?>">
    <h1 style="text-align: center">Print Server Setting</h1>

        <form>
          <div class="row">
              <div class="form-group">
                  <input tabindex="2" type="text" id="ethernet_ip"  name="ethernet_ip" class="form-control" placeholder="IPv4 Address" value="">
                  <small><i style="color:red;padding-left: 12px;"> Eg: IPv4 Address: <b>192.168.0.105</b> (<a target="_blank" href="logo/ethernet_wifi.png">How to get IPv4 Address?</a> )</i></small>
              </div>
              <div class="form-group">
                  <select class="form-control" name="connection_type" id="connection_type">
                      <option value="https://">https</option>
                      <option value="http://">http</option>
                  </select>
                  <small><i style="color:red;padding-left: 12px;">If your server URL is like https://yourwebsite.com/ then select https</i></small><br>
                  <small><i style="color:red;padding-left: 12px;">If your server URL is like http://yourwebsite.com/ then select http</i></small><br>
              </div>


              <div class="form-group">
                  <select class="form-control" name="type" id="type">
                      <option value="">Printer Type</option>
                      <option value="network">Network Printer</option>
                      <option value="windows">USB Printer</option>
                  </select>
              </div>

              <div class="form-group">
                  <input tabindex="2" type="text" id="ip_share_text"  name="ip_share_text" class="form-control" placeholder="Printer IP Address / Share Name" value="">
                  <small><i style="color:red;padding-left: 12px;">
                          Printer IP Address (For Network Printer) e.g: <b>192.168.1.87</b><br>&nbsp;&nbsp;
                          Share Name (For USB Printer) e.g: <b>Door Soft Printer</b> (<a target="_blank" href="logo/shareable_path.png">How to get Share Name?</a> )</i></small>
              </div>
              <div class="form-group div_network">
                  <input tabindex="3" type="text" id="port_address"  name="port_address" class="form-control" placeholder="Printer Port Address" value="">
                  <small>
                      <i style="color:red;padding-left: 12px;">
                          In maximum case the Printer Port Address is 9100 but in case it is different <br>&nbsp;&nbsp;&nbsp;please do a test print from your printer after turning it on, you will get the <br>&nbsp;&nbsp;Printer Port Address in that test print paper.
                      </i></small>
              </div>
              <small style="text-align: center"><i style="color:red;padding-left: 12px;"> Before click <b>Test Print</b>, please check- (<a target="_blank" href="logo/click_here_for_test_print.png">Click Here</a> )</i></small>
              <a href="#" class="btn bg-blue-btn set_url">Test Print</a>
           </div>
        </form>

    <div class="clearfix"></div>
</div>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $(function () {
        "use strict";
        function set_show_hide() {
            let this_value = $("#type").val();
            if(this_value=="network"){
                $(".div_network").show();
            }else{
                $(".div_network").hide();
            }
        }
        $(document).on('change', '#type', function(e){
            set_show_hide();
        });
        $(document).on('click', '.set_url', function(e){
           let ethernet_ip = $("#ethernet_ip").val();
           let connection_type = $("#connection_type").val();
           let type = $("#type").val();
           let ip_share_text = $("#ip_share_text").val();
           let port_address = $("#port_address").val();
           let base_url = $("#base_url").val();

            $("#ethernet_ip").css("border","1px solid #d2d6de");
            $("#ip_share_text").css("border","1px solid #d2d6de");
            $("#port_address").css("border","1px solid #d2d6de");
            $("#base_url").css("border","1px solid #d2d6de");

            if(ethernet_ip==''){
                $("#ethernet_ip").css("border","3px solid red");
                $("#ethernet_ip").focus();
                return false;
            }else if(type==''){
                $("#type").css("border","3px solid red");
                $("#type").focus();
                return false;
           } else if(ip_share_text==''){
                $("#ip_share_text").css("border","3px solid red");
                $("#ip_share_text").focus();
                return false;
           }else if (port_address=='' && type=="network"){
                $("#port_address").css("border","3px solid red");
                $("#port_address").focus();
                return false;
           }else{
               let url_redirect = connection_type+ethernet_ip+"/print_server/print.php?printer_type_value="+ip_share_text+"&&port="+port_address+"&&type="+type;
               window.open(url_redirect, '_blank');
           }

        });
        set_show_hide();
    });
</script>
</body>

</html>
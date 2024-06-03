<?php
if(!isset($oDB))
    include "classDB.php";


class Usuario extends baseDatos{
    var $resuRegistro;
    var $cap;
    function action($cual){
        $result="";
        switch($cual){
            case 'ranking':
            break;
            case 'perfil':
            case'formEdit':
                $registro = $this -> getRecord("SELECT * FROM usuario where id_usuario = ".$_REQUEST['Id']."");
                $result = $this->generarFormulario($registro);
                break;
            case'formNew':
                $result = $this->generarFormulario(null);
                break;   
            case'update':
                if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["correo"]) || empty($_POST["password"])) {
                    $this->error = 'Error al actualizar: Asegurate de no dejar campos vacios.';
                    $result = $this->action("report");
                } else if($_POST["captcha_registro"] == $this->resuRegistro || empty($_POST["captcha_registro"])){
                    $this->error = 'Error al actualizar: Error en el captcha.';
                    $result = $this->action("report");
                }else{                    
                    $sql = "UPDATE usuario SET nombre='" . $_POST['nombre'] . "', apellidos='" . $_POST['apellidos'] . "', correo='" . $_POST['correo'] . "', contrasena=PASSWORD('" . $_POST['password'] . "') WHERE id_usuario=" . $_POST['Id'];
                    $this->query($sql);
                    $result = $this->action("report");           
                }
                break;
            case'insert':
                if (empty($_POST["nombre"]) || empty($_POST["apellidos"]) || empty($_POST["correo"])|| empty($_POST["password"])) {
                    $this->error = 'Error al actualizar: Asegurate de no dejar vacios los campos.';
                    $result = $this->action("report");
                } else if($_POST["captcha_registro"] == $this->resuRegistro || empty($_POST["captcha_registro"])){
                    $this->error = 'Error al actualizar: Error en el captcha.';
                    $result = $this->action("report");
                }else{ 
                    $this->InsertarNuevo();
                    $result = $this->action("report");
                }
                break;           
            case'report':
                $result = $this->despTablaDatos("SELECT id_usuario as Id, UPPER(CONCAT(apellidos, ' ', nombre)) as Nombre,  correo FROM Usuario order by Nombre;");               
                break;
            case'delete':
                $this->query("DELETE FROM usuario WHERE id_usuario=".$_POST['Id']);
                $result = $this->action("report");
                break;
            case 'blank':
                break;    
        }
        return $result;
    }
    function despTablaDatos($query){
        $flag = true;
        $html='<div class = "container mt-4"><table class = "table table-striped table-hover fs-6 font-monospace table-bordered border-dark">';
        $this->query($query);

        //Cabecera
        $datoss= "<tr>";
        $campos = array();
        //$datoss.= '<td class="text-center table-dark">ELIMINAR</td><td class="text-center table-dark">EDITAR</td>';
        $datoss.= '<td class="text-center table-dark">&nbsp;</td><td class="text-center table-dark fs-6">Ver</td>';
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            ($flag) ? $datoss.='<td hidden>'.($campo)."</td> " : $datoss.= '<td class="center table-dark ">'.strtoupper($campo).'</td>';
            $flag = false;
            //$datoss.= '<td class="center table-dark ">'.strtoupper($campo).'</td>';
        }
        $datoss.= "</tr>";
        $header = '<span class="badge bg-darkP p-3 m-2">'.strtoupper($tablaNombre).
        '</span><button type="button"class = "btn  btnPersonalizadoP bg-successP p-2 m-2" onclick="usuarioss(\'formNew\')" style = "width: 80px"> <i class="bi bi-plus-square-fill"></i> </button>';
        //Fin cabecera  
        $flag = true;

        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            //Iconos de accion
            $datoss .= '<td class="col-1 text-center"><button class = "btn btn-sm btn-danger" onclick="usuarioss(\'delete\','.$row['Id'].',\''.$row['Nombre'].' \')">
                        <i class="bi bi-trash"></i></button>
                        </td>';

            $datoss .= '<td class="con-1 text-center "><button class = "btn btn-sm btn-success" onclick="usuarioss(\'formEdit\','.$row['Id'].',\''.$row['Nombre'].' \')">
                        <i class="bi bi-eye-fill"></i></button>
                        </td>';
            foreach ($row as $datos) {
                ($flag) ? $datoss.='<td hidden>'.($datos)."</td> " : $datoss.='<td>'.($datos)."</td>";
                $flag = false;
                //$datoss.='<td>'.($datos)."</td> ";
            }
            $flag = true;
            $datoss.="</tr>";
        }
        $datoss.="</table></div>";
        $header .= (isset($this->error) ? '<div class="alert alert-danger" role="alert">'.$this->error.'</div>' : '');
        return $html.$header.$datoss;
    }

    //Funcion para el formulario de Edit o Nuevo
    function generarFormulario($registro){
        $result = '<div class="container mt-5">
                <div class="row nm-row">
                <div class="form-container border border-dark border-5 rounded p-4 bg-white">';
        $result .= '<div class="form-container border border-info border-3 rounded p-4">
                <div class="header text-center">
                    <h2>Registro</h2>
                    <br>
                </div>
                <form method="post" id = "formUsuario" onsubmit="return usuarioss'.(isset($registro) ? '(\'update\')' : '(\'insert\')'). ';">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input required type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="'.(isset($registro) ? $registro->nombre : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="apellidos">Apellidos</label>
                        <input required type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="'.(isset($registro) ? $registro->apellidos : '').'">
                    </div>
                                                     
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required type="email" class="form-control" id="correo" name="correo" placeholder="Email" value="'.(isset($registro) ? $registro->correo : '').'">
                    </div>';

                    $result.='<div class="form-group">
                        <label for="password">Contraseña</label>
                        <input required type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password2">Confirma la contraseña</label>
                        <input required type="password" class="form-control" id="password2" name="password2" placeholder="******">
                    </div>
                    <div class="form-group">
                        <label for="captcha_registro">Captcha</label>
                        
                        <input required type="text" class="form-control" id="captcha_registro" name="captcha_registro" placeholder="Cuanto es '.$this->cap=$this->captcha($this->resuRegistro)."   ".$this->resuRegistro.'">
                        <input type="hidden" name="capchaHidden" id= "capchaHidden" value="'.$this->resuRegistro.'">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="hidden" name="action" id="action" value="'.(isset($registro) ?  "update" : "insert").'">
                        <button type="submit" id="buttondisable" onClick="return usuarioss(\'valiForm\')" class="btn btnPersonalizado bg-warningP">'.(isset($registro) ? "ACTUALIZAR" : "REGISTRAR  ").'&nbsp;<i class="bi bi-pencil-fill"></i></button>    
                        </div>'
                    .(isset($registro) ? '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">' : '').'
                </form> 
                <div class="d-flex  justify-content-center align-items-center p-4">
                    <span id="mensaje" class="badge bg-danger"s></span>
                </div>


            </div>';
        $result .= '</div> </div> </div><br>';
        return $result;
    }

    //Funcion Insertar
    function InsertarNuevo(){
        $consultaCorreo = $this->getRecord("SELECT * FROM usuario WHERE correo = '".$_POST['correo']."'");
        if ($consultaCorreo) {
            $this->error = "El correo electrónico ya está registrado.";
        } else {
            $nuevPWD="";
            $nuevPWD=$_POST['password']; 
            $cad="INSERT INTO usuario SET nombre='".$_POST['nombre']."', apellidos='".$_POST['apellidos']."', correo='".$_POST['correo']."', contrasena=password('".$nuevPWD."')";
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
            $mail->From="GatoTrack";
            $mail->FromName="GatoTrack";
            $mail->Subject = "Registro completo";
            $mail->MsgHTML("<h1>BIENVENIDO ".$_POST['nombre']." ".$_POST['apellidos']."</h1><h2> tu clave de acceso es : ".$nuevPWD."</h2>");
            $mail->AddAddress($_POST['correo']);
            //$mail->AddAddress("admin@admin.com");
            if (!$mail->Send()){ 
                $this->error ="No se pudo Completar el Registro"; 
            }
            else {
                $this->query($cad);
                $this->error ="Registro Exitoso"; 
            }
        }
    }

    //Funciones para generar el capcha
    function captcha(&$resu){
        $dig1 = rand(1, 9);
        $dig2 = rand(1, 9);
        $dig3 = rand(1, 9);  
        // Definir un array de operadores
        $operadores = ['+', '-', '*'];
        $oper1 = $operadores[array_rand($operadores)];
        $oper2 = $operadores[array_rand($operadores)];
      
        $resu=$this->resuelve($dig1,$dig2, $oper1);
        $resu=$this->resuelve($resu,$dig3, $oper2);
        // Crear la cadena de operación
        $cap = $dig1.$oper1.$dig2.$oper2.$dig3;
        return $cap;
    }
    function resuelve($dig1, $dig2, $ope){
        if($ope=='+')return $dig1+$dig2;
        else if($ope=='-')return $dig1-$dig2;
        else if($ope=='*')return $dig1*$dig2;
    } 
}

//var_dump($_POST);
//print_r();
$oUsuario=new Usuario();
if(isset($_REQUEST['action'])){
    echo $oUsuario ->action($_REQUEST['action'] );
}
else 
  echo $oUsuario->action('report');
<?
session_start();
session_unset();

function captcha(&$palabra){
    // Definir un arreglo de palabras
    $palabras = array(
    "gato", "perro", "ratón", "elefante", "tigre",
    "árbol", "flor", "río", "montaña", "océano",
    "coche", "bicicleta", "avión", "barco", "tren",
    "manzana", "naranja", "plátano", "uva", "sandía",
    "sol", "luna", "estrella", "planeta", "galaxia",
    );
    // Seleccionar una palabra al azar del arreglo
    $palabra = $palabras[array_rand($palabras)];
    return  $palabra;
}

$resuLogin=$resuRegistro=$resuContra="";
$cap1=captcha($resuLogin);
$cap2=captcha($resuRegistro);
$cap3=captcha($resuContra);
// Calcular el resultado
$_SESSION['capt_login']=$resuLogin;
$_SESSION['capt_record']=$resuRegistro;
$_SESSION['capt_contra']=$resuContra;

?>

<!DOCTYPE html>
<html lang="es-mx"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GastoTrack</title>
	<!-- // logo -->
	<link href="./IMG/Logo.svg" rel="icon">
	<link href="./CSS/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./CSS/bootstrap.css">
	<link href="./CSS/custom.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="./controllers/acceso.js?0.02"></script>
</head>

<body>
    <main class="d-flex">
        <div class="container main-container">
            <div class="row nm-row">
                <div class="col-lg-6 nm-bgi d-none d-lg-flex">
                    <div class="overlay">
                        <div class="hero-item hero-item-1">
                            <h2>LLeva el registo de tus gastos</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 nm-mb-1 nm-mb-md-1 nm-aic">
                    <div class="card">
                        <div class="card-content">
                            <div class="header">
                                <img src="./IMG/Logo.svg" class="imgLogo" alt="Logo">
                                <br>
                                <p class="h2 text-success">GastoTrack 1.0</p>
                            </div>
                            <div class="section pb-5 pt-5 pt-sm-2 text-center">
                                <div class='text-center'>
                                    <h6 class="mb-0 pb-3"><span><strong> LOG IN &nbsp&nbsp&nbsp</strong></span><span><strong>SIGN UP</strong></span></h6>
                                </div>
                                <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                                <label for="reg-log"></label>
                                
                                <div class="card-3d-wrap mx-auto d-flex justify-content-center align-items-center">
                                    <div class="card-3d-wrapper" style="margin-top:-500px;">
                                        <!--Login-->
                                        <div class="card-front">
                                            <form method="post"  id="Formlogin" onsubmit="return accesoss('login')" >
                                                <div class="form-group">
                                                    <label>Correo</label>
                                                    <div class="input-group nm-gp">
                                                        <input required name="txtCorreo" type="email" id="txtCorreo" class="form-control"  style="text-align-last: center;">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Clave</label>
                                                    <div class="input-group nm-gp">
                                                        <input name="txtClave" type="password" id="txtClave" class="form-control"  style="text-align-last: center;">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Captcha</label>
                                                    <div class="input-group nm-gp">
                                                        <input name="txtCaptcha" type="text" id="txtCaptcha" class="form-control"  placeholder="Escribe:  <?=$cap1;?>"  style="text-align-last: center;">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="action" value="login" >
                                                <!--Contraseña Olvidada-->
                                                <div class="row nm-mb-1 nm-mt-1 justify-content-center">                              
                                                    <div class="col-md-4 col-12">            
                                                        <a class="nm-ft-bmodal text-success" href="#" data-toggle="modal" data-target="#modalRecuperar"><strong>¿Olvidaste la contraseña?</strong></a>                                  
                                                    </div>
                                                </div>
                                                <button type="submit"  name="btnIniciar" id="BtnIniciar" class="btn btn-block btn-success">Ingresar</button>               
                                                <br>     
                                            </form>
                                        </div>
                                        <!--SignUp-->
                                        <div class="card-back">
                                            <form method="post"  id="Formrecord" onsubmit="return accesoss('record')">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <div class="input-group nm-gp">
                                                        <span class="nm-gp-pp"><i class="fas fa-lock"></i></span>
                                                        <input name="txtNuevoNombre" type="text" id="txtNombre" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Apellidos</label>
                                                    <div class="input-group nm-gp">
                                                        <span class="nm-gp-pp"><i class="fas fa-lock"></i></span>
                                                        <input name="txtNuevoApellidos" type="text" id="txtApellidos" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Correo</label>
                                                    <div class="input-group nm-gp">
                                                        <span class="nm-gp-pp"><i class="fas fa-user"></i></span>
                                                        <input required name="txtNuevoCorreo" type="email" id="txtNuevoCorreo" class="form-control" style="text-transform: lowercase;">
                                                    </div>
                                                </div>                        
                                                <div class="form-group">
                                                    <label>Captcha</label>
                                                    <div class="input-group nm-gp">
                                                        <input name="txtCaptcha2" type="text" id="txtCaptcha2" class="form-control"  placeholder="Escribe:  <?=$cap2;?>"  style="text-align-last: center;">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="action" value="record" >   
                                                <button type="submit" name="btnCrear" id="btnCrear" class="btn btn-block btn-success">Registrarse</button>               
                                            </form>
                                        </div>
                                    </div>
                                </div>                         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </main>


    <div class="modal fade" id="modalRecuperar" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="modalReplicacionLabel">Recuperar contraseña</h5>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return accesoss('password')" id="Formpassword">
                        <input type="" name="action" value="retrievePwd" hidden>
                        <div class="form-group text-center">
                            <label >Email</label>
                            <div class="input-group nm-gp">
                                <span class="nm-gp-pp"><i class="fas fa-lock"></i></span>
                                <input type="email" class="form-control" id="emailReplicacion" name="emailReplicacion" placeholder="Email">
                            </div>    
                        </div>
                        <div class="form-group text-center">
                            <label for="captcha_replicacion">Captcha</label>
                            <div class="input-group nm-gp">
                                <span class="nm-gp-pp"><i class="fas fa-lock"></i></span>
                                <input type="text" class="form-control" id="captcha_replicacion" name="captcha_replicacion" placeholder="Escribe:  <?=$cap3;?>">
                                <input type="hidden" name="action" value="password" >   
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btnPersonalizado bg-successP" name="btnPass" id="btnPass">Enviar</button>
                            <button type="submit" class="btn btnPersonalizado bg-dangerP" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- // Vendor JS files -->
    <script src="./JS/jquery-3.6.0.min.js"></script>
    <script src="./JS/bootstrap.bundle.min.js"></script>
    <script src="./JS/jquery-confirm.js"></script>
    <script src="./JS/custom.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>


    <!-- Vendor JS files // -->

</body>
</html>
var ventFrame;
var ventFrame1;
function accesoss(cual){
    switch(cual){
        case 'login': case 'record': case 'password':
            datos = $('#Form'+cual).serialize();
            $.ajax({url:"./class/classAcceso.php", 
                type: "post", 
                data: datos,
                success: function(result) {
                    console.log(result)
                    if (result == 'admin') {
                        window.location.href = "./Admin/home.php";
                    } else if (result == 'user') {
                        window.location.href = "./User/home.php";
                    } else if (result == 1) {
                        alerta("Error","Credenciales incorrectas",'red');
                    } else if (result == 2) {
                        alerta("Error","Asegurate de no dejar campos vacios","orange");
                    } else if (result == 3) {
                        alerta("Error en el captcha","Asegurate de escribir la palabra correctamente",'orange');
                    }  else if (result == 5) {
                        alerta("Duplicacion de correo","El correo ingresado ya esta registrado",'orange');
                    } else if (result == 6) {
                        alerta("Error de registro","Ocurrio un error en el registro del usuario",'red');
                    } else if (result == 7) {
                        alerta("Revisa tu correo","Se a enviado tu clave de acceso a tu correo [Revisa la carpeta de spam]");
                    }else if (result == 9) {
                        alerta("El correo no esta registrado","Intenta crear una cuenta", "orange");
                    } else if (result == 10) {
                        alerta("Recuperación Completa","En tu correo encontraras tu nueva contraseña");
                    }}});
                return false;
            break;
        default: alert("La opcion '" + cual + "', No existe en accesoss.js");
    }
}
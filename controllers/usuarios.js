var ventFrame;
var ventFrame1;
function usuarioss(cual, id, texto){
    if(typeof(id)=="undefined")
        id= 0;
    switch (cual) {
            case 'perfil':           
            case'formEdit':  
                $.dialog({
                    title: 'Editar',
                    columnClass:"col-7",
                    type:"orange",                
                    content: 'url:../class/classUsuarios.php?action=' + cual+"&Id="+id,
                    onContentReady: function () { ventFrame1 = this; }
                });
            break;

            case "update":
                datos = $("#formUsuario").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classUsuarios.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){
                        //console.log(html);
                        areaTrabajoUsuarios.innerHTML = html;
                        ventFrame1.close();
                    }
                });
                return false
            break;
            
          case "formNew":
                $.dialog({
                    title: 'Agregar',
                    columnClass: "col-7",
                    type: "green",
                    content: 'url:../class/classUsuarios.php?action=formNew', 
                    onContentReady: function () { ventFrame = this; }
                });
            break;

            case "insert":
                datos = $("#formUsuario").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classUsuarios.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){
                        areaTrabajoUsuarios.innerHTML = html;
                        ventFrame.close();
                    }
                });
                return false 
            break;

            case "delete":
                $.confirm({
                    title: 'Estas seguro de Borrar',
                    content:'El registro: '+id + "  " + texto,
                    type:"red",
                    columnclass: "col-6",
                    buttons: {
                        confirm: function () {
                            $.ajax ({url:"../class/classUsuarios.php", 
                                type:"post", 
                                data:{action:cual, Id:id},
                                success: function(html){
                                    areaTrabajoUsuarios.innerHTML = html;                              
                                    alerta("Aviso", "El registro se borro!!!")
                                }
                            });
                        },
                        cancel:function(){$.alert("No borrado");}
                    }    
                })
            break;

            case "valiForm": 
            mensaje.innerHTML=""
                if(password.value==password2.value && password.value>""){
                    if(captcha_registro.value>"" && captcha_registro.value==capchaHidden.value )
                        return true
                    else{
                        mensaje.innerHTML="Error en el capcha"
                        return false
                    }
                }else{
                    mensaje.innerHTML="Clave incorrecta o No duplicada"
                    return false
                }
            break;
            default: alert("La opcion '"+cual+"', No existe en usuarioss.js");
    }
}

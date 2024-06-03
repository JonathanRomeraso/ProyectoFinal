var ventFrame;
var ventFrame1;
function transaccionss(cual, id, id_transaccion, texto){
    if(typeof(id)=="undefined")
        id= 0;
    switch (cual) {
            case'formEdit':  
            console.log(cual + "&Id=" + id+ "&Id_transaccion=" + id_transaccion+"&texto="+texto);
                $.dialog({
                    title: 'Editar',
                    columnClass: "col-7",
                    type: "orange",
                    content: 'url:../class/classTransaccion.php?action=' + cual + "&Id=" + id+ "&Id_transaccion=" + id_transaccion+"&texto="+texto,
                    onContentReady: function () { ventFrame1 = this; }
                });
            break;

            case "update":
                datos = $("#formTransaccion").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classTransaccion.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        ventFrame1.close();
                        areaTrabajoTransaccion.innerHTML = html;
                    }
                });
                return false 
            break;
            
            case "formNew":
                console.log(cual + "&Id=" + id+ "&Id_transaccion=" + id_transaccion+"&texto="+texto);
                $.dialog({
                    title: 'Agregar',
                    columnClass: "col-7",
                    type: "green",
                    content: 'url:../class/classTransaccion.php?action=' + cual + "&Id=" + id,
                    onContentReady: function () { ventFrame = this; }
                });
            break;

            case "insert":
                datos = $("#formTransaccion").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classTransaccion.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        ventFrame.close();
                        areaTrabajoTransaccion.innerHTML = html;
                    }
                });
                return false 
            break;

            case "delete":
            $.confirm({
                title: 'Estas seguro de Borrar',
                content:'El moviento: '+id_transaccion + " del dia:  " + texto,
                type:"red",
                columnclass: "col-6",
                buttons: {
                    confirm: function () {
                        $.ajax ({url:"../class/classTransaccion.php", 
                            type:"post", 
                            data:{action:cual, Id:id, Id_transaccion:id_transaccion},
                            success: function(html){
                                areaTrabajoTransaccion.innerHTML = html;
                                alerta("Aviso", "El registro se borro!!!")
                            }
                        });
                    },
                    cancel:function(){  $.alert("No borrado"); }
                }    
            })
            break;

            case "valiForm": ;
            mensaje.innerHTML=""
            if (metodo.value != 1) {
                if (institucion.value != 1 && institucion.value != 2) {
                    return true;
                }else{
                    mensaje.innerHTML="Seleccionar una institucion si el metodo no es efectivo "
                    return false
                }
            } else {
                if (institucion.value == 1 || institucion.value == 2) {
                    return true;
                }
                else{
                    mensaje.innerHTML="No seleccionar una institucion si el metodo es efectivo "
                    return false
                }
            }
            break;
        default: alert("La opcion '"+accion+"', No existe en usuarioss.js");
    }
    
}

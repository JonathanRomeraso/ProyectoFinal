var ventFrame;
var ventFrame1;
function metodoss(cual, id, texto){
    if(typeof(id)=="undefined")
        id= 0;
    switch (cual) {
            case'formEdit':  
                $.dialog({
                    title: 'Editar',
                    columnClass: "col-7",
                    type: "orange",
                    content: 'url:../class/classMetodos.php?action=' + cual + "&Id=" + id,
                    onContentReady: function () { ventFrame1 = this; }
                });
            break;

            case "update":
                datos = $("#formPalabras").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classMetodos.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        ventFrame1.close();
                        areaTrabajoMetodos.innerHTML = html;
                    }
                });
                return false 
            break;
            
            case "formNew":
                $.dialog({
                    title: 'Agregar',
                    columnClass: "col-7",
                    type: "green",
                    content: 'url:../class/classMetodos.php?action=formNew', 
                    onContentReady: function () { ventFrame = this; }
                });
            break;

            case "insert":
                datos = $("#formPalabras").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classMetodos.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        ventFrame.close();
                        areaTrabajoMetodos.innerHTML = html;
                    }
                });
                return false 
            break;

            case "delete":
            $.confirm({
                title: 'Estas seguro de Borrar',
                content:'El registro: '+id + "- " + texto,
                type:"red",
                columnclass: "col-6",
                buttons: {
                    confirm: function () {
                        $.ajax ({url:"../class/classMetodos.php", 
                            type:"post", 
                            data:{action:cual, Id:id},
                            success: function(html){
                                areaTrabajoMetodos.innerHTML = html;
                                alerta("Aviso", "El registro se borro!!!")
                            }
                        });
                    },
                    cancel:function(){ $.alert("No borrado"); }
                }    
            })
            break;
            
            case "valiForm": ;
            mensaje.innerHTML=""
                if(inputPalabra.value>""){
                    return true
                }else{
                    mensaje.innerHTML="Asegurate de llenar Todos los campos"
                    //alert("Asegurate de llenar Todos los campos");
                    return false
                }
                break;
            default: alert("La opcion '"+accion+"', No existe en usuarioss.js");
    }
    
}
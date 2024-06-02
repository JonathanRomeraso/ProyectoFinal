var ventFrame;
var ventFrame1;
function categoriass(cual, id, id_categoria, texto){
    if(typeof(id)=="undefined")
        id= 0;
    switch (cual) {
            case'formEdit':  
                $.dialog({
                    title: 'Editar',
                    columnClass: "col-7",
                    type: "Mio",
                    content: 'url:../class/classCategoria.php?action=' + cual + "&Id=" + id+ "&IdCategoria=" + id_categoria,
                    onContentReady: function () { ventFrame1 = this; }
                });
            break;

            case "update":
                datos = $("#formCategoria").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classCategoria.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){
                        console.log(html) 
                        ventFrame1.close();
                        areaTrabajoCategoria.innerHTML = html;
                    }
                });
                return false 
            break;
            
            case "formNew":
                $.dialog({
                    title: 'Agregar',
                    columnClass: "col-7",
                    type: "Mio",
                    content: 'url:../class/classCategoria.php?action=formNew', 
                    onContentReady: function () { ventFrame = this; }
                });
            break;

            case "insert":
                datos = $("#formCategoria").serialize();
                buttondisable.disabled = true;
                $.ajax ({url:"../class/classCategoria.php", 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        ventFrame.close();
                        areaTrabajoCategoria.innerHTML = html;
                    }
                });
                return false 
            break;

            case "delete":
            //Confirmar si se borra
            $.confirm({
                title: 'Estas seguro de Borrar',
                content:'El registro: '+id + "- " + texto,
                type:"red",
                columnclass: "col-6",
                buttons: {
                    confirm: function () {
                        $.ajax ({url:"../class/classCategoria.php", 
                            type:"post", 
                            data:{action:cual, Id:id},
                            success: function(html){
                                areaTrabajoCategoria.innerHTML = html;
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
                if(inputCategoria.value>""){
                    return true
                }else{
                    //mensaje.innerHTML="Clave incorrecta o No duplicada"
                    alert("Asegurate de llenar Todos los campos");
                    return false
                }
                break;
            default: alert("La opcion '"+accion+"', No existe en usuarioss.js");
    }
    
}
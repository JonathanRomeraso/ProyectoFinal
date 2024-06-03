var ventFrame;
var ventFrame1;
function reportess(cual, id, fecha, mes){
    if(typeof(id)=="undefined")
        id= 0;
    switch (cual) {
            case "searchDia":
                datos = $("#formDia").serialize();
                $.ajax ({url:'../class/classReporte.php?action=' + cual + "&Id=" + id, 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        reporte.innerHTML = html;
                    }
                });
                return false 
            break;

            case "reportMes":
                datos = $("#formMes").serialize();
                $.ajax ({url:'../class/classReporte.php?action=' + cual + "&Id=" + id, 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        reporte.innerHTML = html;
                    }
                });
                return false 
            break;
            
            case "reportAnio":
                datos = $("#formAnio").serialize();
                $.ajax ({url:'../class/classReporte.php?action=' + cual + "&Id=" + id, 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        reporte.innerHTML = html;
                    }
                });
                return false 
            break;

            case "reportDay":
                datos = $("#formDiaR").serialize();
                $.ajax ({url:'../class/classReporte.php?action=' + cual + "&Id=" + id, 
                    type:"post", 
                    data:datos,
                    success: function(html){ 
                        console.log(datos);
                        reporte.innerHTML = html;
                    }
                });
                return false 
            break;


        default: alert("La opcion '"+accion+"', No existe en usuarioss.js");
    }
    
}

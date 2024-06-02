
function alerta(titulo, contenido, tipo = "green", ancho="small"){
    $.alert({title:titulo, content:contenido, type:tipo, columnClass: ancho})
}
<?php
/*
Comportamiento de validar
*/
if(!isset($oDB))
    include "classDB.php";

class institucion extends baseDatos{
    function action($cual){
        $result="";
        switch($cual){
            case'formEdit':
                $registro = $this -> getRecord("SELECT * FROM institucion where id_institucion = ".$_REQUEST['Id']."");
            case'formNew':
                $result = ' <div class="container mt-5">
                            <div class="row nm-row">
                            <div class="form-container border border-dark border-5 rounded p-4 bg-white">';
                $result .= '<form method="post"  id = "formPalabras"  class="form-container border border-dark border-3 rounded p-4" onsubmit="return institucioness'.(isset($registro) ? '(\'update\')' : '(\'insert\')').';">';
                $result .= (isset($registro) ? '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">' : '');
                $result .= '<h4 class="mb-4">'.(isset($registro) ? "EDITAR INSTITUCION" : "AGREGAR INSTITUCION").'</h4>';
                $result .= '<div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="inputPalabra" class="form-label">INSTITUCION</label>
                                        <input type="text" class="form-control" id="inputPalabra" placeholder="institucion" name="institucion" value="'.(isset($registro) ? $registro->institucion : '').'">
                                    </div>
                                </div>';
                $result .= '<div class="row mt-3">
                                    <div class="col-md-8">
                                        <input type="hidden" name="action" value="'.(isset($registro) ? "update" : "insert").'">
                                        <button type="submit" id="buttondisable" onClick="return institucioness(\'valiForm\')" class="btn btnPersonalizado bg-successP">'.(isset($registro) ? "ACTUALIZAR" : "REGISTRAR").'</button>
                                    </div>
                                </div>
                            </div>';
                $result .= '</form>
                <div class="d-flex  justify-content-center align-items-center p-4">
                    <span id="mensaje" class="badge bg-danger"s></span>
                </div>';
                $result .= '</div> </div> </div>';
                break;
            case'update':
                if(empty($_POST['institucion'])) {
                    $this->error = 'Error al actualizar: El campo INSTITUCION es obligatorio.';
                    $result = $this->action("report");
                } else {
                    $this->query("UPDATE institucion set institucion='".$_POST['institucion']."' where id_institucion=".$_POST['Id']);
                    $result = $this->action("report");
                }
                break;
            case'insert':
                if(empty($_POST['institucion'])) {
                    $this->error = "Error al insertar: El campo INSTITUCION es obligatorio.";
                    $result = $this->action("report");
                } else {
                    $this->query("INSERT into institucion set institucion='".$_POST['institucion']."'");
                    $result = $this->action("report");
                }
                break;           
            case'report':
                $result = $this->despTablaDatos("SELECT * FROM institucion order by institucion");
                break;
            case'delete':
                $this->query("DELETE FROM institucion WHERE id_institucion=".$_POST['Id']);
                $result = $this->action("report");
                break;
            case 'blank':
                break;    
        }
        return $result;
    }
    function despTablaDatos($query){
        $html='<div class = "container mt-4"><table class = "table table-striped table-hover fs-4 font-monospace table-bordered border-dark">';
        $this->query($query);

        //Cabecera
        $datoss= "<tr>";
        $campos = array();
        $datoss.= '<td class="text-center table-dark">ELIMINAR</td><td class="text-center table-dark">EDITAR</td>';
        //$datoss.= '<td >&nbsp;</td><td>&nbsp;</td>';
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            $datoss.= '<td class="fs-4 center table-dark ">'.strtoupper($campo).'</td>';
        }
        $datoss.= "</tr>";
        $header = '<span class="badge bg-darkP p-3 m-2">'.strtoupper($tablaNombre).
        '</span><button class = "btn  btnPersonalizadoP bg-successP p-2 m-2" onclick="institucioness(\'formNew\')" style = "width: 80px"> <i class="bi bi-plus-square-fill"></i></button>';
        //Fin cabecera  

        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            //Iconos de accion
            $datoss .= '<td class="col-1 text-center">
                            <button class = "btn btn-sm btn-danger" onclick="institucioness(\'delete\','.$row['id_institucion'].',\''.$row['institucion'].' \')">
                            <i class="bi bi-trash"></i></button>
                        </td>';
            $datoss .= '<td class="con-1 text-center "><button class = "btn btn-sm btn-warning" onclick="institucioness(\'formEdit\','.$row['id_institucion'].',\''.$row['institucion'].' \')">
                        <i class="bi bi-pencil"></i></button></td>';
            foreach ($row as $datos) {
                $datoss.='<td>'.strtoupper($datos)."</td> ";
            }
            $datoss.="</tr>";
        }
        $datoss.="</table></div>";
        $header .= (isset($this->error) ? '<div class="alert alert-danger" role="alert">'.$this->error.'</div>' : '');
        return $html.$header.$datoss;
    }

}

//var_dump($_POST);
//print_r();
$oPalabra=new institucion();
if(isset($_REQUEST['action'])){
    echo $oPalabra ->action($_REQUEST['action'] );
}
else 
  echo $oPalabra->action('report');
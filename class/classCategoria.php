<?php
if(!isset($oDB))
    include "classDB.php";

class Categoria extends baseDatos{
    public $accion2;
    function action($cual){
        if (isset($this->accion2)){$cual=$this->accion2;} 
        $result="";
        switch($cual){
            case'formEdit':
                $registro = $this -> getRecord("SELECT * FROM categoria where id_categoria = ".$_REQUEST['IdCategoria']." and id_usuario= ".$_REQUEST['Id']."");
            case'formNew':
                $result = ' <div class="container mt-5">
                            <div class="row nm-row">
                            <div class="form-container border border-dark border-5 rounded p-4 bg-white">';
                $result .= '<form method="post" id = "formCategoria" class="form-container border border-dark border-3 rounded p-4" onsubmit="return categoriass'.(isset($registro) ? '(\'update\')' : '(\'insert\')').';">';
                $result .= (isset($registro) ? '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">' : '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">');
                $result .= (isset($registro) ? '<input type="hidden" name="IdCategoria" value="'.$_REQUEST['IdCategoria'].'">' : '');
                $result .= '<h4 class="mb-4">'.(isset($registro) ? "EDITAR CATEGORÍA" : "AGREGAR CATEGORÍA").'</h4>';
                $result .= '<div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="inputCategoria" class="form-label">CATEGORÍA</label>
                                        <input type="text" required class="form-control" id="inputCategoria" placeholder="Nombre de la categoría" name="Categoria" value="'.(isset($registro) ? $registro->categoria : '').'">
                                    </div>
                                    <div class="col-md-8">
                                        <label for="inputCategoria" class="form-label">DESCRIPCION</label>
                                        <input type="text" required class="form-control" id="inputDescripcion" placeholder="Nombre de la categoría" name="Descripcion" value="'.(isset($registro) ? $registro->descripcion : '').'">
                                    </div>
                                </div>';
                $result .= '<div class="row mt-3">
                                    <div class="col-md-8">
                                        <input type="hidden" name="action" value="'.(isset($registro) ? "update" : "insert").'">
                                        <button type="submit" id="buttondisable" onClick="return categoriass(\'valiForm\')" class="btn btnPersonalizado bg-successP">'.(isset($registro) ? "ACTUALIZAR" : "REGISTRAR").'</button>
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
                if(empty($_POST['Categoria']) || empty($_POST['Descripcion'])) {
                    $this->error = 'Error al actualizar: Asegurate de llenar todos los campos.';
                    $result = $this->action("reportAll");
                } else {
                    $this->query("UPDATE Categoria set categoria='".$_POST['Categoria']."', descripcion='".$_POST['Descripcion']. "' where id_categoria=".$_POST['IdCategoria']);
                    $_SESSION['id'] = $_POST['Id'];
                    $result = $this->action("reportAll");
                }
                break;
            case'insert':
                if(empty($_POST['Categoria'])|| empty($_POST['Descripcion'])) {
                    $this->error = 'Error al actualizar: Asegurate de llenar todos los campos.';
                    $result = $this->action("reportAll");
                } else {
                    $_SESSION['id'] = $_POST['Id'];
                    $this->query("INSERT into Categoria set categoria='".$_POST['Categoria']."', descripcion='".$_POST['Descripcion']."', id_usuario='".$_REQUEST['Id']."'");
                    $result = $this->action("reportAll");
                }
                break;           
            case'report':
                $result = $this->despTablaDatosNoEdit("SELECT id_categoria, categoria FROM categoria  where id_usuario = ".$_SESSION['id']." order by categoria limit 1;");
                break;
            case'delete':
                $this->query("DELETE FROM Categoria WHERE id_categoria=".$_POST['Id_categoria']." AND id_usuario=".$_POST['Id']);
                $_SESSION['id'] = $_POST['Id'];
                $result = $this->action("reportAll");
                break;
            case 'blank':
                break;
            case'reportAll':
                $result = $this->despTablaDatos("SELECT id_categoria, categoria FROM categoria  where id_usuario = ".$_SESSION['id']." order by categoria;");
            break;    
        }
        return $result;
    }
    function despTablaDatos($query){
        $flag = true;
        $html='<div class="row">   <div class="col-md-8 col-sm-12">
                    <h2 class="tm-block-title d-inline-block">Categorias Creadas</h2>
                </div>
                <div class="col-md-4 col-sm-12 text-right">
                    <a class="btn btn-small btn-primary" onclick="categoriass(\'formNew\','.$_SESSION['id'].')" >Nueva Categoria</a>
                </div>
                <table class="table table-hover table-striped mt-3"> <tbody>';
        $this->query($query);
        $datoss= "";     
        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            foreach ($row as $datos) {
                ($flag) ? $datoss.='<td hidden>'.($datos)."</td> " : $datoss.='<td>'.strtoupper($datos)."</td>";
                $flag = false;
            }
            $datoss .= '<td class="con-1 text-center "><button class = "btn btn-sm btn-warning" onclick="categoriass(\'formEdit\','.$_SESSION['id'].',\''.$row['id_categoria'].'\')">
                        <i class="bi bi-pencil"></i></button>
                        </td>';
            $datoss .= '<td class="col-1 text-center"><button class = "btn btn-sm btn-danger" onclick="categoriass(\'delete\','.$_SESSION['id'].',\''.$row['id_categoria'].'\',\'' . $row['categoria'] .'\')">
                        <i class="bi bi-trash"></i></button>                      
                        </td>';                        
            $flag = true;
            $datoss.="</tr>";
        }
        $datoss.="</tbody> </table></div> ";
        return $html.$datoss;
    }
    function despTablaDatosNoEdit($query){
        $flag = true;
        $html=' <div class="col-md-8 col-sm-12">
                    <h2 class="tm-block-title d-inline-block">Categorias Creadas</h2>
                </div>
                <table class="table table-hover table-striped mt-3"> <tbody>';
        $this->query($query);
        $datoss= "";     
        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            foreach ($row as $datos) {
                ($flag) ? $datoss.='<td hidden>'.($datos)."</td> " : $datoss.='<td>'.strtoupper($datos)."</td>";
                $flag = false;
            }                      
            $flag = true;
            $datoss.="</tr>";
        }
        $datoss.="</tbody> </table> ";
        return $html.$datoss;
    }


}

$oCategoria=new Categoria();
if(isset($_REQUEST['action'])){
    echo $oCategoria ->action($_REQUEST['action'] );
}
else {
    if(isset($accion)){$oCategoria->accion2 = $accion;}
    echo $oCategoria->action('report');
}
    
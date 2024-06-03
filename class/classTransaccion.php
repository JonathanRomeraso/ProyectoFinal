<?php
/*
Comportamiento de validar
*/
if(!isset($oDB))
    include "classDB.php";

class Torneos extends baseDatos{
    public $accion2;
    function action($cual){
        if (isset($this->accion2)){$cual=$this->accion2;} 
        $result="";
        switch($cual){
            case'formEdit':
                $registro = $this -> getRecord("SELECT * FROM transaccion where id_transaccion = ".$_REQUEST['Id_transaccion']." AND id_usuario=".$_REQUEST['Id']);
                $result = $this->generarFormulario($registro);
                break;
            case'formNew':
                $result = $this->generarFormulario(null);
                break;
            case 'update':
                if (empty($_POST["fecha"]) || empty($_POST["monto"]) || empty($_POST["movimiento"]) || empty($_POST["categoria"]) || empty($_POST["metodo"])) {
                    $this->error = 'Error al actualizar: Asegúrate de no dejar campos obligatorios vacíos.';
                     $result = $this->action("reportAll"); 
                } else {
                    $sql = "UPDATE transaccion SET 
                            fecha='" . $_POST['fecha'] . "', 
                            monto='" . $_POST['monto'] . "', 
                            descripcion='" . $_POST['descripcion'] . "', 
                            id_movimiento='" . $_POST['movimiento'] . "', 
                            id_categoria='" . $_POST['categoria'] . "', 
                            id_metodo_pago='" . $_POST['metodo'] . "', 
                            id_institucion='" . $_POST['institucion'] . "' 
                            WHERE id_transaccion = " . $_POST['Id_transaccion'];                   
                    $this->query($sql);
                    $_SESSION['id'] = $_POST['Id'];
                    $result = $this->action("reportAll");
                }
            break;
            case 'insert':
                if (empty($_POST["fecha"]) || empty($_POST["monto"]) || empty($_POST["movimiento"]) || empty($_POST["categoria"]) || empty($_POST["metodo"])) {
                    $this->error = 'Error al insertar: Asegúrate de no dejar campos obligatorios vacíos.';
                    $result = $this->action("reportAll");
                } else {
                    $sql = "INSERT INTO transaccion (id_usuario, fecha, monto, descripcion, id_movimiento, id_categoria, id_metodo_pago, id_institucion) 
                            VALUES ('". $_POST['Id'] . "', '" . $_POST['fecha'] . "', '" . $_POST['monto'] . "', '" . $_POST['descripcion'] . "', 
                            '" . $_POST['movimiento'] . "', '" . $_POST['categoria'] . "', '" . $_POST['metodo'] . "', '" . $_POST['institucion'] . "')";
                    
                    $this->query($sql);
                    $_SESSION['id'] = $_POST['Id'];
                    $result = $this->action("reportAll");
                }
            break;                     
            case'report':
                $result = $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                where t.id_usuario  = ".$_SESSION['id'].
                                                " order by 2 desc limit 1;");               
                break;
            case'delete':
                $this->query("DELETE FROM transaccion WHERE id_transaccion=".$_POST['Id_transaccion']);
                $_SESSION['id'] = $_POST['Id'];
                $result = $this->action("reportAll");
                break;
            case 'blank':
                break;    
            case'reportAll':
                $result = $this->despTablaDatos("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                where t.id_usuario  = ".$_SESSION['id'].
                                                " order by 2 desc;"); 
            break; 
        }
        return $result;
    }
    function despTablaDatos($query){
        $flag = true;
        $html='<div class="row">
                <div class="col-md-8 col-sm-12">
                    <h2 class="tm-block-title d-inline-block">Tus Transacciones</h2>
                </div>
                <div class="col-md-4 col-sm-12 text-right">
                    <a class="btn btn-small btn-primary" onclick="transaccionss(\'formNew\','.$_SESSION['id'].')">Registrar</a>
                </div>
                </div>
            <table class="table table-hover table-striped tm-table-striped-even mt-3">  <thead>';
        $this->query($query);

        //Cabecera
        $datoss= '<tr class="tm-bg-gray">';
        $campos = array();
        $datoss.= '<th scope="col" class="text-center">&nbsp;</th><th scope="col" class="text-center tm-logout-icon2">Ver</th>';
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            ($flag) ? '<td hidden>'."</td> " :$datoss.= '<th scope="col" class="text-center tm-logout-icon2">'.strtoupper($campo).'</th>';
            $flag = false;
        }
        $datoss.= "</tr></thead>";
        //Fin cabecera  
        $flag = true;
        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            //Iconos de accion
            $datoss .= '<th scope="col" class="text-center"><button class = "btn btn-sm btn-danger" onclick="transaccionss(\'delete\','.$_SESSION['id'].',\''.$row['id_transaccion'].'\',\'' . $row['fecha'] .'\')">
                        <i class="bi bi-trash"></i></button>
                        </th>';

            $datoss .= '<th scope="col" class="text-center"><button class="btn btn-sm btn-success" onclick="return transaccionss(\'formEdit\', '.$_SESSION['id'].', \''.$row['id_transaccion'].'\', '.(isset($this->accion2) ? '\'reportAll\'' : '\'\'').');">';
            $datoss .= '<i class="bi bi-eye-fill"></i></button>
                        </th>';
            foreach ($row as $datos) {
                ($flag) ? $datoss.='<td hidden>'.($datos)."</td> " :$datoss.='<th scope="col" class="text-center tm-logout-icon2">'.($datos)."</th>";
                $flag = false;
            }
            $flag = true;
            $datoss.="</tr>";
        }
        $datoss.="</table></div>";
        return $html.$datoss;
    }
    function despTablaDatosNoEdit($query){
        $flag = true;
        $html='<table class="table table-hover table-striped tm-table-striped-even mt-3">  <thead>';
        $this->query($query);

        //Cabecera
        $datoss= '<tr class="tm-bg-gray">';
        $campos = array();
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            ($flag) ? '<td hidden>'."</td> " :$datoss.= '<th scope="col" class="text-center tm-logout-icon2">'.strtoupper($campo).'</th>';
            $flag = false;
        }
        $datoss.= "</tr></thead>";
        //Fin cabecera  
        $flag = true;
        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';

            foreach ($row as $datos) {
                ($flag) ? $datoss.='<td hidden>'.($datos)."</td> " :$datoss.='<th scope="col" class="text-center tm-logout-icon2">'.($datos)."</th>";
                $flag = false;
            }
            $flag = true;
            $datoss.="</tr>";
        }
        $datoss.="</table></div>";
        return $html.$datoss;
    }
    //Funcion para el formulario de Edit o Nuevo
    function generarFormulario($registro){
        $result = '<div class="container mt-5">
                <div class="row nm-row">
                <div class="form-container border border-dark border-5 rounded p-4 bg-white">';
        $result .= '<div class="form-container border border-info border-3 rounded p-4">
                <div class="header text-center">
                    <h2>Nuevo Registro</h2>
                    <br>
                </div>
                <form method="post" id = "formTransaccion" onsubmit="return transaccionss'.(isset($registro) ? '(\'update\')' : '(\'insert\')').';">  
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input required type="date"" class="form-control" id="fecha" name="fecha" placeholder="fecha" value="'.(isset($registro) ? $registro->fecha : '').'"min="'.date('Y-m-d').'">
                    </div>
                    <div class="form-group ">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="" value="'.(isset($registro) ? $registro->descripcion : '').'">
                    </div> 
                    <div class="form-group ">
                        <label for="monto"> Monto</label>
                        <input required type="number" class="form-control" id="monto" name="monto" min="0.0" placeholder="$$" value="'.(isset($registro) ? $registro->monto : '').'">
                    </div>  ';

                    $registro = $this->getRecord("SELECT id_movimiento, movimiento FROM movimiento");
                    $result .= '<div class="form-group"> 
                                    <label for="movimiento">Movimiento</label>
                                    <select id="movimiento" name="movimiento" class="form-control" style="padding-top: 5px; padding-bottom: 5px;">';
                    foreach ($this->a_bloqRegistros as $row) {
                        $id_movimiento = $row['id_movimiento'];
                        $movimiento = $row['movimiento'];
                        $result .= '<option value="' . $id_movimiento . '">' . $movimiento . '</option>';
                    }
                    $result .= '</select></div>';

                    $registro = $this->getRecord("SELECT id_categoria, categoria FROM categoria where id_usuario=".$_REQUEST['Id']);
                    $result .= '<div class="form-group"> 
                                    <label for="categoria">Categoría</label>
                                    <select id="categoria" name="categoria" class="form-control" style="padding-top: 5px; padding-bottom: 5px;">';
                    foreach ($this->a_bloqRegistros as $row) {
                        $id_categoria = $row['id_categoria'];
                        $categoria = $row['categoria'];
                        $result .= '<option value="' . $id_categoria . '">' . $categoria . '</option>';
                    }
                    $result .= '</select></div>';

                    $registro = $this->getRecord("SELECT id_metodo_pago, metodo_pago FROM metodo_pago");
                    $result .= '<div class="form-group"> 
                                    <label for="metodo">Método de Pago</label>
                                    <select id="metodo" name="metodo" class="form-control" style="padding-top: 5px; padding-bottom: 5px;">';
                    foreach ($this->a_bloqRegistros as $row) {
                        $id_metodo_pago = $row['id_metodo_pago'];
                        $metodo_pago = $row['metodo_pago'];
                        $result .= '<option value="' . $id_metodo_pago . '">' . $metodo_pago . '</option>';
                    }
                    $result .= '</select></div>';

                    $registro = $this->getRecord("SELECT id_institucion, institucion FROM institucion");
                    $result .= '<div class="form-group"> 
                                    <label for="institucion">Institución</label>
                                    <select id="institucion" name="institucion" class="form-control" style="padding-top: 5px; padding-bottom: 5px;">';
                    foreach ($this->a_bloqRegistros as $row) {
                        $id_institucion = $row['id_institucion'];
                        $institucion = $row['institucion'];
                        $result .= '<option value="' . $id_institucion . '">' . $institucion . '</option>';
                    }
                    $result .= '</select></div>';
             

        $result .= '                                                   
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="hidden" name="action" value="'.((isset($registro) && isset($_REQUEST['Id_transaccion'])) ? "update" : "insert").'" >
                        <button type="submit" id="buttondisable" onClick="return transaccionss(\'valiForm\')" class="btn btnPersonalizado bg-warningP">'.((isset($registro) && isset($_REQUEST['Id_transaccion'])) ? "ACTUALIZAR" : "REGISTRAR  ").'&nbsp;<i class="bi bi-pencil-fill"></i></button>    
                    </div>'
                    .((isset($registro) && isset($_REQUEST['Id_transaccion'])) ? '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">' : '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">')
                    .((isset($registro) && isset($_REQUEST['Id_transaccion'])) ? '<input type="hidden" name="Id_transaccion" value="'.$_REQUEST['Id_transaccion'].'">' : '')
                    .((isset($registro) && isset($_REQUEST['Id_transaccion'])) ? '<input type="hidden" name="todo" value="'.$_REQUEST['texto'].'">' : '').'
                </form> 
                <div class="d-flex  justify-content-center align-items-center p-4">
                    <span id="mensaje" class="badge bg-danger"s></span>
                    <span id="cerrado" name = "cerrado"></span>
                </div>
            </div>';
        $result .= '</div> </div> </div><br>';
        return $result;
    }
}

//var_dump($_POST);
//print_r();
if (!isset($oTorneos))
    $oTorneos=new Torneos();

if(isset($_REQUEST['action'])){
    if(isset($accion2)){$oTorneos->accion2 = $accion2;}
    echo $oTorneos ->action($_REQUEST['action'] );
}
else {
    if(isset($accion2)){$oTorneos->accion2 = $accion2;}
  echo $oTorneos->action('report');
}
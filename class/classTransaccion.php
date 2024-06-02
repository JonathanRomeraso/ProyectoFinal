<?php
/*
Comportamiento de validar
*/
if(!isset($oDB))
    include "classDB.php";

class Torneos extends baseDatos{
    var $resuRegistro;
    public $accion2;
    function action($cual){
        if (isset($this->accion2)){$cual=$this->accion2;} 
        $result="";
        switch($cual){
            case'formEdit':
                $registro = $this -> getRecord("SELECT * FROM torneo where Id_torneo = ".$_REQUEST['Id']."");
                $result = $this->generarFormulario($registro);
                break;
            case'formNew':
                $result = $this->generarFormulario(null);
                break;
            case'update':
                if (empty($_POST["fecha"]) || empty($_POST["costo"]) || empty($_POST["tiempo"]) || 
                    empty($_POST["hora"]) || empty($_POST["premio"]) || empty($_POST["rondas"]) || 
                    empty($_POST["meta"]) || empty($_POST["limite"]) || empty($_POST["letras"])) {
                        $this->error = 'Error al actualizar: Asegurate de no dejar vacios los campos.';
                        $result = $this->action("report");
                }else{                   
                    //$this->query("UPDATE Usuario SET nombre='".$_POST['nombre']."', apellidos='".$_POST['apellidos']."', genero='" . $_POST['genero'] . "', Id_tipo_usuario='" . $_POST['tipoUsuario'] . "', email='" . $_POST['correo'] . "' WHERE Id_torneo=" . $_POST['Id']); clave=password('".$nuevPWD."'),
                    $sql = "UPDATE torneo SET fecha='" . $_POST['fecha'] . "', costo='" . $_POST['costo'] . "', tiempoRonda='" . $_POST['tiempo'] . "', horaInicio='" . $_POST['hora'] . 
                    "', premio='" . $_POST['premio'] . "', numeRondasMaximas='" . $_POST['rondas'] ."', puntosMeta='" . $_POST['meta'] ."', fechaLimitePago='" . $_POST['limite'] ."', Letras='" . $_POST['letras'] .  "'WHERE Id_torneo = " . $_POST['Id'];
                    $this->query($sql);
                    echo '<script>';
                    echo 'document.getElementById("cerrado").text = "cerrado";';
                    echo '</script>';
                    $result = $this->action("report");
                }            
            break;
            case'insert':
                if (empty($_POST["fecha"]) || empty($_POST["costo"]) || empty($_POST["tiempo"]) || 
                    empty($_POST["hora"]) || empty($_POST["premio"]) || empty($_POST["rondas"]) || 
                    empty($_POST["meta"]) || empty($_POST["limite"]) || empty($_POST["letras"])) {
                        $this->error = 'Error al actualizar: Asegurate de no dejar vacios los campos.';
                        $result = $this->action("report");
                }else{ 
                    $this->query("INSERT INTO torneo (`fecha`, `costo`, `tiempoRonda`, `horaInicio`, `premio`, `numeRondasMaximas`, `puntosMeta`, `fechaLimitePago`, `Letras`) 
                    VALUES ('" . $_POST['fecha'] . "', '" . $_POST['costo'] . "', '" . $_POST['tiempo'] . "', '" . $_POST['hora'] . "', '" 
                    . $_POST['premio'] . "', '" . $_POST['rondas'] . "', '" . $_POST['meta'] . "', '" . $_POST['limite'] . "', '" . $_POST['letras'] . "')");
                    $result = $this->action("report");
                }
                break;           
            case'report':
                $result = $this->despTablaDatos("SELECT fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_transaccion
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                order by 1 desc limit 1;");               
                //$result = $this->despTablaDatos("SELECT * FROM Usuario order by Nombre");
                break;
            case'delete':
                $this->query("DELETE FROM torneo WHERE Id_torneo=".$_POST['Id']);
                $result = $this->action("report");
                break;
            case 'blank':
                break;    
            case'reportAll':
                $result = $this->despTablaDatos("SELECT fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_transaccion
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                order by 1 desc;"); 
            break; 
        }
        return $result;
    }
    function despTablaDatos($query){

        $html='<table class="table table-hover table-striped tm-table-striped-even mt-3">  <thead>';
        $this->query($query);

        //Cabecera
        $datoss= '<tr class="tm-bg-gray">';
        $campos = array();
        $datoss.= '<th scope="col" class="text-center">&nbsp;</th><th scope="col" class="text-center tm-logout-icon2">Ver</th>';
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            $datoss.= '<th scope="col" class="text-center tm-logout-icon2">'.strtoupper($campo).'</th>';
        }
        $datoss.= "</tr></thead>";
        //Fin cabecera  

        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';
            //Iconos de accion
            $datoss .= '<th scope="col" class="text-center"><button class = "btn btn-sm btn-danger" onclick="torneoss(\'delete\','.$_SESSION['id'].',\''.$row['fecha'].' \')">
                        <i class="bi bi-trash"></i></button>
                        </th>';

            $datoss .= '<th scope="col" class="text-center"><button class = "btn btn-sm btn-success" onclick="return torneoss(\'formEdit\','.$_SESSION['id'].',\''.$row['fecha'].' \')">
                        <i class="bi bi-eye-fill"></i></button>
                        </th>';
            foreach ($row as $datos) {
                $datoss.='<th scope="col" class="text-center tm-logout-icon2">'.($datos)."</th>";
            }
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
                    <h2>Torneo</h2>
                    <br>
                </div>
                <form method="post" id = "formTorneo" onsubmit="return torneoss'.(isset($registro) ? '(\'update\')' : '(\'insert\')').';">
                    <div class="form-group">
                        <label for="fecha">Fecha Realización</label>
                        <input required type="date"" class="form-control" id="fecha" name="fecha" placeholder="fecha" value="'.(isset($registro) ? $registro->fecha : '').'"min="'.date('Y-m-d').'">
                    </div>
                    <div class="form-group ">
                        <label for="costo">Costo Inscripcion</label>
                        <input required type="number" class="form-control" id="costo" name="costo" min="0.0" placeholder="$$" value="'.(isset($registro) ? $registro->costo : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="tiempo">Minutos por Ronda</label>
                        <input required type="number" class="form-control" id="tiempo" name="tiempo" min="2" placeholder="Minutos" value="'.(isset($registro) ? $registro->tiempoRonda : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="hora">Comienzo</label>
                        <input required type="time" class="form-control" id="hora" name="hora" placeholder="Hora Inicio" value="'.(isset($registro) ? $registro->horaInicio : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="premio">Premio a dar</label>
                        <input required type="number" class="form-control" id="premio" name="premio" min="0.0" placeholder="Premio" value="'.(isset($registro) ? $registro->premio : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="rondas">Rondas Maximas</label>
                        <input required type="number" class="form-control" id="rondas" name="rondas" min="1" placeholder="Numero rondas" value="'.(isset($registro) ? $registro->numeRondasMaximas : '').'">
                    </div>
                    <div class="form-group ">
                        <label for="meta">Meta de puntos a alcanzar</label>
                        <input required type="number" class="form-control" id="meta" name="meta" min="1" placeholder="Puntos" value="'.(isset($registro) ? $registro->puntosMeta : '').'">
                    </div>
                    <div class="form-group">
                        <label for="Limite">Fecha limite de Pago</label>
                        <input required type="date"" class="form-control" id="limite" name="limite" placeholder="Fecha limite" value="'.(isset($registro) ? $registro->fechaLimitePago : '').'"min="'.date('Y-m-d').'">
                    </div>
                    <div class="form-group ">
                        <label for="letras">Letras para las Rondas</label>
                        <input required type="text" class="form-control" id="letras" name="letras" placeholder="Ingresa separado por comas ej: A, B, C" value="'.(isset($registro) ? $registro->Letras : '').'">
                    </div>                                         
                    <div class="d-flex justify-content-center align-items-center">
                        <input type="hidden" name="action" value="'.(isset($registro) ? "update" : "insert").'" >
                        <button type="submit" id="buttondisable" onClick="return torneoss(\'valiForm\')" class="btn btnPersonalizado bg-warningP">'.(isset($registro) ? "ACTUALIZAR" : "REGISTRAR  ").'&nbsp;<i class="bi bi-pencil-fill"></i></button>    
                    </div>'
                    .(isset($registro) ? '<input type="hidden" name="Id" value="'.$_REQUEST['Id'].'">' : '').'
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
$oTorneos=new Torneos();
if(isset($_REQUEST['action'])){
    echo $oTorneos ->action($_REQUEST['action'] );
}
else 
    if(isset($accion)){$oTorneos->accion2 = $accion;}
  echo $oTorneos->action('report');
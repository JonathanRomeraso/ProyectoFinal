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
            case'searchDia':
                $result = $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                where t.id_usuario  = ".$_REQUEST['Id']. " AND t.fecha =  '".  $_REQUEST['fecha'].
                                                "' order by 2 desc limit 1;");               
            break;

            case'reportMes':  
                $result ="<h1>Ingresos y Egresos en: ".$_REQUEST['year']."-".$_REQUEST['mes']."</h1>";            
                $result .= $this->despTablaDatosReport("SELECT 
                                            SUM(CASE WHEN id_movimiento = 1 THEN monto ELSE 0 END) AS ingresos,
                                            SUM(CASE WHEN id_movimiento = 2 THEN monto ELSE 0 END) AS egresos
                                        FROM 
                                            transaccion
                                        WHERE  
                                            id_usuario =" . $_REQUEST['Id'] .
                                            " AND YEAR(fecha) =" . $_REQUEST['year'] .
                                            " AND MONTH(fecha) =" . $_REQUEST['mes'] . ";");
                $result .="<br><br><h1>Egresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                                " AND YEAR(fecha) = " . $_REQUEST['year'] .
                                                " AND MONTH(fecha) = " . $_REQUEST['mes'].
                                                " AND t.id_movimiento = 2");
                $result .="<br><br><h1>Ingresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                                " AND YEAR(fecha) = " . $_REQUEST['year'] .
                                                " AND MONTH(fecha) = " . $_REQUEST['mes'].
                                                " AND t.id_movimiento = 1");
           
            break;

            case'reportAnio':  
                $result ="<h1>Ingresos y Egresos en: ".$_REQUEST['year']."</h1>";                        
                $result .= $this->despTablaDatosReport("SELECT 
                                            SUM(CASE WHEN id_movimiento = 1 THEN monto ELSE 0 END) AS ingresos,
                                            SUM(CASE WHEN id_movimiento = 2 THEN monto ELSE 0 END) AS egresos
                                        FROM 
                                            transaccion
                                        WHERE  
                                            id_usuario = " . $_REQUEST['Id'] . " AND YEAR(fecha) = " . $_REQUEST['year']);
                $result .="<br><br><h1>Egresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                                " AND YEAR(fecha) = " . $_REQUEST['year'] .
                                                " AND t.id_movimiento = 2");
                $result .="<br><br><h1>Ingresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                                JOIN categoria c on c.id_categoria = t.id_categoria
                                                JOIN movimiento m on m.id_movimiento = t.id_movimiento
                                                JOIN metodo_pago Bitacora on Bitacora.id_metodo_pago = t.id_metodo_pago
                                                WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                                " AND YEAR(fecha) = " . $_REQUEST['year'] .
                                                " AND t.id_movimiento = 1");
           
            break;
            case'reportDay':  
                $result ="<h1>Ingresos y Egresos en: ".$_REQUEST['fecha']."</h1>";                        
                $result .= $this->despTablaDatosReport("SELECT 
                                            SUM(CASE WHEN id_movimiento = 1 THEN monto ELSE 0 END) AS ingresos,
                                            SUM(CASE WHEN id_movimiento = 2 THEN monto ELSE 0 END) AS egresos
                                        FROM 
                                            transaccion
                                        WHERE  
                                            id_usuario = " . $_REQUEST['Id'] . " AND fecha = '" . $_REQUEST['fecha'] . "'");
                $result .="<br><br><h1>Egresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                        JOIN categoria c ON c.id_categoria = t.id_categoria
                                        JOIN movimiento m ON m.id_movimiento = t.id_movimiento
                                        JOIN metodo_pago Bitacora ON Bitacora.id_metodo_pago = t.id_metodo_pago
                                        WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                        " AND fecha = '" . $_REQUEST['fecha'] . "'" .
                                        " AND t.id_movimiento = 2");
                $result .="<br><br><h1>Ingresos:</h1>";
                $result .= $this->despTablaDatosNoEdit("SELECT id_transaccion, fecha, monto, c.categoria, m.movimiento,  Bitacora.metodo_pago as Metodo FROM transaccion t
                                        JOIN categoria c ON c.id_categoria = t.id_categoria
                                        JOIN movimiento m ON m.id_movimiento = t.id_movimiento
                                        JOIN metodo_pago Bitacora ON Bitacora.id_metodo_pago = t.id_metodo_pago
                                        WHERE t.id_usuario = " . $_REQUEST['Id'] .
                                        " AND fecha = '" . $_REQUEST['fecha'] . "'" .
                                        " AND t.id_movimiento = 1");

           
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
    function despTablaDatosReport($query){
        $html='<table class="table table-hover table-striped tm-table-striped-even mt-3">  <thead>';
        $this->query($query);

        //Cabecera
        $datoss= '<tr class="tm-bg-gray">';
        $campos = array();
        $tablaNombre=$this->campos($campos);
        foreach($campos as $campo){
            $datoss.= '<th scope="col" class="text-center tm-logout-icon2">'.strtoupper($campo).'</th>';
        }
        $datoss.= "</tr></thead>";
        //Fin cabecera  
        foreach ($this->a_bloqRegistros as $row) {
            $datoss.='<tr>';

            foreach ($row as $datos) {
                $datoss.='<th scope="col" class="text-center tm-logout-icon2">'.($datos)."</th>";
                $flag = false;
            }
            $datoss.="</tr>";
        }
        $datoss.="</table></div>";
        return $html.$datoss;
    }
 
}

//var_dump($_POST);
//print_r();
if (!isset($oTorneos))
    $oTorneos=new Torneos();

if(isset($_REQUEST['action'])){
    echo $oTorneos ->action($_REQUEST['action'] );
}
<?
session_start();
if(!isset($_SESSION['nombre']) || !$_SESSION['admin']){
  header("location: ../index.php?m=200");
  //var_dump($_SESSION);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GastoTrack</title>
    <script src="../controllers/reporte.js?2024.001"></script>

</head>

<body id="reportsPage" class="bg02">
    <div class="" id="home">
        <div class="container">
            <div class="row">
                <div class="col-12">
                <?php     
                    include "./barra.php";
                ?>  
                </div>
            </div>
            <!-- row -->
            <div class="row tm-content-row tm-mt-big">
                <div class="col-xl-12 col-lg-12 tm-md-12 tm-sm-12 tm-col">
                    <div class="bg-white tm-block h-100">                        
                        <?php
                            if(isset($_REQUEST['action'])){
                                if($_REQUEST['action']=='anio'){
                                    $result='<form method="post"onsubmit="return reportess(\'reportAnio\','.$_SESSION['id'].')" id="formAnio">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-12">
                                                    <h2 class="tm-block-title d-inline-block">Seleccione un año:</h2>
                                                </div>
                                                <div class="col-md-4 col-sm-12 text-right">                                
                                                    <select id="year" name="year" required class="form-control " style="padding-top: 5px; padding-bottom: 5px;">';
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= 1990; $year--) { $result.= "<option value=\"$year\">$year</option>"; }
                                    $result.='</select>
                                                </div>
                                                <div class="col-md-12 col-sm-12 text-right"> 
                                                    <button type="submit" class="btn btn-small btn-primary">Reporte</button>
                                                    <input type="hidden" name="action" value="reportAnio">
                                                    <input type="hidden" name="Id" value="'.$_SESSION['id'].'">
                                                </div>
                                            </div>
                                            </form>';
                                    echo $result;
                                }
                                if($_REQUEST['action']=='mes'){
                                    $result='<form method="post" onsubmit="return reportess(\'reportMes\','.$_SESSION['id'].')" id="formMes">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <h2 class="tm-block-title d-inline-block">Seleccione año y mes:</h2>
                                                </div>
                                                <div class="col-md-3 col-sm-12"> 
                                                <div class="form-group">  
                                                    <label for="year">Año:</label>                              
                                                    <select id="year" name="year" required class="form-control " style="padding-top: 5px; padding-bottom: 5px;">';
                                                    $currentYear = date('Y');
                                                    for ($year = $currentYear; $year >= 1990; $year--) { $result.= "<option value=\"$year\">$year</option>"; }
                                                    $result.='</select> 
                                                </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12"> 
                                                <div class="form-group">
                                                    <label for="mes">Mes:</label>
                                                    <select id="mes" name="mes" required class="form-control" style="padding-top: 5px; padding-bottom: 5px;">';
                                                    $currentMonth = date('n');
                                                    for ($mes = 1; $mes <= 12; $mes++) {
                                                        $nombreMes = date('F', mktime(0, 0, 0, $mes, 10)); 
                                                        $selected = ($mes == $currentMonth) ? 'selected' : '';
                                                        $result .= "<option value=\"$mes\" $selected>$nombreMes</option>";
                                                    }
                                                    $result .= '</select>
                                                </div>
                                                
                                                </div>
                                                <div class="col-md-12 col-sm-12 text-right"> 
                                                    <button type="submit" class="btn btn-small btn-primary">Reporte</button>
                                                    <input type="hidden" name="action" value="reportMes">
                                                    <input type="hidden" name="Id" value="'.$_SESSION['id'].'">
                                                </div>
                                            </div>
                                            </form>';
                                    echo $result;
                                }
                                if($_REQUEST['action']=='dia'){
                                    $result='<form method="post" onsubmit="return reportess(\'searchDia\','.$_SESSION['id'].')" id="formDia">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12">
                                                        <h2 class="tm-block-title d-inline-block">Seleccione un año:</h2>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 text-right">
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha</label>
                                                        <input required type="date"" class="form-control" id="fecha" name="fecha" placeholder="fecha" "min="'.'2001-01-01'.'">
                                                        </div> 
                                                            <button type="submit" class="btn btn-small btn-primary" >Buscar</button>
                                                            <input type="hidden" name="action" value="reportMes">
                                                            <input type="hidden" name="Id" value="'.$_SESSION['id'].'">
                                                        </div>
                                                    </div>
                                            </form>';
                                    echo $result;
                                }
                                if($_REQUEST['action']=='reportdia'){
                                    $result='<form method="post" onsubmit="return reportess(\'reportDay\','.$_SESSION['id'].')" id="formDiaR">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12">
                                                        <h2 class="tm-block-title d-inline-block">Seleccione un año:</h2>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 text-right">
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha</label>
                                                        <input required type="date"" class="form-control" id="fecha" name="fecha" placeholder="fecha" "min="'.'2001-01-01'.'">
                                                        </div> 
                                                            <button type="submit" class="btn btn-small btn-primary" >Buscar</button>
                                                            <input type="hidden" name="action" value="reportDay">
                                                            <input type="hidden" name="Id" value="'.$_SESSION['id'].'">
                                                        </div>
                                                    </div>
                                            </form>';
                                    echo $result;
                                }
                            }
                        ?>
                                    
                        <div id="reporte">

                        </div>       
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
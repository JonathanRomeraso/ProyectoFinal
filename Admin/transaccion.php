<?
session_start();
if(!isset($_SESSION['nombre']) || !$_SESSION['admin']){
  header("location: ../index.php?m=200");
  //var_dump($_SESSION);
}
$accion2 = "reportAll";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GastoTrack</title>
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
                    <div class="bg-white tm-block h-100" id="areaTrabajoTransaccion">
                        <div class="row">                       
                        <?php     
                            $accion2 = "reportAll";
                            include "../class/classTransaccion.php";
                        ?>
                        </div>          
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
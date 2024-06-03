<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GastoTrack</title>
    <!-- // logo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="../IMG/Logo.svg" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">
    <!-- https://fonts.google.com/specimen/Open+Sans -->
    <link rel="stylesheet" href="../Template/css/fontawesome.min.css">
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" type="text/css" href="../Template/css/bootstrap.css">
    <link rel="stylesheet" href="../Template/css/bootstrap.min.css">
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="../Template/css/tooplate.css?0.02">


</head> 
<body>
<nav class="navbar navbar-expand-xl navbar-light bg-light">
                        <a class="navbar-brand" href="home.php">
                            <img src="../IMG/Logo.svg" alt="Logo">
                            <h1 class="tm-site-title mb-0">GastoTrack</h1>
                        </a>
                        <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size:0.9rem;">
                            <ul class="navbar-nav mx-auto">  
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Reportes
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="reporte.php?action=anio">Por año</a>
                                        <a class="dropdown-item" href="reporte.php?action=mes">Por Meses</a>
                                        <a class="dropdown-item" href="reporte.php?action=reportdia">Por dia</a>
                                        <a class="dropdown-item" href="reporte.php?action=dia">Buscar por dia</a>
                                    </div>
                                </li> 
                                <li class="nav-item ">
                                    <a class="nav-link" href="categorias.php">Categorias</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="transaccion.php">Transacciones</a>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link d-flex" href="../index.php">
                                        <i class="bi bi-person-fill-check"></i>
                                        <span>&nbsp&nbspLogout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="../JS/jquery-3.6.0.min.js"></script>
    <script src="../JS/bootstrap.bundle.min.js"></script>
    <script src="../JS/jquery-confirm.js"></script>
    <script src="../JS/custom.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    
    
    <script src="../controllers/transaccion.js?2024.001"></script>
    <script src="../controllers/categorias.js?2024.001"></script>
    <script src="../controllers/perfil.js?2024.001"></script>

</body>

</html>


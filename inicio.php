<?php
// include_once 'APP/config.php';
include('php_conexion.php'); 

    // include_once '../app/config.php'; //Modelo usuario
    // if(!$_SESSION['_pid']){
    //     header('Location: '.URL.'login.php?e=n');
    // }
    // $idVendedor = $_SESSION['_pid'];
    // $nombre     = $_SESSION['_pname'];
    // $nombreAll  = $_SESSION['_pnamefull'];

    if (!empty($_POST['sucursal'])) {
        $id_sucursalA = $_POST['sucursal'];
        $id_sucursal = $_POST['sucursal'];
        $_SESSION['id_sucursal'] = $id_sucursal;
        $id_sucursal = $_SESSION['id_sucursal'];
        $can=mysql_query("SELECT * FROM empresa WHERE id = '$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
              $Sucursal = $dato['empresa'];
              $_SESSION['sucursal'] = $Sucursal;
            }
    
  }else{
    $id_sucursal = $_SESSION['id_sucursal'];
    $can=mysql_query("SELECT * FROM empresa WHERE id = '$id_sucursal'");
            if($dato=mysql_fetch_array($can)){
              $Sucursal = $dato['empresa'];
              $_SESSION['sucursal'] = $Sucursal;
            }
  }

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/ICONO2.ico" type="image/vnd.microsoft.icon" />
    <title>Inicio</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->
    <!--<link href="css/mdb.min.css" rel="stylesheet"> -->

    <!--<link rel="stylesheet" href="bootstrap.css">-->

    <script type="text/javascript" src="jsV2/tether.min.js"></script>
    <!--<script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>-->

    
    <!--<script src="js/jquery-3.1.1.js"></script>-->
    <script src="jsV2/jquery-1.11.3.js"></script>
        
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <style>
        body{
            /* background: #EBEDEF; */
            background: #F7D358;
        }
        .titulo{
            background: #e7e7e7;
           
            /*#0275d8;*/
            color: #F2F2F2;
        }
        .modal-header{
            background: #0275d8;
            color: #F2F2F2;
        }
        .listado-tareas {
            max-height: calc(50vh - 70px);
            overflow-y: auto;
        }
        .btn{
            border-radius: 0px;
        }
        .finish{
            text-decoration:line-through;
        }
        .dropdown-item{
            color: #E5E8E8;
        }
        .dropdown-item:hover{
            color:#F4F6F6;
        }
        .form-control{
            margin: 0px;
        }

        
    </style>
</head>
<body>
    <?php include_once "layout.php"; ?>
    <div class="container-fluid">
        <!-- <div class="row"><br><br></div> -->
        <div class="row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo">
                        <!--<br>-->
                            <!--<img src="http://www.juliatours.com.mx/juliav2/sites/all/themes/juliatours/logo.png">-->
                            <!--<br>-->
                            <!--<br>-->
                            <!-- <h6>Pagos | Inicio de Sesión</h6> -->
                            <!-- <p>Sistema solicitud de pagos | Julia </p> -->
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <center>
                                <h1>SURTIDITOCELL
                                
                                <?php echo $_SESSION['sucursal'];?>
                                </h1>
                                <br><br><br>
                                </center>
                            </div>
                            <div class="col-md-4"></div>
                            <!-- <div class="col-md-2">
                                <h2>
                                    <a href="nuevaSolicitud.php"><i class="fa fa-wpforms fa-3x" aria-hidden="true"></i><br> Pago</a>
                                </h2>
                            </div>
                            <div class="col-md-2">
                                <h2>
                                    <a href="solicitudes.php"><i class="fa fa-list-alt fa-3x" aria-hidden="true"></i><br> Listado</a>
                                </h2>
                            </div> -->
                            <div class="col-md-4"></div>
                            <h1><br><br><br><br><br><br><br></h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-1"></div> -->
        </div>
    </div>
    <script>
        // new WOW().init();
    </script>
</body>
</html>
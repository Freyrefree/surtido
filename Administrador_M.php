<?php
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
header('location:error.php');
}
if($_SESSION['tipo_usu']=='a'){
$titulo='Administrador/a';
}else{
$titulo='Cajero/a';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $titulo; ?></title>
    <link href='img/ICONO2.ico' rel='shortcut icon' type='image/x-icon'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	  <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="http://www.tiendapablo.soyso.com.mx/ico/ico2.ico"> -->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
body {
	background-color: #D8EBEB;
	background-image: url(img/fondoP.png);
}
.pow{
  width: 12%;
  height: 12%;
}
.navbar .divider-vertical {
    border-left: 1px solid #BCBCBC;
}

.navbar-inverse .divider-vertical {
    border-right-color: #222222;
    border-left-color: #111111;
}

@media (max-width: 767px) {
    .navbar-collapse .nav > .divider-vertical {
        display: none;
     }
}

</style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="95%" border="0">
  <tr>
    <td>
    <div id="navbar-example" class="navbar navbar-static menu">
      <div class="navbar-inner" style="position:fixed; top:0px; width:92%">
        <div class="container" style="position:relative; top:0px "> 
          <ul class="nav" role="navigation">
          <li class="dropdown">
             <?php       
                if($_SESSION['tipo_usu']=='a'){
                echo'<a class="brand" href="empresa.php" target="admin" style="font-size:16px"><i class="icon-user"></i> Administrador</a>';
                }
              ?> 
          </li>
          <li class="divider-vertical"></li>
          <li class="dropdown">
            <a class="brand" href="caja.php?ddes=0" target="admin" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-tags"></i> Ventas</a>
          </li>
          <li class="divider-vertical"></li>
            <li class="dropdown">
              <a id="drop1" href="#" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-user"></i> Cliente/Proveedor <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                <li role="presentation">
                  <?php       
                    if($_SESSION['tipo_usu']=='a'){
                    echo' <a role="menuitem" tabindex="-1" href="crear_clientes.php" target="admin">Nuevo Cliente</a>';
                    }
                  ?>  
                </li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="clientes.php" target="admin">Buscar Clientes</a></li>
                <!-- <li role="presentation" class="divider"></li> -->
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                  <?php       
                    if($_SESSION['tipo_usu']=='a'){
                      echo'   <a role="menuitem" tabindex="-1" href="crear_proveedor.php" target="admin">Nuevo Proveedor</a>';
                      } 
                 ?>
                </li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="proveedor.php" target="admin">Proveedores</a></li>
              </ul>
            </li>
            <li class="divider-vertical"></li>
            <li class="dropdown">
              <a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-book"></i> Inventarios <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                 <li role="presentation">  
                 <?php       
                   if($_SESSION['tipo_usu']=='a'){
                   echo'  <a role="menuitem" tabindex="-1" href="seccion.php" target="admin">Secciones de Inventario</a>';
                    }
                  ?> 
                </li>
                <li role="presentation">  
                 <?php       
                   if($_SESSION['tipo_usu']=='a'){
                   echo'  <a role="menuitem" tabindex="-1" href="UnidadMedida.php" target="admin">Unidades de Medida</a>';
                    }
                  ?> 
                </li>
                <!-- <li role="presentation">  
                 <?php       
                   if($_SESSION['tipo_usu']=='a'){
                   echo'  <a role="menuitem" tabindex="-1" href="CrearUnidadMedida.php" target="admin">Nueva Unidad de Medida</a>';
                    }
                  ?>
                  </li> -->
                
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                 <?php       
                   if($_SESSION['tipo_usu']=='a'){
                    echo'  <a role="menuitem" tabindex="-1" href="crear_producto.php" target="admin">Nuevo Producto</a>';
                    }
                  ?>  
                </li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="producto.php" target="admin">Productos</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="crear_ordencompra.php" target="admin">Orden de Compra</a></li>
              </ul>
            </li>

            <!-- <li class="dropdown">
               <?php       
               if($_SESSION['tipo_usu']=='a'){
                echo'<a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown">Empleados<b class="caret"></b></a> ';
                }
              ?>  
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                
                </ul>
            </li> -->
            <li class="divider-vertical"></li>
            <li class="dropdown">
               <?php       
               if($_SESSION['tipo_usu']=='a'){
                echo'<a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-list-alt"></i> Gastos <b class="caret"></b></a> ';
                }
              ?>  
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="Gastos.php" target="admin"> 
                Registro de Gastos</a>
                </li>
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="AgregarCamion.php" target="admin">
                Nuevo Camion</a>
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="Camiones.php" target="admin">
                Camiones</a>
                </li>
                <li role="presentation" class="divider"></li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="crear_empleado.php" target="admin">
                Nuevo Empleado</a>
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="empleado.php" target="admin"> 
                Buscar Empleado</a>
                </li>
                </ul>
            </li>
            <li class="divider-vertical"></li>
            <!-- <a class="brand" href="Gastos.php" target="admin"><img src="img/total_plan_cost.png">Gastos</a> -->
            <li class="dropdown">
               <?php        
               if($_SESSION['tipo_usu']=='a'){
                echo'<a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-align-justify"></i> Reportes <b class="caret"></b></a> ';
                }
              ?>  
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="PDFusuarios_p.php" target="admin"><i class="icon-th-list"></i> 
                Listado de Usuarios</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="PDFclientes_p.php" target="admin"><i class="icon-th-list"></i> 
                Listado de Clientes</a>
                
                </li>
                <li role="presentation">
                
                <a role="menuitem" tabindex="-1" href="PDFproveedores_p.php" target="admin"><i class="icon-th-list"></i> 
                Listados de Proveedores</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="PDFproducto_p.php" target="admin"><i class="icon-th-list"></i> 
                Listado de Productos</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="PDFsesiones_p.php" target="admin"><i class="icon-th-list"></i> 
                Control de Sesiones</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="PDFestado_inventario_p.php" target="admin"><i class="icon-th-list"></i> 
                Estado de Inventario</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="Cortes/ReporteGastos.php" target="admin"><i class="icon-th-list"></i> 
                Reporte Gastos</a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="Cortes/cortes.php" target="admin"><i class="icon-th-list"></i> 
                Cortes de Ventas </a>
                
                </li>
                <li role="presentation">
                <a role="menuitem" tabindex="-1" href="Cortes/CorteVentasCredito.php" target="admin"><i class="icon-th-list"></i>
                Cortes de Ventas a Credito</a> 
                </li>
               <!--  <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="conceptos.php" target="admin">Administrar Conceptos</a></li>-->

              </ul>
            </li>
            <li class="divider-vertical"></li>
                 <li class="dropdown">
                    <a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-file"></i> Facturación <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                      <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="Facturacion/cortes.php" target="admin"><i class="icon-edit"></i> Nueva Factura </a>
                      </li>
                      <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="Facturacion/consultar_facturas.php" target="admin"><i class="icon-search"></i> Consultar y Cancelar </a>
                      </li>
                      <li role="presentation" class="divider"></li>
                      <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="Facturacion/consultar_timbres.php" target="admin"><i class="icon-search"></i> Consulta de Timbres </a>
                      </li>
                    </ul>
                  </li>
                  <li class="divider-vertical"></li>
          </ul>
                
          <ul class="nav pull-right">
            <li id="fat-menu" class="dropdown">
              <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Hola! <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="cambiar_clave.php" target="admin"><i class="icon-refresh"></i> Cambiar Contraseña</a></li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="php_cerrar.php"><i class="icon-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    </td>
  </tr>
  <tr>
    <td>
    
    <?php       if($_SESSION['tipo_usu']=='a'){
echo'<pre><iframe src="empresa.php" frameborder="0" scrolling="auto" name="admin" width="100%" height="480"></iframe></pre>';
}else {
	
	echo'<pre><iframe src="caja.php?ddes=0" frameborder="0" scrolling="auto" name="admin" width="100%" height="480"></iframe></pre>';
	
	}
      ?>
      
    </td>
  </tr>
  <tr>
    <td>
    <pre><center><strong><img class="pow" src="img/ico-power-by.png" alt=""></strong></center></pre>
    <!-- <pre><center><strong><a href="http://www.soyso.com.mx" target="_blank" style="color:#000">Desarrollado por soyso.com.mx 2015 - software &amp; solutions</a></strong></center></pre> -->
    </td>
  </tr>
</table>
</body>
</html>
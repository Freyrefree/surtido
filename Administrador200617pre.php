<?php
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
header('location:error.php');
}
if($_SESSION['tipo_usu']=='a'){
$titulo='Administrador/a';
}
if($_SESSION['tipo_usu']=='su'){
$titulo='Supervisor/a';
}
if($_SESSION['tipo_usu']=='te'){
$titulo='Tecnico/a';
}
if($_SESSION['tipo_usu']=='ca'){
$titulo='Cajero/a';
}
$Sucursal = "";

if (!empty($_POST['sucursal'])) {
  //echo "<script> alert($_POST['sucursal']) </script>";
    //if ($_SESSION['id_sucursal'] == "") {
      $id_sucursal = $_POST['sucursal'];
      $_SESSION['id_sucursal'] = $id_sucursal;
      $id_sucursal = $_SESSION['id_sucursal'];
      $can=mysql_query("SELECT * FROM empresa WHERE id = '$id_sucursal'");
          if($dato=mysql_fetch_array($can)){
            $Sucursal = $dato['empresa'];
            $_SESSION['sucursal'] = $Sucursal;
          }
  //}
}else{
  $id_sucursal = $_SESSION['id_sucursal'];
  $can=mysql_query("SELECT * FROM empresa WHERE id = '$id_sucursal'");
          if($dato=mysql_fetch_array($can)){
            $Sucursal = $dato['empresa'];
            $_SESSION['sucursal'] = $Sucursal;
          }
}

//obtencion de fecha para recordatorio
$fecha=date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title><?php echo $titulo; ?></title>
    <link href='img/ICONO2.ico' rel='shortcut icon' type='image/x-icon'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <script src="styleb/js/jquery-1.11.3.js"></script>
    <!-- Estilos CSS vinculados -->
    <link href="styleb/css/bootstrap.min.css" rel="stylesheet">
    <link href="styleb/css/bootstrap.css" rel="stylesheet">
	  <script src="styleb/js/bootstrap.min.js"></script>

    
<style type="text/css">
    body {
      background-color: #F7D358 ; /* #D8EBEB  #8A2908 #31B404 #FFBF00 #D8F781*/
      /*background-image: url(img/fondoP.png);*/
    }
    .pow{
      width: 12%;
      height: 12%;
    }
    /* .dropdown-menu > li:hover{
      background-color: #DF0101;
    } */
    .dropdown-menu >li:hover{background-color: #DF0101}
    .navbar .divider-vertical {
        border-left: 1px solid #DF0101 ;/* #BCBCBC #DF0101*/
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
<script>
$(document).ready(function(){
    var fecha = "<?= $fecha ?>";
    var valores = "fecha="+fecha;
    $.ajax({                        
    url: 'Vigencia.php',
     type: "POST",                        
     data: valores,
     success: function(datos){
       if(datos == 1){
        //mensaje de error
         }else{
          //obtencion diferencia de dias
           var aFecha1 = fecha.split('-'); 
           var aFecha2 = datos.split('-');
           var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
           var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
           var dif = fFecha2 - fFecha1;
           var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
           if (dias <= 5 && dias >= 0) {
              if (dias > 1){
                $("#days").text("¡EL SERVICIO EXPIRA EN: "+dias+ " DIAS.!");
                $("#aviso2").removeAttr("data-keyboard");
                $("#aviso2").removeAttr("data-backdrop");
                $('#aviso2').modal('show');
                 }else{
                  if (dias <= 0){
                    $("#days").text("¡EL SERVICIO HA EXPIRADO.!");
                    /*$("#aviso").removeAttr("data-keyboard");
                    $("#aviso").removeAttr("data-backdrop");*/
                    $('#aviso2').modal('show');
                    /*$("#content").css("display", "none");*/
                  }
                  else{
                    $("#days").text("¡El SERVICIO EXPIRA EN: "+dias+ " DIA.!");
                    $("#aviso2").removeAttr("data-keyboard");
                    $("#aviso2").removeAttr("data-backdrop");
                    $('#aviso2').modal('show');
                  }
                }
              //$('#aviso').modal('show');
              //alert("La mensualidad de usu herramienta CLOUD Expira en: "+dias+", dias");
           }else{
            if (dias < 0) {
              $("#content").css("display", "none");
              $("#days").text("¡EL SERVICIO HA EXPIRADO.!");
              $('#aviso2').mymodal('show');
            }else{
              //$("#content").show();
            }
           }

        }
      }
      });
   return false;  
  });

$(document).ready(function(){
  var sucursal = "<?= $_SESSION['id_sucursal']; ?>"
  if (sucursal == "") {
     $('#eleccion').modal('show');
  }
});
</script>
</head>
<body >
<!--data-spy="scroll" data-target=".bs-docs-sidebar"-->
<div align="center">
<table width="99%" border="0">
  <tr>
    <td>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div id="navbar-example" class="navbar navbar-static menu" class="navbar-brand">
      <div class="navbar-header" style="position:fixed; top:0px; width:100%">
        <div class="container" style="position:relative; top:0px">
          <ul class="nav navbar-nav" role="navigation">
          <li class="dropdown">
          <div class="navbar-header">
          <nav class="navbar navbar-default" role="navigation">
  
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Desplegar navegación</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
	            <li class="dropdown">
              <?php       
                  if($_SESSION['tipo_usu']=='a'){
                  echo'<a class="brand" href="empresa.php" target="admin" style="font-size:16px"><i class="icon-bar"></i> Administrador</a>';
                  }
                ?> 
              </li>
              <li class="divider-vertical"></li>
              <li class="dropdown ">
                <a id="drop1" href="#" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-tags"></i> Ventas <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="caja.php?ddes=0" target="admin">Ventas</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="nueva_reparacion.php" target="admin">Reparaciones</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="Solicitudes.php" target="admin">Solicitudes</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="RecargasMayoreo.php" target="admin">Recargas Mayoreo</a></li>
                  <!-- <li role="presentation" class="divider"></li> -->
                  <li role="presentation" class="divider"></li>                
                  <li role="presentation"><a role="menuitem" tabindex="-1" target="admin">Facturacion</a></li>
                  <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="Facturacion/cortes.php" target="admin"> Nueva Factura </a><!-- <i class="icon-edit"></i> -->
                  </li>
                  <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="Facturacion/consultar_facturas.php" target="admin"> Consultar y Cancelar </a><!-- <i class="icon-search"></i> -->
                  </li>
                  <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="Facturacion/consultar_timbres.php" target="admin"> Consulta de Timbres </a><!-- <i class="icon-search"></i> -->
                  </li>
                </ul>
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
                <!-- <li role="presentation">  
                    <?php       
                      if($_SESSION['tipo_usu']=='a'){
                      echo'  <a role="menuitem" tabindex="-1" href="Marcas.php" target="admin">Marcas</a>';
                        }
                      ?> 
                </li> -->
                <!--  <li role="presentation">  
                    <?php       
                      if($_SESSION['tipo_usu']=='a'){
                      echo'  <a role="menuitem" tabindex="-1" href="Modelos.php" target="admin">Modelos</a>';
                        }
                      ?> 
                </li> -->
                  <li role="presentation">  
                    <?php       
                      // *if($_SESSION['tipo_usu']=='a'){
                      // echo'  <a role="menuitem" tabindex="-1" href="UnidadMedida.php" target="admin">Unidades de Medida</a>';
                      // }*
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
                      if($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='te'){
                        echo'  <a role="menuitem" tabindex="-1" href="crear_producto.php" target="admin">Nuevo Producto</a>';
                        }
                      ?>  
                  </li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="producto.php" target="admin">Productos</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="crear_ordencompra.php" target="admin">Agregar al Sistema</a></li>
                <!-- <li class="dropdown">
                  <a id="drop2" href="#" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-user"></i> Orden de compra <b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                    <li role="presentation">
                      <?php       
                        if($_SESSION['tipo_usu']=='a'){
                        echo' <a role="menuitem" tabindex="-1" href="crear_clientes.php" target="admin">Nuevo Cliente</a>';
                        }
                      ?>  
                    </li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="clientes.php" target="admin">Buscar Clientes</a></li>
                    <li role="presentation" class="divider"></li>
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
                </li> -->
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="movimientos.php" target="admin">Movimientos al Inventario</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="MovimientosLote.php" target="admin">Movimientos x Lote</a></li>
                    <?php       
                      /*if($_SESSION['tipo_usu']=='te'){
                          echo'<li role="presentation"><a role="menuitem" tabindex="-1" href="reparaciones.php" target="admin">Reparaciones</a></li>';
                        }else {
                          echo'<li role="presentation"><a role="menuitem" tabindex="-1" href="nueva_reparacion.php" target="admin">Reparaciones</a></li>';
                        }*/
                      ?>
                <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="nueva_reparacion.php" target="admin">Reparaciones</a></li> -->
                <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="PruebaWebService.php" target="admin">Prueba Recargas</a></li> -->
                <!-- <li role="presentation" class="divider"></li> -->
                  <li role="presentation">
                  <?php       
                    /*if($_SESSION['tipo_usu']=='a'){
                      echo'  <a role="menuitem" tabindex="-1" href="Sucursales.php" target="admin">Sucursales</a>';
                      }*/
                    ?>  
                  </li>
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
                <?php if ($_SESSION['tipo_usu'] == 'ca' OR $_SESSION['tipo_usu'] == 'te') { ?>
                  <li class="dropdown">
                  <a id="drop1" href="#" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-user"></i> Credito / Apartado <b class="caret"></b></a>
                  <ul class="dropdown-menu"  aria-labelledby="drop1">
                  <li role="presentation" class="divider"></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="VentasCredito.php" target="admin"> &nbsp; &nbsp; Creditos Actuales</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="VentasAfavor.php" target="admin"> &nbsp; &nbsp; Saldo a favor</a></li>
                  </li>
                </ul> 
                <?php } ?>
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
                  <!-- <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="Comisiones.php" target="admin">
                  Comisionses</a>
                  </li> -->
                  
                  <!-- <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="AgregarCamion.php" target="admin">
                  Nuevo Camion</a>
                  </li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="Camiones.php" target="admin">
                  Camiones</a>
                  </li> -->
                  <!-- <li role="presentation" class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="crear_empleado.php" target="admin">
                  Nuevo Empleado</a>
                  </li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="empleado.php" target="admin"> 
                  Buscar Empleado</a>
                  </li> -->
                  <!-- <li role="presentation" class="divider"></li> -->
                  <!-- <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="Solicitudes.php" target="admin">
                  Solicitudes</a>
                  </li> -->
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
                  <!-- <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="PDFusuarios_p.php" target="admin"><i class="icon-th-list"></i> 
                  Listado de Usuarios</a> -->
                  
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
                  <a role="menuitem" tabindex="-1" href="InventarioProducto.php" target="admin"><i class="icon-th-list"></i> <!-- PDFproducto_p.php -->
                  Listado de Productos</a>
                  
                  </li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="Cortes/ReporteSesiones.php" target="admin"><i class="icon-th-list"></i> 
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
                  <a role="menuitem" tabindex="-1" href="Cortes/CortesGraficas.php" target="admin"><i class="icon-th-list"></i> 
                  Gráficas de Cortes </a>
                  
                  </li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="Cortes/CorteVentasCredito.php" target="admin"><i class="icon-th-list"></i>
                  Cortes de Credito/Apartado</a> 
                  </li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="calculo_comisiones.php" target="admin"><i class="icon-pencil"></i>
                  Reporte/Comisiones</a>
                  </li>
                  
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="ReporteSaldoSucursales.php" target="admin"><i class="icon-th-list"></i>
                  Movimientos de saldo entre sucursales</a> 
                  </li>

                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="ReporteContabilizar.php" target="admin"><i class="icon-th-list"></i>
                  Billetes y Monedas</a> 
                  </li>
                <!--  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="conceptos.php" target="admin">Administrar Conceptos</a></li>-->

                </ul>
              </li>
              <?php        
              if($_SESSION['tipo_usu']=='a'){ ?>
              <li class="divider-vertical"></li>
                  <li class="dropdown">
                      <a href="#" id="drop2" role="button" class="brand" data-toggle="dropdown" style="font-size:16px"> &nbsp; &nbsp;<i class="icon-wrench"></i> Configuracion <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                      <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="RecargasSucursal.php" target="admin">Saldo recargas por sucursal </a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="UnidadMedida.php" target="admin"> Unidades de Medida </a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="Sucursales.php" target="admin"> Sucursales</a>
                        </li>
                        <li role="presentation">
                          <a role="menuitem" tabindex="-1" href="Comisiones.php" target="admin"> Comisiones </a>
                        </li>
                      </ul>
                  </li>
              <li class="divider-vertical"></li>

              <?php } ?> 

            <!-- <li class="divider-vertical"></li>
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
                  <li class="divider-vertical"></li> -->
            </ul>
                
            <ul class="nav pull-right">
            <!--class="dropdown-menu"-->
              <li id="fat-menu" class="dropdown">
                <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> Hola! <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="cambiar_clave.php" target="admin"><i class="icon-refresh"></i> Cambiar Contraseña</a></li>
                  <?php        
                  if($_SESSION['tipo_usu']=='a'){
                    echo'<li role="presentation"><a role="menuitem" tabindex="-1" href="#eleccion" target="admin" data-toggle="modal"><i class="icon-refresh"></i> Cambiar de Sucursal</a></li>';
                    echo'<li role="presentation"><a role="menuitem" tabindex="-1" href="empleado.php" target="admin"><i class="icon-user"></i> Usuarios</a></li>';
                    }
                  ?>  
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="php_cerrar.php"><i class="icon-off"></i> Salir</a></li>
                </ul>
              </li>
            </ul>
          </div>
      </nav>
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
<!-- -------------------------- modal aviso vigencia usu CLOUD ---------------------------------- -->

<!--<div id="eleccion" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">-->
<div id="eleccion" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModal">SUCURSAL A ADMINISTRAR</h3>
      </div>
      <div class="modal-body">
            <div align="center">
                <p>Elija una sucursal a Administrar</p>
            </div>
            <form id="form1" name="inicio" method="post" action="Administrador.php">
                  <label>Sucursal: </label>
                    <select name="sucursal" id="sucursal" class="form-control">
                    <?php $can=mysql_query("SELECT * FROM empresa");
                        while($dato=mysql_fetch_array($can)){?>
                        <option value="<?php echo $dato['id']; ?>" <?php if($sucursal==$dato['id']){ echo 'selected'; } ?> > 
                          <?php echo $dato['empresa']; }?>
                        </option>
                    </select>
                    <br>
                    <div>
                      <input type="submit" class="btn btn-success" name="button" id="button" value="Empezar" />
                    </div>
            </form>
      </div>
  <div class="modal-footer">
    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
 </div>
 </div>
 </div>
</div>

<!-- -------------------------- modal aviso vigencia usu CLOUD --------------------------------- --> 

<div id="aviso2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
    <img src="img/ICONO2.ico" alt="" class="powlog" align="left">
    <center><h3 id="myModalLabel">RECORDATORIO DE PAGO</h3></center>
  </div>
  <div class="modal-body">
      <p align="center" class="text-info"><strong><span id="days"></span></strong></p>
        <div align="center">
            <p>Estimado Usuario, le comunicamos que la vigencia del servicio está próximo a expirar, de manera que, lo invitamos a realizar su pago, para continuar con el servicio.</p>
        </div>
        <img class="powav" src="img/personaje-09.png" alt="" align="right">
  </div>
  <div class="modal-footer">
  <div align="center"><img class="powav" src="img/ico-power-by.png" alt=""></div>
   <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

</body>
</html>
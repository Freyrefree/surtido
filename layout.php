<?php
//session_start();
include_once 'Modelos/Empresa.php'; #Modelo Empresa
include_once 'Modelos/Usuario.php'; #Modelo usuario
include_once 'php_conexion.php'; 

//include(''); 

//define('RAIZ', realpath(dirname(__FILE__)).'/');
//define('RAIZ', "http://localhost/cloudd/"); #representa [ ruta web ]

$empresa = new Empresa();
$usuario = new Usuario();

if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
//header('location:error.php');
}

if($_SESSION['tipo_usu']=='a'){
$titulo='Administrador/a';
}else if($_SESSION['tipo_usu']=='su'){
$titulo='Supervisor/a';
}else if($_SESSION['tipo_usu']=='te'){
$titulo='Tecnico/a';
}else if($_SESSION['tipo_usu']=='ca'){
$titulo='Cajero/a';
}

$Sucursal = "";

if (!empty($_POST['sucursal'])) {

    $idSucursal = $_POST['sucursal'];
    $_SESSION['id_sucursal'] = $idSucursal;
    $idSucursal = $_SESSION['id_sucursal'];
    $empresa->set('id',$idSucursal);
    $empresa->obtieneEmpresa();

    $Sucursal = $empresa->get('empresa');
    $_SESSION['sucursal'] = $Sucursal;
 
}else{

    $idSucursal = $_SESSION['id_sucursal'];
    $empresa->set('id',$idSucursal);
    $empresa->obtieneEmpresa();

    $Sucursal = $empresa->get('empresa');
    $_SESSION['sucursal'] = $Sucursal;
    
}



//obtencion de fecha para recordatorio
$fecha=date("Y-m-d");
?>


<style>
    .modal-header{
        background: #e7e7e7;
        color: black;
        
	}
    .btn{
        /* box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); */
    }
    .btn:hover {
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
    }

    ::-webkit-scrollbar {
        width: 5px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.3); /* 105,106,110 */
        border-radius: 0px;
    }
        
    ::-webkit-scrollbar-thumb {
        border-radius: 30px;
        -webkit-box-shadow: inset 0 0 20px rgba(21, 67, 96);
    }
    .dropdown-item{
        color: black;
    }
    .dropdown-item:hover{
        color: black;
        background: #e7e7e7;
    }



</style>

    <nav class="navbar navbar-light sticky-top  flex-nowrap navbar-toggleable-sm" style="background-color: #e7e7e7;">
        <!-- navbar-fixed-top -->
        <!--  -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex">
            <a class="navbar-brand" href=""><strong><h5></h5></strong></a>
            <!-- Villa Tours -->
            <!--mt-1-->
            <!--navbar-text -->
        </div>
        <div class="navbar-collapse collapse justify-content-between" id="collapsingNavbar">
            <!--justify-content-end-->
            <ul class="navbar-nav">
               
                    <li class="nav-item dropdown">

                        <a class="nav-link" href="<?= URL; ?>inicio.php">Administrador</a>

                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ventas</a>
                        <div class="dropdown-menu ">
                           
                            <a class="dropdown-item" href="<?= URL; ?>caja.php?ddes=0" >Ventas</a>
                            <a class="dropdown-item" href="<?= URL; ?>nueva_reparacion.php?">Ingresar Reparaciones</a>
                            <a class="dropdown-item" href="<?= URL; ?>reparaciones.php">Consulta Reparaciones</a>
                            <a class="dropdown-item" href="<?= URL; ?>liberarReparacionForm.php">Liberar Reparación</a>
                            <a class="dropdown-item" href="<?= URL; ?>Solicitudes.php">Solicitudes</a>
                            <a class="dropdown-item" href="<?= URL; ?>RecargasMayoreo.php">Recargas Mayoreo</a>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cliente/Proveedor</a>
                        <div class="dropdown-menu ">

                            <?php if($_SESSION['tipo_usu']=='a'){ ?> <a class="dropdown-item" href="<?= URL; ?>crear_clientes.php">Nuevo Cliente </a> <?php } ?>
                            <a class="dropdown-item" href="<?= URL; ?>clientes.php">Buscar Clientes</a>
                            <?php if($_SESSION['tipo_usu']=='a'){ ?> <a class="dropdown-item" href="<?= URL; ?>crear_proveedor.php">Nuevo Proveedor </a> <?php } ?>
                            <?php if($_SESSION['tipo_usu']=='a'){ ?> <a class="dropdown-item" href="<?= URL; ?>proveedor.php">Proveedores </a> <?php } ?>
                            
                        </div>
                    </li>




<?php

if (($_SESSION['tipo_usu']=='a') || ($_SESSION['tipo_usu']=='te') || ($_SESSION['tipo_usu']=='ca') || ($_SESSION['tipo_usu']=='su')) 
{
  $nombreUsuario = $_SESSION['username'];
  $usuario->set('usu',$nombreUsuario);
  $usuario->obtieneUsuarioPorUsu();
  $idSucursalReal = $usuario->get('idSucursal');

        //   $consultaRelacion = "SELECT * FROM usuarios WHERE usu = '$nombreUsuario'";
        //   $ejecutar = mysql_query($consultaRelacion);
        //   $datoreal = mysql_fetch_array($ejecutar);
        //   $id_sucursalreal = $datoreal['id_sucursal'];

  if (($idSucursal != $idSucursalReal) && ($_SESSION['tipo_usu'] == 'ca')){
           
    ?>
        <li class="nav-item dropdown">
            <a class="nav-link" href="reportes.php">Productos</a>
        </li>
    <?php
    
    
  }else{

    ?> <li class="nav-item dropdown"> <?php

    if (($idSucursal == $idSucursalReal) && ($_SESSION['tipo_usu'] == 'a' )) 
    {
        ?> <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventarios</a> <?php
    
    }else if(($idSucursal != $idSucursalReal) && ($_SESSION['tipo_usu'] == 'a' ))
    {
        ?> <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventarios</a> <?php
    
    }else if(($idSucursal == $idSucursalReal) && (($_SESSION['tipo_usu'] == 'ca' ) || ($_SESSION['tipo_usu'] == 'su' ) || ($_SESSION['tipo_usu'] == 'te' )) )
    {
        ?> <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventarios</a> <?php
    }


    ?>

        <div class="dropdown-menu ">
            <?php
            if($_SESSION['tipo_usu']=='a') { ?> <a class="dropdown-item" href="<?= URL; ?>seccion.php">Secciones de Inventario</a> <?php }
            if($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='su' or $_SESSION['tipo_usu']=='te'){ ?> <a class="dropdown-item" href="<?= URL; ?>crear_producto.php">Nuevo Producto</a> <?php }
            ?>
            <a class="dropdown-item" href="<?= URL; ?>producto.php">Productos</a>
            <a class="dropdown-item" href="<?= URL; ?>MovimientosLote.php">Movimientos Accesorios</a>
            <a class="dropdown-item" href="<?= URL; ?>Inventariodefectuoso.php">Inventario Garantía</a>
        </div>
    </li>
    <?php
                     
  }

}


?>

               

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Credito / Apartado</a>
                    <div class="dropdown-menu ">
                        <a class="dropdown-item" href="<?= URL; ?>VentasCredito.php">Credito/Apartado</a>
                        <a class="dropdown-item" href="<?= URL; ?>VentasAfavor.php">Saldo a favor</a>
                    </div>
                </li>

              


                <?php if ($_SESSION['tipo_usu'] == 'a') { ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gastos</a>
                        <div class="dropdown-menu ">
                            <a class="dropdown-item" href="<?= URL; ?>Gastos.php">Registro de Gastos</a>
                        </div>
                    </li>

                <?php } ?>

                

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
                        <div class="dropdown-menu ">

                        <?php if ($_SESSION['tipo_usu'] == 'a') { ?>

                            <a class="dropdown-item" href="<?= URL; ?>PDFclientes_p.php">Listado de Clientes</a>
                            <a class="dropdown-item" href="<?= URL; ?>PDFproveedores_p.php">Listado de Proveedores</a>
                            <a class="dropdown-item" href="<?= URL; ?>InventarioProducto.php">Listado de Productos</a>
                            <a class="dropdown-item" href="<?= URL; ?>Cortes/ReporteSesiones.php">Control de Sesiones</a>
                            <a class="dropdown-item" href="<?= URL; ?>PDFestado_inventario_p.php">Estado de Inventario</a>
                            <a class="dropdown-item" href="<?= URL; ?>Cortes/ReporteGastos.php">Reporte Gastos</a>
                            <a class="dropdown-item" href="<?= URL; ?>Cortes/CortesGraficas.php">Gráficas de Cortes</a>
                            <a class="dropdown-item" href="<?= URL; ?>Cortes/CorteVentasCredito.php">Cortes de Crédito/Apartado</a>
                            <a class="dropdown-item" href="<?= URL; ?>calculo_comisiones.php">Reporte/Comisiones</a>
                            <a class="dropdown-item" href="<?= URL; ?>ReporteSaldoSucursales.php">Movimientos de saldo entre sucursales</a>
                            <a class="dropdown-item" href="<?= URL; ?>ReporteContabilizar.php">Billetes y Monedas</a>

                        <?php }  if($_SESSION['tipo_usu'] == 'a' || $_SESSION['tipo_usu'] == 'su') { ?>

                            <a class="dropdown-item" href="<?= URL; ?>Cortes/cortes.php">Cortes de Ventas</a>

                        <?php } ?>

                        </div>
                    </li>

                   

                <?php if ($_SESSION['tipo_usu'] == 'a') { ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Configuración</a>
                        <div class="dropdown-menu ">
                            <!-- <a class="dropdown-item" href="<?= URL; ?>RecargasSucursal.php">Saldo de Recargas por Sucursal</a> -->
                            <a class="dropdown-item" href="<?= URL; ?>UnidadMedida.php">Unidades de Medida</a>
                            <a class="dropdown-item" href="<?= URL; ?>Sucursales.php">Sucursales</a>
                            <a class="dropdown-item" href="<?= URL; ?>Comisiones.php">Comisiones</a>
                        </div>
                    </li>

                <?php } ?>


                    <li class="nav-item dropdown">

                        <a class="nav-link" href="#">|<i class="fa fa-shopping-basket" aria-hidden="true"></i> <?=$Sucursal?></a>

                    </li>
                
            </ul>

            <ul class="nav navbar-nav flex-row">
                
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle " href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i><?= $_SESSION['username'] ?></a>
                    <div class="dropdown-menu " aria-labelledby="dropdown02">

                    <a class="dropdown-item" href="cambiar_clave.php"><i aria-hidden="true"></i> Cambiar <br/> Contraseña</a>

                    <?php        
                     if($_SESSION['tipo_usu']=='a'){ ?>
                        <a class="dropdown-item" href="#eleccion" data-toggle="modal"><i aria-hidden="true"></i> Cambiar <br/> de Sucursal</a>
                        <a class="dropdown-item" href="empleado.php"><i aria-hidden="true"></i> Usuarios</a>
                    <?php } ?>

                    <?php        
                     if($_SESSION['tipo_usu']=='ca'){ ?>
                        <a class="dropdown-item" href="#eleccion" data-toggle="modal"><i aria-hidden="true"></i> Cambiar <br/> de Sucursal</a>
                    <?php } ?>

                   
                    <a class="dropdown-item" href="<?= URL; ?>miCorte.php"><i aria-hidden="true"></i> Corte <br/> del Día</a>
                    <a class="dropdown-item" href="<?= URL; ?>php_cerrar.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Salir</a>

                    </div>
                </li>
            </ul>


        </div>
    </nav>
    <div  style="height:10px;">
    </div>
       

<!-- <style type="text/css">
.ui-jqgrid .ui-search-table td.ui-search-clear {
    display: none;
}    
</style> -->




<div class="modal fade" id="eleccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title " id="myModal" >SUCURSAL A ADMINISTRAR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Elija una sucursal a Administrar</p>

        <form id="form1" name="inicio" method="POST" action="inicio.php">

        <div class="form-group">

            <label for="" class="col-form-label">Sucursal: </label>
                <select name="sucursal" id="sucursal" class="form-control form-control-sm">
                <?php 
                if($_SESSION['tipo_usu']=='a'){
                    $can=mysql_query("SELECT * FROM empresa");
                }else if($_SESSION['tipo_usu']=='ca'){
                    $can=mysql_query("SELECT * FROM empresa WHERE id = 12");
                }

                    while($dato=mysql_fetch_array($can)){
                ?>
                <option value="<?php echo $dato['id']; ?>" <?php if($sucursal==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
                <?php } ?>
                </select>
        </div>

        <button type="submit" class="btn btn-primary" name="button" id="button">Empezar</button>

        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>




<script>

$(document).ready(function(){
    //alert("ready")
  var sucursal = "<?= $_SESSION['id_sucursal']; ?>"
  if (sucursal == "") {
     $('#eleccion').modal('show');
  }
});

</script>
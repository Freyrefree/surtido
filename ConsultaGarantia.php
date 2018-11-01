<?php
        session_start();
        include('php_conexion.php'); 
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $IdsucursalLocal = $_SESSION['id_sucursal'];
        $usuariolocal = $_SESSION['username'];

        
        $IdFact = @$_REQUEST['IdFact'];
        $nuevo = @$_REQUEST['nuevo'];      
        if(isset($IdFact) and !isset($nuevo)){
            $can=mysql_query("DELETE FROM garantia WHERE Factura='$IdFact'");
            
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Compras</title>
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="ico/favicon.png">

</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<?php 
    $datestart  = $_POST['inicio'];
    $datefinish = $_POST['fin'];
 ?>
<table width="100%" border="0">
  <tr>
  <td>
    <div class="btn-group" data-toggle="buttons-checkbox">
        <button type="button" class="btn btn-primary" onClick="window.location='ModuloGarantia.php'">Nuevo Ingreso a Garantía</button>
    </div>
    </td>
    <td>
    <div align="right">
    <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
      <div class="input-append">
        
          <input type="date" name="inicio" id="inicio" value="<?= $datestart; ?>">
          <input type="date" name="fin" id="fin" value="<?= $datefinish; ?>">
             <input name="bus" type="text" class="span2" size="60" list="characters" placeholder="Buscar" autocomplete="off">
              <datalist id="characters">
              <?php
                $buscar=@$_POST['bus'];
                $can=mysql_query("SELECT DISTINCT * FROM garantia");
                while($dato=mysql_fetch_array($can)){
                    echo '<option value="'.$dato['Factura'].'">';
                    echo '<option value="'.$dato['Nombre'].'">';
                }
              ?>
              </datalist>
            <button class="btn" type="submit">Buscar Fecha / ID</button>
      </div>
    </form>
    </div>
    </td>
  </tr>
</table>
</div>
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="16"><center><strong>Listado de Entradas a Garanntía</strong></center></td>
  </tr>
  <tr>
    <td><strong>ID</strong></td>
    <td><strong>Factura</strong></td>
    <td><strong>Código</strong></td>
    <td><strong>Nombre</strong></td>
    <td><strong>Cantidad</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Importe</strong></td>
    <td><strong>Descripcion</strong></td>
    <td><strong>Tipo</strong></td>
    <td><strong>ICCID</strong></td>
    <td><strong>IMEI</strong></td>
    <td><strong>Fecha</strong></td>
    <td><strong>Usuario</strong></td>
    <td><strong>Sucursal</strong></td>
    <td><strong>Liberar</strong></td>
    <td><strong>Nuevo Producto</strong></td>

  </tr>
    <?php 
    if(empty(@$_POST['bus']) AND !empty($_POST['fin']) AND !empty($_POST['inicio'])){

        $datestart  = $_POST['inicio'];
        $datefinish = $_POST['fin'];

        $can=mysql_query("SELECT * FROM garantia WHERE FechaOp BETWEEN '$datestart' AND '$datefinish'");

    }else{

        $buscar=@$_POST['bus'];
        $can=mysql_query("SELECT * FROM garantia WHERE Nombre LIKE '%$buscar%' OR Factura LIKE '%$buscar%'");

    }
    while($dato=mysql_fetch_array($can)){

            if($dato['dir_file']!=""){

                $direccion = $dato['dir_file'];
                $id = $dato['id_compra'];

                //esta parte pendiente
                $estado='<a href="download_com.php?archivo='.$direccion.'&id='.$id.'&val=compra"><span class="label label-success">Documento</span></a>';
            }else{
                $estado='<span class="label label-alert">No Documento</span>';
            }

    ?>
  <tr>
    <td><?php echo $dato['Id']; ?></td>
    <td><?php echo $dato['Factura']; ?></td>
    <td><?php echo $dato['Codigo']; ?></td>
    <td><?php echo $dato['Nombre']; ?></td>
    <td><?php echo $dato['Cantidad']; ?></td>
    <td><?php echo $dato['Valor']; ?></td>
    <td><?php echo $dato['Importe']; ?></td>
    <td><?php echo $dato['Descripcion']; ?></td>
    <td><?php echo $dato['Tipo']; ?></td>
    <td><?php echo $dato['ICCID']; ?></td>
    <td><?php echo $dato['IMEI']; ?></td>
    <td><?php echo $dato['FechaOp']; ?></td>
    <td><?php echo $dato['Usu']; ?></td>
    <?php
    $IdSucursal = $dato['IdSucursal'];

        $SqlQuery=mysql_query("SELECT * FROM empresa WHERE id='$IdSucursal'");
             if($Campo=mysql_fetch_array($SqlQuery)){
                $Empresa = $Campo['empresa'];
            }
    
     ?>
    <td><?php echo $Empresa; ?></td>
    <td><a href="ConsultaGarantia.php?IdFact=<?php echo $dato['Factura']; ?>" class="btn btn-warning">Liberar</a></td>
    <!-- <td><a href="ConsultaGarantia.php?nuevo=nuevo&IdFact=<?php //echo $dato['Factura']; ?>" class="btn btn-primary" id="Nuevo">Nuevo</a></td> -->
    <?php $botoncambio = '<i class="btn btn-primary" id="cambio" name="cambio" onclick="modal('.$dato["Factura"].');">Cambio</i>';?>
    <td><?php echo $botoncambio ?></td>

    
    </tr>
    <?php } ?>
</table>
</div>
</body>
</html>

<!-- ......................................... -->
<div id="modalmensaje" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div  class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">¡Mensaje!</h4>
      </div>
      <div id="msg" class="modal-body">       
      
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- ......................................... -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div  class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">¡Mensaje!</h4>
      </div>
      <div id="mensaje" class="modal-body">       
      
      
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id = "valoruid" onclick="nuevo(this.value)" >Aceptar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- ......................................... -->
<script type="text/javascript">
function modal(uid)
{
    $('#modal').modal('show');

    $('#mensaje').html("¿Desea reemplazar el producto en garantía por un producto nuevo?");

    var s = document.getElementById("valoruid");
            s.value = uid;
}
function nuevo(uid)
{



    var factura = uid;
    var idsucursallocal = "<?php echo $IdsucursalLocal; ?>";
    var usuariolocal = "<?php echo $usuariolocal ?>";
    //alert(factura);
    $.ajax({
     method: "POST",
     url: "nuevoProdGarantia.php",
     data: { factura: factura, idsucursallocal: idsucursallocal,usuariolocal:usuariolocal}
     })
     .done(function(respuesta) {
     //alert(respuesta);
     if(respuesta == 1){
         $("#modal").modal('hide');
         $("#modalmensaje").modal('show');
         $("#msg").html("Ha reemplazado el artículo en garantía por uno nuevo");
     }
     else if (respuesta == 0)
     {
        $("#modal").modal('hide');
        $("#modalmensaje").modal('show');
        $("#msg").html("Lo sentimos no se pudo completar el proceso");
     }
     else if (respuesta == 2)
     {
        $("#modal").modal('hide');
        $("#modalmensaje").modal('show');
        $("#msg").html("Lo sentimos no hay existencias del producto seleccionado");
        cerrar();
        
     }
     });
}
$('#modalmensaje').on('hidden.bs.modal', function cerrar() {
    location.href = "ConsultaGarantia.php";
})
</script>
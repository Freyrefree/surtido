<?php
    include_once 'APP/config.php';
    setlocale(LC_ALL,"es_ES");
 		// session_start();
    include('php_conexion.php'); 
		include('IMP_contado.php');
    include('IMP_Reparacion.php');
    
    if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
		}


    $id_sucursal   = $_SESSION['id_sucursal']; 
    $OtrosMensajes =$_GET['OtrosMensajes'];
    $usuario       =$_SESSION['username'];
    $ExMachineCount=0;


    if ($_GET['tipo'] == "CREDITO"){
      $tpagar=$_GET['tpagar'];
      $ccpago=$_GET['ccpago'];
      $factura=$_GET['factura'];
      $cambio=$ccpago-$tpagar;
      if ($cambio <= 0) {
        $cambio = 0;
      }
    }

    
    if(!empty($_GET['tpagar']) and !empty($_GET['ccpago']) and !empty($_GET['factura'])){
			$tpagar=$_GET['tpagar'];
			$ccpago=$_GET['ccpago'];
			$factura=$_GET['factura'];
			$cambio=$ccpago-$tpagar;
      if ($cambio <= 0) {
        $cambio = 0;
      }
    }
    
    if ($_GET['tipo'] == "REPARACION") {
      $id_reparacion = $_GET['id_reparacion'];
      $sent=mysql_query("SELECT * FROM reparacion where id_reparacion='$id_reparacion' AND id_sucursal = '$id_sucursal'");
        if($data=mysql_fetch_array($sent)){ 
        $tpagar=$data['precio'];
        $ccpago=$data['abono'];
        $cambio=0;

             $u_sql=mysql_query("SELECT ced FROM usuarios where usu='$usuario'");
              if($udat=mysql_fetch_array($u_sql)){
                $cedula=$udat['ced']; //numero de cedula del ususario actual
              }

              $c_sql=mysql_query("SELECT cantidad FROM caja where id_cajero='$cedula'");
              if($cdat=mysql_fetch_array($c_sql)){
                $cantidad=$cdat['cantidad']; //numero de cedula del ususario actual
              }

              $suma = $ccpago+$cantidad;

              if($ExMachineCount==0){
              //actualizar la cantidad encaja en cada venta debe aumentar
              $a_sql="UPDATE caja SET cantidad='$suma' where id_cajero = '$cedula' AND estado = '1'";
              mysql_query($a_sql);
              $ExMachineCount++;
              }
      }
    }
		
		if(!empty($_GET['mensaje'])){
			$error='si';
		}else{
			$error='no';
    }
    
    $numero = $_GET['numero'];
    $confirm = $_GET['confirm'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contado</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <style>

    body{
            
            background: #F7D358;
    }
    .titulo{

            background: #e7e7e7;
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
    .black{
        color: black;
    }
    .red{
        color: red;
    }
    .green{
        color: green;
    }

  </style>
</head>
<?php include_once "layout.php"; ?>
<body>

<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-block titulo"></div>
					<div class="card-block">
						<div class="row">

							<div class="col-md-12">
								<br>

								<div class="container">

									<div class="row">
										<div class="col-md-12">
											<p class="black font-weight-bold titulo text-center">CONTADO</p>
										</div>
									</div>

                      <div class="row">
                          <div class="col-md-6">  
                          <?php if($error=='no'){ ?>
                            <a href="caja.php?ddes=0" class="btn btn-info">REGRESAR A CAJA</a>
                          <?php } ?>
                          </div>

                          <div class="col-md-2">                        
                          
                          
                          </div>

                          <div class="col-md-4">

            
                            
                          </div>

                      </div>
                  
                  <br>

									<div class="row">
										<div class="col-md-12">

                      <?php
                      if($OtrosMensajes=='sinusuario'){
                        echo '<div class="alert alert-error" align="center">
                        <strong>Solo los clientes registrados pueden tener credito</strong> <br>
                        <strong><a href="caja.php?ddes='.$_SESSION['ddes'].'">REGRESAR A CAJA</a></strong>
                        </div>';
                      }else{
                      ?>           

                      <?php if($error=='no'){ ?>
                       
                      <br>

                      <div class="row">

                      <div class="col-md-3">

                        <p style="font-size:24px"><strong class="text-success">Total a Pagar</strong></p>
                        <p style="font-size:24px"><strong>$ <?php echo number_format($tpagar,2); ?></strong></p>
                        <p style="font-size:24px"><strong class="text-success">Dinero Recibido</strong></p>
                        <p style="font-size:24px"><strong>$ <?php echo number_format($ccpago,2); ?></strong></p>
                        <p style="font-size:24px"><strong class="text-success">Cambio</strong></p>
                        <p style="font-size:24px"><strong>$ <?php echo number_format($cambio,2); ?></strong></p>

                        <?php 
                          $can=mysql_query("SELECT * FROM empresa where id=1");	
                            if($dato=mysql_fetch_array($can)){
                            $empresa=$dato['empresa'];		$direccion=$dato['direccion'];
                            $telefono=$dato['tel1'];		$nit=$dato['nit'];
                            $fecha=date("d-m-y H:i:s");		$pagina=$dato['web'];
                            $tama=$dato['tamano'];
                          }
                          $can=mysql_query("SELECT * FROM factura where factura='$factura' AND id_sucursal = '$id_sucursal'");
                            if($datos=mysql_fetch_array($can)){	
                            $cajera=$datos['cajera'];
                          }
                          $can=mysql_query("SELECT * FROM usuarios where usu='$cajera'");	
                            if($datos=mysql_fetch_array($can)){	
                            $cajero=$datos['nom'];
                          }
                          $dia=date("d");
                          setlocale(LC_ALL,"es_ES");
                          $mes=strtoupper(date("M"));
                          $year=date("o");
                          $rfc = $_GET['rfc'];
                          $tipoventa=$_GET['tipo'];
                          if ($_GET['tipo'] == "REPARACION") {
                            
                            PDFR($id_reparacion);
                          }else {if ($_GET['tipo'] == "ABONO") {
                            $num = $_GET['n'];
                          }else {
                            $nombrecliente = $_GET['nombrecliente']; 
                            PDF($factura,$tipoventa,$ccpago,$rfc,$tpagar,$numero,$confirm,$nombrecliente);
                          }
                          }
                        ?>

                      </div>

                      <div class="col-md-9">
                      
                      <?php if ($_GET['tipo'] == "REPARACION") { ?>
                        <embed src="Facturas/R<?php echo $id_reparacion."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
                      <?php }else { if ($_GET['tipo'] == "ABONO") {  ?>
                        <embed src="Facturas/<?php echo "A".$num."_".$factura."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
                      <?php 
                      }else { ?>
                        <embed src="Facturas/<?php echo $factura."_".$id_sucursal; ?>.pdf?#zoom=160" width="100%" height="380" internalinstanceid="4" title>
                      <?php } ?>
                      <?php } //?#zoom=170 ?#zoom=170?>


                      <div class="alert alert-success">
                        <strong>Pago realizado con exito</strong><br><a href="caja.php?ddes=<?php echo $_SESSION['ddes']; ?>">REGRESAR A CAJA</a>
                      </div>

                      <?php } 
                        if($error=='si'){
                      ?>
                      <div class="alert alert-error" align="center">
                        <strong>El dinero recibido es menor al valor a pagar</strong> <br>
                        <strong><a href="caja.php?ddes=<?php echo $_SESSION['ddes']; ?>">Regresar a la caja</a></strong>
                      </div>
                      <?php } 
                      if($error=='num'){
                        echo '<div class="alert alert-error" align="center">
                              <strong>Solo debe de ingresar numeros en este campo</strong> <br>
                              <strong><a href="caja.php?ddes='.$_SESSION['ddes'].'">Regresar a la caja</a></strong>
                              </div>';
                        }
                      }




                      ?>


                      </div>
                      </div>

										</div>
									</div>

								</div>

							</div>

							<div class="col-md-12">
								
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


  
</body>
</html>

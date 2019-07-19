<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        //$id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
?>
<?php 
        $datestart  = $_POST['inicio'];
        $datefinish = $_POST['fin'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comisiones</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- DATA TABLE -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <!-- ********* -->

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
											<p class="black font-weight-bold titulo text-center">COMISIONES</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-6">                        
                                            
                                        </div>

                                        <div class="col-md-3">
										    <a href="#" onClick="exportarResult();" class="green"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>                                                  
                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">


									<div class="col-md-3">
                                    <form name="form1" method="post" action="">
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<label for="">Inicio</label>
											<input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" >
									</div>

									<div class="col-md-3">
											<i class="fa fa-calendar" aria-hidden="true"></i>
											<label for="">Fin</label>
											<input class="form-control" type="date" name="fecha_fin" id="fecha_fin" >
									</div>

                                    <div class="col-md-3">
											<i class="fa fa-user" aria-hidden="true"></i>
											<label for="">Cajero</label>

                                            <?php
                                                $consultaCajero = "SELECT usu,nom FROM usuarios WHERE estado = 's' ORDER BY nom ASC;";
                                                $sql=mysql_query($consultaCajero);
                                                if(mysql_num_rows($sql))
                                                {
                                                    $select= '<select class="form-control" id="ccodigo" name="ccodigo">';
                                                    $select.= '<option value="0">Selecciona el Cajero</option>';
                                                    $select.= '<option value="TODOS">TODOS</option>';
                                                    while($rs=mysql_fetch_array($sql))
                                                    {
                                                        $select.='<option value="'.$rs['usu'].'">'.$rs['nom'].'</option>';
                                                    }
                                                }
                                                $select.='</select>';
                                                echo $select;
                                            ?>
									</div>


									<div class="col-md-3"><br>
                                        <input type="submit" class="btn btn-primary" value="Buscar">                                        
										<i id="loading" class="fa fa-circle-o-notch fa-spin fa-2x fa-fw" style="color:#007bff; display:none;"></i>
										</div>
                                    </form>
									</div>

									<div class="row">
										<div class="col-md-12"><br>



                                      
                                            <?php
                                                if(!empty($_POST['ccodigo'])){// or !empty($_GET['codigo'])
                                                $factura="";$tipo = "";$fecha = "";$codigo='';$usuario=""; //variables que no se usan
                                                $datestart  = $_POST['fecha_inicio'];
                                                $datestart = $datestart.' 00:00:00';
                                                $datefinish = $_POST['fecha_fin'];
                                                $datefinish = $datefinish.' 23:59:59';
                                                //echo "fi: ".$datestart."<br>";echo "ff: ".$datefinish."<br>";
                                                $cantidad_ventas="";$total_ventas="";
                                                    $fechax=date("d").'/'.date("m").'/'.date("Y");
                                                    $fechay=date("Y-m-d");
                                                    $codigo=$_POST['ccodigo'];
                                                    if($codigo != "TODOS")
                                                    {
                                                        $consultasucursal="SELECT id_sucursal FROM usuarios WHERE usu ='$codigo'";
                                                    }

                                                    

                                                    $ejecutarquery = mysql_query($consultasucursal);
                                                    $dato = mysql_fetch_array($ejecutarquery);
                                                    $id_sucursal = $dato['id_sucursal'];

                                                    //*********Total productos vendidos**********
                                                    if ($codigo != "TODOS") {
                                                        $consultaProd = "SELECT SUM(cantidad) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu = '$codigo';";
                                                    }else{
                                                        $consultaProd = "SELECT SUM(cantidad) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'";
                                                    }
                                                    $ejecutarqueryp = mysql_query($consultaProd);
                                                    if($datocant = mysql_fetch_array($ejecutarqueryp))
                                                    {
                                                        $cantidad_Productos = $datocant[0];
                                                    }
                                                    //*******************************************/

                                                    //obtiene cantidad de ventas
                                                    //$consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal = '$id_sucursal'";
                                                    if($codigo != "TODOS")
                                                    {
                                                    $consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo'";
                                                    }else
                                                    {
                                                        $consulta = "SELECT COUNT(*) FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'"; 
                                                    }
                                                    $query=mysql_query($consulta);
                                                    if($dato=mysql_fetch_array($query)){
                                                        $cantidad_ventas= $cantidad_ventas+$dato[0];
                                                    }
                                                    //obtiene cantidad de repparaciones
                                                    if ($codigo != "TODOS") {
                                                        $quer=mysql_query("SELECT COUNT(*) FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal = '$id_sucursal' AND estado = '3'");
                                                    }else{
                                                        $quer=mysql_query("SELECT COUNT(*) FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3'");
                                                    }
                                                    if($dator=mysql_fetch_array($quer)){
                                                        $cantidad_ventas= $cantidad_ventas+$dator[0];
                                                    }
                                                    
                                                        $query2=mysql_query("SELECT * FROM usuarios WHERE usu='$codigo' ");/*AND id_sucursal='$id_sucursal'*/
                                                
                                                    
                                                    if (mysql_num_rows($query2)>0) {
                                                        while ($dato=mysql_fetch_array($query2)) {
                                                            $cedula = $dato['ced'];
                                                            $nombre = $dato['nom'];
                                                            $usuario = $dato['usu'];
                                                            $boton="Cancelar Venta";
                                                        }
                                                    }else{

                                                        $cedula = "TODOS";
                                                        $nombre = "TODOS";
                                                        $usuario = "TODOS";
                                                        $boton="Cancelar Venta";

                                                    }
                                                    if ($codigo != "TODOS") {
                                                        $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo' AND id_sucursal='$id_sucursal'");
                                                    }else{
                                                        $query2=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'");
                                                    }
                                                    while($dato=mysql_fetch_array($query2)){
                                                        $total_ventas = $total_ventas+$dato['importe'];
                                                    }
                                                    if ($codigo != "TODOS") {
                                                        $quer2=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND usuario='$codigo' AND id_sucursal='$id_sucursal' AND estado = '3'");
                                                    }else{
                                                        $quer2=mysql_query("SELECT * FROM reparacion WHERE fecha_salida BETWEEN '$datestart' AND '$datefinish' AND estado = '3'");
                                                    }
                                                    while($dat2=mysql_fetch_array($quer2)){
                                                        $total_ventas = $total_ventas+$dat2['precio'];
                                                    }

                                            ?>
                                            <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
                                            <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>
                                            <input type="hidden" name="usuarioi" id="usuarioi" value="<?php echo $usuario; ?>" readonly>


                                            <table class="table">

                                            <thead>
                                                <tr>
                                                    <th>Cedula</th>
                                                    <th>Nombre</th>
                                                    <th>Cantidad / Ventas</th>
                                                    <th>Cantidad / Productos Vendidos</th>
                                                    <th>Total / Ventas</th>
                                                    <th>Total / Comisiones</th>

                                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" readonly>
                                                    <input type="hidden" name="fi" id="fi" value="<?php echo $datestart; ?>" readonly>
                                                    <input type="hidden" name="ff" id="ff" value="<?php echo $datefinish; ?>" readonly>

                                                </tr>
                                            </thead>
                                                <tr>
                                                    <td><input class="form-control" type="text" name="codigo" id="codigo" value="<?php echo $cedula; ?>" readonly></td>
                                                    <td><input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly></td>
                                                    <td><input class="form-control" type="text" name="cant" id="cant" value="<?php echo $cantidad_ventas; ?>" readonly></td>
                                                    <td><input class="form-control" type="text" name="cant" id="cant" value="<?php echo $cantidad_Productos; ?>" readonly></td>
                                                    <td>                                                
                                                        <input class="form-control" type="text" name="total_ventas" size="10" id="total_ventas" value="<?php echo number_format($total_ventas,2,".",","); ?>" readonly>
                                                    </td>
                                                    <td>                                                   
                                                        <input class="form-control" type="text" name="total_comisiones" size="10" id="total_comisiones"  readonly>
                                                    </td>
                                                </tr>
                                            <tbody>
                                            </tbody>

                                            </table>


                                            <?php } ?>

                                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>N.</th>
                                                                <th>Cod Producto</th>
                                                                <th>Nombre</th>
                                                                <th>Cant.</th>
                                                                <th>Tipo Producto.</th>
                                                                <th>Tipo Venta.</th>
                                                                <th>% .</th>
                                                                <th>Precio U.</th>
                                                                <th>Comisión</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                                $contador = 0;
                                                                if ($codigo != "TODOS") {
                                                                    $query=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish' AND usu='$codigo'");
                                                                }else{
                                                                    $query=mysql_query("SELECT * FROM detalle WHERE fecha_op BETWEEN '$datestart' AND '$datefinish'");
                                                                }
                                                                while($dato=mysql_fetch_array($query)){
                                                                    $contador++;
                                                                    $pro_tipo = "TAE";
                                                                    $pro_codigo =$dato['codigo'];
                                                                    $pro_cant   =$dato['cantidad'];
                                                                    $pro_nombre =$dato['nombre'];
                                                                    $pro_precio =$dato['valor'];
                                                                    //************************************Para mostrar en tabla*****************************                            
                                                                    $tipo_comision = $dato['tipo_comision'];
                                                                    if(($tipo_comision == "venta"))
                                                                    {
                                                                        $tipo_comisionshow = "público";
                                                                    }else if($tipo_comision == "especial")
                                                                    {
                                                                        $tipo_comisionshow = "especial";
                                                                    }else if($tipo_comision == "mayoreo" )
                                                                    {
                                                                        $tipo_comisionshow ="mayoreo";
                                                                    }
                                                                    //************************************************************************************
                                                                    if ($codigo != "TODOS") {
                                                                        $query2=mysql_query("SELECT * FROM producto WHERE cod = '$pro_codigo' AND id_sucursal='$id_sucursal'");
                                                                    }else{
                                                                        $query2=mysql_query("SELECT * FROM producto WHERE cod = '$pro_codigo' AND id_sucursal='1'");
                                                                    }
                                                                    while($dato2=mysql_fetch_array($query2)){
                                                                        $id_comision = $dato2['id_comision'];
                                                                        $pro_costo = $dato2['costo'];
                                                                        $query3=mysql_query("SELECT * FROM comision WHERE id_comision = '$id_comision'");
                                                                        while($dato3=mysql_fetch_array($query3)){
                                                                            $pro_tipo = $dato3['tipo'];


                                                                            //**************************Tipo porcentaje de acuerdo al tipo de venta************************
                                                                            
                                                                            if(($tipo_comision == "venta"))
                                                                            {
                                                                                $pro_porcentaje = $dato3['porcentaje'];
                                                                            }else if($tipo_comision == "especial")
                                                                            {
                                                                                $pro_porcentaje = $dato3['porcentajeespecial'];
                                                                            }else if($tipo_comision == "mayoreo" )
                                                                            {
                                                                                $pro_porcentaje = $dato3['porcentajemayoreo'];
                                                                            }
                                                                            //************************************************************************************************
                                                                        }
                                                                    }
                                                            if ($pro_tipo != "TAE") {
                                                                    $pro_comision = (($pro_precio-$pro_costo)*($pro_porcentaje/100)*$pro_cant);
                                                                    $total_comisiones = $total_comisiones+$pro_comision;
                                                                }else {
                                                                    $pro_comision = 0;
                                                                }
                                                            ?>
                                                            
                                                            <tr>
                                                                <td><?php echo $contador; ?></td>
                                                                <td><?php echo $pro_codigo; ?></td>
                                                                <td><?php echo $pro_nombre; ?></td>                        
                                                                <td><?php echo $pro_cant; ?></td>
                                                                <td><?php echo $pro_tipo; ?></td>
                                                                <td><?php echo $tipo_comisionshow; ?></td>
                                                                <td><?php echo $pro_porcentaje." %"; ?></td>
                                                                <td><?php echo "$ ".number_format($pro_precio,2,",","."); ?></td>
                                                                <td><?php echo "$ ".number_format($pro_comision,2,",","."); ?></td>
                                                            </tr>
                                                            
                                                            <?php  } 
                                                            ?>
                                                            </tbody>
                                                            </table>

                                                            <table class="table">
                                                            <tr>
                                                                <td>Total Comisiones: <?= "$ ".number_format($total_comisiones,2,",","."); ?></td>
                                                            </tr>
                                                            </table>
                                       




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

<script>
        function ExportarGeneral(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteExcel.php?fi='+ fi +'&ff='+ ff;
            
        }
        function ExportarSucursal(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteExcelSucursal.php?fi='+ fi +'&ff='+ ff;
        }
        function ExportarIndividual(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            var usuario = document.getElementById('usuarioi').value;
            document.location.href = 'ReporteExcelIndividual.php?fi='+ fi +'&ff='+ ff +'&usuario='+ usuario;
        }
        function ExportarTaeIndividual(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            var usuario = document.getElementById('usuarioi').value;
            //alert('ReporteRecargas.php?fi='+ fi +'&ff='+ ff +'&usuario = '+ usuario);
            document.location.href = 'ReporteRecargas.php?fi='+ fi +'&ff='+ ff +'&usuario='+ usuario;
        }
        function ExportarTaeGeneral(){
            var fi = document.getElementById('fi').value;
            var ff = document.getElementById('ff').value;
            document.location.href = 'ReporteRecargasGeneral.php?fi='+ fi +'&ff='+ ff;
        }
    </script>



<script>
function exportarResult()
{
    var usuario = "<?php echo $usuario; ?>";
    var fecha_inicio = "<?php echo $datestart;?>";
    var fecha_fin = "<?php echo $datefinish ?>";
    //alert(usuario+"-"+fecha_inicio+"-"+fecha_fin);
    //
    if(usuario != "TODOS")
    {
        location.href = "ReporteExcelIndividual.php?usuario="+usuario+"&fi="+fecha_inicio+"&ff="+fecha_fin;
    }else{
        location.href = "ReporteExceltodos.php?fi="+fecha_inicio+"&ff="+fecha_fin;
    }
    

}

</script>

<script type="text/javascript">

$(document).ready(function() {
    var total_comisiones = "<?php echo $total_comisiones ?>";
    document.getElementById("total_comisiones").value = total_comisiones;
});

$(document).ready(function() {
    tabla();
} );


function tabla(){

$('#example').DataTable({
            "ordering": true,
            "language": {
                "paginate": {
                    "previous": "<i class='mdi mdi-chevron-left'>",
                    "next": "<i class='mdi mdi-chevron-right'>"
                }
            },
            language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
            },
            
        });

}

</script>
<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}        
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jquery-1.9.1.js"></script>

<script type="text/javascript">
function garantia(factura){
  $.ajax({ 
      type: "POST", 
      url: "EntradaSalida.php",
      data: "factura="+factura,
      success: function(msg){
        //$("#divId").load(location.href + " #divId>*", "");
        //refrescar la tabla
      } 
  });
}
</script>


<style type="text/css">
.fila_0 { background-color: #FFFFFF;}
.fila_1 { background-color: #E1E8F1;}
.botone{
  background-color: #FFBF00;
  border-radius: 40px;
  border: 0px;
}
.botone:hover{
  background-color: #F7D358;
}
</style>

<style type="text/css">
    ${demo.css}
</style>
</head>
<body>



<?php
//$id_sucursal  = $_SESSION['id_sucursal'];
$year             = $_POST['year'];
$valor_mes        = array();
$cajero           = $_POST['cajero'];
$producto         = $_POST['producto'];
$codigo           = $_POST['codigo'];
$categoria        = $_POST['categoria'];
$id_sucursal      = $_POST['empresa'];
if($id_sucursal=="Todos"){
    $id_sucursal="%%";
}


// Inicia sección de importes

if($categoria!=""){

    if ($cajero =='Todos'){

        $can=mysql_query("SELECT SUM(cantidad) FROM detalle 
                        WHERE fecha_op BETWEEN '$year-01-01' 
                        AND '$year-12-31' 
                        AND id_sucursal LIKE '$id_sucursal' 
                        AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria') 
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria')))");
        $row=mysql_fetch_array($can) or die ("Error en consulta 1");
        $cantidad_art= $row[0];

        $can1=mysql_query("SELECT SUM(importe) FROM detalle 
                        WHERE fecha_op BETWEEN '$year-01-01' 
                        AND '$year-12-31' 
                        AND id_sucursal LIKE '$id_sucursal' 
                        AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria') 
                        OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria')))");
        $row1=mysql_fetch_array($can1)or die ("Error en consulta 1");
        $importe1= $row1[0];

    }

    if ($cajero != 'Todos' && $producto=="Todos"){

        $tipo_user =$cajero;
        $can=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                                                            AND '$year-12-31' AND usu='$cajero' 
                                                            AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                    
                                                            OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                                            AND id_sucursal LIKE '$id_sucursal'");
        $row=mysql_fetch_array($can);
        $cantidad_art= $row[0];
        $can1=mysql_query("SELECT SUM(importe)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                                                            AND '$year-12-31' 
                                                            AND usu='$cajero' 
                                                            AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                    
                                                            OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                                            AND id_sucursal LIKE '$id_sucursal'");
        $row1=mysql_fetch_array($can1);
        $importe1= $row1[0];
        
    }

}


if($categoria==""){

if ($cajero =='Todos' && $producto == 'Todos'){
 

  $can=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                    AND '$year-12-31' 
                    AND id_sucursal LIKE '$id_sucursal'");
  $row=mysql_fetch_array($can);
  $cantidad_art= $row[0];

  $can1=mysql_query("SELECT SUM(importe) FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                     AND '$year-12-31' 
                     AND id_sucursal LIKE '$id_sucursal'");
  $row1=mysql_fetch_array($can1);
  $importe1= $row1[0];

}

if ($cajero == 'Todos' && $producto != 'Todos' ) {

    $tipo_user =$cajero; $tipo_producto=$producto;
    
    $can=mysql_query("SELECT SUM(cantidad) FROM detalle WHERE codigo='$producto' 
                      AND (fecha_op BETWEEN '$year-01-01' 
                      AND '$year-12-31') 
                      AND id_sucursal LIKE '$id_sucursal'") or die("1 Error en Todos Distinto Todos y codigo vacio".mysql_error());
    $row=mysql_fetch_array($can);
    $cantidad_art= $row[0];

    $can1=mysql_query("SELECT SUM(importe) FROM detalle WHERE codigo='$producto' 
                       AND (fecha_op BETWEEN '$year-01-01' 
                       AND '$year-12-31') 
                       AND id_sucursal LIKE '$id_sucursal'")or die("2 Error en Todos Distinto Todos y codigo vacio".mysql_error());
    $row1=mysql_fetch_array($can1);
    $importe1= $row1[0];

}

if ($cajero != 'Todos' && $producto == 'Todos' ) {

    $tipo_user =$cajero; $tipo_producto=$producto;
    
    $can=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                      AND '$year-12-31' 
                      AND usu='$cajero' 
                      AND id_sucursal LIKE '$id_sucursal'");
    $row=mysql_fetch_array($can);
    $cantidad_art= $row[0];

    $can1=mysql_query("SELECT SUM(importe) FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                       AND '$year-12-31' 
                       AND usu='$cajero' 
                       AND id_sucursal LIKE '$id_sucursal'");
    $row1=mysql_fetch_array($can1);
    $importe1= $row1[0];
      
}

if ($cajero != 'Todos' && $producto != 'Todos' ){

    $tipo_user =$cajero;
    
    $can=mysql_query("SELECT SUM(cantidad)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                      AND '$year-12-31' 
                      AND usu='$cajero' 
                      AND codigo='$producto' 
                      AND id_sucursal LIKE '$id_sucursal'");
    $row=mysql_fetch_array($can);
    $cantidad_art= $row[0];

    $can1=mysql_query("SELECT SUM(importe)FROM detalle WHERE fecha_op BETWEEN '$year-01-01' 
                       AND '$year-12-31' 
                       AND usu='$cajero' 
                       AND codigo='$producto' 
                       AND id_sucursal LIKE '$id_sucursal'");
    $row1=mysql_fetch_array($can1);
    $importe1= $row1[0];
    

	}

}

// Termina sección de importes

// Inicia sección de cantidad de ventas

if($categoria!=""){
    $i = 1;

    if ($cajero == 'Todos' && $categoria != '' && $producto =="Todos") {

               for ($mes = 1; $mes <= 12; $mes++) {
            
                $fechai="$year-$mes-01";
                $fechaf="$year-$mes-31";
                
                $can=mysql_query( "SELECT * FROM detalle 
                                   WHERE (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria') 
                                   OR codigo IN(SELECT codigo FROM compania_tl WHERE id_comision IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) 
                                   AND fecha_op BETWEEN '$fechai' AND '$fechaf' AND id_sucursal LIKE '$id_sucursal'  ORDER BY fecha_op");
                $valor_mes[] = mysql_num_rows($can);

            }   
                
    }

    if ($cajero != 'Todos' && $categoria != '' && $producto =="Todos") {

            for ($mes = 1; $mes <= 12; $mes++) {
            
                $fechai="$year-$mes-01";
                $fechaf="$year-$mes-31";
                
                $can=mysql_query( "SELECT * FROM detalle 
                                    WHERE fecha_op BETWEEN '$fechai' 
                                    AND '$fechaf' 
                                    AND usu='$cajero' 
                                    AND (codigo IN(SELECT cod FROM producto WHERE id_comision='$categoria')                                                                                            
                                    OR codigo   IN(SELECT codigo FROM compania_tl WHERE id_comision 
                                                IN(SELECT id_comision FROM comision WHERE tipo='$categoria'))) AND id_sucursal LIKE '$id_sucursal' ORDER BY fecha_op"); 
                $valor_mes[] = mysql_num_rows($can);

            }    
    }

}

if($categoria==""){

    $i = 1;

    if ($cajero == 'Todos' && $producto == 'Todos') {
     
       for ($mes = 1; $mes <= 12; $mes++) {
        
            $fechai="$year-$mes-01";
            $fechaf="$year-$mes-31";
            
            $can=mysql_query( "SELECT  * FROM detalle WHERE fecha_op BETWEEN '$fechai' 
                               AND '$fechaf' 
                               AND id_sucursal LIKE '$id_sucursal' ORDER BY fecha_op");
            $valor_mes[] = mysql_num_rows($can);

        }    
    }
    if ($cajero == 'Todos' && $producto != 'Todos') {
      
        for ($mes = 1; $mes <= 12; $mes++) {
        
            $fechai="$year-$mes-01";
            $fechaf="$year-$mes-31";
            
            $can=mysql_query( "SELECT * FROM detalle WHERE codigo = '$producto' 
                               AND fecha_op BETWEEN '$fechai' 
                               AND '$fechaf' 
                               AND id_sucursal LIKE '$id_sucursal'  ORDER BY fecha_op");
            $valor_mes[] = mysql_num_rows($can);

        }  

    }
    if ($cajero != 'Todos' && $producto == 'Todos' ) {

        for ($mes = 1; $mes <= 12; $mes++) {

            $fechai="$year-$mes-01";
            $fechaf="$year-$mes-31";
            
            $can=mysql_query( "SELECT * FROM detalle WHERE fecha_op BETWEEN '$fechai' 
                               AND '$fechaf' 
                               AND usu='$cajero' 
                               AND id_sucursal LIKE '$id_sucursal' ORDER BY fecha_op"); 
            $valor_mes[] = mysql_num_rows($can);

        }  
     

    }
    if ($cajero != 'Todos' && $producto != 'Todos') {

        for ($mes = 1; $mes <= 12; $mes++) {
        
            $fechai="$year-$mes-01";
            $fechaf="$year-$mes-31";
            
            $can=mysql_query( "SELECT * FROM detalle WHERE fecha_op BETWEEN '$fechai' 
                               AND '$fechaf' 
                               AND usu='$cajero' 
                               AND codigo='$producto' 
                               AND id_sucursal LIKE '$id_sucursal' ORDER BY fecha_op"); 
            $valor_mes[] = mysql_num_rows($can);

        }    
    }

}

 $VentasCantidad = array_sum($valor_mes);

// Termina sección de cantidad de ventas
?>

<table width="100%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel2" FRAME="border" RULES="none" align="center">
  <tr>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Usuario</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Producto</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Ventas</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Cantidad Articulos</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Venta Total</td>
    <td bgcolor="#FFCC33" style="font-size:16px" align="center">Año Venta</td>
  </tr>
  <tr>
    <td align="center" style="font-size:16px"><?php echo $tipo_user  ?></td>
    <td align="center" style="font-size:16px"><?php echo $tipo_producto  ?></td>
    <td align="center" style="font-size:16px"><?php echo $VentasCantidad ?></td>
    <td align="center" style="font-size:16px"><?php echo $cantidad_art ?></td>
    <td align="center" style="font-size:16px" >$ <?php echo number_format($importe1, 2, ',', ' ') ?></td>
    <td align="center" style="font-size:16px" ><?php echo $year ?></td>
  </tr>
</table>

<script type="text/javascript">
$(function () {
    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            <?php echo "text: 'Número de ventas por mes en el año $year'"; ?>
        },
        subtitle: {
            text: 'AIKO Soluciones Inteligentes'
        },
        xAxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        },
        yAxis: {
            title: {
                text: 'Número de Ventas'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Ventas',
            data: [<?php
			 foreach ($valor_mes as $v1) {
                    echo "$v1,";
					}
				?>]		
        }]
    });
});
</script>

</div>
<p>&nbsp;</p>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</body>
</html>



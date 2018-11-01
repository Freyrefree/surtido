<?php
		session_start();
		include('../php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
?>
<?php header( 'Content-type: text/html; charset=iso-8859-1' );?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



</script>


<style type="text/css">
.fila_0 { background-color: #FFFFFF;}
.fila_1 { background-color: #E1E8F1;}
</style>
</head>
<body>
<table width="127%" border=".5" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" id="Exportar_a_Excel" FRAME="border" RULES="none">
 	          <thead>
              <tr> 
            <td style="color:#000;" width="60"bgcolor="#CEE3F6" height="27"><SMALL>Factura</SMALL></td> 
            
            <td style="color:#000;" width="60"bgcolor="#CEE3F6" height="27"><SMALL>Codigo</SMALL></td> 
            
                                                                                                
            </tr>
	          <thead>




<?php

//$fecha_fin=$_POST['fecha_fin11'];
//$fecha_ini=$_POST['fecha_ini11'];

$fecha_fin3=$_POST['fecha_fin11'];
$fecha_ini3=$_POST['fecha_ini11'];
$i = 1;
//echo $fecha_ini3;

$sql = "SELECT  LTRIM(factura) AS factura,codigo from detalle where fecha_op BETWEEN '".$fecha_ini3."' AND '".$fecha_fin3."'";

//$sql ="SELECT  LTRIM(factura) AS factura,codigo from detalle where fecha_op BETWEEN '2015-01-01' AND '2015-01-06'";
//$can=mysql_query("SELECT  LTRIM(factura) AS factura,codigo from detalle where fecha_op BETWEEN '2015-01-01' AND '2015-01-06'");

while($dato=mysql_fetch_array($can)){




?>
  <tfoot>
<tr>
    <td style="color:#000;" class="fila_<?php echo $i%2; ?>"><SMALL> <?php echo $dato['factura']; ?></SMALL></td> 
    <td style="color:#000;" class="fila_<?php echo $i%2; ?>"><SMALL><?php echo $dato['codigo']; ?></SMALL></td>   
<?php
$i ++;
 }
?>


</table>
   

</body>
</html>


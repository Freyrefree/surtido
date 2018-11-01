<?php
error_reporting(0);
set_time_limit(0);
include('../php_conexion.php');
include('facturacion.php');

$fecha = $_POST['fecha'];    
$folio = $_POST['folio'];    
$subtotal = $_POST['subtotal'];       
$e_rfc = $_POST['e_rfc'];   
$r_rfc = $_POST['r_rfc'];    
$r_empresa = $_POST['r_empresa'];        
$r_pais = $_POST['r_pais'];     
$r_estado = $_POST['r_estado'];       
$r_municipio = $_POST['r_municipio'];                               
$r_colonia = $_POST['r_colonia'];                             
$r_calle = $_POST['r_calle'];                               
$r_cp = $_POST['r_cp'];                              
$r_ext = $_POST['r_ext'];                               
$r_int = $_POST['r_int'];                            
$r_correo = $_POST['r_correo'];                            
$r_contacto = $_POST['r_contacto'];                               
$r_telefono = $_POST['r_telefono'];                              
$r_celular = $_POST['r_celular'];

function cliente($rfc){
	include('../php_conexion.php');
	$consult_c = mysql_query("SELECT codigo from cliente where rfc='$rfc' AND estatus='s'");
	$fila_c = mysql_fetch_array($consult_c);
	return $fila_c['codigo'];
}

$consult = mysql_query("SELECT count(*)as num_reg from reg_factura where folio_compra=$folio AND estatus='vigente'");
$fila = mysql_fetch_array($consult);
if($fila[num_reg]>0){
	echo "La factura ya fue procesada, consulte registro.";
}else{
	$consult1 = mysql_query("SELECT count(*)as num_reg from cliente where rfc='$r_rfc' AND estatus='s'");
	$fila1 = mysql_fetch_array($consult1);
	if($fila1[num_reg]>0){
		$id_cliente = cliente($r_rfc);
		$folio_fact = pruebaTimbrado($id_cliente,$folio);
		if($folio_fact=='Error'){
			echo "Error al generar la factura, consulte proveedor";
		}else{
			mysql_query("INSERT INTO reg_factura(folio_compra,fecha_compra,emisor,receptor,folio,estatus,fecha_facturacion) VALUES('$folio','$fecha','$e_rfc','$r_rfc','$folio_fact','vigente',NOW())");
			echo 1;
		}
	}else{
		mysql_query("INSERT into cliente(rfc,nom,correo,tel,cel,empresa,pais,estado,municipio,colonia,cp,next,nint,calle,estatus) VALUES('$r_rfc','$r_contacto','$r_correo','$r_telefono','$r_celular','$r_empresa','$r_pais','$r_estado','$r_municipio','$r_colonia','$r_cp','$r_ext','$r_int','$r_calle','s')");
		$id_cliente = cliente($r_rfc);
		pruebaTimbrado($id_cliente,$folio);
	}
}                            

?>
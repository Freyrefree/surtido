
<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    error_reporting(0);
    include("host.php");
    include("funciones.php"); 
		$usu=$_SESSION['username'];
    $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te'){
			header('location:error.php');
    }

if($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB))
{    
  if (!empty($_POST['id'])) 
  {
      $data = array();
      $identificador = $_POST['id'];
      $consulta = "SELECT * FROM reparacion where id_reparacion = $identificador";
       
      if($paquete = consultar($con,$consulta))
      {
        if($fila = mysqli_fetch_array($paquete))
        {
          $codigoCliente = trim($fila['cod_cliente']);
          $nombreCliente = utf8_encode($fila['nombre_contacto'])." ".utf8_encode($fila['ap_contacto'])." ".utf8_encode($fila['am_contacto']);
          $rfc = utf8_encode($fila['rfc_curp_contacto']);
          $html='<style type="text/css">
          #tblpostliberacion {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
          }
          
          #tblpostliberacion td, #tblpostliberacion th {
            border: 1px solid #ddd;
            padding: 8px;
          }

          #tblpostliberacion td.a {
            padding-top: 5px;
            padding-bottom: 5px;
            text-align: left;
            background-color: #F7D358;
            color: #000000;
          }

          
          #tblpostliberacion th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #F7D358;
            color: #000000;
          }
</style>
          
          <table id="tblpostliberacion">
          <tr>
              <td class="a">Número de Reparación</td><td>'.$identificador.'</td>
            </tr>
            <tr>
              <td class="a">Código Cliente</td><td>'.$codigoCliente.'</td>
            </tr>
            <tr>
              <td class="a">Cliente</td><td>'.$nombreCliente.'</td>
            </tr>
            <tr>
              <td class="a">RFC</td><td>'.$rfc.'</td>
            </tr>
            <tr>
              <td class="a">Marca</td><td>'.utf8_encode($fila['marca']).'</td>
            </tr>
            <tr>
              <td class="a">Modelo</td><td>'.utf8_encode($fila['modelo']).'</td>
            </tr>
          </table>';


          
          $data['tblliberar'] = $html;
          //echo $html;
          echo json_encode($data);                
        }
      }
      
     
  }
}
?>

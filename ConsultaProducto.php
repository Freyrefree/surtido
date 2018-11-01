<?php
session_start();
include('funciones.php');
include('host.php'); 
$usu=$_SESSION['username'];
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te' or !$_SESSION['tipo_usu']=='su'){
header('location:error.php');
}
    
$Categoria = $_POST['categoria'];
$Categoria = str_replace('_',' ',$Categoria);  


$data=array();

$consulta = "SELECT DISTINCT nom, cod FROM producto WHERE categoria='$Categoria' ORDER BY nom ASC";

if($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)){
    if($paquete = consultar($con,$consulta)){
        while($fila = mysqli_fetch_array($paquete)){

            $codigo         = trim($fila['cod']);
            $nombreProducto = trim($fila['nom']);

            $data[]=array(
                'codigo'            => $codigo,
                'nombreProducto'    => $nombreProducto
            );
        }

        echo json_encode($data);
    }

}
          
                    
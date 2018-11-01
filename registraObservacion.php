<?php
    session_start();
    //error_reporting(E_ALL ^ E_DEPRECATED);
    //error_reporting(0);
    
    include("host.php");
    include("funciones.php");

    $usu=$_SESSION['username'];

    $observacion = $_POST['observacion'];
    $id_reparacion = $_POST['id_reparacion'];


    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {

       $consulta = "SELECT * FROM reparacion WHERE id_reparacion = $id_reparacion";
       if ($paquete = consultar($con, $consulta)) 
       {       
            $consulta2 = "UPDATE reparacion SET observacion = CONCAT(observacion,'\n',NOW(),' ','$usu',': ','$observacion') WHERE id_reparacion = '$id_reparacion'";
            if ($paquete = actualizar($con,$consulta2))
            {
                echo 1;
            }
            else
            {
                echo 0;
            }   
       }else{
           echo 2;
       }       
    }


?>

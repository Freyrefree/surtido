<?php
session_start();
include("funciones.php");
include("host.php");

$idSucursal = $_SESSION['id_sucursal'];
$perfil     = $_SESSION['tipo_usu']; 

$opcion = $_POST['opcion'];

if($opcion == 1){


    $noCA        = $_POST['noCA'];
    $nombreCA    =  $_POST['nombreCA'];
    $correoCA    = $_POST['correoCA'];
    $telefonoCA  = $_POST['telefonoCA'];
    $categoriaCA = $_POST['categoriaCA'];
 
 
     $arrayQuery[0] = $noCA;
     $arrayQuery[1] = $nombreCA;
     $arrayQuery[2] = $correoCA;
     $arrayQuery[3] = $telefonoCA;
     $arrayQuery[4] = $categoriaCA;
     $arrayQuery[5] = $idSucursal;
 
     $consultaCompleta = crearConsulta($arrayQuery,$perfil);
 
     $codigoTabla = tabularCreditoApartado($consultaCompleta);
 
     echo $codigoTabla;

}else if($opcion == 2){

    $idCA = $_POST['idCA'];

    $codigoTabla2 = tabularCAProdcutos($idCA);

    echo $codigoTabla2;
}else if($opcion == 3){

    $idCA = $_POST['idCA'];

    $codigoTabla2 = tabularCAPagos($idCA);

    echo $codigoTabla2;
}

  
    

function crearConsulta($arrayQuery,$perfil)
{

        $countArray = 0;
        $queryMas = "";
    
        foreach ($arrayQuery as &$valor) {
            
    
            if($countArray == 0){
    
                if($valor != ""){
    
                    $queryMas.= " WHERE cr.id = '$valor' ";
                }else{
                    $queryMas.= "";
                }
    
            }
    
    
            if($countArray == 1){
    
                if($valor != ""){
                    if($queryMas != ""){
    
                        $queryMas.= " AND  CONCAT(cl.nom,' ',cl.apaterno,' ',cl.amaterno) LIKE '%$valor%' ";
                    }else{
                        $queryMas.= " WHERE  CONCAT(cl.nom,' ',cl.apaterno,' ',cl.amaterno) LIKE '%$valor%' ";
                    }
                }else{
                    $queryMas.= "";
                }
    
            }
    
            if($countArray == 2){
    
                if($valor != ""){
                    if($queryMas != ""){
    
                        $queryMas.= " AND cl.correo = '$valor' ";
                    }else{
                        $queryMas.= " WHERE cl.correo = '$valor' ";
                    }
                }else{
                    $queryMas.= "";
                }
    
            }
    
            if($countArray == 3){
    
                if($valor != ""){
                    if($queryMas != ""){
    
                        $queryMas.= " AND cl.tel = '$valor' ";
                    }else{
                        $queryMas.= " WHERE cl.tel = '$valor' ";
                    }
                }else{
                    $queryMas.= "";
                }
    
            }

            if($countArray == 4){
    
                if($valor != ""){
                    if($queryMas != ""){
    
                        $queryMas.= " AND com.id_comision = '$valor' ";
                    }else{
                        $queryMas.= " WHERE com.id_comision = '$valor' ";
                    }
                }else{
                    $queryMas.= "";
                }
    
            }

            if($countArray == 5){
    
                if($valor != ""){

                    if($perfil != 'a'){

                        if($queryMas != ""){
    
                            $queryMas.= " AND cr.id_sucursal = '$valor' ";
                        }else{
                            $queryMas.= " WHERE cr.id_sucursal = '$valor' ";
                        }

                    }else{
                        $queryMas.= "";
                    }
                    
                }else{
                    $queryMas.= "";
                }
    
            }
    
    
            $countArray++;
        }
    
        $consultaCompleta    = 
        "SELECT 
        cr.id AS cod,
        cr.estatus AS estatus,
        CONCAT(cl.nom,' ',cl.apaterno,' ',cl.amaterno) AS nombreCliente,
        cl.tel AS telefono,
        cl.correo AS correo,
        cr.total AS total,
        p.nom AS nombreProd,
        com.id_comision,
        cd.iccid as iccid,
        cd.imei as imei
        FROM credito cr
        LEFT JOIN cliente cl
        ON cr.idCliente = cl.codigo 
        LEFT JOIN creditodetalle cd
        ON cr.id = cd.idCredito
        LEFT JOIN producto p 
        ON cd.idProducto = p.cod
        LEFT JOIN comision com
        ON com.id_comision = p.id_comision ".$queryMas." GROUP BY cr.id ORDER BY cr.id DESC";
        
       
       
    
    
    return $consultaCompleta;
    
}

?>




<?php
    session_start();
    error_reporting(E_ALL ^ E_DEPRECATED);
    error_reporting(0);
    include("host.php");
    include("funciones.php"); 
    $usu=$_SESSION['username'];

    $idSucursal = $_SESSION['id_sucursal'];
    if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca' or !$_SESSION['tipo_usu']=='te' or !$_SESSION['tipo_usu']=='su'){
        header('location:error.php');
    }

    ##DATOS POST####
    //$iccid = explode(PHP_EOL, $_POST['iccid']);
    //$iccid = explode(PHP_EOL, $_POST['iccid']);

    $iccid = preg_split('/\r\n|\r|\n/', $_POST['iccid']);

    $arrayLimpio = iccid($iccid);

    if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) 
    {
        foreach($arrayLimpio as $iccid) {
            
            #Verificar que no exista el iccid en caja temp
            $consulta1="SELECT * FROM caja_tmp WHERE iccid = '$iccid'";
            if($paquete = consultar($con,$consulta1)){
                #YA EXISTE EN CAJA TEMP
                $arrayRetorno[]=array('estatus' => '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>'.$iccid.' Error, el ICCID ya se encuentra en el carrito</strong></div>');

            }else{

                $consulta = "SELECT * FROM codigo_producto WHERE identificador = '$iccid'";

                #Verificar que exista en la base de datos
                if($paquete = consultar($con,$consulta)){

                    $fila = mysqli_fetch_array($paquete);
                    $idProducto = trim($fila['id_producto']);
                    $idSucursalIdentificador = trim($fila['id_sucursal']);

                    ##Verificar que el identificador o chip le pertenezaca a esa sucursal
                    if($idSucursal == $idSucursalIdentificador){

                        $consulta2 = "SELECT * FROM producto WHERE cod = '$idProducto' AND id_sucursal = '$idSucursal'";
                        if($paquete = consultar($con,$consulta2)){

                            $filaInsert=mysqli_fetch_array($paquete);

                            $cod            =   $filaInsert['cod'];
                            $nom            =   $filaInsert['nom'];
                            $cant           =   "1";
                            $exitencia      =   $filaInsert['cantidad'];
                            $usu            =   $_SESSION['username'];
                            $tipo_comision  =   $_SESSION['tventa'];

                            if($_SESSION['tventa'] == "venta"){

                                $importe=$filaInsert['venta']; $venta=$filaInsert['venta'];

                            }else if($_SESSION['tventa']=="mayoreo"){

                                $importe=$filaInsert['mayor']; $venta=$filaInsert['mayor'];
                                
                            }else if($_SESSION['tventa']=="especial"){

                                $importe=$filaInsert['especial'];  $venta=$filaInsert['especial'];

                            }

                            $insert="INSERT INTO caja_tmp (cod, nom, venta, cant, importe, exitencia,
                             usu,iccid,nombre_chip,tipo_comision) 
                            VALUES ('$cod','$nom','$venta','$cant','$importe','$exitencia',
                            '$usu','$iccid','$nom','$tipo_comision')";

                            if($paqueteagregar = agregar($con,$insert)){
                                //$b = 1;

                                $arrayRetorno[]=array('estatus' => '<div class="alert alert-success" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>'.$iccid.' Agregado al Carrito</strong></div>');
                            }else{
                                $arrayRetorno[]=array('estatus' => '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>'.$iccid.' Error, no se pudo agregar al carrito</strong></div>');
                            }

                        }

                    }else{
                        $arrayRetorno[]=array('estatus' => '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>'.$iccid.' Error, el ICCID no corresponde a ésta sucursal</strong></div>');
                    }

                }else{
                    $arrayRetorno[]=array('estatus' => '<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert"></button><strong>'.$iccid.' Error, el ICCID no existe</strong></div>');
                }

            }
            
        }
        echo json_encode($arrayRetorno);

        
        


        
    }


    function iccid($array){

        $i=0;
        $arrayLimpio = array();
        if($array != ""){

            foreach($array as $valor) {    
                if(($valor != "")){
    
                    $arrayLimpio[$i] = trim($valor);
                }
                $i++;    
            }
            
        }
        return $arrayLimpio;

    }
    
?>

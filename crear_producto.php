<?php
    session_start();
    include('php_conexion.php'); 
    $id_sucursal = $_SESSION['id_sucursal'];
    if($_SESSION['tipo_usu']!='a' and $_SESSION['tipo_usu']!='su' and $_SESSION['tipo_usu']!='te'){
        header('location:producto.php');
    }

    $permiso = $_SESSION['tipo_usu'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Producto</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="jsV2/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="jsV2/tether.min.js"></script>
    <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Código de barras -->
    <script src="js/jquery-barcode.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf.debug.js"></script>
    <!-- **************** -->


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



        .codebar{
        border: 1px;
        border-style: solid;
        border-color: #000;
        margin-left: 30px;
        margin-bottom: 0px;
        margin-right: 10px;
        margin-top: 10px;
        padding: 5px;
        }
        
        .thumb{
        height: 140px;
        width: 200px;
        border: 1px solid #000;
        margin: 5px 5px 0 0;
        }
        .panel-compra{
        padding-left: 10px;
        padding-top: 10px;
        border-style: solid;
        border-color: #BDBDBD;
        border-top-width: 1px;
        border-right-width: 1px;
        border-bottom-width: 1px;
        border-left-width: 1px;
        }
       
        input{
        text-transform:uppercase;
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
											<p class="black font-weight-bold titulo text-center">CREACIÓN DE PRODUCTOS</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-2">                        

                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">
										<div class="col-md-12">

                                        <div class="row">

                                        
                                            <div class="col-md-3">
                                            <form name="form1" method="post" action="crear_producto.php">
                                                <label for="">Codigo del Articulo</label>                                       
                                                <input class=" form-control" id="ccodigo" name="ccodigo" type="text" placeholder="Codigo del Articulo" maxlength="13">
                                            </div>
                                            <div class="col-md-3">
                                            <br>
                                                <button class="btn  btn-success" id="btnc"  type="submit">Confirmar Codigo</button>
                                                </form>
                                            </div>
                                       
                                            <div class="col-md-3">
                                                <?php 
                                                    if (!empty($_POST['ccodigo']) or !empty($_GET['codigo'])) {
                                                        echo "<canvas  id='Barcode' class='codebar form-control' ></canvas>";                                                  
                                                    }                                    
                                                ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php 
                                                    if (!empty($_POST['ccodigo']) or !empty($_GET['codigo'])) {                                                        
                                                        echo '<button class="btn btn-info" id="btnd" onclick="downloadcodebar();" type="button">Guardar Código en PDF</button>';                                       
                                                    }                                                    
                                                ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">



                                                <!-- inicia agregar y actualizar producto -->
     <?php 
        if(!empty($_POST['codigo'])){
            $gcodigonuevo=strtoupper(trim($_POST['codigonuevo']));
            $gnom=strtoupper($_POST['nom']);        $gprov= strtoupper($_POST['prov']);          $gcosto=strtoupper($_POST['costo']);
            $gmayor=strtoupper($_POST['mayor']);    $gventa=strtoupper($_POST['venta']);        $gcantidad='0'; //$_POST['cantidad'];//+$_POST['cantact'];
            $gminimo=strtoupper($_POST['minimo']);  $gseccion=strtoupper($_POST['seccion']);    $gfecha=strtoupper($_POST['fecha']);
            $gcodigo=strtoupper(trim($_POST['codigo']));  $gcprov=strtoupper($_POST['cprov']);        $unidad=strtoupper($_POST['unidad']);
            $gmarca=strtoupper($_POST['marca']);    $gmodelo=strtoupper($_POST['modelo']);      //$gIMEI=$_POST['imei'];
            $gvalor=strtoupper($_POST['valor']);    $gtipo=strtoupper($_POST['tipo']);          $gcompania=strtoupper($_POST['compania']);
            $color =strtoupper($_POST['color']);   $id_comision=strtoupper($_POST['comision']);$cantidad =$_POST['ncantidad']+$_POST['cantidad'];
            $especial =strtoupper($_POST['especial']);$categoria=strtoupper($_POST['categoria']);
            $imei = $_POST['imei'];
            $iccid = $_POST['iccid'];
            $identifi = $_POST['identifi'];


           

         
            if($gcodigonuevo == "")
            {
               
            
        #identiticadores unicos
            $imeis  = array_filter(explode("\n", $imei));
            $iccids = array_filter(explode("\n", $iccid));
            $identifis = array_filter(explode("\n", $identifi));
        #fin identificadores unicos
            $qcom=mysql_query("SELECT * FROM comision WHERE id_comision='$id_comision'");
            if($data=mysql_fetch_array($qcom)){
                $tipo = $data['tipo'];
            }
            if ($tipo == "FICHA") {
                $gnom = $tipo." ".$gcompania." ".$gvalor;
                $gmarca = "";
            }
            if ($tipo == "CHIP") {
                $gnom = $tipo." ".$gcompania;
                $gmarca = "";
            }
           

           
            $can=mysql_query("SELECT * FROM producto where cod='$gcodigo'");
            if($dato=mysql_fetch_array($can)){
            #nueva entrada de identificador unico  del producto atual
                $contimei  = 0;
                $conticcid = 0;
                if (count($iccids) > 0 && count($imeis) > 0) {
                    //echo "si entra";
                    if (count($iccids) == count($imeis)) {
                    //*******************************************foreach identificador iccid
                        $contfila = 1;
                        foreach ($iccids as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {

                                if (!empty($identificador)) 
                                {
                                    $bandera = validaICCID($identificador);
                                    if($bandera == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $conticcid++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <strong>! Identificador ICCID '.$identificador.' INCORRECTO, capture un ICCID correcto ¡</strong>
                                      </div>';

                                    }
                                }
                            }
                            $contfila++;
                        }
                    //***************************************************fin foreach identificador iccid


                    //*******************************************************foreach identificador imei
                        $contfila = 1;
                        foreach ($imeis as &$identificador) {

                            //$identificador = $iccids($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                
                                if (!empty($identificador)) 
                                {
                                    $banderaIMEI = validaIMEI($identificador);
                                    if($banderaIMEI == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','IMEI','$identificador','$contfila',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $contimei++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Incorrecto, ingrese un IMEI Correcto¡</strong>
                                        </div>';
                                    }
                                }
                            }
                            $contfila++;
                        }
                    //**********************************************************fin foreach identificador imei

                        if ($contimei > 0 && $conticcid > 0) {
                            echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de IMEI´S Registrados '.$contimei.' </strong>
                            </div>';
                            echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de ICCID´S Registrados '.$conticcid.' </strong>
                            </div>';
                        }
                    #Actualizar datos de producto con cantidad
                        if ($contimei == $conticcid) {
                            $gcantidad = $cantidad + $contimei;
                        }else {
                            $gcantidad = $cantidad;
                        }
                        $sql="UPDATE producto SET
                        
                          prov='$gprov',
                                                   cprov='$gcprov',
                                                   nom='$gnom',
                                                   costo='$gcosto',
                                                   mayor='$gmayor',
                                                   venta='$gventa',
                                                   especial='$especial',
                                                   minimo='$gminimo',
                                                   seccion='$gseccion',
                                                   fecha='$gfecha',
                                                   id_comision='$id_comision',
                                                   unidad='$unidad',
                                                   marca='$gmarca',
                                                   modelo='$gmodelo',
                                                   compania='$gcompania',
                                                   valor = '$gvalor',
                                                   tipo_ficha = '$gtipo',
                                                   color = '$color',
                                                   categoria = '$categoria'
                                    WHERE cod='$gcodigo'";
                                    //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                        //echo "con nueva cantidad °_° <br>";
                        mysql_query($sql);
                        $sqlac="UPDATE producto SET  cantidad = '$gcantidad

                                    WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                        $ans = mysql_query($sqlac);
                        if ($ans) {
                            echo '  <div class="alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>Producto / Articulo '.$gnom.' </strong> Actualizado con Exito
                                </div>';
                        }else {
                            echo '  <div class="alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>Producto / Articulo '.$gnom.' </strong> Error Actualización
                                </div>';
                        }
                    #fin Actualizar datos de producto con cantidad
                        $prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';$codigo='';$venta='0';$cprov='';$id_comision='';$id_marca='';
                        $id_modelo='';$IMEI='';
                    }else {
                        echo '<div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert">X</button>
                                <strong>! Cantidad IMEI no coincide con Cantidad ICCID Producto '.$gnom.' No actualizado¡</strong>
                              </div>';
                    }
                }else { // fin if contador imei's and iccid's mayores a 0
                    #Actualizar datos de producto sin cantidad o identificadores iccid ó imei ó identificadores unicos
                    $contimei  = 0;
                    $conticcid = 0;
                    $contidentifi = 0;
                    if (count($iccids) > 0) {
                    #foreach identificador iccid
                        foreach ($iccids as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {

                                if (!empty($identificador)) 
                                {
                                    $bandera = validaICCID($identificador);
                                    if($bandera == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $conticcid++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <strong>! Identificador ICCID '.$identificador.' INCORRECTO, capture un ICCID correcto ¡</strong>
                                      </div>';

                                    }
                                }
                            }
                        }
                    #fin foreach identificador iccid
                    }
                    if (count($identifis) > 0) {
                    #foreach identificador iccid
                        foreach ($identifis as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador UNICO '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                if (!empty($identificador)) {
                                $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                            VALUES ('$gcodigo','identificador ficha','$identificador',NOW(),'s','$id_sucursal')";
                                $answ = mysql_query($sqlc);
                                $contidentifi++;
                                }
                            }
                        }
                    #fin foreach identificador iccid
                    }
                    if (count($imeis) > 0) {
                    #foreach identificador imei
                        foreach ($imeis as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                if (!empty($identificador)) 
                                {
                                    $banderaIMEI = validaIMEI($identificador);
                                    if($banderaIMEI == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','IMEI','$identificador','$contfila',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $contimei++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Incorrecto, ingrese un IMEI Correcto¡</strong>
                                        </div>';
                                    }
                                }
                            }
                        }
                    #fin foreach identificador imei
                    }
                    $sql="UPDATE producto SET
                   
                      prov='$gprov',
                                               cprov='$gcprov',
                                               nom='$gnom',
                                               costo='$gcosto',
                                               mayor='$gmayor',
                                               venta='$gventa',
                                               especial='$especial',
                                               minimo='$gminimo',
                                               seccion='$gseccion',
                                               fecha='$gfecha',
                                               id_comision='$id_comision',
                                               unidad='$unidad',
                                               marca='$gmarca',
                                               modelo='$gmodelo',
                                               compania='$gcompania',
                                               valor = '$gvalor',
                                               tipo_ficha = '$gtipo',
                                               color = '$color',
                                               categoria = '$categoria'
                                WHERE cod='$gcodigo'";
                                //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                    //echo "sin nueva cantidad °_° <br>";
                    $ans1 =  mysql_query($sql);
                    $gcantidad = $cantidad;
                    if ($conticcid > 0) {
                        $gcantidad = $cantidad + $conticcid;
                        echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de ICCID´S Registrados '.$conticcid.' </strong>
                            </div>';
                    }
                    if ($contidentifi > 0) {
                        $gcantidad = $cantidad + $contidentifi;
                        echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de IDENTIFICADORES FICHAS Registrados '.$contidentifi.' </strong>
                            </div>';
                    }
                    if ($contimei > 0) {
                        $gcantidad = $cantidad + $contimei;
                        echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de IMEI´S Registrados '.$contimei.' </strong>
                            </div>';
                    }
                    $sqlac="UPDATE producto SET  cantidad = '$gcantidad'
                                    WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                    $ans = mysql_query($sqlac);
                #fin Actualizar datos de producto sin cantidad
                if ($ans1 && $ans) {
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Producto / Articulo '.$gnom.' </strong> Actualizado con Exito
                        </div>';
                }else {
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Producto / Articulo '.$gnom.' </strong> Error Actualización
                        </div>';
                }
                    $prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';$codigo='';$venta='0';$cprov='';$id_comision='';$id_marca='';
                    $id_modelo='';$IMEI='';
                }
            #-----------------------------------------------------------------

            }else{ //else si no existene la base de datos y eso nuevo producto
                #codigo agregar nuevo producto#
            #nueva entrada de identificador unico  del producto atual
                $conticcid = 0;
                $contimei  = 0;
                $contidentifi = 0;
                if (count($iccids) > 0 && count($imeis) > 0) {

                    if (count($iccids) == count($imeis)) {
                    #foreach identificador iccid
                        $contfila = 1;
                        foreach ($iccids as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                if (!empty($identificador)) 
                                {
                                    $bandera = validaICCID($identificador);
                                    if($bandera == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $conticcid++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <strong>! Identificador ICCID '.$identificador.' INCORRECTO, capture un ICCID correcto ¡</strong>
                                      </div>';

                                    }
                                }
                            }
                            $contfila++;
                        }
                    #fin foreach identificador iccid
                    #foreach identificador imei
                        $contfila = 1;
                        foreach ($imeis as &$identificador) {

                            //$identificador = $iccids($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                            //echo "SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'";
                            if( (mysql_num_rows($queryi)) > 0 ){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                
                                if (!empty($identificador)) 
                                {
                                    $banderaIMEI = validaIMEI($identificador);
                                    if($banderaIMEI == 1)
                                    {

                                        $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,numero,fecha, estado,id_sucursal)
                                                    VALUES ('$gcodigo','IMEI','$identificador','$contfila',NOW(),'s','$id_sucursal')";
                                        $answ = mysql_query($sqlc);
                                        $contimei++;
                                    }else{
                                        echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Incorrecto, ingrese un IMEI Correcto¡</strong>
                                        </div>';
                                    }
                                }
                            }
                            $contfila++;
                        }
                    #fin foreach identificador imei
                        if ($contimei > 0 AND $conticcid > 0) {
                            echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de IMEI´S Registrados '.$contimei.' </strong>
                            </div>';
                            echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Numero de ICCID´S Registrados '.$conticcid.' </strong>
                            </div>';
                        }
                    }else {
                        if ($tipo != "CHIP") {
                            echo '<div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <strong>! Cantidad IMEI no coincide con Cantidad ICCID¡</strong>
                                  </div>';
                        }
                    }
                }

                if (count($iccids) > 0 && $tipo == "CHIP") {
                #foreach identificador iccid
                    foreach ($iccids as &$identificador) {
                        
                        //$identificador = $imeis($i);//$_POST['identificador'];
                        $identificador = trim($identificador);
                        $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                        if( (mysql_num_rows($queryi)) > 0 ){
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                    </div>';
                        }else {
                            if (!empty($identificador)) 
                            {
                                $bandera = validaICCID($identificador);
                                if($bandera == 1)
                                {

                                    $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                    $answ = mysql_query($sqlc);
                                    $conticcid++;
                                }else{
                                    echo '  <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                    <strong>! Identificador ICCID '.$identificador.' INCORRECTO, capture un ICCID correcto ¡</strong>
                                  </div>';

                                }
                            }
                        }
                    }
                #fin foreach identificador iccid
                }
                if (count($identifis) > 0 && $tipo == "FICHA") {
                #foreach identificador iccid
                    foreach ($identifis as &$identificador) {
                        
                        //$identificador = $imeis($i);//$_POST['identificador'];
                        $identificador = trim($identificador);
                        $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                        if( (mysql_num_rows($queryi)) > 0 ){
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! Identificador UNICO '.$identificador.' Existente ¡</strong>
                                    </div>';
                        }else {
                            if (!empty($identificador)) {
                            $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                        VALUES ('$gcodigo','identificador ficha','$identificador',NOW(),'s','$id_sucursal')";
                            $answ = mysql_query($sqlc);
                            $contidentifi++;
                            }
                        }
                    }
                #fin foreach identificador iccid
                }
                if (count($imeis) > 0 && $tipo == "TELEFONO" && count($iccids) == 0) {
                #foreach identificador iccid
                    foreach ($imeis as &$identificador) {
                        
                        //$identificador = $imeis($i);//$_POST['identificador'];
                        $identificador = trim($identificador);
                        $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = '$identificador'");
                        if( (mysql_num_rows($queryi)) > 0 ){
                            echo '  <div class="alert alert-warning">
                                      <button type="button" class="close" data-dismiss="alert">X</button>
                                      <strong>! IMEI '.$identificador.' Existente ¡</strong>
                                    </div>';
                        }else {
                            if (!empty($identificador)) {
                            $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                        VALUES ('$gcodigo','IMEI','$identificador',NOW(),'s','$id_sucursal')";
                            $answ = mysql_query($sqlc);
                            $contimei++;
                            }
                        }
                    }
                #fin foreach identificador iccid
                }
            #-----------------------------------------------------------------
            #agregar el registro mas los identificadores unicos
                $gcantidad = $cantidad;
                $can=mysql_query("SELECT * FROM empresa");
                while($dato=mysql_fetch_array($can)){
                    $id_suc = $dato['id'];
                    $sql = "INSERT INTO producto (cod, prov, cprov, nom,costo, mayor, venta,especial,cantidad, minimo, seccion, fecha, estado,id_comision, unidad,id_sucursal,marca,modelo,compania,valor,tipo_ficha,color,categoria)
                             VALUES ('$gcodigo','$gprov','$gcprov','$gnom','$gcosto','$gmayor','$gventa','$especial','0','$gminimo','$gseccion','$gfecha','s','$id_comision','$unidad','$id_suc','$gmarca','$gmodelo','$gcompania','$gvalor','$gtipo','$color','$categoria')";
                    $answer = mysql_query($sql);
                    
                    if ($answer == '1' AND $id_suc == $id_sucursal) {
                        //echo "suc_database: ".$id_suc." suc_session: ".$id_sucursal."<br>";
                    #sumar cantidad de chip
                        if ($conticcid > 0 && $contimei == 0) {//si contador imei es menor a 0
                            $gcantidad = $cantidad + $conticcid;
                            echo '  <div class="alert alert-success">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>Numero de ICCID´S Registrados '.$conticcid.' </strong>
                                </div>';
                        }
                    #fin sumar cantidad de chip
                    #sumar cantidad de fichas
                        if ($contidentifi > 0) {
                            $gcantidad = $cantidad + $contidentifi;
                            echo '  <div class="alert alert-success">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>Numero de IDENTIFICADORES FICHAS Registrados '.$contidentifi.' </strong>
                                </div>';
                        }
                    #fin sumar cantidad de fichas
                    #sumar cantidad de telefonos sin chip
                        if ($contimei > 0 AND $conticcid == 0) {
                            $gcantidad = $cantidad + $contimei;
                            echo '  <div class="alert alert-success">
                                  <button type="button" class="close" data-dismiss="alert">X</button>
                                  <strong>Numero de IMEI´S Registrados '.$contimei.' </strong>
                                </div>';
                        }
                    #fin sumar cantidad de telefonos sin chip
                        if ($contimei > 0 AND $conticcid > 0){
                            $sqlac="UPDATE producto SET  cantidad = '$contimei'
                                        WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                        }else{
                            $sqlac="UPDATE producto SET  cantidad = '$gcantidad'
                                        WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                        }
                        //echo "query: ".$sqlac."<br>";
                        $ans = mysql_query($sqlac);
                        /*$sql="UPDATE producto SET  cantidad = '$contimei'
                                    WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                                    //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                        mysql_query($sql);*/
                    }
                }
            #fin agregar el registro mas los identificadores unico
                if ($answer == 1) {
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Producto / Articulo '.$gnom.' </strong> Guardado con Exito
                            </div>';
                }else {
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Producto / Articulo '.$gnom.' </strong> No fue Guardado
                            </div>';
                }
            }
            //----------------------------------------------------------------------------
            $extension = end(explode('.', $_FILES['files']['name']));
            $foto = $gcodigo."."."jpg";
            $directorio = 'articulo'; //dirname('articulo'); // directorio de tu elección
            
            // almacenar imagen en el servidor
            move_uploaded_file($_FILES['files']['tmp_name'], $directorio.'/'.$foto);
            $minFoto = 'min_'.$foto;
            $resFoto = 'res_'.$foto;
            resizeImagen($directorio.'/', $foto, 65, 65,$minFoto,$extension);
            resizeImagen($directorio.'/', $foto, 500, 500,$resFoto,$extension);
            unlink($directorio.'/'.$foto);
            //---------------------------------------------------------------------------
        
        

        
    
}
    
    else
    {
        ## Verificar si existe el codigo en otros prodcutos ##
        
        $consultaProd = "SELECT * FROM producto WHERE cod = '$gcodigonuevo'";
        $paqcod = mysql_query($consultaProd);
        if(mysql_num_rows($paqcod)>0){

            echo '  <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>Lo sentimos, el código del producto '.$gcodigonuevo.' </strong> Ya está asignado a otro producto.<br>
            <strong>Intente con un código diferente</strong>
          </div>';

        }else{

            $updtblcodigos="UPDATE codigo_producto SET id_producto = '$gcodigonuevo' WHERE id_producto = '$gcodigo'";
            $ejecutar1=mysql_query($updtblcodigos);
    
            $consultaNuevoCodigo="UPDATE producto SET cod = '$gcodigonuevo' WHERE cod = '$gcodigo'";
            $ejecutar=mysql_query($consultaNuevoCodigo);
    
            $consultaNuevoCodigoML = "UPDATE movimientosxlote SET IdProducto = '$gcodigonuevo' WHERE IdProducto = '$gcodigo'";
            $ejecutar2=mysql_query($consultaNuevoCodigoML);
    
            $consultaNuevoCodigoDetalle = "UPDATE detalle SET codigo = '$gcodigonuevo' WHERE codigo = '$gcodigo'";
            $ejecutar3=mysql_query($consultaNuevoCodigoDetalle); 

            $consultaNuevoCodigoCDetalle = "UPDATE creditodetalle SET idProducto = '$gcodigonuevo' WHERE idProducto = '$gcodigo'";
            $ejecutar4=mysql_query($consultaNuevoCodigoCDetalle); 
    
    
    
            if($ejecutar && $ejecutar1 && $ejecutar2 && $ejecutar3 && $ejecutar4)
            {
                  echo '  <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>Producto / Articulo '.$gnom.' </strong> Guardado con Exito con nuevo CODIGO
              </div>';          
    
            }
            else{
                echo '  <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>Producto / Articulo '.$gnom.' </strong> No fue Guardado
              </div>';
            }

        }



    }
}
        

        ?>
         <!-- finaliza agregar y actualizar producto -->

         <?php 
		//echo $_POST['codigo'];
		if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){

			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';$unidad='';$modelo = "";$valor="";$tipo="";$compania="";$especial='0';
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");

            if(!empty($_POST['codigo'])){
                $codigo=$_POST['codigo'];
            }
            
            $CodOne=$_POST['ccodigo'];
			if(!empty($_POST['ccodigo']) && is_numeric($_POST['ccodigo'])){
                $LongCode=strlen($CodOne);
                #formula obtener digito adicional de codigo de barras ||ean13|| 
                $codig=$_POST['ccodigo'];
                $ac = str_split($codig);
                

                #Fin formula obtener digito adicional de codigo de barras ||ean13||
                $codigo = $codig;

                if($LongCode<13){   
                    $codigo = $CodOne;
                }else{
                    $valcog = $CodOne;
                }

            }else{
                $codigo = $CodOne;
            }

            if(!empty($_GET['codigo'])){
				$codigo=$_GET['codigo'];
			}
			$can=mysql_query("SELECT * FROM producto where cod='$codigo' AND id_sucursal = '$id_sucursal'");
			if($dato=mysql_fetch_array($can)){
				$prov=$dato['prov'];
				$cprov=$dato['cprov'];
				$nom=trim($dato['nom']);
				$costo=$dato['costo'];
				$mayor=$dato['mayor'];
				$venta=$dato['venta'];
				$cantidad=$dato['cantidad'];
				$minimo=$dato['minimo'];
                $id_comision=$dato['id_comision'];
				$seccion=$dato['seccion'];
				$fechay=$dato['fecha'];
                $unidad=$dato['unidad'];
                $id_sucursal = $dato['id_sucursal'];
                $marca = $dato['marca'];
                $modelo = $dato['modelo'];
                $compania = $dato['compania'];
                $valor=$dato['valor'];
                $tipo=$dato['tipo_ficha'];
                $categoria = $dato['categoria'];
                $IMEI= $dato['imei'];
                $color = $dato['color'];
                $especial = $dato['especial'];
				$boton="Actualizar Producto";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo '.$nom.' </strong> con el codigo '.$codigo.' existe
					   </div>';
                $qucom=mysql_query("SELECT * FROM comision WHERE id_comision='$id_comision'");
                if($data=mysql_fetch_array($qucom)){
                    $TipoComision = $data['tipo'];
                }
			}else{
				$boton="Guardar Producto";
			}
	?>



                                            </div> 

                                                                                             
                                        </div>

                                        <div class="row">

                                            <div class="col-md-3">
                                            <form name="form2" method="post" enctype="multipart/form-data" action="crear_producto.php">
                                                
                                                <input class="form-check-input" type="checkbox" id="check" onclick="toggleBoxVisibility()">
                                                <label class="form-check-label">Actualizar Código</label>
                                            </div>

                                            <div class="col-md-3">
                                                <div id="divcodigonuevo" style="display :none;">
                                                    <label>Código Nuevo</label>
                                                    <input class="form-control"  type="text" name="codigonuevo" id="codigonuevo" value="" placeholder="Código Nuevo">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Código</label>
                                                <input class="form-control" type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?> " readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Tipo Articulo/Servicio</label> 
                                                <select class="form-control" name="comision" id="comision" class="comision" required>
                                                    <option value="">Elige una opcion</option>
                                                    <?php
                                                        $can=mysql_query("SELECT * FROM comision WHERE tipo != 'REPARACION' AND tipo != 'RECARGA'");
                                                        while($dato=mysql_fetch_array($can)){
                                                    ?>
                                                    <option value="<?php echo $dato['id_comision']; ?>" <?php if($id_comision==$dato['id_comision']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label  id="lcategoria" <?php if (empty($categoria)) { echo 'style="display:none;visibility:hidden;"'; } ?>>Categoria</label>
                                                <input class="form-control" type="text" name="categoria" id="categoria" value="<?php echo $categoria; ?>" <?php if (empty($categoria)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

                                                <label id="lmarca" <?php if ($TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>>Marca</label>
                                                <input class="form-control"  type="text" name="marca" id="marca" value="<?php echo $marca; ?>" <?php if ($TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?> >

                                                <label  id="lmodelo" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?>>Modelo</label>
                                                <input class="form-control" type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

                                                <label id="lcompania" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?>>Confirmar Nombre/Compañia</label>
                                                <input class="form-control" type="text" name="compania" id="compania" value="<?php echo $compania; ?>" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

                                                <label id="lvalor" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?>>Valor</label>
                                                <input class="form-control" type="text" name="valor" id="valor" value="<?php echo $valor; ?>" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

                                                <label id="ltipo" for="" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >Tipo</label>
                                                
                                                <label id="lltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
                                                <input type="radio" name="tipo" id="optionsRadios2" value="normal" <?php if($tipo=="NORMAL"){ echo 'checked'; } ?>>Normal
                                                </label>

                                                <label id="llltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
                                                <input  type="radio"   name="tipo" id="optionsRadios1" value="distribuidor" <?php if($tipo=="DISTRIBUIDOR"){ echo 'checked'; } ?>>Distribuidor
                                                </label>

                                                <label id="lcolor" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?>>Color</label>
                                                <input class="form-control" type="text" name="color" id="color" value="<?php echo $color; ?>" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
                                                                                

                                            </div>
                                            <div class="col-md-3">
                                                <label id="lnombre" >Nombre</label>
                                                <input class="form-control" type="text" name="nom" id="nom" value="<?php echo $nom; ?>" maxlength="250">                                            
                                            </div>
                                            <div class="col-md-3">

                                                <label>Proveedor</label>
                                                <input class="form-control" name="prov" id='prov' type="text" class="span2" size="60" list="proveedor" placeholder="Proveedor" value="<?php echo $prov ?>">
                                                <datalist id="proveedor">
                                                <?php 
                                                          
                                                    $can=mysql_query("SELECT * FROM proveedor where estado='s'");
                                                    while($dato=mysql_fetch_array($can)){
                                                        echo "<option value='$dato[empresa]'></option>";                    
                                                    } 
                                                ?>
                                                </datalist>
                                            
                                            </div>
                                            <div class="col-md-3">
                                                <label>Fecha</label>
                                                <input class="form-control" type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>                                                            
                                            </div>                       
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Precio Costo</label>                                           
                                                <input class="form-control" type="text" name="costo" id="costo" value="<?php echo $costo; ?>" required> 
                                            </div>
                                            <div class="col-md-3">
                                                <label>Precio Especial</label>                                           
                                                <input class="form-control" type="text" name="especial" id="especial" value="<?php echo $especial; ?>" required> 
                                            </div>
                                            <div class="col-md-3">
                                                <label>Precio Mayoreo</label>                                            
                                                <input class="form-control" type="text" name="mayor" id="mayor" value="<?php echo $mayor; ?>" required>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <label>Precio Venta</label>                                               
                                                <input class="form-control" type="text" name="venta" id="venta" value="<?php echo $venta; ?>" required>                                                    
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Cantidad Actual</label>
                                                <input class="form-control" type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" required maxlength="25" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label>+ Nueva Cantidad</label>
                                                <input class="form-control" type="number" name="ncantidad" id="ncantidad" value="0" maxlength="3" min="0" pattern=" 0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  <?php if ($TipoComision == 'TELEFONO' or $TipoComision == 'CHIP' or $TipoComision == 'FICHA') {
                                                        echo 'readonly';
                                                    } ?>>                                            
                                            </div>
                                            <div class="col-md-3">
                                                <label>Cantidad Minima</label>
                                                <input class="form-control" type="text" name="minimo" id="minimo" value="<?php echo $minimo; ?>" maxlength="25">                                            
                                            </div>
                                            <div class="col-md-3">
                                                <label>Seccion del Articulo</label> 
                                                <select class="form-control" name="seccion" id="seccion">
                                                <?php
                                                    $can=mysql_query("SELECT * FROM seccion where estado='s'");
                                                    while($dato=mysql_fetch_array($can)){
                                                ?>
                                                <option value="<?php echo $dato['id']; ?>" <?php if($seccion==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
                                                <?php } ?>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">

                                                <label>Unidad de medida</label>
                                                <select class="form-control" name="unidad" id="unidad">
                                                <?php
                                                    $can=mysql_query("SELECT * FROM unidad_medida");
                                                    while($dato=mysql_fetch_array($can)){ ?>
                                                <option value="<?php echo $dato['id']; ?>" <?php if($unidad==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
                                                <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-md-3">

                                                <label id="limei" for="textfield" <?php if ($TipoComision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?> >IMEI</label>
                                                <textarea class="form-control" name="imei" id="imei" cols="15" rows="10" value="" <?php if ($TipoComision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
                                                
                                                <label id="lidentifi" for="textfield" <?php if ($TipoComision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?> >IDENTIFICADOR</label>
                                                <textarea class="form-control" name="identifi" id="identifi" cols="15" rows="10" value="" <?php if ($TipoComision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
                                                
                                                <label id="liccid" for="textfield" <?php if ($TipoComision != 'TELEFONO' and $TipoComision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>>ICCID</label>
                                                <textarea class="form-control" name="iccid" id="iccid" cols="15" rows="10" value="" <?php if ($TipoComision != 'TELEFONO' and $TipoComision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea>
                                                                                
                                            </div>
                                            <div class="col-md-3">

                                                <label>Imagen del Producto</label>                                                
                                                <?php
                                                    if (file_exists("articulo/".$codigo.".jpg")){
                                                        echo '<img src="articulo/'.$codigo.'.jpg" width="200" height="200" class="img-polaroid">';
                                                    }else{

                                                    }
                                                ?>
                                                <br>
                                                <output id="list"></output>
                                                    <input class="form-control-file btn btn-primary btn-sm" type="file" name="files" id="files">
                                                    
                                                    
                                                
                                            </div>
                                            
                                            
                                        </div>
                                        <br>
                                        <div clas="row">
                                            <div class="col-md-12">
                                            
                                                <button type="submit"  class="btn btn-primary"><?php echo $boton; ?></button>
                                                <?php } ?>
                                                </form>

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

<script>
          function archivo(evt) {
              var files = evt.target.files; // FileList object
              // Obtenemos la imagen del campo "file".
              for (var i = 0, f; f = files[i]; i++) {
                //Solo admitimos imágenes.
                if (!f.type.match('image.*')) {
                    continue;
                }
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                      // Insertamos la imagen
                     document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    };
                })(f);
                reader.readAsDataURL(f);
              }
          }
          document.getElementById('files').addEventListener('change', archivo, false);
</script>
    
  <script>
        $(document).ready(function(){
            var codigob = "<?= $valcog; ?>"//$('#codigo').val();
            //alert(codigob);

            //$('#Barcode').barcode(codigob,"ean13",{barWidth:2,barHeight:50,output:"canvas"});//
            //$('#Barcode').barcode(codigob,"code128",{barWidth:1,barHeight:50,output:"Canvas"});//

            $('#Barcode').barcode(codigob, "code128",{barWidth:1, barHeight:30,output:"Canvas"});;//
            //$('#Barcode').barcode(codigob,"code128");

            
            //descargar en pdf automaticamente
            $('#btnd').click(function() {       
            html2canvas($("#Barcode"), {
                onrendered: function(canvas) {   
                    var codigob = $('#codigo').val();      
                    var imgData = canvas.toDataURL("image/png");              
                    var doc = new jsPDF('p', 'mm');
                    doc.addImage(imgData, 'PNG', 10, 10);
                    doc.save(codigob+'.pdf');
                }
            });
        });
            $("#comision").change(function() {
              var ValorComision = "";//$("#comision option:selected").html();
              var Identificador = $("#comision").val();
              var url="id="+Identificador;
              //alert(url);
              $.ajax({
                type:'POST',
                url: "ConsultaComision.php?"+url,
                }).done(function(datos){
                   if(datos == 0){ 
                        //alert("Ocurrio un error al consultar comisiones");
                        //jAlert("Error en el registro", "AIKO SOLUCIONES");
                       }else{
                        //alert(datos);
                        ValorComision = datos;
                        $("#categoria").css({"visibility": "hidden","display": "none"});
                        $("#categoria").removeAttr("required");
                        $("#lcategoria").css({"visibility": "hidden","display": "none"});
                      if (ValorComision == "TELEFONO" || ValorComision == "Telefono" || ValorComision == "telefono") {
                        $("#modelo").css({"visibility": "visible","display": "block"});
                        $("#lmodelo").css({"visibility": "visible","display": "block"});
                        $("#modelo").attr("required","true");
                        $("#color").css({"visibility": "visible","display": "block"});
                        $("#lcolor").css({"visibility": "visible","display": "block"});
                        //$("#color").attr("required","true");
                        $("#compania").css({"visibility": "visible","display": "block"});
                        //$("#compania").attr("required","true");
                        $("#lcompania").css({"visibility": "visible","display": "block"});

                        $("#nom").css({"visibility": "visible","display": "block"});
                        $("#lnombre").css({"visibility": "visible","display": "block"});
                        //$("#nom").attr("required","true");
                        $("#nom").removeAttr("required");
                        $("#marca").css({"visibility": "visible","display": "block"});
                        $("#lmarca").css({"visibility": "visible","display": "block"});
                        $("#marca").attr("required","true");

                        $("#limei").css({"visibility": "visible","display": "block"});
                        $("#imei").css({"visibility": "visible","display": "block"});
                        //$("#imei").removeAttr("required");
                        $("#liccid").css({"visibility": "visible","display": "block"});
                        $("#iccid").css({"visibility": "visible","display": "block"});
                        //$("#iccid").removeAttr("required");

                        /*$("#compania").css({"visibility": "hidden","display": "none"});
                        $("#compania").removeAttr("required");
                        $("#lcompania").css({"visibility": "hidden","display": "none"});*/
                        $("#valor").css({"visibility": "hidden","display": "none"});
                        $("#valor").removeAttr("required");
                        $("#lvalor").css({"visibility": "hidden","display": "none"});
                        $("#tipo").css({"visibility": "hidden","display": "none"});
                        $("#tipo").removeAttr("required");
                        $("#ltipo").css({"visibility": "hidden","display": "none"});
                        $("#lltipo").css({"visibility": "hidden","display": "none"});
                        $("#llltipo").css({"visibility": "hidden","display": "none"});

                        $("#lidentifi").css({"visibility": "hidden","display": "none"});
                        $("#identifi").css({"visibility": "hidden","display": "none"});

                        $("#ncantidad").prop("readonly",true);
                        //$("#identifi").removeAttr("required");

                      }else{
                          if (ValorComision == "CHIP" || ValorComision == "Chip" || ValorComision == "chip") {
                            $("#compania").css({"visibility": "visible","display": "block"});
                            $("#lcompania").css({"visibility": "visible","display": "block"});
                            $("#modelo").attr("required","true");

                            $("#liccid").css({"visibility": "visible","display": "block"});
                            $("#iccid").css({"visibility": "visible","display": "block"});
                            $("#tipo").css({"visibility": "visible","display": "block"});
                            $("#tipo").attr("required","true");
                            $("#ltipo").css({"visibility": "visible","display": "block"});
                            $("#lltipo").css({"visibility": "visible","display": "block"});
                            $("#llltipo").css({"visibility": "visible","display": "block"});
                            //$("#iccid").removeAttr("required");

                            $("#modelo").css({"visibility": "hidden","display": "none"});
                            $("#modelo").removeAttr("required");
                            $("#lmodelo").css({"visibility": "hidden","display": "none"});
                            $("#valor").css({"visibility": "hidden","display": "none"});
                            $("#valor").removeAttr("required");
                            $("#lvalor").css({"visibility": "hidden","display": "none"});
                            /*$("#tipo").css({"visibility": "hidden","display": "none"});
                            $("#tipo").removeAttr("required");
                            $("#ltipo").css({"visibility": "hidden","display": "none"});
                            $("#lltipo").css({"visibility": "hidden","display": "none"});
                            $("#llltipo").css({"visibility": "hidden","display": "none"});*/
                            $("#color").css({"visibility": "hidden","display": "none"});
                            $("#lcolor").css({"visibility": "hidden","display": "none"});
                            $("#color").removeAttr("required");

                            $("#nom").css({"visibility": "hidden","display": "none"});
                            $("#lnombre").css({"visibility": "hidden","display": "none"});
                            $("#nom").removeAttr("required");
                            $("#marca").css({"visibility": "hidden","display": "none"});
                            $("#lmarca").css({"visibility": "hidden","display": "none"});
                            $("#marca").removeAttr("required");                                

                            $("#lidentifi").css({"visibility": "hidden","display": "none"});
                            $("#identifi").css({"visibility": "hidden","display": "none"});
                            //$("#identifi").removeAttr("required");
                            $("#limei").css({"visibility": "hidden","display": "none"});
                            $("#imei").css({"visibility": "hidden","display": "none"});
                            $("#ncantidad").prop("readonly",true);
                            //$("#imei").removeAttr("required");
                          }else{
                              if (ValorComision == "FICHA" || ValorComision == "Ficha" || ValorComision == "ficha") {
                                /*$("#tipo").css({"visibility": "visible","display": "block"});
                                $("#tipo").attr("required","true");
                                $("#ltipo").css({"visibility": "visible","display": "block"});
                                $("#lltipo").css({"visibility": "visible","display": "block"});
                                $("#llltipo").css({"visibility": "visible","display": "block"});*/
                                $("#compania").css({"visibility": "visible","display": "block"});
                                $("#compania").attr("required","true");
                                $("#lcompania").css({"visibility": "visible","display": "block"});
                                $("#valor").css({"visibility": "visible","display": "block"});
                                $("#valor").attr("required","true");
                                $("#lvalor").css({"visibility": "visible","display": "block"});

                                $("#lidentifi").css({"visibility": "visible","display": "block"});
                                $("#identifi").css({"visibility": "visible","display": "block"});
                                //$("#identifi").removeAttr("required");

                                $("#modelo").css({"visibility": "hidden","display": "none"});
                                $("#modelo").removeAttr("required");
                                $("#lmodelo").css({"visibility": "hidden","display": "none"});
                                $("#color").css({"visibility": "hidden","display": "none"});
                                $("#lcolor").css({"visibility": "hidden","display": "none"});
                                $("#color").removeAttr("required");

                                $("#nom").css({"visibility": "hidden","display": "none"});
                                $("#lnombre").css({"visibility": "hidden","display": "none"});
                                $("#nom").removeAttr("required");
                                $("#marca").css({"visibility": "hidden","display": "none"});
                                $("#lmarca").css({"visibility": "hidden","display": "none"});
                                $("#marca").removeAttr("required");                                

                                $("#limei").css({"visibility": "hidden","display": "none"});
                                $("#imei").css({"visibility": "hidden","display": "none"});
                                //$("#imei").removeAttr("required");
                                $("#liccid").css({"visibility": "hidden","display": "none"});
                                $("#iccid").css({"visibility": "hidden","display": "none"});
                                $("#ncantidad").prop("readonly",true);
                                //$("#iccid").removeAttr("required");
                                

                              }else{
                                
                                $("#compania").css({"visibility": "hidden","display": "none"});
                                $("#compania").removeAttr("required");
                                $("#lcompania").css({"visibility": "hidden","display": "none"});
                                $("#modelo").css({"visibility": "hidden","display": "none"});
                                $("#modelo").removeAttr("required");
                                $("#lmodelo").css({"visibility": "hidden","display": "none"});
                                $("#valor").css({"visibility": "hidden","display": "none"});
                                $("#valor").removeAttr("required");
                                $("#lvalor").css({"visibility": "hidden","display": "none"});
                                $("#tipo").css({"visibility": "hidden","display": "none"});
                                $("#tipo").removeAttr("required");
                                $("#ltipo").css({"visibility": "hidden","display": "none"});
                                $("#lltipo").css({"visibility": "hidden","display": "none"});
                                $("#llltipo").css({"visibility": "hidden","display": "none"});
                                $("#color").css({"visibility": "hidden","display": "none"});
                                $("#lcolor").css({"visibility": "hidden","display": "none"});
                                $("#color").removeAttr("required");
                                $("#ncantidad").prop("readonly",false);

                                $("#limei").css({"visibility": "hidden","display": "none"});
                                $("#imei").css({"visibility": "hidden","display": "none"});
                                //$("#imei").removeAttr("required");
                                $("#liccid").css({"visibility": "hidden","display": "none"});
                                $("#iccid").css({"visibility": "hidden","display": "none"});
                                //$("#iccid").removeAttr("required");
                                $("#lidentifi").css({"visibility": "hidden","display": "none"});
                                $("#identifi").css({"visibility": "hidden","display": "none"});
                                //$("#identifi").removeAttr("required");

                                $("#nom").css({"visibility": "visible","display": "block"});
                                $("#lnombre").css({"visibility": "visible","display": "block"});
                                $("#nom").attr("required","true");
                                $("#marca").css({"visibility": "visible","display": "block"});
                                $("#lmarca").css({"visibility": "visible","display": "block"});
                                $("#marca").attr("required","true");

                                
                                if (ValorComision == "REFACCION") {
                                    $("#categoria").css({"visibility": "visible","display": "block"});
                                    $("#categoria").attr("required","true");
                                    $("#lcategoria").css({"visibility": "visible","display": "block"});
                                    $("#color").css({"visibility": "visible","display": "block"});
                                    //$("#color").attr("required","true");
                                    $("#lcolor").css({"visibility": "visible","display": "block"});
                                }
                              }
                          }
                      }
                        //jAlert("Módulo agregado correctamente", "AIKO SOLUCIONES");
                        //onkeyup="javascript:this.value=this.value.toUpperCase();"
                      }
                });


              //var ValorComision = $("#comision").text;
              /*if (ValorComision == "TELEFONO" || ValorComision == "Telefono" || ValorComision == "telefono") {
                $("#imei").removeAttr("readonly");
              }else{
                $("#imei").val("");
                $("#imei").attr('readonly', true);
              }*/
            });

           

        });




function toggleBoxVisibility() {
    var usuario = "<?php echo  $permiso; ?>";

if (document.getElementById("check").checked == true) {

    $("#divcodigonuevo").css({"visibility": "visible","display": "block"});
$("#codigonuevo").attr("required","true");
$("#codigonuevo").val("");
$("#comision").attr("readonly", "true");
$("#marca").attr("readonly", "true");
$("#nom").attr("readonly", "true");
$("#prov").attr("readonly", "true");
$("#fecha").attr("readonly", "true");
$("#costo").attr("readonly", "true");
$("#especial").attr("readonly", "true");
$("#mayor").attr("readonly", "true");
$("#venta").attr("readonly", "true");

//if(usuario == "a"){

//}else{
    $("#cantidad").attr("readonly", "true");
//}

$("#minimo").attr("readonly", "true");
$("#seccion").attr("readonly", "true");
$("#unidad").attr("readonly", "true");
$("#imei").attr("readonly", "true");
$("#ncantidad").attr("readonly", "true");
$("#categoria").attr("readonly", "true");
$("#color").attr("readonly", "true");
$("#modelo").attr("readonly", "true");
$("#compania").attr("readonly", "true");
$("#iccid").attr("readonly", "true");
$("#valor").attr("readonly", "true");
$("#identifi").attr("readonly", "true");
$("#files").attr("readonly", "true");


    } 
else {

    $("#divcodigonuevo").css({"visibility": "visible","display": "none"});
    $("#codigonuevo").removeAttr("required");
    $("#codigonuevo").val("");
    $("#comision").removeAttr("readonly");
$("#marca").removeAttr("readonly");
$("#nom").removeAttr("readonly");
$("#prov").removeAttr("readonly");
$("#fecha").removeAttr("readonly");
$("#costo").removeAttr("readonly");
$("#especial").removeAttr("readonly");
$("#mayor").removeAttr("readonly");
$("#venta").removeAttr("readonly");



if(usuario == "a"){

    $("#cantidad").removeAttr("readonly");
}



$("#minimo").removeAttr("readonly");
$("#seccion").removeAttr("readonly");
$("#unidad").removeAttr("readonly");
$("#imei").removeAttr("readonly");
$("#ncantidad").removeAttr("readonly");
$("#categoria").removeAttr("readonly");
$("#color").removeAttr("readonly");
$("#modelo").removeAttr("readonly");
$("#compania").removeAttr("readonly");
$("#iccid").removeAttr("readonly");
$("#valor").removeAttr("readonly");
$("#identifi").removeAttr("readonly");
$("#files").removeAttr("readonly");

    }
}



    </script>          


<?php
function validaICCID ($cadena)
{
$cuantos=strlen($cadena);
$nodo=1;
for($y=0;$y<$cuantos;$y++) 
{
$aux=substr($cadena,$y,1);
if($nodo==1 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=2;}
else{
if($nodo==2 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=3; }
else {
if($nodo==3 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=4;}
else {
if($nodo==4 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=5;}
else {
if($nodo==5 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=6;}
else {
if($nodo==6 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=7;}
else{
if($nodo==7 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=8;}
else{
if($nodo==8 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=9;}
else{
if($nodo==9 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=10;}
else{
if($nodo==10 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=11;}
else{
if($nodo==11 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=12;}
else{
if($nodo==12 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=13;}
else{
if($nodo==13 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=14;}
else{
if($nodo==14 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=15;}
else{
if($nodo==15 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=16;}
else{
if($nodo==16 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=17;}
else{
if($nodo==17 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=18;}
else{
if($nodo==18 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=19;}
else{
if($nodo==19 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=20;}
else{
if($nodo==20 and ord($aux)==70 or ord($aux)==102) {
$nodo=21;}
else{
$nodo=0;
break;
}
}
}
}
}
}
}

}
}
}
}
}
}    
} 
}
}
}
}
}
}
}
if($nodo==20 or $nodo==21){
return 1;
}
else{
return 0;
}
}


function validaIMEI($cadena)
{
$cuantos=strlen($cadena);
$nodo=1;
for($y=0;$y<$cuantos;$y++) 
{
$aux=substr($cadena,$y,1);
if($nodo==1 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=2;}
else{
if($nodo==2 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=3; }
else {
if($nodo==3 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=4;}
else {
if($nodo==4 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=5;}
else {
if($nodo==5 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=6;}
else {
if($nodo==6 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=7;}
else{
if($nodo==7 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=8;}
else{
if($nodo==8 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=9;}
else{
if($nodo==9 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=10;}
else{
if($nodo==10 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=11;}
else{
if($nodo==11 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=12;}
else{
if($nodo==12 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=13;}
else{
if($nodo==13 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=14;}
else{
if($nodo==14 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=15;}
else{
if($nodo==15 and ord($aux)>=48 and ord($aux)<=57) {
$nodo=16;}
else{
$nodo=0;
break;
}
}
}
}
}
}
}
}    
} 
}
}
}
}
}
}
}
if($nodo==16){
return 1;
}
else{
return 0;
}
}

?>

<script>
$(document).ready(function(){
    var permiso = "<?php echo $permiso; ?>";

    if(permiso == "a"){
        $("#cantidad").removeAttr("readonly");

    }

    

});
</script>

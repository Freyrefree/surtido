<?php
		session_start();
		include('php_conexion.php'); 
        $id_sucursal = $_SESSION['id_sucursal'];
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
        $valcog = $_POST['ccodigo'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-affix.js"></script>
    <script src="js/holder/holder.js"></script>
    <script src="js/google-code-prettify/prettify.js"></script>
    <script src="js/application.js"></script>
    <script src="js/jquery-barcode.js"></script>
    <script src="js/html2canvas.js"></script>
    <script src="js/jspdf.debug.js"></script>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <script>
        $(document).ready(function(){
            var codigob = "<?= $valcog; ?>"//$('#codigo').val();

            $('#Barcode').barcode(codigob,"ean13",{barWidth:2,barHeight:50,output:"canvas"});//
            //$("#Barcode").barcode(codigob, "ean13",{barWidth:2, barHeight:30});
            
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
                      if (ValorComision == "TELEFONO" || ValorComision == "Telefono" || ValorComision == "telefono") {
                        $("#modelo").css({"visibility": "visible","display": "block"});
                        $("#lmodelo").css({"visibility": "visible","display": "block"});
                        $("#modelo").attr("required","true");
                        $("#color").css({"visibility": "visible","display": "block"});
                        $("#lcolor").css({"visibility": "visible","display": "block"});
                        $("#color").attr("required","true");

                        $("#nom").css({"visibility": "visible","display": "block"});
                        $("#lnombre").css({"visibility": "visible","display": "block"});
                        $("#nom").attr("required","true");
                        $("#marca").css({"visibility": "visible","display": "block"});
                        $("#lmarca").css({"visibility": "visible","display": "block"});
                        $("#marca").attr("required","true");

                        $("#compania").css({"visibility": "hidden","display": "none"});
                        $("#compania").removeAttr("required");
                        $("#lcompania").css({"visibility": "hidden","display": "none"});
                        $("#valor").css({"visibility": "hidden","display": "none"});
                        $("#valor").removeAttr("required");
                        $("#lvalor").css({"visibility": "hidden","display": "none"});
                        $("#tipo").css({"visibility": "hidden","display": "none"});
                        $("#tipo").removeAttr("required");
                        $("#ltipo").css({"visibility": "hidden","display": "none"});
                        $("#lltipo").css({"visibility": "hidden","display": "none"});
                        $("#llltipo").css({"visibility": "hidden","display": "none"});
                      }else{
                          if (ValorComision == "CHIP" || ValorComision == "Chip" || ValorComision == "chip") {
                            $("#compania").css({"visibility": "visible","display": "block"});
                            $("#lcompania").css({"visibility": "visible","display": "block"});
                            $("#modelo").attr("required","true");

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

                            $("#nom").css({"visibility": "hidden","display": "none"});
                            $("#lnombre").css({"visibility": "hidden","display": "none"});
                            $("#nom").removeAttr("required");
                            $("#marca").css({"visibility": "hidden","display": "none"});
                            $("#lmarca").css({"visibility": "hidden","display": "none"});
                            $("#marca").removeAttr("required");                                
                          }else{
                              if (ValorComision == "FICHA" || ValorComision == "Ficha" || ValorComision == "ficha") {
                                $("#tipo").css({"visibility": "visible","display": "block"});
                                $("#tipo").attr("required","true");
                                $("#ltipo").css({"visibility": "visible","display": "block"});
                                $("#lltipo").css({"visibility": "visible","display": "block"});
                                $("#llltipo").css({"visibility": "visible","display": "block"});
                                $("#compania").css({"visibility": "visible","display": "block"});
                                $("#compania").attr("required","true");
                                $("#lcompania").css({"visibility": "visible","display": "block"});
                                $("#valor").css({"visibility": "visible","display": "block"});
                                $("#valor").attr("required","true");
                                $("#lvalor").css({"visibility": "visible","display": "block"});

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

                                $("#nom").css({"visibility": "visible","display": "block"});
                                $("#lnombre").css({"visibility": "visible","display": "block"});
                                $("#nom").attr("required","true");
                                $("#marca").css({"visibility": "visible","display": "block"});
                                $("#lmarca").css({"visibility": "visible","display": "block"});
                                $("#marca").attr("required","true");
                              }
                          }
                      }
                        //jAlert("Módulo agregado correctamente", "AIKO SOLUCIONES");
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

        /*function downloadcodebar(){
            //descraga directa como archivo
            var canvas = document.getElementById("Barcode");
            var dataUrl = canvas.toDataURL(); // obtenemos la imagen como png
            dataUrl=dataUrl.replace("image/png",'image/octet-stream'); // sustituimos el tipo por octet
            document.location.href =dataUrl; // para forzar al navegador a descargarlo
            //abrir en otra ventana y guardarlo manualmente
            var canvas = document.getElementById("Barcode");
            var dataUrl = canvas.toDataURL(); // obtenemos la imagen como png
            window.open(dataUrl, "Ejemplo", "width=400, height=400");
        }*/
    </script>
    <style>
        .codebar{
            border: 1px;
            border-style: solid;
            border-color: #000;
            margin-left: 30px;
            margin-bottom: 0px;
            margin-right: 10px;
            padding: 5px;
        }
        .hr{
            /* background: blue; */
            margin-bottom: -20px;
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
        /* .incd{
            margin-top: 20px;
        } */
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="4"><center><strong>Creacion de Productos</strong></center></td>
  </tr>
   <tr>
    <td colspan="4">
    <div class="control-group info">
    <form name="form1" method="post" action="">
    	<div class="input-append hr">
   			 <input class="span2 incd" id="ccodigo" name="ccodigo" type="text" placeholder="Codigo del Articulo" maxlength="13">
    	 	 <button class="btn incd" id="btnc" type="submit">Confirmar Codigo</button>
                 <?php 
                    if (!empty($_POST['ccodigo']) or !empty($_GET['codigo'])) {
                        echo "<canvas id='Barcode' class='codebar' width='229' height='70'></canvas>";
                        echo '<button class="btn down" id="btnd" onclick="downloadcodebar();" type="button">Guardar/PDF</button>';
                    
                 ?>
                 <!-- <div id="Barcode"></div> -->
                 <?php } ?>
        </div>
    </form>
    </div>
    <?php 
		//echo $_POST['codigo'];
		if(!empty($_POST['ccodigo']) or !empty($_GET['codigo'])){

			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';$unidad='';$modelo = "";$valor="";$tipo="";$compania="";
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");
			if(!empty($_GET['codigo'])){
				$codigo=$_GET['codigo'];
			}
            if(!empty($_POST['codigo'])){
                $codigo=$_POST['codigo'];
            }
			if(!empty($_POST['ccodigo'])){
				//$codigo=$_POST['ccodigo'];
            #formula obtener digito adicional de codigo de barras ||ean13||
                $codig=$_POST['ccodigo'];
                $ac = str_split($codig);
                print_r($arrcodigo);
                $suma_impares = $ac[0]+$ac[2]+$ac[4]+$ac[6]+$ac[8]+$ac[10];
                $suma_pares = $ac[1]+$ac[3]+$ac[5]+$ac[7]+$ac[9]+$ac[11];
                $multres = $suma_pares*3;
                $suma_resultados = $multres+$suma_impares;
                $arrdig = str_split($suma_resultados);
                $cuenta = count($arrdig);
                $suma_resultados = $suma_resultados-1000;
                $ultimodig = $arrdig[$cuenta-1];
                $valord = 10-$ultimodig;
                if ($valord == 10) {
                    $valord = 0;
                }
                $codigo = $ac[0].$ac[1].$ac[2].$ac[3].$ac[4].$ac[5].$ac[6].$ac[7].$ac[8].$ac[9].$ac[10].$ac[11].$valord;
            #Fin formula obtener digito adicional de codigo de barras ||ean13||
			}
			$can=mysql_query("SELECT * FROM producto where cod='$codigo' AND id_sucursal = '$id_sucursal'");
			if($dato=mysql_fetch_array($can)){
				$prov=$dato['prov'];
				$cprov=$dato['cprov'];
				$nom=$dato['nom'];
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
                $id_marca = $dato['id_marca'];
                $modelo = $dato['modelo'];
                $compania = $dato['compania'];
                $valor=$dato['valor'];
                $tipo=$dato['tipo_ficha'];
                $IMEI= $dato['imei'];
                $color = $dato['color'];
				$boton="Actualizar Producto";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo '.$nom.' </strong> con el codigo '.$codigo.' existe
					   </div>';	
			}else{
				$boton="Guardar Producto";
			}
	?>
    <!-- inicia agregar y actualizar producto -->
     <?php 
        if(!empty($_POST['codigo'])){
            $gnom=$_POST['nom'];        $gprov=$_POST['prov'];          $gcosto=$_POST['costo'];
            $gmayor=$_POST['mayor'];    $gventa=$_POST['venta'];        $gcantidad='0'; //$_POST['cantidad'];//+$_POST['cantact'];
            $gminimo=$_POST['minimo'];  $gseccion=$_POST['seccion'];    $gfecha=$_POST['fecha'];
            $gcodigo=$_POST['codigo'];  $gcprov=$_POST['cprov'];        $unidad=$_POST['unidad'];
            $gmarca=$_POST['marca'];    $gmodelo=$_POST['modelo'];      //$gIMEI=$_POST['imei'];
            $gvalor=$_POST['valor'];    $gtipo=$_POST['tipo'];          $gcompania=$_POST['compania'];
            $color = $_POST['color'];   $id_comision=$_POST['comision'];$cantidad = $_POST['cantidad'];
            $imei = $_POST['imei'];
            $iccid = $_POST['iccid'];
        #identiticadores unicos
            $imeis  = explode("\n", $imei);
            $iccids = explode("\n", $iccid);
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

            //$ncantidad=$_POST['cantidad'];$remision = $_POST['remision'];
            $can=mysql_query("SELECT * FROM producto where cod='$gcodigo'");
            if($dato=mysql_fetch_array($can)){
            #nueva entrada de identificador unico  del producto atual
                $contimei  = 0;
                $conticcid = 0;
                if (count($iccids) > 1 && count($imeis) > 1) {

                    if (count($iccids) == count($imeis)) {
                    #foreach identificador iccid
                        foreach ($iccids as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                            if($row=mysql_fetch_array($queryi)){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                if (!empty($identificador)) {
                                $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                            VALUES ('$gcodigo','IMEI','$identificador',NOW(),'s','$id_sucursal')";
                                $answ = mysql_query($sqlc);
                                $conticcid++;
                                }
                            }
                        }
                    #fin foreach identificador iccid
                    #foreach identificador imei
                        
                        foreach ($imeis as &$identificador) {

                            //$identificador = $iccids($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                            if($row=mysql_fetch_array($queryi)){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                
                                if (!empty($identificador)) {
                                    $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                    $answ = mysql_query($sqlc);
                                    $contimei++;
                                }
                            }
                        }
                    #foreach identificador iccid
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
                        $sql="UPDATE producto SET  prov='$gprov',
                                                   cprov='$gcprov',
                                                   nom='$gnom',
                                                   costo='$gcosto',
                                                   mayor='$gmayor',
                                                   venta='$gventa',
                                                   minimo='$gminimo',
                                                   seccion='$gseccion',
                                                   fecha='$gfecha',
                                                   id_comision='$id_comision',
                                                   unidad='$unidad',
                                                   id_marca='$gmarca',
                                                   modelo='$gmodelo',
                                                   compania='$gcompania',
                                                   valor = '$gvalor',
                                                   tipo_ficha = '$gtipo',
                                                   color = '$color'
                                    WHERE cod='$gcodigo'";
                                    //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                        //echo "con nueva cantidad °_° <br>";
                        mysql_query($sql);
                        $sqlac="UPDATE producto SET  cantidad = '$gcantidad'
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
                    #Actualizar datos de producto sin cantidad
                    
                    $sql="UPDATE producto SET  prov='$gprov',
                                               cprov='$gcprov',
                                               nom='$gnom',
                                               costo='$gcosto',
                                               mayor='$gmayor',
                                               venta='$gventa',
                                               minimo='$gminimo',
                                               seccion='$gseccion',
                                               fecha='$gfecha',
                                               id_comision='$id_comision',
                                               unidad='$unidad',
                                               id_marca='$gmarca',
                                               modelo='$gmodelo',
                                               compania='$gcompania',
                                               valor = 'gvalor',
                                               tipo_ficha = '$gtipo',
                                               color = '$color'
                                WHERE cod='$gcodigo'";
                                //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                    //echo "sin nueva cantidad °_° <br>";
                    mysql_query($sql);
                #fin Actualizar datos de producto sin cantidad
                
                    echo '  <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">X</button>
                              <strong>Producto / Articulo '.$gnom.' </strong> Actualizado con Exito
                        </div>';
                    $prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$fecha='';$codigo='';$venta='0';$cprov='';$id_comision='';$id_marca='';
                    $id_modelo='';$IMEI='';
                }
            #-----------------------------------------------------------------

            }else{
            
            #nueva entrada de identificador unico  del producto atual
                $conticcid = 0;
                $contimei  = 0;
                if (count($iccids) > 0 && count($imeis) > 0) {

                    if (count($iccids) == count($imeis)) {
                    #foreach identificador iccid
                        foreach ($iccids as &$identificador) {
                            
                            //$identificador = $imeis($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                            if($row=mysql_fetch_array($queryi)){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador ICCID '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                if (!empty($identificador)) {
                                $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                            VALUES ('$gcodigo','IMEI','$identificador',NOW(),'s','$id_sucursal')";
                                $answ = mysql_query($sqlc);
                                $conticcid++;
                                }
                            }
                        }
                    #fin foreach identificador iccid
                    #foreach identificador imei
                        
                        foreach ($imeis as &$identificador) {

                            //$identificador = $iccids($i);//$_POST['identificador'];
                            $identificador = trim($identificador);
                            $queryi=mysql_query("SELECT * FROM codigo_producto where identificador = $identificador AND id_sucursal = '$id_sucursal'");
                            if($row=mysql_fetch_array($queryi)){
                                echo '  <div class="alert alert-warning">
                                          <button type="button" class="close" data-dismiss="alert">X</button>
                                          <strong>! Identificador IMEI '.$identificador.' Existente ¡</strong>
                                        </div>';
                            }else {
                                
                                if (!empty($identificador)) {
                                    $sqlc = "INSERT INTO codigo_producto (id_producto,tipo_identificador,identificador,fecha, estado,id_sucursal)
                                                VALUES ('$gcodigo','ICCID','$identificador',NOW(),'s','$id_sucursal')";
                                    $answ = mysql_query($sqlc);
                                    $contimei++;
                                }
                            }
                        }
                    #foreach identificador iccid
                        echo '  <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Numero de IMEI´S Registrados '.$contimei.' </strong>
                        </div>';
                        echo '  <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Numero de ICCID´S Registrados '.$conticcid.' </strong>
                        </div>';
                    }else {
                        echo '<div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert">X</button>
                                <strong>! Cantidad IMEI no coincide con Cantidad ICCID¡</strong>
                              </div>';
                    }
                }
            #-----------------------------------------------------------------
            #agregar el registro mas los identificadores unicos
                $can=mysql_query("SELECT * FROM empresa");
                while($dato=mysql_fetch_array($can)){
                    $id_suc = $dato['id'];
                    $sql = "INSERT INTO producto (cod, prov, cprov, nom,costo, mayor, venta, cantidad, minimo, seccion, fecha, estado,id_comision, unidad,id_sucursal,id_marca,modelo,compania,valor,tipo_ficha,color)
                             VALUES ($gcodigo,'$gprov','$gcprov','$gnom','$gcosto','$gmayor','$gventa','$gcantidad','$gminimo','$gseccion','$gfecha','s','$id_comision','$unidad','$id_suc','$gmarca','$gmodelo','$gcompania','$gvalor','$gtipo','$color')";
                    $answer = mysql_query($sql);
                    if ($answer && $id_suc == $id_sucursal) {
                        $sql="UPDATE producto SET  cantidad = '$contimei'
                                    WHERE cod='$gcodigo' AND id_sucursal = '$id_sucursal'";
                                    //id_sucursal='$id_sucursal' cantidad='$gcantidad',
                        mysql_query($sql);
                    }
                }
            #fin agregar el registro mas los identificadores unico
                echo '  <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Producto / Articulo '.$gnom.' </strong> Guardado con Exito
                        </div>';
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
        ?>
    <!-- finaliza agregar y actualizar producto -->
    </td>    
    <div class="control-group info">
    <form name="form2" method="post" enctype="multipart/form-data" action="">
  	<tr>
    	<td width="24%">
        	<label>* Codigo: </label><input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
            <label>* Tipo Articulo/Servicio: </label> 
            <select name="comision" id="comision" class="comision" required>
            <option value="">Elige una opcion</option>
            <?php
                $can=mysql_query("SELECT * FROM comision");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_comision']; ?>" <?php if($id_comision==$dato['id_comision']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
            
            <!-- ------------------------------- Cambio en el formulario ------------------------------------- -->
            <label id="lnombre" >* Nombre: </label><input type="text" name="nom" id="nom" value="<?php echo $nom; ?>" required>

            <label id="lmarca" >* Marca:</label>
            <select name="marca" id="marca">
            <?php
            $can=mysql_query("SELECT * FROM marca where estado='s'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_marca']; ?>" <?php if($id_marca==$dato['id_marca']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>

            <label  id="lmodelo" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Modelo:</label>
            <input  type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="lcompania" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Compañia:</label>
            <input type="text" name="compania" id="compania" value="<?php echo $compania; ?>" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="lvalor" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Valor:</label>
            <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="ltipo" for="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >* Tipo Ficha</label>
            <label id="lltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <input type="radio" name="tipo" id="optionsRadios2" value="normal" <?php if($tipo=="normal"){ echo 'checked'; } ?>>Normal
            </label>
            <label id="llltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <input type="radio"   name="tipo" id="optionsRadios1" value="distribuidor" <?php if($tipo=="distribuidor"){ echo 'checked'; } ?>>Distribuidor
            </label>

            <label id="lcolor" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Color:</label>
            <input type="text" name="color" id="color" value="<?php echo $color; ?>" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <!-- ------------------------------- fin cambio formulario --------------------------------------- -->
            <label>Proveedor</label>
            <select name="prov" id="prov">
            <?php 
				$can=mysql_query("SELECT * FROM proveedor where estado='s'");
				while($dato=mysql_fetch_array($can)){
			?>
              <option value="<?php echo $dato['codigo']; ?>" <?php if($prov==$dato['codigo']){ echo 'selected'; } ?> > <?php echo $dato['empresa']; ?></option>
            <?php } ?>
            </select>
            <label>* Cod. Articulo del Proveedor: </label><input type="text" name="cprov" id="cprov" value="<?php echo $cprov; ?>" required maxlength="30">
            
            <br><br>
                <button type="submit" class="btn btn-large btn-primary"><?php echo $boton; ?></button>
        </td>
        <td width="5%">
            <label>Fecha: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>
            <label>Precio Costo</label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="costo" id="costo" value="<?php echo $costo; ?>" required> 
                <span class="add-on">.00</span>
            </div>
            <label>Precio Mayoreo: </label>
             <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="mayor" id="mayor" value="<?php echo $mayor; ?>" required>
                <span class="add-on">.00</span>
            </div>
            <label>Precio Venta: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="venta" id="venta" value="<?php echo $venta; ?>" required> 
                <span class="add-on">.00</span>
            </div>
        	<label>Cantidad Actual: </label><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" required maxlength="25" readonly>
            <label>Cantidad Minima: </label><input type="text" name="minimo" id="minimo" value="<?php echo $minimo; ?>" maxlength="25">
            
            <label>Seccion del Articulo: </label> 
            <select name="seccion" id="seccion">
            <?php
				$can=mysql_query("SELECT * FROM seccion where estado='s'");
				while($dato=mysql_fetch_array($can)){
			?>
              <option value="<?php echo $dato['id']; ?>" <?php if($seccion==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
            <label>Unidad de medida: </label>
            <select name="unidad" id="unidad">
            <?php
                $can=mysql_query("SELECT * FROM unidad_medida");
                while($dato=mysql_fetch_array($can)){ ?>
              <option value="<?php echo $dato['id']; ?>" <?php if($unidad==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
              <!-- <div class="panel-compra">
                
                <label>Nueva Cantidad: </label><input type="text" name="cantidad" id="cantidad" value="0" required maxlength="25">
                <label>Orden de Compra: </label><input type="text" name="remision" id="remision" maxlength="25">
                <label for="textfield">Comprobantes Digitales: </label><input type="file" multiple="true" id="archivo" name="archivo[]">
              </div> -->
        </td>
    	<td width="48%">
            <center><label for="textfield">IMEI: </label></center>
            <center><textarea name="imei" id="imei" cols="15" rows="10" value=""><?php echo $observacion; ?></textarea></center>
            <br>
       		<center><label>Imagen del Producto</label></center>
            <center>
			<?php
				if (file_exists("articulo/".$codigo.".jpg")){
					echo '<img src="articulo/'.$codigo.'.jpg" width="200" height="200" class="img-polaroid">';
				}else{ 
					/*echo '<img src="articulo/producto.png" width="200" height="200" class="img-polaroid">';*/
				}
			?>
            </center><br>
            <center><output id="list"></output><!-- <br /> -->
            <input type="file" name="files" id="files"></center>
        </td>      
        <td width="48%">
            <center><label for="textfield">ICCID: </label></center>
            <center><textarea name="iccid" id="iccid" cols="15" rows="10" value=""><?php echo $observacion; ?></textarea></center>
        </td>
	</tr>
    </form>
    </div>
	<?php } ?>
  </table>
  
</div>
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
</body>
</html>
<!-- <select name="modelo" id="modelo">
            <?php
                $can=mysql_query("SELECT * FROM modelo where estado='s'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_modelo']; ?>" <?php if($id_modelo==$dato['id_modelo']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select> -->
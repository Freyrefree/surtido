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
    <td colspan="4"><center><strong>CONSULTAR CUPONES</strong></center></td>
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
    <!-- inicia agregar y actualizar producto -->
     <?php 
        if(!empty($_POST['imei'])){
            
            $imei = $_POST['imei'];
        #identiticadores unicos
            $imeis  = explode("\n", $imei);
        #fin identificadores unicos
            echo "CUPONES: <br>";
            #foreach identificador imei
                foreach ($imeis as &$identificador) {
                    //$identificador = $iccids($i);//$_POST['identificador'];
                    $identificador = trim($identificador);
                    if (!empty($identificador)) {
                        echo '  CUPON: '.$identificador.'<br>';
                    }
                }
            #fin foreach identificador imei            
        }
        ?>
    <!-- finaliza agregar y actualizar producto -->
    </td>    
    <div class="control-group info">
    <form name="form2" method="post" enctype="multipart/form-data" action="">
  	<tr>
    	<td width="48%">
            <center><label for="textfield">CUPONES: </label></center>
            <center><textarea name="imei" id="imei" cols="15" rows="10" value=""><?php echo $observacion; ?></textarea></center>
            <br>
            <center><button class="btn btn-large btn-primary" type="submit">Consultar</button></center>
        </td>        
	</tr>
    </form>
    </div>
	
  </table>
  
</div>

</body>
</html>
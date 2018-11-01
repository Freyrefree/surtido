<?php
    session_start();
    include('php_conexion.php'); 
    $id_sucursal = $_SESSION['id_sucursal'];
    if($_SESSION['tipo_usu']!='a' && $_SESSION['tipo_usu']!='ca' && $_SESSION['tipo_usu']!='te'){
        header('location:producto.php');
    }
    $cadena = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
    $abcdario = explode(",", $cadena);

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
        input{
        text-transform:uppercase;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div align="center">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="4"><center><strong>Detallar de Inventario</strong></center></td>
  </tr>
   <tr>
    <td colspan="4">
    <!-- inicia agregar y actualizar producto -->
     <?php 
        if(!empty($_POST['codigo'])){
            $gnom=strtoupper($_POST['nom']);        $gprov= strtoupper($_POST['prov']);          $gcosto=strtoupper($_POST['costo']);
            $gmayor=strtoupper($_POST['mayor']);    $gventa=strtoupper($_POST['venta']);        $gcantidad='0'; //$_POST['cantidad'];//+$_POST['cantact'];
            $gminimo=strtoupper($_POST['minimo']);  $gseccion=strtoupper($_POST['seccion']);    $gfecha=strtoupper($_POST['fecha']);
            $gcodigo=strtoupper($_POST['codigo']);  $gcprov=strtoupper($_POST['cprov']);        $unidad=strtoupper($_POST['unidad']);
            $gmarca=strtoupper($_POST['marca']);    $gmodelo=strtoupper($_POST['modelo']);      //$gIMEI=$_POST['imei'];
            $gvalor=strtoupper($_POST['valor']);    $gtipo=strtoupper($_POST['tipo']);          $gcompania=strtoupper($_POST['compania']);
            $color =strtoupper($_POST['color']);   $id_comision=strtoupper($_POST['comision']);$cantidad =$_POST['ncantidad']+$_POST['cantidad'];
            $especial =strtoupper($_POST['especial']);$categoria=strtoupper($_POST['categoria']);

            $cantidadCreada = $_POST['ncantidad'];
            $cantidadInicial = $_POST['cantidad'];
            $codigOficial = $_POST['codigOficial'];
            
            $imei = $_POST['imei'];
            $iccid = $_POST['iccid'];
            $identifi = $_POST['identifi'];
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
            //else{ //else sin if | si  no existe en la base de datos y es nuevo producto
                #codigo agregar nuevo producto#
            #nueva entrada de identificador unico  del producto atual
            $conticcid = 0;
            $contimei  = 0;
            $contidentifi = 0;
            #-----------------------------------------------------------------
            #agregar el registro mas los identificadores unicos
            $gcantidad = $cantidad;
            //$can=mysql_query("SELECT * FROM empresa");
            //while($dato=mysql_fetch_array($can)){ //while sucursales --->
            //$id_suc = $dato['id'];
            $nuevaCantidad = $cantidadInicial - $cantidadCreada;
            if($nuevaCantidad >= 0){
                $sql = "INSERT INTO producto (cod, codigo,prov, cprov, nom,costo, mayor, venta,especial,cantidad, minimo, seccion, fecha, estado,id_comision, unidad,id_sucursal,marca,modelo,compania,valor,tipo_ficha,color,categoria)
                        VALUES ('$gcodigo','$codigOficial','$gprov','$gcprov','$gnom','$gcosto','$gmayor','$gventa','$especial','$cantidadCreada','$gminimo','$gseccion','$gfecha','s','$id_comision','$unidad','$id_sucursal','$gmarca','$gmodelo','$gcompania','$gvalor','$gtipo','$color','$categoria')";
                $answer = mysql_query($sql);

                $queryDesc = "UPDATE producto SET  cantidad='$nuevaCantidad' 
                            WHERE cod='$codigOficial' AND id_sucursal = '$id_sucursal'";
                $answerDesc = mysql_query($queryDesc);
            }else{
                echo '  <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert">X</button>
                            <strong>Producto / Articulo '.$gnom.' </strong> No fue guardado, debido a que no se puede asignar la cantidad solicitada, intentelo con una cantidad menor o en 0
                        </div>';
            }
            
            //}//while sucursales --->
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
            //}// else sin if
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

    <?php 
		if(!empty($_GET['codigo'])){

			$prov='';$nom='';$costo='0';$mayor='0';$cantidad='0';$minimo='0';$seccion='';$codigo='';
			$venta='0';$cprov='';$unidad='';$modelo = "";$valor="";$tipo="";$compania="";$especial='0';
			$fechax=date("d").'/'.date("m").'/'.date("Y");
			$fechay=date("Y-m-d");

            if(!empty($_GET['codigo'])){
				$codigo=$_GET['codigo'];
			}
            //validar cuantos productos hijos se han creado
            $queryCont=mysql_query("SELECT COUNT(cod) AS copias FROM producto where codigo = '$codigo' AND id_sucursal = '$id_sucursal'");
            if($cuenta=mysql_fetch_array($queryCont)){
                $numLetra = $cuenta['copias'];
            }
            //validar cuantos productos hijos se han creado
			$can=mysql_query("SELECT * FROM producto where cod='$codigo' AND codigo is NULL AND id_sucursal = '$id_sucursal'");
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
                $marca = $dato['marca'];
                $modelo = $dato['modelo'];
                $compania = $dato['compania'];
                $valor=$dato['valor'];
                $tipo=$dato['tipo_ficha'];
                $categoria = $dato['categoria'];
                $IMEI= $dato['imei'];
                $color = $dato['color'];
                $especial = $dato['especial'];

				$boton="Crear Producto";
				echo '	<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">X</button>
						  <strong>Producto / Articulo: '.$nom.' </strong> con el codigo '.$codigo.' existe
					   </div>';
                $codigOficial = $codigo;
                $codigo=$codigo.$abcdario[$numLetra];
                $qucom=mysql_query("SELECT * FROM comision WHERE id_comision='$id_comision'");
                if($data=mysql_fetch_array($qucom)){
                    $TipoComision = $data['tipo'];
                }
			}else{
				$boton="";
			}
	?>
    
    </td>    
    <div class="control-group info">
    <form name="form2" method="post" enctype="multipart/form-data" action="">
    <!--crear_producto.php-->
  	<tr>
    	<td width="24%">
        	<label>* Codigo: </label><input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" readonly>
            <input type="hidden" name="codigOficial" id="codigOficial" value="<?php echo $codigOficial; ?>" readonly>
            <label>* Tipo Articulo/Servicio: </label> 
            <select name="comision" id="comision" class="comision" required>
            <option value="">Elige una opcion</option>
            <?php
                $can=mysql_query("SELECT * FROM comision WHERE tipo != 'REPARACION' AND tipo != 'RECARGA'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_comision']; ?>" <?php if($id_comision==$dato['id_comision']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select>
            <label  id="lcategoria" <?php if (empty($categoria)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Categoria:</label>
            <input  type="text" name="categoria" id="categoria" value="<?php echo $categoria; ?>" <?php if (empty($categoria)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <!-- ------------------------------- Cambio en el formulario ------------------------------------- -->
            

            <label id="lmarca" <?php if ($TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>>* Marca:</label>
            <input  type="text" name="marca" id="marca" value="<?php echo $marca; ?>" <?php if ($TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <!-- <select name="marca" id="marca" <?php if ($TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>>
            <?php
            $can=mysql_query("SELECT * FROM marca where estado='s'");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id_marca']; ?>" <?php if($id_marca==$dato['id_marca']){ echo 'selected'; } ?>><?php echo $dato['nombre']; ?></option>
            <?php } ?>
            </select> -->
            <label id="lnombre" >Nombre: </label><input type="text" name="nom" id="nom" value="<?php echo $nom; ?>" maxlength="250">

            <label  id="lmodelo" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Modelo:</label>
            <input  type="text" name="modelo" id="modelo" value="<?php echo $modelo; ?>" <?php if (empty($modelo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="lcompania" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Compañia:</label>
            <input type="text" name="compania" id="compania" value="<?php echo $compania; ?>" <?php if (empty($compania)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="lvalor" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Valor:</label>
            <input type="text" name="valor" id="valor" value="<?php echo $valor; ?>" <?php if (empty($valor)) { echo 'style="display:none;visibility:hidden;"'; } ?> >

            <label id="ltipo" for="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >* Tipo </label><!-- Ficha -->
            <label id="lltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <input type="radio" name="tipo" id="optionsRadios2" value="normal" <?php if($tipo=="NORMAL"){ echo 'checked'; } ?>>Normal
            </label>
            <label id="llltipo" class="radio" <?php if (empty($tipo)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <input type="radio"   name="tipo" id="optionsRadios1" value="distribuidor" <?php if($tipo=="DISTRIBUIDOR"){ echo 'checked'; } ?>>Distribuidor
            </label>

            <label id="lcolor" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?>>* Color:</label>
            <input type="text" name="color" id="color" value="<?php echo $color; ?>" <?php if (empty($color)) { echo 'style="display:none;visibility:hidden;"'; } ?> >
            <!-- ------------------------------- fin cambio formulario --------------------------------------- -->
            <label>Proveedor</label>
            <input name="prov" id='prov' type="text" class="span2" size="60" list="proveedor" placeholder="Proveedor" value="<?php echo $prov ?>">
            <datalist id="proveedor">
            <?php 
                 //echo "<option value='aaaaaaa' selected>aaaaa</option>";        

				$can=mysql_query("SELECT * FROM proveedor where estado='s'");
				while($dato=mysql_fetch_array($can)){
                    echo "<option value='$dato[empresa]'></option>";                    
                } 
            ?>
            </datalist>
            <!-- <label>* Cod. Articulo del Proveedor: </label><input type="text" name="cprov" id="cprov" value="<?php echo $cprov; ?>" required maxlength="30"> -->
            
            <br><br>
                <button type="submit" class="btn btn-large btn-primary"><?php echo $boton; ?></button>
        </td>

        <?php
        if($tip=='a')
        {
            $inputcosto = '
            <label>Precio Costo</label>
            <div class="input-prepend input-append">
            <span class="add-on">$</span>
            <input type="text" name="costo" id="costo" value="'.$costo.'" required>
            <span class="add-on">.00</span>
            </div>
            ';
            $inputespecial = '
            <label>Precio Especial: </label>
            <div class="input-prepend input-append">
                <span class="add-on">$</span>
                <input type="text" name="especial" id="especial" value="'.$especial.'" required> 
                <span class="add-on">.00</span>
            </div>
            ';
            
        } 
         ?>
        <td width="5%">
            <label>Fecha: </label><input type="date" name="fecha" id="fecha" value="<?php echo $fechay; ?>" required>
            
                
                <?php  echo $inputcosto;  echo $inputespecial?> 
                
        
                
            
            
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
            
        	<label>Cantidad Original: </label><input type="text" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>" required maxlength="25" readonly>

            <label>Cantidad asignada: </label>
            <input type="text" name="ncantidad" id="ncantidad" value="0" required maxlength="25" <?php if ($TipoComision == 'TELEFONO' OR $TipoComision == 'CHIP' OR $TipoComision == 'FICHA') { echo 'readonly'; } ?>>
            <!--<label>Cantidad Minima: </label>-->
            <input type="hidden" name="minimo" id="minimo" value="<?php echo $minimo; ?>" maxlength="25">
            
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
            <center><label id="limei" for="textfield" <?php if ($TipoComision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?> >IMEI: </label></center>
            <center><textarea name="imei" id="imei" cols="15" rows="10" value="" <?php if ($TipoComision != 'TELEFONO') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea></center>
            <!-- <br> -->
            <center><label id="lidentifi" for="textfield" <?php if ($TipoComision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?> >IDENTIFICADOR: </label></center>
            <center><textarea name="identifi" id="identifi" cols="15" rows="10" value="" <?php if ($TipoComision != 'FICHA') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea></center>
            <!-- <br> -->
            <center><label id="liccid" for="textfield" <?php if ($TipoComision != 'TELEFONO' and $TipoComision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>>ICCID: </label></center>
            <center><textarea name="iccid" id="iccid" cols="15" rows="10" value="" <?php if ($TipoComision != 'TELEFONO' and $TipoComision != 'CHIP') { echo 'style="display:none;visibility:hidden;"'; } ?>></textarea></center>
        </td>      
        <td width="48%">
            
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
                        $("#categoria").css({"visibility": "hidden","display": "none"});
                        $("#categoria").removeAttr("required");
                        $("#lcategoria").css({"visibility": "hidden","display": "none"});
                      if (ValorComision == "TELEFONO" || ValorComision == "Telefono" || ValorComision == "telefono") {
                        $("#modelo").css({"visibility": "visible","display": "block"});
                        $("#lmodelo").css({"visibility": "visible","display": "block"});
                        $("#modelo").attr("required","true");
                        $("#color").css({"visibility": "visible","display": "block"});
                        $("#lcolor").css({"visibility": "visible","display": "block"});
                        $("#color").attr("required","true");
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
                                    $("#color").attr("required","true");
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
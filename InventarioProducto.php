<?php
		session_start();
		include('php_conexion.php'); 
		if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
			header('location:error.php');
		}
		include("MPDF/mpdf.php");
    	$mpdf=new mPDF('utf-8' , 'A4','', 15, 15, 15, 10, 15, 10);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Eleccion de Productos</title>
	<link rel="stylesheet" href="Cortes/themes/base/jquery.ui.all.css">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>    
	<script src="Cortes/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="Cortes/ui/jquery.ui.core.js"></script>
	<script src="Cortes/ui/jquery.ui.widget.js"></script>
	<script src="Cortes/ui/jquery.ui.datepicker.js"></script>
    <script src="Cortes/ui/jquery.ui.button.js"></script>
	
	<link rel="stylesheet" href="Cortes/demos/demos.css">
	<style type="text/css">
	body,td,th {
	font-family: "Trebuchet MS", Arial, Helvetica, Verdana, sans-serif;
	}
	body {
		background-color: #FFF;
	}
    </style>
     
	<script>
	$(function() {
		$( "input[type=submit], a, button" )
			.button()
			.click(function( event ) {
				event.preventDefault();
			});
	});
	function consultacortes(){
		var producto = document.getElementById("product").value;
		var sucursal = document.getElementById("sucursal").value;
		var coin = document.getElementById("coin").value;
		$.post("PDFproducto_p.php",
			   {producto: producto,
			   	sucursal: sucursal,
			   	coin: coin
			   },
			   function(data){		
	         $("#recargado").html(data);
		});			
	}

	function pdfticketcorte(){
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;

var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        //$.ajax({
              //  data:  parametros,
              //  url:   'PDFproductoSucursalTicket.php',
              //  type:  'post',
              ///  beforeSend: function () {
              //  },
               // success:  function (response) {
					window.location = 'PDFproductoSucursalTicket.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
					//modal.style.display = "block";
               // }
      //  });

	}

	function pdfcorte(){
	
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;
	var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        $.ajax({
                data:  parametros,
                url:   'PDFproductoSucursal.php',//
                type:  'post',
                beforeSend: function () {
                },
                success:  function (response) {
					window.location = 'PDFproductoSucursal.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
                }
        });
	}
	
	function excelcorte(){
	
	var producto = document.getElementById("product").value;
	var sucursal = document.getElementById("sucursal").value;
	var coin = document.getElementById("coin").value;
	var parametros = {
		   		producto: producto,
		   		sucursal: sucursal,
			   	coin: coin
        };
        $.ajax({
                data:  parametros,
                url:   'ExcelProductoSucursal.php',
                type:  'post',
                beforeSend: function () {
                },
                success:  function (data) {
					window.location = 'ExcelProductoSucursal.php?producto='+producto+'&sucursal='+sucursal+'&coin='+coin;
                }
        });
	}
</script>
    
 
</head>
<body><table width="100%" border="0" align="center" class="ui-widget-content ui-widget-header">
  <tr>
    <td align="center" style="font-size:14px">Consulta de Productos</td>
  </tr>
</table>
<p>
<table width="80%" border="0"  align="center">
  <tr>
    <td width="30%" align="center" class="ui-widget-content ui-corner-all"><img src="img/product.png" width="32" height="32"> Tipo Producto</td>
    <td width="30%" align="center" class="ui-widget-content ui-corner-all"><img src="img/shop.png" width="32" height="32"> Sucursal/s</td>
    <td width="30%" align="center" class="ui-widget-content ui-corner-all"><img src="img/search.png" width="32" height="32"> Coincidencias</td>
    <td width="10%" align="center" class="ui-widget-content ui-corner-all"><a href="#" onClick="consultacortes();" ><img src="img/report.png" width="32" height="32">Consultar</a></td>
  </tr>
  
  <tr>
    <td width="30%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
	    <select name="product" id="product">
	    <option value="Todos" selected>TODOS </option>
	    <?php 
			$can=mysql_query("SELECT * FROM comision WHERE tipo != 'REPARACION' AND tipo != 'RECARGA'");
			while($dato=mysql_fetch_array($can)){
		?>
	    <option value="<?php echo $dato['id_comision']; ?>"><?php echo $dato['nombre']; ?></option>
	    <?php } ?>
	    </select>
    </td>
    <td width="30%"  class="ui-widget-content ui-state-hover" align="center"> <label></label> 
	    <select name="sucursal" id="sucursal">
		    <option value="Todos" selected>TODOS </option>
		    <?php 
				$can=mysql_query("SELECT id,empresa FROM empresa");
				while($dato=mysql_fetch_array($can)){
			?>
		    <option value="<?php echo $dato['id']; ?>"><?php echo $dato['empresa']; ?></option>
		    <?php } ?>
	    </select>
    </td>
    <td width="30%"  class="ui-widget-content ui-state-hover" align="center">
    	<input type="text" id="coin" name="coin">
    </td><!--  -->
    <td width="10%"  class="ui-widget-content ui-state-hover" align="center">
	   	<a href="#" id="ticket" onClick="pdfticketcorte();"><img src="img/file_extension_pdf.png" width="22" height="22">Imprimir en Ticket</a>
	    <a href="#" id="cmd"    onClick="pdfcorte();"><img src="img/file_extension_pdf.png" width="22" height="22"> Exportar</a>
	    <a href="#" id="exp"    onClick="excelcorte();"><img src="img/ZA102602607.png" width="22" height="22"> Exportar</a>
    </td>
  </tr>
  <tr>
  	<p id="resultado"></p>
  </tr>
</table>
<center><table width="80%" border="0" align="ceneter">
  <tr>
    <td>
	<p>
	<div id="recargado">
		<div id="TicketPdf" width="300px"></div>
	</div>
	</p>
	</td>
  </tr>
</table></center>

<!-- Modal -->
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
</head>
<body>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <embed src="InventarioTicket/Listado_Productos.pdf?#zoom=50" width="100%" height="300" internalinstanceid="2" title>
  </div>

</div>


<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>



</body>
</html>

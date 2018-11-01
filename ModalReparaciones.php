<?php
$id_sucursal = $_SESSION['id_sucursal'];
if($_SESSION['tipo_usu']=='te'){

$QueryLa=mysql_query("SELECT * FROM reparacion WHERE estado < 2");
if($datoLa=mysql_fetch_array($QueryLa)){
?>

<!-- Modal 
<a href="#" class="btn btn-default" id="openBtn">Open modal</a>
-->
<form name="FormMovimientos" id="FormMovimientos" action="" target="_SELFT">
<div id="ModMovimientos" class="modal fade" tabindex="-1" role="dialog" style="width: 80%; left: 35%; height: 400px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Reparaciones Pendientes</h3>
            </div>
            <div class="modal-body">
                <p>     
                  <iframe src="reparaciones.php" frameborder="0" scrolling="auto" name="admin" width="100%" height="250px"></iframe>
                </p>
            </div>
            <div id="hayajax"></div>
            <div class="modal-footer"> 
                <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
                <a href="reparaciones.php" class="btn btn-primary">Maximizar</a>
            </div>
        </div>
    </div>
</div>
</form> 


<script type="text/javascript">
$(function (e) {
	$('#form<?php echo $IdModals ?>').submit(function (e) {
	  e.preventDefault()
  $('#hayajax<?php echo $IdModals ?>').load('RechazaElementoLote.php?' + $('#form<?php echo $IdModals ?>').serialize());
})
})
</script>	

<?php
}
}
?>
<?php
$id_sucursal = $_SESSION['id_sucursal'];
if($_SESSION['tipo_usu']=='a' or $_SESSION['tipo_usu']=='ca'){

$query=mysql_query("SELECT * FROM movimientosxlote WHERE Recibido = 0 AND IdSucEntrada=$id_sucursal");

$nombreUsuario = $_SESSION['username'];
$consultaRelacion = "SELECT * FROM usuarios WHERE usu = '$nombreUsuario'";
$ejecutar = mysql_query($consultaRelacion);
$datoreal = mysql_fetch_array($ejecutar);
$id_sucursalreal = $datoreal['id_sucursal'];
if (($id_sucursal == $id_sucursalreal)) 
{
    if ($dato1=mysql_fetch_array($query)) 
    {
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
                        <h3>Movimientos</h3>
                    </div>
                    <div class="modal-body">
                        <p>     
                        <iframe src="MovimientosLote.php" frameborder="0" scrolling="auto" name="admin" width="100%" height="250px"></iframe>
                        </p>
                    </div>
                    <div id="hayajax"></div>
                    <div class="modal-footer"> 
                        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
                        <a href="MovimientosLote.php" class="btn btn-primary">Maximizar</a>
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
}
?>
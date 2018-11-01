<?php
        session_start();
        include('php_conexion.php'); 
        if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
            header('location:error.php');
        }
        $id_sucursal = $_SESSION['id_sucursal'];
        $usu = $_SESSION['username'];
        $datestart  = $_REQUEST['fecha_inicio'];
        $datefinish = $_REQUEST['fecha_fin'];
        $datefinish = strtotime ( '+1 day' , strtotime ( $datefinish ) ) ;
        $_SESSION['datefinish_recargas']=$datefinish = date ( 'Y-m-j' , $datefinish );

echo"
    <a href='ReporteExcel.php?fi=$datestart&ff=$datefinish' class='btn btn-primary'>Reporte General</a>  
    <a href='ReporteExcelSucursal.php?fi=$datestart&ff=$datefinish' class='btn btn-primary'>Reporte Sucursal</a>  
    <a href='ReporteRecargasGeneral.php?fi=$datestart&ff=$datefinish' class='btn btn-primary'>Reporte TAE General</a>  
";

?>
<br>
<br>
<form name="form2" id="form2" method="post" action="" target="">
        <div class="input-append hr">
            <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?php echo $datestart ?>">
            <input type="hidden" name="fecha_fin" id="fecha_fin" value="<?php echo $datefinish ?>">
            <input type="text" autofocus class="input-xlarge" id="ccodigo" name="ccodigo" list="characters" placeholder="Nombre Empleado" autocomplete="off" >
            <datalist id="characters" >
              <?php 
              $can=mysql_query("SELECT * FROM usuarios WHERE estado = 's' and id_sucursal = '$id_sucursal' OR tipo = 'a'");
              while($dato=mysql_fetch_array($can)){
                  echo '<option value="'.$dato['usu'].'">';
                  }
              ?>
            </datalist>
            <input type="submit" class="btn" name="ConsultarComision" id="ConsultarComision">
    </form>

<div id="ajax2">aa</div>

 <script type='text/javascript'>
$(function (e) {
	$('#form2').submit(function (e) {
	  e.preventDefault()
  $('#ajax2').load('calculo_comisiones3.php?' + $('#form2').serialize())
	})
})
</script>   

    
            
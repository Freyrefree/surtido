<?php
        session_start();
        include('php_conexion.php');
        $usu=$_SESSION['username'];
        $tipo_usu=$_SESSION['tipo_usu'];
        if($_SESSION['tipo_usu']!='a'){
            header('location:error.php');
        }
        //-------------------------------------------------------
        $can=mysql_query("SELECT MAX(ced)as numero FROM usuarios");
        if($dato=mysql_fetch_array($can)){
            $numero=$dato['numero']+1;
        } //genera codigo autimaticamente
        $sucursal = $_SESSION['id_sucursal'];
        $nombre_sucursal = $_SESSION['sucursal'];
        $cedula=''; $nombre='';$usuario='';$ciudad='';$direccion='';$telefono='';$celular='';$tipo='';$barrio='';$sexo='';$sueldo='';
        if(!empty($_GET['codigo'])){    
            $codigo=$_GET['codigo'];
            $can=mysql_query("SELECT * FROM usuarios where ced='$codigo'");
            if($dato=mysql_fetch_array($can)){
                $cedula=$dato['ced'];$nombre=$dato['nom'];$usuario=$dato['usu'];$ciudad=$dato['ciudad'];$direccion=$dato['dir'];
                $telefono=$dato['tel'];$celular=$dato['cel'];$tipo=$dato['tipo'];$barrio=$dato['barrio'];$sueldo=$dato['sueldo'];
                $sexo=$dato['sexo'];$sucursal = $dato['id_sucursal'];
                $boton="Actualizar Empleado";
                $password   = $dato['con'];
                $correo     = $dato['correo'];
                /*echo "<script>alert('".$dato['tipo']."');</script>";*/
            }
        }else{
            $boton="Guardar Empleado";
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crear Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/google-code-prettify/prettify.css" rel="stylesheet">
    
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
    input{
        text-transform:uppercase;
    }
    </style>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">

  <?php 
    if(!empty($_POST['cedula']) and !empty($_POST['nombre']) and !empty($_POST['usuario'])){// and !empty($_POST['tipo'])
        
        $cedula=strtoupper($_POST['cedula']);$nombre=strtoupper($_POST['nombre']);$usuario=strtoupper($_POST['usuario']);$ciudad=strtoupper($_POST['ciudad']);$sueldo=$_POST['sueldo'];
        $direccion=strtoupper($_POST['direccion']);$telefono=$_POST['telefono'];$celular=$_POST['celular'];$tipo=$_POST['tipo'];$barrio=strtoupper($_POST['barrio']);
        $sexo=strtoupper($_POST['sexo']);$usuarioc=strtoupper($_POST['usuario']);$sucursal = $_POST['sucursal'];
        $correoPOST = $_POST['correo']; 
        if (empty($_POST['tipo'])) {
            $tipo="a";
        }
        if ($_POST['tipo'] == "su") {
            //$tipo = "ca";
            $id_sucursal = "";
        }
        $can=mysql_query("SELECT * FROM usuarios where ced='$cedula'");
        if($dato=mysql_fetch_array($can)){
            if($boton=='Actualizar Empleado'){
                $xSQL="UPDATE usuarios SET  nom='$nombre',
                                            dir='$direccion',
                                            tel='$telefono',
                                            cel='$celular',
                                            cupo='$cupo',
                                            barrio='$barrio',
                                            ciudad='$ciudad',
                                            tipo='$tipo',
                                            sueldo='$sueldo',
                                            sexo='$sexo',
                                            id_sucursal='$sucursal',
                                            correo  = '$correoPOST'
                                WHERE ced='$cedula'";
                mysql_query($xSQL); 
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Empleado</strong> Actualizado con Exito</div>';
                }else{
                    echo ' <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error! </strong>El numero de documento ingreso le pertenece al Empleado '.$dato['nom'].'</div>';
            }       
        }else{
            if (preg_match("/\\s/", $usuario)){ 
                echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">X</button><strong>Error!</strong> No se permiten espacios en la cuenta de Empleado.</div>';$usuario='';
                }else{
                    $sql = "INSERT INTO usuarios (ced, estado, nom, dir, tel, cel, barrio, ciudad, usu, con, tipo, sueldo, sexo, id_sucursal, correo)
                             VALUES ('$cedula','s','$nombre','$direccion','$telefono','$celular','$barrio','$ciudad','$usuario','$usuarioc',
                                '$tipo','$sueldo','$sexo','$sucursal','$correoPOST')";
                    mysql_query($sql);
                
                $cedula=''; $nombre='';$usuario='';$ciudad='';$sueldo='';$direccion='';$telefono='';$celular='';$tipo='';$barrio='';$sexo='';$correoPOST = '';
                echo '  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">X</button>
                          <strong>Usuario / Empleado!</strong> Guardado con Exito</div>';
                      }
                  }
              }
?>

<div class="control-group info">
  <form name="form1" method="post" action="">
<table width="80%" border="0" class="table">
  <tr class="info">
    <td colspan="2"><center><strong>Crear Empleado</strong></center></td>
  </tr>
  <tr>
    <td>
        <label for="textfield">* CURP: </label>
        <input type="text" name="cedula" id="cedula" <?php if(!empty($cedula)){echo 'readonly';} ?> value="<?php echo $cedula; ?>" maxlength="20" required>
        <label for="textfield">* Nombre y Apellido: </label><input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" autocomplete="off" maxlength="50" required><br>
        <div class="input-prepend input-append">
            <label for="textfield">* Sueldo: </label>
            <span class="add-on">$</span><input type="number" name="sueldo" id="sueldo" value="<?php echo $sueldo; ?>" autocomplete="off" required><span class="add-on">.00</span>
        </div>
        <label for="textfield">* Cuenta de Usuario: </label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>" <?php if(!empty($usuario)){echo 'readonly';} ?> autocomplete="off" maxlength="30" required>
        <label for="radio">Sexo:</label>
        <!-- <?= $sexo ?> -->
        <label class="radio">
        <input type="radio" name="sexo" id="optionsRadios1" value="H" <?php if($sexo=="h" OR $sexo=="H"){ echo 'checked'; } if(empty($_GET['codigo'])){ echo 'checked';} ?>>Hombre
        </label>
        <label class="radio">
        <input type="radio" name="sexo" id="optionsRadios2" value="M" <?php if($sexo=="m" OR $sexo=="M"){ echo 'checked'; } ?>>Mujer
        </label>
        <?php if($boton=='Actualizar Empleado' and $tipo_usu=='a'){ ?>
            <a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal">Ver Contraseña</a>
        <?php } ?>
        <br>
        <button class="btn btn-large btn-primary" type="submit"><?php echo $boton; ?></button>
        <?php if($boton=='Actualizar Empleado'){ ?> <a href="crear_empleado.php" class="btn btn-large">Cancelar</a><?php }  ?>
    </td>
    <td>    
        <label for="textfield">* Ciudad: </label><input type="text" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" autocomplete="off" maxlength="30" required>
        <label for="textfield">* Direccion / Calle: </label><input type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" autocomplete="off" required maxlength="100">
        <label for="textfield">Barrio / Localidad: </label><input type="text" name="barrio" id="barrio" value="<?php echo $barrio; ?>" autocomplete="off" maxlength="100">
        <label for="textfield">* Telefono: </label><input type="text" minlength="10" maxlength="10" name="telefono" id="telefono" value="<?php echo $telefono; ?>"autocomplete="off" pattern="[0-9]{10}" required>
        <label for="textfield">Celular / Mobil: </label><input type="text" name="celular" id="celular" value="<?php echo $celular; ?>" autocomplete="off"  pattern="[0-9]{10}" minlength="10" maxlength="10">
        <label for="textfield">Correo: </label><input type="email" name="correo" id="correo" value="<?php echo $correo; ?>" required>
        <label>Sucursal: </label>
        <!-- <input type="text" name="sucursal" id="nombre_sucursal" value="<?php echo $nombre_sucursal; ?>" autocomplete="off" maxlength="30" readonly> -->
            <select name="sucursal" id="sucursal">
            <?php 
                $can=mysql_query("SELECT * FROM empresa");
                while($dato=mysql_fetch_array($can)){
            ?>
              <option value="<?php echo $dato['id']; ?>" <?php if($sucursal==$dato['id']){ echo 'selected'; } ?>><?php echo $dato['empresa']; ?></option>
            <?php } ?>
            </select>
        <?php
            if ($tipo == 'a')$visible = 'hidden';
            else$visible = '';
         ?>
        <label for="radio" style="visibility:<?php echo $visible ?>" >Tipo de Empleado</label>
        <label class="radio" style="visibility:<?php echo $visible ?>">
        <input type="radio"   name="tipo" id="optionsRadios1" value="ca" <?php if($tipo=="ca"){ echo 'checked'; } if(empty($_GET['codigo'])){ echo 'checked';} ?>>Cajero
        </label>
        <label class="radio" style="visibility:<?php echo $visible ?>">
        <input type="radio"   name="tipo" id="optionsRadios2" value="te" <?php if($tipo=="te"){ echo 'checked'; } ?>>Tecnico
        </label>
        <label class="radio" style="visibility:<?php echo $visible ?>">
        <input type="radio"   name="tipo" id="optionsRadios2" value="su" <?php if($tipo=="su"){ echo 'checked'; } ?>>Supervisor
        </label>
    </td>
  </tr>
</table>
</form>
</div>
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Recordar Contraseña</h3>
            </div>
            <div class="modal-body">
            <p><?php echo $nombre; ?></p>
            <p>Contraseña:<strong> <?php echo $password; ?></strong></p><!-- $dato['con'];  -->
            </div>
            <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
</body>
</html>
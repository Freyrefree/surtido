<?php
session_start();
include('php_conexion.php'); 
if(!$_SESSION['tipo_usu']=='a' or !$_SESSION['tipo_usu']=='ca'){
 header('location:error.php');
}

//obtener el nombre de la persona
$usuario=$_SESSION['username'];
$fecha=date("Y-m-d");
?>
<!-- Inician los estilos -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Listado Producto</title>
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
	<script src="includes/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="includes/sweetalert/dist/sweetalert.css">
    
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
</head>
<!-- Terminan los estilos -->
<?php
$cans=mysql_query("SELECT * FROM usuarios where usu='$usuario'");
if($datos=mysql_fetch_array($cans)){
   $ced = $datos['ced'];
}

$sqle = mysql_query("SELECT * FROM caja WHERE id_cajero='$ced'");
if($dat=mysql_fetch_array($sqle)){
   $dinerocaja = $dat['apertura']+$dat['cantidad'];
}   
?>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div id="ajax"></div>
<table align="center">
<tbody>
<tr>
    <th>Contabilizar Billetes</th>
    <th>Contabilizar Monedas</th>
    <th>Retiro de Efectivo</th>
</tr>    
    <tr>
        <td valign="top">
            <form id="form1" name="corte" method="post" action="">
                <label for="ccpago">Billetes de $20</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$20</span>
                    <input type="number" name="b20" id="b20" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
                </div>
                <label for="ccpago">Billetes de $50</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$50</span>
                    <input type="number" name="b50" id="b50" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
                </div>
                <label for="ccpago">Billetes de $100</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$100</span>
                    <input type="number" name="b100" id="b100" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
                </div>
                <label for="ccpago">Billetes de $200</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$200</span>
                    <input type="number" name="b200" id="b200" min="0" step="any"  autocomplete="on" onchange="sumar()" value="0" required />
                </div>
                <label for="ccpago">Billetes de $500</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$500</span>
                    <input type="number" name="b500" id="b500" min="0" step="any" autocomplete="on"  onchange="sumar()" value="0" required />
                </div>
                <label for="ccpago">Billetes de $1000</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$1000</span>
                    <input type="number" name="b1000" id="b1000" min="0" autocomplete="on" onchange="sumar()" value="0" required />
                </div>
        </td>
        <td valign="top">
                <label for="">Monedas de $0.50</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$0.50</span>
                    <input type="number" name="m050" id="m050" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
                <label for="">Monedas de $1</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$1</span>
                    <input type="number" name="m1" id="m1" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
                <label for="">Monedas de $2</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$2</span>
                    <input type="number" name="m2" id="m2" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
                <label for="">Monedas de $5</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$5</span>
                    <input type="number" name="m5" id="m5" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
                <label for="">Monedas de $10</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$10</span>
                    <input type="number" name="m10" id="m10" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
                <label for="">Monedas de $20</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$20</span>
                    <input type="number" name="m20" id="m20" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
                </div>
          </td>
          <td valign="top">
                <label for="ccpago">Saldo en caja</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="text" name="efectivo" id="efectivo" value="<?php echo $dinerocaja; ?>" readonly>                    
                </div>
                <label for="ccpago">Retiro de Efectivo</label>
                <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input type="number" name="cierre" id="cierre" min="0" step="any" autocomplete="on" required />
                </div>
                <label for="ccpago">Usuario Responsable</label>
                    <input type="text" name="usuario" id="usuario" min="0" step="any" autocomplete="on" required />
                </div>
                <label for="ccpago">Contraseña</label>
                    <input type="password" name="password" id="password" min="0" step="any" autocomplete="on" required />
                </div>
          <br>     
          <input type="submit" class="btn btn-success" name="button" id="button" value="Aceptar" />
          </form>
        </td>   
    </tr> 
 </tbody>
</table>            

</div>
</body>
</html>

<script type="text/javascript">
$(function (e) {
	$('#form1').submit(function (e) {
	  e.preventDefault()
  $('#ajax').load('CierreCaja2.php?' + $('#form1').serialize());
	})
})
</script>	

    <script type="text/javascript">
    /**
     * Funcion que se ejecuta cada vez que se añade una letra en un cuadro de texto
     * Suma los valores de los cuadros de texto
     */
    function sumar()
    {
        var valor1  =   verificar("b20")     * 20;
        var valor2  =   verificar("b50")     * 50;
        var valor3  =   verificar("b100")    * 100;
        var valor4  =   verificar("b200")    * 200;
        var valor5  =   verificar("b500")    * 500;
        var valor6  =   verificar("b1000")   * 1000;
        var valor7  =   verificar("m050")    * 0.50;
        var valor8  =   verificar("m1")      * 1;
        var valor9  =   verificar("m2")      * 2;
        var valor10 =   verificar("m5")      * 5;
        var valor11 =   verificar("m10")     * 10;
        var valor12 =   verificar("m20")     * 20;

        // realizamos la suma de los valores y los ponemos en la casilla del
        // formulario que contiene el total
        document.getElementById("cierre").value=parseFloat(valor1)+
                                                parseFloat(valor2)+
                                                parseFloat(valor3)+
                                                parseFloat(valor4)+
                                                parseFloat(valor5)+
                                                parseFloat(valor6)+
                                                parseFloat(valor7)+
                                                parseFloat(valor8)+
                                                parseFloat(valor9)+
                                                parseFloat(valor10)+
                                                parseFloat(valor11)+
                                                parseFloat(valor12);
    }
 
    /**
     * Funcion para verificar los valores de los cuadros de texto. Si no es un
     * valor numerico, cambia de color el borde del cuadro de texto
     */
    function verificar(id)
    {
        var obj=document.getElementById(id);
        if(obj.value=="")
            value="0";
        else
            value=obj.value;
        if(validate_importe(value,1))
        {
            // marcamos como erroneo
            obj.style.borderColor="#808080";
            return value;
        }else{
            // marcamos como erroneo
            obj.style.borderColor="#f00";
            return 0;
        }
    }
 
    /**
     * Funcion para validar el importe
     * Tiene que recibir:
     *  El valor del importe (Ej. document.formName.operator)
     *  Determina si permite o no decimales [1-si|0-no]
     * Devuelve:
     *  true-Todo correcto
     *  false-Incorrecto
     */
    function validate_importe(value,decimal)
    {
        if(decimal==undefined)
            decimal=0;
 
        if(decimal==1)
        {
            // Permite decimales tanto por . como por ,
            var patron=new RegExp("^[0-9]+((,|\.)[0-9]{1,2})?$");
        }else{
            // Numero entero normal
            var patron=new RegExp("^([0-9])*$")
        }
 
        if(value && value.search(patron)==0)
        {
            return true;
        }
        return false;
    }
    </script>
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cierre de Caja</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="jsV2/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="jsV2/tether.min.js"></script>
  <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


      <!-- SWAL -->
      <script src="js/sweetalert2.all.min.js"></script>
    <!--**-->


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
											<p class="black font-weight-bold titulo text-center">CIERRE DE CAJA</p>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-3">                        
                                            
                                        </div>

                                        <div class="col-md-6">                        
                                            
                                        </div>

                                        <div class="col-md-3">
										          
                                        </div>
                                    </div>
                  
                                    <br>

									<div class="row">



									<div class="col-md-3">
                                   
									</div>

									<div class="col-md-3">
											
									</div>


									<div class="col-md-6"><br>
                                       
									</div>

									<div class="row">
										<div class="col-md-12"><br>


                                        
<div id="ajax"></div>
<table class="table">
<thead>
<tr>
    <th>Contabilizar Billetes</th>
    <th>Contabilizar Monedas</th>
    <th>Retiro de Efectivo</th>
</tr>
</thead> 
<tbody>  
    <tr>
        <td valign="top">
            <form id="form1" name="corte" method="post" action="">

            <div class="form-group">
                <label for="">Billetes de $20</label>
                <input class="form-control" type="number" name="b20" id="b20" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
            </div>
                
            <div class="form-group">
                <label for="">Billetes de $50</label>
                <input class="form-control" type="number" name="b50" id="b50" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
            </div>
                
            <div class="form-group">
                <label for="">Billetes de $100</label>
                <input class="form-control" type="number" name="b100" id="b100" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />
            </div>
            
            <div class="form-group">
                <label for="">Billetes de $200</label>
                <input class="form-control" type="number" name="b200" id="b200" min="0" step="any"  autocomplete="on" onchange="sumar()" value="0" required />
            </div>
                
            <div class="form-group">
                <label for="">Billetes de $500</label>
                <input class="form-control" type="number" name="b500" id="b500" min="0" step="any" autocomplete="on"  onchange="sumar()" value="0" required />
            </div> 
                
            <div class="form-group">    
                <label for="">Billetes de $1000</label>
                <input class="form-control" type="number" name="b1000" id="b1000" min="0" autocomplete="on" onchange="sumar()" value="0" required />
            </div>
                
        </td>
        <td valign="top">
            <div class="form-group">
                <label for="">Monedas de $0.50</label>
                <input class="form-control" type="number" name="m050" id="m050" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>    
            <div class="form-group">    
                <label for="">Monedas de $1</label>
                <input class="form-control" type="number" name="m1" id="m1" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>
            <div class="form-group">
                <label for="">Monedas de $2</label>          
                <input class="form-control" type="number" name="m2" id="m2" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>    
            <div class="form-group">
                <label for="">Monedas de $5</label>
                <input class="form-control" type="number" name="m5" id="m5" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>
            <div class="form-group">
                <label for="">Monedas de $10</label>
                <input class="form-control" type="number" name="m10" id="m10" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>
            <div class="form-group">
                <label for="">Monedas de $20</label>
                <input class="form-control" type="number" name="m20" id="m20" min="0" step="any" autocomplete="on" onchange="sumar()" value="0" required />                 
            </div>
          </td>
          <td valign="top">
            <div class="form-group">
                <label for="">Saldo en caja</label>
                <input class="form-control" type="text" name="efectivo" id="efectivo" value="<?php echo $dinerocaja; ?>" readonly>
            </div>
                                
            <div class="form-group">
                <label for="">Retiro de Efectivo</label>
                <input class="form-control" type="number" name="cierre" id="cierre" min="0" step="any" autocomplete="on" required />
            </div>

            <div class="form-group">
                <label for="">Usuario Responsable</label>
                <input class="form-control" type="text" name="usuario" id="usuario" min="0" step="any" autocomplete="on" required />
            </div>


            <div class="form-group">
                <label for="">Contraseña</label>
                <input class="form-control" type="password" name="password" id="password" min="0" step="any" autocomplete="on" required />
            </div>
                
          <br>     
          <input type="submit" class="btn btn-primary" name="button" id="button" value="Aceptar" />
          </form>
        </td>   
    </tr> 
 </tbody>
</table>   


                                            

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
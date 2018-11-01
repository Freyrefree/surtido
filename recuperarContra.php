<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href='img/ICONO2.ico' rel='shortcut icon' type='image/x-icon'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/tbl.css" rel="stylesheet">
    <link rel="stylesheet" href="">

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


  </head>
 <style type="text/css">
      body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #F7D358;/* #D1E9E9 #F3F781 #D8F781*/
	
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .per{
        width: 100%;
        height: 100%;
      }
    </style>
<body>
<p>
<p>

<div class="container">
      <form id="formRecuperar"  class="form-signin">
      <br>
        <h2 class="form-signin-heading" align="center"><img class="per" src="img/LogoSurtiCell.jpg"></h2><!-- personaje-09.png -->
        <br>
        <h3 class="form-signin-heading" align="center">Recuperar contraseña</h3>
        
        <input type="email" name="correo" id="correo" class="input-block-level" placeholder="Correo" required>
        <center>
        <input type="submit" id="btnsub"  class="btn btn-large btn-warning" value="Enviar" >
        <br><br>
        <div id="respuesta"></div>
        </center>
        
        <p>&nbsp;</p>
        <center><img src="img/Logoaa.png" alt=""></center>
      </form>
</div> 

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  </body>
</html>

<script>

$('#formRecuperar').submit(function(e) {

    $("#respuesta").html("");
    $("#btnsub").prop("disabled",true);

    e.preventDefault();
    var data = $(this).serializeArray();
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "recuperarContraGet.php",
        data: data
    }).done(function(respuesta) {
            if(respuesta == 1)
            {

                $("#respuesta").html('<div class="alert alert-success" role="alert">Se ha enviado con éxito una nueva contraseña a su correo <br><a href="http://surtiditocloud.aiko.com.mx/">surtiditocloud.aiko.com.mx</a></div>');

            }else if(respuesta == 0)
            {         
        
                $("#respuesta").html('<div class="alert alert-danger" role="alert">Error, el correo ingresado no está registrado</div>');		

            }else if(respuesta == 2){

                $("#respuesta").html('<div class="alert alert-danger" role="alert">Error, intente más tarde error mail</div>');

            }             
        
        });

        $("#btnsub").prop("disabled",false);
        $("#correo").val("");
    
});

</script>
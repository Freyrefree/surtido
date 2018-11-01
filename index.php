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
    <link rel="stylesheet" href="">
    <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png"> -->
    <!-- <link rel="shortcut icon" href="http://www.tiendapablo.soyso.com.mx/ico/ico2.ico"> -->
  </head>
 <style type="text/css">
      body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #F7D358;/* #D1E9E9 #F3F781 #D8F781*/
	background-image: url(img/fondoP.png);
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
      <form name="form1" method="post" action="comprueba.php" class="form-signin">
      <br>
        <h2 class="form-signin-heading" align="center"><img class="per" src="img/LogoSurtiCell.jpg"></h2><!-- personaje-09.png -->
        <br>
        <h3 class="form-signin-heading" align="center">Bienvenidos</h3>
        
        <input type="text" name="usuario" class="input-block-level" placeholder="Usuario">
        <input type="password" name="contra" class="input-block-level" placeholder="Contraseña">
        <center><button class="btn btn-large btn-warning" type="submit">Iniciar</button></center>
        
        <p>&nbsp;</p>
        <div align="center"><a href="recuperarContra.php">¿Olvidaste tu contraseña?</a></div>
        <center><img src="img/Logoaa.png" alt=""></center>
        
      </form>
</div> 

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
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
  </body>
</html>

<?php
include("host.php");
include("funciones.php");

$correo = $_POST['correo'];

if ($con = conectarBase($hostDB, $usuarioDB, $claveDB, $baseDB)) {

    $consultaCorreo = "SELECT nom,correo FROM usuarios WHERE correo = '$correo';";

    if($paqueteCorreo  = consultar($con,$consultaCorreo)){

        $dato = mysqli_fetch_array($paqueteCorreo);
        $correo = $dato['correo'];
        $nombre = $dato['nom'];

        $xPassword = generateRandomString();


        $html = '<html>
        <head>
            <link rel="stylesheet" href="css/tbl.css">
        </head>
        <body>';
        $html.='<table class="tblLisado">';

        $html.='<tr>';
        $html.='<th>Estimado usuario, usted ha solicitado una recuperación de contraseña</th>';
        $html.='</tr>';

        $html.='<tr></tr>';

        $html.='<tr>';
        $html.='<td><strong>Contraseña Nueva: '.$xPassword.'</strong></td>';
        $html.='</tr>';

        $html.='<tr>';
        $html.='<td>Ingresar al Sistema: <a href="http://surtiditocloud.aiko.com.mx/">surtiditocloud.aiko.com.mx</a></td>';
        $html.='</tr>';

        $html.='<tr>
        <td align="center" style="height: 20px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" colspan="3" bgcolor="#E6E6E6">
        <span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
        </td>
        </tr>';
    
        $html.='</table>
        </body></html>';

        if(enviarCorreo($correo,$html,$nombre)){

            $consultaPass = "UPDATE usuarios SET con = '$xPassword' WHERE correo = '$correo';";
            actualizar($con,$consultaPass);

            echo 1;

        }else{

            echo 2;
        }

    }else{
        echo 0;
    }  

}


function enviarCorreo($correo,$html,$nombre){

    require_once('lib/swiftmailer/swift_required.php');
    $retorno = false;

    try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('s0p0rt3**18');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance('SurtiditoCell | Recuperación de Contraseña')
            ->setFrom(array('soporte@aiko.com.mx' => 'SurtiditoCell | Recuperación de Contraseña'))
            ->setTo(array($correo => $nombre))
            ->setCc(array('dgutierrez@aiko.com.mx' => 'Soporte'))
            ->setBody($html, 'text/html'); //body html
            if ($mailer->send($message)){
                //echo 1;
                $retorno = true;
            }else{
                $retorno = false;
                //echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
            }
        } catch (Exception $e) {
        //echo 'Excepcion',  $e->getMessage(), "\n";
        $retorno = false;
        }

    return $retorno;


}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



?>
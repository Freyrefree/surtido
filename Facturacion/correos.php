<?php

function envio($correo,$folio,$uuid){
include("../lib/swift_required.php");

$html='<center><table width="72%"  style="border: 1px solid #337AB7;" bgcolor="#337AB7">
		<tr align="left">	
			<td style="vertical-align:bottom;height:40px;" ><font color="#FFFFFF"><h3>&nbsp;&nbsp;Factura electrónica</h3></font></td>
		</tr>
		</table>
		<table width="72%" style="border: 1px solid #337AB7;">
			<tr>
				<td colspan=3 align="left"><br><br>Estimado Usuario,<br><br>Su comprobante ha sido generado.
				<br>Le remitimos como adjunto el comprobante solicitado de su compra con folio '.$folio.'.<br><br>
				Atentamente,<br>
				Equipo Portal facturación electrónica de AIKO SOLUCIONES.
				</td>
			</tr>
			<tr>
				<td colspan=3 align="right" style="height:40px"><p>  contacto@aiko.com.mx &nbsp; &nbsp; </p></td>
			</tr>
			<tr>
				<td colspan=3 align="justify" ><p style="font-size:10px;">Este mensaje ha sido enviado desde una dirección de correo electrónico exclusivamente de notificación que no admite mensajes. Por favor no responda al mismo.</p>
				</td>
			</tr>
		</table>';	
		try {		
				$transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
				->setUsername('contacto@aiko.com.mx')
				->setPassword('contacto**2015');
				$mailer = Swift_Mailer::newInstance($transport);
				$message = Swift_Message::newInstance('Factura electrónica. - Portal facturación electrónica AIKO‏')
					->setFrom(array('fsolorzano@aiko.com.mx' => 'Factura electrónica'))
					->setTo($correo)
					//->setReplyTo('traslados@bcdtravel.com.mx')
					->setBody($html, 'text/html')
					->attach(Swift_Attachment::fromPath('comprobantes/'.$uuid.'.pdf'))
					->attach(Swift_Attachment::fromPath('comprobantes/'.$uuid.'.xml'));
					//->attach(Swift_Attachment::fromPath($ruta_logo));
				$mailer->send($message);
		} 
		catch (Exception $e) {
		//	echo 'Excepción capturada al enviar correo a '.$correo.'.',  $e->getMessage(), "\n";
		}				
}


include('../php_conexion.php');
$folio = $_POST['folio'];
//$correo = 'fsolorzano@aiko.com.mx';  
	$consult_folio = mysql_query("SELECT r.folio,c.correo from reg_factura as r, cliente as c where c.rfc=r.receptor AND r.folio_compra='$folio' AND r.estatus='vigente'");
	$fila_folio = mysql_fetch_array($consult_folio);
	$uuid = $fila_folio[folio];
	$correo = $fila_folio[correo];

	envio($correo,$folio,$uuid);
	echo 1;



?>
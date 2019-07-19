<?php
	session_start();

	#Configuracion de rutas
	define('DS', DIRECTORY_SEPARATOR); #representa [ \ ]
	//define('ROOT', realpath(dirname(__FILE__)).DS); #representa [ ruta absoluta de la carpeta ]
	define('ROOT', "C:\\xampp\htdocs\cloudd".DS); #representa [ ruta absoluta de la carpeta ]
	//define('URL', "http://villatours.pagos.aiko.com.mx/"); #representa [ ruta web ]
	define('URL', "http://localhost/cloudd/"); #representa [ ruta web ]
	// define('URL', "http://surtiditocloud.aiko.com.mx/");
	#Configuracion de rutas

	
	
	// #Configuracion de correo
	// define('MSERVER', "mail.aiko.com.mx"); #Host servidor de correos [ pruebas ]
	// define('MPSERVER', 587);        	   #Puerto servidor de correos [ pruebas ]
	// define('CFSERVER', " "); 			   #Cifrado servidor de correos [ pruebas ] [PRO : ", TLS"]
	// define('USER', "soporte@aiko.com.mx"); #Usuario correo servidor de correos [ pruebas ]
	// define('PASS', "soporte**17"); 		   #Password correo servidor de correos [ pruebas ]
	// #Configuracion de correo

?>
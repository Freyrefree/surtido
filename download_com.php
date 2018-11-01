<?php
//Si la variable archivo que pasamos por URL no esta 
//establecida acabamos la ejecucion del script.
if (!isset($_GET['archivo']) || empty($_GET['archivo'])) {
   exit();
}
//---------------obtencion de parametros para la descarga----------------------
$files = basename($_GET['archivo']);
$id=$_GET['id'];
$tipo=$_GET['val'];
//---------------direccion de obtencion de archivos----------------------------
/*$carpeta = 'doc_'.$tipo."/".$id;
mkdir($carpeta);*/
$archivo_final = 'archivos_'.$tipo.'_'.$id.'.zip'; // .zip *

//-----------------------------------------------------------------------------
#prueba 
/*$txt = 'doc_'.$tipo."/".$id."/datos.txt";
$fil=fopen($txt,"a") or die("Error");
  //vamos añadiendo el contenido
  fputs($fil,"primera linea");
  fputs($fil,"\n");
  fputs($fil,"segunda linea");
  fputs($fil,"\n");
  fputs($fil,"tercera linea");
  fclose($fil);*/
#fin prueba
$zip = new ZipArchive();
if ($zip->open($archivo_final, ZIPARCHIVE::CREATE)==TRUE){
	$abrir = opendir($carpeta);
		while ($archivo = readdir($abrir)) {
			if (is_dir($archivo)){//verificamos si es o no un directorio
			    }else {
			        $zip->addFile($carpeta."/".$archivo);
			    }
		}
		$zip->close();
		header("Content-type: application/zip");
		header("Content-Disposition: attachment; filename=".$archivo_final);
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: 0");
		readfile($archivo_final);
		unlink($archivo_final);
		//closedir($abrir);
		
	/*$dir = $carpeta."/";
	$handle = opendir($dir);

while ($file = readdir($handle)){
	if (is_file($dir.$file)) { unlink($dir.$file); }
}
rmdir($carpeta);*/
} else {echo 'No se ha podido crear el archivo zip!';}

//echo 'Listo';
 

//Utilizamos basename por seguridad, devuelve el 
//nombre del archivo eliminando cualquier ruta.
/*$archivo = (explode(",",$files));
$max = sizeof($archivo);
for($i = 0; $i < $max;$i++)
	{
		$ruta = 'doc_compra/'.$id.'/'.$archivo[$i];
		//echo  $rura;
		//echo "<script>alert('$ruta')</script>";
		if (is_file($ruta))
		{
		   header('Content-Type: application/force-download');
		   header('Content-Disposition: attachment; filename='.$archivo[$i]);
		   header('Content-Transfer-Encoding: binary');
		   header('Content-Length: '.filesize($ruta));
		   readfile($ruta);

		   //header_remove('Content-Type');
		}
		else
		   exit();
	}*/
?>
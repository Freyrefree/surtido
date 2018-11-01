<?php
	error_reporting(0);
	set_time_limit(0);
    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Description: File Transfer");
    header("Content-Type: image/jpg");
    header('Content-Disposition: attachment; filename="'.basename($_GET['a']).'"');
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($_GET['a']));
    readfile($_GET['a']);
?>
/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.5.5-10.0.17-MariaDB : Database - tienda_demo
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`tienda_demo` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tienda_demo`;

/*Table structure for table `caja` */

DROP TABLE IF EXISTS `caja`;

CREATE TABLE `caja` (
  `id_cajero` varchar(20) NOT NULL,
  `apertura` varchar(20) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `horainicio` varchar(20) NOT NULL,
  `horafin` varchar(20) NOT NULL,
  `cantidad` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `caja` */

/*Table structure for table `caja_tmp` */

DROP TABLE IF EXISTS `caja_tmp`;

CREATE TABLE `caja_tmp` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `cant` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `exitencia` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `caja_tmp` */

/*Table structure for table `camion` */

DROP TABLE IF EXISTS `camion`;

CREATE TABLE `camion` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `year_mod` varchar(255) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `camion` */

insert  into `camion`(`id`,`marca`,`modelo`,`year_mod`,`placa`,`descripcion`) values (5,'FORD','F250','1999','FDRE534','PARA VIAJES DE MATERIAL DIVERSO'),(6,'FORD','F350','1896','FSRW534','PARA MATERIAL PESADO');

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `codigo` bigint(50) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(15) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `cel` varchar(20) NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `pais` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `municipio` varchar(200) NOT NULL,
  `colonia` varchar(200) NOT NULL,
  `cp` bigint(50) NOT NULL,
  `next` bigint(10) DEFAULT NULL,
  `nint` bigint(10) DEFAULT NULL,
  `regimen` varchar(100) NOT NULL,
  `calle` varchar(200) NOT NULL,
  `estatus` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `cliente` */

insert  into `cliente`(`codigo`,`rfc`,`nom`,`correo`,`tel`,`cel`,`empresa`,`pais`,`estado`,`municipio`,`colonia`,`cp`,`next`,`nint`,`regimen`,`calle`,`estatus`) values (3,'MOHJ860911HR1','juan','jmorales@aiko.com.mx','12345','7227084992','JUAN MORALES HERNANDES','MEXICO','MEXICO','TEMOAYA','MOLINO ABAJO',50850,302,0,'PERSONA FISICA','REVOLUCION','s'),(6,'XAXX010101000','Francisco','jmorales@aiko.com.mx','1231231234','','PUBLICO EN GENERAL','MÃ‰XICO','ESTADO DE MÃ‰XICO','TOLUCA','VERTICE',51256,100,0,'','VERTICE','s');

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id_compra` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_producto` varchar(255) DEFAULT NULL,
  `nom_producto` varchar(255) NOT NULL,
  `num_remision` varchar(255) NOT NULL,
  `cantidad` bigint(50) DEFAULT NULL,
  `fecha` varchar(255) DEFAULT NULL,
  `costo` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `dir_file` varchar(500) NOT NULL,
  PRIMARY KEY (`id_compra`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `compras` */

insert  into `compras`(`id_compra`,`id_producto`,`nom_producto`,`num_remision`,`cantidad`,`fecha`,`costo`,`venta`,`dir_file`) values (1,'1','COCA COLA','f',24,'2015-12-07','6','10',''),(2,'1','COCA COLA','F 10010',20,'2015-12-07','6','10','426a6798-5ab0-422f-9dee-d886631ec65b.pdf'),(3,'1','COCA COLA','F 30',20,'2015-12-07','6','10','426a6798-5ab0-422f-9dee-d886631ec65b.xml'),(4,'2','LALA','F512',50,'2015-12-10','10','15.50','426a6798-5ab0-422f-9dee-d886631ec65b.pdf,426a6798-5ab0-422f-9dee-d886631ec65b.xml,aikofirma-01.jpg'),(5,'1','COCA COLA','M563',5,'2015-12-09','6','10','426a6798-5ab0-422f-9dee-d886631ec65b.pdf,426a6798-5ab0-422f-9dee-d886631ec65b.xml,aikofirma-01.jpg'),(6,'2','LALA','F350',10,'2015-12-09','10','15.50','426a6798-5ab0-422f-9dee-d886631ec65b.pdf,426a6798-5ab0-422f-9dee-d886631ec65b.xml,aikofirma-01.jpg');

/*Table structure for table `credito` */

DROP TABLE IF EXISTS `credito`;

CREATE TABLE `credito` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_factura` bigint(50) NOT NULL,
  `rfc_cliente` varchar(20) NOT NULL,
  `total` varchar(255) NOT NULL,
  `adelanto` varchar(255) NOT NULL,
  `resto` varchar(255) NOT NULL,
  `fecha_venta` date NOT NULL,
  `fecha_pago` date NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `credito` */

insert  into `credito`(`id`,`id_factura`,`rfc_cliente`,`total`,`adelanto`,`resto`,`fecha_venta`,`fecha_pago`,`estatus`) values (6,1004,'MOHJ860911HR1','15.5','','15.5','2015-12-09','2015-12-09',0),(7,1006,'MOHJ860911HR1','10','20','-10','2015-12-15','2015-12-15',0);

/*Table structure for table `creditos` */

DROP TABLE IF EXISTS `creditos`;

CREATE TABLE `creditos` (
  `id_creditos` int(11) NOT NULL AUTO_INCREMENT,
  `rfc_cliente` varchar(20) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `consumidos` int(11) DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_creditos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `creditos` */

insert  into `creditos`(`id_creditos`,`rfc_cliente`,`creditos`,`estatus`,`consumidos`,`fecha_asignacion`) values (1,'ESI920427886',490,1,200,'2016-01-04 14:27:53'),(2,'ESI920427886',500,2,0,'2016-01-05 13:06:06');

/*Table structure for table `dat_fiscal` */

DROP TABLE IF EXISTS `dat_fiscal`;

CREATE TABLE `dat_fiscal` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `pais` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `municipio` varchar(20) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `calle` varchar(50) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `next` varchar(20) DEFAULT NULL,
  `nint` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `num_certificado` varchar(50) DEFAULT NULL,
  `archivo_cer` varchar(50) DEFAULT NULL,
  `archivo_pem` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  `regimen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `dat_fiscal` */

insert  into `dat_fiscal`(`id_empresa`,`rfc`,`razon_social`,`pais`,`estado`,`municipio`,`colonia`,`calle`,`cp`,`next`,`nint`,`correo`,`telefono`,`celular`,`num_certificado`,`archivo_cer`,`archivo_pem`,`user_id`,`user_pass`,`regimen`) values (1,'ESI920427886','EMPRESA DEMO','MÉXICO','ESTADO DE MÉXICO','toluca','vertice','colonia vertice',12345,'100','0','fsolorzano@aiko.com.mx','7221895812','7221895812','20001000000200000192','20001000000200000192.cer','20001000000200000192.key.pem','UsuarioPruebasWS','b9ec2afa3361a59af4b4d102d3f704eabdf097d4','No aplica');

/*Table structure for table `detalle` */

DROP TABLE IF EXISTS `detalle`;

CREATE TABLE `detalle` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `factura` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fecha_op` datetime NOT NULL,
  `usu` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `detalle` */

insert  into `detalle`(`id`,`factura`,`codigo`,`nombre`,`cantidad`,`valor`,`importe`,`tipo`,`fecha_op`,`usu`) values (5,'1004','2','LALA','1','15.50','15.50','CREDITO','2015-12-09 14:23:51','admin'),(6,'1005','2','LALA','10','15.50','155','CONTADO','2015-12-15 11:39:31','admin'),(7,'1006','1','COCA COLA','1','10','10','CREDITO','2015-12-15 11:40:30','admin'),(8,'1007','2','LALA','1','15.50','15.50','CONTADO','2015-12-15 11:41:16','admin'),(9,'1008','1','COCA COLA','1','10','10','CONTADO','2015-12-15 13:08:11','admin'),(10,'1009','1','COCA COLA','5','10','50','CONTADO','2015-12-15 17:55:00','admin'),(11,'1009','2','LALA','10','15.50','155','CONTADO','2015-12-15 17:55:00','admin');

/*Table structure for table `detalle_caja` */

DROP TABLE IF EXISTS `detalle_caja`;

CREATE TABLE `detalle_caja` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_cajero` varchar(20) NOT NULL,
  `apertura` varchar(20) NOT NULL,
  `ventas` varchar(100) NOT NULL,
  `horainicio` varchar(10) NOT NULL,
  `horacierre` varchar(10) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `detalle_caja` */

/*Table structure for table `empresa` */

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa` (
  `id` int(255) NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel1` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel2` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `iva` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tamano` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `empresa` */

/*Table structure for table `factura` */

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura` (
  `factura` varchar(255) NOT NULL,
  `cajera` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `factura` */

insert  into `factura`(`factura`,`cajera`,`fecha`,`estado`) values ('1000','admin','2015-12-09','s'),('1001','admin','2015-12-09','s'),('1002','admin','2015-12-09','s'),('1003','admin','2015-12-09','s'),('1004','admin','2015-12-09','s'),('1005','admin','2015-12-15','s'),('1006','admin','2015-12-15','s'),('1007','admin','2015-12-15','s'),('1008','admin','2015-12-15','s'),('1009','admin','2015-12-15','s');

/*Table structure for table `gastos` */

DROP TABLE IF EXISTS `gastos`;

CREATE TABLE `gastos` (
  `id_gasto` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_camion` bigint(50) NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `numero_fact` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `total` varchar(100) NOT NULL,
  `iva` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `gastos` */

insert  into `gastos`(`id_gasto`,`id_camion`,`concepto`,`numero_fact`,`fecha`,`total`,`iva`,`descripcion`,`documento`) values (3,4,'cambio de aceite','FK7645','2015-12-08','1000','160.00','SE PAGO EL CAMBIO DE ACEITE DEL CAMION 1','426a6798-5ab0-422f-9dee-d886631ec65b.pdf'),(4,0,'LUZ','GT4231','2015-12-09','2863','458.08','SE PAGO LA LUZ DEL MES DE OCTUBRE','426a6798-5ab0-422f-9dee-d886631ec65b.pdf,426a6798-5ab0-422f-9dee-d886631ec65b.xml,aikofirma-01.jpg'),(5,0,'AGUA','GT5432','2015-12-09','200','32.00','SE PAGO EL AGUA','426a6798-5ab0-422f-9dee-d886631ec65b.pdf,426a6798-5ab0-422f-9dee-d886631ec65b.xml,aikofirma-01.jpg');

/*Table structure for table `historial_creditos` */

DROP TABLE IF EXISTS `historial_creditos`;

CREATE TABLE `historial_creditos` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(80) DEFAULT NULL,
  `operacion` varchar(10) DEFAULT NULL,
  `fecha_operacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_historial`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `historial_creditos` */

insert  into `historial_creditos`(`id_historial`,`folio`,`operacion`,`fecha_operacion`) values (1,'6B711824-5943-4B0D-A0BC-6D3B47AD0BF7','generacion','2016-01-04 00:00:00'),(2,'6B711824-5943-4B0D-A0BC-6D3B47AD0BF7','cancelado','2016-01-05 14:42:32');

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `cod` varchar(255) NOT NULL,
  `prov` varchar(255) NOT NULL,
  `cprov` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `costo` varchar(255) NOT NULL,
  `mayor` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `minimo` varchar(255) NOT NULL,
  `seccion` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `clase` varchar(255) NOT NULL,
  `unidad` bigint(50) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `producto` */

insert  into `producto`(`cod`,`prov`,`cprov`,`nom`,`costo`,`mayor`,`venta`,`cantidad`,`minimo`,`seccion`,`fecha`,`estado`,`clase`,`unidad`) values ('1','','1','COCA COLA','6','7','10','62','10','','2015-12-09','s','',0),('2','12','123456789','LALA','10','10','15.50','38','5','7','2015-12-09','s','',1);

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `codigo` int(255) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `cel` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `estado` text NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `calle` varchar(500) NOT NULL,
  `colonia` varchar(200) NOT NULL,
  `lestado` varchar(100) NOT NULL,
  `next` bigint(10) NOT NULL,
  `nint` bigint(10) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `cp` bigint(50) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `proveedor` */

insert  into `proveedor`(`codigo`,`empresa`,`nom`,`dir`,`ciudad`,`tel`,`cel`,`correo`,`obs`,`estado`,`rfc`,`calle`,`colonia`,`lestado`,`next`,`nint`,`pais`,`cp`,`regimen`) values (12,'FRANK LACTEOS SA DE CV','francisco','','ZINACANTEPEC','12345','7221895812','fsolorsano@aiko.com.mx','','s','SOAF851017M6A','FRANCISCO JAVIER MINA','SANTA CRUZ','MEXICO',104,0,'MEXICO',51370,'PERSONA FISICA');

/*Table structure for table `reg_factura` */

DROP TABLE IF EXISTS `reg_factura`;

CREATE TABLE `reg_factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `folio_compra` int(11) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `emisor` varchar(20) DEFAULT NULL,
  `receptor` varchar(20) DEFAULT NULL,
  `importe` float(15,0) DEFAULT NULL,
  `folio` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `fecha_facturacion` datetime DEFAULT NULL,
  `fecha_cancelacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `reg_factura` */

insert  into `reg_factura`(`id_factura`,`folio_compra`,`fecha_compra`,`emisor`,`receptor`,`importe`,`folio`,`estatus`,`fecha_facturacion`,`fecha_cancelacion`) values (14,1009,'2015-12-15','ESI920427886','XAXX010101000',NULL,'6B711824-5943-4B0D-A0BC-6D3B47AD0BF7','vigente','2016-01-04 14:39:31',NULL);

/*Table structure for table `seccion` */

DROP TABLE IF EXISTS `seccion`;

CREATE TABLE `seccion` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `seccion` */

insert  into `seccion`(`id`,`nombre`,`estado`) values (7,'lacteos','s');

/*Table structure for table `unidad_medida` */

DROP TABLE IF EXISTS `unidad_medida`;

CREATE TABLE `unidad_medida` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `abreviatura` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `equivalencia` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `unidad_medida` */

insert  into `unidad_medida`(`id`,`nombre`,`abreviatura`,`descripcion`,`equivalencia`) values (1,'LITRO','LT','para venta de lacteos','1000 ml');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `ced` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `cel` varchar(255) NOT NULL,
  `cupo` varchar(255) NOT NULL,
  `barrio` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `con` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `sueldo` bigint(50) NOT NULL,
  `sexo` varchar(2) NOT NULL,
  PRIMARY KEY (`ced`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`ced`,`estado`,`nom`,`dir`,`tel`,`cel`,`cupo`,`barrio`,`ciudad`,`usu`,`con`,`tipo`,`cp`,`sueldo`,`sexo`) values ('abc','s','Administrador','calle conocida','123','123','1','barrio conocido','mexico','admin','admin','a','2',2,'h');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

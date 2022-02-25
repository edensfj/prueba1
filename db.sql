-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pruebas2
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `estado` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (3,'laptos',1),(7,'placas',1),(11,'PARTES DE COMPUTADOR',1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perfil` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_super` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `can_delete` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `can_update` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `can_create` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles`
--

LOCK TABLES `perfiles` WRITE;
/*!40000 ALTER TABLE `perfiles` DISABLE KEYS */;
INSERT INTO `perfiles` VALUES (1,'ADMINISTRADOR',1,0,0,0),(2,'DIGITADOR',0,1,1,1),(3,'USUARIO',0,0,0,0);
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `estado` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `precio` decimal(20,5) unsigned NOT NULL DEFAULT 0.00000,
  `img` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (2,'mouse',1,10000.00000,'',''),(3,'teclado',1,59000.00000,'',''),(5,'memoria ram 6gb',1,256000.00000,'',''),(7,'teclado retroiluminado',0,60000.00000,'','');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_categorias`
--

DROP TABLE IF EXISTS `productos_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_categorias` (
  `idcategoria` int(10) unsigned NOT NULL,
  `idproducto` int(10) unsigned NOT NULL,
  KEY `idcategoria` (`idcategoria`),
  KEY `idproducto` (`idproducto`),
  CONSTRAINT `productos_categorias_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`),
  CONSTRAINT `productos_categorias_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_categorias`
--

LOCK TABLES `productos_categorias` WRITE;
/*!40000 ALTER TABLE `productos_categorias` DISABLE KEYS */;
INSERT INTO `productos_categorias` VALUES (11,5),(11,3),(7,3),(11,7),(11,2);
/*!40000 ALTER TABLE `productos_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idperfil` int(10) unsigned NOT NULL DEFAULT 0,
  `nombre` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dni` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tel` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `direccion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,'SUPER ADMINISTRADOR','55555','21232f297a57a5a743894a0e4a801fc3','','',''),(2,2,'gerente de tienda','1102231345','742bd91d2d21061e40359913fbff49d7','','',''),(3,3,'vendedor','1102231346','22981ee8bebef1155b820e13b18f0e53','','','');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-24 20:59:04

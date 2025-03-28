SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `emendsrtv` DEFAULT CHARACTER SET utf8;
USE `emendsrtv`;

-- Table `Tipo de documento`
CREATE TABLE IF NOT EXISTS `Tipo de documento` (
  `idTipodedocumento` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipodedocumento`)
) ENGINE = InnoDB;

-- Table `Roles`
CREATE TABLE IF NOT EXISTS `Roles` (
  `idRoles` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRoles`)
) ENGINE = InnoDB;

-- Table `Menu`
CREATE TABLE IF NOT EXISTS `Menu` (
  `idMenu` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE = InnoDB;

-- Table `Mesa`
CREATE TABLE IF NOT EXISTS `Mesa` (
  `idMesa` INT AUTO_INCREMENT NOT NULL,
  `NumeroPiso` INT NOT NULL,
  `NumeroMesa` INT NOT NULL,
  PRIMARY KEY (`idMesa`)
) ENGINE = InnoDB;

-- Table `Eventos`
CREATE TABLE IF NOT EXISTS `Eventos` (
  `idEventos` INT AUTO_INCREMENT NOT NULL,
  `Titulo` VARCHAR(255) NOT NULL,
  `Descripcion` VARCHAR(50) NOT NULL,
  `Fecha_Evento` DATETIME NOT NULL,
  PRIMARY KEY (`idEventos`)
) ENGINE = InnoDB;

-- Table `CodigoNis`
CREATE TABLE IF NOT EXISTS `CodigoNis` (
  `idCodigoNis` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(100) NOT NULL,
  `Disponibilidad` TINYINT NOT NULL,
  `Menu_idMenu` INT NOT NULL,
  `Mesa_idMesa` INT NOT NULL,
  `Eventos_idEventos` INT NULL,
  PRIMARY KEY (`idCodigoNis`),
  CONSTRAINT `fk_CodigoNis_Menu1` FOREIGN KEY (`Menu_idMenu`) REFERENCES `Menu` (`idMenu`),
  CONSTRAINT `fk_CodigoNis_Mesa1` FOREIGN KEY (`Mesa_idMesa`) REFERENCES `Mesa` (`idMesa`),
  CONSTRAINT `fk_CodigoNis_Eventos1` FOREIGN KEY (`Eventos_idEventos`) REFERENCES `Eventos` (`idEventos`)
) ENGINE = InnoDB;

-- Table `Usuario`
CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT AUTO_INCREMENT NOT NULL,
  `Nombres` VARCHAR(45) NOT NULL,
  `Apellidos` VARCHAR(45) NOT NULL,
  `Documento` VARCHAR(35) NOT NULL,
  `Correo` VARCHAR(100) NOT NULL,
  `Contraseña` VARBINARY(200) NOT NULL,
  `FechaDeNacimiento` DATE NOT NULL,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) DEFAULT '0',
  `Tipo de documento_idTipodedocumento` INT  NULL,
  `Roles_idRoles` INT NOT NULL,
  `CodigoNis_idCodigoNis` INT NULL,
  PRIMARY KEY (`idUsuario`),
  CONSTRAINT `fk_Usuario_Tipo de documento` FOREIGN KEY (`Tipo de documento_idTipodedocumento`) REFERENCES `Tipo de documento` (`idTipodedocumento`),
  CONSTRAINT `fk_Usuario_Roles1` FOREIGN KEY (`Roles_idRoles`) REFERENCES `Roles` (`idRoles`),
  CONSTRAINT `fk_Usuario_CodigoNis1` FOREIGN KEY (`CodigoNis_idCodigoNis`) REFERENCES `CodigoNis` (`idCodigoNis`)
) ENGINE = InnoDB;

-- Table `Producto`
CREATE TABLE IF NOT EXISTS `Producto` (
  `idProducto` INT AUTO_INCREMENT NOT NULL,
  `Precio` FLOAT NOT NULL,
  `Disponibilidad` TINYINT NOT NULL,
  `Cantidad` INT NOT NULL,
  `CodigoNis_idCodigoNis` INT  NULL,
  PRIMARY KEY (`idProducto`),
  CONSTRAINT `fk_Producto_CodigoNis1` FOREIGN KEY (`CodigoNis_idCodigoNis`) REFERENCES `CodigoNis` (`idCodigoNis`)
) ENGINE = InnoDB;

-- Table `Categoria`
CREATE TABLE IF NOT EXISTS `Categoria` (
  `idCategoria` INT AUTO_INCREMENT NOT NULL,
  `Nombre` VARCHAR(105) NOT NULL,
  `Descripcion` VARCHAR(450) NOT NULL,
  `Foto1` VARCHAR(350) NOT NULL,
  `Foto2` VARCHAR(350) NULL,
  `Foto3` VARCHAR(350) NULL,
  `Producto_idProducto` INT NOT NULL,
  PRIMARY KEY (`idCategoria`),
  CONSTRAINT `fk_Categoria_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `Producto` (`idProducto`)
) ENGINE = InnoDB;

-- Table `Entrega`
CREATE TABLE IF NOT EXISTS `Entrega` (
  `idEntrega` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(450)  NULL,
  `Entregado` TINYINT NOT NULL,
  PRIMARY KEY (`idEntrega`)
) ENGINE = InnoDB;

-- Table `Solicitud`
CREATE TABLE IF NOT EXISTS `Solicitud` (
  `idSolicitud` INT AUTO_INCREMENT NOT NULL,
  `Descripcion` VARCHAR(405) NOT NULL,
  `Informe` VARCHAR(450) NULL,
  `Despachado` TINYINT NOT NULL,
  `Entrega_idEntrega` INT  NULL,
  PRIMARY KEY (`idSolicitud`),
  CONSTRAINT `fk_Solicitud_Entrega1` FOREIGN KEY (`Entrega_idEntrega`) REFERENCES `Entrega` (`idEntrega`)
) ENGINE = InnoDB;

-- Table `Orden`
CREATE TABLE IF NOT EXISTS `Orden` (
  `idOrden` INT AUTO_INCREMENT NOT NULL,
  `TokenCliente` VARCHAR(450)  NULL,
  `Descripcion` VARCHAR(450) NOT NULL,
  `PrecioFinal` FLOAT NOT NULL,
  `Fecha` DATETIME NOT NULL,
  `Producto_idProducto` INT  NULL,
  `Solicitud_idSolicitud` INT  NULL,
  PRIMARY KEY (`idOrden`),
  CONSTRAINT `fk_Orden_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `Producto` (`idProducto`),
  CONSTRAINT `fk_Orden_Solicitud1` FOREIGN KEY (`Solicitud_idSolicitud`) REFERENCES `Solicitud` (`idSolicitud`)
) ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- Crear el esquema con codificación UTF-8
CREATE SCHEMA emendsrtv DEFAULT CHARACTER SET utf8;

-- Usar el esquema recién creado
USE emendsrtv;

-- Crear la tabla users
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `Nombres` varchar(45) NOT NULL,
  `Apellidos` varchar(45) NOT NULL,
  `Documento` varchar(35) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contraseña` varbinary(200) NOT NULL,
  `FechaDeNacimiento` date NOT NULL,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `Tipo de documento_idTipodedocumento` int(11) DEFAULT NULL,
  `Roles_idRoles` int(11) NOT NULL,
  `CodigoNis_idCodigoNis` int(11) DEFAULT NULL
) ENGINE=InnoDB;


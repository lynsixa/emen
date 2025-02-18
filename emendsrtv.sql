-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2025 a las 15:23:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `emendsrtv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `foto1` varchar(250) NOT NULL,
  `foto2` varchar(250) NOT NULL,
  `foto3` varchar(250) NOT NULL,
  `producto_idProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idClientes` int(11) NOT NULL,
  `Nombre` varchar(125) NOT NULL,
  `Documento` varchar(45) NOT NULL,
  `Correo` varchar(45) NOT NULL,
  `Contraseña` varbinary(255) NOT NULL,
  `Fechadenacimiento` datetime NOT NULL,
  `roles_idRoles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idClientes`, `Nombre`, `Documento`, `Correo`, `Contraseña`, `Fechadenacimiento`, `roles_idRoles`) VALUES
(12, '123', '123', '123@gmail.com', 0x243279243130243731526b35495258356f5a5161783739774b6436746531686d7a7551653868525736492f4d2f4563594d39305039304e564f6d7171, '2003-12-11 00:00:00', 1),
(0, 'cp', '1234', '1234@gmail.com', 0x2432792431302465613849354b752f674c3577304f7a677253487134753758594d4668707032652f482e30655a554c6c484171583150637878456c69, '2002-12-11 00:00:00', 4),
(0, 'lyahn', '103053161', 'trollgamem@gmail.com', 0x24327924313024526a754842376556464268536e656f514937744f5975356453794e4832304b394c3843764a694b7a2e6d386959454c387763745736, '2003-12-11 00:00:00', 4),
(0, 'anae', '10546622', 'quinonezjohana2477@gmail.com', 0x243279243130244a68716e4b686b596a643071396a482e68426e764d4f57686b7a515a4d66416f7642376b2f4a673579764d6b5453422e377a4c4b32, '2004-05-31 00:00:00', 4),
(0, 'pepe', '555854446', 'johana35@gmail.com', 0x2432792431302452546d69327154336c6f726f524e6d594d6a4f63356553454371385471696572794b79717a4a7354674442426a5a41444f71697443, '2000-02-05 00:00:00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigonis`
--

CREATE TABLE `codigonis` (
  `idCodigoNIS` int(11) NOT NULL,
  `Descripcion` varchar(10) NOT NULL,
  `mesa_idMesa` int(11) NOT NULL,
  `menu_idMenu` int(11) NOT NULL,
  `cliente_idClientes` int(11) DEFAULT NULL,
  `Producto_idProducto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigonis`
--

INSERT INTO `codigonis` (`idCodigoNIS`, `Descripcion`, `mesa_idMesa`, `menu_idMenu`, `cliente_idClientes`, `Producto_idProducto`) VALUES
(2, '124', 7, 2, NULL, NULL),
(3, '21432', 8, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalledeorden`
--

CREATE TABLE `detalledeorden` (
  `idDetalleDeOrden` int(11) NOT NULL,
  `Descripcion` varchar(700) NOT NULL,
  `Hora` time NOT NULL,
  `Entregado` tinyint(4) NOT NULL,
  `orden_idOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_evento` datetime NOT NULL,
  `menu_idMenu1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEvento`, `titulo`, `descripcion`, `fecha_evento`, `menu_idMenu1`) VALUES
(0, 'HolaMundo', '31', '2025-01-24 01:10:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL,
  `Descripcion` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `Descripcion`) VALUES
(1, 'Común'),
(2, 'Evento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `Numeropiso` int(11) NOT NULL,
  `NumeroMesa` int(11) NOT NULL,
  `CantidadPuestos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `Numeropiso`, `NumeroMesa`, `CantidadPuestos`) VALUES
(1, 123, 123, 1234),
(2, 123, 1123, 123),
(3, 12, 12, 12),
(4, 12, 12, 12),
(5, 12, 12, 12),
(6, 12, 12, 12),
(7, 2, 123, 123122),
(8, 453, 123, 123);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metododepago`
--

CREATE TABLE `metododepago` (
  `idmetodoDePago` int(11) NOT NULL,
  `Metodo` varchar(45) NOT NULL,
  `detalledeorden_idDetalleDeOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idOrden` int(11) NOT NULL,
  `tokenCliente` int(11) NOT NULL,
  `PrecioFinal` float NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Precio` float NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `orden_idOrden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `Descripcion`) VALUES
(1, 'Admin'),
(2, 'Gerente'),
(3, 'Bartender'),
(4, 'Cliente');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

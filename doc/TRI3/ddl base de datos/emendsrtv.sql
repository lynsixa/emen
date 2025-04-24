-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2025 a las 00:17:41
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
  `idCategoria` int(11) NOT NULL,
  `Nombre` varchar(105) NOT NULL,
  `Descripcion` varchar(450) NOT NULL,
  `Foto1` varchar(350) NOT NULL,
  `Foto2` varchar(350) DEFAULT NULL,
  `Foto3` varchar(350) DEFAULT NULL,
  `Producto_idProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `Nombre`, `Descripcion`, `Foto1`, `Foto2`, `Foto3`, `Producto_idProducto`) VALUES
(25, 'Don Perignon', 'Champgne', 'http://localhost/Proyecto/roles/UsuarioconCrud/gesProductos/fotosProductos/champagne/domPerignon/1.1.png', 'http://localhost/Proyecto/roles/UsuarioconCrud/gesProductos/fotosProductos/champagne/domPerignon/1.2.png', 'http://localhost/Proyecto/roles/UsuarioconCrud/gesProductos/fotosProductos/champagne/domPerignon/1.3.png', 32),
(26, 'Moet Ice', 'Champgne', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/moetIce/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/moetIce/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/moetIce/3.png', 33),
(27, 'Vueve Clicquot', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/veuveClicquot/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/veuveClicquot/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/veuveClicquot/3.png', 34),
(28, 'Chandon Rose', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/chandonRose/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/chandonRose/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/chandonRose/3.png', 35),
(29, 'JP. GOLD', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpGold/1.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpGold/2.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpGold/3.webp', 36),
(30, 'JP. Chenet Rose', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpChenetRose/1.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpChenetRose/2.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/champagne/jpChenetRose/3.webp', 37),
(31, 'Buchanan\'s 18 años', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_18_A%C3%B1os/2.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_18_A%C3%B1os/1.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_18_A%C3%B1os/3.jpg', 38),
(32, 'Buchanan\'s 12 años', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_12_A%C3%B1os/2.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_12_A%C3%B1os/1.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_12_A%C3%B1os/3.webp', 39),
(33, 'Buchanan\'s Master', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_Master/1.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_Master/2.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Buchanans_Master/3.jpg', 40),
(34, 'Chivas Extra 13 años', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_Extra_13_A%C3%B1os/3.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_Extra_13_A%C3%B1os/2.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_Extra_13_A%C3%B1os/1.webp', 41),
(53, 'Chivas 12 años', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_12_A%C3%B1os/1.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_12_A%C3%B1os/2.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Chivas_12_A%C3%B1os/3.jpg', 42),
(54, 'Jack Daniel\'s', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels/3.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels/2.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels/1.jpeg', 43),
(55, 'Jack Daniel\'s N7', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels_N7/1.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels_N7/2.webp', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Whisky/Jack_Daniels_N7/3.webp', 44),
(56, 'Don Julio 70', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_70/2.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_70/1.jpg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_70/3.jpg', 45),
(57, 'Don Julio Reposado', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Reposado/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Reposado/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Reposado/3.png', 46),
(58, 'Don Julio Blanco', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Blanco/1.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Blanco/2.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Don_Julio_Blanco/3.jpeg', 47),
(59, 'Olmeca Sirver', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Silver/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Silver/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Silver/3.png', 48),
(60, 'Olmeca Reposado', 'Whisky', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Reposado/1.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Reposado/2.jpeg', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Tequila/Olmeca_Reposado/3.jpeg', 49),
(61, 'Antioqueño Real', 'Champán', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Aguardiente/Antioque%C3%B1o_Real/1.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Aguardiente/Antioque%C3%B1o_Real/2.png', 'http://localhost/Proyecto/Roles/Usuarioconcrud/gesProductos/fotosProductos/Aguardiente/Antioque%C3%B1o_Real/3.png', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigonis`
--

CREATE TABLE `codigonis` (
  `idCodigoNis` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL,
  `Menu_idMenu` int(11) NOT NULL,
  `Mesa_idMesa` int(11) NOT NULL,
  `Eventos_idEventos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigonis`
--

INSERT INTO `codigonis` (`idCodigoNis`, `Descripcion`, `Disponibilidad`, `Menu_idMenu`, `Mesa_idMesa`, `Eventos_idEventos`) VALUES
(1, '123', 1, 1, 1, NULL),
(2, '1234', 0, 2, 2, NULL),
(3, '12', 1, 1, 3, NULL),
(4, '1', 1, 2, 4, NULL),
(5, '1453', 0, 1, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `idEntrega` int(11) NOT NULL,
  `Descripcion` varchar(450) DEFAULT NULL,
  `Entregado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrega`
--

INSERT INTO `entrega` (`idEntrega`, `Descripcion`, `Entregado`) VALUES
(2, 'Entrega de pedido 2', 1),
(3, 'Entrega de pedido 3', 0),
(4, 'Entrega de pedido 4', 1),
(5, 'Entrega de pedido 5', 0),
(6, 'Entrega de los productos en proceso. Usuario: ', 0),
(7, 'Entrega de los productos en proceso. Usuario: ', 0),
(8, 'Entrega de los productos en proceso. Usuario: ', 0),
(9, 'Entrega de los productos en proceso. Usuario: ', 0),
(10, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(11, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(12, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(13, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(14, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(15, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(16, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(17, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(18, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(19, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(20, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(21, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(22, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(23, 'Entrega de los productos en proceso. Usuario: Andres Silva', 0),
(24, 'Entrega de los productos en proceso. Usuario: Sandra Peñaranda', 0),
(25, 'Entrega de los productos en proceso. Usuario: Juan Rayz', 0),
(26, 'Entrega de los productos en proceso. Usuario: Juan Rayz', 1),
(27, 'Entrega de los productos en proceso. Usuario: Juan Rayz', 0),
(28, 'Entrega de los productos en proceso. Usuario: Juan Rayz', 0),
(29, 'Entrega de los productos en proceso. Usuario: Juan Rayz', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEventos` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Fecha_Evento` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEventos`, `Titulo`, `Descripcion`, `Fecha_Evento`) VALUES
(1, 'Conferencia de Tecnología', 'Conferencia sobre innovaciones tecnológicas', '2025-04-10 09:00:00'),
(2, 'Concierto de Jazz', 'Concierto de música jazz', '2025-04-15 20:00:00'),
(3, 'Cena de Gala', 'Cena de gala para invitados especiales', '2025-04-20 18:30:00'),
(4, 'Exposición de Arte', 'Exposición de arte moderno', '2025-05-01 10:00:00'),
(6, 'Cumpleaños', 'joahana', '2025-04-08 10:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL,
  `Descripcion` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `Descripcion`) VALUES
(1, 'Menú Común'),
(2, 'Menú de Evento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `NumeroPiso` int(11) NOT NULL,
  `NumeroMesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `NumeroPiso`, `NumeroMesa`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idOrden` int(11) NOT NULL,
  `TokenCliente` varchar(450) DEFAULT NULL,
  `Descripcion` varchar(450) NOT NULL,
  `PrecioFinal` float NOT NULL,
  `Fecha` datetime NOT NULL,
  `Producto_idProducto` int(11) DEFAULT NULL,
  `Solicitud_idSolicitud` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `Usuario_idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`idOrden`, `TokenCliente`, `Descripcion`, `PrecioFinal`, `Fecha`, `Producto_idProducto`, `Solicitud_idSolicitud`, `cantidad`, `Usuario_idUsuario`) VALUES
(7, 'token1', 'Orden de bebidas', 50, '2025-03-21 12:00:00', NULL, NULL, 1, NULL),
(8, 'token2', 'Orden de comida rápida', 75, '2025-03-21 12:15:00', NULL, NULL, 1, NULL),
(9, 'token3', 'Orden de postres', 30, '2025-03-21 12:30:00', NULL, NULL, 1, NULL),
(10, 'token4', 'Orden de aperitivos', 40, '2025-03-21 12:45:00', NULL, NULL, 1, NULL),
(11, 'token5', 'Orden de ensaladas', 25, '2025-03-21 13:00:00', NULL, NULL, 1, NULL),
(13, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 32, 15, 1, 6),
(14, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 32, 15, 1, 6),
(15, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 33, 15, 1, 6),
(16, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 36, 15, 1, 6),
(17, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 33, 15, 1, 6),
(18, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 33, 15, 1, 6),
(19, '47e1c453ab47be6b5b79701b319f6239', 'Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis: No disponible | Mesa: N/A | Pis', 7960030, '0000-00-00 00:00:00', 33, 15, 1, 6),
(20, 'dd0e4e9b2a901594b18dd9a93e6418ef', 'Moet Ice (Cantidad: 3) - Precio: $930000.000 | Total: $2790000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 2790000, '0000-00-00 00:00:00', 33, 16, 1, 6),
(21, 'd52e36a5cb5307d256c43fec080641f3', 'Vueve Clicquot (Cantidad: 3) - Precio: $930000.000 | Total: $2790000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 2790000, '0000-00-00 00:00:00', 34, 17, 1, 6),
(22, '0931277a85169a1d382a733112673ea6', 'Vueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 930000, '0000-00-00 00:00:00', 34, 18, 1, 6),
(23, '4fd3c4b6c855fd8eff4bd3e75c75abc7', 'Moet Ice (Cantidad: 2) - Precio: $930000.000 | Total: $1860000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 1860000, '0000-00-00 00:00:00', 33, 19, 1, 6),
(24, '6f1ea492ad874d825089ea1f9220fa7e', 'Moet Ice (Cantidad: 2) - Precio: $930000.000 | Total: $1860000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 1860000, '0000-00-00 00:00:00', 33, 20, 1, 6),
(25, '26ba204d4a84f82b8ba44a62660a1b08', 'Moet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 930000, '0000-00-00 00:00:00', 33, 21, 1, 6),
(26, '67bddbf12c56772da001b58418e67675', 'Don Perignon (Cantidad: 2) - Precio: $2500000.000 | Total: $5000000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 5000000, '0000-00-00 00:00:00', 32, 22, 1, 6),
(27, 'd64297e841b982f0e76d930b5d367936', 'Moet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 930000, '0000-00-00 00:00:00', 33, 23, 1, 6),
(28, 'b5593fb8cf29fcd0a223e0d8e0a61f0f', 'Moet Ice (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 3720000, '0000-00-00 00:00:00', 33, 24, 1, 8),
(29, '5facbf55d3f1805d5f0193216f4a91dd', 'Jack Daniel\'s N7 (Cantidad: 1) - Precio: $300000.000 | Total: $300000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 1230000, '0000-00-00 00:00:00', 44, 25, 1, 9),
(30, '5facbf55d3f1805d5f0193216f4a91dd', 'Jack Daniel\'s N7 (Cantidad: 1) - Precio: $300000.000 | Total: $300000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 1230000, '0000-00-00 00:00:00', 33, 25, 1, 9),
(31, 'fe2d0406b10c9a8761dcd5629ea27989', 'Vueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $2500000.000 | Total: $2500000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 3430000, '0000-00-00 00:00:00', 34, 26, 1, 9),
(32, 'fe2d0406b10c9a8761dcd5629ea27989', 'Vueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $2500000.000 | Total: $2500000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n', 3430000, '0000-00-00 00:00:00', 32, 26, 1, 9),
(33, '74c89cb3a788d2fc40d3136315f3cc7c', 'Vueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 930000, '0000-00-00 00:00:00', 34, 27, 1, 9),
(34, '6977d6bb42c236192e6c900cd566e3eb', 'Chandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 1260000, '0000-00-00 00:00:00', 35, 28, 1, 9),
(35, '6977d6bb42c236192e6c900cd566e3eb', 'Chandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 1260000, '0000-00-00 00:00:00', 33, 28, 1, 9),
(36, '769118f802f6d2d15315cc14993426b6', 'Chandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s Master (Cantidad: 1) - Precio: $460000.000 | Total: $460000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s 12 años (Cantidad: 1) - Precio: $400000.000 | Total: $400000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 1190000, '0000-00-00 00:00:00', 35, 29, 1, 9),
(37, '769118f802f6d2d15315cc14993426b6', 'Chandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s Master (Cantidad: 1) - Precio: $460000.000 | Total: $460000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s 12 años (Cantidad: 1) - Precio: $400000.000 | Total: $400000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 1190000, '0000-00-00 00:00:00', 40, 29, 1, 9),
(38, '769118f802f6d2d15315cc14993426b6', 'Chandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s Master (Cantidad: 1) - Precio: $460000.000 | Total: $460000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s 12 años (Cantidad: 1) - Precio: $400000.000 | Total: $400000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n', 1190000, '0000-00-00 00:00:00', 39, 29, 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Precio` decimal(10,3) NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `CodigoNis_idCodigoNis` int(11) DEFAULT NULL,
  `Categoria_idCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `Precio`, `Disponibilidad`, `Cantidad`, `CodigoNis_idCodigoNis`, `Categoria_idCategoria`) VALUES
(32, 2500000.000, 0, 50, NULL, NULL),
(33, 930000.000, 1, 9, NULL, NULL),
(34, 930000.000, 1, 99, NULL, NULL),
(35, 330000.000, 1, 28, NULL, NULL),
(36, 260000.000, 1, 15, NULL, NULL),
(37, 250000.000, 1, 50, NULL, NULL),
(38, 660000.000, 1, 20, NULL, NULL),
(39, 400000.000, 1, 99, NULL, NULL),
(40, 460000.000, 1, 29, NULL, NULL),
(41, 380000.000, 1, 26, NULL, NULL),
(42, 340000.000, 1, 50, NULL, NULL),
(43, 320000.000, 1, 32, NULL, NULL),
(44, 300000.000, 1, 100, NULL, NULL),
(45, 20.000, 1, 30, NULL, NULL),
(46, 10.500, 1, 50, NULL, NULL),
(47, 15.750, 1, 14, NULL, NULL),
(48, 7.250, 1, 100, NULL, NULL),
(49, 20.000, 1, 30, NULL, NULL),
(50, 12.500, 1, 13, NULL, NULL);

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
(1, 'Administrador'),
(2, 'Gerente'),
(3, 'Mesero'),
(4, 'Usuario'),
(5, 'Bartender');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `idSolicitud` int(11) NOT NULL,
  `Descripcion` varchar(405) NOT NULL,
  `Informe` varchar(450) DEFAULT NULL,
  `Despachado` tinyint(4) NOT NULL,
  `Entrega_idEntrega` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`idSolicitud`, `Descripcion`, `Informe`, `Despachado`, `Entrega_idEntrega`) VALUES
(2, 'Solicitud de pedido 2', 'Informe de calidad', 0, 2),
(3, 'Solicitud de pedido 3', 'Informe urgente', 1, 3),
(4, 'Solicitud de pedido 4', NULL, 0, 4),
(5, 'Solicitud de pedido 5', NULL, 1, 5),
(6, 'Solicitud de productos: Don Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 2) - Precio: $930000.000 | Total: $1860000 | Código Nis:  | Mesa:  | Piso: \nOlmeca Reposado (Cantidad: 1) - Precio: $20.000 | Total: $20 | Código Nis:  | Mesa:', NULL, 0, 6),
(7, 'Solicitud de productos: Don Perignon (Cantidad: 3) - Precio: $930000.000 | Total: $2790000 | Código Nis:  | Mesa:  | Piso: \n | Nombre usuario: ', NULL, 0, 7),
(8, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis:  | Mesa:  | Piso: \nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis:  | Mesa:  | Piso: \n', NULL, 0, 8),
(9, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis:  | Mesa:  | Piso: \nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis:  | Mesa:  | Piso: \n', NULL, 0, 9),
(10, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis:  | Mesa:  | Piso: \nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis:  | Mesa:  | Piso: \n', NULL, 0, 10),
(11, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis:  | Mesa:  | Piso: \nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis:  | Mesa:  | Piso: \nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis:  | Mesa:  | Piso: \nJP. GOLD (Cantidad: 2) - Precio: $260000.000 | Total: $520000 | Código Nis:  | Mesa:  | Piso: \n', NULL, 0, 11),
(12, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $2600', NULL, 0, 12),
(13, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $2600', NULL, 0, 13),
(14, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $2600', NULL, 0, 14),
(15, 'Solicitud de productos: Don Perignon (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 2) - Precio: $16.000 | Total: $32 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nJP. GOLD (Cantidad: 2) - Precio: $2600', NULL, 0, 15),
(16, 'Solicitud de productos: Moet Ice (Cantidad: 3) - Precio: $930000.000 | Total: $2790000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 16),
(17, 'Solicitud de productos: Vueve Clicquot (Cantidad: 3) - Precio: $930000.000 | Total: $2790000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 17),
(18, 'Solicitud de productos: Vueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 18),
(19, 'Solicitud de productos: Moet Ice (Cantidad: 2) - Precio: $930000.000 | Total: $1860000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 19),
(20, 'Solicitud de productos: Moet Ice (Cantidad: 2) - Precio: $930000.000 | Total: $1860000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 20),
(21, 'Solicitud de productos: Moet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 21),
(22, 'Solicitud de productos: Don Perignon (Cantidad: 2) - Precio: $2500000.000 | Total: $5000000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 22),
(23, 'Solicitud de productos: Moet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Andres Silva', NULL, 0, 23),
(24, 'Solicitud de productos: Moet Ice (Cantidad: 4) - Precio: $930000.000 | Total: $3720000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n | Nombre usuario: Sandra Peñaranda', NULL, 0, 24),
(25, 'Solicitud de productos:\nJack Daniel\'s N7 (Cantidad: 1) - Precio: $300000.000 | Total: $300000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n\nUsuario: Juan Rayz', NULL, 0, 25),
(26, 'Solicitud de productos:\nVueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\nDon Perignon (Cantidad: 1) - Precio: $2500000.000 | Total: $2500000 | Código Nis: No disponible | Mesa: N/A | Piso: N/A\n\nUsuario: Juan Rayz', NULL, 1, 26),
(27, 'Solicitud de productos:\nVueve Clicquot (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n\nUsuario: Juan Rayz', NULL, 0, 27),
(28, 'Solicitud de productos:\nChandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nMoet Ice (Cantidad: 1) - Precio: $930000.000 | Total: $930000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n\nUsuario: Juan Rayz', NULL, 0, 28),
(29, 'Solicitud de productos:\nChandon Rose (Cantidad: 1) - Precio: $330000.000 | Total: $330000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s Master (Cantidad: 1) - Precio: $460000.000 | Total: $460000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\nBuchanan\'s 12 años (Cantidad: 1) - Precio: $400000.000 | Total: $400000 | Código Nis: 1234 | Mesa: 2 | Piso: 1\n\nUsuario: Juan Rayz', NULL, 0, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo de documento`
--

CREATE TABLE `tipo de documento` (
  `idTipodedocumento` int(11) NOT NULL,
  `Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo de documento`
--

INSERT INTO `tipo de documento` (`idTipodedocumento`, `Descripcion`) VALUES
(1, 'Cédula de ciudadanía'),
(2, 'Pasaporte'),
(3, 'Cédula de extranjería'),
(4, 'Permiso especial de permanencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Nombres`, `Apellidos`, `Documento`, `Correo`, `Contraseña`, `FechaDeNacimiento`, `token`, `token_password`, `password_request`, `Tipo de documento_idTipodedocumento`, `Roles_idRoles`, `CodigoNis_idCodigoNis`) VALUES
(1, 'Juan', 'Pérez', '1234567890', 'juan.perez@mail.com', 0x5f4dcc3b5aa765d61d8327deb882cf99, '1985-02-15', '', NULL, 0, 1, 1, NULL),
(2, 'María', 'Gómez', '9876543210', 'maria.gomez@mail.com', 0x5f4dcc3b5aa765d61d8327deb882cf99, '1990-05-20', '', NULL, 0, 2, 2, NULL),
(3, 'Carlos', 'Rodríguez', '1029384756', 'carlos.rodriguez@mail.com', 0x5f4dcc3b5aa765d61d8327deb882cf99, '1995-08-25', '', NULL, 0, 3, 3, NULL),
(4, 'Laura', 'Martínez', '5647382910', 'laura.martinez@mail.com', 0x5f4dcc3b5aa765d61d8327deb882cf99, '1980-12-10', '', NULL, 0, 4, 4, NULL),
(5, 'Pedro', 'Hernández', '1122334455', 'pedro.hernandez@mail.com', 0x5f4dcc3b5aa765d61d8327deb882cf99, '2000-01-01', '', NULL, 0, 3, 5, NULL),
(6, 'Andres', 'Silva', '1140917400', 'andres.silva310230@gmail.com', 0x243279243130246872677449716a563531756c6b6b334854305949612e7a4f615144584156736f4276486d7a77714c4e586b65705133376f724f4a6d, '2000-10-16', '654a807a7ab8e062d6a31cad11afa477', '81bcb0d3e15e83b9ce933a1d10665b7b', 1, 1, 1, NULL),
(7, 'Johana', 'Milena', '1234567890', 'joana@gmail.com', 0x243279243130244e4937634d51456139747475372f714f6864613666754745377556425756765a44542e43443449667036697556474d74667a4e4c71, '2000-10-17', '3ae59a4e2c1bdc01d1c61a2fb5cf3c0b', NULL, 0, 1, 4, NULL),
(8, 'Sandra', 'Peñaranda', '2345690845', 'sandra@gmail.com', 0x2432792431302442385a30737a55494f66463951397738544944316d4f574b2f637957524a51504d6f42332e4f655a3074474d77386b52636244534b, '2000-02-10', 'a6d9236653df7e6af782befce2812046', NULL, 0, 1, 5, NULL),
(9, 'Juan', 'Rayz', '1021670419', 'estebantellez0515@outlook.com', 0x24327924313024517970623338336131635534425170476c436b617175626b6e36457766614e4444456c504e59383656316f685a4a435a534d423547, '2000-02-12', 'fc8c6dbe7dcc761c652f113255e2606b', NULL, 0, 1, 4, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD KEY `fk_Categoria_Producto1` (`Producto_idProducto`);

--
-- Indices de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD PRIMARY KEY (`idCodigoNis`),
  ADD KEY `fk_CodigoNis_Menu1` (`Menu_idMenu`),
  ADD KEY `fk_CodigoNis_Mesa1` (`Mesa_idMesa`),
  ADD KEY `fk_CodigoNis_Eventos1` (`Eventos_idEventos`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`idEntrega`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEventos`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idOrden`),
  ADD KEY `fk_Orden_Producto1` (`Producto_idProducto`),
  ADD KEY `fk_Orden_Solicitud1` (`Solicitud_idSolicitud`),
  ADD KEY `fk_usuario` (`Usuario_idUsuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `fk_Producto_CodigoNis1` (`CodigoNis_idCodigoNis`),
  ADD KEY `Categoria_idCategoria` (`Categoria_idCategoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`idSolicitud`),
  ADD KEY `fk_Solicitud_Entrega1` (`Entrega_idEntrega`);

--
-- Indices de la tabla `tipo de documento`
--
ALTER TABLE `tipo de documento`
  ADD PRIMARY KEY (`idTipodedocumento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_Usuario_Tipo de documento` (`Tipo de documento_idTipodedocumento`),
  ADD KEY `fk_Usuario_Roles1` (`Roles_idRoles`),
  ADD KEY `fk_Usuario_CodigoNis1` (`CodigoNis_idCodigoNis`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  MODIFY `idCodigoNis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `idEntrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tipo de documento`
--
ALTER TABLE `tipo de documento`
  MODIFY `idTipodedocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_Categoria_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD CONSTRAINT `fk_CodigoNis_Eventos1` FOREIGN KEY (`Eventos_idEventos`) REFERENCES `eventos` (`idEventos`),
  ADD CONSTRAINT `fk_CodigoNis_Menu1` FOREIGN KEY (`Menu_idMenu`) REFERENCES `menu` (`idMenu`),
  ADD CONSTRAINT `fk_CodigoNis_Mesa1` FOREIGN KEY (`Mesa_idMesa`) REFERENCES `mesa` (`idMesa`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `fk_Orden_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `fk_Orden_Solicitud1` FOREIGN KEY (`Solicitud_idSolicitud`) REFERENCES `solicitud` (`idSolicitud`),
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_Producto_CodigoNis1` FOREIGN KEY (`CodigoNis_idCodigoNis`) REFERENCES `codigonis` (`idCodigoNis`),
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`Categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_Solicitud_Entrega1` FOREIGN KEY (`Entrega_idEntrega`) REFERENCES `entrega` (`idEntrega`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_CodigoNis1` FOREIGN KEY (`CodigoNis_idCodigoNis`) REFERENCES `codigonis` (`idCodigoNis`),
  ADD CONSTRAINT `fk_Usuario_Roles1` FOREIGN KEY (`Roles_idRoles`) REFERENCES `roles` (`idRoles`),
  ADD CONSTRAINT `fk_Usuario_Tipo de documento` FOREIGN KEY (`Tipo de documento_idTipodedocumento`) REFERENCES `tipo de documento` (`idTipodedocumento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

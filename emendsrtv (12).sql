-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-02-2025 a las 19:09:47
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

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `foto1`, `foto2`, `foto3`, `producto_idProducto`) VALUES
(1, 'Don perignon', 'Dom Pérignon es un prestigioso champán francés de la región de Champagne, conocido por su refinamiento y calidad excepcional. Elaborado únicamente en las mejores cosechas, cada botella de Dom Pérignon ofrece una experiencia única, combinando elegancia, frescura y complejidad. Su sabor delicado y su burbujea fina lo convierten en una opción ideal para celebraciones especiales. Con un aroma suave de frutas maduras, flores y notas de pan tostado, Do', '../gesProductos/fotosProductos/1/1.1.png', '../gesProductos/fotosProductos/1/1.2.png', '../gesProductos/fotosProductos/1/1.3.png', 1);

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
(1, '123', '123', '123@gmail.com', 0x24327924313024584e43776c6163516e6558354f5042555249586c4d752f39753657717358413179616237316e714d656e664e7a75645a6831646f61, '2003-10-20 00:00:00', 4),
(2, 'Carol', '1202054679', '1234@gmail.com', 0x243279243130247668326b437130476948504e53334a374e3261784d4f43437a4f70793464756b307354306f6f31435271626b6b316d4d4632693743, '2003-12-11 00:00:00', 1),
(3, 'ama', '123455678', 'mama@gmail.com', 0x2432792431302468414e70724861642e2f5345326b775145326c58522e722e4d397349674b4d584d444d6547336e7263465a754f434835394b543361, '2005-09-22 00:00:00', 1),
(4, 'Andres', '1140917200', 'andres@gmail.com', 0x243279243130244b6d64575571362f6c7a5646326b4877706a4d39526557474c742f2e6f4d2f383578564a5339754e42676138715949634f70785265, '2005-10-17 00:00:00', 4);

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
(2, '124', 7, 2, NULL, NULL);

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
(4, 'Fiesta', 'Hora Loca', '2025-01-22 21:00:00', 2),
(9, 'Cumple', 'carlos', '2025-01-22 21:30:00', 2);

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
(7, 2, 123, 123122);

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
-- Estructura de tabla para la tabla `pedidostemporales`
--

CREATE TABLE `pedidostemporales` (
  `idPedidoTemporal` int(11) NOT NULL,
  `cliente_idClientes` int(11) NOT NULL,
  `producto_idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_agregado` datetime NOT NULL DEFAULT current_timestamp(),
  `tokenCliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Precio` float NOT NULL,
  `disponibilidad` enum('disponible','no disponible') DEFAULT 'disponible',
  `Cantidad` int(11) NOT NULL,
  `orden_idOrden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `Precio`, `disponibilidad`, `Cantidad`, `orden_idOrden`) VALUES
(1, 930000, 'disponible', 60, NULL);

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD KEY `fk_categoria_producto1_idx` (`producto_idProducto`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idClientes`),
  ADD KEY `fk_cliente_roles_idx` (`roles_idRoles`);

--
-- Indices de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD PRIMARY KEY (`idCodigoNIS`),
  ADD KEY `fk_codigonis_mesa1_idx` (`mesa_idMesa`),
  ADD KEY `fk_codigonis_menu1_idx` (`menu_idMenu`),
  ADD KEY `fk_codigonis_cliente1_idx` (`cliente_idClientes`),
  ADD KEY `fk_codigonis_producto1_idx` (`Producto_idProducto`);

--
-- Indices de la tabla `detalledeorden`
--
ALTER TABLE `detalledeorden`
  ADD PRIMARY KEY (`idDetalleDeOrden`),
  ADD KEY `fk_detalledeorden_orden1_idx` (`orden_idOrden`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `fk_eventos_menu1_idx1` (`menu_idMenu1`);

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
-- Indices de la tabla `metododepago`
--
ALTER TABLE `metododepago`
  ADD PRIMARY KEY (`idmetodoDePago`),
  ADD KEY `fk_metododepago_detalledeorden1_idx` (`detalledeorden_idDetalleDeOrden`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idOrden`);

--
-- Indices de la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  ADD PRIMARY KEY (`idPedidoTemporal`),
  ADD KEY `fk_pedidostemporales_cliente_idx` (`cliente_idClientes`),
  ADD KEY `fk_pedidostemporales_producto_idx` (`producto_idProducto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `fk_producto_orden1_idx` (`orden_idOrden`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idClientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  MODIFY `idCodigoNIS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idOrden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  MODIFY `idPedidoTemporal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_producto1` FOREIGN KEY (`producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_roles` FOREIGN KEY (`roles_idRoles`) REFERENCES `roles` (`idRoles`);

--
-- Filtros para la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD CONSTRAINT `fk_codigonis_cliente1` FOREIGN KEY (`cliente_idClientes`) REFERENCES `cliente` (`idClientes`),
  ADD CONSTRAINT `fk_codigonis_menu1` FOREIGN KEY (`menu_idMenu`) REFERENCES `menu` (`idMenu`),
  ADD CONSTRAINT `fk_codigonis_mesa1` FOREIGN KEY (`mesa_idMesa`) REFERENCES `mesa` (`idMesa`),
  ADD CONSTRAINT `fk_codigonis_producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `detalledeorden`
--
ALTER TABLE `detalledeorden`
  ADD CONSTRAINT `fk_detalledeorden_orden1` FOREIGN KEY (`orden_idOrden`) REFERENCES `orden` (`idOrden`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_eventos_menu1` FOREIGN KEY (`menu_idMenu1`) REFERENCES `menu` (`idMenu`);

--
-- Filtros para la tabla `metododepago`
--
ALTER TABLE `metododepago`
  ADD CONSTRAINT `fk_metododepago_detalledeorden1` FOREIGN KEY (`detalledeorden_idDetalleDeOrden`) REFERENCES `detalledeorden` (`idDetalleDeOrden`);

--
-- Filtros para la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  ADD CONSTRAINT `fk_pedidostemporales_cliente` FOREIGN KEY (`cliente_idClientes`) REFERENCES `cliente` (`idClientes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedidostemporales_producto` FOREIGN KEY (`producto_idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_orden1` FOREIGN KEY (`orden_idOrden`) REFERENCES `orden` (`idOrden`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

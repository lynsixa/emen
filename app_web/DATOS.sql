-- Insertar datos en la tabla `Tipo de documento`
INSERT INTO `Tipo de documento` (`Descripcion`) VALUES
('Cédula de ciudadanía'),
('Pasaporte'),
('Cédula de extranjería'),
('Permiso especial de permanencia');

-- Insertar datos en la tabla `Roles`
INSERT INTO `Roles` (`Descripcion`) VALUES
('Administrador'),
('Gerente'),
('Mesero'),
('Usuario'),
('Bartender');

-- Insertar datos en la tabla `Menu`
INSERT INTO `Menu` (`Descripcion`) VALUES
('Menú Común'),
('Menú de Evento');

-- Insertar datos en la tabla `Mesa`
INSERT INTO `Mesa` (`NumeroPiso`, `NumeroMesa`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1);

-- Insertar datos en la tabla `Eventos`
INSERT INTO `Eventos` (`Titulo`, `Descripcion`, `Fecha_Evento`) VALUES
('Conferencia de Tecnología', 'Conferencia sobre innovaciones tecnológicas', '2025-04-10 09:00:00'),
('Concierto de Jazz', 'Concierto de música jazz', '2025-04-15 20:00:00'),
('Cena de Gala', 'Cena de gala para invitados especiales', '2025-04-20 18:30:00'),
('Exposición de Arte', 'Exposición de arte moderno', '2025-05-01 10:00:00'),
('Fiesta de Fin de Año', 'Fiesta para despedir el año', '2025-12-31 23:00:00');

-- Insertar datos en la tabla `CodigoNis`
INSERT INTO `CodigoNis` (`Descripcion`, `Disponibilidad`, `Menu_idMenu`, `Mesa_idMesa`, `Eventos_idEventos`) VALUES
('123', 1, 1, 1, NULL),
('1234', 0, 2, 2, NULL),
('12', 1, 1, 3, NULL),
('1', 1, 2, 4, NULL),
('1453', 0, 1, 5, NULL);

-- Insertar datos en la tabla `Usuario`
INSERT INTO `Usuario` (`Nombres`, `Apellidos`, `Documento`, `Correo`, `Contraseña`, `FechaDeNacimiento`, `Tipo de documento_idTipodedocumento`, `Roles_idRoles`) VALUES
('Juan', 'Pérez', '1234567890', 'juan.perez@mail.com', UNHEX('5f4dcc3b5aa765d61d8327deb882cf99'), '1985-02-15', 1, 1),
('María', 'Gómez', '9876543210', 'maria.gomez@mail.com', UNHEX('5f4dcc3b5aa765d61d8327deb882cf99'), '1990-05-20', 2, 2),
('Carlos', 'Rodríguez', '1029384756', 'carlos.rodriguez@mail.com', UNHEX('5f4dcc3b5aa765d61d8327deb882cf99'), '1995-08-25', 3, 3),
('Laura', 'Martínez', '5647382910', 'laura.martinez@mail.com', UNHEX('5f4dcc3b5aa765d61d8327deb882cf99'), '1980-12-10', 4, 4),
('Pedro', 'Hernández', '1122334455', 'pedro.hernandez@mail.com', UNHEX('5f4dcc3b5aa765d61d8327deb882cf99'), '2000-01-01', 3, 5);

-- Insertar datos en la tabla `Producto`
INSERT INTO `Producto` (`Precio`, `Disponibilidad`, `Cantidad`) VALUES
(10.5, 1, 50),
(15.75, 0, 0),
(7.25, 1, 100),
(20.0, 1, 30),
(12.5, 0, 0);

-- Insertar datos en la tabla `Categoria`
INSERT INTO `Categoria` (`Nombre`, `Descripcion`, `Foto1`, `Foto2`, `Foto3`, `Producto_idProducto`) VALUES
('buchainas', 'Whisky', 'foto_bebida1.jpg', 'foto_bebida2.jpg', 'foto_bebida3.jpg', 1),
('jp', 'Champán', 'foto_ensalada1.jpg', 'foto_ensalada2.jpg', 'foto_ensalada3.jpg', 5);

-- Insertar datos en la tabla `Entrega`
INSERT INTO `Entrega` (`Descripcion`, `Entregado`) VALUES
('Entrega de pedido 1', 1),
('Entrega de pedido 2', 0),
('Entrega de pedido 3', 1),
('Entrega de pedido 4', 0),
('Entrega de pedido 5', 1);

-- Insertar datos en la tabla `Solicitud`
INSERT INTO `Solicitud` (`Descripcion`, `Informe`, `Despachado`, `Entrega_idEntrega`) VALUES
('Solicitud de pedido 1', NULL, 1, 1),
('Solicitud de pedido 2', 'Informe de calidad', 0, 2),
('Solicitud de pedido 3', 'Informe urgente', 1, 3),
('Solicitud de pedido 4', NULL, 0, 4),
('Solicitud de pedido 5', NULL, 1, 5);

-- Insertar datos en la tabla `Orden`
INSERT INTO `Orden` (`TokenCliente`, `Descripcion`, `PrecioFinal`, `Fecha`) VALUES
('token1', 'Orden de bebidas', 50.0, '2025-03-21 12:00:00'),
('token2', 'Orden de comida rápida', 75.0, '2025-03-21 12:15:00'),
('token3', 'Orden de postres', 30.0, '2025-03-21 12:30:00'),
('token4', 'Orden de aperitivos', 40.0, '2025-03-21 12:45:00'),
('token5', 'Orden de ensaladas', 25.0, '2025-03-21 13:00:00');
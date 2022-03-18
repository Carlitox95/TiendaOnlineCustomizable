--
-- Insertamos el Usuario Administrador "ADMIN" "1234asd"
--

INSERT INTO `user` (`id`, `username`, `mail`, `roles`, `password`, `direccion_id`) VALUES(1, 'Admin', 'carlos.drsnak@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$diVSxgQfkPem/D1NwHXHMe4uyOHtE.66T9d2Or1vB16B6Z.EuvZcq', NULL);

--
-- Cargamos los estados posibles de una venta
--

INSERT INTO `estadoventa` (`id`, `estado`) VALUES(1,'NUEVA');
INSERT INTO `estadoventa` (`id`, `estado`) VALUES(2,'EN_PROCESO');
INSERT INTO `estadoventa` (`id`, `estado`) VALUES(3,'FINALIZADA');
INSERT INTO `estadoventa` (`id`, `estado`) VALUES(4,'CANCELADA');
INSERT INTO `estadoventa` (`id`, `estado`) VALUES(5,'RECHAZADA');

--
-- Cargamos el Mensaje predeterminado para la HOME
--

INSERT INTO `configuracion` (`id`, `mensaje`, `activo`, `tipo`) VALUES (1, 'Somos una Tienda que busca....  \r\nvender muchos productos y hacer dinero , con eso tener mas stock y mejores productos , para hacer mas dinero, porque me gusta el dinero\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text...\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text...\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text...', 1, '¿Quienes Somos? Mensaje Principal de la Home');
INSERT INTO `configuracion` (`id`, `mensaje`, `activo`, `tipo`) VALUES (2, 'Tienda', '1', 'Nombre de la Tienda');

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`id`, `nombre`, `activo`) VALUES (1, 'Activar Ventas', 1);
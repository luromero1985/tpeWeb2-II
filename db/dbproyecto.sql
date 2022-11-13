-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2022 a las 13:36:35
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbproyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `puesto` varchar(20) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `sueldo` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `puesto`, `descripcion`, `sueldo`) VALUES
(3, 'Servicio de Catering', 'Incluye la comida, la bebida, la mantelería, los cubiertos, y hasta el servicio de cocineros, camareros y personal de limpieza posterior al evento.(Precio por invitado)', 6000),
(4, 'Seguridad', 'Control de accesos. Garantiza orden y seguridad para el desarrollo del evento. Control ingresos. Manejo de evacuaciones.', 42000),
(7, 'Mozo', 'Organización de elementos de trabajo. Montaje y desmontaje de las mesas. Atención en mesa: abastecimiento de bebidas, comidas, higiene de la mesa. Comunicación con los invitados', 60000),
(8, 'Decoración', 'Distribuir el mobiliario y los elementos decorativos de una manera armoniosa a lo largo de todo el espacio para conseguir transmitir a la audiencia una experiencia cómoda y positiva. \r\n\r\n', 140000),
(9, 'Administración', 'manejo de las finanzas de la empresa', 130000),
(11, 'Limpieza', 'Limpieza y atención en toilettes, recolección de residuos y limpieza previa y posterior al evento. ', 50250),
(13, 'Sonidista', 'Se encarga de la captación, el registro, tratamiento y reproducción del sonido. así como de garantizar su calidad técnica y artística.', 113000),
(15, 'Iluminación', 'La iluminación en eventos tiene el poder de evocar emociones, señalar en qué debe fijarse la audiencia, resaltar productos, decorar el lugar, mover a los asistentes a la acción, así como aumentar la diversión entre otras cosas.', 50000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `dni` int(10) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `id_categoria_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `dni`, `celular`, `mail`, `id_categoria_fk`) VALUES
(3, 'Luana Valenzuela', 31708546, '2494026987', 'luanaV@gmail.com', 4),
(6, 'Ana Valor', 13456789, '2494328795', 'anita@gmail.com', 9),
(7, 'Lara Herrero', 47568999, '2497456892', 'lara@gmail.com', 8),
(13, 'Luciana Bello', 31708286, '123456', 'lulita@gmail.com', 11),
(14, 'Federico Barrio Nuevo', 43255111, '249787710', 'fedebn@gmail.com', 15),
(15, 'María Herrero', 48256222, '249741458', 'marita@gmail.com', 13),
(18, 'Macarena Brillo', 38447963, '249741132', 'maca@gmail.com', 11),
(20, 'Helena Maldonado', 29133478, '249777111', 'helenaM@gmail.com', 8),
(27, 'Laura Barr', 31000000, '2494785218', 'laura@gmail.com', 3),
(28, 'Amyra Payes', 31701220, '2494026102', 'ami@gmail.com', 3),
(32, 'Rómulo Remo', 54123112, '249444210', 'rr@gmail.com', 3),
(33, 'Catalina Pia', 35123110, '249444220', 'cataP@gmail.com', 15),
(34, 'Cristina Morón', 30123110, '2494111920', 'cMP@gmail.com', 15),
(35, 'Loreley Cay', 28124110, '2494122720', 'lolyP@gmail.com', 15),
(38, 'Amya Payes', 31701220, '2494026102', 'ami@gmail.com', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`) VALUES
(1, 'yael_romero@hotmail.com', '$2a$12$iV8Vo4avWxWwOfkTOzVNqeA7AfcWCC.OtgLSB6xuZZ.lOVu4lcHJe');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria_fk` (`id_categoria_fk`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_categoria_fk`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

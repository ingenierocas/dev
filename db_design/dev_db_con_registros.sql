-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-03-2024 a las 03:49:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dev_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dev_admin`
--

CREATE TABLE `dev_admin` (
  `idev_admin` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` text NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dev_admin`
--

INSERT INTO `dev_admin` (`idev_admin`, `nombre`, `usuario`, `clave`, `email`) VALUES
(1, 'Administrador', 'admin', '123456', 'ingenierocas@gmail.com'),
(2, 'Consultor 1', 'consultor1', '123456', 'lusierraa@gmail.com'),
(3, 'Consultor 2', 'consultor2', '123456', 'nubiaartunduagamolina@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dev_usuario`
--

CREATE TABLE `dev_usuario` (
  `id_dev` int(10) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `telefono` bigint(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `borrado` enum('v','f') NOT NULL DEFAULT 'v',
  `dev_admin_idev_admin` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dev_usuario`
--

INSERT INTO `dev_usuario` (`id_dev`, `nombre`, `apellido`, `telefono`, `email`, `fecha_registro`, `fecha_modificacion`, `borrado`, `dev_admin_idev_admin`) VALUES
(1, 'Carlos Andrés', 'Sierra', 318245936, 'casierraa@flare.com.co', '2024-03-21 22:01:28', '2024-03-22 01:43:21', 'v', 1),
(2, 'Luis A', 'Sierra', 3182445936, 'luissierra@flare.com.co', '2024-03-21 22:02:06', '2024-03-22 02:35:39', 'v', 1),
(3, 'William', 'Ayola Oviedo', 6626397, 'williamayola@flare.com.co', '2024-03-21 22:09:12', '2024-03-22 01:43:32', 'v', 1),
(4, 'Angela', 'Díaz', 6726397, 'angeladiaz@flare.com.co', '2024-03-22 01:39:14', '2024-03-22 02:35:47', 'v', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dev_admin`
--
ALTER TABLE `dev_admin`
  ADD PRIMARY KEY (`idev_admin`);

--
-- Indices de la tabla `dev_usuario`
--
ALTER TABLE `dev_usuario`
  ADD PRIMARY KEY (`id_dev`),
  ADD KEY `fk_dev_usuario_dev_admin` (`dev_admin_idev_admin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dev_admin`
--
ALTER TABLE `dev_admin`
  MODIFY `idev_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `dev_usuario`
--
ALTER TABLE `dev_usuario`
  MODIFY `id_dev` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dev_usuario`
--
ALTER TABLE `dev_usuario`
  ADD CONSTRAINT `fk_dev_usuario_dev_admin` FOREIGN KEY (`dev_admin_idev_admin`) REFERENCES `dev_admin` (`idev_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

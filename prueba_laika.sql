-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2021 a las 06:18:58
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_laika`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Add_TipoDocumento` (IN `_nombre` VARCHAR(20))  BEGIN

INSERT INTO tipo_documento(nombre, created_at, update_at)
VALUES (_nombre, NOW(), NOW());

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Add_user` (IN `_primer_nombre` VARCHAR(20), IN `_segundo_nombre` VARCHAR(20), IN `_primer_apellido` VARCHAR(20), IN `_segundo_apellido` VARCHAR(20), IN `_nro_documento` VARCHAR(20), IN `_tipo_documento` INT(11))  BEGIN
	INSERT INTO users (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                       nro_documento, tipo_documento_id, created_at, updated_at)
                       
    VALUES (_primer_nombre, _segundo_nombre, _primer_apellido, _segundo_apellido, _nro_documento, _tipo_documento, NOW(), NOW()); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_TipoDocumento` (IN `_id` INT(11))  BEGIN

DELETE FROM tipo_documento WHERE id = _id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_user` (IN `_id` INT(11))  BEGIN

	DELETE FROM users WHERE id = _id;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectAllTiposDocumentos` ()  BEGIN

SELECT * FROM tipo_documento;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SelectAllUSers` ()  BEGIN
	-- Seleccion de usuarios
    
    SELECT * FROM usuarios;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_tipoDocumento` (IN `_id` INT(11), IN `_nombre` VARCHAR(25))  BEGIN

UPDATE tipo_documento SET

id = _id,
nombre = _nombre

WHERE id = _id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_user` (IN `_id` INT(11), IN `_primer_nombre` VARCHAR(20), IN `_segundo_nombre` VARCHAR(20), IN `_primer_apellido` VARCHAR(20), IN `_segundo_apellido` VARCHAR(20), IN `_nro_documento` VARCHAR(20), IN `_tipo_documento_id` VARCHAR(20))  BEGIN

UPDATE users SET
primer_nombre = _primer_nombre,
segundo_nombre = _segundo_nombre,
primer_apellido = _primer_apellido,
segundo_apellido = _segundo_apellido,
nro_documento = _nro_documento,
tipo_documento_id = _tipo_documento_id

WHERE id = _id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Cédula de ciudadanía', '2021-06-24 00:34:52', '2021-06-24 00:34:52'),
(2, 'Tarjeta de identidad', '2021-06-24 00:34:52', '2021-06-24 00:34:52'),
(3, 'Otto', '2021-06-26 04:08:21', '2021-06-26 04:08:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `primer_nombre` varchar(30) NOT NULL,
  `segundo_nombre` varchar(30) NOT NULL,
  `primer_apellido` varchar(30) NOT NULL,
  `segundo_apellido` varchar(30) NOT NULL,
  `nro_documento` varchar(20) NOT NULL,
  `tipo_documento_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `nro_documento`, `tipo_documento_id`, `created_at`, `updated_at`) VALUES
(1, 'Gustavo', 'Alfonso', 'Saldarriaga', 'Pino', '100200300', 1, '2021-06-24 00:35:30', '2021-06-24 00:35:30'),
(3, 'Alfonso', 'Davies', 'Mosquera', 'Mena', '1044521230', 1, '2021-06-24 15:27:34', '2021-06-24 15:27:34'),
(4, 'Juan', 'David', 'Mosquera', 'Perez', '52320123', 1, '2021-06-24 19:48:40', '2021-06-24 19:48:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_documento_id` (`tipo_documento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

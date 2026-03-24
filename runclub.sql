-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-03-2026 a las 12:14:57
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
-- Base de datos: `runclub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `distancia` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` varchar(50) NOT NULL,
  `web_oficial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`, `fecha`, `lugar`, `distancia`, `created_at`, `tipo`, `web_oficial`) VALUES
(1, 'Zurich Maratón de Sevilla', '2026-02-15', 'Sevilla', 42, '2026-02-13 16:38:16', 'maraton', NULL),
(2, 'Carrera Popular Santísima Trinidad Córdoba', '2026-02-15', 'Córdoba', 10, '2026-02-13 16:47:42', 'popular', NULL),
(3, 'Media Maratón Mijas', '2026-02-28', 'Mijas (Málaga)', 21, '2026-02-13 16:49:12', 'media', NULL),
(4, 'Carrera Popular Parque Tamarguillo', '2026-02-28', 'Sevilla', 13, '2026-02-13 16:50:31', 'popular', NULL),
(5, 'Media Maratón Lucena', '2026-03-08', 'Lucena (Córdoba)', 21, '2026-02-13 16:51:51', 'media', NULL),
(6, 'Carrera de la Mujer Almería', '2026-03-08', 'Almería', 8, '2026-02-13 16:53:46', 'popular', NULL),
(7, 'Media Maratón Málaga', '2026-03-15', 'Málaga', 21, '2026-02-13 16:54:40', 'media', 'https://www.mediamaratonmalaga.com/'),
(8, 'Media Maratón Chipiona Rota', '2026-03-15', 'Chipiona (Cádiz)', 21, '2026-02-13 16:55:30', 'media', 'https://gesconchip.es/app/prueba/informacion/xxxix-media-maraton-costa-de-la-luz'),
(9, 'Carrera Popular Santa Clara', '2026-03-21', 'Sevilla', 5, '2026-02-13 16:58:36', 'popular', 'https://sportmaniacs.com/es/services/inscription/xiii-carrera-popular-y-solidaria-santa-clara'),
(10, 'Media Maratón Trebujena', '2026-03-22', 'Trebujena (Cádiz)', 21, '2026-02-13 16:59:30', 'media', NULL),
(11, 'Corriendown Sevilla', '2026-03-22', 'Sevilla', 5, '2026-02-13 17:01:16', 'popular', NULL),
(12, 'Media Maratón Baza', '2026-03-22', 'Baza (Granada)', 21, '2026-02-13 17:02:01', 'media', NULL),
(13, 'Trail Calamorro Skyrace', '2026-04-11', 'Benalmádena (Málaga)', 30, '2026-02-13 17:06:34', 'trail', NULL),
(14, 'Media Maratón Almería', '2026-04-12', 'Almería', 21, '2026-02-13 17:08:19', 'media', NULL),
(15, 'Media Maratón Chiclana', '2026-04-19', 'Chiclana de la frontera (Cádiz)', 21, '2026-02-13 17:09:23', 'media', NULL),
(16, 'Media Maratón Granada', '2026-04-25', 'Granada', 21, '2026-02-13 17:11:19', 'media', NULL),
(18, 'Carrera contra el cáncer Almería', '2026-07-04', 'Almería', 5, '2026-02-16 12:08:06', 'popular', NULL),
(19, 'Media Maratón Marbella', '2026-09-27', 'Marbella (Málaga)', 21, '2026-02-16 12:09:17', 'media', NULL),
(20, 'Media Maratón Jerez de la Frontera', '2026-10-18', 'Jerez de la Frontera (Cádiz)', 21, '2026-02-16 12:10:23', 'media', NULL),
(21, 'Media Maratón Huelva', '2026-11-01', 'Huelva', 21, '2026-02-16 12:11:13', 'media', NULL),
(22, 'Media Maratón Fuengirola', '2026-11-08', 'Fuengirola (Málaga)', 21, '2026-02-16 12:12:04', 'media', NULL),
(23, 'Carrera San Silvestre Rota', '2026-12-26', 'Rota (Cádiz)', 5, '2026-02-16 12:13:12', 'popular', NULL),
(24, 'Media Maratón Hinojosa del Duque', '2026-02-21', 'Alcaracejos (Córdoba)', 21, '2026-02-16 12:16:50', 'media', NULL),
(25, 'Media Maratón Vélez Málaga', '2026-05-01', 'Vélez-Málaga', 21, '2026-02-16 12:20:50', 'media', NULL),
(26, 'Carrera Nocturna Palma del Río', '2026-05-01', 'Palma del Río (Córdoba)', 7, '2026-02-16 12:22:10', 'popular', NULL),
(27, 'Trail Villanueva del Trabuco', '2026-05-02', 'Villanueva del Trabuco (Málaga)', 24, '2026-02-16 12:23:43', 'trail', NULL),
(29, 'Trail Sierro', '2026-05-03', 'Sierro (Almería)', 24, '2026-02-16 12:26:03', 'trail', NULL),
(30, 'Carrera Urbana Estepona', '2026-05-03', 'Estepona (Málaga)', 10, '2026-02-16 12:26:52', 'popular', NULL),
(31, 'Media Maratón El Ejido', '2026-05-10', 'El Ejido (Almería)', 21, '2026-02-16 12:27:40', 'media', NULL),
(32, 'Carrera Popular Salobreña', '2026-05-10', 'Salobreña (Granada)', 10, '2026-02-16 12:28:27', 'popular', NULL),
(33, 'Carrera Popular Órgiva', '2026-05-17', 'Órgiva (Granada)', 19, '2026-02-16 12:29:50', 'popular', NULL),
(34, 'Trail Valle de Almanzora', '2026-05-17', 'Armuña de Almanzora (Almería)', 21, '2026-02-16 12:31:12', 'trail', NULL),
(35, 'Carrera del Espárrago Huétor Tájar', '2026-05-23', 'Huétor-Tájar (Granada)', 10, '2026-02-16 12:32:30', 'popular', 'https://www.gpfgranada.es/'),
(36, 'Trail Lanjarón', '2026-05-30', 'Lanjarón (Granada)', 20, '2026-02-16 12:33:25', 'trail', NULL),
(37, 'Carrera Popular Huéscar', '2026-05-31', 'Huéscar (Granada)', 10, '2026-02-16 12:34:28', 'popular', NULL),
(38, 'Carrera Popular Dúrcal', '2026-06-14', 'Dúrcal (Granada)', 10, '2026-02-16 12:36:50', 'popular', NULL),
(39, 'Carrera Popular Trevélez', '2026-06-21', 'Trevélez (Granada)', 10, '2026-02-16 12:37:39', 'popular', NULL),
(40, 'Carrera Popular Río Dílar', '2026-06-28', 'Gójar (Granada)', 10, '2026-02-16 12:38:34', 'popular', NULL),
(41, 'Trail Medina Sidonia', '2026-07-04', 'Medina-Sidonia (Cádiz)', 21, '2026-02-16 12:39:40', 'trail', NULL),
(42, 'Carrera del Barro La Barca de la Florida', '2026-07-19', 'La Barca de la Florida (Cádiz)', 13, '2026-02-16 12:42:53', 'popular', NULL),
(43, 'Carrera Solidaria Conil', '2026-07-25', 'Conil de la Frontera (Cádiz)', 8, '2026-02-16 12:44:38', 'popular', NULL),
(44, 'Cross Lagos Costa Ballena', '2026-06-25', 'Rota (Cádiz)', 5, '2026-02-16 12:47:24', 'popular', NULL),
(45, 'Recorrido Atlético Playas de Rota', '2026-08-15', 'Rota (Cádiz)', 8, '2026-02-16 12:48:33', 'popular', NULL),
(46, 'Carrera Villa Romana Salar', '2026-09-13', 'Salar (Granada)', 10, '2026-02-16 12:49:24', 'popular', NULL),
(47, 'Media Maratón Guadix', '2026-09-20', 'Guadix (Granada)', 21, '2026-02-16 12:50:58', 'media', NULL),
(48, 'Carrera Popular Almuñécar', '2026-09-27', 'Almuñécar (Granada)', 10, '2026-02-16 12:52:22', 'popular', NULL),
(49, 'Cross Peña Dosa', '2026-09-27', 'Rota (Cádiz)', 10, '2026-02-16 12:53:52', 'popular', NULL),
(50, 'Cross Montalbán de Córdoba', '2026-09-27', 'Montalbán de Córdoba', 6, '2026-02-16 12:54:57', 'popular', NULL),
(51, 'Carrera Popular Casabermeja', '2026-10-04', 'Casabermeja (Málaga)', 6, '2026-02-16 12:55:57', 'popular', NULL),
(52, 'Cross El Colorado Conil de la Frontera', '2026-10-04', 'Conil de la Frontera (Cádiz)', 8, '2026-02-16 12:57:15', 'popular', NULL),
(53, 'Media Maratón Motril', '2026-10-18', 'Motril (Granada)', 21, '2026-02-16 12:58:10', 'media', NULL),
(54, 'Cross Santaella', '2026-10-25', 'Santaella (Córdoba)', 6, '2026-02-16 12:59:11', 'popular', NULL),
(55, 'Carrera Popular Santa Fe', '2026-10-25', 'Santa Fe (Granada)', 10, '2026-02-16 13:00:27', 'popular', NULL),
(56, 'Cross La Victoria', '2026-11-08', 'La Victoria (Córdoba)', 6, '2026-02-16 13:01:21', 'popular', NULL),
(57, 'Carrera Urbana Algeciras', '2026-11-08', 'Algeciras (Cádiz)', 7, '2026-02-16 13:02:25', 'popular', NULL),
(58, 'Media Maratón Sevilla', '2026-11-29', 'Sevilla', 21, '2026-02-19 18:51:39', 'media', 'https://www.mediomaratondesevilla.es/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `producto_id`, `fecha`) VALUES
(1, 17, 1, '2026-02-16 17:19:28'),
(2, 17, 2, '2026-02-16 17:20:51'),
(3, 17, 1, '2026-02-16 17:25:58'),
(4, 17, 1, '2026-02-17 11:40:16'),
(5, 13, 2, '2026-02-19 20:07:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `plazas` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nombre`, `descripcion`, `fecha`, `lugar`, `plazas`, `created_at`) VALUES
(1, 'Entrenamiento Sevilla Centro', 'Easy run 5km por el centro', '2026-05-05', 'Sevilla', 19, '2026-02-13 10:02:00'),
(2, 'Tirada larga Parque Alamillo y río', 'Long run de 15km', '2026-05-10', 'Sevilla', 14, '2026-02-13 10:05:38'),
(3, 'Entrenamiento Sevilla centro', 'Easy run 5km', '2026-02-14', 'Sevilla', 2, '2026-02-13 15:30:32'),
(4, 'Entrenamiento 5km', 'por sevilla', '2026-02-15', 'sevilla', 1, '2026-02-16 16:00:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `usuario_id`, `evento_id`, `fecha_inscripcion`) VALUES
(1, 12, 2, '2026-02-13 10:17:44'),
(4, 12, 1, '2026-02-13 10:21:05'),
(14, 17, 4, '2026-02-16 16:00:39'),
(19, 17, 1, '2026-02-17 12:24:59'),
(25, 13, 2, '2026-02-19 19:42:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_entrenamiento`
--

CREATE TABLE `planes_entrenamiento` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes_entrenamiento`
--

INSERT INTO `planes_entrenamiento` (`id`, `usuario_id`, `carrera_id`, `fecha_creacion`) VALUES
(2, 17, 13, '2026-02-16 10:49:23'),
(33, 13, 5, '2026-02-19 18:59:39'),
(35, 13, 4, '2026-02-19 19:01:46'),
(37, 13, 34, '2026-02-19 19:04:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
(1, 'Camiseta oficial ARC', 'Camiseta transpirable oficial del Andalusian Run Club', 19.99, 17, 'camiseta.jpg'),
(2, 'Gorra ARC', 'Gorra deportiva del Andalusian Run Club', 14.99, 1, 'gorra.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nivel` enum('principiante','intermedio','avanzado','') NOT NULL,
  `rol` enum('usuario','admin','','') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `nivel`, `rol`, `fecha_registro`) VALUES
(7, 'Carlos', 'ale12.agg@gmail.com', '$2y$10$xYkH1mc0WIMIXBdv5Ploeel0DzOKgUp6DRkq.qF0rCFwRDN3atggu', 'avanzado', 'usuario', '2026-02-12 18:42:04'),
(9, 'Rau', 'rau.1234@gmail.com', '$2y$10$mGCd7C61rJys/6UiS.98UeIhyqmWdZjOW.1mU5ZxbZpju3p5X7Oci', 'avanzado', 'usuario', '2026-02-12 18:52:43'),
(10, 'Alejandro', 'ale1234.agg@gmail.com', '$2y$10$UYxrY.Am9Rr.1wnJjBy89uzD.F2HVaOc21R2Fl3EWsbiUqcZe095K', 'avanzado', 'usuario', '2026-02-12 18:54:16'),
(11, 'Alejandro', 'ale1234.agg@gmail.com', '$2y$10$6BfF4MKqYJyHahAm0lNOquNL9x3XLJn1kRHlBmtrjvyhdGmBOD9E2', 'avanzado', 'usuario', '2026-02-12 19:00:24'),
(12, 'Paco', 'paco@gmail.com', '$2y$10$rUUTJSk4nfSFM9VEXCbitew778By9jvuODP3U3sPEOaaTvPp4sjkO', 'principiante', 'usuario', '2026-02-13 10:43:46'),
(13, 'ale1', 'ale1@gmail.com', '$2y$10$WrsORoMi/zKwcA3lGHhOCugH3eqJLn/m31NkatNQHagBmM2DpPiHC', 'principiante', 'usuario', '2026-02-13 16:28:16'),
(14, 'ale2', 'ale2@gmail.com', '$2y$10$yMa//H7SlmC0/d1ojzw6zexquqpc09yDOZa58tixghGzCxEh5dXb2', 'principiante', 'usuario', '2026-02-13 16:32:12'),
(15, '', '', '$2y$10$nsp/AhPvXknXV1bhFb0nSe/w5BGqRJbh95lRNETu5mhpid9SMJzJC', '', 'usuario', '2026-02-14 11:02:24'),
(16, '', '', '$2y$10$INWM7ec2F7gmq8ylWdBM0ebgeISeZwc04LMmMDB6zfiVY5KcOVc1K', '', 'usuario', '2026-02-14 11:02:51'),
(17, 'Ale9', 'ale9@gmail.com', '$2y$10$EOdNcO6sTPyWxOjhNtXcpOl5aAKn3StwslfC.VTx57G.lTLGKoO42', 'avanzado', 'usuario', '2026-02-16 11:05:47'),
(18, '', '', '$2y$10$dzddDAjsqYscFDHNQdvKdu4SXgHc0BdnsAADKE3Ofihc56Nz0Xd7u', '', 'usuario', '2026-02-17 11:22:21'),
(19, '', '', '$2y$10$d5Y7necjyqG6TtoEFUzCoOxZn3QQNn9Pj/uQuhP1oOWbEdBmNPL7S', '', 'usuario', '2026-02-17 11:29:15'),
(20, 'Alejandro', 'ale4.agg@gmail.com', '$2y$10$A26d1uBf2fayx4wyp09xD.RbUTfYv33LyP6ZXt3LxzWn/eMDyokeG', 'intermedio', 'usuario', '2026-02-25 19:50:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.2deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-01-2026 a las 04:53:00
-- Versión del servidor: 8.4.7-0ubuntu0.25.10.3
-- Versión de PHP: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `xegur`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL,
  `categoria` enum('Administradores','Empleados','Senadores','Diputados') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ingreso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editado` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `apellidos`, `nombres`, `correo`, `clave`, `sexo`, `categoria`, `ingreso`, `editado`) VALUES
(5, 'Ruiz', 'Juan Pablo', 'pablo@gmail.com', '$2y$12$1KOA5g4/VSzOSfoznIDgZ.gOkD75IE78kIYMa0gWMfjPWbO31F9By', 'Masculino', 'Administradores', '2026-01-24 01:18:24', '2026-01-24 01:47:24'),
(6, 'Quijano', 'Benjamín', 'benja@gmail.com', '$2y$12$3CDyt1CDTKSXb6JRFAckNeSWeUVvW2H0nqBIqo2P8tDwIw8b.oEF2', 'Masculino', 'Empleados', '2026-01-24 01:19:22', '2026-01-24 01:47:31'),
(7, 'Braillard Poccard', 'Pedro José', 'pedro@gmail.com', '$2y$12$jC7a1dajfWK4T8eDlN61guH1BmDzil5YzOHfaLpZs7jXEaur5911W', 'Masculino', 'Senadores', '2026-01-24 01:22:34', '2026-01-24 01:47:36'),
(8, 'Breard', 'Noél', 'noel@gmail.com', '$2y$12$Q3.LJDaEnjfXsfdjv9jonO1mvfEglBYV3CY5G7X/j.VYnf38PhnaK', 'Masculino', 'Senadores', '2026-01-24 01:40:31', '2026-01-24 01:47:41'),
(9, 'Rotela Cañete', 'Albana', 'albana@gmail.com', '$2y$12$ucGGpBVKjObayZpVcpB1yObs7aMnjzYyRq5cjU46fOJqktKhoFFSK', 'Femenino', 'Diputados', '2026-01-24 01:43:54', '2026-01-24 01:47:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

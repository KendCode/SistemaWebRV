-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 04:10:40
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
-- Base de datos: `sistema_escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_docente`
--

CREATE TABLE `asignaciones_docente` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `materia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones_docente`
--

INSERT INTO `asignaciones_docente` (`id`, `profesor_id`, `curso_id`, `materia_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(7, 1, 6, 4),
(10, 1, 9, 7),
(50, 3, 4, 5),
(51, 25, 4, 3),
(52, 27, 6, 1),
(53, 2, 1, 1),
(54, 2, 2, 1),
(55, 29, 1, 8),
(56, 21, 10, 1),
(57, 22, 10, 2),
(58, 30, 10, 8),
(59, 30, 10, 10),
(60, 29, 10, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `asignacion_id` int(11) DEFAULT NULL,
  `trimestre1` decimal(5,2) DEFAULT NULL CHECK (`trimestre1` between 0 and 100),
  `trimestre2` decimal(5,2) DEFAULT NULL CHECK (`trimestre2` between 0 and 100),
  `trimestre3` decimal(5,2) DEFAULT NULL CHECK (`trimestre3` between 0 and 100),
  `nota_final` decimal(5,2) GENERATED ALWAYS AS (round((`trimestre1` + `trimestre2` + `trimestre3`) / 3,2)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `estudiante_id`, `asignacion_id`, `trimestre1`, `trimestre2`, `trimestre3`) VALUES
(1, 1, 1, 85.00, 90.00, 88.00),
(2, 2, 2, 70.00, 75.00, 80.00),
(7, 7, 7, 92.00, 91.00, 90.00),
(10, 10, 10, 83.00, 86.00, 85.00),
(13, 1, 2, 75.00, NULL, NULL),
(17, 1, 7, 55.00, NULL, NULL),
(18, 21, 58, 89.00, 0.00, 0.00),
(19, 19, 58, 81.00, 0.00, 0.00),
(20, 17, 58, 85.00, 0.00, 0.00),
(21, 18, 58, 60.00, 0.00, 0.00),
(22, 10, 58, 70.00, 0.00, 0.00),
(23, 21, 60, 55.00, 0.00, 0.00),
(24, 10, 60, 60.00, 0.00, 0.00),
(25, 19, 60, 80.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `grado` enum('Primero','Segundo','Tercero','Cuarto','Quinto','Sexto') NOT NULL,
  `paralelo` char(1) DEFAULT NULL CHECK (`paralelo` in ('A','B','C','D','E')),
  `nivel` varchar(20) DEFAULT 'Secundaria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `grado`, `paralelo`, `nivel`) VALUES
(1, 'Primero', 'A', 'Secundaria'),
(2, 'Primero', 'B', 'Secundaria'),
(3, 'Segundo', 'A', 'Secundaria'),
(4, 'Segundo', 'B', 'Secundaria'),
(5, 'Tercero', 'A', 'Secundaria'),
(6, 'Tercero', 'B', 'Secundaria'),
(7, 'Cuarto', 'A', 'Secundaria'),
(8, 'Quinto', 'A', 'Secundaria'),
(9, 'Quinto', 'B', 'Secundaria'),
(10, 'Sexto', 'A', 'Secundaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `genero` char(1) DEFAULT NULL CHECK (`genero` in ('M','F')),
  `curso_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `usuario_id`, `genero`, `curso_id`) VALUES
(1, 4, 'F', 1),
(2, 5, 'M', 2),
(3, 6, 'F', 3),
(4, 7, 'M', 4),
(5, 8, 'F', 5),
(6, 10, 'F', 6),
(7, NULL, 'F', 7),
(8, 5, 'M', 8),
(9, 6, 'F', 9),
(10, 7, 'M', 10),
(17, 26, 'M', 10),
(18, 27, 'M', 10),
(19, 29, 'M', 10),
(21, 31, 'M', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`) VALUES
(1, 'Matemáticas'),
(2, 'Lenguaje'),
(3, 'Física'),
(4, 'Química'),
(5, 'Biología'),
(6, 'Historia'),
(7, 'Geografía'),
(8, 'Inglés'),
(9, 'Educación Física'),
(10, 'Música');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE `observaciones` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) DEFAULT NULL,
  `asignacion_id` int(11) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `fecha` date DEFAULT curdate(),
  `tipo` enum('individual','general') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `observaciones`
--

INSERT INTO `observaciones` (`id`, `estudiante_id`, `asignacion_id`, `texto`, `fecha`, `tipo`) VALUES
(1, 1, 1, 'Buen rendimiento en matemáticas', '2025-06-19', 'individual'),
(2, 2, 2, 'Necesita mejorar en participación', '2025-06-19', 'individual'),
(7, 7, 7, 'Gran avance en la asignatura', '2025-06-19', 'individual'),
(10, 10, 10, 'Buen comportamiento en grupo', '2025-06-19', 'general');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `usuario_id`, `especialidad`, `celular`) VALUES
(1, 1, 'Matemáticas', '76543210'),
(2, 2, 'Lenguaje', '76543211'),
(3, 3, 'Física', '76543212'),
(21, 12, 'Historia', '76543214'),
(22, 13, 'Geografía', '76543215'),
(23, 14, 'Química', '76543216'),
(24, 15, 'Educación Física', '76543217'),
(25, 16, 'Inglés', '76543218'),
(26, 17, 'Música', '76543219'),
(27, 18, 'Tecnología', '76543220'),
(29, 23, 'Artes', '77721213'),
(30, 32, 'FILOSOFIA', '7103013');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `ci` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('profesor','estudiante','secretaria') NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `ci`, `contrasena`, `rol`, `creado_en`) VALUES
(1, 'Juan', 'Pérez', '123456', '1234', 'profesor', '2025-06-19 17:01:01'),
(2, 'María', 'López', '223456', '1234', 'profesor', '2025-06-19 17:01:01'),
(3, 'Carlos', 'Gómez', '323456', '1234', 'profesor', '2025-06-19 17:01:01'),
(4, 'Ana', 'Martínez', '423456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(5, 'Luis', 'Torrez', '523456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(6, 'Lucía', 'Soria', '623456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(7, 'Jorge', 'Quispe', '723456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(8, 'Elena', 'Flores', '823456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(9, 'Mario', 'Cruz', '923456', '1234', 'secretaria', '2025-06-19 17:01:01'),
(10, 'Sofía', 'Vargas', '1023456', '1234', 'estudiante', '2025-06-19 17:01:01'),
(12, 'Jorge', 'Fernández', '223344', '1234', 'profesor', '2025-07-13 21:12:14'),
(13, 'Daniela', 'Ortiz', '334455', '1234', 'profesor', '2025-07-13 21:12:14'),
(14, 'Rodrigo', 'Salinas', '445566', '1234', 'profesor', '2025-07-13 21:12:14'),
(15, 'Verónica', 'Aliaga', '556677', '1234', 'profesor', '2025-07-13 21:12:14'),
(16, 'Esteban', 'Quispe', '667788', '1234', 'profesor', '2025-07-13 21:12:14'),
(17, 'Natalia', 'Gutiérrez', '778899', '1234', 'profesor', '2025-07-13 21:12:14'),
(18, 'Ramiro', 'Castro', '889900', '1234', 'profesor', '2025-07-13 21:12:14'),
(19, 'Valeria', 'Nina', '991122', '1234', 'estudiante', '2025-07-14 00:08:10'),
(23, 'Cecilia Andrea', 'Loza', '9812345', '$2y$10$rqeBCqOxNb.n.pvUaC6A/eoHP9a3hrRKYhYfPudYpENwxHklzMb9.', 'profesor', '2025-07-22 01:48:43'),
(26, 'Luis', 'Mamani Mamani', '1234562', '$2y$10$XaBKZUkOUuks4IF3hTSUT.SZYQOwgKcO7jqN82/EOr5/XqEJ95mhS', 'estudiante', '2025-08-08 03:28:03'),
(27, 'alfredo', 'huanca', '9234561', '$2y$10$9T4SCnKVMO4n9Qz1SmyiveuOTcSkfNtw5Et7lqI12lK4diPM4kmBi', 'estudiante', '2025-08-08 03:34:20'),
(29, 'Fernando', 'Mamani Mamani', '812345', '$2y$10$0Ne4NbehF0CiYTATRhKo/.vlZx5oyYk3vnVAeBurCSC2C4iCLUZBC', 'estudiante', '2025-08-08 03:35:44'),
(31, 'Bryan Kender', 'mendoza', '993381699', '$2y$10$dI3wDSp6xL5rZakwD9yjQ.FD4ULn7tNjMLkS6pIVweNAqaSBTz2em', 'estudiante', '2025-08-08 04:25:34'),
(32, 'LIDIA', 'CANAVIRI', '6056803', '$2y$10$UV9N3u26KPrRbunk7kKCMOkO2KmpRE2YdHr1iVCjGsVzN2DWMIhuW', 'profesor', '2025-08-08 04:58:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones_docente`
--
ALTER TABLE `asignaciones_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `asignacion_id` (`asignacion_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `asignacion_id` (`asignacion_id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ci` (`ci`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_docente`
--
ALTER TABLE `asignaciones_docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones_docente`
--
ALTER TABLE `asignaciones_docente`
  ADD CONSTRAINT `asignaciones_docente_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `asignaciones_docente_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `asignaciones_docente_ibfk_3` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones_docente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD CONSTRAINT `observaciones_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `observaciones_ibfk_2` FOREIGN KEY (`asignacion_id`) REFERENCES `asignaciones_docente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

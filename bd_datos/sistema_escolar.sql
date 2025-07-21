-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2025 a las 21:19:44
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
(3, 2, 1, 2),
(4, 2, 3, 2),
(5, 3, 4, 3),
(6, 3, 5, 3),
(7, 1, 6, 4),
(8, 2, 7, 5),
(9, 3, 8, 6),
(10, 1, 9, 7);

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
(3, 3, 3, 95.00, 93.00, 97.00),
(4, 4, 4, 60.00, 65.00, 62.00),
(5, 5, 5, 88.00, 85.00, 87.00),
(6, 6, 6, 78.00, 80.00, 76.00),
(7, 7, 7, 92.00, 91.00, 90.00),
(8, 8, 8, 70.00, 72.00, 74.00),
(9, 9, 9, 60.00, 60.00, 60.00),
(10, 10, 10, 83.00, 86.00, 85.00);

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
(10, 7, 'M', 10);

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
(3, 3, 3, 'Excelente trabajo en clase', '2025-06-19', 'individual'),
(4, 4, 4, 'Dificultades en lectura', '2025-06-19', 'individual'),
(5, 5, 5, 'Participa activamente', '2025-06-19', 'individual'),
(6, 6, 6, 'Debe practicar más ejercicios', '2025-06-19', 'individual'),
(7, 7, 7, 'Gran avance en la asignatura', '2025-06-19', 'individual'),
(8, 8, 8, 'Falta a algunas clases', '2025-06-19', 'individual'),
(9, 9, 9, 'Mejorar la asistencia', '2025-06-19', 'general'),
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
(3, 3, 'Física', '76543212');

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
(10, 'Sofía', 'Vargas', '1023456', '1234', 'estudiante', '2025-06-19 17:01:01');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

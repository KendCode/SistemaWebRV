-- Crear base de datos
CREATE DATABASE IF NOT EXISTS sistema_escolar;
USE sistema_escolar;

-- Tabla: usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    ci VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('profesor', 'estudiante', 'secretaria') NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: cursos (grado y paralelo, solo secundaria)
CREATE TABLE cursos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    grado ENUM('Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto') NOT NULL,
    paralelo CHAR(1) CHECK (paralelo IN ('A', 'B', 'C', 'D', 'E')),
    nivel VARCHAR(20) DEFAULT 'Secundaria'
);

-- Tabla: estudiantes
CREATE TABLE estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    genero CHAR(1) CHECK (genero IN ('M', 'F')),
    curso_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

-- Tabla: profesores
CREATE TABLE profesores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    especialidad VARCHAR(100),
    celular VARCHAR(15),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla: materias
CREATE TABLE materias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);

-- Tabla: asignaciones_docente
CREATE TABLE asignaciones_docente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    profesor_id INT,
    curso_id INT,
    materia_id INT,
    FOREIGN KEY (profesor_id) REFERENCES profesores(id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id),
    FOREIGN KEY (materia_id) REFERENCES materias(id)
);

-- Tabla: calificaciones
CREATE TABLE calificaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estudiante_id INT,
    asignacion_id INT,
    trimestre1 DECIMAL(5,2) CHECK (trimestre1 BETWEEN 0 AND 100),
    trimestre2 DECIMAL(5,2) CHECK (trimestre2 BETWEEN 0 AND 100),
    trimestre3 DECIMAL(5,2) CHECK (trimestre3 BETWEEN 0 AND 100),
    nota_final DECIMAL(5,2) GENERATED ALWAYS AS (
        ROUND((trimestre1 + trimestre2 + trimestre3) / 3, 2)
    ) STORED,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (asignacion_id) REFERENCES asignaciones_docente(id) ON DELETE CASCADE
);

-- Tabla: observaciones
CREATE TABLE observaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estudiante_id INT,
    asignacion_id INT,
    texto TEXT,
    fecha DATE DEFAULT CURRENT_DATE,
    tipo ENUM('individual', 'general'),
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (asignacion_id) REFERENCES asignaciones_docente(id) ON DELETE CASCADE
);

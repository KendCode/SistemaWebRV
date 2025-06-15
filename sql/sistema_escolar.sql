-- Crear base de datos
CREATE DATABASE sistema_escolar;
USE sistema_escolar;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    ci VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('profesor', 'estudiante', 'secretaria') NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK (nombre REGEXP '^[A-Za-z ]+$'),
    CHECK (apellido REGEXP '^[A-Za-z ]+$'),
    CHECK (ci REGEXP '^[0-9]+$')
);

-- Tabla de cursos
CREATE TABLE cursos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    nivel VARCHAR(50)
);

-- Tabla de estudiantes
CREATE TABLE estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    genero CHAR(1) CHECK (genero IN ('M', 'F')),
    curso_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

-- Tabla de profesores
CREATE TABLE profesores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    especialidad VARCHAR(100),
    celular VARCHAR(15),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de materias
CREATE TABLE materias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);

-- Tabla de asignación de docentes a cursos y materias
CREATE TABLE asignaciones_docente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    profesor_id INT,
    curso_id INT,
    materia_id INT,
    FOREIGN KEY (profesor_id) REFERENCES profesores(id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id),
    FOREIGN KEY (materia_id) REFERENCES materias(id)
);

-- Tabla de calificaciones por estudiante/materia
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

-- Tabla de observaciones
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

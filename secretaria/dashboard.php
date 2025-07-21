<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaría - Colegio Dahboar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
            background-color: #f0f8ff;
        }
        footer {
            background-color: #e7f1ff;
            padding: 20px 0;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        h1, h2 {
            color: #007bff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="#">Colegio Dahboar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#inicio">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../profesor/ListProf.php">Profesores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#cursos">Cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contacto">Contacto</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5" id="inicio">
    <header class="mb-4">
        <h1>Bienvenidos a la Secretaría</h1>
        <p>Información y servicios para estudiantes y padres.</p>
        <div class="mb-3">
            <a href="#profesores" class="btn btn-primary">Ver Profesores</a>
            <a href="#cursos" class="btn btn-secondary">Ver Cursos</a>
        </div>
    </header>

    <section class="mb-4" id="profesores">
        <h2>Profesores</h2>
        <ul>
            <li>Juan Pérez - Matemáticas</li>
            <li>María López - Historia</li>
            <li>Pedro González - Ciencias</li>
            <li>Ana Torres - Lengua</li>
        </ul>
    </section>

    <section class="mb-4" id="cursos">
        <h2>Cursos</h2>
        <ul>
            <li>1° Grado</li>
            <li>2° Grado</li>
            <li>3° Grado</li>
            <li>4° Grado</li>
        </ul>
    </section>

    <section class="mb-4" id="contacto">
        <h2>Contactar</h2>
        <p>Para cualquier consulta, por favor llame a nuestra oficina o envíenos un correo electrónico.</p>
    </section>
</div>

<footer class="text-center">
    <div class="container">
        <p>&copy; 2023 Colegio Dahboar. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaría - Colegio Dahboar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            background-color: #f0f8ff;
        }
        .sidebar {
            min-width: 280px;
            background-color: #e7f1ff;
            text-align: center; /* Centrar texto */
        }
        h1, h2 {
            color: #007bff;
        }
        .nav-link {
            display: flex;
            justify-content: center; /* Centrar texto */
            align-items: center;
        }
        .nav-link i {
            margin-right: 8px; /* Espacio entre icono y texto */
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <ul class="nav nav-pills flex-column mb-auto">
            <a href="/" class="d-flex align-items-center mb-3 text-decoration-none">
                <span class="fs-4">Colegio Dahboar</span>
            </a>
            
            <li class="nav-item">
                <a href="../secretaria/dashboard.php" class="nav-link active" aria-current="page">
                    <i class="fas fa-home"></i> Panel de Inicio
                </a>
            </li>
            <li>
                <a href="../profesor/ListProf.php" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i> Lista de Profesores
                </a>
            </li>
            <li>
                <a href="../AsignarClase/ListProf.php" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i> Asignar Clase a profesor
                </a>
            </li>
            <li>
                <a href="../cursos/ListCursos.php" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i> Lista de Cursos
                </a>
            </li>
            <li>
                <a href="../estudiante/ListaEst.php" class="nav-link">
                    <i class="fas fa-receipt"></i> Lista de Estudiantes
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-box"></i> Asignaturas - Materias
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i> Grados - Cursos
                </a>
            </li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
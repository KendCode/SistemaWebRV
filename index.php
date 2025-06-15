<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Escolar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://via.placeholder.com/1500x500') center/cover no-repeat;
      color: white;
      padding: 100px 0;
      text-align: center;
    }
    .card:hover {
      transform: scale(1.03);
      transition: 0.3s ease;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">Sistema Escolar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Ingresar</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero / Bienvenida -->
  <section class="hero">
    <div class="container">
      <h1 class="display-4">Bienvenidos al Sistema Escolar</h1>
      <p class="lead">Gestión académica eficiente para estudiantes, profesores y administrativos.</p>
      <a href="#" class="btn btn-light btn-lg mt-3">Ingresar al sistema</a>
    </div>
  </section>

  <!-- Sección de módulos -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Módulos del Sistema</h2>
      <div class="row g-4">

        <div class="col-md-3">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Estudiantes</h5>
              <p class="card-text">Consulta tus calificaciones, observaciones y actividades escolares.</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Profesores</h5>
              <p class="card-text">Registra notas, observaciones y realiza seguimiento a tus grupos.</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Secretaría</h5>
              <p class="card-text">Administra estudiantes, docentes, horarios y comunicaciones internas.</p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">Dirección</h5>
              <p class="card-text">Supervisa todo el sistema académico y genera reportes globales.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-light py-4">
    <div class="container text-center">
      <p>&copy; 2025 Sistema Escolar. Todos los derechos reservados.</p>
      <p>Contacto: info@sistemaescolar.edu.bo | Tel: +591 71234567</p>
    </div>
  </footer>

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

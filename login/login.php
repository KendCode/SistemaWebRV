<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - Sistema Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="mb-3 text-center">Iniciar Sesión</h3>

        <form method="POST" action="../control/control.php">
            <div class="mb-3">
                <label for="ci" class="form-label">Cédula de Identidad</label>
                <input type="text" name="ci" id="ci" class="form-control" required autofocus />
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required />
            </div>
            <button class="btn btn-primary w-100" type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
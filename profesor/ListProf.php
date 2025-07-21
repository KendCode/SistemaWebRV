<?php
include("../config/db.php");
session_start();

$conn = db_connect();

// Consulta para obtener todos los profesores con su información de usuario
$consulta = "SELECT 
    p.id AS profesor_id,
    u.nombre,
    u.apellido,
    u.ci,
    p.especialidad,
    p.celular
FROM profesores p
JOIN usuarios u ON u.id = p.usuario_id
ORDER BY u.nombre ASC";

$resultado = mysqli_query($conn, $consulta);

$profesores = [];
if ($resultado) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $profesores[] = $fila;
    }
} else {
    $error = "Error al obtener los profesores: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Profesores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista de Profesores</h2>
        <a href="AgregarProf.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar Profesor</a>
    </div>

    <?php if (!empty($profesores)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Especialidad</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($profesores as $i => $prof): ?>
                    <tr>
                        <td class="text-center"><?php echo $i + 1; ?></td>
                        <td><?php echo $prof['nombre'] . " " . $prof['apellido']; ?></td>
                        <td class="text-center"><?php echo $prof['ci']; ?></td>
                        <td><?php echo $prof['especialidad']; ?></td>
                        <td class="text-center"><?php echo $prof['celular']; ?></td>
                        <td class="text-center">
                            <a href="VerProf.php?id=<?php echo $prof['profesor_id']; ?>" class="btn btn-info btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                            <a href="editar_profesor.php?id=<?php echo $prof['profesor_id']; ?>" class="btn btn-warning btn-sm" title="Editar"><i class="bi bi-pencil-square"></i></a>
                            <a href="eliminar_profesor.php?id=<?php echo $prof['profesor_id']; ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este profesor?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No hay profesores registrados.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

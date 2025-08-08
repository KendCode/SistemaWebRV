<?php
include("../layaouts/navegacion.php");
include("../config/db.php");
session_start();
$conn = db_connect();

$sql = "SELECT e.id, u.nombre, u.apellido, u.ci, e.genero, c.grado, c.paralelo
        FROM estudiantes e
        JOIN usuarios u ON e.usuario_id = u.id
        JOIN cursos c ON e.curso_id = c.id";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Lista de Estudiantes</h2>
        <a href="AgregarEst.php" class="btn btn-success mb-3">+ Agregar Estudiante</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>CI</th>
                    <th>Género</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($e = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?= $e['id'] ?></td>
                        <td><?= $e['nombre'] . ' ' . $e['apellido'] ?></td>
                        <td><?= $e['ci'] ?></td>
                        <td><?= $e['genero'] == 'M' ? 'Masculino' : 'Femenino' ?></td>
                        <td><?= $e['grado'] . ' "' . $e['paralelo'] . '"' ?></td>
                        <td>
                            <a href="EditarEst.php?id=<?= $e['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <!-- Botón Eliminar -->
                            <button
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminarEstudiante"
                                data-id="<?= $e['id'] ?>"
                                data-nombre="<?= $e['nombre'] . ' ' . $e['apellido'] ?>">
                                Eliminar
                            </button>
                            <!-- Modal Confirmación -->
                            <div class="modal fade" id="modalEliminarEstudiante" tabindex="-1" aria-labelledby="modalEliminarEstudianteLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalEliminarEstudianteLabel">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p>¿Estás seguro de que quieres eliminar al estudiante <strong id="nombreEstudiante"></strong>?</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="#" id="btnConfirmarEliminar" class="btn btn-danger">Eliminar</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEliminar = document.getElementById('modalEliminarEstudiante');
    modalEliminar.addEventListener('show.bs.modal', function (event) {
        
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');

        // Cambiar el texto en el modal
        document.getElementById('nombreEstudiante').textContent = nombre;

        // Cambiar el enlace del botón Eliminar
        document.getElementById('btnConfirmarEliminar').href = 'EliminarEst.php?id=' + id;
    });
});
</script>


</body>
</html>
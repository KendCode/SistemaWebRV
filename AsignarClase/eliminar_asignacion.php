<?php
include("../config/db.php");
session_start();

$conn = db_connect();

if (!isset($_GET['profesor'])) {
    echo "No se especificó profesor.";
    exit;
}

$profesor = intval($_GET['profesor']);

// Obtener datos del profesor
$sqlProfesor = "SELECT u.nombre, u.apellido FROM profesores p JOIN usuarios u ON u.id = p.usuario_id WHERE p.id = ?";
$stmtProfesor = $conn->prepare($sqlProfesor);
$stmtProfesor->bind_param('i', $profesor);
$stmtProfesor->execute();
$resultProfesor = $stmtProfesor->get_result();
$datosProfesor = $resultProfesor->fetch_assoc();

if (!$datosProfesor) {
    echo "Profesor no encontrado.";
    exit;
}

// Procesar eliminación individual
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idEliminar = intval($_POST['id']);
    $sqlEliminar = "DELETE FROM asignaciones_docente WHERE id = ?";
    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bind_param('i', $idEliminar);

    if ($stmtEliminar->execute()) {
        $mensaje = "Asignación eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar la asignación.";
    }
}

// Procesar eliminación de todas las asignaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_todas'])) {
    $sqlEliminarTodas = "DELETE FROM asignaciones_docente WHERE profesor_id = ?";
    $stmtEliminarTodas = $conn->prepare($sqlEliminarTodas);
    $stmtEliminarTodas->bind_param('i', $profesor);

    if ($stmtEliminarTodas->execute()) {
        $mensaje = "Todas las asignaciones fueron eliminadas correctamente.";
    } else {
        $mensaje = "Error al eliminar las asignaciones.";
    }
}

// Obtener todas las asignaciones
$sqlAsignaciones = "
    SELECT ad.id, c.grado, c.paralelo, m.nombre AS materia
    FROM asignaciones_docente ad
    JOIN cursos c ON c.id = ad.curso_id
    JOIN materias m ON m.id = ad.materia_id
    WHERE ad.profesor_id = ?
    ORDER BY c.grado, c.paralelo, m.nombre
";

$stmtAsignaciones = $conn->prepare($sqlAsignaciones);
$stmtAsignaciones->bind_param('i', $profesor);
$stmtAsignaciones->execute();
$resultAsignaciones = $stmtAsignaciones->get_result();
$asignaciones = $resultAsignaciones->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Eliminar Asignaciones - <?= htmlspecialchars($datosProfesor['nombre'] . ' ' . $datosProfesor['apellido']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-5">
    <h2>Asignaciones de <?= htmlspecialchars($datosProfesor['nombre'] . ' ' . $datosProfesor['apellido']) ?></h2>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if (count($asignaciones) > 0): ?>
        <div class="mb-3">
            <!-- Botón para eliminar todas las asignaciones -->
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminarTodas">
                Eliminar todas las asignaciones
            </button>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Materia</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asignaciones as $asig): ?>
                    <tr>
                        <td><?= $asig['id'] ?></td>
                        <td><?= htmlspecialchars($asig['grado'] . ' ' . $asig['paralelo']) ?></td>
                        <td><?= htmlspecialchars($asig['materia']) ?></td>
                        <td>
                            <!-- Botón para eliminar asignación individual, pasa datos al modal -->
                            <button class="btn btn-danger btn-sm btn-eliminar-individual" 
                                data-id="<?= $asig['id'] ?>" 
                                data-curso="<?= htmlspecialchars($asig['grado'] . ' ' . $asig['paralelo']) ?>"
                                data-materia="<?= htmlspecialchars($asig['materia']) ?>"
                                data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminarIndividual">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay asignaciones para este profesor.</p>
    <?php endif; ?>

    <a href="ListProf.php" class="btn btn-secondary mt-3">Volver al listado de profesores</a>

    <!-- Modal Confirmar eliminar asignación individual -->
    <div class="modal fade" id="modalConfirmarEliminarIndividual" tabindex="-1" aria-labelledby="modalConfirmarEliminarIndividualLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" id="formEliminarIndividual">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalConfirmarEliminarIndividualLabel">Confirmación de Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar esta asignación?</p>
                    <p><strong>Curso:</strong> <span id="modalCurso"></span></p>
                    <p><strong>Materia:</strong> <span id="modalMateria"></span></p>
                    <input type="hidden" name="id" id="inputEliminarId" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Modal Confirmar eliminar todas las asignaciones -->
    <div class="modal fade" id="modalConfirmarEliminarTodas" tabindex="-1" aria-labelledby="modalConfirmarEliminarTodasLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST">
            <input type="hidden" name="eliminar_todas" value="1" />
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalConfirmarEliminarTodasLabel">Confirmación de Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar <strong>todas</strong> las asignaciones de este profesor?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Sí, eliminar todo</button>
                </div>
            </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Al abrir modal para eliminar individual, rellenar datos dinámicamente
        document.querySelectorAll('.btn-eliminar-individual').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const curso = this.getAttribute('data-curso');
                const materia = this.getAttribute('data-materia');

                document.getElementById('modalCurso').textContent = curso;
                document.getElementById('modalMateria').textContent = materia;
                document.getElementById('inputEliminarId').value = id;
            });
        });
    </script>
</body>
</html>

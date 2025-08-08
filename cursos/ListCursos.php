<?php
include("../layaouts/navegacion.php");
include("../config/db.php");
session_start();
$conn = db_connect();

$resultado = mysqli_query($conn, "SELECT * FROM cursos");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Listado de Cursos</h2>
        <a href="AgregarCurso.php" class="btn btn-success mb-3">+ Agregar Curso</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Grado</th>
                    <th>Paralelo</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($curso = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?= $curso['id'] ?></td>
                        <td><?= $curso['grado'] ?></td>
                        <td><?= $curso['paralelo'] ?></td>
                        <td><?= $curso['nivel'] ?></td>
                        <td>
                            <!-- Botón Ver -->
                            <a href="VerCurso.php?id=<?= $curso['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="EditarCurso.php?id=<?= $curso['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <!-- Botón que abre el modal -->
                            <a href="#" class="btn btn-danger btn-sm btn-confirm-delete" data-url="EliminarCurso.php?id=<?= $curso['id'] ?>">
                                Eliminar
                            </a>

                            <!-- Modal de confirmación -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro que deseas eliminar este curso?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                            <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Sí, eliminar</a>
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
        document.querySelectorAll('.btn-confirm-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // prevenir que el enlace se siga directamente

                const url = this.getAttribute('data-url');
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

                // Asignar url al botón de confirmar dentro del modal
                document.getElementById('confirmDeleteBtn').setAttribute('href', url);

                // Mostrar modal
                modal.show();
            });
        });
    </script>

</body>

</html>
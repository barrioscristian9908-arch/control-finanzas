<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔹 Título + botón RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                
                <h4 class="mb-0">🏷️ Categorías</h4>

                <a href="/control_finanzas/index.php?action=categorias.crear" 
                   class="btn btn-primary">
                    ➕ Nueva categoría
                </a>
            </div>

            <!-- 🔹 Tabla -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(!empty($categorias)): ?>

                                <?php foreach($categorias as $c): ?>

                                    <tr>
                                        <!-- Tipo -->
                                        <td class="<?= $c['tipo'] == 'ingreso' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                                            <?= ucfirst($c['tipo']) ?>
                                        </td>

                                        <!-- Nombre -->
                                        <td class="fw-semibold"><?= $c['nombre'] ?></td>

                                        <!-- Acciones -->
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="/control_finanzas/index.php?action=categorias.editar&id=<?= $c['id'] ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    ✏️
                                                </a>

                                                <a href="/control_finanzas/index.php?action=categorias.delete&id=<?= $c['id'] ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('¿Eliminar categoria?')">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No hay categorías registradas 😅
                                    </td>
                                </tr>

                            <?php endif; ?>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/footer.php"); ?>
<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔹 Título + botones RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                
                <h4 class="mb-0">💸 Movimientos</h4>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="/control_finanzas/index.php?action=movimientos.crear" 
                       class="btn btn-primary">
                        ➕ Nuevo movimiento
                    </a>

                    <a href="?action=movimientos.transferir" 
                       class="btn btn-warning">
                        🔄 Transferir
                    </a>
                </div>
            </div>

            <!-- 🔹 Tabla -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th class="d-none d-md-table-cell">Categoría</th>
                                    <th class="d-none d-lg-table-cell">Cuenta</th>
                                    <th>Fecha</th>
                                    <th class="d-none d-md-table-cell">Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(!empty($movimientos)): ?>

                                <?php foreach($movimientos as $m): ?>

                                    <tr>
                                        <!-- Tipo -->
                                        <td class="<?= $m['tipo'] == 'ingreso' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                                            <?= ucfirst($m['tipo']) ?>
                                        </td>

                                        <!-- Monto -->
                                        <td class="fw-semibold">$<?= $m['monto'] ?></td>

                                        <!-- Categoría -->
                                        <td class="d-none d-md-table-cell">
                                            <?php if($m['meta_id']): ?>
                                                🎯 Aporte
                                            <?php elseif(str_contains($m['descripcion'], 'Transferencia')): ?>
                                                🔄 Transferencia
                                            <?php else: ?>
                                                <?= $m['categoria'] ?? 'Sin categoría' ?>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Cuenta -->
                                        <td class="d-none d-lg-table-cell">
                                            <?= $m['cuenta'] ?? 'Sin cuenta' ?>
                                        </td>

                                        <!-- Fecha -->
                                        <td><?= $m['fecha'] ?></td>

                                        <!-- Descripción -->
                                        <td class="d-none d-md-table-cell">
                                            <?= $m['descripcion'] ?? '-' ?>
                                        </td>

                                        <!-- Acciones -->
                                        <td>
                                            <?php if(empty($m['meta_id'])): ?>

                                                <div class="d-flex gap-1">
                                                    <a href="/control_finanzas/index.php?action=movimientos.editar&id=<?= $m['id'] ?>" 
                                                       class="btn btn-sm btn-warning">✏️</a>

                                                    <a href="/control_finanzas/index.php?action=movimientos.delete&id=<?= $m['id'] ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('¿Eliminar movimiento?')">🗑️</a>
                                                </div>

                                            <?php else: ?>

                                                <span class="badge bg-info">Meta</span>

                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No hay movimientos registrados 😅
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
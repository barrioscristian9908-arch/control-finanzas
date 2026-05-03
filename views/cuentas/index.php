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
                
                <h4 class="mb-0">💼 Cuentas</h4>

                <a href="/control_finanzas/index.php?action=cuentas.crear" 
                   class="btn btn-primary">
                    ➕ Nueva cuenta
                </a>
            </div>

            <!-- 🔹 Tabla -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>Cuenta</th>
                                    <th>Saldo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(!empty($cuentas)): ?>

                                <?php foreach($cuentas as $c): ?>

                                    <tr>

                                        <!-- Nombre -->
                                        <td class="fw-semibold"><?= $c['nombre'] ?></td>

                                        <!-- Saldo -->
                                        <td class="fw-bold">$<?= $c['saldo'] ?></td>

                                        <!-- Acciones -->
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="/control_finanzas/index.php?action=cuentas.editar&id=<?= $c['id'] ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    ✏️
                                                </a>

                                                <a href="/control_finanzas/index.php?action=cuentas.delete&id=<?= $c['id'] ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('¿Eliminar cuenta?')">
                                                    🗑️
                                                </a>
                                            </div>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No hay cuentas registradas 😅
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
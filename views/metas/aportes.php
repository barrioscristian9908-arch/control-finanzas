<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔹 HEADER RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                
                <h4 class="mb-0">
                    📊 Aportes - <?= $meta["nombre"] ?>
                </h4>

                <a href="/control_finanzas/index.php?action=metas" 
                   class="btn btn-secondary w-100 w-sm-auto">
                    ⬅ Volver
                </a>
            </div>

            <!-- 🔹 TABLA -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php if(!empty($aportes)): ?>

                                <?php foreach($aportes as $a): ?>

                                    <tr>
                                        <!-- Monto -->
                                        <td class="fw-bold text-success">
                                            $<?= $a["monto"] ?>
                                        </td>

                                        <!-- Fecha -->
                                        <td><?= $a["fecha"] ?></td>

                                        <!-- Acciones -->
                                        <td>
                                            <a href="/control_finanzas/index.php?action=metas.deleteAporte&id=<?= $a["id"] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('¿Eliminar aporte? Esto devolverá el dinero a la cuenta.')">
                                                🗑️
                                            </a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No hay aportes registrados 😅
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
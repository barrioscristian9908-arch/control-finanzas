<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔹 HEADER RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                
                <h4 class="mb-0">🎯 Metas</h4>

                <a href="/control_finanzas/index.php?action=metas.crear" 
                   class="btn btn-primary">
                    ➕ Nueva meta
                </a>
            </div>

            <!-- 🔹 CONTENIDO -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <?php if(!empty($metas)): ?>

                        <?php foreach($metas as $meta): ?>

                            <?php 
                                $porcentaje = ($meta["monto_objetivo"] > 0) 
                                    ? ($meta["ahorrado"] / $meta["monto_objetivo"]) * 100 
                                    : 0;

                                $porcentaje = min($porcentaje, 100);

                                if($porcentaje < 50){
                                    $color = "bg-danger";
                                } elseif($porcentaje < 80){
                                    $color = "bg-warning";
                                } else {
                                    $color = "bg-success";
                                }
                            ?>

                            <!-- 🔹 CARD META -->
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">

                                    <!-- Nombre + monto -->
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <strong class="fs-6"><?= $meta["nombre"] ?></strong>
                                        <span class="fw-semibold mt-1 mt-md-0">
                                            $<?= $meta["ahorrado"] ?> / $<?= $meta["monto_objetivo"] ?>
                                        </span>
                                    </div>

                                    <!-- Barra -->
                                    <div class="progress mt-2">
                                        <div class="progress-bar <?= $color ?>" 
                                             style="width: <?= $porcentaje ?>%">
                                            <?= round($porcentaje) ?>%
                                        </div>
                                    </div>

                                    <!-- Info extra -->
                                    <div class="mt-2 d-flex flex-column flex-md-row justify-content-between">

                                        <small class="text-muted">
                                            $<?= $meta["ahorrado"] ?> ahorrado
                                        </small>

                                        <?php if(!empty($meta["fecha_limite"])): ?>
                                            <small class="text-muted">
                                                📅 <?= $meta["fecha_limite"] ?>
                                            </small>
                                        <?php endif; ?>

                                    </div>

                                    <!-- Meta completada -->
                                    <?php if($porcentaje >= 100): ?>
                                        <div class="mt-2">
                                            <span class="badge bg-success">🎉 Meta completada</span>
                                        </div>
                                    <?php endif; ?>

                                    <!-- 🔹 ACCIONES RESPONSIVE -->
                                    <div class="mt-3 d-flex flex-wrap gap-2">

                                        <a href="/control_finanzas/index.php?action=metas.aportar&id=<?= $meta['id'] ?>" 
                                           class="btn btn-sm btn-success flex-fill">
                                            💰 Aportar
                                        </a>

                                        <a href="/control_finanzas/index.php?action=metas.aportes&id=<?= $meta['id'] ?>" 
                                           class="btn btn-sm btn-info flex-fill">
                                            📊 Aportes
                                        </a>

                                        <a href="/control_finanzas/index.php?action=metas.editar&id=<?= $meta["id"] ?>" 
                                           class="btn btn-sm btn-warning flex-fill">
                                            ✏️ Editar
                                        </a>

                                        <a href="/control_finanzas/index.php?action=metas.delete&id=<?= $meta["id"] ?>" 
                                           class="btn btn-sm btn-danger flex-fill"
                                           onclick="return confirm('¿Eliminar meta?')">
                                            🗑️ Eliminar
                                        </a>

                                    </div>

                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <p class="text-muted">No hay metas registradas 😅</p>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/footer.php"); ?>
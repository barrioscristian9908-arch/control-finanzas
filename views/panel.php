<?php require_once("layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-4">

            <!-- 🔥 HEADER -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                <h3>🏠 Dashboard</h3>

                <a href="/control_finanzas/index.php?action=movimientos.crear" 
                   class="btn btn-primary">
                    ➕ Agregar movimiento
                </a>
            </div>

            <!-- 💰 CARDS -->
            <div class="row mb-4">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card shadow-sm p-3">
                        <h6>Balance Total</h6>
                        <h4 class="text-primary">$<?= $balance; ?></h4>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card shadow-sm p-3">
                        <h6>Ingresos</h6>
                        <h4 class="text-success">$<?= $ingresos; ?></h4>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card shadow-sm p-3">
                        <h6>Egresos</h6>
                        <h4 class="text-danger">$<?= $egresos; ?></h4>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card shadow-sm p-3">
                        <h6>Cuentas</h6>
                        <h4><?= $totalCuentas; ?></h4>
                    </div>
                </div>

            </div>

            <!-- 📋 ÚLTIMOS MOVIMIENTOS -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5>Últimos Movimientos</h5>

                    <div class="table-responsive">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Monto</th>
                                    <th>Categoría</th>
                                    <th>Cuenta</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php if(!empty($movimientos)): ?>

                                <?php foreach($movimientos as $m): ?>
                                <tr>
                                    <td class="<?= $m['tipo'] == 'ingreso' ? 'text-success' : 'text-danger' ?>">
                                        <?= ucfirst($m['tipo'])?>
                                    </td>

                                    <td>$<?= $m['monto'] ?></td>

                                    <td class="text-break">
                                        <?php if($m['meta_id']): ?>

                                            🎯 Aporte a meta

                                        <?php elseif(str_contains($m['descripcion'], 'Transferencia')): ?>

                                            🔄 Transferencia

                                        <?php else: ?>

                                            <?= $m['categoria'] ?? 'Sin categoría' ?>

                                        <?php endif; ?>
                                    </td>

                                    <td><?= $m['cuenta'] ?? 'Sin cuenta' ?></td>
                                    <td><?= $m['fecha'] ?></td>
                                </tr>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="5" class="text-center">
                                        No hay movimientos registrados
                                    </td>
                                </tr>

                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- 🎯 METAS -->
            <?php if(!empty($metas)): ?>

                <?php foreach(array_slice($metas, 0, 3) as $meta): ?>

                    <?php 
                        $porcentaje = ($meta['monto_objetivo'] > 0) 
                            ? ($meta['monto_actual'] / $meta['monto_objetivo']) * 100 
                            : 0;

                        $porcentaje = min($porcentaje, 100);

                        if($porcentaje < 50){
                            $color = "bg-danger";
                        } elseif($porcentaje < 80){
                            $color = "bg-warning";
                        } else {
                            $color = "bg-success";
                        }

                        if($porcentaje >= 100){
                            $color = "bg-success";
                        }
                    ?>

                    <div class="mb-3">
                        <p class="mb-1">
                            <?= $meta['nombre'] ?> 
                            ($<?= $meta['monto_objetivo'] ?>)
                        </p>

                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar <?= $color ?>" 
                                style="width: <?= $porcentaje ?>%">
                                <?= round($porcentaje) ?>%
                            </div>
                        </div>

                        <small class="text-muted">
                            $<?= $meta['monto_actual'] ?> ahorrado
                        </small>

                        <?php if($porcentaje >= 100): ?>
                            <div>
                                <span class="badge bg-success">🎉 Completada</span>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>

                <a href="/control_finanzas/index.php?action=metas" 
                   class="btn btn-sm btn-outline-primary mt-2">
                    Ver todas las metas
                </a>

            <?php else: ?>

                <p class="text-muted">
                    No tienes metas aún 😅 <br>
                    ¡Empieza creando una!
                </p>

                <a href="/control_finanzas/index.php?action=metas.crear" 
                   class="btn btn-sm btn-primary">
                    Crear meta
                </a>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once("layouts/footer.php"); ?>
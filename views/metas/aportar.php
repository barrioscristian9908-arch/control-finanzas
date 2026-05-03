<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔹 SIDEBAR -->
        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <!-- 🔹 TÍTULO -->
                    <h4 class="mb-3 mb-md-4">Aportar a Meta</h4>

                    <form action="/control_finanzas/index.php?action=metas.storeAporte" method="POST">

                        <!-- ID de la meta -->
                        <input type="hidden" name="meta_id" value="<?= $meta['id'] ?>">

                        <!-- Meta -->
                        <div class="mb-3">
                            <label class="form-label">Meta</label>
                            <input type="text" class="form-control"
                                   value="<?= $meta['nombre'] ?>" readonly>
                        </div>

                        <!-- Monto -->
                        <div class="mb-3">
                            <label class="form-label">Monto</label>

                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="monto" class="form-control" step="0.01" required>
                            </div>
                        </div>

                        <!-- Cuenta -->
                        <div class="mb-3">
                            <label class="form-label">Cuenta</label>
                            <select name="cuenta_id" class="form-select" required>
                                <option value="">Seleccionar cuenta</option>

                                <?php foreach($cuentas as $c): ?>
                                    <option value="<?= $c['id'] ?>">
                                        <?= $c['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- 🔹 BOTONES RESPONSIVE -->
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                            <button type="submit" class="btn btn-success w-100 w-sm-auto">
                                💰 Aportar
                            </button>

                            <button type="button" onclick="history.back()" 
                                    class="btn btn-secondary w-100 w-sm-auto">
                                ← Cancelar
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/footer.php"); ?>
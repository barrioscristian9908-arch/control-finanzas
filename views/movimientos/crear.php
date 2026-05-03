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
                    <h4 class="mb-3 mb-md-4">Nuevo Movimiento</h4>

                    <form action="/control_finanzas/index.php?action=movimientos.store" method="POST">

                        <!-- Tipo -->
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <option value="">Seleccionar</option>
                                <option value="ingreso">Ingreso</option>
                                <option value="egreso">Egreso</option>
                            </select>
                        </div>

                        <!-- Monto -->
                        <div class="mb-3">
                            <label class="form-label">Monto</label>
                            <input type="number" name="monto" class="form-control" required>
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

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Seleccionar categoría</option>

                                <?php foreach($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= $cat['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>

                        <!-- 🔹 BOTONES RESPONSIVE -->
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                            <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                💾 Guardar
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
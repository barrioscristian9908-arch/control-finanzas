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
                    <h4 class="mb-3 mb-md-4">Editar Cuenta</h4>

                    <form action="/control_finanzas/index.php?action=cuentas.update" method="POST">

                        <!-- ID oculto -->
                        <input type="hidden" name="id" value="<?= $cuenta['id'] ?>">

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control"
                                   value="<?= $cuenta['nombre'] ?>" required>
                        </div>

                        <!-- Saldo (solo lectura) -->
                        <div class="mb-3">
                            <label class="form-label">Saldo</label>

                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="saldo" class="form-control" step="0.01"
                                       value="<?= $cuenta['saldo'] ?>" readonly>
                            </div>

                            <small class="text-muted">
                                El saldo se modifica automáticamente con los movimientos
                            </small>
                        </div>
                    
                        <!-- 🔹 BOTONES RESPONSIVE -->
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                            <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                💾 Actualizar
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
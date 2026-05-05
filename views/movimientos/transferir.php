<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-2 p-md-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔹 HEADER RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
                
                <h3 class="mb-0">🔄 Transferir dinero</h3>

                <a href="/control_finanzas/index.php?action=movimientos" 
                   class="btn btn-secondary">
                    ← Volver
                </a>
            </div>

            <!-- 🔹 FORMULARIO -->
            <div class="card shadow-sm">
                <div class="card-body p-2 p-md-3">

                    <form method="POST" action="/control_finanzas/index.php?action=movimientos.storeTransferencia">

                        <!-- 🔹 CUENTA ORIGEN -->
                        <div class="mb-3">
                            <label class="form-label">Cuenta origen</label>
                            <select name="cuenta_origen" class="form-select" required>
                                <option value="">Seleccionar</option>
                                <?php foreach($cuentas as $cuenta): ?>
                                    <option value="<?= $cuenta['id'] ?>">
                                        <?= $cuenta['nombre'] ?> ($<?= $cuenta['saldo'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 🔹 CUENTA DESTINO -->
                        <div class="mb-3">
                            <label class="form-label">Cuenta destino</label>
                            <select name="cuenta_destino" class="form-select" required>
                                <option value="">Seleccionar</option>
                                <?php foreach($cuentas as $cuenta): ?>
                                    <option value="<?= $cuenta['id'] ?>">
                                        <?= $cuenta['nombre'] ?> ($<?= $cuenta['saldo'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 🔹 MONTO -->
                        <div class="mb-3">
                            <label class="form-label">Monto</label>
                            <input type="number" name="monto" class="form-control" step="0.01" required>
                        </div>

                        <!-- 🔹 DESCRIPCIÓN -->
                        <div class="mb-3">
                            <label class="form-label">Descripción (opcional)</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>

                        <!-- 🔥 BOTÓN -->
                        <button class="btn btn-warning w-100">
                            🔄 Transferir
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/footer.php"); ?>
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
                    <h4 class="mb-3 mb-md-4">Editar Meta</h4>

                    <form action="/control_finanzas/index.php?action=metas.update" method="POST">

                        <!-- ID oculto -->
                        <input type="hidden" name="id" value="<?= $meta['id'] ?>">

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control"
                                   value="<?= $meta['nombre'] ?>" required>
                        </div>

                        <!-- Monto objetivo -->
                        <div class="mb-3">
                            <label class="form-label">Monto objetivo</label>

                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="monto_objetivo" class="form-control" step="0.01"
                                       value="<?= $meta['monto_objetivo'] ?>" required>
                            </div>
                        </div>

                        <!-- Fecha límite -->
                        <div class="mb-3">
                            <label class="form-label">Fecha límite (opcional)</label>
                            <input type="date" name="fecha_limite" class="form-control"
                                   value="<?= $meta['fecha_limite'] ?>">
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
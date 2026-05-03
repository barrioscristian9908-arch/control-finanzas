<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/header.php"); ?>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/navbar.php"); ?>

<div class="container-fluid">
    <div class="row">

        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/sidebar.php"); ?>

        <!-- 🔹 CONTENIDO -->
        <div class="col-12 col-md-10 p-4">

            <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

            <!-- 🔥 TÍTULO -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
                <h3>📊 Reportes</h3>
            </div>

            <!-- 📅 FILTRO -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <form method="GET" class="row g-3">
                        <input type="hidden" name="action" value="reportes">

                        <div class="col-12 col-md-3">
                            <label>Desde</label>
                            <input type="date" name="desde" class="form-control" value="<?= $desde ?>">
                        </div>

                        <div class="col-12 col-md-3">
                            <label>Hasta</label>
                            <input type="date" name="hasta" class="form-control" value="<?= $hasta ?>">
                        </div>

                        <div class="col-12 col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100">
                                Filtrar
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- 📊 GRÁFICO INGRESOS VS EGRESOS -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5>Ingresos vs Egresos</h5>

                    <div class="w-100">
                        <canvas id="grafico"></canvas>
                    </div>
                </div>
            </div>

            <!-- 🥧 GRÁFICO CATEGORÍAS -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5>Gastos por Categoría</h5>

                    <?php if(!empty($categorias)): ?>

                        <div class="w-100">
                            <canvas id="graficoCategorias"></canvas>
                        </div>

                    <?php else: ?>

                        <p class="text-muted text-center">
                            📊 No hay gastos registrados en este rango de fechas
                        </p>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- 📊 CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- 📊 SCRIPT GRÁFICO INGRESOS/EGRESOS -->
<script>
const data = <?= json_encode($data) ?>;

const labels = data.map(d => d.fecha);
const ingresos = data.map(d => d.ingresos);
const egresos = data.map(d => d.egresos);

new Chart(document.getElementById('grafico'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Ingresos',
                data: ingresos,
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: 'Egresos',
                data: egresos,
                borderWidth: 2,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>

<!-- 🥧 SCRIPT GRÁFICO CATEGORÍAS -->
<script>
const dataCategorias = <?= json_encode($categorias) ?>;

if(dataCategorias.length > 0){

    const labelsCat = dataCategorias.map(d => d.categoria ?? "Sin categoría");
    const valoresCat = dataCategorias.map(d => d.total);

    const colores = [
        "#0d6efd",
        "#198754",
        "#dc3545",
        "#ffc107",
        "#6f42c1",
        "#fd7e14",
        "#20c997"
    ];

    new Chart(document.getElementById('graficoCategorias'), {
        type: 'pie',
        data: {
            labels: labelsCat,
            datasets: [{
                data: valoresCat,
                backgroundColor: colores
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
}
</script>

<?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/footer.php"); ?>
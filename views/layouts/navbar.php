<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-3">

    <!-- 🔥 BOTÓN MOBILE -->
    <button class="btn btn-outline-light d-md-none me-3" 
            type="button" 
            data-bs-toggle="offcanvas" 
            data-bs-target="#menuMobile">
        ☰
    </button>

    <!-- 🔹 TÍTULO -->
    <span class="navbar-brand mb-0 h1">
        💰 Control Finanzas
    </span>

    <!-- 🔹 USUARIO -->
    <div class="ms-auto text-white d-flex align-items-center">
        <span class="me-3">
            Hola, <?php echo ucfirst($_SESSION['usuario']); ?>
        </span>

        <a href="/control_finanzas/index.php?action=logout" 
           class="btn btn-sm btn-danger">
            Cerrar sesión
        </a>
    </div>

</nav>
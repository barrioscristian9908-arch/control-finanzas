<?php if(isset($_SESSION["mensaje"])): ?>

    <div class="alert alert-<?= $_SESSION["tipo"] ?? 'info' ?> alert-dismissible fade show">
        <?= $_SESSION["mensaje"] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php unset($_SESSION["mensaje"]); ?>
    <?php unset($_SESSION["tipo"]); ?>

<?php endif; ?>
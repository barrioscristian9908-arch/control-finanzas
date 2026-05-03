<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingresar - Control Finanzas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body{
            background-image: url('/control_finanzas/public/images/finanzas.jpg');
            background-position: center;
            background-size: cover;
            hbackground-repeat: no-repeat;
        }
    </style>
  </head>
  <body class="">
    

     <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form action="/control_finanzas/index.php?action=auth.login" method="POST" class="border rounded-3 p-4 bg-white" style="width: 25rem;">

        <!-- Mensaje de alerta -->
        
        <?php require_once("c://xampp/htdocs/control_finanzas/views/layouts/alert.php"); ?>

        <h2 class="mb-2">Login</h2>
            <div class="mb-3">
                <label for="user" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="user" name="user" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Loguearse</button>
            </div>
            <div class="mb-3">
                <a href="/control_finanzas/index.php?action=register">¿Aun no tienes una cuenta?</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>Connection failed</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php";?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
</head>
<body>
    <div class="container d-flex align-items-center h-100">
        <div class="row mx-auto">
            <div class="col-12">
                <img src="img/other/conn_failed.svg" class="img-fluid d-block mx-auto" style="width: 380px; height: 380px;" />
                <h1 class="display-2 font-weight-bold text-center text-uppercase">SERVER DOWN!</h1>
                <h3 class="h3 text-muted text-center pt-3">C'è un problema di connessione al server. <br/>Contattare il tecnico di sistema per ripristinare il servizio</h3>
                <a type="button" class="btn btn-green d-block mx-auto mt-4" href="index.php" style="width: 20%;"><i class="fas fa-redo fa-sm"></i> Ricarica</a>
            </div>
        </div>
    </div>
</body>
</html>
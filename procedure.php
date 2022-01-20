<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Procedure standard</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php";?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
    <!-- Include custom php functions -->
    <?php 
        session_start();
        require_once "helper/session.php";
        if($_SESSION['Username'] == "" && $_SESSION['Ruolo'] == "") {
            $_SESSION['title'] = "Sessione scaduta!";
            $_SESSION['text'] = "Effettua di nuovo il login!";
            $_SESSION['icon'] = "error";
            header("location: index.php");
        }

        if($_SESSION['Ruolo'] !== 'Administrator' && $_SESSION['Developer'] != 1) {
            $_SESSION['title'] = "ACCESS DENIED!";
            $_SESSION['text'] = "Non puoi accedere a questa pagina!";
            $_SESSION['icon'] = "error";
            header("location: dashboard.php");
            die();
        }
    ?>
</head>
<body>
    <?php include "includes/load.php"; ?>
    <div class="wrapper">
        <?php include "includes/navigation/sidebar.php"; ?>
        <div id="content">
            <?php include "includes/navigation/navbar.php"; ?>
            <div class="container-fluid p-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="procedure.php" class="text-dark font-weight-bold">Procedure</a></li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <div class="container-fluid bg-white rounded border p-4 shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center text-muted pt-3">Non ci sono procedure da eseguire</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
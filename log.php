<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Log</title>
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

        if($_SESSION['Ruolo'] == "User") {
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
                                <li class="breadcrumb-item" aria-current="page"><a href="log.php" class="text-dark font-weight-bold">Log</a></li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <!-- Tabs navs -->
                <div class="row">
                    <div class="col-12">
                        <div class="container-fluid p-0 bg-white border shadow-sm rounded">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active font-weight-bold" data-mdb-toggle="tab" href="#insertLog" role="tab">Log di inserimento</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#updateLog" role="tab">Log di modifica</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#deleteLog" role="tab">Log di cancellazione</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#migrationLog" role="tab">Log di migrazione</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#requestLog" role="tab">Log richieste</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content px-5 pb-5">
                <div class="tab-pane fade show active" id="insertLog" role="tabpanel">
                    <?php include "includes/body/log/insertLog.php"; ?>
                </div>
                <div class="tab-pane fade" id="updateLog" role="tabpanel">
                    <?php include "includes/body/log/updateLog.php"; ?>
                </div>
                <div class="tab-pane fade" id="deleteLog" role="tabpanel">
                    <?php include "includes/body/log/deleteLog.php"; ?>
                </div>
                <div class="tab-pane fade" id="migrationLog" role="tabpanel">
                    <?php include "includes/body/log/migrationLog.php"; ?>
                </div>
                <div class="tab-pane fade" id="requestLog" role="tabpanel">
                    <?php include "includes/body/log/requestLog.php"; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
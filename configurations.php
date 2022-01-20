<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Configurazioni</title>
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
                                <li class="breadcrumb-item" aria-current="page"><a href="configurations.php" class="text-dark font-weight-bold">Configurazioni</a></li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="container-fluid p-0 bg-white border shadow-sm rounded">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active font-weight-bold" data-mdb-toggle="tab" href="#ConfigTipoErogatori" role="tab">Tipo erogatori</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#ConfigConvProtocollo" role="tab">Conv. protocollo</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid px-5 tab-content">
                <div class="tab-pane fade show active" id="ConfigTipoErogatori" role="tabpanel">
                    <?php
                        $query1 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Tipo erogatore'";
                        $res1 = mysqli_query(connDB(),$query1) or die(mysqli_error(connDB()));

                        $query2 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Testata'";
                        $res2 = mysqli_query(connDB(),$query2) or die(mysqli_error(connDB()));

                        $query3 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Protocollo'";
                        $res3 = mysqli_query(connDB(),$query3) or die(mysqli_error(connDB()));
                    ?>
                    <?php include "includes/body/configuration/config_tipo_erogatori.php"; ?>
                </div>
                <div class="tab-pane fade" id="ConfigConvProtocollo" role="tabpanel">
                    <?php
                        $query4 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Convertitore di protocollo'";
                        $res4 = mysqli_query(connDB(),$query4) or die(mysqli_error(connDB()));

                        $query5 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Versione'";
                        $res5 = mysqli_query(connDB(),$query5) or die(mysqli_error(connDB()));
                    ?>
                    <?php include "includes/body/configuration/config_conv_protocollo.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "includes/modal/configuration/modalNewCTE.php"; ?>
    <?php require_once "includes/modal/configuration/modalUpdateCTE.php"; ?>
    <?php require_once "includes/modal/configuration/modalDeleteCTE.php"; ?>
    <?php require_once "includes/modal/configuration/modalClearCTE.php"; ?>

    <?php require_once "includes/modal/configuration/modalNewCCP.php"; ?>
    <?php require_once "includes/modal/configuration/modalUpdateCCP.php"; ?>
    <?php require_once "includes/modal/configuration/modalDeleteCCP.php"; ?>
    <?php require_once "includes/modal/configuration/modalClearCCP.php"; ?>
    
    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
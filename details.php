<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Title -->
    <title>MDS - Dettagli impianto</title>
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
    ?>
</head>

<body>
    <?php include "includes/load.php"; ?>
    <div class="wrapper">
        <?php include "includes/navigation/sidebar.php"; ?>
        <div id="content">
            <?php include "includes/navigation/navbar.php"; ?>
            <div class="container-fluid px-5 pt-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <?php
                            $id = $_GET['id'];
                            $query = "SELECT `NomeImpianto` FROM impianti WHERE `IdImpianto` = $id";
                            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
                            if ($row = mysqli_fetch_array($result)) {
                                $namePlant = $row['NomeImpianto'];
                            }
                        ?>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="list_plants.php?id=<?=$_GET['idCustomer']?>" class="text-muted">Impianti cliente</a></li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="details.php?id=<?=$_GET['id']?>&idCustomer=<?=$_GET['idCustomer']?>" class="text-dark font-weight-bold">Dettagli 
                                    <i class="fas fa-long-arrow-alt-right"></i> <?=$namePlant?></a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php"'; ?>
                </div>
                <!-- Tabs navs -->
                <div class="row">
                    <div class="col-12">
                        <div class="container-fluid p-0 bg-white border shadow-sm rounded">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active font-weight-bold" data-mdb-toggle="tab" href="#computer" role="tab">Computer</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#mac" role="tab">MAC</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#erogatori" role="tab">Erogatori</a>
                                </li>
                                <!-- COSM #09 - Aggiunta sezione accessori -->
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link font-weight-bold" data-mdb-toggle="tab" href="#accessori" role="tab">Accessori</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid px-5 mt-5 tab-content">
                <div class="tab-pane fade show active" id="computer" role="tabpanel">
                    <?php include "includes/body/computer.php"; ?>
                </div>
                <?php
                    $query1 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Tipo erogatore'";
                    $res1 = mysqli_query(connDB(),$query1) or die(mysqli_error(connDB()));

                    $query2 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Testata'";
                    $res2 = mysqli_query(connDB(),$query2) or die(mysqli_error(connDB()));

                    $query3 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Protocollo'";
                    $res3 = mysqli_query(connDB(),$query3) or die(mysqli_error(connDB()));

                    $query4 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Convertitore di protocollo'";
                    $res4 = mysqli_query(connDB(),$query4) or die(mysqli_error(connDB()));

                    $query5 = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = 'Versione'";
                    $res5 = mysqli_query(connDB(),$query5) or die(mysqli_error(connDB()));
                ?>
                <div class="tab-pane fade" id="mac" role="tabpanel">
                    <?php include "includes/body/mac.php"; ?>
                </div>
                <div class="tab-pane fade" id="erogatori" role="tabpanel">
                    <?php include "includes/body/erogatori.php"; ?>
                </div>
                <!-- COSM #09 - Aggiunta sezione accessori -->
                <div class="tab-pane fade" id="accessori" role="tabpanel">
                    <?php include "includes/body/accessori.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/timeSwal.php"; ?>
</body>

</html>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Report bug</title>
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
            <div class="container-fluid p-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="bug.php" class="text-dark font-weight-bold">Segnalazioni</a></li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <button class="btn btn-light shadow-sm border" onclick="reloadTable()">
                            <i class="fas fa-sync"></i> Aggiorna
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewBug" class="btn btn-green float-md-end float-sm-start float-start mt-md-0 mt-3 border shadow-sm">
                            <i class="fas fa-plus"></i> Aggiungi
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $username = $_SESSION['Username'];
                                    if($_SESSION['Ruolo'] == 'Administrator' && $_SESSION['Developer'] == 1) {
                                        $query = "SELECT * FROM `report_bug` ORDER BY `Id` DESC";
                                    } else {
                                        $query = "SELECT * FROM `report_bug` WHERE Utente = '$username' ORDER BY `Id` DESC";
                                    }
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtBug" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">ID segnalazione</th>
                                                <th class="th-sm">Data apertura</th>
                                                <th class="th-sm">Oggetto</th>
                                                <th class="th-sm">Impatto</th>
                                                <th class="th-sm">Priorità</th>
                                                <th class="th-sm">Stato</th>
                                                <th class="th-sm">Chiamante</th>
                                                <th class="th-sm"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td>#<?=$row['Id'];?></td>
                                                <td><?=$row['DataApertura'];?></td>
                                                <td><?=stripslashes($row['Oggetto']);?></td>
                                                <td>
                                                    <?php if($row['Impatto'] == 1) { ?>
                                                    <span class="badge bg-danger">Alto</span>
                                                    <?php } elseif($row['Impatto'] == 2) { ?>
                                                    <span class="badge bg-warning">Medio</span>
                                                    <?php } elseif($row['Impatto'] == 3) { ?>
                                                    <span class="badge bg-primary">Basso</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($row['Priorita'] == 1) { ?>
                                                    <span class="badge rounded-pill bg-danger">Urgente</span>
                                                    <?php } elseif($row['Priorita'] == 2) { ?>
                                                    <span class="badge rounded-pill bg-warning">Media</span>
                                                    <?php } elseif($row['Priorita'] == 3) { ?>
                                                    <span class="badge rounded-pill bg-primary">Bassa</span>
                                                    <?php } ?>
                                                </td>
                                                <td><?=stripslashes($row['Chiamante']);?></td>
                                                <td>
                                                    <?php if($row['Stato'] == 1) { ?>Nuovo
                                                    <?php } elseif($row['Stato'] == 2) { ?>In lavorazione
                                                    <?php } elseif($row['Stato'] == 3) { ?>Chiusa
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $obj = json_encode($row); 
                                                        $obj = htmlspecialchars($obj, ENT_QUOTES);
                                                    ?>
                                                    <a class="btn btn-sm btn-outline-dark btn-rounded" data-mdb-toggle="modal" onclick='updateReportBug(<?= $obj; ?>)'>
                                                        <?php
                                                            if ($_SESSION['Developer'] == 1) {
                                                                echo _("Gestisci");
                                                            } else {
                                                                echo _("Modifica");
                                                            }
                                                        ?>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <img src="img/other/bug.png" class="img-fluid d-block mx-auto mt-2" style="width: 96px; height: 96px;" />
                                <h5 class="text-muted text-center pt-3">Non sono presenti segnalazioni!</h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once "includes/modal/bug/modalNewBug.php"; ?>
    <?php require_once "includes/modal/bug/modalUpdateBug.php"; ?>
    
    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
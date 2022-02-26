<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Report bug</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php";?>
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
                        <?php if($_SESSION['Developer'] == 0) { ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewBug" class="btn btn-green float-md-end float-sm-start float-start mt-md-0 mt-3 border shadow-sm">
                            <i class="fas fa-plus"></i> Aggiungi
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $username = $_SESSION['Username'];
                                    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
                                    if($row = mysqli_fetch_array($result)) {
                                        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
                                    }
                                    $array = array(trim($username),trim($currentUser));
                                    $objArray = json_encode($array);

                                    if($_SESSION['Developer'] == 1) {
                                        $query = "SELECT * FROM `report_bug` WHERE `Stato` IN (1,2,3) ORDER BY `Id` DESC";
                                    } else {
                                        $query = "SELECT * FROM `report_bug` WHERE `Utente` = '$username' ORDER BY `Id` DESC";
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
                                                <th class="th-sm">Data chiusura</th>
                                                <th class="th-sm">Chiamante</th>
                                                <th class="th-sm">Oggetto</th>
                                                <th class="th-sm">Impatto</th>
                                                <th class="th-sm">Priorità</th>
                                                <th class="th-sm">Stato</th>
                                                <th class="th-sm"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td>#<?=$row['Id'];?></td>
                                                <td><?=$row['DataApertura'];?></td>
                                                <td><?=stripslashes($row['DataChiusura']);?></td>
                                                <td><?=stripslashes($row['Chiamante']);?></td>
                                                <td><?=stripslashes($row['Oggetto']);?></td>
                                                <td>
                                                    <?php 
                                                        if($row['Impatto'] == 1) { 
                                                            echo _("Alto");
                                                        } elseif($row['Impatto'] == 2) {
                                                            echo _("Medio");
                                                        } elseif($row['Impatto'] == 3) {
                                                            echo _("Basso");
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if($row['Priorita'] == 1) { ?>
                                                    <span class="font-weight-bold text-danger">Urgente</span>
                                                    <?php } elseif($row['Priorita'] == 2) { ?>
                                                    <span class="font-weight-bold text-warning">Media</span>
                                                    <?php } elseif($row['Priorita'] == 3) { ?>
                                                    <span class="font-weight-bold text-info">Bassa</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($row['Stato'] == 1) { ?>
                                                        <a data-mdb-toggle="tooltip" title="Nuova">
                                                            <i class="fas fa-unlock"></i>
                                                        </a>
                                                    <?php } elseif($row['Stato'] == 2) { ?>
                                                        <a data-mdb-toggle="tooltip" title="In lavorazione">
                                                            <i class="fas fa-spinner"></i>
                                                        </a>
                                                    <?php } elseif($row['Stato'] == 3) { ?>
                                                        <a data-mdb-toggle="tooltip" title="Consegnata">
                                                            <i class="fas fa-truck"></i>
                                                        </a>
                                                    <?php } elseif($row['Stato'] == 4) { ?>
                                                        <a data-mdb-toggle="tooltip" title="Chiusa">
                                                            <i class="fas fa-lock"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($_SESSION['Developer'] == 1 && ($row['Stato'] == 1 || $row['Stato'] == 2) || $_SESSION['Developer'] == 1 && (empty($row['Operatore']) && empty($row['UsernameOpe']))) { ?>
                                                    <a class="btn btn-sm btn-warning px-2" data-mdb-toggle="modal" title="Prendi in carico" onclick='getTicket(<?= $objArray; ?>)'>
                                                        <i class="fas fa-user-tag"></i>
                                                    </a>
                                                    <?php } ?>
                                                    <?php
                                                        $row['FlagDev'] = $_SESSION['Developer']; 
                                                        $obj = json_encode($row); 
                                                        $obj = htmlspecialchars($obj, ENT_QUOTES);
                                                    ?>
                                                    <?php if($_SESSION['Developer'] == 1 && (!empty($row['Operatore']) && !empty($row['UsernameOpe'])) || $_SESSION['Developer'] == 0) { ?>
                                                    <a class="btn btn-sm btn-primary" data-mdb-toggle="modal" onclick='updateReportBug(<?= $obj; ?>)'>
                                                        <?php
                                                            if ($_SESSION['Developer'] == 1 && ($row['Stato'] == 1 || $row['Stato'] == 2)) {
                                                                echo _("Gestisci");
                                                            } elseif ($_SESSION['Developer'] == 1 && $row['Stato'] == 3) {
                                                                echo _("Visualizza");
                                                            } elseif ($_SESSION['Developer'] == 0 && ($row['Stato'] == 1 || $row['Stato'] == 2 || $row['Stato'] == 3)) {
                                                                echo _("Aggiorna");
                                                            } elseif ($_SESSION['Developer'] == 0 && $row['Stato'] == 4) {
                                                                echo _("Visualizza");
                                                            }
                                                        ?>
                                                    </a>
                                                    <?php } ?>
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
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
    <?php if($_SESSION['Developer'] == 0) { ?>
        <?php require_once "includes/modal/bug/modalNewBug.php"; ?>
    <?php } ?>

    <?php if($_SESSION['Developer'] == 1 && (!empty($row['Operatore']) && !empty($row['UsernameOpe'])) || $_SESSION['Developer'] == 0) { ?>
        <?php require_once "includes/modal/bug/modalUpdateBug.php"; ?>
    <?php } ?>

    <?php if ($_SESSION['Developer'] == 1 && ($row['Stato'] == 1 || $row['Stato'] == 2) || $_SESSION['Developer'] == 1 && (empty($row['Operatore']) && empty($row['UsernameOpe']))) { ?>
        <?php require_once "includes/modal/bug/modalGetTicket.php"; ?>
    <?php } ?>

    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
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
                            <i class="fas fa-user-plus"></i> Aggiungi
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $query = "SELECT * FROM `report_bug`";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtUsers" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">ID segnalazione</th>
                                                <th class="th-sm">Chiamante</th>
                                                <th class="th-sm">Data apertura</th>
                                                <th class="th-sm">Oggetto</th>
                                                <th class="th-sm">Priorità</th>
                                                <th class="th-sm">Stato</th>
                                                <th class="th-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=$row['Id'];?></td>
                                                <td><?=stripslashes($row['Chiamante']);?></td>
                                                <td><?=stripslashes($row['DataApertura']);?></td>
                                                <td><?=stripslashes($row['Oggetto']);?></td>
                                                <td><?=$row['Priorita'];?></td>
                                                <td><?=$row['Stato'];?></td>
                                                <td></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <img src="img/other/bug.png" class="img-fluid d-block mx-auto mt-2" style="width: 96px; height: 96px;" />
                                <h5 class="text-muted text-center pt-3">Non sono presenti dati!</h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "includes/modal/user/modalNewBug.php"; ?>
    <?php require_once "includes/modal/user/modalDeleteBug.php"; ?>
    <?php require_once "includes/modal/user/modalUpdateBug.php"; ?>
    
    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
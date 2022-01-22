<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Richieste in sospeso</title>
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
                                <li class="breadcrumb-item" aria-current="page"><a href="pending.php" class="text-dark font-weight-bold">Richieste in sospeso</a></li>
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
                    <?php
                        $query = "SELECT * FROM `richieste_append` ORDER BY `DataRichiesta`";
                        $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                        if(mysqli_fetch_array($result)) {
                    ?>
                    <div class="col-md-6">
                        <button data-mdb-toggle="modal" class="btn btn-danger float-end me-0" onclick='deleteAllRequests()'>
                            <i class="fas fa-trash"></i> Pulisci
                        </button>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $query = "SELECT * FROM `richieste_append` ORDER BY `DataRichiesta`";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtRequests" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Data Richiesta</th>
                                                <th class="th-sm">Richiesta</th>
                                                <th class="th-sm">Impianto</th>
                                                <th class="th-sm">Operatore</th>
                                                <th class="th-sm">Dettagli</th>
                                                <th class="th-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=$row['DataRichiesta'];?></td>
                                                <td><?=$row['Richiesta'];?></td>
                                                <td><?=$row['Impianto'];?></td>
                                                <td><?=$row['Operatore'];?></td>
                                                <td>
                                                    <a class="btn btn-white btn-sm px-2" href="details.php?id=<?=$row['IdImpianto_FK']?>&idCustomer=<?=$row['IdCliente_FK']?>">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $obj = json_encode($row); 
                                                        $obj = htmlspecialchars($obj, ENT_QUOTES);
                                                    ?>
                                                    <a class="btn btn-success btn-sm px-2" data-mdb-toggle="modal" onclick='acceptRequest(<?= $obj; ?>)'>
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm px-2" data-mdb-toggle="modal" onclick='deleteRequest(<?= $obj; ?>)'>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <img src="img/other/inbox.png" class="img-fluid d-block mx-auto mt-2" />
                                <h5 class="text-muted text-center pt-3">Non sono presenti richieste!</h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($_SESSION['Ruolo'] == 'Administrator') { ?>
        <?php require_once "includes/modal/request/modalAcceptRequest.php"; ?>
        <?php require_once "includes/modal/request/modalDeleteRequest.php"; ?>
        <?php require_once "includes/modal/request/modalClearRequests.php"; ?>
    <?php } ?>

    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
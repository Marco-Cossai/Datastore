<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Dati erogatori</title>
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
                                <li class="breadcrumb-item" aria-current="page"><a href="operations.php" class="text-dark font-weight-bold">Dati erogatori</a></li>
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
                        <?php
                            $result = mysqli_query(connDB(),"SELECT * FROM `dati_erogatori`");
                            if (mysqli_fetch_array($result)) {
                        ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalClearDataDispenser" class="btn btn-danger float-md-end float-sm-start float-start mt-md-0 mt-3 border shadow-sm">
                            <i class="fas fa-trash"></i> Pulisci
                        </button>
                        <?php } ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewDataDispenser" class="btn btn-green float-md-end float-sm-start float-start mt-md-0 mt-3 me-lg-1 me-md-1 border shadow-sm">
                            <i class="fas fa-plus"></i> Aggiungi
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $query = "SELECT * FROM `dati_erogatori` ORDER BY `Id` DESC";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtDataDispenser" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Nome</th>
                                                <th class="th-sm">Tipologia</th>
                                                <th class="th-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=$row['Nome'];?></td>
                                                <td><?=$row['Tipologia'];?></td>
                                                <td>
                                                    <?php 
                                                        $obj = json_encode($row); 
                                                        $obj = htmlspecialchars($obj, ENT_QUOTES);
                                                    ?>
                                                    <a class="btn btn-primary btn-sm px-2" data-mdb-toggle="modal" onclick='updateDataDispenser(<?= $obj; ?>)'>
                                                        <i class="fas fa-pencil-alt fa-sm"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm px-2" data-mdb-toggle="modal" onclick='deleteDataDispenser(<?= $obj; ?>)'>
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <img src="img/other/empty.svg" class="img-fluid d-block mx-auto mt-2" style="width: 95px; height: 95px;" />
                                <h5 class="text-muted text-center pt-3">Non sono presenti dati!</h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "includes/modal/configuration/modalNewDataDispenser.php"; ?>
    <?php require_once "includes/modal/configuration/modalUpdateDataDispenser.php"; ?>
    <?php require_once "includes/modal/configuration/modalDeleteDataDispenser.php"; ?>
    <?php require_once "includes/modal/configuration/modalClearDataDispenser.php"; ?>
    
    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
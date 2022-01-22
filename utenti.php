<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Utenti</title>
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
                                <li class="breadcrumb-item" aria-current="page"><a href="utenti.php" class="text-dark font-weight-bold">Utenti</a></li>
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
                        <?php if($_SESSION['Ruolo'] == 'Administrator') { ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewUser" class="btn btn-green float-md-end float-sm-start float-start mt-md-0 mt-3 border shadow-sm">
                            <i class="fas fa-user-plus"></i> Aggiungi
                        </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $currentUser = $_SESSION['Username'];
                                    $query = "SELECT `IdUtente`,`Nome`,`Cognome`,`Sesso`,`Ruolo`,`Email`,`Username`,`LastAccess`,`Stato`,`Developer` FROM `utenti` WHERE `Username` != '$currentUser' ORDER BY `Nome`";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtUsers" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Nome</th>
                                                <th class="th-sm">Cognome</th>
                                                <th class="th-sm">Ruolo</th>
                                                <th class="th-sm">Email</th>
                                                <th class="th-sm">Username</th>
                                                <th class="th-sm">Status</th>
                                                <th class="th-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=$row['Nome'];?></td>
                                                <td><?=$row['Cognome'];?></td>
                                                <td>
                                                    <?=$row['Ruolo'];?>
                                                    <?php if ($row['Developer'] == 1) { ?>
                                                    <i class="fab fa-dev text-green fa-lg"></i>
                                                    <?php } ?>
                                                </td>
                                                <td><?=$row['Email'];?></td>
                                                <td><?=$row['Username'];?></td>
                                                <td>
                                                    <?php if($row['Stato'] == 1) { ?>
                                                    <h6 class="mb-0"><span class="badge bg-green font-weight-bold">Online</span></h6>
                                                    <?php } elseif($row['Stato'] == 0) { ?>
                                                    <h6 class="mb-0"><span class="badge bg-danger">Offline</span></h6>
                                                    <?php } ?>
                                                </td>
                                                <?php if($_SESSION['Ruolo'] == 'Administrator') { ?>
                                                <td>
                                                    <?php 
                                                        $obj = json_encode($row); 
                                                        $obj = htmlspecialchars($obj, ENT_QUOTES);
                                                    ?>
                                                    <a class="btn btn-primary btn-sm px-2" data-mdb-toggle="modal" onclick='updateUser(<?= $obj; ?>)'>
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm px-2" data-mdb-toggle="modal" onclick='deleteUser(<?= $obj; ?>)'>
                                                        <i class="fas fa-user-times"></i>
                                                    </a>
                                                </td>
                                                <?php } else {?>
                                                <td><i class="fas fa-ban text-danger fa-lg"></i></td>
                                                <?php } ?>
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

    <?php if($_SESSION['Ruolo'] == 'Administrator') { ?>
        <?php require_once "includes/modal/user/modalNewUser.php"; ?>
        <?php require_once "includes/modal/user/modalDeleteUser.php"; ?>
        <?php require_once "includes/modal/user/modalUpdateUser.php"; ?>
    <?php } ?>

    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
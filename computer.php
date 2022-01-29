<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Computer</title>
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
                                <li class="breadcrumb-item"><a href="impianti.php" class="text-muted">Impianti</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="computer.php" class="text-dark font-weight-bold">Computer</a></li>
                            </ol>
                        </nav>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <button class="btn btn-light shadow-sm border" onclick="reloadTable()">
                            <i class="fas fa-sync"></i> Aggiorna
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border mt-3">
                            <div class="card-body">
                                <?php
                                    $query = "SELECT * FROM (computer JOIN impianti ON computer.IdImpianto_FK=impianti.IdImpianto)";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtComputer" class="table table-sm text-nowrap align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Matricola</th>
                                                <th class="th-sm">SN-PC</th>
                                                <th class="th-sm">Stampante</th>
                                                <th class="th-sm">SN-Router</th>
                                                <th class="th-sm">Indirizzo IP</th>
                                                <th class="th-sm">Anydesk</th>
                                                <th class="th-sm">Dettagli</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=stripslashes($row['Matricola']);?></td>
                                                <td><?=stripslashes($row['SerialePC']);?></td>
                                                <td><?=stripslashes($row['Stampante']);?></td>
                                                <td><?=stripslashes($row['SerialeRouter']);?></td>
                                                <td><?=stripslashes($row['IP']);?></td>
                                                <td><?=stripslashes($row['Anydesk']);?></td>
                                                <td>
                                                    <a class="btn btn-white btn-sm px-2" href="details.php?id=<?=$row['IdImpianto']?>&idCustomer=<?=$row['IdCliente_FK']?>">
                                                        <i class="fas fa-external-link-alt"></i>
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
    <?php include "includes/timeSwal.php"; ?>
</body>
</html>
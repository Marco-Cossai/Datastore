<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Dashboard</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php";?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
    <!-- Include custom php functions -->
    <?php 
        session_start();
        include "helper/session.php";
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
                        <h3 class="section-title pt-2">Dashboard</h3>
                    </div>
                    <?php include 'includes/calendar.php'; ?>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card bg-card-green mt-lg-3 mt-md-3 mt-sm-3 mt-3 shadow-sm border">
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                        $user = $_SESSION['Username'];
                                        $result = mysqli_query(connDB(),"SELECT * FROM utenti WHERE Username='$user';") or die(mysqli_error(connDB()));
                                        if(mysqli_fetch_array($result)) {
                                            foreach($result as $row) {

                                    ?>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-8">
                                        <h4 class="h4 text-body font-weight-bold"> 
                                            <?php if ($row['Sesso'] == 'Maschio') { ?>
                                            Bentornato,
                                            <?php } elseif ($row['Sesso'] == 'Femmina') { ?>
                                            Bentornata,
                                            <?php } else { ?>
                                            Bentornato/a,
                                            <?php } ?>
                                            <?=$row['Nome'];?>
                                        </h4>
                                        <p class="text-body font-weight-bold">Dashboard</p>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-4">
                                        <img src="img/other/hello.svg" class="img-fluid" alt="Bentornato!">
                                    </div>
                                    <?php } }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card mt-lg-3 mt-md-3 mt-sm-2 mt-3 shadow-sm border">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col me-2">
                                        <?php
                                            $result = mysqli_query(connDB(),"SELECT * FROM clienti;") or die(mysqli_error(connDB()));
                                            $num = mysqli_num_rows($result);
                                        ?>
                                        <div class="h5 mb-2 font-weight-bold text-dark"><?=$num;?></div>
                                        <div class="text-xs font-weight-bold text-muted text-uppercase">Clienti</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-tie fa-2x p-lg-4 p-md-4 p-sm-4 p-3 rounded-circle text-body bg-card-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card mt-lg-3 mt-md-3 mt-sm-2 mt-3 shadow-sm border">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col me-2">
                                        <?php
                                            $result = mysqli_query(connDB(),"SELECT * FROM impianti;") or die(mysqli_error(connDB()));
                                            $num = mysqli_num_rows($result);
                                        ?>
                                        <div class="h5 mb-2 font-weight-bold text-dark"><?=$num;?></div>
                                        <div class="text-xs font-weight-bold text-muted text-uppercase">Impianti</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-industry fa-2x p-lg-4 p-md-4 p-sm-4 p-3 rounded-circle text-body bg-card-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="card mt-lg-3 mt-md-3 mt-sm-2 mt-3 shadow-sm border">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col me-2">
                                        <?php
                                            $result = mysqli_query(connDB(),"SELECT * FROM utenti WHERE Stato = 1;") or die(mysqli_error(connDB()));
                                            $num = mysqli_num_rows($result);
                                        ?>
                                        <div class="h5 mb-2 font-weight-bold text-dark"><?=$num;?></div>
                                        <div class="text-xs font-weight-bold text-uppercase">Online</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x p-lg-4 p-md-4 p-sm-4 p-3 rounded-circle text-body bg-card-green"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-xl-9">
                        <div class="card shadow-sm border">
                            <div class="card-header">Impianti</div>
                            <div class="card-body">
                                <?php
                                    $query = "SELECT * FROM (`impianti` JOIN `clienti` ON impianti.IdCliente_FK = clienti.IdCliente)";
                                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                                    if(mysqli_fetch_array($result)){
                                ?>
                                <div class="table-responsive">
                                    <table id="dtPlantDash" class="table table-sm align-middle text-center py-4">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">Nome impianto</th>
                                                <th class="th-sm">Email</th>
                                                <th class="th-sm">Recapito</th>
                                                <th class="th-sm">Cliente</th>
                                                <th class="th-sm">Dettagli</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($result as $row) { ?>
                                            <tr>
                                                <td><?=$row['NomeImpianto'];?></td>
                                                <td><?= $row['Email'];?></td>
                                                <td><?= $row['Recapito'];?></td>
                                                <td><?= $row['RagioneSociale'];?></td>
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
                    <div class="col-xl-3">
                        <div class="card mt-xl-0 mt-lg-4 mt-md-4 mt-sm-4 mt-4 shadow-sm border">
                            <div class="card-header font-weight-bold">Feed<span class="badge bg-green float-end">Today</span></div>
                            <div class="card-body p-0">
                                <ul class="navbar-nav">
                                    <?php
                                        $today = date("d/m/Y");
                                        $result = mysqli_query(connDB(),"SELECT * FROM `log` WHERE SUBSTRING(DataLog,1,10) = '$today' ORDER BY `DataLog` DESC LIMIT 0,8") or die(mysqli_error(connDB()));
                                        if(mysqli_fetch_array($result)) {
                                            foreach($result as $row) {
                                                $aryDataLog = explode(" - ",$row['DataLog']);
                                                $hour = substr($aryDataLog[1],0,strlen($aryDataLog[1])-3);
                                    ?>
                                    <?php if($row['Operazione'] == 1) { ?>
                                    <li class="border-bottom px-3 py-2">
                                        <div class="font-weight-bold text-black-50"><?=$hour?></div>
                                        <div class="text-muted"><?=$row['Compilatore'];?> ha inserito dei dati</div>
                                    </li>
                                    <?php } elseif ($row['Operazione'] == 2) { ?>
                                    <li class="border-bottom px-3 py-2">
                                        <div class="font-weight-bold text-black-50"><?=$hour?></div>
                                        <div class="text-muted"><?=$row['Compilatore'];?> ha modificato dei dati</div>
                                    </li>
                                    <?php } elseif($row['Operazione'] == 3) { ?>
                                    <li class="border-bottom px-3 py-2">
                                        <div class="font-weight-bold text-black-50"><?=$hour?></div>
                                        <div class="text-muted"><?=$row['Compilatore'];?> ha cancellato dei dati</div>
                                    </li>
                                    <?php } elseif($row['Operazione'] == 4) { ?>
                                    <li class="border-bottom px-3 py-2">
                                        <div class="font-weight-bold text-black-50"><?=$hour?></div>
                                        <div class="text-muted"><?=$row['Compilatore'];?> ha migrato un impianto</div>
                                    </li>
                                    <?php } elseif($row['Operazione'] == 5) { ?>
                                    <li class="border-bottom px-3 py-2">
                                        <div class="font-weight-bold text-black-50"><?=$hour?></div>
                                        <div class="text-muted"><?=$row['Compilatore'];?> ha effettuato una richiesta di cancellazione</div>
                                    </li>
                                    <?php } } } else { ?>
                                    <li class="text-muted text-center py-4">Non c'è ancora nessuna attività...</li>
                                    <?php } ?>
                                </ul>
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
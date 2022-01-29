<nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a type="button" id="sidebarCollapse" class="ms-2" data-mdb-target="#navbarCollapse" data-mdb-toggle="collapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fa-lg"></i>
        </a>
        <a href="dashboard.php" class="ms-4 text-decoration-0">
            <img src="img/logo/logo.png" class="mx-auto img-fluid" style="margin-top: -5px; height: 20px;"/>
        </a>
        <ul class="navbar-nav ms-auto">
            <?php if ($_SESSION['Ruolo'] == "Administrator") {?>
            <li class="nav-item pe-2">
                <a href="#" class="nav-link mt-1" id="notifyDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <?php
                        $result = mysqli_query(connDB(),"SELECT * FROM `richieste_append` LIMIT 0,11") or die(mysqli_error(connDB()));
                        if (mysqli_fetch_array($result)) {
                    ?>
                    <span class="badge badge-dot bg-green pb-0"></span>
                    <?php } ?>
                </a>
                <?php 
                    if (mysqli_fetch_array($result)) { 
                        $num = mysqli_num_rows($result);
                ?>
                <ul class="dropdown-menu dropdown-menu-end border shadow me-2" aria-labelledby="notifyDropdown" style="margin: -10px;">
                    <li>
                        <a class="dropdown-item border-bottom py-1">
                            <h6 class="pt-2 text-center text-muted">
                                <?php if($num == 1) { ?>
                                <?=$num?> nuova notifica
                                <?php } elseif ($num > 1 && $num <= 10) { ?>
                                <?=$num?> nuove notifiche
                                <?php } elseif($num > 10) {?>
                                10+ notifiche
                                <?php } ?>
                            </h6>
                        </a>
                    </li>
                    <?php foreach ($result as $row) { ?>
                    <li>
                        <a class="dropdown-item m-0 p-3">
                            <i class="far fa-bell text-green pe-2"></i>
                            <div class="d-inline text-dark font-weight-bold"> <?=$row['Operatore']?></div>
                            <div class="text-muted small mt-1"><?=$row['Richiesta']?></div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <?php } ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle me-4 text-dark" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <?php
                        $user = $_SESSION['Username'];
                        $query = "SELECT `Nome`,`Cognome`,`Sesso` FROM `utenti` WHERE `Username` = '$user'";
                        $result = mysqli_query(connDB(),$query);
                        $row = mysqli_fetch_array($result);
                    ?>
                    <?php if ($row['Sesso'] == 'Maschio') { ?>
                    <img src="img/other/user.png" class="img-fluid"/>
                    <?php } elseif ($row['Sesso'] == 'Femmina') { ?>
                    <img src="img/other/userfemale.png" class="img-fluid"/>
                    <?php } else { ?>
                    <img src="img/other/default.png" class="img-fluid"/>
                    <?php } ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border shadow" aria-labelledby="navbarDropdown" style="margin: -3px;">
                    <li>
                        <a class="dropdown-item">Signed in as <br/>
                            <b><?= $row['Nome']." ".stripslashes($row['Cognome']); ?></b> <br/>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider m-0" /></li>
                    <li>
                        <a class="dropdown-item">Last activity <br/>
                            <b><?= $_SESSION['LastHourActivity']; ?></b>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider m-0" /></li>
                    <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog fa-sm"></i> Impostazioni</a></li>
                    <li><a class="dropdown-item" href="#" data-mdb-toggle="modal" data-mdb-target="#Logout"><i class="fas fa-power-off fa-sm"></i> Sign out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php include "collapse.php"; ?>
<?php include "includes/modal/modalLogout.php"; ?>
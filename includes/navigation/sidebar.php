<nav id="sidebar" class="shadow-2-strong">
    <div id="dismiss" class="px-3 py-2 mt-2 me-2 float-end rounded">
        <i class="fas fa-times"></i>
    </div>
    <div class="sidebar-header py-3">
        <img src="img/logo/logo_white.png" class="ms-4 img-fluid" style="margin-top: -5px; height: 22px;"/>
        <hr class="text-light"/>
    </div>
    <ul class="list-unstyled components">
        <div class="sidenav-menu-heading pt-4 ps-3">Generale</div>
        <li class="ps-3 pt-2">
            <a href="dashboard.php">
                <i class="far fa-chart-bar"></i>
                <span class="ps-1" >Dashboard</span>
            </a>
        </li>
        <li class="ps-3 pt-1">
            <a href="clienti.php">
                <i class="fas fa-user-tie"></i>
                <span class="ps-1">Clienti</span>
            </a>
        </li>
        <div class="sidenav-menu-heading pt-4 ps-3">Impianti</div>
        <li class="ps-3 pt-2">
            <a href="impianti.php">
                <i class="fas fa-industry"></i>
                <span class="ps-1">Impianti</span>
            </a>
        </li>
        <li class="ps-3 pt-1">
            <a href="computer.php">
                <i class="fas fa-desktop"></i>
                <span class="ps-1">Postazioni</span>
            </a>
        </li>
        <div class="sidenav-menu-heading pt-4 ps-3">Altro</div>
        <li class="ps-3 pt-2">
            <a href="utenti.php">
                <i class="fas fa-users"></i>
                <span class="ps-1">Utenze</span>
            </a>
        </li>
        <?php if($_SESSION['Ruolo'] == "Administrator") { ?>
        <li class="dropdown ps-3 pt-1">
            <a href="#ConfigurazioneErogatori" data-mdb-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cogs"></i> Config. erogatori</a>
            <ul class="collapse list-unstyled" id="ConfigurazioneErogatori">
                <li><a href="operations.php" class="ps-4 pt-1"><i class="fas fa-database"></i> Dati erogatori</a></li>
                <li><a href="configurations.php" class="ps-4 pt-1"><i class="fas fa-random"></i> Combinazioni</a></li>
            </ul>
        </li>
        <li class="ps-3 pt-1">
            <a href="pending.php">
                <i class="fas fa-comments"></i>
                <span class="ps-1" >Richieste</span>
                <?php
                    $query = mysqli_query(connDB(),"SELECT * FROM `richieste_append`") or die(mysqli_error(connDB()));
                    $num = mysqli_num_rows($query);
                    if($num > 0) {
                ?>
                <span class="badge bg-green ms-3 px-2"><?= $num; ?></span>
                <?php } ?>
            </a>
        </li>
        <li class="ps-3 pt-1">
            <a href="log.php">
                <i class="fas fa-history"></i>
                <span class="ps-1">Log</span>
            </a>
        </li>
        <?php } ?>
        <div class="sidenav-menu-heading pt-4 ps-3">Assistenza</div>
        <li class="ps-3 pt-2">
            <a href="bug.php">
                <i class="fas fa-bug"></i>
                <span class="ps-1">Segnalazioni</span>
            </a>
        </li>
        <?php if($_SESSION['Ruolo'] == 'Administrator' && $_SESSION['Developer'] == 1) { ?>
        <div class="sidenav-menu-heading pt-4 ps-3">Development</div>
        <li class="ps-3 pt-2">
            <a href="procedure.php">
                <i class="fas fa-wrench"></i>
                <span class="ps-1">Procedure standard</span>
            </a>
        </li>
        <?php } ?>
    </ul>
</nav>
<div class="collapse navbar-collapse d-lg-none d-md-none shadow-sm bg-white pb-3" id="navbarCollapse">
    <ul class="navbar-nav me-auto">
        <div class="sidenav-menu-heading pt-4 ps-4">Generale</div>
        <li class="nav-item ps-4">
            <a class="nav-link text-dark pt-1" href="dashboard.php">
                <i class="far fa-chart-bar"></i>
                <span class="ps-1" >Dashboard</span>
            </a>
        </li>
        <li class="nav-item ps-4">
            <a class="nav-link text-dark pt-0" href="clienti.php">
                <i class="fas fa-user-tie"></i>
                <span class="ps-1" >Clienti</span>
            </a>
        </li>
        <div class="sidenav-menu-heading ps-4 pt-3">Impianti</div>
        <li class="nav-item ps-4">
            <a class="nav-link text-dark pt-1" href="impianti.php">
                <i class="fas fa-industry"></i>
                <span class="ps-1" >Impianti</span>
            </a>
        </li>
        <li class="nav-item ps-4">
            <a class="nav-link text-dark pt-0" href="computer.php">
                <i class="fas fa-desktop"></i>
                <span class="ps-1" >Postazioni</span>
            </a>
        </li>
        <div class="sidenav-menu-heading ps-4 pt-3">Altro</div>
        <li class="nav-item ps-4">
            <a href="utenti.php" class="nav-link text-dark pt-1">
                <i class="fas fa-users"></i>
                <span class="ps-1">Utenze</span>
            </a>
        </li>
        <?php if($_SESSION['Ruolo'] == "Administrator") { ?>
        <li class="dropdown ps-4">
            <a class="nav-link dropdown-toggle text-dark pt-0" href="#ConfigurazioneErogatori" data-mdb-toggle="collapse" aria-expanded="false"> <i class="fas fa-cogs pe-1"></i> Config. erogatori</a>
            <ul class="collapse list-unstyled navbar-nav" id="ConfigurazioneErogatori">
                <li class="nav-item ms-4"><a href="operations.php" class="nav-link text-dark pt-0"><i class="fas fa-database"></i> Dati erogatori</a></li>
                <li class="nav-item ms-4"><a href="configurations.php" class="nav-link text-dark pt-0"><i class="fas fa-random"></i> Combinazioni</a></li>
            </ul>
        </li>        
        <li class="nav-item ps-4">
            <a class="nav-link text-dark pt-0" href="pending.php">
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
        <li class="nav-item ps-4">
            <a href="log.php" class="nav-link text-dark pt-0">
                <i class="fas fa-history"></i>
                <span class="ps-1">Log</span>
            </a>
        </li>
        <?php } ?>
        <div class="sidenav-menu-heading ps-4 pt-3">Assistenza</div>
        <li class="nav-item ps-4">
            <a href="bug.php" class="nav-link text-dark pt-1">
                <i class="fas fa-bug"></i>
                <span class="ps-1">Segnalazioni</span>
            </a>
        </li>
        <?php if($_SESSION['Ruolo'] == 'Administrator' && $_SESSION['Developer'] == 1) { ?>
        <div class="sidenav-menu-heading ps-4 pt-3">Altro</div>
        <li class="nav-item ps-4">
            <a href="procedure.php" class="nav-link text-dark pt-1">
                <i class="fas fa-wrench"></i>
                <span class="ps-1">Procedure standard</span>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
                
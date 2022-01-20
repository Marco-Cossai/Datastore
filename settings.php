<!DOCTYPE html>
<html lang="it">

<head>
    <!-- Title -->
    <title>MDS - Settings</title>
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
                        <h3 class="section-title pt-1">Impostazioni</h3>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <a class="btn btn-white float-md-end float-sm-start float-start mt-lg-0 mt-md-0 mt-sm-2 mt-2 shadow-sm border" href="dashboard.php">Torna alla dashboard</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-3 col-md-3">
                        <!-- Tab navs -->
                        <div class="nav flex-column nav-pills text-center mx-0 my-2 shadow-sm border" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link m-0 font-weight-bold bg-light border-bottom rounded-0" role="tab">Profile settings</a>
                            <a class="nav-link active m-0 rounded-0 border-bottom" id="v-pills-account-tab" data-mdb-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account</a>
                            <?php if($_SESSION['Ruolo'] == 'Administrator') {?>
                            <a class="nav-link m-0 rounded-0 border-bottom" id="v-pills-password-tab" data-mdb-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">Modifica password</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <!-- Tab content -->
                        <div class="tab-content mx-0 my-2" id="v-pills-tabContent">
                            <?php include "includes/body/settings/account.php"; ?>
                            <?php if($_SESSION['Ruolo'] == 'Administrator') {?>
                            <?php include "includes/body/settings/change_password.php"; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
    <?php include "includes/timeSwal.php"; ?>
</body>

</html>
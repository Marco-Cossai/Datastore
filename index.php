<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Sign in</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php" ;?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php";?>
    <!-- Include custom php functions -->
    <?php 
        session_start();
        require_once "helper/functions.php"; 
    ?>
</head>
<body>
    <?php include "includes/loader.php"; ?>
    <div class="container-fluid background-custom d-flex align-items-center">
        <div class="row mx-auto bg-white shadow p-xl-4 p-lg-4 p-md-4 p-sm-4 py-4 px-2 rounded">
            <img src="img/logo/logo.png" class="mx-auto mb-3" style="width: 210px; height: 32px;"/>
            <hr />
            <div class="col-12">
                <form class="needs-validation" novalidate action="database/database.php" method="POST">
                    <input type="hidden" class="form-control" name="datamodule" value="login" readonly/>

                    <label class="mt-2">Username</label>
                    <input type="text" class="form-control mt-1 mb-0" name="Username" minlength="8" required>

                    <label class="mt-2">Password</label>
                    <input type="password" class="form-control mt-1 mb-0" name="Password" minlength="8" maxlength="16" required>

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <a type="button" data-mdb-toggle="modal" data-mdb-target="#ModalResetPassword" class="mt-4 text-decoration-0">Password dimenticata?</a>
                            <button class="btn btn-green d-block mt-3" type="submit">Sign in</button>
                        </div>
                        <?php
                            $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Ruolo` = 'Administrator';") or die (mysqli_error(connDB()));
                            if(!mysqli_fetch_array($result)) {
                        ?>
                        <div class="col-lg-6 col-md-6">
                            <p class="text-dark mt-4 text-lg-end text-md-end text-sm-start text-start">Sei il primo a iscriverti?</p>
                            <a class="btn btn-outline-dark mt-0 float-lg-end float-md-end float-sm-start float-start" href="signup.php">Sign up</a>
                        </div>
                        <?php } ?>
                    </div>
                </form>
                <?php include "includes/modal/modalResetPassword.php";?>
            </div>
        </div>
    </div> 
    <?php include "includes/swal.php"; ?> 
</body>
</html>
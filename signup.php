<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Sign up</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php";?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php"; ?>
    <!-- Include custom php functions -->
    <?php 
        session_start();
        require_once "helper/functions.php";
        $result = mysqli_query(connDB(),"SELECT * FROM `utenti`;") or die (mysqli_error(connDB()));
        if(mysqli_fetch_array($result)) {
            if($_SESSION['Username'] == "") {
                header("location: index.php");
            }
            if($_SESSION['Ruolo'] == "User" || $_SESSION['Ruolo'] == "Administrator") {
                $_SESSION['title'] = "ERRORE!";
                $_SESSION['text'] = "Accesso negato!";
                $_SESSION['icon'] = "error";
                header("location: dashboard.php");
            }
        }
    ?>
</head>
<body>
    <?php include "includes/loader.php"; ?>
    <div class="container-fluid background-custom d-flex align-items-center">
        <div class="container bg-white shadow p-xl-4 p-lg-4 p-md-4 p-sm-4 py-4 px-2 rounded">
            <div class="row">
                <a href="index.php" class="text-center text-decoration-0">
                    <img src="img/logo/logo.png" class="mx-auto mb-3" style="width: 210px; height: 32px;"/>
                </a>
                <hr />
                <div class="col-12">
                    <form class="needs-validation" novalidate action="database/database.php" method="POST">
                        <h4 class="h4 title py-3 text-center">Registrazione primo utente</h4>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" class="form-control" name="datamodule" value="signup" readonly/>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Nome *</label>
                                <input type="text" class="form-control mt-1 mb-0" name="Nome" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Cognome *</label>
                                <input type="text" class="form-control mt-1 mb-0" name="Cognome" required>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Sesso *</label>
                                <select class="form-select mt-1 py-1 mb-0" name="Sesso" required>
                                    <option value=""></option>
                                    <option value="Maschio">Maschio</option>
                                    <option value="Femmina">Femmina</option>
                                    <option value="N.S.">Non specificato</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Email</label>
                                <input type="email" class="form-control mt-1 mb-0" name="Email">
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Username *</label>
                                <input type="text" class="form-control mt-1 mb-0" name="Username" minlength="8" required>
                                <span class="form-text font-italic">Lunghezza minima di 8 caratteri</span>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="mt-2">Password *</label>
                                <input type="password" class="form-control mt-1 mb-0" name="Password" minlength="8" maxlength="16" required>
                                <span class="form-text font-italic">Lunghezza 8-16 caratteri</span>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-green mt-4 float-end" type="submit">Sign up</button>
                                <button class="btn btn-danger mt-4 me-2 float-end" type="reset">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "includes/swal.php"; ?>
</body>
</html>
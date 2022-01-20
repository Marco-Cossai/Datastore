<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Title -->
    <title>MDS - Reset password</title>
    <!-- Metatag -->
    <?php include "includes/header/metaTags.php";?>
    <!-- Include style -->
    <?php include "includes/header/style.php" ;?>
    <!-- Include javascript -->
    <?php include "includes/header/scripts.php";?>
    <!-- Include custom php functions -->
    <?php 
        session_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/'.'database/config.php';      
        connDB();

        $_SESSION['Token'] = $_GET['token'];
        $_SESSION['IdUtente'] = $_GET['id'];
        $token = $_GET['token'];
        $idUser = $_GET['id'];
        
        if($_SESSION['IdUtente'] == "" || $_SESSION['Token'] == "") {
            $_SESSION['title'] = "ERRORE DI ACCESSO!";
            $_SESSION['text'] = "Non puoi accedere a questa pagina";
            $_SESSION['icon'] = "error";
            header("location: index.php");
        }

        $result = mysqli_query(connDB(), "SELECT `Token`,`IdUtente_FK` FROM `reset_password` WHERE `Token` = '$token' AND `IdUtente_FK` = $idUser;");
        if(!mysqli_fetch_array($result)){
            $_SESSION['title'] = "La richiesta è scaduta!";
            $_SESSION['text'] = "Prova a effettuare un nuovo recupero password";
            $_SESSION['icon'] = "error";
            header("location: index.php");
        }
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
                    <input type="hidden" class="form-control" name="datamodule" value="reset_pwd" readonly/>
                    <input type="hidden" class="form-control" name="IdUtente" value="<?=$_GET['id']?>" readonly>
                    <label class="mt-3">Nuova password</label>
                    <input type="password" class="form-control mt-1 mb-0" name="Password" minlength="8" maxlength="16" required>
                    <span class="form-text font-italic">Lunghezza 8-16 caratteri</span>
                    
                    <button class="btn btn-green float-end mt-5" type="submit">Reset password</button>
                </form>
            </div>
        </div>
    </div> 
    <?php include "includes/swal.php"; ?> 
</body>
</html>
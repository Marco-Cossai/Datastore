<meta http-equiv="refresh" content="1800" />
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/'.'database/config.php';       
    connDB();

    /**
    *   session()
    *   Funzione per la gestione della sessione
    */
    function session() {
        $username = $_SESSION['Username'];

        if(time() - $_SESSION['loginTime'] >= 1800) {
            $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
            if(mysqli_fetch_array($result)) {
                foreach($result as $row) {
                    $query = mysqli_query(connDB(),"UPDATE `utenti` SET `Stato` = 0 WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
                    if($query) {
                        $_SESSION['title'] = "Sessione scaduta!";
                        $_SESSION['text'] = "Effettua di nuovo il login";
                        $_SESSION['icon'] = "error";
                        header("location: index.php");
                    }
                }
            }
        } else {
            $_SESSION['loginTime'] = time();
            $_SESSION['LastHourActivity'] = date("H:i");
            
            $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
            if(mysqli_fetch_array($result)) {
                foreach($result as $row) {
                    mysqli_query(connDB(),"UPDATE `utenti` SET `Stato` = 1 WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
                }
            }
        }
    }

    session();
?>
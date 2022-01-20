<?php
require_once '../functions.php';

/**
*   changeStructureDataSoftwareColumn()
*   Questa funzione trasforma in JSON i vecchi dati della colonna "Software" della tabella "computer" nel database
*   E' stata creata questa procedura perchè in precedenza i dati dei vari software si salvavano in formato stringa e non in formato JSON
*/
function changeStructureDataSoftwareColumn() {

    $query = "SELECT `IdComputer`,`Software` FROM `computer`";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        foreach ($result as $row) {
            $arrayTemp = array();
            $nameSoftware = null;
            $id = $row['IdComputer'];
    
            if (strpos($row['Software'],"BackOffice") !== false) {
                $nameSoftware = "BackOffice";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Storesmart") !== false) {
                $nameSoftware = "Storesmart";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Cardsmart") !== false) {
                $nameSoftware = "Cardsmart";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Quadrature") !== false) {
                $nameSoftware = "Quadrature";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Puntimanager") !== false) {
                $nameSoftware = "Puntimanager";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Smartmanager") !== false) {
                $nameSoftware = "Smartmanager";
                $arrayTemp[] = $nameSoftware;
            }
            if (strpos($row['Software'],"Gestock") !== false) {
                $nameSoftware = "Gestock";
                $arrayTemp[] = $nameSoftware;
            }
            $jsonSoftware = json_encode($arrayTemp);
            $queryUpdate = "UPDATE `computer` SET `Software` = '$jsonSoftware' WHERE `IdComputer` = $id";
            mysqli_query(connDB(),$queryUpdate) or die(mysqli_error(connDB()));
        }
        $_SESSION['title'] = "Procedura eseguita!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header("location: ../../procedure.php");
    }

}

/**
*   deleteLogUpdate()
*   Questa procedura cancella i log di modifica.
*   E' stata creata questa procedura perchè in precedenza i dati dei vari log di modifica si salvavano in formato stringa e non in formato JSON.
*/
function deleteLogUpdate() {
    $query = "DELETE FROM `log` WHERE `Operazione` = 2";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Procedura eseguita!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header("location: ../../procedure.php");
    } else {
        $_SESSION['title'] = "Procedura non eseguita!";
        $_SESSION['text'] = "Si è verificato un errore durante l'esecuzione";
        $_SESSION['icon'] = "error";
        header("location: ../../procedure.php");
    }
}

/**
*   dropTablesDataDispenser()
*   Questa procedura cancellerà le tabelle inutilizzate:
*   1. (conv_protocollo)
*   2. (protocollo)
*   3. (testata)
*   4. (tipo_erogatore)
*   5. (versione)
*   E' stata creata questa procedura perchè i vecchi dati contenuti in queste tabelle ora sono contenuti in un'unica tabella.
*/
function dropTablesDataDispenser() {
    $query = "DROP TABLE IF EXISTS `conv_protocollo`,`protocollo`,`testata`,`tipo_erogatore`,`versione`";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Procedura eseguita!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header("location: ../../procedure.php");
    } else {
        $_SESSION['title'] = "Procedura non eseguita!";
        $_SESSION['text'] = "Si è verificato un errore durante l'esecuzione";
        $_SESSION['icon'] = "error";
        header("location: ../../procedure.php");
    }
}
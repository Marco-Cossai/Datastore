<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/'.'database/config.php';    
require_once 'path.php';    
connDB();

/**
*   logIn()
*   Funzione di Login
*/
function logIn() {
    $username = addslashes($_POST['Username']);
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);
    $lastAccess = date("Y-m-d H:i:s");

    $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {

        if(password_verify($password, $row["Password"])) {
            mysqli_query(connDB(),"UPDATE `utenti` SET `LastAccess` = '$lastAccess', `Stato` = 1 WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
            $_SESSION['Username'] = $username;
            $_SESSION['Ruolo'] = $row['Ruolo'];
            $_SESSION['Developer'] = $row['Developer'];
            $_SESSION['loginTime'] = time();
            $_SESSION['LastHourActivity'] = date("H:i");
            header(pathDashboard());
        } else {
            $_SESSION['title'] = "Password errata!";
            $_SESSION['text'] = "Se non la ricordi effettua il recupero password";
            $_SESSION['icon'] = "error";
            header(pathLogIn());
        }

    } else {
        $_SESSION['title'] = "Username errato!";
        $_SESSION['text'] = "Lo username inserito è errato o inesistente";
        $_SESSION['icon'] = "error";
        header(pathLogIn());
    }
}

/**
*   logOut()
*   Funzione di logout
*/
function logOut() {
    $username = $_SESSION['Username'];

    $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {

        $result = mysqli_query(connDB(),"UPDATE `utenti` SET `Stato` = 0 WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
        if($result) {
            header(pathLogIn());
            session_destroy();
        }

    } else {
        $_SESSION['title'] = "FATAL ERROR!";
        $_SESSION['text'] = "Impossibile effettuare il logout";
        $_SESSION['icon'] = "error";
        header(pathDashboard());
    }
}

/**
*   signUp()
*   Funzione di registrazione primo utente
*/
function signUp() {
    //Prelevo i dati dal form
    $name = $_POST['Nome'];
    $surname = addslashes($_POST['Cognome']);
    $sex = $_POST['Sesso'];
    $role = "Administrator";
    $email = $_POST['Email'];
    $username = addslashes($_POST['Username']);
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $lastAccess = "";
    $status = 0;
    $dev = 0;

    //Inserisco l'utente
    $result = mysqli_query(connDB(),"INSERT INTO `utenti` VALUES (0,'$name','$surname','$sex','$role','$email','$username','$password','$lastAccess',$status,$dev)") or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "REGISTRAZIONE EFFETTUATA!";
        $_SESSION['text'] = "Ora puoi effettuare il login";
        $_SESSION['icon'] = "success";
        header(pathLogIn());
    } else {
        $_SESSION['title'] = "FATAL ERROR!";
        $_SESSION['text'] = "Si è verificato un errore nella registrazione";
        $_SESSION['icon'] = "error";
        header(pathSignUp());
    }
}

/**
*   sendmail()
*   Funzione che permette di effettuare il recupero password via email
*/
function sendmail() {
    $email = filter_var(strtolower($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $sender = "DATASTORE MASER";
    $sender_email = "admin.datastore@maseritalia.com";
    $result = mysqli_query(connDB(),"SELECT `Email` FROM `utenti` WHERE `Email` = '$email'") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Impossibile effettuare il recupero!";
        $_SESSION['text'] = "La mail inserita è errata o inesistente!";
        $_SESSION['icon'] = "error";
        header(pathLogIn());
        die();
    } else {

        //Recupero i dati dell'utente
        $result = mysqli_query(connDB(),"SELECT `IdUtente`, `Nome`, `Cognome` FROM `utenti` WHERE `Email` = '$email'") or die (mysqli_error(connDB()));
        $userData = mysqli_fetch_array($result);
        $idUser = $userData['IdUtente'];
        $name = $userData['Nome'];
        $surname = $userData['Cognome'];
        $user = $name." ".$surname;
        
        //Controllo se nella tabella è già stata inviata una richiesta in precedenza da quell'utente. Se si aggiorno la tabella
        $result = mysqli_query(connDB(), "SELECT * FROM `reset_password` WHERE `IdUtente_FK` = $idUser") or die (mysqli_error(connDB()));
        if(mysqli_fetch_array($result)) {

            //Creo un Token
            $rand = bin2hex(openssl_random_pseudo_bytes(32));
            $token = uniqid().$rand;

            //Apporto le modifiche nella tabella
            mysqli_query(connDB(), "UPDATE `reset_password` SET `Token` = '$token', `TimeStamp` = NOW() WHERE `IdUtente_FK` = $idUser") or die(mysqli_error(connDB()));

            //Parametri per l'invio
            $to = $email;
            $subject = "Reset password"." ".$user;
            $message = "Per procedere con il recupero password clicca sul seguente link:\nhttp://datastore.maseritalia.com:81/reset.php?token=$token&id=$idUser\n\nE-mail generata dal sistema, pertanto non rispondere. Se non sei stato tu a richiedere il recupero password contatta un admin.";
            $headers = "From: " .  $sender . " <" .  $sender_email . ">\r\n";
            $headers .= 'MIME-Version: 1.0';
            $headers .= 'Content-type: text/html; charset=utf-8';

            //Invio della mail
            if(mail($to, $subject, $message, $headers)) {
                $_SESSION['title'] = "Ti è stata inviata una mail!";
                $_SESSION['text'] = "Controlla nella posta in arrivo o nello SPAM";
                $_SESSION['icon'] = "success";
                header(pathLogIn());
            } else if(!mail($to, $subject, $message, $headers)) {
                $_SESSION['title'] = "Email non inviata!";
                $_SESSION['text'] = "Si è verificato un problema durante l'invio";
                $_SESSION['icon'] = "error";
                header(pathLogIn());
            }

        } else {
            //altrimenti inserisco la richiesta
            
            //Creo un Token
            $rand = bin2hex(openssl_random_pseudo_bytes(32));
            $token = uniqid().$rand;

            //Aggiungo la mia richiesta nella tabella reset password
            mysqli_query(connDB(),"INSERT INTO `reset_password` VALUES(0,'$token',NOW(),$idUser)") or die(mysqli_error(connDB()));

            //Parametri per l'invio
            $to = $email;
            $subject = "Reset password"." ".$user;
            $message = "Per procedere con il recupero password clicca sul seguente link:\nhttp://datastore.maseritalia.com:81/reset.php?token=$token&id=$idUser\n\nE-mail generata dal sistema, pertanto non rispondere. Se non sei stato tu a richiedere il recupero password contatta un admin.";
            $headers = "From: " .  $sender . " <" .  $sender_email . ">\r\n";
            $headers .= 'MIME-Version: 1.0';
            $headers .= 'Content-type: text/html; charset=utf-8';

            //Invio della mail
            if(mail($to, $subject, $message, $headers)) {
                $_SESSION['title'] = "Ti è stata inviata una mail!";
                $_SESSION['text'] = "Controlla nella posta in arrivo o nello SPAM";
                $_SESSION['icon'] = "success";
                header(pathLogIn());
            } else if(!mail($to, $subject, $message, $headers)) {
                $_SESSION['title'] = "Email non inviata!";
                $_SESSION['text'] = "Si è verificato un problema durante l'invio";
                $_SESSION['icon'] = "error";
                header(pathLogIn());
            }

        }
    }
}

/**
*   resetPWD()
*   Funzione che effettua il reset password
*/
function resetPWD() {
    $idUser = $_POST['IdUtente'];
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = mysqli_query(connDB(),"UPDATE `utenti` SET `Password` = '$password' WHERE `IdUtente` = $idUser") or die (mysqli_error(connDB()));
    if($result) {
        mysqli_query(connDB(), "DELETE FROM `reset_password` WHERE `IdUtente_FK` = $idUser") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Operazione effettuata!";
        $_SESSION['text'] = "Password modificata correttamente. Effettua il login";
        $_SESSION['icon'] = "success";
        header(pathLogIn());
    } else {
        mysqli_query(connDB(), "DELETE FROM `reset_password` WHERE `IdUtente_FK` = $idUser") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Password non modificata!";
        $_SESSION['text'] = "Effettuare una nuova richiesta";
        $_SESSION['icon'] = "error";
        header(pathLogIn());
    }
}

/**
*   newUser()
*   Funzione di inserimento di un nuovo utente
*/
function newUser() {
    //Prelevo i dati dal form
    $name = $_POST['Nome'];
    $surname = addslashes($_POST['Cognome']);
    $sex = $_POST['Sesso'];
    $role = $_POST['Ruolo'];
    $email = $_POST['Email'];
    $username = addslashes($_POST['Username']);
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $lastAccess = "";
    $status = 0;
    $dev = 0;

    //Verifico se esiste già un utente con quello username
    $result = mysqli_query(connDB(), "SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die(mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        if ($username == $row['Username']) {
            $_SESSION['title'] = "Username già esistente!";
            $_SESSION['text'] = "Scegli uno username diverso";
            $_SESSION['icon'] = "warning";
            header(pathUsers());
        }
    } else {
        //Inserisco il nuovo utente
        $result = mysqli_query(connDB(), "INSERT INTO `utenti` VALUES (0,'$name','$surname','$sex','$role','$email','$username','$password','$lastAccess',$status,$dev)") or die(mysqli_error(connDB()));
        if ($result) {
            $_SESSION['title'] = "Utenza creata!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathUsers());
        } else {
            $_SESSION['title'] = "FATAL ERROR!";
            $_SESSION['text'] = "Si è verificato un errore nella creazione";
            $_SESSION['icon'] = "error";
            header(pathUsers());
        }
    }
}

/**
*   deleteUser()
*   Funzione di cancellazione di un utente
*/
function deleteUser() {
    //Prelevo i dati dal form
    $idUserToDelete = $_POST['IdUtente'];
    $username = addslashes($_POST['Username']);
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);
    
    //Qui parte la validazione dei dati per la cancellazione dell'account
    $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        if(password_verify($password, $row["Password"])) {

            //Elimino l'utenza
            $res = mysqli_query(connDB(),"DELETE FROM `utenti` WHERE `IdUtente` = $idUserToDelete") or die (mysqli_error(connDB()));
            if(!mysqli_fetch_array($res)) {
                $_SESSION['title'] = "Utenza eliminata!";
                $_SESSION['text'] = "Operazione andata a buon fine";
                $_SESSION['icon'] = "success";
                header(pathUsers());
            } else {
                $_SESSION['title'] = "Utenza non rimossa!";
                $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
                $_SESSION['icon'] = "error";
                header(pathUsers());
            }

        } else {
            $_SESSION['title'] = "Password errata!";
            $_SESSION['text'] = "La password inserita non è corretta";
            $_SESSION['icon'] = "warning";
            header(pathUsers());
        }
    } else {
        $_SESSION['title'] = "FATAL ERROR!";
        $_SESSION['text'] = "Impossibile continuare l'operazione richiesta";
        $_SESSION['icon'] = "error";
        header(pathUsers());
    }
}

/**
*   updateUser()
*   Funzione di modifica di un utente
*/
function updateUser() {
    //Prelevo i dati dal form
    $id = $_POST['IdUtente'];
    $nome = $_POST['Nome'];
    $cognome = addslashes($_POST['Cognome']);
    $sesso = $_POST['Sesso'];
    $ruolo = $_POST['Ruolo'];
    $email = $_POST['Email'];
    $username = addslashes($_POST['Username']);
    $password = mysqli_real_escape_string(connDB(), $_POST["Password"]);

    if(empty($password)) {
        $query = "UPDATE `utenti` SET `Nome` = '$nome', `Cognome` = '$cognome', `Sesso` = '$sesso', `Ruolo` = '$ruolo', `Email` = '$email', `Username` = '$username' WHERE `idUtente` = $id";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE `utenti` SET `Nome` = '$nome', `Cognome` = '$cognome', `Sesso` = '$sesso', `Ruolo` = '$ruolo', `Email` = '$email', `Username` = '$username', `Password` = '$password' WHERE `IdUtente` = $id";
    }
    
    //Modifico l'utente
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "Utente modificato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathUsers());
    } else {
        $_SESSION['title'] = "FATAL ERROR!";
        $_SESSION['text'] = "Si è verificato un errore nella modifica";
        $_SESSION['icon'] = "error";
        header(pathUsers());
    }
}

/**
*   newCustomer()
*   Funzione di inserimento di un nuovo utente
*/
function newCustomer() {
    //Prelevo i dati dal form
    $businessName = addslashes($_POST['RagioneSociale']);
    $kindCustomer = $_POST['TipoCliente'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Creo il messaggio
    $message = addslashes("E' stato aggiunto il cliente $businessName");
    
    //Controllo se esiste già un cliente con quella ragione sociale
    $result = mysqli_query(connDB(),"SELECT * FROM `clienti` WHERE `RagioneSociale` = '$businessName'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        if ($businessName == $row['RagioneSociale']) {
            $_SESSION['title'] = "Cliente già esistente!";
            $_SESSION['text'] = "";
            $_SESSION['icon'] = "warning";
            header(pathCustomers());
        }
    } else {
        //Inserisco i dati del nuovo cliente
        $result = mysqli_query(connDB(),"INSERT INTO `clienti` VALUES (0,'$businessName','$kindCustomer')") or die (mysqli_error(connDB()));
        if($result) {
            //Inserisco il log
            mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',1,'$currentUser')") or die (mysqli_error(connDB()));
            $_SESSION['title'] = "Cliente inserito!";
            $_SESSION['text'] = "L'operazione è andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathCustomers());  
        } else {
            $_SESSION['title'] = "FATAL ERROR!";
            $_SESSION['text'] = "Si è verificato un errore nell'inserimento";
            $_SESSION['icon'] = "error";
            header(pathCustomers());
        }
    }
}

/**
*   updateCustomer()
*   Funzione di modifica di un cliente
*/
function updateCustomer() {
    //Prelevo i dati dal form
    $businessName = addslashes($_POST['RagioneSociale']);
    $kindCustomer = addslashes($_POST['TipoCliente']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo i vecchi dati dal db
    $idCustomer = $_POST['IdCustomer'];
    $result = mysqli_query(connDB(),"SELECT `RagioneSociale`,`TipoCliente` FROM `clienti` WHERE `IdCliente` = $idCustomer") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $oldBusinessName = addslashes($row['RagioneSociale']);
        $oldKindCustomer = addslashes($row['TipoCliente']);
    }

    //Costruisco il messaggio per il log
    $aryLog = array();
    $aryLog = array('section' => "CLIENTE: ".$oldBusinessName);
    if($oldBusinessName !== $businessName) {
        $aryLog['log'][] = array('field' => "Ragione sociale", 'old' => $oldBusinessName, 'new' => $businessName);
    }
    if($oldKindCustomer !== $kindCustomer) {
        $aryLog['log'][] = array('field' => "Tipologia", 'old' => $oldKindCustomer, 'new' => $kindCustomer);
    }
    $message = addslashes(json_encode($aryLog));

    //Modifico i dati
    $result = mysqli_query(connDB(),"UPDATE `clienti` SET `RagioneSociale` = '$businessName', `TipoCliente` = '$kindCustomer' WHERE `IdCliente` = $idCustomer") or die (mysqli_error(connDB()));
    if ($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',2,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Cliente modificato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathCustomers());
    } else {
        $_SESSION['title'] = "Cliente non modificato!";
        $_SESSION['text'] = "Si è verificato un problema nella modifica";
        $_SESSION['icon'] = "error";
        header(pathCustomers());
    }
}

/**
*   deleteCustomer()
*   Funzione di cancellazione di un cliente
*/
function deleteCustomer() {
    //Prelevo i dati dal form
    $id = $_POST['IdCustomer'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo la ragione sociale del cliente che verrà rimosso
    $result = mysqli_query(connDB(),"SELECT `RagioneSociale` FROM `clienti` WHERE `IdCliente` = $id") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $businessName = $row['RagioneSociale'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato rimosso il cliente $businessName con i relativi impianti");
    
    //Rimuovo il cliente
    $result = mysqli_query(connDB(),"DELETE FROM `clienti` WHERE `IdCliente` = $id") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Cliente eliminato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathCustomers());
    } else {
        $_SESSION['title'] = "Cliente non rimosso!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathCustomers());
    }
}

/**
*   changeAccount()
*   Funzione di modifica dati dell'utente nelle impostazioni dell'account
*/
function changeAccount() {
    //Prelevo i dati dal form

    $id = $_POST['Id'];
    $nome = $_POST['Nome'];
    $cognome = addslashes($_POST['Cognome']);
    $sesso = $_POST['Sesso'];
    $devOptions = "0";
    if(array_key_exists('DevOptions', $_POST)) {
        $devOptions = $_POST['DevOptions'];
    }
    $email = addslashes($_POST['Email']);
    $role = $_POST['Ruolo'];

    //Modifico i dati
    if ($role === 'Administrator') {
        $query = "UPDATE `utenti` SET `Nome` = '$nome', `Cognome` = '$cognome', `Sesso` = '$sesso', `Email` = '$email', `Developer` = $devOptions WHERE `idUtente` = $id";
        $_SESSION['Developer'] = $devOptions;
    } else {
        $query = "UPDATE `utenti` SET `Nome` = '$nome', `Cognome` = '$cognome', `Sesso` = '$sesso' WHERE `idUtente` = $id";
    }

    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "Account aggiornato!";
        $_SESSION['text'] = "Le modifiche al tuo account sono andate a buon fine";
        $_SESSION['icon'] = "success";
        header(pathSettings());
    } else {
        $_SESSION['title'] = "Account non aggiornato!";
        $_SESSION['text'] = "Si è verificato un errore nell'aggiornamento";
        $_SESSION['icon'] = "error";
        header(pathSettings());
    }
}

/**
*   changePassword()
*   Funzione di modifica password dall'utente nelle impostazioni dell'account
*/
function changePassword() {
    //Prelevo i dati dal form
    $username = addslashes($_POST['Username']);
    $oldPassword = mysqli_real_escape_string(connDB(), $_POST["OldPassword"]);
    $newPassword = mysqli_real_escape_string(connDB(), $_POST["NewPassword"]);

    //Controllo se la nuova password coincide con quella vecchia
    if($newPassword == $oldPassword) {
        $_SESSION['title'] = "IMPOSSIBILE MODIFICARE!";
        $_SESSION['text'] = "La nuova password non può essere uguale a quella vecchia";
        $_SESSION['icon'] = "warning";
        header(pathSettings());
    } else {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $result = mysqli_query(connDB(),"SELECT * FROM `utenti` WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
        if ($row = mysqli_fetch_array($result)) {

            //Modifico la password
            if(password_verify($oldPassword, $row["Password"])) {
                mysqli_query(connDB(),"UPDATE `utenti` SET `Password` = '$newPassword', `Stato` = 0 WHERE BINARY `Username` = '$username'") or die (mysqli_error(connDB()));
                $_SESSION['title'] = "PASSWORD CAMBIATA!";
                $_SESSION['text'] = "Effettua di nuovo il login";
                $_SESSION['icon'] = "success";
                header(pathLogIn());
                die();
            } else {
                $_SESSION['title'] = "IMPOSSIBILE MODIFICARE!";
                $_SESSION['text'] = "La vecchia password inserita è errata. Riprovare.";
                $_SESSION['icon'] = "warning";
                header(pathSettings());
            }

        } else {
            $_SESSION['title'] = "FATAL ERROR!";
            $_SESSION['text'] = "Si è verificato un errore nel cambiare la password";
            $_SESSION['icon'] = "error";
            header(pathSettings());
        }
    }
}

/**
*   newPlant()
*   Funzione di aggiunta di un nuovo impianto associato ad un cliente
*/
function newPlant() {
    //Prelevo i dati dal form
    $idCustomer = $_POST['IdCustomer_FK'];
    $namePlant = addslashes($_POST['NomeImpianto']);
    $email = addslashes($_POST['Email']);
    $number = addslashes($_POST['Recapito']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Creo il messaggio
    $message = addslashes("E' stato aggiunto l'impianto $namePlant");
    
    //Verifico nel db se esiste già un impianto con il nome inserito dal form
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `NomeImpianto` = '$namePlant'") or die (mysqli_error(connDB()));
    if(mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Impianto già esistente!";
        $_SESSION['text'] = "Il nome dell'impianto esiste già";
        $_SESSION['icon'] = "warning";
        if (empty($_POST['page'])) {
            header(pathPlants());
        } else {
            header(listPlants($idCustomer));
        }
    } else {
        //Inserisco l'impianto
        $result = mysqli_query(connDB(),"INSERT INTO `impianti` VALUES (0,'$namePlant','$email','$number',$idCustomer)") or die (mysqli_error(connDB()));
        if($result) {
            //Inserisco il log
            mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',1,'$currentUser')") or die (mysqli_error(connDB()));
            $_SESSION['title'] = "Impianto inserito!";
            $_SESSION['text'] = "L'operazione è andata a buon fine";
            $_SESSION['icon'] = "success";
            if (empty($_POST['page'])) {
                header(pathPlants());
            } else {
                header(listPlants($idCustomer));
            }
        } else {
            $_SESSION['title'] = "FATAL ERROR!";
            $_SESSION['text'] = "Si è verificato un errore nell'inserimento";
            $_SESSION['icon'] = "error";
            if (empty($_POST['page'])) {
                header(pathPlants());
            } else {
                header(listPlants($idCustomer));
            }
        }
    }
}

/**
*   updatePlant()
*   Funzione di modifica di un impianto associato ad un cliente
*/
function updatePlant() {
    //Prelevo i dati dal form
    $idPlant = $_POST['IdImpianto'];
    $idCustomer = $_POST['IdCustomer_FK'];
    $namePlant = addslashes($_POST['NomeImpianto']);
    $email = addslashes($_POST['Email']);
    $number = addslashes($_POST['Recapito']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo i vecchi dati dal database
    $result = mysqli_query(connDB(),"SELECT * FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    $oldData = mysqli_fetch_array($result);

    //Costruisco il messaggio per il log
    $aryLog = array();
    $aryLog = array('section' => "IMPIANTO: ".addslashes($oldData['NomeImpianto']));
    if($oldData['NomeImpianto'] !== $namePlant) {
        $aryLog['log'][] = array('field' => "Nome impianto", 'old' => $oldData['NomeImpianto'], 'new' => $namePlant);
    }
    if($oldData['Email'] !== $email) {
        $aryLog['log'][] = array('field' => "Email", 'old' => $oldData['Email'], 'new' => $email);
    }
    if($oldData['Recapito'] !== $number) {
        $aryLog['log'][] = array('field' => "Recapito", 'old' => $oldData['Recapito'], 'new' => $number);
    }
    $message = addslashes(json_encode($aryLog));

    //Modifico i dati
    $result = mysqli_query(connDB(),"UPDATE `impianti` SET `NomeImpianto` = '$namePlant', `Email` = '$email', `Recapito` = '$number' WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',2,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Impianto modificato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        if (empty($_POST['page'])) {
            header(pathPlants());
        } else {
            header(listPlants($idCustomer));
        }
    } else {
        $_SESSION['title'] = "Impianto non modificato!";
        $_SESSION['text'] = "Si è verificato un problema nella modifica";
        $_SESSION['icon'] = "error";
        if (empty($_POST['page'])) {
            header(pathPlants());
        } else {
            header(listPlants($idCustomer));
        }
    }
}

/**
*   deletePlant()
*   Funzione di cancellazione di un impianto
*/
function deletePlant() {
    //Prelevo i dati dal form
    $id = $_POST['IdPlant'];
    $idCustomer = $_POST['IdCustomer'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto che verrà rimosso
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $id") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato rimosso l'impianto $namePlant con i relativi dettagli");

    //Rimuovo l'impianto
    $result = mysqli_query(connDB(),"DELETE FROM `impianti` WHERE `IdImpianto` = $id") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Impianto eliminato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        if (empty($_POST['page'])) {
            header(pathPlants());
        } else {
            header(listPlants($idCustomer));
        }
    } else {
        $_SESSION['title'] = "Impianto non rimosso!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        if (empty($_POST['page'])) {
            header(pathPlants());
        } else {
            header(listPlants($idCustomer));
        }
    }
}

/**
*   migrationPlant()
*   Funzione che migra un impianto da un cliente a un altro
*/
function migrationPlant() {
    $idPlant = $_POST['IdPlant_FK'];
    $idOldCustomer = $_POST['IdOldCustomer_FK'];
    $idNewCustomer = $_POST['IdCustomer_FK'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Prelevo la ragione sociale del vecchio cliente
    $result = mysqli_query(connDB(),"SELECT `RagioneSociale` FROM `clienti` WHERE `IdCliente` = $idOldCustomer") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $oldBusinessName = $row['RagioneSociale'];
    }

    //Prelevo la ragione sociale del nuovo cliente
    $result = mysqli_query(connDB(),"SELECT `RagioneSociale` FROM `clienti` WHERE `IdCliente` = $idNewCustomer") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $newBusinessName = $row['RagioneSociale'];
    }

    $message = addslashes("L'impianto $namePlant è migrato da $oldBusinessName a $newBusinessName");

    //Modifico i dati
    $query = "UPDATE `impianti` SET `IdCliente_FK` = $idNewCustomer WHERE `IdImpianto` = $idPlant";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',4,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Migrazione completata!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathPlants());
    } else {
        $_SESSION['title'] = "Migrazione non completata!";
        $_SESSION['text'] = "Si è verificato un problema nella migrazione";
        $_SESSION['icon'] = "error";
        header(pathPlants());
    }
}

/**
*   newPC()
*   Funzione di inserimento postazione a un impianto
*/
function newPC() {
    //Prelevo i dati dal form
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $number = addslashes($_POST['Matricola']);
    $model = addslashes($_POST['Modello']);
    $platform = addslashes($_POST['Architettura']);
    $snPC =  addslashes($_POST['SerialePC']);
    $software = json_encode($_POST['Software']);
    $printer = addslashes($_POST['Stampante']);
    $PBL = addslashes($_POST['PBL']);
    $router = addslashes($_POST['TipoRouter']);
    $snRouter = addslashes($_POST['SerialeRouter']);
    $IP = addslashes($_POST['IndirizzoIP']);
    $anydesk = addslashes($_POST['Anydesk']);
    if (!empty($PBL)) {
        $ticket = "https://maseritalia.atlassian.net/issues/?jql=cf%5B10037%5D%20%3D%20%22PBL".$PBL."%22";
    } else {
        $ticket = "";
    }
    $note = addslashes($_POST['Note']);
    $data = $_POST['DataCompilazione'];
    $compiler = addslashes($_POST['Compilatore']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stata aggiunta la sezione pc all'impianto $namePlant");

    //Controllo se esiste già una postazione con questi parametri
    $result = mysqli_query(connDB(),"SELECT `Matricola`,`SerialePC` FROM `computer` WHERE `Matricola` = '$number' OR `SerialePC` = '$snPC'") or die (mysqli_error(connDB()));
    if(mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Postazione già esistente!";
        $_SESSION['text'] = "Non sono ammessi valori duplicati";
        $_SESSION['icon'] = "warning";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        //Inserisco la postazione
        mysqli_query(connDB(),"INSERT INTO `computer` VALUES (0,'$number','$model','$platform','$snPC','$software','$printer','$PBL','$router','$snRouter','$IP','$anydesk','$ticket','$note','$data','$compiler',$idPlant_FK)") or die (mysqli_error(connDB()));
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',1,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Postazione creata!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   updatePC()
*   Funzione di modifica postazione a un impianto
*/
function updatePC() {
    //Prelevo i dati dal form
    $id = $_POST['id'];
    $idPlant_FK = $_POST['IdImpianto_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $number = addslashes($_POST['Matricola']);
    $model = addslashes($_POST['Modello']);
    $platform = addslashes($_POST['Architettura']);
    $snPC =  addslashes($_POST['SerialePC']);
    $software = json_encode($_POST['Software']);
    $printer = addslashes($_POST['Stampante']);
    $PBL = addslashes($_POST['PBL']);
    $router = addslashes($_POST['TipoRouter']);
    $snRouter = addslashes($_POST['SerialeRouter']);
    $IP = addslashes($_POST['IndirizzoIP']);
    $anydesk = addslashes($_POST['Anydesk']);
    if (!empty($PBL)) {
        $ticket = "https://maseritalia.atlassian.net/issues/?jql=cf%5B10037%5D%20%3D%20%22PBL".$PBL."%22";
    } else {
        $ticket = "";
    }
    $note = addslashes($_POST['Note']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $namePlant = addslashes($row['NomeImpianto']);
    }

    //Prendo i vecchi dati dal database
    $result = mysqli_query(connDB(),"SELECT * FROM `computer` WHERE `IdComputer`= $id") or die (mysqli_error(connDB()));
    $oldData = mysqli_fetch_array($result);
    

    //Inizio a costruire il messaggio di log
    $aryLog = array();
    $aryLog = array('section' => "IMPIANTO: ".$namePlant);
    if($oldData['Matricola'] !== $number) {
        $aryLog['log'][] = array('field' => "Matricola", 'old' => $oldData['Matricola'], 'new' => $number);
    }
    if($oldData['ModelloPC'] !== $model) {
        $aryLog['log'][] = array('field' => "Modello PC", 'old' => $oldData['ModelloPC'], 'new' => $model);
    }
    if($oldData['Architettura'] !== $platform) {
        $aryLog['log'][] = array('field' => "Architettura", 'old' => $oldData['Architettura'], 'new' => $platform);
    }
    if($oldData['SerialePC'] !== $snPC) {
        $aryLog['log'][] = array('field' => "SN-PC", 'old' => $oldData['SerialePC'], 'new' => $snPC);
    }

    //Gestione particolare per i software
    $arraySoftware = json_decode($software,true);
    $arrayOldSoftware = json_decode($oldData['Software']);
    $strOldSoftware = "";
    foreach ($arraySoftware as $value) {
        if (strpos($oldData['Software'],$value) === false) {
            $difference = $value;
        }
    }
    foreach ($arrayOldSoftware as $value) {
        $strOldSoftware .= $value . ", ";
    }
    if (!empty($difference)) {
        $aryLog['log'][] = array('field' => "SOFTWARE", 'old' => substr($strOldSoftware,0,strlen($strOldSoftware)-2), 'new' => $strOldSoftware.$difference);
    }

    if($oldData['Stampante'] !== $printer) {
        $aryLog['log'][] = array('field' => "Stampante", 'old' => $oldData['Stampante'], 'new' => $printer);
    }
    if($oldData['PBL'] != $PBL) {
        $aryLog['log'][] = array('field' => "PBL", 'old' => $oldData['PBL'], 'new' => $PBL);
    }
    if($oldData['TipoRouter'] !== $router) {
        $aryLog['log'][] = array('field' => "Router", 'old' => $oldData['TipoRouter'], 'new' => $router);
    }
    if($oldData['SerialeRouter'] !== $snRouter) {
        $aryLog['log'][] = array('field' => "SN-ROUTER", 'old' => $oldData['SerialeRouter'], 'new' => $snRouter);
    }
    if($oldData['IP'] !== $IP) {
        $aryLog['log'][] = array('field' => "IP", 'old' => $oldData['IP'], 'new' => $IP);
    }
    if($oldData['Anydesk'] !== $anydesk) {
        $aryLog['log'][] = array('field' => "Anydesk", 'old' => $oldData['Anydesk'], 'new' => $anydesk);
    }
    if($oldData['Note'] !== $note) {
        $aryLog['log'][] = array('field' => "Note", 'old' => $oldData['Note'], 'new' => $note);
    }
    $message = addslashes(json_encode($aryLog));

    //Modifico i dati
    $query = "UPDATE `computer` SET `Matricola` = '$number', `ModelloPC` = '$model', `Architettura` = '$platform', `SerialePC` = '$snPC', `Software` = '$software', `Stampante` = '$printer', `PBL` = '$PBL', `TipoRouter` = '$router', `SerialeRouter` = '$snRouter', `IP` = '$IP', `Anydesk` = '$anydesk', `Ticket` = '$ticket', `Note` = '$note' WHERE `IdComputer` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if($result) {
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',2,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Postazione modificata!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "Postazione non modificata!";
        $_SESSION['text'] = "Si è verificato un problema nella modifica dei dati";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   deletePC()
*   Funzione di cancellazione di una postazione pc
*/
function deletePC() {
    //Prelevo i dati dal form
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $dataLog = date("d/m/Y - H:i:s");
    
    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto che verrà rimosso
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stata eliminata la postazione pc dell'impianto $namePlant");

    //Rimuovo il computer
    $result = mysqli_query(connDB(),"DELETE FROM `computer` WHERE `IdImpianto_FK` = $idPlant_FK") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Cancello la richiesta
        mysqli_query(connDB(),"DELETE FROM `richieste_append` WHERE `IdImpianto_FK` = $idPlant_FK AND `TabellaRichiesta` = 'computer'") or die (mysqli_error(connDB()));
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Postazione eliminata!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "Postazione non rimossa!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   newMAC()
*   Funzione di inserimento di un MAC a un impianto
*/
function newMAC() {
    //Prelevo i dati dal form
    $idPlant = $_POST['IdPlant_FK'];
    $idCustomer = $_POST['IdCustomer_FK'];
    $name = addslashes($_POST['Nome']);
    $number = addslashes($_POST['Matricola']);
    $model = addslashes($_POST['Modello']);
    $pinpad = addslashes($_POST['Pinpad']);
    $cpu = addslashes($_POST['CPU']);
    $printer = addslashes($_POST['Stampante']);
    $reader = addslashes($_POST['Lettore']);
    //COSM #06 - Aggiunta colonna per salvataggio indirizzo IP
    $IP = addslashes($_POST['IP']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato aggiunto $name all'impianto $namePlant");

    //Controllo se esiste già un MAC con la matricola inserita
    $result = mysqli_query(connDB(),"SELECT `Matricola` FROM `mac` WHERE `Matricola` = '$number'") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        if((!empty($row['Matricola']) || $row['Matricola'] !== NULL) && $number == $row['Matricola']){
            $_SESSION['title'] = "MAC ESISTENTE!";
            $_SESSION['text'] = "Esiste già un MAC con matricola $number";
            $_SESSION['icon'] = "warning";
            header(pathDetails($idPlant,$idCustomer));
        }
    } else {
        //Inserisco MAC
        //COSM #06 - Aggiunta colonna per salvataggio indirizzo IP
        mysqli_query(connDB(),"INSERT INTO `mac` VALUES (0,'$name','$number','$model','$pinpad','$cpu','$printer','$reader','$IP',$idPlant)") or die (mysqli_error(connDB()));
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',1,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "MAC inserito!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant,$idCustomer));
    }
}

/**
*   updateMAC()
*   Funzione di modifica di un MAC a un impianto
*/
function updateMAC() {
    //Prelevo i dati dal form
    $id = $_POST['Id'];
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $name = addslashes($_POST['Nome']);
    $number = addslashes($_POST['Matricola']);
    $model = addslashes($_POST['Modello']);
    $pinpad = addslashes($_POST['Pinpad']);
    $cpu = addslashes($_POST['CPU']);
    $printer = addslashes($_POST['Stampante']);
    $reader = addslashes($_POST['Lettore']);
    //COSM #06 - Aggiunta colonna per salvataggio indirizzo IP
    $IP = addslashes($_POST['IP']);
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = addslashes($row['NomeImpianto']);
    }

    //Prelevo i vecchi dati dal db
    $result = mysqli_query(connDB(),"SELECT * FROM `mac` WHERE `IdMac` = $id") or die (mysqli_error(connDB()));
    $oldData = mysqli_fetch_array($result);

    //Costruisco il messaggio per il log
    $aryLog = array();
    $aryLog = array('section' => "IMPIANTO: ".$namePlant);
    if ($oldData['Nome'] !== $name) {
        $aryLog['log'][] = array('field' => "Nome MAC", 'old' => $oldData['Nome'], 'new' => $name);
    }
    if ($oldData['Matricola'] !== $number) {
        $aryLog['log'][] = array('field' => "Matricola", 'old' => $oldData['Matricola'], 'new' => $number);
    }
    if ($oldData['Modello'] !== $model) {
        $aryLog['log'][] = array('field' => "Modello MAC", 'old' => $oldData['Modello'], 'new' => $model);
    }
    if ($oldData['Pinpad'] !== $pinpad) {
        $aryLog['log'][] = array('field' => "Pinpad", 'old' => $oldData['Pinpad'], 'new' => $pinpad);
    }
    if ($oldData['CPU'] !== $cpu) {
        $aryLog['log'][] = array('field' => "CPU", 'old' => $oldData['CPU'], 'new' => $cpu);
    }
    if ($oldData['Stampante'] !== $printer) {
        $aryLog['log'][] = array('field' => "Stampante", 'old' => $oldData['Stampante'], 'new' => $printer);
    }
    if ($oldData['Lettore'] !== $reader) {
        $aryLog['log'][] = array('field' => "Lettore", 'old' => $oldData['Lettore'], 'new' => $reader);
    }
    //COSM #06 - Aggiunta colonna per salvataggio indirizzo IP
    if ($oldData['IndirizzoIP'] !== $IP) {
        $aryLog['log'][] = array('field' => "IP", 'old' => $oldData['IndirizzoIP'], 'new' => $IP);
    }
    $message = addslashes(json_encode($aryLog));

    //Modifico i dati
    //COSM #06 - Aggiunta colonna per salvataggio indirizzo IP
    $query = "UPDATE `mac` SET `Nome` ='$name', `Matricola` = '$number', `Modello` = '$model', `Pinpad`= '$pinpad', `CPU` = '$cpu', `Stampante` = '$printer', `Lettore` = '$reader', `IndirizzoIP` = '$IP' WHERE `IdMac` = $id";
    $result = mysqli_query(connDB(),$query)or die (mysqli_error(connDB()));
    if($result) {
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',2,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "MAC modificato!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "MAC non modificato!";
        $_SESSION['text'] = "Si è verificato un problema nella modifica";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }

}

/**
*   deleteMAC()
*   Funzione di cancellazione di un MAC a un impianto
*/
function deleteMAC() {
    //Prelevo i dati dal form
    $id = $_POST['Id'];
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato eliminato un MAC dall'impianto $namePlant");

    //Cancello un singolo MAC
    $query = "DELETE FROM `mac` WHERE `IdMac` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "MAC eliminato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "MAC non cancellato!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   deleteAllMAC()
*   Funzione di cancellazione di tutti i MAC a un impianto
*/
function deleteAllMAC() {
    //Prelevo i dati dal form
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("Sono stati eliminati tutti i MAC dall'impianto $namePlant");

    //Cancello tutti i MAC
    $result = mysqli_query(connDB(),"DELETE FROM `mac` WHERE `IdImpianto_FK` = $idPlant_FK") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Cancello la richiesta
        mysqli_query(connDB(),"DELETE FROM `richieste_append` WHERE `IdImpianto_FK` = $idPlant_FK AND `TabellaRichiesta` = 'mac'") or die (mysqli_error(connDB()));
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Ho eliminato tutti i MAC!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "MAC non cancellati!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   newDispenser()
*   Funzione di inserimento di un erogatore associato a un MAC di un impianto
*/
function newDispenser() {
    //Prelevo i dati dal form
    $idMAC = $_POST['IdMac_FK'];
    $idPlant = $_POST['IdPlant_FK'];
    $idCustomer = $_POST['IdCustomer_FK'];
    $dispenserType = addslashes($_POST['TipoErogatore']);
    $protocolConverter = addslashes($_POST['ConvProtocollo']);
    $protocol = addslashes($_POST['Protocollo']);
    $header = addslashes($_POST['Testata']);
    $version = addslashes($_POST['Versione']);
    $gasPump = $_POST['Pistole'];
    $side = $_POST['Lato'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato aggiunto un erogatore all'impianto $namePlant");
    
    //Inserisco l'erogatore
    $result = mysqli_query(connDB(),"INSERT INTO `erogatori` VALUES (0,'$dispenserType','$protocolConverter','$protocol','$header','$version',$gasPump,$side,$idMAC,$idPlant)") or die (mysqli_error(connDB()));
    if($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',1,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Erogatore inserito!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant,$idCustomer)); 
    } else {
        $_SESSION['title'] = "Erogatore non inserito!";
        $_SESSION['text'] = "Si è verificato un errore nell'inserimento";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant,$idCustomer));
    }
}

/**
*   updateDispenser()
*   Funzione di modifica di un erogatore associato a un MAC di un impianto
*/
function updateDispenser() {
    //Prelevo i dati dal form
    $id = $_POST['Id'];
    $idMAC = $_POST['IdMac_FK'];
    $idPlant = $_POST['IdPlant_FK'];
    $idCustomer = $_POST['IdCustomer_FK'];
    $dispenserType = addslashes($_POST['TipoErogatore']);
    $protocolConverter = addslashes($_POST['ConvProtocollo']);
    $protocol = addslashes($_POST['Protocollo']);
    $header = addslashes($_POST['Testata']);
    $version = addslashes($_POST['Versione']);
    $gasPump = $_POST['Pistole'];
    $side = $_POST['Lato'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i vecchi dati dal db
    $result = mysqli_query(connDB(),"SELECT * FROM `erogatori` WHERE `IdErogatore` = $id") or die (mysqli_error(connDB()));
    $oldData = mysqli_fetch_array($result);

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = addslashes($row['NomeImpianto']);
    }
    
    //Costruisco il messaggio per il log
    $aryLog = array();
    $aryLog = array('section' => "IMPIANTO: ".$namePlant);
    if($oldData['TipoErogatore'] !== $dispenserType) {
        $aryLog['log'][] = array('field' => "Tipo erogatore", 'old' => $oldData['TipoErogatore'], 'new' => $dispenserType);
    }
    if($oldData['ConvProtocollo'] !== $protocolConverter) {
        $aryLog['log'][] = array('field' => "Conv. protocollo", 'old' => $oldData['ConvProtocollo'], 'new' => $protocolConverter);
    }
    if($oldData['Protocollo'] !== $protocol) {
        $aryLog['log'][] = array('field' => "Protocollo", 'old' => $oldData['Protocollo'], 'new' => $protocol);
    }
    if($oldData['Testata'] !== $header) {
        $aryLog['log'][] = array('field' => "Testata", 'old' => $oldData['Testata'], 'new' => $header);
    }
    if($oldData['Versione'] !== $version) {
        $aryLog['log'][] = array('field' => "Versione", 'old' => $oldData['Versione'], 'new' => $version);
    }
    if($oldData['Pistole'] != $gasPump) {
        $aryLog['log'][] = array('field' => "Pistole", 'old' => $oldData['Pistole'], 'new' => $gasPump);
    }
    if($oldData['Lato'] != $side) {
        $aryLog['log'][] = array('field' => "Lato", 'old' => $oldData['Lato'], 'new' => $side);
    }
    $message = addslashes(json_encode($aryLog));

    //Modifico i dati
    $query = "UPDATE `erogatori` SET `TipoErogatore` = '$dispenserType', `ConvProtocollo` = '$protocolConverter', `Protocollo` = '$protocol', `Testata` = '$header', `Versione` = '$version', `Pistole` = $gasPump, `Lato` = $side WHERE `IdErogatore` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if($result) {
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',2,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Erogatore modificato!";
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant,$idCustomer));
    } else {
        $_SESSION['title'] = "Erogatore non modificato!";
        $_SESSION['text'] = "Si è verificato un problema nella modifica";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant,$idCustomer));
    }
}

/**
*   deleteDispenser()
*   Funzione di cancellazione di un erogatore associato a un MAC di un impianto
*/
function deleteDispenser() {
    //Prelevo i dati dal form
    $id = $_POST['Id'];
    $idPlant = $_POST['IdPlant_FK'];
    $idCustomer = $_POST['IdCustomer_FK'];
    $dataLog = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = $row['NomeImpianto'];
    }

    //Creo il messaggio
    $message = addslashes("E' stato eliminato un erogatore dall'impianto $namePlant");

    //Cancello un singolo erogatore
    $query = "DELETE FROM `erogatori` WHERE `IdErogatore` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$dataLog','$message',3,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Erogatore eliminato!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant,$idCustomer));
    } else {
        $_SESSION['title'] = "Erogatore non cancellato!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant,$idCustomer));
    }
}

/**
*   requestDeletePC()
*   Funzione che invia una richiesta di cancellazione di una postazione pc 
*   a tutti gli admin registrati, che dovranno poi approvare o rifiutare tale richiesta
*/
function requestDeletePC() {
    //Prelevo i dati dal form
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $data = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto che verrà rimosso
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = addslashes($row['NomeImpianto']);
    }

    //Creo il messaggio di log
    $message = addslashes("E' stata inviata richiesta di cancellazione della postazione PC dell'impianto $namePlant");

    //Creo la richiesta
    $request = addslashes("Richiesta di cancellazione della postazione");

    //Inserisco la richiesta
    $result = mysqli_query(connDB(),"INSERT INTO `richieste_append` VALUES(0,'$data','$request','$namePlant','$currentUser','computer',$idPlant_FK,$idCustomer_FK)") or die (mysqli_error(connDB()));
    if ($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$data','$message',5,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Richiesta effettuata!";
        $_SESSION['text'] = "Un admin prenderà in carico la richiesta";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "Richiesta non effettuata!";
        $_SESSION['text'] = "Si è verificato un errore durante l'invio";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   requestDeleteAllMAC()
*   Funzione che invia una richiesta di cancellazione di tutti i MAC 
*   a tutti gli admin registrati, che dovranno poi approvare o rifiutare tale richiesta
*/
function requestDeleteAllMAC() {
    //Prelevo i dati dal form
    $idPlant_FK = $_POST['IdPlant_FK'];
    $idCustomer_FK = $_POST['IdCustomer_FK'];
    $data = date("d/m/Y - H:i:s");

    //Prelevo i dati dell'utente
    $usernameSession = $_SESSION['Username'];
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$usernameSession'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Prelevo il nome dell'impianto
    $result = mysqli_query(connDB(),"SELECT `NomeImpianto` FROM `impianti` WHERE `IdImpianto` = $idPlant_FK") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $namePlant = addslashes($row['NomeImpianto']);
    }

    //Creo il messaggio di log
    $message = addslashes("E' stata inviata richiesta di cancellazione di tutti i MAC dell'impianto $namePlant");

    //Creo la richiesta
    $request = addslashes("Richiesta di cancellazione dei MAC");

    //Inserisco la richiesta
    $result = mysqli_query(connDB(),"INSERT INTO `richieste_append` VALUES(0,'$data','$request','$namePlant','$currentUser','mac',$idPlant_FK,$idCustomer_FK)") or die (mysqli_error(connDB()));
    if ($result) {
        //Inserisco il log
        mysqli_query(connDB(),"INSERT INTO `log` VALUES (0,'$data','$message',5,'$currentUser')") or die (mysqli_error(connDB()));
        $_SESSION['title'] = "Richiesta effettuata!";
        $_SESSION['text'] = "Un admin prenderà in carico la richiesta";
        $_SESSION['icon'] = "success";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    } else {
        $_SESSION['title'] = "Richiesta non effettuata!";
        $_SESSION['text'] = "Si è verificato un errore durante l'invio";
        $_SESSION['icon'] = "error";
        header(pathDetails($idPlant_FK,$idCustomer_FK));
    }
}

/**
*   deleteRequest()
*   Funzione che cancella una richiesta in sospeso
*/
function deleteRequest() {
    //Prelevo i dati dal form
    $id = $_POST['IdRequest'];
    $idPlant = $_POST['IdPlant_FK'];

    //Cancello la richiesta
    $result = mysqli_query(connDB(),"DELETE FROM `richieste_append` WHERE `IdRichiesta` = $id") or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Richiesta rifiutata!";
        $_SESSION['text'] = "La richiesta fatta dall'operatore è stata ignorata";
        $_SESSION['icon'] = "success";
        header(pathPendingRequests());
    } else {
        $_SESSION['title'] = "Impossibile eliminare!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione della richiesta";
        $_SESSION['icon'] = "error";
        header(pathPendingRequests());
    }
}

/**
*   clearRequests()
*   Funzione che cancella tutte le richieste in sospeso
*/
function clearRequests() {
    $result = mysqli_query(connDB(),"TRUNCATE TABLE `richieste_append`") or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "Richieste rifiutate";
        $_SESSION['text'] = "Tutte le richieste sono state rifiutate";
        $_SESSION['icon'] = "success";
        header(pathPendingRequests());
    } else {
        $_SESSION['title'] = "Impossibile eliminare!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathPendingRequests());
    }
}

/**
*   newDataDispenser()
*   Funzione che inserisce dati inerenti agli erogatori, tra cui:
*   1.  Tipo erogatore
*   2.  Testata
*   3.  Protocollo  
*   4.  Convertitore di protocollo
*   5.  Versione
*/
function newDataDispenser() {
    $name = addslashes($_POST['Nome']);
    $type = addslashes($_POST['Tipologia']);

    $query = "SELECT * FROM `dati_erogatori` WHERE `Nome` = '$name' AND `Tipologia` = '$type'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "$type già esistente!";
        $_SESSION['text'] = "Prova con un nome diverso";
        $_SESSION['icon'] = "error";
        header(pathOperations());
    } else {
        $query = "INSERT INTO `dati_erogatori` VALUES (0,'$name','$type')";
        mysqli_query(connDB(),$query);
        if ($type == 'Testata' || $type == 'Versione') {
            $_SESSION['title'] = "$type inserita!";
        } else {
            $_SESSION['title'] = "$type inserito!";
        }
        $_SESSION['text'] = "L'operazione è andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathOperations());
    }
}

/**
*   updateDataDispenser()
*   Funzione che modifica i dati inerenti agli erogatori
*/
function updateDataDispenser() {
    $id = $_POST['Id'];
    $name = addslashes($_POST['Nome']);
    $type = addslashes($_POST['Tipologia']);

    $query = "SELECT * FROM `dati_erogatori` WHERE `Nome` = '$name' AND `Tipologia` = '$type'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "$type già esistente!";
        $_SESSION['text'] = "Prova con un nome diverso";
        $_SESSION['icon'] = "error";
        header(pathOperations());
    } else {
        $query = "UPDATE `dati_erogatori` SET `Nome` = '$name', `Tipologia` = '$type' WHERE `Id` = $id";
        $result = mysqli_query(connDB(),$query);
        if ($result) {
            if ($type == 'Testata' || $type == 'Versione') {
                $_SESSION['title'] = "$type modificata!";
            } else {
                $_SESSION['title'] = "$type modificato!";
            }
            $_SESSION['text'] = "L'operazione è andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathOperations());
        } else {
            if ($type == 'Testata' || $type == 'Versione') {
                $_SESSION['title'] = "$type non modificata!";
            } else {
                $_SESSION['title'] = "$type non modificato!";
            }
            $_SESSION['text'] = "Si è verificato un problema nella modifica";
            $_SESSION['icon'] = "error";
            header(pathOperations());
        }
    }
}

/**
*   deleteDataDispenser()
*   Funzione che elimina un singolo dato inerente agli erogatori
*/
function deleteDataDispenser() {
    $id = $_POST['Id'];
    $type = addslashes($_POST['Tipologia']);

    $query = "DELETE FROM `dati_erogatori` WHERE `Id` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        if ($type == 'Testata' || $type == 'Versione') {
            $_SESSION['title'] = "$type eliminata!";
        } else {
            $_SESSION['title'] = "$type eliminato!";
        }
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathOperations());
    } else {
        $_SESSION['title'] = "Impossibile eliminare!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathOperations());
    }
}

/**
*   clearDataDispenser()
*   Funzione che cancella tutti i dati inerente agli erogatori in base ad un filtro
*/
function clearDataDispenser() {
    $filter = addslashes($_POST['Filter']);
    
    if ($filter == 'All') {

        $result = mysqli_query(connDB(),"TRUNCATE TABLE `dati_erogatori`") or die (mysqli_error(connDB()));
        if($result) {
            $_SESSION['title'] = "Dati eliminati!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathOperations());
        } else {
            $_SESSION['title'] = "Impossibile eliminare!";
            $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
            $_SESSION['icon'] = "error";
            header(pathOperations());
        }

    } else {

        $query = "SELECT * FROM `dati_erogatori` WHERE `Tipologia` = '$filter'";
        $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
        if (mysqli_fetch_array($result)) {

            $query = "DELETE FROM `dati_erogatori` WHERE `Tipologia` = '$filter'";
            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
            if(!mysqli_fetch_array($result)) {
                $_SESSION['title'] = "Pulizia effettuata";
                $_SESSION['text'] = "Ho pulito le righe con la tipologia $filter";
                $_SESSION['icon'] = "success";
                header(pathOperations());
            } else {
                $_SESSION['title'] = "Impossibile eliminare!";
                $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
                $_SESSION['icon'] = "error";
                header(pathOperations());
            }

        } else {
            $_SESSION['title'] = "Non ci sono dati da pulire!";
            $_SESSION['text'] = "Non ho trovato dati con il filtro $filter";
            $_SESSION['icon'] = "warning";
            header(pathOperations());
        }
    }
    
}

/**
*   newCTE()
*   Funzione che inserisce una nuova configurazione in base al tipo erogatore
*/
function newCTE() {
    $name = addslashes($_POST['TipoErogatore']);
    $header = addslashes($_POST['Testata']);
    $protocol = addslashes($_POST['Protocollo']);

    $query = "SELECT * FROM `union_tipo_erogatore` WHERE `TipoErogatore` = '$name' AND `Testata` = '$header' AND `Protocollo` = '$protocol'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione esistente!";
        $_SESSION['text'] = "Creare una configurazione diversa";
        $_SESSION['icon'] = "warning";
        header(pathConfigurations());
    } else {
        $result = mysqli_query(connDB(),"INSERT INTO `union_tipo_erogatore` VALUES (0,'$name', '$header', '$protocol')") or die (mysqli_error(connDB()));
        if(!mysqli_fetch_array($result)) {
            $_SESSION['title'] = "Configurazione creata!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathConfigurations());  
        } else {
            $_SESSION['title'] = "Configurazione non creata!";
            $_SESSION['text'] = "Si è verificato un errore nella creazione";
            $_SESSION['icon'] = "error";
            header(pathConfigurations());
        }
    }
}

/**
*   updateCTE()
*   Funzione che modifica una configurazione in base al tipo erogatore
*/
function updateCTE() {
    $id = $_POST['Id'];
    $name = addslashes($_POST['TipoErogatore']);
    $header = addslashes($_POST['Testata']);
    $protocol = addslashes($_POST['Protocollo']);

    $query = "SELECT * FROM `union_tipo_erogatore` WHERE `TipoErogatore` = '$name' AND `Testata` = '$header' AND `Protocollo` = '$protocol'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione esistente!";
        $_SESSION['text'] = "Creare una configurazione diversa";
        $_SESSION['icon'] = "warning";
        header(pathConfigurations());
    } else {
        $query = "UPDATE `union_tipo_erogatore` SET `TipoErogatore` = '$name', `Testata` = '$header', `Protocollo` = '$protocol' WHERE `Id` = $id";
        $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
        if(!mysqli_fetch_array($result)) {
            $_SESSION['title'] = "Configurazione modificata!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathConfigurations());  
        } else {
            $_SESSION['title'] = "Configurazione non modificata!";
            $_SESSION['text'] = "Si è verificato un errore nella modifica";
            $_SESSION['icon'] = "error";
            header(pathConfigurations());
        }
    }
}

/**
*   deleteCTE()
*   Funzione che cancella una configurazione in base al tipo erogatore
*/
function deleteCTE() {
    $id = $_POST['Id'];

    $query = "DELETE FROM `union_tipo_erogatore` WHERE `Id` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione eliminata!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathConfigurations());
    } else {
        $_SESSION['title'] = "Configurazione non eliminata!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathConfigurations());
    }
}

/**
*   clearCTE()
*   Funzione che cancella tutte le configurazioni in base ai tipo erogatore
*/
function clearCTE() {
    $result = mysqli_query(connDB(),"TRUNCATE TABLE `union_tipo_erogatore`") or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "Configurazioni cancellate";
        $_SESSION['text'] = "Tutte le configurazioni sono state cancellate";
        $_SESSION['icon'] = "success";
        header(pathConfigurations());
    } else {
        $_SESSION['title'] = "Impossibile eliminare!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathConfigurations());
    }
}

/**
*   newCCP()
*   Funzione che inserisce una nuova configurazione in base al convertitore di protocollo
*/
function newCCP() {
    $name = addslashes($_POST['ConvProtocollo']);
    $version = addslashes($_POST['Versione']);

    $query = "SELECT * FROM `union_convert_protocollo` WHERE `ConvProtocollo` = '$name' AND `Versione` = '$version'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione esistente!";
        $_SESSION['text'] = "Creare una configurazione diversa";
        $_SESSION['icon'] = "warning";
        header(pathConfigurations());
    } else {
        $result = mysqli_query(connDB(),"INSERT INTO `union_convert_protocollo` VALUES (0,'$name', '$version')") or die (mysqli_error(connDB()));
        if(!mysqli_fetch_array($result)) {
            $_SESSION['title'] = "Configurazione creata!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathConfigurations());  
        } else {
            $_SESSION['title'] = "Configurazione non creata!";
            $_SESSION['text'] = "Si è verificato un errore nella creazione";
            $_SESSION['icon'] = "error";
            header(pathConfigurations());
        }
    }
}

/**
*   updateCCP()
*   Funzione che modifica una configurazione in base al convertitore di protocollo
*/
function updateCCP() {
    $id = $_POST['Id'];
    $name = addslashes($_POST['ConvProtocollo']);
    $version = addslashes($_POST['Versione']);

    $query = "SELECT * FROM `union_convert_protocollo` WHERE `ConvProtocollo` = '$name' AND `Versione` = '$version'";
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione esistente!";
        $_SESSION['text'] = "Creare una configurazione diversa";
        $_SESSION['icon'] = "warning";
        header(pathConfigurations());
    } else {
        $query = "UPDATE `union_convert_protocollo` SET `ConvProtocollo` = '$name', `Versione` = '$version' WHERE `Id` = $id";
        $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
        if(!mysqli_fetch_array($result)) {
            $_SESSION['title'] = "Configurazione modificata!";
            $_SESSION['text'] = "Operazione andata a buon fine";
            $_SESSION['icon'] = "success";
            header(pathConfigurations());  
        } else {
            $_SESSION['title'] = "Configurazione non modificata!";
            $_SESSION['text'] = "Si è verificato un errore nella modifica";
            $_SESSION['icon'] = "error";
            header(pathConfigurations());
        }
    }
}

/**
*   deleteCCP()
*   Funzione che cancella una configurazione in base al convertitore di protocollo
*/
function deleteCCP() {
    $id = $_POST['Id'];

    $query = "DELETE FROM `union_convert_protocollo` WHERE `Id` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Configurazione eliminata!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathConfigurations());
    } else {
        $_SESSION['title'] = "Configurazione non eliminata!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathConfigurations());
    }
}

/**
*   clearCCP()
*   Funzione che cancella tutte le configurazioni in base ai tipo erogatore
*/
function clearCCP() {
    $result = mysqli_query(connDB(),"TRUNCATE TABLE `union_convert_protocollo`") or die (mysqli_error(connDB()));
    if($result) {
        $_SESSION['title'] = "Configurazioni cancellate";
        $_SESSION['text'] = "Tutte le configurazioni sono state cancellate";
        $_SESSION['icon'] = "success";
        header(pathConfigurations());
    } else {
        $_SESSION['title'] = "Impossibile eliminare!";
        $_SESSION['text'] = "Si è verificato un errore nella cancellazione";
        $_SESSION['icon'] = "error";
        header(pathConfigurations());
    }
}

/**
 *  newBugReport()
 *  Funzione che permette l'inserimento di segnalazioni di bug riscontrati nell'utilizzo del datastore 
 */

function newBugReport() {
    $caller = addslashes($_POST['Chiamante']);
    $dateOpenBug = $_POST['DataApertura'];
    $email = addslashes($_POST['Email']);
    $user = addslashes($_POST['Utente']);
    $state = $_POST['Stato'];
    $issueEnvironment = addslashes($_POST['AreaProblema']);
    $impact = $_POST['Impatto'];
    $priority = $_POST['Priorita'];
    $object = addslashes($_POST['Oggetto']);
    $description = addslashes($_POST['Descrizione']);

    $query = "INSERT INTO `report_bug` VALUES (0,'$issueEnvironment',$impact,$priority,$state,'$caller','$email','$user','$dateOpenBug',NULL,NULL,NULL,'$object','$description',NULL)";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Segnalazione creata!";
        $_SESSION['text'] = "La segnalazione è stata inserita";
        $_SESSION['icon'] = "success";
        header(pathSectionBug());  
    } else {
        $_SESSION['title'] = "Segnalazione non creata!";
        $_SESSION['text'] = "Si è verificato un errore nell'apertura della segnalazione";
        $_SESSION['icon'] = "error";
        header(pathSectionBug());
    }
}

/**
 * getTicket()
 * Funzione che permette al developer di prendere in carico le segnalazioni di bug riscontrati nell'utilizzo del datastore 
 */
function getTicket() {
    $id = $_POST['Id'];
    $nameDev = addslashes($_POST['Operatore']);
    $usernameDev = addslashes($_POST['UsernameOpe']);

    $query = "UPDATE `report_bug` SET `Operatore` = '$nameDev', `UsernameOpe` = '$usernameDev' WHERE `Id` = $id";
    //Lancio la query
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Segnalazione presa in carico!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathSectionBug());  
    } else {
        $_SESSION['title'] = "Segnalazione non presa in carico!";
        $_SESSION['text'] = "Si è verificato un errore durante l'operazione";
        $_SESSION['icon'] = "error";
        header(pathSectionBug());
    }
}


/**
 *  updateBugReport()
 * @param $isDev datatype: boolean
 *  Funzione che permette l'aggiornamento delle segnalazioni di bug riscontrati nell'utilizzo del datastore 
 */
function updateBugReport($isDev) {

    $id = $_POST['Id'];
    $caller = addslashes($_POST['Chiamante']);
    $dateOpenBug = $_POST['DataApertura'];
    $email = addslashes($_POST['Email']);
    $user = addslashes($_POST['Utente']);
    $nameDev = addslashes($_POST['Operatore']);
    $usernameDev = addslashes($_POST['UsernameOpe']);
    $state = $_POST['Stato'];
    $issueEnvironment = addslashes($_POST['AreaProblema']);
    $impact = $_POST['Impatto'];
    $priority = $_POST['Priorita'];
    $object = addslashes($_POST['Oggetto']);
    $description = addslashes($_POST['Descrizione']);
    $workNotes = addslashes($_POST['WorkNotes']);

    $timeStamp = date("d/m/Y - H:i:s");
    $sessionUser = addslashes($_SESSION['Username']);
    $arrayWN = array();

    //Utente che sta aggiornando la segnalazione
    $result = mysqli_query(connDB(),"SELECT `Nome`,`Cognome` FROM `utenti` WHERE BINARY `Username` = '$sessionUser'") or die (mysqli_error(connDB()));
    if($row = mysqli_fetch_array($result)) {
        $currentUser = $row['Nome'] . " " . addslashes($row['Cognome']);
    }

    //Recupero il JSON salvato nel campo "Commenti" sulla tabella report_bug
    $result = mysqli_query(connDB(),"SELECT `Commenti` FROM `report_bug` WHERE `Id` = $id") or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $aryWorkNotes = json_decode($row['Commenti'],true);
    }   

    //Salvataggio delle note di lavoro
    if (empty($aryWorkNotes)) {
        if (!empty(trim($workNotes))) {
           $arrayWN[] = array('user' => trim($currentUser), 'timestamp' => trim($timeStamp), 'notes' => trim($workNotes));
           $workNotes = json_encode($arrayWN,true);
        }
    } else {
        if (!empty(trim($workNotes))) {
            $arrayWN[] = $aryWorkNotes;
            foreach ($arrayWN as $value) {
                $value[] = array('user' => trim($currentUser), 'timestamp' => trim($timeStamp), 'notes' => trim($workNotes));
                $workNotes = json_encode($value,true);
            }
        }
    }

    //Gestione dei vari stati della segnalazione per tipo di query da eseguire
    if (!$isDev && $state == 1) {

        if(!empty($workNotes)) {
            $query = "UPDATE `report_bug` SET `Area` = '$issueEnvironment', `Impatto` = '$impact', `Priorita` = '$priority', `Commenti` = '$workNotes' WHERE `Id` = $id";
        } else {
            $query = "UPDATE `report_bug` SET `Area` = '$issueEnvironment', `Impatto` = '$impact', `Priorita` = '$priority' WHERE `Id` = $id";
        }

    } elseif (($isDev && $state == 2) || (!$isDev && $state == 2)) {

        if(!empty($workNotes)) {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `Operatore` = '$nameDev', `UsernameOpe` = '$usernameDev', `Commenti` = '$workNotes' WHERE `Id` = $id";
        } else {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `Operatore` = '$nameDev', `UsernameOpe` = '$usernameDev' WHERE `Id` = $id";
        }
        
    } elseif ($isDev && $state == 3) {

        if(!empty($workNotes)) {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `Operatore` = NULL, `UsernameOpe` = NULL, `Commenti` = '$workNotes' WHERE `Id` = $id";
        } else {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `Operatore` = NULL, `UsernameOpe` = NULL WHERE `Id` = $id";
        }
        
    } elseif (!$isDev && $state == 4) {
        $dateCloseBug = date("d/m/Y");

        if(!empty($workNotes)) {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `DataChiusura` = '$dateCloseBug' WHERE `Id` = $id";
        } else {
            $query = "UPDATE `report_bug` SET `Stato` = $state, `DataChiusura` = '$dateCloseBug' WHERE `Id` = $id";
        }
        
    }

    //Lancio la query
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if(!mysqli_fetch_array($result)) {
        $_SESSION['title'] = "Segnalazione aggiornata!";
        $_SESSION['text'] = "Operazione andata a buon fine";
        $_SESSION['icon'] = "success";
        header(pathSectionBug());  
    } else {
        $_SESSION['title'] = "Segnalazione non aggiornata!";
        $_SESSION['text'] = "Si è verificato un errore nella modifica";
        $_SESSION['icon'] = "error";
        header(pathSectionBug());
    }

}


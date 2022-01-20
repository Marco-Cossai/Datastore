<?php

/**
*   connParameterDB()
*   Parametri di connessione al database
*/
function connParameterDB() {

    return $connParam [] = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'datastore'
    );

}

/**
*   connDB()
*   Ritorna la connessione al database
*/
function connDB() {
    $options = connParameterDB();

    /** Creo la connessione al database */
    $conn = new mysqli($options['host'], $options['user'], $options['password'], $options['database']);
    if ($conn->connect_error) {
        header("location: conn_failed.php");
        exit();
    }

    return $conn;
}

?>

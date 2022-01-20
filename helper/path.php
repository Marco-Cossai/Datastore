<?php

/**
*   Funzioni con le varie path per le varie pagine
*/

function pathLogIn() {
    $path = "location: ../index.php";
    return $path;
}

function pathSignUp() {
    $path = "location: ../signup.php";
    return $path;
}

function pathDashboard() {
    $path = "location: ../dashboard.php";
    return $path;
}

function pathSettings() {
    $path = "location: ../settings.php";
    return $path;
}

function pathUsers() {
    $path = "location: ../utenti.php";
    return $path;
}

function pathCustomers() {
    $path = "location: ../clienti.php";
    return $path;
}

function pathPlants() {
    $path = "location: ../impianti.php";
    return $path;
}

function listPlants(int $idCustomer) {
    $path = "location: ../list_plants.php?id=$idCustomer";
    return $path;
}

function pathDetails(int $id, int $idCustomer_FK) {
    $path = "location: ../details.php?id=$id&idCustomer=$idCustomer_FK";
    return $path;
}

function pathPendingRequests() {
    $path = "location: ../pending.php";
    return $path;
}

function pathOperations() {
    $path = "location: ../operations.php";
    return $path;
}

function pathConfigurations() {
    $path = "location: ../configurations.php";
    return $path;
}
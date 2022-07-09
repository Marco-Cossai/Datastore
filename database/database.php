<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/'.'helper/functions.php';

//Prelevo i riferimeti al datamodule e all'azione da compiere 
$datamodule = $_POST['datamodule'];
$action = $_POST['action'];

switch ($datamodule) {
    case 'signup': signUp(); break;
    case 'login': logIn(); break;
    case 'logout': logOut(); break;
    case 'sendmail': sendmail(); break;
    case 'reset_pwd': resetPWD(); break;
    case 'settings':
        if ($action == 'changeAccount') { changeAccount(); }
        if ($action == 'changePassword') { changePassword(); }
    break;
    case 'users':
        if ($action == 'insert') { newUser(); }
        if ($action == 'update') { updateUser(); }
        if ($action == 'delete') { deleteUser(); } 
    break;
    case 'customers':
        if ($action == 'insert') { newCustomer(); }
        if ($action == 'update') { updateCustomer(); }
        if ($action == 'delete') { deleteCustomer(); }
        //COSM - #10 - Aggiunta bottone per migrazione impianto
        if ($action == 'migration') { migrationPlant('customers'); } 
    break;
    case 'plants':
        if ($action == 'insert') { newPlant(); }
        if ($action == 'update') { updatePlant(); }
        if ($action == 'delete') { deletePlant(); } 
        //COSM - #10 - Aggiunta bottone per migrazione impianto
        if ($action == 'migration') { migrationPlant('plants'); }  
    break;
    case 'computer':
        if ($action == 'insert') { newPC(); }
        if ($action == 'update') { updatePC(); }
        if ($action == 'delete') { deletePC(); }
        if ($action == 'request_delete_pc') { requestDeletePC(); }
    break;
    case 'mac':
        if ($action == 'insert') { newMAC(); }
        if ($action == 'update') { updateMAC(); }
        if ($action == 'delete') { deleteMAC(); }
        if ($action == 'delete_all_mac') { deleteAllMAC(); }
        if ($action == 'request_delete_all_mac') { requestDeleteAllMAC(); }
        break;
    case 'dispenser':
        if ($action == 'insert') { newDispenser(); }
        if ($action == 'update') { updateDispenser(); }
        if ($action == 'delete') { deleteDispenser(); }
        //COSM #08 - Modifica sezione 'Erogatori'
        if ($action == 'delete_all_dispenser') { deleteAllDispenser(); }
        if ($action == 'request_delete_all_dispenser') { requestDeleteAllDispenser(); }
    break;
    //COSM #09 - Aggiunta sezione accessori
    case 'accessories':
        if ($action == 'insert') { newAccessories(); }
        if ($action == 'update') { updateAccessories(); }
        if ($action == 'delete') { deleteAccessories(); }
        if ($action == 'request_delete_accessories') { requestDeleteAccessories(); }
    break;
    case 'request':
        if ($action == 'computer') { deletePC(); }
        if ($action == 'mac') { deleteAllMAC(); }
        //COSM #08 - Modifica sezione 'Erogatori'
        if ($action == 'dispenser') { deleteAllDispenser(); }
        if ($action == 'delete') { deleteRequest(); }
        if ($action == 'delete_all_requests') { clearRequests(); }
        //COSM #09 - Cancello gli accessori a seguito di richiesta cancellazione
        if ($action == 'accessories') { deleteAccessories(); }
        break;
    case 'configuration': 
        if ($action == 'insert_data_dispenser') { newDataDispenser(); }
        if ($action == 'update_data_dispenser') { updateDataDispenser(); }
        if ($action == 'delete_data_dispenser') { deleteDataDispenser(); }
        if ($action == 'clear_data_dispenser') { clearDataDispenser(); }

        if ($action == 'insert_cte') { newCTE(); }
        if ($action == 'update_cte') { updateCTE(); }
        if ($action == 'delete_cte') { deleteCTE(); }
        if ($action == 'clear_cte') { clearCTE(); }

        if ($action == 'insert_ccp') { newCCP(); }
        if ($action == 'update_ccp') { updateCCP(); }
        if ($action == 'delete_ccp') { deleteCCP(); }
        if ($action == 'clear_ccp') { clearCCP(); }
    break; 
    default: echo 'Questo tipo di operazione non è consentita!'; break;
}
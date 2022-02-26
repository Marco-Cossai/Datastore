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
    break;
    case 'plants':
        if ($action == 'insert') { newPlant(); }
        if ($action == 'update') { updatePlant(); }
        if ($action == 'delete') { deletePlant(); } 
        if ($action == 'migration') { migrationPlant(); } 
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
    break;
    case 'request':
        if ($action == 'computer') { deletePC(); }
        if ($action == 'mac') { deleteAllMAC(); }
        if ($action == 'delete') { deleteRequest(); }
        if ($action == 'delete_all_requests') { clearRequests(); }
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
    case 'bug':
        if ($action == 'insert') { newBugReport(); }
        if ($action == 'getTicket') { getTicket(); }
        if ($action == 'update') { 
            //Sarà 1 se è un developer altrimenti sarà 0
            $isDev = $_SESSION['Developer'];
            if ($isDev == 1) {
                $isDev = true;
            }
            updateBugReport($isDev); 
        }
    break;
    default: echo 'Questo tipo di operazione non è consentita!'; break;
}
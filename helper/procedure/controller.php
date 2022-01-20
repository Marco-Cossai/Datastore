<?php
    session_start();
    require_once 'procedure.php';

    //Prelevo i riferimeti al datamodule e all'azione da compiere 
    $datamodule = $_POST['datamodule'];
    $action = $_POST['action'];


    switch ($datamodule) {
        case 'procedure':
            if ($action == 'proc_1') { changeStructureDataSoftwareColumn(); }
            if ($action == 'proc_2') { deleteLogUpdate(); }
            if ($action == 'proc_3') { dropTablesDataDispenser(); }
        break; 
        default: echo 'Questo tipo di operazione non è consentita!'; break;
    }
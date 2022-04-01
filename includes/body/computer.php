<div class="row pb-5">
    <div class="col-12">
        <div class="card shadow-sm border">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-7">
                        <a name="SezionePC"></a>
                        <i class="fas fa-desktop"></i> PC
                    </div>
                    <div class="col-5">
                        <?php
                            $id = $_GET['id'];
                            $query = "SELECT * FROM `computer` WHERE `IdImpianto_FK` = $id";
                            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
                            if ($row = mysqli_fetch_array($result)) {
                                $obj = json_encode($row);
                                $obj = htmlspecialchars($obj, ENT_QUOTES);
                        ?>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='deletePC(<?= $obj; ?>)'>
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0" onclick='updatePC(<?= $obj; ?>)'>
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                        <?php } else { ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewPC" class="float-end bg-white border-0 me-1">
                            <i class="fas fa-plus text-green"></i>
                        </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $id = $_GET['id'];
                    $query = "SELECT * FROM `computer` WHERE `IdImpianto_FK` = $id";
                    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
                    if ($row = mysqli_fetch_array($result)) {
                        if ($row['Software'] === "null") {
                            $array = array();
                        } else {
                            $array = json_decode($row['Software']);
                        }
                ?>
                <div class="row pb-1">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Matricola" class="mt-2">Matricola</label>
                        <input type="text" class="form-control mt-1" id="Matricola" value="<?=stripslashes($row['Matricola']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="ModelloPC" class="mt-2">Modello PC</label>
                        <input type="text" class="form-control mt-1" id="ModelloPC" value="<?=stripslashes($row['ModelloPC']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Architettura" class="mt-2">Architettura</label>
                        <input type="text" class="form-control mt-1" id="Architettura" value="<?=stripslashes($row['Architettura']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="SerialePC" class="mt-2">SN-PC</label>
                        <input type="text" class="form-control mt-1" id="SerialePC" value="<?=stripslashes($row['SerialePC']);?>"
                            readonly>
                    </div>
                    <div class="col-12">
                        <h6 class="font-weight-bold pt-3">Software installati</h6>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="BackOffice"
                                <?=in_array("BackOffice",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="BackOffice">BackOffice</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Storesmart"
                                <?=in_array("Storesmart",$array) === true ? 'checked' : ''?> onclick=" return false;">
                            <label class="form-check-label" for="Storesmart">Storesmart</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Cardsmart"
                                <?=in_array("Cardsmart",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="Cardsmart">Cardsmart</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Quadrature"
                                <?=in_array("Quadrature",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="Quadrature">Quadrature</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Puntimanager"
                                <?=in_array("Puntimanager",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="Puntimanager">Puntimanager</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Smartmanager"
                                <?=in_array("Smartmanager",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="Smartmanager">Smartmanager</label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="Gestock"
                                <?=in_array("Gestock",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="Gestock">Gestock</label>
                        </div>
                    </div>
                    <!-- COSM #05 - Aggiunta software CashManager -->
                    <div class="col-lg-3 col-md-4">
                        <div class="form-check form-check-inline mt-2 ms-1">
                            <input type="checkbox" class="form-check-input" id="CashManager"
                                <?=in_array("CashManager",$array) === true ? 'checked' : ''?> onclick="return false;">
                            <label class="form-check-label" for="CashManager">CashManager</label>
                        </div>
                    </div>
                    <?php
                        $idCustomer = $_GET['idCustomer'];
                        $res = mysqli_query(connDB(),"SELECT `TipoCliente` FROM `clienti` WHERE `IdCliente` = $idCustomer;") or die (mysqli_error(connDB()));
                        if (($value = mysqli_fetch_array($res))) {
                            if($value['TipoCliente'] !== "Privato") {
                    ?>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Stampante" class="mt-2">Stampante</label>
                        <input type="text" class="form-control mt-1" id="Stampante" value="<?=stripslashes($row['Stampante']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="PBL" class="mt-2">PBL</label>
                        <input type="text" class="form-control mt-1" id="PBL" value="<?=stripslashes($row['PBL']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="TipoRouter" class="mt-2">Tipo Router</label>
                        <input type="text" class="form-control mt-1" id="TipoRouter" value="<?=stripslashes($row['TipoRouter']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="SerialeRouter" class="mt-2">SN-Router</label>
                        <input type="text" class="form-control mt-1" id="SerialeRouter" value="<?=stripslashes($row['SerialeRouter']);?>" readonly>
                    </div>
                    <?php } else { ?>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <label for="Stampante" class="mt-2">Stampante</label>
                        <input type="text" class="form-control mt-1" id="Stampante" value="<?=stripslashes($row['Stampante']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <label for="TipoRouter" class="mt-2">Tipo Router</label>
                        <input type="text" class="form-control mt-1" id="TipoRouter" value="<?=stripslashes($row['TipoRouter']);?>"
                            readonly>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <label for="SerialeRouter" class="mt-2">SN-Router</label>
                        <input type="text" class="form-control mt-1" id="SerialeRouter" value="<?=stripslashes($row['SerialeRouter']);?>" readonly>
                    </div>
                    <?php } } ?>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="IndirizzoIP" class="mt-2">Indirizzo IP</label>
                        <input type="text" class="form-control mt-1" id="IndirizzoIP" value="<?=stripslashes($row['IP']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Anydesk" class="mt-2">Anydesk</label>
                        <input type="text" class="form-control mt-1" id="Anydesk" value="<?=stripslashes($row['Anydesk']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="DataCompilazione" class="mt-2">Compilato il</label>
                        <input type="text" class="form-control mt-1" id="DataCompilazione" value="<?=$row['DataCompilazione']?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Compilatore" class="mt-2">Compilatore</label>
                        <input type="text" class="form-control mt-1" id="Compilatore" value="<?=stripslashes($row['Compilatore']);?>"
                            readonly>
                    </div>
                    <?php if(!empty($row['Ticket'])) {?>
                    <div class="col-12">
                        <a href="<?=$row['Ticket']?>" class="btn btn-purple btn-lg mt-4 float-end" target="_blank">
                            <i class="fab fa-jira"></i> Ticket
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(!empty($row['Note'])) {?>
                    <div class="col-12">
                        <div class="alert alert-warning mt-4" role="alert">
                            <i class="fas fa-sticky-note"></i>
                            <strong class="me-auto">Note: </strong><?=stripslashes($row['Note']);?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="col-12">
                        <p class="text-muted text-center pt-3">Non è inserita la postazione del pc</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php require_once "includes/modal/computer/modalNewPC.php"; ?>
<?php require_once "includes/modal/computer/modalUpdatePC.php"; ?>
<?php require_once "includes/modal/computer/modalDeletePC.php"; ?>
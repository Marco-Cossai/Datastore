<div class="row pb-5">
    <div class="col-12">
        <div class="card shadow-sm border">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-7">
                        <a name="SezionePC"></a>
                        <i class="fas fa-plug"></i> Accessori
                    </div>
                    <div class="col-5">
                        <?php
                            $id = $_GET['id'];
                            $query = "SELECT * FROM `accessori` WHERE `ID_IMPIANTO_FK` = $id";
                            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
                            if ($row = mysqli_fetch_array($result)) {
                                $obj = json_encode($row);
                                $obj = htmlspecialchars($obj, ENT_QUOTES);
                        ?>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='deleteAccessories(<?= $obj; ?>)'>
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0" onclick='updateAccessories(<?= $obj; ?>)'>
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                        <?php } else { ?>
                        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewAccessories" class="float-end bg-white border-0 me-1">
                            <i class="fas fa-plus text-green"></i>
                        </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $id = $_GET['id'];
                    $query = "SELECT * FROM `accessori` WHERE `ID_IMPIANTO_FK` = $id";
                    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
                    if ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="row pb-1">
                    <div class="col-12">
                        <h6 class="font-weight-bold pt-3">POS</h6>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="ModelloPOS" class="mt-2">Modello POS</label>
                        <input type="text" class="form-control mt-1" id="ModelloPOS" value="<?=stripslashes($row['MODELLO_POS']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="TID" class="mt-2">TID</label>
                        <input type="text" class="form-control mt-1" id="TID" value="<?=stripslashes($row['TID']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="VersioneIFSF" class="mt-2">Versione IFSF</label>
                        <input type="text" class="form-control mt-1" id="VersioneIFSF" value="<?=stripslashes($row['VERSIONE_IFSF']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="IP_POS" class="mt-2">Indirizzo IP</label>
                        <input type="text" class="form-control mt-1" id="IP_POS" value="<?=stripslashes($row['IP_POS']);?>" readonly>
                    </div>
                    <hr class="mt-4">
                    <div class="col-12">
                        <h6 class="font-weight-bold pt-3">RFID WI-FI</h6>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <label for="QNT_RFID" class="mt-2">Quantità</label>
                        <input type="text" class="form-control mt-1" id="QNT_RFID" value="<?=stripslashes($row['QNT_RFID']);?>" readonly>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <label for="IP_GTW" class="mt-2">IP Gateway</label>
                        <input type="text" class="form-control mt-1" id="IP_GTW" value="<?=stripslashes($row['IP_GTW_RFID']);?>" readonly>
                    </div>
                    <hr class="mt-4">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="MediaSmart" class="mt-2">MediaSmart</label>
                        <input type="text" class="form-control mt-1" id="MediaSmart" value="<?=stripslashes($row['MEDIASMART']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Stampanti" class="mt-2">Stampanti</label>
                        <input type="text" class="form-control mt-1" id="Stampanti" value="<?=stripslashes($row['STAMPANTI']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="IpSafetySmart" class="mt-2">IP SafetySmart</label>
                        <input type="text" class="form-control mt-1" id="IpSafetySmart" value="<?=stripslashes($row['IP_SAFETYSMART']);?>" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <label for="Backup" class="mt-2">Backup</label>
                        <input type="text" class="form-control mt-1" id="Backup" value="<?=stripslashes($row['BACKUP']);?>" readonly>
                    </div>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="col-12">
                        <p class="text-muted text-center pt-3">Non sono presenti accessori!</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php require_once "includes/modal/accessories/modalNewAccessories.php"; ?>
<?php require_once "includes/modal/accessories/modalUpdateAccessories.php"; ?>
<?php require_once "includes/modal/accessories/modalDeleteAccessories.php"; ?>
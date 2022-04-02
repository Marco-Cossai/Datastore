<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <?php
            $id = $_GET['id'];
            $query = "SELECT * FROM `mac` WHERE `IdImpianto_FK` = $id";
            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
            if (mysqli_fetch_array($result)) {
        ?>
        <button data-mdb-toggle="modal" class="btn btn-danger float-md-end float-sm-start float-start me-0" onclick="deleteAllMAC()">
            <i class="fas fa-trash"></i> Pulisci
        </button>
        <?php } ?>
        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewMAC" class="btn btn-green float-md-end float-sm-start float-start me-2">
            <i class="fas fa-plus"></i> Aggiungi
        </button>
    </div>
</div>

<div class="row pb-5">
    <?php
        $id = $_GET['id'];
        $query = "SELECT * FROM `mac` WHERE `IdImpianto_FK` = $id ORDER BY `Nome` DESC";
        $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
        if (mysqli_fetch_array($result)) {
            foreach ($result as $row) {
                $obj = json_encode($row);
                $obj = htmlspecialchars($obj, ENT_QUOTES);
    ?>
    <div class="col-xl-4 col-lg-6">
        <div class="card shadow-sm border mt-3 pb-2">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-7">
                        <i class="fas fa-hdd"></i> <?=$row['Nome']?>
                    </div>
                    <div class="col-5">
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='deleteMAC(<?= $obj; ?>)'>
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='updateMAC(<?= $obj; ?>)'>
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body mb-2">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">Matricola</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Matricola']);?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">Modello</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Modello']);?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">Pinpad</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Pinpad']);?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">CPU</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['CPU']);?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">Stampante</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Stampante']);?>" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                        <label class="mt-2">Lettore</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Lettore']);?>" readonly>
                    </div>
                    <!-- COSM #06 - Aggiunta campo visualizzazione di indirizzo IP -->
                    <div class="col-12">
                        <label class="mt-2">Indirizzo IP</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['IndirizzoIP']);?>" readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer pb-0">
                <button data-mdb-toggle="modal" class="btn btn-green float-end border-0 me-0 px-3" onclick='newDispenser(<?= $obj; ?>)'>
                    <i class="fas fa-gas-pump"></i>
                </button>
            </div>
        </div>
    </div>
    <?php } } else {?>
    <div class="col-12">
        <div class="card shadow-sm border mt-3">
            <div class="card-header">
                <a name="MAC"></a>
                <i class="fas fa-hdd"></i> MAC
            </div>
            <div class="card-body mb-2">
                <p class="text-muted text-center pt-3">Non sono presenti MAC</p>
            </div>
        </div>
    </div>
    <?php }?>
</div>

<?php require_once "includes/modal/dispenser/modalNewDispenser.php"; ?>
<?php require_once "includes/modal/mac/modalNewMAC.php"; ?>
<?php require_once "includes/modal/mac/modalUpdateMAC.php"; ?>
<?php require_once "includes/modal/mac/modalDeleteAllMAC.php"; ?>
<?php require_once "includes/modal/mac/modalDeleteMAC.php"; ?>
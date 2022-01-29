<div class="row pb-5">
    <?php
        $id = $_GET['id'];
        $query = "SELECT * FROM (`erogatori` JOIN `mac` ON mac.IdMac = erogatori.IdMac_FK) WHERE mac.IdImpianto_FK = $id AND erogatori.IdImpianto_FK = $id ORDER BY `Nome` DESC";
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
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='deleteDispenser(<?= $obj; ?>)'>
                            <i class="far fa-trash-alt text-danger"></i>
                        </button>
                        <button data-mdb-toggle="modal" class="float-end bg-white border-0 ms-1 me-0" onclick='updateDispenser(<?= $obj; ?>)'>
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body mb-2">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Tipo erogatore</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['TipoErogatore']);?>" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Testata</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Testata']);?>" readonly>
                    </div>
                    <div class="col-12">
                        <label class="mt-2">Protocollo</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Protocollo']);?>" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Conv. protocollo</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['ConvProtocollo']);?>" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Versione</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Versione']);?>" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Pistole</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Pistole']);?>" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="mt-2">Lato</label>
                        <input type="text" class="form-control mt-1" value="<?=stripslashes($row['Lato']);?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } else {?>
    <div class="col-12">
        <div class="card shadow-sm border">
            <div class="card-header">
                <i class="fas fa-gas-pump"></i> Erogatori
            </div>
            <div class="card-body mb-2">
                <p class="text-muted text-center pt-3">Non sono presenti erogatori</p>
            </div>
        </div>
    </div>
    <?php }?>
</div>

<?php require_once "includes/modal/dispenser/modalUpdateDispenser.php"; ?>
<?php require_once "includes/modal/dispenser/modalDeleteDispenser.php"; ?>
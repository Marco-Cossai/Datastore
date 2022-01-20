<div class="row">
    <div class="col-md-6">
        <p class="text-muted font-weight-bold">Config. tipo erogatore</p>
    </div>
    <div class="col-md-6">
        <?php
            $query = "SELECT * FROM `union_tipo_erogatore`";
            $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
            if (mysqli_fetch_array($result)) {
        ?>
        <button data-mdb-toggle="modal" data-mdb-target="#ModalClearCTE" class="btn btn-danger float-md-end float-sm-start float-start me-0 ms-lg-1 ms-md-1">
            <i class="fas fa-trash"></i> Pulisci
        </button>
        <?php } ?>
        <button data-mdb-toggle="modal" data-mdb-target="#ModalNewCTE" class="btn btn-green float-md-end float-sm-start float-start">
            <i class="fas fa-plus"></i> Aggiungi
        </button>
    </div>
</div>

<?php
    $query = "SELECT * FROM `union_tipo_erogatore`";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if (mysqli_fetch_array($result)) {
?>
<div class="row">
    <?php
        $query = "SELECT DISTINCT `TipoErogatore` FROM `union_tipo_erogatore`";
        $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
        foreach ($result as $value) {
    ?>
    <div class="col-lg-4">
        <div class="card shadow-sm border mt-3">
            <div class="card-header font-weight-bold"><?=$value['TipoErogatore'];?></div>
            <div class="card-body">
                <?php
                    $dispenserType = $value['TipoErogatore'];
                    $q = "SELECT * FROM `union_tipo_erogatore` WHERE `TipoErogatore` = '$dispenserType' ORDER BY `Id` DESC";
                    $res = mysqli_query(connDB(),$q) or die(mysqli_error(connDB()));
                ?>
                <div class="table-responsive">
                    <table class="table table-sm text-nowrap align-middle text-center py-4">
                        <thead>
                            <tr>
                                <th class="th-sm">Testata</th>
                                <th class="th-sm">Protocollo</th>
                                <th class="th-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($res as $row) { ?>
                            <tr>
                                <td><?=$row['Testata'];?></td>
                                <td><?= $row['Protocollo'];?></td>
                                <td>
                                    <?php $obj = json_encode($row); ?>
                                    <a class="btn btn-primary btn-sm px-2" data-mdb-toggle="modal" onclick='updateCTE(<?= $obj; ?>)'>
                                        <i class="fas fa-pencil-alt fa-sm"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm px-2" data-mdb-toggle="modal" onclick='deleteCTE(<?= $obj; ?>)'>
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } else { ?>
    <div class="card shadow-sm border mt-3">
        <div class="card-body">
            <img src="img/other/empty.svg" class="img-fluid d-block mx-auto mt-2" style="width: 95px; height: 95px;" />
            <h5 class="text-muted text-center pt-3">Non sono presenti configurazioni!</h5>
        </div>
    </div>
<?php } ?>
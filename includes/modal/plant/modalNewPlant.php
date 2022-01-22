<?php
    if (empty($_GET)) {
        $query = "SELECT * FROM `clienti` ORDER BY `RagioneSociale`";
    } else {
        $id = $_GET['id'];
        $query = "SELECT * FROM `clienti` WHERE `IdCliente` = $id";
    }
    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
?>
<div class="modal fade" id="ModalNewPlant" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuovo impianto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="plants" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                            <input type="hidden" class="form-control" id="page" name="page" readonly>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label for="NomeImpianto" class="mt-2">Nome impianto *</label>
                            <input type="text" class="form-control mb-0" id="NomeImpianto" name="NomeImpianto" required>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label for="Email" class="mt-2">Email</label>
                            <input type="text" class="form-control mb-0" id="Email" name="Email">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label for="Recapito" class="mt-2">Recapito</label>
                            <input type="text" class="form-control mb-0" id="Recapito" name="Recapito">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <label for="Cliente" class="mt-2">Cliente *</label>
                            <select class="form-select py-1 mb-0" id="Cliente" name="IdCustomer_FK" required>
                                <?php if (empty($_GET)) {?>
                                <option value=""></option>
                                <?php } ?>
                                <?php foreach ($result as $row) { ?>
                                <option value="<?=$row['IdCliente'];?>"><?=stripslashes($row['RagioneSociale']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-green shadow-sm" type="submit"><i class="fas fa-plus"></i> Aggiungi</button>
                </div>
            </form>
        </div>
    </div>
</div>
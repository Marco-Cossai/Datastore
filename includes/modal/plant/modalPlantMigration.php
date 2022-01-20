<div class="modal fade" id="ModalPlantMigration" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Migrazione impianto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="plants" readonly>
                    <input type="hidden" class="form-control" name="action" value="migration" readonly>
                    <input type="hidden" class="form-control" id="idPlant" name="IdPlant_FK" readonly>
                    <input type="hidden" class="form-control" id="idOldCustomer" name="IdOldCustomer_FK" readonly>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="oldBusinessName" class="mt-2">Vecchio cliente</label>
                            <input type="text" class="form-control mt-1 mb-0" id="oldBusinessName" readonly>
                        </div>
                        <div class="col-lg-6">
                            <label class="mt-2">Nuovo cliente *</label>
                            <select class="form-select mt-1 mb-0 py-1" name="IdCustomer_FK" required>
                                <option value=""></option>
                                <?php foreach ($result as $row) { ?>
                                <option value="<?=$row['IdCliente'];?>"><?=$row['RagioneSociale'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning shadow-sm" type="submit" id="btn-submit"><i class="fas fa-exchange-alt"></i> Migra impianto</button>
                </div>
            </form>
        </div>
    </div>
</div>
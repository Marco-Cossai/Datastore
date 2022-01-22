<div class="modal fade" id="ModalUpdateCCP" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica dati</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" onchange="checkData('','configCCP')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="configuration" readonly>
                            <input type="hidden" class="form-control" name="action" value="update_ccp" readonly>
                            <input type="hidden" class="form-control" id="uIdCCP" name="Id" readonly>
                        </div>
                        <div class="col-12">
                            <label for="convprotocollo" class="mt-2">Tipo erogatore *</label>
                            <select class="form-select py-1 mb-0" id="convprotocollo" name="ConvProtocollo" required>
                                <?php foreach ($res4 as $row) { ?>
                                <option value="<?=stripslashes($row['Nome']);?>"><?=stripslashes($row['Nome']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="versione" class="mt-2">Testata *</label>
                            <select class="form-select py-1 mb-0" id="versione" name="Versione" required>
                                <?php foreach ($res5 as $row) { ?>
                                <option value="<?=stripslashes($row['Nome']);?>"><?=stripslashes($row['Nome']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-configCCP"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
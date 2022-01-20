<div class="modal fade" id="ModalNewCCP" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserimento dati</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="configuration" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert_ccp" readonly>
                        </div>
                        <div class="col-12">
                            <label class="mt-2">Conv. protocollo *</label>
                            <select class="form-select py-1 mb-0" name="ConvProtocollo" required>
                                <option value=""></option>
                                <?php foreach ($res4 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="mt-2">Versione *</label>
                            <select class="form-select py-1 mb-0" name="Versione" required>
                                <option value=""></option>
                                <?php foreach ($res5 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
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
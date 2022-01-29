<div class="modal fade" id="ModalUpdateCTE" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica dati</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" onchange="checkData('','configCTE')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="configuration" readonly>
                            <input type="hidden" class="form-control" name="action" value="update_cte" readonly>
                            <input type="hidden" class="form-control" id="uIdCTE" name="Id" readonly>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="tipoerogatore" class="mt-2">Tipo erogatore *</label>
                            <select class="form-select py-1 mb-0" id="tipoerogatore" name="TipoErogatore" required>
                                <?php foreach ($res1 as $row) { ?>
                                <option value="<?=stripslashes($row['Nome']);?>"><?=stripslashes($row['Nome']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="testata" class="mt-2">Testata *</label>
                            <select class="form-select py-1 mb-0" id="testata" name="Testata" required>
                                <?php foreach ($res2 as $row) { ?>
                                <option value="<?=stripslashes($row['Nome']);?>"><?=stripslashes($row['Nome']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="protocollo" class="mt-2">Protocollo *</label>
                            <select class="form-select py-1 mb-0" id="protocollo" name="Protocollo" required>
                                <?php foreach ($res3 as $row) { ?>
                                <option value="<?=stripslashes($row['Nome']);?>"><?=stripslashes($row['Nome']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-configCTE"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
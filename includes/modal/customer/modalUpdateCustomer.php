<div class="modal fade" id="ModalUpdateCustomer" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica cliente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('update','customers')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="customers" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" value="" id="uId" name="IdCustomer" readonly>
                        </div>
                        <div class="col-12">
                            <label for="uRagioneSociale" class="mt-3">Ragione sociale *</label>
                            <input type="text" class="form-control mb-0" id="uRagioneSociale" name="RagioneSociale" required>
                        </div>
                        <div class="col-12">
                            <label for="uTipoCliente" class="mt-2">Tipologia *</label>
                            <select class="form-select py-1 mb-0" id="uTipoCliente" name="TipoCliente" required>
                                <option value="Privato">Privato</option>
                                <option value="Compagnia petrolifera">Compagnia petrolifera</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-customers"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>

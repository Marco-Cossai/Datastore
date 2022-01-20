<div class="modal fade" id="ModalNewCustomer" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuovo cliente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="customers" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                        </div>
                        <div class="col-12">
                            <label for="RagioneSociale" class="mt-3">Ragione sociale *</label>
                            <input type="text" class="form-control mb-0" id="RagioneSociale" name="RagioneSociale" required>
                        </div>
                        <div class="col-12">
                            <label for="TipoCliente" class="mt-2">Tipo cliente *</label>
                            <select class="form-select py-1 mb-0" id="TipoCliente" name="TipoCliente" required>
                                <option value=""></option>
                                <option value="Privato">Privato</option>
                                <option value="Compagnia petrolifera">Compagnia petrolifera</option>
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
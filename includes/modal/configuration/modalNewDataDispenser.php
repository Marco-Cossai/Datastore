<div class="modal fade" id="ModalNewDataDispenser" role="dialog" aria-hidden="true">
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
                            <input type="hidden" class="form-control" name="action" value="insert_data_dispenser" readonly>
                        </div>
                        <div class="col-12">
                            <label class="mt-3">Nome *</label>
                            <input type="text" class="form-control mb-0" name="Nome" required>
                        </div>
                        <div class="col-12">
                            <label class="mt-2">Tipologia *</label>
                            <select class="form-select py-1 mb-0" name="Tipologia" required>
                                <option value=""></option>
                                <option value="Tipo erogatore">Tipo erogatore</option>
                                <option value="Testata">Testata</option>
                                <option value="Protocollo">Protocollo</option>
                                <option value="Convertitore di protocollo">Conv. protocollo</option>
                                <option value="Versione">Versione</option>
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
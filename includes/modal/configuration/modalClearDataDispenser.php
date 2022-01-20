<div class="modal fade" id="ModalClearDataDispenser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pulisci i dati</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body mb-3">
                    <input type="hidden" class="form-control" name="datamodule" value="configuration" readonly>
                    <input type="hidden" class="form-control" name="action" value="clear_data_dispenser" readonly>

                    <img src="img/other/wait.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-2">Cosa vuoi ripulire?</h5>
                    <p class="text-danger text-center pt-2">NB: cancellerai tutti i dati in base al filtro che selezionerai!</p>
                    <select class="form-select py-1 mb-0 mt-2" name="Filter" required>
                        <option value=""></option>
                        <option value="All">TUTTO</option>
                        <option value="Tipo erogatore">Tipo erogatore</option>
                        <option value="Testata">Testata</option>
                        <option value="Protocollo">Protocollo</option>
                        <option value="Convertitore di protocollo">Conv. protocollo</option>
                        <option value="Versione">Versione</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Pulisci</button>
                </div>
            </form>
        </div>
    </div>
</div>
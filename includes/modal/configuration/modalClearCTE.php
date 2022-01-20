<div class="modal fade" id="ModalClearCTE" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pulisci i dati</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="configuration" readonly>
                    <input type="hidden" class="form-control" name="action" value="clear_cte" readonly>

                    <img src="img/other/wait.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-2">Vuoi davvero proseguire?</h5>
                    <p class="text-danger text-center">NB: cancellerai tutti le configurazioni esistenti!</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Pulisci</button>
                </div>
            </form>
        </div>
    </div>
</div>
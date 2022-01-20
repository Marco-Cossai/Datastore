<div class="modal fade" id="ModalDeleteAllRequests" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pulisci richieste</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="request" readonly/>
                    <input type="hidden" class="form-control" id="tabRequest" name="action" readonly/>

                    <img src="img/other/wait.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-3">Pulire tutte le richieste?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Pulisci</button>
                </div>
            </form>
        </div>
    </div>
</div>
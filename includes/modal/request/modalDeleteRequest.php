<div class="modal fade" id="ModalDeleteRequest" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancella richiesta</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="request" readonly/>
                    <input type="hidden" class="form-control" id="tabRequest" name="action" readonly/>
                    <input type="hidden" class="form-control" id="idRequest" name="IdRequest" readonly/>
                    <input type="hidden" class="form-control" id="idPlant" name="IdPlant_FK" readonly/>

                    <img src="img/other/wait.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-3">Rifiutare la richiesta di cancellazione?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Rifiuta</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDeletePlant" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancella impianto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="plants" readonly>
                    <input type="hidden" class="form-control" name="action" value="delete" readonly>
                    <input type="hidden" class="form-control" id="id" name="IdPlant" readonly>
                    <input type="hidden" class="form-control" id="dIdCustomer" name="IdCustomer" readonly>
                    <input type="hidden" class="form-control" id="dPage" name="page" readonly>

                    <img src="img/other/warning.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-2">Vuoi davvero eliminare questo impianto?</h5>
                    <p class="text-danger text-center">NB: cancellerai anche tutti i dati relativi all'impianto!</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Elimina</button>
                </div>
            </form>
        </div>
    </div>
</div>
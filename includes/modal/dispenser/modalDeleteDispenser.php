<div class="modal fade" id="ModalDeleteDispenser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancella erogatore</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="dispenser" readonly>
                    <input type="hidden" class="form-control" name="action" value="delete" readonly>
                    <input type="hidden" class="form-control" id="dIdErogatore" name="Id" readonly>
                    <input type="hidden" class="form-control" name="IdPlant_FK" value="<?=$_GET['id']?>" readonly>
                    <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>

                    <img src="img/other/warning.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-2">Vuoi davvero eliminare questo erogatore?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Elimina</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDeleteUser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancella utente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body mb-4">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="users" readonly>
                            <input type="hidden" class="form-control" name="action" value="delete" readonly>
                            <input type="hidden" class="form-control" value="" id="id" name="IdUtente" readonly>
                            <input type="hidden" class="form-control" name="Username" value="<?php echo $_SESSION['Username'];?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <img src="img/other/wait.png" class="mx-auto d-block img-fluid">
                            <h5 class="text-center text-dark pt-2">Vuoi davvero eliminare questo utente?</h5>
                            <input type="password" class="form-control mt-4 mb-0" placeholder="Inserisci la tua password" name="Password" minlength="8" maxlength="16" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit"><i class="fas fa-user-times"></i> Elimina</button>
                </div>
            </form>
        </div>
    </div>
</div>
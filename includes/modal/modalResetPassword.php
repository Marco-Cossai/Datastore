<div class="modal fade" id="ModalResetPassword" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recupera password</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="sendmail" readonly>
                    <div class="row">
                        <div class="col-12">
                            <label class="mt-2">Email</label>
                            <input type="email" class="form-control mt-1" name="Email" required>
                            <div class="invalid-feedback">
                                Il campo non può essere vuoto!
                            </div>
                            <p class="text-muted pt-4">
                                Inserisci la mail associata all'utenza per cui vuoi recuperare la password.
                                Riceverai una mail contenente un link su cui dovrai cliccare per impostare la nuova password
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-green" type="submit">Invia</button>
                </div>
            </form>
        </div>
    </div>
</div>
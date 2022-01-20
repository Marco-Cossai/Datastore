<div class="modal fade" id="ModalUpdateUser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica utente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('update','users')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" id="datamodule" name="datamodule" value="users" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" id="uId" name="IdUtente" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uNome" class="mt-2">Nome *</label>
                            <input type="text" class="form-control mb-0" id="uNome" name="Nome" required>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uCognome" class="mt-2">Cognome *</label>
                            <input type="text" class="form-control mb-0" id="uCognome" name="Cognome" required>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uSesso" class="mt-2">Sesso *</label>
                            <select class="form-select py-1 mb-0" id="uSesso" name="Sesso" required>
                                <option value="Maschio">Maschio</option>
                                <option value="Femmina">Femmina</option>
                                <option value="Non specificato">Non specificato</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uRuolo" class="mt-2">Ruolo *</label>
                            <select class="form-select py-1 mb-0" id="uRuolo" name="Ruolo" required>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <label for="uEmail" class="mt-2">Email</label>
                            <input type="email" class="form-control mb-0" id="uEmail" name="Email">
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uUsername" class="mt-2">Username *</label>
                            <input type="text" class="form-control mb-0" id="uUsername" name="Username" minlength="8" required>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="uPassword" class="mt-2">Password</label>
                            <input type="password" class="form-control mb-0" id="uPassword" name="Password" minlength="8" maxlength="16">
                            <span id="password" class="form-text font-italic">Lunghezza 8-16 caratteri</span>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-users"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>

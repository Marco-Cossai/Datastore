<div class="modal fade" id="ModalNewUser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crea utente</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="users" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Nome" class="mt-2">Nome *</label>
                            <input type="text" class="form-control mb-0" id="Nome" name="Nome" required>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Cognome" class="mt-2">Cognome *</label>
                            <input type="text" class="form-control mb-0" id="Cognome" name="Cognome" required>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Sesso" class="mt-2">Sesso *</label>
                            <select class="form-select py-1 mb-0" id="Sesso" name="Sesso" required>
                                <option value=""></option>
                                <option value="Maschio">Maschio</option>
                                <option value="Femmina">Femmina</option>
                                <option value="Non specificato">Non specificato</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Ruolo" class="mt-2">Ruolo *</label>
                            <select class="form-select py-1 mb-0" id="Ruolo" name="Ruolo" required>
                                <option value=""></option>
                                <option value="Administrator">Administrator</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <label for="Email" class="mt-2">Email</label>
                            <input type="email" class="form-control mb-0" id="Email" name="Email">
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Username" class="mt-2">Username *</label>
                            <input type="text" class="form-control mb-0" id="Username" name="Username" minlength="8" required>
                            <span class="form-text font-italic">Lunghezza minima di 8 caratteri</span>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <label for="Password" class="mt-2">Password *</label>
                            <input type="password" class="form-control mb-0" id="Password" name="Password" minlength="8" maxlength="16" required>
                            <span class="form-text font-italic">Lunghezza 8-16 caratteri</span>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-green shadow-sm" type="submit"><i class="fas fa-user-plus"></i> Aggiungi</button>
                </div>
            </form>
        </div>
    </div>
</div>
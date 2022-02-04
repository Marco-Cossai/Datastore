<div class="modal fade" id="ModalUpdateBug" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php
                        if ($_SESSION['Ruolo'] == 'Administrator' && $_SESSION['Developer'] == 1) {
                            echo _("Gestisci segnalazione");
                        } else {
                            echo _("Modifica segnalazione");
                        }
                    ?>
                </h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="bug" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" name="Id" id="uId" readonly>
                            <input type="hidden" class="form-control" name="Utente" id="uUtente" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uChiamante" class="mt-2">Chiamante</label>
                            <input type="text" class="form-control mb-0" id="uChiamante" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uDataApertura" class="mt-2">Data apertura</label>
                            <input type="text" class="form-control mb-0" id="uDataApertura" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uEmail" class="mt-2">Email</label>
                            <input type="email" class="form-control mb-0" id="uEmail" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uDataChiusura" class="mt-2">Data chiusura</label>
                            <input type="text" class="form-control mb-0" id="uDataChiusura" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uAreaProblema" class="mt-2">Area del problema *</label>
                            <select class="form-select py-1 mb-0" id="uAreaProblema" name="AreaProblema" required>
                                <option value=""></option>
                                <option value="Clienti">Clienti</option>
                                <option value="Impianti">Impianti</option>
                                <option value="Postazioni">Postazioni</option>
                                <option value="MAC">MAC</option>
                                <option value="Erogatori">Erogatori</option>
                                <option value="Utenze">Utenze</option>
                                <option value="Dati erogatore">Dati erogatore</option>
                                <option value="Combinazioni">Combinazioni</option>
                                <option value="Richieste cancellazione PC">Rich. cancella PC</option>
                                <option value="Richieste cancellazione MAC">Rich. cancella MAC</option>
                                <option value="Accesso ai log">Accesso ai log</option>
                                <option value="Altro">Altro</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="uStato" class="mt-2">Stato</label>
                            <select class="form-select py-1 mb-0" id="uStato" name="Stato" required>
                                <option value="1">Nuova</option>
                                <option value="2">In lavorazione</option>
                                <option value="3">Consegnata</option>
                                <option value="4">Chiuso</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <label for="uImpatto" class="mt-2">Impatto *</label>
                            <select class="form-select py-1 mb-0" id="uImpatto" name="Impatto" required>
                                <option value=""></option>
                                <option value="1">1 - Alto</option>
                                <option value="2">2 - Medio</option>
                                <option value="3">3 - Basso</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <label for="uPriorita" class="mt-2">Priorità *</label>
                            <select class="form-select py-1 mb-0" id="uPriorita" name="Priorita" required>
                                <option value=""></option>
                                <option value="1">1 - Urgente</option>
                                <option value="2">2 - Media</option>
                                <option value="3">3 - Bassa</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6"></div>
                        <div class="col-12">
                            <label for="uOggetto" class="mt-2">Oggetto</label>
                            <input type="text" class="form-control mb-0" id="uOggetto" maxlength="128" readonly>
                        </div>
                        <div class="col-12">
                            <label class="mt-2" for="uDescrizione">Descrizione</label>
                            <textarea class="form-control" id="uDescrizione" rows="4" readonly></textarea>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm" type="submit"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
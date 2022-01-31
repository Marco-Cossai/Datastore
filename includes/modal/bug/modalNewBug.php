<?php
    $username = addslashes($_SESSION['Username']);

    $query = "SELECT `Nome`,`Cognome`,`Email` FROM `utenti` WHERE BINARY `Username` = '$username'";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB())); 
    if($row = mysqli_fetch_array($result)) {
        $caller = $row['Nome'] . " " . addslashes($row['Cognome']);
        $email = $row['Email'];
    }
?>
<div class="modal fade" id="ModalNewBug" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apri segnalazione</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="bug" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="Chiamante" class="mt-2">Chiamante</label>
                            <input type="text" class="form-control mb-0" id="Chiamante" name="Chiamante" value="<?=$caller?>" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="DataApertura" class="mt-2">Data apertura</label>
                            <input type="text" class="form-control mb-0" id="DataApertura" name="DataApertura" value="<?=date("d/m/Y");?>" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="Email" class="mt-2">Email</label>
                            <input type="email" class="form-control mb-0" id="Email" name="Email" value="<?=$email?>" readonly>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="Stato" class="mt-2">Stato</label>
                            <select class="form-select py-1 mb-0" id="Stato" name="Stato" required>
                                <option value="1">Nuovo</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <label for="AreaProblema" class="mt-2">Area del problema *</label>
                            <select class="form-select py-1 mb-0" id="AreaProblema" name="AreaProblema" required>
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
                                <option value="Altro">-- Altro</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <label for="Impatto" class="mt-2">Impatto *</label>
                            <select class="form-select py-1 mb-0" id="Impatto" name="Impatto" required>
                                <option value=""></option>
                                <option value="1">1 - Alto</option>
                                <option value="2">2 - Medio</option>
                                <option value="3">3 - Basso</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <label for="Priorita" class="mt-2">Priorità *</label>
                            <select class="form-select py-1 mb-0" id="Priorita" name="Priorita" required>
                                <option value=""></option>
                                <option value="1">1 - Urgente</option>
                                <option value="2">2 - Alta</option>
                                <option value="3">3 - Media</option>
                                <option value="4">4 - Bassa</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="Oggetto" class="mt-2">Oggetto *</label>
                            <input type="text" class="form-control mb-0" id="Oggetto" name="Oggetto" maxlength="128" required>
                        </div>
                        <div class="col-12">
                            <label class="mt-2" for="Descrizione">Descrizione *</label>
                            <textarea class="form-control" id="Descrizione" name="Descrizione" rows="4" required></textarea>
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
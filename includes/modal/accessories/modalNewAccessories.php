<div class="modal fade" id="ModalNewAccessories" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserimento accessori</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('insert','accessories')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="accessories" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                            <input type="hidden" class="form-control" name="IdImpianto_FK" value="<?=$_GET['id']?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="font-weight-bold py-2"><i class="far fa-credit-card"></i> POS</h6>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iModelloPOS" class="mt-2">Modello POS</label>
                            <select class="form-select py-1 mb-0" id="iModelloPOS" name="ModelloPOS">
                                <option value="">Non presente</option>
                                <option value="Desk3200">Desk3200</option>
                                <option value="Move3500">Move3500</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iTID" class="mt-2">TID</label>
                            <input type="text" class="form-control mb-0" id="iTID" name="TID" maxlength="8" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iVersioneIFSF" class="mt-2">Versione IFSF</label>
                            <input type="text" class="form-control mb-0" id="iVersioneIFSF" name="VersioneIFSF" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iIP_POS" class="mt-2">Indirizzo IP</label>
                            <input type="text" class="form-control mb-0" id="iIP_POS" name="IP_POS" minlength="7" maxlength="15" readonly>
                        </div>
                        <hr class="mt-4">
                        <div class="col-12">
                            <h6 class="font-weight-bold py-2"><i class="fas fa-wifi"></i> RFID Wi-Fi</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="iQNT_RFID" class="mt-2">Quantità</label>
                            <input type="number" class="form-control mb-0" id="iQNT_RFID" name="QNT_RFID">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="iIP_GTW" class="mt-2">IP Gateway</label>
                            <input type="text" class="form-control mb-0" id="iIP_GTW" name="iIP_GTW" minlength="7" maxlength="15">
                        </div>
                        <hr class="mt-4">
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iMediaSmart" class="mt-2">MediaSmart</label>
                            <input type="number" class="form-control mb-0" id="iMediaSmart" name="MediaSmart">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iStampanti" class="mt-2">Stampanti</label>
                            <input type="number" class="form-control mb-0" id="iStampanti" name="Stampanti">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iIpSafetySmart" class="mt-2">IP SafetySmart</label>
                            <input type="text" class="form-control mb-0" id="iIpSafetySmart" name="IpSafetySmart" minlength="7" maxlength="15">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iBackup" class="mt-2">Backup</label>
                            <select class="form-select py-1 mb-0" id="iBackup" name="Backup">
                                <option value="">Non presente</option>
                                <option value="USB">USB</option>
                                <option value="NAS">NAS</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-5 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-green shadow-sm" type="submit"><i class="fas fa-plus"></i> Aggiungi</button>
                </div>
            </form>
        </div>
    </div>
</div>
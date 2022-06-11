<div class="modal fade" id="ModalUpdateAccessories" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica accessori</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('update','accessories')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="accessories" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" id="uId" name="Id" readonly>
                            <input type="hidden" class="form-control" id="uIdImpianto_FK" name="IdImpianto_FK" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="font-weight-bold py-2"><i class="far fa-credit-card"></i> POS</h6>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uModelloPOS" class="mt-2">Modello POS</label>
                            <select class="form-select py-1 mb-0" id="uModelloPOS" name="ModelloPOS">
                                <option value="">Non presente</option>
                                <option value="Desk3200">Desk3200</option>
                                <option value="Move3500">Move3500</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uTID" class="mt-2">TID</label>
                            <input type="text" class="form-control mb-0" id="uTID" name="TID" maxlength="8" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uVersioneIFSF" class="mt-2">Versione IFSF</label>
                            <input type="text" class="form-control mb-0" id="uVersioneIFSF" name="VersioneIFSF" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uIP_POS" class="mt-2">Indirizzo IP</label>
                            <input type="text" class="form-control mb-0" id="uIP_POS" name="IP_POS" minlength="7" maxlength="15" readonly>
                        </div>
                        <hr class="mt-4">
                        <div class="col-12">
                            <h6 class="font-weight-bold py-2"><i class="fas fa-wifi"></i> RFID Wi-Fi</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="uQNT_RFID" class="mt-2">Quantità</label>
                            <input type="number" class="form-control mb-0" id="uQNT_RFID" name="QNT_RFID">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <label for="uIP_GTW" class="mt-2">IP Gateway</label>
                            <input type="text" class="form-control mb-0" id="uIP_GTW" name="IP_GTW" minlength="7" maxlength="15">
                        </div>
                        <hr class="mt-4">
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uMediaSmart" class="mt-2">MediaSmart</label>
                            <input type="number" class="form-control mb-0" id="uMediaSmart" name="MediaSmart">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uStampanti" class="mt-2">Stampanti</label>
                            <input type="number" class="form-control mb-0" id="uStampanti" name="Stampanti">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uIpSafetySmart" class="mt-2">IP SafetySmart</label>
                            <input type="text" class="form-control mb-0" id="uIpSafetySmart" name="IpSafetySmart" minlength="7" maxlength="15">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uBackup" class="mt-2">Backup</label>
                            <select class="form-select py-1 mb-0" id="uBackup" name="Backup">
                                <option value="">Non presente</option>
                                <option value="USB">USB</option>
                                <option value="NAS">NAS</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-5 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-accessories"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
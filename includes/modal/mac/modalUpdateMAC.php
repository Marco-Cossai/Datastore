<div class="modal fade" id="ModalUpdateMAC" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica MAC</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" onchange="checkData('update','mac')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="mac" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" name="IdPlant_FK" value="<?=$_GET['id']?>" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                            <input type="hidden" class="form-control" id= "uIdMAC" name="Id" readonly>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <label for="nameMAC" class="mt-2">Nome MAC *</label>
                            <input type="text" class="form-control mb-0" id="uNameMAC" name="Nome" required>
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="numberMAC" class="mt-2">Matricola</label>
                            <input type="text" class="form-control mb-0" id="uNumberMAC" name="Matricola">
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="model" class="mt-2">Modello</label>
                            <select class="form-select py-1 mb-0" id="uModel" name="Modello">
                                <option value=""></option>
                                <option value="Mac Duo">Mac Duo</option>
                                <option value="SP">SP</option>
                                <option value="4.0">4.0</option>
                            </select>
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="pinpad" class="mt-2">Pinpad</label>
                            <select class="form-select py-1 mb-0" id="uPinpad" name="Pinpad">
                                <option value=""></option>
                                <option value="V3">V3</option>
                                <option value="V4">V4</option>
                            </select>
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="cpu" class="mt-2">CPU</label>
                            <select class="form-select py-1 mb-0" id="uCPU" name="CPU">
                                <option value=""></option>
                                <option value="Lizard">Lizard</option>
                                <option value="3.0">3.0</option>
                            </select>
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="printerMAC" class="mt-2">Stampante</label>
                            <select class="form-select py-1 mb-0" id="uPrinterMAC" name="Stampante">
                                <option value=""></option>
                                <option value="12V">12V</option>
                                <option value="12V H">12V H</option>
                                <option value="24V">24V</option>
                            </select>
                        </div>
                        <!-- COSM #06 - Rimozione obbligatorietà del campo -->
                        <div class="col-lg-3 col-md-12">
                            <label for="reader" class="mt-2">Lettore banconote</label>
                            <select class="form-select py-1 mb-0" id="uReader" name="Lettore">
                                <option value=""></option>
                                <option value="Eba 40">Eba 40</option>
                                <option value="Eba 34">Eba 34</option>
                                <option value="DVB 500">DVB 500</option>
                            </select>
                        </div>
                        <!-- COSM #06 - Aggiunta campo per salvataggio indirizzo IP -->
                        <div class="col-lg-3 col-md-12">
                            <label for="uIpMAC" class="mt-2">Indirizzo IP</label>
                            <input type="text" class="form-control mb-0" id="uIpMAC" name="IP" minlength="7" maxlength="15">
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campo obbligatorio</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-mac"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    $id = $_GET['id'];
    $idCustomer = $_GET['idCustomer'];

    $query = "SELECT * FROM `computer` WHERE `IdImpianto_FK` = $id";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $software = $row['Software'];
    }

    $query = "SELECT * FROM `clienti` WHERE `IdCliente` = $idCustomer";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $kindCustomer = $row['TipoCliente'];
    }

?>
<div class="modal fade" id="ModalUpdatePC" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica postazione</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('update','computer')">
                <div class="modal-body py-4">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="computer" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" id="uId" name="id" readonly>
                            <input type="hidden" class="form-control" id="uIdImpianto" name="IdImpianto_FK" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uMatricola" class="mt-2">Matricola *</label>
                            <input type="text" class="form-control mb-0" id="uMatricola" name="Matricola" maxlength="5" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uModello" class="mt-2">Modello PC *</label>
                            <select class="form-select py-1 mb-0" id="uModello" name="Modello" required>
                                <option value="HP">HP</option>
                                <option value="Fujitsu">Fujitsu</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uArchitettura" class="mt-2">Architettura *</label>
                            <select class="form-select py-1 mb-0" id="uArchitettura" name="Architettura" required>
                                <option value="x64">x64</option>
                                <option value="x32">x32</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uSerialePC" class="mt-2">SN-PC *</label>
                            <input type="text" class="form-control mb-0" id="uSerialePC" name="SerialePC" required>
                        </div>
                        <div class="col-12">
                            <h6 class="font-weight-bold pt-3">Software installati</h6>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uBackOffice" name="Software[]" value="BackOffice">
                                <label class="form-check-label my-0" for="uBackOffice">BackOffice</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uStoresmart" name="Software[]" value="Storesmart">
                                <label class="form-check-label my-0" for="uStoresmart">Storesmart</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uCardsmart" name="Software[]" value="Cardsmart">
                                <label class="form-check-label my-0" for="uCardsmart">Cardsmart</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uQuadrature" name="Software[]" value="Quadrature">
                                <label class="form-check-label my-0" for="uQuadrature">Quadrature</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uPuntimanager" name="Software[]" value="Puntimanager">
                                <label class="form-check-label my-0" for="uPuntimanager">Puntimanager</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uSmartmanager" name="Software[]" value="Smartmanager">
                                <label class="form-check-label my-0" for="uSmartmanager">Smartmanager</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="uGestock" name="Software[]" value="Gestock">
                                <label class="form-check-label my-0" for="uGestock">Gestock</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4"></div>
                        <?php if($kindCustomer !== "Privato") { ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uStampante" class="mt-2">Stampante</label>
                            <select class="form-select py-1 mb-0" id="uStampante" name="Stampante">
                                <option value="">Non presente</option>
                                <option value="Epson TM-T7OII">Epson TM-T7OII</option>
                                <option value="SNBC">SNBC</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uPBL" class="mt-2">PBL</label>
                            <input type="text" class="form-control mb-0" id="uPBL" name="PBL" maxlength="6" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uTipoRouter" class="mt-2">Router</label>
                            <select class="form-select py-1 mb-0" id="uTipoRouter" name="TipoRouter">
                                <option value="">Non presente</option>
                                <option value="Mako">Mako</option>
                                <option value="Zyxel">Zyxel</option>
                                <option value="Teltonika">Teltonika</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uSerialeRouter" class="mt-2">SN-Router</label>
                            <input type="text" class="form-control mb-0" id="uSerialeRouter" name="SerialeRouter" readonly>
                        </div>
                        <?php } else { ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uStampante" class="mt-2">Stampante</label>
                            <select class="form-select py-1 mb-0" id="uStampante" name="Stampante">
                                <option value="">Non presente</option>
                                <option value="Epson TM-T7OII">Epson TM-T7OII</option>
                                <option value="SNBC">SNBC</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uTipoRouter" class="mt-2">Router</label>
                            <select class="form-select py-1 mb-0" id="uTipoRouter" name="TipoRouter">
                                <option value="">Non presente</option>
                                <option value="Mako">Mako</option>
                                <option value="Zyxel">Zyxel</option>
                                <option value="Teltonika">Teltonika</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <label for="uSerialeRouter" class="mt-2">SN-Router</label>
                            <input type="text" class="form-control mb-0" id="uSerialeRouter" name="SerialeRouter" readonly>
                        </div>
                        <?php } ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uIndirizzoIP" class="mt-2">Indirizzo IP</label>
                            <input type="text" class="form-control mb-0" id="uIndirizzoIP" name="IndirizzoIP" minlength="7" maxlength="15" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uAnydesk" class="mt-2">Anydesk *</label>
                            <input type="text" class="form-control mb-0" id="uAnydesk" name="Anydesk" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uDataCompilazione" class="mt-2">Compilato il</label>
                            <input type="text" class="form-control" id="uDataCompilazione" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="uCompilatore" class="mt-2">Compilatore</label>
                            <input type="text" class="form-control" id="uCompilatore" readonly>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-12">
                            <label for="uNote" class="font-weight-bold">Note</label>
                            <input type="text" class="form-control mb-0" id="uNote" name="Note" maxlength="255">
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-computer"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
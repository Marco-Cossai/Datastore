<?php
    $idCustomer = $_GET['idCustomer'];
    $username = $_SESSION['Username'];

    $query = "SELECT * FROM `clienti` WHERE `IdCliente` = $idCustomer";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $kindCustomer = $row['TipoCliente'];
    }

    $query = "SELECT `Nome`,`Cognome` FROM `utenti` WHERE `Username` = '$username'";
    $result = mysqli_query(connDB(),$query) or die (mysqli_error(connDB()));
    if ($row = mysqli_fetch_array($result)) {
        $user = $row['Nome'] . " " . $row['Cognome'];
    }
?>
<div class="modal fade" id="ModalNewPC" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuova postazione</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate method="POST" action="database/database.php" onchange="checkData('insert','computer')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="computer" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                            <input type="hidden" class="form-control" name="IdPlant_FK" value="<?=$_GET['id']?>" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iMatricola" class="mt-2">Matricola *</label>
                            <input type="text" class="form-control mb-0" id="iMatricola" name="Matricola" maxlength="5" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iModello" class="mt-2">Modello PC *</label>
                            <select class="form-select py-1 mb-0" id="iModello" name="Modello" required>
                                <option value=""></option>
                                <option value="HP">HP</option>
                                <option value="Fujitsu">Fujitsu</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iArchitettura" class="mt-2">Architettura *</label>
                            <select class="form-select py-1 mb-0" id="iArchitettura" name="Architettura" required>
                                <option value=""></option>
                                <option value="x64">x64</option>
                                <option value="x32">x32</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iSerialePC" class="mt-2">SN-PC *</label>
                            <input type="text" class="form-control mb-0" id="iSerialePC" name="SerialePC" required>
                        </div>
                        <div class="col-12">
                            <h6 class="font-weight-bold pt-3">Software installati</h6>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iBackOffice" name="Software[]" value="BackOffice">
                                <label class="form-check-label my-0" for="iBackOffice">BackOffice</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iStoresmart" name="Software[]" value="Storesmart">
                                <label class="form-check-label my-0" for="iStoresmart">Storesmart</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iCardsmart" name="Software[]" value="Cardsmart">
                                <label class="form-check-label my-0" for="iCardsmart">Cardsmart</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iQuadrature" name="Software[]" value="Quadrature">
                                <label class="form-check-label my-0" for="iQuadrature">Quadrature</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iPuntimanager" name="Software[]" value="Puntimanager">
                                <label class="form-check-label my-0" for="iPuntimanager">Puntimanager</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iSmartmanager" name="Software[]" value="Smartmanager">
                                <label class="form-check-label my-0" for="iSmartmanager">Smartmanager</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-check form-check-inline mt-2 ms-1">
                                <input type="checkbox" class="form-check-input" id="iGestock" name="Software[]" value="Gestock">
                                <label class="form-check-label my-0" for="iGestock">Gestock</label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4"></div>
                        <?php if($kindCustomer !== "Privato") { ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iStampante" class="mt-2">Stampante</label>
                            <select class="form-select py-1 mb-0" id="iStampante" name="Stampante">
                                <option value="">Non presente</option>
                                <option value="Epson TM-T7OII">Epson TM-T7OII</option>
                                <option value="SNBC">SNBC</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iPBL" class="mt-2">PBL *</label>
                            <input type="text" class="form-control mb-0" id="iPBL" name="PBL" maxlength="6" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iTipoRouter" class="mt-2">Router</label>
                            <select class="form-select py-1 mb-0" id="iTipoRouter" name="TipoRouter">
                                <option value="">Non presente</option>
                                <option value="Mako">Mako</option>
                                <option value="Zyxel">Zyxel</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iSerialeRouter" class="mt-2">SN-Router</label>
                            <input type="text" class="form-control mb-0" id="iSerialeRouter" name="SerialeRouter" readonly>
                        </div>
                        <?php } else { ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iStampante" class="mt-2">Stampante</label>
                            <select class="form-select py-1 mb-0" id="iStampante" name="Stampante">
                                <option value="">Non presente</option>
                                <option value="Epson TM-T7OII">Epson TM-T7OII</option>
                                <option value="SNBC">SNBC</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iTipoRouter" class="mt-2">Router</label>
                            <select class="form-select py-1 mb-0" id="iTipoRouter" name="TipoRouter">
                                <option value="">Non presente</option>
                                <option value="Mako">Mako</option>
                                <option value="Zyxel">Zyxel</option>
                                <option value="Teltonika">Teltonika</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <label for="iSerialeRouter" class="mt-2">SN-Router</label>
                            <input type="text" class="form-control mb-0" id="iSerialeRouter" name="SerialeRouter" readonly>
                        </div>
                        <?php } ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iIndirizzoIP" class="mt-2">Indirizzo IP</label>
                            <input type="text" class="form-control mb-0" id="iIndirizzoIP" name="IndirizzoIP" minlength="7" maxlength="15" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iAnydesk" class="mt-2">Anydesk *</label>
                            <input type="text" class="form-control mb-0" id="iAnydesk" name="Anydesk" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iDataCompilazione" class="mt-2">Compilato il</label>
                            <input type="text" class="form-control" id="iDataCompilazione" name="DataCompilazione" value="<?=date("d/m/Y");?>" readonly>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <label for="iCompilatore" class="mt-2">Compilatore</label>
                            <input type="text" class="form-control" id="iCompilatore" name="Compilatore" value="<?=$user?>" readonly>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="row">
                        <div class="col-12">
                            <label for="Note" class="font-weight-bold">Note</label>
                            <input type="text" class="form-control mb-0" id="Note" name="Note" maxlength="255">
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-green shadow-sm" type="submit"><i class="fas fa-plus"></i> Aggiungi</button>
                </div>
            </form>
        </div>
    </div>
</div>
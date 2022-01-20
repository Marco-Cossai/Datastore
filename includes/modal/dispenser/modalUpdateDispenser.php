<div class="modal fade" id="ModalUpdateDispenser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica erogatore</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" onchange="checkData('','dispenser')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="dispenser" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" id="uIdErogatore" name="Id" readonly>
                            <input type="hidden" class="form-control" id="uIdMAC_FK" name="IdMac_FK" readonly>
                            <input type="hidden" class="form-control" name="IdPlant_FK" value="<?=$_GET['id']?>" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="uTipoErogatore" class="mt-2">Tipo erogatore *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uTipoErogatore" name="TipoErogatore" required>
                                <?php foreach ($res1 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="uTestata" class="mt-2">Testata *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uTestata" name="Testata" required>
                                <?php foreach ($res2 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="uProtocollo" class="mt-2">Protocollo *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uProtocollo" name="Protocollo" required>
                                <?php foreach ($res3 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="uConvProtocollo" class="mt-2">Conv. protocollo *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uConvProtocollo" name="ConvProtocollo" required>
                                <?php foreach ($res4 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="uVersione" class="mt-2">Versione *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uVersione" name="Versione" required>
                                <?php foreach ($res5 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="uPistole" class="mt-2">Pistole *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uPistole" name="Pistole" required>
                                <?php for ($i = 1; $i <= 4; $i++) { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="uLato" class="mt-2">Lato *</label>
                            <select class="form-select py-1 mb-0 mt-1" id="uLato" name="Lato" required>
                                <?php for ($i = 1; $i <= 32; $i++) { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-dispenser"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
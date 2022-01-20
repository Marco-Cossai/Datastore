<div class="modal fade" id="ModalNewDispenser" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuovo erogatore</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" name="datamodule" value="dispenser" readonly>
                            <input type="hidden" class="form-control" name="action" value="insert" readonly>
                            <input type="hidden" class="form-control" id="idMAC" name="IdMac_FK" readonly>
                            <input type="hidden" class="form-control" name="IdPlant_FK" value="<?=$_GET['id']?>" readonly>
                            <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label class="mt-2">Tipo erogatore *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="TipoErogatore" required>
                                <option value=""></option>
                                <?php foreach ($res1 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="mt-2">Testata *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="Testata" required>
                                <option value=""></option>
                                <?php foreach ($res2 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="mt-2">Protocollo *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="Protocollo" required>
                                <option value=""></option>
                                <?php foreach ($res3 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="mt-2">Conv. protocollo *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="ConvProtocollo" required>
                                <option value=""></option>
                                <?php foreach ($res4 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="mt-2">Versione *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="Versione" required>
                                <option value=""></option>
                                <?php foreach ($res5 as $row) { ?>
                                <option value="<?=$row['Nome']?>"><?=$row['Nome']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="mt-2">Pistole *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="Pistole" required>
                                <option value=""></option>
                                <?php for ($i = 1; $i <= 4; $i++) { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="mt-2">Lato *</label>
                            <select class="form-select py-1 mb-0 mt-1" name="Lato" required>
                                <option value=""></option>
                                <?php for ($i = 1; $i <= 32; $i++) { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
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
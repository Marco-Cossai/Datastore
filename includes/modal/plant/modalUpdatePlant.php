<div class="modal fade" id="ModalUpdatePlant" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica impianto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST" onchange="checkData('update','plants')">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" class="form-control" id="uBusinessName" name="RagioneSociale" readonly>
                            <input type="hidden" class="form-control" name="datamodule" value="plants" readonly>
                            <input type="hidden" class="form-control" name="action" value="update" readonly>
                            <input type="hidden" class="form-control" id="uPage" name="page" readonly>
                            <input type="hidden" class="form-control" id="uId" name="IdImpianto" readonly>
                            <input type="hidden" class="form-control" id="uCustomer" name="IdCustomer_FK" readonly>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="uNamePlant" class="mt-2">Nome impianto *</label>
                            <input type="text" class="form-control mt-1 mb-0" id="uNamePlant" name="NomeImpianto" required>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="uEmail" class="mt-2">Email</label>
                            <input type="email" class="form-control mt-1 mb-0" id="uEmail" name="Email">
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <label for="uNumber" class="mt-2">Recapito</label>
                            <input type="text" class="form-control mt-1 mb-0" id="uNumber" name="Recapito">
                        </div>
                    </div>
                    <p class="text-muted pt-4 pb-0">* Campi obbligatori</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary shadow-sm disabled" type="submit" id="btn-submit-plants"><i class="far fa-edit"></i> Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>
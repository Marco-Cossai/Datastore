<!-- Content change password -->
<div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
    <div class="card shadow-sm border">
        <div class="card-header font-weight-bold">Modifica password</div>
        <form class="needs-validation" novalidate method="POST" action="database/database.php">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" class="form-control" name="datamodule" value="settings" readonly>
                        <input type="hidden" class="form-control" name="action" value="changePassword" readonly>
                        <input type="hidden" class="form-control" value="<?=$_SESSION['Username'];?>" name="Username" readonly>
                    </div>
                    <div class="col-12">
                        <label class="mt-2">Vecchia password *
                            <button type="button" class="border-0 bg-white px-2 py-1" data-mdb-toggle="popover" data-mdb-trigger="focus" title="Vecchia password" data-mdb-content="Se non la ricordi contattata un admin per farti creare una nuova password">
                                <i class="far fa-question-circle text-primary"></i>
                            </button>
                        </label>
                        <input type="password" class="form-control mt-1 mb-0" name="OldPassword" minlength="8" maxlength="16" required>
                    </div>
                    <div class="col-12">
                        <label class="mt-2">Nuova password *
                            <button type="button" class="border-0 bg-white px-2 py-1 " data-mdb-toggle="popover" data-mdb-trigger="focus" title="Nuova password" data-mdb-content="Deve contenere un minimo di 8 e un massimo di 16 caratteri">
                                <i class="far fa-question-circle text-primary"></i>
                            </button>
                        </label>
                        <input type="password" class="form-control mt-1 mb-0" name="NewPassword" minlength="8" maxlength="16" required>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 py-1">
                <button class="btn btn-primary shadow-sm float-end mb-3" type="submit" id="btn-submit"><i class="fas fa-save"></i> Salva</button>
            </div>
        </form>
    </div>
</div>
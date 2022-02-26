<div class="modal fade" id="ModalGetTicket" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assegnazione ticket</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="bug" readonly>
                    <input type="hidden" class="form-control" name="action" value="getTicket" readonly>
                    <input type="hidden" class="form-control" name="UsernameOpe" id="UsernameOpe" readonly>
                    <input type="hidden" class="form-control" name="Operatore" id="Operatore" readonly>

                    <h5 class="text-center text-dark pt-2">Vuoi prendere in carico questo ticket?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning shadow-sm" type="submit"><i class="fas fa-user-tag"></i> Prendi in carico</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="Logout" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body pt-4 pb-4">
                    <img src="img/other/exit.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-3">Vuoi davvero uscire?</h5>
                </div>
                <div class="modal-footer">
                    <?php $_SESSION['datamodule'] = 'logout';?>
                    <button class="btn btn-danger" type="submit" value="<?= $_SESSION['datamodule']; ?>" name="datamodule"><i class="fas fa-power-off"></i> Sign out</button>
                </div>
            </form>
        </div>
    </div>
</div>
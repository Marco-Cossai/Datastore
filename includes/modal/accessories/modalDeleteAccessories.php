<div class="modal fade" id="ModalDeleteAccessories" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Elimina accessori</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="database/database.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="datamodule" value="accessories" readonly>
                    <?php if($_SESSION['Ruolo'] == "Administrator") { ?>
                    <input type="hidden" class="form-control" name="action" value="delete" readonly>
                    <?php } else { ?>
                    <input type="hidden" class="form-control" name="action" value="request_delete_accessories" readonly>
                    <?php } ?>
                    <input type="hidden" class="form-control" name="Id" id="dId" readonly>
                    <input type="hidden" class="form-control" name="IdPlant_FK" id="dIdPlant_FK" readonly>
                    <input type="hidden" class="form-control" name="IdCustomer_FK" value="<?=$_GET['idCustomer']?>" readonly>
                    <img src="img/other/warning.png" class="mx-auto d-block img-fluid">
                    <h5 class="text-center text-dark pt-2">
                    <?php 
                        if($_SESSION['Ruolo'] == "Administrator") {
                            echo _("Vuoi davvero eliminare gli accessori?");
                        } else {
                            $idPlant = $_GET['id'];
                            $query = "SELECT * FROM `richieste_append` WHERE `IdImpianto_FK` = $idPlant AND `TabellaRichiesta` = 'accessories'";
                            $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                            if (!mysqli_fetch_array($result)) {
                                echo _("Verrà inviata una richiesta di cancellazione agli admin. Continuare?");
                            } else {
                                echo _("Richiesta di cancellazione già inoltrata");
                            }
                        }
                    ?>
                    </h5>
                </div>
                <div class="modal-footer">
                <?php if($_SESSION['Ruolo'] == "Administrator") { ?>
                    <button class="btn btn-danger" type="submit">Elimina</button>
                <?php 
                    } else {
                        $idPlant = $_GET['id'];
                        $query = "SELECT * FROM `richieste_append` WHERE `IdImpianto_FK` = $idPlant AND `TabellaRichiesta` = 'accessories'";
                        $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                        if (!mysqli_fetch_array($result)) {
                ?>
                    <button class="btn btn-green" type="submit">Si, invia</button> 
                <?php } else { ?>
                    <button class="btn btn-danger disabled" type="submit">Elimina</button> 
                <?php } }?>
                </div>
            </form>
        </div>
    </div>
</div>
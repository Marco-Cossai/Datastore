<!-- Log di inserimento -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border">
            <div class="card-body">
                <?php
                    $query = "SELECT * FROM `log` WHERE `Operazione` = 1 ORDER BY `IdLog` DESC";
                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                    if(mysqli_fetch_array($result)){
                ?>
                <div class="table-responsive">
                    <table id="dtLogInsert" class="table table-sm align-middle text-center py-4">
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Data</th>
                                <th class="th-sm">Messaggio</th>
                                <th class="th-sm">Operatore</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row) { ?>
                            <tr>
                                <td><?=$row['IdLog'];?></td>
                                <td><?=$row['DataLog'];?></td>
                                <td><?=$row['Messaggio'];?></td>
                                <td><?=$row['Compilatore'];?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <img src="img/other/log.png" class="img-fluid d-block mx-auto mt-2" />
                <h5 class="text-muted text-center pt-3">Non sono presenti log!</h5>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
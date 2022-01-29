<!-- Log di modifica -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border">
            <div class="card-body">
                <?php
                    $query = "SELECT * FROM `log` WHERE `Operazione` = 2 ORDER BY `IdLog` DESC";
                    $result = mysqli_query(connDB(),$query) or die(mysqli_error(connDB()));
                    if(mysqli_fetch_array($result)){
                ?>
                <div class="table-responsive">
                    <table id="dtLogUpdate" class="table table-sm align-middle text-center py-4">
                        <thead>
                            <tr>
                                <th class="th-sm">Id</th>
                                <th class="th-sm">Data</th>
                                <th class="th-sm">Messaggio</th>
                                <th class="th-sm">Operatore</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($result as $row) { 
                                    $aryLog = json_decode($row['Messaggio'],true);
                            ?>
                            <tr>
                                <td><?=$row['IdLog'];?></td>
                                <td><?=$row['DataLog'];?></td>
                                <td>
                                    <?php foreach ($aryLog['log'] as $v) { ?>
                                    <div class="rounded bg-dark-blue text-white px-4 py-2 mt-1">
                                        <span class="font-weight-bold"><?=stripslashes($v['field']);?>:</span> <?=stripslashes($v['old']);?> <i class="fas fa-long-arrow-alt-right mx-2"></i> <?=stripslashes($v['new']);?>
                                    </div>
                                    <?php } ?>
                                    <div class="rounded bg-green text-white px-4 py-2 mt-1">
                                        <?=stripslashes($aryLog['section']);?>
                                    </div>
                                </td>
                                <td><?=stripslashes($row['Compilatore']);?></td>
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
<!-- Content account -->
<div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
    <div class="card shadow-sm border">
        <div class="card-header font-weight-bold">Profilo utente</div>
        <form class="needs-validation" novalidate method="POST" action="database/database.php">
            <div class="card-body">
                <?php
                    $user = $_SESSION['Username'];
                    $result = mysqli_query(connDB(),"SELECT `IdUtente`,`Nome`,`Cognome`,`Sesso`,`Ruolo`,`Email`,`Username`,`Developer` FROM `utenti` WHERE `Username` = '$user'") or die (mysqli_error(connDB()));
                    if (mysqli_fetch_array($result)) {
                        foreach ($result as $row) {
                ?>
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" class="form-control" name="datamodule" value="settings" readonly>
                        <input type="hidden" class="form-control" name="action" value="changeAccount" readonly>
                        <input type="hidden" class="form-control" value="<?=$row['IdUtente'];?>" name="Id" readonly>
                        <input type="hidden" class="form-control" value="<?=$_SESSION['Ruolo'];?>" name="Ruolo" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="mt-2">Nome *</label>
                        <input type="text" class="form-control mt-1 mb-0" value="<?=$row['Nome'];?>" name="Nome" required>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="mt-2">Cognome *</label>
                        <input type="text" class="form-control mt-1 mb-0" value="<?=stripslashes($row['Cognome']);?>" name="Cognome" required>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="mt-2">Sesso *</label>
                        <select class="form-select mt-1 py-1" name="Sesso" required>
                            <?php if ($row['Sesso'] == 'Maschio') { ?>

                            <option value="<?=$row['Sesso'];?>"><?=$row['Sesso'];?></option>
                            <option value="Femmina">Femmina</option>
                            <option value="Non specificato">Non specificato</option>

                            <?php } elseif ($row['Sesso'] == 'Femmina') { ?>

                            <option value="<?=$row['Sesso'];?>"><?=$row['Sesso'];?></option>
                            <option value="Maschio">Maschio</option>
                            <option value="Non specificato">Non specificato</option>

                            <?php } else { ?>

                            <option value="<?=$row['Sesso'];?>"><?=$row['Sesso'];?></option>
                            <option value="Maschio">Maschio</option>
                            <option value="Femmina">Femmina</option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="mt-2">Ruolo</label>
                        <input type="text" class="form-control mt-1 mb-0" value="<?=$row['Ruolo'];?>" readonly>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <?php
                            $readonly = "";
                            if($_SESSION['Ruolo'] !== 'Administrator') { 
                                $readonly = "readonly";
                            } 
                        ?>
                        <label class="mt-2">Email</label>
                        <input type="email" class="form-control mt-1 mb-0" value="<?=stripslashes($row['Email']);?>" name="Email" <?=$readonly?>>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="mt-2">Username</label>
                        <input type="text" class="form-control mt-1 mb-0" value="<?=$row['Username'];?>" readonly>
                    </div>
                    <?php if($_SESSION['Ruolo'] === 'Administrator') { ?>
                    <div class="col-12">
                        <p class="text-muted mt-4">Attivando "<b>opzioni sviluppatore</b>" potrai visualizzare nel menu laterale la sezione dedicata alle procedure automatiche da lanciare</p>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="DevOptions" value="1" <?=$row['Developer'] == 1 ? "checked" : ""?>/>
                            <label class="form-check-label">Opzioni sviluppatore</label>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } }?>
            </div>
            <div class="card-footer border-0 py-1">
                <button class="btn btn-primary shadow-sm float-end mb-3" type="submit" id="btn-submit"><i class="fas fa-save"></i> Salva</button>
            </div>
        </form>
    </div>
</div>
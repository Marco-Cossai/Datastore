var initialValues;
var newValues;
//COSM #05 - Aggiunta software CashManager
var arraySoftware = ['BackOffice', 'Storesmart', 'Cardsmart', 'Quadrature', 'Puntimanager', 'Smartmanager', 'Gestock', 'CashManager'];


//==================================================+

function updateUser(data) {
    var select = $('#ModalUpdateUser #uRuolo').empty()
    $('#ModalUpdateUser #uId').val(data.IdUtente);
    $('#ModalUpdateUser #uUsername').val(data.Username);
    $('#ModalUpdateUser #uNome').val(data.Nome);
    $('#ModalUpdateUser #uCognome').val(data.Cognome);
    $('#ModalUpdateUser #uSesso').val(data.Sesso);
    $('#ModalUpdateUser #uRuolo').val(data.Ruolo);
    $('#ModalUpdateUser #uEmail').val(data.Email);
    $('#ModalUpdateUser').modal('show');

    var userOpt = document.createElement('option');
    var AdminOpt = document.createElement('option');
    userOpt.value = "User";
    userOpt.text= "User";
    AdminOpt.value = "Administrator";
    AdminOpt.text = "Administrator";

    if(data.Ruolo === "User") {
        select.append(userOpt);
        select.append(AdminOpt);
    }else if(data.Ruolo === "Administrator"){
        select.append(AdminOpt);
    }

    var old = {
        nome: $('#uNome').val(),
        cognome: $('#uCognome').val(),
        sesso: $('#uSesso').val(),
        ruolo: $('#uRuolo').val(),
        email: $('#uEmail').val(),
        username: $('#uUsername').val(),
        password: $('#uPassword').val()
    }
    initialValues = Object.values(old);
}

function deleteUser(data) {
    $('#ModalDeleteUser #id').val(data.IdUtente);
    $('#ModalDeleteUser').modal('show');
}

//==================================================+

function updateCustomer(data) {
    $('#ModalUpdateCustomer #uId').val(data.IdCliente);
    $('#ModalUpdateCustomer #uRagioneSociale').val(data.RagioneSociale);
    $('#ModalUpdateCustomer #uTipoCliente').val(data.TipoCliente);
    $('#ModalUpdateCustomer').modal('show');

    var old = {
        ragioneSociale: $('#uRagioneSociale').val(),
        tipologia: $('#uTipoCliente').val()
    }
    initialValues = Object.values(old);
}

function deleteCustomer(data) {
    $('#ModalDeleteCustomer #id').val(data.IdCliente);
    $('#ModalDeleteCustomer').modal('show');
}

//==================================================+
function newPlant(page_name) {
    $('#ModalNewPlant #page').val(page_name);
    $('#ModalNewPlant').modal('show');
}

function updatePlant(data) {
    $('#ModalUpdatePlant #uPage').val(data.CurrentPage);
    $('#ModalUpdatePlant #uId').val(data.IdImpianto);
    $('#ModalUpdatePlant #uNamePlant').val(data.NomeImpianto);
    $('#ModalUpdatePlant #uEmail').val(data.Email);
    $('#ModalUpdatePlant #uNumber').val(data.Recapito);
    $('#ModalUpdatePlant #uCustomer').val(data.IdCliente_FK);
    $('#ModalUpdatePlant #uBusinessName').val(data.RagioneSociale);
    $('#ModalUpdatePlant').modal('show');

    var old = {
        nomeImpianto: $('#uNamePlant').val(),
        email: $('#uEmail').val(),
        recapito: $('#uNumber').val(),
        customer: $('#uCustomer').val()
    }
    initialValues = Object.values(old);
}

function deletePlant(data) {
    $('#ModalDeletePlant #dPage').val(data.CurrentPage);
    $('#ModalDeletePlant #id').val(data.IdImpianto);
    $('#ModalDeletePlant #dIdCustomer').val(data.IdCliente_FK);
    $('#ModalDeletePlant').modal('show');
}

function migrationPlant(data) {
    $('#ModalPlantMigration #idPlant').val(data.IdImpianto);
    $('#ModalPlantMigration #idOldCustomer').val(data.IdCliente_FK);
    $('#ModalPlantMigration #oldBusinessName').val(data.RagioneSociale);
    $('#ModalPlantMigration').modal('show');
}

//==================================================+

function updatePC(data) {
    let arySoftware = [];
    let software;
    
    $('#ModalUpdatePC #uId').val(data.IdComputer);
    $('#ModalUpdatePC #uIdImpianto').val(data.IdImpianto_FK);
    $('#ModalUpdatePC #uMatricola').val(data.Matricola);
    $('#ModalUpdatePC #uModello').val(data.ModelloPC);
    $('#ModalUpdatePC #uArchitettura').val(data.Architettura);
    $('#ModalUpdatePC #uSerialePC').val(data.SerialePC);
    arraySoftware.forEach(e => {       
        if(data.Software.search(e) !== -1) {
            document.getElementById(`u${e}`).setAttribute('checked', 'checked');
        }
    });
    $('#ModalUpdatePC #uStampante').val(data.Stampante);
    $('#ModalUpdatePC #uPBL').val(data.PBL);
    $('#ModalUpdatePC #uTipoRouter').val(data.TipoRouter);
    $('#ModalUpdatePC #uSerialeRouter').val(data.SerialeRouter);
    $('#ModalUpdatePC #uIndirizzoIP').val(data.IP);
    if(data.TipoRouter !== "") {
        $('#ModalUpdatePC #uSerialeRouter').removeAttr('readonly');
        $('#ModalUpdatePC #uIndirizzoIP').removeAttr('readonly');
    }
    $('#ModalUpdatePC #uAnydesk').val(data.Anydesk);
    $('#ModalUpdatePC #uDataCompilazione').val(data.DataCompilazione);
    $('#ModalUpdatePC #uCompilatore').val(data.Compilatore);
    $('#ModalUpdatePC #uNote').val(data.Note);
    $('#ModalUpdatePC').modal('show');

    arraySoftware.forEach(e => {       
        let checkbox = document.getElementById(`u${e}`);
        let singleSoftware = $(`#u${e}`).val();
        if(checkbox.checked) {
            arySoftware.push(singleSoftware);
        }
    });
    software = JSON.stringify(arySoftware);
    
    var old = {
        matricola: $('#uMatricola').val(),
        modelloPC: $('#uModello').val(),
        architettura: $('#uArchitettura').val(),
        serialePC: $('#uSerialePC').val(),
        stampante: $('#uStampante').val(),
        software: software,
        pbl: $('#uPBL').val(),
        tiporouter: $('#uTipoRouter').val(),
        serialerouter: $('#uSerialeRouter').val(),
        ip: $('#uIndirizzoIP').val(),
        anydesk: $('#uAnydesk').val(),
        note: $('#uNote').val()
    }
    initialValues = Object.values(old);
}

function deletePC(data) {
    $('#ModalDeletePC #deleteId').val(data.IdComputer);
    $('#ModalDeletePC').modal('show');
}

//==================================================+

function updateMAC(data) {
    $('#ModalUpdateMAC #uIdMAC').val(data.IdMac);
    $('#ModalUpdateMAC #uNameMAC').val(data.Nome);
    $('#ModalUpdateMAC #uNumberMAC').val(data.Matricola);
    $('#ModalUpdateMAC #uModel').val(data.Modello);
    $('#ModalUpdateMAC #uPinpad').val(data.Pinpad);
    $('#ModalUpdateMAC #uCPU').val(data.CPU);
    $('#ModalUpdateMAC #uPrinterMAC').val(data.Stampante);
    $('#ModalUpdateMAC #uReader').val(data.Lettore);
    //COSM #06 - Aggiunta campo per salvataggio indirizzo IP
    $('#ModalUpdateMAC #uIpMAC').val(data.IndirizzoIP);
    $('#ModalUpdateMAC').modal('show');

    var old = {
        nameMAC: $('#uNameMAC').val(),
        numberMAC: $('#uNumberMAC').val(),
        model: $('#uModel').val(),
        pinpad: $('#uPinpad').val(),
        cpu: $('#uCPU').val(),
        printerMAC: $('#uPrinterMAC').val(),
        reader: $('#uReader').val(),
        //COSM #06 - Aggiunta campo per salvataggio indirizzo IP
        ip: $('#uIpMAC').val()
    }
    initialValues = Object.values(old);
}

function deleteAllMAC() {
    $('#ModalDeleteAllMAC').modal('show');
}

function deleteMAC(data) {
    $('#ModalDeleteMAC #dIdMAC').val(data.IdMac);
    $('#ModalDeleteMAC').modal('show');
}

//==================================================+

/* COSM #08 - Modifica che porta l'inserimento erogatori direttamente nel tab "Erogatori"
function newDispenser(data) {
    $('#ModalNewDispenser #idMAC').val(data.IdMac);
    $('#ModalNewDispenser').modal('show');
}
*/

function updateDispenser(data) {
    $('#ModalUpdateDispenser #uIdErogatore').val(data.IdErogatore);
    $('#ModalUpdateDispenser #uIdMAC_FK').val(data.IdMac_FK);
    $('#ModalUpdateDispenser #uTipoErogatore').val(data.TipoErogatore);
    $('#ModalUpdateDispenser #uTestata').val(data.Testata);
    $('#ModalUpdateDispenser #uProtocollo').val(data.Protocollo);
    $('#ModalUpdateDispenser #uConvProtocollo').val(data.ConvProtocollo);
    $('#ModalUpdateDispenser #uVersione').val(data.Versione);
    $('#ModalUpdateDispenser #uPistole').val(data.Pistole);
    $('#ModalUpdateDispenser #uLato').val(data.Lato);
    //COSM #08 - Modifica sezione 'Erogatori'
    if(data.IdMac_FK == 0) {
        $('#ModalUpdateDispenser #uMacAssoc').val('');
    } else {
        $('#ModalUpdateDispenser #uMacAssoc').val(data.IdMac_FK);
    }
    $('#ModalUpdateDispenser').modal('show');

    var old = {
        tipoerogatore: $('#uTipoErogatore').val(),
        testata: $('#uTestata').val(),
        protocollo: $('#uProtocollo').val(),
        convprotocollo: $('#uConvProtocollo').val(),
        versione: $('#uVersione').val(),
        pistole: $('#uPistole').val(),
        lato: $('#uLato').val(),
        //COSM #08 - Modifica sezione 'Erogatori'
        macAssoc: $('#uMacAssoc').val()
    }
    initialValues = Object.values(old);
}

function deleteDispenser(data) {
    $('#ModalDeleteDispenser #dIdErogatore').val(data.IdErogatore);
    $('#ModalDeleteDispenser').modal('show');
}

//COSM #08 - Modifica sezione 'Erogatori'
function deleteAllDispenser() {
    $('#ModalDeleteAllDispenser').modal('show');
}

//==================================================+
function acceptRequest(data) {
    $('#ModalAcceptRequest #tabRequest').val(data.TabellaRichiesta);
    $('#ModalAcceptRequest #idPlant').val(data.IdImpianto_FK);
    $('#ModalAcceptRequest #idCustomer').val(data.IdCliente_FK);
    $('#ModalAcceptRequest').modal('show');
}

function deleteRequest(data) {
    $('#ModalDeleteRequest #tabRequest').val('delete');
    $('#ModalDeleteRequest #idRequest').val(data.IdRichiesta);
    $('#ModalDeleteRequest #idPlant').val(data.IdImpianto_FK);
    $('#ModalDeleteRequest').modal('show');
}

function deleteAllRequests() {
    $('#ModalDeleteAllRequests #tabRequest').val('delete_all_requests');
    $('#ModalDeleteAllRequests').modal('show');
}

//==================================================+
function updateDataDispenser(data) {
    $('#ModalUpdateDataDispenser #uId').val(data.Id);
    $('#ModalUpdateDataDispenser #uNome').val(data.Nome);
    $('#ModalUpdateDataDispenser #uTipologia').val(data.Tipologia);
    $('#ModalUpdateDataDispenser').modal('show');

    var old = {
        nome: $('#uNome').val(),
        tipologia: $('#uTipologia').val(),
    }
    initialValues = Object.values(old);
}

function deleteDataDispenser(data) {
    $('#ModalDeleteDataDispenser #deleteID').val(data.Id);
    $('#ModalDeleteDataDispenser #dTipologia').val(data.Tipologia);
    $('#ModalDeleteDataDispenser').modal('show');
}

//==================================================+
function updateCTE(data) {
    $('#ModalUpdateCTE #uIdCTE').val(data.Id);
    $('#ModalUpdateCTE #tipoerogatore').val(data.TipoErogatore);
    $('#ModalUpdateCTE #testata').val(data.Testata);
    $('#ModalUpdateCTE #protocollo').val(data.Protocollo);
    $('#ModalUpdateCTE').modal('show');

    var old = {
        tipoerogatore: $('#tipoerogatore').val(),
        testata: $('#testata').val(),
        protocollo: $('#protocollo').val(),
    }
    initialValues = Object.values(old);
}

function deleteCTE(data) {
    $('#ModalDeleteCTE #dIdCTE').val(data.Id);
    $('#ModalDeleteCTE').modal('show');
}

//==================================================+
function updateCCP(data) {
    $('#ModalUpdateCCP #uIdCCP').val(data.Id);
    $('#ModalUpdateCCP #convprotocollo').val(data.ConvProtocollo);
    $('#ModalUpdateCCP #versione').val(data.Versione);
    $('#ModalUpdateCCP').modal('show');

    var old = {
        convprotocollo: $('#convprotocollo').val(),
        versione: $('#versione').val(),
    }
    initialValues = Object.values(old);
}

function deleteCCP(data) {
    $('#ModalDeleteCCP #dIdCCP').val(data.Id);
    $('#ModalDeleteCCP').modal('show');
}

//==================================================+
function updateAccessories(data) {
    $('#ModalUpdateAccessories #uId').val(data.Id);
    $('#ModalUpdateAccessories #uIdImpianto_FK').val(data.ID_IMPIANTO_FK);
    $('#ModalUpdateAccessories #uModelloPOS').val(data.MODELLO_POS);
    if(data.MODELLO_POS !== "") {
        $('#ModalUpdateAccessories #uTID').removeAttr('readonly');
        $('#ModalUpdateAccessories #uVersioneIFSF').removeAttr('readonly');
        $('#ModalUpdateAccessories #uIP_POS').removeAttr('readonly');
    }
    $('#ModalUpdateAccessories #uTID').val(data.TID);
    $('#ModalUpdateAccessories #uVersioneIFSF').val(data.VERSIONE_IFSF);
    $('#ModalUpdateAccessories #uIP_POS').val(data.IP_POS);
    $('#ModalUpdateAccessories #uQNT_RFID').val(data.QNT_RFID);
    $('#ModalUpdateAccessories #uIP_GTW').val(data.IP_GTW_RFID);
    $('#ModalUpdateAccessories #uMediaSmart').val(data.MEDIASMART);
    $('#ModalUpdateAccessories #uStampanti').val(data.STAMPANTI);
    $('#ModalUpdateAccessories #uIpSafetySmart').val(data.IP_SAFETYSMART);
    $('#ModalUpdateAccessories #uBackup').val(data.BACKUP);
    $('#ModalUpdateAccessories').modal('show');

    var old = {
        modelloPOS: $('#uModelloPOS').val(),
        TID: $('#uTID').val(),
        versioneIFSF: $('#uVersioneIFSF').val(),
        ipPOS: $('#uIP_POS').val(),
        qntRFID: $('#uQNT_RFID').val(),
        ipGTW: $('#uIP_GTW').val(),
        mediasmart: $('#uMediaSmart').val(),
        stampanti: $('#uStampanti').val(),
        ipSS: $('#uIpSafetySmart').val(),
        backup: $('#uBackup').val(),
	}
    initialValues = Object.values(old);
}

function deleteAccessories(data) {
    $('#ModalDeleteAccessories #dId').val(data.Id);
    $('#ModalDeleteAccessories #dIdPlant_FK').val(data.ID_IMPIANTO_FK);
    $('#ModalDeleteAccessories').modal('show');
}

//==================================================+

function getTicket(data) {
    $('#ModalGetTicket #idTicket').val(data[0]);
    $('#ModalGetTicket #usernameOpe').val(data[1]);
    $('#ModalGetTicket #operatore').val(data[2]);
    $('#ModalGetTicket').modal('show');
}



//==================================================+

function updateReportBug(data) {
    let select = $('#ModalUpdateBug #uStato').empty()
    $('#ModalUpdateBug #uId').val(data.Id);
    $('#ModalUpdateBug #uUtente').val(data.Utente);
    $('#ModalUpdateBug #uChiamante').val(data.Chiamante);
    $('#ModalUpdateBug #uDataApertura').val(data.DataApertura);
    $('#ModalUpdateBug #uUsernameOpe').val(data.UsernameOpe);
    $('#ModalUpdateBug #uOperatore').val(data.Operatore);
    $('#ModalUpdateBug #uDataChiusura').val(data.DataChiusura);
    $('#ModalUpdateBug #uEmail').val(data.Email);
    $('#ModalUpdateBug #uStato').val(data.Stato);
    $('#ModalUpdateBug #uAreaProblema').val(data.Area);
    $('#ModalUpdateBug #uImpatto').val(data.Impatto);
    $('#ModalUpdateBug #uPriorita').val(data.Priorita);
    $('#ModalUpdateBug #uOggetto').val(data.Oggetto);
    $('#ModalUpdateBug #uDescrizione').val(data.Descrizione);
    $('#ModalUpdateBug').modal('show');

    let newOpt = document.createElement('option');
    let processingOpt = document.createElement('option');
    let deliveredOpt = document.createElement('option');
    let closedOpt = document.createElement('option');

    newOpt.value = "1";
    newOpt.text= "Nuova";

    processingOpt.value = "2";
    processingOpt.text = "In lavorazione";

    deliveredOpt.value = "3";
    deliveredOpt.text = "Consegnata";

    closedOpt.value = "4";
    closedOpt.text = "Chiusa";

    if(data.Stato === "1" && data.FlagDev === "0") {
        select.append(newOpt);
    }else if(data.Stato === "2" && data.FlagDev === "0"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(processingOpt);
    } else if(data.Stato === "3" && data.FlagDev === "0"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(deliveredOpt);
        select.append(processingOpt);
        select.append(closedOpt);
        $('#uWorkNotes').prop('disabled', true);
    } else if(data.Stato === "4" && data.FlagDev === "0"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(closedOpt);
        $('#uWorkNotes').prop('disabled', true);
    } else if(data.Stato === "1" && data.FlagDev === "1"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(newOpt);
        select.append(processingOpt);
        $('#uWorkNotes').prop('disabled', true);
    } else if(data.Stato === "2" && data.FlagDev === "1"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(processingOpt);
        select.append(deliveredOpt);
    } else if(data.Stato === "3" && data.FlagDev === "1"){
        $('#uAreaProblema').prop('disabled', true);
        $('#uImpatto').prop('disabled', true);
        $('#uPriorita').prop('disabled', true);
        select.append(deliveredOpt);
    }

    var old = {
        stato: $('#uStato').val(),
        area: $('#uAreaProblema').val(),
        impatto: $('#uImpatto').val(),
        priorita: $('#uPriorita').val(),
        commenti: $('#uWorkNotes').val(),
    }
    initialValues = Object.values(old);
}


//==================================================+
function reloadTable() {
    location.reload();
}

function checkData(param,dm) {
    let arySoftware = [];
    let software;

    switch (dm) {
        case 'users':
            var newData = {
                nome: $('#uNome').val(),
                cognome: $('#uCognome').val(),
                sesso: $('#uSesso').val(),
                ruolo: $('#uRuolo').val(),
                email: $('#uEmail').val(),
                username: $('#uUsername').val(),
                password: $('#uPassword').val()
            }
            newValues = Object.values(newData);
        break;
        case 'customers':
            var newData = {
                ragioneSociale: $('#uRagioneSociale').val(),
                tipologia: $('#uTipoCliente').val()
            }
            newValues = Object.values(newData);
        break;
        case 'plants':
            var newData = {
                nomeImpianto: $('#uNamePlant').val(),
                email: $('#uEmail').val(),
                recapito: $('#uNumber').val(),
                customer: $('#uCustomer').val()
            }
            newValues = Object.values(newData);
        break;
        case 'computer':

            if(param){
                activeFieldsRouter(param);
            }

            arraySoftware.forEach(e => {       
                let checkbox = document.getElementById(`u${e}`);
                let singleSoftware = $(`#u${e}`).val();
                if(checkbox.checked) {
                    arySoftware.push(singleSoftware);
                }
            });
            software = JSON.stringify(arySoftware);

            var newData = {
                matricola: $('#uMatricola').val(),
                modelloPC: $('#uModello').val(),
                architettura: $('#uArchitettura').val(),
                serialePC: $('#uSerialePC').val(),
                stampante: $('#uStampante').val(),
                software: software,
                pbl: $('#uPBL').val(),
                tiporouter: $('#uTipoRouter').val(),
                serialerouter: $('#uSerialeRouter').val(),
                ip: $('#uIndirizzoIP').val(),
                anydesk: $('#uAnydesk').val(),
                note: $('#uNote').val()
            }
            newValues = Object.values(newData);
        break;
        case 'mac':
            var newData = {
                nameMAC: $('#uNameMAC').val(),
                numberMAC: $('#uNumberMAC').val(),
                model: $('#uModel').val(),
                pinpad: $('#uPinpad').val(),
                cpu: $('#uCPU').val(),
                printerMAC: $('#uPrinterMAC').val(),
                reader: $('#uReader').val(),
                //COSM #06 - Aggiunta campo per salvataggio indirizzo IP
                ip: $('#uIpMAC').val()
            }
            newValues = Object.values(newData);
        break;
        case 'dispenser':
            var newData = {
                tipoerogatore: $('#uTipoErogatore').val(),
                testata: $('#uTestata').val(),
                protocollo: $('#uProtocollo').val(),
                convprotocollo: $('#uConvProtocollo').val(),
                versione: $('#uVersione').val(),
                pistole: $('#uPistole').val(),
                lato: $('#uLato').val(),
                //COSM #08 - Modifica sezione 'Erogatori'
                macAssoc: $('#uMacAssoc').val()
            }
            newValues = Object.values(newData);
        break;
        //COSM #09 - Aggiunta sezione accessori
        case 'accessories':

            if(param){
                activeFieldsPOS(param);
            }
            
            var newData = {
                modelloPOS: $('#uModelloPOS').val(),
                TID: $('#uTID').val(),
                versioneIFSF: $('#uVersioneIFSF').val(),
                ipPOS: $('#uIP_POS').val(),
                qntRFID: $('#uQNT_RFID').val(),
                ipGTW: $('#uIP_GTW').val(),
                mediasmart: $('#uMediaSmart').val(),
                stampanti: $('#uStampanti').val(),
                ipSS: $('#uIpSafetySmart').val(),
                backup: $('#uBackup').val(),
            }
            newValues = Object.values(newData);
        break;
        case 'configuration':
            var newData = {
                nome: $('#uNome').val(),
                tipologia: $('#uTipologia').val(),
            }
            newValues = Object.values(newData);
        break;
        case 'configCTE':
            var newData = {
                tipoerogatore: $('#tipoerogatore').val(),
                testata: $('#testata').val(),
                protocollo: $('#protocollo').val(),
            }
            newValues = Object.values(newData);
        break;
        case 'configCCP':
            var newData = {
                convprotocollo: $('#convprotocollo').val(),
                versione: $('#versione').val(),
            }
            newValues = Object.values(newData);
        break;
        case 'bug':
            var newData = {
                stato: $('#uStato').val(),
                area: $('#uAreaProblema').val(),
                impatto: $('#uImpatto').val(),
                priorita: $('#uPriorita').val(),
                commenti: $('#uWorkNotes').val(),
            }
            newValues = Object.values(newData);
        break;
    }
    
    let submitButton = document.querySelector("#btn-submit-" + dm);
    if (newValues.every((el, index) => el === initialValues[index])) {
        submitButton.classList.add('disabled');
    } else {
        submitButton.classList.remove('disabled');
    }
}

function activeFieldsRouter(param) {
    let prefix = '';
    if(param === "insert") { prefix = 'i'; }
    if(param === "update") { prefix = 'u'; }

    let typeRouter = $('#'+prefix+'TipoRouter').val();
    
    if(typeRouter !== "") {
        $('#'+prefix+'SerialeRouter').removeAttr('readonly');
        $('#'+prefix+'IndirizzoIP').removeAttr('readonly');
    } else if(typeRouter === "") {
        $('#'+prefix+'SerialeRouter').prop('readonly', true);
        $('#'+prefix+'SerialeRouter').val('');
        $('#'+prefix+'IndirizzoIP').prop('readonly', true);
        $('#'+prefix+'IndirizzoIP').val('');
    }
}

//COSM #09 - Aggiunta sezione accessori
function activeFieldsPOS(param) {
    let prefix = '';
    if(param === "insert") { prefix = 'i'; }
    if(param === "update") { prefix = 'u'; }

    let POSModel = $('#'+prefix+'ModelloPOS').val();
    
    if(POSModel !== "") {
        $('#'+prefix+'TID').removeAttr('readonly');
        $('#'+prefix+'VersioneIFSF').removeAttr('readonly');
        $('#'+prefix+'IP_POS').removeAttr('readonly');
    } else if(POSModel === "") {
        $('#'+prefix+'TID').prop('readonly', true);
        $('#'+prefix+'TID').val('');
        $('#'+prefix+'VersioneIFSF').prop('readonly', true);
        $('#'+prefix+'VersioneIFSF').val('');
        $('#'+prefix+'IP_POS').prop('readonly', true);
        $('#'+prefix+'IP_POS').val('');
    }
}
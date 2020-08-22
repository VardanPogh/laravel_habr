var serviceType = ''
function openUsedServiceForm(type){

    if (type == 1){
        serviceType = type
        $('.ullService').show()
        $('.acqService').hide();
        $('.mnpService').hide()
        $('.conversionService').hide()
        $('.nipService').hide()
    }else if (type == 5){
        serviceType = type
        $('.acqService').show()
        $('.ullService').hide()
        $('.mnpService').hide()
        $('.conversionService').hide()
        $('.nipService').hide()
    }else if (type == 2){
        serviceType = type
        $('.nipService').show()
        $('.acqService').hide();
        $('.mnpService').hide()
        $('.conversionService').hide()
        $('.ullService').hide()
    }else if (type == 3){
        serviceType = type
        $('.conversionService').show()
        $('.ullService').hide()
        $('.acqService').hide();
        $('.mnpService').hide()
        $('.nipService').hide()
    }else if (type == 4){
        serviceType = type
        $('.mnpService').show()
        $('.ullService').hide()
        $('.acqService').hide();
        $('.nipService').hide();
        $('.conversionService').hide()
    }
}
function addConfirmReload() {
    var confirmReloadService = $('#confirmReloadService');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    form.append("reloaded_number", $('[name=reloaded_number]', confirmReloadService).val());
    form.append("confirm_reloaded_number", $('[name=confirm_reloaded_number]', confirmReloadService).val());
    form.append("service_id", $('[name=service_id]', confirmReloadService).val());



    const config = {
        onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progressRelaod').parent().removeAttr('style')
            $('#progressRelaod').remove()
            $('#progressProcentReload').show()
            $('#progressProcentReload').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcentReload').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/services_reload_confirm',
        form, config
    ).then((resolve) => {
        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcentReload').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
function addUllTransaction() {
    var ullForm = $('#form1');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    $("[type='file']", ullForm).each(function(){
        inp = $(this);
        console.log(inp)
        form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
    })


    form.append("first_name", $('[name=first_name]', ullForm).val());
    form.append("last_name", $('[name=last_name]', ullForm).val());
    form.append("tax_code", $('[name=tax_code]', ullForm).val());
    form.append("birthday", $('[name=birthday]', ullForm).val());
    form.append("mobile",  $('[name=mobile]', ullForm).val());
    form.append("birth_place",  $('[name=birth_place]', ullForm).val());
    form.append("provincia", $('inut[name=provincia]', ullForm).val());
    form.append("gender",  $('[name=gender]', ullForm).val());
    form.append("email",  $('[name=email]', ullForm).val());
    form.append("document_number",  $('[name=document_number]', ullForm).val());
    form.append("document_date", $('[name=document_date]', ullForm).val());
    form.append("document_type", $('[name=document_type]', ullForm).val());
    form.append("issue_date", $('[name=issue_date]',ullForm).val());
    form.append("expiry_date", $('[name=expiry_date]',ullForm).val());
    form.append("place_of_issue", $('[name=place_of_issue]',ullForm).val());
    form.append("issuing_body", $('[name=issuing_body]',ullForm).val());
    form.append("emission_province", $('[name=emission_province]',ullForm).val());
    form.append("province", $('[name=province]',ullForm).val());
    form.append("plant_location_address", $('[name=plant_location_address]',ullForm).val());
    form.append("new_sim_number", $('[name=new_sim_number]',ullForm).val());
    form.append("type_of_document", $('[name=type_of_document]',ullForm).val());
    form.append("current_manager", $('[name=current_manager]',ullForm).val());
    form.append("migration_code", $('[name=migration_code]',ullForm).val());
    form.append("current_landline_number", $('[name=current_landline_number]',ullForm).val());
    form.append("alternative_telephone_number", $('[name=alternative_telephone_number]',ullForm).val());
    form.append("service_id", $('[name=service_id]',ullForm).val());

    const config = {
        onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progress1').parent().removeAttr('style')
            $('#progress1').remove()
            $('#progressProcent1').show()
            $('#progressProcent1').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcent1').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/ull_transaction',
      form, config
    ).then((resolve) => {

        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcent1').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
function addAcqTransaction() {
    var acqForm = $('#form5');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    $("[type='file']", acqForm).each(function(){
        inp = $(this);
        console.log(inp)
        form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
    })


    form.append("first_name", $('[name=first_name]', acqForm).val());
    form.append("last_name", $('[name=last_name]', acqForm).val());
    form.append("tax_code", $('[name=tax_code]', acqForm).val());
    form.append("birthday", $('[name=birthday]', acqForm).val());
    form.append("mobile",  $('[name=mobile]', acqForm).val());
    form.append("birth_place",  $('[name=birth_place]', acqForm).val());
    form.append("provincia", $('inut[name=provincia]', acqForm).val());
    form.append("gender",  $('[name=gender]', acqForm).val());
    form.append("email",  $('[name=email]', acqForm).val());
    form.append("document_number",  $('[name=document_number]', acqForm).val());
    form.append("document_date", $('[name=document_date]', acqForm).val());
    form.append("document_type", $('[name=document_type]', acqForm).val());
    form.append("issue_date", $('[name=issue_date]',acqForm).val());
    form.append("expiry_date", $('[name=expiry_date]',acqForm).val());
    form.append("place_of_issue", $('[name=place_of_issue]',acqForm).val());
    form.append("issuing_body", $('[name=issuing_body]',acqForm).val());
    form.append("type_of_document", $('[name=type_of_document]',acqForm).val());
    form.append("emission_province", $('[name=emission_province]',acqForm).val());
    form.append("province", $('[name=province]',acqForm).val());
    form.append("iccid_serial_sim", $('[name=iccid_serial_sim]',acqForm).val());
    form.append("iccid_serial_sim_2", $('[name=iccid_serial_sim_2]',acqForm).val());
    form.append("new_sim_number", $('[name=new_sim_number]',acqForm).val());
    form.append("service_id", $('[name=service_id]',acqForm).val());
    form.append("client_id", $('[name=client_id]',acqForm).val());

    const config = {
        onUploadProgress: function(progressEvent) {
            let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progress5').parent().removeAttr('style')
            $('#progress5').remove()
            $('#progressProcent5').show()
            $('#progressProcent5').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcent5').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/acq_transaction',
        form, config
    ).then((resolve) => {
        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcent5').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
function addNipTransaction() {
    var nipForm = $('#form2');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    $("[type='file']", nipForm).each(function(){
        inp = $(this);
        console.log(inp)
        form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
    })


    form.append("first_name", $('[name=first_name]', nipForm).val());
    form.append("last_name", $('[name=last_name]', nipForm).val());
    form.append("tax_code", $('[name=tax_code]', nipForm).val());
    form.append("birthday", $('[name=birthday]', nipForm).val());
    form.append("mobile",  $('[name=mobile]', nipForm).val());
    form.append("birth_place",  $('[name=birth_place]', nipForm).val());
    form.append("provincia", $('inut[name=provincia]', nipForm).val());
    form.append("gender",  $('[name=gender]', nipForm).val());
    form.append("email",  $('[name=email]', nipForm).val());
    form.append("document_number",  $('[name=document_number]', nipForm).val());
    form.append("document_date", $('[name=document_date]', nipForm).val());
    form.append("document_type", $('[name=document_type]', nipForm).val());
    form.append("issue_date", $('[name=issue_date]',nipForm).val());
    form.append("expiry_date", $('[name=expiry_date]',nipForm).val());
    form.append("place_of_issue", $('[name=place_of_issue]',nipForm).val());
    form.append("issuing_body", $('[name=issuing_body]',nipForm).val());
    form.append("type_of_document", $('[name=type_of_document]',nipForm).val());
    form.append("emission_province", $('[name=emission_province]',nipForm).val());
    form.append("province", $('[name=province]',nipForm).val());
    form.append("plant_location_address", $('[name=plant_location_address]',nipForm).val());
    form.append("alternative_telephone_number", $('[name=alternative_telephone_number]',nipForm).val());

    form.append("client_id", $('[name=client_id]',nipForm).val());
    form.append("service_id", $('[name=service_id]',nipForm).val());

    const config = {
        onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progress2').parent().removeAttr('style')
            $('#progress2').remove()
            $('#progressProcent2').show()
            $('#progressProcent2').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcent2').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/nip_transaction',
        form, config
    ).then((resolve) => {

        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcent2').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
function addConversionTransaction() {
    var conversionForm = $('#form3');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    $("[type='file']", conversionForm).each(function(){
        inp = $(this);
        console.log(inp)
        form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
    })


    form.append("first_name", $('[name=first_name]', conversionForm).val());
    form.append("last_name", $('[name=last_name]', conversionForm).val());
    form.append("tax_code", $('[name=tax_code]', conversionForm).val());
    form.append("mobile",  $('[name=mobile]', conversionForm).val());
    form.append("birthday", $('[name=birthday]', conversionForm).val());
    form.append("birth_place", $('[name=birth_place]', conversionForm).val());
    form.append("provincia", $('inut[name=provincia]', conversionForm).val());
    form.append("gender",  $('[name=gender]', conversionForm).val());
    form.append("email",  $('[name=email]', conversionForm).val());
    form.append("document_number",  $('[name=document_number]', conversionForm).val());
    form.append("document_date", $('[name=document_date]', conversionForm).val());
    form.append("document_type", $('[name=document_type]', conversionForm).val());
    form.append("issue_date", $('[name=issue_date]',conversionForm).val());
    form.append("expiry_date", $('[name=expiry_date]',conversionForm).val());
    form.append("place_of_issue", $('[name=place_of_issue]',conversionForm).val());
    form.append("issuing_body", $('[name=issuing_body]',conversionForm).val());
    form.append("type_of_document", $('[name=type_of_document]',conversionForm).val());
    form.append("emission_province", $('[name=emission_province]',conversionForm).val());
    form.append("province", $('[name=province]',conversionForm).val());
    form.append("plant_location_address", $('[name=plant_location_address]',conversionForm).val());
    form.append("alternative_telephone_number", $('[name=alternative_telephone_number]',conversionForm).val());
    form.append("fixed_tim_number", $('[name=fixed_tim_number]',conversionForm).val());

    form.append("client_id", $('[name=client_id]',conversionForm).val());
    form.append("service_id", $('[name=service_id]',conversionForm).val());

    const config = {
        onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progress3').parent().removeAttr('style')
            $('#progress3').remove()
            $('#progress3').show()
            $('#progressProcent3').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcent3').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/conversion_transaction',
        form, config
    ).then((resolve) => {

        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcent3').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
function addMnpTransaction() {
    var mnpForm = $('#form4');
    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };

    $("[type='file']", mnpForm).each(function(){
        inp = $(this);
        console.log(inp)
        form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
    })


    form.append("first_name", $('[name=first_name]', mnpForm).val());
    form.append("last_name", $('[name=last_name]', mnpForm).val());
    form.append("tax_code", $('[name=tax_code]', mnpForm).val());
    form.append("mobile",  $('[name=mobile]', mnpForm).val());
    form.append("birthday", $('[name=birthday]', mnpForm).val());
    form.append("birth_place",  $('[name=birth_place]', mnpForm).val());
    form.append("provincia", $('inut[name=provincia]', mnpForm).val());
    form.append("gender",  $('[name=gender]', mnpForm).val());
    form.append("email",  $('[name=email]', mnpForm).val());
    form.append("document_number",  $('[name=document_number]', mnpForm).val());
    form.append("document_date", $('[name=document_date]', mnpForm).val());
    form.append("document_type", $('[name=document_type]', mnpForm).val());
    form.append("issue_date", $('[name=issue_date]',mnpForm).val());
    form.append("expiry_date", $('[name=expiry_date]',mnpForm).val());
    form.append("place_of_issue", $('[name=place_of_issue]',mnpForm).val());
    form.append("issuing_body", $('[name=issuing_body]',mnpForm).val());
    form.append("type_of_document", $('[name=type_of_document]',mnpForm).val());
    form.append("emission_province", $('[name=emission_province]',mnpForm).val());
    form.append("province", $('[name=province]',mnpForm).val());
    form.append("iccid_serial_sim", $('[name=iccid_serial_sim]',mnpForm).val());
    form.append("current_mobile_operator", $('[name=current_mobile_operator]',mnpForm).val());
    form.append("temporary_tim_number", $('[name=temporary_tim_number]',mnpForm).val());

    form.append("service_id", $('[name=service_id]',mnpForm).val());
    form.append("client_id", $('[name=client_id]',mnpForm).val());

    const config = {
        onUploadProgress: function(progressEvent) {
            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            $('#progress4').parent().removeAttr('style')
            $('#progress4').remove()
            $('#progressProcent4').show()
            $('#progressProcent4').attr('style', 'width: '+percentCompleted+'%')
            $('#progressProcent4').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/mnp_transaction',
        form, config
    ).then((resolve) => {
        window.location.replace("/agent/transaction");
    }).catch((error) => {
        $('#progressProcent4').hide()
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}
window.onload = function() {
    const confirmReloadedNumber = document.getElementById('confirmReloadedNumber');
    confirmReloadedNumber.onpaste = function(e) {
        e.preventDefault();
    }
}

function getServiceTaxCode(){
    let data = {}
    if (serviceType == 5){
        var acqForm = $('#form5');
        data = $('[name=tax_code]', acqForm).val()
    }
    if (serviceType == 1){
        var ullForm = $('#form1');
        data = $('[name=tax_code]', ullForm).val()
    }

    if (serviceType == 2){
        var nipForm = $('#form2');
        data = $('[name=tax_code]', nipForm).val()
    }

    if (serviceType == 3){
        var conversionForm = $('#form3');
        data = $('[name=tax_code]', conversionForm).val()
    }

    if (serviceType == 4){
        var mnpForm = $('#form4');
        data = $('[name=tax_code]', mnpForm).val()
    }
    return data
}

function addFiscalCode() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: '/agent/tax-code',
        data: {tax_code: getServiceTaxCode()},
        success: resolve => {
            notifyWarFiscalTransaction(resolve);
        },
        error: error => {
            //notify('danger', error.responseJSON.message)
        }
    });
}

function notifyWarFiscalTransaction(data) {
    Swal.fire({
        background: '#ffc107',
        confirmButtonText: 'Load client data',
        showCancelButton: true,
        cancelButtonText: 'Create New',
        preConfirm: () => {
            $('[name=client_id]', $('#form'+ serviceType)).val(data.data.id)
            editInput(data);
        },
    })

}

function changeFixedServiceClientDate() {
    if ($('[name=birthday]', $('#form'+ serviceType)).val()) {
        let thbrt = moment($('[name=birthday]', $('#form'+ serviceType)).val());
        let nowdy = moment();
        let t = thbrt.from(nowdy).split(' ')[0];
        if (t < 18 || t == 'in') {
            this.notifyWar('warning');
        }
    }
}


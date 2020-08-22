
var errorMessage = {};


$(document).ready(function(){
    $('input[type="file"]').change(function(event){
        $(this).next('label').html(event.target.files[0].name);
    });

    $("input").change(event=>{
        errorChange(event.target.attributes.name.value)
    });
});


function changeType(){
    $('fieldset').toggleClass('d-none')
}

function addEditClients() {

    const form = new FormData();
    const header = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'multipart/form-data',
    };


    if ($("[name=id]").val()) {
        form.append('id', $("[name=id]").val());
    }


    if ($("[name='type']:checked").val() == 1) {
        $("[type='file']").each(function(){
            inp = $(this);
            console.log(inp)
            form.append(inp.attr('ref'), inp[0].files[0] != undefined ? inp[0].files[0] : '');
        })

    }

        form.append("first_name", $('[name=first_name]').val());
        form.append("last_name", $('[name=last_name]').val());
        form.append("service_id", $('[name=service_id]').val());
        form.append("address", $('[name=address]').val());
        form.append("cap", $('[name=cap]').val());
        form.append("tax_code", $('[name=tax_code]').val());
        form.append("house_number", $('[name=house_number]').val());
        form.append("birthday", $('[name=birthday]').val());
        form.append("manager", $("[name=manager] option:selected").val());


        form.append("type", $('[name=type]:checked').val());
        form.append("provincia", $('inut[name=provincia]').val());
        form.append("city", $('[name=city]').val());
        form.append("fixed_delivery", $('[name=fixed_delivery]').val());
        form.append("fixed_manager", $('[name=fixed_manager]').val());
        form.append("mobile_delivery", $('[name=mobile_delivery]').val());
        form.append("alternative_mobile", $('[name=alternative_mobile]').val());
        form.append("mobile",  $('[name=mobile]').val());
        form.append("email",  $('[name=email]').val());
        form.append("birth_place",  $('[name=birth_place]').val());
        form.append("birth_provincia",  $('[name=birth_provincia]').val());
        form.append("gender",  $('[name=service_id]').val());
        form.append("vat_number", $('[name=gender]:checked').val());
        form.append("business_name", $('[name=business_name]').val());
        form.append("alternative_email", $('[name=alternative_email]').val());

    $('.privato [type=date]').each(function(){
        inp = $(this);
        form.append(inp.attr('name'), inp.val() );
    });

    $('.privato select').each(function(){
        inp = $(this);
        form.append(inp.attr('name'), inp.val() );
    })

    const config = {
        onUploadProgress: function(progressEvent) {
        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        $('#progress').parent().removeAttr('style')
        $('#progress').attr('style', 'width: '+percentCompleted+'%')
        $('#progressProcent').html(percentCompleted+'%')
        },
        headers: header
    }

    axios.post(
        '/agent/add-client',
        form, config
    ).then((resolve) => {

        window.location.replace("/agent/transaction");
    }).catch((error) => {
        errorMessage = error.response.data.errors;
        errorFunction();
        notify('danger', error.response.data.message);
    });
}

function errorFunction() {
    if(Object.keys(errorMessage).length) {
        for(let i in errorMessage) {
            $("[name="+i+"]").addClass('is-invalid');
            $("#"+i).addClass('error');
            $("#"+i).html(errorMessage[i][0]);
        }
    }
}

function errorChange(name) {
    if(Object.keys(errorMessage).length) {
        if (errorMessage[name]) {
            $("[name="+name+"]").removeClass('is-invalid');
            $("#"+name).removeClass('error');
            $("#"+name).html();
        }
    }
}

function fiscalCode() {
    console.log($('#taxCodeInput').val())
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: '/agent/tax-code',
        data: { tax_code: $('#taxCodeInput').val() },
        success: resolve => {
            notifyWarFiscal(resolve);
        },
        error: error => {
            //notify('danger', error.responseJSON.message)
        }
    });
}

function editInput(resolve) {

    if (Object.keys(resolve.data).length) {
        $("[name=id]").val(resolve.data.id);
        $("[name=first_name]").val(resolve.data.first_name);
        $("[name=last_name]").val(resolve.data.last_name);
        $("[name=address]").val(resolve.data.address);
        $("[name=house_number]").val(resolve.data.house_number);
        $("[name=birthday]").val(resolve.data.birthday);
        $("[name=city]").val(resolve.data.city);
        $("[name=provincia]").val(resolve.data.provincia);
        $("[name=birth_place]").val(resolve.data.birth_place);
        $("[name=birth_provincia]").val(resolve.data.birth_provincia);
        $("[name=fixed_delivery]").val(resolve.data.fixed_delivery);
        $("[name=fixed_manager]").val(resolve.data.fixed_manager);
        $("[name=mobile]").val(resolve.data.mobile);
        $("[name=mobile_delivery]").val(resolve.data.mobile_delivery);
        $("[name=alternative_mobile]").val(resolve.data.alternative_mobile);
        $("[name=email]").val(resolve.data.email);
        $("[name=alternative_email]").val(resolve.data.alternative_email);
        $("[name=business_name]").val(resolve.data.business_name);
        $("[name=vat_number]").val(resolve.data.vat_number);
        $("[name=cap]").val(resolve.data.cap);
        $(".gender [value='"+resolve.data.gender+"']").prop('checked', true)
        if(resolve.data.manager){
            $('#managerOptions option[value='+resolve.data.manager.id+']').prop('selected',  true);
        }

    }
}

function changeDate() {
    if ($('#birthdayInput').val()) {
        let thbrt = moment($('#birthdayInput').val());
        let nowdy = moment();
        let t = thbrt.from(nowdy).split(' ')[0];
        if (t < 18 || t == 'in') {
            this.notifyWar('warning');
        }
    }
}

function notifyWarFiscal(data) {

    Swal.fire({
        background: '#ffc107',
        confirmButtonText: 'Load client data',
        showCancelButton: true,
        cancelButtonText: 'Create New',
        preConfirm: () => {

            editInput(data);
        },
    })

}

function notifyWar(type, text) {

    Swal.fire({
        text: 'The client is less than 18 years old',
        background: '#ffc107',
        icon: type,
        confirmButtonText: 'close'
    })

}

function notify(type, text){
    var icon, bg_color;
    if (type == 'success') {
        icon = `<i class="far fa-check-circle float-left"></i>`;
        bg_color = '#28a74580';
    } else if(type == 'danger') {
        icon = `<i class="fas fa-times float-left"></i>`;
        bg_color = '#dc354580';
    }

    Swal.fire({
        html: `<div class="h4 text-dark m-0">`+icon + text + `</div>`,
        position: 'top-end',
        background: bg_color,
        width: '30%',
        timer: '2000',
        showConfirmButton: false
    })

}

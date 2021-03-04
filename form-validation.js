var initialErrorMessage = '';

$(document).ready(function() {
    $('#form-validation-success').addClass('fv-d-none');
    $('#form-validation-error').addClass('fv-d-none');
});

function work(data, callback){
    var json = JSON.parse(data);
        
    console.log(json);

    $('#form-validation-success').addClass('fv-d-none');
    $('#form-validation-error').addClass('fv-d-none');

    if (json.result) {
        $('.input-error').removeClass('input-error');
        $('#form-validation-success').removeClass('fv-d-none');
        callback();
    } else {
        $('.input-error').removeClass('input-error');
        for (const property in json.errors) {
            var field = $('#' + property + '-error');

            $(field).addClass('input-error');
        }

        if (initialErrorMessage == '') {
            initialErrorMessage = $('#form-validation-error').html();
        }

        if (json.displayError != '') {
            $('#form-validation-error').html(json.displayError);
        }else {
            $('#form-validation-error').html(initialErrorMessage);
        }

        $('#form-validation-error').removeClass('fv-d-none');
    }
}

function validateForm(event, form, callback = (() => {})) {
    event.preventDefault();

    var formValues = $(form).serialize();

    console.log(formValues);

    switch ($(form).attr('method').toLowerCase()) {
        case 'get':
            $.get($(form).attr('action'), formValues, function (data) {
                work(data, callback);
            });
            break;

        case 'post':
            $.post($(form).attr('action'), formValues, function (data) {
                work(data, callback);
            });
            break;
    
        default:
            break;
    }

    
}
$(document).ready(function() {
    $('#form-validation-success').addClass('fv-d-none');
    $('#form-validation-error').addClass('fv-d-none');
});

function validateForm(event, form) {
    event.preventDefault();

    var formValues = $(form).serialize();

    console.log(formValues);

    switch ($(form).attr('method').toLowerCase()) {
        case 'get':
            $.get($(form).attr('action'), formValues, function (data) {
                var json = JSON.parse(data);
        
                console.log(json);
        
                $('#form-validation-success').addClass('fv-d-none');
                $('#form-validation-error').addClass('fv-d-none');

                if (json.result) {
                    $('.input-error').removeClass('input-error');
                    $('#form-validation-success').removeClass('fv-d-none');
                } else {
                    $('.input-error').removeClass('input-error');
                    for (const property in json.errors) {
                        var field = $('#' + property + '-error');
        
                        $(field).addClass('input-error');
                    }
                    $('#form-validation-error').removeClass('fv-d-none');
                }
            });
            break;

        case 'post':
            $.post($(form).attr('action'), formValues, function (data) {
                var json = JSON.parse(data);
        
                console.log(json);
        
                $('#form-validation-success').addClass('fv-d-none');
                $('#form-validation-error').addClass('fv-d-none');

                if (json.result) {
                    $('.input-error').removeClass('input-error');
                    $('#form-validation-success').removeClass('fv-d-none');
                } else {
                    $('.input-error').removeClass('input-error');
                    for (const property in json.errors) {
                        var field = $('#' + property + '-error');
        
                        $(field).addClass('input-error');
                    }
                    $('#form-validation-error').removeClass('fv-d-none');
                }
            });
            break;
    
        default:
            break;
    }

    
}
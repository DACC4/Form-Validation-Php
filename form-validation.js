

function validateForm(event, form) {
    event.preventDefault();

    var formValues = $(form).serialize();

    console.log(formValues);

    switch ($(form).attr('method')) {
        case 'get':
            $.get($(form).attr('action'), formValues, function (data) {
                var json = JSON.parse(data);
        
                console.log(json);
        
                if (json.result) {
                    alert('IOUPY');
                    return true;
                } else {
                    $('.input-error').removeClass('input-error');
                    for (const property in json.errors) {
                        var field = $('#' + property + '-error');
        
                        $(field).addClass('input-error');
                    }
                }
                return false;
            });
            break;

        case 'post':
            $.post($(form).attr('action'), formValues, function (data) {
                var json = JSON.parse(data);
        
                console.log(json);
        
                if (json.result) {
                    alert('IOUPY');
                    return true;
                } else {
                    $('.input-error').removeClass('input-error');
                    for (const property in json.errors) {
                        var field = $('#' + property + '-error');
        
                        $(field).addClass('input-error');
                    }
                }
                return false;
            });
            break;
    
        default:
            break;
    }

    
}
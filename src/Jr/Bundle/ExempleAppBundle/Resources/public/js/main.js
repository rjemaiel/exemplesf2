jQuery(document).ready(function($) {
    $('body').on('submit', 'form.form-create-ajax', function(e) {
        e.preventDefault();
        submitFormAjax($(this));
    });
    $('body').on('click', 'a#delete', function() {
        var id = $(this).attr('data-id');
        deleteExempleAjax(id);
    });
});

function submitFormAjax(form){
    $.ajax({
        type: form.attr("method"),
        data: form.serialize(),
        url: form.attr('action'),
        success: function(response) {
            if (response != ''){
                $('.list-content').replaceWith(response.content.list);
                $('.form-content').replaceWith(response.content.newExemple);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.state());
            console.log(thrownError);
        }
    });
}

function deleteExempleAjax(id){
    $.ajax({
        type: 'POST',
        url: Routing.generate('exemple_delete', {
            id: id
        }),
        async: true,
        success: function(response) {
            if (response != ''){
                $('.list-content').replaceWith(response.content);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.state());
            console.log(thrownError);
        }
    });
}
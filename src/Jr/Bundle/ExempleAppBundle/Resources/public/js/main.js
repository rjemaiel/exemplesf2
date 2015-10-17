jQuery(document).ready(function($) {
    $('body').on('click', 'a#delete', function() {
        var id = $(this).attr('data-id');
        deleteExempleAjax(id);
    });
});

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
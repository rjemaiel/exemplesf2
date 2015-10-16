jQuery(document).ready(function($) {
    $('body').on('click', '#back', function() {
        console.log(Routing.generate('exemple'));
    });
});
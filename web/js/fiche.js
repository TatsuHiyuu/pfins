$(document).ready(function() {
    $(document).on('click','.ongletFiche', function() {
        var onglet = $(this);
        if (onglet.hasClass('inactive')) {
            $.each(onglet.parent().find('.ongletFiche'), function(index) {
                var current = $(this);
                current.removeClass('active').addClass('inactive');
                current.parent().find('.zone').removeClass('showing').addClass('hiding');
            });
        }
        onglet.removeClass('inactive').addClass('active');
        onglet.parent().find("[data-onglet='" + onglet.data("onglet") + "']").removeClass('hiding').addClass('showing');
    });
});
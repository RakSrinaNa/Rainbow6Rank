$(function () {
    $('.nav-link[data-toggle="pill"]').click(function (e) {
        const elem = $(this);
        if (elem.is('.active')) {
            e.stopImmediatePropagation();
            elem.removeClass('active');
            $(elem.attr('href')).removeClass('active');
			$(elem.attr('href')).find('.nav-link.active').removeClass('active');
			$(elem.attr('href')).find('.tab-pane.active').removeClass('active');
            return false;
        }
        return true;
    });
});

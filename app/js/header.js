$('#refreshCron').click(function () {
    const loader = $('#refreshLoader');
    if (loader.is('.content-hide')) {
        loader.removeClass('content-hide');
        $.ajax({
            url: '/cron.php',
            beforeSend: function (xhr) {
                xhr.overrideMimeType("text/plain; charset=x-user-defined");
            }
        }).done(function () {
            location.reload(true);
        });
    }
});
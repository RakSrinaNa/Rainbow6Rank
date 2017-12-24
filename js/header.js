$('#refreshCron').click(function () {
    $.ajax({
        url: '//rainbow.mrcraftcod.fr/cron.php',
        beforeSend: function (xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        }
    }).done(function () {
        location.reload(true);
    });
});
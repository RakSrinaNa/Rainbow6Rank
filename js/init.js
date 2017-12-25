AmCharts.lazyLoadMakeChart = AmCharts.makeChart;

AmCharts.makeChart = function (a, b, c) {
    $(document).on('scroll load touchmove shown.bs.tab', handleScroll);
    $(window).on('load', handleScroll);
    const item = $('#' + a.id);

    function handleScroll() {
        if (true === b.lazyLoaded || !item.closest('.tab-pane').hasClass('active'))
            return;
        var hT = item.offset().top;
        var hH = item.outerHeight() / 4;
        var wH = $(window).height();
        var wS = $(window).scrollTop();
        if (wS > (hT + hH - wH)) {
            b.lazyLoaded = true;
            AmCharts.lazyLoadMakeChart(a, b, c);
            console.log("loading " + a.id);
        }
    }

    return {
        addListener: function () {
        }
    };
};

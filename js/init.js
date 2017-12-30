/*AmCharts.lazyLoadMakeChart = AmCharts.makeChart;

AmCharts.makeChart = function (a, b, c) {
    $(document).on('scroll load touchmove shown.bs.tab', handleScroll);
    $(window).on('load', handleScroll);
    const item = $('#' + a.id);

    function handleScroll() {
        if (true === b.lazyLoaded || !item.closest('.tab-pane').hasClass('active'))
            return;
        if (!item.parents('.tab-pane').is('.active'))
            return;
        b.lazyLoaded = true;
        AmCharts.lazyLoadMakeChart(a, b, c);
        console.log("Loading chart " + a.id);
    }

    return {
        addListener: function () {
        }
    };
};*/

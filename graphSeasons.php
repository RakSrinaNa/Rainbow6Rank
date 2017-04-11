<!--suppress JSDuplicatedDeclaration -->
<script type='text/javascript'>
    function roundDate(date) {
        var coeff = 1000 * 60 * 60;
        return new Date(Math.floor(date.getTime() / coeff) * coeff)
    }

    $(document).ready(function () {

        //Resize chart to fit height
        var chartHolder = document.getElementById('chartHolder' + '<?php echo $divName; ?>');
        var chartDiv = document.getElementById('chartDiv' + '<?php echo $divName; ?>');
        new ResizeSensor(chartHolder, function () {
            chartDiv.style.height = '' + chartHolder.clientHeight + 'px';
        });

        AmCharts.ready(function () {
            var chartColors = {
                theme: 'dark',
                selectedBackgroundColor: '#444444',
                gridColor: '#999999',
                color: '#111111',
                scrollBarBackgroundColor: '#666666',
                labelColor: '#000000',
                backgroundColor: '#777777',
                ratioLineColor: '#196E1F',
                countLineColor: '#214DD1',
                handDrawn: false
            };

            var ranks = {
                'Silver I': {
                    from: 2400,
                    to: 2500
                },
                'Silver II': {
                    from: 2300,
                    to: 2400
                },
                'Silver III': {
                    from: 2200,
                    to: 2300
                },
                'Silver IV': {
                    from: 2100,
                    to: 2200
                },
                'Bronze I': {
                    from: 2000,
                    to: 2100
                },
                'Bronze II': {
                    from: 1900,
                    to: 2000
                },
                'Bronze III': {
                    from: 1800,
                    to: 1900
                },
                'Bronze IV': {
                    from: 1700,
                    to: 1800
                },
                'Copper I': {
                    from: 1600,
                    to: 1700
                },
                'Copper II': {
                    from: 1500,
                    to: 1600
                },
                'Copper III': {
                    from: 1400,
                    to: 1500
                }
            };

            var i = 0;
            var guideColors = [
                '#555555',
                '#aaaaaa'
            ];
            var guides = [];
            for (var rank in ranks)
                if (ranks.hasOwnProperty(rank)) {
                    guides.push({
                        fillAlpha: 0.3,
                        lineAlpha: 1,
                        lineThickness: 1,
                        value: ranks[rank]['from'],
                        toValue: ranks[rank]['to'],
                        valueAxis: 'pointsAxis',
                        label: rank,
                        inside: true,
                        position: 'right',
                        fillColor: guideColors[i++ % guideColors.length]
                    });
                }


            var datas = JSON.parse('<?php echo $datas(); ?>');

            var rankedGraphs = [];
            var rankedTempDatas = [];
            for (var player in datas)
                if (datas.hasOwnProperty(player)) {
                    const username = player;
                    rankedGraphs.push({
                        id: username,
                        bullet: 'circle',
                        bulletBorderAlpha: 1,
                        bulletBorderThickness: 1,
                        connect: true,
                        dashLengthField: 'dashLength',
                        legendValueText: '[[value]]',
                        title: username,
                        //fillAlphas: 0.2,
                        valueField: username,
                        valueAxis: 'pointsAxis',
                        type: 'smoothedLine',
                        lineThickness: 2,
                        bulletSize: 8,
                        balloonFunction: function (graphDataItem) {
                            var date = graphDataItem.category;
                            return username + '<br>' + ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + '<br/><b><span style="font-size:14px;">' + graphDataItem.values.value + '</span></b>';
                        }
                    });

                    for (var date in datas[player])
                        if (datas[player].hasOwnProperty(date)) {
                            var roundedDate = roundDate(new Date(date));
                            if (!rankedTempDatas.hasOwnProperty(roundedDate))
                                rankedTempDatas[roundedDate] = {};
                            rankedTempDatas[roundedDate][player] = datas[player][date];
                        }
                }

            var rankedDatas = [];
            for (var date in rankedTempDatas)
                if (rankedTempDatas.hasOwnProperty(date)) {
                    var dateData = {};
                    dateData['date'] = date;
                    for (var user in rankedTempDatas[date])
                        if (rankedTempDatas[date].hasOwnProperty(user))
                            dateData[user] = rankedTempDatas[date][user];

                    rankedDatas.push(dateData);
                }

            rankedDatas = rankedDatas.sort(function (a, b) {
                return Date.parse(a['date']) - Date.parse(b['date']);
            });

            //Build Chart
            AmCharts.makeChart(chartDiv, {
                    type: 'serial',
                    theme: chartColors['theme'],
                    backgroundAlpha: 1,
                    backgroundColor: chartColors['backgroundColor'],
                    fillColors: chartColors['backgroundColor'],
                    handDrawn: chartColors['handDrawn'],
                    legend: {
                        equalWidths: false,
                        useGraphSettings: true,
                        valueAlign: 'left',
                        valueWidth: 60,
                        backgroundAlpha: 1,
                        backgroundColor: chartColors['backgroundColor'],
                        fillColors: chartColors['backgroundColor'],
                        valueFunction: function (graphDataItem) {
                            return graphDataItem && graphDataItem.graph && graphDataItem.graph.valueField && graphDataItem.values && (graphDataItem.values.value || graphDataItem.values.value === 0) ? Math.round(graphDataItem.values.value * 100) / 100 : '';
                        }
                    },
                    dataProvider: rankedDatas,
                    valueAxes: [{
                        id: 'pointsAxis',
                        axisAlpha: 0.5,
                        gridAlpha: 0.2,
                        inside: false,
                        color: chartColors['labelColor'],
                        position: 'left',
                        title: '<?php echo $title ?>'
                    }],
                    categoryAxis: {
                        parseDates: true,
                        dashLength: 1,
                        minorGridEnabled: true,
                        equalSpacing: true,
                        autoWrap: true,
                        position: 'bottom',
                        minPeriod: 'hh',
                        labelRotation: 10,
                        labelFunction: function (valueText, date) {
                            return ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2)
                        }
                    },
                    graphs: rankedGraphs,
                    chartScrollbar: {
                        autoGridCount: true,
                        scrollbarHeight: 40,
                        selectedBackgroundColor: chartColors['selectedBackgroundColor'],
                        gridColor: chartColors['gridColor'],
                        color: chartColors['color'],
                        backgroundColor: chartColors['scrollBarBackgroundColor'],
                        graphFillAlpha: 0,
                        graphLineAlpha: 0.5,
                        selectedGraphFillAlpha: 0,
                        selectedGraphLineAlpha: 1
                    },
                    chartCursor: {
                        cursorAlpha: 0.1,
                        cursorColor: '#000000',
                        fullWidth: true,
                        valueBalloonsEnabled: true,
                        valueLineBalloonEnabled: true,
                        valueLineEnabled: true,
                        zoomable: false,
                        categoryBalloonDateFormat: 'MMMM-DD HH:NN'
                    },
                    numberFormatter: {
                        precision: -1,
                        decimalSeparator: ",",
                        thousandsSeparator: ""
                    },
                    guides: guides,
                    categoryField: 'date',
                    minPeriod: 'mm',
                    autoGridCount: true,
                    axisColor: '#555555',
                    gridAlpha: 0.1,
                    gridColor: '#FFFFFF',
                    creditsPosition: 'bottom-left'
                }, {
                    responsive: {
                        enabled: true
                    }
                }
            );
        });
    });
</script>
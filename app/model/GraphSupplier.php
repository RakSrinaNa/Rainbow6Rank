<?php

	namespace R6
	{
		/**
		 * Created by PhpStorm.
		 * User: mrcraftcod
		 * Date: 07/05/2017
		 * Time: 16:34
		 */
		abstract class GraphSupplier
		{
			function plot()
			{ ?>
                <script type='text/javascript'>
					$(function () {
						//Resize chart to fit height
						const chartDiv = document.getElementById('chartDiv' + '<?php echo $this->getID(); ?>');

						function loadTheChart() {
							function getPlayers(playersCallback) {
								$.ajax({
									url: '<?php echo $this->getPlayersURL(); ?>',
									context: document.body,
									method: 'GET'
								}).done(function (data) {
									if (data && data['players']) {
										playersCallback(data['players']);
									}
								});
							}

							getPlayers(function (players) {
								const graphs = [];
								for (const playerName in players) {
									if (players.hasOwnProperty(playerName)) {
										graphs.push({
											id: playerName,
											bullet: 'circle',
											bulletBorderAlpha: 1,
											bulletBorderThickness: 1,
											connect: true,
											dashLengthField: 'dashLength',
											legendValueText: '[[value]]',
											title: playerName,
											//fillAlphas: 0.05,
											valueField: playerName,
											valueAxis: 'pointsAxis',
											type: 'step',
											//type: 'smoothedLine',
											lineThickness: 2,
											bulletSize: 8,
											balloonFunction: function (graphDataItem) {
												let parser = function () {
													return "";
												};
												parser = <?php echo $this->getParser(); ?>;
												const date = graphDataItem.category;
												let balloon = playerName + '<br>' + ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + '<br/><b><span style="font-size:14px;">' + parser(graphDataItem.values.value) + '</span></b>';
												<?php
												foreach($this->getAdditionalBalloon() as $field => $text)
												{ ?>
												const key = playerName + '<?php echo $field; ?>';
												if (graphDataItem.dataContext.hasOwnProperty(key)) {
													balloon += '<br/><?php echo $text; ?>' + graphDataItem.dataContext[key];
												}
												<?php
												}?>
												return balloon;
											}
										});
									}
								}

								const chartData = {
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
									dataLoader: {
										url: "<?php echo $this->getDataProvider(); ?>",
										format: "json"
									},
									valueAxes: [{
										id: 'pointsAxis',
										axisAlpha: 0.5,
										gridAlpha: 0.2,
										inside: false,
										color: chartColors['labelColor'],
										position: 'left',
										title: '<?php echo $this->getTitle() ?>'
										<?php
										if($this->getMinimum())
											echo ', minimum: ' . $this->getMinimum();
										?>
									}],
									categoryAxis: {
										parseDates: true,
										dashLength: 1,
										minorGridEnabled: true,
										equalSpacing: true,
										autoWrap: true,
										position: 'bottom',
										minPeriod: 'hh',
										labelsEnabled: true
									},
									graphs: graphs,
									chartScrollbar: {
										autoGridCount: true,
										scrollbarHeight: 20,
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
										zoomable: true,
										valueZoomable: true,
										categoryBalloonDateFormat: 'MMMM DD HH:NN',
										showNextAvailable: true
									},
									numberFormatter: {
										precision: -1,
										decimalSeparator: ",",
										thousandsSeparator: ""
									},
									guides: <?php echo $this->getGuides() ?>,
									categoryField: 'date',
									minPeriod: 'dd',
									autoGridCount: true,
									axisColor: '#555555',
									gridAlpha: 0.1,
									gridColor: '#FFFFFF',
									creditsPosition: 'bottom-left'
								};

								const chartOptions = {
									responsive: {
										enabled: true
									}
								};

								//Build Chart
								AmCharts.makeChart(chartDiv, chartData, chartOptions);
							});
						}

						if (AmCharts.isReady) {
							loadTheChart();
						} else {
							AmCharts.ready(loadTheChart());
						}
					);
                </script>
				<?php
			}

			/**
			 * @return string
			 */
			abstract function getID();

			/**
			 * @return array
			 */
			function getAdditionalBalloon()
			{
				return array();
			}

			/**
			 * @return string
			 */
			abstract function getTitle();

			/**
			 * @return string
			 */
			function getParser()
			{
				return 'function(data){return data;}';
			}

			/**
			 * @return string
			 */
			function getGuides()
			{
				return json_encode(array());
			}

			/**
			 * @return bool
			 */
			function shouldPlot()
			{
				return true;
			}

			/**
			 * @return bool | null
			 */
			function getMinimum()
			{
				return null;
			}

			/**
			 * @return string
			 */
			abstract function getPlayersURL();

			/**
			 * @return string
			 */
			private function getDataProvider()
			{
				if($_GET['section'] === 'detailed' || $_GET['section'] === 'all')
					return $this->getAllDataProvider();
				return $this->getWeeklyDataProvider();
			}

			/**
			 * @return string
			 */
			abstract function getAllDataProvider();

			/**
			 * @return string
			 */
			abstract function getWeeklyDataProvider();
		}
	}
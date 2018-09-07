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
							const chartDiv = document.getElementById('chartDiv' + '<?php echo $this->getID(); ?>');

							function getPlayers(playersCallback) {
								$.ajax({
									url: '<?php echo $this->getPlayersURL(); ?>',
									context: document.body,
									method: 'GET'
								}).done(function (data) {
									if (data && data instanceof Array) {
										playersCallback(data);
									}
								});
							}

							if (chartDiv) {
								getPlayers(function (players) {
									let chart = am4core.create(chartDiv, am4charts.XYChart);
									let title = chart.titles.create();
									title.text = "<?php echo $this->getTitle(); ?>";
									title.fontSize = 15;
									title.marginBottom = 15;

									let xAxis = chart.xAxes.push(new am4charts.DateAxis());
									xAxis.title.text = 'Date';
									xAxis.skipEmptyPeriods = true;
									let yAxis = chart.yAxes.push(new am4charts.ValueAxis());

									chart.legend = new am4charts.Legend();
									chart.legend.useDefaultMarker = true;

									let marker = chart.legend.markers.template.children.getIndex(0);
									marker.cornerRadius(12, 12, 12, 12);
									marker.strokeWidth = 2;
									marker.strokeOpacity = 1;
									marker.stroke = am4core.color("#ccc");

									chart.cursor = new am4charts.XYCursor();
									chart.cursor.xAxis = xAxis;

									for (const playerIndex in players) {
										if (players.hasOwnProperty(playerIndex)) {
											const playerName = players[playerIndex];
											let series = chart.series.push(new am4charts.LineSeries());
											series.dataFields.valueY = "value";
											series.dataFields.dateX = "date";
											series.tooltipText = "{date}: [bold]{value}";
											series.dataSource.url = "<?php echo $this->getDataProvider(); ?>/" + playerName;
											series.dataSource.parser.options.dateFields = ['date'];
											series.dataSource.parser.options.dateFormat = 'yyyy-MM-dd hh:mm:ss';
											series.name = playerName;
											series.strokeWidth = 2;
											series.legendSettings.valueText = "{valueY}";
										}
									}

									// Create scrollbars
									chart.scrollbarX = new am4core.Scrollbar();
									chart.scrollbarY = new am4core.Scrollbar();
								});
							}
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
			 * @return string
			 */
			abstract function getTitle();

			/**
			 * @return bool
			 */
			function shouldPlot()
			{
				return true;
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
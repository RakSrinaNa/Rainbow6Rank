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
									chart.dateFormat = 'yyyy-MM-dd HH:mm:ss';
									chart.exporting.menu = new am4core.ExportMenu();

									let title = chart.titles.create();
									title.text = "<?php echo $this->getTitle(); ?>";
									title.fontSize = 15;
									title.marginBottom = 15;

									let xAxis = chart.xAxes.push(new am4charts.DateAxis());
									xAxis.title.text = 'Date';
									xAxis.skipEmptyPeriods = true;
									xAxis.dateFormats.setKey("year", "yyyy");
									xAxis.dateFormats.setKey("month", "MMM yyyy");
									xAxis.dateFormats.setKey("week", "dd MMM yyyy");
									xAxis.dateFormats.setKey("day", "dd MMM");
									xAxis.dateFormats.setKey("hour", "HH:00");
									xAxis.dateFormats.setKey("minute", "HH:mm");
									xAxis.dateFormats.setKey("second", "HH:mm:ss");
									xAxis.baseInterval = {
										"timeUnit": "minute",
										"count": 15
									};
									let yAxis = chart.yAxes.push(new am4charts.ValueAxis());
									<?php if($this->isDurationGraph())
								{
									echo 'chart.durationFormatter.durationFormat = "HH:mm:ss";';
								}?>

									chart.legend = new am4charts.Legend();
									chart.legend.useDefaultMarker = true;

									let marker = chart.legend.markers.template.children.getIndex(0);
									marker.cornerRadius(12, 12, 12, 12);
									marker.strokeWidth = 2;
									marker.strokeOpacity = 1;
									marker.stroke = am4core.color("#cccccc");

									chart.cursor = new am4charts.XYCursor();
									chart.cursor.xAxis = xAxis;

									<?php echo $this->getGuides(); ?>

									for (const playerIndex in players) {
										if (players.hasOwnProperty(playerIndex)) {
											const playerName = players[playerIndex];
											let series = chart.series.push(new am4charts.LineSeries());
											series.dataFields.valueY = "value";
											series.dataFields.dateX = "date";
											series.tooltipText = "[bold]" + playerName + " - {date.formatDate(\"yyyy-MM-dd HH:mm\")}[/]\n<?php echo $this->getBalloonTooltip(); ?>";
											series.dataSource.url = "<?php echo $this->getDataProvider(); ?>/" + playerName;
											series.dataSource.requestOptions.requestHeaders = [{
												"range": "<?php echo $_GET['range'] ?>"
											}];
											series.dataSource.parser.options.dateFields = ['date'];
											series.dataSource.parser.options.dateFormat = 'yyyy-MM-dd HH:mm:ss';
											series.name = playerName;
											series.strokeWidth = 2;
											series.legendSettings.valueText = "<?php echo $this->getLegendText(); ?>";
											// series.fillOpacity = 0.3;

											let bullet = series.bullets.push(new am4charts.CircleBullet());
											bullet.width = 10;
											bullet.height = 10;
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

			/**
			 * @return string
			 */
			protected function getBalloonTooltip()
			{
				return "[bold]{value}";
			}

			/**
			 * @return bool
			 */
			protected function isDurationGraph()
			{
				return false;
			}

			/**
			 * @return string
			 */
			protected function getLegendText()
			{
				return "{value}";
			}

			/**
			 * @return string
			 */
			protected function getGuides()
			{
				return ';';
			}
		}
	}
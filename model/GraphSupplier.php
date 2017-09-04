<?php

	namespace R6
	{
		/**
		 * Created by PhpStorm.
		 * User: mrcraftcod
		 * Date: 07/05/2017
		 * Time: 16:34
		 */
		require_once __DIR__ . '/GraphUtils.php';

		abstract class GraphSupplier
		{
			protected $datas = array();

			function plot()
			{ ?>
                <!--suppress JSDuplicatedDeclaration, JSUnusedAssignment -->
                <script type='text/javascript'>
					function roundDate(date) {
						var coeff = 1000 * 60 * 60;
						return new Date(Math.floor(date.getTime() / coeff) * coeff)
					}

					$(document).ready(function () {

						//Resize chart to fit height
						var chartdivWatched = document.getElementById('chartDiv' + '<?php echo $this->getID(); ?>');

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

							var datas = JSON.parse('<?php echo $this->getDatas(); ?>');

							var graphs = [];
							var tempDatas = [];
							for (var player in datas)
								if (datas.hasOwnProperty(player)) {
									const username = player;
									graphs.push({
										id: username,
										bullet: 'circle',
										bulletBorderAlpha: 1,
										bulletBorderThickness: 1,
										connect: true,
										dashLengthField: 'dashLength',
										legendValueText: '[[value]]',
										title: username,
										//fillAlphas: 0.05,
										valueField: username,
										valueAxis: 'pointsAxis',
										type: 'step',
										//type: 'smoothedLine',
										lineThickness: 2,
										bulletSize: 8,
										balloonFunction: function (graphDataItem) {
											var parser = <?php echo $this->getParser(); ?>;
											var date = graphDataItem.category;
											var balloon = username + '<br>' + ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + '<br/><b><span style="font-size:14px;">' + parser(graphDataItem.values.value) + '</span></b>';
											<?php
											foreach($this->getAdditionalBalloon() as $field => $text)
											{ ?>
											var key = username + '<?php echo $field; ?>';
											if (graphDataItem.dataContext.hasOwnProperty(key)) {
												balloon += '<br/><?php echo $text; ?>' + graphDataItem.dataContext[key];
											}
											<?php
											}?>
											return balloon;
										}
									});

									for (var date in datas[player])
										if (datas[player].hasOwnProperty(date)) {
											var roundedDate = roundDate(new Date(date));
											if (!tempDatas.hasOwnProperty(roundedDate))
												tempDatas[roundedDate] = {};
											tempDatas[roundedDate][player] = datas[player][date];
										}
								}

							var datas = [];
							for (var date in tempDatas)
								if (tempDatas.hasOwnProperty(date)) {
									var dateData = {};
									dateData['date'] = date;
									for (var user in tempDatas[date])
										if (tempDatas[date].hasOwnProperty(user)) {
											for (var valueData in tempDatas[date][user]) {
												if (tempDatas[date][user].hasOwnProperty(valueData)) {
													if (valueData === 'value')
														dateData[user] = tempDatas[date][user][valueData];
													else
														dateData[valueData] = tempDatas[date][user][valueData];
												}
											}

										}

									datas.push(dateData);
								}

							datas = datas.sort(function (a, b) {
								return Date.parse(a['date']) - Date.parse(b['date']);
							});

							//Build Chart
							AmCharts.makeChart(chartdivWatched, {
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
									dataProvider: datas,
									valueAxes: [{
										id: 'pointsAxis',
										axisAlpha: 0.5,
										gridAlpha: 0.2,
										inside: false,
										color: chartColors['labelColor'],
										position: 'left',
										title: '<?php echo $this->getTitle() ?>'
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
								}, {
									responsive: {
										enabled: true
									}
								}
							);
						});
					});
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
			final function getDatas()
			{
				return json_encode(GraphUtils::process($this->datas));
			}

			/**
			 * @param string $username The username to remap.
			 * @return string The mapped username.
			 */
			function remapUsername($username)
			{
				switch($username)
				{
					case 'PhoenixRS666':
						return 'Fuel_Rainbow';
				}
				return $username;
			}

			/**
			 * @param array $player
			 * @param string $timestamp
			 */
			function processPoint($player, $timestamp)
			{
				$username = $this->remapUsername($player['player']['username']);
				if(!isset($this->datas[$username]))
					$this->datas[$username] = array();
				$data = $this->getPoint($player);
				if($data === null)
					return;
				$data['timestamp'] = $timestamp;
				$this->datas[$username][$player['player']['updated_at']] = $data;
			}

			/**
			 * @param array $player
			 * @return array
			 */
			abstract function getPoint($player);

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
		}
	}
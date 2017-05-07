<?php
	require_once dirname(__FILE__) . '/model/GraphUtils.php';

	/**
	 * Created by PhpStorm.
	 * User: mrcraftcod
	 * Date: 07/05/2017
	 * Time: 16:34
	 */
	abstract class GraphSupplier
	{
		final function plot()
		{ ?>
            <!--suppress JSDuplicatedDeclaration -->
            <script type='text/javascript'>
				function roundDate(date) {
					var coeff = 1000 * 60 * 60;
					return new Date(Math.floor(date.getTime() / coeff) * coeff)
				}

				$(document).ready(function () {

					//Resize chart to fit height
					var chartHolderWatched = document.getElementById('chartHolder' + '<?php echo $this->getID(); ?>');
					var chartdivWatched = document.getElementById('chartDiv' + '<?php echo $this->getID(); ?>');
					new ResizeSensor(chartHolderWatched, function () {
						chartdivWatched.style.height = '' + chartHolderWatched.clientHeight + 'px';
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
										var date = graphDataItem.category;
										return username + '<br>' + ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear() + " " + ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2) + '<br/><b><span style="font-size:14px;">' + graphDataItem.values.value + '</span></b>';
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
									if (tempDatas[date].hasOwnProperty(user))
										dateData[user] = tempDatas[date][user];

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

		abstract function getID();

		function getDatas()
		{
			$datas = array();
			$files = glob('players/*/*.json', GLOB_BRACE);
			foreach($files as $file)
			{
				$timestamp = (explode('.', array_values(array_slice(explode('/', $file), -1))[0])[0] / 1000);
				if(!isset($_GET['all']) && time() - $timestamp > $this->getRange())
					continue;
				$player = json_decode(file_get_contents($file), true);
				if(!isset($player['player']['username']) || $player['player']['username'] === '')
					continue;
				$username = $player['player']['username'];
				if(!isset($datas[$username]))
					$datas[$username] = array();
				$data = $this->getPoint($player);
				if($datas === null)
					continue;
				$data['timestamp'] = $timestamp;
				$datas[$username][$player['player']['updated_at']] = $data;
			}
			return json_encode(GraphUtils::process($datas));
		}

		final function getRange()
		{
			return isset($_GET['weekly']) ? 31536000 : 2592000;
		}

		abstract function getPoint($player);

		abstract function getTitle();

		function getGuides()
		{
			return json_encode(array());
		}
	}
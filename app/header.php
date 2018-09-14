<?php
    include_once __DIR__ . "/api/v1/model/DBConnection.class.php";

	{
		$rootDir = '/homez.2349/mrcraftcgg/www/subdomains/rainbow';

		function getLastCheckDate($rootDir)
		{
			$date = 0;
			$files = glob($rootDir . '/players/last.update', GLOB_BRACE);
			foreach($files as $file)
			{
				$fDate = filemtime($file);
				$date = $date > $fDate ? $date : $fDate;
			}
			return $date === 0 ? 'UNKNOWN' : date("H:i:s", $date);
		}

		function getLastDataDate()
		{
			$query = \R6\DBConnection::getConnection()->query("SELECT MAX(Updated) AS Updated FROM R6_Player");
			if($result = $query->fetch())
			{
				$dt = new DateTime($result["Updated"]);
				return $dt->format("H:i:s");
			}
			return 'UNKNOWN';
		}

		?>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark" role="navigation">
            <a class="navbar-brand" href="#"><img src="favicon.ico" alt="Logo" style="width:40px;"></a>
            <ul class="nav navbar-nav">
                <li class="nav-item"><a class="nav-link" href="https://r6stats.com/" target="_blank">Data from R6Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="refreshCron">Request update
                        <div id="refreshLoader" class="loader content-hide"></div>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link">Last check: <?php echo getLastCheckDate($rootDir) ?></a></li>
                <li class="nav-item"><a class="nav-link">Last data: <?php echo getLastDataDate(); ?></a></li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
<!--                <li class="nav-item --><?php //echo $_GET['range'] === '-1' ? 'active' : ''; ?><!--">-->
<!--                    <a class="nav-link" href="?section=--><?php //echo $_GET['section']; ?><!--&range=-1">See weekly data</a>-->
<!--                </li>-->
                <li class="nav-item <?php echo $_GET['range'] === '7' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=<?php echo $_GET['section']; ?>&range=7">See last 7 days</a>
                </li>
                <li class="nav-item <?php echo $_GET['range'] === '30' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=<?php echo $_GET['section']; ?>&range=30">See last 30 days</a>
                </li>
                <li class="nav-item <?php echo $_GET['range'] === '10000' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=<?php echo $_GET['section']; ?>&range=10000">See all data</a>
                </li>
            </ul>
        </nav>
        <script src="js/header.js"></script>
		<?php
	}

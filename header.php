<?php
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

		function getLastUpdateDate($rootDir)
		{
			$date = 0;
			$files = glob($rootDir . '/players/*/*.json', GLOB_BRACE);
			foreach($files as $file)
			{
				$fDate = filemtime($file);
				$date = $date > $fDate ? $date : $fDate;
			}
			return $date === 0 ? 'UNKNOWN' : date("H:i:s", $date);
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
                <li class="nav-item"><a class="nav-link">Last update at: <?php echo getLastCheckDate($rootDir) ?></a></li>
                <li class="nav-item"><a class="nav-link">Last data from: <?php echo getLastUpdateDate($rootDir); ?></a></li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item <?php echo $_GET['section'] === 'weekly' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=weekly">See weekly data</a>
                </li>
                <li class="nav-item <?php echo $_GET['section'] === 'detailed' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=detailed">See detailed data</a>
                </li>
                <li class="nav-item <?php echo $_GET['section'] === 'all' ? 'active' : ''; ?>">
                    <a class="nav-link" href="?section=all">See all data</a>
                </li>
            </ul>
        </nav>
        <script src="js/header.js"></script>
		<?php
	}

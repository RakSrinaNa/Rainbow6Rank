<?php
$divName = 'KDC';
$title = 'K/D Ratio Casual';

$datas = function () {
    $datas = array();
    $files = glob('players/*/*.json', GLOB_BRACE);
    foreach ($files as $file) {
        $player = json_decode(file_get_contents($file), true);
        $username = $player['player']['username'];
        if(!$username || $username === '')
            continue;
        if (!isset($datas[$username]))
            $datas[$username] = array();
        $datas[$username][$player['player']['updated_at']] = $player['player']['stats']['casual']['kd'];
    }
    return json_encode($datas);
};

//echo '<br/>' . $datas() . '<br/>';

include 'graph.php';
<?php
$divName = 'WLRR';
$title = 'WLR Ratio Ranked';

$datas = function () {
    $datas = array();
    $files = glob('players/*/*.json', GLOB_BRACE);
    foreach ($files as $file) {
        $player = json_decode(file_get_contents($file), true);
        if(!isset($player['player']['username']) || $player['player']['username'] === '')
            continue;
        $username = $player['player']['username'];
        if(!isset($datas[$username]))
            $datas[$username] = array();
        $datas[$username][$player['player']['updated_at']] = $player['player']['stats']['ranked']['wlr'];
    }
    return json_encode($datas);
};

//echo '<br/>' . $datas() . '<br/>';

include 'graph.php';
<?php
$divName = 'WLRR';
$title = 'W/L Ratio Ranked';

$guides = function(){
    return json_encode(array());
};

$datas = function () use (&$monthRange) {
    $datas = array();
    $files = glob('players/*/*.json', GLOB_BRACE);
    foreach ($files as $file) {
        if(!isset($_GET['all']) && time() - (explode('.', array_values(array_slice(explode('/', $file), -1))[0])[0] / 1000) > $monthRange)
            continue;
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

include 'graph.php';
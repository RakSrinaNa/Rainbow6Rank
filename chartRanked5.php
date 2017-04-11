<?php
$divName = 'Ranked5';
$title = 'Ranked points';

$datas = function()
{
    $datas = array();
    $files = glob('players/*/*.json', GLOB_BRACE);
    foreach ($files as $file) {
        $player = json_decode(file_get_contents($file), true);
        if(!$player['seasons']['5'])
            continue;
        $username = $player['player']['username'];
        if(!$username || $username === '')
            continue;
        if(!isset($datas[$username]))
            $datas[$username] = array();
        $datas[$username][$player['player']['updated_at']] = $player['seasons']['5']['emea']['ranking']['rating'];
    }
    return json_encode($datas);
};

//echo '<br/>' . $datas() . '<br/>';

include 'graphSeasons.php';
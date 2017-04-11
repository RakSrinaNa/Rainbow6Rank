<?php
function logg($fpLog, $message)
{
    echo $message;
    fwrite($fpLog, $message);
}

function readAPI($fpLog, $path)
{
    $ENDPOINT = 'https://api.r6stats.com/api/v1/players/';
    $url = $ENDPOINT . $path;

    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURL, CURLOPT_HTTPGET, true);
    curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    $content = curl_exec($cURL);
    //$content = file_get_contents($ENDPOINT . $path);
    curl_close($cURL);
    if(!$content)
    {
        log($fpLog, 'Error getting from API ' . error_get_last()['message'] . "\n");
    }
    return $content;
}

$timeFormat = 'Y-m-d\TH:i:s+';

$players = array('MrCraftCod', 'LokyDogma');

$fpLog = fopen('log.log', 'w');

foreach($players as $player)
{
    logg($fpLog, 'Doing player ' . $player . ':' . "\n");
    $json = array();
    $c1 = readAPI($fpLog, $player . '?platform=uplay');
    $c2 = readAPI($fpLog, $player . '/seasons?platform=uplay');
    if(!$c1 || !$c2)
    {
        continue;
    }
    $json['player'] = json_decode($c1, true);
    $json['seasons'] = json_decode($c2, true);

    logg($fpLog, 'Datas ' . json_encode($json) . "\n");
    
    $temp = $json['player']['player']['updated_at'];
    $date = date_create_from_format($timeFormat, $temp);
    if($date)
    {    
        $time = $date->getTimestamp() * 1000;

        logg($fpLog, 'Time ' . $time . "\n");

        $file = 'players/' . $player . '/' . $time . '.json';

        if(!file_exists($file))
        {
            logg($fpLog, 'Writing file' . $file . "\n");
            $fp = fopen($file, 'w');
            fwrite($fp, json_encode($json));
            fclose($fp);
            logg($fpLog, 'Writing file done' . "\n");
        }
        else
        {
            logg($fpLog, "File " . $file . ' already exists, skipping' . "\n");
        }
        logg($fpLog, "\n");
    }
    else
    {
        echo DateTime::getLastErrors();
    }
}

fclose($fpLog);

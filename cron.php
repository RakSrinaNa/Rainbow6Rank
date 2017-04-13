<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

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
    logg($fpLog, 'HTTP Response: ' . curl_getinfo($cURL, CURLINFO_HTTP_CODE) . "\n");
    //$content = file_get_contents($ENDPOINT . $path);
    if (!$content) {
        logg($fpLog, 'Error getting from API (' . curl_errno($cURL) . ')' . curl_error($cURL) . "\n");
    }
    curl_close($cURL);
    logg($fpLog, 'Read content from ' . $path . ' -> ' . $content . "\n");
    return $content;
}

$timeFormat = 'Y-m-d\TH:i:s+';

$players = array('MrCraftCod', 'LokyDogma');

$fpLog = fopen('log.log', 'w');

logg($fpLog, 'Working directory: ' . getcwd() . "\n\n");

foreach ($players as $player) {
    logg($fpLog, 'Doing player ' . $player . ':' . "\n");
    $json = array();
    $c1 = readAPI($fpLog, $player . '?platform=uplay');
    $c2 = readAPI($fpLog, $player . '/seasons?platform=uplay');
    if (!$c1 || !$c2) {
        continue;
    }
    $json['player'] = json_decode($c1, true)['player'];
    $json['seasons'] = json_decode($c2, true)['seasons'];

    logg($fpLog, 'Datas ' . json_encode($json) . "\n");

    $temp = $json['player']['player']['updated_at'];
    $date = date_create_from_format($timeFormat, $temp);
    if ($date) {
        $time = $date->getTimestamp() * 1000;

        logg($fpLog, 'Time ' . $time . "\n");

        $file = 'www/subdomains/rainbow/players/' . $player . '/' . $time . '.json';

        if (!file_exists($file)) {
            logg($fpLog, 'Writing file ' . $file . "\n");
            $fp = fopen($file, 'w');
            if (!$fp) {
                logg($fpLog, 'Error opening file ' . $file . "\n");
            } else {
                fwrite($fp, json_encode($json));
                fclose($fp);
                logg($fpLog, 'Writing file done' . "\n");
            }
        } else {
            logg($fpLog, "File " . $file . ' already exists, skipping' . "\n");
        }
        logg($fpLog, "\n");
    } else {
        echo DateTime::getLastErrors();
    }
}

logg($fpLog, 'Done' . "\n");
fclose($fpLog);

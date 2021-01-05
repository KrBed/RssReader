<?php


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\RssSchema;

//use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Feed;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Main;

//use Spatie\SimpleExcel\SimpleExcelWriter;

include '../vendor/autoload.php';
echo "RSS Reader will be executed\n";

$fileNameArgumentIndex = array_search(basename(__FILE__), $argv);
if ($fileNameArgumentIndex !== false) unset($argv[$fileNameArgumentIndex]);
$argv = array_values($argv);

Main::execute($argv);









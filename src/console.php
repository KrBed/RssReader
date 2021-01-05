<?php


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\RssSchema;

//use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Feed;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Main;

//use Spatie\SimpleExcel\SimpleExcelWriter;

// include '../vendor/autoload.php';
require_once __DIR__ . '../../vendor/autoload.php';

echo "RSS Reader will be executed\n";

$argv = array_values(array_slice($argv, -3, 3, true));

Main::execute($argv);

<<<<<<< HEAD

=======
>>>>>>> fa213462f5d1b289ca759dd33e05c9ae26348e4c








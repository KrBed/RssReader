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

//$result = Feed::load('https://blog.nationalgeographic.org/feed/');
//
//
//$arr = $result->toArray();
//$description = $arr['item'][0]['description'];
//$pubDate = $arr['item'][0]['pubDate'];
//$articles = [];
//foreach ($arr['item'] as $item) {
//  $article = new RssSchema();
//  $desc = $item['description'];
//  $article->setDescription($item['description']);
//  $article->setCreator($item['dc:creator']);
//  $article->setLink($item['link']);
//  $article->setPubDate($item['pubDate']);
//  $article->setTitle($item['title']);
//  $articles[] = $article;
//}
//$writer = SimpleExcelWriter::create('test.csv');
//foreach ($articles as $article) {
//  $writer->addRow(['title'       => $article->getTitle(),
//                   'pubDate'     => $article->getPubDate(),
//                   'link'        => $article->getLink(),
//                   'description' => $article->getDescription(),
//                   'creator'     => $article->getCreator()]);
//}









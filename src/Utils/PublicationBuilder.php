<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Utils;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use SimpleXMLElement;

class PublicationBuilder
{
  /**
   * @param SimpleXMLElement $data
   * @return Publication
   */
  public static function createPublicationForRSS($data): Publication
  {
    $publication = new Publication();
    $publication->setTitle($data->title);
    $publication->setPubDate($data->pubDate);
    $publication->setLink($data->link);
    $publication->setCreator($data->dcCreator);
    $publication->setDescription($data->description);

    return $publication;
  }

  /**
   * @param $item
   * @return Publication
   */
  public static function createPublicationForAtom($data): Publication
  {
    $publication = new Publication();

    foreach ($data->link as $link) {
      $publication->setLink($link['href']);
    }

    $publication->setCreator($data->author->name);
    $publication->setPubDate($data->updated);
    $publication->setTitle($data->title);
    $publication->setDescription($data->summary);

    return $publication;
  }
}
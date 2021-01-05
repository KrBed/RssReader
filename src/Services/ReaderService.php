<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Utils\PublicationBuilder;
use SimpleXMLElement;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\FeedException;


class ReaderService
{

  /** @var SimpleXMLElement */
  protected $xml;

  /**
   * Loads RSS or Atom feed.
   * @param string $url
   * @return Publication []
   * @throws FeedException
   */
  public function load(string $url)
  {
    $xml = $this->loadXml($url);
    if ($this->canReadRss($xml)) {
      return $this->getPublicationsfromRss($xml);
    } elseif ($this->canReadAtom($xml)) {
      return $this->getPublicationsfromAtom($xml);
    } else {
      throw new FeedException('Invalid feed.');
    }
  }

  /**
   * @param SimpleXMLElement $xml
   * @return Publication []
   */
  public function getPublicationsfromRss(SimpleXMLElement $xml): array
  {
    $publications = [];
    // converts namespaces to camelCase tags
    self::adjustNamespaces($xml);
    foreach ($xml->channel->item as $item) {
      self::adjustNamespaces($item);
    }

    foreach ($xml->channel->item as $item) {
      $publications [] = PublicationBuilder::createPublicationForRSS($item);
    }

    return $publications;
  }

  /**
   * @param SimpleXMLElement $xml
   * @return Publication [];
   */
  public function getPublicationsfromAtom(SimpleXMLElement $xml): array
  {
    $publications = [];
    foreach ($xml->entry as $item) {
      $publications [] = PublicationBuilder::createPublicationForAtom($item);
    }

    return $publications;
  }

  /**
   * Load XML from or HTTP.
   * @param string
   * @return SimpleXMLElement
   * @throws FeedException
   */
  public function loadXml($url)
  {
    $data = false;

    if (extension_loaded('curl')) {
      $request = new RequestService($url);
      $data = $request->execute();
    } else {
      $data = simplexml_load_string(file_get_contents($url));
    }
    if ($data === false) {
      throw new FeedException('Cannot load feed.');
    }
    return new SimpleXMLElement($data, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_NOCDATA);
  }

  /**
   * //RSS feeds name their root node 'rss'.
   * @param SimpleXMLElement $xml
   * @return bool
   */
  public function canReadRss(SimpleXMLElement $xml): bool
  {
    return $xml->getName() === 'rss';
  }

  /**
   * Checks if $xml is Atom feed
   * @param SimpleXMLElement $xml
   * @return bool
   */
  public function canReadAtom(SimpleXMLElement $xml): bool
  {
    return $xml->getName() === 'feed';
  }

  /**
   * adds element from namespaces to Generates better accessible namespaced tags.
   * @param  $element SimpleXMLElement
   * @return void
   */
  private static function adjustNamespaces(SimpleXMLElement $element): void
  {
    foreach ($element->getNamespaces(true) as $prefix => $ns) {
      $children = $element->children($ns);
      foreach ($children as $tag => $content) {
        $element->{$prefix . ucfirst($tag)} = $content;
      }
    }
  }
}
<?php

namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes;


class Publication
{
  private $title;
  private $description;
  private $link;
  private $pubDate;
  private $creator;

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @param string $title
   */
  public function setTitle(string $title): void
  {
    $this->title = $this->clearValuefromHtmlTagsAndSpecialChars($title);
  }

  /**
   * @return string
   */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description): void
  {
    $this->description = $this->clearValuefromHtmlTagsAndSpecialChars($description);
  }

  /**
   * @return string
   */
  public function getLink()
  {
    return $this->link;
  }

  /**
   * @param string $link
   */
  public function setLink(string $link): void
  {
    $this->link = $link;
  }

  /**
   * @return mixed
   */
  public function getPubDate()
  {
    return $this->pubDate;
  }

  /**
   * @param mixed $pubDate
   */
  public function setPubDate($pubDate): void
  {
    $locale = array( "pl_PL", "polish_pol", "pl_PL.ISO8859-2" );
    setlocale( LC_ALL, $locale );
    $time = strtotime($pubDate);
    $date = strftime ('%d %B %Y %H:%M:%S', $time);
    $this->pubDate = $date;
  }

  /**
   * @return mixed
   */
  public function getCreator()
  {
    return $this->creator;
  }

  /**
   * @param mixed $creator
   */
  public function setCreator($creator): void
  {
    $this->creator = $creator;
  }

  private function clearValuefromHtmlTagsAndSpecialChars(string $value)
  {
    return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5));
  }
}
<?php

namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;

use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use PHPUnit\Framework\TestCase;

class PublicationTest extends TestCase
{
  /** @var Publication */
  private $publication;

  protected function setUp(): void
  {
//    Concern Worldwide is transforming lives in 23 of the world's poorest countries.

    $this->publication = new Publication();
    $this->publication->setTitle("2020 Ranking of Global Hunger Index Scores in Concern Worldwide&#39;s Countries of Operation");
    $this->publication->setDescription('<img style="margin:5px; float:left;" src="https://www.globalhungerindex.org/media/images/articles2/concern-countries_thumb.jpg" 
    alt="2020 Ranking of Global Hunger Index Scores in Concern Worldwide&#39;s Countries of Operation" />
    <strong>Concern Worldwide is transforming lives in 23 of the world&#39;s poorest countries.</strong><br />');
    $this->publication->setPubDate('2020-11-19T14:01:00+00:00');
    $this->publication->setLink('https://www.globalhungerindex.org/concern-worldwide.html');
    $this->publication->setCreator('Ethical Sector');

  }

  public function testShouldCreateNewPublicationClass()
  {
    //When
    $publication = new Publication();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertInstanceOf(Publication::class, $publication);
  }

  public function testShouldReturnTitleWithoutHtmlTagsAndSpecialChars()
  {
    //Given
    $title = "2020 Ranking of Global Hunger Index Scores in Concern Worldwide's Countries of Operation";
    //When
    $actual = $this->publication->getTitle();
    //Then
    self::assertEquals($title, $actual);
  }

  public function testShouldReturnDescriptionWithoutHtmlTagsAndSpecialChars()
  {
    //Given
    $description = "Concern Worldwide is transforming lives in 23 of the world's poorest countries.";
    //When
    $actual = $this->publication->getDescription();
    //Then
    self::assertEquals($description, $actual);
  }

  public function testShouldReturnLink()
  {
    //Given
    $link = "https://www.globalhungerindex.org/concern-worldwide.html";
    //When
    $actual = $this->publication->getLink();
    //Then
    self::assertEquals($link, $actual);
  }

  public function testShouldReturnDateWithLocaleSetToPolish()
  {
    //Given
    $date = "19 listopad 2020 15:01:00";
    //When
    $actual = $this->publication->getPubDate();
    //Then
    self::assertEquals($date, $actual);
  }

  public function testShouldReturnCreator()
  {
    //Given
    $creator = "Ethical Sector";
    //When
    $actual = $this->publication->getCreator();
    //Then
    self::assertEquals($creator, $actual);
  }
}

<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\FeedException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services\ReaderService;
use PHPUnit\Framework\TestCase;

class ReaderServiceTest extends TestCase
{
  /** @var ReaderService */
  private $serviceUnderTest;

  public function setUp(): void
  {
    $this->serviceUnderTest = new ReaderService();
  }

  public function testShouldReturnSimpleXmlObjectAfterSuccesfulyLoadedData()
  {
    //Given
    $url = "https://blog.nationalgeographic.org/rss";
    //When
    $actual = $this->serviceUnderTest->loadXml($url);
    //Then
    self::assertInstanceOf(\SimpleXMLElement::class, $actual);
  }

  public function testShouldThrowInvalidFeedExceptionWhenXMlFeedIsInvalid()
  {
    $this->expectException(FeedException::class);

    $this->serviceUnderTest->loadXml('');
  }

  public function testShouldReturnTrueIfXmlIsRssFeed()
  {
    //Given  zmienne wejściowe wyjściowe
    $xml = TestRssAtomFixtures::getXmlWithRssFeed();
    //When wywoływanie metody testowanej
    $actual = $this->serviceUnderTest->canReadRss($xml);
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertTrue($actual);
  }

  public function testShouldReturnTrueIfXmlIsAtomFeed()
  {
    //Given  zmienne wejściowe wyjściowe
    $xml = TestRssAtomFixtures::getXmlWithAtomFeed();
    //When wywoływanie metody testowanej
    $actual = $this->serviceUnderTest->canReadAtom($xml);
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertTrue($actual);
  }

  public function testShouldReturnPublicationsArrayAfterSuccesfullyReadRssXml()
  {
    //Given
    $xml = TestRssAtomFixtures::getXmlWithRssFeed();
    //When
    $publications = $this->serviceUnderTest->getPublicationsfromRss($xml);
    $publication = $publications[0];
    //Then
    self::assertIsArray($publications);
    self::assertInstanceOf(Publication::class,$publication);
  }
  public function testShouldReturnPublicationsArrayAfterSuccesfullyReadAtomXml()
  {
    //Given
    $xml = TestRssAtomFixtures::getXmlWithAtomFeed();
    //When
    $publications = $this->serviceUnderTest->getPublicationsfromAtom($xml);
    $publication = $publications[0];
    //Then
    self::assertIsArray($publications);
    self::assertInstanceOf(Publication::class,$publication);
  }
}
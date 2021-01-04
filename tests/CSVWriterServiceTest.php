<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\AppSettings;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services\CSVWriterService;
use PHPUnit\Framework\TestCase;

class CSVWriterServiceTest extends TestCase
{
  /** @var AppSettings */
  private $settings;
  private $command = "csv:simple";
  private $path = __DIR__ . '\testFile.csv';
  private $url = "https://blog.nationalgeographic.org/rss";
  private $publication;
  /**
   * @var CSVWriterService
   */
  private CSVWriterService $writerServiceUnderTest;

  private $publications = [];

  public function setUp(): void
  {

    $this->settings = AppSettings::getInstance();
    $this->settings->setUrl($this->url);
    $this->settings->setCommand($this->command);
    $this->settings->setPath($this->path);
    $this->publications = [];

    $this->writerServiceUnderTest = new CSVWriterService($this->settings);

    $date = new \DateTime();
    $date->format('Y-m-d H:i:s');

    $this->publication = new Publication();
    $this->publication->setCreator('testCreator');
    $this->publication->setTitle('testTitle');
    $this->publication->setLink('testLink');
    $this->publication->setPubDate($date->format('Y-m-d H:i:s'));
    $this->publication->setDescription('testDescription');

  }

  public function testShouldSavePublicationData()
  {

    //When wywoływanie metody testowanej
    $this->publications [] = $this->publication;
    $this->writerServiceUnderTest->savePublicationData($this->publications);

    $fileArr = file($this->settings->getPath());
    $actual = count($fileArr);

    self::assertEquals(2, $actual);

    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
  }

  public function testShouldOverridePublicationFileWhenCsvSimpleCommandIsSet()
  {
    //Given
    $this->settings->setCommand("csv:simple");
    $this->publications [] = $this->publication;
    //When /Then
    $this->writerServiceUnderTest->savePublicationData($this->publications);

    $fileArr = file($this->settings->getPath());
    $numberOfFileRowsAfterFirstSaveToFile = count($fileArr);

    $this->writerServiceUnderTest->savePublicationData($this->publications);
    self::assertEquals(2, $numberOfFileRowsAfterFirstSaveToFile);

    $fileArr = file($this->settings->getPath());
    $actual = count($fileArr);
    self::assertEquals($numberOfFileRowsAfterFirstSaveToFile, $actual);
  }

  public function testShouldIncludePublicationToFileWhenCsvExtendedCommandIsSet()
  {
    //Given
    $this->settings->setCommand("csv:simple");
    $this->publications [] = $this->publication;
    //When /Then
    $this->writerServiceUnderTest->savePublicationData($this->publications);

    $fileArr = file($this->settings->getPath());
    $numberOfFileRowsAfterFirstSaveToFile = count($fileArr);
    self::assertEquals(2, $numberOfFileRowsAfterFirstSaveToFile);

    $this->settings->setCommand("csv:extended");

    $this->writerServiceUnderTest->savePublicationData($this->publications);

    $fileArr = file($this->settings->getPath());
    $actual = count($fileArr);
    self::assertEquals(3, $actual);
  }

  public function testShouldCheckifFileHasCorrectColumnHeaders()
  {
    //Given
    $this->publications[] = $this->publication;
    $this->settings->setCommand('csv:simple');
    //When
    $this->writerServiceUnderTest->savePublicationData($this->publications);
    $actual = $this->writerServiceUnderTest->checkIfCsvFileHeaderHasCorrectColumns();
    //Then
    self::assertTrue($actual);
  }
}
<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\AppSettings;
use PHPUnit\Framework\TestCase;

class AppSettingsTest extends TestCase
{
  /** AppSettings */
  private $settings;

  public function setUp(): void
  {
    $this->settings = AppSettings::getInstance();
  }

  public function testShouldCheckIfAppSettingsClassIsTheSameInstance()
  {
    //When
    $actual = AppSettings::getInstance();
    //Then
    self::assertSame($this->settings, $actual);
  }

  public function testShouldReturnNullIfCommandWasNotSetSuccessfully()
  {
    //Given  zmienne wejściowe wyjściowe
    $command = "csv:sim";
    //When wywoływanie metody testowanej
    $this->settings->setCommand($command);
    $actual = $this->settings->getCommand();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertNull($actual);
  }

  public function testShouldReturnCommandIfCommandWasSetSuccessfully()
  {
    //Given  zmienne wejściowe wyjściowe
    $command = "csv:simple";
    //When wywoływanie metody testowanej
    $this->settings->setCommand($command);
    $actual = $this->settings->getCommand();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertSame($command, $actual);
  }

  public function testShouldReturnNullIfUrlWasNotSetSuccessfully()
  {
    //Given  zmienne wejściowe wyjściowe
    $rssUrl = "https://blog.nationgraphic.org/rss";
    //When wywoływanie metody testowanej
    $this->settings->setUrl($rssUrl);
    $actual = $this->settings->getUrl();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertNull($actual);
  }

  public function testShouldReturnUrlIfUrlWasSetSuccessfully()
  {
    //Given
    $rssUrl = "https://blog.nationalgeographic.org/rss";
    //When
    $this->settings->setUrl($rssUrl);
    $actual = $this->settings->getUrl();
    //Then
    self::assertSame($rssUrl, $actual);
  }

  public function testShouldReturnNullIfPathWasNotSetSuccessfully()
  {
    //Given  zmienne wejściowe wyjściowe
    $path = __DIR__ . 'test\test.csv';
    //When wywoływanie metody testowanej
    $this->settings->setPath($path);
    $actual = $this->settings->getPath();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertNull($actual);
  }

  public function testShouldReturnPathIfPathWasSetSuccessfully()
  {
    //Given
    $path = __DIR__ . '\test.csv';
    //When
    $this->settings->setPath($path);
    $actual = $this->settings->getPath();
    //Then
    self::assertSame($path, $actual);
  }
}
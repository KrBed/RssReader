<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidCommandArgumentException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidPathException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidSettingsArgumentException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidUrlArgumentException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidUrlrgumentException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Validators\AppSettingsValidator;
use PHPUnit\Framework\TestCase;

class AppSettingsValidatorTest extends TestCase
{

  public function testShouldReturnTrueWhenCommandIsCorrect()
  {
    //Given
    $command = "csv:simple";
    //When

    $actual = AppSettingsValidator::validateCommand($command);
    //Then
    self::asserttrue($actual);
  }

  public function testShouldReturnFalseWhenCommandIsNotCorrect()
  {
    //Given
    $command = "csv:sim";
    //When
    $actual = AppSettingsValidator::validateCommand($command);
    //Then
    self::assertFalse($actual);
  }

  public function testShouldAddInvalidCommandArgumentExceptionMessageToValidationErrorsArrayWhenCommandIsNotCorrect()
  {
    //Given
    $command = "csv:sim";
    $message = "--- Unknown argument type {$command} ---";
    $key = InvalidCommandArgumentException::class;
    //When
    AppSettingsValidator::validateCommand($command);
    $keyExists = array_key_exists(InvalidCommandArgumentException::class, AppSettingsValidator::$validationErrors);
    self::assertTrue($keyExists);
    $actualMessage = AppSettingsValidator::$validationErrors[$key];
    //Then
    self::assertSame($message, $actualMessage);
  }

  public function testShouldReturnTrueWhenRssUrlIsCorrect()
  {
    //Given
    $rssUrl = "https://blog.nationalgeographic.org/rss";
    //When
    $actual = AppSettingsValidator::validateUrl($rssUrl);
    //Then
    self::assertTrue($actual);
  }

  public function testShouldReturnFalseWhenRssUrlIsNotCorrect()
  {
    //Given
    $rssUrl = "https://blog.nationalgeograp.org/rss";
    //When
    $actual = AppSettingsValidator::validateUrl($rssUrl);
    //Then
    self::assertFalse($actual);
  }

  public function testShouldAddInvalidUrlExceptionMessageToValidationErrorsArrayWhenUrlIsNotCorrect()
  {
    //Given
    $rssUrl = "https://blog.nationalgeograp.org/rss";
    $message = "--- Url feed address is invalid {$rssUrl} ---";
    $key = InvalidUrlArgumentException::class;
    //When
    AppSettingsValidator::validateUrl($rssUrl);
    $keyExists = array_key_exists($key, AppSettingsValidator::$validationErrors);
    $actualMessage = AppSettingsValidator::$validationErrors[$key];
    //Then
    self::assertTrue($keyExists);
    self::assertEquals($message, $actualMessage);
  }

  public function testShouldReturnTrueWhenAtomUrlIsCorrect()
  {
    //Given
    $AtomUrl = "https://www.globalhungerindex.org/atom.xml";
    //When
    $actual = AppSettingsValidator::validateUrl($AtomUrl);
    //Then
    self::assertTrue($actual);
  }

  public function testShouldReturnFalseWhenAtomUrlIsNotCorrect()
  {
    //Given
    $AtomUrl = "https://www.globalhger.org/atom.xml";
    //When
    $actual = AppSettingsValidator::validateUrl($AtomUrl);
    //Then
    self::assertFalse($actual);
  }

  public function testShouldReturnTrueWhenPathIsCorrect()
  {
    //Given
    $path = __DIR__ . '\test.csv';
    //When
    $actual = AppSettingsValidator::validatePath($path);;
    //Then
    self::assertTrue($actual);
  }

  public function testShouldReturnFalseWhenPathIsNotCorrect()
  {
    //Given
    $path = 'fail\test.csv';
    //When
    $actual = AppSettingsValidator::validatePath($path);
    //Then
    self::assertFalse($actual);
  }

  public function testShouldAddInvalidPathErrorMessageToValidationErrorsArrayWhenPathIsNotCorrect()
  {
    //Given
    $path = '\fail\test.csv';
    $message = "--- Path to save csv file is invalid {$path} ---";
    $key = InvalidPathException::class;
    //When
    AppSettingsValidator::validatePath($path);
    $keyExists = array_key_exists($key, AppSettingsValidator::$validationErrors);
    $actualMessage = AppSettingsValidator::$validationErrors[$key];
    //Then
    self::assertTrue($keyExists);
    self::assertEquals($message, $actualMessage);
  }
}
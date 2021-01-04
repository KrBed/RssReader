<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\Tests;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services\RequestService;
use PHPUnit\Framework\TestCase;

class RequestServiceTest extends TestCase
{
  public function testShouldReturnStatusCode0AfterSuccesfulCreateCurl()
  {
    //Given
    $url = "https://blog.nationalgeographic.org/rss";
    $request = new  RequestService($url);
    //When
    $actual = $request->getStatusCode();
    //Then
    self::assertEquals(0,$actual);
  }
  public function testShouldReturnStatusCode200AfterSuccesfulDataRequest()
  {
    //Given
    $url = "https://blog.nationalgeographic.org/rss";
    //When
    $request = new  RequestService($url);
    $request->execute();
    $actual = $request->getStatusCode();
    //Then
    self::assertEquals(200,$actual);
  }
  public function testShouldReturnErrorNumber0AfterSuccesfulConnection()
  {
    //Given  zmienne wejściowe wyjściowe
    $url = "https://blog.nationalgeographic.org/rss";
    //When wywoływanie metody testowanej
    $request = new  RequestService($url);
    $actual = $request->getErrorNumber();
    //Then sprawdzamy czego oczekujemy (wywołujemy asercję)
    self::assertEquals(0,$actual);
  }
}
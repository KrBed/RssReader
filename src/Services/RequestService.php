<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services;


class RequestService
{
  private $url;

  private $curl;
  /** @var string */
  public $userAgent = 'FeedFetcher-Google';

  public function __construct($url)
  {
    $this->url = $url;
    $this->curl = $this->initCurl($url);
  }

  private function initCurl($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent); // some feeds require a user agent
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if (!ini_get('open_basedir')) {
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // sometime is useful :)
    }
    return $curl;
  }

  /**
   * @return mixed
   */
  public function getStatusCode()
  {
    return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
  }

  /**
   * @return bool|string
   */
  public function execute()
  {
    $result = curl_exec($this->curl);
    if ($this->getErrorNumber() === 0 && $this->getStatusCode() === 200) {
      return $result;
    }
    return false;
  }

  /**
   * @return int
   */
  public function getErrorNumber(): int
  {
    return curl_errno($this->curl);
  }
}
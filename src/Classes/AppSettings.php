<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Validators\AppSettingsValidator;

class AppSettings
{

  public const CMD_HELP = '--?';
  public const CSV_SIMPLE = "csv:simple";
  public const CSV_EXTENDED = "csv:extended";

  public const ALLOWED_ARGS = [
    self::CMD_HELP,
    self::CSV_SIMPLE,
    self::CSV_EXTENDED
  ];

  public const SUPPORTED_FILE_EXTENSIONS = ['csv'];

  private $command;
  private $url;
  private $path;

  private static $instances = [];

  /**
   * AppSettings constructor.
   */
  protected function __construct()
  {
  }


  protected function __clone()
  {
  }

  public function __wakeup()
  {
    throw new \Exception("Cannot unserialize a singleton.");
  }

  /**
   * @return AppSettings
   */
  public static function getInstance(): AppSettings
  {
    $settings = static::class;
    if (!isset(self::$instances[$settings])) {
      self::$instances[$settings] = new static();
    }

    return self::$instances[$settings];
  }

  /**
   * @return mixed
   */
  public function getCommand()
  {
    return $this->command;
  }

  /**
   * @param string $command
   */
  public function setCommand($command): void
  {
    if (AppSettingsValidator::validateCommand($command)) {
      $this->command = $command;
    } else {
      $this->command = null;
    }

  }

  /**
   * @return mixed
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * @param string $url
   */
  public function setUrl($url): void
  {
    if (AppSettingsValidator::validateUrl($url)) {
      $this->url = $url;
    } else {
      $this->url = null;
    }
  }

  /**
   * @return mixed
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * @param string $path
   */
  public function setPath($path): void
  {
    if (AppSettingsValidator::validatePath($path)) {
      $this->path = $path;
    } else {
      $this->path = null;
    }
  }
}
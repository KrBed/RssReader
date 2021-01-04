<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Validators;


use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\AppSettings;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidCommandArgumentException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidPathException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidUrlArgumentException;


class AppSettingsValidator
{
  public const COMMAND_EXCEPTION_MESSAGE = "--- Unknown argument type";
  public const URL_EXCEPTION_MESSAGE = "--- Url feed address is invalid";
  public const PATH_EXCEPTION_MESSAGE = "--- Path to save csv file is invalid";

  public const ATOM_VALID_MESSAGE = "This is a valid Atom";
  public const RSS_VALID_MESSAGE = "This is a valid RSS";

  public const FEED_VALIDATION_MESSAGES = [
    self::ATOM_VALID_MESSAGE,
    self::RSS_VALID_MESSAGE
  ];

  public const VALIDATE_RSS_URL = 'https://validator.w3.org/feed/check.cgi?url=';

  public static $validationErrors = [];

  /**
   * @param string $command
   * @return bool
   */
  public static function validateCommand($command): bool
  {
    try {
      if (in_array($command, AppSettings::ALLOWED_ARGS, true)) {
        return true;
      }
      throw new InvalidCommandArgumentException(self::COMMAND_EXCEPTION_MESSAGE . " {$command} ---");
    } catch (InvalidCommandArgumentException $ex) {
      self::$validationErrors[InvalidCommandArgumentException::class] = self::COMMAND_EXCEPTION_MESSAGE . " {$command} ---";
      return false;
    }
  }

  /**
   * checks if url is valid
   * @param string $url
   * @return bool
   */
  public static function validateUrl(string $url): bool
  {
    try {
      if ($validationResponse = @file_get_contents(self::VALIDATE_RSS_URL . urlencode($url))) {
        if (self::checkFeedValidationMesage($validationResponse, self::FEED_VALIDATION_MESSAGES)) {
          return true;
        }
      }
      throw new InvalidUrlArgumentException(self::URL_EXCEPTION_MESSAGE . " {$url} ---");
    } catch (InvalidUrlArgumentException $ex) {
      self::$validationErrors[InvalidUrlArgumentException::class] = self::URL_EXCEPTION_MESSAGE . " {$url} ---";
      return false;
    }
  }

  /**
   * checks if path is valid
   * @param string $savePath
   * @return bool
   */
  public static function validatePath(string $savePath): bool
  {
    $fileName = basename($savePath);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $directory = str_replace($fileName, '', $savePath);
    $path = realpath($directory);

    try {
      if(!is_dir($directory)){
        throw new InvalidPathException(self::PATH_EXCEPTION_MESSAGE . " {$savePath} ---");
      }
      if (!in_array($ext, AppSettings::SUPPORTED_FILE_EXTENSIONS, true) || ($path === false && !is_dir($path))) {
        throw new InvalidPathException(self::PATH_EXCEPTION_MESSAGE . " {$savePath} ---");
      }
      return true;
    } catch (InvalidPathException $ex) {
      self::$validationErrors[InvalidPathException::class] = self::PATH_EXCEPTION_MESSAGE . " {$savePath} ---";
      return false;
    }
  }

  /**
   * searches validation message in given string
   * @param string $haystack
   * @param array $validationMessages
   * @return bool
   */
  private static function checkFeedValidationMesage(string $haystack, array $validationMessages): bool
  {
    if (!is_array($validationMessages)) {
      $validationMessages = array($validationMessages);
    }
    foreach ($validationMessages as $message) {
      if (strpos($haystack, $message,) !== false) {
        return true;
      }
    }
    return false;
  }
}
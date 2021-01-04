<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS;

use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\AppSettings;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InternetConnectionException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Exceptions\InvalidNumberOfArgumentsException;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services\CSVWriterService;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services\ReaderService;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Validators\AppSettingsValidator;

class Main
{
  /**
   * List of supported arguemnts.
   * @var array
   */
  public const SUPPORTED_ARGS = [
//    self::CSV      => 'saves RSS data as csv file',
    AppSettings::CSV_SIMPLE   => 'overrides file with taken RSS data',
    AppSettings::CSV_EXTENDED => 'joins taken RSS data to file',
    AppSettings::CMD_HELP     => 'it print help screen'
  ];
  public const INTERNET_EXCEPTION_MESSAGE = "No internet connection.";

  /**
   * checks if arguments write to console are valid
   * @param array $args
   * @return AppSettings
   * @throws InvalidNumberOfArgumentsException
   */
  private static function detectArguments($args = []): AppSettings
  {
    if (count($args) !== 3) {
      throw new InvalidNumberOfArgumentsException('Wrong number of argument, allowed number is 3');
    }
    $settings = AppSettings::getInstance();
    $settings->setCommand($args[0]);
    $settings->setUrl($args[1]);
    $settings->setPath($args[2]);
    if (!empty(AppSettingsValidator::$validationErrors)) {
      foreach (AppSettingsValidator::$validationErrors as $key => $message) {
        echo "  [" . $key . "]" . "\n" . "  " . $message;
        echo "\n";
      }
      die();
    }
    return $settings;
  }

  /**
   * It return a string with welcome message, version info and avaliable arguments
   */
  public static function helpMessageScreen(): void
  {
    echo("\r");
    echo "\n| Arguments lists: \n";
    // fixed width
    $mask = "|\t%-20s\t |\t%-30s\n";
    printf("|\t%-20s\t |\t%-30s", 'Command', 'Description');
    echo "\n";

    foreach (self::SUPPORTED_ARGS as $CMD => $DESC)
      printf($mask, $CMD, $DESC);
  }

  /**
   * Main function to execute app
   * @param array $arguments
   * @throws Exceptions\FeedException
   * @throws InternetConnectionException
   * @throws InvalidNumberOfArgumentsException
   */
  public static function execute($arguments = []): void
  {
    if(($arguments[0] === AppSettings::CMD_HELP )){
      self::helpMessageScreen();
      die();
    }
    echo "Checking internet connection \n";
    self::checkInterneConnection();
    echo "Internet connection OK";

    $settings = self::detectArguments($arguments);
    echo "+ Connecting to  RSS Reader...\n";

    $service = new ReaderService();
    $publications = $service->load($settings->getUrl());
    if (!empty($publications)) {
      echo "+ RSS data loaded successfully...\n";
    }
    echo "+ Saving RSS data to {$settings->getPath()} file ...\n";

    $writer = new CSVWriterService($settings);
    if ($writer->savePublicationData($publications)) {
      echo "+ Data saved successfully to {$settings->getPath()} file ...\n";
    }
    echo "+ End of program. Bye Bye ...\n";
  }

  /**
   * checks if is internet connection
   * @return bool
   * @throws InternetConnectionException
   */
  public static function checkInterneConnection(): bool
  {
    $connected = @fsockopen("www.google.com", 443);

    if ($connected) {
      fclose($connected);
      return true;
    }
    throw new InternetConnectionException(self::INTERNET_EXCEPTION_MESSAGE);
  }
}
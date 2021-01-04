<?php


namespace KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Services;

use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\AppSettings;
use KrzysztofBednarskiRekrutacjaHRtec\FeedRSS\Classes\Publication;
use RuntimeException;
use SplFileObject;

class CSVWriterService
{
  /**
   * @var AppSettings
   */
  private $settings;
  private $fileConnector;

  public const HEADER_COLUMNS = [
    "title", "description", "link", "pubDate", "creator"
  ];

  public const OVERRIDE = 'wb+';
  public const INCLUDE = 'ab+';
  public const READ = 'r+';

  public const SAVE_OPTIONS = [
    self::OVERRIDE, self::INCLUDE,self::READ
  ];

  /**
   * CSVWriterService constructor.
   * @param AppSettings $settings
   * @param Publication [] $publications
   */
  public function __construct(AppSettings $settings)
  {
    $this->settings = $settings;
    if (!file_exists($settings->getPath())) {
      touch($settings->getPath());
    }
    $this->fileConnector = new SplFileObject($settings->getPath(), self::READ);
  }

  /**
   * @param Publication[] $publications
   */
  public function savePublicationData(array $publications) :bool
  {
    switch ($this->settings->getCommand()) {
      case $this->settings->getCommand() === AppSettings::CSV_SIMPLE:
        $this->addToCsvFile($publications, true, self::OVERRIDE);
        return true;
        break;
      case $this->settings->getCommand() === AppSettings::CSV_EXTENDED:
        if ($this->fileConnector->getSize() === 0 && !$this->checkIfCsvFileHeaderHasCorrectColumns()) {
          $this->addToCsvFile($publications, true, self::INCLUDE);
        } else {
          $this->addToCsvFile($publications, false, self::INCLUDE);
        }
        return true;
        break;
      default:
        break;
    }
  }

  /**
   * @param array $publications
   * @param bool $addHeaderColumns
   * @param string $SAVE_OPTIONS
   */
  private function addToCsvFile(array $publications, bool $addHeaderColumns, string $SAVE_OPTIONS)
  {
    if(!in_array($SAVE_OPTIONS,self::SAVE_OPTIONS)){
      throw new RuntimeException("Invalid Save option");
    }
    $this->fileConnector = new SplFileObject($this->settings->getPath(), $SAVE_OPTIONS);
    if ($addHeaderColumns) {
      $this->fileConnector->fputcsv(self::HEADER_COLUMNS);
    }
    foreach ($publications as $publication) {
      $this->fileConnector->fputcsv((array)$publication);
    }
  }

  /**
   * @return array|false
   */
  public function checkIfCsvFileHeaderHasCorrectColumns()
  {
    $this->fileConnector->rewind();
    $columns = $this->fileConnector->fgetcsv();
    if ($columns === self::HEADER_COLUMNS) {
      return true;
    }
    return false;
  }
}


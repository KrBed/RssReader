RSS-Reader
================

:package_description

- [Uruchomienie](#uruchomienie)
- [Testy](#testing)

Uruchomienie
------------

Po pobraniu projektu wywołujemy komendę "composer install"
Następnie composer "dump-autoload" - aktualizacja namespace

Aby uruchomić aplikacje należy wejść do folderu /src 
uruchamiamy komendą php console.php [komenda] [url] [ścieżka do zapisu]
Parametry trzeba oddzielić spacjią
Wpisanie komendy "--?" uruchomi help screen

Testy
-------

testy możemy uruchomiś z konsoli komendą z katalogu głownego aplikacji "./vendor/bin/phpunit"
Można też dodać konfiguracjię PHPUnit w PhpStorm i podać ścieżkę do katalogu z testami 



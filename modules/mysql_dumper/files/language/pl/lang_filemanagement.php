<?php
$lang['L_CONVERT_START'] = 'Rozpocznij konwersję';
$lang['L_CONVERT_TITLE'] = 'Konwertuj kopię do formatu MSD';
$lang['L_CONVERT_WRONG_PARAMETERS'] = 'Błędne parametry!  Konwersja nie możliwa.';
$lang['L_FM_UPLOADFILEREQUEST'] = 'wybierz plik.';
$lang['L_FM_UPLOADNOTALLOWED1'] = 'Ten format pliku nie jest obsługiwany.';
$lang['L_FM_UPLOADNOTALLOWED2'] = 'Poprawne formaty plików to: *.gz i *.sql .';
$lang['L_FM_UPLOADMOVEERROR'] = 'Nie można przenieść wybranego pliku do katalogu wysyłania.';
$lang['L_FM_UPLOADFAILED'] = 'Wysyłanie nie udane!';
$lang['L_FM_UPLOADFILEEXISTS'] = 'Plik o takiej nazwie już istnieje!';
$lang['L_FM_NOFILE'] = 'Nie wybrano pliku!';
$lang['L_FM_DELETE1'] = 'Plik ';
$lang['L_FM_DELETE2'] = ' został pomyślnie usunięty.';
$lang['L_FM_DELETE3'] = ' nie został usunięty!';
$lang['L_FM_CHOOSE_FILE'] = 'Wybrany plik:';
$lang['L_FM_FILESIZE'] = 'Rozmiar pliku';
$lang['L_FM_FILEDATE'] = 'Data modyfikacji pliku';
$lang['L_FM_NOFILESFOUND'] = 'Plik nie znaleziony.';
$lang['L_FM_TABLES'] = 'Tabele';
$lang['L_FM_RECORDS'] = 'Rekordy';
$lang['L_FM_ALL_BU'] = 'Wszystkie kopie zapasowe';
$lang['L_FM_ANZ_BU'] = 'Kopie zapasowe';
$lang['L_FM_LAST_BU'] = 'Ostatnia kopia zapasowa';
$lang['L_FM_TOTALSIZE'] = 'Całkowity rozmiar';
$lang['L_FM_SELECTTABLES'] = 'Wybierz tabele';
$lang['L_FM_COMMENT'] = 'Wpisz komentarz';
$lang['L_FM_RESTORE'] = 'Przywróć';
$lang['L_FM_ALERTRESTORE1'] = 'Czy baza danych';
$lang['L_FM_ALERTRESTORE2'] = 'powinna być przywrócona z rekordami z pliku';
$lang['L_FM_ALERTRESTORE3'] = ' ?';
$lang['L_FM_DELETE'] = 'Usuń';
$lang['L_FM_ASKDELETE1'] = 'Czy plik(i)';
$lang['L_FM_ASKDELETE2'] = 'na pewno mają być usunięte?';
$lang['L_FM_ASKDELETE3'] = 'Czy chcesz uruchomić automatyczne usuwanie plików?';
$lang['L_FM_ASKDELETE4'] = 'Czy chcesz usunąć wszystkie kopie zapasowe?';
$lang['L_FM_ASKDELETE5'] = 'Czy chcesz usunąć wszystkie kopie zapasowe z ';
$lang['L_FM_ASKDELETE5_2'] = '_* ?';
$lang['L_FM_DELETEAUTO'] = 'Uruchom automatyczne usuwanie ręcznie';
$lang['L_FM_DELETEALL'] = 'Usuń wszystkie pliki kopii zapasowej';
$lang['L_FM_DELETEALLFILTER'] = 'Usuń wszystkie z  ';
$lang['L_FM_DELETEALLFILTER2'] = '_*';
$lang['L_FM_STARTDUMP'] = 'Rozpocznij nową kopię zapasową';
$lang['L_FM_FILEUPLOAD'] = 'Wyślij plik';
$lang['L_FM_DBNAME'] = 'Nazwa bazy danych';
$lang['L_FM_FILES1'] = 'Kopie zapasowe baz danych';
$lang['L_FM_FILES2'] = 'Struktury bazy danych';
$lang['L_FM_AUTODEL1'] = 'Automatyczne usuwanie: podane pliki zostały usunięte z powodu przekroczenia wybranych wartości:';
$lang['L_DELETE_FILE_SUCCESS'] = 'Plik \'%s\' został pomyślnie usunięty.';
$lang['L_FM_DUMPSETTINGS'] = 'Konfiguracja kopii zapasowej';
$lang['L_FM_OLDBACKUP'] = '(nieznane)';
$lang['L_FM_RESTORE_HEADER'] = 'Przywróć bazę danych \'<strong>%s</strong>\'';
$lang['L_DELETE_FILE_ERROR'] = 'Błąd podczas usuwania pliku \'%s\'!';
$lang['L_FM_DUMP_HEADER'] = 'Kopia zapasowa';
$lang['L_DOCRONBUTTON'] = 'Uruchom skrypt Pearl Cron';
$lang['L_DOPERLTEST'] = 'Testuj moduły Pearl';
$lang['L_DOSIMPLETEST'] = 'Test Perl';
$lang['L_PERLOUTPUT1'] = 'Wejście do crondump.pl dla absolute_path_of_configdir';
$lang['L_PERLOUTPUT2'] = 'URL dla przeglądarki lub dla skryptów Cron';
$lang['L_PERLOUTPUT3'] = 'Komenda dla serwera Shell lub dla Crontab';
$lang['L_RESTORE_OF_TABLES'] = 'Wybierz tabele, które mają być przywrócone';
$lang['L_CONVERTER'] = 'Konwerter kopii zapasowych';
$lang['L_CONVERT_FILE'] = 'Pliki do skonwertowania';
$lang['L_CONVERT_FILENAME'] = 'Nazwa pliku docelowego (bez rozszerzenia)';
$lang['L_CONVERTING'] = 'Konwertowanie';
$lang['L_CONVERT_FILEREAD'] = 'Odczyt pliku \'%s\'';
$lang['L_CONVERT_FINISHED'] = 'Konwersja uukończona, \'%s\' został zapisany pomyślnie.';
$lang['L_NO_MSD_BACKUPFILE'] = 'Kopie zapasowe innych skryptów';
$lang['L_MAX_UPLOAD_SIZE'] = 'Maksymalny rozmiar pliku';
$lang['L_MAX_UPLOAD_SIZE_INFO'] = 'Jeśli plik kopii zapasowej jest większy od ustawionego limitu, musisz wysłać go przez klienta FTP do katalogu \'work/backup\'. 
Następnie możesz wybrać ten plik by rozpocząć procesz przywracania kopii. ';
$lang['L_ENCODING'] = 'kodowanie';
$lang['L_FM_CHOOSE_ENCODING'] = 'Wybierz kodowanie kopii zapasowej';
$lang['L_CHOOSE_CHARSET'] = 'MySQLDumper nie mógł wykryć kodowania kopii zapasowej automatycznie.
<br>Musisz wybrać kodowanie znaków, które zostało użytwe przy tworzeniu kopii zapasowej.
<br>Jeśli odkryjesz jakiekolwiek problemy ze znakami po przywróceniu kopii, możesz powtórzyć cały proces, wybierając inne kodowanie znaków.
<br>Powodzenia. ;)';
$lang['L_DOWNLOAD_FILE'] = 'Pobierz plik';
$lang['L_BACKUP_NOT_POSSIBLE'] = 'Kopia zapasowa systemowej bazy danych `%s` nie jest możliwa!';
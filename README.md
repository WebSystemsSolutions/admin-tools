RU 
# admin-tools

Набор инструментов  для административных задач:

Подключение:
```
composer require sd1328/admin-tools
```


#### 1.1 Ридер логов
> /Service/LogPageReader

Позволяет постраничное чтение текстовых логов (удобно в случае лога большого размера)  начиная с конца (последних добавленных строк).

Может использоваться для мониторинга состояния различных текстовых логов.

__Пример использования:__
```php
$logReader = new LogPageReader('/var/www/logs/test-log', 5 * 1024);

// Чтение 1 страницы (самого конца лога)
$page1 = $logReader->getLogContent();
// получаем смещение для чтения следующей страницы
$prevOffset = $logReader->getLastOffset();

// Чтение 2 страница (движение с конца файла)
// устанавливаем смещение предыдущей страницы
$logReader->setLastOffset($prevOffset);
$page2 = $logReader->getLogContent();
// получаем смещение для чтения следующей страницы
$prevOffset = $logReader->getLastOffset();
```

#### 2.1 Получение показателей работы сервера
> /Server/OsMonitoring

Компонент состоит из набора классов сенсоров `/Server/Sensors/...`, каждый из которых возвращает один из показателей работы сервера:
- показатели загрузки процессора
- показатели использования оперативной памяти
- показатели файловой системы

Может использоваться для мониторинга работы сервера.

__Пример использования:__
```php
// можно задать список получаемых показателей - по умолчанию все доступные
$sensorList = null;
$stat = new OsMonitoring($sensorList);

// получения показаний
foreach ($stat->getMeters() as $key => $meter) {
    echo $key . ' : ' . $meter . PHP_EOL;
}

```
ENG
# admin-tools

A set of tools for administrative tasks:

Connection:
```
composer require sd1328 / admin-tools
```


#### 1.1 Log Reader
> / Service / LogPageReader

Allows page-by-page reading of text logs (conveniently in the case of a large-sized log) starting from the end (last lines added).

It can be used to monitor the status of various text logs.

__Example use: __
`` php
$ logReader = new LogPageReader ('/ var / www / logs / test-log', 5 * 1024);

// Reading 1 page (the very end of the log)
$ page1 = $ logReader-> getLogContent ();
// get the offset to read the next page
$ prevOffset = $ logReader-> getLastOffset ();

// Reading 2 page (movement from the end of the file)
// set the offset of the previous page
$ logReader-> setLastOffset ($ prevOffset);
$ page2 = $ logReader-> getLogContent ();
// get the offset to read the next page
$ prevOffset = $ logReader-> getLastOffset ();
```

#### 2.1 Getting Server Performance Indicators
> / Server / OsMonitoring

The component consists of a set of sensor classes `/ Server / Sensors / ...`, each of which returns one of the server performance indicators:
- CPU utilization rates
- indicators of the use of RAM
- file system indicators

Can be used to monitor server operation.

__Example use: __
`` php
// you can set a list of the received indicators - by default all available
$ sensorList = null;
$ stat = new OsMonitoring ($ sensorList);

// getting testimony
foreach ($ stat-> getMeters () as $ key => $ meter) {
    echo $ key. ':'. $ meter. PHP_EOL;
}

```

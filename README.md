Gitter
======

### Публикуем файл конфигурации
```
php artisan config:publish laravelrus/gitter-bot
```
Открываем файл `app/config/packages/laravelrus/gitter-bot/config.php`
Прописываем токен (token) в сервисе Gitter.im и ID комнаты (roomId) с которой планируем работать

### Создаем таблицу в базе данных (опционально)
```
php artisan migrate --package=laravelrus/gitter-bot
```

### Наполняем таблицу gitter_users участниками чата (опционально)
```
php artisan db:seed --class=Laravelrus\Gitter\GitterUserTableSeeder
```

### Пример отправки сообщения
```
$gitter = App::make('gitter');

$message = \Laravelrus\Gitter\GitterMessage::newInstance('Сообщение');

// Чтобы отправить сообщение в виде статуса
$message->isStatus();

$gitter->sendMessage($message);
```


### Получить список участников комнаты
```
$gitter = App::make('gitter');

$user = $gitter->users();
```

### Установить произвольный User Agent
```
$gitter = App::make('gitter');

$gitter->setUserAgent('Firefox');
```

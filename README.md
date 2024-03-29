# Телеграм-бот для викторин

Настоящий бот работает и находится тут: [@FullRussiaBot](https://t.me/FullRussiaBot) — викторина для автомобилистов по мотивам игры Full Throttle.

На этом же движке работают еще два бота:

+ [@EverlastingRussiaBot](https://t.me/EverlastingRussiaBot) — помоги пионеру остаться в лагере «Совенок», ответив на все вопросы медсестры. Викторина по гербам и флагам регионов России.

+ [@GeografRussiaBot](https://t.me/GeografRussiaBot) — помоги географу вернуть пропитый глобус.

## Установка

+ composer install
+ Создайте БД MySQL и разверните дамп setup.sql.
+ В bot/lib/cfg.php укажите реквизиты доступа к базе и токен бота.
+ Зайдите по адресу https://your.domain/bot/webhook.php — callback будет зарегистрирован в Telegram API, и бот начнет работать.

## Кастомизация

Вся логика игры находится в файле bot/lib/gamecore.php, для изменения логики работы править нужно его.

Для создания игры на тех же принципах, но с другим контентом необходимо править следующие файлы:

+ bot/lib/cfg.php — реплики бота, имеющие отношение к герою;

+ bot/img/region/all.txt — список всех правильных ответов;

+ bot/img/region/01...99/info.txt — правильный ответ на текущую картинку;

+ в папке bot/img/region/01...99 — находятся картинки для вопросов.

На каждом шаге игры бот выбирает случайную папку из bot/img/region, подпапки 01...99. Далее выбирает случайную картинку из данной папки и показывает ее пользователю. Из файла info.txt в выбранной папке берет ответ на данную картинку. Отображает 4 кнопки для ответа, одна из кнопок — правильный ответ, остальные три — любые ответы из bot/img/region/all.txt.

Посмотреть, как это работает: [@FullRussiaBot](https://t.me/FullRussiaBot).

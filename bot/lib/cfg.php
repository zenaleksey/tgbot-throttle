<?php

if(false)
{
	error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED));
	ini_set('display_errors', 1);
}

$tgapikey = 'telegram-token';

$mysql_host = "localhost";
$mysql_db = "full";
$mysql_user = "full";
$mysql_password = "password";

$txt_other_game = file_get_contents('../other_game.txt');

$txt_welcome =
"Привет, Бен! 

Как видишь, все детали у меня есть, и мы починим твой мотоцикл! 

Но сначала тебе нужно доказать, что ты действительно крутой байкер и главарь банды. 

Ты готов потягаться со мной?"; 

$button_start = "Заводи мотор, детка!"; 

$txt_zadanie = "Смотри на номерные знаки, которые я украла в дальних поездках, и угадывай регион!"; 

$txt_gameover =
"*GAME OVER* 

Ты облажался, Бен! И тебя ждет неминуемая смерть!"; 

$score_award01 = 5;

$txt_award01 =
"*Приз: канистра бензина* 

Получай свой приз, Бен! 

Начало положено, но тебе предстоит еще много работы и много заработанных деталей. Продолжай в том же духе, ковбой!"; 

$score_award02 = 15;

$txt_award02 =
"*Приз: передняя вилка 

Мы все ближе к цели, Бен! Совсем скоро ты покинешь это место!"; 

$score_award03 = 45;

$txt_award03 =
"*Приз: поход в бар* 

Бен, осталось совсем немного! Сходи попей пива с друзьями, а я пока займусь делом. 

Продолжишь завтра утром. Ты заслужил отдых..."; 

$score_win = 80;

$txt_win =
"*Ты выиграл, а мотоцикл готов!* 

— Бен, забирай свой мотоцикл! 

И задай всем жару, ты настоящий мужик!"; 

?>
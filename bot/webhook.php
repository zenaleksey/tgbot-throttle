<?php

header('Content-Type: text/html; charset=utf-8');
require_once("vendor/autoload.php");
require_once("lib/cfg.php");
require_once("lib/tgbot.inc.php");
require_once("lib/gamecore.php");


$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_db", $mysql_user, $mysql_password);
$bot = new \TelegramBot\Api\Client($tgapikey, null);

if(!file_exists("registered.trigger"))
{ 
	$page_url = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$result = $bot->setWebhook($page_url);
	if($result){
		file_put_contents("registered.trigger",time());
	} else die("ошибка регистрации");
}

new MyGame($bot, $db);



echo "bot-tyt";
?>

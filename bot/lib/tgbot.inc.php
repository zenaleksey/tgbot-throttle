<?php
/* 
 * TgClass v0.0.1
 * Author: Zen Aleksey
 *
 */

class TGBot
{
   protected $bot;
   protected $db;
   protected $session;
   protected $chatid;
   private $session_load_flag = false;
   private $keyboard = null;
   
   static public function baseurl()
   {
      return 'https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/';   
   }
   
   private function loadsession($chatid)
   {
   	$this->chatid = $chatid;
   	$this->session_load_flag = true;
   	
 
   	$stmt = $this->db->prepare("SELECT * FROM session WHERE `tgid` = ?");
      $stmt->execute([$chatid]);
      if($row = $stmt->fetch(PDO::FETCH_LAZY)) 
      {
          $this->session = json_decode($row["session"], true);
      }
      else 
      {
      	
      	$this->session = array();
      	$json = json_encode($this->session);
      	
      	$s = $this->db->prepare("INSERT INTO `session` (`tgid`, `session`, `createtime`) VALUES (:tgid, :json, :createtime)");
         $s->execute(['tgid' => $chatid, 'json' => $json, 'createtime' => time()]);
       
      }
      
   
   }
   
   private function savesession()
   {
      $json = json_encode($this->session);
       
      $s = $this->db->prepare("UPDATE `session` SET `session`=:json, `cyrtime`=:cyrtime WHERE `tgid`=:tgid");
      $s->execute(['tgid' => $this->chatid, 'json' => $json, 'cyrtime' => time()]);
   }
   
   public function __construct($tgbot, $pdo_db)
   {
   	$this->bot = $tgbot;
   	$this->db = $pdo_db;
   	$thisis = $this;
   	
      $this->bot->command('start', function ($message) use ($thisis) 
      {   
        
        $thisis->loadsession($message->getChat()->getId());
                
        $replay = $thisis->start();
        if($replay !== false)
        {
           $thisis->bot->sendMessage($message->getChat()->getId(), $replay);
        }
      });

      $this->bot->command('help', function ($message) use ($thisis) 
      {   
        
               
        $thisis->loadsession($message->getChat()->getId());
        
        $replay = $thisis->help();
        if($replay !== false)
        {
           $thisis->bot->sendMessage($message->getChat()->getId(), $replay);
        }
      });
      
      $this->bot->on(function($Update) use ($thisis)
      {
	      $message = $Update->getMessage();
	      $mtext = $message->getText();
	      $cid = $message->getChat()->getId();
	      
	      $thisis->loadsession($message->getChat()->getId());
	
	      if(mb_strlen($mtext) >= 1 )
	      {
	      	$replay = $thisis->text($mtext);
            if($replay !== false)
            {
               $thisis->bot->sendMessage($message->getChat()->getId(), $replay);
            }
   	   }
       }, function($message) { return true; /* когда тут true - команда проходит */ });
      
        
      
      $this->bot->run();    
   }
   
   function __destruct()
   {
      if($this->session_load_flag) $this->savesession();
   }
   
   //Use this command for communication with user
   protected function SendText($txt)
   {
       $this->bot->sendMessage($this->chatid, $txt, 'Markdown', false, null, $this->keyboard);
   }   
    
   protected function SendPhoto($url)
   {
   	try 
   	{
   	    $this->bot->sendPhoto($this->chatid, $url);
   	}
   	catch (\TelegramBot\Api\HttpException $e) 
      {
          error_log("Error SendPhoto: $url");
      }
      
   }
   
   protected function SetKeyboard($key)
   {
       $this->keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($key, true); // true for one-time keyboard  
   }
   
   //Overwrite this commands in you child class
   protected function start()
   {
      $this->session['start'] = "yes";
            
      return "This is start command.";   
   }
   
   protected function help()
   {
      return "This is help command.";   
   }
   
   protected function text($text)
   {
      return "You type: $text";   
   }
   
   
}

?>

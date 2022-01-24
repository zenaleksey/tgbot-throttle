<?php

/* 
 * TgGame Full Throttle v0.1
 * Author: Zen Aleksey
 *
 */

function randjpg($dir)
{
  $dirs = glob($dir."/*", GLOB_ONLYDIR);
  $dir = $dirs[ rand(0, count($dirs) - 1) ];

  $files = glob("$dir/*.jpg");
  $file = $files[ rand(0, count($files) - 1) ];
  
  return $file;
}

class MyGame extends TGBot
{
	
	protected function start()
	{
	  if(!isset($this->session['best_result'])) $this->session['best_result'] = 0;
     $this->session["life"] = 3;
     $this->session["score"] = 0;
     $this->session["true_answer"] = '';
     	
	  $this->SendPhoto($this->baseurl()."img/boss.jpg");
	  
	  $this->SetKeyboard(array(array($GLOBALS['button_start'])));
	   
	  $this->SendText($GLOBALS['txt_welcome']);

     return false;
	}
	
	protected function text($txt)
	{
		if(mb_stripos($txt, $GLOBALS['button_start']) !== false)
		{
			//Начинаем игру
			$this->SetKeyboard(null);
			$this->session["score"] = 0;
			$this->session["life"] = 3;
			
			$this->SendText($GLOBALS['txt_zadanie']);
			               
			$this->gamestep();
	   }
	   else if(mb_stripos($txt, "/reset") !== false)
	   {
	        $this->session['best_result'] = 0;
	        $this->SendText("Рекорд сброшен!");
	   }
	   else if(mb_stripos($txt, "Упс") !== false)
	   {
	   	  $this->gamestep();
	   }
	   else if(mb_stripos($txt, "Играть еще раз") !== false)
	   {
	   	  $this->start();
	   }
	   else if(mb_stripos($txt, "Играть в другие игры") !== false)
	   {
	   	  $this->SendText($GLOBALS['txt_other_game']);
	   }
	   else if(mb_stripos($txt, "Получить приз") !== false)
	   {
	   	  //Призы
	   	  
	   	  if($this->session['best_result'] < $GLOBALS['score_award01']) 
	   	  {
	   	  	  $this->SendText(
	   	  	                    "Что бы получить приз нужно набрать хотя бы ".$GLOBALS['score_award01']." очков.".
	   	  	                    "\n\nВаш рекорд: ". $this->session['best_result'] .
	   	  	                    "\n\nПризов у вас пока нет!".
	   	  	                    "\n\n Переиграть? /start"
	   	  	                 );
	   	  }
	   	  else if($this->session['best_result'] >= $GLOBALS['score_award01'] && $this->session['best_result'] < $GLOBALS['score_award02'])
	   	  {
              	   	  	 
	   	  	  //award01
	   	  	  $this->SendPhoto($this->baseurl()."img/award01.jpg");
	   	  	  
	   	  	  $this->SendText(
                               "Мой рекорд: ".$this->session['best_result']." очков\n\n".	   	  	                   
	   	  	                   $GLOBALS['txt_award01']
	   	  	                 );
	   	  	                 
	   	  	  $this->SendText(
	   	  	                   "_Перешли это сообщение друзьям и похвастайся своими успехами в игре!_".
	   	  	                   "\n\nНабирай еще больше очков и получай новые призы! Следующий приз при ".$GLOBALS['score_award02']. " очках.".
	   	  	                   "\n\nСыграем еще? /start"
	   	  	                 );
	   	  }

	   	  else if($this->session['best_result'] >= $GLOBALS['score_award02'] && $this->session['best_result'] < $GLOBALS['score_award03'])
	   	  {
	   	  	  //award02
	   	  	  $this->SendPhoto($this->baseurl()."img/award02.jpg");
	   	  	  $this->SendText(
                               "Мой рекорд: ".$this->session['best_result']."\n\n".	   	  	                   
	   	  	                   $GLOBALS['txt_award02']
	   	  	                 );
	   	  	  $this->SendText(
	   	  	                   "_Перешли это сообщение друзьям и похвастайся своими успехами в игре!_".
	   	  	                   "\n\nНабирай еще больше очков и получай новые призы! Следующий приз при *".$GLOBALS['score_award03']." очках.*".
	   	  	                   "\n\nСыграем еще? /start"
	   	  	                 );	   	  	  
	   	  
	   	  }
	   	  else if($this->session['best_result'] >= $GLOBALS['score_award03'] && $this->session['best_result'] < $GLOBALS['score_win'])
	   	  {
	   	  	  //award03
	   	  	  $this->SendPhoto($this->baseurl()."img/award03.jpg");
	   	  	  $this->SendText(
                               "Мой рекорд: ".$this->session['best_result']."\n\n".	   	  	                   
	   	  	                   $GLOBALS['txt_award03']
	   	  	                 );
	   	  	  $this->SendText(
	   	  	                   "_Перешли это сообщение друзьям и похвастайся своими успехами в игре!_".
	   	  	                   "\n\nНабирай еще больше очков и получай новые призы! Вы выиграете набрав *".$GLOBALS['score_win']." очков.*".
	   	  	                   "\n\nСыграем еще? /start"
	   	  	                 );		   	  	  
	   	  
	   	  }
	   	  else if($this->session['best_result'] >= $GLOBALS['score_win'] )
	   	  {
	   	  	  //win
	   	  	  $this->SendPhoto($this->baseurl()."img/win.jpg");
	   	  	  $this->SendText(
                               "Мой рекорд: ".$this->session['best_result']."\n\n".	   	  	                   
	   	  	                   $GLOBALS['txt_win']
	   	  	                 );
	   	  	  $this->SendText(
	   	  	                   "_Перешли это сообщение друзьям и похвастайся своими успехами в игре!_".
	   	  	                   "\n\nСыграем еще? /start"
	   	  	                 );		   	  
	   	  }

	   }
	   else 
	   {  	
	   	
	   	if(mb_stripos($this->session['true_answer'], $txt) !== false)
	   	{
             //Угадал           
             $this->session["score"] = $this->session["score"] + 1;	   	    
	   	    $this->SendText(
	   	                     "Верно, это ".$this->session['true_answer'].
	   	                     "\n\n Набрано очков: ".$this->session['score'].
	   	                     "\n\n Осталось жизней: ".$this->session['life']
	   	                   );
	   	    $this->gamestep();
	   	}
	   	else 
	   	{
            //Ошибся
            $this->session["life"] = $this->session["life"] - 1;
            
            if($this->session["life"] <= 0) //
            {
            	//Закончились жизни
            	
            	if($this->session['best_result'] < $this->session['score']) $this->session['best_result'] = $this->session['score'];
            	
            	if($this->session['score'] >= $GLOBALS['score_win'])
            	{
            		//выиграл игру
            		            	$this->SendPhoto($this->baseurl()."img/win.jpg");
            	                  $this->SetKeyboard(
            	                    array(
            	                             array("Получить приз"),
            	                             array("Играть в другие игры"),
            	                             array("Играть еще раз")
            	                         )
            	                    
            	                  );
            	                  $this->SendText(  
            	                                   "На самом деле это: ".$this->session['true_answer']." Но ты уже выиграл!\n\n".
	   	                                          $GLOBALS['txt_win'].
	   	                                          "\n\nНабрано очков: ".$this->session['score'].
	   	                                          " (твой рекорд: ".$this->session['best_result'].")".
	   	                                          "\n\n\nПовторим?"
	   	                                       );
            	}
            	else 
            	{
            		//проиграл игру
            		            	$this->SendPhoto($this->baseurl()."img/game_over.jpg?nocache=21");
            	                  $this->SetKeyboard(
            	                    array(
            	                             array("Получить приз"),
            	                             array("Играть в другие игры"),
            	                             array("Играть еще раз")
            	                         )
            	                    
            	                  );
            	                  $this->SendText(  
            	                                   "На самом деле это: ".$this->session['true_answer']."\n\n".
	   	                                          $GLOBALS['txt_gameover'].
	   	                                          "\n\nНабрано очков: ".$this->session['score'].
	   	                                          " (твой рекорд: ".$this->session['best_result'].")".
	   	                                          "\n\n\nПовторим?"
	   	                                       );
            	}

            	
            }
            else 
            {
            	//Просто ошибся
            	$this->SetKeyboard(array(array("Упс...")));	   
	   	      $this->SendText(
	   	                        "Не верно! На самом деле, это ".$this->session['true_answer'].
	   	                        "\n\n Набрано очков: ".$this->session['score'].
	   	                        "\n\n Осталось жизней: ".$this->session['life']
	   	                     );
            	
            }
	   	}

	   }
	   return false;
	}
	
	protected function gamestep()
	{
       $img = randjpg("img/region");
       $right_answer = str_replace('\n', '', file_get_contents(dirname($img)."/info.txt"));

       $all_regions = file('img/region/all.txt');

       $buttons = array();
       $buttons[] = $right_answer;
       $buttons[] = $all_regions[ rand(1, count($all_regions) - 2) ];
       $buttons[] = $all_regions[ rand(1, count($all_regions) - 2) ];
       $buttons[] = $all_regions[ rand(1, count($all_regions) - 2) ];
       shuffle($buttons); 		
		
		
		$this->session['true_answer'] = $right_answer;
	   $this->SetKeyboard(array( 
	   	                          array($buttons[0]), 
	   	                          array($buttons[1]),
	   	                          array($buttons[2]),
	   	                          array($buttons[3])
	                         )); 
	   $this->SendPhoto($this->baseurl().$img);
	   $this->SendText("Угадал?");
	}


}

?>

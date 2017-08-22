<?PHP
if(file_exists($lockfile) && $i > 100){
  $parts = explode("!",$server['READ_BUFFER']);
  $name = $parts[0];
  $parts = explode(":",$server['READ_BUFFER']); 
  $message = $parts[2];
  if (trim($message) != '') {  
      // ignore system messages in meeting log
      $pos_t1 = strpos($server['READ_BUFFER'], 'MDPPbot');
      $pos_t2 = strpos($server['READ_BUFFER'], 'PING');
      $pos_t3 = strpos($server['READ_BUFFER'], 'ChanServ');
      if ($pos_t1 === false && $pos_t2 === false){
        if(isset($speakers[$name])){
            $speakers[$name] = $speakers[$name] + 1;
        }else{
            $speakers[$name] = 0;
            SendCommand("PRIVMSG #mdpp :Welcome $name, could you tell your name and county to the group for the current meeting that is in progress.\n\r");  
            sleep(1);
            error_log("<div style='border:1px solid black; padding:5px;'>Maryland Pirate Party Welcomes You $name, could you tell your name and county to the group for the current meeting that is in progress.</div>", 3, $meeting_log); 
        }
        error_log("<div style='border:1px solid black; padding:5px;'>".date('r')." <b>$name:</b> $message </div>", 3, $meeting_log); 
      }
      if ($pos_t3 !== false){
        error_log("<div style='border:1px solid black; padding:5px; background-color:orange;'>Pirates in Attendance ".$server['READ_BUFFER']." </div>", 3, $meeting_log); 
      }
  }
  error_log(date('r')." [meeting active] [$i] ".$server['READ_BUFFER'], 3, $debug_log);
}else{
  error_log(date('r')." [receive] [$i] ".$server['READ_BUFFER'], 3, $debug_log);
}

if ($slack_url != ''){  
  // PUSH COMM TO SLACK
  $pos = strpos($server['READ_BUFFER'], 'PING');
  if($pos === false){
    $slack = $server['READ_BUFFER'];
    $command = "curl -X POST -H 'Content-type: application/json' --data '{\"text\":\"$slack\"}' $slack_url";
    exec($command);
  }
}

if(file_exists($lockfile_agenda) && $i > 100){
  $parts = explode("!",$server['READ_BUFFER']);
  $name = $parts[0];
  $parts = explode(":",$server['READ_BUFFER']); 
  $message = $parts[2];
  if (trim($message) != '') {  
      // ignore system messages in meeting log
      $pos_t1 = strpos($server['READ_BUFFER'], 'MDPPbot');
      $pos_t2 = strpos($server['READ_BUFFER'], 'PING');
      $pos_t3 = strpos($server['READ_BUFFER'], 'ChanServ');
      if ($pos_t1 === false && $pos_t2 === false){
        if(isset($speakers[$name])){
            $speakers[$name] = $speakers[$name] + 1;
        }else{
            $speakers[$name] = 0;
            //SendCommand("PRIVMSG #mdpp :Welcome $name, could you tell your name and county to the group for the current meeting that is in progress.\n\r");  
            //sleep(1);
            //error_log("<div style='border:1px solid black; padding:5px;'>Maryland Pirate Party Welcomes You $name, could you tell your name and county to the group for the current meeting that is in progress.</div>", 3, $agenda_log); 
        }
        error_log("<div style='border:1px solid black; padding:5px;'>".date('r')." <b>$name:</b> $message </div>", 3, $agenda_log); 
      }
      if ($pos_t3 !== false){
        error_log("<div style='border:1px solid black; padding:5px; background-color:orange;'>Pirates in Attendance ".$server['READ_BUFFER']." </div>", 3, $agenda_log); 
      }
  }
  error_log(date('r')." [meeting active] [$i] ".$server['READ_BUFFER'], 3, $debug_log);
}




?>

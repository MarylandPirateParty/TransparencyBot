<?PHP
//
//// start command
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'help');
if ($pos !== false){  
  SendCommand("PRIVMSG #mdpp :I have made the following public commands available \n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."help - You just ran that command \n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."start meeting - Turn On Meeting System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."end meeting - Turn Off Meeting System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."start agenda - Turn On Agenda System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."end agenda - Turn Off Agenda System\n\r");
}



//
//// start command
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'start meeting');
if ($pos !== false){  
  SendCommand("PRIVMSG #mdpp :Meeting log has started \n\r");  
  SendCommand("NAMES #mdpp\n\r");
  touch($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:lightgreen;'>".date('r')." Meeting Has Started</div>", 3, $meeting_log);
  $refresh = '<meta http-equiv="refresh" content="5">';
  error_log($refresh, 3, $meeting_log);
}


//
//// end meeting
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'end meeting');
if ($pos !== false){ 
  SendCommand("PRIVMSG #mdpp :Meeting log has ended \n\r");  
  unlink($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:lightblue;'>".date('r')." Meeting Complete </div>", 3, $meeting_log);
  foreach($speakers as $name => $count ){
    SendCommand("PRIVMSG #mdpp :Thank you $name for contributing $count messages to the meeting. \n\r");  
    error_log("<div style='border:1px solid black; padding:5px; background-color:lightblue;'>Thank you $name for contributing $count messages to the meeting.</div>", 3, $meeting_log);          
  }
}

//
//// start agenda
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'start agenda');
if ($pos !== false){  
  SendCommand("PRIVMSG #mdpp :Agenda log is on \n\r");  
  SendCommand("NAMES #mdpp\n\r");
  touch($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>".date('r')." Agenda Has Started</div>", 3, $meeting_log);
  $refresh = '<meta http-equiv="refresh" content="5">';
  error_log($refresh, 3, $meeting_log);
}


//
//// end agenda
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'end agenda');
if ($pos !== false){ 
  SendCommand("PRIVMSG #mdpp :Agenda log is off \n\r");  
  unlink($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>".date('r')." Agenda Complete </div>", 3, $meeting_log);
  foreach($speakers as $name => $count ){
    SendCommand("PRIVMSG #mdpp :Thank you $name for contributing $count messages to the meeting. \n\r");  
    error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>Thank you $name for contributing $count messages to the meeting.</div>", 3, $meeting_log);          
  }
}


?>

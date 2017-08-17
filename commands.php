<?PHP

//
//// start command
//
$pos = strpos($server['READ_BUFFER'], 'start meeting');
if ($pos !== false){  
  SendCommand("PRIVMSG #mdpp :Meeting log has started \n\r");  
  SendCommand("NAMES #mdpp\n\r");
  touch($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:lightgreen;'>".date('r')." Meeting Has Started</div>", 3, $meeting_log);
  $refresh = '<meta http-equiv="refresh" content="5">';
  error_log($refresh, 3, $meeting_log);
}


//
//// end command
//
$pos = strpos($server['READ_BUFFER'], 'end meeting');
if ($pos !== false){ 
  SendCommand("PRIVMSG #mdpp :Meeting log has ended \n\r");  
  unlink($lockfile);
  error_log("<div style='border:1px solid black; padding:5px; background-color:lightblue;'>".date('r')." Meeting Complete </div>", 3, $meeting_log);
  foreach($speakers as $name => $count ){
    SendCommand("PRIVMSG #mdpp :Thank you $name for contributing $count messages to the meeting. \n\r");  
    error_log("<div style='border:1px solid black; padding:5px; background-color:lightblue;'>Thank you $name for contributing $count messages to the meeting.</div>", 3, $meeting_log);          
  }
}

?>

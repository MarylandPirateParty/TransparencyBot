<?PHP
  
// user commands
  
//
//// help 
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'help');
if ($pos !== false){  
  SendCommand("PRIVMSG #mdpp :I have made the following public commands available \n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."help - You just ran that command \n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."start meeting - Turn On Meeting System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."end meeting - Turn Off Meeting System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."start agenda - Turn On Agenda System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."end agenda - Turn Off Agenda System\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."history - Work in Progress\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."post - Work in Progress\n\r");
  SendCommand("PRIVMSG #mdpp :".$command_prefix."email - work in Progress\n\r");
}



//
//// start meeting
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
  touch($lockfile_agenda);
  error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>".date('r')." Agenda Has Started</div>", 3, $agenda_log);
  $refresh = '<meta http-equiv="refresh" content="5">';
  error_log($refresh, 3, $agenda_log);
}


//
//// end agenda
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'end agenda');
if ($pos !== false){ 
  SendCommand("PRIVMSG #mdpp :Agenda log is off \n\r");  
  unlink($lockfile_agenda);
  error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>".date('r')." Agenda Complete </div>", 3, $agenda_log);
  foreach($speakers as $name => $count ){
    SendCommand("PRIVMSG #mdpp :Thank you $name for contributing $count messages to the meeting. \n\r");  
    error_log("<div style='border:1px solid black; padding:5px; background-color:pink;'>Thank you $name for contributing $count messages to the meeting.</div>", 3, $agenda_log);          
  }
}



//
//// today's history
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'history');
if ($pos !== false){ 
  // we need to know who to send the history to...
  SendCommand("PRIVMSG BaltimoreHacker :History Requested \n\r");  
}

//
//// post the meeting to wordpress blog?
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'post');
if ($pos !== false){ 
  // we need to know who to send the history to...
  SendCommand("PRIVMSG BaltimoreHacker :Post Requested \n\r");  
}

//
//// send meeting via email
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'email');
if ($pos !== false){ 
  $to = 'baltimorehacker@gmail.com';
  // we need to know who to send the history to...
  // To send HTML mail, the Content-type header must be set
  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';
  // Additional headers
  $headers[] = 'From: MDPPbot <MDPPbot@mdpirateparty.org>';
  $headers[] = 'Cc: captain@mdpirateparty.org';
  //$headers[] = 'Bcc: birthdaycheck@example.com';
  // Mail it
  mail($to, "IRC Meeting Notes", $server['READ_BUFFER'], implode("\r\n", $headers));
}



// system commands

//
//// Welcome on join
//
$pos = strpos($server['READ_BUFFER'], 'JOIN #mdpp');
if ($pos !== false){ 
   SendCommand("PRIVMSG BaltimoreHacker :User has (re)joined MDPP \n\r");    
}



//
//// DISABLE BOT ON ERROR
//
$pos = strpos($server['READ_BUFFER'], 'ERROR');
if ($pos !== false){ 
   error_log("***ERROR DETECTED \n", 3, $debug_log);          
   touch($lockfile_dead);
}


if ($i > 100){
  // post messages from slack users
  if (file_exists($slack_buffer)){
    foreach(file($slack_buffer) as $line) {
      // process the line read.
    //  SendCommand("PRIVMSG #mdpp :Slack User says $line \n\r");
    }
    unlink($slack_buffer);
  }
}


//
//// post the meeting to wordpress blog?
//
$pos = strpos($server['READ_BUFFER'], $command_prefix.'restart');
if ($pos !== false){ 
  // we need to know who to send the history to...
  SendCommand("PRIVMSG BaltimoreHacker :Bot Restarting \n\r");  
  exec('killall php');
}

?>

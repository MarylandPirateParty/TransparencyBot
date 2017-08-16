<?php
//Also inclue our config file 
include("config.php"); 
exec("ps -A | grep -i php | grep -v grep", $pids);
$instances = count($pids);
if ($instances == 2) {
    error_log(date('r')." Bot System is Healthy : $instances \n", 3 , $debug_log);
    exit(0);
}
error_log(date('r')." Bot is Missing - DOING CPR \n", 3 , $debug_log);
$i=0;
//now that we are good to begin set the timeout limit to 0 so the page wont time out. 
set_time_limit(0); 
//Second lets grab our data from our form. 
$nickname = strtoupper($shortname)."bot".rand(1,999); 
//Now lets check to see if there is a nickname set. 
//Ok, We have a nickname, now lets connect. 
$server = array(); //we will use an array to store all the server data. 
//Open the socket connection to the IRC server 
$server['SOCKET'] = @fsockopen($server_host, $server_port, $errno, $errstr, 2); 
if($server['SOCKET']){
  //Ok, we have connected to the server, now we have to send the login commands. 
  SendCommand("PASS NOPASS\n\r"); //Sends the password not needed for most servers 
  SendCommand("NICK $nickname\n\r"); //sends the nickname 
  SendCommand("USER $nickname USING PHP IRC\n\r"); //sends the user must have 4 paramters 
  //while we are connected to the server 
  while(!feof($server['SOCKET'])){ 
    $server['READ_BUFFER'] = fgets($server['SOCKET'], 1024); //get a line of data from the server 
    //echo "[RECIVE] ".$server['READ_BUFFER']."<br>\n\r"; //display the recived data from the server 
    // try to exclude first 100 lines of a reconnect
    if(file_exists($lockfile) && $i > 100){
      $parts = explode("!",$server['READ_BUFFER']);
      $name = $parts[0];
      $parts = explode(":",$server['READ_BUFFER']); 
      $message = $parts[2];
      if (trim($message) != '') {  
          // ignore system messages in meeting log
          $pos_t1 = strpos($server['READ_BUFFER'], 'MDPPbot');
          $pos_t2 = strpos($server['READ_BUFFER'], 'PING');
          $pos_t3 = strpos($server['READ_BUFFER'], '#mdpp');
          if ($pos_t1 === false && $pos_t2 === false){
            error_log("<div style='border:1px solid black; padding:5px;'>".date('r')." <b>$name:</b> $message </div>", 3, $meeting_log); 
          }
          if ($pos_t3 !== false){
            error_log("<div style='border:1px solid black; padding:5px; background-color:orange;'>".date('r')." ".$server['READ_BUFFER']." </div>", 3, $meeting_log); 
          }
      }
      error_log(date('r')." [meeting active] [$i] ".$server['READ_BUFFER'], 3, $debug_log);
    }else{
      error_log(date('r')." [receive] [$i] ".$server['READ_BUFFER'], 3, $debug_log);
    }
    /* 
    IRC Sends a "PING" command to the client which must be anwsered with a "PONG" 
    Or the client gets Disconnected 
    */ 
    //Now lets check to see if we have joined the server 
    $i++;
    // line 90 is about mid MOTD - we have found it is good to send the commands at this point
    if($i == 90){ 
      SendCommand("JOIN #mdpp\n\r"); //Join the chanel 
    }
    //
    //// start command
    //
    $pos = strpos($server['READ_BUFFER'], 'start meeting');
    if ($pos !== false){  
      SendCommand("PRIVMSG #mdpp :Meeting log has started");  
      //SendCommand("NAMES #mdpp");
      touch($lockfile);
      error_log("<div style='border:1px solid black; padding:5px; background-color:lightgreen;'>".date('r')." Meeting Has Started</div>", 3, $meeting_log);
      $refresh = '<meta http-equiv="refresh" content="5">';
      error_log($refresh, 3, $meeting_log);
    }
    //
    //// names command
    //
    $pos = strpos($server['READ_BUFFER'], 'roll call');
    if ($pos !== false){  
      //SendCommand("PRIVMSG #mdpp :Meeting log has started");  
      SendCommand("NAMES #mdpp");
      //touch($lockfile);
      //error_log("<div style='border:1px solid black; padding:5px; background-color:lightgreen;'>".date('r')." Meeting Has Started</div>", 3, $meeting_log);
      //$refresh = '<meta http-equiv="refresh" content="5">';
      //error_log($refresh, 3, $meeting_log);
    }
    //
    //// end command
    //
    $pos = strpos($server['READ_BUFFER'], 'end meeting');
    if ($pos !== false){ 
      SendCommand("PRIVMSG #mdpp :Meeting log has ended");  
      unlink($lockfile);
      error_log("<div style='border:1px solid black; padding:5px; background-color:lightblue;'>".date('r')." Meeting Complete </div>", 3, $meeting_log);
    }
    //If the server has sent the ping command 
    if(substr($server['READ_BUFFER'], 0, 6) == "PING :"){ 
      SendCommand("PONG :".substr($server['READ_BUFFER'], 6)."\n\r"); //Reply with pong                                                                                                                                                                                                                                                                                                                      //As you can see i dont have it reply with just "PONG" 
      //It sends PONG and the data recived after the "PING" text on that recived line 
      //Reason being is some irc servers have a "No Spoof" feature that sends a key after the PING 
      //Command that must be replied with PONG and the same key sent. 
    } 
    flush(); //This flushes the output buffer forcing the text in the while loop to be displayed "On demand" 
  } 
} // end if socket exists

function SendCommand ($cmd){ 
  global $debug_log;
  global $server; //Extends our $server array to this function 
  @fwrite($server['SOCKET'], $cmd, strlen($cmd)); //sends the command to the server 
  //echo "[SEND] $cmd <br>"; // displays it to the screen 
  error_log(date('r')." [send] ".$cmd, 3 , $debug_log);
} 

?>

<?php
//Also inclue our config file 
include("config.php"); 
if (file_exists($lockfile_dead)){
    error_log(date('r')." Bot System is offline ($lockfile_dead) \n", 3 , $debug_log);
    die();   
}
exec("ps -A | grep -i php | grep -v grep", $pids);
$instances = count($pids);
if ($instances > 2) {
    error_log(date('r')." Bot System is **NOT** Healthy : $instances \n", 3 , $debug_log);
    exit(0);
}
if ($instances == 2) {
    error_log(date('r')." Bot System is Healthy : $instances \n", 3 , $debug_log);
    exit(0);
}
if ($instances == 1) {
    error_log(date('r')." Bot System is responds with 1 not 2 : $instances \n", 3 , $debug_log);
}
error_log(date('r')." Bot is Missing - Launching NEW Bot \n", 3 , $debug_log);
// $i is our command counter
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
    include('log.php');
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
    include('commands.php');
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

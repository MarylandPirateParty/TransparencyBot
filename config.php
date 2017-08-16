<?php 
date_default_timezone_set("Asia/America/New_York");
// Shortname
$shortname = "mdpp";
//The server host is the IP or DNS of the IRC server. 
$server_host = "irc.pirateirc.net"; 
//Server Port, this is the port that the irc server is running on. Deafult: 6667 
$server_port = 6667; 
//Server Chanel, After connecting to the IRC server this is the channel it will join. 
$server_chan = "#$short"; 
// log file to monitor bot performance
$debug_log = "debug.log"; 
if ($debug_log != ''){
  touch($debug_log);
}
?>

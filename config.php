<?php 
//$bot_local_user = exec('whoami');
date_default_timezone_set("America/New_York");
// IRC command prefix
$command_prefix = "+";
// Shortname
$shortname = "mdpp";
$fullname = "Maryland Pirate Party";
//The server host is the IP or DNS of the IRC server. 
$server_host = "irc.pirateirc.net"; 
//Server Port, this is the port that the irc server is running on. Deafult: 6667 
$server_port = 6667; 
//Server Chanel, After connecting to the IRC server this is the channel it will join. 
$server_chan = "#$shortname"; 
$meeting_log = "/var/www/html/TransparencyBot/".$shortname.'_meeting_'.date('Y-m-d').'.html';
$agenda_log = "/var/www/html/TransparencyBot/".$shortname.'_agenda_'.date('Y-m-d').'.html';
// log file to monitor bot performance
global $debug_log;
$debug_log = "/var/www/html/TransparencyBot/debug.log"; 
$lockfile = "/var/www/html/TransparencyBot/meeting_active.info";
$lockfile_agenda = "/var/www/html/TransparencyBot/agenda_active.info";
$lockfile_dead = "/var/www/html/TransparencyBot/bot_dead.info";
$logo = "/wp-content/uploads/2017/07/MarylandPiratePartySmall.png";
// who talks
global $speakers;
$speakers=array();


// SLACK APPLICATION
$slack_url = "https://hooks.slack.com/services/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";
$slack_log = "/var/www/html/TransparencyBot/slack.log";
$slack_buffer = "/var/www/html/TransparencyBot/slack.buffer"; 
?>

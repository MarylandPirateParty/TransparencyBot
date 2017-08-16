<title>#mdpp Weekly Meetings</title>
<div>Weekly Meeting Archive</div>
<div>Click to open any meeting in a new tab</div>
<?PHP
$all = scandir('.');
foreach ($all as $file) {
 $pos = strpos($file,'html');
 if ($pos !== false){
  echo "<li><a target='_Blank' href='$file'>$file</a></li>";
 }
}
?>

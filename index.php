<?PHP include("config.php"); ?>
<title><?PHP echo $server_chan;?> Weekly Meeting Vault</title>
<h1><?PHP echo $server_chan;?> Weekly Meeting Vault</h1>
<img src="<?PHP echo $logo;?>">
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

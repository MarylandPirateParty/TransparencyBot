<?PHP
$all = scandir('.');
foreach ($all as $file) {
 $pos = strpos($file,'html');
 if ($pos !== FALSE){
  echo "<li><a href='$file'>$file</a></li>";
 }
}
?>

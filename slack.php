<?PHP
include("config.php");
error_log(date('r')." [slack receive] [begin] \n", 3, $slack_log); 
// use a buffer file fo imcomming post messages from slack
ob_start();
print_r($_POST);
$buffer = ob_get_clean();
error_log(date('r')." [slack receive] [".$buffer."] \n", 3, $slack_log);
//foreach ($_POST as $key) {
    //echo "Key: $key<br />\n";
//    error_log(date('r')." [slack receive] [$key] \n", 3, $slack_log); 
//}
?>

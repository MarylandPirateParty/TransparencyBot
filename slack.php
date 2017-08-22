<?PHP
include("config.php");
$response=array();
$response['challenge']='test';
error_log(date('r')." [slack receive] [begin] [".$_SERVER['REQUEST_METHOD']."] \n", 3, $slack_log); 
// use a buffer file fo imcomming post messages from slack
$buffer = json_decode($_POST, true);
error_log(date('r')." [slack receive] [".$buffer."] \n", 3, $slack_log);
//foreach ($_POST as $key) {
    //echo "Key: $key<br />\n";
//    error_log(date('r')." [slack receive] [$key] \n", 3, $slack_log); 
//}
echo json_encode($response); 
?>

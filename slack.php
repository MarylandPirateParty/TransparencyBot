<?PHP
include("config.php");
$response=array();
$response['challenge']='test';
error_log(date('r')." [slack receive] [begin] [".$_SERVER['REQUEST_METHOD']."] \n", 3, $slack_log); 
// use a buffer file fo imcomming post messages from slack
$data = json_decode(file_get_contents('php://input'), true);
ob_start();
print_r($data);
$buffer = ob_get_clean();
error_log(date('r')." [slack receive] [".$buffer."] \n", 3, $slack_log);
//foreach ($_POST as $key) {
    //echo "Key: $key<br />\n";
//    error_log(date('r')." [slack receive] [$key] \n", 3, $slack_log); 
//}
echo json_encode($response); 
?>

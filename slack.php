<?PHP
include("config.php");
// use a buffer file fo imcomming post messages from slack
$type = $_POST['body']['type'];
$token = $_POST['body']['token'];
$challenge = $_POST['body']['challenge'];
//echo $challenge;
error_log(date('r')." [slack receive] [$type] [$token] [$challenge] \n", 3, $slack_log);
echo "test";
?>

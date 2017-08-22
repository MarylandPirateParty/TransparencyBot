<?PHP
include("config.php");
error_log(date('r')." [slack receive] [begin] \n", 3, $slack_log); 
error_log(date('r')." [slack receive] [".$_POST."] \n", 3, $slack_log);
error_log(date('r')." [slack receive] [".$_POST['body']."] \n", 3, $slack_log);
// use a buffer file fo imcomming post messages from slack
foreach ($_POST['body'] as $key => $value) {
    echo "Key: $key; Value: $value<br />\n";
    error_log(date('r')." [slack receive] [$key] [$value] \n", 3, $slack_log); 
}
die();
$type = $_POST['body']['type'];
$token = $_POST['body']['token'];
$challenge = $_POST['body']['challenge'];
//echo $challenge;
error_log(date('r')." [slack receive] [$type] [$token] [$challenge] \n", 3, $slack_log);
echo $challenge;
?>

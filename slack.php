<?PHP
// use a buffer file fo imcomming post messages from slack
$type = $_POST['body']['type'];
$token = $_POST['body']['token'];
$challenge = $_POST['body']['challenge'];
echo $challenge;
?>

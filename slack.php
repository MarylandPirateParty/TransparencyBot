<?PHP
include("config.php");
$data = json_decode(file_get_contents('php://input'), true);
$response=array();
$response['challenge']=$data['challenge'];
echo json_encode($response); 
ob_start();
print_r($data);
$buffer = ob_get_clean();
error_log(date('r').": $buffer \n", 3 , $slack_log);
// write mesasage to buffer
if ($data['event']['bot_id'] == ''){
  $fh = fopen($slack_buffer, 'a') or die("can't open file");
  $stringData = $data['event']['text']."\n";
  fwrite($fh, $stringData);
  fclose($fh);
}
?>

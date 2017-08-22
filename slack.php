<?PHP
include("config.php");
$data = json_decode(file_get_contents('php://input'), true);
$response=array();
$response['challenge']=$data['challenge'];
echo json_encode($response); 
?>

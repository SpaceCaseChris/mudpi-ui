<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();
handle_csrf();

// $json_str = file_get_contents('php://input');
// $json_obj = json_decode($json_str, true);

if (!isset($_POST["message"]) || empty($_POST["message"])) {
	response_error('Message was not set or invalid.');
	// $_POST["source"] = "unknown";
}

if (!isset($_POST["duration"]) || empty($_POST["duration"]) || !is_numeric($_POST["duration"])) {
	response_error('Duration was not set or invalid.');
}

if (!isset($_POST["topic"]) || empty($_POST["topic"]) ) {
	response_error('Topic was not set or invalid.');
}

$data = array(
	"event" => "Message", //Clear, ClearQueue, Message
	"data" => [
		"time" => date("Y-m-d H:i:s"),
		"message" => $_POST["message"],
		"duration" => $_POST["duration"],
	],
	"topic" => $_POST["topic"]
);

//Connecting to Redis server on localhost 
$redis = new \Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

if($redis->publish($data["topic"], json_encode($data))) {
	echo json_encode(['status' => 'OK', 
		'message' => 'Successfully Sent Message to Queue'
		'data' => $data]);
}
else {
	response_error('Problem Sending Message to Queue');
}

?>


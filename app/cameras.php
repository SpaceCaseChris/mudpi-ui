<?php
// a page to test custom content in ui
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

//Connecting to Redis server on localhost 
$redis = new Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

$started_at = strtotime($redis->get("started_at"));

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/".MUDPI_CONFIG_FILE));

$cameras = $config->camera;
foreach($cameras as $camera) {
	if(empty($camera->name)) {
		$camera->name = ucwords(str_replace("_", " ", $camera->key));
	}
	if(empty($camera->topic)) {
		$camera->topic = "camera/".$camera->key;
	}
	try {
		$state = $redis->get($camera->key.'.state');

		if (!empty($state)) {
			$camera->state = json_decode($state);
			$camera->binary = base64_encode(file_get_contents($camera->state->state));
		}
		else {
			throw new Exception('No State Found');
		}
	} catch (Exception $e) {
		$camera->state = (object)['component_id' => $camera->key,
								'state' => '',
								'updated_at' => '',
								'metadata' => ''];
	}
}

include 'templates/cameras.php';
?>
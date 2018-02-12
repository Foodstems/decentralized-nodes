<?php

function get_db() {
	global $config;

	init_db();

	return json_decode(file_get_contents($config['data']), true);
}

function init_db() {
	global $config;
	if (!is_dir(dirname($config['data']))) {
		mkdir(dirname($config['data']), 0777, true);
	}

	if(!is_file($config['data'])) {
		$genesis_block = [['previous_hash'=>'0', "name"=>"First product", "hash"=>"kvdISoqbRO1CQkKLoCjg/pL3SEqKm0TtQkJCi6Ao4P4="]];
		file_put_contents($config['data'], json_encode($genesis_block));
	}
}

function save_db($contents) {
	global $config;

	init_db();

	file_put_contents($config['data'], json_encode($contents));
}

function add_record($product, $do_not_calculate_hash=false) {
	$db = get_db();
	if(!$do_not_calculate_hash)
		$product['hash'] = make_hash($product);
	$db[]=$product;
	save_db($db);
}

function make_hash($product) {
	
	$md5 = md5(json_encode($product));

	$pack = pack('H*', $md5.$md5);
	$base = base64_encode($pack);
	return $base;
}

function make_stellar_hash($product) {

	$md5 = md5(json_encode($product));

	return $md5.$md5;
}

function get_last_block() {
	$db = get_db();

	return array_pop($db);
}

function find_by_hash($hash) {

	$db = get_db();

	$data = $db;
	$hash = stripslashes($hash);

	$key = array_search($hash, array_column($data, 'hash'));

	return $key ? $data[$key] : false;
}

function verify_block($block) {
	$hash = $block['hash'];

	unset($block['hash']);

	return make_hash($block)===$hash;
}

function broadcast_block($block) {
	global $config;
	$info = '';

	$client = new GuzzleHttp\Client();

	foreach($config['other_nodes'] as $node) {
		try {
			$response= $client->request('POST', $node, 
			[
				'body'=>json_encode($block),
				'timeout'=>$config['guzzle_timeout']
			]);
			//echo $response->getStatusCode().'<br>';
			$info.='Successfully broadcasted block to node '.$node.'. Response: '.$response->getBody();
		} catch(\Exception $e) {
			$info.='Error broadcasting block to node '.$node.': '.$e->getMessage();
		}
		$info.="\n";

	}
	return $info;
}
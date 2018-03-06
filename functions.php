<?php

/*
* Return the blockchain as an array
*/
function get_db() {
	global $config;

	init_db();

	return json_decode(file_get_contents($config['data']), true);
}

/*
* Create the path provided in the config.
* Create the first hash and put it in the file.
*/
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

/*
* Save previously read database
*/
function save_db($contents) {
	global $config;

	init_db();

	file_put_contents($config['data'], json_encode($contents));
}

/*
* Add a new block.
* Do not calculate hash - applies to blocks that have their hash already calculated
*/
function add_record($product, $do_not_calculate_hash=false) {
	$db = get_db();
	if(!$do_not_calculate_hash)
		$product['hash'] = make_hash($product);
	$db[]=$product;
	save_db($db);
}

/*
* Create a hash, matches the Stellar algorithm
*/
function make_hash($product) {
	
	$md5 = md5(json_encode($product));

	$pack = pack('H*', $md5.$md5);
	$base = base64_encode($pack);
	return $base;
}

/*
* Stellar asks 64 characters, so we send the md5 of the hash twice
*/
function make_stellar_hash($product) {

	$md5 = md5(json_encode($product));

	return $md5.$md5;
}

/*
* Return the last block of the blockchain
*/
function get_last_block() {
	$db = get_db();

	return array_pop($db);
}

/*
* Find block by hash (linear time of execution)
*/
function find_by_hash($hash) {

	$db = get_db();

	$data = $db;

	foreach($data as $d) {
		if($d['hash']==$hash)
			return $d;
	}
	
	return false;
}

/*
* Verify block
*/
function verify_block($block) {
	$hash = $block['hash'];

	unset($block['hash']);
	unset($block["stellar_transaction_hash"]);

	return make_hash($block)===$hash;
}

/*
* Update block
*/
function update_block($hash, $stellar_transaction_hash) {

	$db = get_db();

	$block = find_by_hash($hash);
	array_pop($db);

	$_block 					= [];
	$_block["name"] 			= $block["name"];
	$_block["previous_hash"] 	= $block["previous_hash"];
	$_block["hash"] 			= $block["hash"];
	$_block["stellar_transaction_hash"] = $stellar_transaction_hash;

	$db[]=$_block;
	save_db($db);
}

/*
* Get latest transactions
*/
function get_latest_transactions($number=10) {

	$db 	= get_db();

	$data = array_reverse($db);

	return array_slice($data, 0 , $number);
}

/*
* Broadcast block to other nodes listed in the config file
*/
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

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

function add_record($product) {
	$db = get_db();
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

function get_last_block() {
	$db = get_db();

	return array_pop($db);
}
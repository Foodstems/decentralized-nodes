<?php

$data_file = './data/data';

function get_db() {
	return json_decode(file_get_contents($data_file));
}

function save_db($contents) {
	file_put_contents("./data/data.txt", json_encode($contents));
}

function add_record($product) {
	$db = get_db();
	$db[]=$product;
	save_db($db);
}

function get_config() {
	return json_decode(file_get_contents('./config.json'));
}
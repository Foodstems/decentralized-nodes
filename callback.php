<?php
include 'bootstrap.php';

$data = json_decode(file_get_contents('php://input'), true);

$last = get_last_block();

if(!verify_block($data)) {
	echo 'Block not valid.';
	exit;
}

if(find_by_hash($data['hash'])) {
	echo 'Block already exists.';
	exit;
}

if($last['hash']!==$data['previous_hash']) {
	echo 'Block previous_hash not valid.';
	exit;
}

add_record($data, true);
echo 'Block added.';
// @todo check hashes and insert data in db if correct
// @todo broadcast the block to other nodes if correct, with guzzle send post to all the nodes in config, on /callback.php


<?php
include 'bootstrap.php';

$data = json_decode(file_get_contents('php://input'), true);

$last = get_last_block();

if(verify_block($data) && $last['hash']===$data['previous_hash']) {
	add_record($data);
	echo 'Block added';
} else {
	echo 'Block refused';
}

// @todo check hashes and insert data in db if correct
// @todo broadcast the block to other nodes if correct, with guzzle send post to all the nodes in config, on /callback.php


<?php
include 'bootstrap.php';

/*
* When other nodes broadcast blocks, they end up here
*/

// Receive the data
$data = json_decode(file_get_contents('php://input'), true);

$stellar_transaction_hash = $data["stellar_transaction_hash"];
$last = get_last_block();

// Verify the new block
if(!verify_block($data)) {
	echo 'Block not valid.';
	exit;
}

// Check if the blocks exists
if(find_by_hash($data['hash'])) {
	echo 'Block already exists.';
	exit;
}

// Check the previous hash
if($last['hash']!==$data['previous_hash']) {
	echo 'Block previous_hash not valid.';
	exit;
}
$data["stellar_transaction_hash"] = $stellar_transaction_hash;

// If everything is ok, add the block
add_record($data, true);
echo 'Block added.';

// @todo broadcast the block to other nodes if correct

<?php 
include 'bootstrap.php';

/*
* This is called only once for each block when created
*/
$post = $_POST;

// Make the hash of the new block
$md5 = $post["product_hash"];
$pack = pack('H*', $md5);
$base = base64_encode($pack);

// Update the block with the stellar transaction
update_block($base, $post["stellar_transaction_hash"]);


$latest = get_last_block();
$latest["stellar_transaction_hash"] = $post["stellar_transaction_hash"];

// Broadcast block to other nodes
$broadcast_info = broadcast_block($latest);

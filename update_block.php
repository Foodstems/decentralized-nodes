<?php 
include 'bootstrap.php';
$post = $_POST;

$md5 = $post["product_hash"];
$pack = pack('H*', $md5);
$base = base64_encode($pack);


update_block($base, $post["stellar_transaction_hash"]);


$latest = get_last_block();
$broadcast_info = broadcast_block($latest);

?>
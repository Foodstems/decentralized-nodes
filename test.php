<?php
include 'bootstrap.php';

$block = ['name'=>'First product', 'previous_hash'=>'0'];
$block['hash'] = make_hash($block);

broadcast_block($block);
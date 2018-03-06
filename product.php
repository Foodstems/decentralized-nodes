<?php 

include 'functions.php';

/*
* Called when creating a new block
*/

$post = $_POST;

unset($post['submit']);

// Create a stellar hash which will be added in the stellar transaction
print json_encode(["hash" => make_stellar_hash($post)]);

?>
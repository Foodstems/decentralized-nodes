<?php 

include 'functions.php';

$post = $_POST;

unset($post['submit']);


print json_encode(["hash" => make_stellar_hash($post)]);

?>
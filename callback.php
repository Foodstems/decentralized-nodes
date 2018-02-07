<?php
include 'bootstrap.php';

$data = json_decode(file_get_contents('php://input'), true);
print_r($data);
// @todo check hashes and insert data in db if correct
// @todo broadcast the block to other nodes if correct, with guzzle send post to all the nodes in config, on /callback.php


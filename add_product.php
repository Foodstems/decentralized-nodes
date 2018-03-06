<?php 

include 'bootstrap.php';

$data = $_POST;

$last_block = get_last_block();

// Check if the new block's previous hash links to the last block in our blockchain
if($data['previous_hash']!=$last_block['hash']) {
    echo json_encode(["error" => "Hashes do not match. Transaction will not be created!"]);
    exit;
} else {
    // If everything is ok, add the block to the blockchain
    add_record($data);
    $latest = get_last_block();
    
    echo json_encode(["latest"=>$latest]);
    exit;
}


?>

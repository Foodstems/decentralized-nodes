<?php 

include 'bootstrap.php';


$data = $_POST;

$last_block = get_last_block();

if($data['previous_hash']!=$last_block['hash']) {
    echo 'Hashes doesn\'t match';
} else {
    
    add_record($data);
    $latest = get_last_block();
    echo json_encode(["latest"=>$latest]);
}


?>
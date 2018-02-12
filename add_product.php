<?php 

include 'bootstrap.php';


$data = $_POST;

$last_block = get_last_block();

if($data['previous_hash']!=$last_block['hash']) {
    echo json_encode(["error" => "Hashes does not match. Transaction will not be created!"]);
    exit;
} else {
    
    add_record($data);
    $latest = get_last_block();
    //$broadcast_info = broadcast_block($latest);
    echo json_encode(["latest"=>$latest]);
    exit;
}


?>
<?php

include 'bootstrap.php';

//@todo add new product to db, and broadcast that block to other nodes for validation
//print some feedback if the block was accepted by other nodes
    $record_added = false;
    /*
    if (isset($_POST['name'])) {

        $data = $_POST;
        unset($data['submit']);

        $last_block = get_last_block();

        if($data['previous_hash']!=$last_block['hash']) {
            echo 'Hashes doesn\'t match';
        } else {
            echo 'Record added';
            add_record($data);
            $latest = get_last_block();
            print "\nInfo\n";
            print_r($latest);
        }
    }
    */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/stellar-sdk/stellar-sdk.min.js"></script>
    <script src="/bower_components/buffer/buffer.min.js"></script>
    <script src="/js/scripts.js"></script>
    <title>Document</title>
</head>
<body>

  
        <input type="input" name="name" id="name" placeholder="Name"/>
        <input type="input" name="previous_hash" id="previous_hash" placeholder="Previous hash"/>

        <button id="add">Add</button>

    
        
       <div class="transaction-error" style="display:none">
            <p id="error-message"></p>
       </div>

        <div class="transaction-info" style="display:none">
            <h2>Record was added</h2>
            <p>Product hash:</a>
            <p id="product_hash_response"></p>

            <p>Stellar transaction info<p>
            <a target="_blank" id="stellar_link_response" href="">info</a>


            <p> <a href="index.php" >Add new</a></P>
        </div>

</body>

<script>

    
	var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
    StellarSdk.Network.useTestNetwork();

</script>
</html> 

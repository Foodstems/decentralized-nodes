<?php

include 'bootstrap.php';

    $record_added = false;
    // Get latest transactions and list below
    $latest_transactions = get_latest_transactions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/stellar-sdk/stellar-sdk.min.js"></script>
    <script src="/bower_components/buffer/buffer.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="/config.js"></script>
    <title>Block Explorer</title>
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
            <input type="hidden" id="stellar_transaction_hash" />
            <p> <a href="index.php" >Add new</a></P>
        </div>


    
    <?php if(count($latest_transactions)) { ?>
        <h2>Last transactions</h2>
        <table class="table">
        <tr>
            <td>Data</td>
            <td>Memo hash</td>
            <td>Transaction hash</td>
        </td>

        <?php foreach($latest_transactions as $transaction) {?>
            <tr>
                <td><?php echo isset($transaction["name"]) ? $transaction["name"] : "" ?></td>
                <td>
                    <?php echo (isset($transaction["hash"])) ? "<a target='_blank' href='/explorer.php?hash=".urlencode($transaction['hash'])."'>".$transaction['hash']."</a>" : "" ?>
                </td>
                <td>
                    <?php echo (isset($transaction["stellar_transaction_hash"])) ? "<a target='_blank' href='https://horizon-testnet.stellar.org/transactions/".$transaction['stellar_transaction_hash']."'>".$transaction['stellar_transaction_hash']."</a>" : "" ?>
                </td>
            </tr>
        <?php } ?>
       
        </table>
    <?php } ?>

</body>

<script>

    
	var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
    StellarSdk.Network.useTestNetwork();

</script>
</html> 

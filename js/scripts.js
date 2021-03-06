$(function(){

    $("#add").click(function(e){
       
        e.preventDefault();
   
        var product_hash = "";
        var _data = {};
        _data.name = $("#name").val();
        _data.previous_hash = $("#previous_hash").val();
      
        // get product hash
        $.ajax({
            type: "post",
            url: "/product.php",
            data: _data,
            success: function(response){
            
               var data = JSON.parse(response);
              
               product_hash = data.hash;
   
               add_product(product_hash);
              
            }, 
            error: function(err){

            }
        })
        // make stellar transaction

        // save response in db

        return false;

    })
})

function add_product(product_hash) {


    var _data = {};
    _data.name = $("#name").val();
    _data.previous_hash = $("#previous_hash").val();

    $.ajax({
        type: "post",
        url: "/add_product.php",
        data: _data,
        success: function(response){
       
           var data = JSON.parse(response);

           if (typeof data.error != "undefined") {
               console.log('ne cini');
                $("#error-message").text(data.error);
                $(".transaction-error").show();
                $(".transaction-info").hide();
           } else {
                console.log(product_hash)
                $("#product_hash_response").text(data.latest.hash);
                commit_stellar_transaction(product_hash)

           }

        }, 
        error: function(err){

        }
    })
}

function update_stellar_hash_in_block(_data) {

    $.ajax({
        type: "post",
        url: "/update_block.php",
        data: _data,
        success:function(response) {
            console.log('block updated')
        }, 
        error: function(err) {
            console.log("block not updated");
            console.log(err)
        } 
    });

}

function commit_stellar_transaction(product_hash) {

    var sourceSecretKey = Foodstems.payeer_private_key;

    var hash = new StellarSdk.Memo(StellarSdk.MemoHash, product_hash);

    var sourceKeypair = StellarSdk.Keypair.fromSecret(sourceSecretKey);
    var stellar_public_key = sourceKeypair.publicKey();
    var receiverPublicKey = Foodstems.receiver_public_key;
    server.loadAccount(stellar_public_key)
    .then(function(account) {
        var transaction = new StellarSdk.TransactionBuilder(account)

        .addOperation(StellarSdk.Operation.setOptions({
            homeDomain: 'foodstems.com'
        }))
        .addMemo(hash)
        .build();

        transaction.sign(sourceKeypair);
    

        server.submitTransaction(transaction)
        .then(function(transactionResult) {
            
            $("#stellar_link_response").attr("href", transactionResult._links.transaction.href);
            $("#stellar_transaction_hash").val(transactionResult.hash);
            $(".transaction-info").show();

            var _data = {};
            _data.product_hash = product_hash;
            _data.stellar_transaction_hash = transactionResult.hash;

            update_stellar_hash_in_block(_data);
            
        })
        .catch(function(err) {
            console.log('An error has occured:');
            console.log(err);
        });
    })
    .catch(function(e) {
        console.error(e);
    });
}
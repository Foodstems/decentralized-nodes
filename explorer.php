<?php
include 'bootstrap.php';

if (isset($_GET["hash"])) {
    
    $product = find_by_hash($_GET['hash']); 

    if ($product) {
       echo "<h2>Results</h2>";
       echo "<p>Name:" . $product["name"] . "</p>";
       echo "<p>Hash:" . $product["hash"] . "</p>";
    } else {
        echo "no results";
    }

} else {
    echo "<h2>No hash was provided</h2>";
}


//@todo find hash in db and show all the data related to it

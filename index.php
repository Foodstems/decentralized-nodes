<?php

include 'functions.php';

//@todo add new product to db, and broadcast that block to other nodes for validation
//print some feedback if the block was accepted by other nodes

    $record_added = false;

    if (isset($_POST['data'])) {

        $data = $_POST['data'];

        save_db($data);
        $record_added = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php  if (!$record_added) {?>
    <form action="" method="post" >
        <textarea name="data" placeholder="Product json"></textarea>
        <input type="submit" name="submit" value="Add" />
    </form>
    <?php } else {?>
    
        <h2>Record was added</h2>
        <a href="index.php" >Add new</a>
    <?php }?>
</body>
</html> 

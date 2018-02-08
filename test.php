<?php
include 'bootstrap.php';

$block = ['name'=>'Broadcasted block', 'previous_hash'=>'9USrWjpG/c1zazelItNvOvVEq1o6Rv3Nc2s3pSLTbzo='];
$block['hash'] = make_hash($block);

broadcast_block($block);
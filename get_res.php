<?php

include_once('./lib/coco.lib.php');


$it_id = $_POST['productid'];
$user_id = $_POST['user_id'];

$user_id = "test";



$target_file = getHashPath($user_id, $it_id);

echo("{$target_file}\n{$user_id}\n{$it_id}\n");

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}


?>
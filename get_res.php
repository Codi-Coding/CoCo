<?php

include_once('./lib/coco.lib.php');


$upper_id = $_POST['upper'];
$lower_id = $_POST['lower'];
$user_id = $_POST['userid'];


$target_file = getHashPath($user_id, $upper_id.$lower_id);

// echo("{$target_file}\n{$user_id}\n{$it_id}\n");

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    echo("{'result' : true, 'description' : 'image upload success'}");
} else {
    // echo "Sorry, there was an error uploading your file.";
}


?>
<?php
include_once('./_common.php');


$id = $member['mb_id'];


list($it_id, $ext) = $_FILES['fileToUpload']['name'];

$target_name = md5(id.it_id);

$upddr = '/res/';


$target_file = $uploaddir . basename($target_name.$ext);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}


?>
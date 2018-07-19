<?php
    include_once "./_common.php";

    session_save_path(G5_SESSION_PATH);
    session_start();
    $_SESSION['lang'] = $l;
    goto_url($u);
?>

<?php

    include "account-related-functions.php";

    DEFINE("DB_HOST", "localhost");
    DEFINE("DB_USER", "root");
    DEFINE("DB_PWRD", "");
    DEFINE("DB_NAME", "odserver");

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PWRD, DB_NAME)
    or die("Could not establish connection with the server. REASON: " . mysqli_connect_error());
?>

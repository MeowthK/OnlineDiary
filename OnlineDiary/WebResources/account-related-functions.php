<?php

    function UsernameExists($username, $connection)
    {
        $query = "SELECT * FROM users WHERE UserID='$username'";
        $response = mysqli_query($connection, $query);

        return mysqli_num_rows($response) > 0;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Diary</title>
    </head>

    <body>

        <?php

            $username = $_POST["username"];
            $password = $_POST["password"];

            require_once "mysql-connection.php";

            $query = "SELECT * FROM users WHERE UserID='$username'";
            $response = mysqli_query($connection, $query);

            if (UsernameExists($username, $connection))
            {
                $row = mysqli_fetch_array($response);
                $UserID = $row["UserID"];
                $HashedPassword = $row["Password"];
                $UserName = $row["Name"];
                $AccountCreationDate = $row["AccountCreationDate"];

                if (password_verify($password, $HashedPassword))
                    echo "Successful login.";
                else
                    echo "Invalid credentials.";
            }
            else
            {
                echo "User $username is not registered on our site.";
            }

        ?>

    </body>
</html>

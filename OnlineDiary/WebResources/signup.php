<!DOCTYPE html>
<html>
    <head>
        <title>Online Diary</title>
    </head>

    <body>

        <?php

            $name = $_POST["name"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            require_once "mysql-connection.php";

            if (UsernameExists($username, $connection))
            {
                echo "Username is already taken. Please try a different name.";
            }
            else
            {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO users(UserID, Password, Name)
                          VALUES('$username', '$hashedPassword', '$name')";
                          
                if (mysqli_query($connection, $query))
                    echo "Thank you for signing up! Now you may proceed to the login page.";
                else
                    echo "Something went wrong. REASON: " . mysqli_error($connection);
            }

        ?>

    </body>
</html>

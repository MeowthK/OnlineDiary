<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Diary</title>
        <link rel="stylesheet" href="css/stylesheet.css"/>
    </head>

    <body>
        <section>
            
            <?php

                if (!isset($_SESSION["current-user"]))
                {
                    header("location: index.php?errormsg=notloggedin");
                    exit();
                }

            ?>

            <form action="logout.php" method="POST">

                <?php

                    echo "Hello, " . $_SESSION["current-user-name"] . "!<br>";
                    echo "Diary Entry Date: " . date("m/d/Y") . "<hr>";

                ?>

                <button type="submit" name="submit">Log out</button>
                <br>
                <br>
            </form>
            
            <form action="diary-entry.php" method="POST">
                <textarea class="textarea-resize-lock" name="diary-entry" rows="25" cols="100" placeholder="How was your day?" required><?php if (isset($_GET["lastentry"])){ echo $_GET["lastentry"]; } ?></textarea>
                <br>
                <div>

                    <?php

                        if (isset($_GET["error"]))
                        {
                            $errorList = [ "none" => "No errors.",
                                           "lookuperror" => "Placeholder X",
                                           "lookuperror2" => "Placeholder Y",
                                           "insertionerror" => "Can't record current entry :(" ];

                            echo "Error log: " . $errorList[$_GET["error"]];
                        }

                    ?>

                </div>
                <br>
                <input type="date" name="diary-date" value="<?php echo date("Y-m-d"); ?>"/>
                <button type="submit" name="submit">Write to Diary</button>
            </form>
        </section>
    </body>
</html>

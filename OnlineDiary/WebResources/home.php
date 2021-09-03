<?php
    session_start();
    
    require_once "mysql-connection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Diary</title>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <textarea class="boxSizing" name="diary-entry" id="diary-entry" rows="20" cols="100" placeholder="How was your day?" required><?php

                    WriteDiaryEntryToHTML($_SESSION["current-user"], date("Y-m-d"), $connection);

                ?></textarea>
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

                <?php

                    $dateInput = "<input type='date' name='diary-date' id='diary-date'";
                    $currentDate = date("Y-m-d");
                    $dateInput .= "value='$currentDate' max='$currentDate'/>";

                    echo $dateInput;

                ?>

                <button type="submit" name="submit" id="submit">Write to Diary</button>
                <button class="hidden2" type="submit" name="delete-final" id="delete-final"></button>
            </form>

                <br>
                <button class="hidden2" name="delete" id="delete">Crumple</button>
                <br>

                <div class="hidden2" name="delete-confirmation" id="delete-confirmation">

                    <p>Are you sure you want to delete this entry?</p>
                    <button name="delete-confirm" id="delete-confirm">Yes</button>
                    <button name="cancel" id="cancel">No</button>

                </div>

        </section>
        <script src="js/script.js"></script>
    </body>
</html>

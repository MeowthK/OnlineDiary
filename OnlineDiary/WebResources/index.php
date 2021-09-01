<?php
	session_start();

	if (isset($_SESSION["current-user"]))
	{
		header("location: home.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Online Diary</title>
		<link rel="stylesheet" href="css/stylesheet.css"/>
	</head>
	
	<body>
		<section class="center">
			<b>Welcome! Log-in to start writing.</b>
			<p></p>

			<form action="login.php" method="POST">

				<input type="text" name="username" placeholder="Username" required/><br>
				<input type="password" name="password" placeholder="Password" required/><br>
				
				<div>

					<?php

						if (isset($_GET["errormsg"]))
						{
							$errList = [ "invalidcredentials" => "Invalid Credentials.",
							             "usernamenotfound" => "Username not found. Check for typos and try again.",
										 "notloggedin" => "Please login first." ];

							echo $errList[$_GET["errormsg"]];
						}

					?>
					
				</div>

				<br>
				<button type="submit" name="submit">Login</button>

			</form>

			<hr>
			<b>Or Sign Up</b>
			<p>Set-up an account now to start recording your daily highlights!</p>

			<form action="signup.php" method="POST">
			
				<input type="text" name="name" placeholder="Your Name" required/><br>
				<input type="text" name="username" placeholder="Username" required/><br>
				<input type="password" name="password" placeholder="Password" required/><br>
				<input type="password" name="password2" placeholder="Repeat Password" required/><br>

				<div>
					
					<?php

						if (isset($_GET["signup-error"]))
						{
							$errList = [ "passwordmismatch" => "Passwords do not match.",
						 				 "usernameexists" => "Username is already taken. Please try another." ];
							
							echo $errList[$_GET["signup-error"]];
						}

					?>

				</div>
				
				<br>
				<button type="submit" name="submit">Sign Up</button>

			</form>
		</section>
	</body>
</html>

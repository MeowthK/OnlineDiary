<html>
	<head>
		<title>Online Diary</title>
	</head>
	
	<body>
		<b>Welcome! Log-in to start writing.</b>
		<p></p>

		<form action="login.php" method="POST">

			Username: <input type="text" name="username" required/><br>
			Password: <input type="password" name="password" required/><br>
			<button type="submit">Login</button>

		</form>

		<hr>
		<b>Or Sign Up</b>
		<p>Set-up an account now to start recording your daily highlights!</p>

		<form action="signup.php" method="POST">
		
			Your Name: <input type="text" name="name" required/><br>
			Username: <input type="text" name="username" required/><br>
			Password: <input type="password" name="password" required/><br>
			<button type="submit">Sign Up</button>

		</form>

	</body>
</html>

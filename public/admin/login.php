<?php 
	require_once '../../includes/initialize.php';
	if($session->is_logged_in()) {
	  redirect_to("index.php");
	}
	$message = "";
	if (isset($_POST['submit'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		$found_user = User::authenticate($username, $password);
		if ($found_user) {
			$session->login($found_user);
			redirect_to("index.php");
		}else{
			$message = "Invalid username or password!";
		}
	}else {
		$username = "";
		$password = "";
	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/main.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	
	</head>
<body>
			
		<div id="header">
			<!--navbar-->
			<?php echo output_message($message); ?>
		</div>
		
		<div id="main">
			<div class="box">
				<div class="header-box">
					<h3>Photo Gallery</h3>
				</div>
				<div class="main-box">
					<form action="login.php" method="POST">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control" value="<?php echo htmlentities($username) ?>">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control" value="<?php echo htmlentities($password); ?>">
						</div>
						<input type="submit" name="submit" class="btn btn-success">
					</form>
				</div>				
			</div>
		</div>
		
	
	<div id="footer">
		
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
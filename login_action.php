 
<html>
<head>
<title>Login</title>
</head>
<body>
<?php
 
if(isset($_POST['loginButton'])){
    
	require_once('../mysqli_connect.php');
    //$user = $_POST['user']; //prone to sql_injection
	//$pass = $_POST['pass']; //prone to sql_injection
	//if these are used instead of the actual variable statements,
	//typing in 
	//or '1'='1'
	//we can login to any user assume we know the user
	//Note, that hash password needs to be remove for sql_injection to work
	
	//Did not use mysql_prepare statments here because I could not get it to work with hash passwords
	
	//this will prevent sql_injection
	$user = mysqli_real_escape_string($dbc, $_POST['user']);
	$pass = mysqli_real_escape_string($dbc, $_POST['pass']);
	//end of sql_injection
	
	//de-hash password
	$sql = "SELECT * FROM users WHERE user='$user'";
	
	$result = $dbc->query($sql);
	$row = $result->fetch_assoc();
	
	$hash_pass = $row['pass'];
	$hash = password_verify($pass, $hash_pass);
	
	if ($hash == 0){
		//redirects user back to login page

		header("Location: ../login.php?error=empty");
		exit();
	}else {
		
		$sql = "SELECT * FROM users WHERE user='$user' AND pass='$hash_pass'";
		
		$result = $dbc-> query($sql);
			
		if ($row = mysqli_fetch_assoc($result)){
			echo "You are log in!";
		}
	}
	
 
		
}
 
?>
 
</body>
</html>
 
<html>
<head>
<title>Add User</title>
</head>
<body>
<?php
 
if(isset($_POST['registerButton'])){
    
    $data_error = array();
    
    if(empty($_POST['fullname'])){
 
        // Adds name to array
        $data_error[] = 'Fullname is missing';
 
    } else {
 
        // Trim white space from the name and store the name
        $fullname = trim($_POST['fullname']);
 
    }
 
    if(empty($_POST['user'])){
 
        // Adds user to array
        $data_error[] = 'User is missing';
 
    } else{
 
        // Trim white space from the name and store the name
        $user = trim($_POST['user']);
 
    }
	
	
	//password
	if(empty($_POST['pass'])){
 
        // Adds pass to array
        $data_error[] = 'Password is missing';
 
    }
	
	if(empty($_POST['pass2'])){
 
        // Adds pass to array
        $data_error[] = 'Retype Password is missing';
 
    }if ($_POST['pass'] != $_POST['pass2']){
		$data_error[] = 'Password does not match';
		
	}else{
 
        // Hash password
		$temp = $_POST['pass'];
        $pass = password_hash ($temp, PASSWORD_DEFAULT);
		
		//Salt password
 
    }
	
    
	//check is Username is availble
    
	require_once('../mysqli_connect.php');
	$sql = "SELECT user FROM users WHERE user='$user'";
	
	$result = $dbc-> query($sql);
	if ($row = mysqli_fetch_assoc($result)){
		
		echo "Username has been taken";

	}	
	//reCAPTCHA

    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LdSrCIUAAAAAMR6Qwqfnfr38OgbjS5tzyO0npFz',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        echo '<p>reCAPTCHA was not checked!</p>';
    } else {
        // If CAPTCHA is successfully completed...
			if(empty($data_error)){
			
			require_once('../mysqli_connect.php');
			
			$query = "INSERT INTO users (fullname, user, pass) VALUES (?, ?, ?)";
			
			$stmt = mysqli_prepare($dbc, $query);
			
			mysqli_stmt_bind_param($stmt, "sss", $fullname, $user, $pass);
			
			mysqli_stmt_execute($stmt);
			
			$affected_rows = mysqli_stmt_affected_rows($stmt);
			
			if($affected_rows == 1){
				
				echo 'User has been entered!';
				
				
				mysqli_stmt_close($stmt);
				
				mysqli_close($dbc);
				
			} else {
				
				echo 'Error Occurred<br />';
				echo mysqli_error();
				
				mysqli_stmt_close($stmt);
				
				mysqli_close($dbc);
				
			}
			
		} else {
			
			echo 'The following error has occurred: <br />';
			
			foreach($data_error as $missing){
				
				echo "<br>";
				echo "$missing<br />";
				
			}
			
		}
	 
    }
	//end of reCAPTCHA
    
}
 
?>
 

<form action="http://localhost:1234/register.php" method="post">
 
<p>
<input type="submit" name="logButton" value="Go back to Register Page" />
</p>
 
</form>


<form action="http://localhost:1234/login.php" method="post">
 
<p>
<input type="submit" name="logButton" value="Go to Login Page" />
</p>
 
</form>


</body>
</html>
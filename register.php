<html>
<head>
<title>Register Page</title>
<script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
<form action="http://localhost:1234/register_action.php" method="post">
 
<b>Register Page</b>
 
<p>Fullname:
<input type="text" name="fullname" size="32" value=""/>
</p>
 
<p>User:
<input type="text" name="user" size="32" value="" />
</p>

<p>Password:
<input type="password" name="pass" size="32" value="" />
</p>
<p>Retype Password:
<input type="password" name="pass2" size="32" value="" />
</p>

<div class="g-recaptcha" data-sitekey="6LdSrCIUAAAAAHgJ6WQi89oURhSIXbs-t9B2Ogde"></div>
 
<p>
<input type="submit" name="registerButton" value="Register" />
</p>
 
</form>

<br><br>




</body>
</html>
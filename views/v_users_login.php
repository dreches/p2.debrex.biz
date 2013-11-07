
<form method='POST' action='/users/p_login'>
	<h3>Log in</h3>
	
	Email: <input type='text' name='email' <?php if ($user) echo "value='".$user->email."'";?> required><br>
	Password: <input type='password' name='password' required><br/><br/>
	<input type='hidden' name='form_id' value='login'>	
	<input class="button" type='Submit' value='Log in'>
	<br/><br/>	
    Not a member? <a class="button" href='/users/signup'>Sign up</a><br/><br/>
	<br/>
	
	<?php if(isset($error)) echo "<span class='error_msg'>$error</span>"; ?>
	<br><br>	
</form>
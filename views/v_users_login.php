<h2>Log in</h2>
'
<form method='POST' action='/users/p_login'>
	
	Email: <input type='text' name='email' <?php if ($user) echo "value='".$user->email."'";?>><br>
	Password: <input type='password' name='password'><br>
	<input type='hidden' name='form_id' value='login'>	
	<input class="button" type='Submit' value='Log in'>	
    
	<?php if(isset($error)) echo "<span class='error'>.$error.</span>"; ?>	
</form>
<h2>Sign Up</h2>

<form id="signupform" method='POST' action='/users/p_signup'>
	
	<fieldset>
		<label for="first_name">First Name </label>
		<input type='text' id="first_name" name='first_name' required value='<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>' ><br><br>
		<label for="last_name">Last Name </label>
		<input type='text' id="last_name" name='last_name' required value='<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>'><br><br>
		<label for="email">Email </label>
		<input type='text' id="email" name='email' required value='<?php if(isset($_POST['email'])) echo $_POST['email']?>'><br><br>
		<label for="password">Password</label>
		<input type='password' id="password" name='password' required><br><br>
		<label for="password2">Retype Password</label>
		<input type='password' id="password2" name='password2' required><br><br>
		
		<?php if(isset($error)) echo "<span class='error_msg'>$error</span><br><br>"; ?>
	
	</fieldset>
	
		
	
	<div id="submission">
		<input type='hidden' name='form_id' value='signup'>	
		<input class="button" type='submit' value='Sign Up'>
		<input class="button" type="reset" name="resetButton" value="Reset" />
	</div>
	
	
	

</form>
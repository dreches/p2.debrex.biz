<h2>Sign Up</h2>

<form id="signupform" method='POST' action='/users/p_signup'>
	
	<fieldset>
		<label for="first_name">First Name </label>
		<input type='text' id="first_name" name='first_name'><br><br>
		<label for="last_name">Last Name </label>
		<input type='text' id="last_name" name='last_name'><br><br>
		<label for="email">Email </label>
		<input type='text' id="email" name='email'><br><br>
		<label for="password">Password</label>
		<input type='password' id="password" name='password'><br><br>
	</fieldset>
	<fieldset id="submission">
	
		<input class="button" type='submit' value='Sign Up'>
		<input class="button" type="reset" name="resetButton" value="Reset" />
	</fieldset>
	

</form>
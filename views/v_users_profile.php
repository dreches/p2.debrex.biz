<?php if(isset($user_name)): ?>
	<h2>Profile for <?=$user_name?></h2>
	<div id='user_id'><?=$user->email?>
		<?if (isset($user->avatar)):?>
			<img id="user_avatar" src='<?=$user->avatar?>' alt='' height='100' width='100'></img>
		<?endif;?> 
	</div>
	<form method='POST' enctype="multipart/form-data" action='/users/p_profile'>
		<fieldset>
		<label for="first_name">First Name </label>
		<input type='text' id="first_name" name='first_name' value='<?=$user->first_name?>'><br><br>
		<label for="last_name">Last Name </label>
		<input type='text' id="last_name" name='last_name' value='<?=$user->last_name?>'><br><br>
		
		</fieldset>
		<fieldset>
		<label for="password">Password</label>
		<input type='password' id="password" name='password'><br><br>
		</fieldset>
		<fieldset>
		<legend>Create an image you'd like to appear with your posts</legend>
		Avatar: <input type='file' id="avatar" name="avatar" accept="image/*"><br><br>
		Select a highlight color: <input type='color' id='highlight' name='highlight'>
		
		</fieldset>
		<fieldset id="submission">
		<input class="button" type='submit' value='Update'>
		<a class="button" href="/users/posts">Don't update, skip</a>
		<input class="button" type="reset" name="resetButton" value="Reset" />
		
	</fieldset>
	</form>
	
	<?php if(isset($error)) echo "<span class='error_msg'>$error</span>"; ?>	
	
<?php else: ?>
	<h1 class="page_error">No user has been specified</h1>
<?php endif; ?>

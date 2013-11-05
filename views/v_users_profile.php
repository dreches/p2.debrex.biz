<?php if(isset($user)): ?>
	
	<form method='POST' enctype="multipart/form-data" action='/users/p_profile'>
		<div id='user_header' class = 'ui-widget-header'>
		<?if (isset($user->avatar)):?>
			<img id="user_avatar" src='<?=$user->avatar?>' alt='' height='100' width='100'></img>
		<?endif;?> 
		<h2 id="title"><?=$user->first_name?> <?=$user->last_name?></h2>
		<span id="user_email" class="subheader"><?=$user->email?></span>
		</div>
		
		<fieldset>
			<legend>Edit your profile</legend>
		<fieldset>
			<legend>Edit first or last name</legend>
			<label for="first_name">First Name </label>
			<input type='text' id="first_name" name='first_name' value='<?=$user->first_name?>'><br><br>
			<label for="last_name">Last Name </label>
			<input type='text' id="last_name" name='last_name' value='<?=$user->last_name?>'><br><br>
		</fieldset>
		
		<fieldset>
			<legend>Create an image you'd like to appear with your posts</legend>
			Avatar: <input type='file' id="avatar" name="avatar"  accept="image/*" <? if (isset($error)) echo "autofocus";?>><br><br>
			
		</fieldset>
		
		 <p class='error_msg'><?php if(isset($error)) echo $error;?></p>	
		
		<div id="submission">
			<input class="button" type='submit' value='Update'>
			<a class="button" href="/posts/add">Skip for now</a>
			<input class="button" type="reset" name="resetButton" value="Reset" />
		</div>
	</fieldset>
	
	
	
	</form>
	
	
	
<?php else: ?>
	<h1 class="page_error">No user has been specified</h1>
<?php endif; ?>

<?php if(isset($user)): ?>

	<form method='post' action='/posts/p_add'>
		
		<div id='user_header' class = 'ui-widget-header'>
			<?if (isset($user->avatar)):?>
				<img id="user_avatar" src='<?=$user->avatar?>' alt='' height='100' width='100'></img>
			<?endif;?> 
			<h2 id="title"><?=$user->first_name?> <?=$user->last_name?></h2>
			<span id="user_email" class="subheader"><?=$user->email?></span>
			
		</div>
		<p>Post a memo, and if desired, tag it.by a topic of your choosing
		</p>
		<textarea name='content' autofocus ; ></textarea><br><br>
		<label for="tag">Tag</label>
		<input type='text' id="tag" name='tag'/>
		Select a highlight color: <input type='color' id='highlight' name='highlight'>
		<br><br>
		
		<?php if(isset($error)) echo "<span class='error_msg'>$error</span>"; ?>
		
		<input class="button" type='Submit' value='Add new post'/>

	</form>
<?php else: ?>
	<h1 class="page_error">No user has been specified</h1>
<?php endif; ?>

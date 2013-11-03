<p id="home">
<?php if($user): ?>
	<span class="greeting">Hello <?=$user->first_name;?>. Check out recent posts. </span> <a class="button" href='/posts/index'>See posts</a>
<?php else: ?>

	<span class="greeting">Welcome!  This is a place to communicate with your colleagues. Follow posts by user or topic.</span>
	<br/><br/>
	Already a member? 	<a class="button" href='/users/login'>Log In</a>
	<br/><br/>
	Not a member?  <a class="button" href='/users/signup'>Sign Up</a>
	
<?php endif; ?>
</p>


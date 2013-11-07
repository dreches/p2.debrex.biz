<p id="home">
<?php if($user): ?>
	<span class="greeting">Hello <?=$user->first_name;?>. Check out recent posts. </span> <a class="button" href='/posts/index'>See posts</a>
<?php else: ?>

	<span class="greeting">Welcome!  This is a place to communicate with your colleagues. Follow posts by user or topic.</span>
	<br/><br/>
	Already a member? 	<a class="button" href='/users/login'>Log In</a>
	<br/><br/>
	Not a member?  <a class="button" href='/users/signup'>Sign Up</a>
	<br><br><br><br>
	
	<div id='plus_one'>
		<h3>Plus Ones</h3>
		<ul id='outer_list'>
			<li>Edit your profile (name/uploading an avatar)</li>
			<li>3 ways of viewing posts.
				<ol id='inner_list'>
					<li><span class="bold">By user</span> - see posts of people you are following</li>
					<li><span class="bold">By self</span> - See your own posts (automatic when you add a new post)</li>
					<li><span class="bold">By tag</span> - View posts by tag. When creating a post, add one or more tags.<br>
						When viewing posts, click on a tab to view ALL posts with that tag.</li>
				</ol>
			</li>
		</ul>
	</div>
<?php endif; ?>
</p>


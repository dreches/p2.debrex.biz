<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- JS/CSS File we want on every page -->
	<link href="/css/custom-theme/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
	<!--<script src="/js/jquery-1.9.1.js"></script>-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>				
	<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="/js/mycustom.js"></script>	
	<!-- Controller Specific JS/CSS -->
	<link rel="stylesheet" href="/css/sample-app.css" type="text/css">
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
		
</head>

<body>	
	<header id="header" > 
		<div id="eyebrow">
			<?php if($user): ?>
				You are logged in as <?=$user->first_name?> <?=$user->last_name?><br>
			<?php endif; ?>
		</div>	
		<div id="logo">
			<img src="/images/doctalktrns4.jpg" alt="DocTalk:Home"></a>
			&nbsp;&nbsp;
			<h1>DocTalk</h1>
		</div>
		<h2 id="subtitle">A chat site for the medical community.</h2>
 	</header>
	<nav class="subheader">
		<menu>
				<li><a href='/'>Home</a></li>
				
			<?php if($user): ?>
				<li><a href='/posts/add'>Add Post</a></li>
				<li><a href='/posts/'>View Posts</a></li>
				<li><a href='/posts/users'>Follow Users</a></li>
				<li><a href='/users/logout'>Logout</a></li>
			<?php else: ?>
				<li><a href='/users/signup'>Sign Up</a></li>
				<li><a href='/users/login'>Log In</a></li>
			<?php endif; ?>
		</menu>
	</nav>
	
	<br><br>
	<div id="main_content">
	<?php if(isset($content)) echo $content; ?>
	</div>
	<?php if(isset($client_files_body)) echo $client_files_body; ?>
	<pre><?php print_r($user);?></pre>
		
						
	
</body>
</html>
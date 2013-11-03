<ul id="post_list">
<?php foreach($posts as $post): ?>
<li class = "post">
	<p class="user_id"><?=$post['first_name']?> <?=$post['last_name']?></p>
	<p class="post_content"><?=$post['content']?></p>
	<h5 class="timestamp"> posted on <?=Time::display($post['created'])?></h5>
	
</li>	
<?php endforeach; ?>
</ul>

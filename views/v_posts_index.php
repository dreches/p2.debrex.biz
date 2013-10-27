<ul id="post_list">
<?php foreach($posts as $post): ?>
<li class = "post">
	<h5 class="timestamp"><?=$post['first_name']?> posted on <?=Time::display($post['created'])?></h5>
	<p class="post_content"><?=$post['content']?></p>
</li>	
<?php endforeach; ?>
</ul>


<? if (empty($posts)):  ?>
	<p>There are no posts to show. Would you like to create one?  <a id="button" href='/posts/add'>Add a post</a><br>
	   Or add followers?  <a id="button" href='/posts/users'>Add followers</a><br>
	</p>
<? else: ?>
    <ul id="post_list">
    <? foreach($posts as $post): ?>
		<li class = "post">
			<div class="user_id" >
				<img src='<?=$avatar_urls[$post['post_user_id']]?>' alt='' height='50px' width='50px'></img>
				<?=$post['first_name']?> <?=$post['last_name']?>
				<span class="timestamp"> posted on <?=Time::display($post['created'])?></span>
			</div>
			<p class="post_content"><?=$post['content']?></p>
			<?if (!empty($tags[$post['post_id']])) :?>
				
				<ul class="tag_list">
					<span class='tag_list_title'>Tags:</span>
					<? foreach ($tags[$post['post_id']] as $tag) : ?>
						<li class="tag"><?=$tag['tag_name']?></li>
					<?endforeach?>
				</ul>
			<?endif?>
		</li>	
	<? endforeach; ?>
	</ul>
<? endif ?>

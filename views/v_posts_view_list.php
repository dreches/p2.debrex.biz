
<? if (empty($posts)):  ?>
	<p>There are no posts to show. Would you like to create one?  <a id="button" href='/posts/add'>Add a post</a><br>
	   Or add followers?  <a id="button" href='/posts/users'>Add followers</a><br>
	</p>
<? else: ?>
    <ul id="post_list">
    <? foreach($posts as $post): ?>

		<?if (!(isset($avatar_url[$puid=$post['post_user_id']])))
			# Creating a temporary array to store the avatars so we don't need to repeat this whole process each time
			$avatar_url[$puid] = empty($post['avatar'])? PLACE_HOLDER_IMAGE: AVATAR_PATH.$post['avatar']; ?>
		<li class = "post">
			<p class="user_id" >
				<img src='<?=$avatar_url[$puid]?>' alt='' height='50px' width='50px'></img>
				<?=$post['first_name']?> <?=$post['last_name']?>
			</p>
			<p class="post_content"><?=$post['content']?></p>
			<h5 class="timestamp"> posted on <?=Time::display($post['created'])?></h5>

		</li>	
	<? endforeach; ?>
	</ul>
<? endif ?>

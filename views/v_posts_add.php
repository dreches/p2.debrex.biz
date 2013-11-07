<?php if(isset($user)): ?>

	<form method='post' action='/posts/p_add'>
		
		<div id='user_header' class = 'ui-widget-header'>
			<?if (isset($user->avatar)):?>
				<img id="user_avatar" src='<?=$user->avatar?>' alt='' height='100' width='100'></img>
			<?endif;?> 
			<h2 id="title"><?=$user->first_name?> <?=$user->last_name?></h2>
			<span id="user_email" class="subheader"><?=$user->email?></span>
			
		</div>
		<p>Post a memo, and if desired, tag it by one or more topics of your choosing.<br>
		</p>
		<textarea name='content' autofocus cols='70' rows='7'  ; ></textarea><br><br>
		
		<?php if(isset($error)) echo "<span class='error_msg'>$error</span>"; ?>
		
		
		
		<label for="tag_selector">Select tags for your table</label>
		<br>
				
		<select id='tag_selector' name='tags[]' multiple size="5" >
			<? foreach($tags as $tag): ?>
				<option value='<?=$tag['tag_id']?>'><?=$tag['tag_name']?></option>
			<? endforeach; ?>
		</select>
	
		<button onclick="{createTag(); return false}" 
		title="Note: After creating new tags, you will still need to highlight them in order to add them to the post." >Add a new tag </button>
		
		<br><br>
		
		
		<input class="button" type='Submit' value='Add new post'/>
	</form>	
	<script>
		function createTag(){
		
			var tagname=prompt("Please enter a new tag name","tag");
			
			if (tagname!=null && (tagname.trim().length > 0))
			  {
				var myoption=document.createElement("option");
				myoption.innerHTML=tagname;
				myoption.setAttribute("value","NEW:"+tagname);
				var selection = document.getElementById("tag_selector");
				selection.appendChild(myoption);
		
					
			  }
			}
			return false;
	</script>
<?php else: ?>
	<h1 class="page_error">No user has been specified</h1>
<?php endif; ?>

<?php

class posts_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		# Make sure the base controller construct gets called
		parent::__construct();
		
		if(!$this->user) {
			$this->template->content = View::instance('v_users_login');
			$this->template->content->error = "<br/>Profile page for members only. Please log in.";
			die("$this->template");
			
		}
		
	} 
	
	 
	/*-------------------------------------------------------------------------------------------------
	Display a new post form
	-------------------------------------------------------------------------------------------------*/
	public function add($errstr = NULL) {
	
		$this->template->content = View::instance("v_posts_add");
		$this->template->title = "DocTalk: Post";
		$client_files_body = array('/js/createTag.js');
		# Right now the javascript is embedded in v_posts_add
		#$this->template->client_files_body = Utils::load_client_files($client_files_body);
		if (!($errstr===NULL)) 
		{
			$this->template->content->error = $errstr;
			#IF we bring the user back to the page, we still want the tags
			#echo $this->template;
		}
		
		#Get the list of tags already out there
		$q = 
		"SELECT * 
		FROM tags
		ORDER BY tag_name ASC";
		
		# Run query
		$tags = DB::instance(DB_NAME)->select_rows($q);
		$this->template->content->tags = $tags;
		echo $this->template;
	
	}	
	
	
	/*-------------------------------------------------------------------------------------------------
	Process new posts
	-------------------------------------------------------------------------------------------------*/
	public function p_add() {
		/**
		echo "<pre><br>";
		echo print_r($_POST);
		echo "<br>TAG DATA<br>";
		echo print_r($_POST['tags']);
		echo "</pre>";
		**/
		if(empty($_POST['content'])){
			$this->add("Post content was empty. Nothing was posted <br/><br/>");
		}
		else
		{
			
			
			$_POST['user_id']  = $this->user->user_id;
			$_POST['created']  = Time::now();
			$_POST['modified'] = Time::now();
			#copy the tag ids for later processing
			#Initialize to prevent from crashing
			$tag_ids = Array();
			if(isset($_POST['tags']))
				$tag_ids = $_POST['tags'];

	
			
			unset($_POST['highlight']);
			unset($_POST['tags']);
		
			$post_id = DB::instance(DB_NAME)->insert('posts',$_POST);
			
			# Loop through the tags to see if any need to be added to the DB
		    
			$post_tags = Array();
			foreach( $tag_ids as $key => $tag_id ){
				if (strncmp($tag_id,"NEW:",4) == 0)
				{
					$new_tag = Array( "tag_name" => substr($tag_id,4) );
					#INSERT each new tag seperately, so we can get its id back
					$tag_id = DB::instance(DB_NAME)->insert('tags',$new_tag); 
				}
				#Now build the array linking the post to the tags
				if (is_numeric($tag_id))
				{
					$post_tags[] = Array( 'post_id'=>$post_id, 'tag_id'=>$tag_id);
					
				}
			}
			# Only update the posts_tags table if values are legit
			if  (is_numeric($post_id) and !empty($post_tags)) {
				DB::instance(DB_NAME)->insert_rows('posts_tags',$post_tags);
			}
			
			
			
			Router::redirect('/posts/view_list/self');
			
		}
		
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	View all posts
	-------------------------------------------------------------------------------------------------*/
	public function index($arg = "user") {
		/*
		Originally, my thinking was to include the view in a larger index page, but I didn't end up doing 
		that, so all my functionality is in view_list.  
		
		
		# Set up view
		$this->template->content = View::instance('v_posts_index');
	
		$this->template->content->post_view_list = View::instance('v_posts_view_list');
		
		$this->view_list("user",$this->template->content->post_view_list);
		
		
		
		
		# Render view
		echo $this->template; 
		*/
		
		Router::redirect('/posts/view_list/'.$arg);
	}
	
	public function view_list($list_mode = "user", &$content=NULL) {
		$standalone = true;
		$avatar_urls = array();
		$tags = array();
		# Set up view which can be run as part of another page or by itself
		if ($content===NULL ) :
			$standalone = true;
			 $this->template->content = View::instance('v_posts_view_list');
			$content =& $this->template->content; 
		endif;
		
		
		if( strncmp($list_mode,"tag=",4) == 0) {
			$search_value = substr($list_mode,4);
			$list_mode = "tag";
		}
		if ($list_mode === "user") 
			# create a query by user
			$q = $this->query_by_user();
		else if ($list_mode === "self" )
			$q = $this->query_by_self();
		else if ($list_mode === "tag") 
			$q = $this->query_by_tag($search_value);
		else die(print_r($list_mode));
		

		# Run query	
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		foreach($posts as $post):
			$puid=$post['post_user_id'];
			if (!(isset($avatar_urls[$puid]))) {
				# Creating a temporary array to store the avatars so we don't need to 
				# repeat this whole process each time
				$avatar_urls[$puid] = empty($post['avatar'])? PLACE_HOLDER_IMAGE: AVATAR_PATH.$post['avatar']; 
		    }
			$q = "SELECT 
					posts_tags.tag_id,
					tags.tag_name 
				FROM posts_tags
				INNER JOIN tags
				ON posts_tags.tag_id = tags.tag_id
				WHERE posts_tags.post_id = '".$post['post_id']."'";
			
			$tags[$post['post_id']] =  DB::instance(DB_NAME)->select_array($q,'tag_id');
			
		endforeach;
		
		if (!empty($search_value)) {
			$search_tag=$tags[key($tags)][$search_value]['tag_name'];
			$list_mode .= "=$search_tag";
		}
		
		# Pass $posts array to the view
		$content->list_mode = $list_mode;
		$content->posts = $posts;
		$content->tags = $tags;
		$content->avatar_urls = $avatar_urls;
		if ($standalone) {
			# Render view
			echo $this->template;
		}
		
	}
	
	private function query_by_user()	{
		# Set up query
		$q = "SELECT 
				posts.post_id,
			    posts.content,
			    posts.created,
			    posts.user_id AS post_user_id,
			    users_users.user_id AS follower_id,
			    users.first_name,
			    users.last_name,
				users.avatar
			FROM posts
			INNER JOIN users_users 
			    ON posts.user_id = users_users.user_id_followed
			INNER JOIN users 
			    ON posts.user_id = users.user_id
			WHERE users_users.user_id = '".$this->user->user_id."'
			ORDER BY posts.post_id DESC";
		return $q;
	}
	
	private function query_by_self()	{
		# Set up query
		$q = "SELECT 
				posts.post_id,
			    posts.content,
			    posts.created,
			    posts.user_id AS post_user_id,
				users.first_name,
			    users.last_name,
				users.avatar

			FROM posts
			INNER JOIN users 
			    ON posts.user_id = users.user_id
			WHERE posts.user_id = '".$this->user->user_id."'
			ORDER BY posts.post_id DESC"
			;
		return $q;
	}
	private function query_by_tag ($search_value) {
		
		$q = "SELECT
				posts.post_id,
			    posts.content,
			    posts.created,
			    posts.user_id AS post_user_id,
			    posts_tags.tag_id,
				users.first_name,
			    users.last_name,
				users.avatar
			FROM posts
			INNER JOIN posts_tags 
			    ON posts_tags.post_id = posts.post_id
			INNER JOIN users 
			    ON posts.user_id = users.user_id
			WHERE posts_tags.tag_id = '".$search_value."'
			ORDER BY posts.post_id DESC";
		return $q;
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/
	public function users() {
		
		# Set up view
		$this->template->content = View::instance("v_posts_users");
		
		# Set up query to get all users
		# We don't need all the information about the users at this point
		$q = 'SELECT user_id,
		 first_name,last_name,
		 concat(first_name," ",last_name) as user_name,
		 concat("'.AVATAR_PATH.'",avatar) as avatar_url
		FROM users
		 ORDER BY last_name,first_name ASC';
			
		# Run query
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		# Set up query to get all connections from users_users table
		$q = "SELECT *
			FROM users_users
			WHERE user_id = '".$this->user->user_id."'";
			
		# Run query
		$connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');
		
		# Pass data to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;
		
		# Render view
		echo $this->template;
		
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	Creates a row in the users_users table representing that one user is following another
	-------------------------------------------------------------------------------------------------*/
	public function follow($user_id_followed) {
	
	    # Prepare the data array to be inserted
	    $data = Array(
	        "created"          => Time::now(),
	        "user_id"          => $this->user->user_id,
	        "user_id_followed" => $user_id_followed
	        );
	
	    # Do the insert
	    DB::instance(DB_NAME)->insert('users_users', $data);
	
	    # Send them back
	    Router::redirect("/posts/users");
	
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	Removes the specified row in the users_users table, removing the follow between two users
	-------------------------------------------------------------------------------------------------*/
	public function unfollow($user_id_followed) {
	
	    # Set up the where condition
	    $where_condition = "WHERE user_id = '".$this->user->user_id.
		"' AND user_id_followed = '".$user_id_followed."'";
	    
	    # Run the delete
	    DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
	    # Send them back
	    Router::redirect("/posts/users");
	
	}
	
	
	
} # eoc

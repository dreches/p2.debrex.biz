<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        #echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        //echo "This is the signup page";
		# Set up the view
	   $this->template->title = "DocTalk: signup";
       $this->template->content = View::instance('v_users_signup');
	    # Render the view
       echo $this->template;
	   //echo DB_NAME;
    }
	
	public function p_signup() {
	    	    
	    $_POST['created']  = Time::now();
	    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    $_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	    
	    echo "<pre>";
	    print_r($_POST);
		echo DB_NAME;
	    echo "<pre>";
	    
	    DB::instance(DB_NAME)->insert_row('users', $_POST);
	    
	    # Send them to the login page
	    Router::redirect('/users/login');
	    
	    
    }

    public function login() {
        //echo "This is the login page";
		$this->template->content = View::instance('v_users_login');    	
    	echo $this->template;   
       
    }
	
	public function p_login() {
	   	   
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		echo "<pre>";
	    print_r($_POST);
	    echo "</pre>";

		$q = 
			'SELECT token 
			FROM users
			WHERE email = "'.$_POST['email'].'"
			AND password = "'.$_POST['password'].'"';
			
			//echo $q;
	   
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# Success
		if($token) {
			setcookie('token',$token, strtotime('+1 year'), '/');
			echo "You are logged in!";
		}
		# Fail
		else {
			echo "Login failed!";
		}
	   
    }


    public function logout() {
	 # Generate a new token they'll use next time they login
       $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
       
       # Update their row in the DB with the new token
       $data = Array(
       	'token' => $new_token
       );
       DB::instance(DB_NAME)->update('users',$data, 'WHERE user_id ='. $this->user->user_id);
       
       # Delete their old token cookie by expiring it
       setcookie('token', '', strtotime('-1 year'), '/');
       
       # Send them back to the homepage
       Router::redirect('/');
       
	}

    public function profile($user_name = NULL) {
		/*
		if($user_name == NULL) {
            echo "No user specified";
        }
        else {
            echo "This is the profile for ".$user_name;
        }
		*/
		# Only logged in users are allowed...
		if(!$this->user) {
			die('Members only. <a href="/users/login">Login</a>');
		}
		
				
		# Set up the View
		$this->template->content = View::instance('v_users_profile');
		$this->template->title = "DocTalk: Profile";
		
		# Load client files
		$client_files_head = Array(
			'/css/profile.css',
			);
		
		$this->template->client_files_head = Utils::load_client_files($client_files_head);
		
		$client_files_body = Array(
			'/js/profile.js'
			);
		
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
		
		# Pass the data to the View
		$this->template->content->user_name = $user_name;
		
		# Display the view
		echo $this->template;
			
		//$view = View::instance('v_users_profile');
		//$view->user_name = $user_name;		
		//echo $view;
		
    }


} # end of the class
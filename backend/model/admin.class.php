<?php 

	/**
	 * 
	 */
	class model_admin extends lib_database
	{
		
		function __construct()
		{
			parent::__construct();
		}

		/**
		 * Getters
		 */

		public function Login()
		{
			$this->query("SELECT * FROM admin WHERE username = :username");

			$this->bind(":username", $_POST["username"]);
			$res = $this->single();
			if ($res && password_verify($_POST['password'], $res->password)) {
				$_SESSION['admin'] = $res->id_admin;
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * Setters
		 */

		public function Logout()
		{
			// remove all session variables
			session_unset();

			// destroy the session
			session_destroy(); 
		}

	}

 ?>
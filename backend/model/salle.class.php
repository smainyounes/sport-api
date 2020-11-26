<?php 

	/**
	 * 
	 */
	class model_salle extends lib_database
	{
		
		function __construct()
		{
			parent::__construct();
		}

		/**
		 * Getters
		 */

		public function Detail($id_salle)
		{
			
			$this->query("SELECT * FROM salle WHERE id_salle = :id");
			$this->bind(":id", $id_salle);
			return $this->single();
			 
		}

		public function Login()
		{
			$this->query("SELECT * FROM salle WHERE username = :username");

			$this->bind(":username", strip_tags($_POST['username']));

			$res = $this->single();
			if ($res && password_verify($_POST['password'], $res->password)) {
				$_SESSION['salle'] = $res->id_salle;
				return true;
			}else{
				return false;
			}
		}

		/**
		 * Setters
		 */

		public function Inscription()
		{
			if ($_POST['password'] !== $_POST['password2'] ) {
				return false;
			}
			
			$sql = "INSERT INTO 
						salle(nom, username, password, wilaya, commune, address, tel, img_prof, img_cover, description_salle) 
						VALUES(:nom, :username, :password, :wilaya, :commune, :address, :tel, :img_prof, :img_cover, :description)";
			$this->query($sql);

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":username", strip_tags($_POST['username']));
			$this->bind(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":img_prof", "1.jpg");
			$this->bind(":img_cover", "1.jpg");
			$this->bind(":description", strip_tags($_POST['description']));

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditInfos()
		{
			$this->query("UPDATE salle SET nom = :nom, wilaya = :wilaya, commune = :commune, address = :address, tel = :tel, description_salle = :description WHERE id_salle = :id");

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":description", strip_tags($_POST['description']));
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditGeneralInfos()
		{
			$this->query("UPDATE salle SET nom = :nom, tel = :tel, username = :username WHERE id_salle = :id");

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":username", strip_tags($_POST['username']));
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditAddress()
		{
			$this->query("UPDATE salle SET wilaya = :wilaya, commune = :commune, address = :address WHERE id_salle = :id");

			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditDescription()
		{
			$this->query("UPDATE salle SET description_salle = :description WHERE id_salle = :id");

			$this->bind(":description", strip_tags($_POST['description']));
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangePassword()
		{
			$this->query("UPDATE salle SET password = :password WHERE id_salle = :id");
			
			$this->bind(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangeProfilePic($link)
		{
			$this->query("UPDATE salle SET img_prof = :img_prof WHERE id_salle = :id");
			
			$this->bind(":img_prof", $link);
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangeCoverPic($link)
		{
			$this->query("UPDATE salle SET img_cover = :img_cover WHERE id_salle = :id");
			
			$this->bind(":img_cover", $link);
			$this->bind(":id", $_SESSION['salle']);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function DeleteSalle($id_salle)
		{
			$this->query("DELETE FROM salle WHERE id_salle = :id");

			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function Logout()
		{
			// remove all session variables
			session_unset();

			// destroy the session
			session_destroy(); 
		}

	}

 ?>
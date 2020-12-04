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

		public function GetAll($page, $limit)
		{
			$limit = (INT) $limit;
			$this->query("SELECT * FROM salle ORDER BY id_salle DESC LIMIT :num OFFSET :start");

			$this->bind(":num", $limit);
			$this->bind(":start", ($page - 1) * $limit);

			return $this->resultSet();
		}

		public function CountAll()
		{
			$this->query("SELECT COUNT(id_salle) nbr FROM salle");

			$res = $this->single();

			return $res->nbr;
		}

		public function Random($limit)
		{
			$limit = (INT) $limit;
			$this->query("SELECT * FROM salle WHERE etat_salle = :etat ORDER BY RAND() LIMIT :num");

			$this->bind(":etat", "active");
			$this->bind(":num", $limit);

			return $this->resultSet();
		}

		public function Detail($id_salle)
		{		
			$this->query("SELECT * FROM salle WHERE id_salle = :id OR slug = :id");
			$this->bind(":id", $id_salle);
			return $this->single();	 
		}

		public function Login()
		{
			if (!isset($_POST['username']) || !isset($_POST['password'])) {
				return null;
			}

			$this->query("SELECT * FROM salle WHERE username = :username");

			$this->bind(":username", strip_tags($_POST['username']));

			$res = $this->single();
			if ($res && password_verify($_POST['password'], $res->password)) {
				return $res;
			}else{
				return null;
			}
		}

		public function CheckSalle($id_salle, $tokken)
		{
			$this->query("SELECT * FROM salle INNER JOIN salle_login ON salle.id_salle = salle_login.id_salle WHERE salle.id_salle = :id AND salle_login.session_tokken = :tokken");

			$this->bind(":id", $id_salle);
			$this->bind(":tokken", $tokken);

			$res = $this->single();

			if ($res) {
				return true;
			}else{
				return false;
			}
		}

		public function TestOwner($id_salle, $id_sport)
		{
			$this->query("SELECT id_sport FROM sport WHERE id_sport = :id_sport AND id_salle = :id_salle");

			$this->bind(":id_sport", $id_sport);
			$this->bind(":id_salle", $id_salle);

			$res = $this->single();
			if ($res) {
				return true;
			}else{
				return false;
			}
		}

		public function CountSlug($slug)
		{
			$this->query("SELECT COUNT(id_salle) nbr FROM salle WHERE slug = :slug");

			$this->bind(":slug", $slug);

			$res = $this->single();

			return $res->nbr;
		}

		public function ProfImgName($id_salle)
		{
			$this->query("SELECT img_prof FROM salle WHERE id_salle = :id");

			$this->bind(":id", $id_salle);

			$res = $this->single();

			return $res->img_prof;
		}

		public function CoverImgName($id_salle)
		{
			$this->query("SELECT img_cover FROM salle WHERE id_salle = :id");

			$this->bind(":id", $id_salle);

			$res = $this->single();

			return $res->img_cover;
		}

		/**
		 * Setters
		 */

		public function GenTokken($id_salle)
		{
			$tokken = token(10) . uniqid();
			$this->query("INSERT INTO salle_login(`id_salle`, `session_tokken`, `ip`, `infos`) VALUES(:id, :tokken, :ip, :infos)");

			$this->bind(":id", $id_salle);
			$this->bind(":tokken", $tokken);
			$this->bind(":ip", $_SERVER['REMOTE_ADDR']);
			$this->bind(":infos", $_SERVER['HTTP_USER_AGENT']);

			try {
				$this->execute();
				return $tokken;
			} catch (Exception $e) {
				return null;
			}
		}

		public function Inscription()
		{
			if ($_POST['password'] !== $_POST['password2'] ) {
				return false;
			}
			
			$slug = slugify($_POST['nom']);
			$count = $this->CountSlug($slug);

			if ($count > 0) {
				$slug = slugify($_POST['nom'] . " $count");
			}
			
			$sql = "INSERT INTO 
						salle(nom, username, password, wilaya, commune, address, tel, description_salle, slug) 
						VALUES(:nom, :username, :password, :wilaya, :commune, :address, :tel, :description, :slug)";
			$this->query($sql);

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":username", strip_tags($_POST['username']));
			$this->bind(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":description", strip_tags($_POST['description']));
			$this->bind(":slug", $slug);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditInfos($id_salle)
		{
			$this->query("UPDATE salle SET nom = :nom, wilaya = :wilaya, commune = :commune, address = :address, tel = :tel, description_salle = :description WHERE id_salle = :id");

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":description", strip_tags($_POST['description']));
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditGeneralInfos($id_salle)
		{
			$this->query("UPDATE salle SET nom = :nom, tel = :tel, username = :username WHERE id_salle = :id");

			$this->bind(":nom", strip_tags($_POST['nom']));
			$this->bind(":tel", strip_tags($_POST['tel']));
			$this->bind(":username", strip_tags($_POST['username']));
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditAddress($id_salle)
		{
			$this->query("UPDATE salle SET wilaya = :wilaya, commune = :commune, address = :address WHERE id_salle = :id");

			$this->bind(":wilaya", strip_tags($_POST['wilaya']));
			$this->bind(":commune", strip_tags($_POST['commune']));
			$this->bind(":address", strip_tags($_POST['address']));
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditDescription($id_salle)
		{
			$this->query("UPDATE salle SET description_salle = :description WHERE id_salle = :id");

			$this->bind(":description", strip_tags($_POST['description']));
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangePassword($id_salle)
		{
			$this->query("UPDATE salle SET password = :password WHERE id_salle = :id");
			
			$this->bind(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangeProfilePic($id_salle, $link)
		{
			$this->query("UPDATE salle SET img_prof = :img_prof WHERE id_salle = :id");
			
			$this->bind(":img_prof", $link);
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function ChangeCoverPic($link, $id_salle)
		{
			$this->query("UPDATE salle SET img_cover = :img_cover WHERE id_salle = :id");
			
			$this->bind(":img_cover", $link);
			$this->bind(":id", $id_salle);

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

		public function Logout($id_salle, $tokken)
		{
			if ($this->CheckSalle($id_salle, $tokken)) {
				$this->query("DELETE FROM salle_login WHERE id_salle = :id AND session_tokken = :tokken");

				$this->bind(":id", $id_salle);
				$this->bind(":tokken", $tokken);

				try {
					$this->execute();
					return true;
				} catch (Exception $e) {
					return false;
				}
			}else{
				return false;
			}
		}

	}

 ?>
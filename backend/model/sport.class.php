<?php 

	/**
	 * 
	 */
	class model_sport extends lib_database
	{
		
		function __construct()
		{
			parent::__construct();
		}

		/**
		 * Getters
		 */

		public function GetAll($page)
		{
			$limit = 20;
			$start = ($page - 1) * $limit;

			$sql = "SELECT *
						FROM salle, sport LEFT JOIN img
						ON sport.id_sport = img.id_sport
						WHERE NOT EXISTS(
						    SELECT * 
						    FROM img as T2BIS -- just an alias table
						    WHERE T2BIS.id_sport = sport.id_sport -- usual join
						    AND img.id_img > T2BIS.id_img -- change operator to take the last instead of the first
						) AND salle.id_salle = sport.id_salle ORDER BY sport.id_sport DESC LIMIT $limit OFFSET $start";
			$this->query($sql);
			return $this->resultSet();
		}

		public function GetBySalle($id_salle, $page)
		{
			$limit = 20;
			$start = ($page - 1) * $limit;

			$sql = "SELECT *
						FROM salle, sport LEFT JOIN img
						ON sport.id_sport = img.id_sport
						WHERE NOT EXISTS(
						    SELECT * 
						    FROM img as T2BIS -- just an alias table
						    WHERE T2BIS.id_sport = sport.id_sport -- usual join
						    AND img.id_img > T2BIS.id_img -- change operator to take the last instead of the first
						) AND salle.id_salle = sport.id_salle AND salle.id_salle = :id ORDER BY sport.id_sport DESC LIMIT $limit OFFSET $start";
			$this->query($sql);
			$this->bind(":id", $id_salle);

			return $this->resultSet();
		}

		public function Search($wilaya, $commune, $keyword, $page)
		{
			$limit = 20;
			$start = ($page - 1) * $limit;

			$conc1 = "";
			$conc2 = "";

			if (strcmp($wilaya, "tout")) {
				$conc1 = " AND salle.wilaya = :wilaya ";
			}

			if (strcmp($commune, "tout")) {
				$conc2 = " AND salle.commune = :commune ";
			}

			$sql = "SELECT *
						FROM salle, sport LEFT JOIN img
						ON sport.id_sport = img.id_sport
						WHERE NOT EXISTS(
						    SELECT * 
						    FROM img as T2BIS -- just an alias table
						    WHERE T2BIS.id_sport = sport.id_sport -- usual join
						    AND img.id_img > T2BIS.id_img -- change operator to take the last instead of the first
						) AND salle.id_salle = sport.id_salle AND (sport.nom_arab LIKE :keyword OR sport.nom_french LIKE :keyword) $conc1 $conc2 ORDER BY sport.id_sport DESC LIMIT $limit OFFSET $start";
			$this->query($sql);
			$this->bind(":keyword", "%{$keyword}%");

			if ($conc1 != "") {
				$this->bind(":wilaya", $wilaya);
			}

			if ($conc2 != "") {
				$this->bind(":commune", $commune);
			}

			return $this->resultSet();
		}

		public function Detail($id_sport)
		{
			$this->query("SELECT * FROM sport INNER JOIN salle ON sport.id_salle = salle.id_salle WHERE sport.id_sport = :id");

			$this->bind(":id", $id_sport);

			return $this->single();
		}

		public function CountSport($wilaya, $commune, $keyword)
		{
			$conc1 = "";
			$conc2 = "";

			if (strcmp($wilaya, "tout")) {
				$conc1 = " AND salle.wilaya = :wilaya ";
			}

			if (strcmp($commune, "tout")) {
				$conc2 = " AND salle.commune = :commune ";
			}

			$sql = "SELECT COUNT(id_sport) nbr FROM salle INNER JOIN sport ON salle.id_salle = sport.id_salle WHERE nom LIKE :keyword $conc1 $conc2";

			$this->query($sql);
			$this->bind(":keyword", "%{$keyword}%");
			if ($conc1 != "") {
				$this->bind(":wilaya", $wilaya);
			}

			if ($conc2 != "") {
				$this->bind(":commune", $commune);
			}
			
			$res = $this->single();
			return $res->nbr;
		}

		public function CountBySalle($id_salle)
		{
			$this->query("SELECT COUNT(id_sport) nbr FROM sport WHERE id_salle = :id");

			$this->bind(":id", $id_salle);

			$res = $this->single();
			return $res->nbr;
		}

		/**
		 * Setters
		 */

		public function Add()
		{
			$this->query("INSERT INTO sport(id_salle, nom_arab, nom_french, description_sport) VALUES(:id, :arab, :fr, :des)");

			$this->bind(":id", $_SESSION['salle']);
			$this->bind(":arab", strip_tags($_POST['arab']));
			$this->bind(":fr", strip_tags($_POST['fr']));
			$this->bind(":des", strip_tags($_POST['description']));

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditInfos()
		{
			$this->query("UPDATE sport SET nom_arab = :arab, nom_french = :fr, description_sport = :des");

			$this->bind(":arab", strip_tags($_POST['arab']));
			$this->bind(":fr", strip_tags($_POST['fr']));
			$this->bind(":des", strip_tags($_POST['description']));

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function Delete($id_sport)
		{
			$this->query("DELETE FROM sport WHERE id_sport = :id");

			$this->bind(":id", $id_sport);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}
	}

 ?>
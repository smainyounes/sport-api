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

		public function GetAll($page, $limit)
		{
			$limit = (INT) $limit;

			$this->query("SELECT * FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE salle.etat_salle = :etat ORDER BY sport.id_sport DESC LIMIT :num OFFSET :start");

			$this->bind(":etat", "active");
			$this->bind(":num", $limit);
			$this->bind(":start", ($page - 1) * $limit);

			return $this->resultSet();
		}

		public function Random($limit)
		{
			$limit = (INT) $limit;

			$this->query("SELECT * FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE salle.etat_salle = :etat ORDER BY RAND() LIMIT :num");

			$this->bind(":etat", "active");
			$this->bind(":num", $limit);

			return $this->resultSet();
		}

		public function GetBySalle($id_salle, $page, $limit)
		{
			$limit = (INT) $limit;

			$this->query("SELECT * FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE (salle.id_salle = :id OR salle.slug = :id) AND salle.etat_salle = :etat ORDER BY sport.id_sport DESC LIMIT :num OFFSET :start");

			$this->bind(":id", $id_salle);
			$this->bind(":etat", "active");
			$this->bind(":num", $limit);
			$this->bind(":start", ($page - 1) * $limit);

			try {
			return $this->resultSet();
				
			} catch (Exception $e) {
				echo "$e";
			}
		}

		public function Search($wilaya, $commune, $keyword, $page, $limit)
		{
			$limit = (INT) $limit;

			$conc1 = "";
			$conc2 = "";

			if (strcmp($wilaya, "tout")) {
				$conc1 = " AND salle.wilaya = :wilaya ";
			}

			if (strcmp($commune, "tout")) {
				$conc2 = " AND salle.commune = :commune ";
			}

			$sql = "SELECT * FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE (sport_names.nom_ar LIKE :keyword OR sport_names.nom_fr LIKE :keyword) $conc1 $conc2 AND salle.etat_salle = :etat ORDER BY sport.id_sport DESC LIMIT :num OFFSET :start";

			$this->query($sql);
			$this->bind(":keyword", "%{$keyword}%");

			if ($conc1 != "") {
				$this->bind(":wilaya", $wilaya);
			}

			if ($conc2 != "") {
				$this->bind(":commune", $commune);
			}

			$this->bind(":etat", "active");
			$this->bind(":num", $limit);
			$this->bind(":start", ($page - 1) * $limit);

			return $this->resultSet();
		}

		public function Detail($id_sport)
		{
			$this->query("SELECT * FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE sport.id_sport = :id");

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

			$sql = "SELECT COUNT(sport.id_sport) AS nbr FROM ((sport INNER JOIN salle ON sport.id_salle = salle.id_salle) INNER JOIN sport_names ON sport_names.id_sport_name = sport.id_sport_name) WHERE salle.etat_salle = :etat AND nom LIKE :keyword $conc1 $conc2";

			$this->query($sql);
			$this->bind(":etat", "active");
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
			$this->query("SELECT COUNT(sport.id_sport) nbr FROM sport INNER JOIN salle ON sport.id_salle = salle.id_salle WHERE id_salle = :id AND salle.etat_salle = :etat");

			$this->bind(":id", $id_salle);
			$this->bind(":etat", "active");

			$res = $this->single();
			return $res->nbr;
		}

		public function CountAll()
		{
			$this->query("SELECT COUNT(sport.id_sport) nbr FROM sport INNER JOIN salle ON sport.id_salle = salle.id_salle WHERE salle.etat_salle = :etat");

			$this->bind(":etat", "active");

			$res = $this->single();
			
			return $res->nbr;
		}

		public function Names()
		{
			$this->query("SELECT * FROM sport_names");

			return $this->resultSet();
		}

		/**
		 * Setters
		 */

		public function Add($id_salle)
		{
			$this->query("INSERT INTO sport(id_salle, id_sport_name, description_sport) VALUES(:id, :id_sport_name, :des)");

			$this->bind(":id", $id_salle);
			$this->bind(":id_sport_name", $_POST['id_sport_name']);
			$this->bind(":des", strip_tags($_POST['description']));

			try {
				$this->execute();
				return $this->LastId();
			} catch (Exception $e) {
				return false;
			}
		}

		public function EditInfos($id_sport)
		{
			$this->query("UPDATE sport SET id_sport_name = :id_sport_name, description_sport = :des WHERE id_sport = :id");

			$this->bind(":id_sport_name", $_POST['id_sport_name']);
			$this->bind(":des", strip_tags($_POST['description']));
			$this->bind(":id", $id_salle);

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
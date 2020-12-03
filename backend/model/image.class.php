<?php 

	/**
	 * 
	 */
	class model_image extends lib_database
	{
		
		function __construct()
		{
			parent::__construct();
		}

		public function GetImages($id_salle)
		{
			$this->query("SELECT * FROM img WHERE id_salle = :id");
			$this->bind(":id", $id_salle);

			return $this->resultSet();
		}

		public function GetImgLink($id_img)
		{
			$this->query("SELECT link FROM img WHERE id_img = :id");
			$this->bind(":id", $id_img);

			return $this->single();
		}
		
		public function CheckImg($id_salle, $id_img)
		{
			$this->query("SELECT id_img FROM img WHERE id_img = :id_img AND id_salle = :id_salle");

			$this->bind(":id_img", $id_img);
			$this->bind(":id_salle", $id_salle);

			$res = $this->single();

			if ($res) {
				return true;
			}else{
				return false;
			}
		}

		public function AddImg($id_salle, $img_name)
		{
			$this->query("INSERT INTO img(id_salle, link) VALUES(:id, :link)");
			$this->bind(":id", $id_salle);
			$this->bind(":link", $img_name);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function DeleteImg($id_img)
		{
			$this->query("DELETE FROM img WHERE id_img = :id");
			$this->bind(":id", $id_img);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}

		public function DeleteAllImgSalle($id_salle)
		{
			$this->query("DELETE FROM img WHERE id_salle = :id");
			$this->bind(":id", $id_salle);

			try {
				$this->execute();
				return true;
			} catch (Exception $e) {
				return false;
			}
		}
	}


 ?>
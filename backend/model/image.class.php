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

		public function GetImages($id_sport)
		{
			$this->query("SELECT * FROM img WHERE id_sport = :id");
			$this->bind(":id", $id_sport);

			return $this->resultSet();
		}

		public function GetImgLink($id_img)
		{
			$this->query("SELECT link FROM img WHERE id_img = :id");
			$this->bind(":id", $id_img);

			return $this->single();
		}
		
		public function CheckImg($id_sport, $id_img)
		{
			$this->query("SELECT id_img FROM img WHERE id_img = :id_img AND id_sport = :id_sport");

			$this->bind(":id_img", $id_img);
			$this->bind(":id_sport", $id_sport);

			$res = $this->single();

			if ($res) {
				return true;
			}else{
				return false;
			}
		}

		public function AddImg($id_sport, $img_name)
		{
			$this->query("INSERT INTO img(id_sport, link) VALUES(:id, :link)");
			$this->bind(":id", $id_sport);
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

		public function DeleteAllImgSport($id_sport)
		{
			$this->query("DELETE FROM img WHERE id_sport = :id");
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
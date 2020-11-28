<?php 

	/**
	 * 
	 */
	class controller_salle
	{
		private $view_salle;

		function __construct()
		{
			$this->view_salle = new view_salle();
		}

		public function GetAll($page = 1, $limit = 9)
		{
			$this->view_salle->GetAll($page, $limit);
		}

		public function Detail($id_salle = 0)
		{
			$this->view_salle->Detail($id_salle);
		}

		public function Random($limit = 9)
		{
			$this->view_salle->Random($limit);
		}
	}

 ?>
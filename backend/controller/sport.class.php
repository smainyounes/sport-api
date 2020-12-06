<?php 

	/**
	 * 
	 */
	class controller_sport
	{
		private $view_sport;
		function __construct()
		{
			$this->view_sport = new view_sport();
		}

		private function forbidden($id_salle, $tokken, $id_sport = null)
		{
			$json = ['status' => 'error', 'msg' => 'access forbidden'];

			$mod = new model_salle();

			if (!$mod->CheckSalle($id_salle, $tokken)) {
				die(json_encode($json, JSON_PRETTY_PRINT));
			}

			if (isset($id_sport) && !$mod->TestOwner($id_salle, $id_sport)) {
				die(json_encode($json, JSON_PRETTY_PRINT));
			}
		}

		public function GetAll($page = 1, $limit = 9)
		{
			$this->view_sport->GetAll($page, $limit);
		}

		public function Random($limit = 9)
		{
			$this->view_sport->Random($limit);
		}

		public function BySalle($id_salle, $page = 1, $limit = 9)
		{
			$this->view_sport->BySalle($id_salle, $page, $limit);
		}

		public function Detail($id_sport)
		{
			$this->view_sport->Detail($id_sport);
		}

		public function Search($wilaya = "tout", $commune = "tout", $keyword = "", $page = 1, $limit = 9)
		{
			$this->view_sport->Search($wilaya, $commune, $keyword, $page, $limit);
		}

		public function Names()
		{
			$this->view_sport->Names();
		}

		/**
		 * Salle user methods
		 */

		public function Add($id_salle, $tokken)
		{
			$this->forbidden($id_salle, $tokken);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_sport();

				$id = $mod->Add($id_salle);

				if ($id) {
					echo json_encode(['status' => 'success', 'id_sport' => $id], JSON_PRETTY_PRINT);
				}else{
					echo json_encode(['status' => 'error', 'msg' => 'sport could not be added'], JSON_PRETTY_PRINT);
				}
			}
		}

		public function Edit($id_salle, $tokken, $id_sport)
		{
			$this->forbidden($id_salle, $tokken, $id_sport);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_sport();

				if ($mod->EditInfos($id_sport)) {
					echo json_encode(['status' => 'success'], JSON_PRETTY_PRINT);
				}else{
					echo json_encode(['status' => 'error', 'msg' => 'sport infos not changed'], JSON_PRETTY_PRINT);
				}
			}
		}

		public function Delete($id_salle, $tokken, $id_sport)
		{
			$this->forbidden($id_salle, $tokken, $id_sport);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_sport();

				if ($mod->Delete($id_sport)) {
					echo json_encode(['status' => 'success'], JSON_PRETTY_PRINT);
				}else{
					echo json_encode(['status' => 'error', 'msg' => 'sport could not be deleted'], JSON_PRETTY_PRINT);
				}
			}
		}
	}

 ?>
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

		/**
		 * Checking methods
		 */

		private function forbidden($id_salle, $tokken)
		{
			$json = ['status' => 'error', 'msg' => 'access forbidden'];

			$mod = new model_salle();

			if (!$mod->CheckSalle($id_salle, $tokken)) {
				die(json_encode($json, JSON_PRETTY_PRINT));
			}
		}

		public function Checklogin($id_salle, $tokken)
		{
			$mod = new model_salle();

			if ($mod->CheckSalle($id_salle, $tokken)) {				
				echo json_encode(['status' => 'success', 'msg' => 'user is logged in'], JSON_PRETTY_PRINT);
			}else{
				echo json_encode(['status' => 'error', 'msg' => 'user is not logged in'], JSON_PRETTY_PRINT);
			}
		}

		/**
		 * Getting infos methods
		 */

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

		public function GetGallery($id_salle)
		{
			# code...
		}

		/**
		 * Salle user methods
		 */

		public function Inscription()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST'){
				$mod = new model_salle();

				if ($mod->Inscription()) {
					die(json_encode(['status' => 'success'], JSON_PRETTY_PRINT));
				}else{
					die(json_encode(['status' => 'error', 'msg' => 'data not inserted'], JSON_PRETTY_PRINT));
				}
			}
		}

		public function EditInfos($id_salle, $tokken)
		{
			$this->forbidden($id_salle, $tokken);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_salle();

				if ($mod->EditInfos($id_salle)) {
					echo json_encode(['status' => 'success'], JSON_PRETTY_PRINT);
				}else{
					echo json_encode(['status' => 'error', 'msg' => 'infos were not updated'], JSON_PRETTY_PRINT);
				}
			}
		}

		public function Changepassword($id_salle, $tokken)
		{
			$this->forbidden($id_salle, $tokken);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_salle();

				if ($mod->ChangePassword($id_salle)) {
					echo json_encode(['status' => 'success'], JSON_PRETTY_PRINT);
				}else{
					echo json_encode(['status' => 'error', 'msg' => 'infos were not updated'], JSON_PRETTY_PRINT);
				}
			}
		}

		public function Imgprof($id_salle, $tokken)
		{
			$this->forbidden($id_salle, $tokken);

			$res = UploadPic($_FILES['img'], "profile");

			if ($res['status'] !== 'success') {
				die(json_encode($res, JSON_PRETTY_PRINT));
			}

			$mod = new model_salle();

			// get old profile img
			$old_img = $mod->ProfImgName($id_salle);

			if (!$mod->ChangeProfilePic($id_salle, $res['data']['filename'])) {
				// not inserted in database delete uploaded file
				DeletePic("img/" . $res['data']['filename']);
				die(json_encode(['status' => 'error', 'msg' => 'not inserted in database'], JSON_PRETTY_PRINT));
			}

			if ($old_img) {
				DeletePic("img/" . $old_img);
			}

			echo json_encode(['status' => 'success', 'data' => ['img_prof' => PUBLIC_URL . 'img/' . $res['data']['filename']]], JSON_PRETTY_PRINT);
		}

		public function Imgcover($id_salle, $tokken)
		{
			$this->forbidden($id_salle, $tokken);

			$res = UploadPic($_FILES['img'], "cover");

			if ($res['status'] !== 'success') {
				die(json_encode($res, JSON_PRETTY_PRINT));
			}

			$mod = new model_salle();

			// get old profile img
			$old_img = $mod->CoverImgName($id_salle);

			if (!$mod->ChangeCoverPic($id_salle, $res['data']['filename'])) {
				// not inserted in database delete uploaded file
				DeletePic("img/" . $res['data']['filename']);
				die(json_encode(['status' => 'error', 'msg' => 'not inserted in database'], JSON_PRETTY_PRINT));
			}

			if ($old_img) {
				DeletePic("img/" . $old_img);
			}

			echo json_encode(['status' => 'success', 'data' => ['img_cover' => PUBLIC_URL . 'img/' . $res['data']['filename']]], JSON_PRETTY_PRINT);
		}

		public function AddToGallery($id_salle, $tokken)
		{
			# code...
		}

		public function DeleteFromGallery($id_salle, $tokken, $id_image)
		{
			# code...
		}

		public function Login()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$mod = new model_salle();
				$data = $mod->Login();
				if ($data) {
					$tokken = $mod->GenTokken($data->id_salle);

					if (isset($tokken)) {
						$json = ['status' => 'success'];

						$json['data'] = array_merge(['tokken' => $tokken], $this->view_salle->SalleJson($data));

						echo json_encode($json, JSON_PRETTY_PRINT);

					}else{
						echo json_encode(['status' => 'error', 'msg' => 'tokken could not be generated'], JSON_PRETTY_PRINT);
					}

				}else{
					echo json_encode(['status' => 'error', 'msg' => 'wrong username or password'], JSON_PRETTY_PRINT);
				}

			}
		}

		public function Logout($id_salle, $tokken)
		{
			$mod = new model_salle();

			if ($mod->Logout($id_salle, $tokken)) {
				echo json_encode(['status' => 'success']);
			}else{
				echo json_encode(['status' => 'error', 'msg' => 'logout failed']);
			}
		}

	}

 ?>
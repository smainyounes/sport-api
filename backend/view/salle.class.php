<?php 

	/**
	 * 
	 */
	class view_salle
	{
		private $mod_salle;
		function __construct()
		{
			$this->mod_salle = new model_salle();
		}

		public function SalleJson($data)
		{
			return ['id_salle' => $data->id_salle,
					'nom_salle' => $data->nom,
					'wilaya' => $data->wilaya,
					'commune' => $data->commune,
					'address' => $data->address,
					'tel' => $data->tel,
					'description_salle' => $data->description_salle,
					'etat_salle' => $data->etat_salle,
					'img_prof' => ($data->img_prof && file_exists("img/".$data->img_prof)) ? PUBLIC_URL."img/".$data->img_prof : "",
					'img_cover' => ($data->img_cover && file_exists("img/".$data->img_cover)) ? PUBLIC_URL."img/".$data->img_cover : ""];
		}

		public function GetAll($page, $limit)
		{
			$data = $this->mod_salle->GetAll($page, $limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";
				$json["data"]["infos"] = ['nombre_page' => ceil($this->mod_salle->CountAll() / $limit), 'page' => $page];

				foreach ($data as $salle) {
					$json['data']['salles'][] = $this->SalleJson($salle);
				}

			}else{
				$json = ['status' => 'error', 'data' => ['msg' => 'no result found']];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}
	
		public function Detail($id_salle)
		{
			$data = $this->mod_salle->Detail($id_salle);
			$json = [];

			if ($data) {
				$json = ['status' => 'success', 'data' => $this->SalleJson($data)];
			}else{
				$json = ['status' => 'error', 'data' => ['msg' => 'no result found']];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function Random($limit)
		{
			$data = $this->mod_salle->Random($limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";

				foreach ($data as $salle) {
					$json['data']['salles'][] = $this->SalleJson($salle);
				}

			}else{
				$json = ['status' => 'error', 'data' => ['msg' => 'no result found']];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

	}

 ?>
<?php 

	/**
	 * 
	 */
	class view_sport
	{
		private $mod_sport;
		function __construct()
		{
			$this->mod_sport = new model_sport();
		}

		public function SportJson($data)
		{
			return ['id_sport' => $data->id_sport,
					'nom_ar' => $data->nom_ar,
					'nom_fr' => $data->nom_fr,
					'date_ajout' => date("d-m-Y", strtotime($data->date_ajout)),
					'description_sport' => $data->description_sport,
					'id_salle' => $data->id_salle,
					'slug' => $data->slug,
					'nom_salle' => $data->nom,
					'wilaya' => $data->wilaya,
					'commune' => $data->commune,
					'address' => $data->address,
					'tel' => $data->tel,
					'description_salle' => $data->description_salle,
					'etat_salle' => $data->etat_salle,
					'img_cover' => ($data->img_cover && file_exists("img/".$data->img_cover)) ? PUBLIC_URL."img/".$data->img_cover : "",
					'img_prof' => ($data->img_prof && file_exists("img/".$data->img_prof)) ? PUBLIC_URL."img/".$data->img_prof : ""];
		}		

		public function GetAll($page, $limit)
		{
			$data = $this->mod_sport->GetAll($page, $limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";
				$json["data"]["infos"] = ['nombre_page' => ceil($this->mod_sport->CountAll() / $limit), 'page' => $page];

				foreach ($data as $sport) {
					$json['data']['sports'][] = $this->sportJson($sport);
				}

			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function Random($limit)
		{
			$data = $this->mod_sport->Random($limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";

				foreach ($data as $sport) {
					$json['data']['sports'][] = $this->SportJson($sport);
				}

			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function BySalle($id_salle, $page, $limit)
		{
			$data = $this->mod_sport->GetBySalle($id_salle, $page, $limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";
				$json["data"]["infos"] = ['nombre_page' => ceil($this->mod_sport->CountBySalle($id_salle) / $limit), 'page' => $page];

				foreach ($data as $sport) {
					$json['data']['sports'][] = $this->SportJson($sport);
				}

			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function Search($wilaya, $commune, $keyword, $page, $limit)
		{
			$data = $this->mod_sport->Search($wilaya, $commune, $keyword, $page, $limit);
			$json = [];

			if ($data) {
				$json['status'] = "success";
				$json["data"]["infos"] = ['nombre_page' => ceil($this->mod_sport->CountSport($wilaya, $commune, $keyword) / $limit), 'page' => $page];

				foreach ($data as $sport) {
					$json['data']['sports'][] = $this->SportJson($sport);
				}

			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function Detail($id_sport)
		{
			$data = $this->mod_sport->Detail($id_sport);
			$json = [];

			if ($data) {
				$json = ['status' => 'success', 'data' => $this->SportJson($data)];
			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

		public function Names()
		{
			$data = $this->mod_sport->Names();
			$json = [];

			if ($data) {
				$json['status'] = "success";

				foreach($data as $name){
					$json['data']['names'][] = ['id_sport_name' => $name->id_sport_name,
												'nom_ar' => $name->nom_ar,
												'nom_fr' =>$name->nom_fr];
				}

			}else{
				$json = ['status' => 'error', 'msg' => 'no result found'];
			}

			echo json_encode($json, JSON_PRETTY_PRINT);
		}

	}

 ?>
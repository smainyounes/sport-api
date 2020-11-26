<?php 

	/**
	 * 
	 */
	class controller_error
	{
		
		function __construct()
		{

		}

		public function Index()
		{
			echo json_encode(['msg' => 'error 404']);
		}
	}

 ?>
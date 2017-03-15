<?php

	class BaseController{
		public function home(){
			require_once('views/pages/home.php');
		}

		public function error(){
			require_once('views/pages/error.php');
		}
	}

?>
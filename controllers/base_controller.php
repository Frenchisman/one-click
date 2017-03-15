<?php

	class BaseController{
		public function home(){
			$ini = parse_ini_file('config/config.ini');
			//if app is installed redirect to login else we launch the install
			if(isset($ini['installed']) && $ini['installed'] == true){
				require_once('views/pages/login.php');
			}
			else{
				require_once('views/pages/install.php');
			}
		}

		public function error(){
			require_once('views/pages/error.php');
		}
	}

?>